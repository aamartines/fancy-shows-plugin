/**
 * Block Grid
 *
 * Original concept from CSS-Tricks:
 * http://css-tricks.com/equal-height-blocks-in-rows/
 *
 * @copyright Modifications Copyright (c) 2015 Cedaro, LLC
 * @license MIT
 */

(function (factory) {
    if ( 'function' === typeof define && define.amd ) {
        define( [ 'jquery' ], factory );
    } else if ( 'object' === typeof exports ) {
        module.exports = factory( require( 'jquery' ) );
    } else {
        factory( jQuery );
    }
}(function ( $ ) {
    var $window = $( window ),
		groups = [];

	function resizeItems() {
		if ( ! groups.length ) {
			return;
		}

		if ( window.requestAnimationFrame ) {
			requestAnimationFrame( updateGroups );
		} else {
			updateGroups();
		}
	}

	function setGroupHeights( group ) {
		var currentTallest = 0,
			currentRowStart = 0,
			$rowItems = $();

		group.$items.css( 'height', 'auto' );

		if ( viewportWidth() < group.settings.minWidth ) {
			return;
		}

		group.$items.each(function() {
			var $item = $( this );

			if ( $item.position().top !== currentRowStart ) {
				// We just came to a new row.
				// Set all the heights on the completed row.
				$rowItems.height( currentTallest );

				// Set the variables for the new row.
				currentRowStart = $item.position().top;
				currentTallest = $item.height();
				$rowItems = $item; // Reset the group.
			} else {
				// Another div on the current row.
				// Add it to the list and check if it's taller.
				$rowItems = $rowItems.add( $item );
				currentTallest = Math.max( currentTallest, $item.height() );
			}

			$rowItems.height( currentTallest );
		});
	}

	function throttle( handler, threshold ) {
		var callback, timeoutId,
			doCallback = true;

		return function() {
			if ( doCallback ) {
				doCallback = false;
				timeoutId = setTimeout( function() {
					handler();
					doCallback = true;
				}, threshold );
			}
		};
	}

	function updateGroups() {
		var i;
		for ( i = 0; i < groups.length; ++i ) {
			setGroupHeights( groups[ i ] );
		}
	}

	function viewportWidth() {
		return window.innerWidth || $window.width();
	}

	$window.on( 'load orientationchange', resizeItems )
	       .on( 'resize', throttle( resizeItems, 250 ) );

	$.fn.blockGrid = function( options ) {
		var group = {
				$items: $( this ),
				settings: $.extend({
					minWidth: 0
				}, options )
			};

		groups.push( group );
		setGroupHeights( group );

		return this;
	};
}));
