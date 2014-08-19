<?php get_header(); ?>

    <div id="title-container">
	  <h1 class="title col-full"><?php _e( 'Search results:', 'woothemes' ); ?> <?php the_search_query();?></h1>
	</div>
       
    <div id="content" class="col-full">
            
       	<?php if ( $woo_options[ 'woo_breadcrumbs_show' ] == 'true' ) { ?>
			<div id="breadcrumbs">
				<?php woo_breadcrumbs(); ?>
			</div><!--/#title-container -->
		<?php } ?>
		  	    
		<div id="main" class="col-left">
            			
			<?php if ( have_posts() ) { $count = 0; ?>                      
            <?php while ( have_posts() ) { the_post(); $count++; ?>
                                                                        
            <!-- Post Starts -->
            <div <?php post_class(); ?>>
            
                <?php
                	if ( $woo_options['woo_post_content'] != 'content' ) {
                		$image_args = 'width=' . $woo_options['woo_thumb_w'] . '&height=' . $woo_options['woo_thumb_h'] . '&class=thumbnail ' . $woo_options['woo_thumb_align'];
                		if ( get_post_type() == 'portfolio' ) { $image_args .= '&key=portfolio-image'; }
                		
                		woo_image( $image_args );
                	}
                ?> 
            
                <h2 class="title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                
                <?php woo_post_meta(); ?>
                
                <div class="entry">
                    <?php the_excerpt(); ?>
                </div><!-- /.entry -->
                
    			<div class="fix"></div>
                        
            </div><!-- /.post -->
                                                    
            <?php
            		}
            	} else {
            ?>
            
            <div <?php post_class(); ?>>
                <p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
            </div><!-- /.post -->
         
            <?php } ?>
			<?php woo_pagenav(); ?>
                
        </div><!-- /#main -->

        <?php get_sidebar(); ?>

    </div><!-- /#content -->
		
<?php get_footer(); ?>