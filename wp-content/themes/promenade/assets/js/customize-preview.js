/*global wp:false */

(function( $, wp ) {
	'use strict';

	// Site title
	wp.customize( 'blogname', function( value ) {
		var $siteTitle = $( '.site-title a' );
		value.bind(function( to ) {
			$siteTitle.text( to );
		});
	});

})( jQuery, wp );
