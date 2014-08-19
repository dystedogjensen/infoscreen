<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Template Name: Business
 *
 * This template creates a business style page optionally including a slider, features and testimonials
 *
 * @package WooFramework
 * @subpackage Template
 */

 global $woo_options;
 get_header();

/**
 * The Variables
 *
 * Setup default variables, overriding them if the "Theme Options" have been saved.
 */

	$settings = array(
                    'thumb_w' => 616,
                    //'thumb_h' => 100,
                    'thumb_align' => 'alignleft',
                    'business_display_slider' => 'true',
                    'business_display_features' => 'true',
                    'business_display_testimonials' => 'true',
                    'business_display_blog' => 'true',
                    'single_w' => 999,
                    'single_h' => 999,
                    'thumb_single_align' => 'alignnone'
                    );

	$settings = woo_get_dynamic_values( $settings );
    $fImage = get_the_post_thumbnail( $post->ID );
?>
    <!-- #content Starts -->
    <div id="content" class="col-full">

        <?php woo_main_before(); ?>

        <section id="main">

            <?php
            // Display WooSlider if activated and specified in theme options
            if ( 'true' == $settings['business_display_slider'] ) {
                do_action( 'wooslider' );
            }
            ?>

        <?php if (have_posts()) : $count = 0; ?>
        <?php while (have_posts()) : the_post(); $count++; ?>

            <div class="page">

            <article <?php post_class(); ?>>

                <header class="page-header <?php if ( $fImage && 'false' == $settings['business_display_slider'] ) { echo 'has-image'; } else { echo 'no-image'; } ?>">

                    <?php if ( 'false' == $settings['business_display_slider'] ) woo_image( 'link=img&width=' . $settings['single_w'] . '&height=' . $settings['single_h'] . '&class=thumbnail ' . $settings['thumb_single_align'] ); ?>
                    <h1><?php the_title(); ?></h1>

                </header>

                <div class="entry">
                    <?php the_content(); ?>
                </div><!-- /.entry -->

            </article><!-- /.post -->

            </div>


        <?php endwhile; else: ?>
        <?php endif; ?>

        <?php
            // Display Features if activated and specified in theme options
            if ( 'true' == $settings['business_display_features'] ) {
                echo '<h2 class="text-center business-title">' . apply_filters( 'maximize_business_features_title', __( 'Features', 'woothemes' ) ) . '</h2>';
                do_action( 'woothemes_features', array( 'limit' => apply_filters( 'maximize_business_features_limit', 10 ) ) );
                echo '<hr />';
            }
            // Display Features if activated and specified in theme options
            if ( 'true' == $settings['business_display_testimonials'] ) {
                echo '<h2 class="text-center business-title">' . apply_filters( 'maximize_business_testimonials_title', __( 'Testimonials', 'woothemes' ) ) . '</h2>';
                do_action( 'woothemes_testimonials', array( 'limit' => apply_filters( 'maximize_business_testimonials_limit', 10 ) ) );
                echo '<hr />';
            }
        ?>

        <?php if ( 'true' == $settings['business_display_blog'] ) { ?>

    		<?php
                echo '<h2 class="text-center business-title">' . apply_filters( 'maximize_business_blog_title', __( 'From the blog...', 'woothemes' ) ) . '</h2>';
                woo_loop_before();
            ?>

            <?php

            	if ( get_query_var( 'paged') ) { $paged = get_query_var( 'paged' ); } elseif ( get_query_var( 'page') ) { $paged = get_query_var( 'page' ); } else { $paged = 1; }

            	$query_args = array(
            						'post_type' => 'post',
            						'paged' => $paged
            					);

            	$query_args = apply_filters( 'woo_blog_template_query_args', $query_args ); // Do not remove. Used to exclude categories from displaying here.

            	remove_filter( 'pre_get_posts', 'woo_exclude_categories_homepage' );

            	query_posts( $query_args );

            	if ( have_posts() ) {
            		$count = 0;
            		while ( have_posts() ) { the_post(); $count++;

    					/* Include the Post-Format-specific template for the content.
    					 * If you want to overload this in a child theme then include a file
    					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
    					 */
    					get_template_part( 'content', get_post_format() );

            		} // End WHILE Loop

            	} else {
            ?>
                <article <?php post_class(); ?>>
                    <p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
                </article><!-- /.post -->
            <?php } // End IF Statement ?>

            <?php woo_loop_after(); ?>

            <?php woo_pagenav(); ?>
    		<?php wp_reset_query(); ?>

        <?php } ?>

        </section><!-- /#main -->

        <?php woo_main_after(); ?>

		<?php get_sidebar(); ?>

    </div><!-- /#content -->

<?php get_footer(); ?>