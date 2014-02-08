<?php

/**
 * MediaWiki extension for user to sign up for Wikimedia account using
 * Persona login
 * Copyright (C) 2014 Stephen Zhou <stepzhou@gmail.com>, Don Yu <donyu8@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class SpecialPersonaSignup extends FormSpecialPage {
	/**
     * @var LoginForm Special:Userlogin instance used for account creation
     */
	private $mLoginForm;

	function __construct() {
		parent::__construct( 'PersonaSignup' );
		$this->mLoginForm = new LoginForm();

	}

	function getMessagePrefix() {
		return 'persona-signup';
	}

	function requiresWrite() {
		return true;
	}

	function requiresUnblock() {
		global $wgBlockDisablesLogin;
		return !$wgBlockDisablesLogin;
	}

	function getFormFields() {
		$personaEmail = $this->getRequest()->getSessionData( 'persona_email' );

		return array(
			'Name' => array(
				'type' => 'text',
				'label-message' => 'persona-signup-username',
				'required' => true,
			),
			'Email' => array(
				'type' => 'info',
				'label-message' => 'persona-signup-email',
				'readonly' => true,
				'default' => $personaEmail,
			),
			'RealName' => array(
				'type' => 'text',
				'label-message' => 'persona-signup-name',
				'required' => false,
			),
			'CreateaccountToken' => array(
				'type' => 'hidden',
				'default' => LoginForm::getCreateaccountToken(),
			),
		);
	}

	function onSubmit( array $data ) {
		global $wgRedirectOnLogin, $wgSecureLogin;

		$personaEmail = $this->getRequest()->getSessionData( 'persona_email' );
		$context = new DerivativeContext( $this->getContext() );
		$context->setRequest( new DerivativeRequest(
			$this->getContext()->getRequest(),
			array(
				'type' => 'signup',
				'wpName' => $data['Name'],
				'wpEmail' => $personaEmail,
				'wpRealName' => $data['RealName'],
				'wpCreateaccountToken' => $data['CreateaccountToken'],
				'wpCreateaccountMail' => true,
			)
		));

		$this->mLoginForm = new LoginForm();
		$this->mLoginForm->setContext( $context );
		$this->mLoginForm->load();

		$status = $this->mLoginForm->addNewaccountInternal();
		if ( $status->isGood() ) {
			// Success!
			$user = $status->getValue();
			$this->getContext()->setUser( $user );

			// Save settings (including confirmation token)
			$user->confirmEmail();
			$user->saveSettings();

			wfRunHooks( 'AddNewAccount', array( $user, true ) );
			$user->addNewUserLogEntry( 'create' );
		} elseif ( !$status->isOK() ) {
			// There was an error
			return $status;
		}

		$user = $this->getContext()->getUser();
		$user->invalidateCache();

		// Set cookies.
		if ( $wgSecureLogin ) {
			$user->setCookies( $this->getRequest(), false );
		} else {
			$user->setCookies( $this->getRequest() );
		}

		LoginForm::clearLoginToken();
		unset( $_SESSION['persona_email'] );

		return true;
	}

	function onSuccess() {
		$this->mLoginForm->successfulCreation();
	}

}
