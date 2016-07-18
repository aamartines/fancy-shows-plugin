<?php
/**
 * The template for displaying a single gig.
 *
 * @package Promenade
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="content-area single-gig" role="main" itemprop="mainContentOfPage">

	<?php while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'gig' ); ?> itemscope itemtype="http://schema.org/MusicEvent">
			<header class="gig-header content-stretch-wide">
				<div class="gig-title-date">
					<?php the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' ); ?>

					<h2 class="gig-date">
						<meta content="<?php the_audiotheme_gig_time( 'c' ); ?>" itemprop="startDate">
						<time class="dtstart" datetime="<?php the_audiotheme_gig_time( 'c' ); ?>">
							<?php the_audiotheme_gig_time( get_option( 'date_format' ) ); ?>
						</time>
					</h2>
				</div>

				<?php if ( audiotheme_gig_has_venue() ) : ?>

					<figure class="gig-map">
						<?php
						printf( '<a href="%s" class="gig-map-link" style="background-image: url(\'%s\')" target="_blank"></a>',
							esc_url( get_audiotheme_google_map_url() ),
							esc_url( get_audiotheme_google_static_map_url( array(
								'width'  => 640,
								'height' => 175,
							) ) )
						);
						?>
					</figure>

				<?php endif; ?>
			</header>

			<div class="primary-area">
				<?php get_template_part( 'audiotheme/parts/gig-meta' ); ?>

				<?php the_audiotheme_gig_description( '<div class="gig-description">', '</div>' ); ?>

				<div class="meta-links meta-links--subscribe">
					<h4 class="button"><?php _e( 'Add To Calendar', 'promenade' ); ?> <i class="icon"></i></h4>

					<?php get_template_part( 'audiotheme/parts/gig-subscribe-links' ); ?>
				</div>

				<?php if ( ! empty( $post->post_content ) ) : ?>

					<div class="entry-content">
						<?php do_action( 'promenade_entry_content_top' ); ?>

						<?php the_content( '' ); ?>

						<?php do_action( 'promenade_entry_content_bottom' ); ?>
					</div>

				<?php endif; ?>

				<?php comments_template( '', true ); ?>
			</div>

			<?php if ( audiotheme_gig_has_venue() ) : ?>

				<div class="secondary-area">
					<div class="venue-meta">
						<h4><?php _e( 'Venue Details', 'promenade' ); ?></h4>

						<?php the_audiotheme_venue_vcard( array( 'container' => 'div' ) ); ?>
					</div>
				</div>

			<?php endif; ?>
		</article>

	<?php endwhile; ?>

</main>

<?php
get_footer();
