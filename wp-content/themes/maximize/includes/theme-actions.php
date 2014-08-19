<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Theme Setup
- Load style.css in the <head>
- Load responsive <meta> tags in the <head>
- Add custom styling to HEAD
- Add custom typography to HEAD
- Add layout to body_class output
- woo_feedburner_link
- Optionally load custom logo.
- Add custom CSS class to the <body> tag if the lightbox option is enabled.
- Load PrettyPhoto JavaScript and CSS if the lightbox option is enabled.
- Customise the default search form
- Load responsive IE scripts
- Add masonry class to body tag if required
- Loop Wrapper
- Back to top
- Features
- Excerpt customisation
- Post Formats

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* Theme Setup */
/*-----------------------------------------------------------------------------------*/
/**
 * Theme Setup
 *
 * This is the general theme setup, where we add_theme_support(), create global variables
 * and setup default generic filters and actions to be used across our theme.
 *
 * @package WooFramework
 * @subpackage Logic
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */

if ( ! isset( $content_width ) ) $content_width = 640;

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support for post thumbnails.
 *
 * To override woothemes_setup() in a child theme, add your own woothemes_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for automatic feed links.
 * @uses add_editor_style() To style the visual editor.
 */

add_action( 'after_setup_theme', 'woothemes_setup' );

if ( ! function_exists( 'woothemes_setup' ) ) {
	function woothemes_setup () {
		// This theme styles the visual editor with editor-style.css to match the theme style.
		if ( locate_template( 'editor-style.css' ) != '' ) { add_editor_style(); }

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );
	} // End woothemes_setup()
}

/**
 * Set the default Google Fonts used in theme.
 *
 * Used to set the default Google Fonts used in the theme, when Custom Typography is disabled.
 */

global $default_google_fonts;
//$default_google_fonts = array( 'Lato' );


/*-----------------------------------------------------------------------------------*/
/* Load style.css and layout.css in the <head> */
/*-----------------------------------------------------------------------------------*/

if ( ! is_admin() ) { add_action( 'wp_enqueue_scripts', 'woo_load_frontend_css', 20 ); }

if ( ! function_exists( 'woo_load_frontend_css' ) ) {
	function woo_load_frontend_css () {
		global $woo_options;
		wp_register_style( 'theme-stylesheet', get_stylesheet_uri() );
		wp_register_style( 'woo-layout', get_template_directory_uri() . '/css/layout.css' );
		wp_enqueue_style( 'theme-stylesheet' );
		wp_enqueue_style( 'woo-layout' );
		wp_enqueue_style( 'lato', 'http://fonts.googleapis.com/css?family=Lato:300,400,700,400italic' );
	} // End woo_load_frontend_css()
}



/*-----------------------------------------------------------------------------------*/
/* Load responsive <meta> tags in the <head> */
/*-----------------------------------------------------------------------------------*/

add_action( 'wp_head', 'woo_load_responsive_meta_tags', 10 );

if ( ! function_exists( 'woo_load_responsive_meta_tags' ) ) {
	function woo_load_responsive_meta_tags () {
		$html = '';

		$html .= "\n" . '<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->' . "\n";
		$html .= '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />' . "\n";

		/* Remove this if not responsive design */
		$html .= "\n" . '<!--  Mobile viewport scale | Disable user zooming as the layout is optimised -->' . "\n";
		$html .= '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">' . "\n";

		echo $html;
	} // End woo_load_responsive_meta_tags()
}

/*-----------------------------------------------------------------------------------*/
/* Add Custom Styling to HEAD */
/*-----------------------------------------------------------------------------------*/

add_action( 'woo_head', 'woo_custom_styling', 10 ); // Add custom styling to HEAD

