<?php 

global $vc_add_css_animation;

vc_map( array(
	"name" => esc_html__("Image Box", 'voip'),
	"base" => "wd_image_with_text",
	"icon" => get_template_directory_uri()."/inc/images/icon/greenenergy_icon.png",
	"content_element" => true,
	"is_container" => FALSE,
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => esc_html__("Title", 'voip'),
			"param_name" => "title",
		),
		array(
			"type" => "textarea",
			"heading" => esc_html__("Text", 'voip'),
			"param_name" => "text",
		),
		array(
			"type" => "attach_image", // it will bind a img choice in WP
			"heading" => esc_html__("Image", 'voip'),
			"param_name" => "image",
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Layout', 'voip' ),
			'param_name' => 'layout',
			'value' => array('Layout 1' => 1,
			                 'Layout 2' => 2,
			                 'Layout 3' => 3),
			'description' => esc_html__( 'Select the box style.', 'voip' ),
			'admin_label' => true
		),
		array(
			"type" => "vc_link",
			"heading" => esc_html__("URL to :", 'voip'),
			"param_name" => "url",
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Extra Classes", 'voip'),
			"param_name" => "extra_classes",
		),
		$vc_add_css_animation
	)
) );