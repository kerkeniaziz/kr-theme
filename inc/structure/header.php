<?php
/**
 * Header Structure Functions
 *
 * @package KR_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add sticky header class
 */
function kr_theme_sticky_header_class( $classes ) {
	if ( get_theme_mod( 'kr_theme_sticky_header', false ) ) {
		$classes[] = 'sticky-header';
	}
	return $classes;
}
add_filter( 'body_class', 'kr_theme_sticky_header_class' );

/**
 * Get header layout
 */
function kr_theme_get_header_layout() {
	return get_theme_mod( 'kr_theme_header_layout', 'default' );
}
