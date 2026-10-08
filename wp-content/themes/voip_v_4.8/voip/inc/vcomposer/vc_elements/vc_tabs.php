<?php 
global $icons;


vc_add_param("vc_tab",
		array(
			'type' => 'dropdown',
			'heading' =>  'Icon',
			'param_name' => "wd_icon",
			"value" =>$icons
			)
		);
vc_add_param("vc_tab",
        array(
            "type" => "checkbox",
            "heading" => esc_html__("Display image instead of icon", 'voip'),
            "param_name" => "wd_image_checkbox",
            'value' => array( esc_html__( 'Yes, please', 'voip' ) => 'yes' ),
        )
        );
vc_add_param("vc_tab",
        array(
            "type" => "attach_image", // it will bind a img choice in WP
            "heading" => esc_html__("Image", 'voip'),
            "param_name" => "wd_image",
        )
        );
vc_add_param("vc_tab",
        array(
            "type" => "attach_image", // it will bind a img choice in WP
            "heading" => esc_html__("Background Image", 'voip'),
            "param_name" => "wd_bg_image",
        )
        );
vc_add_param("vc_tab",
        array(
            "type" => "dropdown", // it will bind a img choice in WP
            "heading" => esc_html__("Background position H", 'voip'),
            "param_name" => "wd_bg_position_h",
            "value" => array(
              "Left" => "left",
              "Right" => "right",
              "Center" => "center"
            ),
        )
        );
vc_add_param("vc_tab",
        array(
            "type" => "dropdown", // it will bind a img choice in WP
            "heading" => esc_html__("Background position V", 'voip'),
            "param_name" => "wd_bg_position_v",
            "value" => array(
              "Top" => "top",
              "Bottom" => "bottom",
              "Center" => "center"
            ),
        )
        );
vc_add_param("vc_tab",
        array(
            "type" => "dropdown", // it will bind a img choice in WP
            "heading" => esc_html__("Background Repeat", 'voip'),
            "param_name" => "wd_bg_repeat",
            "value" => array(
              "repeat-x" => "repeat-x",
              "repeat-y" => "repeat-y",
              "repeat" => "repeat-x",
              "no-repeat" => "no-repeat"
            ),
        )
        );