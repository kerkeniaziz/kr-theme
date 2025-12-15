<?php
/**
 * Single Product Template
 *
 * @package KR_Theme
 * @since 1.3.2
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>

<main id="main" class="site-main" role="main">
	<?php
	while ( have_posts() ) :
		the_post();
		?>

		<div class="kr-product-single" style="max-width: 1200px; margin: 2rem auto; padding: 0 2rem;">
			<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: start;">
				<!-- Product Images -->
				<div class="kr-product-images">
					<?php woocommerce_show_product_images(); ?>
				</div>

				<!-- Product Info -->
				<div class="kr-product-info">
					<?php do_action( 'woocommerce_single_product_summary' ); ?>
				</div>
			</div>

			<!-- Product Tabs -->
			<div class="kr-product-tabs" style="margin-top: 4rem;">
				<?php woocommerce_output_product_data_tabs(); ?>
			</div>

			<!-- Related Products -->
			<div class="kr-product-related" style="margin-top: 4rem;">
				<?php woocommerce_output_related_products(); ?>
			</div>
		</div>

		<?php
	endwhile;
	?>

	<?php do_action( 'woocommerce_after_main_content' ); ?>
</main>

<?php
get_footer( 'shop' );
