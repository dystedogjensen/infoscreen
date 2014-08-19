jQuery(window).load(function($){

	var windowHeight		= jQuery(window).height();
	var contentHeight		= jQuery( "#wrapper" ).height();
	var windowWidth			= jQuery(window).width();
	var slideImageWidth		= jQuery( '.home .slide-image' ).width();

	// Offset the image on handheld devices
	if ( jQuery(window).width() <= 320 && jQuery(window).height() >= 480 ) {
		// It's an iPhone (portrait)
		jQuery( '.home .slide-image' ).css( "margin-left", -windowWidth / 2 );
	}
	jQuery( '.home .slide-media, .home .slide-video' ).css( "width", windowWidth );
	jQuery( '.home .slide-media, .home .slide-video' ).css( "height", windowHeight );

});

// On window resize (when the browser window is resized)
jQuery(window).resize(function($){
	var windowHeight		= jQuery(window).height();
	var contentHeight		= jQuery( "#wrapper" ).height();
	var windowWidth			= jQuery(window).width();
	var siteHeaderHeight	= jQuery( ".site-header" ).height();
	var slideImageWidth		= jQuery( '.home .slide-image' ).width();

	// Set the image dimensions in the homepage slider
	if (jQuery(window).width() > 768) {
		jQuery( '.home .slide-image' ).css( {height:windowHeight, width:windowWidth} );
	}
	jQuery( '.home .fluid-width-video-wrapper iframe' ).css( {height:windowHeight, width:windowWidth} );
	jQuery( '.home .fluid-width-video-wrapper' ).css( "padding-top", windowHeight );

	// Offset the image on handheld devices
	if ( jQuery(window).width() <= 320 && jQuery(window).height() >= 480 ) {
		// It's an iPhone (portrait)
		jQuery( '.home .slide-image' ).css( "margin-left", -windowWidth/2 );
	}
	jQuery( '.home .slide-media, .home .slide-video' ).css( "width", windowWidth );
	jQuery( '.home .slide-media, .home .slide-video' ).css( "height", windowHeight );

});

// On document ready (once the html document has been loaded)
jQuery(document).ready(function($){
	var siteHeaderHeight	= jQuery( ".site-header" ).height();
	var slideImageWidth		= jQuery( '.home .slide-image' ).width();

	// Homepage slider img dimensions
	var windowHeight	= jQuery(window).height();
	var windowWidth		= jQuery(window).width();
	if (jQuery(window).width() > 768) {
		jQuery( '.home .slide-image' ).css( {height:windowHeight, width:windowWidth} );
	}
	jQuery( '.home .fluid-width-video-wrapper iframe' ).css( {height:windowHeight, width:windowWidth} );
	jQuery( '.home .fluid-width-video-wrapper' ).css( "padding-top", windowHeight );

});