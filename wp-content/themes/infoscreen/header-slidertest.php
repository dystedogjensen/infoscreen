<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Header Template
 *
 * Here we setup all logic and XHTML that is required for the header section of all screens.
 *
 * @package WooFramework
 * @subpackage Template
 */

 global $woo_options, $woocommerce;

?><!DOCTYPE html>
<html <?php language_attributes(); ?> <?php if ( ! is_home() || ! is_front_page() ) { echo 'id="inner"'; } else { echo 'id="home"'; } ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<?php 

if ( ! is_admin() ) {

?>

<link href="/wp-content/themes/infoscreen/notadmin.css" type="text/css" rel="stylesheet" />

<?php

} else { }

?>
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'woothemes' ), max( $paged, $page ) );

	?></title>
<?php woo_meta(); ?>
<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>" />
<?php
wp_head();
woo_head();
?>
</head>
<body <?php body_class(); ?>>
<?php woo_top(); ?>

<?php
if ( ! is_404() && ! is_search() ) {
	$post_background = get_post_meta( $post->ID, '_background', true );
} else {
	$post_background = '';
}
?>
<div id="wrapper" <?php if ( $post_background ) echo 'style="background-image:url(' . $post_background . '); background-attachment: fixed; background-repeat:no-repeat; background-size: cover;"'; ?>>
	<div id="inner-wrapper">
<div id="top_right">
<h4>Åbningstider</h4>
</div>
    <?php woo_header_before(); ?>

	<header id="header">
		<?php woo_header_inside(); ?>



        <?php woo_nav_before(); ?>

        <div class="toggle-and-nav">

	        <span class="nav-toggle"><a href="#navigation" title="<?php _e( 'Toggle Navigation', 'woothemes' ); ?>"><span><?php _e( 'Navigation', 'woothemes' ); ?></span></a></span>

		    <?php
				if ( isset( $woo_options['woocommerce_header_search_form'] ) && 'true' == $woo_options['woocommerce_header_search_form'] && is_woocommerce_activated() ) {

					the_widget( 'WC_Widget_Product_Search', 'title=' );
					?>
					<span class="search-toggle"><a href="#" title="<?php _e( 'Toggle Product Search', 'woothemes' ); ?>"></a></span>
					<?php
				}
			?>
			<?php if ( is_woocommerce_activated() && isset( $woo_options['woocommerce_header_cart_link'] ) && 'true' == $woo_options['woocommerce_header_cart_link'] ) { ?>
	        	<?php woo_wc_cart_link(); ?>
	        <?php } ?>

			<nav id="navigation" class="col-full" role="navigation">

				<div class="inner-nav">

					<section class="menus">

					<?php
					if ( function_exists( 'has_nav_menu' ) && has_nav_menu( 'primary-menu' ) ) {
						echo '<h3>' . woo_get_menu_name('primary-menu') . '</h3>';
						wp_nav_menu( array( 'depth' => 6, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'main-nav', 'menu_class' => 'nav', 'theme_location' => 'primary-menu' ) );
					} else {
					?>
			        <ul id="main-nav" class="nav">
						<?php if ( is_page() ) $highlight = 'page_item'; else $highlight = 'page_item current_page_item'; ?>
						<li class="<?php echo $highlight; ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php _e( 'Home', 'woothemes' ); ?></a></li>
						<?php wp_list_pages( 'sort_column=menu_order&depth=6&title_li=&exclude=' ); ?>
					</ul><!-- /#nav -->
			        <?php } ?>
			        <ul class="nav rss">
			            <?php
			            	$email = '';
			            	$rss = get_bloginfo_rss( 'rss2_url' );

			            	if ( isset( $woo_options['woo_subscribe_email'] ) && ( $woo_options['woo_subscribe_email'] != '' ) ) {
			            		$email = $woo_options['woo_subscribe_email'];
			            	}

			            	if ( isset( $woo_options['woo_feed_url'] ) && ( $woo_options['woo_feed_url'] != '' ) ) {
			            		$rss = esc_url( $woo_options['woo_feed_url'] );
			            	}

			            	if ( $email != '' ) {
			            ?>
			            <li class="sub-email"><a href="<?php echo esc_url( $email ); ?>" target="_blank"><?php _e( 'Email', 'woothemes' ); ?></a></li>
			            <?php } ?>
			            <li class="sub-rss"><a href="<?php echo esc_url( $rss ); ?>"><?php _e( 'RSS', 'woothemes' ); ?></a></li>
			        </ul>

		    	</section><!--/.menus-->

		    	<?php woo_social_icons(); ?>

		    	<?php if ( woo_active_sidebar( 'navigation' ) ) {
					woo_sidebar( 'navigation' );
				} // End IF Statement ?>

		        <a href="#top" class="nav-close"><span><?php _e('Return to Content', 'woothemes' ); ?></span></a>

				</div><!-- /.inner-nav -->

			</nav><!-- /#navigation -->

		</div>

		<?php woo_nav_after(); ?>

	</header><!-- /#header -->

	<?php woo_content_before(); ?>
