<?php
if ( ! defined( 'ABSPATH' ) ) exit;
global $woo_options;

/*-----------------------------------------------------------------------------------*/
/* Hooks & Filters */
/*-----------------------------------------------------------------------------------*/

if ( ! is_admin() ) {
	add_action( 'wp_enqueue_scripts', 'woo_wc_css', 10 );
}

add_action( 'after_setup_theme', 							'woocommerce_support' );

// Related Products
add_filter( 'woocommerce_output_related_products_args', 	'woo_wc_related_products' );

// Custom place holder
add_filter( 'woocommerce_placeholder_img_src', 				'woo_wc_placeholder_img_src' );

// Product columns
add_filter( 'loop_shop_columns', 							'woo_wc_loop_columns', 98 );

// Products per page
add_filter( 'loop_shop_per_page',							'woo_wc_produts_per_page', 98 );

// Layout
remove_action( 'woocommerce_before_main_content', 			'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 			'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_before_main_content', 				'woo_wc_before_content', 10 );
add_action( 'woocommerce_after_main_content', 				'woo_wc_after_content', 20 );
add_action( 'woocommerce_before_main_content',				'woo_wc_archive_header', 30 );
add_action( 'woocommerce_archive_description',				'woo_wc_archive_header_end', 1 );

remove_action( 'woocommerce_after_shop_loop_item_title', 	'woocommerce_template_loop_price', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 		'woocommerce_template_loop_price', 15 );
remove_action( 'woocommerce_after_shop_loop_item_title', 	'woocommerce_template_loop_rating', 5 );
add_action( 'woocommerce_before_shop_loop_item_title', 		'woocommerce_template_loop_rating', 14 );
add_action( 'woocommerce_after_shop_loop_item_title', 		'woocommerce_template_single_excerpt', 10 );

remove_action( 'woocommerce_after_single_product_summary', 	'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 	'woocommerce_output_related_products', 20 );

add_action( 'woocommerce_after_single_product', 			'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product', 			'woocommerce_output_related_products', 20 );
add_filter( 'woocommerce_product_thumbnails_columns', 		'woo_wc_thumb_cols' );

// Breadcrumb
remove_action( 'woocommerce_before_main_content', 			'woocommerce_breadcrumb', 20, 0 );

// Pagination / Search
remove_action( 'woocommerce_after_shop_loop', 				'woocommerce_pagination', 10 );
add_action( 'woocommerce_after_shop_loop', 					'woo_wc_pagination', 10 );

// Cart Fragments
add_filter( 'add_to_cart_fragments', 						'woo_wc_header_add_to_cart_fragment' );

// Reviews
add_filter ( 'woocommerce_review_gravatar_size', 			'woo_wc_review_gravatar' );


/*-----------------------------------------------------------------------------------*/
/* Compatibility */
/*-----------------------------------------------------------------------------------*/

// Declare WooCommerce Support
function woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

/*-----------------------------------------------------------------------------------*/
/* Styles */
/*-----------------------------------------------------------------------------------*/

// Disable WooCommerce styles
if ( version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
	// WooCommerce 2.1 or above is active
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );
} else {
	// WooCommerce less than 2.1 is active
	define( 'WOOCOMMERCE_USE_CSS', false );
}

if ( ! function_exists( 'woo_wc_css' ) ) {
	function woo_wc_css () {
		wp_register_style( 'woocommerce', esc_url( get_template_directory_uri() . '/css/woocommerce.css' ) );
		wp_enqueue_style( 'woocommerce' );
	} // End woo_wc_css()
}


/*-----------------------------------------------------------------------------------*/
/* Products */
/*-----------------------------------------------------------------------------------*/

// Replace the default related products function with our own which displays the correct number of product columns
function woo_wc_related_products() {
	$args = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);
	return $args;
}

