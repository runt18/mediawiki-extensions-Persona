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

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Persona',
	'version' => '0.6.0',
	'author' => array(
		'Tyler Romeo',
		'Don Yu',
		'Stephen Zhou',
	),
	'url' => 'https://www.mediawiki.org/wiki/Extension:Persona',
	'descriptionmsg' => 'persona-desc'
);

/**
 * Determines if the persona login link is displayed on every page in the personal URLs bar (true)
 * or if it is only displayed on the login page (false).
 *
 * @var bool
 */
$wgPersonaLoginAnywhere = true;

$wgHooks['BeforePageDisplay'][] = 'efAddPersonaModule';
$wgHooks['UserLoginForm'][] = 'efAddPersonaLogin';
$wgHooks['PersonalUrls'][] = 'efAddPersonaLinks';
$wgAutoloadClasses['SpecialPersonaSignup'] = __DIR__ . '/SpecialPersonaSignup.php';
$wgAutoloadClasses['ApiPersona'] = __DIR__ . '/ApiPersona.php';
$wgSpecialPages['PersonaSignup'] = 'SpecialPersonaSignup';
$wgSpecialPageGroups['PersonaSignup'] = 'login';
$wgAPIModules['persona'] = 'ApiPersona';
$wgMessagesDirs['Persona'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['Persona'] = __DIR__ . '/Persona.i18n.php';
$wgExtensionMessagesFiles['PersonaAlias'] = __DIR__ . '/Persona.i18n.alias.php';

$wgResourceModules['ext.persona'] = array(
	'scripts' => array( 'js/persona_hooks.js' ),
	'messages' => array(
		'sessionfailure',
		'actionthrottledtext',
		'persona-error-insecure',
		'persona-error-failure',
		'persona-error-dberror',
		'persona-error-invaliduser',
		'persona-error-multipleusers',
	),
	'dependencies' => array(
		'mediawiki.api',
		'mediawiki.Title',
		'mediawiki.notify',
	),
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'Persona'
);
$wgResourceModules['ext.persona.old'] = array(
	'scripts' => array( 'js/persona_hooks_old.js' ),
	'messages' => array(
		'sessionfailure',
		'actionthrottledtext',
		'persona-error-insecure',
		'persona-error-failure',
		'persona-error-dberror',
		'persona-error-invaliduser',
		'persona-error-multipleusers',
	),
	'dependencies' => array(
		'mediawiki.api',
		'mediawiki.Title',
		'mediawiki.jqueryMsg',
	),
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'Persona'
);

/**
 * Add the Persona JS module and variables to the output page. Also make sure a session
 * is started and a login token is set.
 *
 * @param User $user Current user that is logged in
 * @param OutputPage $out Output page to add scripts to
 */
function efPersonaAddScripts( User $user, OutputPage $out ) {
	global $wgVersion;

	if ( !isset( $_SESSION ) ) {
		wfSetupSession();
	}
	if ( !LoginForm::getLoginToken() ) {
		LoginForm::setLoginToken();
	}

	// Persona requires that IE compatibility mode be disabled
	// Add the meta tag here in case MediaWiki core doesn't do it
	$out->addMeta( 'http:X-UA-Compatible', 'IE=Edge' );

	if ( ResourceLoader::inDebugMode() ) {
		$out->addHeadItem( 'persona',
			Html::linkedScript( 'https://login.persona.org/include.orig.js' ) );
	} else {
		$out->addHeadItem( 'persona',
			Html::linkedScript( 'https://login.persona.org/include.js' ) );
	}

	if ( version_compare( $wgVersion, '1.20', '<' ) ) {
		$out->addModules( 'ext.persona.old' );
	} else {
		$out->addModules( 'ext.persona' );
	}

	$out->addJsConfigVars( 'wgPersonaUserEmail',
		$user->isEmailConfirmed() ? $user->getEmail() : null );
}

/**
 * Add the Persona module to the OutputPage.
 *
 * @param OutputPage &$out
 *
 * @return bool true
 */
function efAddPersonaModule( OutputPage &$out ) {
	global $wgPersonaLoginAnywhere;

	// Only add the modules and whatnot if necessary.
	if (
		!$wgPersonaLoginAnywhere &&
		$out->getTitle()->equals( SpecialPage::getTitleFor( 'Userlogin' ) )
	) {
		return true;
	}

	$context = RequestContext::getMain();
	efPersonaAddScripts( $context->getUser(), $out );

	$out->addHTML( Html::input(
		'wpLoginToken',
		LoginForm::getLoginToken(),
		'hidden'
	) );

	return true;
}

/**
 * Add the Persona login button and necessary JavaScript modules
 * to the login form.
 *
 * @param $template QuickTemplate
 *
 * @return bool true
 */
function efAddPersonaLogin( $template ) {
	$personaButton = Html::input(
		'wpPersona',
		wfMessage( 'persona-login' )->text(),
		'button',
		array(
			'id' => 'wpPersona',
			'class' => 'mw-ui-button',
			'style' => 'display:none',
		)
	);
	$template->set( 'header', $personaButton );

	return true;
}

/**
 * Add persona login button to personal URLs.
 *
 * @param $personal_urls Array of personal URLs
 * @param $title Title currently being viewed
 *
 * @return bool true
 */
function efAddPersonaLinks( array &$personal_urls, Title $title ) {
	global $wgPersonaLoginAnywhere;

	if ( $wgPersonaLoginAnywhere && !isset( $personal_urls['logout'] ) ) {
		$personal_urls['personalogin'] = array(
			'text' => wfMessage( 'persona-login' ),
			'href' => '#',
			'active' => $title->isSpecial( 'Userlogin' ),
			'class' => 'printfooter',
		);
	}

	return true;
}
