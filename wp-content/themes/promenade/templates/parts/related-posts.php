<?php
/**
 * The template part for displaying a related posts section.
 *
 * Loaded by promenade_related_posts() in includes/template-tags.php.
 *
 * @package Promenade
 * @since 1.0.0
 */
?>

<section class="related-posts content-stretch-wide">
	<header class="related-posts-header">
		<h4 class="related-posts-title">
			<?php
			printf( _x( 'More %s', 'related posts title', 'promenade' ),
				esc_html( promenade_get_archive_title( $post->ID ) )
			);
			?>
		</h4>
	</header>

	<ul class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

			<li id="post-<?php the_ID(); ?>" class="block-grid-item">
				<?php
				printf( '<a class="block-grid-item-thumbnail" href="%s">%s</a>',
					esc_url( get_permalink() ),
					get_the_post_thumbnail()
				);
				?>

				<?php the_title( '<h3 class="block-grid-item-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
			</li>

		<?php endwhile; wp_reset_postdata(); ?>

	</ul>
</section>
