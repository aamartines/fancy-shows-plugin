<?php
/**
 * The Template for displaying all single Eventbrite events.
 */

get_header();

// Get our event based on the ID passed by query variable.
$event = new Eventbrite_Query( array( 'p' => get_query_var( 'eventbrite_id' ) ) );
?>

<main id="primary" class="content-area" role="main" itemprop="mainContentOfPage">

	<?php if ( $event->have_posts() ) : ?>

		<?php while ( $event->have_posts() ) : $event->the_post(); ?>

			<article id="event-<?php the_ID(); ?>" <?php post_class(); ?>>

				<div class="primary-area">
					<header class="entry-header">
						<?php the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' ); ?>

						<?php if ( ! empty( eventbrite_event_venue()->name ) ) : ?>
							<p class="entry-meta entry-meta--header">
								<a class="published" href="<?php echo esc_url( eventbrite_venue_get_archive_link() ); ?>">
									<?php echo esc_html( eventbrite_event_venue()->name ) ?>
								</a>
							</p>
						<?php endif; ?>
					</header>

					<div class="entry-content">
						<?php the_content(); ?>
					</div>

					<?php eventbrite_ticket_form_widget(); ?>

					<?php eventbrite_edit_post_link( __( 'Edit', 'promenade' ), '<footer class="entry-meta entry-meta--footer"><span class="edit-link">', '</span></footer>' ); ?>
				</div>

				<div class="secondary-area">
					<div class="event-meta">
						<h4>Event Details</h4>
						<?php eventbrite_event_meta(); ?>
					</div>

					<figure class="entry-thumbnail">
						<?php the_post_thumbnail(); ?>
					</figure>
				</div>
			</article>

		<?php endwhile; ?>

	<?php else : ?>

		<?php get_template_part( 'templates/parts/no-results', 'eventbrite' ); ?>

	<?php endif; ?>

	<?php wp_reset_postdata(); ?>

</main>

<?php
get_footer();
