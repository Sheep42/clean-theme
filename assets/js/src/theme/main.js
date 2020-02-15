(function( $ ) {

	// Variables and DOM Caching.
	var $body = $( 'body' ),
		$navigation = $body.find( '.navigation-top' ),
		$navWrap = $navigation.find( '.wrap' ),
		$navMenuItem = $navigation.find( '.menu-item' ),
		$menuToggle = $navigation.find( '.menu-toggle' ),
		$entryContent = $body.find( '.entry-content' ),
		isFrontPage = $body.hasClass( 'cleantheme-front-page' ) || $body.hasClass( 'home blog' );

	/**
	 * Test if an iOS device.
	 * 
	*/
	function checkiOS() {
		return /iPad|iPhone|iPod/.test(navigator.userAgent) && ! window.MSStream;
	}

	// DOM ready.
	// $( document ).ready( function() { });

	// Window Load
	// $( window ).load( function() { });

	// Window Scroll
	// $( window ).on( 'scroll', function() { });
	
	// Window Resize
	// $( window ).resize( function() { });

})( jQuery );
