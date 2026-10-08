<?php
if(!function_exists('wd_image_with_text')){
  function wd_image_with_text($atts) {
	  $css_animation = $title = $image = $extra_classes = $text = $url = "";
    extract( shortcode_atts( array(
      'title' => 'Block title',
      'text'  => 'Some text should be hrre...',
      'layout' => '1',
      'extra_classes' => '',
      'url' => '',
      'image_checkbox' => '',
      'image' => '',
      'css_animation' => 'no',
    ), $atts ) );
    

    $img_size = "voip_650x350";
    $thumb_size="thumbnail";
    $post_thumbnail="";

    $animation_classes =  "";
    $data_animated = "";

    if(($css_animation != 'no')){
      $animation_classes =  " animated ";
      $data_animated = "data-animated=$css_animation";
    }

	  $href = vc_build_link($url);
	  $url = $href['url'];

    ob_start(); ?>



<?php if (isset($layout) && $layout== 1){ ?>

<section class="wd-image-text style-2">
  <div class="<?php echo esc_attr($animation_classes) . ' ' . esc_attr($extra_classes); ?>" <?php echo esc_attr($data_animated); ?>>
    <?php 
    $img_id = preg_replace( '/[^\d]/', '', $image );

    echo wp_get_attachment_image( $img_id, $img_size );    ?>

	  <?php if($url != "") echo "<a href=$url>"; ?>
	    <h4 class="wd-title-element"><?php echo $title; ?></h4>
	  <?php if($url != "") echo "</a>"; ?>
    <p>
      <?php echo $text; ?>
    </p>
  </div>
</section>
<?php }elseif (isset($layout) && $layout== 2){ ?>
		  <div class="wd-section-blog-services style-3">
			  <article class="layout-<?php echo esc_attr($layout) . ' ' . esc_attr($animation_classes) . ' ' . esc_attr($extra_classes); ?>" <?php echo esc_attr($data_animated); ?>>
				  <div class="wd-blog-post">
					  <div class="svg-wrapper">
						  <svg width="172" height="172" xmlns="http://www.w3.org/2000/svg">
							  <rect height="166" width="166" class="shape"></rect>
						  </svg>
						  <div class="img-wrapper">
							  <?php
							  $img_id = preg_replace( '/[^\d]/', '', $image );
							  $img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'full_size' => $img_size,'thumb_size' => 'thumbnail') );
							  $img_path=$img['p_img_large'][0]; ?>
							  <img src="<?php echo $img_path  ?>" alt="icon"/>
						  </div>
					  </div>
					  <?php if($url != "") echo "<a href=$url>"; ?>
					    <h4 class="wd-title-element"><?php echo $title; ?></h4>
					  <?php if($url != "") echo "</a>"; ?>
					  <p>
						  <?php echo $text; ?>
					  </p>
				  </div>
			  </article>
		  </div>
<?php } else { ?>
		  <div class="wd-image-text text-left style-3">
			  <div class="<?php echo esc_attr($animation_classes) . ' ' . esc_attr($extra_classes); ?>" <?php echo esc_attr($data_animated); ?>>
				  <a class="picture-div left" href="<?php echo $url; ?>">
				    <?php  print wp_get_attachment_image( $image, $img_size ); ?>
				  </a>
				  <div class="text-div">
					  <?php if($url != "") echo "<a href=$url>"; ?>
					    <h6 class="wd-title-element"><?php echo $title; ?></h6>
			      <?php if($url != "") echo "</a>"; ?>
					  <p><?php echo $text; ?> </p>
				  </div>
			  </div>
		  </div>

<?php } ?>
    <?php return ob_get_clean();
  }
  add_shortcode( 'wd_image_with_text', 'wd_image_with_text' );
}  
?>