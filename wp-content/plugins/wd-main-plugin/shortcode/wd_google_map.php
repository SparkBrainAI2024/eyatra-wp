<?php
if(!function_exists('wd_google_map')){
  function wd_google_map($atts) {
              
    extract( shortcode_atts( array(
      'title'  => '',
      'company_name'  => 'Your company name',
      'latitude' => '-37.817612',
      'longitude' => '144.959399',
      'map_height' => '560',
      'image' => '',
      'zoom' => '14',
      'description' => '<h4>Envato Office</h4> 2 Elizabeth St, Melbourne Victoria 3000 Australia',
    ), $atts ) );

    ob_start();
    $img_size="";
    $border_color="";
    $style="";
    $post_thumbnail="";

    ?>
   <?php 
      $img_id = preg_replace( '/[^\d]/', '', $image );
      //$img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'full_size' => $img_size, 'class' => $style . $border_color ) );
       ?>
      <?php 
      //$img_path=$img['p_img_large'][0];
     ?>

    <div class="map">
      <?php if( $title != ''){ ?>
        <h2><?php echo $title ?></h2>
      <?php } ?>
      <div id="map-canvas" style="height: <?php echo $map_height ?>px;" data-latitude="<?php echo $latitude ?>"  
        data-longitude="<?php echo $longitude ?>" data-zoom="<?php echo $zoom ?>" data-companyname="<?php echo $company_name ?>" 
        data-decription="<?php echo $description ?>">
      </div>
    </div>
    

    <?php return ob_get_clean();
  }
  add_shortcode( 'wd_google_map', 'wd_google_map' );
}  
?>