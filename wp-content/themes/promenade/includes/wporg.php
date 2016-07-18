<?php
/**
 * Functionality specific to self-hosted installations of WordPress, including
 * any plugin support.
 *
 * @package Promenade
 * @since 1.1.1
 */

/**
 * Add support for self hosted theme functions.
 *
 * @since 1.5.0
 */
function promenade_wporg_setup() {
	// Add support for Cedaro Theme featured content.
	promenade_theme()->featured_content->add_support()->set_max_posts( 4 );
}
add_action( 'after_setup_theme', 'promenade_wporg_setup' );

/**
 * Set up custom fonts for self-hosted sites.
 *
 * @since 1.6.0
 */
function promenade_wporg_setup_custom_fonts() {
	$headings = array(
		'h1',
		'h2',
		'h3',
		'h4',
		'h5',
		'h6',
		'dt',
		'label',
		'button',
		'input',
		'select',
		'button',
		'html input[type="button"]',
		'input[type="reset"]',
		'input[type="submit"]',
		'.button',
		'textarea',
		'.published',
		'.entry-meta--header .post-type',
		'.entry-meta--footer a',
		'.pagination',
		'.lead',
		'.archive-intro',
		'.menu--archive a',
		'.front-page .content-area',
		'.front-page .content-area .entry-content',
		'.featured-content',
		'.featured-content .block-grid-item-date',
		'.record-details',
		'.comments-header .comments-title',
		'.comment-meta',
		'.comment-author',
		'.comment-reply-title',
		'.widget-title',
		'.widget_archive li',
		'.widget_categories li',
		'.widget_meta li',
		'.widget_nav_menu li',
		'.widget_pages li',
		'.widget_calendar table caption',
		'.widget_contact_info .confit-address',
		'.widget_recent_entries',
		'.widget_rss .rss-date',
		'.credits',
		'.gallery .gallery-caption',
		'.promenade-player',
		'.single-gig .venue-details',
		'.single-gig .gig-meta',
		'.single-gig .gig-description',
		'.archive-gig',
		'.gig-card',
		'.tracklist',
		'.widget .recent-posts-feed-link',
		'.widget .recent-posts-archive-link',
		'.widget .upcoming-gigs-archive-link',
		'.recent-posts-item-title',
		'.widget_audiotheme_upcoming_gigs .upcoming-gigs-archive-link',
		'.widget-area--home .widget_recent_posts .block-grid-item-title',
		'#infinite-handle span',
		'#infinite-footer',
		'.widget-area .milestone-header .event',
		'.widget-area .milestone-countdown .difference',
	);

	promenade_theme()->fonts
		->add_support()
		->register_text_groups( array(
			array(
				'id'          => 'site-title',
				'label'       => esc_html__( 'Site Title', 'promenade' ),
				'selector'    => '.site-title',
				'family'      => 'Raleway',
				'variations'  => '300',
				'tags'        => array( 'content', 'heading' ),
			),
			array(
				'id'          => 'site-navigation',
				'label'       => esc_html__( 'Site Navigation', 'promenade' ),
				'selector'    => '.site-navigation',
				'family'      => 'Raleway',
				'variations'  => '400',
				'tags'        => array( 'content', 'heading' ),
			),
			array(
				'id'          => 'headings',
				'label'       => esc_html__( 'Headings', 'promenade' ),
				'selector'    => implode( ', ', $headings ),
				'family'      => 'Raleway',
				'variations'  => '400,600,700',
				'tags'        => array( 'content', 'heading' ),
			),
			array(
				'id'          => 'content',
				'label'       => esc_html__( 'Content', 'promenade' ),
				'selector'    => 'body, input[type="checkbox"] + label, input[type="radio"] + label, .comments-area, .comment-reply-title small, .widget',
				'family'      => 'Lora',
				'variations'  => '400,400italic,700,700italic',
				'tags'        => array( 'content' ),
			),
		) );
}
add_action( 'after_setup_theme', 'promenade_wporg_setup_custom_fonts' );


/**
 * Filter the style sheet URI to point to the parent theme when a child theme is
 * being used.
 *
 * @since 1.8.0
 *
 * @param  string $uri Style sheet URI.
 * @return string
 */
function promenade_stylesheet_uri( $uri ) {
	return get_template_directory_uri() . '/style.css';
}
add_filter( 'stylesheet_uri', 'promenade_stylesheet_uri' );

/**
 * Enqueue the child theme styles.
 *
 * The action priority must be set to load after any stylesheet that need to be
 * overridden in the child theme stylesheet.
 *
 * @since 1.8.0
 */
function promenade_enqueue_child_assets() {
	if ( is_child_theme() ) {
		wp_enqueue_style( 'promenade-child-style', get_stylesheet_directory_uri() . '/style.css' );
	}

	// Deregister old handle recommended in sample child theme.
	if ( wp_style_is( 'promenade-parent-style', 'enqueued' ) ) {
		wp_dequeue_style( 'promenade-parent-style' );
		wp_deregister_style( 'promenade-parent-style' );
	}
}
add_action( 'wp_enqueue_scripts', 'promenade_enqueue_child_assets', 20 );


/*
 * Admin hooks.
 * -----------------------------------------------------------------------------
 */

/**
 * Add settings to the Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function promenade_wporg_customize_register( $wp_customize ) {
	/*
	 * Theme Options.
	 */

	$wp_customize->add_setting( 'enable_related_posts', array(
		'sanitize_callback' => 'promenade_customize_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'promenade_enable_related_posts', array(
		'type'     => 'checkbox',
		'label'    => __( 'Enable Promenade Related Posts', 'promenade' ),
		'section'  => 'theme_options',
		'settings' => 'enable_related_posts',
	) );
}
add_action( 'customize_register', 'promenade_wporg_customize_register' );


