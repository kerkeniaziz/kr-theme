<?php
/**
 * Archive Structure Functions
 *
 * @package KR_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get archive layout
 */
function kr_theme_get_archive_layout() {
	return get_theme_mod( 'kr_theme_archive_layout', 'default' );
}

/**
 * Get posts per page for archives
 */
function kr_theme_archive_posts_per_page( $query ) {
	if ( ! is_admin() && $query->is_main_query() && is_archive() ) {
		$posts_per_page = get_theme_mod( 'kr_theme_archive_posts_per_page', 10 );
		$query->set( 'posts_per_page', $posts_per_page );
	}
}
add_action( 'pre_get_posts', 'kr_theme_archive_posts_per_page' );
