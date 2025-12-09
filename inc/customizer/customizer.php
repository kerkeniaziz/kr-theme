<?php
/**
 * Customizer Main Loader
 *
 * @package KR_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load customizer files
 */
require_once KR_THEME_DIR . '/inc/customizer/colors.php';
require_once KR_THEME_DIR . '/inc/customizer/typography.php';
require_once KR_THEME_DIR . '/inc/customizer/layout.php';
require_once KR_THEME_DIR . '/inc/customizer/controls.php';

/**
 * Register customizer settings
 */
function kr_theme_customize_register( $wp_customize ) {
	// Add postMessage support for site title and description
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdesc' )->transport = 'postMessage';
	
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => function() {
					bloginfo( 'name' );
				},
			)
		);
		
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => function() {
					bloginfo( 'description' );
				},
			)
		);
	}
}
add_action( 'customize_register', 'kr_theme_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously
 */
function kr_theme_customize_preview_js() {
	wp_enqueue_script( 'kr-theme-customizer', KR_THEME_URI . '/assets/js/customizer.js', array( 'customize-preview' ), KR_THEME_VERSION, true );
}
add_action( 'customize_preview_init', 'kr_theme_customize_preview_js' );
