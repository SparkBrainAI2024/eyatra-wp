<?php 
/* Hero Image
---------------------------------------------------------- */
vc_map( array(
    "name" => esc_html__("Hero Image", 'voip'),
    "base" => "wd_hero_image",
    "icon" => get_template_directory_uri()."/images/icon/meknes.png",
    "content_element" => true, 
    "is_container" => FALSE,
    "params" => array(
	    array(
		    "type" => "attach_image", // it will bind a img choice in WP
		    "heading" => esc_html__("Image", 'voip'),
		    "param_name" => "image",
	    ),
	    array(
		    "type" => "checkbox",
		    "heading" => esc_html__("Full Screen", 'voip'),
		    "param_name" => "hero_full_screen",
		    'value' => array( esc_html__( 'Yes, please', 'voip' ) => 'yes' ),
	    ),
      array(
          "type" => "textarea_raw_html", // it will bind a textfield in WP
          "heading" => esc_html__("Text", 'voip'),
          "param_name" => "hero_text",
      )
    )
) );