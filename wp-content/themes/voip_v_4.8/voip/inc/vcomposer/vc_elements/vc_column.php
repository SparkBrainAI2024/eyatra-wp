<?php 

/*============================= Columns  =====================================*/
vc_add_param("vc_column", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => "Equal Height Columns",
	"param_name" => "equalizer_column",
	"value" => array("Create equal height content on your column ?" => "yes" )
));
vc_add_param("vc_column_inner", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => "Equal Height Columns",
	"param_name" => "equalizer_column_inner",
	"value" => array("Create equal height content on your column ?" => "yes" )
));

vc_map( array(
    "name"            => esc_html__("wd_last_post", 'voip'), // add a name
    "base"            => "wd_last_post", // bind with our shortcode
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
            "type" => "textarea",
            "heading" => esc_html__("Title", 'voip'),
            "param_name" => "title",
        ),
        
        
    )
) );