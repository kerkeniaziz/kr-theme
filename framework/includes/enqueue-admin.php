<?php
/**
 * KR Theme - Enqueue Admin
 * 
 * @package KR_Theme
 */

if ( ! function_exists( 'kr_enqueue_admin_scripts' ) ) {
	function kr_enqueue_admin_scripts( $hook ) {
		// Add admin scripts here
	}

	add_action( 'admin_enqueue_scripts', 'kr_enqueue_admin_scripts' );
}
