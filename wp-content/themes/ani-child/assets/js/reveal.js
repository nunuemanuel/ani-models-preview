/**
 * ANI Child Theme — reveal.js
 * Scroll-in motion via IntersectionObserver.
 * Applies opacity + translateY transition to elements with .reveal class.
 * Respects prefers-reduced-motion — no-ops when motion is reduced.
 */
( function () {
	'use strict';

	// No-op if reduced motion is preferred.
	if ( window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
		return;
	}

	var observer = new IntersectionObserver(
		function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					entry.target.classList.add( 'reveal--visible' );
					observer.unobserve( entry.target );
				}
			} );
		},
		{ threshold: 0.12 }
	);

	function init() {
		var targets = document.querySelectorAll( '.reveal' );
		targets.forEach( function ( el ) {
			observer.observe( el );
		} );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
} )();
