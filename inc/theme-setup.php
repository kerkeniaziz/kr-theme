<?php
/**
 * Theme Setup and Configuration
 *
 * @package KR_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function kr_theme_setup() {
	// Make theme available for translation
	load_theme_textdomain( 'kr-theme', KR_THEME_DIR . '/languages' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 675, true );

	// Add additional image sizes
	add_image_size( 'kr-theme-featured', 800, 450, true );
	add_image_size( 'kr-theme-thumbnail', 400, 300, true );

	// Register navigation menus
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'kr-theme' ),
		'footer'  => esc_html__( 'Footer Menu', 'kr-theme' ),
	) );

	// Switch default core markup to output valid HTML5
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );

	// Add theme support for selective refresh for widgets
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for custom logo
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 300,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	// Add support for custom header
	add_theme_support( 'custom-header', array(
		'default-image'      => '',
		'width'              => 1920,
		'height'             => 400,
		'flex-height'        => true,
		'flex-width'         => true,
		'header-text'        => true,
		'default-text-color' => '000000',
	) );

	// Add support for custom background
	add_theme_support( 'custom-background', array(
		'default-color' => 'ffffff',
	) );

	// Add support for editor styles
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor-style.css' );

	// Add support for responsive embeds
	add_theme_support( 'responsive-embeds' );

	// Add support for wide alignment
	add_theme_support( 'align-wide' );

	// Add support for editor color palette
	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => esc_html__( 'Primary', 'kr-theme' ),
			'slug'  => 'primary',
			'color' => '#2563eb',
		),
		array(
			'name'  => esc_html__( 'Secondary', 'kr-theme' ),
			'slug'  => 'secondary',
			'color' => '#0f172a',
		),
		array(
			'name'  => esc_html__( 'Text', 'kr-theme' ),
			'slug'  => 'text',
			'color' => '#1e293b',
		),
		array(
			'name'  => esc_html__( 'Background', 'kr-theme' ),
			'slug'  => 'background',
			'color' => '#ffffff',
		),
	) );

	// Set content width
	$GLOBALS['content_width'] = apply_filters( 'kr_theme_content_width', 800 );
}
add_action( 'after_setup_theme', 'kr_theme_setup' );

/**
 * Register widget areas
 */
function kr_theme_widgets_init() {
	// Primary sidebar
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'kr-theme' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'kr-theme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	// Footer widget areas
	$footer_widget_regions = apply_filters( 'kr_theme_footer_widget_regions', 4 );
	for ( $i = 1; $i <= intval( $footer_widget_regions ); $i++ ) {
		register_sidebar( array(
			'name'          => sprintf( esc_html__( 'Footer %d', 'kr-theme' ), $i ),
			'id'            => 'footer-' . $i,
			'description'   => sprintf( esc_html__( 'Add widgets here to appear in footer column %d.', 'kr-theme' ), $i ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}
}
add_action( 'widgets_init', 'kr_theme_widgets_init' );

/**
 * Add body classes for layout customization
 */
function kr_theme_body_classes( $classes ) {
	// Add class for active sidebar
	if ( is_active_sidebar( 'sidebar-1' ) && ! is_page_template( 'templates/template-fullwidth.php' ) ) {
		$classes[] = 'has-sidebar';
	} else {
		$classes[] = 'no-sidebar';
	}

	// Add class if custom logo exists
	if ( has_custom_logo() ) {
		$classes[] = 'has-custom-logo';
	}

	// Add class for singular pages
	if ( is_singular() ) {
		$classes[] = 'singular';
	}

	return $classes;
}
add_filter( 'body_class', 'kr_theme_body_classes' );

/**
 * Add custom classes to post
 */
function kr_theme_post_classes( $classes, $class, $post_id ) {
	// Add has-post-thumbnail class
	if ( has_post_thumbnail( $post_id ) ) {
		$classes[] = 'has-post-thumbnail';
	}

	return $classes;
}
add_filter( 'post_class', 'kr_theme_post_classes', 10, 3 );
