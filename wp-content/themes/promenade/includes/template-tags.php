<?php
/**
 * Custom template tags.
 *
 * @package Promenade
 * @since 1.0.0
 */

if ( ! function_exists( 'promenade_site_title' ) ) :
/**
 * Display the site title.
 *
 * Either the site title or a logo image, depending on what is set in the Customizer.
 *
 * @since 1.0.0
 */
function promenade_site_title() {
	$site_logo = promenade_theme()->logo->html();

	$site_title = sprintf( '<h1 class="site-title"><a href="%1$s" rel="home">%2$s</a></h1>',
		esc_url( home_url( '/' ) ),
		get_bloginfo( 'name' )
	);

	echo $site_logo . $site_title;
}
endif;

if ( ! function_exists( 'promenade_hero_image' ) ) :
/**
 * Display the featured image for a post.
 *
 * @since 1.0.0
 */
function promenade_hero_image() {
	$post_id = get_the_ID();

	if ( 'page' === get_option( 'show_on_front' ) && ! is_front_page() && is_home() ) {
		$post_id = get_option( 'page_for_posts' );
	}

	// Display featured image on the first page only.
	if ( has_post_thumbnail( $post_id ) && 1 === promenade_get_paged_query_var() ) :
	?>
		<figure class="hero-image">
			<?php echo get_the_post_thumbnail( $post_id, 'full' ); ?>
		</figure>
	<?php
	endif;
}
endif;

if ( ! function_exists( 'promenade_entry_date' ) ) :
/**
 * Print HTML with meta information for the current post-date/time.
 *
 * @since 1.0.0
 *
 * @param bool $show_updated Whether to show modified time. Defaults to false.
 */
function promenade_entry_date( $show_updated = false, $echo = true ) {
	$time_string = '<time class="entry-date published" datetime="%1$s" itemprop="datePublished">%2$s</time>';

	if ( $show_updated && get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="entry-date updated" datetime="%3$s" itemprop="dateModified">%4$s</time>';
	}

	$output = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	if ( $echo ) {
		print $output;
	} else {
		return $output;
	}
}
endif;

if ( ! function_exists( 'promenade_post_terms' ) ) :
/**
 * Print HTML with meta information for categories and tags.
 *
 * @since 1.0.0
 */
function promenade_post_terms() {
	// translators: used between list items, there is a space after the comma.
	$category_list = get_the_category_list( __( ', ', 'promenade' ) );

	// translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'promenade' ) );

	if ( ! promenade_is_categorized_blog() ) {
		// This blog only has one category so we just need to worry about tags in the meta text.
		if ( ! empty( $tag_list ) ) {
			$meta_text = __( 'Tagged as %2$s.', 'promenade' );
		} else {
			$meta_text = '';
		}
	} else {
		// This blog has loads of categories so we should probably display them here.
		if ( ! empty( $tag_list ) ) {
			$meta_text = __( 'Posted in %1$s and tagged as %2$s.', 'promenade' );
		} else {
			$meta_text = __( 'Posted in %1$s.', 'promenade' );
		}
	}

	printf( $meta_text, $category_list, $tag_list );
}
endif;

if ( ! function_exists( 'promenade_posted_by' ) ) :
/**
 * Print HTML with meta information for the current author.
 *
 * @since 1.0.0
 */
