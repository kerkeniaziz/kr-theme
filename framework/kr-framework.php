<?php
/**
 * KR Theme Framework
 * 
 * @package    KR_Theme
 * @version    1.0.0
 * @author     Administrator
 * @copyright  Copyright 2025, KR Theme
 */

if ( ! function_exists( 'kr_theme_framework' ) ) {
    /**
     * Load KR Theme Framework
     */
    function kr_theme_framework() {
        // Load include libraries: theme_setup, theme_options,...
        if ( file_exists( get_template_directory() . '/framework/includes/include_init.php' ) ) {
            require_once get_template_directory() . '/framework/includes/include_init.php';
        }

        // Load theme tax meta (taxonomy metabox)
        if ( true == kr_check_core_plugin_status() ) {
            require_once( get_template_directory() . '/framework/includes/plugin-functions.php' );
        }
    }

    kr_theme_framework();
}

/**
 * Check WooCommerce is active before use WooCommerce in theme
 */
function kr_check_woocommerce_status() {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

    if ( class_exists( 'WooCommerce' ) ) {
        return true;
    } else {
        return false;
    }
}

/**
 * Check KR Toolkit plugin load
 */
function kr_check_core_plugin_status() {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

    if ( class_exists( 'KR_Toolkit' ) ) {
        return true;
    } else {
        return false;
    }
}

/**
 * Check Custom Fonts plugin load
 */
function kr_check_custom_fonts_plugin_status() {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    
    if ( class_exists( 'Bsf_Custom_Fonts_Render' ) ) {
        return true;
    } else {
        return false;
    }
}

/**
 * Check WPC Product Options plugin load
 */
function kr_check_wpc_product_options_plugin_status() {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    
    if ( class_exists( 'WPCleverWpcpo' ) ) {
        return true;
    } else {
        return false;
    }
}
