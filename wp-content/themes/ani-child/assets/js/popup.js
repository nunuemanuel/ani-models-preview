/**
 * ANI Lead Popup — vanilla JS, progressive, footer-loaded.
 *
 * Config: window.ANI_POPUP (set by ani-popup.php via inline <script>):
 *   trigger        'exit_intent' | 'time_delay' | 'scroll_depth'
 *   delaySeconds   int — seconds before open (time_delay)
 *   scrollPercent  int 1-100 — page scroll % before open (scroll_depth)
 *   frequencyDays  int — don't reshow within N days (0 = always)
 *
 * Frequency cap: localStorage key 'ani_popup_last_closed'.
 * Focus trap, Esc to close, focus restore, no permanent scroll lock.
 * Reduced-motion: popup still opens, just no CSS animation (CSS handles it).
 * Exit-intent: desktop only (pointer device, no coarse pointer).
 */

( function () {
	'use strict';

	var config = window.ANI_POPUP || {};
	var trigger       = config.trigger        || 'time_delay';
	var delaySeconds  = parseInt( config.delaySeconds, 10 )  || 15;
	var scrollPercent = parseInt( config.scrollPercent, 10 ) || 50;
	var frequencyDays = parseInt( config.frequencyDays, 10 );
	if ( isNaN( frequencyDays ) ) { frequencyDays = 7; }

	var STORAGE_KEY = 'ani_popup_last_closed';

	/* ---- Frequency cap ------------------------------------------------ */

	/**
	 * Returns true if enough days have passed since last close/submit.
	 */
	function shouldShow() {
		if ( frequencyDays === 0 ) {
			return true;
		}
		var last = localStorage.getItem( STORAGE_KEY );
		if ( ! last ) {
			return true;
		}
		var daysSince = ( Date.now() - parseInt( last, 10 ) ) / ( 1000 * 60 * 60 * 24 );
		return daysSince >= frequencyDays;
	}

	/**
	 * Mark the popup as closed now so it won't show again within the window.
	 */
	function markClosed() {
		localStorage.setItem( STORAGE_KEY, String( Date.now() ) );
	}

	/* ---- DOM refs ----------------------------------------------------- */

	var overlay  = document.getElementById( 'ani-popup-overlay' );
	var dialog   = document.getElementById( 'ani-popup-dialog' );
	var closeBtn = document.getElementById( 'ani-popup-close' );

	if ( ! overlay || ! dialog || ! closeBtn ) {
		return; // Guard: elements not in DOM (disabled scope).
	}

	/* ---- Focus trap helpers ------------------------------------------- */

	var FOCUSABLE = [
		'a[href]',
		'button:not([disabled])',
		'input:not([disabled])',
		'select:not([disabled])',
		'textarea:not([disabled])',
		'[tabindex]:not([tabindex="-1"])',
	].join( ', ' );

	function getFocusableEls() {
		return Array.prototype.slice.call( dialog.querySelectorAll( FOCUSABLE ) );
	}

	function trapFocus( e ) {
		var els = getFocusableEls();
		if ( ! els.length ) { return; }
		var first = els[0];
		var last  = els[ els.length - 1 ];

		if ( e.key === 'Tab' ) {
			if ( e.shiftKey ) {
				if ( document.activeElement === first ) {
					e.preventDefault();
					last.focus();
				}
			} else {
				if ( document.activeElement === last ) {
					e.preventDefault();
					first.focus();
				}
			}
		}
	}

	/* ---- Open / close ------------------------------------------------- */

	var triggerEl     = null; // element that triggered open (for focus restore)
	var alreadyOpened = false;

	function openPopup( fromEl ) {
		if ( alreadyOpened ) { return; }
		if ( ! shouldShow() ) { return; }
		alreadyOpened = true;

		triggerEl = fromEl || document.activeElement || document.body;

		overlay.classList.add( 'is-open' );
		overlay.setAttribute( 'aria-hidden', 'false' );
		document.body.classList.add( 'ani-popup-open' );

		// Move focus into the dialog after the transition starts.
		var focusDelay = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ? 0 : 50;
		setTimeout( function () {
			dialog.focus();
		}, focusDelay );

		document.addEventListener( 'keydown', handleKeydown );
	}

	function closePopup() {
		overlay.classList.remove( 'is-open' );
		overlay.setAttribute( 'aria-hidden', 'true' );
		document.body.classList.remove( 'ani-popup-open' );
		document.removeEventListener( 'keydown', handleKeydown );

		markClosed();

		// Restore focus to the element that triggered the popup.
		if ( triggerEl && typeof triggerEl.focus === 'function' ) {
			triggerEl.focus();
		}
	}

	function handleKeydown( e ) {
		if ( e.key === 'Escape' ) {
			closePopup();
			return;
		}
		trapFocus( e );
	}

	/* ---- Close button + overlay backdrop click ------------------------ */

	closeBtn.addEventListener( 'click', closePopup );

	overlay.addEventListener( 'click', function ( e ) {
		// Close if click lands on the overlay itself (not the dialog card).
		if ( e.target === overlay ) {
			closePopup();
		}
	} );

	/* ---- Listen for form submission success inside the popup ---------- */
	// The callback form redirects on POST; but if a JS-progressive success
	// banner appears with .ani-form-notice--success, close the popup then.
	var formObserver = new MutationObserver( function ( mutations ) {
		for ( var i = 0; i < mutations.length; i++ ) {
			var nodes = mutations[i].addedNodes;
			for ( var j = 0; j < nodes.length; j++ ) {
				var node = nodes[j];
				if ( node.nodeType === 1 &&
					node.classList &&
					node.classList.contains( 'ani-form-notice--success' ) ) {
					markClosed();
					// Short delay so the user sees the success message first.
					setTimeout( closePopup, 2800 );
				}
			}
		}
	} );
	formObserver.observe( dialog, { childList: true, subtree: true } );

	/* ---- Triggers ----------------------------------------------------- */

	var triggered = false;

	function fireTrigger() {
		if ( triggered ) { return; }
		triggered = true;
		openPopup( null );
	}

	if ( trigger === 'time_delay' ) {
		/* ---- Time delay ------------------------------------------------ */
		setTimeout( fireTrigger, delaySeconds * 1000 );

	} else if ( trigger === 'scroll_depth' ) {
		/* ---- Scroll depth ---------------------------------------------- */
		function onScroll() {
			var scrolled = window.scrollY || window.pageYOffset;
			var docHeight = Math.max(
				document.body.scrollHeight,
				document.documentElement.scrollHeight
			) - window.innerHeight;

			if ( docHeight <= 0 ) { return; }

			var pct = ( scrolled / docHeight ) * 100;
			if ( pct >= scrollPercent ) {
				window.removeEventListener( 'scroll', onScroll, { passive: true } );
				fireTrigger();
			}
		}
		window.addEventListener( 'scroll', onScroll, { passive: true } );

	} else if ( trigger === 'exit_intent' ) {
		/* ---- Exit intent (desktop with fine pointer only) -------------- */
		// Check for non-touch, fine-pointer device.
		var isDesktop = window.matchMedia( '(pointer: fine) and (hover: hover)' ).matches;
		if ( ! isDesktop ) {
			// Fall back to time_delay (30 s) on touch/mobile devices.
			setTimeout( fireTrigger, 30000 );
		} else {
			function onMouseLeave( e ) {
				// Trigger when the mouse leaves toward the top of the viewport.
				if ( e.clientY <= 10 ) {
					document.removeEventListener( 'mouseleave', onMouseLeave );
					fireTrigger();
				}
			}
			document.addEventListener( 'mouseleave', onMouseLeave );
		}
	}

} )();
