<?php
/**
 * WooCommerce integration.
 *
 * @package Promenade
 * @since 1.1.0
 * @link https://wordpress.org/plugins/woocommerce/
 * @link http://docs.woothemes.com/document/third-party-custom-theme-compatibility/
 */

/**
 * Set up WooCommerce theme support.
 *
 * @since 1.1.0
 */
function promenade_woocommerce_setup() {
	add_theme_support( 'woocommerce' );

	// Disable the page title for the catalog and product archive pages.
	add_filter( 'woocommerce_show_page_title', '__return_false' );
}
add_action( 'after_setup_theme', 'promenade_woocommerce_setup', 11 );

/**
 * Remove the default WooCommerce content wrappers.
 *
 * @since 1.1.0
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' );

/**
 * Print the default theme content open tag.
 *
 * Wraps WooCommerce content with the same elements used throughout the theme.
 *
 * @since 1.1.0
 */
function promenade_woocommerce_before_main_content() {
	echo '<main id="primary" class="content-area" role="main" itemprop="mainContentOfPage">';
}
add_action( 'woocommerce_before_main_content', 'promenade_woocommerce_before_main_content' );

/**
 * Print the default theme content wrapper close tag.
 *
 * @since 1.1.0
 */
function promenade_woocommerce_after_main_content() {
	echo '</main>';
}
add_action( 'woocommerce_after_main_content', 'promenade_woocommerce_after_main_content' );

/**
 * Filter the section title on WooCommerce pages.
 *
 * @since 1.1.0
 *
 * @param string $title Section title.
 * @return string
 */
function promenade_woocommerce_section_title( $title ) {
	if ( is_shop() ) {
		$title = woocommerce_page_title( false );
	}

	return $title;
}
add_filter( 'promenade_section_title', 'promenade_woocommerce_section_title' );
