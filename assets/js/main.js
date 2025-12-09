/**
 * Main Theme JavaScript
 * General theme functionality
 */
(function() {
	'use strict';

	// Smooth scroll for anchor links
	document.querySelectorAll('a[href^="#"]').forEach(anchor => {
		anchor.addEventListener('click', function(e) {
			const href = this.getAttribute('href');
			if (href !== '#' && href !== '#0') {
				const target = document.querySelector(href);
				if (target) {
					e.preventDefault();
					target.scrollIntoView({
						behavior: 'smooth',
						block: 'start'
					});
				}
			}
		});
	});

	// Add loaded class to body
	window.addEventListener('load', function() {
		document.body.classList.add('loaded');
	});

	// Lazy load images
	if ('loading' in HTMLImageElement.prototype) {
		const images = document.querySelectorAll('img[loading="lazy"]');
		images.forEach(img => {
			img.src = img.dataset.src || img.src;
		});
	} else {
		// Fallback for browsers that don't support lazy loading
		const script = document.createElement('script');
		script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js';
		document.body.appendChild(script);
	}

	// External links in new tab
	document.querySelectorAll('a[href^="http"]').forEach(link => {
		if (link.hostname !== window.location.hostname) {
			link.setAttribute('target', '_blank');
			link.setAttribute('rel', 'noopener noreferrer');
		}
	});
})();
