<?php
/**
 * Eventbrite integration.
 *
 * @package Promenade
 * @since 1.7.0
 * @link https://wordpress.org/plugins/eventbrite-api/
 */

/**
 * Set up Eventbrite theme support.
 *
 * @since 1.7.0
 */
function promenade_eventbrite_setup() {
	// Add Eventbrite support
	add_theme_support( 'eventbrite' );

	// Remove the separator from Eventbrite events meta.
	add_filter( 'eventbrite_meta_separator', '__return_false' );
}
add_action( 'after_setup_theme', 'promenade_eventbrite_setup' );

/**
 * Add classes to the <body> element.
 *
 * @since 1.0.0
 *
 * @param array $classes Default classes.
 * @return array
 */
function promenade_eventbrite_body_class( $classes ) {
	if ( eventbrite_is_single() || promenade_eventbrite_is_archive() ) {
		$classes = array_diff( $classes, array( 'layout-page-header' ) );
	}

	return $classes;
}
add_filter( 'body_class', 'promenade_eventbrite_body_class' );


/*
 * Theme hooks
 * -----------------------------------------------------------------------------
 */

/**
 * Determine when a full width layout should be used.
 *
 * @since 1.7.0
 *
 * @param bool $is_full_width Whether the layout is full width.
 * @return bool
 */
function promenade_eventbrite_is_full_width_layout( $is_full_width ) {
	if ( promenade_eventbrite_is_archive() ) {
		$is_full_width = true;
	}

	return $is_full_width;
}
add_filter( 'promenade_is_full_width_layout', 'promenade_eventbrite_is_full_width_layout' );

/**
 * Load the site content header.
 *
 * @since 1.1.0
 */
function promenade_eventbrite_register_template_parts() {
	if ( eventbrite_is_single() || promenade_eventbrite_is_archive() ) {
		add_action( 'promenade_content_top', 'promenade_template_site_content_header', 20 );
	}
}
add_action( 'promenade_register_template_parts', 'promenade_eventbrite_register_template_parts' );

/**
 * Filter the archive title on single event pages.
 *
 * @since 1.1.0
 *
 * @param string  $title Section title.
 * @return string
 */
function promenade_eventbrite_archive_title( $title ) {
	if ( eventbrite_is_single() || promenade_eventbrite_is_archive() ) {
		$title = esc_html__( 'Events', 'promenade' );
	}

	return $title;
}
add_filter( 'promenade_archive_title', 'promenade_eventbrite_archive_title', 20, 2 );

/**
 * Hide site content header navigation on single event pages.
 *
 * @since 1.7.0
 *
 * @param bool $show_nav Show or hide navigation.
 * @return bool
 */
function promenade_eventbrite_site_content_header_nav( $show_nav ) {
	if ( eventbrite_is_single() || promenade_eventbrite_is_archive() ) {
		$show_nav = false;
	}

	return $show_nav;
}
add_filter( 'promenade_show_site_content_header_nav', 'promenade_eventbrite_site_content_header_nav' );


/*
 * Template tags
 * -----------------------------------------------------------------------------
 */


/**
 * Return event venue name.
 *
 * @since 1.7.0
 */
function promenade_eventbrite_get_venue() {
	return eventbrite_event_venue()->name;
}

/**
 * Determine if event has a venue set.
 *
 * @since 1.7.0
 */
function promenade_eventbrite_has_venue() {
	return empty( promenade_eventbrite_get_venue() ) ? false : true;
}

/**
 * Determine if we're viewing an Eventbrite archive page.
 *
 * @since 1.7.0
 */
function promenade_eventbrite_is_archive() {
	return (
		'eventbrite-index.php' == get_post_meta( get_the_ID(), '_wp_page_template', true )
		&& ! eventbrite_is_single()
	);
}

/**
 * Return event start date for singular date display.
 *
 * @since 1.7.0
 */
function promenade_eventbrite_get_date() {
	return mysql2date( 'F j', eventbrite_event_start()->local );
}

/**
 * Get event venue location name.
 *
 * @since 1.7.0
 */
function promenade_eventbrite_get_venue_location() {
	$venue    = eventbrite_event_venue();
	$city     = ( isset( $venue->address->city ) )   ? $venue->address->city   : '';
	$region   = ( isset( $venue->address->region ) ) ? $venue->address->region : '';
	$location = get_the_title();

	if ( ! empty( $city ) && ! empty( $region ) ) {
		$location = sprintf( '<span class="city">%1$s</span> <span class="region-sep">,</span> <span class="region">%2$s</span>', esc_html( $city ), esc_html( $region ) );
	}

	return $location;
}
