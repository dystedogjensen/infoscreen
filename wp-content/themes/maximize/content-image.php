<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * The default template for displaying content with the image post format
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

			if ( has_post_thumbnail( $post->ID ) ) {
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
			} else {
				$image = null;
			}

			if ( $image ) {
				echo '<a href="' . $image[0] . '">';
	    		woo_image( 'link=img&width=' . $settings['thumb_w'] . '&noheight=true&class=thumbnail ' . $settings['thumb_align'] );
	    		echo '</a>';
	    	}
	    ?>

		<header>

			<?php woo_post_meta(); ?>

		</header>

		<section class="entry">
		<?php the_excerpt(); ?>
		</section>

		<footer class="post-more">
			<span class="categories"><?php the_category( ', ') ?></span>
			<span class="comments"><?php comments_popup_link( __( '0', 'woothemes' ), __( '1', 'woothemes' ), __( '%', 'woothemes' ) ); ?></span>
		</footer>

	</article><!-- /.post -->