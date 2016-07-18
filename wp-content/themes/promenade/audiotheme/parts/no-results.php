<?php
/**
 * The template for displaying a message that posts cannot be found.
 *
 * @package Promenade
 * @since 1.0.0
 */
?>

<div class="archive-intro">
	<?php
	$post_type        = get_post_type() ? get_post_type() : get_query_var( 'post_type' );
	$post_type_object = get_post_type_object( $post_type );

	if ( empty( $post_type_object ) && is_tax() ) {
		$taxonomy = get_taxonomy( get_queried_object()->taxonomy );
		$post_type_object = get_post_type_object( $taxonomy->object_type[0] );
	}
	?>

	<?php if ( current_user_can( 'publish_posts' ) ) : ?>

		<p>
			<?php
			printf( _x( 'Ready to publish your first %1$s? <a href="%2$s">Get started here</a>.', 'post type label; add post type link', 'promenade' ),
				esc_html( strtolower( $post_type_object->labels->singular_name ) ),
				esc_url( add_query_arg( 'post_type', $post_type_object->name, admin_url( 'post-new.php' ) ) )
			);
			?>
		</p>

	<?php else : ?>

		<p>
			<?php
			printf( _x( 'There currently aren\'t any %s available.', 'post type label', 'promenade' ),
				esc_html( strtolower( $post_type_object->label ) )
			);
			?>
		</p>

	<?php endif; ?>
</div>
