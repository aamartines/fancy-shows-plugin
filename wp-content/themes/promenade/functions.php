<?php
/**
 * Promenade functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package Promenade
 * @since 1.0.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 720; // in pixels
}

/**
 * Adjust the content width for full width pages.
 *
 * @since 1.0.0
 */
function promenade_content_width() {
	global $content_width;

	if ( promenade_is_full_width_layout() ) {
		$content_width = 1100;
	}
}
add_action( 'template_redirect', 'promenade_content_width' );

/**
 * Load helper functions and libraries.
 */
require( get_template_directory() . '/includes/customizer.php' );
require( get_template_directory() . '/includes/hooks.php' );
require( get_template_directory() . '/includes/template-helpers.php' );
require( get_template_directory() . '/includes/template-tags.php' );
require( get_template_directory() . '/includes/vendor/cedaro-theme/autoload.php' );
promenade_theme()->load();

if ( ! function_exists( 'promenade_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since 1.0.0
 */
function promenade_setup() {
	// Add support for translating strings in this theme.
	// @link http://codex.wordpress.org/Function_Reference/load_theme_textdomain
	load_theme_textdomain( 'promenade', get_template_directory() . '/languages' );

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array(
		is_rtl() ? 'assets/css/editor-style-rtl.css' : 'assets/css/editor-style.css',
		promenade_fonts_icon_url(),
	) );

	// Add support for default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Add support for the title tag.
	add_theme_support( 'title-tag' );

	// Add support for a logo.
	add_theme_support( 'site-logo', array(
		'size' => 'full',
	) );

	// Add support for post thumbnails.
	add_theme_support( 'post-thumbnails' );

	// Set thumbnail size to cover 2 column grids and featured content thumbnail
	set_post_thumbnail_size( 550, 550, array( 'center', 'top' ) );

	// Add support for Custom Background functionality.
	add_theme_support( 'custom-background', apply_filters( 'promenade_custom_background_args', array(
		'default-color' => 'ffffff',
	) ) );

	// Add HTML5 markup for the comment forms, search forms and comment lists.
	add_theme_support( 'html5', array(
		'caption', 'comment-form', 'comment-list', 'gallery', 'search-form',
	) );

	// Register default nav menus.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'promenade' ),
		'social'  => __( 'Social Menu', 'promenade' ),
	) );

	// Register the full width page template for use on the front page.
	promenade_theme()->front_page->add_support()->add_templates( 'templates/full-width.php' );

	// Register support for archive content settings.
	promenade_theme()->archive_content->add_support();

	// Register support for archive image settings.
	promenade_theme()->archive_images->add_support();
}
endif;
add_action( 'after_setup_theme', 'promenade_setup' );

/**
 * Register widget areas.
 *
 * @since 1.0.0
 */
