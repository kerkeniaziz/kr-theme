<?php kr_theme_before_footer(); ?>

<footer id="colophon" class="site-footer">
	<div class="kr-container">
		<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) : ?>
			<div class="footer-widgets">
				<?php
				for ( $i = 1; $i <= 4; $i++ ) {
					if ( is_active_sidebar( 'footer-' . $i ) ) {
						echo '<div class="footer-widget-area">';
						dynamic_sidebar( 'footer-' . $i );
						echo '</div>';
					}
				}
				?>
			</div>
		<?php endif; ?>

		<?php get_template_part( 'template-parts/footer/site-info' ); ?>
	</div>
</footer><!-- #colophon -->

<?php kr_theme_after_footer(); ?>

<?php wp_footer(); ?>

</body>
</html>
