/**
 * Accessibility Features
 * Keyboard navigation and focus management
 */
(function() {
	'use strict';

	// Add outline on keyboard focus
	document.addEventListener('keydown', function(e) {
		if (e.key === 'Tab') {
			document.body.classList.add('keyboard-navigation');
		}
	});

	document.addEventListener('mousedown', function() {
		document.body.classList.remove('keyboard-navigation');
	});

	// Focus management for modals and popups
	const trapFocus = function(element) {
		const focusableElements = element.querySelectorAll(
			'a[href], button:not([disabled]), textarea, input, select, [tabindex]:not([tabindex="-1"])'
		);
		
		if (focusableElements.length === 0) return;
		
		const firstFocusable = focusableElements[0];
		const lastFocusable = focusableElements[focusableElements.length - 1];
		
		element.addEventListener('keydown', function(e) {
			if (e.key === 'Tab') {
				if (e.shiftKey && document.activeElement === firstFocusable) {
					e.preventDefault();
					lastFocusable.focus();
				} else if (!e.shiftKey && document.activeElement === lastFocusable) {
					e.preventDefault();
					firstFocusable.focus();
				}
			}
			
			if (e.key === 'Escape') {
				element.classList.remove('active');
			}
		});
	};

	// Apply focus trap to modals
	const modals = document.querySelectorAll('.modal, .popup');
	modals.forEach(modal => {
		trapFocus(modal);
	});

	// Skip to content link functionality
	const skipLinks = document.querySelectorAll('.skip-link');
	skipLinks.forEach(link => {
		link.addEventListener('click', function(e) {
			const target = document.querySelector(this.getAttribute('href'));
			if (target) {
				e.preventDefault();
				target.setAttribute('tabindex', '-1');
				target.focus();
				target.scrollIntoView({ behavior: 'smooth' });
			}
		});
	});
})();
