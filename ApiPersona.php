<?php

/**
 * This file is part of the MediaWiki extension Persona.
 * Copyright (C) 2012 Tyler Romeo <tylerromeo@gmail.com>
 *
 * Extension:Persona is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Extension:Persona is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Extension:Persona.  If not, see <http://www.gnu.org/licenses/>.
 */

class ApiPersona extends ApiBase {

	function getDescription() {
		return 'Process Persona login requests and login user if valid.';
	}

	function mustBePosted() {
		return true;
	}

	function isReadMode() {
		return false;
	}

	function getAllowedParams() {
		return array(
			'assertion' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true
			),
			'token' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true
			),
			'stickhttps' => array(
				ApiBase::PARAM_TYPE => 'boolean',
				ApiBase::PARAM_REQUIRED => false
			)
		);
	}

	function getParamDescription() {
		return array(
			'assertion' => 'Token received from Mozilla Persona.',
			'token' => 'Login token retrieved from login form.',
			'stickhttps' => 'Whether to set cookies as secure or not.'
		);
	}

	function execute() {
		global $wgSecureLogin;
		$webRequest = $this->getRequest();

		if ( $wgSecureLogin && WebRequest::detectProtocol() !== 'https' ) {
			$this->dieUsage( 'Secure login is enabled, and an insecure (non-HTTPS) request was made.', 'insecure' );
		}

		$params = $this->extractRequestParams();

		// Check login token and throttling as is done in LoginForm::authenticateUserData.
		// Note that since we do not yet know the username of the login target, the throttle
		// is set for an empty user, effectively making this a per-IP only throttle.
		if ( !LoginForm::getLoginToken() ) {
			LoginForm::setLoginToken();
			$this->dieUsageMsg( 'sessionfailure' );
		} elseif ( LoginForm::incLoginThrottle( '' ) === true ) {
			$this->dieUsageMsg( 'actionthrottledtext' );
		} elseif ( $params['token'] !== LoginForm::getLoginToken() ) {
			$this->dieUsageMsg( 'sessionfailure' );
		}

		// Contact the verification server.
		$assertion = $params['assertion'];
		$request = MWHttpRequest::factory( 'https://login.persona.org/verify', array(
			'method' => 'POST',
			'caInfo' => __DIR__ . '/persona.crt',
			'sslVerifyHost' => true,
			'sslVerifyCert' => true,
			'postData' => FormatJson::encode( array(
				'assertion' => $assertion,
				'audience' => wfExpandUrl( '/', $wgSecureLogin ? PROTO_HTTPS : PROTO_HTTP )
			) ),
		) );
		$request->setHeader( 'Content-Type', 'application/json' );

		$request->execute();
		$response = $request->getContent();
		$result = (array)FormatJson::decode( $response );

		if ( !isset( $result['status'] ) || $result['status'] !== 'okay' ) {
			// Bad assertion. Do nothing, as the response itself has
			// sufficient information.
			$result['status'] = 'failure';
		} elseif ( $result['audience'] != wfExpandUrl( '/', $wgSecureLogin ? PROTO_HTTPS : PROTO_HTTP ) ) {
			// Weird. Audience was returned differently.
			$result['status'] = 'error';
		} else {
			// Valid token. Login the user.

			// BC: User::selectFields is new in MediaWiki 1.21
			if ( function_exists( array( 'User', 'selectFields' ) ) ) {
				$fields = User::selectFields();
			} else {
				$fields = '*';
			}

			$dbr = wfGetDB( DB_MASTER );
			$res = $dbr->select(
				'user',
				$fields,
				array( 'user_email' => $result['email'] )
			);

			if ( $res === false ) {
				$result['status'] = 'dberror';
			} elseif ( $res->numRows() == 0 ) {
				$result['status'] = 'usernotfound';
				$webRequest->setSessionData( 'persona_email', $result['email'] );
			} elseif ( $res->numRows() > 1 ) {
				$result['status'] = 'multipleusers';
			} else {
				// We're good to go. Login the user.
				$user = User::newFromRow( $res->current() );
				$this->getContext()->setUser( $user );
				$user->invalidateCache();

				// Set cookies.
				if( $wgSecureLogin && empty( $params['stickhttps'] ) ) {
					$user->setCookies( $this->getRequest(), false );
				} else {
					$user->setCookies( $this->getRequest() );
				}

				LoginForm::clearLoginToken();
				// BC: ApiQueryInfo::resetTokenCache didn't exist in MediaWiki 1.20
				if ( function_exists( array( 'ApiQueryInfo', 'resetTokenCache' ) ) ) {
					ApiQueryInfo::resetTokenCache();
				}

				// Add injected HTML as an optional message.
				$injected_html = '';
				Hooks::run( 'UserLoginComplete', array( &$user, &$injected_html ) );
				$result['message'] = $injected_html;
			}
		}

		$this->getResult()->addValue( null, 'login', $result );
	}
}
