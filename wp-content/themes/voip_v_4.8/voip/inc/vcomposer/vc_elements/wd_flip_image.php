<?php 

global $vc_add_css_animation;
// Flip image
 vc_map( array(
    "name" => esc_html__("Flip image", 'voip'), // add a name
    "base" => "wd_flip_image", // bind with our shortcode
    "icon" => get_template_directory_uri()."/images/icon/meknes.png",
    "content_element" => true, // set this parameter when element will has a content
    "is_container" => FALSE, // set this param when you need to add a content element in this element
    // Here starts the definition of array with parameters of our compnent
    "params" => array(
        array(
            "type" => "attach_image", // it will bind a img choice in WP
            "heading" => esc_html__("Image", 'voip'),
            "param_name" => "image",
        ),
 
        array(
            "type" => "textfield", // it will bind a textfield in WP
            "heading" => esc_html__("Title", 'voip'),
            "param_name" => "title",
        ),
        array(
            "type" => "textarea", // it will bind a textarea in WP
            "heading" => esc_html__("Text", 'voip'),
            "param_name" => "text",
        ),
        $vc_add_css_animation
    )
) );