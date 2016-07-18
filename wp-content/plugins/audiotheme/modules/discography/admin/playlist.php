<?php
/**
 * Playlist-related admin functionality.
 *
 * Playlist functionality extends the Cue plugin.
 *
 * @package AudioTheme_Framework
 * @subpackage Discography
 * @link https://wordpress.org/plugins/cue/
 */

/**
 * Enqueue playlist scripts and styles.
 *
 * @since 1.5.0
 */
function audiotheme_playlist_admin_enqueue_scripts() {
	if ( 'cue_playlist' !== get_current_screen()->id ) {
		return;
	}

	wp_enqueue_style( 'modules/audiotheme-playlist-admin', AUDIOTHEME_URI . 'modules/discography/admin/css/playlist.css' );

	wp_enqueue_script(
		'audiotheme-playlist-admin',
		AUDIOTHEME_URI . 'modules/discography/admin/js/playlist.js',
		array( 'cue-admin' ),
		'1.0.0',
		true
	);

	wp_localize_script( 'audiotheme-playlist-admin', '_audiothemePlaylistSettings', array(
		'l10n' => array(
			'frameTitle'        => __( 'AudioTheme Tracks', 'audiotheme' ),
			'frameMenuItemText' => __( 'Add from AudioTheme', 'audiotheme' ),
			'frameButtonText'   => __( 'Add Tracks', 'audiotheme' ),
		),
	) );
}

/**
 * Print playlist JavaScript templates.
 *
 * @since 1.5.0
 */
function audiotheme_playlist_print_templates() {
	?>
	<script type="text/html" id="tmpl-audiotheme-playlist-record">
		<div class="audiotheme-playlist-record-header">
			<img src="{{ data.thumbnail }}">
			<h4 class="audiotheme-playlist-record-title"><em>{{ data.title }}</em> {{ data.artist }}</h4>
		</div>

		<ol class="audiotheme-playlist-record-tracks">
			<# _.each( data.tracks, function( track ) { #>
				<li class="audiotheme-playlist-record-track" data-id="{{ track.id }}">
					<span class="audiotheme-playlist-record-track-cell">
						{{{ track.title }}}
					</span>
				</li>
			<# }); #>
		</ol>
	</script>
	<?php
}

/**
 * Convert a track into the format expected by the Cue plugin.
 *
 * @since 1.5.0
 *
 * @param int|WP_Post $post Post object or ID.
 * @return object Track object expected by Cue.
 */
function get_audiotheme_playlist_track( $post = 0 ) {
	$post = get_post( $post );
	$track = new stdClass;

	$track->id = $post->ID;
	$track->artist = get_audiotheme_track_artist( $post->ID );
	$track->audioUrl = get_audiotheme_track_file_url( $post->ID );
	$track->title = get_the_title( $post->ID );

	if ( $thumbnail_id = get_audiotheme_track_thumbnail_id( $post->ID ) ) {
		$size = apply_filters( 'cue_artwork_size', array( 300, 300 ) );
		$image = image_downsize( $thumbnail_id, $size );

		$track->artworkUrl = $image[0];
	}

	return $track;
}
