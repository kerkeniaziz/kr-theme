<?php
/**
 * KR Theme Functions
 * 
 * Main entry point - loads the core theme class
 *
 * @package KR_Theme
 * @author KR Theme
 * @link https://www.krtheme.com
 * @since 1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load System Requirements Checker
 */
require_once get_template_directory() . '/inc/core/class-kr-requirements.php';

/**
 * Load Main Theme Class
 */
require_once get_template_directory() . '/inc/class-kr-theme.php';

/**
 * Initialize Theme - Following Astra's singleton pattern
 */
function kr_theme_init() {
	return KR_Theme::instance();
}

/**
 * Start the theme after WordPress loads
 */
add_action( 'after_setup_theme', 'kr_theme_init', -1 );

/**
 * Load WooCommerce Support
 */
if ( class_exists( 'WooCommerce' ) ) {
	require_once get_template_directory() . '/inc/compatibility/woocommerce-functions.php';
}

/**
 * Enqueue WooCommerce Styles
 */
function kr_theme_woocommerce_styles() {
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style(
			'kr-woocommerce',
			get_template_directory_uri() . '/inc/compatibility/woocommerce-styles.css',
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
}
add_action( 'wp_enqueue_scripts', 'kr_theme_woocommerce_styles' );

/**
 * Add WooCommerce Support
 */
function kr_theme_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'kr_theme_add_woocommerce_support' );

/**
 * Register WooCommerce Sidebar
 */
function kr_theme_register_woocommerce_widgets() {
	register_sidebar( array(
		'name'          => esc_html__( 'WooCommerce Sidebar', 'kr-theme' ),
		'id'            => 'woocommerce-sidebar',
		'description'   => esc_html__( 'Sidebar displayed on WooCommerce pages', 'kr-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'kr_theme_register_woocommerce_widgets' );