function promenade_register_widget_areas() {
	register_sidebar( array(
		'id'            => 'sidebar-1',
		'name'          => __( 'Main Sidebar', 'promenade' ),
		'description'   => __( 'The default sidebar on all posts and pages.', 'promenade' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'id'              => 'home-widgets',
		'name'            => __( 'Home', 'promenade' ),
		'description'     => __( 'Widgets that appear on the homepage.', 'promenade' ),
		'before_widget'   => '<section id="%1$s" class="widget %2$s block-grid-item">',
		'after_widget'    => '</section>',
		'before_title'    => '<h2 class="widget-title">',
		'after_title'     => '</h2>',
	) );

	register_sidebar( array(
		'id'            => 'footer-widgets',
		'name'          => __( 'Footer', 'promenade' ),
		'description'   => __( 'Widgets that appear at the bottom of every page.', 'promenade' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s block-grid-item">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'promenade_register_widget_areas' );

/**
 * Enqueue scripts and styles.
 *
 * @since 1.0.0
 */
function promenade_scripts() {
	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'genericons', promenade_fonts_icon_url(), array(), '3.3.0' );

	// Load main style sheet.
	wp_enqueue_style( 'promenade-style', get_stylesheet_uri() );

	// Load RTL style sheet.
	wp_style_add_data( 'promenade-style', 'rtl', 'replace' );

	// Load theme scripts.
	wp_enqueue_script( 'promenade-plugins', get_template_directory_uri() . '/assets/js/plugins.js', array( 'jquery' ), '20151104', true );
	wp_enqueue_script( 'promenade', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery', 'promenade-plugins' ), '20151104', true );

	// Localize the main theme script.
	wp_localize_script( 'promenade', '_promenadeSettings', array(
		'l10n' => array(
			'nextTrack'      => __( 'Next Track', 'promenade' ),
			'previousTrack'  => __( 'Previous Track', 'promenade' ),
			'togglePlaylist' => __( 'Toggle Playlist', 'promenade' ),
		),
		'mejs' => array(
			'pluginPath' => includes_url( 'js/mediaelement/', 'relative' ),
		),
	) );

	// Load script to support comment threading when it's enabled.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Register scripts and styles for enqueueing on demand.
	wp_register_style( 'promenade-fonts', promenade_fonts_url(), array(), null );
	wp_register_script( 'promenade-cue', get_template_directory_uri() . '/assets/js/vendor/jquery.cue.js', array( 'jquery', 'mediaelement' ), '1.1.6', true );
}
add_action( 'wp_enqueue_scripts', 'promenade_scripts' );

/**
 * Output elements in the document head.
 *
 * Echoing these elements in a hook allows them to be removed, instead of
 * needing to replicate the header template.
 *
 * These elements will also be inserted into any custom header templates
 * implementing the standard <code>wp_head()</code> template tag.
 *
 * @since 1.0.0
 */
function promenade_document_head() {
	echo '<link rel="profile" href="http://gmpg.org/xfn/11">' . "\n";
	echo '<link rel="pingback" href="' . get_bloginfo( 'pingback_url' ) . '">' . "\n";
	echo '<script>document.documentElement.className = document.documentElement.className.replace(\'no-js\',\'js\');</script>' . "\n";
	echo '<!--[if lt IE 9]><script src="' . esc_url( get_template_directory_uri() ) . '/assets/js/vendor/html5.js"></script><![endif]-->' . "\n";
}
add_action( 'wp_head', 'promenade_document_head' );

/**
 * Return the Google font stylesheet URL, if available.
 *
 * The default Google font usage is localized. For languages that use characters
 * not supported by the font, the font can be disabled.
 *
 * As of 1.6.0, this is only used on WordPress.com. It's still available and is
 * registered (but not enqueued) for backward compatibility. Custom fonts are
 * loaded on self-hosted installations by the Cedaro Theme library.
 *
 * @since 1.0.0
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function promenade_fonts_url() {
	$fonts_url = '';

	/*
	translators: If there are characters in your language that are not
	supported by Lora, translate this to 'off'. Do not translate into your
	own language.
	*/
	$lora = _x( 'on', 'Lora font: on or off', 'promenade' );

	/*
	translators: If there are characters in your language that are not
	supported by Raleway, translate this to 'off'. Do not translate into your
	own language.
	*/
	$raleway = _x( 'on', 'Raleway font: on or off', 'promenade' );

	if ( 'off' !== $lora || 'off' !== $raleway ) {
		$font_families = array();

		if ( 'off' !== $lora ) {
			$font_families[] = 'Lora:400,400italic,700';
		}

		if ( 'off' !== $raleway ) {
			$font_families[] = 'Raleway:400,600,700';
		}

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = esc_url_raw( add_query_arg( $query_args, 'https://fonts.googleapis.com/css' ) );
	}

	return $fonts_url;
}

/**
 * Return the Genericons icon font stylesheet URL
 *
 * @since 1.0.0
 *
 * @return string Font stylesheet.
 */
function promenade_fonts_icon_url() {
	return get_template_directory_uri() . '/assets/css/genericons.css';
}

/**
 * Wrapper for accessing the Cedaro_Theme instance.
 *
 * @since 1.2.0
 *
 * @return Cedaro_Theme
 */
function promenade_theme() {
	static $instance;

	if ( null === $instance ) {
		Cedaro_Theme_Autoloader::register();
		$instance = new Cedaro_Theme( array( 'prefix' => 'promenade' ) );
	}

	return $instance;
}

/**
 * Return a "non-cachable" version ID.
 *
 * @deprecated 1.6.0
 * @since 1.0.0
 *
 * @return string
 */
function promenade_version_id() {
	return wp_get_theme()->get( 'Version' );
}
