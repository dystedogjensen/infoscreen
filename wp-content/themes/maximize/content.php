<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * The default template for displaying content
 */

	global $woo_options;

/**
 * The Variables
 *
 * Setup default variables, overriding them if the "Theme Options" have been saved.
 */

 	$settings = array(
					'thumb_w' => 616,
					//'thumb_h' => 999,
					'thumb_align' => 'alignleft'
					);

	$settings = woo_get_dynamic_values( $settings );

?>

	<article <?php post_class(); ?>>

	    <?php
	    	woo_image( 'width=' . $settings['thumb_w'] . '&noheight=true&class=thumbnail ' . $settings['thumb_align'] );
	    ?>

		<header>

			<?php woo_post_meta(); ?>
			<h1><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>

		</header>

		<section class="entry">
		<?php the_excerpt(); ?>
		</section>

		<footer class="post-more">
			<span class="categories"><?php the_category( ', ') ?></span>
			<span class="comments"><?php comments_popup_link( __( '0', 'woothemes' ), __( '1', 'woothemes' ), __( '%', 'woothemes' ) ); ?></span>
		</footer>

	</article><!-- /.post -->