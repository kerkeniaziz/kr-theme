<?php
/**
 * Gutenberg Compatibility
 *
 * @package KR_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Gutenberg editor styles
 */
function kr_theme_gutenberg_editor_styles() {
	wp_enqueue_style( 'kr-theme-editor-styles', KR_THEME_URI . '/assets/css/editor-style.css', false, KR_THEME_VERSION, 'all' );
}
add_action( 'enqueue_block_editor_assets', 'kr_theme_gutenberg_editor_styles' );

/**
 * Add support for Gutenberg wide images
 */
function kr_theme_gutenberg_setup() {
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
}
add_action( 'after_setup_theme', 'kr_theme_gutenberg_setup' );

/**
 * Enqueue Gutenberg block styles
 */
function kr_theme_gutenberg_block_styles() {
	wp_enqueue_style( 'kr-theme-blocks', KR_THEME_URI . '/assets/css/blocks.css', false, KR_THEME_VERSION );
}
add_action( 'wp_enqueue_scripts', 'kr_theme_gutenberg_block_styles' );
