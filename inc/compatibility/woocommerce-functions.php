<?php
/**
 * KR Theme WooCommerce Functions
 *
 * Handles WooCommerce integration and customization
 *
 * @package KR_Theme
 * @since 1.3.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

/**
 * Remove default WooCommerce styles (we'll use custom)
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Products Per Page
 */
if ( ! function_exists( 'kr_woocommerce_products_per_page' ) ) {
	function kr_woocommerce_products_per_page() {
		$products_per_page = get_theme_mod( 'kr_woocommerce_products_per_page', 12 );
		return apply_filters( 'kr_woocommerce_products_per_page', $products_per_page );
	}
	add_filter( 'loop_shop_per_page', 'kr_woocommerce_products_per_page' );
}

/**
 * Add Product Meta Fields (New, Hot, Video)
 */
if ( ! function_exists( 'kr_woocommerce_add_custom_fields' ) ) {
	function kr_woocommerce_add_custom_fields() {
		echo '<div class="options_group">';
		
		woocommerce_wp_checkbox( array(
			'id'    => 'kr_product_new',
			'label' => esc_html__( 'Mark as New Product', 'kr-theme' )
		) );

		woocommerce_wp_checkbox( array(
			'id'    => 'kr_product_hot',
			'label' => esc_html__( 'Mark as Hot/Trending', 'kr-theme' )
		) );

		woocommerce_wp_text_input( array(
			'id'          => 'kr_product_video_url',
			'label'       => esc_html__( 'Video URL', 'kr-theme' ),
			'type'        => 'url',
			'placeholder' => esc_html__( 'Enter YouTube or Vimeo URL', 'kr-theme' ),
			'desc_tip'    => true,
			'description' => esc_html__( 'Add a video URL to display on product page', 'kr-theme' )
		) );

		echo '</div>';
	}
	add_action( 'woocommerce_product_options_general_product_data', 'kr_woocommerce_add_custom_fields' );
}

/**
 * Save Product Meta Fields
 */
if ( ! function_exists( 'kr_woocommerce_save_custom_fields' ) ) {
	function kr_woocommerce_save_custom_fields( $post_id ) {
		// Verify nonce
		if ( ! isset( $_POST['woocommerce_meta_nonce'] ) || ! wp_verify_nonce( $_POST['woocommerce_meta_nonce'], 'woocommerce_save_data' ) ) {
			return;
		}

		// Save New product flag
		$kr_product_new = isset( $_POST['kr_product_new'] ) ? 'yes' : 'no';
		update_post_meta( $post_id, 'kr_product_new', sanitize_text_field( $kr_product_new ) );

		// Save Hot product flag
		$kr_product_hot = isset( $_POST['kr_product_hot'] ) ? 'yes' : 'no';
		update_post_meta( $post_id, 'kr_product_hot', sanitize_text_field( $kr_product_hot ) );

		// Save Video URL
		$kr_product_video_url = isset( $_POST['kr_product_video_url'] ) ? esc_url_raw( $_POST['kr_product_video_url'] ) : '';
		update_post_meta( $post_id, 'kr_product_video_url', $kr_product_video_url );
	}
	add_action( 'woocommerce_process_product_meta', 'kr_woocommerce_save_custom_fields' );
}

/**
 * Add Custom Columns to Product List
 */
if ( ! function_exists( 'kr_woocommerce_product_list_columns' ) ) {
	function kr_woocommerce_product_list_columns( $columns ) {
		$columns['kr_product_new'] = esc_html__( 'New', 'kr-theme' );
		$columns['kr_product_hot'] = esc_html__( 'Hot', 'kr-theme' );
		return $columns;
	}
	add_filter( 'manage_edit-product_columns', 'kr_woocommerce_product_list_columns' );
}

/**
 * Populate Custom Columns in Product List
 */
if ( ! function_exists( 'kr_woocommerce_product_list_column_values' ) ) {
	function kr_woocommerce_product_list_column_values( $column, $post_id ) {
		switch ( $column ) {
			case 'kr_product_new':
				$value = get_post_meta( $post_id, 'kr_product_new', true );
				echo ( $value === 'yes' ) ? '<span style="color: #10b981; font-weight: 600;">✓ New</span>' : '—';
				break;

			case 'kr_product_hot':
				$value = get_post_meta( $post_id, 'kr_product_hot', true );
				echo ( $value === 'yes' ) ? '<span style="color: #ef4444; font-weight: 600;">✓ Hot</span>' : '—';
				break;
		}
	}
	add_action( 'manage_product_posts_custom_column', 'kr_woocommerce_product_list_column_values', 10, 2 );
}

/**
 * Display New Badge on Product
 */
if ( ! function_exists( 'kr_woocommerce_product_new_badge' ) ) {
	function kr_woocommerce_product_new_badge() {
		global $product;
		
		if ( ! is_a( $product, 'WC_Product' ) ) {
			return;
		}

		$is_new = get_post_meta( $product->get_id(), 'kr_product_new', true );
		
		if ( $is_new === 'yes' ) {
			echo '<span class="kr-product-badge kr-product-badge-new" style="
				position: absolute;
				top: 10px;
				left: 10px;
				background: #10b981;
				color: white;
				padding: 0.25rem 0.75rem;
				border-radius: 4px;
				font-size: 0.75rem;
				font-weight: 600;
				text-transform: uppercase;
				z-index: 10;
			">New</span>';
		}
	}
	add_action( 'woocommerce_product_loop_start', 'kr_woocommerce_product_new_badge', 5 );
}

