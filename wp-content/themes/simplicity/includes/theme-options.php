<?php

//Enable WooSEO on these custom Post types
$seo_post_types = array('post','page', 'portfolio');
define("SEOPOSTTYPES", serialize($seo_post_types));

//Global options setup
add_action('init','woo_global_options');
function woo_global_options(){
	// Populate WooThemes option in array for use in theme
	global $woo_options;
	$woo_options = get_option('woo_options');
}

add_action( 'admin_head','woo_options' );  
if (!function_exists('woo_options')) {
function woo_options() {
	
// VARIABLES
$themename = "Simplicity";
$manualurl = 'http://www.woothemes.com/support/theme-documentation/simplicity/';
$shortname = "woo";

//Access the WordPress Categories via an Array
$woo_categories = array();  
$woo_categories_obj = get_categories('hide_empty=0');
foreach ($woo_categories_obj as $woo_cat) {
    $woo_categories[$woo_cat->cat_ID] = $woo_cat->cat_name;}
$categories_tmp = array_unshift($woo_categories, "Select a category:");    
       
//Access the WordPress Pages via an Array
$woo_pages = array();
$woo_pages_obj = get_pages('sort_column=post_parent,menu_order');    
foreach ($woo_pages_obj as $woo_page) {
    $woo_pages[$woo_page->ID] = $woo_page->post_name; }
$woo_pages_tmp = array_unshift($woo_pages, "Select a page:");       

//Stylesheets Reader
$alt_stylesheet_path = TEMPLATEPATH . '/styles/';
$alt_stylesheets = array();
if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if(stristr($alt_stylesheet_file, ".css") !== false) {
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }    
    }
}

// Setup an array of slide-page terms for a dropdown.
$args = array( 'echo' => 0, 'hierarchical' => 1, 'taxonomy' => 'slide-page' );
$cats_dropdown = wp_dropdown_categories( $args );
$cats = array();

// Quick string hack to make sure we get the pages with the indents.
$cats_dropdown = str_replace( "<select name='cat' id='cat' class='postform' >", '', $cats_dropdown );
$cats_dropdown = str_replace( '</select>', '', $cats_dropdown );
$cats_split = explode( '</option>', $cats_dropdown );

$cats[] = __( 'Select a Slide Group:', 'woothemes' );

foreach ( $cats_split as $k => $v ) {   
    $id = '';   
    // Get the ID value.
    preg_match( '/value="(.*?)"/i', $v, $matches );
    
    if ( isset( $matches[1] ) ) {   
        $id = $matches[1];
        $cats[$id] = trim( strip_tags( $v ) );
    }
}

$slide_groups = $cats;

//More Options
$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");

// THIS IS THE DIFFERENT FIELDS
$options = array();   

  
// General

$options[] = array( "name" => __( 'General Settings', 'woothemes' ), 
					"type" => "heading",
					"icon" => "general");

$options[] = array( 'name' => __( 'Quick Start', 'woothemes' ),
    				'type' => 'subheading' );
                 
$options[] = array( "name" => __( 'Theme Stylesheet', 'woothemes' ),
					"desc" => __( 'Select your themes alternative color scheme.', 'woothemes' ),
					"id" => $shortname."_alt_stylesheet",
					"std" => "default.css",
					"type" => "select",
					"options" => $alt_stylesheets);

$options[] = array( "name" => __( 'Custom Logo', 'woothemes' ),
					"desc" => __( 'Upload a logo for your theme, or specify an image URL directly.', 'woothemes' ),
					"id" => $shortname."_logo",
					"std" => "",
					"type" => "upload");    
                                                                                     
$options[] = array( "name" => __( 'Text Title', 'woothemes' ),
					"desc" => sprintf( __( 'Enable text-based Site Title and Tagline. Setup title & tagline in %sGeneral Settings%s.', 'woothemes' ), '<a href="' . esc_url( admin_url( 'options-general.php' ) ) . '">', '</a>' ),
					"id" => $shortname."_texttitle",
					"std" => "false",
					"class" => "collapsed",
					"type" => "checkbox");

$options[] = array( "name" => __( 'Site Title', 'woothemes' ),
					"desc" => __( 'Change the site title typography.', 'woothemes' ),
					"id" => $shortname."_font_site_title",
					"std" => array('size' => '40','unit' => 'px','face' => 'Georgia','style' => '','color' => '#222222'),
					"class" => "hidden",
					"type" => "typography");  

$options[] = array( "name" => __( 'Site Description', 'woothemes' ),
					"desc" => __( 'Enable the site description/tagline under site title.', 'woothemes' ),
					"id" => $shortname."_tagline",
					"class" => "hidden",
					"std" => "false",
					"type" => "checkbox" );

$options[] = array( "name" => __( 'Site Description', 'woothemes' ),
					"desc" => __( 'Change the site description typography.', 'woothemes' ),
					"id" => $shortname."_font_tagline",
					"std" => array('size' => '14','unit' => 'px','face' => 'Georgia','style' => 'italic','color' => '#999999'),
					"class" => "hidden last",
					"type" => "typography");  
					          
$options[] = array( "name" => __( 'Custom Favicon', 'woothemes' ),
					"desc" => sprintf( __( 'Upload a 16px x 16px %sico image%s that will represent your website\'s favicon.', 'woothemes' ), '<a href="' . esc_url( 'http://faviconr.com/' ) . '">', '</a>' ),
					"id" => $shortname."_custom_favicon",
					"std" => "",
					"type" => "upload"); 
                                               
$options[] = array( "name" => __( 'Tracking Code', 'woothemes' ),
					"desc" => __( 'Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.', 'woothemes' ),
					"id" => $shortname."_google_analytics",
					"std" => "",
					"type" => "textarea");        

$options[] = array( 'name' => __( 'Subscription Settings', 'woothemes' ),
    				'type' => 'subheading' );

$options[] = array( "name" => __( 'RSS URL', 'woothemes' ),
					"desc" => __( 'Enter your preferred RSS URL. (Feedburner or other)', 'woothemes' ),
					"id" => $shortname."_feed_url",
					"std" => "",
					"type" => "text");
                    
$options[] = array( "name" => __( 'Contact Form E-Mail', 'woothemes' ),
					"desc" => __( 'Enter your E-mail address to use on the Contact Form Page Template. Add the contact form by adding a new page and selecting "Contact Form" as page template.', 'woothemes' ),
					"id" => $shortname."_contactform_email",
					"std" => "",
					"type" => "text");

