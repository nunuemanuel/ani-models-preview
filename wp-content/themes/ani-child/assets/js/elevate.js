/*
 *  ,d88b.d88b,
 *  88888888888
 *  `Y8888888Y'
 *    `Y888Y'
 *      `Y'
 *     mano
 *
 *  elevate.js — sitewide interaction layer for the A.N.I redesign:
 *  scroll-progress bar, staggered reveals, and safe number count-ups.
 *  Vanilla, dependency-free, reduced-motion aware.
 */
( function () {
	'use strict';
	var reduce = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	/* -------- scroll progress bar -------- */
	function scrollbar() {
		if ( reduce ) { return; }
		var bar = document.createElement( 'div' );
		bar.className = 'ani-scrollbar';
		document.body.appendChild( bar );
		var ticking = false;
		function update() {
			var h = document.documentElement;
			var max = h.scrollHeight - h.clientHeight;
			var p = max > 0 ? h.scrollTop / max : 0;
			bar.style.setProperty( '--sp', p.toFixed( 4 ) );
			ticking = false;
		}
		window.addEventListener( 'scroll', function () {
			if ( ! ticking ) { window.requestAnimationFrame( update ); ticking = true; }
		}, { passive: true } );
		update();
	}

	/* -------- staggered reveals: cascade siblings that share a parent -------- */
	function stagger() {
		if ( reduce ) { return; }
		// Cascade: per-parent delay by index among reveal-children.
		var seen = new Map();
		document.querySelectorAll( '[data-reveal]' ).forEach( function ( el ) {
			var p = el.parentNode; if ( ! p ) { return; }
			var sibs = seen.get( p );
			if ( ! sibs ) { sibs = Array.prototype.filter.call( p.children, function ( c ) { return c.hasAttribute && c.hasAttribute( 'data-reveal' ); } ); seen.set( p, sibs ); }
			if ( sibs.length > 1 ) {
				var i = sibs.indexOf( el );
				el.style.setProperty( '--d', ( Math.min( i, 8 ) * 70 ) + 'ms' );
			}
		} );
	}

	/* -------- count-up: only pure "123", "35+", "100%" (never "24/7") -------- */
	function counters() {
		var els = document.querySelectorAll( '[data-count], .stat__num, .hero-stat__num, .stat-num, .ani-count' );
		if ( ! els.length ) { return; }
		var re = /^(\d{1,4})([%+]?)$/;
		var io = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( e ) {
				if ( ! e.isIntersecting ) { return; }
				var el = e.target; io.unobserve( el );
				var m = ( el.getAttribute( 'data-count' ) || el.textContent.trim() ).match( re );
				if ( ! m ) { return; }
				var target = parseInt( m[ 1 ], 10 ), suffix = m[ 2 ] || '';
				if ( reduce ) { el.textContent = target + suffix; return; }
				var start = null, dur = 1100;
				function step( ts ) {
					if ( start === null ) { start = ts; }
					var t = Math.min( ( ts - start ) / dur, 1 );
					var eased = 1 - Math.pow( 1 - t, 3 );
					el.textContent = Math.round( eased * target ) + suffix;
					if ( t < 1 ) { window.requestAnimationFrame( step ); }
				}
				window.requestAnimationFrame( step );
			} );
		}, { threshold: 0.6 } );
		els.forEach( function ( el ) { io.observe( el ); } );
	}

	/* -------- reveal-on-view for [data-reveal] (self-contained) -------- */
	function reveal() {
		var els = document.querySelectorAll( '[data-reveal]' );
		if ( ! els.length ) { return; }
		if ( reduce || ! ( 'IntersectionObserver' in window ) ) {
			els.forEach( function ( el ) { el.classList.add( 'rv-in' ); } );
			return;
		}
		var io = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( e ) {
				if ( e.isIntersecting ) { e.target.classList.add( 'rv-in' ); io.unobserve( e.target ); }
			} );
		}, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' } );
		els.forEach( function ( el ) { io.observe( el ); } );
		// safety: reveal everything after 2.5s in case a callback is missed
		window.setTimeout( function () { els.forEach( function ( el ) { el.classList.add( 'rv-in' ); } ); }, 2500 );
	}

	function init() {
		document.documentElement.classList.add( 'ani-js' );
		scrollbar(); stagger(); reveal(); counters();
	}
	if ( document.readyState === 'loading' ) { document.addEventListener( 'DOMContentLoaded', init ); }
	else { init(); }
} )();
