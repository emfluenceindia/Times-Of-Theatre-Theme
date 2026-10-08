/**
 * Times of Theatre main script.
 *
 * Toggles the primary navigation on small screens.
 */
( function () {
	'use strict';

	var toggle = document.querySelector( '.menu-toggle' );
	var nav = document.querySelector( '.main-navigation' );

	if ( ! toggle || ! nav ) {
		return;
	}

	toggle.addEventListener( 'click', function () {
		var expanded = 'true' === toggle.getAttribute( 'aria-expanded' );

		toggle.setAttribute( 'aria-expanded', expanded ? 'false' : 'true' );
		nav.classList.toggle( 'is-open', ! expanded );
	} );
}() );
