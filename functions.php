<?php
/**
 * KR Theme Functions
 * 
 * Main entry point - loads the KR Theme Framework
 *
 * @package KR_Theme
 * @author KR Theme
 * @link https://www.krtheme.com
 * @since 1.4.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load the KR theme framework, all functions for theme will be in includes folder in framework folder
require get_template_directory() . '/framework/kr-framework.php';

// Remove plugin flag from redux. Get rid of redirect
if ( ! function_exists( 'kr_remove_as_plugin_flag' ) ) {
	function kr_remove_as_plugin_flag() {
		ReduxFramework::$_as_plugin = false;
	}

	add_action( 'redux/construct', 'kr_remove_as_plugin_flag' );
}

if ( ! function_exists( 'kr_add_theme_support' ) ) {
	function kr_add_theme_support() {
		add_theme_support( 'html5', array( 'script', 'style' ) );
	}

	add_action( 'after_setup_theme', 'kr_add_theme_support' );
}

