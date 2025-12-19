<?php
/**
 * KR Theme - TGMPA Register
 * 
 * @package KR_Theme
 */

if ( ! function_exists( 'kr_register_required_plugins' ) ) {
	function kr_register_required_plugins() {
		$plugins = array(
			array(
				'name'     => 'Redux Framework',
				'slug'     => 'redux-framework',
				'required' => true,
			),
			array(
				'name'     => 'KR Toolkit',
				'slug'     => 'kr-toolkit',
				'required' => true,
			),
			array(
				'name'     => 'Elementor',
				'slug'     => 'elementor',
				'required' => false,
			),
			array(
				'name'     => 'WooCommerce',
				'slug'     => 'woocommerce',
				'required' => false,
			),
		);

		$config = array(
			'id'           => 'kr-theme',
			'default_path' => '',
			'menu'         => 'install-required-plugins',
			'has_notices'  => true,
			'dismissable'  => true,
			'dismiss_msg'  => '',
			'is_automatic' => false,
			'message'      => '',
		);

		tgmpa( $plugins, $config );
	}

	add_action( 'tgmpa_register', 'kr_register_required_plugins' );
}
