<?php
/**
 * The header for our theme.
 *
 * @package Promenade
 * @since 1.0.0
 */
?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php promenade_body_schema(); ?>>
	<div id="page" class="hfeed site">
		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'promenade' ); ?></a>

		<?php do_action( 'promenade_before' ); ?>

		<header id="masthead" class="site-header" role="banner" itemscope itemtype="http://schema.org/WPHeader">
			<?php promenade_site_title(); ?>

			<nav id="site-navigation" class="site-navigation clearfix" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
				<button class="site-navigation-toggle"><?php _e( 'Menu', 'promenade' ); ?></button>

				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'menu',
					'fallback_cb'    => 'promenade_primary_nav_menu_fallback_cb',
					'depth'          => 3,
				) );
				?>
			</nav>
		</header>

		<?php do_action( 'promenade_content_before' ); ?>

		<div id="content" class="site-content">

			<?php do_action( 'promenade_content_top' ); ?>

			<div class="site-content-inside">
				<div class="page-fence">

					<?php do_action( 'promenade_content_inside_top' ); ?>
