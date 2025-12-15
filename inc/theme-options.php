<?php
/**
 * KR Theme Options - Redux Framework Configuration
 * 
 * This file configures the Redux Framework theme options panel
 * allowing users to customize headers, footers, and other theme settings
 * 
 * @package KR_Theme
 * @since 1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Redux_Framework_KR_Theme_Options' ) ) {

	class Redux_Framework_KR_Theme_Options {

		public $args = array();
		public $sections = array();
		public $ReduxFramework;

		/**
		 * Constructor
		 */
		public function __construct() {
			if ( ! class_exists( 'ReduxFramework' ) ) {
				return;
			}

			$this->initSettings();
		}

		/**
		 * Initialize Settings
		 */
		public function initSettings() {
			// Set default arguments
			$this->setArguments();
			
			// Create sections and fields
			$this->setSections();

			if ( ! isset( $this->args['opt_name'] ) ) {
				return;
			}

			// Initialize Redux
			$this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
		}

		/**
		 * Set Redux Framework Arguments
		 */
		public function setArguments() {
			$this->args = array(
				'opt_name'                  => 'kr_theme_options',
				'display_name'              => 'KR Theme Options',
				'display_version'           => '1.4.0',
				'menu_type'                 => 'menu',
				'allow_admin_notes'         => false,
				'allow_tracking'            => false,
				'dev_mode'                  => false,
				'force_dev_mode'            => false,
				'update_notice'             => false,
				'customizer'                => false,
				'page_priority'             => 59,
				'page_parent'               => 'themes.php',
				'page_permissions'          => 'manage_options',
				'menu_icon'                 => 'dashicons-admin-appearance',
				'show_import_export'        => false,
				'show_options_object'       => false,
				'show_search'               => true,
				'transitionIn'              => 'fadeIn',
				'transitionInTime'          => 300,
				'transitionOut'             => 'fadeOut',
				'transitionOutTime'         => 300,
				'intro_text'                => '',
				'footer_text'               => '<p style="text-align: center;"><strong>KR Theme v1.4.0</strong> - Professional WordPress Theme for Modern Websites</p>',
				'footer_credit'             => '<p style="text-align: center;">Created by <a href="https://www.krtheme.com" target="_blank">KR Theme Team</a></p>',
				'capability'                => 'manage_options',
				'disable_save_warn'         => false,
				'ajax_save'                 => true,
				'use_cdn'                   => true,
				'admin_bar'                 => true,
				'admin_bar_icon'            => 'dashicons-admin-appearance',
				'admin_bar_priority'        => 100,
			);
		}

		/**
		 * Create Sections and Fields
		 */
		public function setSections() {
			// General Settings
			$this->sections[] = array(
				'title'      => esc_html__( 'General Settings', 'kr-theme' ),
				'desc'       => esc_html__( 'Welcome to KR Theme Options! Customize your site appearance, headers, footers, and more.', 'kr-theme' ),
				'icon'       => 'el el-cog',
				'icon_class' => 'el-cog',
				'fields'     => array(
					array(
						'id'       => 'kr_layout_style',
						'type'     => 'button_set',
						'title'    => esc_html__( 'Layout Style', 'kr-theme' ),
						'subtitle' => esc_html__( 'Choose your site layout', 'kr-theme' ),
						'options'  => array(
							'wide'  => esc_html__( 'Wide', 'kr-theme' ),
							'boxed' => esc_html__( 'Boxed', 'kr-theme' ),
						),
						'default'  => 'wide',
					),
					array(
						'id'       => 'kr_site_max_width',
						'type'     => 'slider',
						'title'    => esc_html__( 'Site Max Width (px)', 'kr-theme' ),
						'subtitle' => esc_html__( 'Set the maximum width of your site', 'kr-theme' ),
						'default'  => 1400,
						'min'      => 1000,
						'max'      => 1600,
						'step'     => 10,
						'required' => array( 'kr_layout_style', '=', 'boxed' ),
					),
				),
			);

			// Header Settings
			$this->sections[] = array(
				'title'      => esc_html__( 'Header', 'kr-theme' ),
				'desc'       => esc_html__( 'Configure your site header. Create and manage headers in KR Toolkit > Header Builder.', 'kr-theme' ),
				'icon'       => 'el el-arrow-up',
				'icon_class' => 'el-arrow-up',
				'fields'     => array(
					array(
						'id'       => 'kr_header',
						'type'     => 'header',
						'title'    => esc_html__( 'Header Builder', 'kr-theme' ),
						'subtitle' => esc_html__( 'Select a header or create a new one in KR Toolkit', 'kr-theme' ),
						'desc'     => esc_html__( 'Create headers with Elementor and select them here. You can override this per page.', 'kr-theme' ),
					),
					array(
						'id'       => 'kr_header_transparent',
						'type'     => 'switch',
						'title'    => esc_html__( 'Header Transparent', 'kr-theme' ),
						'subtitle' => esc_html__( 'Make the header background transparent', 'kr-theme' ),
						'default'  => 0,
					),
					array(
						'id'       => 'kr_header_transparent_skin',
						'type'     => 'button_set',
						'title'    => esc_html__( 'Transparent Header Skin', 'kr-theme' ),
						'options'  => array(
							'light' => esc_html__( 'Light', 'kr-theme' ),
							'dark'  => esc_html__( 'Dark', 'kr-theme' ),
						),
						'default'  => 'light',
						'required' => array( 'kr_header_transparent', '=', array( '1' ) ),
					),
					array(
						'id'       => 'kr_header_sticky',
						'type'     => 'switch',
						'title'    => esc_html__( 'Sticky Header', 'kr-theme' ),
						'subtitle' => esc_html__( 'Make header sticky when scrolling', 'kr-theme' ),
						'default'  => 1,
					),
					array(
						'id'       => 'kr_header_sticky_element',
						'type'     => 'button_set',
						'title'    => esc_html__( 'Sticky Element', 'kr-theme' ),
						'subtitle' => esc_html__( 'Choose which part of header sticks when scrolling', 'kr-theme' ),
						'options'  => array(
							'header' => esc_html__( 'Full Header', 'kr-theme' ),
							'menu'   => esc_html__( 'Menu Only', 'kr-theme' ),
						),
						'default'  => 'header',
						'required' => array( 'kr_header_sticky', '=', array( '1' ) ),
					),
				),
			);

			// Footer Settings
			$this->sections[] = array(
				'title'      => esc_html__( 'Footer', 'kr-theme' ),
				'desc'       => esc_html__( 'Configure your site footer. Create and manage footers in KR Toolkit > Footer Builder.', 'kr-theme' ),
				'icon'       => 'el el-arrow-down',
				'icon_class' => 'el-arrow-down',
				'fields'     => array(
					array(
						'id'       => 'kr_footer',
						'type'     => 'footer',
						'title'    => esc_html__( 'Footer Builder', 'kr-theme' ),
						'subtitle' => esc_html__( 'Select a footer or create a new one in KR Toolkit', 'kr-theme' ),
						'desc'     => esc_html__( 'Create footers with Elementor and select them here. You can override this per page.', 'kr-theme' ),
					),
				),
			);

			// Logo & Favicon
			$this->sections[] = array(
				'title'      => esc_html__( 'Logo & Favicon', 'kr-theme' ),
				'desc'       => esc_html__( 'Upload your site logo and favicon', 'kr-theme' ),
				'icon'       => 'el el-picture',
				'icon_class' => 'el-picture',
				'fields'     => array(
					array(
						'id'       => 'kr_logo',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__( 'Site Logo', 'kr-theme' ),
						'subtitle' => esc_html__( 'Upload your site logo (recommended: 200px x 60px)', 'kr-theme' ),
						'desc'     => esc_html__( 'You can also manage logo in Header Builder', 'kr-theme' ),
					),
					array(
						'id'       => 'kr_logo_dark',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__( 'Logo - Dark Mode', 'kr-theme' ),
						'subtitle' => esc_html__( 'Upload logo for dark mode (if you have dark mode enabled)', 'kr-theme' ),
						'desc'     => '',
					),
					array(
						'id'       => 'kr_favicon',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__( 'Favicon', 'kr-theme' ),
						'subtitle' => esc_html__( 'Upload favicon (16x16 or 32x32 PNG/ICO)', 'kr-theme' ),
						'desc'     => '',
					),
				),
			);

			// Colors & Typography
			$this->sections[] = array(
				'title'      => esc_html__( 'Colors & Typography', 'kr-theme' ),
				'desc'       => esc_html__( 'Customize your site colors and fonts', 'kr-theme' ),
				'icon'       => 'el el-brush',
				'icon_class' => 'el-brush',
				'fields'     => array(
					array(
						'id'       => 'kr_primary_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Primary Color', 'kr-theme' ),
						'subtitle' => esc_html__( 'Main brand color for buttons, links, etc.', 'kr-theme' ),
						'default'  => '#2563eb',
						'output'   => array(
							'color'            => '.kr-primary-text',
							'border-color'     => '.kr-primary-border',
							'background-color' => '.kr-primary-bg',
						),
					),
					array(
						'id'       => 'kr_secondary_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Secondary Color', 'kr-theme' ),
						'subtitle' => esc_html__( 'Accent color for highlights', 'kr-theme' ),
						'default'  => '#9333ea',
						'output'   => array(
							'color'            => '.kr-secondary-text',
							'border-color'     => '.kr-secondary-border',
							'background-color' => '.kr-secondary-bg',
						),
					),
					array(
						'id'       => 'kr_body_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Text Color', 'kr-theme' ),
						'subtitle' => esc_html__( 'Main text color for content', 'kr-theme' ),
						'default'  => '#1e293b',
						'output'   => array(
							'color' => 'body',
						),
					),
				),
			);
		}
	}

	// Initialize Redux
	new Redux_Framework_KR_Theme_Options();
}
