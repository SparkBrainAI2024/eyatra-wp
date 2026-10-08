<?php 

global $vc_add_css_animation;
// PIE CHART
// -------------------------------------------------------------------
vc_map( array(
    "name" => esc_html__("Pie Chart", 'voip'),
    "base" => "wd_chart_pie", 
    "icon" => get_template_directory_uri()."/images/icon/meknes.png",
    "content_element" => true, 
    "is_container" => FALSE,
    "params" => array( 
        array(
              "type" => "textfield", // it will bind a textfield in WP
              "heading" => esc_html__("title", 'voip'),
              "param_name" => "title",
          ),
        array(
            "type" => "textfield", // it will bind a textfield in WP
            "heading" => esc_html__("value", 'voip'),
            "param_name" => "value",
        ),
        array(
          'type' => 'dropdown',
          'heading' => esc_html__( 'style', 'voip' ),
          'param_name' => 'style',
          'value' => array('style1' => 1,
                           'style2' => 2,
                           'style3' => 3,
                         ),
          'description' => esc_html__( 'Select the icon to use.', 'voip' ),
          'admin_label' => true
        ),
        $vc_add_css_animation
    )
) );