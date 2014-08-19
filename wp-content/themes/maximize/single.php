<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Single Post Template
 *
 * This template is the default page template. It is used to display content when someone is viewing a
 * singular view of a post ('post' post_type).
 * @link http://codex.wordpress.org/Post_Types#Post
 *
 * @package WooFramework
 * @subpackage Template
 */
	get_header();
	global $woo_options;

/**
 * The Variables
 *
 * Setup default variables, overriding them if the "Theme Options" have been saved.
 */

	$settings = array(
					'thumb_single' => 'false',
					'single_w' => 999,
					//'single_h' => 999,
					'thumb_single_align' => 'alignnone'
					);

	$settings = woo_get_dynamic_values( $settings );
?>

    <div id="content" class="col-full">

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

                <header class="post-header <?php if ( $fImage ) { echo 'has-image'; } else { echo 'no-image'; } ?>">

                	<?php echo woo_embed( 'width=999' ); ?>
               		<?php woo_image( 'link=img&width=' . $settings['single_w'] . '&noheight=true&class=thumbnail ' . $settings['thumb_single_align'] ); ?>
               		<h1><?php the_title(); ?></h1>

                </header>

                <section class="entry fix">
                	<aside class="meta">
                		<p class="post-date"><?php the_time( get_option( 'date_format' ) ); ?></p>
                		<span class="categories"><?php the_category( ', ') ?></span>
						<span class="comments"><?php comments_popup_link( __( 'Leave a comment', 'woothemes' ), __( '1 Comment', 'woothemes' ), __( '% Comments', 'woothemes' ) ); ?></span>
						<?php the_tags( '<span class="tags">', ', ', '</span>' ); ?>
                	</aside>
                	<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'woothemes' ), 'after' => '</div>' ) ); ?>
				</section>

            </article><!-- .post -->

				<?php if ( isset( $woo_options['woo_post_author'] ) && $woo_options['woo_post_author'] == 'true' ) { ?>
				<aside id="post-author" class="fix">
					<div class="profile-image"><?php echo get_avatar( get_the_author_meta( 'ID' ), '250' ); ?></div>
					<div class="profile-content">
						<h2 class="title"><?php printf( esc_attr__( 'About %s', 'woothemes' ), get_the_author() ); ?></h2>
						<?php the_author_meta( 'description' ); ?>
						<div class="profile-link">
							<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
								<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'woothemes' ), get_the_author() ); ?>
							</a>
						</div><!-- #profile-link	-->
					</div><!-- .post-entries -->
				</aside><!-- .post-author-box -->
				<?php } ?>

				<?php woo_subscribe_connect(); ?>

	        <nav id="post-entries" class="fix">
	            <div class="nav-prev fl"><?php previous_post_link( '%link', '%title' ); ?></div>
	            <div class="nav-next fr"><?php next_post_link( '%link', '%title' ); ?></div>
	        </nav><!-- #post-entries -->
            <?php
            	// Determine wether or not to display comments here, based on "Theme Options".
            	if ( isset( $woo_options['woo_comments'] ) && in_array( $woo_options['woo_comments'], array( 'post', 'both' ) ) ) {
            		comments_template();
            	}

				} // End WHILE Loop
			} else {
		?>
			<article <?php post_class(); ?>>
            	<p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
			</article><!-- .post -->
       	<?php } ?>

		</section><!-- #main -->

		<?php woo_main_after(); ?>

        <?php get_sidebar(); ?>

    </div><!-- #content -->

<?php get_footer(); ?>