<?php
/**
 * Post Structure Functions
 *
 * @package KR_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get post layout
 */
function kr_theme_get_post_layout() {
	return get_theme_mod( 'kr_theme_post_layout', 'default' );
}

/**
 * Check if featured image should be displayed
 */
function kr_theme_show_featured_image() {
	return get_theme_mod( 'kr_theme_show_featured_image', true );
}
