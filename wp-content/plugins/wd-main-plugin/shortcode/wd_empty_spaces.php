<?php
if(!function_exists('wd_empty_spaces')){
  function wd_empty_spaces($atts) {
              
    extract( shortcode_atts( array(
      'height_mobile' => '130px',
      'height_tablet' => '130px',
      'height_desktop' => '130px',
      'extra_classes' => ''
      
    ), $atts ) );

    ob_start(); ?>


<div class="wd_empty_space" data-heightmobile="<?php echo esc_attr($height_mobile) ?>" data-heighttablet="<?php echo esc_attr($height_tablet); ?>" data-heightdesktop="<?php echo esc_attr($height_desktop); ?>">

</div>
      



        
      
    <?php return ob_get_clean();
  }
  add_shortcode( 'wd_empty_spaces', 'wd_empty_spaces' );
}  
?>