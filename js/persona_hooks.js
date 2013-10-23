( function( $, mw ) {
	'use strict';

	$( function( $ ) {
		$( '#wpPersona' ).click( function() {
			navigator.id.request();
		} );

		$( '#pt-personalogin' ).click( function() {
			navigator.id.request();
		} );

		$( '#pt-logout > a' ).click( function() {
			navigator.id.logout();
		} );

		navigator.id.watch( {
			loggedInUser: mw.config.get( 'wgPersonaUserEmail' ),
			onlogin: function( assertion ) {
				var api = new mw.Api();
				api.post( {
					'action': 'persona',
					'assertion': assertion,
					'token': $( 'input[name="wpLoginToken"]' ).val()
				} )
				.done( function ( data ) {
					if ( data.login.status !== 'okay' ) {
						console.log( 'Persona login failed.', data );
						mw.notify( mw.message( 'persona-error-' + data.login.status ).text() );
						navigator.id.logout();
						return;
					}

					var vars, url, queryPos, fragPos, hash, q, title, lowercaseTitle;

					console.log( 'Persona login result:', data );
					vars = [];
					url = document.URL;
					queryPos = url.indexOf( '?' ) + 1;
					fragPos = url.indexOf( '#', queryPos );
					q = document.URL.substring( queryPos, fragPos );
					if ( queryPos < fragPos && q !== "" ){
						q = q.split( '&' );
						for ( var i = 0; i < q.length; i++ ) {
							hash = q[i].split( '=' );
							vars[hash[0]] = decodeURIComponent( hash[1] ).replace( '+', ' ' );
						}
					} else {
						vars = {};
					}

					lowercaseTitle = vars.title !== undefined ? vars.title.toLowerCase() : undefined;
					if ( vars.returnto !== undefined ) {
						title = new mw.Title( vars.returnto );
						window.location.href = title.getUrl();
					} else if ( lowercaseTitle !== 'special:userlogin' &&
						lowercaseTitle !== 'special:userlogout'
					) {
						window.location.reload();
					} else {
						title = new mw.Title( 'Main_Page' );
						window.location.href = title.getUrl();
					}
				} )
				.fail( function ( error ) {
					console.log( 'Persona login failed.', error );
					mw.notify( mw.message( error ).text() );
					navigator.id.logout();
				} );
			},
			onlogout: function() {}
		} );
	} );

} )( jQuery, mediaWiki );
