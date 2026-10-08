<?php
/** @var $this WPBakeryShortCode_VC_Tab */
$output = $title = $tab_id = $wd_icon = $wd_image = $wd_image_checkbox = $wd_bg_image = $wd_bg_position_h =  $wd_bg_repeat =  $wd_bg_position_v = '';

extract( shortcode_atts( array(
  'wd_bg_image' => '',
  'wd_bg_position_h' => '',
  'wd_bg_position_v' => '',
  'wd_bg_repeat' => ""
), $atts ) );


extract(shortcode_atts($this->predefined_atts, $atts));

wp_enqueue_script('jquery_ui_tabs_rotate');
$img_size="";
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_tab ui-tabs-panel wpb_ui-tabs-hide vc_clearfix', $this->settings['base'], $atts );
$output .= "\n\t\t\t" . '<div id="tab-'. (empty($tab_id) ? sanitize_title( $title ) : $tab_id) .'" class="'.$css_class. '"';
	if (isset($wd_bg_image)) {
		if ($wd_bg_image != "") {
			$img_id    = preg_replace( '/[^\d]/', '', $wd_bg_image );
			$img       = wpb_getImageBySize( array( 'attach_id' => $img_id, 'full_size' => $img_size,'thumb_size' => 'thumbnail') );
			$img_path  = $img['p_img_large'][0];
			$wd_bg_position_string = "";
			$wd_bg_repeat_string = "";
			if ($wd_bg_position_h != "" && $wd_bg_position_v != "") {
				$wd_bg_position_string = "background-position : " . $wd_bg_position_h . " " . $wd_bg_position_v . ";";
			}
			if ($wd_bg_repeat != "") {
				$wd_bg_repeat_string = "background-repeat : " . $wd_bg_repeat . ";";
			}
			$output .= ' style="background-image: url(' . $img_path .');' . $wd_bg_position_string . ";" . $wd_bg_repeat_string . ";" . '
			"';
		}
	}

	

$output .= ">";
$output .= ($content=='' || $content==' ') ? esc_html__("Empty tab. Edit page to add content here.", 'voip') : "\n\t\t\t\t" . wpb_js_remove_wpautop($content);
$output .= "\n\t\t\t" . '</div> ' . $this->endBlockComment('.wpb_tab');

echo html_entity_decode($output, ENT_HTML5);