// Custom Placeholder
if ( ! function_exists( 'woo_wc_placeholder_img_src' ) ) {
	function woo_wc_placeholder_img_src( $src ) {
		global $woo_options;
		if ( isset( $woo_options['woo_placeholder_url'] ) && '' != $woo_options['woo_placeholder_url'] ) {
			$src = $woo_options['woo_placeholder_url'];
		}
		else {
			$src = get_template_directory_uri() . '/images/wc-placeholder.gif';
		}
		return esc_url( $src );
	} // End woo_wc_placeholder_img_src()
}

// Set product columns to 3
if ( ! function_exists( 'woo_wc_loop_columns' ) ) {
	function woo_wc_loop_columns() {
		return 3;
	}
}

if ( ! function_exists( 'woo_wc_produts_per_page' ) ) {
	function woo_wc_produts_per_page( $cols ) {
		$cols = apply_filters( 'woo_products_per_page', 15 );
		return $cols;
	}
}

// Review gravatar size
function woo_wc_review_gravatar( $size ) {
	$size = 250;
	return $size;
}

// Thumbs
function woo_wc_thumb_cols() {
	return 5; // .last class applied to every 4th thumbnail
}


/*-----------------------------------------------------------------------------------*/
/* Layout */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woo_wc_before_content' ) ) {
	function woo_wc_before_content() {
		global $woo_options;
		?>
		<!-- #content Starts -->
		<?php woo_content_before(); ?>
	    <div id="content" class="col-full">

	        <!-- #main Starts -->
	        <?php woo_main_before(); ?>
	        <div id="main" class="col-left">

	    <?php
	} // End woo_wc_before_content()
}


if ( ! function_exists( 'woo_wc_after_content' ) ) {
	function woo_wc_after_content() {
		?>

			</div><!-- /#main -->
	        <?php woo_main_after(); ?>
	        <?php do_action( 'woocommerce_sidebar' ); ?>

	    </div><!-- /#content -->
		<?php woo_content_after(); ?>
	    <?php
	} // End woo_wc_after_content()
}

function woo_wc_archive_header() {
	if ( is_shop() || is_product_taxonomy() ) {
	?>
		<div class="archive-header">
	<?php
	}
}

function woo_wc_archive_header_end() {
	if ( is_shop() || is_product_taxonomy() ) {
	?>
		</div>
	<?php
	}
}


/*-----------------------------------------------------------------------------------*/
/* Pagination / Search */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woo_wc_pagination' ) ) {
function woo_wc_pagination() {
	if ( is_search() && is_post_type_archive() ) {
		add_filter( 'woo_pagination_args', 'woo_wc_add_search_fragment', 10 );
		add_filter( 'woo_pagination_args_defaults', 'woo_wc_pagination_defaults', 10 );
	}
	woo_pagination();
} // End woo_wc_pagination()
}

if ( ! function_exists( 'woo_wc_add_search_fragment' ) ) {
function woo_wc_add_search_fragment ( $settings ) {
	$settings['add_fragment'] = '&post_type=product';
	return $settings;
} // End woo_wc_add_search_fragment()
}

if ( ! function_exists( 'woo_wc_pagination_defaults' ) ) {
function woo_wc_pagination_defaults ( $settings ) {
	$settings['use_search_permastruct'] = false;
	return $settings;
} // End woo_wc_pagination_defaults()
}

/*-----------------------------------------------------------------------------------*/
/* Cart Fragments */
/*-----------------------------------------------------------------------------------*/

// Ensure cart contents update when products are added to the cart via AJAX
if ( ! function_exists( 'woo_wc_header_add_to_cart_fragment' ) ) {
	function woo_wc_header_add_to_cart_fragment( $fragments ) {
		global $woocommerce;

		ob_start();

		woo_wc_cart_link();

		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	} // End woo_wc_header_add_to_cart_fragment()
}

if ( ! function_exists( 'woo_wc_cart_link' ) ) {
	function woo_wc_cart_link() {
		global $woocommerce;
		?>
		<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><span class="content"><?php echo $woocommerce->cart->get_cart_total(); ?> <span class="count"><?php echo sprintf( _n('%d', '%d', $woocommerce->cart->get_cart_contents_count(), 'woothemes' ), $woocommerce->cart->get_cart_contents_count() );?></span></span></a>
		<?php
	}
}