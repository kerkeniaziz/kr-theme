<?php
/**
 * Template for displaying pages
 *
 * @package KR_Theme
 * @since 1.0.0
 */

get_header();
?>

<div class="kr-container">
	<div class="kr-content-wrapper">
		<main id="primary" class="kr-main-content site-main">

			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #primary -->

		<?php
		if ( ! get_post_meta( get_the_ID(), '_kr_disable_sidebar', true ) ) {
			get_sidebar();
		}
		?>
	</div><!-- .kr-content-wrapper -->
</div><!-- .kr-container -->

<?php
get_footer();
