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
function wpcampuscpt_Shows_init() {
	$labels = array(
		'name'               => _x( 'Shows', 'post type general name', 'wpcampus-cpt' ),
		'singular_name'      => _x( 'Show', 'post type singular name', 'wpcampus-cpt' ),
		'menu_name'          => _x( 'Shows', 'admin menu', 'wpcampus-cpt' ),
		'name_admin_bar'     => _x( 'Show', 'add new on admin bar', 'wpcampus-cpt' ),
		'add_new'            => _x( 'Add New', 'Show', 'wpcampus-cpt' ),
		'add_new_item'       => __( 'Add New Show', 'wpcampus-cpt' ),
		'new_item'           => __( 'New Show', 'wpcampus-cpt' ),
		'edit_item'          => __( 'Edit Show', 'wpcampus-cpt' ),
		'view_item'          => __( 'View Show', 'wpcampus-cpt' ),
		'all_items'          => __( 'All Shows', 'wpcampus-cpt' ),
		'search_items'       => __( 'Search Shows', 'wpcampus-cpt' ),
		'parent_item_colon'  => __( 'Parent Shows:', 'wpcampus-cpt' ),
		'not_found'          => __( 'No Shows found.', 'wpcampus-cpt' ),
		'not_found_in_trash' => __( 'No Shows found in Trash.', 'wpcampus-cpt' )
	);

	$args = array(
		'labels'             => $labels,
                'description'        => __( 'Description.', 'wpcampus-cpt' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'Show' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    'taxonomies'         => array('category', 'post_tag' ),
    'menu_icon'          => 'dashicons-calendar-alt'
	);

	register_post_type( 'Show', $args );
}
add_action( 'init', 'wpcampuscpt_Shows_init' );

/**
 * Show update messages.
 *
 * See /wp-admin/edit-form-advanced.php
 *
 * @param array $messages Existing post update messages.
 *
 * @return array Amended post update messages with new CPT update messages.
 */
function wpcampuscpt_Show_updated_messages( $messages ) {
	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );

	$messages['Show'] = array(
		0  => '', // Unused. Messages start at index 1.
		1  => __( 'Show updated.', 'wpcampus-cpt' ),
		2  => __( 'Custom field updated.', 'wpcampus-cpt' ),
		3  => __( 'Custom field deleted.', 'wpcampus-cpt' ),
		4  => __( 'Show updated.', 'wpcampus-cpt' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Show restored to revision from %s', 'wpcampus-cpt' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => __( 'Show published.', 'wpcampus-cpt' ),
		7  => __( 'Show saved.', 'wpcampus-cpt' ),
		8  => __( 'Show submitted.', 'wpcampus-cpt' ),
		9  => sprintf(
			__( 'Show scheduled for: <strong>%1$s</strong>.', 'wpcampus-cpt' ),
			// translators: Publish box date format, see http://php.net/date
			date_i18n( __( 'M j, Y @ G:i', 'wpcampus-cpt' ), strtotime( $post->post_date ) )
		),
		10 => __( 'Show draft updated.', 'wpcampus-cpt' )
	);

	if ( $post_type_object->publicly_queryable ) {
		$permalink = get_permalink( $post->ID );

		$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View Show', 'wpcampus-cpt' ) );
		$messages[ $post_type ][1] .= $view_link;
		$messages[ $post_type ][6] .= $view_link;
		$messages[ $post_type ][9] .= $view_link;

		$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
		$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview Show', 'wpcampus-cpt' ) );
		$messages[ $post_type ][8]  .= $preview_link;
		$messages[ $post_type ][10] .= $preview_link;
	}

	return $messages;
}
add_filter( 'post_updated_messages', 'wpcampuscpt_Show_updated_messages' );

/**
 * Flush rewrite rules to make custom URLs active
 */
function wpcampuscpt_rewrite_flush() {
    wpcampuscpt_Shows_init(); //
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'wpcampuscpt_rewrite_flush' );


// Create two taxonomies, Class and Year, for the post type "Show"
function wpcampuscpt_Show_taxonomies() {
	// Add Class taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Classs', 'taxonomy general name' ),
		'singular_name'     => _x( 'Class', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Classes' ),
		'all_items'         => __( 'All Classes' ),
		'parent_item'       => __( 'Parent Class' ),
		'parent_item_colon' => __( 'Parent Class:' ),
		'edit_item'         => __( 'Edit Class' ),
		'update_item'       => __( 'Update Class' ),
		'add_new_item'      => __( 'Add New Class' ),
		'new_item_name'     => __( 'New Class Name' ),
		'menu_name'         => __( 'Class' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'class' ),
	);

	register_taxonomy( 'class', array( 'Show' ), $args );

	// Add new Year taxonomy, make it non-hierarchical (like tags)
	$labels = array(
		'name'                       => _x( 'Years', 'taxonomy general name' ),
		'singular_name'              => _x( 'Year', 'taxonomy singular name' ),
		'search_items'               => __( 'Search Years' ),
		'popular_items'              => __( 'Popular Years' ),
		'all_items'                  => __( 'All Years' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Year' ),
		'update_item'                => __( 'Update Year' ),
		'add_new_item'               => __( 'Add New Year' ),
		'new_item_name'              => __( 'New Year Name' ),
		'separate_items_with_commas' => __( 'Separate years with commas' ),
		'add_or_remove_items'        => __( 'Add or remove years' ),
		'choose_from_most_used'      => __( 'Choose from the most used years' ),
		'not_found'                  => __( 'No years found.' ),
		'menu_name'                  => __( 'Years' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'year' ),
	);

	register_taxonomy( 'year', 'Show', $args );
}
add_action( 'init', 'wpcampuscpt_Show_taxonomies', 0 );

/**
 * Include Show post type in the main and search queries
 */
function wpcampuscpt_query_filter( $query ) {
    if ( !is_admin() && $query->is_main_query() ) {
		if ( $query->is_search() || $query->is_home() ) {
			$query->set('post_type', array( 'post', 'Show' ) );
	    }
    }
}
add_action( 'pre_get_posts', 'wpcampuscpt_query_filter' );

/**
 * Prints HTML with meta information for the categories, tags, etc.
 * Augmented from the Twenty Sixteen original, found in inc/template-tags.php
 */
function twentysixteen_entry_meta() {
	if ( 'post' === get_post_type() || 'Show' === get_post_type() ) {
		$author_avatar_size = apply_filters( 'twentysixteen_author_avatar_size', 49 );
		printf( '<span class="byline"><span class="author vcard">%1$s<span class="screen-reader-text">%2$s </span> <a class="url fn n" href="%3$s">%4$s</a></span></span>',
			get_avatar( get_the_author_meta( 'user_email' ), $author_avatar_size ),
			_x( 'Author', 'Used before post author name.', 'wpcampus' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			get_the_author()
		);
	}

	if ( in_array( get_post_type(), array( 'post', 'Show', 'attachment' ) ) ) {
		twentysixteen_entry_date();
	}

	$format = get_post_format();
	if ( current_theme_supports( 'post-formats', $format ) ) {
		printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
			sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'wpcampus' ) ),
			esc_url( get_post_format_link( $format ) ),
			get_post_format_string( $format )
		);
	}

	if ( 'post' === get_post_type() || 'Show' === get_post_type() ) {
		twentysixteen_entry_taxonomies();
	}

	if ( ! is_singular() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'wpcampus' ), get_the_title() ) );
		echo '</span>';
	}
}

