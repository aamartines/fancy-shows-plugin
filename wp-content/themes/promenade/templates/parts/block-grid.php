<?php
/**
 * The template part for displaying a block grids, usually on media centric
 * archive pages (e.g. video, audio, portfolio, etc.)
 *
 * Loaded by promenade_block_grid() in includes/template-tags.php.
 *
 * @package Promenade
 * @since 1.0.0
 */
?>

<ul class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

	<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

		<li class="block-grid-item">
			<?php
			printf( '<a class="block-grid-item-thumbnail" href="%s">%s</a>',
				esc_url( get_permalink() ),
				get_the_post_thumbnail()
			);
			?>

			<h2 class="block-grid-item-title">
				<?php the_title( '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a>' ); ?>
				<?php edit_post_link( __( 'Edit', 'promenade' ) ); ?>
			</h2>
		</li>

	<?php endwhile; wp_reset_postdata(); ?>

</ul>
