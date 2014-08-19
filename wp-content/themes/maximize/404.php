<?php
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

    <div id="content" class="col-full">

    	<?php woo_main_before(); ?>

		<section id="main" class="col-left">
            <div class="page">
                <div class="page">
                    <article class="page type-page">

        				<header class="page-header no-image">
                        	<h1><?php _e( 'Error 404 - Page not found!', 'woothemes' ); ?></h1>
                        </header>
                        <section class="entry">
                        	<p><?php _e( 'The page you trying to reach does not exist, or has been moved. Please use the menus or the search box to find what you are looking for.', 'woothemes' ); ?></p>

                            <?php

                            if ( apply_filters( 'woo_404_search', true ) ) {
                                get_search_form();
                            }

                            if ( apply_filters( 'woo_404_recent_posts', true ) ) {
                                the_widget( 'WP_Widget_Recent_Posts' );
                            }

                            if ( apply_filters( 'woo_404_archives', true ) ) {
                                the_widget( 'WP_Widget_Archives', 'dropdown=1' );
                            }

                            if ( apply_filters( 'woo_404_tags', true ) ) {
                                the_widget( 'WP_Widget_Tag_Cloud' );
                            }

                            ?>

                        </section>

                    </article><!-- /.post -->
                </div>
            </div>

        </section><!-- /#main -->

        <?php woo_main_after(); ?>

        <?php get_sidebar(); ?>

    </div><!-- /#content -->

<?php get_footer(); ?>