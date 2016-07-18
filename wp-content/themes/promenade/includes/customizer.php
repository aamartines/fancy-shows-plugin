<?php
/**
 * Customizer
 *
 * @package Promenade
 * @since 1.0.0
 */

/**
 * Add settings to the Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function promenade_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';

	/*
	 * Theme Options.
	 *
	 * Create section to standardize location for child themes and plugins to
	 * extend the theme options.
	 */
	$wp_customize->add_section( 'theme_options', array(
		'title'    => __( 'Theme Options', 'promenade' ),
		'priority' => 120,
	) );
}
add_action( 'customize_register', 'promenade_customize_register' );

/**
 * Bind JS handlers to make the Customizer preview reload changes asynchronously.
 *
 * @since 1.0.0
 */
function promenade_customize_preview_js() {
	wp_enqueue_script(
		'promenade-customize-preview',
		get_template_directory_uri() . '/assets/js/customize-preview.js',
		array( 'customize-preview' ),
		'20150226',
		true
	);
}
add_action( 'customize_preview_init', 'promenade_customize_preview_js' );

/**
 * Sanitization callback for checkbox controls in the Customizer.
 *
 * @since 1.0.0
 *
 * @param string $value Setting value.
 * @return string 1 if checked, empty string otherwise.
 */
function promenade_customize_sanitize_checkbox( $value ) {
	return empty( $value ) || ! $value ? '' : '1';
}

/**
 * Sanitization callback for lists of IDs in the Customizer.
 *
 * @since 1.0.0
 *
 * @param string $value Setting value.
 * @return string Comma-separated list of IDs.
 */
function promenade_customize_sanitize_id_list( $value ) {
	return implode( ',', wp_parse_id_list( $value ) );
}
