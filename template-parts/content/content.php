<?php
/**
 * Template part for displaying posts
 *
 * @package KR_Theme
 * @since 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'large' ); ?>
			</a>
		</div>
	<?php else : ?>
		<!-- Placeholder Unsplash Image if no featured image -->
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=1200&h=675&fit=crop&q=80" 
					 alt="<?php the_title_attribute(); ?>"
					 style="width: 100%; height: 100%; object-fit: cover;">
			</a>
		</div>
	<?php endif; ?>

	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
		?>

		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php
				kr_theme_posted_on();
				kr_theme_posted_by();
				kr_theme_comments_link();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		if ( is_singular() ) {
			the_content();

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kr-theme' ),
					'after'  => '</div>',
				)
			);
		} else {
			the_excerpt();
		}
		?>
	</div><!-- .entry-content -->

	<?php if ( is_singular() ) : ?>
		<footer class="entry-footer">
			<?php
			kr_theme_post_categories();
			kr_theme_post_tags();
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
