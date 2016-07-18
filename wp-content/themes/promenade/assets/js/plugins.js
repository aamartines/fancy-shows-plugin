/*global jQuery */
/*jshint browser:true */
/*!
* FitVids 1.1
*
* Copyright 2013, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
* Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
* Released under the WTFPL license - http://sam.zoy.org/wtfpl/
*
*/

(function( $ ){

  "use strict";

  $.fn.fitVids = function( options ) {
    var settings = {
      customSelector: null
    };

    if(!document.getElementById('fit-vids-style')) {
      // appendStyles: https://github.com/toddmotto/fluidvids/blob/master/dist/fluidvids.js
      var head = document.head || document.getElementsByTagName('head')[0];
      var css = '.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}';
      var div = document.createElement('div');
      div.innerHTML = '<p>x</p><style id="fit-vids-style">' + css + '</style>';
      head.appendChild(div.childNodes[1]);
    }

    if ( options ) {
      $.extend( settings, options );
    }

    return this.each(function(){
      var selectors = [
        "iframe[src*='player.vimeo.com']",
        "iframe[src*='youtube.com']",
        "iframe[src*='youtube-nocookie.com']",
        "iframe[src*='kickstarter.com'][src*='video.html']",
        "object",
        "embed"
      ];

      if (settings.customSelector) {
        selectors.push(settings.customSelector);
      }

      var $allVideos = $(this).find(selectors.join(','));
      $allVideos = $allVideos.not("object object"); // SwfObj conflict patch

      $allVideos.each(function(){
        var $this = $(this);
        if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) { return; }
        var height = ( this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10))) ) ? parseInt($this.attr('height'), 10) : $this.height(),
            width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
            aspectRatio = height / width;
        if(!$this.attr('id')){
          var videoID = 'fitvid' + Math.floor(Math.random()*999999);
          $this.attr('id', videoID);
        }
        $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100)+"%");
        $this.removeAttr('height').removeAttr('width');
      });
    });
  };
// Works with either jQuery or Zepto
})( window.jQuery || window.Zepto );

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
