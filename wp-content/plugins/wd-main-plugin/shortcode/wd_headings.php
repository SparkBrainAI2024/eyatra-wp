<?php

function wd_get_heading_separator($headings_separator, $custom_separatore_style){
	if($headings_separator == "border"){ echo "<hr style='$custom_separatore_style'/>"; }
}


if(!function_exists('wd_headings')){
	function wd_headings($atts) {

		$custom_header_inline_style = $custom_subheader_inline_style = $custom_separatore_style = $wd_heading_spacing = $heading_extraclass = "";

		extract( shortcode_atts( array(
			'title'  => 'this is a title',
			'headings_title'  => 'The title..',
			'headings_title_tag'  => 'h2',
			'headings_subtitle'  => 'subtitle',
			'headings_subtitle_tag'  => 'h4',
			'headings_layout' => 's-under-t',
			'headings_alignment' => 'center',

			'headings_separator' => '',
			'headings_separator_position' => 'center',
			'headings_separator_border_style' => '',
			'headings_separator_border_width' => '',
			'headings_separator_border_color' => '',

			'heading_extraclass' => '',

			'wd_heading_font_family' => '',
			'wd_heading_font_weight' => '',
			'wd_heading_font_size' => '',
			'wd_heading_color' => '',
			'wd_heading_text_transform' => '',
			'wd_heading_line_height' => '',
			'wd_heading_letter_spacing' => '',

			'wd_heading_spacing' => '10px',

			'wd_sub_heading_font_family' => '',
			'wd_sub_heading_font_weight' => '',
			'wd_sub_heading_font_size' => '',
			'wd_sub_heading_color' => '',
			'wd_sub_heading_text_transform' => '',
			'wd_sub_heading_line_height' => '',
			'wd_sub_heading_letter_spacing' => '',

			'css_animation' => 'no'
		), $atts ) );


		$animation_classes =  "";
		$data_animated = "";

		if(($css_animation != 'no')){
			$animation_classes =  " animated ";
			$data_animated = "data-animated=$css_animation";
		}


		$custom_header_inline_style = "margin:0;";
		$wd_font_family_heading_to_enqueue = "";

		if($wd_heading_font_family != 'Default') {
			$custom_header_inline_style .= 'font-family:'.esc_attr($wd_heading_font_family).';';
			$wd_font_family_heading_to_enqueue .= esc_attr($wd_heading_font_family) . ":";
		}
		if($wd_heading_font_weight != '') {
			$custom_header_inline_style .= 'font-weight:'.esc_attr($wd_heading_font_weight).';';
			$wd_font_family_heading_to_enqueue .= esc_attr($wd_heading_font_weight);
		}
		if($wd_heading_font_size != '') {
			$custom_header_inline_style .= 'font-size:'.esc_attr($wd_heading_font_size).'px;';
		}
		if($wd_heading_color != '') {
			$custom_header_inline_style .= 'color:'.esc_attr($wd_heading_color).';';
		}
		if($wd_heading_text_transform != '') {
			$custom_header_inline_style .= 'text-transform:'.esc_attr($wd_heading_text_transform).';';
		}
		if($wd_heading_line_height != '') {
			$custom_header_inline_style .= 'line-height:'.esc_attr($wd_heading_line_height).'px;';
		}
		if($wd_heading_letter_spacing != '') {
			$custom_header_inline_style .= 'letter-spacing:'.esc_attr($wd_heading_letter_spacing).'px;';
		}

		// Separator : border
		if($headings_separator == 'border' && $headings_separator_border_style != '' ) {
			$custom_separatore_style .= 'border-bottom-style: ' . esc_attr( $headings_separator_border_style ) . ';';
		}
		if($headings_separator == 'border' && $headings_separator_border_width != '' ) {
			$custom_separatore_style .= 'border-bottom-width: ' . esc_attr( $headings_separator_border_width ) . ';';
		}
		if($headings_separator == 'border' && $headings_separator_border_color != '' ) {
			$custom_separatore_style .= 'border-bottom-color: '.esc_attr($headings_separator_border_color).';';
		}


		$custom_separatore_style .= ' margin: '.esc_attr($wd_heading_spacing).' 0;';

		
		if($wd_sub_heading_font_family != 'Default') {
			$custom_subheader_inline_style .= 'font-family:'.esc_attr($wd_sub_heading_font_family).';';
			$wd_font_family_heading_to_enqueue .= "|" . esc_attr($wd_sub_heading_font_family) . ":";
		}
		if($wd_sub_heading_font_weight != '') {
			$custom_subheader_inline_style .= 'font-weight:'.esc_attr($wd_sub_heading_font_weight).';';
			$wd_font_family_heading_to_enqueue .= esc_attr($wd_sub_heading_font_weight);
		}
		if($wd_sub_heading_font_size != '') {
			$custom_subheader_inline_style .= 'font-size:'.esc_attr($wd_sub_heading_font_size).'px;';
		}
		if($wd_sub_heading_color != '') {
			$custom_subheader_inline_style .= 'color:'.esc_attr($wd_sub_heading_color).';';
		}
		if($wd_sub_heading_text_transform != '') {
			$custom_subheader_inline_style .= 'text-transform:'.esc_attr($wd_sub_heading_text_transform).';';
		}
		if($wd_sub_heading_line_height != '') {
			$custom_subheader_inline_style .= 'line-height:'.esc_attr($wd_sub_heading_line_height).'px;';
		}
		if($wd_sub_heading_letter_spacing != '') {
			$custom_subheader_inline_style .= 'letter-spacing:'.esc_attr($wd_sub_heading_letter_spacing).'px;';
		}



		$protocol = is_ssl() ? 'https' : 'http';
	  wp_enqueue_style('wd_heading_google_fonts',$protocol.'://fonts.googleapis.com/css?family=' . $wd_font_family_heading_to_enqueue);



		ob_start(); ?>
		<div class="wd-heading text-<?php esc_attr_e($headings_alignment); ?> <?php echo esc_attr($animation_classes .' '. $heading_extraclass); ?>" <?php echo esc_attr($data_animated); ?>>
			<?php if($headings_layout == "t-under-s" ){ ?>

				<?php if( $headings_separator_position  == "top") {  wd_get_heading_separator($headings_separator, $custom_separatore_style); } ?>
				 <?php if($headings_subtitle != '') { ?>
					<<?php echo $headings_subtitle_tag  ?> style="<?php echo esc_attr($custom_subheader_inline_style); ?>" >
							<?php echo $headings_subtitle  ?>
					</<?php echo $headings_subtitle_tag  ?>>
				 <?php } ?>
				<?php if( $headings_separator_position  == "center") {  wd_get_heading_separator($headings_separator, $custom_separatore_style); } ?>

				<<?php echo $headings_title_tag  ?> style="<?php echo esc_attr($custom_header_inline_style); ?>" >
						<?php echo $headings_title  ?>
				</<?php echo $headings_title_tag  ?>>

				<?php if( $headings_separator_position  == "bottom") {  wd_get_heading_separator($headings_separator, $custom_separatore_style); } ?>

			<?php }else{ ?>

				<?php if( $headings_separator_position  == "top") {  wd_get_heading_separator($headings_separator, $custom_separatore_style); } ?>

				<<?php echo $headings_title_tag  ?> style="<?php echo esc_attr($custom_header_inline_style); ?>" >
					<?php echo $headings_title  ?>
				</<?php echo $headings_title_tag  ?>>

				<?php if( $headings_separator_position  == "center") {  wd_get_heading_separator($headings_separator, $custom_separatore_style); } ?>
				<?php if($headings_subtitle != '') { ?>
				<<?php echo $headings_subtitle_tag  ?> style="<?php echo esc_attr($custom_subheader_inline_style); ?>" >
					<?php echo $headings_subtitle  ?>
				</<?php echo $headings_subtitle_tag  ?>>
						<?php } ?>
				<?php if( $headings_separator_position  == "bottom") {  wd_get_heading_separator($headings_separator, $custom_separatore_style); } ?>

			<?php } ?>
		</div>

		<?php return ob_get_clean();
	}
	add_shortcode( 'wd_headings', 'wd_headings' );
}
?>