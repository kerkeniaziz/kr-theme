<?php
/**
 * KR Theme Functions
 *
 * @package KR_Theme
 * @author Aziz Kerkeni
 * @link https://www.kerkeniaziz.ovh/
 * @since 4.2.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme version and constants
 */
define( 'KR_THEME_VERSION', '4.2.1' );
define( 'KR_THEME_DIR', get_template_directory() );
define( 'KR_THEME_URI', get_template_directory_uri() );

/**
 * Load theme setup and configuration
 */
require_once KR_THEME_DIR . '/inc/theme-setup.php';

/**
 * Load enqueue functions
 */
require_once KR_THEME_DIR . '/inc/enqueue.php';

/**
 * Load custom hooks
 */
require_once KR_THEME_DIR . '/inc/hooks.php';

/**
 * Load markup functions
 */
require_once KR_THEME_DIR . '/inc/markup.php';

/**
 * Load customizer
 */
require_once KR_THEME_DIR . '/inc/customizer/customizer.php';

/**
 * Load structure functions
 */
require_once KR_THEME_DIR . '/inc/structure/header.php';
require_once KR_THEME_DIR . '/inc/structure/footer.php';
require_once KR_THEME_DIR . '/inc/structure/sidebar.php';
require_once KR_THEME_DIR . '/inc/structure/post.php';
require_once KR_THEME_DIR . '/inc/structure/archive.php';

/**
 * Load compatibility files
 */
require_once KR_THEME_DIR . '/inc/compatibility/elementor.php';
require_once KR_THEME_DIR . '/inc/compatibility/woocommerce.php';
require_once KR_THEME_DIR . '/inc/compatibility/gutenberg.php';
