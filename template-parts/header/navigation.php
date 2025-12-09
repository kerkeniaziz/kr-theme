<?php
/**
 * Template part for displaying navigation
 *
 * @package KR_Theme
 * @since 1.0.0
 */

?>

<nav id="site-navigation" class="main-navigation">
	<button class="mobile-menu-toggle" aria-controls="primary-menu" aria-expanded="false">
		<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'kr-theme' ); ?></span>
		<span class="menu-icon">&#9776;</span>
	</button>
	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'menu_id'        => 'primary-menu',
			'container'      => false,
			'fallback_cb'    => false,
		)
	);
	?>
</nav><!-- #site-navigation -->
