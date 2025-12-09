<?php
/**
 * Customizer Layout Settings
 *
 * @package KR_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register layout settings
 */
function kr_theme_customize_layout( $wp_customize ) {
	// Layout Section
	$wp_customize->add_section( 'kr_theme_layout', array(
		'title'    => esc_html__( 'Layout Settings', 'kr-theme' ),
		'priority' => 50,
	) );

	// Container Width
	$wp_customize->add_setting( 'kr_theme_container_width', array(
		'default'           => '1200',
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'kr_theme_container_width', array(
		'label'       => esc_html__( 'Container Width (px)', 'kr-theme' ),
		'section'     => 'kr_theme_layout',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 960,
			'max'  => 1920,
			'step' => 10,
		),
	) );

	// Sidebar Position
	$wp_customize->add_setting( 'kr_theme_sidebar_position', array(
		'default'           => 'right',
		'sanitize_callback' => 'kr_theme_sanitize_sidebar_position',
	) );

	$wp_customize->add_control( 'kr_theme_sidebar_position', array(
		'label'   => esc_html__( 'Sidebar Position', 'kr-theme' ),
		'section' => 'kr_theme_layout',
		'type'    => 'select',
		'choices' => array(
			'left'  => esc_html__( 'Left', 'kr-theme' ),
			'right' => esc_html__( 'Right', 'kr-theme' ),
			'none'  => esc_html__( 'No Sidebar', 'kr-theme' ),
		),
	) );
}
add_action( 'customize_register', 'kr_theme_customize_layout' );

/**
 * Sanitize sidebar position
 */
function kr_theme_sanitize_sidebar_position( $input ) {
	$valid = array( 'left', 'right', 'none' );
	return in_array( $input, $valid, true ) ? $input : 'right';
}
