<?php
/**
 * KR Theme - TGMPA Register
 * 
 * This file registers required plugins for the theme.
 * Plugins are automatically installed and activated upon theme activation.
 * 
 * @package KR_Theme
 */

/**
 * Include the TGM_Plugin_Activation class
 */
if ( ! class_exists( 'TGM_Plugin_Activation' ) ) {
	require_once get_template_directory() . '/plugins/class-tgm-plugin-activation.php';
}

if ( ! function_exists( 'kr_register_required_plugins' ) ) {
	function kr_register_required_plugins() {
		/*
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(
			// KR Toolkit - Bundled with theme
			array(
				'name'               => esc_html__( 'KR Toolkit', 'kr-theme' ),
				'slug'               => 'kr-toolkit',
				'source'             => get_template_directory() . '/plugins/kr-toolkit.zip',
				'required'           => true,
				'force_activation'   => true,
				'force_deactivation' => false,
				'version'            => '1.4.0',
			),

			// Redux Framework - WordPress.org
			array(
				'name'               => esc_html__( 'Redux Framework', 'kr-theme' ),
				'slug'               => 'redux-framework',
				'required'           => true,
				'force_activation'   => true,
			),

			// Elementor - WordPress.org
			array(
				'name'               => esc_html__( 'Elementor', 'kr-theme' ),
				'slug'               => 'elementor',
				'required'           => true,
				'force_activation'   => true,
			),

			// WooCommerce - WordPress.org (Optional)
			array(
				'name'     => esc_html__( 'WooCommerce', 'kr-theme' ),
				'slug'     => 'woocommerce',
				'required' => false,
			),

			// Contact Form 7 - WordPress.org (Optional)
			array(
				'name'     => esc_html__( 'Contact Form 7', 'kr-theme' ),
				'slug'     => 'contact-form-7',
				'required' => false,
			),
		);

		/*
		 * Array of configuration settings
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
			'is_automatic' => true, // Automatically activate plugins after installation
			'message'      => '',
		);

		tgmpa( $plugins, $config );
	}

	add_action( 'tgmpa_register', 'kr_register_required_plugins' );
}
