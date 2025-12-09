<?php
/**
 * Customizer Typography Settings
 *
 * @package KR_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register typography settings
 */
function kr_theme_customize_typography( $wp_customize ) {
	// Typography Section
	$wp_customize->add_section( 'kr_theme_typography', array(
		'title'    => esc_html__( 'Typography', 'kr-theme' ),
		'priority' => 40,
	) );

	// Body Font Size
	$wp_customize->add_setting( 'kr_theme_body_font_size', array(
		'default'           => '16',
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'kr_theme_body_font_size', array(
		'label'       => esc_html__( 'Body Font Size (px)', 'kr-theme' ),
		'section'     => 'kr_theme_typography',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 24,
			'step' => 1,
		),
	) );

	// Line Height
	$wp_customize->add_setting( 'kr_theme_line_height', array(
		'default'           => '1.6',
		'sanitize_callback' => 'kr_theme_sanitize_float',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'kr_theme_line_height', array(
		'label'       => esc_html__( 'Line Height', 'kr-theme' ),
		'section'     => 'kr_theme_typography',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 1,
			'max'  => 3,
			'step' => 0.1,
		),
	) );
}
add_action( 'customize_register', 'kr_theme_customize_typography' );

/**
 * Sanitize float value
 */
function kr_theme_sanitize_float( $input ) {
	return floatval( $input );
}
