<?php 

global $vc_add_css_animation;
/*********---------team--------------------------*/
  vc_map( array(
    "name" => esc_html__("Team", 'voip'), // add a name
    "base" => "wd_team", // bind with our shortcode
    "icon" => get_template_directory_uri()."/images/icon/meknes.png",
    "content_element" => true, // set this parameter when element will has a content
    "is_container" => FALSE, // set this param when you need to add a content element in this element
    // Here starts the definition of array with parameters of our compnent
    "params" => array( 
        array(
            "type" => "dropdown", // it will bind a textfield in WP
            "heading" => esc_html__("Columns", 'voip'),
            "param_name" => "columns",
             "value" => array('1','2','3','4','5','6','7'),
        ),
        array(
            "type" => "textfield", // it will bind a textfield in WP
            "heading" => esc_html__("Items Per Page", 'voip'),
            "param_name" => "itemperpage",
        ),
		    array(
			    "type" => "checkbox",
			    "heading" => esc_html__("Display column gutters", 'voip'),
			    "param_name" => "team_collapse",
			    "std" => "yes",
			    'value' => array( esc_html__( 'Yes, please', 'voip' ) => 'yes' ),
		    ),
		    array(
			    "type" => "checkbox",
			    "heading" => esc_html__("Display team members description", 'voip'),
			    "param_name" => "show_description",
			    "std" => "yes",
			    'value' => array( esc_html__( 'Yes, please', 'voip' ) => 'yes' ),
		    ),
        $vc_add_css_animation
    )
) );