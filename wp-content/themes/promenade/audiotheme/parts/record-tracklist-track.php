<?php
/**
 * The template for displaying a track list in a single track template.
 *
 * @package Promenade
 * @since 1.0.0
 */
?>

<div class="tracklist-section tracklist-section--track">
	<ol class="tracklist">
		<li id="track-<?php the_ID(); ?>" class="track">
			<?php the_title( '<span class="track-title" itemprop="name">', '</span>' ); ?>

			<meta content="<?php the_permalink(); ?>" itemprop="url" />

			<span class="track-meta">
				<span class="track-current-time">-:--</span>
				<span class="track-sep-duration"> / </span>
				<span class="track-duration"><?php promenade_audiotheme_track_length(); ?></span>
			</span>

			<div class="track-progress"><div class="track-seek-bar"><div class="track-play-bar"></div></div></div>
		</li>

		<?php enqueue_audiotheme_tracks( get_the_ID(), 'record' ); ?>
	</ol>
</div>
