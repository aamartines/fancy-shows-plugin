<?php
/**
 * The template part for displaying the front page player.
 *
 * @package Promenade
 * @since 1.0.0
 */
?>

<div class="promenade-player">
	<div class="promenade-player-inside">
		<audio src="<?php echo esc_url( $settings['tracks'][0]['src'] ); ?>" controls preload="none" style="width: 100%; height: auto"></audio>

		<div class="promenade-player-playlist-toggle">
			<?php
			$toggle_text = __( 'Playlist', 'promenade' );
			printf( '<button type="button" title="%1$s" aria-label="%1$s"></button>', esc_attr( $toggle_text ) );
			?>
		</div>
	</div>

	<div class="promenade-player-playlist">
		<ol class="promenade-player-playlist-tracks cue-tracks">

			<?php foreach ( $settings['tracks'] as $track ) : ?>

				<li class="cue-track" itemprop="track" itemscope itemtype="http://schema.org/MusicRecording">
					<div class="page-fence">
						<?php do_action( 'promenade_player_track_top', $track ); ?>

						<span class="cue-track-details cue-track-cell">
							<span class="cue-track-title" itemprop="name"><?php echo esc_html( $track['title'] ); ?></span>
							<span class="cue-track-artist" itemprop="byArtist"><?php echo esc_html( $track['meta']['artist'] ); ?></span>
						</span>

						<span class="cue-track-length cue-track-cell"><?php echo esc_html( $track['meta']['length_formatted'] ); ?></span>

						<?php do_action( 'promenade_player_track_bottom', $track ); ?>
					</div>
				</li>

			<?php endforeach; ?>

		</ol>

		<script type="application/json"><?php echo json_encode( $settings ); ?></script>
	</div>
</div>
