<?php 

global $icons;
global $vc_add_css_animation;
// COUNTUP
// -------------------------------------------------------------------
vc_map( array(
    "name" => esc_html__("Count UP", 'voip'),
    "base" => "wd_count_up", 
    "icon" => get_template_directory_uri()."/images/icon/meknes.png",
    "content_element" => true, 
    "is_container" => FALSE,
    "params" => array( 
    
    	array(
			"heading" => esc_html__("Alignment", 'voip'),
			"type" => "dropdown",
			"param_name" => "wd_countup_alignment",
			'value' => array('Left (Default)' => 'left',
							 'center' => 'center',
							 'right' => 'right',
							),
		),
		array(
			"heading" => esc_html__("Layout", 'voip'),
			"type" => "dropdown",
			"param_name" => "wd_countup_layout",
			'value' => array('Icon / Number / Text (Default)' => 'style1',
							 'Text / Number / Icon ' => 'style2',
							 'Number / Icon / Text' => 'style3',
							),
		),
     
	//___________Title ______________________________
        array(
            "type" => "textfield", // it will bind a textfield in WP
            "heading" => esc_html__("Title", 'voip'),
            "param_name" => "wd_countup_title",
            "group"=>"Title"
        ),
         array(
			"heading" => esc_html__("Title Text Color", 'voip'),
			"type" => "colorpicker",
			"param_name" => "wd_countup_title_color",
			"value" => '#eee',
			"group" => "Title",
		),
		array(
			"heading" => esc_html__("Title Padding", 'voip'),
			"type" => "textfield",
			"param_name" => "wd_countup_title_padding",
			"value" => '0px',
			"group" => "Title",
		),
        //////////// Typography Title
		array(
			"type" => "textfield",
			"heading" => esc_html__("Font Family", 'voip'),
			"param_name" => "wd_countup_title_font_family",
			"group" => "Title",
		),
		
		array(
			"type" => "dropdown",
			"heading" 		=>	__("Font Weight", 'voip'),
			"param_name"	=>	"wd_countup_title_font_weight",
			'value' => array(
				__('Default', 'voip')	=>	'400',
				'100'	=>	'100',
				'200'	=>	'200',
				'300'	=>	'300',
				'500'	=>	'500',
				'600'	=>	'600',
				'700'	=>	'700',
				'800'	=>	'800',
				'900'	=>	'900',
			),
			"group" => "Title"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Font Size", 'voip'),
			"param_name" => "wd_countup_title_font_size",
			"min" => 14,
			"suffix" => "px",
			"group" => "Title",
		),
		
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Text Transform", 'voip'),
			"param_name" => "wd_countup_title_text_transform",
			'value' => array(
				__('Default', 'voip')	=>	'None',
				'lowercase'	=>	'Lowercase',
				'uppercase'	=>	'Uppercase',
				'capitalize'	=>	'Capitalize',
				'inherit'	=>	'Inherit',
			),
			"group" => "Title"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Line Height", 'voip'),
			"param_name" => "wd_countup_title_line_height",
			"value" => "",
			"suffix" => "px",
			"group" => "Title"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Letter spacing", 'voip'),
			"param_name" => "wd_countup_title_letter_spacing",
			"value" => "",
			"suffix" => "px",
			"group" => "Title"
		),
    //_______________Number ____________________
        array(
            "type" => "textfield", // it will bind a textfield in WP
            "heading" => esc_html__("Number", 'voip'),
            "param_name" => "wd_countup_number",
            "group"=>"Number"
        ),
        array(
			"heading" => esc_html__("Number Padding", 'voip'),
			"type" => "textfield",
			"param_name" => "wd_countup_number_padding",
			"value" => '0px',
			"group" => "Number",
		),
        array(
			"heading" => esc_html__("Number Color", 'voip'),
			"type" => "colorpicker",
			"param_name" => "wd_countup_number_color",
			"value" => '#eee',
			"group" => "Number",
		),
		 //////////// Typography Title
		array(
			"type" => "textfield",
			"heading" => esc_html__("Font Family", 'voip'),
			"param_name" => "wd_countup_number_font_family",
			"group" => "Number",
		),
		
		array(
			"type" => "dropdown",
			"heading" 		=>	__("Font Weight", 'voip'),
			"param_name"	=>	"wd_countup_number_font_weight",
			'value' => array(
				__('Default', 'voip')	=>	'400',
				'100'	=>	'100',
				'200'	=>	'200',
				'300'	=>	'300',
				'500'	=>	'500',
				'600'	=>	'600',
				'700'	=>	'700',
				'800'	=>	'800',
				'900'	=>	'900',
			),
			"group" => "Number"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Font Size", 'voip'),
			"param_name" => "wd_countup_number_font_size",
			"min" => 14,
			"suffix" => "px",
			"group" => "Number",
		),
		
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Text Transform", 'voip'),
			"param_name" => "wd_countup_number_text_transform",
			'value' => array(
				__('Default', 'voip')	=>	'None',
				'lowercase'	=>	'Lowercase',
				'uppercase'	=>	'Uppercase',
				'capitalize'	=>	'Capitalize',
				'inherit'	=>	'Inherit',
			),
			"group" => "Number"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Line Height", 'voip'),
			"param_name" => "wd_countup_number_line_height",
			"value" => "",
			"suffix" => "px",
			"group" => "Number"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Letter spacing", 'voip'),
			"param_name" => "wd_countup_number_letter_spacing",
			"value" => "",
			"suffix" => "px",
			"group" => "Number"
		),
	//___________icon_______________________________
	array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Switcher Icon/Image', 'voip' ),
			'param_name' => 'wd_countup_switch',
			'value' => array(
				__('None', 'voip')	=>	'None',
				'Icon'	=>	'wd_countup_icon',
				'Image'	=>	'wd_countup_image',
			),
			"group" => "Icon",
		),
        array(
            "type" => "attach_image", // it will bind a img choice in WP
            "heading" => esc_html__("Image", 'voip'),
            "param_name" => "wd_countup_image",
            "dependency" => Array("element" => "wd_countup_switch", "value" => array('wd_countup_image')),
            "group" => 'Icon'
        ),
       array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'voip' ),
			'param_name' => 'wd_countup_fontawesome',
			'settings' => array(
				'emptyIcon' => true, // default true, display an "EMPTY" icon?
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'description' => esc_html__( 'Select icon from library.', 'voip' ),
			"dependency" => Array("element" => "wd_countup_switch", "value" => array('wd_countup_icon')),
			"group" => 'Icon'
		),
		array(
			"heading" => esc_html__("Icon/image Padding", 'voip'),
			"type" => "textfield",
			"param_name" => "wd_countup_icon_padding",
			"value" => '0px',
			"group" => "Icon",
			"dependency" => Array("element" => "wd_countup_switch", "value" => array('wd_countup_icon','wd_countup_image')),
		),
		array(
			"heading" => esc_html__("Icon Color", 'voip'),
			"type" => "colorpicker",
			"param_name" => "wd_countup_icon_color",
			"value" => '#eee',
			"dependency" => Array("element" => "wd_countup_switch", "value" => array('wd_countup_icon')),
			"group" => "Icon",
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Icon Font Size", 'voip'),
			"param_name" => "wd_countup_icon_font_size",
			"min" => 14,
			"suffix" => "px",
			"dependency" => Array("element" => "wd_countup_switch", "value" => array('wd_countup_icon')),
			"group" => "Icon",
		),
        
       $vc_add_css_animation
    )
) );