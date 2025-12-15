<?php
/**
 * Redux Header Field Renderer
 * 
 * Renders the header selection dropdown in theme options
 * 
 * @package KR_Theme
 * @since 1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Header Field Class
 */
class ReduxFramework_field_header {

	/**
	 * Field Render
	 */
	public static function render( $field = array(), $value = '' ) {
		// Get all header CPTs
		$headers = get_posts( array(
			'post_type'      => 'kr_header',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
		) );

		echo '<div class="kr-redux-header-field">';
		
		echo '<div class="kr-header-info">';
		echo '<p style="margin: 0 0 15px 0; color: #666; font-size: 14px;">';
		echo esc_html__( 'Select a header to display on your site.', 'kr-theme' ) . ' ';
		echo '<a href="' . esc_url( admin_url( 'admin.php?page=kr-toolkit-header-builder' ) ) . '" style="color: #2563eb; text-decoration: none; font-weight: 600;">';
		echo esc_html__( 'Create or manage headers', 'kr-theme' );
		echo '</a>';
		echo '</p>';
		echo '</div>';

		echo '<select name="' . esc_attr( $field['name'] ) . '" class="kr-header-select" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">';
		
		echo '<option value="">' . esc_html__( '-- Select a Header --', 'kr-theme' ) . '</option>';
		
		if ( $headers ) {
			foreach ( $headers as $header ) {
				$selected = selected( $value, $header->ID, false );
				echo '<option value="' . esc_attr( $header->ID ) . '" ' . $selected . '>';
				echo esc_html( $header->post_title );
				echo '</option>';
			}
		}
		
		echo '</select>';
		
		echo '</div>';

		// Add inline styles
		echo '<style>
			.kr-redux-header-field {
				background: linear-gradient(135deg, #f8f9ff 0%, #f3f4f8 100%);
				padding: 20px;
				border-radius: 8px;
				border-left: 4px solid #2563eb;
			}
			.kr-header-info {
				margin-bottom: 15px;
			}
			.kr-header-select:focus {
				outline: none;
				border-color: #2563eb;
				box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
			}
		</style>';
	}
}

// Register field
Redux::setFieldClass( 'header', 'ReduxFramework_field_header' );