if ( ! function_exists( 'woo_custom_styling' ) ) {
	function woo_custom_styling() {

		$output = '';
		// Get options
		$settings = array(
						'body_color' => '',
						'body_img' => '',
						'body_repeat' => '',
						'body_pos' => '',
						'body_attachment' => '',
						'link_color' => '',
						'link_hover_color' => '',
						'button_color' => ''
						);
		$settings = woo_get_dynamic_values( $settings );

		// Type Check for Array
		if ( is_array($settings) ) {

			// Add CSS to output
			if ( $settings['body_color'] != '' ) {
				$output .= '#inner #wrapper { background: ' . $settings['body_color'] . ' !important; }' . "\n";
			}

			if ( $settings['body_img'] != '' ) {
				$body_image = $settings['body_img'];
				if ( is_ssl() ) { $body_image = str_replace( 'http://', 'https://', $body_image ); }
				$output .= '#inner #wrapper { background-image: url( ' . esc_url( $body_image ) . ' ) !important; }' . "\n";
			}

			if ( ( $settings['body_img'] != '' ) && ( $settings['body_repeat'] != '' ) && ( $settings['body_pos'] != '' ) ) {
				$output .= '#inner #wrapper { background-repeat: ' . $settings['body_repeat'] . ' !important; }' . "\n";
			}

			if ( ( $settings['body_img'] != '' ) && ( $settings['body_pos'] != '' ) ) {
				$output .= '#inner #wrapper { background-position: ' . $settings['body_pos'] . ' !important; }' . "\n";
			}

			if ( ( $settings['body_img'] != '' ) && ( $settings['body_attachment'] != '' ) ) {
				$output .= '#inner #wrapper { background-attachment: ' . $settings['body_attachment'] . ' !important; }' . "\n";
			}

			if ( $settings['link_color'] != '' ) {
				$output .= 'a { color: ' . $settings['link_color'] . ' !important; }' . "\n";
			}

			if ( $settings['link_hover_color'] != '' ) {
				$output .= 'a:hover, .post-more a:hover, .post-meta a:hover, .post p.tags a:hover { color: ' . $settings['link_hover_color'] . ' !important; }' . "\n";
			}

			if ( $settings['button_color'] != '' ) {
				$output .= 'a.button, a.comment-reply-link, #commentform #submit, #contact-page .submit { background: ' . $settings['button_color'] . ' !important; border-color: ' . $settings['button_color'] . ' !important; }' . "\n";
				$output .= 'a.button:hover, a.button.hover, a.button.active, a.comment-reply-link:hover, #commentform #submit:hover, #contact-page .submit:hover { background: ' . $settings['button_color'] . ' !important; opacity: 0.9; }' . "\n";
			}

		} // End If Statement

		// Output styles
		if ( isset( $output ) && $output != '' ) {
			$output = strip_tags( $output );
			$output = "\n" . "<!-- Woo Custom Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
			echo $output;
		}
	} // End woo_custom_styling()
}

// Returns proper font css output
if (!function_exists( 'woo_generate_font_css')) {
	function woo_generate_font_css($option, $em = '1') {

		// Test if font-face is a Google font
		global $google_fonts;

		// Type Check for Array
		if ( is_array($google_fonts) ) {

			foreach ( $google_fonts as $google_font ) {

				// Add single quotation marks to font name and default arial sans-serif ending
				if ( $option[ 'face' ] == $google_font[ 'name' ] )
					$option[ 'face' ] = "'" . $option[ 'face' ] . "', arial, sans-serif";

			} // END foreach

		} // End If Statement

		if ( !@$option["style"] && !@$option["size"] && !@$option["unit"] && !@$option["color"] )
			return 'font-family: '.stripslashes($option["face"]).';';
		else
			return 'font:'.$option["style"].' '.$option["size"].$option["unit"].'/'.$em.'em '.stripslashes($option["face"]).';color:'.$option["color"].';';
	}
}

// Output stylesheet and custom.css after custom styling
remove_action( 'wp_head', 'woothemes_wp_head' );
add_action( 'woo_head', 'woothemes_wp_head' );


/*-----------------------------------------------------------------------------------*/
/* Add layout to body_class output */
/*-----------------------------------------------------------------------------------*/

add_filter( 'body_class','woo_layout_body_class', 10 );		// Add layout to body_class output

