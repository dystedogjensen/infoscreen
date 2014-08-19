/*-----------------------------------------------------------------------------------*/
/* GENERAL SCRIPTS */
/*-----------------------------------------------------------------------------------*/
// On window load (after all elements (including images etc has loaded)).
jQuery(window).load(function($){

	var windowHeight		= jQuery(window).height();
	var contentHeight		= jQuery( "#wrapper" ).height();
	var windowWidth			= jQuery(window).width();

	// Set the navigation height on the homepage
	jQuery( '.home #navigation' ).css({height:windowHeight});

	// Set the navigation height on inner pages
	jQuery( '#inner #navigation' ).css({height:contentHeight});

	jQuery( '.home .fluid-width-video-wrapper iframe' ).css( {height:windowHeight, width:windowWidth} );
	jQuery( '.home .fluid-width-video-wrapper' ).css( "padding-top", windowHeight );

	jQuery( '.home .slide-media, .home .slide-video' ).css( "width", windowWidth );
	jQuery( '.home .slide-media, .home .slide-video' ).css( "height", windowHeight );

	jQuery( 'body.home #featured-slider' ).removeClass( 'loading' );
	jQuery( 'body.home' ).removeClass( 'loading' );

	if ( jQuery.cookie( 'history' ) != 'visited' ) {
		setTimeout(function(){
			jQuery( 'body.home' ).addClass( 'show-nav' );
		}, 0);
		setTimeout(function(){
			jQuery( 'body.home.show-nav' ).removeClass( 'show-nav' );
			jQuery( 'body.home .nav-toggle' ).toggleClass( 'active' );
		}, 2000);
	}
});


jQuery( 'body.home' ).ready( function() {
	// Set a cookie when the homepage has been visited so the nav-reveal action doesn't repeat.
	setTimeout(function(){
		jQuery.cookie( 'history', 'visited', { path: '/' } );
	}, 2000);
});


// On window resize (when the browser window is resized)
jQuery(window).resize(function($){
	var windowHeight		= jQuery(window).height();
	var contentHeight		= jQuery( "#wrapper" ).height();
	var windowWidth			= jQuery(window).width();
	var siteHeaderHeight	= jQuery( ".site-header" ).height();

	// Set the navigation height on the homepage
	jQuery( '.home #navigation' ).css({height:windowHeight});

	// Set the navigation height on inner pages
	jQuery( '#inner #navigation' ).css({height:contentHeight});

	jQuery( '.home .fluid-width-video-wrapper iframe' ).css( {height:windowHeight, width:windowWidth} );
	jQuery( '.home .fluid-width-video-wrapper' ).css( "padding-top", windowHeight );

	jQuery( '.home .slide-media, .home .slide-video' ).css( "width", windowWidth );
	jQuery( '.home .slide-media, .home .slide-video' ).css( "height", windowHeight );

	// Set the #content padding according to the height of the site header
	if (jQuery(window).width() < 768) {
		jQuery( '#content' ).css( "padding-top", siteHeaderHeight );
	}

	// Set the sidebar padding according to the height of the site header
	if (jQuery(window).width() >= 768) {
		jQuery( '#sidebar' ).css( "padding-top", siteHeaderHeight );
		jQuery( '#content' ).css( "padding-top", '0' );
	}
});

