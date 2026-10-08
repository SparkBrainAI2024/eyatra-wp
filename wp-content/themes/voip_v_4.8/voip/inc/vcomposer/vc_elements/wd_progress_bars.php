<?php 

global $vc_add_css_animation;
/*--------------progress bars -------------------------*/
vc_map( array(
    "name" => esc_html__("Progress bars", 'voip'),
    "base" => "wd_progress_bars", 
    "content_element" => true, 
    "is_container" => true,
    "params" => array( 
        array(
            "type" => "textfield", // it will bind a textfield in WP
            "heading" => esc_html__("Progress bar title", 'voip'),
            "param_name" => "progress_title1",
        ),
        array(
            "type" => "textfield", // it will bind a textfield in WP
            "heading" => esc_html__("Progress bar longer", 'voip'),
            "param_name" => "progress_meter1",
        ),
        
        array(
            "type" => "textfield", // it will bind a textfield in WP
            "heading" => esc_html__("Progress bar title", 'voip'),
            "param_name" => "progress_title2",
        ),
        array(
            "type" => "textfield", // it will bind a textfield in WP
            "heading" => esc_html__("Progress bar longer", 'voip'),
            "param_name" => "progress_meter2",
        ),
        
        array(
            "type" => "textfield", // it will bind a textfield in WP
            "heading" => esc_html__("Progress bar title", 'voip'),
            "param_name" => "progress_title3",
        ),
        array(
            "type" => "textfield", // it will bind a textfield in WP
            "heading" => esc_html__("Progress bar longer", 'voip'),
            "param_name" => "progress_meter3",
        ),
        
        array(
            "type" => "textfield", // it will bind a textfield in WP
            "heading" => esc_html__("Progress bar title", 'voip'),
            "param_name" => "progress_title4",
        ),
        array(
            "type" => "textfield", // it will bind a textfield in WP
            "heading" => esc_html__("Progress bar longer", 'voip'),
            "param_name" => "progress_meter4",
        ),
        $vc_add_css_animation
        
    )
) );