<?php
/**
 * KR Theme Setup
 * 
 * Handles theme setup and WordPress features
 * Based on Astra's architecture patterns
 *
 * @package KR_Theme
 * @since 1.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'KR_Theme_Setup' ) ) {

	/**
	 * KR_Theme_Setup class
	 */
	final class KR_Theme_Setup {

		/**
		 * Instance
		 */
		private static $instance = null;

		/**
		 * Get Instance
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		private function __construct() {
			$this->setup_theme_support();
			$this->setup_image_sizes();
			$this->setup_menus();
			$this->setup_sidebars();
			$this->init_hooks();
		}

		/**
		 * Theme support
		 */
		private function setup_theme_support() {
			// Let WordPress manage the document title
			add_theme_support( 'title-tag' );

			// Enable support for Post Thumbnails
			add_theme_support( 'post-thumbnails' );

			// HTML5 markup support
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

			// RSS feed links to head
			add_theme_support( 'automatic-feed-links' );

			// Custom logo support
			add_theme_support( 'custom-logo', array(
				'height'      => 60,
				'width'       => 200,
				'flex-height' => true,
				'flex-width'  => true,
				'header-text' => array( 'site-title', 'site-description' ),
			) );

			// Custom background support
			add_theme_support( 'custom-background', array(
				'default-color' => 'ffffff',
			) );

			// Wide alignment support
			add_theme_support( 'align-wide' );

			// Responsive embeds
			add_theme_support( 'responsive-embeds' );

			// Elementor support
			add_theme_support( 'elementor' );

			// WooCommerce support
			add_theme_support( 'woocommerce' );
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );
		}

		/**
		 * Setup custom image sizes
		 */
		private function setup_image_sizes() {
			// Blog thumbnail
			add_image_size( 'kr-blog-thumb', 400, 250, true );
			
			// Portfolio thumbnail
			add_image_size( 'kr-portfolio-thumb', 600, 400, true );
			
			// Hero image
			add_image_size( 'kr-hero', 1200, 600, true );
		}

		/**
		 * Register navigation menus
		 */
		private function setup_menus() {
			register_nav_menus( array(
				'primary'   => esc_html__( 'Primary Menu', 'kr-theme' ),
				'footer'    => esc_html__( 'Footer Menu', 'kr-theme' ),
				'mobile'    => esc_html__( 'Mobile Menu', 'kr-theme' ),
			) );
		}

		/**
		 * Setup widget areas
		 */
		private function setup_sidebars() {
			add_action( 'widgets_init', array( $this, 'register_sidebars' ) );
		}

		/**
		 * Register sidebars
		 */
		public function register_sidebars() {
			// Primary sidebar
			register_sidebar( array(
				'name'          => esc_html__( 'Primary Sidebar', 'kr-theme' ),
				'id'            => 'sidebar-1',
				'description'   => esc_html__( 'Add widgets here.', 'kr-theme' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );

			// Footer widgets
			for ( $i = 1; $i <= 4; $i++ ) {
				register_sidebar( array(
					'name'          => sprintf( esc_html__( 'Footer Widget %d', 'kr-theme' ), $i ),
					'id'            => 'footer-' . $i,
					'description'   => sprintf( esc_html__( 'Add widgets to footer column %d.', 'kr-theme' ), $i ),
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h4 class="widget-title">',
					'after_title'   => '</h4>',
				) );
			}
		}

		/**
		 * Initialize hooks
		 */
		private function init_hooks() {
			// Content width
			add_action( 'after_setup_theme', array( $this, 'content_width' ), 0 );

			// Excerpt length
			add_filter( 'excerpt_length', array( $this, 'excerpt_length' ) );

			// Excerpt more
			add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );

			// Body classes
			add_filter( 'body_class', array( $this, 'body_classes' ) );

			// Pingback header
			add_action( 'wp_head', array( $this, 'pingback_header' ) );
		}

		/**
		 * Set content width
		 */
		public function content_width() {
			$GLOBALS['content_width'] = apply_filters( 'kr_theme_content_width', 1200 );
		}

		/**
		 * Custom excerpt length
		 */
		public function excerpt_length( $length ) {
			if ( is_admin() ) {
				return $length;
			}

			return apply_filters( 'kr_theme_excerpt_length', 20 );
		}

		/**
		 * Custom excerpt more
		 */
		public function excerpt_more( $more ) {
			if ( is_admin() ) {
				return $more;
			}

			return apply_filters( 'kr_theme_excerpt_more', '&hellip;' );
		}

		/**
		 * Add custom body classes
		 */
		public function body_classes( $classes ) {
			// Add class if we're viewing the Customizer
			if ( is_customize_preview() ) {
				$classes[] = 'customizer-preview';
			}

			// Add class on front page
			if ( is_front_page() && is_home() ) {
				$classes[] = 'kr-blog-home';
			} elseif ( is_front_page() ) {
				$classes[] = 'kr-front-page';
			}

			// Add class if sidebar is active
			if ( is_active_sidebar( 'sidebar-1' ) && ! is_page_template( 'templates/full-width.php' ) ) {
				$classes[] = 'has-sidebar';
			} else {
				$classes[] = 'no-sidebar';
			}

			// Add Elementor classes
			if ( class_exists( 'Elementor\Plugin' ) ) {
				$classes[] = 'elementor-default';
				
				if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
					$classes[] = 'elementor-preview-mode';
				}
			}

			return $classes;
		}

		/**
		 * Add pingback header
		 */
		public function pingback_header() {
			if ( is_singular() && pings_open() ) {
				printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
			}
		}

		/**
		 * Get default theme options
		 */
		public static function get_theme_defaults() {
			return array(
				'site_layout'           => 'full-width',
				'container_width'       => 1200,
				'primary_color'         => '#3b82f6',
				'text_color'           => '#374151',
				'link_color'           => '#3b82f6',
				'heading_font_family'  => 'inherit',
				'body_font_family'     => 'inherit',
				'show_page_title'      => true,
				'show_breadcrumbs'     => false,
			);
		}
	}
}