<?php
/**
 * KR Theme Redux Framework
 * 
 * @package    KR_Theme
 * @version    1.0.0
 * @author     KR Theme
 * @copyright  Copyright 2025, KR Theme
*/

// Load the embedded Redux Framework - use this to override redux core
if ( file_exists( WP_PLUGIN_DIR . '/redux-framework/ReduxCore/framework.php') ) {
    require_once WP_PLUGIN_DIR . '/redux-framework/ReduxCore/framework.php';
}

// Use this to load extensions for Redux as custom fields,...
if ( true == kr_check_core_plugin_status() ) {
	if ( file_exists( WP_PLUGIN_DIR . '/kr-toolkit/core/redux-extensions/loader.php') ) {
	    require_once WP_PLUGIN_DIR . '/kr-toolkit/core/redux-extensions/loader.php';
	}
}

if ( ! class_exists( 'KRReduxFramework' ) && class_exists( 'ReduxFramework' ) ) { // Fixed for bug if not install redux framework
    class KRReduxFramework extends ReduxFramework {
        // We can override ReduxFramework here
    }

    do_action( 'redux/init', KRReduxFramework::init() );
}
