<?php
/**
 * Plugin Installation and Activation
 * 
 * This file handles automatic plugin installation prompts for KR Theme.
 * It uses TGM Plugin Activation to recommend and install required plugins.
 *
 * @package KR_Theme
 * @author KR Theme
 * @link https://krtheme.com
 * @since 4.2.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once KR_THEME_DIR . '/inc/libraries/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'kr_theme_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function kr_theme_register_required_plugins() {
	
	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// KR Toolkit - Required for header/footer builder and demos
		// Install from GitHub releases
		array(
			'name'               => 'KR Toolkit - Header/Footer Builder & Demos',
			'slug'               => 'kr-toolkit',
			'source'             => 'https://github.com/kerkeniaziz/kr-toolkit/releases/latest/download/kr-toolkit.zip',
			'required'           => true,
			'version'            => '1.2.7',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => 'https://github.com/kerkeniaziz/kr-toolkit',
		),

		// Elementor - Required page builder
		// Status: CRITICAL - Core functionality depends on Elementor
		array(
			'name'     => 'Elementor Page Builder - REQUIRED',
			'slug'     => 'elementor',
			'required' => true,
			'version'  => '3.16.0',
		),

		// Essential Addons for Elementor - 60+ Free Widgets
		// Status: CRITICAL - Provides extended widgets needed by theme
		array(
			'name'     => 'Essential Addons for Elementor - REQUIRED',
			'slug'     => 'essential-addons-for-elementor-lite',
			'required' => true,
		),

		// WooCommerce - Optional for e-commerce sites
		// Status: OPTIONAL - Only needed if selling products
		array(
			'name'     => 'WooCommerce - OPTIONAL (for e-commerce)',
			'slug'     => 'woocommerce',
			'required' => false,
		),

		// Contact Form 7 - Optional for contact forms
		array(
			'name'     => 'Contact Form 7 - OPTIONAL (for contact forms)',
			'slug'     => 'contact-form-7',
			'required' => false,
		),

	);

	/**
	 * Array of configuration settings.
	 */
	$config = array(
		'id'           => 'kr-theme',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => __( 'KR Theme requires some plugins to be installed and activated for full functionality. Below is a list of required and recommended plugins.', 'kr-theme' ),
		'strings'      => array(
			'page_title'                      => __( 'KR Theme - Install Required Plugins', 'kr-theme' ),
			'menu_title'                      => __( '⚠️ Install Required Plugins', 'kr-theme' ),
			'installing'                      => __( 'Installing Plugin: %s', 'kr-theme' ),
			'updating'                        => __( 'Updating Plugin: %s', 'kr-theme' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'kr-theme' ),
			'notice_can_install_required'     => _n_noop(
				'<strong>KR Theme Notice:</strong> The following plugin is REQUIRED for KR Theme to work properly: %1$s. <a href="%2$s" class="button button-primary">Install Now</a>',
				'<strong>KR Theme Notice:</strong> The following plugins are REQUIRED for KR Theme to work properly: %1$s. <a href="%2$s" class="button button-primary">Install Now</a>',
				'kr-theme'
			),
			'notice_can_install_recommended'  => _n_noop(
				'<strong>KR Theme Notice:</strong> The following plugin is recommended: %1$s. <a href="%2$s" class="button button-primary">Install Now</a>',
				'<strong>KR Theme Notice:</strong> The following plugins are recommended: %1$s. <a href="%2$s" class="button button-primary">Install Now</a>',
				'kr-theme'
			),
			'notice_ask_to_update'            => _n_noop(
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with KR Theme: %1$s.',
				'The following plugins need to be updated to their latest versions to ensure maximum compatibility with KR Theme: %1$s.',
				'kr-theme'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'kr-theme'
			),
			'notice_can_activate_required'    => _n_noop(
				'<strong>KR Theme Notice:</strong> The following required plugin is currently inactive: %1$s. <a href="%2$s" class="button button-primary">Activate Now</a>',
				'<strong>KR Theme Notice:</strong> The following required plugins are currently inactive: %1$s. <a href="%2$s" class="button button-primary">Activate Now</a>',
				'kr-theme'
			),
			'notice_can_activate_recommended' => _n_noop(
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'kr-theme'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'kr-theme'
			),
			'update_link'                     => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'kr-theme'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'kr-theme'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'kr-theme' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'kr-theme' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'kr-theme' ),
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'kr-theme' ),
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for KR Theme. Please update the plugin.', 'kr-theme' ),
			'complete'                        => __( '✓ All required plugins installed and activated successfully. Your KR Theme is now ready! %1$s', 'kr-theme' ),
			'dismiss'                         => __( 'Dismiss this notice', 'kr-theme' ),
			'notice_cannot_install_activate'  => __( '<strong>Important:</strong> There are one or more required plugins to install and activate. KR Theme cannot function properly without them.', 'kr-theme' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'kr-theme' ),
			'nag_type'                        => 'updated',
		),
	);

	tgmpa( $plugins, $config );
}
