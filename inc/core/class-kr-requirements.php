<?php
/**
 * KR Theme System Requirements Checker
 * 
 * Verifies that all required plugins and minimum version requirements are met
 * Displays admin notices if requirements are not satisfied
 *
 * @package KR_Theme
 * @since 1.3.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'KR_Requirements' ) ) {

	/**
	 * System Requirements Checker Class
	 */
	class KR_Requirements {

		/**
		 * Instance
		 *
		 * @var KR_Requirements
		 */
		private static $instance = null;

		/**
		 * Required plugins
		 *
		 * @var array
		 */
		private $required_plugins = array();

		/**
		 * Missing requirements
		 *
		 * @var array
		 */
		private $missing_requirements = array();

		/**
		 * Get Instance - Singleton Pattern
		 *
		 * @return KR_Requirements
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
			$this->init();
		}

		/**
		 * Initialize
		 */
		private function init() {
			// Check requirements
			$this->check_requirements();

			// Display admin notices
			if ( is_admin() ) {
				add_action( 'admin_notices', array( $this, 'display_admin_notices' ) );
			}

			// Check on theme activation
			add_action( 'after_switch_theme', array( $this, 'on_theme_activation' ) );
		}

		/**
		 * Check All Requirements
		 */
		public function check_requirements() {
			$this->missing_requirements = array();

			// Check PHP version
			$this->check_php_version();

			// Check WordPress version
			$this->check_wordpress_version();

			// Check required plugins
			$this->check_required_plugins();

			// Check plugin versions
			$this->check_plugin_versions();
		}

		/**
		 * Check PHP Version
		 * Minimum: 7.4
		 */
		private function check_php_version() {
			$required_version = '7.4';
			$current_version = phpversion();

			if ( version_compare( $current_version, $required_version, '<' ) ) {
				$this->missing_requirements['php'] = array(
					'name'     => 'PHP Version',
					'required' => $required_version,
					'current'  => $current_version,
					'type'     => 'error',
					'message'  => sprintf(
						/* translators: %1$s = required version, %2$s = current version */
						__( 'KR Theme requires PHP %1$s or higher. Your current version is %2$s.', 'kr-theme' ),
						$required_version,
						$current_version
					),
				);
			}
		}

		/**
		 * Check WordPress Version
		 * Minimum: 6.0
		 */
		private function check_wordpress_version() {
			$required_version = '6.0';
			$current_version = get_bloginfo( 'version' );

			if ( version_compare( $current_version, $required_version, '<' ) ) {
				$this->missing_requirements['wordpress'] = array(
					'name'     => 'WordPress Version',
					'required' => $required_version,
					'current'  => $current_version,
					'type'     => 'error',
					'message'  => sprintf(
						/* translators: %1$s = required version, %2$s = current version */
						__( 'KR Theme requires WordPress %1$s or higher. Your current version is %2$s.', 'kr-theme' ),
						$required_version,
						$current_version
					),
				);
			}
		}

		/**
		 * Check Required Plugins
		 */
		private function check_required_plugins() {
			// Required plugins list
			$required = array(
				'elementor'                                    => array(
					'name'     => 'Elementor Page Builder',
					'slug'     => 'elementor',
					'type'     => 'required',
					'min_version' => '3.16.0',
				),
				'essential-addons-for-elementor-lite/essential-addons-for-elementor-lite.php' => array(
					'name'     => 'Essential Addons for Elementor',
					'slug'     => 'essential-addons-for-elementor-lite',
					'type'     => 'required',
					'min_version' => '5.0',
				),
				'kr-toolkit/kr-toolkit.php'                    => array(
					'name'     => 'KR Toolkit',
					'slug'     => 'kr-toolkit',
					'type'     => 'required',
					'min_version' => '1.2.7',
				),
				'woocommerce/woocommerce.php'                  => array(
					'name'     => 'WooCommerce',
					'slug'     => 'woocommerce',
					'type'     => 'optional',
					'min_version' => '6.0',
				),
			);

			$this->required_plugins = $required;

			foreach ( $required as $plugin_file => $plugin_info ) {
				$is_active = is_plugin_active( $plugin_file );

				if ( 'required' === $plugin_info['type'] && ! $is_active ) {
					$this->missing_requirements[ $plugin_info['slug'] ] = array(
						'name'     => $plugin_info['name'],
						'slug'     => $plugin_info['slug'],
						'type'     => 'error',
						'message'  => sprintf(
							/* translators: %s = plugin name */
							__( 'KR Theme requires the "%s" plugin to be installed and activated.', 'kr-theme' ),
							$plugin_info['name']
						),
					);
				}
			}
		}

		/**
		 * Check Plugin Versions
		 */
		private function check_plugin_versions() {
			foreach ( $this->required_plugins as $plugin_file => $plugin_info ) {
				if ( ! is_plugin_active( $plugin_file ) ) {
					continue;
				}

				// Get plugin data
				$plugin_path = WP_PLUGIN_DIR . '/' . $plugin_file;
				
				// Check if plugin file exists
				if ( ! file_exists( $plugin_path ) ) {
					continue;
				}

				$plugin_data = get_plugin_data( $plugin_path );
				$current_version = isset( $plugin_data['Version'] ) ? trim( $plugin_data['Version'] ) : '0.0.0';
				$required_version = $plugin_info['min_version'];

				// Only show warning if current version is LESS than required version
				if ( version_compare( $current_version, $required_version, '<' ) ) {
					$this->missing_requirements[ $plugin_info['slug'] . '_version' ] = array(
						'name'     => $plugin_info['name'],
						'required' => $required_version,
						'current'  => $current_version,
						'type'     => 'warning',
						'message'  => sprintf(
							/* translators: %1$s = plugin name, %2$s = required version, %3$s = current version */
							__( '%1$s version %2$s or higher is recommended. You have version %3$s installed.', 'kr-theme' ),
							$plugin_info['name'],
							$required_version,
							$current_version
						),
					);
				}
			}
		}

		/**
		 * Display Admin Notices
		 */
		public function display_admin_notices() {
			if ( empty( $this->missing_requirements ) ) {
				return;
			}

			$current_theme = wp_get_theme();
			if ( 'KR Theme' !== $current_theme->get( 'Name' ) ) {
				return;
			}

			foreach ( $this->missing_requirements as $requirement ) {
				$class = 'error' === $requirement['type'] ? 'notice notice-error' : 'notice notice-warning';
				?>
				<div class="<?php echo esc_attr( $class ); ?> is-dismissible">
					<p>
						<strong><?php esc_html_e( 'KR Theme:', 'kr-theme' ); ?></strong><br>
						<?php echo wp_kses_post( $requirement['message'] ); ?>
					</p>
				</div>
				<?php
			}
		}

		/**
		 * On Theme Activation
		 */
		public function on_theme_activation() {
			// Refresh requirements check
			$this->check_requirements();

			// Log activation
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				error_log( 'KR Theme activated. Missing requirements: ' . count( $this->missing_requirements ) );
			}
		}

		/**
		 * Get Missing Requirements
		 *
		 * @return array
		 */
		public function get_missing_requirements() {
			return $this->missing_requirements;
		}

		/**
		 * Get All Requirements Status
		 *
		 * @return array
		 */
		public function get_requirements_status() {
			return array(
				'php'        => array(
					'name'     => 'PHP Version',
					'required' => '7.4',
					'current'  => phpversion(),
					'status'   => version_compare( phpversion(), '7.4', '>=' ) ? 'pass' : 'fail',
				),
				'wordpress'  => array(
					'name'     => 'WordPress Version',
					'required' => '6.0',
					'current'  => get_bloginfo( 'version' ),
					'status'   => version_compare( get_bloginfo( 'version' ), '6.0', '>=' ) ? 'pass' : 'fail',
				),
				'elementor'  => array(
					'name'     => 'Elementor Page Builder',
					'required' => true,
					'status'   => is_plugin_active( 'elementor/elementor.php' ) ? 'pass' : 'fail',
				),
				'essential-addons' => array(
					'name'     => 'Essential Addons for Elementor',
					'required' => true,
					'status'   => is_plugin_active( 'essential-addons-for-elementor-lite/essential-addons-for-elementor-lite.php' ) ? 'pass' : 'fail',
				),
				'kr-toolkit' => array(
					'name'     => 'KR Toolkit Plugin',
					'required' => true,
					'status'   => is_plugin_active( 'kr-toolkit/kr-toolkit.php' ) ? 'pass' : 'fail',
				),
				'woocommerce' => array(
					'name'     => 'WooCommerce',
					'required' => false,
					'status'   => is_plugin_active( 'woocommerce/woocommerce.php' ) ? 'pass' : 'optional',
				),
			);
		}

		/**
		 * Check if all requirements are met
		 *
		 * @return bool
		 */
		public function is_requirements_met() {
			return empty( $this->missing_requirements );
		}
	}

	// Initialize on WordPress init
	add_action( 'wp_loaded', function() {
		KR_Requirements::instance();
	} );
}
