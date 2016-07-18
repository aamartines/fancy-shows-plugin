<?php
/**
 * Jetpack integration.
 *
 * @package Promenade
 * @since 1.0.0
 * @link https://wordpress.org/plugins/jetpack/
 */

/**
 * Set up Jetpack theme support.
 *
 * Adds support for Featured Content and Infinite Scroll.
 *
 * @since 1.0.0
 */
function promenade_jetpack_setup() {
	// Add support for Infinite Scroll
	// @link http://jetpack.me/support/infinite-scroll/
	add_theme_support( 'infinite-scroll', array(
		'container'      => 'primary',
		'footer'         => 'footer',
		'footer_widgets' => 'footer-widgets',
		'render'         => 'promenade_infinite_scroll_render',
	) );
}
add_action( 'after_setup_theme', 'promenade_jetpack_setup' );

/**
 * Load required assets for Jetpack support.
 *
 * @since 1.8.0
 */
function promenade_jetpack_enqueue_assets() {
	wp_enqueue_style(
		'promenade-jetpack',
		get_template_directory_uri() . '/assets/css/jetpack.css',
		array( 'promenade-style' )
	);

	wp_style_add_data( 'promenade-jetpack', 'rtl', 'replace' );
}
add_action( 'wp_enqueue_scripts', 'promenade_jetpack_enqueue_assets' );

if ( ! function_exists( 'promenade_infinite_scroll_render' ) ) :
/**
 * Callback for the Infinite Scroll module in Jetpack to render additional posts.
 *
 * @since 1.0.0
 */
function promenade_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'templates/parts/content', get_post_format() );
	}
}
endif;