$options[] = array( 'name' => __( 'Display Options', 'woothemes' ),
    				'type' => 'subheading' );

$options[] = array( "name" => __( 'Custom CSS', 'woothemes' ),
                    "desc" => __( 'Quickly add some CSS to your theme by adding it to this block.', 'woothemes' ),
                    "id" => $shortname."_custom_css",
                    "std" => "",
                    "type" => "textarea");

$options[] = array( "name" => __( 'Post/Page Comments', 'woothemes' ),
					"desc" => __( 'Select if you want to enable/disable comments on posts and/or pages.', 'woothemes' ),
					"id" => $shortname."_comments",
					"type" => "select2",
					"options" => array("post" => __( 'Posts Only', 'woothemes' ), "page" => __( 'Pages Only', 'woothemes' ), "both" => __( 'Pages / Posts', 'woothemes' ), "none" => __( 'None', 'woothemes' ) ) );                                                          
    
$options[] = array( "name" => __( 'Post Content', 'woothemes' ),
					"desc" => __( 'Select if you want to show the full content or the excerpt on posts.', 'woothemes' ),
					"id" => $shortname."_post_content",
					"type" => "select2",
					"options" => array("excerpt" => __( 'The Excerpt', 'woothemes' ), "content" => __( 'Full Content', 'woothemes' ) ) );                                                          

$options[] = array( "name" => __( 'Post Author Box', 'woothemes' ),
					"desc" => sprintf( __( 'This will enable the post author box on the single posts page. Edit description in %sProfile%s.', 'woothemes' ), '<a href="' . esc_url( admin_url( 'profile.php' ) ) . '">', '</a>' ),
					"id" => $shortname."_post_author",
					"std" => "true",
					"type" => "checkbox");
					
$options[] = array( "name" => __( 'Display Breadcrumbs', 'woothemes' ),
					"desc" => __( 'Display dynamic breadcrumbs on each page of your website.', 'woothemes' ),
					"id" => $shortname."_breadcrumbs_show",
					"std" => "false",
					"type" => "checkbox");
				
$options[] = array( "name" => __( 'Pagination Style', 'woothemes' ),
					"desc" => __( 'Select the style of pagination you would like to use on the blog.', 'woothemes' ),
					"id" => $shortname."_pagination_type",
					"type" => "select2",
					"options" => array("paginated_links" => "Numbers", "simple" => "Next/Previous" ) );
// Styling 

$options[] = array( "name" => __( 'Styling Options', 'woothemes' ),
					"type" => "heading",
					"icon" => "styling");   

$options[] = array( 'name' => __( 'Background', 'woothemes' ),
					'type' => 'subheading' );
			
$options[] = array( "name" =>  __( 'Body Background Color', 'woothemes' ),
					"desc" => __( 'Pick a custom color for background color of the theme e.g. #697e09', 'woothemes' ),
					"id" => "woo_body_color",
					"std" => "",
					"type" => "color");
					
$options[] = array( "name" => __( 'Body background image', 'woothemes' ),
					"desc" => __( 'Upload an image for the theme\'s background', 'woothemes' ),
					"id" => $shortname."_body_img",
					"std" => "",
					"type" => "upload");
					
$options[] = array( "name" => __( 'Background image repeat', 'woothemes' ),
                    "desc" => __( 'Select how you would like to repeat the background-image', 'woothemes' ),
                    "id" => $shortname."_body_repeat",
                    "std" => "no-repeat",
                    "type" => "select",
                    "options" => array("no-repeat","repeat-x","repeat-y","repeat"));

