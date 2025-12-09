<?php
/**
 * Sidebar Structure Functions
 *
 * @package KR_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if sidebar should be displayed
 */
function kr_theme_display_sidebar() {
	// Don't display on Elementor canvas pages
	if ( function_exists( 'elementor_location_exits' ) ) {
		$document = \Elementor\Plugin::$instance->documents->get( get_the_ID() );
		if ( $document && 'canvas' === $document->get_settings( 'template' ) ) {
			return false;
		}
	}
	
	// Check if sidebar is active
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		return false;
	}
	
	// Check sidebar position setting
	$position = get_theme_mod( 'kr_theme_sidebar_position', 'right' );
	if ( 'none' === $position ) {
		return false;
	}
	
	return true;
}

/**
 * Get sidebar position
 */
function kr_theme_get_sidebar_position() {
	return get_theme_mod( 'kr_theme_sidebar_position', 'right' );
}
