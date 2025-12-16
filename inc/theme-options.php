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
				'menu_type'                 => 'submenu',
				'allow_admin_notes'         => false,
				'allow_tracking'            => false,
				'dev_mode'                  => false,
				'force_dev_mode'            => false,
				'update_notice'             => false,
				'customizer'                => false,
				'page_priority'             => 59,
				'page_parent'               => 'kr-toolkit-dashboard',
				'page_permissions'          => 'manage_options',
				'menu_icon'                 => 'dashicons-admin-appearance',
				'show_import_export'        => true,
				'show_options_object'       => false,
				'show_search'               => true,
				'transitionIn'              => 'fadeIn',
				'transitionInTime'          => 300,
				'transitionOut'             => 'fadeOut',
				'transitionOutTime'         => 300,
				'intro_text'                => '<p>' . esc_html__( 'Welcome to KR Theme Options! Customize your site appearance, headers, footers, and more. Please note some settings here can be overridden by settings in the Page Metabox of each page.', 'kr-theme' ) . '</p>',
				'footer_text'               => '<p style="text-align: center;"><strong>KR Theme v1.4.0</strong> - Professional WordPress Theme for Modern Websites</p>',
				'footer_credit'             => '<p style="text-align: center;">Created by <a href="https://www.krtheme.com" target="_blank">KR Theme</a></p>',
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
		 * Create Sections and Fields - Matching Pricom Theme Structure
		 */
		public function setSections() {

			// ==================== GENERAL SETTINGS ====================
			$this->sections[] = array(
				'title'  => esc_html__( 'General Settings', 'kr-theme' ),
				'desc'   => esc_html__( 'Welcome to KR Theme! Customize layout, preloader, back-to-top, and more.', 'kr-theme' ),
				'icon'   => 'el el-cog',
				'fields' => array(

					// Layout Style
					array(
						'id'       => 'kr_layout_style',
						'type'     => 'image_select',
						'title'    => esc_html__( 'Layout Style', 'kr-theme' ),
						'subtitle' => esc_html__( 'Choose your site layout style', 'kr-theme' ),
						'desc'     => esc_html__( 'Select between Wide, Boxed, or Float layout', 'kr-theme' ),
						'options'  => array(
							'wide'  => array(
								'alt'   => esc_html__( 'Wide', 'kr-theme' ),
								'title' => esc_html__( 'Wide', 'kr-theme' ),
								'img'   => get_template_directory_uri() . '/assets/images/layout-wide.png'
							),
							'boxed' => array(
								'alt'   => esc_html__( 'Boxed', 'kr-theme' ),
								'title' => esc_html__( 'Boxed', 'kr-theme' ),
								'img'   => get_template_directory_uri() . '/assets/images/layout-boxed.png'
							),
							'float' => array(
								'alt'   => esc_html__( 'Float', 'kr-theme' ),
								'title' => esc_html__( 'Float', 'kr-theme' ),
								'img'   => get_template_directory_uri() . '/assets/images/layout-float.png'
							)
						),
						'default'  => 'wide'
					),

					// Site Max Width
					array(
						'id'       => 'kr_layout_site_max_width',
						'type'     => 'slider',
						'title'    => esc_html__( 'Site Max Width (px)', 'kr-theme' ),
						'subtitle' => esc_html__( 'Set the site max width of body', 'kr-theme' ),
						'default'  => 1400,
						'min'      => 1000,
						'max'      => 2000,
						'step'     => 10,
						'required' => array( 'kr_layout_style', '=', 'boxed' ),
					),

					// Body Background Mode
					array(
						'id'       => 'kr_body_background_mode',
						'type'     => 'button_set',
						'title'    => esc_html__( 'Body Background Mode', 'kr-theme' ),
						'subtitle' => esc_html__( 'Choose Background Mode', 'kr-theme' ),
						'options'  => array(
							'color'   => esc_html__( 'Color', 'kr-theme' ),
							'image'   => esc_html__( 'Image', 'kr-theme' ),
							'pattern' => esc_html__( 'Pattern', 'kr-theme' ),
						),
						'default'  => 'color',
						'required' => array( 'kr_layout_style', '=', 'boxed' ),
					),

					// Body Background Color
					array(
						'id'       => 'kr_body_background',
						'type'     => 'background',
						'title'    => esc_html__( 'Body Background', 'kr-theme' ),
						'subtitle' => esc_html__( 'Body background (Use only for Boxed layout style)', 'kr-theme' ),
						'desc'     => esc_html__( 'Select color or upload background image', 'kr-theme' ),
						'default'  => array(
							'background-color' => '#ffffff',
						),
						'required' => array( 'kr_layout_style', '=', 'boxed' ),
					),

					// Body Background Pattern
					array(
						'id'       => 'kr_body_background_pattern',
						'type'     => 'image_select',
						'title'    => esc_html__( 'Background Pattern', 'kr-theme' ),
						'subtitle' => esc_html__( 'Body background pattern (Use only for Boxed layout style)', 'kr-theme' ),
						'options'  => array(
							'pattern1' => array(
								'alt'   => esc_html__( 'Pattern 1', 'kr-theme' ),
								'title' => esc_html__( 'Pattern 1', 'kr-theme' ),
								'img'   => get_template_directory_uri() . '/assets/images/pattern1.png'
							),
							'pattern2' => array(
								'alt'   => esc_html__( 'Pattern 2', 'kr-theme' ),
								'title' => esc_html__( 'Pattern 2', 'kr-theme' ),
								'img'   => get_template_directory_uri() . '/assets/images/pattern2.png'
							),
						),
						'required' => array( array( 'kr_layout_style', '=', 'boxed' ), array( 'kr_body_background_mode', '=', 'pattern' ) ),
					),

					// Page Preloader
					array(
						'id'       => 'kr_home_preloader',
						'type'     => 'select',
						'title'    => esc_html__( 'Page Preloader', 'kr-theme' ),
						'subtitle' => esc_html__( 'Select a preloader style or leave empty if you don\'t want to use this', 'kr-theme' ),
						'options'  => array(
							''          => esc_html__( 'None', 'kr-theme' ),
							'spinner1'  => esc_html__( 'Spinner 1', 'kr-theme' ),
							'spinner2'  => esc_html__( 'Spinner 2', 'kr-theme' ),
							'spinner3'  => esc_html__( 'Spinner 3', 'kr-theme' ),
							'pulse'     => esc_html__( 'Pulse', 'kr-theme' ),
						),
						'default'  => '',
					),

					// Preloader Background Color
					array(
						'id'       => 'kr_home_preloader_bg_color',
						'type'     => 'color_rgba',
						'title'    => esc_html__( 'Preloader Background Color', 'kr-theme' ),
						'subtitle' => esc_html__( 'Set the preloader background color with transparency', 'kr-theme' ),
						'default'  => array(
							'color' => '#ffffff',
							'alpha' => 0.95,
						),
						'required' => array( 'kr_home_preloader', '!=', '' ),
					),

					// Preloader Spinner Color
					array(
						'id'       => 'kr_home_preloader_spinner_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Preloader Spinner Color', 'kr-theme' ),
						'subtitle' => esc_html__( 'Color of the preloader spinner', 'kr-theme' ),
						'default'  => '#2563eb',
						'required' => array( 'kr_home_preloader', '!=', '' ),
					),

					// Back To Top
					array(
						'id'       => 'kr_back_to_top',
						'type'     => 'switch',
						'title'    => esc_html__( 'Back To Top Button', 'kr-theme' ),
						'subtitle' => esc_html__( 'Show a "Back to Top" button on scroll', 'kr-theme' ),
						'default'  => 1,
					),

					// Custom JS
					array(
						'id'       => 'kr_custom_js',
						'type'     => 'ace_editor',
						'title'    => esc_html__( 'Custom JS Code', 'kr-theme' ),
						'subtitle' => esc_html__( 'Insert your JavaScript code here. Do not place any &lt;script&gt; tags here!', 'kr-theme' ),
						'mode'     => 'javascript',
						'default'  => '',
					),
				),
			);

			// ==================== HEADER ====================
			$this->sections[] = array(
				'title'  => esc_html__( 'Header', 'kr-theme' ),
				'desc'   => esc_html__( 'Configure your site header settings. Create and manage headers in KR Toolkit > Header Builder.', 'kr-theme' ),
				'icon'   => 'el el-arrow-up',
				'fields' => array(

					// Header Builder
					array(
						'id'       => 'kr_header',
						'type'     => 'header',
						'title'    => esc_html__( 'Header Builder', 'kr-theme' ),
						'subtitle' => esc_html__( 'Select a header or create a new one in KR Toolkit', 'kr-theme' ),
						'desc'     => esc_html__( 'Create headers with Elementor and select them here. You can override this per page.', 'kr-theme' ),
					),

					// Header Transparent
					array(
						'id'       => 'kr_header_transparent',
						'type'     => 'switch',
						'title'    => esc_html__( 'Header Transparent', 'kr-theme' ),
						'subtitle' => esc_html__( 'Make the header background transparent', 'kr-theme' ),
						'default'  => 0,
					),

					// Header Transparent Skin
					array(
						'id'       => 'kr_header_transparent_skin',
						'type'     => 'button_set',
						'title'    => esc_html__( 'Header Transparent Skin', 'kr-theme' ),
						'subtitle' => esc_html__( 'Choose text color for transparent header', 'kr-theme' ),
						'options'  => array(
							'light' => esc_html__( 'Light', 'kr-theme' ),
							'dark'  => esc_html__( 'Dark', 'kr-theme' ),
						),
						'default'  => 'light',
						'required' => array( 'kr_header_transparent', '=', 1 ),
					),

					// Header Sticky
					array(
						'id'       => 'kr_header_sticky',
						'type'     => 'switch',
						'title'    => esc_html__( 'Sticky Header', 'kr-theme' ),
						'subtitle' => esc_html__( 'Make header sticky when scrolling', 'kr-theme' ),
						'default'  => 1,
					),

					// Header Sticky Element
					array(
						'id'       => 'kr_header_sticky_element',
						'type'     => 'button_set',
						'title'    => esc_html__( 'Sticky Header Element', 'kr-theme' ),
						'subtitle' => esc_html__( 'Choose which part of header sticks when scrolling', 'kr-theme' ),
						'options'  => array(
							'header' => esc_html__( 'Full Header', 'kr-theme' ),
							'menu'   => esc_html__( 'Menu Only', 'kr-theme' ),
						),
						'default'  => 'header',
						'required' => array( 'kr_header_sticky', '=', 1 ),
					),
				),
			);

			// ==================== FOOTER ====================
			$this->sections[] = array(
				'title'  => esc_html__( 'Footer', 'kr-theme' ),
				'desc'   => esc_html__( 'Configure your site footer settings. Create and manage footers in KR Toolkit > Footer Builder.', 'kr-theme' ),
				'icon'   => 'el el-arrow-down',
				'fields' => array(

					// Footer Builder
					array(
						'id'       => 'kr_footer',
						'type'     => 'footer',
						'title'    => esc_html__( 'Footer Builder', 'kr-theme' ),
						'subtitle' => esc_html__( 'Select a footer or create a new one in KR Toolkit', 'kr-theme' ),
						'desc'     => esc_html__( 'Create footers with Elementor and select them here. You can override this per page.', 'kr-theme' ),
					),
				),
			);

			// ==================== LOGO & FAVICON ====================
			$this->sections[] = array(
				'title'  => esc_html__( 'Logo & Favicon', 'kr-theme' ),
				'desc'   => esc_html__( 'Upload your site logo and favicon', 'kr-theme' ),
				'icon'   => 'el el-picture',
				'fields' => array(

					// Custom Logo
					array(
						'id'       => 'kr_custom_logo',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__( 'Custom Logo', 'kr-theme' ),
						'subtitle' => esc_html__( 'Upload your site logo (recommended: 200px x 60px)', 'kr-theme' ),
						'desc'     => esc_html__( 'You can also manage logo in Header Builder', 'kr-theme' ),
					),

					// Dark Mode Logo
					array(
						'id'       => 'kr_custom_logo_dark',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__( 'Logo - Dark Mode', 'kr-theme' ),
						'subtitle' => esc_html__( 'Upload logo for dark mode (if you have dark mode enabled)', 'kr-theme' ),
						'desc'     => '',
					),

					// Custom Favicon
					array(
						'id'       => 'kr_custom_favicon',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__( 'Custom Favicon', 'kr-theme' ),
						'subtitle' => esc_html__( 'Upload favicon (16x16 or 32x32 PNG/ICO)', 'kr-theme' ),
						'desc'     => esc_html__( 'Leave empty to use the default favicon', 'kr-theme' ),
					),
				),
			);

			// ==================== APPEARANCE ====================
			$this->sections[] = array(
				'title'  => esc_html__( 'Appearance', 'kr-theme' ),
				'desc'   => esc_html__( 'Customize the appearance and styling of your theme', 'kr-theme' ),
				'icon'   => 'el el-brush',
				'fields' => array(

					// SCSS Compiler
					array(
						'id'       => 'kr_scss_compiler',
						'type'     => 'switch',
						'title'    => esc_html__( 'SCSS Compiler', 'kr-theme' ),
						'subtitle' => esc_html__( 'Enable SCSS compiler to process custom styles', 'kr-theme' ),
						'desc'     => esc_html__( 'Make sure PHP settings meet theme requirements', 'kr-theme' ),
						'default'  => 0,
					),
				),
			);

			// ==================== COLOR SCHEME ====================
			$this->sections[] = array(
				'title'  => esc_html__( 'Color Scheme', 'kr-theme' ),
				'desc'   => esc_html__( 'Customize your site colors to match your brand', 'kr-theme' ),
				'icon'   => 'el el-invert',
				'fields' => array(

					// Light Mode Section
					array(
						'id'     => 'kr_section_color_light',
						'type'   => 'section',
						'title'  => esc_html__( 'Light Mode Colors', 'kr-theme' ),
						'indent' => true,
					),

					// Primary Color
					array(
						'id'       => 'kr_primary_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Primary Color', 'kr-theme' ),
						'subtitle' => esc_html__( 'Main brand color for buttons and links', 'kr-theme' ),
						'default'  => '#2563eb',
					),

					// Text Color
					array(
						'id'       => 'kr_text_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Text Color', 'kr-theme' ),
						'subtitle' => esc_html__( 'Main text color for content', 'kr-theme' ),
						'default'  => '#1f2937',
					),

					// Text Color Secondary
					array(
						'id'       => 'kr_text_color_secondary',
						'type'     => 'color',
						'title'    => esc_html__( 'Text Color Secondary', 'kr-theme' ),
						'subtitle' => esc_html__( 'Secondary text color for less important content', 'kr-theme' ),
						'default'  => '#6b7280',
					),

					// Text Color Tertiary
					array(
						'id'       => 'kr_text_color_tertiary',
						'type'     => 'color',
						'title'    => esc_html__( 'Text Color Tertiary', 'kr-theme' ),
						'subtitle' => esc_html__( 'Tertiary text color for borders and separators', 'kr-theme' ),
						'default'  => '#d1d5db',
					),

					// Heading Color
					array(
						'id'       => 'kr_heading_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Heading Color', 'kr-theme' ),
						'subtitle' => esc_html__( 'Color for all headings (H1-H6)', 'kr-theme' ),
						'default'  => '#111827',
					),

					// Link Color
					array(
						'id'       => 'kr_link_color',
						'type'     => 'link_color',
						'title'    => esc_html__( 'Link Colors', 'kr-theme' ),
						'subtitle' => esc_html__( 'Set colors for links (normal, hover, visited, active)', 'kr-theme' ),
						'default'  => array(
							'regular' => '#2563eb',
							'hover'   => '#1d4ed8',
							'visited' => '#7c3aed',
							'active'  => '#1d4ed8',
						),
					),

					// End light mode section
					array(
						'id'     => 'kr_section_color_light_end',
						'type'   => 'section',
						'indent' => false,
					),

					// Gradient Colors Section
					array(
						'id'     => 'kr_section_gradient_colors',
						'type'   => 'section',
						'title'  => esc_html__( 'Gradient Colors', 'kr-theme' ),
						'subtitle' => esc_html__( 'Use gradient colors for icon boxes, elements with background gradients, and special sections', 'kr-theme' ),
						'indent' => true,
					),

					// Gradient Color 1
					array(
						'id'       => 'kr_gradient_color_1',
						'type'     => 'color',
						'title'    => esc_html__( 'Gradient Color 1', 'kr-theme' ),
						'subtitle' => esc_html__( 'First color for gradient backgrounds', 'kr-theme' ),
						'default'  => '#ff869f',
					),

					// Gradient Color 2
					array(
						'id'       => 'kr_gradient_color_2',
						'type'     => 'color',
						'title'    => esc_html__( 'Gradient Color 2', 'kr-theme' ),
						'subtitle' => esc_html__( 'Second color for gradient backgrounds', 'kr-theme' ),
						'default'  => '#fa988a',
					),

					// Gradient Color 3
					array(
						'id'       => 'kr_gradient_color_3',
						'type'     => 'color',
						'title'    => esc_html__( 'Gradient Color 3', 'kr-theme' ),
						'subtitle' => esc_html__( 'Third color for gradient backgrounds', 'kr-theme' ),
						'default'  => '#f19a73',
					),

					// Gradient Color 4
					array(
						'id'       => 'kr_gradient_color_4',
						'type'     => 'color',
						'title'    => esc_html__( 'Gradient Color 4', 'kr-theme' ),
						'subtitle' => esc_html__( 'Fourth color for gradient backgrounds', 'kr-theme' ),
						'default'  => '#ffd0b1',
					),

					// Gradient Heading Color 1
					array(
						'id'       => 'kr_gradient_heading_color_1',
						'type'     => 'color',
						'title'    => esc_html__( 'Gradient Heading Color 1', 'kr-theme' ),
						'subtitle' => esc_html__( 'First color for heading gradients', 'kr-theme' ),
						'default'  => '#b1f1b3',
					),

					// Gradient Heading Color 2
					array(
						'id'       => 'kr_gradient_heading_color_2',
						'type'     => 'color',
						'title'    => esc_html__( 'Gradient Heading Color 2', 'kr-theme' ),
						'subtitle' => esc_html__( 'Second color for heading gradients', 'kr-theme' ),
						'default'  => '#f3eec2',
					),

					// End gradient section
					array(
						'id'     => 'kr_section_gradient_colors_end',
						'type'   => 'section',
						'indent' => false,
					),
				),
			);

			// ==================== TYPOGRAPHY ====================
			$this->sections[] = array(
				'title'  => esc_html__( 'Typography', 'kr-theme' ),
				'desc'   => esc_html__( 'Customize fonts and typography for your site', 'kr-theme' ),
				'icon'   => 'el el-font',
				'fields' => array(

					// Body Font
					array(
						'id'       => 'kr_body_font_family',
						'type'     => 'google_fonts',
						'title'    => esc_html__( 'Body Font Family', 'kr-theme' ),
						'subtitle' => esc_html__( 'Select the font for body text', 'kr-theme' ),
						'default'  => array(
							'font-family' => 'Inter',
							'font-weight' => '400',
						),
					),

					// Body Font Size
					array(
						'id'       => 'kr_body_font_size',
						'type'     => 'slider',
						'title'    => esc_html__( 'Body Font Size (px)', 'kr-theme' ),
						'subtitle' => esc_html__( 'Set the default font size for body text', 'kr-theme' ),
						'default'  => 16,
						'min'      => 12,
						'max'      => 24,
						'step'     => 1,
					),

					// Body Line Height
					array(
						'id'       => 'kr_body_line_height',
						'type'     => 'slider',
						'title'    => esc_html__( 'Body Line Height', 'kr-theme' ),
						'subtitle' => esc_html__( 'Set line height for body text (1.0-2.0)', 'kr-theme' ),
						'default'  => 1.6,
						'min'      => 1.0,
						'max'      => 2.0,
						'step'     => 0.1,
					),

					// Heading Font
					array(
						'id'       => 'kr_heading_font_family',
						'type'     => 'google_fonts',
						'title'    => esc_html__( 'Heading Font Family', 'kr-theme' ),
						'subtitle' => esc_html__( 'Select the font for headings', 'kr-theme' ),
						'default'  => array(
							'font-family' => 'Poppins',
							'font-weight' => '600',
						),
					),

					// Heading Line Height
					array(
						'id'       => 'kr_heading_line_height',
						'type'     => 'slider',
						'title'    => esc_html__( 'Heading Line Height', 'kr-theme' ),
						'subtitle' => esc_html__( 'Set line height for headings', 'kr-theme' ),
						'default'  => 1.2,
						'min'      => 1.0,
						'max'      => 1.8,
						'step'     => 0.1,
					),
				),
			);

			// ==================== WORDPRESS PARAMETERS ====================
			$this->sections[] = array(
				'title'  => esc_html__( 'WordPress Parameters', 'kr-theme' ),
				'desc'   => esc_html__( 'Configure WordPress-related settings for pages and posts', 'kr-theme' ),
				'icon'   => 'el el-website',
				'fields' => array(

					// Page Layout Section
					array(
						'id'     => 'kr_section_page_layout',
						'type'   => 'section',
						'title'  => esc_html__( 'Page Layout Settings', 'kr-theme' ),
						'indent' => true,
					),

					// Page Layout Style
					array(
						'id'       => 'kr_page_layout',
						'type'     => 'button_set',
						'title'    => esc_html__( 'Default Page Layout', 'kr-theme' ),
						'subtitle' => esc_html__( 'Choose default layout style for pages', 'kr-theme' ),
						'options'  => array(
							'full-width'  => esc_html__( 'Full Width', 'kr-theme' ),
							'container'   => esc_html__( 'Container', 'kr-theme' ),
							'large'       => esc_html__( 'Large Container', 'kr-theme' ),
						),
						'default'  => 'container',
					),

					// Page Sidebar
					array(
						'id'       => 'kr_page_sidebar',
						'type'     => 'image_select',
						'title'    => esc_html__( 'Default Page Sidebar', 'kr-theme' ),
						'subtitle' => esc_html__( 'Choose default sidebar layout for pages', 'kr-theme' ),
						'options'  => array(
							'none'  => array(
								'alt'   => esc_html__( 'None', 'kr-theme' ),
								'title' => esc_html__( 'No Sidebar', 'kr-theme' ),
								'img'   => get_template_directory_uri() . '/assets/images/sidebar-none.png'
							),
							'right' => array(
								'alt'   => esc_html__( 'Right', 'kr-theme' ),
								'title' => esc_html__( 'Right Sidebar', 'kr-theme' ),
								'img'   => get_template_directory_uri() . '/assets/images/sidebar-right.png'
							),
						),
						'default'  => 'none',
					),

					// End page layout section
					array(
						'id'     => 'kr_section_page_layout_end',
						'type'   => 'section',
						'indent' => false,
					),

					// Page Title Section
					array(
						'id'     => 'kr_section_page_title',
						'type'   => 'section',
						'title'  => esc_html__( 'Page Title Settings', 'kr-theme' ),
						'indent' => true,
					),

					// Show Page Title
					array(
						'id'       => 'kr_show_page_title',
						'type'     => 'switch',
						'title'    => esc_html__( 'Show Page Title', 'kr-theme' ),
						'subtitle' => esc_html__( 'Display page title section', 'kr-theme' ),
						'default'  => 1,
					),

					// Page Title Layout
					array(
						'id'       => 'kr_page_title_layout',
						'type'     => 'button_set',
						'title'    => esc_html__( 'Page Title Layout', 'kr-theme' ),
						'subtitle' => esc_html__( 'Choose page title container layout', 'kr-theme' ),
						'options'  => array(
							'full-width'  => esc_html__( 'Full Width', 'kr-theme' ),
							'container'   => esc_html__( 'Container', 'kr-theme' ),
							'large'       => esc_html__( 'Large Container', 'kr-theme' ),
						),
						'default'  => 'full-width',
						'required' => array( 'kr_show_page_title', '=', 1 ),
					),

					// Page Title Background
					array(
						'id'       => 'kr_page_title_bg_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Page Title Background Color', 'kr-theme' ),
						'subtitle' => esc_html__( 'Set background color for page title area', 'kr-theme' ),
						'default'  => '#f5f5f5',
						'required' => array( 'kr_show_page_title', '=', 1 ),
					),

					// End page title section
					array(
						'id'     => 'kr_section_page_title_end',
						'type'   => 'section',
						'indent' => false,
					),

					// Blog Settings Section
					array(
						'id'     => 'kr_section_blog_settings',
						'type'   => 'section',
						'title'  => esc_html__( 'Blog Settings', 'kr-theme' ),
						'indent' => true,
					),

					// Show Post Title
					array(
						'id'       => 'kr_show_post_title',
						'type'     => 'switch',
						'title'    => esc_html__( 'Show Blog Post Title', 'kr-theme' ),
						'subtitle' => esc_html__( 'Display blog post title section', 'kr-theme' ),
						'default'  => 1,
					),

					// Post Title Layout
					array(
						'id'       => 'kr_post_title_layout',
						'type'     => 'button_set',
						'title'    => esc_html__( 'Post Title Layout', 'kr-theme' ),
						'subtitle' => esc_html__( 'Choose post title container layout', 'kr-theme' ),
						'options'  => array(
							'full-width'  => esc_html__( 'Full Width', 'kr-theme' ),
							'container'   => esc_html__( 'Container', 'kr-theme' ),
							'large'       => esc_html__( 'Large Container', 'kr-theme' ),
						),
						'default'  => 'full-width',
						'required' => array( 'kr_show_post_title', '=', 1 ),
					),

					// Post Title Background Color
					array(
						'id'       => 'kr_post_title_bg_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Post Title Background Color', 'kr-theme' ),
						'subtitle' => esc_html__( 'Set background color for post title area', 'kr-theme' ),
						'default'  => '#f5f5f5',
						'required' => array( 'kr_show_post_title', '=', 1 ),
					),

					// End blog section
					array(
						'id'     => 'kr_section_blog_settings_end',
						'type'   => 'section',
						'indent' => false,
					),
				),
			);

			// ==================== WOOCOMMERCE ====================
			if ( class_exists( 'WooCommerce' ) ) {
				$this->sections[] = array(
					'title'  => esc_html__( 'WooCommerce', 'kr-theme' ),
					'desc'   => esc_html__( 'Configure WooCommerce product and shop settings', 'kr-theme' ),
					'icon'   => 'el el-shopping-cart-sign',
					'fields' => array(

						// Sale Badge Mode
						array(
							'id'       => 'kr_product_sale_badge_mode',
							'type'     => 'button_set',
							'title'    => esc_html__( 'Sale Badge Mode', 'kr-theme' ),
							'subtitle' => esc_html__( 'Choose how to display sale badges on products', 'kr-theme' ),
							'options'  => array(
								'text'    => esc_html__( 'Text', 'kr-theme' ),
								'percent' => esc_html__( 'Percent', 'kr-theme' ),
							),
							'default'  => 'percent',
						),

						// Quick View Button
						array(
							'id'       => 'kr_product_quick_view',
							'type'     => 'switch',
							'title'    => esc_html__( 'Quick View Button', 'kr-theme' ),
							'subtitle' => esc_html__( 'Enable/disable quick view functionality on products', 'kr-theme' ),
							'default'  => 1,
						),

						// Wishlist Button
						array(
							'id'       => 'kr_product_wishlist',
							'type'     => 'switch',
							'title'    => esc_html__( 'Add To Wishlist Button', 'kr-theme' ),
							'subtitle' => esc_html__( 'Enable/disable wishlist button on products', 'kr-theme' ),
							'default'  => 1,
						),

						// Compare Button
						array(
							'id'       => 'kr_product_compare',
							'type'     => 'switch',
							'title'    => esc_html__( 'Add To Compare Button', 'kr-theme' ),
							'subtitle' => esc_html__( 'Enable/disable compare button on products', 'kr-theme' ),
							'default'  => 1,
						),

						// Shop Layout Section
						array(
							'id'     => 'kr_section_shop_layout',
							'type'   => 'section',
							'title'  => esc_html__( 'Shop Page Layout', 'kr-theme' ),
							'indent' => true,
						),

						// Products Per Page
						array(
							'id'       => 'kr_products_per_page',
							'type'     => 'text',
							'title'    => esc_html__( 'Products Per Page', 'kr-theme' ),
							'subtitle' => esc_html__( 'Number of products to display per page', 'kr-theme' ),
							'validate' => 'numeric',
							'default'  => '12',
						),

						// Shop Layout Style
						array(
							'id'       => 'kr_shop_layout',
							'type'     => 'button_set',
							'title'    => esc_html__( 'Shop Page Layout', 'kr-theme' ),
							'subtitle' => esc_html__( 'Choose layout style for shop page', 'kr-theme' ),
							'options'  => array(
								'full-width'  => esc_html__( 'Full Width', 'kr-theme' ),
								'container'   => esc_html__( 'Container', 'kr-theme' ),
								'large'       => esc_html__( 'Large Container', 'kr-theme' ),
							),
							'default'  => 'container',
						),

						// Shop Sidebar
						array(
							'id'       => 'kr_shop_sidebar',
							'type'     => 'image_select',
							'title'    => esc_html__( 'Shop Sidebar', 'kr-theme' ),
							'subtitle' => esc_html__( 'Choose sidebar layout for shop page', 'kr-theme' ),
							'options'  => array(
								'none'  => array(
									'alt'   => esc_html__( 'None', 'kr-theme' ),
									'title' => esc_html__( 'No Sidebar', 'kr-theme' ),
									'img'   => get_template_directory_uri() . '/assets/images/sidebar-none.png'
								),
								'left'  => array(
									'alt'   => esc_html__( 'Left', 'kr-theme' ),
									'title' => esc_html__( 'Left Sidebar', 'kr-theme' ),
									'img'   => get_template_directory_uri() . '/assets/images/sidebar-left.png'
								),
								'right' => array(
									'alt'   => esc_html__( 'Right', 'kr-theme' ),
									'title' => esc_html__( 'Right Sidebar', 'kr-theme' ),
									'img'   => get_template_directory_uri() . '/assets/images/sidebar-right.png'
								),
							),
							'default'  => 'left',
						),

						// End shop layout section
						array(
							'id'     => 'kr_section_shop_layout_end',
							'type'   => 'section',
							'indent' => false,
						),

						// Product Page Section
						array(
							'id'     => 'kr_section_product_page',
							'type'   => 'section',
							'title'  => esc_html__( 'Single Product Page', 'kr-theme' ),
							'indent' => true,
						),

						// Single Product Layout
						array(
							'id'       => 'kr_single_product_layout',
							'type'     => 'button_set',
							'title'    => esc_html__( 'Single Product Layout', 'kr-theme' ),
							'subtitle' => esc_html__( 'Choose layout style for single product page', 'kr-theme' ),
							'options'  => array(
								'full-width'  => esc_html__( 'Full Width', 'kr-theme' ),
								'container'   => esc_html__( 'Container', 'kr-theme' ),
								'large'       => esc_html__( 'Large Container', 'kr-theme' ),
							),
							'default'  => 'container',
						),

						// Product Gallery Style
						array(
							'id'       => 'kr_product_gallery_style',
							'type'     => 'select',
							'title'    => esc_html__( 'Product Gallery Style', 'kr-theme' ),
							'subtitle' => esc_html__( 'Choose how to display product images', 'kr-theme' ),
							'options'  => array(
								'horizontal' => esc_html__( 'Horizontal Slider', 'kr-theme' ),
								'vertical'   => esc_html__( 'Vertical Gallery', 'kr-theme' ),
								'grid'       => esc_html__( 'Grid Gallery', 'kr-theme' ),
							),
							'default'  => 'horizontal',
						),

						// End product section
						array(
							'id'     => 'kr_section_product_page_end',
							'type'   => 'section',
							'indent' => false,
						),
					),
				);
			}

		}
	}

	// Initialize Redux
	new Redux_Framework_KR_Theme_Options();
}
