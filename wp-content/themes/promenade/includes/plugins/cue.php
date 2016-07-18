<?php
/**
 * Cue integration.
 *
 * @package Promenade
 * @since 1.3.0
 * @link https://audiotheme.com/view/cue/
 */

/**
 * Register a player for Cue.
 *
 * @since 1.0.0
 *
 * @param array $players List of players.
 */
function promenade_register_cue_players( $players ) {
	$players['homepage'] = __( 'Homepage Player', 'promenade' );
	return $players;
}
add_filter( 'cue_players', 'promenade_register_cue_players' );

/**
 * Get Cue tracks.
 *
 * @since 1.3.0
 *
 * @param array $track List of tracks.
 */
function promenade_cue_player_tracks( $tracks ) {
	if ( function_exists( 'get_cue_player_tracks' ) ) {
		$tracks = get_cue_player_tracks( 'homepage', array( 'context' => 'wp-playlist' ) );
	}

	return $tracks;
}
add_filter( 'pre_player_attachment_ids_tracks', 'promenade_cue_player_tracks' );

/**
 * Display a purchase link in the player tracklist.
 *
 * @since 1.8.0
 *
 * @param array $track Track.
 */
function promenade_cue_player_track_actions( $track ) {
	if ( ! function_exists( 'cue_track_action_links' ) ) {
		return;
	}

	cue_track_action_links( $track );
}
add_action( 'promenade_player_track_bottom', 'promenade_cue_player_track_actions' );
