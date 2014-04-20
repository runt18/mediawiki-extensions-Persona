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
	const OPTION_CREATE = 0;
	const OPTION_LOGIN = 1;

	private $mLoginForm;
	private $mCreateOrLogin;

	function __construct() {
		parent::__construct( 'PersonaSignup' );
		$this->mLoginForm = new LoginForm();
		$this->mCreateOrLogin = self::OPTION_CREATE;
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
			'Question' => array(
				'type' => 'radio',
				'label-message' => 'persona-signup-question',
				'options-messages' => array(
					'persona-signup-new-account' => self::OPTION_CREATE,
					'persona-signup-existing-account' => self::OPTION_LOGIN,
				),
				'default' => $this->mCreateOrLogin,
			),
			'Password' => array(
				'type' => 'password',
				'default' => '',
			 ),
			'CreateaccountToken' => array(
				'type' => 'hidden',
				'default' => LoginForm::getCreateaccountToken(),
			),
			'LoginToken' => array(
				'type' => 'hidden',
				'default' => LoginForm::getLoginToken(),
			),
		);
	}

	function onSubmit( array $data ) {
		$personaEmail = $this->getRequest()->getSessionData( 'persona_email' );
		$data['PersonaEmail'] = $personaEmail;
		$this->mCreateOrLogin = $data['Question'];

		if ( $this->mCreateOrLogin == self::OPTION_CREATE ) {
			$this->createAccount( $data );
		} else {
			$this->associateAccount( $data );
		}

		unset( $_SESSION['persona_email'] );

		return true;
	}

	function createAccount( array $data ) {
		global $wgSecureLogin;

		$context = new DerivativeContext( $this->getContext() );
		$context->setRequest( new DerivativeRequest(
			$this->getContext()->getRequest(),
			array(
				'type' => 'signup',
				'wpName' => $data['Name'],
				'wpEmail' => $data['PersonaEmail'],
				'wpRealName' => $data['RealName'],
				'wpCreateaccountToken' => $data['CreateaccountToken'],
				'wpCreateaccountMail' => true,
			)
		) );

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
	}

	function associateAccount( array $data ) {
		$context = new DerivativeContext( $this->getContext() );
		$context->setRequest( new DerivativeRequest(
			$this->getContext()->getRequest(),
			array(
			'type' => 'login',
			'wpName' => $data['Name'],
			'wpPassword' => $data['Password'],
			'wpLoginToken' => $data['LoginToken'],
			)
		) );

		$this->mLoginForm->setContext( $context );
		$this->mLoginForm->load();
		$this->mLoginForm->processLogin();

		// Save email used with Persona as current user's email
		$currentUser = $this->mLoginForm->getUser();
		$currentUser->setEmail( $data['PersonaEmail'] );
		$currentUser->confirmEmail();
		$currentUser->saveSettings();
	}

	function onSuccess() {
		if ( $this->mCreateOrLogin == self::OPTION_CREATE ) {
			$this->mLoginForm->successfulCreation();
		} else {
			$this->mLoginForm->successfulLogin();
		}
	}

}
