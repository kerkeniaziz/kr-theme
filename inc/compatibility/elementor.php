<?php
/**
 * Elementor Compatibility
 *
 * @package KR_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Elementor locations
 */
function kr_theme_register_elementor_locations( $elementor_theme_manager ) {
	$elementor_theme_manager->register_all_core_location();
}
add_action( 'elementor/theme/register_locations', 'kr_theme_register_elementor_locations' );

/**
 * Add Elementor support
 */
function kr_theme_elementor_support() {
	// Elementor Canvas support
	add_theme_support( 'elementor' );
	
	// Add custom width
	add_theme_support( 'elementor', array(
		'settings' => array(
			'page_title_selector' => '.entry-title',
			'page_wrapper_selector' => '.kr-main-content',
		),
	) );
}
add_action( 'after_setup_theme', 'kr_theme_elementor_support' );

/**
 * Enqueue Elementor compatibility CSS
 */
function kr_theme_elementor_css() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}
	
	wp_enqueue_style( 'kr-theme-elementor', KR_THEME_URI . '/assets/css/elementor.css', array(), KR_THEME_VERSION );
}
add_action( 'wp_enqueue_scripts', 'kr_theme_elementor_css' );

/**
 * Remove theme wrapper for Elementor canvas
 */
function kr_theme_elementor_canvas_body_class( $classes ) {
	if ( class_exists( '\Elementor\Plugin' ) ) {
		$page_id = get_the_ID();
		$document = \Elementor\Plugin::$instance->documents->get( $page_id );
		
		if ( $document && 'canvas' === $document->get_settings( 'template' ) ) {
			$classes[] = 'elementor-template-canvas';
		}
	}
	
	return $classes;
}
add_filter( 'body_class', 'kr_theme_elementor_canvas_body_class' );
