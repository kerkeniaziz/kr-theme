<?php
/**
 * HTML Markup Functions
 *
 * @package KR_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Output schema.org markup for article
 */
function kr_theme_article_schema() {
	if ( ! is_singular( 'post' ) ) {
		return;
	}
	
	$schema = array(
		'@context'      => 'https://schema.org',
		'@type'         => 'BlogPosting',
		'headline'      => get_the_title(),
		'datePublished' => get_the_date( 'c' ),
		'dateModified'  => get_the_modified_date( 'c' ),
		'author'        => array(
			'@type' => 'Person',
			'name'  => get_the_author(),
		),
	);
	
	if ( has_post_thumbnail() ) {
		$schema['image'] = get_the_post_thumbnail_url( null, 'full' );
	}
	
	echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>';
}
add_action( 'wp_head', 'kr_theme_article_schema' );

/**
 * Output breadcrumbs
 */
function kr_theme_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}
	
	$separator = ' &raquo; ';
	$home_text = esc_html__( 'Home', 'kr-theme' );
	
	echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'kr-theme' ) . '">';
	echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( $home_text ) . '</a>';
	
	if ( is_category() || is_single() ) {
		echo $separator;
		$categories = get_the_category();
		if ( ! empty( $categories ) ) {
			$category = $categories[0];
			echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
		}
		if ( is_single() ) {
			echo $separator;
			the_title( '<span>', '</span>' );
		}
	} elseif ( is_page() ) {
		echo $separator;
		the_title( '<span>', '</span>' );
	} elseif ( is_search() ) {
		echo $separator;
		echo '<span>' . esc_html__( 'Search Results', 'kr-theme' ) . '</span>';
	} elseif ( is_404() ) {
		echo $separator;
		echo '<span>' . esc_html__( '404 Not Found', 'kr-theme' ) . '</span>';
	}
	
	echo '</nav>';
}

/**
 * Get post meta information
 */
function kr_theme_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}
	
	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_html( get_the_modified_date() )
	);
	
	$posted_on = sprintf(
		/* translators: %s: post date. */
		esc_html_x( 'Posted on %s', 'post date', 'kr-theme' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);
	
	echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Get post author
 */
function kr_theme_posted_by() {
	$byline = sprintf(
		/* translators: %s: post author. */
		esc_html_x( 'by %s', 'post author', 'kr-theme' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);
	
	echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Display post categories
 */
function kr_theme_post_categories() {
	$categories_list = get_the_category_list( esc_html__( ', ', 'kr-theme' ) );
	if ( $categories_list ) {
		printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'kr-theme' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

/**
 * Display post tags
 */
function kr_theme_post_tags() {
	$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'kr-theme' ) );
	if ( $tags_list ) {
		printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'kr-theme' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

/**
 * Display comments link
 */
function kr_theme_comments_link() {
	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link(
			sprintf(
				wp_kses(
					/* translators: %s: post title */
					__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'kr-theme' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);
		echo '</span>';
	}
}
