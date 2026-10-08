<?php 

global $vc_add_css_animation;
global $icons;
/* Feature Box
---------------------------------------------------------- */
vc_map( array(
    "name" => esc_html__("Featured Box", 'voip'),
    "base" => "wd_featured_box",
    "icon" => get_template_directory_uri()."/images/icon/meknes.png",
    "content_element" => true,
    "is_container" => FALSE,
    "params" => array(
		    array(
			    'type' => 'colorpicker',
			    'heading' => esc_html__( 'Backround Color', 'voip' ),
			    'param_name' => 'background_color',
			    'description' => esc_html__( 'Select font color', 'voip' ),
		    ),
        array(
            "type" => "textfield", // it will bind a textfield in WP
            "heading" => esc_html__("Title", 'voip'),
            "param_name" => "title",
        ),
        array(
            "type" => "textarea", // it will bind a textfield in WP
            "heading" => esc_html__("Text", 'voip'),
            "param_name" => "text",
        ),
        array(
            "type" => "checkbox",
            "heading" => esc_html__("Display image instead of icon", 'voip'),
            "param_name" => "image_checkbox",
            'value' => array( esc_html__( 'Yes, please', 'voip' ) => 'yes' ),
        ),
        array(
            "type" => "attach_image", // it will bind a img choice in WP
            "heading" => esc_html__("Image", 'voip'),
            "param_name" => "image",
        ),
        array(
          'type' => 'dropdown',
          'heading' => esc_html__( 'Icon', 'voip' ),
          'param_name' => 'icon',
          'value' => $icons,
          'description' => esc_html__( 'Select the icon to use.', 'voip' ),
          'admin_label' => true
        ),
        array(
          'type' => 'dropdown',
          'heading' => esc_html__( 'Layout', 'voip' ),
          'param_name' => 'layout',
          'value' => array('Layout 1' => 1,
                           'Layout 2' => 2,
                           'Layout 3' => 3,
                           'Layout 4' => 4,
                           'Layout 5' => 5,
                           'Layout 5 inverse' => '5-inverse',
                           'Layout 6' => 6,
                           'Layout 7' => 7,
                           'Layout 8' => 8,
                         ),
          'description' => esc_html__( 'Select the icon to use.', 'voip' ),
          'admin_label' => true
        ),
        array(
            "type" => "vc_link", // it will bind a textfield in WP
            "heading" => esc_html__("URL to :", 'voip'),
            "param_name" => "url",
        ),
        array(
            "type" => "textfield", // it will bind a textfield in WP
            "heading" => esc_html__("Extra Classes", 'voip'),
            "param_name" => "extra_classes",
        ),
	      $vc_add_css_animation
    )
) );