<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! is_admin() ) { add_action( 'wp_enqueue_scripts', 'woothemes_add_javascript' ); }

if ( ! function_exists( 'woothemes_add_javascript' ) ) {
	function woothemes_add_javascript() {
		global $woo_options;

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		// Register scripts
		wp_register_script( 'prettyPhoto', get_template_directory_uri() . '/includes/js/jquery.prettyPhoto' . $suffix . '.js', array( 'jquery' ), '3.1.3' );
		wp_register_script( 'enable-lightbox', get_template_directory_uri() . '/includes/js/enable-lightbox.js', array( 'jquery', 'prettyPhoto' ) );
		wp_register_script( 'google-maps', 'http://maps.google.com/maps/api/js?sensor=false' );
		wp_register_script( 'google-maps-markers', get_template_directory_uri() . '/includes/js/markers.js' );
		wp_register_script( 'flexslider', get_template_directory_uri() . '/includes/js/jquery.flexslider' . $suffix . '.js', array( 'jquery' ), '2.1' );
		wp_register_script( 'featured-slider', get_template_directory_uri() . '/includes/js/featured-slider.js', array( 'jquery' , 'flexslider' ) );
		wp_register_script( 'masonry', get_template_directory_uri() . '/includes/js/jquery.masonry' . $suffix . '.js', array( 'jquery' ), '3.0.1' );
		wp_register_script( 'full-screen-images', get_template_directory_uri() . '/includes/js/jquery.fullscreen-images' . $suffix . '.js', array( 'jquery' ), '3.0.1' );
		wp_register_script( 'fire-masonry', get_template_directory_uri() . '/includes/js/jquery.masonry.fire' . $suffix . '.js', array( 'jquery' ), '1.0' );
		wp_register_script( 'jquery-cookie', get_template_directory_uri() . '/includes/js/jquery.cookie' . $suffix . '.js', array( 'jquery' ), '1.4.0' );

		// Enqueue third party scripts
		wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/includes/js/fitvids' . $suffix . '.js', array( 'jquery' ), '1.0' );
		wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/includes/js/modernizr' . $suffix . '.js', array( 'jquery' ), '2.6.2' );
		wp_enqueue_script( 'doubleTapToGo', get_template_directory_uri() . '/includes/js/jquery.doubleTapToGo' . $suffix . '.js', array( 'jquery' ), '1.0' );
		wp_enqueue_script( 'tipTip', get_template_directory_uri() . '/includes/js/jquery.tipTip' . $suffix . '.js', array( 'jquery' ), '1.3' );

		if ( is_post_type_archive( 'post' ) || is_archive() || is_tag() || is_author() || is_page_template( 'template-blog.php' ) || is_page_template( 'template-business.php' ) || is_category() ) {
			wp_enqueue_script( 'masonry' );
			wp_enqueue_script( 'fire-masonry' );
		} elseif ( is_woocommerce_activated() ) {
			if ( is_woocommerce() || is_cart() ) {
				wp_enqueue_script( 'masonry' );
				wp_enqueue_script( 'fire-masonry' );
			}
		}

		if ( 'fullscreen' == $woo_options['woo_homepage_image_format'] && is_home() ) {
			wp_enqueue_script( 'full-screen-images' );
		}

		// Enqueue scripts
		wp_enqueue_script( 'general', get_template_directory_uri() . '/includes/js/general.js', array( 'jquery' ) );

		// Load Google Script on Contact Form Page Template
		if ( is_page_template( 'template-contact.php' ) ) {
			wp_enqueue_script( 'google-maps' );
			wp_enqueue_script( 'google-maps-markers' );
		} // End If Statement

		if ( is_home() ) {
			wp_enqueue_script( 'jquery-cookie' );
		}

		do_action( 'woothemes_add_javascript' );
	} // End woothemes_add_javascript()
}

if ( ! is_admin() ) { add_action( 'wp_print_styles', 'woothemes_add_css' ); }

if ( ! function_exists( 'woothemes_add_css' ) ) {
	function woothemes_add_css () {
		wp_register_style( 'prettyPhoto', get_template_directory_uri().'/includes/css/prettyPhoto.css' );

		do_action( 'woothemes_add_css' );
	} // End woothemes_add_css()
}

// Add an HTML5 Shim
add_action( 'wp_head', 'html5_shim' );

if ( ! function_exists( 'html5_shim' ) ) {
	function html5_shim() {
		?>
<!--[if lt IE 9]>
<script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
		<?php
	} // End html5_shim()
}

add_action( 'woothemes_add_javascript' , 'woo_load_featured_slider_js' );

function woo_load_featured_slider_js() {
	if ( is_home() ) {

		//Slider settings
		$settings = array(
					'featured_speed' 			=> apply_filters( 'upstart_homepage_slideshow_speed', '7' ),
					'featured_hover' 			=> 'true',
					'featured_action' 			=> 'true',
					'featured_touchswipe' 		=> 'true',
					'featured_animation_speed' 	=> '0.6',
					'featured_pagination' 		=> 'false',
					'featured_nextprev' 		=> 'true',
					'featured_animation' 		=> 'fade'
					);

		$settings = woo_get_dynamic_values( $settings );

		if ( $settings['featured_speed'] == '0' ) { $slideshow = 'false'; } else { $slideshow = 'true'; }
		if ( 'true' == $settings['featured_touchswipe'] ) { $touchSwipe = 'true'; } else { $touchSwipe = 'false'; }
		if ( ! in_array( $settings['featured_animation'], array( 'fade', 'slide' ) ) ) { $settings['featured_animation'] = 'fade'; }
		$slideshowSpeed = (int) $settings['featured_speed'] * 1000; // milliseconds
		$animationSpeed = (int) $settings['featured_animation_speed'] * 1000; // milliseconds
		$manualControls = '';

		$data = array(
			'animation' 			=> $settings['featured_animation'],
			'controlsContainer' 	=> '.controls-container',
			'smoothHeight' 			=> 'true',
			'directionNav' 			=> 'true',
			'manualControls' 		=> $manualControls,
			'slideshow' 			=> apply_filters( 'maximize_homepage_slideshow', 'false' ),
			'pauseOnHover' 			=> false,
			'slideshowSpeed' 		=> $slideshowSpeed,
			'animationSpeed' 		=> $animationSpeed,
			'touch' 				=> $touchSwipe
		);

		wp_localize_script( 'featured-slider', 'woo_localized_data', $data);

		wp_enqueue_script( 'featured-slider' );
	} // End woo_load_featured_slider_js()
}
?>