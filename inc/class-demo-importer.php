<?php
/**
 * KR Theme Demo Importer
 * Handles demo content import directly from theme options
 *
 * @package KR_Theme
 * @since 1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class KR_Theme_Demo_Importer {

	/**
	 * Available demos
	 *
	 * @var array
	 */
	private $demos = array();

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->load_demos();
		add_action( 'wp_ajax_kr_import_demo', array( $this, 'ajax_import_demo' ) );
		add_action( 'wp_ajax_kr_get_import_status', array( $this, 'ajax_get_import_status' ) );
	}

	/**
	 * Load available demos from demos folder
	 */
	private function load_demos() {
		$demos_dir = get_template_directory() . '/demos';
		
		if ( ! is_dir( $demos_dir ) ) {
			return;
		}

		$demo_folders = scandir( $demos_dir );
		
		foreach ( $demo_folders as $demo_folder ) {
			if ( in_array( $demo_folder, array( '.', '..' ) ) ) {
				continue;
			}

			$config_file = $demos_dir . '/' . $demo_folder . '/config.json';
			
			if ( file_exists( $config_file ) ) {
				$config = json_decode( file_get_contents( $config_file ), true );
				if ( $config ) {
					$this->demos[] = $config;
				}
			}
		}
	}

	/**
	 * Get available demos
	 *
	 * @return array
	 */
	public function get_available_demos() {
		return apply_filters( 'kr_theme_demos', $this->demos );
	}

	/**
	 * Get demo by slug
	 *
	 * @param string $slug Demo slug.
	 * @return array|false
	 */
	public function get_demo( $slug ) {
		foreach ( $this->demos as $demo ) {
			if ( $demo['slug'] === $slug ) {
				return $demo;
			}
		}
		return false;
	}

	/**
	 * Import demo via AJAX
	 */
	public function ajax_import_demo() {
		if ( ! wp_verify_nonce( $_POST['nonce'], 'kr_theme_nonce' ) || ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'Permission denied.', 'kr-theme' ) ) );
		}

		$demo_slug = isset( $_POST['demo_slug'] ) ? sanitize_text_field( wp_unslash( $_POST['demo_slug'] ) ) : '';

		if ( empty( $demo_slug ) ) {
			wp_send_json_error( array( 'message' => __( 'Invalid demo slug.', 'kr-theme' ) ) );
		}

		$result = $this->import_demo( $demo_slug );

		if ( is_wp_error( $result ) ) {
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
		}

		wp_send_json_success( array( 
			'message' => __( 'Demo imported successfully!', 'kr-theme' ),
			'demo' => $demo_slug
		) );
	}

	/**
	 * Get import status via AJAX
	 */
	public function ajax_get_import_status() {
		if ( ! wp_verify_nonce( $_POST['nonce'], 'kr_theme_nonce' ) || ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'Permission denied.', 'kr-theme' ) ) );
		}

		$demo_slug = isset( $_POST['demo_slug'] ) ? sanitize_text_field( wp_unslash( $_POST['demo_slug'] ) ) : '';
		$import_status = get_option( 'kr_theme_import_status_' . $demo_slug, array() );

		wp_send_json_success( $import_status );
	}

	/**
	 * Import demo content
	 *
	 * @param string $demo_slug Demo slug to import.
	 * @return bool|WP_Error
	 */
	public function import_demo( $demo_slug ) {
		$demo = $this->get_demo( $demo_slug );

		if ( ! $demo ) {
			return new WP_Error( 'invalid_demo', __( 'Invalid demo selected.', 'kr-theme' ) );
		}

		$demo_path = get_template_directory() . '/demos/' . $demo_slug . '/';

		if ( ! file_exists( $demo_path ) ) {
			return new WP_Error( 'demo_not_found', __( 'Demo files not found.', 'kr-theme' ) );
		}

		// Initialize import
		$import_status = array(
			'demo_slug' => $demo_slug,
			'status' => 'importing',
			'started' => current_time( 'mysql' ),
		);
		update_option( 'kr_theme_import_status_' . $demo_slug, $import_status );

		// Import content
		$this->import_content( $demo_path );

		// Import customizer settings
		$this->import_customizer( $demo_path );

		// Import theme options
		$this->import_theme_options( $demo_path );

		// Import widgets
		$this->import_widgets( $demo_path );

		// Mark as completed
		$import_status['status'] = 'completed';
		$import_status['completed'] = current_time( 'mysql' );
		update_option( 'kr_theme_import_status_' . $demo_slug, $import_status );

		// Save imported demo info
		$imported_demos = get_option( 'kr_theme_imported_demos', array() );
		$imported_demos[] = array(
			'slug'      => $demo_slug,
			'name'      => $demo['name'],
			'date'      => current_time( 'mysql' ),
			'timestamp' => time(),
		);
		update_option( 'kr_theme_imported_demos', $imported_demos );

		do_action( 'kr_theme_after_demo_import', $demo_slug );

		return true;
	}

	/**
	 * Import content (posts, pages, etc.)
	 *
	 * @param string $demo_path Path to demo files.
	 */
	private function import_content( $demo_path ) {
		$content_file = $demo_path . 'content.xml';

		if ( ! file_exists( $content_file ) ) {
			return;
		}

		// Use WordPress importer if available
		if ( ! class_exists( 'WP_Import' ) ) {
			$importer_path = ABSPATH . 'wp-admin/includes/import.php';
			if ( file_exists( $importer_path ) ) {
				require_once $importer_path;
			}
		}

		// Import content using WP_Import
		if ( class_exists( 'WP_Import' ) ) {
			$importer = new WP_Import();
			$importer->fetch_attachments = true;
			ob_start();
			$importer->import( $content_file );
			ob_end_clean();
		}
	}

	/**
	 * Import customizer settings
	 *
	 * @param string $demo_path Path to demo files.
	 */
	private function import_customizer( $demo_path ) {
		$customizer_file = $demo_path . 'customizer.json';

		if ( ! file_exists( $customizer_file ) ) {
			return;
		}

		$customizer_data = file_get_contents( $customizer_file );
		$settings = json_decode( $customizer_data, true );

		if ( ! empty( $settings ) && is_array( $settings ) ) {
			foreach ( $settings as $key => $value ) {
				set_theme_mod( $key, $value );
			}
		}
	}

	/**
	 * Import theme options
	 *
	 * @param string $demo_path Path to demo files.
	 */
	private function import_theme_options( $demo_path ) {
		$options_file = $demo_path . 'theme-options.json';

		if ( ! file_exists( $options_file ) ) {
			return;
		}

		$options_data = file_get_contents( $options_file );
		$options = json_decode( $options_data, true );

		if ( ! empty( $options ) && is_array( $options ) ) {
			update_option( 'kr_theme_options', $options );
		}
	}

	/**
	 * Import widgets
	 *
	 * @param string $demo_path Path to demo files.
	 */
	private function import_widgets( $demo_path ) {
		$widgets_file = $demo_path . 'widgets.json';

		if ( ! file_exists( $widgets_file ) ) {
			return;
		}

		$widgets_data = file_get_contents( $widgets_file );
		$widgets = json_decode( $widgets_data, true );

		if ( ! empty( $widgets ) && is_array( $widgets ) ) {
			update_option( 'sidebars_widgets', $widgets );
		}
	}

	/**
	 * Get imported demos
	 *
	 * @return array
	 */
	public function get_imported_demos() {
		return get_option( 'kr_theme_imported_demos', array() );
	}

	/**
	 * Check if demo is imported
	 *
	 * @param string $demo_slug Demo slug.
	 * @return bool
	 */
	public function is_demo_imported( $demo_slug ) {
		$imported = $this->get_imported_demos();
		foreach ( $imported as $demo ) {
			if ( $demo['slug'] === $demo_slug ) {
				return true;
			}
		}
		return false;
	}
}

// Initialize
if ( is_admin() ) {
	new KR_Theme_Demo_Importer();
}
