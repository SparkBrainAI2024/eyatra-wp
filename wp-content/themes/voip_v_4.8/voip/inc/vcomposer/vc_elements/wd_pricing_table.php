<?php 

global $vc_add_css_animation;
vc_map( array(
    "name"            => esc_html__("Pricing Table", 'voip'), // add a name
    "base"            => "wd_pricing_table", // bind with our shortcode
    "description"     => "You can add a prince table",
    "content_element" => true, // set this parameter when element will has a content
    "is_container"    => FALSE, // set this param when you need to add a content element in this element
    // Here starts the definition of array with parameters of our compnent
    "params" => array( 
        array(
            "type" => "textfield",
            "heading" => esc_html__("Title", 'voip'),
            "param_name" => "title",
        ), 
        array(
            "type" => "textfield",
            "heading" => esc_html__("Price", 'voip'),
            "param_name" => "price",
        ), 
        array(
            "type" => "textfield",
            "heading" => esc_html__("Description", 'voip'),
            "param_name" => "description",
        ), 
        array(
            "type" => "textfield",
            "heading" => esc_html__("Button Text", 'voip'),
            "param_name" => "button_text",
            "value" => "Buy Now",
        ), 
        array(
            "type" => "vc_link",
            "heading" => esc_html__("Button Link", 'voip'),
            "param_name" => "button_link",
        ), 
        array(            
            "type" => "textarea",
            "class" => "",
            "heading" => "Plan Options",
            "param_name" => "content_text",
            "value" => "<ul><li>Option #1</li><li>Option #2</li><li>Option #3</li><li>Option #4</li></ul>",
            "description" => "",
        ), 
        array(
            "type" => "checkbox",
            "heading" => esc_html__("Set this table as featured", 'voip'),
            "param_name" => "featured",
            "value" =>array( esc_html__( 'Yes, please', 'voip' ) => 'featured' ),
        ),
        $vc_add_css_animation
    )
) );