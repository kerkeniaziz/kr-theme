<?php
/**
 * KR Theme Functions
 * 
 * Main entry point - loads the core theme class
 *
 * @package KR_Theme
 * @author Aziz Kerkeni
 * @link https://www.kerkeniaziz.ovh/
 * @since 1.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load Main Theme Class
 */
require_once get_template_directory() . '/inc/class-kr-theme.php';

/**
 * Initialize Theme - Following Astra's singleton pattern
 */
function kr_theme_init() {
	return KR_Theme::instance();
}

/**
 * Start the theme after WordPress loads
 */
add_action( 'after_setup_theme', 'kr_theme_init', -1 );

/**
 * Global function to access theme instance
 * Usage: kr_theme()->method_name()
 */
function kr_theme() {
	return KR_Theme();
}
