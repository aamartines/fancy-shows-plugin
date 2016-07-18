<?php
/**
 * AudioTheme integration.
 *
 * @package Promenade
 * @since 1.0.0
 * @link https://audiotheme.com/
 */

/**
 * Set up theme defaults and register support for various AudioTheme features.
 *
 * @since 1.0.0
 */
function promenade_audiotheme_setup() {
	// Add AudioTheme automatic updates support
	add_theme_support( 'audiotheme-automatic-updates' );

	// Add thumbnail support to archive pages
	add_post_type_support( 'audiotheme_archive', 'thumbnail' );

	// Register default nav menus.
	register_nav_menus( array(
		'audiotheme_gig'    => __( 'Gigs Menu', 'promenade' ),
		'audiotheme_record' => __( 'Records Menu', 'promenade' ),
		'audiotheme_video'  => __( 'Videos Menu', 'promenade' ),
	) );

	// Add support for AudioTheme widgets.
	add_theme_support( 'audiotheme-widgets', array(
		'recent-posts', 'record', 'track', 'upcoming-gigs', 'video',
	) );

	// Add post type support for featured content.
	promenade_theme()->featured_content->add_post_types( array(
		'audiotheme_gig',
		'audiotheme_record',
		'audiotheme_video',
	) );
}
add_action( 'after_setup_theme', 'promenade_audiotheme_setup', 11 );

/**
 * Load required scripts for AudioTheme support.
 *
 * @since 1.0.0
 */
function promenade_audiotheme_scripts() {
	wp_enqueue_style(
		'promenade-audiotheme',
		get_template_directory_uri() . '/assets/css/audiotheme.css',
		array( 'promenade-style' )
	);

	wp_style_add_data( 'promenade-audiotheme', 'rtl', 'replace' );

	if ( in_array( get_post_type(), array( 'audiotheme_record', 'audiotheme_track' ) ) ) {
		wp_enqueue_script( 'promenade-cue' );
	}
}
add_action( 'wp_enqueue_scripts', 'promenade_audiotheme_scripts' );

/**
 * Insert CSS to make the background color match a custom color on single gig pages.
 *
 * @since 1.5.0
 */
function promenade_audiotheme_background_color() {
	$background_color = get_background_color();

	if ( ! is_singular( 'audiotheme_gig' ) || 'ffffff' === $background_color ) {
		return;
	}

	$gig_background   = sprintf( '.single-gig .has-venue .primary-area { background-color: #%s;}', $background_color );
	wp_add_inline_style( 'promenade-style', $gig_background );
}
add_action( 'wp_enqueue_scripts', 'promenade_audiotheme_background_color', 20 );

/**
 * Add classes to the <body> element.
 *
 * @since 1.0.0
 *
 * @param array $classes Default classes.
 * @return array
 */
function promenade_audiotheme_body_class( $classes ) {
	if (
		is_post_type_archive( array( 'audiotheme_gig', 'audiotheme_record', 'audiotheme_video' ) ) ||
		is_tax( array( 'audiotheme_record_type', 'audiotheme_video_category' ) )
	) {
		$classes[] = 'layout-full';
	}

	if ( is_singular( array( 'audiotheme_record', 'audiotheme_track' ) ) ) {
		$classes[] = 'layout-sidebar-content';
	}

	return $classes;
}
add_filter( 'body_class', 'promenade_audiotheme_body_class' );

/**
 * Add additional HTML classes to posts.
 *
 * @since 1.0.0
 *
 * @param array $classes List of HTML classes.
 * @return array
 */
function promenade_audiotheme_post_class( $classes ) {
	if ( is_singular( 'audiotheme_gig' ) && audiotheme_gig_has_venue() ) {
		$classes[] = 'has-venue';
	}

	return array_unique( $classes );
}
add_filter( 'post_class', 'promenade_audiotheme_post_class', 10 );

/**
 * Adjust AudioTheme widget image sizes.
 *
 * @since 1.0.0
 *
 * @param string|array Image size.
 * @return array
 */
function promenade_audiotheme_widget_image_size( $size ) {
	return array( 680, 680 ); // sidebar width x 2
}
add_filter( 'audiotheme_widget_record_image_size', 'promenade_audiotheme_widget_image_size' );
add_filter( 'audiotheme_widget_track_image_size', 'promenade_audiotheme_widget_image_size' );
add_filter( 'audiotheme_widget_video_image_size', 'promenade_audiotheme_widget_image_size' );

/**
 * Filter the section title.
 *
 * @since 1.1.0
 *
 * @param string  $title Section title.
 * @return string
 */
