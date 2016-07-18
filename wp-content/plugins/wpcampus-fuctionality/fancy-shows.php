<?php
/*
Plugin Name: Fancy Shows
Plugin URI:  https://2016.wpcampus.org/schedule/wordpress-masterclass/
Description: Adds custom post types and taxonomies
Version:     1.0.0
Author:      Alexandra Martines
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: wpcampus-cpt
*/

/**
 * Register a Shows post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
 add_action( 'init', 'codex_show_init' );
 /**
  * Register a show post type.
  *
  * @link http://codex.wordpress.org/Function_Reference/register_post_type
  */
 function codex_show_init() {
 	$labels = array(
 		'name'               => _x( 'Shows', 'post type general name', 'your-plugin-textdomain' ),
 		'singular_name'      => _x( 'Show', 'post type singular name', 'your-plugin-textdomain' ),
 		'menu_name'          => _x( 'Shows', 'admin menu', 'your-plugin-textdomain' ),
 		'name_admin_bar'     => _x( 'Show', 'add new on admin bar', 'your-plugin-textdomain' ),
 		'add_new'            => _x( 'Add New', 'show', 'your-plugin-textdomain' ),
 		'add_new_item'       => __( 'Add New Show', 'your-plugin-textdomain' ),
 		'new_item'           => __( 'New Show', 'your-plugin-textdomain' ),
 		'edit_item'          => __( 'Edit Show', 'your-plugin-textdomain' ),
 		'view_item'          => __( 'View Show', 'your-plugin-textdomain' ),
 		'all_items'          => __( 'All Shows', 'your-plugin-textdomain' ),
 		'search_items'       => __( 'Search Shows', 'your-plugin-textdomain' ),
 		'parent_item_colon'  => __( 'Parent Shows:', 'your-plugin-textdomain' ),
 		'not_found'          => __( 'No shows found.', 'your-plugin-textdomain' ),
 		'not_found_in_trash' => __( 'No shows found in Trash.', 'your-plugin-textdomain' )
 	);

 	$args = array(
 		'labels'             => $labels,
                 'description'        => __( 'Description.', 'your-plugin-textdomain' ),
 		'public'             => true,
 		'publicly_queryable' => true,
 		'show_ui'            => true,
 		'show_in_menu'       => true,
 		'query_var'          => true,
 		'rewrite'            => array( 'slug' => 'show' ),
 		'capability_type'    => 'post',
 		'has_archive'        => true,
 		'hierarchical'       => false,
 		'menu_position'      => null,
 		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
 	);

 	register_post_type( 'show', $args );
 }

 add_filter( 'post_updated_messages', 'codex_show_updated_messages' );
/**
 * Show update messages.
 *
 * See /wp-admin/edit-form-advanced.php
 *
 * @param array $messages Existing post update messages.
 *
 * @return array Amended post update messages with new CPT update messages.
 */
function codex_show_updated_messages( $messages ) {
	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );

	$messages['show'] = array(
		0  => '', // Unused. Messages start at index 1.
		1  => __( 'Show updated.', 'your-plugin-textdomain' ),
		2  => __( 'Custom field updated.', 'your-plugin-textdomain' ),
		3  => __( 'Custom field deleted.', 'your-plugin-textdomain' ),
		4  => __( 'Show updated.', 'your-plugin-textdomain' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Show restored to revision from %s', 'your-plugin-textdomain' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => __( 'Show published.', 'your-plugin-textdomain' ),
		7  => __( 'Show saved.', 'your-plugin-textdomain' ),
		8  => __( 'Show submitted.', 'your-plugin-textdomain' ),
		9  => sprintf(
			__( 'Show scheduled for: <strong>%1$s</strong>.', 'your-plugin-textdomain' ),
			// translators: Publish box date format, see http://php.net/date
			date_i18n( __( 'M j, Y @ G:i', 'your-plugin-textdomain' ), strtotime( $post->post_date ) )
		),
		10 => __( 'Show draft updated.', 'your-plugin-textdomain' )
	);

	if ( $post_type_object->publicly_queryable ) {
		$permalink = get_permalink( $post->ID );

		$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View show', 'your-plugin-textdomain' ) );
		$messages[ $post_type ][1] .= $view_link;
		$messages[ $post_type ][6] .= $view_link;
		$messages[ $post_type ][9] .= $view_link;

		$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
		$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview show', 'your-plugin-textdomain' ) );
		$messages[ $post_type ][8]  .= $preview_link;
		$messages[ $post_type ][10] .= $preview_link;
	}

	return $messages;
}

/**
 * Flush rewrite rules to make custom URLs active
 */

function codex_rewrite_flush() {
    codex_show_init();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'codex_rewrite_flush' );
