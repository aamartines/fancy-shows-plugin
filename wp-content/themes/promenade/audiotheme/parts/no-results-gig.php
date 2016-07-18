<?php
/**
 * The template for displaying a message when there aren't any upcoming gigs.
 *
 * @package Promenade
 * @since 1.0.0
 */

$post_type_object = get_post_type_object( 'audiotheme_gig' );
?>

<div class="archive-intro">
	<p>
		<?php if ( current_user_can( 'publish_posts' ) ) : ?>

			<?php
			printf( _x( 'Ready to publish your next %1$s? <a href="%2$s">Get started here</a>.', 'post type label; add post type link', 'promenade' ),
				esc_html( strtolower( $post_type_object->labels->singular_name ) ),
				esc_url( add_query_arg( 'post_type', $post_type_object->name, admin_url( 'post-new.php' ) ) )
			);
			?>

		<?php else : ?>

			<?php _e( "There currently aren't any scheduled shows. Check back soon!", 'promenade' ); ?>

		<?php endif; ?>
	</p>
</div>

<?php
$recent_gigs = new Audiotheme_Gig_Query( array(
	'order'          => 'desc',
	'posts_per_page' => 5,
	'meta_query'     => array(
		array(
			'key'     => '_audiotheme_gig_datetime',
			'value'   => current_time( 'mysql' ),
			'compare' => '<=',
			'type'    => 'DATETIME',
		),
	),
) );

if ( $recent_gigs->have_posts() ) :
	printf( '<h2>%s</h2>', __( 'Recent Shows', 'promenade' ) );

	while ( $recent_gigs->have_posts() ) : $recent_gigs->the_post();

		get_template_part( 'audiotheme/parts/gig-card' );

	endwhile;
endif;
