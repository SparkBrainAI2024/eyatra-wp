<?php 

global $vc_add_css_animation;
/* our client
---------------------------------------------------------- */
vc_map( array(
    "name" => esc_html__("Carousel Clients", 'voip'),
    "base" => "wd_client", 
    "icon" => get_template_directory_uri()."/images/icon/meknes.png",
    "content_element" => true, 
    "is_container" => FALSE,
    "params" => array(         
		array(
			'type' => 'attach_images',
			'heading' => esc_html__( 'Images', 'voip' ),
			'param_name' => 'images',
			
		),array(
            "type" => "dropdown", // it will bind a textfield in WP
            "heading" => esc_html__("Columns", 'voip'),
            "param_name" => "columns",
             "value" => array('1','2','3','4','5','6','7'),
        ),
        $vc_add_css_animation
    )
) );