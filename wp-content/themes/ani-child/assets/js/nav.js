/**
 * ANI Child Theme — nav.js
 * Hide-on-scroll-down / show-on-scroll-up sticky header.
 * Throttled with requestAnimationFrame; respects prefers-reduced-motion.
 *
 * @package ani
 * @since   1.1.0
 */
( function () {
	'use strict';

	var header = document.querySelector( '.ani-site-header' );
	if ( ! header ) {
		return;
	}

	// Honour prefers-reduced-motion: keep header always visible, no transform.
	var mediaQuery = window.matchMedia( '(prefers-reduced-motion: reduce)' );
	if ( mediaQuery.matches ) {
		return;
	}

	var lastScrollY    = window.scrollY;
	var ticking        = false;
	var SCROLL_SHADOW  = 60; // px from top before shadow appears
	var HIDE_THRESHOLD = 80; // px scrolled down before we hide

	function update() {
		var currentY = window.scrollY;

		// Shadow: once past threshold, add scrolled class.
		if ( currentY > SCROLL_SHADOW ) {
			header.classList.add( 'ani-header--scrolled' );
		} else {
			header.classList.remove( 'ani-header--scrolled' );
		}

		// Hide / reveal based on direction — but only past the fold.
		if ( currentY > HIDE_THRESHOLD ) {
			if ( currentY > lastScrollY ) {
				// Scrolling down → hide.
				header.classList.add( 'ani-header--hidden' );
			} else {
				// Scrolling up → reveal.
				header.classList.remove( 'ani-header--hidden' );
			}
		} else {
			// Near the top → always visible.
			header.classList.remove( 'ani-header--hidden' );
		}

		lastScrollY = currentY;
		ticking     = false;
	}

	function onScroll() {
		if ( ! ticking ) {
			window.requestAnimationFrame( update );
			ticking = true;
		}
	}

	window.addEventListener( 'scroll', onScroll, { passive: true } );
}() );
