/*
 *  ,d88b.d88b,
 *  88888888888
 *  `Y8888888Y'
 *    `Y888Y'
 *      `Y'
 *     mano
 */

/**
 * Capability-page interactions for A.N.I — Models & Prototypes.
 *  1. Hero video — play/pause on viewport visibility, honour reduced-motion,
 *     provide an accessible pause/play toggle.
 *  2. Proof gallery — accessible lightbox (click / Enter / Space to open,
 *     click-backdrop / Esc / close-button to dismiss, focus restored).
 * Vanilla JS, no dependencies. Guards every lookup so it is a no-op when the
 * relevant markup is absent.
 */
( function () {
	'use strict';

	var reduceMotion = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	/* ---------------------------------------------------------------- video */
	function initVideo() {
		var wrap = document.querySelector( '.ani-svc-video' );
		if ( ! wrap ) {
			return;
		}
		var video  = wrap.querySelector( '.ani-svc-video__el' );
		var toggle = wrap.querySelector( '.ani-svc-video__toggle' );
		if ( ! video ) {
			return;
		}

		var wantPlaying = ! reduceMotion; // reduced-motion → stay on poster.

		function play() {
			var p = video.play();
			if ( p && typeof p.catch === 'function' ) {
				p.catch( function () {} ); // autoplay may be blocked; ignore.
			}
			wrap.classList.remove( 'is-paused' );
		}
		function pause() {
			video.pause();
			wrap.classList.add( 'is-paused' );
		}

		// Expose an accessible toggle regardless of motion setting.
		if ( toggle ) {
			toggle.hidden = false;
			toggle.setAttribute( 'aria-pressed', wantPlaying ? 'false' : 'true' );
			toggle.addEventListener( 'click', function () {
				if ( video.paused ) {
					wantPlaying = true;
					play();
					toggle.setAttribute( 'aria-pressed', 'false' );
				} else {
					wantPlaying = false;
					pause();
					toggle.setAttribute( 'aria-pressed', 'true' );
				}
			} );
		}

		if ( reduceMotion ) {
			pause();
			return;
		}

		// Play only while visible — saves battery / decode when scrolled away.
		if ( 'IntersectionObserver' in window ) {
			var io = new IntersectionObserver( function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( ! wantPlaying ) {
						return;
					}
					if ( entry.isIntersecting ) {
						play();
					} else {
						video.pause();
					}
				} );
			}, { threshold: 0.35 } );
			io.observe( video );
		} else {
			play();
		}
	}

	/* ------------------------------------------------------------- lightbox */
	function initLightbox() {
		var gallery = document.querySelector( '[data-lightbox]' );
		if ( ! gallery ) {
			return;
		}
		var items = gallery.querySelectorAll( '.ani-svc-gallery__item' );
		if ( ! items.length ) {
			return;
		}

		var lastFocus = null;

		// Build the overlay once.
		var overlay = document.createElement( 'div' );
		overlay.className = 'ani-lightbox';
		overlay.setAttribute( 'role', 'dialog' );
		overlay.setAttribute( 'aria-modal', 'true' );
		overlay.setAttribute( 'aria-label', 'תצוגת תמונה' );
		overlay.hidden = true;
		overlay.innerHTML =
			'<button type="button" class="ani-lightbox__close" aria-label="סגירה">' +
			'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" aria-hidden="true"><line x1="6" y1="6" x2="18" y2="18"/><line x1="18" y1="6" x2="6" y2="18"/></svg>' +
			'</button><img class="ani-lightbox__img" alt="">';
		document.body.appendChild( overlay );

		var imgEl   = overlay.querySelector( '.ani-lightbox__img' );
		var closeEl = overlay.querySelector( '.ani-lightbox__close' );

		function open( src, alt ) {
			lastFocus = document.activeElement;
			imgEl.setAttribute( 'src', src );
			imgEl.setAttribute( 'alt', alt || '' );
			overlay.hidden = false;
			document.body.classList.add( 'ani-lb-open' );
			// Force reflow so the CSS transition runs, then reveal.
			void overlay.offsetWidth;
			overlay.classList.add( 'is-open' );
			closeEl.focus();
		}
		function close() {
			overlay.classList.remove( 'is-open' );
			document.body.classList.remove( 'ani-lb-open' );
			var done = function () {
				overlay.hidden = true;
				imgEl.removeAttribute( 'src' );
				overlay.removeEventListener( 'transitionend', done );
			};
			overlay.addEventListener( 'transitionend', done );
			if ( lastFocus && typeof lastFocus.focus === 'function' ) {
				lastFocus.focus();
			}
		}

		items.forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				var full = btn.getAttribute( 'data-full' );
				var img  = btn.querySelector( 'img' );
				if ( full ) {
					open( full, img ? img.getAttribute( 'alt' ) : '' );
				}
			} );
		} );

		closeEl.addEventListener( 'click', close );
		overlay.addEventListener( 'click', function ( e ) {
			if ( e.target === overlay ) {
				close();
			}
		} );
		document.addEventListener( 'keydown', function ( e ) {
			if ( ! overlay.hidden && ( e.key === 'Escape' || e.key === 'Esc' ) ) {
				close();
			}
		} );
	}

	function init() {
		initVideo();
		initLightbox();
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
} )();
