jQuery(window).load(function($){

	// Fire masonry
	if ( jQuery(window).width() <= 1280 ) {
		jQuery( '.has-masonry .loop-wrapper' ).masonry({
			columnWidth: 251,
			itemSelector: '.post',
			gutter: 31
		});
		jQuery( '.woocommerce ul.products' ).masonry({
			columnWidth: 251,
			itemSelector: '.product',
			gutter: 31
		});
		jQuery( '.masonry-wrap' ).masonry({
			columnWidth: 251,
			itemSelector: '.lesson',
			gutter: 31
		});
		jQuery( '.masonry-wrap-courses' ).masonry({
			columnWidth: 251,
			itemSelector: '.course',
			gutter: 31
		});
		jQuery( '.course-lessons' ).masonry({
			columnWidth: 251,
			itemSelector: '.lesson',
			gutter: 31
		});
		jQuery( '.page-template-template-business-php #main .widget_woothemes_testimonials .testimonials' ).masonry({
			columnWidth: 251,
			itemSelector: '.quote',
			gutter: 31
		});
		jQuery( '.page-template-template-business-php #main .widget_woothemes_features .features' ).masonry({
			columnWidth: 251,
			itemSelector: '.feature',
			gutter: 31
		});
	}
	if ( jQuery(window).width() > 1280 ) {
		jQuery( '.has-masonry .loop-wrapper' ).masonry({
			columnWidth: 308,
			itemSelector: '.post',
			gutter: 31
		});
		jQuery( '.woocommerce ul.products, .woocommerce-cart ul.products' ).masonry({
			columnWidth: 308,
			itemSelector: '.product',
			gutter: 31
		});
		jQuery( '.masonry-wrap' ).masonry({
			columnWidth: 308,
			itemSelector: '.lesson',
			gutter: 31
		});
		jQuery( '.masonry-wrap-courses' ).masonry({
			columnWidth: 308,
			itemSelector: '.course',
			gutter: 31
		});
		jQuery( '.course-lessons' ).masonry({
			columnWidth: 308,
			itemSelector: '.lesson',
			gutter: 31
		});
		jQuery( '.page-template-template-business-php #main .widget_woothemes_testimonials .testimonials' ).masonry({
			columnWidth: 308,
			itemSelector: '.quote',
			gutter: 31
		});
		jQuery( '.page-template-template-business-php #main .widget_woothemes_features .features' ).masonry({
			columnWidth: 308,
			itemSelector: '.feature',
			gutter: 31
		});
	}

	jQuery( '.has-masonry .format-gallery .gallery' ).masonry({
		columnWidth: '.gallery-item',
		itemSelector: '.gallery-item',
		gutter: 0
	});

});