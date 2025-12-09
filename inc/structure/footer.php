<?php
/**
 * Footer Structure Functions
 *
 * @package KR_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get footer layout
 */
function kr_theme_get_footer_layout() {
	return get_theme_mod( 'kr_theme_footer_layout', 'columns-4' );
}

/**
 * Get copyright text
 */
function kr_theme_get_copyright_text() {
	return get_theme_mod( 'kr_theme_copyright_text', '' );
}
