<?php
/**
 * Header Structure Functions
 *
 * @package KR_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add sticky header class
 */
function kr_theme_sticky_header_class( $classes ) {
	if ( get_theme_mod( 'kr_theme_sticky_header', false ) ) {
		$classes[] = 'sticky-header';
	}
	return $classes;
}
add_filter( 'body_class', 'kr_theme_sticky_header_class' );

/**
 * Get header layout
 */
function kr_theme_get_header_layout() {
	return get_theme_mod( 'kr_theme_header_layout', 'default' );
}

/**
 * Default Header HTML (Fallback when builder is not used)
 */
function kr_theme_default_header() {
	?>
	<div class="kr-container">
		<div class="header-inner" style="display: flex; align-items: center; justify-content: space-between; padding: 1rem 0;">
			<?php get_template_part( 'template-parts/header/site-branding' ); ?>
			<?php get_template_part( 'template-parts/header/navigation' ); ?>
		</div>
	</div>
	<?php
}