$options[] = array( "name" => __( 'Background image position', 'woothemes' ),
                    "desc" => __( 'Select how you would like to position the background', 'woothemes' ),
                    "id" => $shortname."_body_pos",
                    "std" => "top",
                    "type" => "select",
                    "options" => array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right"));

$options[] = array( 'name' => __( 'Links', 'woothemes' ),
					'type' => 'subheading' );

$options[] = array( "name" =>  __( 'Link Color', 'woothemes' ),
					"desc" => __( 'Pick a custom color for links or add a hex color code e.g. #697e09', 'woothemes' ),
					"id" => "woo_link_color",
					"std" => "",
					"type" => "color");   

$options[] = array( "name" =>  __( 'Link Hover Color', 'woothemes' ),
					"desc" => __( 'Pick a custom color for links hover or add a hex color code e.g. #697e09', 'woothemes' ),
					"id" => "woo_link_hover_color",
					"std" => "",
					"type" => "color");                    

$options[] = array( "name" =>  __( 'Button Color', 'woothemes' ),
					"desc" => __( 'Pick a custom color for buttons or add a hex color code e.g. #697e09', 'woothemes' ),
					"id" => "woo_button_color",
					"std" => "",
					"type" => "color");          

/* Typography */	
				
$options[] = array( "name" => __( 'Typography', 'woothemes' ),
					"type" => "heading",
					"icon" => "typography");   

$options[] = array( "name" => __( 'Enable Custom Typography', 'woothemes' ),
					"desc" => __( 'Enable the use of custom typography for your site. Custom styling will be output in your sites HEAD.', 'woothemes' ),
					"id" => $shortname."_typography",
					"std" => "false",
					"type" => "checkbox"); 									   

$options[] = array( "name" => __( 'General Typography', 'woothemes' ),
					"desc" => __( 'Change the general font.', 'woothemes' ),
					"id" => $shortname."_font_body",
					"std" => array('size' => '12','unit' => 'px','face' => 'Arial','style' => '','color' => '#555555'),
					"type" => "typography");  

$options[] = array( "name" => __( 'Navigation', 'woothemes' ),
					"desc" => __( 'Change the navigation font.', 'woothemes' ),
					"id" => $shortname."_font_nav",
					"std" => array('size' => '17','unit' => 'px','face' => 'PT Sans','style' => '','color' => '#3E4245'),
					"type" => "typography");  

$options[] = array( "name" => __( 'Post Title', 'woothemes' ),
					"desc" => __( 'Change the post title.', 'woothemes' ),
					"id" => $shortname."_font_post_title",
					"std" => array('size' => '33','unit' => 'px','face' => 'PT Sans','style' => 'normal','color' => '#293F4C'),
					"type" => "typography");  

$options[] = array( "name" => __( 'Post Meta', 'woothemes' ),
					"desc" => __( 'Change the post meta.', 'woothemes' ),
					"id" => $shortname."_font_post_meta",
					"std" => array('size' => '12','unit' => 'px','face' => 'Arial','style' => '','color' => '#999999'),
					"type" => "typography");  
					          
$options[] = array( "name" => __( 'Post Entry', 'woothemes' ),
					"desc" => __( 'Change the post entry.', 'woothemes' ),
					"id" => $shortname."_font_post_entry",
					"std" => array('size' => '14','unit' => 'px','face' => 'Arial','style' => '','color' => '#555555'),
					"type" => "typography");  

$options[] = array( "name" => __( 'Widget Titles', 'woothemes' ),
					"desc" => __( 'Change the widget titles.', 'woothemes' ),
					"id" => $shortname."_font_widget_titles",
					"std" => array('size' => '18','unit' => 'px','face' => 'PT Sans','style' => 'bold','color' => '#555555'),
					"type" => "typography");  

/* Layout */
$options[] = array( "name" => __( 'Layout Options', 'woothemes' ),
					"type" => "heading",
					"icon" => "layout");   
					 					                   
$url =  get_template_directory_uri() . '/functions/images/';
$options[] = array( "name" => __( 'Main Layout', 'woothemes' ),
					"desc" => __( 'Select which layout you want for your site.', 'woothemes' ),
					"id" => $shortname."_site_layout",
					"std" => "layout-left-content",
					"type" => "images",
					"options" => array(
						'layout-left-content' => esc_url( $url . '2cl.png' ),
						'layout-right-content' => esc_url( $url . '2cr.png' ) )
					);															

$options[] = array( 'name' => __( 'How do I set up the secondary navigation?', 'woothemes' ), 
					'id' => $shortname . '_secondary_navigation_notice', 
					'type' => 'info', 
					'std' => __( 'We\'ve upgraded the way in which the secondary navigation menu is setup. Adding a "Custom Menu", "Pages" or "Categories" widget to the "Secondary" widget area will display this menu on your pages.', 'woothemes' ) . '<br /><br />' . sprintf( __( 'Visit the "%s" section to get started.', 'woothemes' ), '<a href="' . admin_url( 'widgets.php' ) . '" target="_blank">' . __( 'Widgets', 'woothemes' ) . '</a>' )
					);
					 		   
/* Slider */
$options[] = array( "name" => __( 'Homepage Slider', 'woothemes' ),
					"icon" => "slider",
					"type" => "heading");
					
$options[] = array( "name" => __( 'Enable Slider', 'woothemes' ),
                    "desc" => __( 'Enable the slider on the homepage.', 'woothemes' ),
                    "id" => $shortname."_slider",
                    "std" => "true",
                    "type" => "checkbox");

$options[] = array(    "name" => __( 'Slider Entries', 'woothemes' ),
                    "desc" => __( 'Select the number of entries that should appear in the home page slider.', 'woothemes' ),
                    "id" => $shortname."_slider_entries",
                    "std" => "3",
                    "type" => "select",
                    "options" => $other_entries);

$options[] = array( 'name' => __( 'Slide Group', 'woothemes' ),
                    'desc' => __( 'Optionally choose to display only slides from a specific slide group.', 'woothemes' ),
                    'id' => $shortname . '_featured_slide_group',
                    'std' => '0',
                    'type' => 'select2',
                    'options' => $slide_groups );

$options[] = array( "name" => __( 'Effect', 'woothemes' ),
					"desc" => __( 'Select the animation effect.', 'woothemes' ),
					"id" => $shortname."_slider_effect",
					"type" => "select2",
					"options" => array("slide" => __( 'Slide', 'woothemes' ), "fade" => __( 'Fade', 'woothemes' ) ) );     

$options[] = array( "name" => __( 'Cross Fade', 'woothemes' ),
                    "desc" => __( 'Enable cross-fading between slides when using the fade effect.', 'woothemes' ),
                    "id" => $shortname."_slider_crossfade",
                    "std" => "false",
                    "type" => "checkbox"); 

$options[] = array( "name" => __( 'Hover Pause', 'woothemes' ),
                    "desc" => __( 'Hovering over slideshow will pause it', 'woothemes' ),
                    "id" => $shortname."_slider_hover",
                    "std" => "false",
                    "type" => "checkbox"); 

$options[] = array( "name" => __( 'Randomize', 'woothemes' ),
                    "desc" => __( 'Select to randomize slides.', 'woothemes' ),
                    "id" => $shortname."_slider_random",
                    "std" => "false",
                    "type" => "checkbox"); 
                    
$options[] = array( "name" => __( 'Animation Speed', 'woothemes' ),
                    "desc" => sprintf( __( 'The time in %sseconds%s the animation between frames will take.', 'woothemes' ), '<strong>', '</strong>' ),
                    "id" => $shortname."_slider_speed",
                    "std" => "0.6",
					"type" => "select",
					"options" => array( '0.0', '0.1', '0.2', '0.3', '0.4', '0.5', '0.6', '0.7', '0.8', '0.9', '1.0', '1.1', '1.2', '1.3', '1.4', '1.5', '1.6', '1.7', '1.8', '1.9', '2.0' ) );
                    
$options[] = array( "name" => __( 'Fade Speed', 'woothemes' ),
                    "desc" => sprintf( __( 'The time in %sseconds%s the fade between frames will take.', 'woothemes' ), '<strong>', '</strong>' ),
                    "id" => $shortname."_fade_speed",
                    "std" => "0.3",
					"type" => "select",
					"options" => array( '0.0', '0.1', '0.2', '0.3', '0.4', '0.5', '0.6', '0.7', '0.8', '0.9', '1.0', '1.1', '1.2', '1.3', '1.4', '1.5', '1.6', '1.7', '1.8', '1.9', '2.0' ) );

$options[] = array(    "name" => __( 'Auto Start', 'woothemes' ),
                    "desc" => __( 'Set the slider to start sliding automatically.', 'woothemes' ),
                    "id" => $shortname."_slider_auto",
                    "std" => "false",
                    "type" => "checkbox");   
                    
$options[] = array(    "name" => __( 'Auto Slide Interval', 'woothemes' ),
                    "desc" => sprintf( __( 'The time in %sseconds%s each slide pauses for, before sliding to the next.', 'woothemes' ), '<strong>', '</strong>' ),
                    "id" => $shortname."_slider_interval",
                    "std" => "6",
					"type" => "select",
					"options" => array( '1', '2', '3', '4', '5', '6', '7', '8', '9', '10' ) );
                    
$options[] = array( "name" => __( 'Show Title with Image Background', 'woothemes' ),
					"desc" => __( 'Show the post title when using an image as slider background.', 'woothemes' ),
					"id" => $shortname."_slider_title",
					"std" => "false",
					"type" => "checkbox");  
					
$options[] = array( "name" => __( 'Show Excerpt with Image Background', 'woothemes' ),
					"desc" => __( 'Show the post excerpt when using an image as slider background.', 'woothemes' ),
					"id" => $shortname."_slider_content",
					"std" => "false",
					"type" => "checkbox"); 
					
$options[] = array( "name" => __( 'Next/Previous', 'woothemes' ),
                    "desc" => __( 'Select to display next/previous buttons.', 'woothemes' ),
                    "id" => $shortname."_slider_nextprev",
                    "std" => "false",
                    "type" => "checkbox"); 

$options[] = array( "name" => __( 'Pagination', 'woothemes' ),
                    "desc" => __( 'Select to display pagination.', 'woothemes' ),
                    "id" => $shortname."_slider_pagination",
                    "std" => "true",
                    "type" => "checkbox"); 

/* Homepage */
$options[] = array( "name" => __( 'Homepage', 'woothemes' ),
                    "icon" => "homepage",
					"type" => "heading");
					 
$options[] = array( 'name' => __( 'Homepage Setup', 'woothemes' ),
					'type' => 'subheading' );
					
$options[] = array(	"name" => __( 'Display Recent Posts', 'woothemes' ),
					"desc" => __( 'Show recent posts below slider instead of features.', 'woothemes' ),
					"id" => $shortname."_home_posts",
					"std" => "false",
					"type" => "checkbox");					

$options[] = array( "name" => __( 'Enable Portfolio', 'woothemes' ),
					"desc" => __( 'Enable the portfolio section below the about section. Add portfolio posts using the "Portfolio" custom post type.', 'woothemes' ),
					"id" => $shortname."_portfolio",
					"std" => "true",
					"type" => "checkbox");

$options[] = array( "name" => __( 'Mini-Features Area', 'woothemes' ),
          			"desc" => __( 'Enable the front page Mini-Features features area.', 'woothemes' ),
          			"id" => $shortname."_mini_features",
          			"std" => "true",
          			"type" => "checkbox");

$options[] = array( "name" => __( 'Enable Testimonials', 'woothemes' ),
					"desc" => __( 'Enable the testimonials section below the portfolio section. Add testimonials using the "Testimonial" custom post type.', 'woothemes' ),
					"id" => $shortname."_testimonials",
					"std" => "true",
					"type" => "checkbox");

if ( is_woocommerce_activated() ) {
	$options[] = array( 'name' => __( 'Display featured products', 'woothemes' ),
					'desc' => __( 'Display features products on the homepage?', 'woothemes' ),
					'id' => $shortname.'_homepage_featured_products',
					'std' => 'false',
					"class" => "collapsed",
					'type' => 'checkbox' );
}

$options[] = array(	"name" => __( 'Homepage Sidebar', 'woothemes' ),
					"desc" => __( 'Show sidebar instead of full-width', 'woothemes' ),
					"id" => $shortname."_home_sidebar",
					"std" => "true",
					"type" => "checkbox");
				
/* Mini Features */
$options[] = array( 'name' => __( 'Mini Features', 'woothemes' ),
					'type' => 'subheading' );
          			
$options[] = array( "name" => __( 'Mini-Features Title', 'woothemes' ),
					"desc" => __( 'Edit the title of the Mini-Features section', 'woothemes' ),
					"id" => $shortname."_sub_featured_title",
					"std" => "",
					"type" => "text");
					
$options[] = array( "name" => __( 'Number of Mini-Features', 'woothemes' ),
					"id" => $shortname."_mini_features_number",
					"std" => "3",
					"type" => "select",
					"options" => $other_entries);	
					
$options[] = array( "name" => __( 'Custom permalink', 'woothemes' ),
          			"desc" => sprintf( __( 'This option allows you to change the permalink on the individual mini-features pages. (e.g /infobox/pagename to /features/pagename/). Please update %sPermalinks%s after any changes.', 'woothemes' ), '<a href="' . esc_url( admin_url( 'options-permalink.php' ) ) . '">', '</a>' ),
          			"id" => $shortname."_infobox_rewrite",
          			"std" => "infobox",
          			"type" => "text");                          
	

/* Homepage Portfolio */
$options[] = array( 'name' => __( 'Portfolio Items', 'woothemes' ),
					'type' => 'subheading' );
															
					
$options[] = array( "name" => __( 'Portfolio Title', 'woothemes' ),
					"desc" => __( 'Edit the title of the portfolio section', 'woothemes' ),
					"id" => $shortname."_portfolio_title",
					"std" => "",
					"type" => "text");
					
$options[] = array( "name" => __( 'Number of Portfolio items', 'woothemes' ),
					"id" => $shortname."_portfolio_number",
					"std" => "4",
					"type" => "select",
					"options" => $other_entries);		
					
$options[] = array( "name" => __( 'Custom permalink', 'woothemes' ),
          			"desc" => sprintf( __( 'This option allows you to change the permalink on the individual portfolio pages. (e.g /portfolio-items/pagename to /artwork/pagename/). Please update %sPermalinks%s after any changes.', 'woothemes' ), '<a href="' . esc_url( admin_url( 'options-permalink.php' ) ) . '">', '</a>' ),
          			"id" => $shortname."_portfolioitems_rewrite",
          			"std" => "portfolio-items",
          			"type" => "text");    

/* Testimonials */
$options[] = array( 'name' => __( 'Testimonials', 'woothemes' ),
					'type' => 'subheading' );

					
$options[] = array( "name" => __( 'Testimonials Title', 'woothemes' ),
					"desc" => __( 'Edit the title of the testimonials section', 'woothemes' ),
					"id" => $shortname."_info_quote_title",
					"std" => "",
					"type" => "text");                                                   

$options[] = array( "name" => __( 'Auto-Fade Between Testimonials', 'woothemes' ),
					"desc" => __( 'Enable automatic fading between testimonials.', 'woothemes' ),
					"id" => $shortname."_testimonials_autofade",
					"std" => "true",
					"type" => "checkbox");

$options[] = array( "name" => __( 'Auto Fade Interval', 'woothemes' ),
                    "desc" => sprintf( __( 'The time in %smilliseconds%s each testimonial pauses for, before fading to the next.', 'woothemes' ), '<strong>', '</strong>' ),
                    "id" => $shortname."_testimonials_interval",
                    "std" => "6000",
                    "type" => "text");
                  
/* Homepage Featured Products */
if ( is_woocommerce_activated() ) {
$options[] = array( 'name' => __( 'Featured Products', 'woothemes' ),
					'type' => 'subheading' );

$options[] = array( 'name' => __( 'Display how many featured products?', 'woothemes' ),
					'desc' => __( 'Specify how many featured products should appear on the homepage.', 'woothemes' ),
					'id' => $shortname . '_homepage_featured_products_perpage',
					'std' => '3',
					'type' => 'select2',
					'options' => $other_entries);
}

/* Portfolio */
$options[] = array( "name" => __( 'Portfolio', 'woothemes' ),
                    "icon" => "portfolio",
					"type" => "heading");    		

$options[] = array( "name" => __( 'Portfolio Tags', 'woothemes' ),
					"desc" => __( 'Enter comma seperated tags for portfolio sorting (e.g. web, print, icons). You must add these tags to the portfolio items you want to sort.', 'woothemes' ),
					"id" => $shortname."_portfolio_tags",
					"std" => "",
					"type" => "text");
					
$options[] = array( "name" => __( 'Enable Single Portfolio Gallery', 'woothemes' ),
					"desc" => __( 'Enable the gallery feature in the single portfolio page layout.', 'woothemes' ),
					"id" => $shortname."_portfolio_gallery",
					"std" => "true",
					"type" => "checkbox");
					
$options[] = array( "name" => __( 'Single Portfolio Title', 'woothemes' ),
					"desc" => __( 'Edit the title of the single portfolio section', 'woothemes' ),
					"id" => $shortname."_single_portfolio_title",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => __( 'Portfolio items link to&hellip;', 'woothemes' ),
					"desc" => __( 'Select whether the portfolio items link to the portfolio image (in a lightbox) or to the portfolio item\'s detail page.', 'woothemes' ),
					"id" => $shortname."_portfolio_link",
					"type" => "select2",
					"std" => "image",
					"options" => array( "image" => "Image", "page" => "Page" ) );
					

/* Dynamic Images */
$options[] = array( "name" => __( 'Dynamic Images', 'woothemes' ),
					"type" => "heading",
					"icon" => "image");    

$options[] = array( 'name' => __( 'Resizer Settings', 'woothemes' ),
					'type' => 'subheading' );
	
$options[] = array( 'name' => __( 'Dynamic Image Resizing', 'woothemes' ),
    				'desc' => '',
    				'id' => $shortname . '_wpthumb_notice',
    				'std' => __( 'There are two alternative methods of dynamically resizing the thumbnails in the theme, <strong>WP Post Thumbnail</strong> or <strong>TimThumb - Custom Settings panel</strong>. We recommend using WP Post Thumbnail option.', 'woothemes' ),
    				'type' => 'info' );

$options[] = array( "name" => __( 'WP Post Thumbnail', 'woothemes' ),
					"desc" => __( 'Use WordPress post thumbnail to assign a post thumbnail.', 'woothemes' ),
					"id" => $shortname."_post_image_support",
					"std" => "true",
					"class" => "collapsed",
					"type" => "checkbox"); 

$options[] = array( "name" => __( 'WP Post Thumbnail - Dynamically Resize', 'woothemes' ),
					"desc" => sprintf( __( 'The post thumbnail will be dynamically resized using native WP resize functionality. %s(Requires PHP 5.2+)%s', 'woothemes' ), '<em>', '</em>' ),
					"id" => $shortname."_pis_resize",
					"std" => "true",
					"class" => "hidden",
					"type" => "checkbox"); 									   
					
$options[] = array( "name" => __( 'WP Post Thumbnail - Hard Crop', 'woothemes' ),
					"desc" => __( 'The image will be cropped to match the target aspect ratio.', 'woothemes' ),
					"id" => $shortname."_pis_hard_crop",
					"std" => "true",
					"class" => "hidden last",
					"type" => "checkbox"); 									   

$options[] = array( 'name' => __( 'TimThumb - Custom Settings Panel', 'woothemes' ),
    				'desc' => sprintf( __( 'This will enable the %1$s (thumb.php) script which dynamically resizes images added through the <strong>custom settings panel below the post</strong>. Make sure your themes <em>cache</em> folder is writable. %2$s', 'woothemes' ), '<a href="http://code.google.com/p/timthumb/">TimThumb</a>', '<a href="http://www.woothemes.com/2008/10/troubleshooting-image-resizer-thumbphp/">Need help?</a>' ),
    				'id' => $shortname . '_resize',
    				'std' => 'true',
    				'type' => 'checkbox' );   
                    
$options[] = array( "name" => __( 'Automatic Image Thumbs', 'woothemes' ),
					"desc" => __( 'If no image is specified in the "image" custom field or WP post thumbnail then the first uploaded post image is used.', 'woothemes' ),
					"id" => $shortname."_auto_img",
					"std" => "false",
					"type" => "checkbox");    

$options[] = array( 'name' => __( 'Thumbnail Settings', 'woothemes' ),
					'type' => 'subheading' );

$options[] = array( "name" => __( 'Thumbnail Image Dimensions', 'woothemes' ),
					"desc" => __( 'Enter an integer value i.e. 250 for the desired size which will be used when dynamically creating the images.', 'woothemes' ),
					"id" => $shortname."_image_dimensions",
					"std" => "",
					"type" => array( 
									array(  'id' => $shortname. '_thumb_w',
											'type' => 'text',
											'std' => 100,
											'meta' => __( 'Width', 'woothemes' ) ),
									array(  'id' => $shortname. '_thumb_h',
											'type' => 'text',
											'std' => 100,
											'meta' => __( 'Height', 'woothemes' ) )
								  ));
                                                                                                
$options[] = array( "name" => __( 'Thumbnail Image alignment', 'woothemes' ),
					"desc" => __( 'Select how to align your thumbnails with posts.', 'woothemes' ),
					"id" => $shortname."_thumb_align",
					"std" => "alignleft",
					"type" => "radio",
					"options" => array("alignleft" => __( 'Left', 'woothemes' ), "alignright" => __( 'Right', 'woothemes' ), "aligncenter" => __( 'Center', 'woothemes' ) )); 

$options[] = array( "name" => __( 'Show thumbnail in Single Posts', 'woothemes' ),
					"desc" => __( 'Show the attached image in the single post page.', 'woothemes' ),
					"id" => $shortname."_thumb_single",
					"class" => "collapsed",
					"std" => "false",
					"type" => "checkbox");    

$options[] = array( "name" => __( 'Single Image Dimensions', 'woothemes' ),
					"desc" => __( 'Enter an integer value i.e. 250 for the image size. Max width is 576.', 'woothemes' ),
					"id" => $shortname."_image_dimensions",
					"std" => "",
					"class" => "hidden last",
					"type" => array( 
									array(  'id' => $shortname. '_single_w',
											'type' => 'text',
											'std' => 618,
											'meta' => __( 'Width', 'woothemes' ) ),
									array(  'id' => $shortname. '_single_h',
											'type' => 'text',
											'std' => 142,
											'meta' => __( 'Height', 'woothemes' ) )
								  ));

$options[] = array( "name" => __( 'Single Post Image alignment', 'woothemes' ),
					"desc" => __( 'Select how to align your thumbnail with single posts.', 'woothemes' ),
					"id" => $shortname."_thumb_single_align",
					"std" => "alignright",
					"type" => "radio",
					"class" => "hidden",
					"options" => array("alignleft" => __( 'Left', 'woothemes' ), "alignright" => __( 'Right', 'woothemes' ), "aligncenter" => __( 'Center', 'woothemes' ) )); 

$options[] = array( "name" => __( 'Add thumbnail to RSS feed', 'woothemes' ),
					"desc" => __( 'Add the the image uploaded via your Custom Settings to your RSS feed', 'woothemes' ),
					"id" => $shortname."_rss_thumb",
					"std" => "false",
					"type" => "checkbox");  
					
/* Footer */
$options[] = array( "name" => __( 'Footer Customization', 'woothemes' ),
					"type" => "heading",
					"icon" => "footer");    
					

$url =  get_template_directory_uri() . '/functions/images/';
$options[] = array( "name" => __( 'Footer Widget Areas', 'woothemes' ),
					"desc" => __( 'Select how many footer widget areas you want to display.', 'woothemes' ),
					"id" => $shortname."_footer_sidebars",
					"std" => "4",
					"type" => "images",
					"options" => array(
						'0' => esc_url( $url . 'layout-off.png' ),
						'1' => esc_url( $url . 'footer-widgets-1.png' ),
						'2' => esc_url( $url . 'footer-widgets-2.png' ),
						'3' => esc_url( $url . 'footer-widgets-3.png' ),
						'4' => esc_url( $url . 'footer-widgets-4.png' ) )
					); 		   
										
$options[] = array( "name" => __( 'Custom Affiliate Link', 'woothemes' ),
					"desc" => __( 'Add an affiliate link to the WooThemes logo in the footer of the theme.', 'woothemes' ),
					"id" => $shortname."_footer_aff_link",
					"std" => "",
					"type" => "text");	
									
$options[] = array( "name" => __( 'Enable Custom Footer (Left)', 'woothemes' ),
					"desc" => __( 'Activate to add the custom text below to the theme footer.', 'woothemes' ),
					"id" => $shortname."_footer_left",
					"std" => "false",
					"type" => "checkbox");    

$options[] = array( "name" => __( 'Custom Text (Left)', 'woothemes' ),
					"desc" => __( 'Custom HTML and Text that will appear in the footer of your theme.', 'woothemes' ),
					"id" => $shortname."_footer_left_text",
					"std" => "",
					"type" => "textarea");
						
$options[] = array( "name" => __( 'Enable Custom Footer (Right)', 'woothemes' ),
					"desc" => __( 'Activate to add the custom text below to the theme footer.', 'woothemes' ),
					"id" => $shortname."_footer_right",
					"std" => "false",
					"type" => "checkbox");    

$options[] = array( "name" => __( 'Custom Text (Right)', 'woothemes' ),
					"desc" => __( 'Custom HTML and Text that will appear in the footer of your theme.', 'woothemes' ),
					"id" => $shortname."_footer_right_text",
					"std" => "",
					"type" => "textarea");

/* Subscribe & Connect */
$options[] = array( "name" => __( 'Subscribe & Connect', 'woothemes' ),
					"type" => "heading",
					"icon" => "connect"); 

$options[] = array( 'name' => __( 'S&C Setup', 'woothemes' ),
    				'type' => 'subheading' );

$options[] = array( "name" => __( 'Enable Subscribe & Connect - Single Post', 'woothemes' ),
					"desc" => sprintf( __( 'Enable the subscribe & connect area on single posts. You can also add this as a %swidget%s in your sidebar.', 'woothemes' ), '<a href="' . esc_url( admin_url( 'widgets.php' ) ) . '">', '</a>' ),
					"id" => $shortname."_connect",
					"std" => 'true',
					"type" => "checkbox"); 

$options[] = array( "name" => __( 'Subscribe Title', 'woothemes' ),
					"desc" => __( 'Enter the title to show in your subscribe & connect area.', 'woothemes' ),
					"id" => $shortname."_connect_title",
					"std" => '',
					"type" => "text"); 

$options[] = array( "name" => __( 'Text', 'woothemes' ),
					"desc" => __( 'Change the default text in this area.', 'woothemes' ),
					"id" => $shortname."_connect_content",
					"std" => '',
					"type" => "textarea"); 

$options[] = array( 'name' => __( 'Enable Related Posts', 'woothemes' ),
    				'desc' => __( 'Enable related posts in the subscribe area. Uses posts with the same <strong>tags</strong> to find related posts. Note: Will not show in the Subscribe widget.', 'woothemes' ),
    				'id' => $shortname . '_connect_related',
    				'std' => 'true',
    				'type' => 'checkbox' );

$options[] = array( 'name' => __( 'Subscribe Settings', 'woothemes' ),
    				'type' => 'subheading' );

$options[] = array( "name" => __( 'Subscribe By E-mail ID (Feedburner)', 'woothemes' ),
					"desc" => sprintf( __( 'Enter your %sFeedburner ID%s for the e-mail subscription form.', 'woothemes' ), '<a href="http://www.woothemes.com/tutorials/how-to-find-your-feedburner-id-for-email-subscription/">', '</a>' ),
					"id" => $shortname."_connect_newsletter_id",
					"std" => '',
					"type" => "text"); 					

$options[] = array( "name" => __( 'Subscribe By E-mail to MailChimp', 'woothemes' ),
					"desc" => sprintf( __( 'If you have a MailChimp account you can enter the %sMailChimp List Subscribe URL%s to allow your users to subscribe to a MailChimp List.', 'woothemes' ), '<a href="' . esc_url( 'http://woochimp.heroku.com/' ) . '" target="_blank">', '</a>' ),
					"id" => $shortname."_connect_mailchimp_list_url",
					"std" => '',
					"type" => "text");

$options[] = array( 'name' => __( 'Connect Settings', 'woothemes' ),
    				'type' => 'subheading' );

$options[] = array( "name" => __( 'Enable RSS', 'woothemes' ),
					"desc" => __( 'Enable the subscribe and RSS icon.', 'woothemes' ),
					"id" => $shortname."_connect_rss",
					"std" => 'true',
					"type" => "checkbox"); 

$options[] = array( 'name' => __( 'Twitter URL', 'woothemes' ),
    				'desc' => sprintf( __( 'Enter your %1$s URL e.g. http://www.twitter.com/woothemes', 'woothemes' ), '<a href="http://www.twitter.com/">'.__( 'Twitter', 'woothemes' ).'</a>' ),
    				'id' => $shortname . '_connect_twitter',
    				'std' => '',
    				'type' => 'text' );

$options[] = array( 'name' => __( 'Facebook URL', 'woothemes' ),
    				'desc' => sprintf( __( 'Enter your %1$s URL e.g. http://www.facebook.com/woothemes', 'woothemes' ), '<a href="http://www.facebook.com/">'.__( 'Facebook', 'woothemes' ).'</a>' ),
    				'id' => $shortname . '_connect_facebook',
    				'std' => '',
    				'type' => 'text' );

$options[] = array( 'name' => __( 'YouTube URL', 'woothemes' ),
    				'desc' => sprintf( __( 'Enter your %1$s URL e.g. http://www.youtube.com/woothemes', 'woothemes' ), '<a href="http://www.youtube.com/">'.__( 'YouTube', 'woothemes' ).'</a>' ),
    				'id' => $shortname . '_connect_youtube',
    				'std' => '',
    				'type' => 'text' );

$options[] = array( 'name' => __( 'Flickr URL', 'woothemes' ),
    				'desc' => sprintf( __( 'Enter your %1$s URL e.g. http://www.flickr.com/woothemes', 'woothemes' ), '<a href="http://www.flickr.com/">'.__( 'Flickr', 'woothemes' ).'</a>' ),
    				'id' => $shortname . '_connect_flickr',
    				'std' => '',
    				'type' => 'text' );

$options[] = array( 'name' => __( 'LinkedIn URL', 'woothemes' ),
    				'desc' => sprintf( __( 'Enter your %1$s URL e.g. http://www.linkedin.com/in/woothemes', 'woothemes' ), '<a href="http://www.www.linkedin.com.com/">'.__( 'LinkedIn', 'woothemes' ).'</a>' ),
    				'id' => $shortname . '_connect_linkedin',
    				'std' => '',
    				'type' => 'text' );

$options[] = array( 'name' => __( 'Delicious URL', 'woothemes' ),
    				'desc' => sprintf( __( 'Enter your %1$s URL e.g. http://www.delicious.com/woothemes', 'woothemes' ), '<a href="http://www.delicious.com/">'.__( 'Delicious', 'woothemes' ).'</a>' ),
    				'id' => $shortname . '_connect_delicious',
    				'std' => '',
    				'type' => 'text' );

$options[] = array( 'name' => __( 'Google+ URL', 'woothemes' ),
    				'desc' => sprintf( __( 'Enter your %1$s URL e.g. https://plus.google.com/104560124403688998123/', 'woothemes' ), '<a href="http://plus.google.com/">'.__( 'Google+', 'woothemes' ).'</a>' ),
    				'id' => $shortname . '_connect_googleplus',
    				'std' => '',
    				'type' => 'text' );
							
                                              
// Add extra options through function
if ( function_exists("woo_options_add") )
	$options = woo_options_add($options);

if ( get_option('woo_template') != $options) update_option('woo_template',$options);      
if ( get_option('woo_themename') != $themename) update_option('woo_themename',$themename);   
if ( get_option('woo_shortname') != $shortname) update_option('woo_shortname',$shortname);
if ( get_option('woo_manual') != $manualurl) update_option('woo_manual',$manualurl);

// Woo Metabox Options
// Start name with underscore to hide custom key from the user
$woo_metaboxes = array();

global $post;

if ( ( get_post_type() == 'post') || ( !get_post_type() ) ) {

	$woo_metaboxes[] = array (	"name" => "image",
								"label" => __( 'Image', 'woothemes' ),
								"type" => "upload",
								"desc" => __( 'Upload an image or enter an URL.', 'woothemes' ) );
	
	if ( get_option('woo_resize') == "true" ) {						
		$woo_metaboxes[] = array (	"name" => "_image_alignment",
									"std" => "c",
									"label" => __( 'Image Crop Alignment', 'woothemes' ),
									"type" => "select2",
									"desc" => __( 'Select crop alignment for resized image', 'woothemes' ),
									"options" => array(	"c" => __( 'Center', 'woothemes' ),
														"t" => __( 'Top', 'woothemes' ),
														"b" => __( 'Bottom', 'woothemes' ),
														"l" => __( 'Left', 'woothemes' ),
														"r" => __( 'Right', 'woothemes' ) ));
	}

	$woo_metaboxes[] = array (  "name"  => "embed",
					            "std"  => "",
					            "label" => __( 'Embed Code', 'woothemes' ),
					            "type" => "textarea",
					            "desc" => __( 'Enter the video embed code for your video (YouTube, Vimeo or similar)', 'woothemes' ) );
					            
										
} // End post

if ( get_post_type() == 'slide' || !get_post_type() ) {

	$woo_metaboxes[] = array (	"name" => "image",
								"label" => __( 'Slide Image', 'woothemes' ),
								"type" => "upload",
								"desc" => __( 'Upload an image or enter an URL to your slide image', 'woothemes' ));

	$woo_metaboxes[] = array (  "name"  => "embed",
					            "std"  => "",
					            "label" => __( 'Video Embed Code', 'woothemes' ),
					            "type" => "textarea",
					            "desc" => __( 'Enter the video embed code for your video (YouTube, Vimeo or similar). Will show instead of your image.', 'woothemes' ) );
					            
	$woo_metaboxes[] = array (	"name" => "url",
								"label" => __( 'URL', 'woothemes' ),
								"type" => "text",
								"desc" => __( 'Enter URL if you want to add a link to the uploaded image and title. (optional)', 'woothemes' ) );
					          
} //End slide

if( get_post_type() == 'infobox' || !get_post_type()){	

$woo_metaboxes[] = array (		"name" => "mini-image",
								"label" => __( 'Mini-features Image', 'woothemes' ),
								"type" => "upload",
								"desc" => __( 'Upload image for use with the Mini-Feature on the homepage (optional)', 'woothemes' ) );
 
$woo_metaboxes[] = array (		"name" => "mini_excerpt",
								"label" => __( 'Mini-features Excerpt', 'woothemes' ),
								"type" => "textarea",
								"desc" => __( 'Enter the text to show in your Mini-Feature.', 'woothemes' ) );

$woo_metaboxes[] = array (		"name" => "mini_readmore",
								"std" => "",
								"label" => __( 'Mini-features URL', 'woothemes' ),
								"type" => "text",
								"desc" => __( 'Add an URL for your Mini-Feature image and title (optional)', 'woothemes' ) );

} // End mini

if ( get_post_type() == 'portfolio' || !get_post_type() ) {

	$woo_metaboxes[] = array (	"name" => "portfolio-image",
								"label" => __( 'Portfolio Image', 'woothemes' ),
								"type" => "upload",
								"desc" => __( 'Upload an image or enter an URL to your portfolio image', 'woothemes' ) );
								
	if ( get_option('woo_resize') == "true" ) {						
		$woo_metaboxes[] = array (	"name" => "_image_alignment",
									"std" => "c",
									"label" => __( 'Image Crop Alignment', 'woothemes' ),
									"type" => "select2",
									"desc" => __( 'Select crop alignment for resized image', 'woothemes' ),
									"options" => array(	"c" => __( 'Center', 'woothemes' ),
														"t" => __( 'Top', 'woothemes' ),
														"b" => __( 'Bottom', 'woothemes' ),
														"l" => __( 'Left', 'woothemes' ),
														"r" => __( 'Right', 'woothemes' ) ));
	}

	$woo_metaboxes[] = array (  "name"  => "embed",
					            "std"  => "",
					            "label" => __( 'Video Embed Code', 'woothemes' ),
					            "type" => "textarea",
					            "desc" => __( 'Enter the video embed code for your video (YouTube, Vimeo or similar). Will show instead of your image.', 'woothemes' ) );
					            
	$woo_metaboxes['lightbox-url'] = array (	
								"name" => "lightbox-url",
								"label" => __( 'Lightbox URL', 'woothemes' ),
								"type" => "text",
								"desc" => sprintf( __( 'Enter an optional URL to show in the %sPrettyPhoto lightbox%s for this portfolio item.', 'woothemes' ), '<a href="' . esc_url( 'http://www.no-margin-for-errors.com/projects/prettyphoto-jquery-lightbox-clone/' ) . '" target="_blank">', '</a>' ) );

	$woo_metaboxes['testimonial'] = array (	
								"name" => "testimonial",
								"label" => __( 'Testimonial', 'woothemes' ),
								"type" => "textarea",
								"desc" => __( 'Enter a testimonial from your client to be displayed on the single portfolio page', 'woothemes' ) );

	$woo_metaboxes['testimonial_author'] = array (	
								"name" => "testimonial_author",
								"label" => __( 'Testimonial Author', 'woothemes' ),
								"type" => "text",
								"desc" => __( 'Enter the name of the author of the testimonial e.g. Joe Bloggs)', 'woothemes' ) );
								
	$woo_metaboxes[] = array (	"name" => "url",
								"label" => __( 'URL', 'woothemes' ),
								"type" => "text",
								"desc" => __( 'Enter URL of your clients site. (optional)', 'woothemes' ) );
					            
} //End portfolio

if( get_post_type() == 'testimonial' || !get_post_type()){	

	$woo_metaboxes['testimonial_author'] = array (	
								"name" => "testimonial_author",
								"label" => __( 'Testimonial Author', 'woothemes' ),
								"type" => "text",
								"desc" => __( 'Enter the name of the author of the testimonial e.g. Joe Bloggs', 'woothemes' )
			);
 
	$woo_metaboxes['testimonial_url'] = array (	
								"name" => "testimonial_url",
								"label" => __( 'Testimonial URL', 'woothemes' ),
								"type" => "text",
								"desc" => __( '(optional) Enter the URL to the testimonial author e.g. http://www.woothemes.com', 'woothemes' )
			);

} // End testimonial

if ( get_post_type() == 'page' || get_post_type() == 'post' || !get_post_type() ) {

	$url = get_template_directory_uri() . '/functions/images/';

	$woo_metaboxes[] = array (	"name" => "_layout",
								"std" => "layout-default",
								"label" => __( 'Layout', 'woothemes' ),
								"type" => "images",
								"desc" => __( 'Select the layout you want on this specific post/page.', 'woothemes' ),
								"options" => array(
										'layout-default' => esc_url( $url . 'layout-off.png' ),
										'layout-full' => esc_url( $url . '1c.png' ),
										'layout-left-content' => esc_url( $url . '2cl.png' ),
										'layout-right-content' => esc_url( $url . '2cr.png' ) ));

}

// Add extra metaboxes through function
if ( function_exists("woo_metaboxes_add") )
	$woo_metaboxes = woo_metaboxes_add($woo_metaboxes);
    
if ( get_option('woo_custom_template') != $woo_metaboxes) update_option('woo_custom_template',$woo_metaboxes);      

}
}



?>