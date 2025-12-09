<?php
/**
 * KR Enqueue
 * 
 * Handles scripts and styles enqueuing with performance optimization
 * Based on Astra's efficient asset loading patterns
 *
 * @package KR_Theme
 * @since 1.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'KR_Enqueue' ) ) {

	/**
	 * KR_Enqueue class
	 */
	final class KR_Enqueue {

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
			$this->enqueue_styles();
			$this->enqueue_scripts();
			$this->init_hooks();
		}

		/**
		 * Enqueue styles
		 */
		private function enqueue_styles() {
			// Main theme stylesheet
			wp_enqueue_style(
				'kr-theme-style',
				get_stylesheet_uri(),
				array(),
				KR_THEME_VERSION
			);

			// Add RTL support
			wp_style_add_data( 'kr-theme-style', 'rtl', 'replace' );

			// Conditional styles
			$this->conditional_styles();
		}

		/**
		 * Conditional styles - Load only when needed
		 */
		private function conditional_styles() {
			// Elementor styles (only if Elementor is active and page uses it)
			if ( class_exists( 'Elementor\Plugin' ) ) {
				if ( $this->is_elementor_page() || is_customize_preview() ) {
					wp_enqueue_style(
						'kr-elementor',
						KR_THEME_URI . '/assets/css/elementor.css',
						array( 'kr-theme-style' ),
						KR_THEME_VERSION
					);
				}
			}

			// WooCommerce styles (only on WooCommerce pages)
			if ( class_exists( 'WooCommerce' ) && $this->is_woocommerce_page() ) {
				wp_enqueue_style(
					'kr-woocommerce',
					KR_THEME_URI . '/assets/css/woocommerce.css',
					array( 'kr-theme-style' ),
					KR_THEME_VERSION
				);
			}
		}

		/**
		 * Enqueue scripts
		 */
		private function enqueue_scripts() {
			// Navigation script
			wp_enqueue_script(
				'kr-navigation',
				KR_THEME_URI . '/assets/js/navigation.js',
				array(),
				KR_THEME_VERSION,
				true
			);

			// Main theme script
			wp_enqueue_script(
				'kr-theme-script',
				KR_THEME_URI . '/assets/js/main.js',
				array( 'kr-navigation' ),
				KR_THEME_VERSION,
				true
			);

			// Localize script
			wp_localize_script( 'kr-theme-script', 'krTheme', array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'kr_theme_nonce' ),
				'strings' => array(
					'loading' => __( 'Loading...', 'kr-theme' ),
					'error'   => __( 'Something went wrong. Please try again.', 'kr-theme' ),
				),
			) );

			// Comment reply script
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}

			// Skip link focus fix for IE11
			wp_enqueue_script(
				'kr-skip-link-focus-fix',
				KR_THEME_URI . '/assets/js/accessibility.js',
				array(),
				KR_THEME_VERSION,
				true
			);
		}

		/**
		 * Initialize hooks
		 */
		private function init_hooks() {
			// Remove jQuery migrate in frontend (performance optimization)
			add_action( 'wp_default_scripts', array( $this, 'remove_jquery_migrate' ) );

			// Preload key resources
			add_action( 'wp_head', array( $this, 'preload_assets' ), 1 );

			// Add async/defer attributes
			add_filter( 'script_loader_tag', array( $this, 'add_async_defer_attributes' ), 10, 3 );

			// Remove version query strings (for caching)
			add_filter( 'style_loader_src', array( $this, 'remove_version_query_strings' ), 10, 1 );
			add_filter( 'script_loader_src', array( $this, 'remove_version_query_strings' ), 10, 1 );

			// Admin styles
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
		}

		/**
		 * Check if current page uses Elementor
		 */
		private function is_elementor_page() {
			if ( ! class_exists( 'Elementor\Plugin' ) ) {
				return false;
			}

			$elementor_page_id = get_the_ID();
			
			if ( ! $elementor_page_id ) {
				return false;
			}

			return \Elementor\Plugin::$instance->documents->get( $elementor_page_id )->is_built_with_elementor();
		}

		/**
		 * Check if current page is WooCommerce related
		 */
		private function is_woocommerce_page() {
			if ( ! class_exists( 'WooCommerce' ) ) {
				return false;
			}

			return is_woocommerce() || is_shop() || is_product_category() || is_product_tag() || is_product() || is_cart() || is_checkout() || is_account_page();
		}

		/**
		 * Remove jQuery Migrate for performance
		 */
		public function remove_jquery_migrate( $scripts ) {
			if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
				$script = $scripts->registered['jquery'];
				
				if ( $script->deps ) {
					$script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
				}
			}
		}

		/**
		 * Preload key assets for performance
		 */
		public function preload_assets() {
			// Preload main stylesheet
			echo '<link rel="preload" href="' . esc_url( get_stylesheet_uri() ) . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">';
			echo '<noscript><link rel="stylesheet" href="' . esc_url( get_stylesheet_uri() ) . '"></noscript>';

			// Preload fonts if any
			$this->preload_fonts();
		}

		/**
		 * Preload web fonts
		 */
		private function preload_fonts() {
			// Add font preloading here if using custom fonts
			// Example:
			// echo '<link rel="preload" href="' . KR_THEME_URI . '/assets/fonts/font.woff2" as="font" type="font/woff2" crossorigin>';
		}

		/**
		 * Add async/defer attributes to scripts
		 */
		public function add_async_defer_attributes( $tag, $handle, $src ) {
			// Scripts to defer
			$defer_scripts = array( 'kr-theme-script', 'kr-navigation' );
			
			// Scripts to async
			$async_scripts = array( 'kr-skip-link-focus-fix' );

			if ( in_array( $handle, $defer_scripts, true ) ) {
				return str_replace( '<script ', '<script defer ', $tag );
			}

			if ( in_array( $handle, $async_scripts, true ) ) {
				return str_replace( '<script ', '<script async ', $tag );
			}

			return $tag;
		}

		/**
		 * Remove version query strings for better caching
		 */
		public function remove_version_query_strings( $src ) {
			if ( strpos( $src, 'ver=' ) ) {
				$src = remove_query_arg( 'ver', $src );
			}
			return $src;
		}

		/**
		 * Admin styles
		 */
		public function admin_styles( $hook_suffix ) {
			// Only on theme-related admin pages
			if ( in_array( $hook_suffix, array( 'themes.php', 'customize.php' ), true ) ) {
				wp_enqueue_style(
					'kr-admin-style',
					KR_THEME_URI . '/assets/css/admin.css',
					array(),
					KR_THEME_VERSION
				);
			}
		}

		/**
		 * Get inline CSS for critical above-the-fold styles
		 */
		public static function get_critical_css() {
			$css = "
			/* Critical CSS - Above the fold */
			body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;line-height:1.6;margin:0}
			.container{max-width:1200px;margin:0 auto;padding:0 1rem}
			.header{background:#fff;border-bottom:1px solid #e5e7eb;position:sticky;top:0;z-index:999}
			.nav ul{display:flex;list-style:none;margin:0;padding:0;gap:2rem}
			.nav a{color:#374151;text-decoration:none;font-weight:500}
			.nav a:hover{color:#3b82f6}
			@media(max-width:768px){.nav{display:none}}
			";

			return apply_filters( 'kr_theme_critical_css', $css );
		}

		/**
		 * Output critical CSS inline
		 */
		public static function output_critical_css() {
			$css = self::get_critical_css();
			if ( ! empty( $css ) ) {
				echo '<style id="kr-critical-css">' . $css . '</style>';
			}
		}
	}
}