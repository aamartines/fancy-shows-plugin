<?php
/**
 * Template to display a Upcoming Gigs widget.
 *
 * @package Promenade
 * @since 1.0.0
 */

if ( ! empty( $title ) ) :
	echo $before_title . $title . $after_title;
endif;

if ( $loop->have_posts() ) :
?>

	<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

		<?php get_template_part( 'audiotheme/parts/gig-card' ); ?>

	<?php endwhile; ?>

	<footer>
		<?php
		printf( '<a class="more-link upcoming-gigs-archive-link" href="%s">%s <i class="icon"></i></a>',
			esc_url( get_post_type_archive_link( get_post_type() ) ),
			__( 'View All Gigs', 'promenade' )
		);
		?>
	</footer>

<?php else : ?>

	<p class="upcoming-gigs-no-results">
		<?php _e( 'No gigs are currently scheduled.', 'promenade' ); ?>
	</p>

<?php
endif;
