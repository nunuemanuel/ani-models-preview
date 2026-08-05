/**
 * Trusted-logos marquee.
 * Progressively upgrades the static .trusted__row into the seamless
 * .trusted__track / .trusted__set marquee already styled in components.css.
 * No DB / Elementor-data change — pure front-end enhancement.
 * Honors prefers-reduced-motion (leaves the static row in place).
 */
(function () {
	'use strict';

	if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
		return; // keep the static row — no motion
	}

	function build(wrap) {
		if (wrap.dataset.marquee) return;
		var row = wrap.querySelector('.trusted__row');
		if (!row) return;

		var items = row.querySelectorAll('.trusted__logo, .trusted__name');
		if (items.length < 2) return;

		function makeSet(ariaHidden) {
			var set = document.createElement('div');
			set.className = 'trusted__set';
			if (ariaHidden) set.setAttribute('aria-hidden', 'true');
			items.forEach
				? items.forEach(append)
				: Array.prototype.forEach.call(items, append);
			function append(el) { set.appendChild(el.cloneNode(true)); }
			return set;
		}

		var track = document.createElement('div');
		track.className = 'trusted__track';
		track.appendChild(makeSet(false)); // visible set (keeps logos in the a11y tree once)
		track.appendChild(makeSet(true));  // duplicate for the seamless loop

		wrap.classList.add('trusted', 'is-marquee');
		row.replaceWith(track);
		wrap.dataset.marquee = '1';
	}

	function init() {
		var wraps = document.querySelectorAll('.trusted--static');
		Array.prototype.forEach.call(wraps, build);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
