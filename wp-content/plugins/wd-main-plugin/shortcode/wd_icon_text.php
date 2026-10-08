<?php
if(!function_exists('wd_icon_text')){
  function wd_icon_text($atts) {
              
    extract( shortcode_atts( array(
      'title' => 'Block title',
      'text'  => '',
      'icon' => '',
      'layout' => '1',
      'extra_classes' => '',
      'url' => '',
      'image_checkbox' => '',
      'text_icon_border_checkbox' => '',
      'image' => '',
      'img_size' => '650x350',
    ), $atts ) );

    $href = vc_build_link($url);
    $url = $href['url'];

    ob_start(); ?>
    
    <div class="boxes small layout-<?php echo $layout; ?> clearfix <?php echo $extra_classes ?>">
      <div class="box-container clearfix <?php if ($text_icon_border_checkbox =='yes'){ echo " border "; }  ?>" >
        <?php if( $icon != '---- None ----' ): ?>
          <?php if ($url != ""): ?>
            <a href="<?php echo $url; ?>">
          <?php endif ?>
          <div class="box-icon">
          <?php if ($image_checkbox =='yes'){ ?>
            <?php 
             /************************************************
              ================== image resize =================
               *************************************************/

              $sap = str_replace(array('X','x'),'X',$img_size);
              $voip_image_size_ = explode( 'X', $sap) ;
              if(isset($voip_image_size_[0])){
                  $voip_image_size_w = $voip_image_size_[0];
              }
              if(isset($voip_image_size_[1])){
                  $voip_image_size_h = $voip_image_size_[1];
              }else{
                  $voip_image_size_h = '';
              }

              $thumb = preg_replace( '/[^\d]/', '', $image );
              $img_url = wp_get_attachment_url( $thumb,'full' );
              if($voip_image_size_h != '') {
                  $img_path = voip_image_resize( $img_url, $voip_image_size_w, $voip_image_size_h , true );
              }else{
                  $img_path = voip_image_resize( $img_url, $voip_image_size_w, true );
              }
             ?>
             <img src="<?php echo $img_path  ?>" alt='icon' />
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
  add_shortcode( 'wd_icon_text', 'wd_icon_text' );
}  
?>