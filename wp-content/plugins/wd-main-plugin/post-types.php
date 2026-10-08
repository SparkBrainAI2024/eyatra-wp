<?php 
/*-------------- portfolio custom posttyp -----------------------*/
 if( ! function_exists('webdevia_portfolio_posttype')): 
  function webdevia_portfolio_posttype() {
    register_post_type( 'portfolio',
      array(
        'labels' => array(
          'name' => __( 'Portfolio', 'metroblocks' ),
          'singular_name' => __( 'portfolio', 'metroblocks' ),
          'add_new' => __( 'Add New Portfolio Item', 'metroblocks' ),
          'add_new_item' => __( 'Add New Portfolio Item', 'metroblocks' ),
          'edit_item' => __( 'Edit portfolio', 'metroblocks' ),
          'new_item' => __( 'Add New Portfolio Item', 'metroblocks' ),
          'view_item' => __( 'View Portfolio Item', 'metroblocks' ),
          'search_items' => __( 'Search Portfolio Item', 'metroblocks' ),
          'not_found' => __( 'No Portfolio Item found', 'metroblocks' ),
          'not_found_in_trash' => __( 'No Portfolio Item found in trash', 'metroblocks' )
        ),
        'public' => true,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => array( 'title', 'thumbnail', 'comments','editor'),
        'capability_type' => 'post',
        'rewrite' => array("slug" => "portfolio"), // Permalinks format
        'menu_position' => 5
      )
    );
    register_taxonomy( 'projet', 'portfolio', array( 'hierarchical' => true,
											                               'label' => 'Categories',
											                               'query_var' => true,
											                               'show_ui' => true,
											                               'rewrite' => true ) );
  }
  add_action( 'init', 'webdevia_portfolio_posttype' );
endif;
/*-------------- portfolio custom posttyp -----------------------*/
 if( ! function_exists('webdevia_woocat_posttype')):
  function webdevia_woocat_posttype() {
    register_post_type( 'product_cat_disc',
      array(
        'labels' => array(
          'name' => __( 'woocat', 'metroblocks' ),
          'singular_name' => __( 'woocat', 'metroblocks' ),
          'add_new' => __( 'Add New woocat Item', 'metroblocks' ),
          'add_new_item' => __( 'Add New woocat Item', 'metroblocks' ),
          'edit_item' => __( 'Edit woocat', 'metroblocks' ),
          'new_item' => __( 'Add New woocat Item', 'metroblocks' ),
          'view_item' => __( 'View woocat Item', 'metroblocks' ),
          'search_items' => __( 'Search woocat Item', 'metroblocks' ),
          'not_found' => __( 'No woocat Item found', 'metroblocks' ),
          'not_found_in_trash' => __( 'No woocat Item found in trash', 'metroblocks' )
        ),
        'public' => true,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => array( 'title', 'thumbnail', 'comments','editor'),
        'capability_type' => 'post',
        'rewrite' => array("slug" => "woocat"), // Permalinks format
        'menu_position' => 5
      )
    );
  }
  add_action( 'init', 'webdevia_woocat_posttype' );
endif;


//----------------------- Custom type Team Member -----------------
if( ! function_exists('webdevia_teammember_posttype')): 
  function webdevia_teammember_posttype() {
    register_post_type( 'team-member',
      array(
        'labels' => array(
          'name' => __( 'Team Members', 'metroblocks' ),
          'singular_name' => __( 'team member', 'metroblocks' ),
          'add_new' => __( 'Add New Team Member', 'metroblocks' ),
          'add_new_item' => __( 'Add New Team Member', 'metroblocks' ),
          'edit_item' => __( 'Edit Team Member', 'metroblocks' ),
          'new_item' => __( 'Add New Team Member', 'metroblocks' ),
          'view_item' => __( 'View Team Member', 'metroblocks' ),
          'search_items' => __( 'Search Team Member', 'metroblocks' ),
          'not_found' => __( 'No Team Member found', 'metroblocks' ),
          'not_found_in_trash' => __( 'No Team Member found in trash', 'metroblocks' )
        ),
        'public' => true,
        'menu_icon' => 'dashicons-businessman',
        'supports' => array( 'title'),
        'capability_type' => 'post',
        'rewrite' => array("slug" => "team-member"), // Permalinks format
        'menu_position' => 5
      )
    );
  }
  add_action( 'init', 'webdevia_teammember_posttype' );
endif;
//----------------------- Custom type Testimonials -----------------
if( ! function_exists('webdevia_testimonials_posttype')):
  function webdevia_testimonials_posttype() {
    register_post_type( 'testimonials',
      array(
        'labels' => array(
          'name' => __( 'Testimonials', 'metroblocks' ),
          'singular_name' => __( 'testimonial', 'metroblocks' ),
          'add_new' => __( 'Add New Testimonial', 'metroblocks' ),
          'add_new_item' => __( 'Add New Testimonial', 'metroblocks' ),
          'edit_item' => __( 'Edit Testimonial', 'metroblocks' ),
          'new_item' => __( 'Add New Testimonial', 'metroblocks' ),
          'view_item' => __( 'View Testimonial', 'metroblocks' ),
          'search_items' => __( 'Search Testimonial', 'metroblocks' ),
          'not_found' => __( 'No Testimonials found', 'metroblocks' ),
          'not_found_in_trash' => __( 'No Testimonials found in trash', 'metroblocks' )
        ),
        'public' => true,
        'menu_icon' 					=> 			'dashicons-format-quote',
        'supports' => array( 'title', 'excerpt'),
        'capability_type' => 'post',
        'rewrite' => array("slug" => "testimonials"), // Permalinks format
        'menu_position' => 5
      )
    );
  }
  add_action( 'init', 'webdevia_testimonials_posttype' );
endif;