function promenade_audiotheme_section_title( $title ) {
	if ( is_singular( array( 'audiotheme_gig', 'audiotheme_record', 'audiotheme_video' ) ) ) {
		$post_type = get_post()->post_type;

		// @see get_audiotheme_post_type_archive_title()
		if ( $page_id = get_audiotheme_post_type_archive( $post_type ) ) {
			$page = get_post( $page_id );
			$title = $page->post_title;
		}
	} elseif ( is_singular( 'audiotheme_track' ) ) {
		$title = get_the_title( get_post()->post_parent );
	}

	return $title;
}
add_filter( 'promenade_section_title', 'promenade_audiotheme_section_title', 10, 2 );

/**
 * Display a secondary menu below the section header to filter AudioTheme post type archives.
 *
 * @since 1.1.0
 */
function promenade_audiotheme_archive_menu() {
	$post_type = get_post_type() ? get_post_type() : get_query_var( 'post_type' );

	if ( is_tax( 'audiotheme_record_type' ) ) {
		$post_type = 'audiotheme_record';
	} elseif ( is_tax( 'audiotheme_video_category' ) ) {
		$post_type = 'audiotheme_video';
	}

	if ( empty( $post_type ) || ! has_nav_menu( $post_type ) ) {
		return;
	}

	if ( ! is_post_type_archive( $post_type ) && ! is_tax( array( 'audiotheme_record_type', 'audiotheme_video_category' ) ) ) {
		return;
	}
	?>

	<header class="site-content-header site-content-header--secondary">
		<nav class="page-fence">
			<?php
			wp_nav_menu( array(
				'theme_location' => $post_type,
				'container'      => false,
				'menu_class'     => 'menu menu--archive',
				'depth'          => 1,
				'fallback_cb'    => false,
			) );
			?>
		</nav>
	</header>

	<?php
}
add_action( 'promenade_after_site_content_header', 'promenade_audiotheme_archive_menu' );

/**
 * Display the archive's hero image.
 *
 * @since 1.0.0
 */
function promenade_audiotheme_archive_hero() {
	if (
		! is_audiotheme_post_type_archive() ||
		! ( $id = get_audiotheme_post_type_archive() ) ||
		! has_post_thumbnail( $id )
	) {
		return;
	}
	?>
	<figure class="hero-image">
		<?php echo get_the_post_thumbnail( $id, 'full' ); ?>
	</figure>
	<?php
}
add_action( 'promenade_after_site_content_header', 'promenade_audiotheme_archive_hero', 20 );

/**
 * Link single track archive link to parent record.
 *
 * @since 1.0.0
 *
 * @param string $archive_link Post type archive link.
 * @return string
 */
function promenade_audiotheme_archive_link( $link ) {
	if ( is_singular( 'audiotheme_track' ) ) {
		$link = get_permalink( get_post()->post_parent );
	}

	return $link;
}
add_filter( 'promenade_archive_link', 'promenade_audiotheme_archive_link' );

/**
 * Filter featured content titles.
 *
 * @since 1.5.0
 *
 * @param  string $title Post title.
 * @return string
 */
function promenade_audiotheme_featured_content_title( $title ) {
	if ( 'audiotheme_gig' === get_post_type() ) {
		$title = get_audiotheme_gig_title();
	}

	return $title;
}
add_filter( 'promenade_featured_content_title', 'promenade_audiotheme_featured_content_title' );

/**
 * Filter featured content dates.
 *
 * @since 1.5.0
 *
 * @param  string $title Date string.
 * @return string
 */
function promenade_audiotheme_featured_content_date( $date ) {
	if ( 'audiotheme_gig' === get_post_type() ) {
		$date = sprintf(
			'<time class="entry-date dtstart" datetime="%1$s">%2$s</time>',
			esc_attr( get_audiotheme_gig_time( 'c' ) ),
			esc_html( get_audiotheme_gig_time( get_option( 'date_format' ) ) )
		);
	}

	if ( 'audiotheme_record' === get_post_type() ) {
		$date = __( 'Record', 'promenade' );

		if ( $year = get_audiotheme_record_release_year() ) {
			$date = __( 'Released', 'promenade' ) . ' ' . $year;
		}
	}

	if ( 'audiotheme_video' === get_post_type() ) {
		$date = __( 'Video', 'promenade' );
	}

	return $date;
}
add_filter( 'promenade_featured_content_date', 'promenade_audiotheme_featured_content_date' );

/**
 * Add styles for static Google Map images.
 *
 * @since 1.0.0
 * @link https://developers.google.com/maps/documentation/staticmaps/?csw=1#StyledMaps
 *
 * @param array $styles Style key-value pairs.
 * @return array
 */
