<?php
/**
 * KR Theme - Sidebar
 * 
 * @package KR_Theme
 */

if ( ! function_exists( 'kr_register_sidebars' ) ) {
	function kr_register_sidebars() {
		register_sidebar( array(
			'name'          => esc_html__( 'Primary Sidebar', 'kr-theme' ),
			'id'            => 'primary-sidebar',
			'description'   => esc_html__( 'Main sidebar for pages and posts', 'kr-theme' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}

	add_action( 'widgets_init', 'kr_register_sidebars' );
}
