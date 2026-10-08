<?php
$output = $title = $link = $size = $el_class = $video_thumb_image = $video_thumb_html = $video_module_mode = $video_source = $video_id = $video_title = $description = $wrapper_extra_class = $module_alignment = $label_background = $label_css = $icon_color = $icon_css = '';
extract( shortcode_atts( array(
	//'title' => '',
	'video_module_mode' => 'simple',
	'link' => 'http://vimeo.com/92033601',
	'size' => ( isset( $content_width ) ) ? $content_width : 500,
	'video_source' => 'youtube',
	'video_id' => 'RUCc7kY9BvA',
	'el_class' => '',
	'video_thumb_image' => '',
	'modal_size' => 'medium',
	'module_alignment' => 'text-left',
	'icon_color' => '#FFF',
	'label_background' => 'rgba(0,0,0,0.0)',
	'css' => ''

), $atts ) );

$unique_id = uniqid('module_video_');

if ( $link == '' ) {
	return null;
}
$el_class = $this->getExtraClass( $el_class );

$video_w = ( isset( $content_width ) ) ? $content_width : 500;
$video_h = $video_w / 1.61; //1.61 golden ratio

$embed = '';


if(strcmp($video_module_mode, 'full_screen') === 0) {
	if($label_background != '' || $icon_color != '') {
		$icon_css .= 'style="';
		if($label_background != '') {
			$icon_css .= 'background: '.esc_attr($label_background).';';
		}
		if($icon_color != '') {
			$icon_css .= 'color: '.esc_attr($icon_color).';';
		}
		$icon_css .= '"';
	}
	$modal_id = uniqid('modal');
	$embed .= '<a href="#" data-reveal-id="'.$modal_id.'" class=""><i '.$icon_css.' class="fa fa-play-circle fa-5x"></i></a>';
	$embed .= '<div id="'.$modal_id.'" class="reveal-modal '. $modal_size .'" data-reveal  aria-hidden="true" role="dialog">
						  <div class="flex-video widescreen vimeo">';
  $embed .= '<iframe width="1280" height="720" src="https://www.youtube.com/embed/'. esc_attr($video_id) .'?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>';
	$embed .= '	 </div>
						  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
						</div>';

}elseif(strcmp($video_module_mode, 'simple') === 0) {
	/** @var WP_Embed $wp_embed  */
	global $wp_embed;
	$embed .= $wp_embed->run_shortcode( '[embed width="' . $video_w . '"' . $video_h . ']' . $link . '[/embed]' );
	if(isset($video_thumb_image) && !empty($video_thumb_image)) {
		$thumb_image_url = wp_get_attachment_image_src($video_thumb_image, 'full');
		$image_src = aq_resize($thumb_image_url[0], $video_w, $video_h, true, true, true);
		if(!$image_src) {
			$image_src = $thumb_image_url[0];
		}
		$video_thumb_html .= '<a href="#" class="wd-video-image-thumb" title="'.esc_attr__('Play video','voip').'"><i style="'.$icon_css.'" class="fa fa-play-circle fa-5x"></i><img src="'.esc_url($image_src).'" alt="'.esc_attr__("video","voip").'" /></a>';
	}
}


$wrapper_extra_class .= " " . $module_alignment;

$output .= "\n\t\t" . '<div class="wpb_wrapper">';
$output .= wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_video_heading' ) );
$output .= '<div class="wd-video-box">';
$output .= $video_thumb_html;
$output .= '<div class="wpb_video_wrapper '.$wrapper_extra_class.'">' . $embed . '</div>';
$output .= '</div>';
$output .= "\n\t\t" . '</div> ' . $this->endBlockComment( '.wpb_wrapper' );
if($video_thumb_html != '' && strcmp($video_module_mode, 'simple') === 0) {
	$output .= '<script>
					(function($) {
						"use strict";
						$(document).ready(function() {
							var video_box = $("#'. esc_js($unique_id) .'");
							var button = video_box.find(".wd-video-image-thumb");
							button.on("click",function(e) {
								var player = video_box.find("iframe");
								$(this).fadeOut("slow");
								e.preventDefault();
								player[0].src += "&autoplay=1";
							});
						});
					})(jQuery);
				</script>';
}

echo html_entity_decode($output, ENT_HTML5);