<?php
/**
 * Enqueue scripts and styles
 *
 * @package KR_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue theme styles
 */
function kr_theme_enqueue_styles() {
	// Main stylesheet
	wp_enqueue_style( 'kr-theme-style', get_stylesheet_uri(), array(), KR_THEME_VERSION );
	
	// Additional CSS
	wp_enqueue_style( 'kr-theme-main', KR_THEME_URI . '/assets/css/main.css', array(), KR_THEME_VERSION );
	
	// Add inline CSS for customizer colors
	$custom_css = kr_theme_get_customizer_css();
	if ( $custom_css ) {
		wp_add_inline_style( 'kr-theme-style', $custom_css );
	}
}
add_action( 'wp_enqueue_scripts', 'kr_theme_enqueue_styles' );

/**
 * Enqueue theme scripts
 */
function kr_theme_enqueue_scripts() {
	// Navigation script
	wp_enqueue_script( 'kr-theme-navigation', KR_THEME_URI . '/assets/js/navigation.js', array(), KR_THEME_VERSION, true );
	
	// Main script
	wp_enqueue_script( 'kr-theme-main', KR_THEME_URI . '/assets/js/main.js', array(), KR_THEME_VERSION, true );
	
	// Comment reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	// Accessibility script
	wp_enqueue_script( 'kr-theme-accessibility', KR_THEME_URI . '/assets/js/accessibility.js', array(), KR_THEME_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'kr_theme_enqueue_scripts' );

/**
 * Generate customizer CSS
 */
function kr_theme_get_customizer_css() {
	$css = '';
	
	// Primary color
	$primary_color = get_theme_mod( 'kr_theme_primary_color', '#2563eb' );
	if ( $primary_color !== '#2563eb' ) {
		$css .= ':root { --kr-color-primary: ' . esc_attr( $primary_color ) . '; }';
	}
	
	// Secondary color
	$secondary_color = get_theme_mod( 'kr_theme_secondary_color', '#0f172a' );
	if ( $secondary_color !== '#0f172a' ) {
		$css .= ':root { --kr-color-secondary: ' . esc_attr( $secondary_color ) . '; }';
	}
	
	// Container width
	$container_width = get_theme_mod( 'kr_theme_container_width', 1200 );
	if ( $container_width != 1200 ) {
		$css .= ':root { --kr-container-width: ' . intval( $container_width ) . 'px; }';
	}
	
	return $css;
}

/**
 * Add preconnect for Google Fonts (if enabled)
 */
function kr_theme_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'kr_theme_resource_hints', 10, 2 );
