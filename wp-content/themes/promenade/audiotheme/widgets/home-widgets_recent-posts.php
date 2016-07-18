<?php
/**
 * Template to display a Recent Posts widget in the Home Widgets widget area.
 *
 * @package Promenade
 * @since 1.0.0
 */
?>

<div class="recent-posts-wrapper">
	<?php
	if ( ! empty( $title ) ) :
		echo $before_title . $title . $after_title;
	endif;
	?>

	<span class="recent-posts-links">
		<?php
		if ( $show_feed_link ) :
			printf( '<a class="recent-posts-feed-link" href="%s" title="%s"><i class="icon"></i></a>',
				esc_url( $feed_link ),
				__( 'Feed', 'promenade' )
			);
		endif;
		?>

		<?php
		printf( '<a class="recent-posts-archive-link" href="%s">%s</a>',
			esc_url( promenade_get_post_type_archive_link( $post_type ) ),
			esc_html( get_post_type_object( $post_type )->labels->all_items )
		);
		?>
	</span>

	<?php if ( $loop->have_posts() ) : ?>

		<?php
		$columns = promenade_get_mapped_column_number( $number );

		$classes = array(
			'block-grid',
			'block-grid-' . apply_filters( 'promenade_audiotheme_widget_recent_posts_columns', $columns ),
		);

		switch ( $post_type ) {
			case 'audiotheme_record':
				$classes[] = 'block-grid-thumbnails';
				break;

			case 'audiotheme_video':
				$classes[] = 'block-grid-thumbnails';
				$classes[] = 'block-grid-thumbnails--landscape';
				break;
		}

		$classes = array_unique( apply_filters( 'promenade_audiotheme_widget_recent_posts_classes', $classes ) );
		?>

		<ul class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

			<li class="block-grid-item">
				<?php
				if ( in_array( 'block-grid-thumbnails', $classes ) ) {
					printf( '<a class="block-grid-item-thumbnail" href="%s">%s</a>',
						esc_url( get_permalink() ),
						get_the_post_thumbnail()
					);
				}
				?>

				<?php the_title( '<h3 class="block-grid-item-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' ); ?>

				<?php
				if ( $show_date ) :
					if ( 'audiotheme_record' === get_post_type() ) :
						$date_html = '';

						if ( $release_year = get_audiotheme_record_release_year() ) :
							$date_html = sprintf( '<span class="published"><span class="prefix">%s</span> %s</span>',
								__( 'Released', 'promenade' ),
								$release_year
							);
						endif;
					else :
						$date_html = promenade_entry_date( false, false );
					endif;

					printf( '<div class="block-grid-item-date">%s</div>',
						apply_filters( 'audiotheme_widget_recent_posts_date_html', $date_html, $instance )
					);
				endif;
				?>

				<?php
				if ( $show_excerpts ) :
					$excerpt = wpautop( wp_html_excerpt( get_the_excerpt(), $excerpt_length, '&hellip;' ) );

					printf( '<div class="block-grid-item-excerpt">%s</div>',
						apply_filters( 'audiotheme_widget_recent_posts_excerpt', $excerpt, $loop->post, $instance )
					);
				endif;
				?>
			</li>

		<?php endwhile; ?>

		</ul>

	<?php endif; ?>
</div>