// On document ready (once the html document has been loaded)
jQuery(document).ready(function($){
	var siteHeaderHeight	= jQuery( ".site-header" ).height();
	var windowHeight		= jQuery(window).height();
	var windowWidth			= jQuery(window).width();

	jQuery( 'body.home' ).addClass( 'loading' );

	// Set the #content padding according to the height of the site header
	if (jQuery(window).width() < 768) {
		jQuery( '#content' ).css( "padding-top", siteHeaderHeight );
	}

	// Set the sidebar padding according to the height of the site header
	if (jQuery(window).width() >= 768) {
		jQuery( '#sidebar' ).css( "padding-top", siteHeaderHeight );
	}

	// Table alt row styling
	jQuery( '.entry table tr:odd' ).addClass( 'alt-table-row' );

	// FitVids - Responsive Videos
	jQuery( '.post, .widget, .panel, .page, #featured-slider .slide-media' ).fitVids();

	// Add class to parent menu items with JS until WP does this natively
	jQuery( 'ul.sub-menu, ul.children' ).parents( 'li' ).addClass( 'parent' );

	// Homepage slider img dimensions
	jQuery( '.home .fluid-width-video-wrapper iframe' ).css( {height:windowHeight, width:windowWidth} );
	jQuery( '.home .fluid-width-video-wrapper' ).css( "padding-top", windowHeight );

	// Fire tipTip
	jQuery(function(){
		jQuery( '.star-rating' ).tipTip({
			defaultPosition: 'top',
			delay: 100,
			edgeOffset: 31
		});
	});

	// Reveal the slide content on the homepage
	jQuery( 'body.home .slide-content, body.home .site-header' ).addClass( 'animated bounceInLeft' );

	// Animate WooCommerce messages
	jQuery( '.woocommerce-message, .woocommerce-info, .woocommerce-error' ).addClass( 'animated flash' );


	/**
	 * Navigation
	 */
	// Hide the search form in the header
	jQuery( '#header .widget_product_search' ).addClass( 'hidden' );

	// Toggle that class when .search-toggle is clicked
	jQuery( '.search-toggle' ).click(function(e) {

		// Prevent default behaviour
		e.preventDefault();

		// Toggle active class
		jQuery(this).toggleClass( 'active' );

		// Toggle the 'hidden' class
		jQuery( '#header .widget_product_search' ).toggleClass( 'visible' ).toggleClass( 'hidden' );
	});


	// Add the 'show-nav' class to the body when the nav toggle is clicked
	jQuery( '.nav-toggle' ).click(function(e) {

		// Prevent default behaviour
		e.preventDefault();

		// Toggle active class
		jQuery(this).toggleClass( 'active' );

		// Add the 'show-nav' class
		jQuery( 'body' ).toggleClass( 'show-nav' );

		// Check if .top-navigation already exists
		if ( jQuery( '#navigation' ).find( '.top-navigation' ).size() ) return;

		// If it doesn't, clone it (so it will still appear when resizing the browser window in desktop orientation) and add it.
		jQuery( '#top .top-navigation' ).clone().appendTo( '#navigation .menus' );
	});

	// Remove the 'show-nav' class from the body when the nav-close anchor is clicked
	jQuery('.nav-close').click(function(e) {

		// Prevent default behaviour
		e.preventDefault();

		// Remove the 'show-nav' class
		jQuery( 'body' ).removeClass( 'show-nav' );

		// Remove the active class from the nav toggle
		jQuery( '.nav-toggle' ).toggleClass( 'active' );
	});

	// Remove 'show-nav' class from the body when user tabs outside of #navigation on handheld devices
	var hasParent = function(el, id) {
        if (el) {
            do {
                if (el.id === id) {
                    return true;
                }
                if (el.nodeType === 9) {
                    break;
                }
            }
            while((el = el.parentNode));
        }
        return false;
    };
	if (jQuery(window).width() < 767) {
		if (jQuery('body')[0].addEventListener){
			document.addEventListener('touchstart', function(e) {
			if ( jQuery( 'body' ).hasClass( 'show-nav' ) && !hasParent( e.target, 'navigation' ) ) {
				// Prevent default behaviour
				e.preventDefault();

				// Remove the 'show-nav' class
				jQuery( 'body' ).removeClass( 'show-nav' );
			}
		}, false);
		} else if (jQuery('body')[0].attachEvent){
			document.attachEvent('ontouchstart', function(e) {
			if ( jQuery( 'body' ).hasClass( 'show-nav' ) && !hasParent( e.target, 'navigation' ) ) {
				// Prevent default behaviour
				e.preventDefault();

				// Remove the 'show-nav' class
				jQuery( 'body' ).removeClass( 'show-nav' );
			}
		});
		}
	}

	// Fix dropdowns in Android
	jQuery( '.nav li:has(ul)' ).doubleTapToGo();

	// Back to top
	jQuery(function () {
        jQuery( '.back-to-top' ).click(function () {
            jQuery( 'body,html' ).animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    });
    $(window).scroll(function() {
        if ( $(this).scrollTop() > 200 ) {
            $( '.back-to-top' ).fadeIn();
        } else {
            $( '.back-to-top' ).fadeOut();
        }
    });

});