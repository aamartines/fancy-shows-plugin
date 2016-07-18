/*!
 * Row Height
 *
 * Improved concept from CSS Tricks:
 * http://css-tricks.com/equal-height-blocks-in-rows/
 */
(function( window, $, undefined ) {
	var $all = $(),
		doSetHeight = true,
		setHeight;

	setHeight = function( $items ) {
		var currentTallest = 0,
			currentRowStart = 0,
			$rowItems = $();

		$items.each(function() {
			var $item = $( this );

			$item.css( 'height', 'auto' );

			if ( $item.position().top !== currentRowStart ) {
				// We just came to a new row. Set all the heights on the completed row.
				$rowItems.height( currentTallest );

				// Set the variables for the new row.
				currentRowStart = $item.position().top;
				currentTallest = $item.height();
				$rowItems = $item; // Reset the collection.
			} else {
				// Another div on the current row. Add it to the list and check if it's taller.
				$rowItems = $rowItems.add( $item );
				currentTallest = Math.max( currentTallest, $item.height() );
			}

			$rowItems.height( currentTallest );
		});
	};

	$( window ).on( 'load resize orientationchange', function( e ) {
		// Throttle resize events.
		if ( doSetHeight || 'resize' !== e.type ) {
			doSetHeight = false;
			setTimeout(function() {
				setHeight( $all );
				doSetHeight = true;
			}, 'resize' === e.type ? 500 : 0 );
		}
	});

	$.fn.rowHeight = function() {
		setHeight( this );
		$all = $all.add( this );
		return this;
	};
})( window, jQuery );
