<?php
/**
 * Footer Structure Functions
 *
 * @package KR_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get footer layout
 */
function kr_theme_get_footer_layout() {
	return get_theme_mod( 'kr_theme_footer_layout', 'columns-4' );
}

/**
 * Get copyright text
 */
function kr_theme_get_copyright_text() {
	return get_theme_mod( 'kr_theme_copyright_text', '' );
}

/**
 * Default Footer HTML (Fallback when builder is not used)
 */
function kr_theme_default_footer() {
	?>
	<div class="kr-container">
		<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) : ?>
			<div class="footer-widgets" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
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
	<?php
}
