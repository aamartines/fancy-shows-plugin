<?php
/**
 * The template for displaying meta information about a track.
 *
 * @package Promenade
 * @since 1.0.0
 */
?>

<?php if ( $thumbnail_id = get_audiotheme_track_thumbnail_id() ) : ?>

	<p class="entry-thumbnail">
		<a href="<?php echo esc_url( wp_get_attachment_url( $thumbnail_id ) ); ?>" target="_blank">
			<?php echo wp_get_attachment_image( $thumbnail_id, 'post-thumbnail' ); ?>
		</a>
	</p>

<?php endif; ?>

<?php if ( get_audiotheme_track_purchase_url() || is_audiotheme_track_downloadable() ) : ?>

	<div class="meta-links">
		<ul>
			<?php if ( $purchase_url = get_audiotheme_track_purchase_url() ) : ?>

				<li>
					<?php
					printf( '<a class="button button-alt button-large js-maybe-external" href="%1$s" itemprop="url">%2$s</a>',
						esc_url( $purchase_url ),
						__( 'Purchase', 'promenade' )
					);
					?>
				</li>

			<?php endif; ?>

			<?php if ( $download_url = is_audiotheme_track_downloadable() ) : ?>

				<li>
					<?php
					printf( '<a class="button button-alt button-large" href="%1$s" download="%2$s">%3$s</a>',
						esc_url( $download_url ),
						esc_attr( basename( $download_url ) ),
						__( 'Download', 'promenade' )
					);
					?>
				</li>

			<?php endif; ?>
		</ul>
	</div>

<?php
endif;
