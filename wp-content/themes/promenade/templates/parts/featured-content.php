<?php
/**
 * The template part for displaying featured content.
 *
 * @package Promenade
 * @since 1.0.0
 */

$featured_posts = promenade_get_featured_posts();
$featured_posts_count = count( $featured_posts );
?>

<section class="featured-content" id="featured-content">
	<div class="featured-content-inside">

		<?php do_action( 'promenade_featured_posts_before' ); ?>

		<?php
		// Setup first post's post data.
		$post = $featured_posts[0];
		setup_postdata( $post );

		get_template_part( 'templates/parts/featured-post', 'hero' );

		// Unset first post and reset post data.
		unset( $featured_posts[0] );
		wp_reset_postdata();
		?>

		<?php if ( $featured_posts_count > 1 ) : ?>

			<ul class="block-grid block-grid-3">

				<?php foreach ( (array) $featured_posts as $order => $post ) : setup_postdata( $post ); ?>

					<?php get_template_part( 'templates/parts/featured-post' ); ?>

				<?php endforeach; ?>

			</ul>

		<?php endif; ?>

		<?php do_action( 'promenade_featured_posts_after' ); ?>

		<?php wp_reset_postdata(); ?>

	</div>
</section>
