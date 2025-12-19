<?php
/**
 * KR Theme - Setup
 * 
 * @package KR_Theme
 */

if ( ! function_exists( 'kr_setup_theme' ) ) {
	function kr_setup_theme() {
		load_theme_textdomain( 'kr-theme', get_template_directory() . '/languages' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'custom-logo' );
		add_theme_support( 'woocommerce' );
	}

	add_action( 'after_setup_theme', 'kr_setup_theme' );
}
