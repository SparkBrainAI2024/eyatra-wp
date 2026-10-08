<?php 
function wd_flip_image($atts) {
  extract( shortcode_atts( array(
    'image' => '',
    'text' =>  '',
    'title'=> '',
  ), $atts ) );
ob_start();

$img_size="";
$border_color="";
$style ="";
$thumb_size="";
$post_thumbnail="";
?>
  
                        

      <?php 
      $img_id = preg_replace( '/[^\d]/', '', $image );
      $img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'full_size' => $img_size,'thumb_size' => 'thumbnail', 'class' => $style . $border_color ) );
       ?>
      <?php
      $img_path=$img['p_img_large'][0];
       ?>

    <div class="scene">
      <div class="flip">
        <div class="avant"><img src="<?php echo $img_path  ?>"/></div>
        <div class="arriere">
            <h5><?php echo $title ?>
            </h5>
            <p><?php echo $text ?></p>
        </div>
      </div>
    </div>


<?php return ob_get_clean();
}
add_shortcode( 'wd_flip_image', 'wd_flip_image' );
?>