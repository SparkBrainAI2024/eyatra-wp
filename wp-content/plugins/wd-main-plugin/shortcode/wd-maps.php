<?php
if(!function_exists('voip_maps')){
  function voip_maps($atts) {
              
    extract( shortcode_atts( array(
      'voip_map_latitude'  => '-37.817612',
      'voip_map_longitude'  => '144.959399',
      'voip_map_height' => '500',
      'voip_map_zoom' => '14',
      'voip_map_style' => 'wa_map_style1',
      'voip_map_company_name' => 'Envato',
      'voip_map_company_description' => '2 Elizabeth St, Melbourne Victoria 3000 Australia',
      'voip_map_source_image' => '',
      'voip_map_extra_class_name' => '',
      'css_animation' => 'no'
    ), $atts ) );

    ob_start();
   
		$voip_image = wp_get_attachment_image_src( $voip_map_source_image, '50X50');
		$data_animated = '';
    $animation_classes =  "";
	  if(($css_animation != 'no')){
		  $animation_classes =  " animated ";
		  $data_animated = "data-animated=$css_animation";
	  }

    ?>
   

    <div class="map <?php echo esc_attr($animation_classes)  ?>" <?php echo esc_attr($data_animated); ?>>
      <div class="map-canvas" data-id="map-canvas" style="height: <?php echo $voip_map_height ?>px;" data-latitude="<?php echo $voip_map_latitude ?>"
        data-longitude="<?php echo $voip_map_longitude ?>" data-zoom="<?php echo $voip_map_zoom ?>" data-companyname="<?php echo $voip_map_company_name ?>"
        data-decription="<?php echo $voip_map_company_description ?>" data-imagepath="<?php echo $voip_image[0] ?>" data-wdmapstyle="<?php echo $voip_map_style ?>">
      </div>
    </div>
    

    <?php return ob_get_clean();
  }
  add_shortcode( 'voip_maps', 'voip_maps' );
}  
?>