function promenade_google_static_map_styles( $styles ) {
	// Global styles.
	$styles[] = array(
		'element' => 'geometry.fill',
		'color'   => '0xf5f5f5',
	);

	$styles[] = array(
		'element' => 'geometry.stroke',
		'color'   => '0xffffff',
	);

	$styles[] = array(
		'element' => 'labels.text.fill',
		'color'   => '0x1f1f1f',
	);

	// Road styles.
	$styles[] = array(
		'feature' => 'road',
		'element' => 'geometry.fill',
		'color'   => '0xd1d1d1',
	);

	return $styles;
}
add_filter( 'audiotheme_google_static_map_styles', 'promenade_google_static_map_styles' );

/**
 * Retrieve the formatted time for a gig.
 *
 * @since 1.5.4
 *
 * @param int|WP_Post $post Optional. Post ID or object. Defaults to the current global post.
 * @return string
 */
function promenade_audiotheme_gig_time( $post = 0 ) {
	$time_format = get_theme_mod( 'gig_time_format' );
	$time_format = empty( $time_format ) ? 'g:i A' : $time_format;
	return get_audiotheme_gig_time( '', $time_format, false, null, $post );
}

/*
 * Admin hooks.
 * -----------------------------------------------------------------------------
 */

/**
 * Add settings to the Customizer.
 *
 * @since 1.5.4
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function promenade_audiotheme_customize_register( $wp_customize ) {
	$wp_customize->add_setting( 'gig_time_format', array(
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'promenade_gig_time_format', array(
		'type'        => 'text',
		'label'       => __( 'Gig Time Format', 'promenade' ),
		'description' => '<a href="https://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">Documentation on time formatting.</a>',
		'section'     => 'theme_options',
		'settings'    => 'gig_time_format',
		'priority'    => 100,
	) );
}
add_action( 'customize_register', 'promenade_audiotheme_customize_register' );

/**
 * Unregister default widgets.
 *
 * The default recent posts widget is replaced by a similar widget from the
 * AudioTheme framework using the same identifier so that settings can be
 * migrated while switching between them.
 *
 * @since 1.0.0
 */
function promenade_audiotheme_unregister_widgets() {
	unregister_widget( 'WP_Widget_Recent_Posts' );
}
add_action( 'widgets_init', 'promenade_audiotheme_unregister_widgets' );

/**
 * Activate default archive setting fields.
 *
 * @since 1.0.0
 *
 * @param array $fields List of default fields to activate.
 * @param string $post_type Post type archive.
 * @return array
 */
function promenade_audiotheme_archive_settings_fields( $fields, $post_type ) {
	if ( ! in_array( $post_type, array( 'audiotheme_record', 'audiotheme_video' ) ) ) {
		return $fields;
	}

	$fields['columns'] = array(
		'choices' => range( 3, 5 ),
		'default' => 4,
	);

	$fields['posts_per_archive_page'] = true;

	return $fields;
}
add_filter( 'audiotheme_archive_settings_fields', 'promenade_audiotheme_archive_settings_fields', 10, 2 );

/**
 * Modify post type support for the AudioTheme Recent Posts widget.
 *
 * @since 1.0.0
 *
 * @param array $post_types Allowed post type objects.
 * @return array Array of supported post type objects.
 */
function promenade_audiotheme_widget_recent_posts_post_types( $post_types ) {
	$post_types = array(
		'post'              => get_post_type_object( 'post' ),
		'audiotheme_record' => get_post_type_object( 'audiotheme_record' ),
		'audiotheme_video'  => get_post_type_object( 'audiotheme_video' ),
	);

	return $post_types;
}
add_filter( 'audiotheme_widget_recent_posts_post_types', 'promenade_audiotheme_widget_recent_posts_post_types' );
add_filter( 'audiotheme_widget_recent_posts_show_post_type_dropdown', '__return_true' );


/*
 * Supported plugin hooks.
 * -----------------------------------------------------------------------------
 */

/**
 * Disable Jetpack Infinite Scroll on AudioTheme post types.
 *
 * @since 1.0.0
 *
 * @param bool $supported Whether Infinite Scroll is supported for the current request.
 * @return bool
 */
function promenade_audiotheme_infinite_scroll_archive_supported( $supported ) {
	$post_type = get_post_type() ? get_post_type() : get_query_var( 'post_type' );

	if ( $post_type && false !== strpos( $post_type, 'audiotheme_' ) ) {
		$supported = false;
	}

	return $supported;
}
add_filter( 'infinite_scroll_archive_supported', 'promenade_audiotheme_infinite_scroll_archive_supported' );

/**
 * Display a track's duration.
 *
 * @since 1.5.2
 *
 * @param int $track_id Track ID.
 */
function promenade_audiotheme_track_length( $track_id = 0 ) {
	$track_id = empty( $track_id ) ? get_the_ID() : $track_id;
	$length   = get_audiotheme_track_length( $track_id );

	if ( empty( $length ) ) {
		$length = _x( '-:--', 'default track length', 'promenade' );
	}

	echo esc_html( $length );
}
