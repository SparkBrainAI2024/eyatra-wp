<?php 

global $vc_add_css_animation;
//-----------------portfolio------------------*/

vc_map( array(
    "name" => esc_html__("Portfolio", 'voip'),
    "base" => "wd_vc_portfolio", 
    "icon" => get_template_directory_uri()."/images/icon/meknes.png",
    "content_element" => true, 
    "is_container" => FALSE,
    "params" => array(         
		array(
            "type" => "textfield", // it will bind a textfield in WP
            "heading" => esc_html__("Items to display", 'voip'),
            "param_name" => "itemperpage",
        ),
        array(
            "type" => "textfield", // it will bind a textfield in WP
            "heading" => esc_html__("Show", 'voip'),
            "param_name" => "number",
        ),
				array(
            "type" => "textfield", // it will bind a textfield in WP
            "heading" => esc_html__("Margin", 'voip'),
            "param_name" => "margin",
        ),
				array(
            "type" => "dropdown", // it will bind a textfield in WP
            "heading" => esc_html__("Layout", 'voip'),
            "param_name" => "layout",
             "value" => array('Grid'=>'grid','Carousel'=>'carousel'),
        ),
        array(
          "type" => "checkbox",
          "heading" => esc_html__("Display Pagination", 'voip'),
          "param_name" => "show_pagination",
        ),
        $vc_add_css_animation
    
    )
) );