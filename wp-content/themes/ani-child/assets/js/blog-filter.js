/**
 * ANI Blog index — filter + search + per-page + pagination
 *
 * Progressive enhancement: every non-sticky post row is rendered server-side
 * (the main loop runs posts_per_page=-1). No-JS: all rows stay visible.
 * This script narrows the visible set to one page of the FILTERED rows.
 *
 * State model:  { category, search, perPage, page }
 *   category — active category slug, or 'all'
 *   search   — lowercased search query (substring match on data-search)
 *   perPage  — rows per page (10 / 20 / 50)
 *   page     — current page within the filtered set (1-based)
 *
 * Flow (applyState):
 *   1. filter rows  → data-cat contains category AND data-search contains query
 *   2. paginate     → slice the filtered set to the current page
 *   3. render       → toggle .is-hidden so only the current page shows
 *   4. rebuild the pagination control to match the filtered count
 *   5. update the "showing X" count + the no-results message
 *
 * Native data (built in home.php):
 *   - Tabs carry data-cat-filter (slug or 'all').
 *   - Each row carries data-cat (space-separated slugs) + data-search.
 *
 * Accessibility: tabs use aria-pressed; the active page button uses
 * aria-current="page"; the count span is aria-live.
 */
( function () {
	'use strict';

	function initBlogFilter() {
		var grid = document.querySelector( '[data-blog-grid]' );

		if ( ! grid ) {
			return;
		}

		var rows = Array.prototype.slice.call( grid.querySelectorAll( '.ani-blog-row' ) );

		if ( ! rows.length ) {
			return;
		}

		var tabs       = document.querySelectorAll( '.ani-blog-tab' );
		var searchEl   = document.querySelector( '[data-blog-search]' );
		var perPageEl  = document.querySelector( '[data-blog-perpage]' );
		var countEl    = document.querySelector( '[data-count]' );
		var noResults  = document.querySelector( '[data-blog-noresults]' );
		var pager      = document.querySelector( '[data-blog-pagination]' );

		var state = {
			category: 'all',
			search: '',
			perPage: perPageEl ? ( parseInt( perPageEl.value, 10 ) || 10 ) : 10,
			page: 1
		};

		// Returns the rows that match the current category + search.
		function getFiltered() {
			return rows.filter( function ( row ) {
				var cat        = ' ' + ( row.getAttribute( 'data-cat' ) || '' ) + ' ';
				var haystack   = row.getAttribute( 'data-search' ) || '';
				var catMatch   = 'all' === state.category || cat.indexOf( ' ' + state.category + ' ' ) !== -1;
				var queryMatch = '' === state.search || haystack.indexOf( state.search ) !== -1;
				return catMatch && queryMatch;
			} );
		}

		// Build the prev / numbered / next control for the filtered set.
		function renderPagination( totalPages ) {
			if ( ! pager ) {
				return;
			}

			pager.textContent = '';

			if ( totalPages <= 1 ) {
				pager.hidden = true;
				return;
			}

			pager.hidden = false;

			var frag = document.createDocumentFragment();

			frag.appendChild( makePageButton( 'prev', state.page - 1, state.page <= 1 ) );

			for ( var i = 1; i <= totalPages; i++ ) {
				frag.appendChild( makePageButton( i, i, false, i === state.page ) );
			}

			frag.appendChild( makePageButton( 'next', state.page + 1, state.page >= totalPages ) );

			pager.appendChild( frag );
		}

		function makePageButton( label, targetPage, disabled, isCurrent ) {
			var btn = document.createElement( 'button' );
			btn.type = 'button';
			btn.className = 'ani-blog-page';

			if ( 'prev' === label || 'next' === label ) {
				btn.classList.add( 'ani-blog-page--' + label );
				// RTL: "prev" points to the start (→ on screen), "next" to the end (←).
				btn.textContent = 'prev' === label ? '›' : '‹';
				btn.setAttribute(
					'aria-label',
					'prev' === label ? 'העמוד הקודם' : 'העמוד הבא'
				);
			} else {
				btn.textContent = String( label );
			}

			if ( disabled ) {
				btn.disabled = true;
			}

			if ( isCurrent ) {
				btn.classList.add( 'is-current' );
				btn.setAttribute( 'aria-current', 'page' );
			}

			btn.addEventListener( 'click', function () {
				if ( btn.disabled ) {
					return;
				}
				state.page = targetPage;
				applyState();
				// Keep the list in view after a page change.
				if ( grid.scrollIntoView ) {
					grid.scrollIntoView( { behavior: 'smooth', block: 'start' } );
				}
			} );

			return btn;
		}

		function applyState() {
			var filtered   = getFiltered();
			var total      = filtered.length;
			var totalPages = Math.max( 1, Math.ceil( total / state.perPage ) );

			// Clamp the current page to the available range.
			if ( state.page > totalPages ) {
				state.page = totalPages;
			}
			if ( state.page < 1 ) {
				state.page = 1;
			}

			var start = ( state.page - 1 ) * state.perPage;
			var end   = start + state.perPage;

			// Hide every row, then reveal only the current page of the filtered set.
			rows.forEach( function ( row ) {
				row.classList.add( 'is-hidden' );
			} );
			filtered.slice( start, end ).forEach( function ( row ) {
				row.classList.remove( 'is-hidden' );
			} );

			if ( countEl ) {
				countEl.textContent = String( total );
			}

			if ( noResults ) {
				noResults.hidden = total !== 0;
			}

			renderPagination( totalPages );
		}

		// --- control wiring (every change resets to page 1) ---

		tabs.forEach( function ( tab ) {
			tab.addEventListener( 'click', function () {
				state.category = tab.getAttribute( 'data-cat-filter' ) || 'all';
				state.page = 1;

				tabs.forEach( function ( btn ) {
					var isActive = btn === tab;
					btn.classList.toggle( 'is-active', isActive );
					btn.setAttribute( 'aria-pressed', isActive ? 'true' : 'false' );
				} );

				applyState();
			} );
		} );

		if ( searchEl ) {
			searchEl.addEventListener( 'input', function () {
				state.search = searchEl.value.trim().toLowerCase();
				state.page = 1;
				applyState();
			} );
		}

		if ( perPageEl ) {
			perPageEl.addEventListener( 'change', function () {
				state.perPage = parseInt( perPageEl.value, 10 ) || 10;
				state.page = 1;
				applyState();
			} );
		}

		applyState();
	}

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', initBlogFilter );
	} else {
		initBlogFilter();
	}
}() );
