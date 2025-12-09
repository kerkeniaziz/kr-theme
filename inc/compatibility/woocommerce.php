<?php
/**
 * WooCommerce Compatibility
 *
 * @package KR_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Declare WooCommerce support
 */
function kr_theme_woocommerce_support() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'kr_theme_woocommerce_support' );

/**
 * WooCommerce layout
 */
function kr_theme_woocommerce_wrapper_start() {
	echo '<div class="kr-container"><div class="kr-content-wrapper"><main id="primary" class="kr-main-content site-main">';
}
add_action( 'woocommerce_before_main_content', 'kr_theme_woocommerce_wrapper_start', 10 );

function kr_theme_woocommerce_wrapper_end() {
	echo '</main>';
	get_sidebar();
	echo '</div></div>';
}
add_action( 'woocommerce_after_main_content', 'kr_theme_woocommerce_wrapper_end', 10 );

/**
 * Remove default WooCommerce wrappers
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/**
 * Enqueue WooCommerce styles
 */
function kr_theme_woocommerce_scripts() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}
	
	wp_enqueue_style( 'kr-theme-woocommerce', KR_THEME_URI . '/assets/css/woocommerce.css', array(), KR_THEME_VERSION );
}
add_action( 'wp_enqueue_scripts', 'kr_theme_woocommerce_scripts' );

/**
 * Customize WooCommerce products per page
 */
function kr_theme_woocommerce_products_per_page() {
	return get_theme_mod( 'kr_theme_woocommerce_products_per_page', 12 );
}
add_filter( 'loop_shop_per_page', 'kr_theme_woocommerce_products_per_page', 20 );

/**
 * Customize WooCommerce product columns
 */
function kr_theme_woocommerce_product_columns() {
	return get_theme_mod( 'kr_theme_woocommerce_product_columns', 3 );
}
add_filter( 'loop_shop_columns', 'kr_theme_woocommerce_product_columns' );
