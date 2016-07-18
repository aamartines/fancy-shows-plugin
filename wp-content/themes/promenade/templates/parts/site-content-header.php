<?php
/**
 * The template for displaying a page title and possible subnavigation.
 *
 * @package Promenade
 * @since 1.0.0
 */

do_action( 'promenade_before_site_content_header' );

if ( $title = promenade_get_section_title() ) :
?>

	<header class="site-content-header">
		<div class="page-fence">

			<h1 class="site-content-header-title">
				<?php echo promenade_allowed_tags( $title ); ?>
			</h1>

			<?php if ( apply_filters( 'promenade_show_site_content_header_nav', is_singular() ) ) : ?>
				<?php promenade_post_nav(); ?>
			<?php endif; ?>
		</div>
	</header>

<?php
endif;

do_action( 'promenade_after_site_content_header' );