if ( ! function_exists( 'woo_layout_body_class' ) ) {
	function woo_layout_body_class( $classes ) {

		global $woo_options;

		$layout = 'two-col-left';

		if ( isset( $woo_options['woo_site_layout'] ) && ( $woo_options['woo_site_layout'] != '' ) ) {
			$layout = $woo_options['woo_site_layout'];
		}

		// Set main layout on post or page
		if ( is_singular() ) {
			global $post;
			$single = get_post_meta($post->ID, '_layout', true);
			if ( $single != "" AND $single != "layout-default" )
				$layout = $single;
		}

		// Add layout to $woo_options array for use in theme
		$woo_options['woo_layout'] = $layout;

		// Add show-nav class on homepage
		/*if ( is_home() ) {
			$classes[] = 'show-nav';
		}*/

		// Add classes to body_class() output
		$classes[] = $layout;
		return $classes;

	} // End woo_layout_body_class()
}


/*-----------------------------------------------------------------------------------*/
/* woo_feedburner_link() */
/*-----------------------------------------------------------------------------------*/
/**
 * woo_feedburner_link()
 *
 * Replace the default RSS feed link with the Feedburner URL, if one
 * has been provided by the user.
 *
 * @package WooFramework
 * @subpackage Filters
 */

add_filter( 'feed_link', 'woo_feedburner_link', 10 );

function woo_feedburner_link ( $output, $feed = null ) {

	global $woo_options;

	$default = get_default_feed();

	if ( ! $feed ) $feed = $default;

	if ( isset($woo_options[ 'woo_feed_url']) && $woo_options[ 'woo_feed_url' ] && ( $feed == $default ) && ( ! stristr( $output, 'comments' ) ) ) $output = esc_url( $woo_options[ 'woo_feed_url' ] );

	return $output;

} // End woo_feedburner_link()

/*-----------------------------------------------------------------------------------*/
/* Optionally load custom logo. */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woo_logo' ) ) {
function woo_logo () {
	global $woo_options;
	$site_description = get_bloginfo( 'description', 'display' );
	if ( isset( $woo_options['woo_texttitle'] ) && $woo_options['woo_texttitle'] == 'true' ) {
		?>
		<div class="site-header">
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
			<?php if ( $site_description ) : ?>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			<?php endif; ?>
		</div>
		<?php
	} else {

	$logo = esc_url( get_template_directory_uri() . '/images/logo.png' );
	if ( isset( $woo_options['woo_logo'] ) && $woo_options['woo_logo'] != '' ) { $logo = $woo_options['woo_logo']; }
	if ( is_ssl() ) { $logo = str_replace( 'http://', 'https://', $logo ); }
?>
	<div class="site-header">
		<a id="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'description' ) ); ?>">
			<img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
		</a>
	</div>
<?php }
} // End woo_logo()
}

add_action( 'woo_header_inside', 'woo_logo' );

/*-----------------------------------------------------------------------------------*/
/* Add custom CSS class to the <body> tag if the lightbox option is enabled. */
/*-----------------------------------------------------------------------------------*/

add_filter( 'body_class', 'woo_add_lightbox_body_class', 10 );

function woo_add_lightbox_body_class ( $classes ) {
	global $woo_options;

	if ( isset( $woo_options['woo_enable_lightbox'] ) && $woo_options['woo_enable_lightbox'] == 'true' ) {
		$classes[] = 'has-lightbox';
	}

	return $classes;
} // End woo_add_lightbox_body_class()

/*-----------------------------------------------------------------------------------*/
/* Load PrettyPhoto JavaScript and CSS if the lightbox option is enabled. */
/*-----------------------------------------------------------------------------------*/

add_action( 'woothemes_add_javascript', 'woo_load_prettyphoto', 10 );
add_action( 'woothemes_add_css', 'woo_load_prettyphoto', 10 );

function woo_load_prettyphoto () {
	global $woo_options;

	if ( ! isset( $woo_options['woo_enable_lightbox'] ) || $woo_options['woo_enable_lightbox'] == 'false' ) { return; }

	$filter = current_filter();

	switch ( $filter ) {
		case 'woothemes_add_javascript':
			wp_enqueue_script( 'enable-lightbox' );
		break;

		case 'woothemes_add_css':
			wp_enqueue_style( 'prettyPhoto' );
		break;

		default:
		break;
	}
} // End woo_load_prettyphoto()