/**
 * Display Hot Badge on Product
 */
if ( ! function_exists( 'kr_woocommerce_product_hot_badge' ) ) {
	function kr_woocommerce_product_hot_badge() {
		global $product;
		
		if ( ! is_a( $product, 'WC_Product' ) ) {
			return;
		}

		$is_hot = get_post_meta( $product->get_id(), 'kr_product_hot', true );
		
		if ( $is_hot === 'yes' ) {
			echo '<span class="kr-product-badge kr-product-badge-hot" style="
				position: absolute;
				top: 10px;
				' . ( get_post_meta( $product->get_id(), 'kr_product_new', true ) === 'yes' ? 'left: 65px;' : 'left: 10px;' ) . '
				background: #ef4444;
				color: white;
				padding: 0.25rem 0.75rem;
				border-radius: 4px;
				font-size: 0.75rem;
				font-weight: 600;
				text-transform: uppercase;
				z-index: 10;
			">Hot</span>';
		}
	}
	add_action( 'woocommerce_product_loop_start', 'kr_woocommerce_product_hot_badge', 6 );
}

/**
 * Get Product New Status
 */
if ( ! function_exists( 'kr_get_product_is_new' ) ) {
	function kr_get_product_is_new( $product_id ) {
		return get_post_meta( $product_id, 'kr_product_new', true ) === 'yes';
	}
}

/**
 * Get Product Hot Status
 */
if ( ! function_exists( 'kr_get_product_is_hot' ) ) {
	function kr_get_product_is_hot( $product_id ) {
		return get_post_meta( $product_id, 'kr_product_hot', true ) === 'yes';
	}
}

/**
 * Get Product Video URL
 */
if ( ! function_exists( 'kr_get_product_video_url' ) ) {
	function kr_get_product_video_url( $product_id ) {
		return get_post_meta( $product_id, 'kr_product_video_url', true );
	}
}

/**
 * Shop Page Heading
 */
if ( ! function_exists( 'kr_woocommerce_shop_heading' ) ) {
	function kr_woocommerce_shop_heading() {
		if ( is_shop() || is_product_taxonomy() ) {
			?>
			<div class="kr-woocommerce-page-header" style="
				padding: 4rem 2rem;
				background: linear-gradient(135deg, rgba(102,126,234,0.1), rgba(168,85,247,0.1));
				margin-bottom: 3rem;
			">
				<div class="kr-container">
					<h1 style="margin: 0; font-size: clamp(2rem, 5vw, 3rem); color: #1e293b;">
						<?php 
						if ( is_shop() ) {
							echo esc_html__( 'Shop', 'kr-theme' );
						} else {
							echo wp_kses_post( single_term_title( '', false ) );
						}
						?>
					</h1>
					<?php
					if ( is_product_taxonomy() ) {
						$term = get_queried_object();
						if ( $term && $term->description ) {
							echo '<p style="color: #64748b; margin-top: 0.5rem; margin-bottom: 0;">' . wp_kses_post( $term->description ) . '</p>';
						}
					}
					?>
				</div>
			</div>
			<?php
		}
	}
	add_action( 'woocommerce_before_main_content', 'kr_woocommerce_shop_heading', 5 );
}

/**
 * Add WooCommerce Classes to Body
 */
if ( ! function_exists( 'kr_woocommerce_body_classes' ) ) {
	function kr_woocommerce_body_classes( $classes ) {
		if ( is_woocommerce() ) {
			$classes[] = 'kr-woocommerce';
			
			if ( is_shop() ) {
				$classes[] = 'kr-woocommerce-shop';
			}
			
			if ( is_product() ) {
				$classes[] = 'kr-woocommerce-product';
			}
			
			if ( is_product_taxonomy() ) {
				$classes[] = 'kr-woocommerce-taxonomy';
			}
		}
		
		return $classes;
	}
	add_filter( 'body_class', 'kr_woocommerce_body_classes' );
}

/**
 * Wrap Shop Content
 */
if ( ! function_exists( 'kr_woocommerce_before_shop_loop' ) ) {
	function kr_woocommerce_before_shop_loop() {
		echo '<div class="kr-woocommerce-content" style="display: grid; grid-template-columns: 250px 1fr; gap: 2rem; align-items: start;">';
		echo '<aside class="kr-woocommerce-sidebar" style="position: sticky; top: 80px;">';
		dynamic_sidebar( 'woocommerce-sidebar' );
		echo '</aside>';
		echo '<div class="kr-woocommerce-products">';
	}
	add_action( 'woocommerce_before_shop_loop', 'kr_woocommerce_before_shop_loop', 5 );
}

/**
 * Close Shop Content Wrapper
 */
if ( ! function_exists( 'kr_woocommerce_after_shop_loop' ) ) {
	function kr_woocommerce_after_shop_loop() {
		echo '</div></div>';
	}
	add_action( 'woocommerce_after_shop_loop', 'kr_woocommerce_after_shop_loop', 999 );
}

/**
 * Update Products Per Page Options
 */
if ( ! function_exists( 'kr_woocommerce_product_columns' ) ) {
	function kr_woocommerce_product_columns() {
		return apply_filters( 'kr_woocommerce_product_columns', 3 );
	}
	add_filter( 'loop_shop_columns', 'kr_woocommerce_product_columns' );
}
