<?php
/**
 * The template for displaying the subscribe links for a gig.
 *
 * Easily customize the links by overriding this template in a child theme.
 *
 * @package Promenade
 * @since 1.0.0
 */
?>

<ul>
	<li>
		<a href="<?php the_audiotheme_gig_gcal_link(); ?>" target="_blank" class="button js-popup" data-popup-width="800" data-popup-height="600">
			<?php _e( 'Google Calendar', 'promenade' ); ?>
		</a>
	</li>
	<li class="last-item">
		<a href="<?php the_audiotheme_gig_ical_link(); ?>" class="button">
			<?php _e( 'iCal', 'promenade' ); ?>
		</a>
	</li>
</ul>
