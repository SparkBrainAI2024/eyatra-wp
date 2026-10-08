<?php
/**
 *----------------- include ------------------------------------------
 */
include_once( get_template_directory() . '/inc/tools.php' );
include_once( get_template_directory() . '/inc/plugins/plugins.php' );
include_once( get_template_directory() . '/inc/panel.php' );
include_once( get_template_directory() . '/inc/mega-menu.php' );
require_once( get_template_directory() . '/inc/aq_resizer.php' );
function voip_setup() {
	load_theme_textdomain( 'voip', get_template_directory() . '/languages' );
	if ( function_exists( 'add_theme_support' ) ) {
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats', array( 'gallery', 'link', 'quote', 'video', 'audio' ) );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'woocommerce' );
		add_theme_support( 'custom-background' );
		add_theme_support( 'title-tag' );
		add_theme_support( "custom-header" );
		add_theme_support( 'editor-styles' );
		add_editor_style( 'editor.css' );
		add_editor_style( 'custom-editor-style.css' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-color-palette', array(
			array(
				'name'  => esc_html__( 'Primary Color', 'voip' ),
				'slug'  => 'primary',
				'color' => 'rgba(16,110,170,1)',
			),
			array(
				'name'  => esc_html__( 'Secondary color ', 'voip' ),
				'slug'  => 'secondary ',
				'color' => 'rgba(16,110,170,1)',
			),
		) );
		add_theme_support( 'editor-font-sizes', array(
			array(
				'name'      => esc_html__( 'small', 'voip' ),
				'shortName' => esc_html__( 'S', 'voip' ),
				'size'      => 14,
				'slug'      => 'small'
			),
			array(
				'name'      => esc_html__( 'regular', 'voip' ),
				'shortName' => esc_html__( 'M', 'voip' ),
				'size'      => 16,
				'slug'      => 'regular'
			),
			array(
				'name'      => esc_html__( 'large', 'voip' ),
				'shortName' => esc_html__( 'L', 'voip' ),
				'size'      => 18,
				'slug'      => 'large'
			),
		) );

	}
	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'    => esc_html__( 'Primary Navigation', 'voip' ),
		'right-menu' => esc_html__( 'Right', 'voip' ),
		'login-menu' => esc_html__( 'login menu', 'voip' ),
	) );
}

add_action( 'after_setup_theme', 'voip_setup' );
/*-----------------add Body Classes------------------------------------------*/
function voip_body_classes( $classes ) {
	if ( voip_get_option( 'wd_box_wrapper' ) == 'on' ) {
		$classes[] = 'bg_body_color';
	}

	return $classes;
}

add_filter( 'body_class', 'voip_body_classes' );
function voip_theme_add_editor_styles() {
	add_editor_style( 'custom-editor-style.css' );
}

add_action( 'admin_init', 'voip_theme_add_editor_styles' );
/**
 *-----------------add sidebar------------------------------------------
 */
function voip_widgets_init() {
	//--------------- Widget for Right Sidebar
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Right', 'voip' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to appear in your right sidebar.', 'voip' ),
		'before_widget' => '<section>',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="block-title">',
		'after_title'   => '</h2>',
	) );
	//--------------- Widget for left Sidebar
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Left', 'voip' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here to appear in your left sidebar.', 'voip' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="block-title">',
		'after_title'   => '</h2>',
	) );
	//--------------- Widget for first column Footer
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1st column', 'voip' ),
		'id'            => 'footer',
		'description'   => esc_html__( 'Add widgets here to appear in your first footer column.', 'voip' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="block-title">',
		'after_title'   => '</h2>',
	) );
	//--------------- Widget for 2nd column Footer
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2nd column', 'voip' ),
		'id'            => 'footer_columns_tow',
		'description'   => esc_html__( 'Add widgets here to appear in your 2nd footer column.', 'voip' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="block-title">',
		'after_title'   => '</h2>',
	) );
	//--------------- Widget for 3rd column Footer
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3rd column', 'voip' ),
		'id'            => 'footer_columns_three',
		'description'   => esc_html__( 'Add widgets here to appear in your 3rd footer column.', 'voip' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="block-title">',
		'after_title'   => '</h2>',
	) );
	//--------------- Widget for 4th column Footer
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 4th column', 'voip' ),
		'id'            => 'footer_columns_four',
		'description'   => esc_html__( 'Add widgets here to appear in your 4th footer column.', 'voip' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="block-title">',
		'after_title'   => '</h2>',
	) );
	//--------------- Widget for woocomerce Sidebar
	register_sidebar( array(
		'name'          => esc_html__( 'Woocommerce Sidebar', 'voip' ),
		'id'            => 'shop-widgets',
		'description'   => esc_html__( 'Appears on the shop page of your website.', 'voip' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s shop-widgets sidebar">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="block-title">',
		'after_title'   => '</h2>',
	) );
}

add_action( 'widgets_init', 'voip_widgets_init' );
/**
 *--------------- Image presets-----------
 */