function promenade_posted_by() {
	$author_link = sprintf( '<span class="author vcard" itemprop="author" itemscope itemtype="http://schema.org/Person"><a class="url fn n" href="%1$s" rel="author" itemprop="url"><span itemprop="name">%2$s</span></a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	);

	// translators: 1: byline prefix, 2: post author link
	printf( __( '%1$s %2$s', 'promenade' ),
		sprintf( '<span class="sep sep-by">%s</span>', _x( 'By', 'author byline prefix', 'promenade' ) ),
		$author_link
	);
}
endif;

if ( ! function_exists( 'promenade_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable.
 *
 * @since 1.0.0
 * @uses promenade_paging_nav()
 * @uses promenade_post_nav()
 */
function promenade_content_nav() {
	if ( is_singular() ) {
		promenade_post_nav();
	} else {
		promenade_paginate_links();
	}
}
endif;

if ( ! function_exists( 'promenade_post_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable in singular
 * templates.
 *
 * @since 1.0.0
 */
function promenade_post_nav() {
	$post = get_post();

	if ( ! is_singular() ) {
		return;
	}

	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}

	$post_type_object = get_post_type_object( get_post_type() );
	?>
	<nav class="paged-nav paged-nav--singular" role="navigation">
		<?php previous_post_link( '<span class="paged-nav-prev icon">%link</span>', sprintf( _x( 'Previous %s', 'previous post link', 'promenade' ), esc_html( $post_type_object->labels->singular_name ) ) ); ?>

		<?php
		printf( '<span class="paged-nav-back icon"><a href="%s">%s</a></span>',
			esc_url( promenade_get_archive_link() ),
			_x( 'Back', 'post type archive link', 'promenade' )
		);
		?>

		<?php next_post_link( '<span class="paged-nav-next icon">%link</span>', sprintf( _x( 'Next %s', 'next post link', 'promenade' ), esc_html( $post_type_object->labels->singular_name ) ) ); ?>
	</nav>
	<?php
}
endif;

if ( ! function_exists( 'promenade_paginate_links' ) ) :
/**
 * Retrieve or display pagination output.
 *
 * @since 1.0.0
 *
 * @param array $args Optional. List of arguments to modify behavior and output.
 * @param WP_Query $custom_query Optional. A custom WP_Query object to base the pagination off of instead of the global.
 * @return string
 */
function promenade_paginate_links( $args = array(), $custom_query = null ) {
	global $wp_query, $wp_rewrite;

	$output = '';
	$echo = ( ! isset( $args['echo'] ) || $args['echo'] ) ? true : false;
	$current = ( $wp_query->get( 'paged' ) > 1 ) ? $wp_query->get( 'paged' ) : 1;

	if ( $custom_query ) {
		$default_query = $wp_query;
		$wp_query = $custom_query;
	}

	$args = wp_parse_args( $args, array(
		'base'      => str_replace( '999999999', '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
		'format'    => '?paged=%#%',
		'total'     => $wp_query->max_num_pages,
		'current'   => max( 1, promenade_get_paged_query_var() ),
		'prev_next' => false,
		'end_size'  => false,
		'type'      => 'list'
	) );

	if ( $wp_query->max_num_pages > 1 ) {
		$output  = '<nav class="pagination navigation-paging" role="navigation">';
		$output .= paginate_links( $args );
		$output .= '</nav>';
	}

	if ( $custom_query ) {
		$wp_query = $default_query;
		unset( $default_query );
		wp_reset_query();
	}

	if ( $echo ) {
		echo $output;
	} else {
		return $output;
	}
}
endif;

if ( ! function_exists( 'promenade_page_links' ) ) :
/**
 * Wrapper for wp_link_pages() to help standardize page links output.
 *
 * @since 1.0.0
 */
function promenade_page_links() {
	wp_link_pages( array(
		'before' => '<div class="page-links"><span>' . __( 'Pages:', 'promenade' ) . '</span>',
		'after'  => '</div>',
	) );
}
endif;

/**
 * Get the current page number for paginated requests.
 *
 * The below functionality is used because the query is set in a page template,
 * the "paged" variable is available. However, if the query is on a page
 * template that is set as the websites static posts page, "paged" is always set
 * at 0. In this case, we have another variable to work with called "page",
 * which increments the pagination properly.
 *
 * Hat Tip: @nathanrice
 *
 * @link http://wordpress.org/support/topic/wp-30-bug-with-pagination-when-using-static-page-as-homepage-1
 *
 * @since 1.0.0
 *
 * @return int
 */
function promenade_get_paged_query_var() {
	if ( get_query_var( 'paged' ) ) {
		$paged = get_query_var( 'paged' );
	} elseif ( get_query_var( 'page' ) ) {
		$paged = get_query_var( 'page' );
	} else {
		$paged = 1;
	}

	return $paged;
}

/**
 * Check if a blog has more than one category.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function promenade_is_categorized_blog() {
	return promenade_theme()->template->has_multiple_terms( 'category' );
}

if ( ! function_exists( 'promenade_block_grid' ) ) :
/**
 * Display block grid media objects.
 *
 * Display posts in a block grid on archive type pages.
 *
 * @since 1.0.0
 *
 * @param int|WP_Post $post Optional. Post ID or object. Defaults to current post.
 * @param array $args List of arguments for modifying the query and display.
 */
function promenade_block_grid( $args = array(), $post = null ) {
	global $wp_query;

	$post = get_post( $post );

	$args = wp_parse_args( $args, array(
		'columns' => 3,
		'classes' => array(),
		'loop'    => $wp_query,
	) );

	$columns = $args['columns'];
	$classes = $args['classes'];
	$loop    = $args['loop'];

	$classes[] = 'block-grid';

	if ( $columns ) {
		$classes[] = 'block-grid-' . $columns;
	}

	do_action( 'promenade_block_grid_before', $post );
	include( locate_template( 'templates/parts/block-grid.php' ) );
	do_action( 'promenade_block_grid_after', $post );
}
endif;

if ( ! function_exists( 'promenade_related_posts' ) ) :
/**
 * Display related posts.
 *
 * Randomly selects other posts of the same type.
 *
 * @since 1.0.0
 *
 * @param int|WP_Post $post Optional. Post ID or object. Defaults to current post.
 * @param array $args List of arguments for modifying the query and display.
 */
function promenade_related_posts( $post = null, $args = array() ) {
	// Return early if Related Posts has not been enabled.
	if ( ! get_theme_mod( 'enable_related_posts' ) ) {
		return;
	}

	$post = get_post( $post );

	$args = wp_parse_args( $args, array(
		'post_type'      => $post->post_type,
		'posts_per_page' => 3,
		'post__not_in'   => array( $post->ID ),
		'orderby'        => 'rand',
	) );

	$loop = new WP_Query( apply_filters( 'promenade_related_posts_args', $args ) );

	if ( ! $loop->have_posts() ) {
		return;
	}

	$classes = array(
		'related-posts-' . $post->post_type,
		'block-grid',
		'block-grid-' . promenade_get_mapped_column_number( $args['posts_per_page'] ),
		'block-grid-thumbnails',
	);

	if ( 'audiotheme_video' === $post->post_type ) {
		$classes[] = 'block-grid-thumbnails--landscape';
	}

	do_action( 'promenade_before_related_posts', $post );
	include( locate_template( 'templates/parts/related-posts.php' ) );
	do_action( 'promenade_after_related_posts', $post );
}
endif;

if ( ! function_exists( 'promenade_is_full_width_layout' ) ) :
/**
 * Boolean function to check if page has a full width layout.
 *
 * @since 1.0.0
 */
function promenade_is_full_width_layout() {
	$is_full_width    = false;
	$is_page_on_front = is_front_page() && 'page' === get_option( 'show_on_front' );

	if ( $is_page_on_front || is_page_template( 'templates/full-width.php' ) ) {
		$is_full_width = true;
	}

	return apply_filters( 'promenade_is_full_width_layout', $is_full_width );
}
endif;

/**
 * Determine if a page is the singular version of a registered type.
 *
 * @since 1.0.0
 *
 * @param string $type A registered page type.
 * @return bool
 */
function promenade_is_page_type( $type = '' ) {
	return promenade_theme()->page_types->is_type( $type );
}

/**
 * Retrieve archive page templates.
 *
 * Maintained for backwards compatibility with child themes.
 *
 * @deprecated 1.3.0
 * @since 1.0.0
 *
 * @return array
 */
function promenade_get_archive_page_template() {
	$templates = array();
	if ( promenade_theme()->page_types->is_archive() ) {
		$templates = promenade_theme()->page_types->get_archive_templates();
	}
	return $templates;
}

/**
 * Retrieve the permalink for an archive.
 *
 * @since 1.0.0
 *
 * @param int|WP_Post $post Optional. Post to get the archive link for. Defaults to the current post.
 * @return string
 */
function promenade_get_archive_link( $post = null ) {
	return promenade_theme()->get_archive_link( $post );
}

if ( ! function_exists( 'promenade_get_post_type_archive_link' ) ) :
/**
 * Retrieve the permalink for a post type's archive.
 *
 * Core's get_post_type_archive_link() doesn't work with regular posts, for
 * which we'd like to return a link to the homepage or the page_for_posts page.
 *
 * @since 1.3.0
 *
 * @param string $post_type Post type.
 * @return string
 */
function promenade_get_post_type_archive_link( $post_type ) {
	$archive_link = get_post_type_archive_link( $post_type );

	if ( 'post' === $post_type ) {
		$archive_link = home_url( '/' );

		if ( 'page' === get_option( 'show_on_front' ) && get_option( 'page_for_posts', false ) ) {
			$archive_link = get_permalink( get_option( 'page_for_posts' ) );
		}
	}

	return apply_filters( 'promenade_post_type_archive_link', $archive_link, $post_type );
}
endif;

/**
 * Retrieve the section title.
 *
 * @since 1.1.0
 *
 * @param int|WP_Post $post Optional. Post to get the archive title for. Defaults to the current post.
 * @return string
 */
function promenade_get_section_title( $post = null ) {
	$title = '';

	if ( is_home() || is_singular() ) {
		$title = promenade_get_archive_title( $post );
	} elseif ( is_archive() ) {
		if ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		} elseif ( is_category() || is_tag() || is_tax() ) {
			$title = single_term_title( '', false );
		} elseif ( is_author() ) {
			$title = sprintf( __( 'Author: %s', 'promenade' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" rel="me">' . get_the_author() . '</a></span>' );
		} elseif ( is_day() ) {
			$title = sprintf( __( 'Day: %s', 'promenade' ), '<span>' . get_the_date() . '</span>' );
		} elseif ( is_month() ) {
			$title = sprintf( __( 'Month: %s', 'promenade' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );
		} elseif ( is_year() ) {
			$title = sprintf( __( 'Year: %s', 'promenade' ), '<span>' . get_the_date( 'Y' ) . '</span>' );
		} else {
			$title = __( 'Archives', 'promenade' );
		}
	} elseif ( is_search() ) {
		$title = sprintf( __( 'Search Results for: %s', 'promenade' ), '<span class="search-term">' . get_search_query() . '</span>' );
	} elseif ( is_404() ) {
		$title = __( 'Oops! That page can&rsquo;t be found.', 'promenade' );
	}

	return apply_filters( 'promenade_section_title', $title );
}

/**
 * Retrieve the section title for an archive.
 *
 * @since 1.0.0
 *
 * @param int|WP_Post $post Optional. Post to get the archive title for. Defaults to the current post.
 * @return string
 */
function promenade_get_archive_title( $post = null ) {
	$post = get_post( $post );

	if ( 'post' === get_post_type( $post ) && 'page' === get_option( 'show_on_front' ) ) {
		$title = get_the_title( get_option( 'page_for_posts' ) );
	} elseif ( promenade_is_page_type() ) {
		$title = get_the_title( $post->post_parent );
	} else {
		$title = get_post_type_object( $post->post_type )->label;
	}

	return apply_filters( 'promenade_archive_title', $title, $post );
}

/**
 * Determine if a post has content.
 *
 * @since 1.4.1
 *
 * @param int|WP_Post $post_id Optional. Post ID or WP_Post object. Defaults to the current global post.
 * @return bool
 */
function promenade_has_content( $post_id = null ) {
	$post_id = empty( $post_id ) ? get_the_ID() : $post_id;
	$content = get_post_field( 'post_content', $post_id );

	return empty( $content ) ? false : true;
}

/**
 * Getter function for Featured Content.
 *
 * @since 1.0.0
 *
 * @return array An array of WP_Post objects.
 */
function promenade_get_featured_posts() {
	return apply_filters( 'promenade_get_featured_posts', array() );
}

if ( ! function_exists( 'promenade_has_featured_posts' ) ) :
/**
 * A helper conditional function that returns a boolean value.
 *
 * @since 1.0.0
 *
 * @return bool Whether there are featured posts.
 */
function promenade_has_featured_posts( $minimum = 1 ) {
	if ( is_paged() ) {
		return false;
	}

	$minimum = absint( $minimum );
	$featured_posts = promenade_get_featured_posts();

	if ( ! is_array( $featured_posts ) || $minimum > count( $featured_posts ) ) {
		return false;
	}

	return true;
}
endif;

/**
 * Retrieve settings for the homepage player.
 *
 * @since 1.0.0
 *
 * @return array Array of settings.
 */
function promenade_get_player_settings() {
	$settings = array(
		'tracks' => promenade_get_player_tracks(),
	);

	return $settings;
}

/**
 * Retrieve the tracks for the homepage player.
 *
 * Uses values set by a filter, otherwise uses an option from the Customizer.
 *
 * @since 1.3.0
 * @see wp_get_playlist()
 *
 * @return array Array of tracks.
 */
function promenade_get_player_tracks() {
	return promenade_theme()->template->get_tracks( 'player_attachment_ids' );
}

if ( ! function_exists( 'promenade_get_mapped_column_number' ) ) :
/**
 * Map number of columns greater than 5 to a new column count.
 *
 * @since 1.0.0
 */
function promenade_get_mapped_column_number( $columns = 3 ) {
	$columns_map = array(
		'6'  => 3,
		'7'  => 4,
		'8'  => 4,
		'9'  => 3,
		'10' => 5,
	);

	if ( $columns > 5 ) {
		$columns = array_key_exists( $columns, $columns_map ) ? $columns_map[ $columns ] : 3;
	}

	return $columns;
}
endif;

if ( ! function_exists( 'promenade_primary_nav_menu_fallback_cb' ) ) :
/**
 * Output primary nav menu fallback message.
 *
 * @since 1.0.0
 */
function promenade_primary_nav_menu_fallback_cb() {
	if ( ! current_user_can( 'edit_theme_options' ) || ! is_customize_preview() ) {
		return;
	}
	?>
	<p>
		<?php _e( 'Ready to create your first menu?', 'promenade' ); ?>

		<?php
		printf( '<a href="%s">%s</a>.',
			esc_url( admin_url( 'nav-menus.php' ) ),
			__( 'Get started here', 'promenade' )
		);
		?>
	</p>
	<?php
}
endif;

/**
 * Display body schema markup.
 *
 * @since 1.6.0
 */
function promenade_body_schema() {
	$schema = 'http://schema.org/';
	$type   = 'WebPage';

	if ( is_home() || is_singular( 'post' ) || is_category() || is_tag() ) {
		$type = 'Blog';
	} elseif ( is_author() ) {
		$type = 'ProfilePage';
	} elseif ( is_search() ) {
		$type = 'SearchResultsPage';
	}

	$type = apply_filters( 'promenade_body_schema', $type );

	printf(
		'itemscope="itemscope" itemtype="%1$s%2$s"',
		esc_attr( $schema ),
		esc_attr( $type )
	);
}

if ( ! function_exists( 'promenade_allowed_tags' ) ) :
/**
 * Allow only the allowedtags array in a string.
 *
 * @since 1.1.0
 *
 * @param  string $string The unsanitized string.
 * @return string         The sanitized string.
 */
function promenade_allowed_tags( $string ) {
	global $allowedtags;

	$theme_tags = array(
		'span' => array(
			'class' => true,
		),
	);

	return wp_kses( $string, array_merge( $allowedtags, $theme_tags ) );
}
endif;

if ( ! function_exists( 'promenade_credits' ) ) :
/**
 * Theme credits text.
 *
 * @since 1.0.0
 *
 * @param string $text Text to display.
 * @return string
 */
function promenade_credits() {
	$text = sprintf( __( '%1$s WordPress theme by %2$s.', 'promenade' ),
		'<a href="https://audiotheme.com/view/promenade/">Promenade</a>',
		'<a href="https://audiotheme.com/">AudioTheme</a>'
	);

	echo apply_filters( 'promenade_credits', $text );
}
endif;
