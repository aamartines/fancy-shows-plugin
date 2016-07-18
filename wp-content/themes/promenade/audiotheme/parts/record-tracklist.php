<?php
/**
 * The template for displaying a track list.
 *
 * @package Promenade
 * @since 1.0.0
 */
?>

<?php if ( $tracks = get_audiotheme_record_tracks() ) : ?>

	<div class="tracklist-section">
		<meta content="<?php echo count( $tracks ); ?>" itemprop="numTracks" />

		<ol class="tracklist">

			<?php foreach ( $tracks as $track ) : ?>

				<li id="track-<?php echo absint( $track->ID ); ?>" class="track" itemprop="track" itemscope itemtype="http://schema.org/MusicRecording">
					<?php
					printf( '<a href="%s" itemprop="url" class="track-title"><span itemprop="name">%s</span></a>',
						esc_url( get_permalink( $track->ID ) ),
						get_the_title( $track->ID )
					);
					?>

					<span class="track-meta">
						<span class="track-current-time">-:--</span>
						<span class="track-sep-duration"> / </span>
						<span class="track-duration"><?php promenade_audiotheme_track_length( $track->ID ); ?></span>

						<?php
						if ( $download_url = is_audiotheme_track_downloadable( $track->ID ) ) :
							$text = __( 'Download', 'promenade' );

							printf( '<a class="track-download-link icon" href="%1$s" download="%2$s" title="%3$s"></a>',
								esc_url( $download_url ),
								esc_attr( basename( $download_url ) ),
								esc_attr( $text )
							);
						endif;
						?>
					</span>

					<div class="track-progress"><div class="track-seek-bar"><div class="track-play-bar"></div></div></div>
				</li>

			<?php endforeach; ?>

			<?php enqueue_audiotheme_tracks( wp_list_pluck( $tracks, 'ID' ), 'record' ); ?>
		</ol>
	</div>

<?php
endif;
