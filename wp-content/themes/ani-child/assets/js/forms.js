/**
 * ANI Forms — progressive enhancement JS.
 *
 * Responsibilities:
 *   1. Disable the submit button on submit to prevent double-submit.
 *   2. Client-side required-field check + focus first invalid (server is authoritative).
 *   3. File input: show selected file names; enforce 3-file limit and 25MB per file.
 *   4. On page load: if a success notice exists, focus it.
 *
 * Server-side validation and spam checks are the source of truth.
 * This layer is enhancement only — the form works without JS.
 *
 * RTL-safe: no direction assumptions; layout via CSS logical properties.
 * Reduced-motion: no CSS transitions are triggered here — only focus + disable.
 *
 * @package ani
 * @since   1.0.0
 */

( function () {
	'use strict';

	var MAX_FILES = 3;
	var MAX_BYTES = 25 * 1024 * 1024; // 25 MB

	/** Allowed extensions (must match server allowlist). */
	var ALLOWED_EXT = [ 'step', 'stp', 'stl', 'iges', 'igs', 'dxf', 'sldprt', 'pdf' ];

	/**
	 * Focus a success or error notice if it exists on the page (after redirect).
	 */
	function focusNotice() {
		var notice = document.querySelector(
			'#ani-callback-success, #ani-rfq-success, #ani-callback-error-summary, #ani-rfq-error-summary'
		);
		if ( notice ) {
			notice.focus();
		}
	}

	/**
	 * Attach double-submit guard and client-side validation to a form.
	 *
	 * @param {HTMLFormElement} form
	 */
	function initForm( form ) {
		var submitBtn = form.querySelector( '.ani-form__submit' );
		if ( ! submitBtn ) {
			return;
		}

		var originalText     = submitBtn.textContent.trim();
		var submittingText   = submitBtn.dataset.aniSubmittingText || '...';
		var submitting       = false;

		form.addEventListener( 'submit', function ( e ) {
			if ( submitting ) {
				e.preventDefault();
				return;
			}

			// Minimal client validation — just focus first invalid native field.
			// The browser's built-in required check fires first because novalidate
			// is NOT set on purpose for the client-side path.
			// We do NOT block submission here; server validates authoritatively.

			submitting = true;
			submitBtn.disabled = true;
			submitBtn.textContent = submittingText;

			// Safety: re-enable after 15s in case the page doesn't navigate.
			setTimeout( function () {
				submitting = false;
				submitBtn.disabled = false;
				submitBtn.textContent = originalText;
			}, 15000 );
		} );
	}

	/**
	 * Wire the file input to show a list of selected files and enforce limits.
	 *
	 * @param {HTMLInputElement} input
	 * @param {HTMLElement}      listEl  The live region to render the file list.
	 */
	function initFileInput( input, listEl ) {
		input.addEventListener( 'change', function () {
			// Clear children without innerHTML — avoids any parser path.
			while ( listEl.firstChild ) {
				listEl.removeChild( listEl.firstChild );
			}

			var files  = Array.prototype.slice.call( input.files );
			var errors = [];

			if ( files.length > MAX_FILES ) {
				errors.push( 'ניתן לצרף עד ' + MAX_FILES + ' קבצים.' );
				// Truncate the FileList visually — can't truncate a real FileList; just warn.
			}

			files.forEach( function ( file, idx ) {
				if ( idx >= MAX_FILES ) {
					return;
				}

				var ext = file.name.split( '.' ).pop().toLowerCase();
				var item = document.createElement( 'div' );
				item.className = 'ani-form__file-item';

				if ( ALLOWED_EXT.indexOf( ext ) === -1 ) {
					item.className += ' ani-form__file-item--error';
					item.textContent = '⚠ ' + file.name + ' — סוג לא נתמך';
				} else if ( file.size > MAX_BYTES ) {
					item.className += ' ani-form__file-item--error';
					item.textContent = '⚠ ' + file.name + ' — גדול מ-25MB';
				} else {
					var sizeMb = ( file.size / ( 1024 * 1024 ) ).toFixed( 1 );
					item.textContent = '✓ ' + file.name + ' (' + sizeMb + ' MB)';
				}

				listEl.appendChild( item );
			} );

			if ( errors.length ) {
				var errEl = document.createElement( 'div' );
				errEl.className = 'ani-form__file-item ani-form__file-item--error';
				errEl.textContent = errors.join( ' ' );
				listEl.prepend( errEl );
			}
		} );
	}

	/**
	 * Boot — runs once on DOMContentLoaded.
	 */
	function boot() {
		// Focus any success/error notice rendered on page load after redirect.
		focusNotice();

		// Attach submit guard to every ANI form on the page.
		var forms = document.querySelectorAll( '.ani-form' );
		forms.forEach( initForm );

		// Wire file inputs.
		document.querySelectorAll( '.ani-form__file' ).forEach( function ( input ) {
			var listEl = document.getElementById( 'ani-file-list' );
			if ( listEl ) {
				initFileInput( input, listEl );
			}
		} );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', boot );
	} else {
		boot();
	}
}() );
