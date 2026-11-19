/* Modo Daltónico - JS (CSP compliant) */
(function() {
	'use strict';

	/**
	 * Expected config keys:
	 * - initialActive (bool)
	 * - contrastType (string: protanopia|deuteranopia|tritanopia)
	 * - toggleUrl (string)
	 * - activeLabel (string)
	 * - inactiveLabel (string)
	 * - strings (object)
	 */
	var C = (typeof window !== 'undefined' && window.ModoDaltonicoConfig) ? window.ModoDaltonicoConfig : {
		initialActive: true,
		contrastType: 'deuteranopia',
		toggleUrl: '#',
		activeLabel: 'Activate',
		inactiveLabel: 'Deactivate',
		strings: {
			modo_activo: 'Color-blind mode is active',
			modo_inactivo: 'Color-blind mode is inactive'
		}
	};

	var LS_KEY = 'md_active';
	var LS_TYPE = 'md_type';

	function getState() {
		var ls = null;
		try { ls = window.localStorage.getItem(LS_KEY); } catch(e) {}
		if (ls === null || ls === undefined) {
			return !!C.initialActive;
		}
		return ls === '1' || ls === 'true' || ls === 'on';
	}

	function setState(active) {
		try { window.localStorage.setItem(LS_KEY, active ? '1' : '0'); } catch(e) {}
	}

	function getType() {
		var t = null;
		try { t = window.localStorage.getItem(LS_TYPE); } catch(e) {}
		if (!t) return C.contrastType || 'deuteranopia';
		return t;
	}

	function setType(type) {
		try { window.localStorage.setItem(LS_TYPE, type); } catch(e) {}
	}

	function applyState(btn, badge) {
		var active = getState();
		var type = getType();
		var body = document.body;
		if (!body) return;

		// Reset classes
		body.classList.remove('md-active', 'md-contrast-protanopia', 'md-contrast-deuteranopia', 'md-contrast-tritanopia');

		if (active) {
			body.classList.add('md-active');
			var typeClass = 'md-contrast-' + (type || 'deuteranopia');
			body.classList.add(typeClass);
		}

		if (btn) {
			btn.setAttribute('aria-pressed', active ? 'true' : 'false');
			btn.setAttribute('aria-label', active ? C.strings.modo_activo : C.strings.modo_inactivo);
			var labelSpan = btn.querySelector('.md-label');
			if (labelSpan) {
				labelSpan.textContent = active ? C.inactiveLabel : C.activeLabel;
			}
		}
		if (badge) {
			badge.classList.remove('is-on', 'is-off');
			badge.classList.add(active ? 'is-on' : 'is-off');
		}
	}

	function toggleActive(btn, badge) {
		var newState = !getState();
		setState(newState);
		applyState(btn, badge);

		// Notify server (optional; no persistence server-side)
		if (C.toggleUrl && C.toggleUrl !== '#') {
			try {
				var params = new URLSearchParams();
				params.set('activo', newState ? 'on' : 'off');
				fetch(C.toggleUrl, {
					method: 'POST',
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
					body: params.toString(),
					credentials: 'same-origin'
				}).catch(function(){ /* no-op */ });
			} catch(e) { /* no-op */ }
		}
	}

	function ensureTypeStored() {
		// Ensure the selected type from config is stored if absent
		var t = getType();
		if (!t) setType(C.contrastType || 'deuteranopia');
	}

	document.addEventListener('DOMContentLoaded', function() {
		ensureTypeStored();

		// Create floating toggle
		var btn = document.createElement('button');
		btn.type = 'button';
		btn.className = 'md-toggle';
		btn.setAttribute('aria-pressed', 'false');
		btn.setAttribute('title', 'Modo daltónico');

		var label = document.createElement('span');
		label.className = 'md-label';
		label.textContent = C.initialActive ? C.inactiveLabel : C.activeLabel;
		btn.appendChild(label);

		var badge = document.createElement('span');
		badge.className = 'md-badge';
		btn.appendChild(badge);

		btn.addEventListener('click', function() { toggleActive(btn, badge); });

		// Create floating contrast selector (same design language)
		var selWrap = document.createElement('div');
		selWrap.className = 'md-select';

		var selLabel = document.createElement('span');
		selLabel.className = 'md-label';
		selLabel.textContent = C.strings.indicador_activo || 'Contraste';
		selWrap.appendChild(selLabel);

		var sel = document.createElement('select');
		sel.className = 'md-select-control';

		var types = [
			{ value: 'protanopia', text: C.strings.protanopia || 'Protanopia' },
			{ value: 'deuteranopia', text: C.strings.deuteranopia || 'Deuteranopia' },
			{ value: 'tritanopia', text: C.strings.tritanopia || 'Tritanopia' }
		];
		types.forEach(function(o){
			var opt = document.createElement('option');
			opt.value = o.value;
			opt.textContent = o.text;
			sel.appendChild(opt);
		});

		try { sel.value = getType(); } catch(e) {}

		sel.addEventListener('change', function() {
			setType(sel.value);
			applyState(btn, badge);
		});

		selWrap.appendChild(sel);

		document.body.appendChild(selWrap);
		document.body.appendChild(btn);
		applyState(btn, badge);
	});
})();
