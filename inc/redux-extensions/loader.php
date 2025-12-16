<?php
/**
 * Load Redux Framework Custom Extensions
 * 
 * Loads custom field extensions for Header and Footer
 * 
 * @package KR_Theme
 * @since 1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Only load custom Redux extensions if Redux Framework is active
if ( class_exists( 'ReduxFramework' ) ) {
	// Load Header Extension
	if ( file_exists( dirname( __FILE__ ) . '/extensions/header/extension_header.php' ) ) {
		require_once dirname( __FILE__ ) . '/extensions/header/extension_header.php';
	}

	// Load Footer Extension
	if ( file_exists( dirname( __FILE__ ) . '/extensions/footer/extension_footer.php' ) ) {
		require_once dirname( __FILE__ ) . '/extensions/footer/extension_footer.php';
	}
}
