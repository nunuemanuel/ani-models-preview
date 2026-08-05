/**
 * ANI Projects — Capability filter
 *
 * Progressive enhancement: all cards are rendered server-side.
 * This script hides/shows them based on data-category.
 * No-JS: all items remain visible (display: block is the default;
 *        .is-hidden class is applied only by this script).
 *
 * Accessibility:
 *   - Filter buttons use aria-pressed (true/false).
 *   - Grid has aria-live="polite" so screen readers announce changes.
 */
( function () {
	'use strict';

	var initialized = false;

	function initFilter() {
		if ( initialized ) {
			return;
		}

		var buttons = document.querySelectorAll( '.ani-projects-filter-btn' );
		var cards   = document.querySelectorAll( '.ani-project-card' );

		if ( ! buttons.length || ! cards.length ) {
			return;
		}

		initialized = true;

		function applyFilter( activeSlug ) {
			cards.forEach( function ( card ) {
				var cat = card.getAttribute( 'data-category' );
				if ( 'all' === activeSlug || cat === activeSlug ) {
					card.classList.remove( 'is-hidden' );
				} else {
					card.classList.add( 'is-hidden' );
				}
			} );

			buttons.forEach( function ( btn ) {
				var isActive = btn.getAttribute( 'data-filter' ) === activeSlug;
				btn.classList.toggle( 'is-active', isActive );
				btn.setAttribute( 'aria-pressed', isActive ? 'true' : 'false' );
			} );
		}

		buttons.forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				applyFilter( btn.getAttribute( 'data-filter' ) );
			} );
		} );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', initFilter );
	} else {
		initFilter();
	}
}() );
