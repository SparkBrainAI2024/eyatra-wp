<?php
global $vc_add_css_animation;

add_filter( 'vc_iconpicker-type-fontawesome', 'vc_iconpicker_type_fontawesome' );
vc_map( array(
	"name" => esc_html__("Maps", 'voip'),
	"base" => "voip_maps",
	"icon" => get_template_directory_uri()."/images/icon/meknes.png",
	"content_element" => true,
	"is_container" => FALSE,
	"params" => array(
		
		
		
		 
		array(
			"heading" => esc_html__("Latitude", 'voip'),
			"type" => "textfield",
			"param_name" => "voip_map_latitude",
			"value" => '',
		),
		array(
			"heading" => esc_html__("Latitude", 'voip'),
			"type" => "textfield",
			"param_name" => "voip_map_longitude",
			"value" => '',
		),
		
		array(
			"heading" => esc_html__("Map Height", 'voip'),
			"type" => "textfield",
			"param_name" => "voip_map_height",
			"value" => '',
		),
		array(
			"heading" => esc_html__("Map Zoom", 'voip'),
			"type" => "textfield",
			"param_name" => "voip_map_zoom",
			"value" => '',
		),
		array(
			"heading" => esc_html__("Map Style", 'voip'),
			"type" => "dropdown",
			"param_name" => "voip_map_style",
			"value" => array(
				'style I' => 'wa_map_style1',
				'style II' => 'wa_map_style2',
				'style III' => 'wa_map_style3',
				'style IV' => 'wa_map_style4',
				),
		),
		array(
			"heading" => esc_html__("Extra class name", 'voip'),
			"type" => "textfield",
			"param_name" => "voip_map_extra_class_name",
			"value" => '',
			"description" => 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.'
		),
		
		//__________________Company Name_______________________
		array(
			"heading" => esc_html__("Company Name", 'voip'),
			"type" => "textfield",
			"param_name" => "voip_map_company_name",
			"value" => 'I am a Title change my',
			"group" => "Popup",
		),
		
		
		//__________________Company Description _______________________
		array(
			"type" => "textarea",
			"heading" => esc_html__("Company Description", 'voip'),
			"param_name" => "voip_map_company_description",
			"value" => "",
			"group" => "Popup",
		),
		
		//__________________Icon_______________________
		
		array(
			'type' => 'attach_image',
			'heading' => esc_html__( 'Markup', 'voip' ),
			'param_name' => 'voip_map_source_image',
			"group" => "Popup",
			
		),
		
		
		
		
		
	
		
		
		

		$vc_add_css_animation

	)
) );