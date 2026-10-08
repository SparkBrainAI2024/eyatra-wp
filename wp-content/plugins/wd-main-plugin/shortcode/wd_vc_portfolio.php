<?php 
function wd_vc_portfolio($atts) {
           
  extract( shortcode_atts( array(
    'itemperpage' => '10',
		'number'=>'4',
		'margin'=>'10',
    'category'=>'',
    'layout' =>'',
    'columns' => '3',
    'show_pagination' => ''
  ), $atts ) );

  ob_start();


 if($layout == 'carousel') {
 	 $style = 'carousel_portfolio'; 
 		}else {
 		$style = 'masque';
 		}

	if (!empty($show_pagination)) {
		$show_pagination = false;
	} else {
		$show_pagination = true;
	};
  ?>
  
  <ul class='<?php echo $style ?> small-block-grid-2 large-block-grid-<?php echo $columns; ?>' data-numberitem="<?php echo $number  ?>" data-margin="<?php echo $margin  ?>">
  	<?php
		$paged = get_query_var('paged') ? get_query_var('paged') : 1;
		$loop = new WP_Query( array( 'post_type' => 'portfolio', 'paged' =>$paged, 'posts_per_page' => $itemperpage ,'cat' => $category, 'no_found_rows'=> $show_pagination) );
    while ( $loop->have_posts() ) : $loop->the_post(); ?>
    	<li class="wd-carousel-container">
    		<?php the_post_thumbnail( 'wd_650x350' ) ?>
    		<div class="carousel-icon">
				<a href="<?php the_permalink(); ?>"><i class="fa fa-link"></i></a>
        </div>
        <div class="info">
          <div class="carousel-details">
    		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    		</div>
    		</div>
    	</li>
  	<?php endwhile;?>
  </ul>
	<?php
	if (function_exists('voip_pagination')) {
		voip_pagination($loop->max_num_pages, "", $paged);
	}
	?>
  
  
  
  
  <?php return ob_get_clean();
  
}
add_shortcode( 'wd_vc_portfolio', 'wd_vc_portfolio' ); ?>