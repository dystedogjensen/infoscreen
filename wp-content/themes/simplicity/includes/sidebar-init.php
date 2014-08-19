<?php

// Register widgetized areas

if ( !function_exists( 'the_widgets_init' ) ) {
	function the_widgets_init() {
		if ( !function_exists( 'register_sidebars' ) )
			return;

		register_sidebar( array( 'name' => __( 'Primary', 'woothemes' ), 'id' => 'primary', 'description' => __( 'The default sidebar used on your website', 'woothemes' ), 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3>', 'after_title' => '</h3>' ) );
		
		register_sidebar( array( 'name' => __( 'Secondary', 'woothemes' ), 'id' => 'secondary', 'description' => __( 'Optional secondary widget area for pages (hidden if no widgets are added)', 'woothemes' ), 'before_widget' => '<div id="%1$s" class="widget menu %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3>', 'after_title' => '</h3>' ) );
		
		/*
	    register_sidebar(array('name' => 'Secondary Left','id' => 'secondary-1', 'description' => "Left column (part of 2-col sidebar)", 'before_widget' => '<div id="%1$s" class="widget %2$s">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
	    register_sidebar(array('name' => 'Secondary Right','id' => 'secondary-2', 'description' => "Right column (part of 2-col sidebar)", 'before_widget' => '<div id="%1$s" class="widget %2$s">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
*/
		register_sidebar( array( 'name' => __( 'Footer 1', 'woothemes' ), 'id' => 'footer-1', 'description' => __( 'Widgetized footer', 'woothemes' ), 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3>', 'after_title' => '</h3>' ) );
		register_sidebar( array( 'name' => __( 'Footer 2', 'woothemes' ), 'id' => 'footer-2', 'description' => __( 'Widgetized footer', 'woothemes' ), 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3>', 'after_title' => '</h3>' ) );
		register_sidebar( array( 'name' => __( 'Footer 3', 'woothemes' ), 'id' => 'footer-3', 'description' => __( 'Widgetized footer', 'woothemes' ), 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3>', 'after_title' => '</h3>' ) );
		register_sidebar( array( 'name' => __( 'Footer 4', 'woothemes' ), 'id' => 'footer-4', 'description' => __( 'Widgetized footer', 'woothemes' ), 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3>', 'after_title' => '</h3>' ) );
	}
}

add_action( 'init', 'the_widgets_init' );
?>