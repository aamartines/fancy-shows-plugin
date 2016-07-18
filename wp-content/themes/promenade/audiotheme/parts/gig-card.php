<?php
/**
 * The template used for displaying a gig on the archive page or at the top of
 * the individual gig page.
 *
 * @package Promenade
 * @since 1.0.0
 */

$gig = get_audiotheme_gig();
?>

<dl class="gig-card vevent" itemscope itemtype="http://schema.org/MusicEvent">
	<?php if ( audiotheme_gig_has_venue() ) : ?>

		<dt>
			<span class="gig-name summary" itemprop="name"><?php echo get_audiotheme_gig_title(); ?></span>
			<span class="gig-title"><?php echo get_audiotheme_venue_location( $gig->venue->ID ); ?></span>

			<a href="<?php the_permalink(); ?>" class="gig-permalink" title="<?php _e( 'View Details', 'promenade' ); ?>"><?php _ex( '+', 'gig permalink', 'promenade' ); ?></a>
		</dt>

	<?php endif; ?>

	<dd class="date">
		<meta content="<?php the_audiotheme_gig_time( 'c' ); ?>" itemprop="startDate">
		<time class="dtstart" datetime="<?php the_audiotheme_gig_time( 'c' ); ?>">
			<span class="value-title" title="<?php the_audiotheme_gig_time( 'c' ); ?>"></span>
			<span class="month"><?php the_audiotheme_gig_time( 'M' ); ?></span>
			<span class="day"><?php the_audiotheme_gig_time( 'd' ); ?></span>
		</time>
	</dd>

	<?php if ( audiotheme_gig_has_venue() ) : ?>

		<dd class="location vcard" itemprop="location" itemscope itemtype="http://schema.org/EventVenue">
			<?php the_audiotheme_venue_vcard( array( 'container' => '' ) ); ?>
		</dd>

	<?php endif; ?>

	<?php
	if ( ! is_singular( 'audiotheme_gig' ) ) :
		the_audiotheme_gig_description( '<dd class="gig-note" itemprop="description">', '</dd>' );
	endif;
	?>

</dl>
