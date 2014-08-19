<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Template Name: SliderTest
 *
 * The blog page template displays the "blog-style" template on a sub-page.
 *
 * @package WooFramework
 * @subpackage Template
 */

 global $woo_options;
 get_header('slidertest');

/**
 * The Variables
 *
 * Setup default variables, overriding them if the "Theme Options" have been saved.
 */

	$settings = array(
					'thumb_w' => 616,
					//'thumb_h' => 100,
					'thumb_align' => 'alignleft',
                    'woo_pagenav_show' => 'true'
					);

	$settings = woo_get_dynamic_values( $settings );
?>
    <!-- #content Starts -->
    <div id="content" class="col-full">

        <?php woo_main_before(); ?>

        <section id="main" class="col-left">

        <header class="archive-header">
            <h1><?php the_title(); ?></h1>
        </header>

		<?php woo_loop_before(); ?>

        <?php
					get_template_part( 'content', get_post_format() );

        	

        woo_loop_after(); ?>

        

        </section><!-- /#main -->

        <?php woo_main_after(); ?>

		<?php get_sidebar(); ?>

    </div><!-- /#content -->

<?php get_footer(); ?>
