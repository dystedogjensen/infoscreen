<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Template Name: Full Width
 *
 * This template is a full-width version of the page.php template file. It removes the sidebar area.
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

    if ( get_the_post_thumbnail( $post->ID ) ) {
        $fImage = get_the_post_thumbnail( $post->ID );
    } else {
        $fImage = false;
    }

?>

    <div id="content" class="page col-full">

    	<?php woo_main_before(); ?>

		<section id="main" class="fullwidth">

        <?php
        	if ( have_posts() ) { $count = 0;
        		while ( have_posts() ) { the_post(); $count++;
        ?>
                <article <?php post_class(); ?>>

                	<header class="page-header <?php if ( $fImage ) { echo 'has-image'; } else { echo 'no-image'; } ?>">

	                    <?php echo woo_embed( 'width=999' ); ?>
	                    <?php if ( $settings['thumb_single'] == 'true' && ! woo_embed( '' ) ) { woo_image( 'link=img&width=' . $settings['single_w'] . '&height=' . $settings['single_h'] . '&class=thumbnail ' . $settings['thumb_single_align'] ); } ?>
					    <h1><?php the_title(); ?></h1>

	                </header>

                    <section class="entry">
	                	<?php the_content(); ?>
	               	</section><!-- /.entry -->

                </article><!-- /.post -->

			<?php
					} // End WHILE Loop
				} else {
			?>
				<article <?php post_class(); ?>>
                	<p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
                </article><!-- /.post -->
            <?php } ?>

		</section><!-- /#main -->

		<?php woo_main_after(); ?>

		<?php get_sidebar(); ?>

    </div><!-- /#content -->

<?php get_footer(); ?>