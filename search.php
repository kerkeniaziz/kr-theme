<?php
/**
 * Template for displaying search results
 *
 * @package KR_Theme
 * @since 1.0.0
 */

get_header();
?>

<div class="kr-container">
	<div class="kr-content-wrapper">
		<main id="primary" class="kr-main-content site-main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title">
						<?php
						printf(
							/* translators: %s: search query. */
							esc_html__( 'Search Results for: %s', 'kr-theme' ),
							'<span>' . get_search_query() . '</span>'
						);
						?>
					</h1>
				</header><!-- .page-header -->

				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content/content', 'search' );

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
