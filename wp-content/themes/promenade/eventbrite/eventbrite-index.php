<?php
/**
 * Template Name: Eventbrite Events
 */

get_header();

// Set up and call our Eventbrite query.
$events = new Eventbrite_Query( apply_filters( 'eventbrite_query_args', array(
	// 'display_private' => false, // boolean
	// 'nopaging' => false,        // boolean
	// 'limit' => null,            // integer
	// 'organizer_id' => null,     // integer
	// 'p' => null,                // integer
	// 'post__not_in' => null,     // array of integers
	// 'venue_id' => null,         // integer
	// 'category_id' => null,      // integer
	// 'subcategory_id' => null,   // integer
	// 'format_id' => null,        // integer
) ) );
?>

<main id="primary" class="content-area archive-gig" role="main" itemprop="mainContentOfPage">

		<?php while ( have_posts() ) : the_post(); ?>
			<div class="archive-intro">
				<?php the_content(); ?>
			</div>
		<?php endwhile; ?>

		<?php if ( $events->have_posts() ) : ?>

			<?php while ( $events->have_posts() ) : $events->the_post(); ?>

				<dl id="event-<?php the_ID(); ?>" <?php post_class( array( 'gig-card', 'vevent' ) ); ?>>
					<dt>
						<?php the_title( '<span class="gig-name summary" itemprop="name">', '</span>' ); ?>

						<span class="gig-title">
							<?php echo promenade_eventbrite_get_venue_location(); ?>
						</span>

						<a href="<?php the_permalink(); ?>" class="gig-permalink" title="<?php esc_html_e( 'View Details', 'promenade' ); ?>"><?php echo esc_html_x( '+', 'Eventbrite event permalink', 'promenade' ); ?></a>
					</dt>

					<dd class="date">
						<?php echo promenade_eventbrite_get_date() ?>
					</dd>

					<?php if ( promenade_eventbrite_has_venue() ) : ?>
						<dd class="location vcard" itemprop="location" itemscope itemtype="http://schema.org/EventVenue">
							<?php echo esc_html( promenade_eventbrite_get_venue() ); ?>
						</dd>
					<?php endif; ?>
				</dl>

			<?php endwhile; ?>

			<?php eventbrite_paging_nav( $events ); ?>

		<?php else : ?>

			<?php esc_html_e( "There currently aren't any scheduled events. Check back soon!", 'promenade' ); ?>

		<?php endif; ?>

		<?php wp_reset_postdata(); ?>

</main>

<?php
get_footer();
