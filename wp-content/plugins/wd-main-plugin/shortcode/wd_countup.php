<?php
if(!function_exists('wd_count_up')){
	function wd_count_up($atts) {
		global $wd_fonts_to_enqueue_array;
		extract( shortcode_atts( array(
			//___________general_________



			'wd_countup_alignment'  => 'left',
			"wd_countup_layout"=> 'style1',
			//___________Title_________
			'wd_countup_title'  => '',
			'wd_countup_title_color'  => '',
			'wd_countup_title_padding'  => '',
			'wd_countup_title_font_family'  => '',
			'wd_countup_title_font_weight'  => '',
			'wd_countup_title_font_size'  => '',
			'wd_countup_title_text_transform'  => '',
			'wd_countup_title_line_height'  => '',
			'wd_countup_title_letter_spacing'  => '',
			//___________Number_________
			'wd_countup_number'  => '',
			'wd_countup_number_padding'  => '',
			'wd_countup_number_color'  => '',
			'wd_countup_number_font_family'  => '',
			'wd_countup_number_font_weight'  => '',
			'wd_countup_number_font_size'  => '',
			'wd_countup_number_text_transform'  => '',
			'wd_countup_number_line_height'  => '',
			'wd_countup_number_letter_spacing'  => '',
			//___________icon_________
			'wd_countup_switch'  => '',
			'wd_countup_image'  => '',
			'wd_countup_fontawesome'  => '',
			'wd_countup_icon_padding'  => '',
			'wd_countup_icon_color'  => '',
			'wd_countup_icon_font_size'  => '',
			'css_animation' => 'no'
		), $atts ) );


		$animation_classes =  "";
		$data_animated = "";

		if(($css_animation != 'no')){
			$animation_classes =  " animated ";
			$data_animated = "data-animated=$css_animation";
		}
		//___________________ Title font Style _______________

		$wd_font_family_countup_to_enqueue = "";

		$custom_title_inline_style = '';
		if($wd_countup_title_font_family != '' && $wd_countup_title_font_family != 'Default') {
			$custom_title_inline_style .= 'font-family:'.esc_attr($wd_countup_title_font_family).';';
			$wd_font_family_countup_to_enqueue .= esc_attr($wd_countup_title_font_family) . ":";
		}
		if($wd_countup_title_padding != '') {
			$custom_title_inline_style .= 'padding:'.esc_attr($wd_countup_title_padding).';';
		}
		if($wd_countup_title_color != '') {
			$custom_title_inline_style .= 'color:'.esc_attr($wd_countup_title_color).';';
		}
		if($wd_countup_title_font_weight != '' && $wd_countup_title_font_family != '') {
			$custom_title_inline_style .= 'font-weight:'.esc_attr($wd_countup_title_font_weight) . ';';
			$wd_font_family_countup_to_enqueue .= esc_attr($wd_countup_title_font_weight) . "%7C";
		}
		if($wd_countup_title_font_size != '') {
			$custom_title_inline_style .= 'font-size:'.esc_attr($wd_countup_title_font_size).'px;';
		}
		if($wd_countup_title_text_transform != '') {
			$custom_title_inline_style .= 'text-transform:'.esc_attr($wd_countup_title_text_transform).';';
		}
		if($wd_countup_title_line_height != '') {
			$custom_title_inline_style .= 'line-height:'.esc_attr($wd_countup_title_line_height).'px;';
		}
		if($wd_countup_title_letter_spacing != '') {
			$custom_title_inline_style .= 'letter-spacing:'.esc_attr($wd_countup_title_letter_spacing).'px;';
		}

		$wd_fonts_to_enqueue_array[] = esc_attr($wd_font_family_countup_to_enqueue);


		$wd_font_family_countup_to_enqueue = "";
		//___________Number style_________
		$custom_number_inline_style ='';
		if($wd_countup_number_color != '') {
			$custom_number_inline_style .= 'color:'.esc_attr($wd_countup_number_color).';';
		}
		if($wd_countup_number_font_family != '' && $wd_countup_number_font_family != 'Default') {
			$custom_number_inline_style .= 'font-family:'.esc_attr($wd_countup_number_font_family).';';
			$wd_font_family_countup_to_enqueue .= esc_attr($wd_countup_number_font_family) . ":";
		}
		if($wd_countup_number_font_weight != '' && $wd_countup_number_font_family != '') {
			$custom_number_inline_style .= 'font-weight:'.esc_attr($wd_countup_number_font_weight).';';
			$wd_font_family_countup_to_enqueue .= esc_attr($wd_countup_number_font_weight) . "%7C";
		}
		if($wd_countup_number_font_size != '') {
			$custom_number_inline_style .= 'font-size:'.esc_attr($wd_countup_number_font_size).'px;';
		}
		if($wd_countup_number_text_transform != '') {
			$custom_number_inline_style .= 'text-transform:'.esc_attr($wd_countup_number_text_transform).';';
		}
		if($wd_countup_number_line_height != '') {
			$custom_number_inline_style .= 'line-height:'.esc_attr($wd_countup_number_line_height).'px;';
		}
		if($wd_countup_number_letter_spacing != '') {
			$custom_number_inline_style .= 'letter-spacing:'.esc_attr($wd_countup_number_letter_spacing).'px;';
		}
		if($wd_countup_number_padding != '') {
			$custom_number_inline_style .= 'padding:'.esc_attr($wd_countup_number_padding).';';
		}

		$wd_fonts_to_enqueue_array[] = esc_attr($wd_font_family_countup_to_enqueue);

		//_________________________Icon style ___________________________
		$custom_icon_inline_style ='';
		if($wd_countup_icon_color != '') {
			$custom_icon_inline_style .= 'color:'.esc_attr($wd_countup_icon_color).';';
		}
		if($wd_countup_icon_font_size != '') {
			$custom_icon_inline_style .= 'font-size:'.esc_attr($wd_countup_icon_font_size).'px;';
		}
		if($wd_countup_icon_padding != '') {
			$custom_icon_inline_style .= 'padding:'.esc_attr($wd_countup_icon_padding).';';
		}

		ob_start(); ?>

		<div class="<?php echo  esc_attr($animation_classes); ?> clearfix" style="text-align:<?php echo esc_attr($wd_countup_alignment) ?>" <?php echo esc_attr($data_animated); ?>>
			<?php if($wd_countup_layout == 'style1') {  ?>
				<?php if($wd_countup_switch == 'wd_countup_icon') { ?>
					<i class="fa <?php echo esc_attr($wd_countup_fontawesome) ?>" style="<?php echo esc_attr($custom_icon_inline_style) ?>"></i>
				<?php }elseif($wd_countup_switch == 'wd_countup_image'){
					$wd_image = wp_get_attachment_image_src( $wdd_countup_image, '150X150');
					?>
					<img src="<?php echo $wd_image[0] ?>" style="<?php echo esc_attr($custom_icon_inline_style) ?>">
				<?php
				} ?>
				<h5 style="<?php echo esc_attr($custom_number_inline_style) ?>" class="counter" data-file="<?php echo $wd_countup_number ?>"><?php echo esc_attr($wd_countup_number) ?> </h5>
				<h2 style="<?php echo esc_attr($custom_title_inline_style) ?>"><?php echo esc_attr($wd_countup_title) ?></h2>

			<?php }elseif($wd_countup_layout == 'style2'){ ?>
				<h2 style="<?php echo esc_attr($custom_title_inline_style) ?>"><?php echo esc_attr($wd_countup_title) ?></h2>
				<?php if($wd_countup_switch == 'wd_countup_icon') { ?>
					<i class="fa <?php echo esc_attr($wd_countup_fontawesome) ?>" style="<?php echo esc_attr($custom_icon_inline_style) ?>"></i>
				<?php }elseif($wd_countup_switch == 'wd_countup_image'){
					$wd_image = wp_get_attachment_image_src( $wd_countup_image, '150X150');
					?>
					<img src="<?php echo $wd_image[0] ?>" style="<?php echo esc_attr($custom_icon_inline_style) ?>">
				<?php
				} ?>
				<h5 style="<?php echo esc_attr($custom_number_inline_style) ?>" class="counter" data-file="<?php echo $wd_countup_number ?>"><?php echo esc_attr($wd_countup_number) ?> </h5>


			<?php }else{ ?>
				<h5 style="<?php echo esc_attr($custom_number_inline_style) ?>" class="counter" data-file="<?php echo $wd_countup_number ?>"><?php echo esc_attr($wd_countup_number) ?> </h5>
				<?php if($wd_countup_switch == 'wd_countup_icon') { ?>
					<i class="fa <?php echo esc_attr($wd_countup_fontawesome) ?>" style="<?php echo esc_attr($custom_icon_inline_style) ?>"></i>
				<?php }elseif($wd_countup_switch == 'wd_countup_image'){
					$wd_image = wp_get_attachment_image_src( $wd_countup_image, '150X150');
					?>
					<img src="<?php echo $wd_image[0] ?>" style="<?php echo esc_attr($custom_icon_inline_style) ?>">
				<?php
				} ?>

				<h2 style="<?php echo esc_attr($custom_title_inline_style) ?>"><?php echo esc_attr($wd_countup_title) ?></h2>

			<?php } ?>

		</div>

		<?php return ob_get_clean();
	}
	add_shortcode( 'wd_count_up', 'wd_count_up' );
}
?>