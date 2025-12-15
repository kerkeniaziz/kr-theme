<?php
/**
 * Redux Footer Field Renderer
 * 
 * Renders the footer selection dropdown in theme options
 * 
 * @package KR_Theme
 * @since 1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Footer Field Class
 */
class ReduxFramework_field_footer {

	/**
	 * Field Render
	 */
	public static function render( $field = array(), $value = '' ) {
		// Get all footer CPTs
		$footers = get_posts( array(
			'post_type'      => 'kr_footer',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
		) );

		echo '<div class="kr-redux-footer-field">';
		
		echo '<div class="kr-footer-info">';
		echo '<p style="margin: 0 0 15px 0; color: #666; font-size: 14px;">';
		echo esc_html__( 'Select a footer to display on your site.', 'kr-theme' ) . ' ';
		echo '<a href="' . esc_url( admin_url( 'admin.php?page=kr-toolkit-footer-builder' ) ) . '" style="color: #9333ea; text-decoration: none; font-weight: 600;">';
		echo esc_html__( 'Create or manage footers', 'kr-theme' );
		echo '</a>';
		echo '</p>';
		echo '</div>';

		echo '<select name="' . esc_attr( $field['name'] ) . '" class="kr-footer-select" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">';
		
		echo '<option value="">' . esc_html__( '-- Select a Footer --', 'kr-theme' ) . '</option>';
		
		if ( $footers ) {
			foreach ( $footers as $footer ) {
				$selected = selected( $value, $footer->ID, false );
				echo '<option value="' . esc_attr( $footer->ID ) . '" ' . $selected . '>';
				echo esc_html( $footer->post_title );
				echo '</option>';
			}
		}
		
		echo '</select>';
		
		echo '</div>';

		// Add inline styles
		echo '<style>
			.kr-redux-footer-field {
				background: linear-gradient(135deg, #faf5ff 0%, #f8f3fc 100%);
				padding: 20px;
				border-radius: 8px;
				border-left: 4px solid #9333ea;
			}
			.kr-footer-info {
				margin-bottom: 15px;
			}
			.kr-footer-select:focus {
				outline: none;
				border-color: #9333ea;
				box-shadow: 0 0 0 3px rgba(147, 51, 234, 0.1);
			}
		</style>';
	}
}

// Register field
Redux::setFieldClass( 'footer', 'ReduxFramework_field_footer' );
