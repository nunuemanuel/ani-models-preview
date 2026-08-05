/* <3 mano <3 */
/**
 * ANI Child Theme — nav-menu.js
 * Mobile hamburger menu: toggles the .ani-header-collapse drawer + backdrop,
 * manages aria-expanded, body scroll-lock, Escape-to-close, and closes when a
 * nav link is tapped. Desktop (>= 980px) ignores all of this via CSS.
 *
 * @package ani
 * @since   1.2.0
 */
( function () {
	'use strict';

	var toggle   = document.getElementById( 'ani-nav-toggle' );
	var collapse = document.getElementById( 'ani-mobile-nav' );
	var backdrop = document.getElementById( 'ani-nav-backdrop' );
	if ( ! toggle || ! collapse ) {
		return;
	}

	var OPEN_CLASS = 'ani-nav-open';

	function isOpen() {
		return document.body.classList.contains( OPEN_CLASS );
	}

	function openMenu() {
		document.body.classList.add( OPEN_CLASS );
		toggle.setAttribute( 'aria-expanded', 'true' );
		toggle.setAttribute( 'aria-label', 'סגירת תפריט' );
		if ( backdrop ) {
			backdrop.hidden = false;
		}
	}

	function closeMenu() {
		document.body.classList.remove( OPEN_CLASS );
		toggle.setAttribute( 'aria-expanded', 'false' );
		toggle.setAttribute( 'aria-label', 'פתיחת תפריט' );
		if ( backdrop ) {
			backdrop.hidden = true;
		}
	}

	function toggleMenu() {
		if ( isOpen() ) {
			closeMenu();
		} else {
			openMenu();
		}
	}

	toggle.addEventListener( 'click', toggleMenu );

	if ( backdrop ) {
		backdrop.addEventListener( 'click', closeMenu );
	}

	// Close when any nav link inside the drawer is activated.
	collapse.addEventListener( 'click', function ( e ) {
		var link = e.target.closest( 'a' );
		if ( link ) {
			closeMenu();
		}
	} );

	// Escape closes the drawer.
	document.addEventListener( 'keydown', function ( e ) {
		if ( 'Escape' === e.key && isOpen() ) {
			closeMenu();
			toggle.focus();
		}
	} );

	// Reset state if the viewport grows to desktop while open.
	var desktop = window.matchMedia( '(min-width: 980px)' );
	var onChange = function () {
		if ( desktop.matches && isOpen() ) {
			closeMenu();
		}
	};
	if ( desktop.addEventListener ) {
		desktop.addEventListener( 'change', onChange );
	} else if ( desktop.addListener ) {
		desktop.addListener( onChange );
	}
}() );