add_image_size( 'voip_small-thumb', 100, 70, true );
add_image_size( 'voip_sidebar-thumb', 160, 150, true );
add_image_size( 'voip_recent-blog-h', 465, 243, true );
add_image_size( 'voip_recent-blog-v', 390, 308, true );
add_image_size( 'voip_blog-thumb', 880, 350, true );
add_image_size( 'voip_650x350', 650, 350, true );
add_image_size( 'voip_team', 550, 576, true );
add_image_size( 'voip_team_member_slider', 744, 833, true );
add_image_size( 'voip_team_member_carousel', 370, 370, true );
add_image_size( 'voip_sidebar-thumb', 140, 140, true );
add_image_size( 'voip_1900x620', 1900, 620, true );
/**
 * ---------------load scripts and styles--------------------------------
 */
function voip_fonts_url( $voip_font_body_name, $voip_font_weight_style, $voip_main_text_font_subsets ) {
	$voip_font_url = '';
	/*
	Translators: If there are characters in your language that are not supported
	by chosen font(s), translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Google font: on or off', 'voip' ) ) {
		$voip_font_url = add_query_arg( 'family', urlencode( $voip_font_body_name . ':' . $voip_font_weight_style . '&subset=' . $voip_main_text_font_subsets ), "//fonts.googleapis.com/css" );
	}

	return $voip_font_url;
}

function voip_wp_admin_style() {
	$voip_protocol = is_ssl() ? 'https' : 'http';
	wp_enqueue_style( 'wd_body_google_fonts', voip_fonts_url('Poppins','100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&subset=devanagari','latin-ext' ));
}

add_action( 'admin_enqueue_scripts', 'voip_wp_admin_style' );

function voip_load_js_css_file() {
	/*----------google -fonts ------------------*/
	$voip_font_body_name               = voip_get_option( 'wd_body_font_familly', "default" );
	$voip_font_weight_style            = '300,400,500,600,700';
	$voip_main_text_font_subsets       = voip_get_option( 'wd_main-text-font-subsets' );
	$font_header_name                  = voip_get_option( 'wd_head_font_familly', "default" );
	$voip_heading_font_weight_style    = '300,400,500,600,700';
	$voip_heading_text_font_subsets    = voip_get_option( 'wd_heading-text-font-subsets' );
	$voip_navigation_font_familly      = voip_get_option( 'wd_navigation_font_familly', "default" );
	$voip_navigation_font_weight_style = '300,400,500,600,700';
	$voip_navigation_text_font_subsets = voip_get_option( 'wd_navigation-text-font-subsets' );
	$voip_protocol                     = is_ssl() ? 'https' : 'http';
	if ( is_rtl() ) {
		wp_enqueue_style( 'voip_body_google_fonts', voip_fonts_url('Droid Arabic Kufi', '400,700', 'latin,latin-ext'), array(), '1.0.0' );
	} elseif ( $voip_font_body_name != "default" ) {
		wp_enqueue_style( 'voip_body_google_fonts', voip_fonts_url( $voip_font_body_name, $voip_font_weight_style, $voip_main_text_font_subsets ), array(), '1.0.0' );
	} else {
		wp_enqueue_style( 'wd_body_google_fonts', voip_fonts_url('Poppins', '100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i', 'latin,latin-ext'), array(), '1.0.0' );
	}
	if ( $font_header_name != "default" ) {
		wp_enqueue_style( 'voip_header_google_fonts', voip_fonts_url( $font_header_name, $voip_heading_font_weight_style, $voip_main_text_font_subsets ), array(), '1.0.0' );
	}
	if ( $voip_navigation_font_familly != "default" ) {
		wp_enqueue_style( 'wd_navigation_google_fonts', voip_fonts_url( $voip_navigation_font_familly, $voip_navigation_font_weight_style, $voip_navigation_text_font_subsets ), array(), '1.0.0' );
	}
	wp_enqueue_style( 'animation-custom', get_template_directory_uri() . "/css/animate-custom.css" );
	wp_enqueue_style( 'customstyle', get_template_directory_uri() . "/css/app.css" );
	wp_enqueue_style( 'component', get_template_directory_uri() . "/css/vendor/component.css" );
	wp_enqueue_style( 'custom-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'owlcarouselstyl', get_template_directory_uri() . "/css/owl.carousel.css" );
	wp_enqueue_style( 'woocommerce', get_template_directory_uri() . "/css/woocommerce.css" );
	wp_enqueue_style( 'mediaelementplayer', get_template_directory_uri() . "/css/mediaelementplayer.css" );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . "/css/font-awesome.min.css" );
	if ( is_singular() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	$voip_google_map_key = voip_get_option( 'voip_google_map_key' );
	if ( $voip_google_map_key ) {
		wp_enqueue_script( 'googlemaps', $voip_protocol."://maps.googleapis.com/maps/api/js?key=" . $voip_google_map_key, array( 'jquery' ) );
	}

	wp_enqueue_script( 'zeptojs', get_template_directory_uri() . "/js/vendor/zeptojs.js", array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'appear', get_template_directory_uri() . "/js/vendor/appear.js", array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'easing', get_template_directory_uri() . "/js/vendor/easing.js", array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . "/js/vendor/modernizr.js", array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . "/js/vendor/owl.carousel.min.js", array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'owl-carousel2-thumbs', get_template_directory_uri() . "/js/vendor/owl.carousel2.thumbs.js", array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'packery-metafizzy', get_template_directory_uri() . "/js/vendor/packery.metafizzy.js", array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'isotope', get_template_directory_uri() . "/js/vendor/isotope.min.js", array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'counterup', get_template_directory_uri() . "/js/vendor/counterup.js", array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'easypiechart', get_template_directory_uri() . "/js/vendor/easypiechart.js", array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'waypoints', get_template_directory_uri() . "/js/vendor/waypoints.js", array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'shortcodes-js', get_template_directory_uri() . "/js/shortcode/script-shortcodes.js", array( 'jquery' ) );
	wp_enqueue_script( 'voip_plugins-owl', get_template_directory_uri() . "/js/wd_owlcarousel.js", array( 'jquery' ) );
	// eYatra: only load the map script on pages that actually render a map.
	// It was previously enqueued site-wide while no [voip_maps] shortcode remained.
	$voip_map_post_id = (int) get_queried_object_id();
	if ( $voip_google_map_key ) {
		wp_enqueue_script( 'voip_maps', get_template_directory_uri() . "/js/wd-maps.js", array( 'jquery' ) );
	} elseif ( $voip_map_post_id ) {
		// Strip HTML comments first: the map shortcode is kept as a disabled
		// restore hint in a comment and has_shortcode() would match it there.
		$voip_map_content = preg_replace( '/<!--.*?-->/s', '', (string) get_post_field( 'post_content', $voip_map_post_id ) );
		if ( has_shortcode( $voip_map_content, 'voip_maps' ) ) {
			wp_enqueue_script( 'voip_maps', get_template_directory_uri() . "/js/wd-maps.js", array( 'jquery' ) );
		}
	}
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/js/scripts.js', array( 'jquery', 'hoverIntent' ) );
	global $wp_query;
	if ( ! is_search() and ! is_404() and ! is_admin() ) {
		$voip_thePageID = $wp_query->post->ID;
	} else {
		$voip_thePageID = "";
	}
	if ( function_exists( 'WC' ) ) {
		if ( is_shop() ) {
			$voip_thePageID = get_option( 'woocommerce_shop_page_id' );
		}
	}

	$voip_style       = get_post_meta( $voip_thePageID, 'wd_page_title_area_style', true );
	$voip_page_bg_img = get_post_meta( $voip_thePageID, 'wd_page_title_area_bg_img', true );
	wp_enqueue_style( 'custom-line', get_template_directory_uri() . '/style.css' );
	//********* inline style ***************/
	$voip_custom_css    = "";
	$voip_custom_css    .= "";
	$voip_custom_css    .= ".l-footer-columns { background-color: " . voip_get_option( 'footer_bg_color' ) . "}";
	$voip_custom_css    .= ".l-footer-columns, .l-footer-columns .block-title , .l-footer-columns ul li a { color: " . voip_get_option( 'footer_text_color' ) . "}";
	$voip_custom_css    .= ".l-footer { background-color: " . voip_get_option( 'copyright_bg_color' ) . "; color: " . voip_get_option( 'copyright_text_color' ) . ";}";
	$voip_footer_bg_img = voip_get_option( 'wd_footer_bg_image', true ) == '' ? '' : voip_get_option( 'wd_footer_bg_image', true );
	$voip_custom_css    .= "
            .l-footer-columns {
              background-image: url('$voip_footer_bg_img');
              background-size: cover;

            }";
	if ( $voip_page_bg_img != "" ) {
		//-------------title page--------------
		$voip_custom_css .= "
      .titlebar {
        background:url($voip_page_bg_img) " . esc_html( get_post_meta( $voip_thePageID, 'wd_page_title_area_bg_color', true ) ) . " no-repeat;
        width:100%;
        text-align:" . esc_html( get_post_meta( $voip_thePageID, 'wd_page_title_position', true ) ) . ";
        background-size: cover;
      }
      #page-title,.breadcrumbs a{
        color:" . esc_html( get_post_meta( $voip_thePageID, 'wd_page_title_color', true ) ) . ";
      }
      .titlebar::after {
	      background-color: rgba(0,0,0,0.1);
	    }";
	}
	if ( $voip_page_bg_img == "" ) {
		$voip_title_bg_image = voip_get_option( 'voip_title_bg_image' );
		if ( $voip_title_bg_image !== '' ) {
			$voip_custom_css .= "
      .titlebar {
        background:url($voip_title_bg_image)  no-repeat;
        
        width:100%;
        text-align:" . esc_html( get_post_meta( $voip_thePageID, 'wd_page_title_position', true ) ) . ";
        background-size: cover;
      }
      #page-title,.breadcrumbs a{
        color:" . esc_html( get_post_meta( $voip_thePageID, 'wd_page_title_color', true ) ) . ";
      }";
		}
	}
	$voip_custom_css .= "
	  .header-top.social_top_bar, .orange_bar {
			background : " . esc_html( voip_get_option( 'adress_bar_bgcolor' ) ) . ";
		}
	  .header-top.social_top_bar, .orange_bar,
	  .l-header .header-top .contact-info,
	  .l-header .header-top i,
	  .l-header .header-top .social-icons.accent li i,
	  #lang_sel_list a.lang_sel_sel, #lang_sel_list > ul > li a {
			color : " . esc_html( voip_get_option( 'adress_bar_color' ) ) . ";
		}
		";
	if ( voip_get_option( 'wd_box_wrapper' ) == 'on' ) {
		$voip_custom_css .= "
 							.bg_body_color {
 								background : " . esc_html( voip_get_option( 'wrapper_bg_color','#fff' ) ) . ";
 							}
 			";
	}
	if ( is_rtl() ) {
		$voip_custom_css .= "body, p, #lang_sel_list {
            font-family : 'Droid Arabic Kufi', serif;
          } ";
		$voip_custom_css .= "h1, h2, h3, h4, h5, h6 {
              font-family : 'Droid Arabic Naskh', serif;
            } ";
	} else {
		if ( ( voip_get_option( 'wd_body_font_familly' ) != 'default' ) && ( voip_get_option( 'wd_body_font_familly' ) != false ) ) {
			$voip_custom_css .= "body, body p {
    	font-family :'" . esc_html( voip_get_option( 'wd_body_font_familly' ) ) . "';
    	font-weight :" . esc_html( voip_get_option( 'wd_font-weight-style' ) ) . ";
    }";
			if ( voip_get_option( 'wd_main_text_lettre_spacing' ) != false && voip_get_option( 'wd_main_text_lettre_spacing' ) != "" ) {
				$voip_custom_css .= "body, body p {
	    	letter-spacing :" . esc_html( voip_get_option( 'wd_main_text_lettre_spacing' ) ) . ";
	  	}";
			}
		} else {
			$voip_custom_css .= "body, body p {
    	font-family: 'Poppins', sans-serif;
    	font-weight :" . esc_html( voip_get_option( 'wd_font-weight-style' ) ) . ";
    }";
			if ( voip_get_option( 'wd_main_text_lettre_spacing' ) != false && voip_get_option( 'wd_main_text_lettre_spacing' ) != "" ) {
				$voip_custom_css .= "body, body p {
	    	letter-spacing :" . esc_html( voip_get_option( 'wd_main_text_lettre_spacing' ) ) . ";
	  	}";
			}
		}
		if ( ( voip_get_option( 'wd_head_font_familly' ) != 'default' ) && ( voip_get_option( 'wd_head_font_familly' ) != false ) ) {
			$voip_custom_css .= "h1, h2, h3, h4, h5, h6, .menu-list a {
    	font-family :'" . esc_html( voip_get_option( 'wd_head_font_familly' ) ) . "';
    	font-weight :" . esc_html( voip_get_option( 'wd_heading-font-weight-style' ) ) . ";
    }";
			if ( voip_get_option( 'wd_heading_text_lettre_spacing' ) != false && voip_get_option( 'wd_heading_text_lettre_spacing' ) != "" ) {
				$voip_custom_css .= "h1, h2, h3, h4, h5, h6, .menu-list a {
	    	letter-spacing :" . esc_html( voip_get_option( 'wd_heading_text_lettre_spacing' ) ) . ";
	  	}";
			}
		} else {
			$voip_custom_css .= "h1, h2, h3, h4, h5, h6, .menu-list a {
    	font-family: 'Poppins', sans-serif;
    	font-weight :" . esc_html( voip_get_option( 'wd_heading-font-weight-style' ) ) . ";
    }";
			if ( voip_get_option( 'wd_heading_text_lettre_spacing' ) != false && voip_get_option( 'wd_heading_text_lettre_spacing' ) != "" ) {
				$voip_custom_css .= "h1, h2, h3, h4, h5, h6, .menu-list a {
	    	letter-spacing :" . esc_html( voip_get_option( 'wd_heading_text_lettre_spacing' ) ) . ";
	  	}";
			}
		}
		if ( ( voip_get_option( 'wd_navigation_font_familly' ) != 'default' ) && ( voip_get_option( 'wd_navigation-font-weight-style' ) != false ) ) {
			$voip_custom_css .= ".top-bar-section .main-nav > li > a:not(.button),.top-bar-section ul li > a {
			font-family : '" . esc_html( voip_get_option( 'wd_navigation_font_familly' ) ) . "';
			font-weight : " . esc_html( voip_get_option( 'wd_navigation-font-weight-style' ) ) . ";

		}";
			if ( voip_get_option( 'wd_navigation_text_lettre_spacing' ) != false && voip_get_option( 'wd_navigation_text_lettre_spacing' ) != "" ) {
				$voip_custom_css .= ".top-bar-section ul li > a {
	    	letter-spacing :" . esc_html( voip_get_option( 'wd_navigation_text_lettre_spacing' ) ) . ";
	  	}";
			}
		} else {
			$voip_custom_css .= ".corporate-layout .top-bar-section ul.menu > li > a {
			font-family: 'Poppins', sans-serif;
			font-weight : " . esc_html( voip_get_option( 'wd_navigation-font-weight-style' ) ) . ";
		}";
			if ( voip_get_option( 'wd_navigation_text_lettre_spacing' ) != false && voip_get_option( 'wd_navigation_text_lettre_spacing' ) != "" ) {
				$voip_custom_css .= ".top-bar-section ul li > a {
	    	letter-spacing :" . esc_html( voip_get_option( 'wd_navigation_text_lettre_spacing' ) ) . ";
	  	}";
			}
		}
	}

	$social_bar_color    = voip_get_option( 'social_bar_color' );
	$social_bar_bg_color = voip_get_option( 'social_bar_bg_color' );
	if ( $social_bar_bg_color ) {
		$voip_custom_css .= "
		.top_address_bar {
      background: " . $social_bar_bg_color . ";
		}
	";
	}
	if ( $social_bar_color ) {
		$voip_custom_css .= "
		.top_address_bar, .social-icons.accent li i {
      color: " . $social_bar_color . ";
		}
	";
	}

	$voip_custom_css .= "

		.primary-color_bg, .square-img > a:before,
		.boxes .box > a:before, .boxes .box .flipper a:before,
		input.wpcf7-submit, .square-img > a::before, .boxes .box > a::before,
		 .boxes .box .flipper a::before, .wd_onepost .title-block span, 
		 .one_post_box .box_image .titel_icon .box_icon, .one_post_box .more,
	  .boxes .box-container > a::before, .boxes .box-container .flipper a::before,
	   .layout-4 div.box-icon i.fa, .boxes.small.layout-5 .box-icon,
    .boxes.small.layout-5-inverse .box-icon, .boxes.small.layout-6 .box-icon i.fa,
     .carousel_blog span.tag a, .wd-carousel-container .carousel-icon i,
    table thead, table tfoot, .block-block-17, .row.call-action, .blog-info,
     span.wpb_button:hover, span.wpb_button:focus
		.wd_onepost .title-block span, .one_post_box .box_image .titel_icon .box_icon,
		.one_post_box .more, .boxes .box-container > a:before,
		.boxes .box-container .flipper a:before, .layout-4 div.box-icon i.fa,
		.boxes.small.layout-5 .box-icon, .boxes.small.layout-5-inverse .box-icon,
		.boxes.small.layout-6 .box-icon i.fa, .carousel_blog span.tag a,
		.wd-carousel-container .carousel-icon i, .search_box input[type='submit'],
		table thead, table tfoot, .block-block-17, .row.call-action, .blog-info,
		button.dark:hover, button.dark:focus, .button.dark:hover, .button.dark:focus,
		span.wpb_button:hover, span.wpb_button:focus,
		.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
		.woocommerce-page .widget_price_filter .ui-slider .ui-slider-range,
		.products .product .button,
		.woocommerce #content input.button.alt, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt,
		.woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce-page #content input.button.alt,
		.woocommerce-page #respond input#submit.alt, .woocommerce-page a.button.alt,
		.woocommerce-page button.button.alt, .woocommerce-page input.button.alt,
		.woocommerce #content input.button:hover, .woocommerce #respond input#submit:hover,
		.woocommerce a.button:hover, .woocommerce button.button:hover,
		.woocommerce input.button:hover, .woocommerce-page #content input.button:hover,
		.woocommerce-page #respond input#submit:hover, .woocommerce-page a.button:hover,
		.woocommerce-page button.button:hover, .woocommerce-page input.button:hover,
		.woocommerce span.onsale, .woocommerce-page span.onsale,
		.woocommerce-page button.button, .widget_product_search #searchsubmit, .widget_product_search #searchsubmit:hover,
		.l-footer-columns #searchsubmit,.page-numbers.current,.post-password-form input[type='submit'],
		.page-links a:hover,
		.blog-post .sticky .blog-info, .team-member-slider .owl-dots .owl-dot.active span, .team-member-slider .owl-theme .owl-dots .owl-dot:hover span,
		.team-member-carousel .owl-dots .owl-dot.active span, .team-member-carousel .owl-theme .owl-dots .owl-dot:hover span,
		#comments ul.commentlist li.comment section.comment .comment-reply-link, #comments ol.commentlist li.comment section.comment .comment-reply-link, 
		.wd-image-text.style-2 h4:after,.woocommerce-page input.button,.woocommerce-page a.button,#tribe-events .tribe-events-button,#tribe-bar-form .tribe-bar-submit input[type='submit']:hover,
		.tribe-events-calendar thead th,.l-footer-columns h2::after, .l-footer-columns .newsletter-div .newslettersubmit,
		div.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-heading, div.vc_tta-color-grey.vc_tta-style-classic .vc_tta-tab.vc_active > a,
		.team-member-name-job-title
		  {
						background :		" . esc_html( voip_get_option( 'primary_color', '#F7A901' ) ) . ";
		}
		.text_icon_hover > div .vc_row:hover
		  {
						background :		" . esc_html( voip_get_option( 'primary_color', '#F7A901' ) ) . " !important;
		}
		  .text_icon_hover > div .vc_row:hover .box-title-1, .text_icon_hover > div .vc_row:hover .box-body{
		  	color : #fff;
		  }
		.blog-post .sticky .blog-info {
			background: " . esc_html( voip_get_option( 'primary_color', '#F7A901' ) ) . " repeating-linear-gradient(-55deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3) 10px, rgba(0, 0, 0, 0) 10px, rgba(0, 0, 0, 0) 20px) repeat scroll 0 0;
		}

		.sidebar #s:active,
    .sidebar #s:focus, .boxes.layout-3 .box-icon,.top-bar-section ul li:hover,.corporate-layout .top-bar-section ul li:hover,.corporate-layout .top-bar-section ul li.current-menu-item,
     div.vc_tta-color-grey.vc_tta-style-classic .vc_tta-tab.vc_active > a, 
     .contact_form .contact .wpb_wrapper label .wpcf7-text, 
     .contact_form .contact .wpb_wrapper label span.your-message .wpcf7-textarea
     {
      border-color :    " . esc_html( voip_get_option( 'primary_color', '#F7A901' ) ) . ";
    }
    div.vc_tta-color-grey.vc_tta-style-classic .vc_tta-tab > a {
    border-bottom-color :    " . esc_html( voip_get_option( 'primary_color', '#F7A901' ) ) . ";
    }
    .blog-info .arrow {
      border-color: transparent " . esc_html( voip_get_option( 'primary_color', '#F7A901' ) ) . ";
		}

		.primary-color_color, a, a:focus, a.active, a:active, a:hover, .boxes.small .box-icon i,
		 .box-container:hover .box-title a, a:focus, a.active, a:active, a:hover,section.corporate .menu-item a i,
		 .box-container:hover .box-title, .blog-posts i, .woocommerce .woocommerce-breadcrumb, .woocommerce-page .woocommerce-breadcrumb,
		  div.boxes.small.layout-3 .box-icon i,.corporate-layout .header-top .contact-info .fa,
		 .l-header .header-top .social-icons.accent li:hover i,.corporate-layout .top-bar-section ul li:hover:not(.has-form) > a,
		 .corporate-layout .top-bar-section ul.menu > li.current-menu-item > a, .l-footer-columns ul li a::before,
		 .breadcrumbs > *
		  {
				color : 	" . esc_html( voip_get_option( 'primary_color', '#F7A901' ) ) . " ;
		}
		 .boxes.small.layout-3 .box-icon i,
		  div.boxes.small.layout-3:hover .box-icon i {
		   color: rgba(255,255,255,1);
		 }

		.blog-posts h2 a, .breadcrumbs {
			color : " . esc_html( voip_get_option( 'secondary_color' ) ) . "
		}
		button, button:hover, button:focus, .button:hover, .button:focus, .products .product:hover .button,
		.woocommerce-product-search > input[type='submit'] {
			background-color : " . esc_html( voip_get_option( 'secondary_color' ) ) . "
		}

		.corporate-layout .top-bar-section ul.menu > li > a,
		.creative-layout .top-bar-section ul li > a {
      color :    " . esc_html( voip_get_option( 'navigation_text_color', '#fff' ) ) . ";
    }

    .contain-to-grid.sticky.fixed {
			background-color:" . esc_html( voip_get_option( 'navigation_bg_color_sticky', '#FFF' ) ) . ";
		}

		.l-footer-columns, .l-footer-columns .block-title , .l-footer-columns ul li a {
			color: " . esc_html( voip_get_option( 'footer_text_color' ) ) . "
		}

		.l-footer {
			background-color : " . esc_html( voip_get_option( 'copyright_bg' ) ) . "
		}

		.contain-to-grid.sticky.fixed , .top-bar , .corporate-layout .contain-to-grid.sticky, header.l-header,.corporate-layout .contain-to-grid {
			background-color : " . esc_html( voip_get_option( 'header_bg' ) ) . "
		}

		#spaces-main {
			background-color : " . esc_html( voip_get_option( 'container_bg' ) ) . "
		}";
	$voip_custom_css .= html_entity_decode( voip_get_option( 'wd_theme_custom_css' ) );
	$voip_custom_css .= "
											.blog-info .arrow {
    									border-left-color:" . voip_get_option( 'primary_color' ) . " ;
												}
												.ui-accordion-header-active, .ui-tabs-active, .box-icon {
													border-top-color:" . voip_get_option( 'primary_color' ) . "
												}

												";
	wp_add_inline_style( 'customstyle', $voip_custom_css );
	//*********/inline style***************/
}