/*
 * Plugin support.
 * -----------------------------------------------------------------------------
 */

/**
 * Load AudioTheme support or display a notice that it's needed.
 */
if ( function_exists( 'audiotheme_load' ) ) {
	include( get_template_directory() . '/includes/plugins/audiotheme.php' );
} else {
	include( get_template_directory() . '/includes/vendor/class-audiotheme-themenotice.php' );

	new Audiotheme_ThemeNotice( array(
		'strings' => array(
			'notice'     => __( 'The AudioTheme Framework should be installed and activated for this theme to display properly.', 'promenade' ),
			'activate'   => __( 'Activate now', 'promenade' ),
			'learn_more' => __( 'Find out more', 'promenade' ),
			'dismiss'    => __( 'Dismiss', 'promenade' ),
		),
	) );
}

/**
 * Load Cue support.
 */
if ( class_exists( 'Cue' ) ) {
	include( get_template_directory() . '/includes/plugins/cue.php' );
}

/**
 * Load Eventbrite support.
 */
if ( function_exists( 'eventbrite_api_init' ) ) {
	include( get_template_directory() . '/includes/plugins/eventbrite.php' );
}

/**
 * Load Jetpack support.
 */
if ( class_exists( 'Jetpack' ) ) {
	include_once( get_template_directory() . '/includes/plugins/jetpack.php' );
}

/**
 * Load WooCommerce support.
 */
if ( class_exists( 'WooCommerce' ) ) {
	include( get_template_directory() . '/includes/plugins/woocommerce.php' );
}


/*
 * Theme Hooks
 * -----------------------------------------------------------------------------
 */

/**
 * Getter function for Featured Content.
 *
 * @since 2.0.0
 *
 * @return array An array of WP_Post objects.
 */
function promenade_wporg_get_featured_posts() {
	return promenade_theme()->featured_content->get_posts();
}
add_filter( 'promenade_get_featured_posts', 'promenade_wporg_get_featured_posts' );


/*
 * Theme upgrade methods.
 * -----------------------------------------------------------------------------
 */

/**
 * Upgrade theme data after an update.
 *
 * @since 1.1.1
 */
function promenade_wporg_upgrade() {
	$previous_version = get_theme_mod( 'version', '0' );
	$current_version  = wp_get_theme()->get( 'Version' );

	if ( version_compare( $previous_version, '1.3.0', '<' ) ) {
		promenade_wporg_upgrade_site_logo();
	}

	// Update the theme mod if the version is outdated.
	if ( '0' === $previous_version || version_compare( $previous_version, $current_version, '<' ) ) {
		set_theme_mod( 'version', $current_version );
	}
}
add_action( 'admin_init', 'promenade_wporg_upgrade' );

/**
 * Update site logo-related options.
 *
 * @since 1.3.0
 */
function promenade_wporg_upgrade_site_logo() {
	$logo_url = get_theme_mod( 'logo_url', '' );

	if ( ! empty( $logo_url ) ) {
		$attachment_id = promenade_get_attachment_id_by_url( $logo_url );

		// Only update data if the old logo attachment can be found and
		// a site logo option hasn't been set.
		if ( $attachment_id && ! get_option( 'site_logo' ) ) {
			$attachment_data = wp_prepare_attachment_for_js( $attachment_id );

			// Set new theme mods and hide header text by default to mimic
			// old functionality.
			set_theme_mod( 'cedaro_site_logo_url', $logo_url );
			set_theme_mod( 'site_logo_header_text', '' );

			// Update the site logo option.
			$site_logo = array_intersect_key( $attachment_data, array_flip( array( 'id', 'sizes', 'url' ) ) );
			update_option( 'site_logo', $site_logo );
		}

		// Delete the old theme mod.
		remove_theme_mod( 'logo_url' );
	}
}

/**
 * Return an ID of an attachment by searching the database with the file URL.
 *
 * First checks to see if the $url is pointing to a file that exists in the
 * wp-content directory. If so, then we search the database for a partial match
 * consisting of the remaining path AFTER the wp-content directory. Finally, if
 * a match is found the attachment ID will be returned.
 *
 * @link http://frankiejarrett.com/get-an-attachment-id-by-url-in-wordpress/
 * @link https://core.trac.wordpress.org/ticket/16830
 * @todo https://core.trac.wordpress.org/changeset/24240
 *
 * @param string $url URL.
 * @return int Attachment ID.
 */
function promenade_get_attachment_id_by_url( $url ) {
	global $wpdb;

	// Split the $url into two parts with the wp-content directory as the separator.
	$parse_url  = explode( parse_url( WP_CONTENT_URL, PHP_URL_PATH ), $url );

	// Get the host of the current site and the host of the $url, ignoring www.
	$this_host = str_ireplace( 'www.', '', parse_url( home_url(), PHP_URL_HOST ) );
	$file_host = str_ireplace( 'www.', '', parse_url( $url, PHP_URL_HOST ) );

	// Return nothing if there aren't any $url parts or if the current host and $url host do not match.
	if ( ! isset( $parse_url[1] ) || empty( $parse_url[1] ) || ( $this_host !== $file_host ) ) {
		return null;
	}

	// Search the DB for an attachment GUID with a partial path match.
	$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='attachment' AND guid RLIKE %s", $parse_url[1] ) );

	// Returns null if no attachment is found.
	return $attachment[0];
}
