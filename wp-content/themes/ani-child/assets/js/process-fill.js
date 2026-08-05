/**
 * Process-chain scroll-fill.
 * As a .process-chain scrolls through the viewport, its numbered circles light
 * up in sequence and a connecting spine fills with brand blue — an interactive
 * progress effect. Works for both the horizontal (desktop) and vertical (mobile)
 * layouts: it sets a continuous --ani-chain-p (0–1) for the spine fill AND
 * toggles .is-active per step for the circles. Honors prefers-reduced-motion.
 */
(function () {
	'use strict';

	var chains = Array.prototype.slice.call(document.querySelectorAll('.process-chain'));
	if (!chains.length) return;

	var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	function clamp(v, lo, hi) { return Math.max(lo, Math.min(hi, v)); }

	chains.forEach(function (chain) {
		chain.classList.add('process-chain--anim');
		var steps = Array.prototype.slice.call(chain.querySelectorAll('.process-chain__step'));
		if (!steps.length) return;

		if (reduce) {
			steps.forEach(function (s) { s.classList.add('is-active'); });
			chain.style.setProperty('--ani-chain-p', '1');
			return;
		}

		function update() {
			var rect = chain.getBoundingClientRect();
			var vh = window.innerHeight || document.documentElement.clientHeight;
			// Activation line ~62% down the viewport: steps above it are "done".
			var line = vh * 0.62;

			// Continuous progress through the chain (drives the spine fill).
			var p = clamp((line - rect.top) / Math.max(rect.height, 1), 0, 1);
			chain.style.setProperty('--ani-chain-p', p.toFixed(3));

			// Per-step activation by each step's own centre.
			steps.forEach(function (s) {
				var sr = s.getBoundingClientRect();
				var center = sr.top + sr.height / 2;
				s.classList.toggle('is-active', center < line);
			});
		}

		var ticking = false;
		function onScroll() {
			if (ticking) return;
			ticking = true;
			requestAnimationFrame(function () { update(); ticking = false; });
		}

		update();
		window.addEventListener('scroll', onScroll, { passive: true });
		window.addEventListener('resize', onScroll, { passive: true });
	});
})();
