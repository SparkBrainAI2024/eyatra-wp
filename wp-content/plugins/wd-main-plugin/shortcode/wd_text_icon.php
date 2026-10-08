<?php
if(!function_exists('wd_text_icon')){
  function wd_text_icon($atts) {
              
    extract( shortcode_atts( array(
      'title' => 'Block title',
      'text'  => 'Some text should be hrre... sdds',
      'icon' => '',
      'layout' => '1',
      'extra_classes' => '',
      'url' => '',
      'image_checkbox' => '',
      'image' => '',
      'css_animation' => 'no',
    ), $atts ) );
    

    $img_size="";
    $thumb_size="thumbnail";
    $post_thumbnail="";

    $animation_classes =  "";
    $data_animated = "";

    if(($css_animation != 'no')){
      $animation_classes =  " animated ";
      $data_animated = "data-animated=$css_animation";
    }


    ob_start(); ?>
    
    <div class="boxes small layout-<?php echo esc_attr($layout) . ' ' . esc_attr($animation_classes) . ' ' . esc_attr($extra_classes); ?> clearfix"  <?php echo esc_attr($data_animated); ?>>
      <div class="box-container clearfix">
        <?php if( $icon != '---- None ----' ): ?>
          <?php if ($url != ""): ?>
            <a href="<?php echo $url; ?>">
          <?php endif ?>
          <div class="box-icon">
          <?php if ($image_checkbox =='yes'){ ?>
            <?php 
            $img_id = preg_replace( '/[^\d]/', '', $image );
            $img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'full_size' => $img_size,'thumb_size' => 'thumbnail') );
             ?>
            <?php
            $img_path=$img['p_img_large'][0];
             ?>
             <img src="<?php echo $img_path  ?>" alt="icon" />
          <?php }else { ?>
            <i class="fa <?php echo $icon; ?>"></i>
          <?php } ?>
          </div>
          <?php if ($url != ""): ?>
            </a>
          <?php endif ?>
        <?php endif; ?>
        <?php if ($layout==5 || $layout==6 || $layout==7){ ?>
          <div class="box-text-<?php echo $layout; ?>">
        <?php } ?>
          <h3 class="box-title-<?php echo $layout; ?>"><?php echo $title; ?></h3>
        <?php if( $layout == 3 ): ?>
          <hr>
        <?php endif; ?>
        <p class="box-body"><?php echo $text; ?></p>
        <?php if ($layout==5 || $layout==6 || $layout==7){ ?>
          </div>
        <?php } ?>
      </div>    
    </div>      
      
    <?php return ob_get_clean();
  }
  add_shortcode( 'wd_text_icon', 'wd_text_icon' );
}  
?>