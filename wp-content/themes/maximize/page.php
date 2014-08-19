<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Page Template
 *
 * This template is the default page template. It is used to display content when someone is viewing a
 * singular view of a page ('page' post_type) unless another page template overrules this one.
 * @link http://codex.wordpress.org/Pages
 *
 * @package WooFramework
 * @subpackage Template
 */
	get_header();
	global $woo_options;

    $settings = array(
                    'thumb_single' => 'false',
                    'single_w' => 999,
                    'single_h' => 999,
                    'thumb_single_align' => 'alignnone'
                    );

    $settings = woo_get_dynamic_values( $settings );
?>

    <div id="content" class="page col-full">

    	<?php woo_main_before(); ?>

		<section id="main" class="col-left">

        <?php
        	if ( have_posts() ) { $count = 0;
        		while ( have_posts() ) { the_post(); $count++;
                if ( get_the_post_thumbnail( $post->ID ) ) {
                    $fImage = get_the_post_thumbnail( $post->ID );
                } else {
                    $fImage = false;
                }
        ?>
            <article <?php post_class(); ?>>

                <header class="page-header <?php if ( $fImage ) { echo 'has-image'; } else { echo 'no-image'; } ?>">

                    <?php woo_image( 'link=img&width=' . $settings['single_w'] . '&height=' . $settings['single_h'] . '&class=thumbnail ' . $settings['thumb_single_align'] ); ?>
				    <h1><?php the_title(); ?></h1>

                </header>

                <section class="entry">
                	<?php the_content(); ?>

					<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'woothemes' ), 'after' => '</div>' ) ); ?>
               	</section><!-- /.entry -->

            </article><!-- /.post -->

            <?php
            	// Determine wether or not to display comments here, based on "Theme Options".
            	if ( isset( $woo_options['woo_comments'] ) && in_array( $woo_options['woo_comments'], array( 'page', 'both' ) ) ) {
            		comments_template();
            	}

				} // End WHILE Loop
			} else {
		?>
			<article <?php post_class(); ?>>
            	<p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
            </article><!-- /.post -->
        <?php } // End IF Statement ?>

		</section><!-- /#main -->

		<?php woo_main_after(); ?>

        <?php get_sidebar(); ?>

    </div><!-- /#content -->

<?php get_footer(); ?>