add_action( 'wp_enqueue_scripts', 'voip_load_js_css_file' );
/**
 * ---------------menu--------------------------------
 */
$voip_count = 1;

class voip_top_bar_walker extends Walker_Nav_Menu {
	static protected $menu_bg_test;

	function start_el( &$output, $item, $depth = 0, $args = Array(), $id = 0 ) {
		$voip_class = "";
		if ( is_object( $args ) ) {
			global $voip_count;
			$icon = $item->classes[1];
			if ( $item->mega_menu == 1 ) {
				$voip_class = 'wd_mega-menu';
			}
			$voip_icon          = $item->mega_menu_icon;
			self::$menu_bg_test = $item->mega_menu_bg_image;
			$indent             = ( $depth ) ? str_repeat( "\t", $depth ) : '';
			$class_names        = $value = '';
			$classes            = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[]          = ( $item->current ) ? 'active' : '';
			$classes[]          = ( $args->has_children ) ? ' color-1 has-dropdown not-click' : '';
			$args->link_before  = ( in_array( 'section', $classes ) ) ? '<label>' : '';
			$args->link_after   = ( in_array( 'section', $classes ) ) ? '</label>' : '';
			$output             .= ( in_array( 'section', $classes ) );
			$class_names        = ( $args->has_children ) ? 'has-dropdown not-click ' . $voip_class : '';
			$class_names        .= ( $item->current ) ? ' active_menu' : '';
			$parent             = $item->menu_item_parent;
			if ( $parent == 0 ) {
				$voip_count ++;
			}
			$current_page = empty( $item->classes[4] ) ? '' : $item->classes[4];
			$class_names  .= ' color-' . $voip_count . ' ' . $current_page;
			$class_names  = strlen( trim( $class_names ) ) > 0 ? ' class="' . esc_attr( $class_names ) . '"' : '';
			$output       .= $indent . '
			<li id="menu-item-' . $item->ID . '"' . $value . $class_names . '>';
			$attributes   = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
			$attributes   .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
			$attributes   .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
			$attributes   .= ! empty( $item->url ) ? ' href="' . esc_url( $item->url ) . '"' : '';
			$attributes   .= ' class="has-icon"';
			$item_output  = $args->before;
			$item_output  .= ( ! in_array( 'section', $classes ) ) ? '
			<a' . $attributes . '>' : '';
			if ( ( $icon != '' ) and ( $icon != '---- None ----' ) ) {
				$item_output .= '<i class="' . $voip_icon . ' fa"></i> ';
			}
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID );
			$item_output .= $args->link_after;
			$item_output .= ( ! in_array( 'section', $classes ) ) ? '</a>' : '';
			$item_output .= $args->after;
			$output      .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}

