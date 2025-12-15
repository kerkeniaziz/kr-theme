<?php
/**
 * Template part for displaying site info in footer
 *
 * @package KR_Theme
 * @since 1.0.0
 */

?>

<div class="site-info">
		<div class="kr-container">
			<?php
			printf(
				/* translators: 1: Year, 2: Site name, 3: WordPress */
				esc_html__( 'Copyright &copy; %1$s %2$s. Powered by %3$s', 'kr-theme' ),
				date( 'Y' ),
				'<a href="https://www.krtheme.com/" target="_blank" rel="noopener">KR Theme</a>',
				'<a href="' . esc_url( __( 'https://wordpress.org/', 'kr-theme' ) ) . '">WordPress</a>'
			);
			?>
			<span class="sep"> | </span>
			<?php
			printf(
				/* translators: %s: Theme name */
				esc_html__( '%s Theme', 'kr-theme' ),
				'<a href="https://krtheme.com" target="_blank" rel="noopener">KR</a>'
			);
			?>
		</div>
	</div><!-- .site-info -->
