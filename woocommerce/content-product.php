<?php
/**
 * Product Content Template
 *
 * @package KR_Theme
 * @since 1.3.2
 */

defined( 'ABSPATH' ) || exit;

global $product;
?>

<li <?php wc_product_class( '', $product ); ?> style="position: relative;">
	<?php
	do_action( 'woocommerce_shop_loop_item_title' );
	do_action( 'woocommerce_after_shop_loop_item_title' );
	do_action( 'woocommerce_shop_loop_item_title' );
	do_action( 'woocommerce_shop_loop_item' );
	?>

	<a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link" style="
		display: block;
		text-decoration: none;
		position: relative;
		overflow: hidden;
	">
		<?php
		do_action( 'woocommerce_before_shop_loop_item' );
		woocommerce_template_loop_product_thumbnail();
		do_action( 'woocommerce_before_shop_loop_item_title' );
		woocommerce_template_loop_product_title();
		do_action( 'woocommerce_after_shop_loop_item_title' );
		woocommerce_template_loop_rating();
		woocommerce_template_loop_price();
		do_action( 'woocommerce_after_shop_loop_item' );
		?>
	</a>

	<?php
	do_action( 'woocommerce_after_shop_loop_item' );
	?>
</li>