	function end_el( &$output, $item, $depth = 0, $args = Array() ) {
		$output .= '
</li>' . "\n";
	}

	function start_lvl( &$output, $depth = 0, $args = Array() ) {
		$indent = str_repeat( "\t", $depth );
		if ( isset( $menu_bg_test ) && $menu_bg_test != "" ) {
			$output .= "\n" . $indent . '
<ul class="sub-menu dropdown " style = "background-image : url(' . self::$menu_bg_test . ')">
	' . "\n";
		} else {
			$output .= "\n" . $indent . '
			<ul class="sub-menu dropdown ">
	' . "\n";
		}
	}

	function end_lvl( &$output, $depth = 0, $args = Array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= $indent . '

 </ul>' . "\n";
	}

	function display_element( $element, &$children_elements, $max_depth, $depth  , $args, &$output ) {
		$id_field = $this->db_fields['id'];
		if ( is_object( $args[0] ) ) {
			$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
		}

		return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
}

function voip_main_menu_fallback() {
	if(is_user_logged_in()) {
	echo '<div class="empty-menu">';
	echo esc_html__( 'Please assign a menu to the primary menu location under ', 'voip' ); ?>
  <a href="<?php get_admin_url( get_current_blog_id(), 'nav-menus.php' ) ?>"><?php echo esc_html__('Menus Settings','voip') ?></a>
  </div> <?php
  }
}

/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 625;
}
/*---------wooocomerce---------*/
//Reposition WooCommerce breadcrumb
function voip_woocommerce_remove_breadcrumb() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
}

