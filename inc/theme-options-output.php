<?php
/**
 * KR Theme Options Output Logic
 * 
 * This file handles all the output logic for theme options
 * Connects Redux options to frontend CSS, JS, and functionality
 * 
 * @package KR_Theme
 * @since 1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class KR_Theme_Options_Output {

	/**
	 * Initialize Output Logic
	 */
	public static function init() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_frontend_assets' ), 99 );
		add_action( 'wp_head', array( __CLASS__, 'output_inline_styles' ), 99 );
		add_action( 'wp_footer', array( __CLASS__, 'output_inline_scripts' ), 99 );
	}

	/**
	 * Enqueue Frontend Assets
	 */
	public static function enqueue_frontend_assets() {
		// Enqueue theme stylesheet for layout styles
		wp_enqueue_style( 'kr-theme-options', get_template_directory_uri() . '/assets/css/theme-options.css', array(), '1.4.0' );
	}

	/**
	 * Output Inline Styles in wp_head
	 */
	public static function output_inline_styles() {
		$options = get_option( 'kr_theme_options', array() );
		
		if ( empty( $options ) ) {
			return;
		}

		// Start output buffer
		ob_start();
		?>
		<style id="kr-theme-options-inline" type="text/css">
		<?php
			// ==================== GENERAL SETTINGS OUTPUT ====================
			self::output_general_settings( $options );
			
			// ==================== LAYOUT STYLES OUTPUT ====================
			self::output_layout_styles( $options );
			
			// ==================== COLOR SCHEME OUTPUT ====================
			self::output_color_scheme( $options );
			
			// ==================== TYPOGRAPHY OUTPUT ====================
			self::output_typography( $options );
			
			// ==================== GRADIENT COLORS OUTPUT ====================
			self::output_gradient_colors( $options );
			
			// ==================== WORDPRESS PARAMETERS OUTPUT ====================
			self::output_wordpress_parameters( $options );
			
			// ==================== WOOCOMMERCE OUTPUT ====================
			self::output_woocommerce_styles( $options );
		?>
		</style>
		<?php
		// Output inline styles
		echo wp_kses_post( ob_get_clean() );
	}

	/**
	 * Output General Settings Styles
	 */
	private static function output_general_settings( $options ) {
		// Layout Style handling via class in body
		// This is handled by output_layout_styles()

		// Back To Top Button styling
		if ( ! empty( $options['kr_back_to_top'] ) && $options['kr_back_to_top'] == 1 ) {
			echo esc_html( '/* Back to Top Button Enabled */' ) . "\n";
		}

		// Custom Body Background
		if ( isset( $options['kr_layout_style'] ) && $options['kr_layout_style'] === 'boxed' ) {
			if ( ! empty( $options['kr_body_background'] ) ) {
				echo "body { \n";
				
				if ( ! empty( $options['kr_body_background']['background-color'] ) ) {
					echo "  background-color: " . esc_attr( $options['kr_body_background']['background-color'] ) . "; \n";
				}
				
				if ( ! empty( $options['kr_body_background']['background-image'] ) ) {
					echo "  background-image: url('" . esc_url( $options['kr_body_background']['background-image'] ) . "'); \n";
				}
				
				if ( ! empty( $options['kr_body_background']['background-repeat'] ) ) {
					echo "  background-repeat: " . esc_attr( $options['kr_body_background']['background-repeat'] ) . "; \n";
				}
				
				if ( ! empty( $options['kr_body_background']['background-attachment'] ) ) {
					echo "  background-attachment: " . esc_attr( $options['kr_body_background']['background-attachment'] ) . "; \n";
				}
				
				if ( ! empty( $options['kr_body_background']['background-position'] ) ) {
					echo "  background-position: " . esc_attr( $options['kr_body_background']['background-position'] ) . "; \n";
				}
				
				if ( ! empty( $options['kr_body_background']['background-size'] ) ) {
					echo "  background-size: " . esc_attr( $options['kr_body_background']['background-size'] ) . "; \n";
				}
				
				echo "} \n\n";
			}
		}
	}

	/**
	 * Output Layout Style Classes
	 */
	private static function output_layout_styles( $options ) {
		$layout_style = ! empty( $options['kr_layout_style'] ) ? $options['kr_layout_style'] : 'wide';
		$site_max_width = ! empty( $options['kr_layout_site_max_width'] ) ? intval( $options['kr_layout_site_max_width'] ) : 1400;

		if ( $layout_style === 'boxed' ) {
			echo ".kr-boxed-layout { max-width: {$site_max_width}px; margin: 0 auto; } \n";
		} elseif ( $layout_style === 'float' ) {
			echo ".kr-float-layout { max-width: {$site_max_width}px; margin: 0 auto; padding: 0 20px; } \n";
		}
		
		echo "body { --kr-layout-style: '" . esc_attr( $layout_style ) . "'; } \n\n";
	}

	/**
	 * Output Color Scheme CSS Variables
	 */
	private static function output_color_scheme( $options ) {
		// Get color options with defaults
		$primary_color = ! empty( $options['kr_primary_color'] ) ? $options['kr_primary_color'] : '#2563eb';
		$text_color = ! empty( $options['kr_text_color'] ) ? $options['kr_text_color'] : '#1f2937';
		$text_secondary = ! empty( $options['kr_text_color_secondary'] ) ? $options['kr_text_color_secondary'] : '#6b7280';
		$text_tertiary = ! empty( $options['kr_text_color_tertiary'] ) ? $options['kr_text_color_tertiary'] : '#d1d5db';
		$heading_color = ! empty( $options['kr_heading_color'] ) ? $options['kr_heading_color'] : '#111827';

		// Link colors
		$link_colors = ! empty( $options['kr_link_color'] ) ? $options['kr_link_color'] : array();
		$link_regular = ! empty( $link_colors['regular'] ) ? $link_colors['regular'] : '#2563eb';
		$link_hover = ! empty( $link_colors['hover'] ) ? $link_colors['hover'] : '#1d4ed8';
		$link_active = ! empty( $link_colors['active'] ) ? $link_colors['active'] : '#1d4ed8';

		echo ":root { \n";
		echo "  --kr-primary-color: " . esc_attr( $primary_color ) . "; \n";
		echo "  --kr-text-color: " . esc_attr( $text_color ) . "; \n";
		echo "  --kr-text-secondary: " . esc_attr( $text_secondary ) . "; \n";
		echo "  --kr-text-tertiary: " . esc_attr( $text_tertiary ) . "; \n";
		echo "  --kr-heading-color: " . esc_attr( $heading_color ) . "; \n";
		echo "  --kr-link-color: " . esc_attr( $link_regular ) . "; \n";
		echo "  --kr-link-hover: " . esc_attr( $link_hover ) . "; \n";
		echo "  --kr-link-active: " . esc_attr( $link_active ) . "; \n";
		echo "} \n\n";

		// Apply text colors to body and headings
		echo "body { color: " . esc_attr( $text_color ) . "; } \n";
		echo "h1, h2, h3, h4, h5, h6 { color: " . esc_attr( $heading_color ) . "; } \n";
		echo "a { color: " . esc_attr( $link_regular ) . "; } \n";
		echo "a:hover { color: " . esc_attr( $link_hover ) . "; } \n";
		echo "a:active { color: " . esc_attr( $link_active ) . "; } \n\n";

		// Primary color styles for buttons
		echo ".btn-primary, button[type='submit'], input[type='submit'], .button { \n";
		echo "  background-color: " . esc_attr( $primary_color ) . "; \n";
		echo "  color: #ffffff; \n";
		echo "} \n\n";
	}

	/**
	 * Output Gradient Colors CSS Variables
	 */
	private static function output_gradient_colors( $options ) {
		$gradient_1 = ! empty( $options['kr_gradient_color_1'] ) ? $options['kr_gradient_color_1'] : '#ff869f';
		$gradient_2 = ! empty( $options['kr_gradient_color_2'] ) ? $options['kr_gradient_color_2'] : '#fa988a';
		$gradient_3 = ! empty( $options['kr_gradient_color_3'] ) ? $options['kr_gradient_color_3'] : '#f19a73';
		$gradient_4 = ! empty( $options['kr_gradient_color_4'] ) ? $options['kr_gradient_color_4'] : '#ffd0b1';
		$gradient_heading_1 = ! empty( $options['kr_gradient_heading_color_1'] ) ? $options['kr_gradient_heading_color_1'] : '#b1f1b3';
		$gradient_heading_2 = ! empty( $options['kr_gradient_heading_color_2'] ) ? $options['kr_gradient_heading_color_2'] : '#f3eec2';

		echo ":root { \n";
		echo "  --kr-gradient-color-1: " . esc_attr( $gradient_1 ) . "; \n";
		echo "  --kr-gradient-color-2: " . esc_attr( $gradient_2 ) . "; \n";
		echo "  --kr-gradient-color-3: " . esc_attr( $gradient_3 ) . "; \n";
		echo "  --kr-gradient-color-4: " . esc_attr( $gradient_4 ) . "; \n";
		echo "  --kr-gradient-heading-1: " . esc_attr( $gradient_heading_1 ) . "; \n";
		echo "  --kr-gradient-heading-2: " . esc_attr( $gradient_heading_2 ) . "; \n";
		echo "} \n\n";

		// Define gradient classes for use in Elementor
		echo ".gradient-1 { background: linear-gradient(135deg, var(--kr-gradient-color-1), var(--kr-gradient-color-2)); } \n";
		echo ".gradient-2 { background: linear-gradient(135deg, var(--kr-gradient-color-3), var(--kr-gradient-color-4)); } \n";
		echo ".gradient-heading { background: linear-gradient(135deg, var(--kr-gradient-heading-1), var(--kr-gradient-heading-2)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; } \n\n";
	}

	/**
	 * Output Typography CSS Variables
	 */
	private static function output_typography( $options ) {
		// Body Font
		if ( ! empty( $options['kr_body_font_family'] ) ) {
			$body_font = $options['kr_body_font_family'];
			$body_family = ! empty( $body_font['font-family'] ) ? $body_font['font-family'] : 'Inter';
			$body_weight = ! empty( $body_font['font-weight'] ) ? $body_font['font-weight'] : '400';
			
			echo "body { \n";
			echo "  font-family: '" . esc_attr( $body_family ) . "', sans-serif; \n";
			echo "  font-weight: " . esc_attr( $body_weight ) . "; \n";
			
			if ( ! empty( $options['kr_body_font_size'] ) ) {
				echo "  font-size: " . intval( $options['kr_body_font_size'] ) . "px; \n";
			}
			
			if ( ! empty( $options['kr_body_line_height'] ) ) {
				echo "  line-height: " . floatval( $options['kr_body_line_height'] ) . "; \n";
			}
			
			echo "} \n\n";
		}

		// Heading Font
		if ( ! empty( $options['kr_heading_font_family'] ) ) {
			$heading_font = $options['kr_heading_font_family'];
			$heading_family = ! empty( $heading_font['font-family'] ) ? $heading_font['font-family'] : 'Poppins';
			$heading_weight = ! empty( $heading_font['font-weight'] ) ? $heading_font['font-weight'] : '600';
			
			echo "h1, h2, h3, h4, h5, h6 { \n";
			echo "  font-family: '" . esc_attr( $heading_family ) . "', sans-serif; \n";
			echo "  font-weight: " . esc_attr( $heading_weight ) . "; \n";
			
			if ( ! empty( $options['kr_heading_line_height'] ) ) {
				echo "  line-height: " . floatval( $options['kr_heading_line_height'] ) . "; \n";
			}
			
			echo "} \n\n";
		}
	}

	/**
	 * Output Inline Scripts in wp_footer
	 */
	public static function output_inline_scripts() {
		$options = get_option( 'kr_theme_options', array() );
		
		if ( empty( $options ) ) {
			return;
		}

		// Output Back To Top script
		self::output_back_to_top_script( $options );
		
		// Output Preloader script
		self::output_preloader_script( $options );
		
		// Output Sticky Header script
		self::output_sticky_header_script( $options );
		
		// Output Custom JS
		self::output_custom_js( $options );
	}

	/**
	 * Output Back To Top Script
	 */
	private static function output_back_to_top_script( $options ) {
		if ( empty( $options['kr_back_to_top'] ) || $options['kr_back_to_top'] != 1 ) {
			return;
		}

		?>
		<script type="text/javascript">
		(function() {
			'use strict';
			
			// Create back-to-top button if it doesn't exist
			if ( ! document.getElementById( 'kr-back-to-top' ) ) {
				var btn = document.createElement( 'div' );
				btn.id = 'kr-back-to-top';
				btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M7 14l5-5 5 5H7z"/></svg>';
				btn.title = '<?php echo esc_js( __( 'Back to Top', 'kr-theme' ) ); ?>';
				document.body.appendChild( btn );
			}

			var backToTopBtn = document.getElementById( 'kr-back-to-top' );
			
			// Show/hide button on scroll
			window.addEventListener( 'scroll', function() {
				if ( window.scrollY > 300 ) {
					backToTopBtn.classList.add( 'visible' );
				} else {
					backToTopBtn.classList.remove( 'visible' );
				}
			});

			// Smooth scroll to top
			backToTopBtn.addEventListener( 'click', function() {
				window.scrollTo( {
					top: 0,
					behavior: 'smooth'
				});
			});
		})();
		</script>
		<style>
		#kr-back-to-top {
			position: fixed;
			bottom: 30px;
			right: 30px;
			width: 40px;
			height: 40px;
			background-color: var(--kr-primary-color, #2563eb);
			border-radius: 50%;
			cursor: pointer;
			display: flex;
			align-items: center;
			justify-content: center;
			color: white;
			opacity: 0;
			visibility: hidden;
			transition: all 0.3s ease;
			z-index: 999;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
		}

		#kr-back-to-top svg {
			width: 20px;
			height: 20px;
		}

		#kr-back-to-top.visible {
			opacity: 1;
			visibility: visible;
		}

		#kr-back-to-top:hover {
			background-color: var(--kr-link-hover, #1d4ed8);
			transform: translateY(-5px);
			box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
		}
		</style>
		<?php
	}

	/**
	 * Output Preloader Script
	 */
	private static function output_preloader_script( $options ) {
		$preloader_type = ! empty( $options['kr_home_preloader'] ) ? $options['kr_home_preloader'] : '';
		
		if ( empty( $preloader_type ) ) {
			return;
		}

		$bg_color = ! empty( $options['kr_home_preloader_bg_color'] ) ? $options['kr_home_preloader_bg_color'] : array();
		$bg_hex = ! empty( $bg_color['color'] ) ? $bg_color['color'] : '#ffffff';
		$bg_alpha = ! empty( $bg_color['alpha'] ) ? floatval( $bg_color['alpha'] ) : 0.95;

		$spinner_color = ! empty( $options['kr_home_preloader_spinner_color'] ) ? $options['kr_home_preloader_spinner_color'] : '#2563eb';

		?>
		<style>
		.kr-preloader {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: <?php echo esc_attr( 'rgba(' . implode( ',', array_map( 'intval', sscanf( $bg_hex, '#%02x%02x%02x' ) ) ) . ',' . $bg_alpha . ')' ); ?>;
			display: flex;
			align-items: center;
			justify-content: center;
			z-index: 9999;
			opacity: 1;
			visibility: visible;
			transition: all 0.5s ease;
		}

		.kr-preloader.loaded {
			opacity: 0;
			visibility: hidden;
		}

		.kr-preloader-content {
			text-align: center;
		}

		.kr-preloader-spinner {
			width: 50px;
			height: 50px;
			border: 4px solid rgba(0, 0, 0, 0.1);
			border-top-color: <?php echo esc_attr( $spinner_color ); ?>;
			border-radius: 50%;
			animation: kr-spin 0.8s linear infinite;
		}

		@keyframes kr-spin {
			to { transform: rotate( 360deg ); }
		}
		</style>

		<div class="kr-preloader">
			<div class="kr-preloader-content">
				<div class="kr-preloader-spinner"></div>
			</div>
		</div>

		<script>
		(function() {
			'use strict';
			document.addEventListener( 'DOMContentLoaded', function() {
				var preloader = document.querySelector( '.kr-preloader' );
				if ( preloader ) {
					setTimeout( function() {
						preloader.classList.add( 'loaded' );
						setTimeout( function() {
							preloader.remove();
						}, 500 );
					}, 1500 );
				}
			});
		})();
		</script>
		<?php
	}

	/**
	 * Output Sticky Header Script
	 */
	private static function output_sticky_header_script( $options ) {
		if ( empty( $options['kr_header_sticky'] ) || $options['kr_header_sticky'] != 1 ) {
			return;
		}

		$sticky_element = ! empty( $options['kr_header_sticky_element'] ) ? $options['kr_header_sticky_element'] : 'header';
		$header_transparent = ! empty( $options['kr_header_transparent'] ) ? $options['kr_header_transparent'] : 0;

		?>
		<script>
		(function() {
			'use strict';
			var lastScrollTop = 0;
			var headerElement = document.querySelector( 'header.site-header' );
			
			if ( ! headerElement ) {
				return;
			}

			window.addEventListener( 'scroll', function() {
				var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
				
				if ( scrollTop > 100 ) {
					headerElement.classList.add( 'kr-sticky-active' );
					<?php if ( $header_transparent == 1 ) { ?>
					headerElement.classList.add( 'kr-header-transparent' );
					<?php } ?>
				} else {
					headerElement.classList.remove( 'kr-sticky-active' );
					<?php if ( $header_transparent == 1 ) { ?>
					headerElement.classList.remove( 'kr-header-transparent' );
					<?php } ?>
				}
				
				lastScrollTop = scrollTop;
			});
		})();
		</script>

		<style>
		header.site-header.kr-sticky-active {
			position: fixed;
			top: 0;
			left: 0;
			right: 0;
			width: 100%;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
			z-index: 1000;
			animation: slideDown 0.3s ease;
		}

		@keyframes slideDown {
			from { transform: translateY( -100% ); }
			to { transform: translateY( 0 ); }
		}

		body.header-sticky-active {
			padding-top: 80px;
		}
		</style>
		<?php
	}

	/**
	 * Output WordPress Parameters Styles
	 */
	private static function output_wordpress_parameters( $options ) {
		// Page Title Background
		if ( ! empty( $options['kr_show_page_title'] ) && $options['kr_show_page_title'] == 1 ) {
			$page_title_bg = ! empty( $options['kr_page_title_bg_color'] ) ? $options['kr_page_title_bg_color'] : '#f5f5f5';
			
			echo ".kr-page-title { \n";
			echo "  background-color: " . esc_attr( $page_title_bg ) . "; \n";
			echo "  padding: 40px 0; \n";
			echo "  margin-bottom: 40px; \n";
			echo "} \n\n";
		}

		// Post Title Background
		if ( ! empty( $options['kr_show_post_title'] ) && $options['kr_show_post_title'] == 1 ) {
			$post_title_bg = ! empty( $options['kr_post_title_bg_color'] ) ? $options['kr_post_title_bg_color'] : '#f5f5f5';
			
			echo ".kr-post-title { \n";
			echo "  background-color: " . esc_attr( $post_title_bg ) . "; \n";
			echo "  padding: 40px 0; \n";
			echo "  margin-bottom: 40px; \n";
			echo "} \n\n";
		}

		// Store CSS Variables for layout settings
		$page_layout = ! empty( $options['kr_page_layout'] ) ? $options['kr_page_layout'] : 'container';
		$post_layout = ! empty( $options['kr_post_title_layout'] ) ? $options['kr_post_title_layout'] : 'full-width';
		$page_title_layout = ! empty( $options['kr_page_title_layout'] ) ? $options['kr_page_title_layout'] : 'full-width';
		
		echo "body { \n";
		echo "  --kr-page-layout: '" . esc_attr( $page_layout ) . "'; \n";
		echo "  --kr-post-title-layout: '" . esc_attr( $post_layout ) . "'; \n";
		echo "  --kr-page-title-layout: '" . esc_attr( $page_title_layout ) . "'; \n";
		echo "} \n\n";
	}

	/**
	 * Output WooCommerce Styles
	 */
	private static function output_woocommerce_styles( $options ) {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		// Sale Badge customization
		if ( ! empty( $options['kr_product_sale_badge_mode'] ) ) {
			echo ".woocommerce span.onsale { \n";
			echo "  padding: 5px 15px; \n";
			echo "  border-radius: 50%; \n";
			echo "  background-color: var(--kr-primary-color, #2563eb); \n";
			echo "  color: white; \n";
			echo "  font-weight: 600; \n";
			echo "  position: absolute; \n";
			echo "  top: 10px; \n";
			echo "  right: 10px; \n";
			echo "} \n\n";
		}

		// Quick View Button
		if ( ! empty( $options['kr_product_quick_view'] ) && $options['kr_product_quick_view'] == 1 ) {
			echo ".kr-product-quick-view { display: block; } \n";
		} else {
			echo ".kr-product-quick-view { display: none; } \n";
		}
		echo "\n";

		// Wishlist Button
		if ( ! empty( $options['kr_product_wishlist'] ) && $options['kr_product_wishlist'] == 1 ) {
			echo ".kr-product-wishlist { display: block; } \n";
		} else {
			echo ".kr-product-wishlist { display: none; } \n";
		}
		echo "\n";

		// Compare Button
		if ( ! empty( $options['kr_product_compare'] ) && $options['kr_product_compare'] == 1 ) {
			echo ".kr-product-compare { display: block; } \n";
		} else {
			echo ".kr-product-compare { display: none; } \n";
		}
		echo "\n";

		// Shop Layout settings
		$shop_layout = ! empty( $options['kr_shop_layout'] ) ? $options['kr_shop_layout'] : 'container';
		$shop_sidebar = ! empty( $options['kr_shop_sidebar'] ) ? $options['kr_shop_sidebar'] : 'left';
		
		echo "body.woocommerce { \n";
		echo "  --kr-shop-layout: '" . esc_attr( $shop_layout ) . "'; \n";
		echo "  --kr-shop-sidebar: '" . esc_attr( $shop_sidebar ) . "'; \n";
		echo "} \n\n";

		// Product Gallery styles
		$gallery_style = ! empty( $options['kr_product_gallery_style'] ) ? $options['kr_product_gallery_style'] : 'horizontal';
		
		if ( $gallery_style === 'horizontal' ) {
			echo ".woocommerce div.product .flex-wrapper .woocommerce-product-gallery { \n";
			echo "  flex-direction: column; \n";
			echo "} \n\n";
		} elseif ( $gallery_style === 'vertical' ) {
			echo ".woocommerce div.product .flex-wrapper { \n";
			echo "  flex-direction: column; \n";
			echo "} \n";
			echo ".woocommerce-product-gallery { \n";
			echo "  flex-direction: row; \n";
			echo "} \n\n";
		} elseif ( $gallery_style === 'grid' ) {
			echo ".woocommerce-product-gallery .flex-control-thumbs { \n";
			echo "  display: grid; \n";
			echo "  grid-template-columns: repeat(4, 1fr); \n";
			echo "  gap: 10px; \n";
			echo "} \n\n";
		}

		// Products per page CSS var
		$products_per_page = ! empty( $options['kr_products_per_page'] ) ? intval( $options['kr_products_per_page'] ) : 12;
		echo "body.woocommerce { \n";
		echo "  --kr-products-per-page: " . $products_per_page . "; \n";
		echo "} \n\n";

		// Single Product Layout
		$single_product_layout = ! empty( $options['kr_single_product_layout'] ) ? $options['kr_single_product_layout'] : 'container';
		echo "body.woocommerce.single-product { \n";
		echo "  --kr-single-product-layout: '" . esc_attr( $single_product_layout ) . "'; \n";
		echo "} \n\n";
	}

	/**
	 * Get WooCommerce Settings Callbacks
	 */
	public static function get_woocommerce_sale_badge_mode( $option_id = 'kr_product_sale_badge_mode' ) {
		$options = get_option( 'kr_theme_options', array() );
		return ! empty( $options[ $option_id ] ) ? $options[ $option_id ] : 'percent';
	}

	public static function get_woocommerce_products_per_page( $option_id = 'kr_products_per_page' ) {
		$options = get_option( 'kr_theme_options', array() );
		return ! empty( $options[ $option_id ] ) ? intval( $options[ $option_id ] ) : 12;
	}

	public static function get_woocommerce_shop_layout( $option_id = 'kr_shop_sidebar' ) {
		$options = get_option( 'kr_theme_options', array() );
		return ! empty( $options[ $option_id ] ) ? $options[ $option_id ] : 'left';
	}

	public static function get_page_title_status( $option_id = 'kr_show_page_title' ) {
		$options = get_option( 'kr_theme_options', array() );
		return ! empty( $options[ $option_id ] ) ? $options[ $option_id ] : 1;
	}

	public static function get_post_title_status( $option_id = 'kr_show_post_title' ) {
		$options = get_option( 'kr_theme_options', array() );
		return ! empty( $options[ $option_id ] ) ? $options[ $option_id ] : 1;
	}

	/**
	 * Output Custom JS
	 */
	private static function output_custom_js( $options ) {
		if ( empty( $options['kr_custom_js'] ) ) {
			return;
		}

		?>
		<script type="text/javascript">
		<?php echo wp_unslash( $options['kr_custom_js'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</script>
		<?php
	}
}

// Initialize output logic
if ( ! is_admin() ) {
	KR_Theme_Options_Output::init();
}
