<?php
/**
 * Template for displaying archive pages
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
					<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
					?>
				</header><!-- .page-header -->

				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

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
