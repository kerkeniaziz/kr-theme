<?php
/**
 * Archive Product Template
 *
 * @package KR_Theme
 * @since 1.3.2
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>

<main id="main" class="site-main" role="main">
	<?php
	do_action( 'woocommerce_before_main_content' );
	do_action( 'woocommerce_archive_description' );
	?>

	<?php if ( have_posts() ) : ?>

		<?php do_action( 'woocommerce_before_shop_loop' ); ?>

		<?php woocommerce_product_loop_start(); ?>

			<?php
			while ( have_posts() ) :
				the_post();
				do_action( 'woocommerce_shop_loop' );
				wc_get_template_part( 'content', 'product' );
			endwhile;
			?>

		<?php woocommerce_product_loop_end(); ?>

		<?php do_action( 'woocommerce_after_shop_loop' ); ?>

		<?php do_action( 'woocommerce_pagination' ); ?>

	<?php else : ?>

		<?php wc_get_template( 'loop/no-products-found.php' ); ?>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_main_content' ); ?>
</main>

<?php
get_footer( 'shop' );
