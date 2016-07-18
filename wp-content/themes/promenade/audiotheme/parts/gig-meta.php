<?php
/**
 * The template used for displaying gig meta for individual gigs.
 *
 * @package Promenade
 * @since 1.0.0
 */
?>

<?php if ( audiotheme_gig_has_venue() ) : $venue = get_audiotheme_venue(); ?>

	<h1 class="venue-location"><?php echo get_audiotheme_venue_location( $venue->ID ); ?></h1>
	<h2 class="venue-name"><?php echo esc_html( $venue->name ); ?></h2>

<?php endif; ?>

<?php if ( ( $time = promenade_audiotheme_gig_time() ) || audiotheme_gig_has_ticket_meta() ) : ?>

	<dl class="gig-meta">
		<?php if ( ! empty( $time ) ) : ?>

			<dd class="gig-time"><?php echo esc_html( $time ); ?></dd>

		<?php endif; ?>

		<?php if ( audiotheme_gig_has_ticket_meta() ) : ?>

			<dd class="gig-tickets" itemprop="offers" itemscope itemtype="http://schema.org/Offer">

				<?php if ( $gig_tickets_price = get_audiotheme_gig_tickets_price() ) : ?>

					<span class="gig-tickets-price" itemprop="price"><?php echo esc_html( $gig_tickets_price ); ?></span>

				<?php endif; ?>

				<?php if ( $gig_tickets_url = get_audiotheme_gig_tickets_url() ) : ?>

					<span class="gig-tickets-link">
						<a href="<?php echo esc_url( $gig_tickets_url ); ?>" class="js-maybe-external" itemprop="url"><?php _e( 'Buy Tickets', 'promenade' ); ?></a>
					</span>

				<?php endif; ?>
			</dd>

		<?php endif; ?>
	</dl>

<?php endif; ?>
