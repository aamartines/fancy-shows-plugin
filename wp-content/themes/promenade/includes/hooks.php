<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * @package Promenade
 * @since 1.0.0
 */

/**
 * Register template parts to load throughout the theme.
 *
 * Take note of the priorities. Changing them will allow template parts to be
 * loaded in a different order.
 *
 * To remove any of these parts, use remove_action() in the
 * "promenade_register_template_parts" hook or later.
 *
 * @since 1.3.0
 */
function promenade_register_template_parts() {
	// Load the featured content and player on the front page.
	if ( is_front_page() ) {
		add_action( 'promenade_content_top', 'promenade_template_featured_content' );
		add_action( 'promenade_content_top', 'promenade_template_front_page_player', 20 );
	}

	// Load hero image on singular posts and pages.
	if ( is_singular( array( 'post', 'page' ) ) && ! promenade_is_page_type() ) {
		add_action( 'promenade_content_top', 'promenade_hero_image', 15 );
	}

	// Load the hero image for a static posts page.
	if ( ! is_front_page() && is_home() ) {
		add_action( 'promenade_content_top', 'promenade_hero_image', 15 );
	}

	// Load the site content header.
	if ( ! is_page() || promenade_is_page_type() ) {
		add_action( 'promenade_content_top', 'promenade_template_site_content_header', 20 );
	}

	do_action( 'promenade_register_template_parts' );
}
add_action( 'template_redirect', 'promenade_register_template_parts', 9 );

/**
 * Add classes to the 'body' element.
 *
 * @since 1.0.0
 *
 * @param array $classes Default classes.
 * @return array
 */
function promenade_body_class( $classes ) {
	if ( is_front_page() && 'page' === get_option( 'show_on_front' ) ) {
		$classes[] = 'front-page';
	}

	if ( is_front_page() && ! is_home() && ! promenade_has_content() ) {
		$classes[] = 'no-content';
	}

	if ( promenade_is_full_width_layout() ) {
		$classes[] = 'layout-full';
	}

	if ( is_page() && ! is_front_page() && ! promenade_is_page_type() ) {
		$classes[] = 'layout-page-header';
	}

	if ( is_page_template( 'templates/no-sidebar.php' ) ) {
		$classes[] = 'layout-content';
	}

	if ( is_singular( 'post' ) && ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'layout-content';
	}

	if ( ( is_home() || is_post_type_archive( 'post' ) || is_search() || is_404() ) && ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'layout-content';
	}

	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return array_unique( $classes );
}
add_filter( 'body_class', 'promenade_body_class' );

/**
 * Add an image itemprop attribute to image attachments.
 *
 * @since 1.6.0
 *
 * @param  array $attr Attributes for the image markup.
 * @return array
 */
function promenade_attachment_image_attributes( $attr ) {
	$attr['itemprop'] = 'image';
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'promenade_attachment_image_attributes' );

/**
 * Display the Home widget area on the front page.
 *
 * An action is used so that the home widget are can show on any page used as
 * the front page, including pages set to use a custom page template, or
 *
 * @since 1.5.2
 */
function promenade_home_widgets() {
	if ( ! is_front_page() || ! is_active_sidebar( 'home-widgets' ) ) {
		return;
	}

	get_sidebar( 'home' );
}
add_action( 'promenade_content_inside_bottom', 'promenade_home_widgets' );

/**
 * Comment form customizations.
 *
 * @since 1.0.0
 *
 * @param array $defaults Default comment form arguments.
 * @return array
 */
function promenade_comment_form_defaults( $defaults ) {
	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? " aria-required='true'" : '' );

	$defaults['fields']['author'] = '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'promenade' ) . '</label> ' .
		'<input type="text" name="author" id="author" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="' . esc_attr__( 'Name', 'promenade' ) . '" size="30"' . $aria_req . '>' .
		( $req ? ' <span class="required">' . __( 'required', 'promenade' ) . '</span>' : '' ) .
		'</p>';

	$defaults['fields']['email'] = '<p class="comment-form-email"><label for="email">' . __( 'Email', 'promenade' ) . '</label> ' .
		'<input type="text" name="email" id="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" placeholder="' . esc_attr__( 'Email', 'promenade' ) . '" size="30"' . $aria_req . '>' .
		( $req ? ' <span class="required">' . __( 'required (not published)', 'promenade' ) . '</span>' : '' ) .
		'</p>';

	$defaults['fields']['url'] = '<p class="comment-form-url"><label for="url">' . __( 'Website', 'promenade' ) . '</label>' .
		'<input type="url" name="url" id="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="' . esc_attr__( 'Website', 'promenade' ) . '" size="30"></p>';

	$defaults['comment_field'] = '<p class="comment-form-comment"><label for="comment">' . __( 'Comment', 'promenade' ) . '</label>' .
		'<textarea name="comment" id="comment" placeholder="' . esc_attr__( 'Write a comment...', 'promenade' ) . '" cols="45" rows="8" aria-required="true"></textarea></p>';

	$defaults['comment_notes_before'] = '';
	$defaults['comment_notes_after'] = '';
	$defaults['id_submit'] = 'comment-submit';
	$defaults['label_submit'] = __( 'Submit', 'promenade' );
	$defaults['format'] = 'html5';

	return $defaults;
}
add_filter( 'comment_form_defaults', 'promenade_comment_form_defaults', 9 );