add_action( 'woocommerce_before_main_content', 'voip_woocommerce_remove_breadcrumb' );
function voip_woocommerce_custom_breadcrumb() {
	woocommerce_breadcrumb();
}

add_action( 'woo_custom_breadcrumb', 'voip_woocommerce_custom_breadcrumb' );
// Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
add_filter( 'woocommerce_add_to_cart_fragments', 'voip_woocommerce_header_add_to_cart_fragment' );
function voip_woocommerce_header_add_to_cart_fragment( $fragments ) {
	ob_start();
	?>
  <a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>"
     title="<?php echo esc_attr__( 'View your shopping cart', 'voip' ); ?>"><?php echo sprintf( esc_html__( '%d item', 'voip', WC()->cart->cart_contents_count ), WC()->cart->cart_contents_count ); ?>
    - <?php echo WC()->cart->get_cart_total(); ?></a>
	<?php
	$fragments['a.cart-contents'] = ob_get_clean();

	return $fragments;
}


// retrieves the attachment ID from the file URL
function voip_get_image_id( $image_url ) {
	global $wpdb;
	$image_url  = esc_sql( $image_url );
	$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ) );
	if ( isset( $attachment[0] ) ) {
		return $attachment[0];
	}
}

// initialize options
if ( ! function_exists( 'voip_initialize_options' ) ) {
	function voip_initialize_options() {
		if ( ! get_option( "wd_options_array" ) ) {
			$options_array = get_option( "wd_options_array" );
			$options_array = array(
				'wd_show_logo'                      => "",
				'wd_show_cart'                      => "",
				'wd_show_top_social_bare'           => "",
				'wd_box_wrapper'                    => "",
				'wd_menu_in_grid'                   => "off",
				'wd_menu_sticky'                    => "",
				'wd_show_title'                     => "",
				'wd_footer_bg_image'                => "",
				'footer_bg_color'                   => "",
				'footer_text_color'                 => "",
				'wd_copyright'                      => "",
				'wd_poweredby'                      => "",
				'copyright_text_color'              => "",
				'wd_logo'                           => "",
				'wd_404_page'                       => "",
				'wd_home_page'                      => "",
				'wd_favicon'                        => "",
				'wd_theme_custom_css'               => "",
				'wrapper_bg_color'                  => "",
				'primary_color'                     => "",
				'secondary_color'                   => "",
				'adress_bar_color'                  => "",
				'social_bar_color'                  => "",
				'copyright_bg'                      => "",
				'header_bg'                         => "",
				'container_bg'                      => "",
				'wd_footer_columns'                 => "",
				'navigation_text_color'             => "",
				'navigation_bg_color_sticky'        => "",
				'footer_text_color'                 => "",
				'wd_copyright'                      => "",
				'language_area_html'                => "",
				'voip_show_wpml_widget'             => '',
				'twitter'                           => "",
				'facebook'                          => "",
				'flickr'                            => "",
				'vimeo'                             => "",
				'phone'                             => "",
				'adress'                            => "",
				'wd_body_font_familly'              => "",
				'wd_font-weight-style'              => "",
				'wd_main_text_lettre_spacing'       => '',
				'wd_main-text-font-subsets'         => "",
				'wd_head_font_familly'              => "",
				'wd_heading-font-weight-style'      => "",
				'wd_heading-text-font-subsets'      => "",
				'wd_heading_text_lettre_spacing'    => "",
				'wd_navigation_font_familly'        => "",
				'wd_navigation-font-weight-style'   => "",
				'wd_navigation-text-font-subsets'   => "",
				'wd_navigation_text_lettre_spacing' => "",
				'wd_menu_style'                     => "",
				'wd_theme_custom_js'                => ""
			);
			update_option( "wd_options_array", $options_array );
		}
	}
}
// get options value
if ( ! function_exists( 'voip_get_option' ) ) {
	function voip_get_option( $voip_option_key, $voip_option_default_value = null ) {
		voip_initialize_options();
		$options_array   = get_option( "wd_options_array" );
		$voip_meta_value = "";
		if ( array_key_exists( $voip_option_key, $options_array ) ) {
			if ( isset( $options_array[ $voip_option_key ] ) && ! empty( $options_array[ $voip_option_key ] ) ) {
				$voip_meta_value = esc_attr( $options_array[ $voip_option_key ] );
			}
			if ( $voip_meta_value == "" ) {
				$voip_meta_value = $voip_option_default_value;
			}
		}

		return $voip_meta_value;
	}
}
// get options value
if ( ! function_exists( 'voip_save_option' ) ) {
	function voip_save_option( $voip_option_key, $voip_option_value = null ) {
		$options_array                     = get_option( "wd_options_array" );
		$options_array[ $voip_option_key ] = $voip_option_value;
		update_option( "wd_options_array", $options_array );
	}
}
if ( ! function_exists( 'voip_get_categories' ) ) {
	function voip_get_categories( $taxonomy = '' ) {
		$args             = array( 'type' => 'post', 'hide_empty' => 0 );
		$output           = array();
		$args['taxonomy'] = $taxonomy;
		$categories       = get_categories( $args );
		if ( ! empty( $categories ) && is_array( $categories ) ) {
			foreach ( $categories as $category ) {
				if ( is_object( $category ) ) {
					$output[ $category->name ] = $category->slug;
				}
			}
		}

		return $output;
	}
}
function voip_removeslashes( $string ) {
	$string = implode( "", explode( "\\", $string ) );

	return stripslashes( trim( $string ) );
}