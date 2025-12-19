<?php
/**
 * KR Theme - Enqueue Frontend
 * 
 * @package KR_Theme
 */

if ( ! function_exists( 'kr_enqueue_frontend_scripts' ) ) {
	function kr_enqueue_frontend_scripts() {
		wp_enqueue_style( 'kr-theme-style', get_stylesheet_uri() );
		wp_enqueue_script( 'kr-theme-script', get_template_directory_uri() . '/assets/js/script.js', array( 'jquery' ), '1.0', true );
	}

	add_action( 'wp_enqueue_scripts', 'kr_enqueue_frontend_scripts' );
}
