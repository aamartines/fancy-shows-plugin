<?php
/**
 * Helper methods for loading or displaying template partials.
 *
 * These are typically miscellaneous template parts used outside the loop.
 * Although if the partial requires any sort of set up or tearddown, moving that
 * logic into a helper keeps the parent template a little more lean, clean,
 * reusable and easier to override in child themes.
 *
 * Loading these partials within an action hook will allow them to be easily
 * added, removed, or reordered without changing the parent template file.
 *
 * Take a look at promenade_register_template_parts() to see where most of these
 * are inserted.
 *
 * This approach tries to blend the two common approaches to theme development
 * (hooks or partials).
 *
 * @package Promenade
 * @since 1.3.0
 */

/**
 * Load the featured content.
 *
 * @since 1.3.0
 */
function promenade_template_featured_content() {
	if ( promenade_has_featured_posts() ) {
		get_template_part( 'templates/parts/featured-content' );
	}
}

/**
 * Load the front page player template part.
 *
 * @since 1.3.0
 */
function promenade_template_front_page_player() {
	$settings = promenade_get_player_settings();

	if ( empty( $settings['tracks'] ) ) {
		return;
	}

	wp_enqueue_script( 'promenade-cue' );

	include( locate_template( 'templates/parts/player.php' ) );
}

/**
 * Load the content header template part.
 *
 * @since 1.3.0
 */
function promenade_template_site_content_header() {
	get_template_part( 'templates/parts/site-content-header', get_post_type() );
}
