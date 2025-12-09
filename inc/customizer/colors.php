<?php
/**
 * Customizer Color Settings
 *
 * @package KR_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register color settings
 */
function kr_theme_customize_colors( $wp_customize ) {
	// Colors Section
	$wp_customize->add_section( 'kr_theme_colors', array(
		'title'    => esc_html__( 'Theme Colors', 'kr-theme' ),
		'priority' => 30,
	) );

	// Primary Color
	$wp_customize->add_setting( 'kr_theme_primary_color', array(
		'default'           => '#2563eb',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'kr_theme_primary_color', array(
		'label'    => esc_html__( 'Primary Color', 'kr-theme' ),
		'section'  => 'kr_theme_colors',
		'settings' => 'kr_theme_primary_color',
	) ) );

	// Secondary Color
	$wp_customize->add_setting( 'kr_theme_secondary_color', array(
		'default'           => '#0f172a',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'kr_theme_secondary_color', array(
		'label'    => esc_html__( 'Secondary Color', 'kr-theme' ),
		'section'  => 'kr_theme_colors',
		'settings' => 'kr_theme_secondary_color',
	) ) );

	// Text Color
	$wp_customize->add_setting( 'kr_theme_text_color', array(
		'default'           => '#1e293b',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'kr_theme_text_color', array(
		'label'    => esc_html__( 'Text Color', 'kr-theme' ),
		'section'  => 'kr_theme_colors',
		'settings' => 'kr_theme_text_color',
	) ) );

	// Link Color
	$wp_customize->add_setting( 'kr_theme_link_color', array(
		'default'           => '#2563eb',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'kr_theme_link_color', array(
		'label'    => esc_html__( 'Link Color', 'kr-theme' ),
		'section'  => 'kr_theme_colors',
		'settings' => 'kr_theme_link_color',
	) ) );
}
add_action( 'customize_register', 'kr_theme_customize_colors' );
