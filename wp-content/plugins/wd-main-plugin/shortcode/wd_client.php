<?php 
function wd_client($atts) {
           
  extract( shortcode_atts( array(
  
    'images' => '',
    'columns'=> '5',
    'title' => '',
		'onclick' => 'link_image',
		'custom_links' => '',
		'custom_links_target' => '',
		'img_size' => 'thumbnail',
		'pretty_rand' =>''
  ), $atts ) );


  ob_start();
  
$images = explode( ',', $images );
 ?>
  <div class="carousel_client" data-clienttoshow = '<?php echo $columns ?>'>

<?php foreach ( $images as $attach_id ): ?>
<?php
if ( $attach_id > 0 ) {
	$post_thumbnail = wpb_getImageBySize( array( 'attach_id' => $attach_id, 'thumb_size' => $img_size ) );
} else {
	$post_thumbnail = array();
	$post_thumbnail['thumbnail'] = '<img src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';
	$post_thumbnail['p_img_large'][0] = vc_asset_url( 'vc/no_image.png' );
}
$thumbnail = $post_thumbnail['thumbnail'];
?>
<div class="wd-item">
	
		
		<?php $p_img_large = $post_thumbnail['p_img_large'];?>
		<img  class="prettyphoto" src="<?php echo $p_img_large[0] ?>" alt="<?php echo $title ?>">

	
</div>
<?php 

endforeach;?>
  </div>
<?php return ob_get_clean();
}
add_shortcode( 'wd_client', 'wd_client' );
?>