<?php
/**
 * Main KR Theme Class
 * 
 * Handles theme initialization and loading following Astra's proven patterns
 * 
 * @package KR_Theme
 * @since 1.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'KR_Theme' ) ) {

	/**
	 * Main KR_Theme Class - Singleton Pattern
	 */
	final class KR_Theme {

		/**
		 * Instance
		 *
		 * @var KR_Theme
		 */
		private static $instance = null;

		/**
		 * Get Instance - Singleton Pattern
		 *
		 * @return KR_Theme
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
			$this->define_constants();
			$this->includes();
			$this->init_hooks();
		}

		/**
		 * Define Constants
		 */
		private function define_constants() {
			if ( ! defined( 'KR_THEME_VERSION' ) ) {
				define( 'KR_THEME_VERSION', '1.3.0' );
			}
			if ( ! defined( 'KR_THEME_DIR' ) ) {
				define( 'KR_THEME_DIR', get_template_directory() );
			}
			if ( ! defined( 'KR_THEME_URI' ) ) {
				define( 'KR_THEME_URI', get_template_directory_uri() );
			}
			if ( ! defined( 'KR_THEME_INC_DIR' ) ) {
				define( 'KR_THEME_INC_DIR', KR_THEME_DIR . '/inc/' );
			}
		}

		/**
		 * Include Files - Load in correct order
		 */
		private function includes() {
			// Core files
			$this->include_file( 'core/class-kr-theme-setup.php' );
			$this->include_file( 'core/class-kr-enqueue.php' );
			$this->include_file( 'core/class-kr-hooks.php' );
			
			// Customizer
			$this->include_file( 'customizer/class-kr-customizer.php' );
			
			// Compatibility layers
			$this->include_file( 'compatibility/class-kr-elementor.php' );
			$this->include_file( 'compatibility/class-kr-woocommerce.php' );
			$this->include_file( 'compatibility/class-kr-gutenberg.php' );
			
			// Markup and structure
			$this->include_file( 'markup/class-kr-header.php' );
			$this->include_file( 'markup/class-kr-footer.php' );
			$this->include_file( 'markup/class-kr-content.php' );

			// Admin (only in admin area)
			if ( is_admin() ) {
				$this->include_file( 'admin/class-kr-admin.php' );
			}

			// Load debug helper only when needed
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				$this->include_file( 'debug/class-kr-debug-helper.php' );
			}
		}

		/**
		 * Safe file include with error handling
		 *
		 * @param string $file_path Relative path from inc/ directory
		 * @return bool
		 */
		private function include_file( $file_path ) {
			$full_path = KR_THEME_INC_DIR . $file_path;
			
			if ( ! file_exists( $full_path ) ) {
				if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
					error_log( "KR Theme: Missing file - {$file_path}" );
				}
				return false;
			}

			try {
				require_once $full_path;
				return true;
			} catch ( Exception $e ) {
				if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
					error_log( "KR Theme: Error loading {$file_path}: " . $e->getMessage() );
				}
				return false;
			}
		}

		/**
		 * Initialize Hooks
		 */
		private function init_hooks() {
			// Theme setup
			add_action( 'after_setup_theme', array( $this, 'setup_theme' ), 0 );
			
			// Enqueue scripts and styles
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 1 );
			
			// Customizer
			add_action( 'customize_register', array( $this, 'customize_register' ) );
			
			// Init theme components
			add_action( 'init', array( $this, 'init_components' ) );
		}

		/**
		 * Theme Setup
		 */
		public function setup_theme() {
			if ( class_exists( 'KR_Theme_Setup' ) ) {
				KR_Theme_Setup::instance();
			}
		}

		/**
		 * Enqueue Scripts and Styles
		 */
		public function enqueue_scripts() {
			if ( class_exists( 'KR_Enqueue' ) ) {
				KR_Enqueue::instance();
			}
		}

		/**
		 * Customizer Registration
		 */
		public function customize_register( $wp_customize ) {
			if ( class_exists( 'KR_Customizer' ) ) {
				KR_Customizer::instance()->register( $wp_customize );
			}
		}

		/**
		 * Initialize Theme Components
		 */
		public function init_components() {
			// Initialize compatibility layers
			if ( class_exists( 'KR_Elementor' ) ) {
				KR_Elementor::instance();
			}
			if ( class_exists( 'KR_WooCommerce' ) ) {
				KR_WooCommerce::instance();
			}
			if ( class_exists( 'KR_Gutenberg' ) ) {
				KR_Gutenberg::instance();
			}

			// Initialize markup classes
			if ( class_exists( 'KR_Header' ) ) {
				KR_Header::instance();
			}
			if ( class_exists( 'KR_Footer' ) ) {
				KR_Footer::instance();
			}
			if ( class_exists( 'KR_Content' ) ) {
				KR_Content::instance();
			}
		}

		/**
		 * Get theme version
		 *
		 * @return string
		 */
		public function get_version() {
			return KR_THEME_VERSION;
		}

		/**
		 * Check if theme component is active
		 *
		 * @param string $component Component name
		 * @return bool
		 */
		public function is_component_active( $component ) {
			$active_components = array(
				'elementor' => class_exists( 'Elementor\Plugin' ),
				'woocommerce' => class_exists( 'WooCommerce' ),
				'gutenberg' => function_exists( 'register_block_type' ),
			);

			return isset( $active_components[ $component ] ) ? $active_components[ $component ] : false;
		}

		/**
		 * Prevent cloning
		 */
		private function __clone() {}

		/**
		 * Prevent unserialization
		 */
		private function __wakeup() {}
	}
}

/**
 * Main function to get KR_Theme instance
 *
 * @return KR_Theme
 */
function KR_Theme() {
	return KR_Theme::instance();
}