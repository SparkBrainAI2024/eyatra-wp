<?php 

/*============================= Video =====================================*/
if(function_exists('vc_remove_param')) {
	vc_remove_param('vc_video','title');
	vc_remove_param('vc_video','link');
	vc_remove_param('vc_tour','title');
	vc_remove_param('vc_single_image','onclick');
}

vc_add_param('vc_video',array(
		'type' => 'dropdown',
		'class' => '',
		'heading' => esc_html__('Video mode...', 'voip'),
		'param_name' => 'video_module_mode',
		'value' => array(
			esc_html__('Simple video', 'voip') => 'simple',
			esc_html__('Full screen video', 'voip') => 'full_screen'
		),
	)
);
vc_add_param('vc_video',array(
		'type' => 'textfield',
		'heading' => esc_html__( 'Video link', 'voip' ),
		'param_name' => 'link',
		'admin_label' => true,
		'description' => sprintf( esc_html__( 'Link to the video. More about supported formats at %s.', 'voip' ), '<a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">WordPress codex page</a>' ),
		'dependency' => array('element' => 'video_module_mode','value' => array('simple')),
	)
);
vc_add_param('vc_video',array(
		'type' => 'attach_image',
		'class' => '',
		'heading' => esc_html__('Thumbnail Image', 'voip'),
		'param_name' => 'video_thumb_image',
		'value' => '',
		'description' => esc_html__('Upload or select video thumbnail image from media gallery.', 'voip'),
		'dependency' => array('element' => 'video_module_mode','value' => array('simple')),
	)
);
vc_add_param('vc_video',array(
		'type' => 'dropdown',
		'class' => '',
		'heading' => esc_html__('Video source', 'voip'),
		'param_name' => 'video_source',
		'value' => array(
			esc_html__('Youtube', 'voip') => 'youtube',
			esc_html__('Vimeo', 'voip') => 'vimeo'
		),
		//'description' => esc_html__('Upload or select video thumbnail image from media gallery.', 'voip'),
		'dependency' => array('element' => 'video_module_mode','value' => array('full_screen')),
	)
);
vc_add_param('vc_video',array(
		'type' => 'textfield',
		'heading' => esc_html__( 'Video ID', 'voip' ),
		'param_name' => 'video_id',
		'admin_label' => true,
		'dependency' => array('element' => 'video_module_mode','value' => array('full_screen')),
	)
);
vc_add_param('vc_video',array(
		'type' => 'dropdown',
		'class' => '',
		'heading' => esc_html__('Label Alignment','voip'),
		'param_name' => 'module_alignment',
		"value" => array(
			esc_html__('Left','voip') => "text-left",
			esc_html__('Center','voip') => "text-center",
			esc_html__('Right','voip') => "text-right"
		),
		'dependency' => array('element' => 'video_module_mode','value' => array('full_screen')),
	)
);
vc_add_param('vc_video',array(
		'type' => 'dropdown',
		'class' => '',
		'heading' => esc_html__('Modal Size (width)','voip'),
		'param_name' => 'modal_size',
		"value" => array(
			esc_html__('Medium (60%)','voip') => "medium",
			esc_html__('Small (40%)','voip') => "small",
			esc_html__('Tiny (30%)','voip') => "tiny",
			esc_html__('Large (70%)','voip') => "large",
			esc_html__('XLarge (95%)','voip') => "xlarge",
			esc_html__('Full (100%)','voip') => "full"
		),
		'dependency' => array('element' => 'video_module_mode','value' => array('full_screen')),
	)
);
vc_add_param('vc_video',array(
		'type' => 'colorpicker',
		'class' => '',
		'heading' => esc_html__('Icon color', 'voip'),
		'param_name' => 'icon_color',
		'value' => '#ffffff',
		'dependency' => array('element' => 'video_module_mode','value' => array('full_screen')),
	)
);
vc_add_param('vc_video',array(
		'type' => 'colorpicker',
		'class' => '',
		'heading' => esc_html__('Label background', 'voip'),
		'param_name' => 'label_background',
		'value' => 'rgba(0,0,0,0.0)',
		'dependency' => array('element' => 'video_module_mode','value' => array('full_screen')),
	)
);