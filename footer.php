<?php kr_theme_before_footer(); ?>

<!-- KR Footer Builder Support -->
<footer id="colophon" class="site-footer">
	<?php 
		// Check if footer builder is available and has a default footer
		if ( class_exists( 'KR_Header_Footer_Builder' ) ) {
			$footer_id = KR_Header_Footer_Builder::get_default_footer_id();
			if ( $footer_id ) {
				// Display custom footer from builder
				echo wp_kses_post( KR_Header_Footer_Builder::get_footer( $footer_id ) );
			} else {
				// Fallback to default theme footer
				kr_theme_default_footer();
			}
		} else {
			// Fallback if builder not available
			kr_theme_default_footer();
		}
	?>
</footer><!-- #colophon -->

<?php kr_theme_after_footer(); ?>

<?php wp_footer(); ?>

</body>
</html>
