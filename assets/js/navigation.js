/**
 * Navigation Scripts
 * Handles mobile menu toggle and keyboard navigation
 */
(function() {
	'use strict';

	// Mobile menu toggle
	const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
	const navigation = document.querySelector('.main-navigation');

	if (mobileMenuToggle && navigation) {
		mobileMenuToggle.addEventListener('click', function() {
			const expanded = this.getAttribute('aria-expanded') === 'true' || false;
			this.setAttribute('aria-expanded', !expanded);
			navigation.classList.toggle('toggled');
		});
	}

	// Close mobile menu when clicking outside
	document.addEventListener('click', function(event) {
		if (!event.target.closest('.main-navigation') && !event.target.closest('.mobile-menu-toggle')) {
			if (navigation && navigation.classList.contains('toggled')) {
				navigation.classList.remove('toggled');
				if (mobileMenuToggle) {
					mobileMenuToggle.setAttribute('aria-expanded', 'false');
				}
			}
		}
	});

	// Dropdown menu keyboard navigation
	const menuItems = document.querySelectorAll('.main-navigation li');
	
	menuItems.forEach(function(item) {
		item.addEventListener('keydown', function(e) {
			if (e.key === 'Escape') {
				const openSubMenu = this.querySelector('.sub-menu');
				if (openSubMenu) {
					this.querySelector('a').focus();
				}
			}
		});
	});

	// Add aria-haspopup to parent menu items
	const parentMenuItems = document.querySelectorAll('.main-navigation .menu-item-has-children > a');
	parentMenuItems.forEach(function(item) {
		item.setAttribute('aria-haspopup', 'true');
		item.setAttribute('aria-expanded', 'false');
	});
})();
