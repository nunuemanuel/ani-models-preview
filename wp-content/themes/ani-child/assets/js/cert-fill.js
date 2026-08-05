/* <3 mano <3 */
/**
 * ANI Child Theme — cert-fill.js
 * Mobile-only scroll animation for the certification badges: as the certs
 * section enters view, each badge fills brand-blue (text → white) in sequence.
 * On desktop the badges use :hover instead (CSS), so this stays gated to <=760px.
 * Honors prefers-reduced-motion.
 *
 * @package ani
 * @since   1.4.0
 */
( function () {
	'use strict';

	var badges = Array.prototype.slice.call( document.querySelectorAll( '.cert-badge' ) );
	if ( ! badges.length ) {
		return;
	}

	var mobile = window.matchMedia && window.matchMedia( '(max-width: 760px)' );
	var reduce = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	function activateAll( on ) {
		badges.forEach( function ( b ) { b.classList.toggle( 'is-active', on ); } );
	}

	// Only run the scroll effect on mobile; clear it otherwise.
	if ( ! mobile || ! mobile.matches ) {
		activateAll( false );
	}

	if ( ! ( 'IntersectionObserver' in window ) || reduce ) {
		if ( mobile && mobile.matches ) {
			activateAll( true );
		}
		return;
	}

	var io = new IntersectionObserver( function ( entries ) {
		entries.forEach( function ( entry ) {
			if ( ! entry.isIntersecting ) {
				return;
			}
			if ( mobile.matches ) {
				var i = badges.indexOf( entry.target );
				setTimeout( function () { entry.target.classList.add( 'is-active' ); }, Math.max( 0, i ) * 160 );
			}
			io.unobserve( entry.target );
		} );
	}, { threshold: 0.55 } );

	badges.forEach( function ( b ) { io.observe( b ); } );

	// If the viewport crosses the breakpoint, reset desktop state.
	if ( mobile && mobile.addEventListener ) {
		mobile.addEventListener( 'change', function () {
			if ( ! mobile.matches ) {
				activateAll( false );
			}
		} );
	}
}() );