/*-----------------------------------------------------------------------------------*/
/* Customise the default search form */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woo_customise_search_form' ) ) {
function woo_customise_search_form ( $html ) {
  // Add the "search_main" and "fix" classes to the wrapping DIV tag.
  $html = str_replace( '<form', '<div class="search_main fix"><form', $html );
  // Add the "searchform" class to the form.
  $html = str_replace( ' method=', ' class="searchform" method=', $html );
  // Add the placeholder attribute and CSS classes to the input field.
  $html = str_replace( ' name="s"', ' name="s" class="field s" placeholder="' . esc_attr( __( 'Search...', 'woothemes' ) ) . '"', $html );
  // Wrap the end of the form in a closing DIV tag.
  $html = str_replace( '</form>', '</form></div>', $html );
  // Add the "search-submit" class to the button.
  $html = str_replace( ' id="searchsubmit"', ' class="search-submit" id="searchsubmit"', $html );

  return $html;
} // End woo_customise_search_form()
}

add_filter( 'get_search_form', 'woo_customise_search_form' );

/*-----------------------------------------------------------------------------------*/
/* Load responsive IE scripts */
/*-----------------------------------------------------------------------------------*/

add_action( 'wp_footer', 'woo_load_responsive_IE_footer', 10 );

if ( ! function_exists( 'woo_load_responsive_IE_footer' ) ) {
	function woo_load_responsive_IE_footer () {
		$html = '';
		echo '<!--[if lt IE 9]>'. "\n";
		echo '<script src="' . get_template_directory_uri() . '/includes/js/respond.js"></script>'. "\n";
		echo '<![endif]-->'. "\n";

		echo $html;
	} // End woo_load_responsive_IE_footer()
}

/*-----------------------------------------------------------------------------------*/
/* Masonry */
/*-----------------------------------------------------------------------------------*/

add_filter( 'body_class', 'woo_add_masonry_class' );
if ( ! function_exists( 'woo_add_masonry_class' ) ) {
	function woo_add_masonry_class( $classes ) {

		if ( is_post_type_archive( 'post' ) || is_archive() || is_tag() || is_author() || is_page_template( 'template-blog.php' ) || is_page_template( 'template-business.php' ) || is_category() ) {
			$classes[] = 'has-masonry';
		}
		return $classes;
	}
}

/*-----------------------------------------------------------------------------------*/
/* Woo Loop Wrapper */
/*-----------------------------------------------------------------------------------*/

add_action( 'woo_loop_before', 'woo_loop_wrapper_open' );
add_action( 'woo_loop_after', 'woo_loop_wrapper_close' );
function woo_loop_wrapper_open() {
	?>
	<div class="loop-wrapper">
	<?php
}
function woo_loop_wrapper_close() {
	?>
	</div>
	<?php
}

/*-----------------------------------------------------------------------------------*/
/* Back to top */
/*-----------------------------------------------------------------------------------*/

add_action( 'wp_footer', 'woo_back_to_top' );
function woo_back_to_top() {
	if ( ! is_home() ) {
	?>
	<a href="#" class="back-to-top" title="<?php _e( 'Back to top', 'woothemes' ); ?>"><?php _e( 'Back to top', 'woothemes' ); ?></a>
	<?php
	}
}

/*-----------------------------------------------------------------------------------*/
/* Features Tweaks */
/*-----------------------------------------------------------------------------------*/

add_filter( 'woothemes_features_args', 'maximize_features' );
function maximize_features( $args ) {
	$args['size'] = 600;
	return $args;
}

/*-----------------------------------------------------------------------------------*/
/* Excerpt customisation */
/*-----------------------------------------------------------------------------------*/

function woo_excerpt_length( $length ) {
	return 25;
}
add_filter( 'excerpt_length', 'woo_excerpt_length', 999 );

function woo_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter('excerpt_more', 'woo_excerpt_more');

/*-----------------------------------------------------------------------------------*/
/* Post Formats */
/*-----------------------------------------------------------------------------------*/

add_action( 'after_setup_theme', 'woo_post_formats' );
function woo_post_formats() {
	add_theme_support( 'post-formats',
		array(
			'image',
			'gallery'
			)
		);
}

/*-----------------------------------------------------------------------------------*/
/* END */
/*-----------------------------------------------------------------------------------*/
?>