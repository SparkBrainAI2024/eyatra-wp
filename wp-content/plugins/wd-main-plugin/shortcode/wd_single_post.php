<?php 
function wd_one_post($atts) {
           
  extract( shortcode_atts( array(
		'title'       => '',
		'discription' => '',
		'post_id'     => '',
		'link'        => '#'
  ), $atts ) );

  ob_start();

	$href = vc_build_link($link);
	$link = $href['url'];
  ?>
  
  <div class='wd_onepost'>
  	<div class="title-block">
    	<div class="large-4 push-4">
    		<h2><?php echo $title ?></h2>
    		<span></span>
    	</div>
    	
    	<div class="description large-8 push-2">
    		<p><?php echo $discription ?></p>
    	</div>
  	</div>
  	
  	<div class="one_post_box large-12">
		  	<?php
		  	$the_post = get_post($post_id); 
        
		  	if( is_object( $the_post ) ):?>
			    <div class="box_image large-9 columns">					
					<?php echo get_the_post_thumbnail( $the_post->ID, 'wd_1900x620'); ?>					      
					  <div class="titel_icon">					 		  
					 		<div class="box_icon">
							<a href="<?php echo get_the_permalink($post_id); ?>">	<i class="fa fa-search-plus"></i></a>
						   </div>
						   <h3><?php echo $the_post->post_title; ?></h3>
						   
						   <div class="tag">
				      <?php echo get_the_category_list( $the_post->ID ); ?>
				      </div>
					  </div>
					</div>
				<?php endif;?>

				<div class="more large-3 columns">
					<div>
						<a href="<?php echo $link  ?>"><h3><?php echo _('See More Projects');  ?></h3>
				   	<i class="fa fa-arrow-right"> </i>
				   	</a>
					</div>
				</div>
 		 </div>	 		 
 
  </div>
  
  <?php return ob_get_clean();
  
}
add_shortcode( 'wd_one_post', 'wd_one_post' ); ?>