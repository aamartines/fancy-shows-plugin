<?php
/**
 * The template for displaying meta information about a record.
 *
 * @package Promenade
 * @since 1.0.0
 */
?>

<?php if ( $thumbnail_id = get_post_thumbnail_id() ) : ?>

	<figure class="entry-thumbnail">
		<a href="<?php echo esc_url( wp_get_attachment_url( $thumbnail_id ) ); ?>" target="_blank">
			<?php the_post_thumbnail(); ?>
		</a>
	</figure>

<?php endif; ?>

<?php if ( $links = get_audiotheme_record_links() ) : ?>

	<div class="meta-links">
		<ul>
			<?php
			foreach ( $links as $link ) {
				printf( '<li><a href="%s" class="button button-alt button-large js-maybe-external" itemprop="offers">%s</a></li>',
					esc_url( $link['url'] ),
					esc_html( $link['name'] )
				);
			}
			?>
		</ul>
	</div>

<?php
endif;
