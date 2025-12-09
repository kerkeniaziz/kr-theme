<?php
/**
 * The main template file
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
			if ( have_posts() ) :

				if ( is_home() && ! is_front_page() ) :
					?>
					<header>
						<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
					</header>
					<?php
				endif;

				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					/*
					 * Include the Post-Type-specific template for the content.
					 */
					get_template_part( 'template-parts/content/content', get_post_type() );

				endwhile;

				the_posts_navigation();

			else :

				get_template_part( 'template-parts/content/content', 'none' );

			endif;
			?>

		</main><!-- #primary -->

		<?php get_sidebar(); ?>
	</div><!-- .kr-content-wrapper -->
</div><!-- .kr-container -->

<?php
get_footer();
