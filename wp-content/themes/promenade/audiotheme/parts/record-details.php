<?php
/**
 * The template used for displaying details about a record.
 *
 * @package Promenade
 * @since 1.0.0
 */
?>

<dl class="record-details">
	<?php
	if ( is_singular( array( 'audiotheme_track' ) ) ) {
		$id     = $post->post_parent;
		$artist = get_audiotheme_track_artist();
	} else {
		$id     = get_the_ID();
		$artist = get_audiotheme_record_artist();
	};
	?>

	<?php if ( $artist ) : ?>

		<dt class="record-artist"><?php _e( 'Artist', 'promenade' ); ?></dt>
		<dd class="record-artist" itemprop="byArtist" itemscope itemtype="http://schema.org/MusicGroup"><span itemprop="name"><?php echo esc_html( $artist ); ?></span></dd>

	<?php endif; ?>

	<?php if ( $year = get_audiotheme_record_release_year( $id ) ) : ?>

		<dt class="record-release"><?php _e( 'Released', 'promenade' ); ?></dt>
		<dd class="record-release" itemprop="dateCreated"><?php echo esc_html( $year ); ?></dd>

	<?php endif; ?>

	<?php if ( $genre = get_audiotheme_record_genre( $id ) ) : ?>

		<dt class="record-genre"><?php _e( 'Genre', 'promenade' ); ?></dt>
		<dd class="record-genre" itemprop="genre"><?php echo esc_html( $genre ); ?></dd>

	<?php endif; ?>
</dl>