/**
 * Prints HTML with category and tags for current post.
 * Augmented from the Twenty Sixteen original, found in inc/template-tags.php
 */
function twentysixteen_entry_taxonomies() {

	// Display Class taxonomy when available
	$tax_class_title = '<span class="tax-title">' . __( 'Class:', 'wpcampus' ) . '</span> ';
	$class_list = get_the_term_list( $post->ID, 'class', $tax_class_title, _x( ', ', 'Used between list items, there is a space after the comma.', 'wpcampus' ) );
	if ( $class_list && ( 'Show' === get_post_type() ) ) {
		echo '<span class="cat-links">' . $class_list . '</span>';
	}

	// Display Year taxonomy when available
	$tax_year_title = '<span class="tax-title">' . __( 'Year:', 'wpcampus' ) . '</span> ';
	$year_list = get_the_term_list( $post->ID, 'year', $tax_year_title, _x( ', ', 'Used between list items, there is a space after the comma.', 'wpcampus' ) );
	if ( $year_list && ( 'Show' === get_post_type() ) ) {
		echo '<span class="cat-links">' . $year_list . '</span>';
	}

	$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'wpcampus' ) );
	if ( $categories_list && twentysixteen_categorized_blog() ) {
		if ( 'Show' === get_post_type() ) {
			printf( '<span class="cat-links"><span class="tax-title">%1$s</span> %2$s</span>',
				_x( 'Categories: ', 'Used before category names.', 'wpcampus' ),
				$categories_list
			);
		} else {
			printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
				_x( 'Categories', 'Used before category names.', 'wpcampus' ),
				$categories_list
			);
		}
	}

	$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'wpcampus' ) );
	if ( $tags_list ) {
		if ( 'Show' === get_post_type() ) {
			printf( '<span class="tags-links"><span class="tax-title">%1$s </span>%2$s</span>',
				_x( 'Tags: ', 'Used before tag names.', 'wpcampus' ),
				$tags_list
			);
		} else {
			printf( '<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
				_x( 'Tags', 'Used before tag names.', 'wpcampus' ),
				$tags_list
			);
		}
	}
}
