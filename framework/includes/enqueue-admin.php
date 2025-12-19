<?php
/**
 * KR Theme - Enqueue Admin
 * 
 * @package KR_Theme
 */

/* Register Font Admin */
if ( ! function_exists( 'kr_fonts_url_admin' ) ) {
	function kr_fonts_url_admin() {
		$font_url = '';
		
		$inter = _x( 'on', 'Inter font: on or off', 'kr-theme' );
		$poppins = _x( 'on', 'Poppins font: on or off', 'kr-theme' );

		if ( 'off' !== $inter || 'off' !== $poppins ) {
			$font_families = array();
		}

		if ( 'off' !== $inter ) {
			$font_families[] = 'Inter:100,200,300,400,500,600,700,800,900';
		}

		if ( 'off' !== $poppins ) {
			$font_families[] = 'Poppins:100,200,300,400,500,600,700,800,900';
		}

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );

		return esc_url_raw( $fonts_url );
	}
}

if ( ! function_exists( 'kr_admin_enqueue_scripts' ) ) {
	function kr_admin_enqueue_scripts() {
		// Enqueue Script
		wp_enqueue_script( 'kr-admin-js', get_template_directory_uri() . '/framework/admin-assets/js/haru-admin.js', array(), '1.0.0', true );

		// Enqueue CSS
		wp_enqueue_style( 'kr-admin-style', get_template_directory_uri() . '/framework/admin-assets/css/admin-style.css', false, '1.0.0' );

		wp_enqueue_style( 'kr-admin-redux', get_template_directory_uri() . '/framework/admin-assets/css/admin-redux.css', false, '1.0.0' );

		// Load font for Editor
		wp_enqueue_style( 'kr-fonts-admin', kr_fonts_url_admin(), array(), '1.0.0' );
	}

	add_action( 'admin_enqueue_scripts', 'kr_admin_enqueue_scripts' );
}
