/*global _promenadeSettings:false, AudiothemeTracks:false */

window.cue = window.cue || {};
window.promenade = window.promenade || {};

(function( window, $, undefined ) {
	'use strict';

	var cue = window.cue,
		promenade = window.promenade;

	// Localize jquery.cue.js.
	cue.l10n = $.extend( cue.l10n, _promenadeSettings.l10n );

	$.extend( promenade, {
		config: {
			player: {
				cueSkin: 'promenade-playbar',
				features: [
					'cueprevioustrack',
					'playpause',
					'cuenexttrack',
					'cuecurrentdetails',
					'cueplaylist',
					'progress'
				],
				pluginPath: _promenadeSettings.mejs.pluginPath
			},
			tracklist: {
				cueSkin: 'promenade-tracklist',
				cueSelectors: {
					playlist: '.tracklist-section',
					track: '.track',
					trackCurrentTime: '.track-current-time',
					trackDuration: '.track-duration',
					trackPlayBar: '.track-play-bar',
					trackProgressBar: '.track-progress',
					trackSeekBar: '.track-seek-bar'
				},
				features: ['cueplaylist'],
				pluginPath: _promenadeSettings.mejs.pluginPath
			}
		},

		init: function() {
			$( 'body' ).addClass( 'ontouchstart' in window || 'onmsgesturechange' in window ? 'touch' : 'no-touch' );

			$( '.featured-content .block-grid-item, .widget-area--home .block-grid-item' ).blockGrid({
				minWidth: 801
			});

			// Open external links in a new window.
			$( '.js-maybe-external' ).each(function() {
				if ( this.hostname && this.hostname !== window.location.hostname ) {
					$( this ).attr( 'target', '_blank' );
				}
			});

			// Open a popup window for links with a "js-popup" class.
			$( '.js-popup' ).on( 'click.promenade', function( e ) {
				var $this = $( this ),
					popupId = $this.data( 'popup-id' ) || 'popup',
					popupUrl = $this.data( 'popup-url' ) || $this.attr( 'href' ),
					popupWidth = $this.data( 'popup-width' ) || 550,
					popupHeight = $this.data( 'popup-height' ) || 260;

				e.preventDefault();

				window.open( popupUrl, popupId, [
					'width=' + popupWidth,
					'height=' + popupHeight,
					'directories=no',
					'location=no',
					'menubar=no',
					'scrollbars=no',
					'status=no',
					'toolbar=no'
				].join( ',' ) );
			});

			// Toggle add to calendar link visibility.
			$( '.meta-links--subscribe .button' ).on( 'click.promenade', function() {
				$( this ).toggleClass( 'is-active' ).next().slideToggle( 'fast' );
			});
		},

		/**
		 * Set up the main navigation.
		 */
		setupNavigation: function() {
			var blurTimeout,
				$navigation = $( '.site-navigation' ),
				$menu = $navigation.find( '.menu' ),
				$toggleButton = $( '.site-navigation-toggle' );

			// Append sub-menu toggle elements.
			$menu.find( 'ul' ).parent().children( 'a' ).append( '<button class="sub-menu-toggle"></button>' );

			// Toggle the main menu.
			$toggleButton.on( 'click', function() {
				$navigation.toggleClass( 'is-open' );
			});

			// Toggle sub-menus.
			$menu.on( 'mouseenter', 'li', function( e ) {
				// https://davidwalsh.name/ios-hover-menu-fix
				if ( 'touchstart' === e.type ) {
					e.stopImmediatePropagation();
					e.preventDefault();
				}

				$( this ).addClass( 'is-active' ).addClass(function() {
					return $toggleButton.is( ':visible' ) ? '' : 'is-sub-menu-open';
				});
			}).on( 'mouseleave', 'li', function() {
				$( this ).removeClass( 'is-active' ).removeClass(function() {
					return $toggleButton.is( ':visible' ) ? '' : 'is-sub-menu-open';
				});
			}).on( 'focus', 'a', function() {
				var $this = $( this ),
					$parents = $( this ).parents( 'li' );

				$parents.addClass( 'is-active' );

				// Open the top-level menu item when focused if the toggle button isn't visible.
				if ( $this.parent().hasClass( 'menu-item-has-children' ) && ! $this.children( '.sub-menu-toggle' ).is( ':visible' ) ) {
					$parents.last().addClass( 'is-sub-menu-open' );
				}
			}).on( 'blur', 'a', function() {
				clearTimeout( blurTimeout );

				// Hack to grab the activeElement after the blur event has been processed.
				blurTimeout = setTimeout(function() {
					var $parents = $( document.activeElement ).parents( 'li' );
					$menu.find( 'li' ).not( $parents ).removeClass( 'is-active is-sub-menu-open' );
				}, 1 );
			}).on( 'click', '.sub-menu-toggle', function( e ) {
				e.preventDefault();
				$( this ).closest( 'li' ).toggleClass( 'is-sub-menu-open' );
			});
		},

		/**
		 * Initialize the theme player and playlist.
		 */
		setupPlayer: function() {
			if ( $.isFunction( $.fn.cuePlaylist ) ) {
				$( '.promenade-player' ).cuePlaylist( this.config.player )
					.find( '.promenade-player-playlist-toggle button' ).on( 'click', function() {
						$( '.promenade-player-playlist' ).slideToggle( 200 );
					});
			}
		},

		setupTracklist: function() {
			var $tracklist = $( '.tracklist-section' );

			if ( $tracklist.length && $.isFunction( $.fn.cuePlaylist ) ) {
				$tracklist.cuePlaylist( $.extend( this.config.tracklist, {
					cuePlaylistTracks: AudiothemeTracks.record
				}));
			}
		},

		/**
		 * Set up videos.
		 *
		 * - Makes videos responsive.
		 * - Moves videos embedded in page content to an '.entry-video'
		 *   container. Used primarily with the WPCOM single video templates.
		 */
		setupVideos: function() {
			$( '.hentry' ).fitVids();
			$( 'body.page' ).find( '.single-video' ).find( '.fluid-width-video-wrapper' ).first().appendTo( '.entry-video' );
		}
	});

	// Document ready.
	jQuery(function() {
		promenade.init();
		promenade.setupNavigation();
		promenade.setupPlayer();
		promenade.setupTracklist();
		promenade.setupVideos();
	});

})( this, jQuery );
