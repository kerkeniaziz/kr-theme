<?php
/**
 * Custom Hooks
 *
 * @package KR_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Hook: Before header
 */
function kr_theme_before_header() {
	do_action( 'kr_theme_before_header' );
}

/**
 * Hook: After header
 */
function kr_theme_after_header() {
	do_action( 'kr_theme_after_header' );
}

/**
 * Hook: Before content
 */
function kr_theme_before_content() {
	do_action( 'kr_theme_before_content' );
}

/**
 * Hook: After content
 */
function kr_theme_after_content() {
	do_action( 'kr_theme_after_content' );
}

/**
 * Hook: Before footer
 */
function kr_theme_before_footer() {
	do_action( 'kr_theme_before_footer' );
}

/**
 * Hook: After footer
 */
function kr_theme_after_footer() {
	do_action( 'kr_theme_after_footer' );
}

/**
 * Custom excerpt length
 */
function kr_theme_excerpt_length( $length ) {
	$excerpt_length = get_theme_mod( 'kr_theme_excerpt_length', 30 );
	return absint( $excerpt_length );
}
add_filter( 'excerpt_length', 'kr_theme_excerpt_length', 999 );

/**
 * Custom excerpt more text
 */
function kr_theme_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'kr_theme_excerpt_more' );

/**
 * Add Read More link to excerpt
 */
function kr_theme_excerpt_read_more( $excerpt ) {
	if ( ! is_singular() ) {
		$excerpt .= ' <a href="' . esc_url( get_permalink() ) . '" class="read-more">' . esc_html__( 'Read More', 'kr-theme' ) . '</a>';
	}
	return $excerpt;
}
add_filter( 'the_excerpt', 'kr_theme_excerpt_read_more' );
