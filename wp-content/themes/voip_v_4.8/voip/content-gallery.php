<article>
  	<h2 class="node-title" datatype="" property="dc:title"><a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a></h2>
	<header>
		<ul class="post-infos clearfix">
			<li><?php echo get_the_date('d-m-y'); ?></li>
			<li><?php echo esc_html__('By: ','voip'); the_author() ?></li>
			<li>
				<?php echo esc_html__('Category: ','voip');	   the_category(', '); ?>
			</li>
			<li class="comment-count"><?php comments_number( '0', '1', '% responses' ); echo esc_html__(' comment', 'voip') ?></li>
		</ul>
	</header>
  		<div>
  		 <i class="fa fa-image"></i>
	  		<ul class="wd-gallery-images-holder clearfix">  												
	  			<?php $portfolio_image_gallery_val = get_post_meta($post -> ID, 'wd_portfolio-image-gallery', true);
				if ($portfolio_image_gallery_val != '')
					$portfolio_image_gallery_array = explode(',', $portfolio_image_gallery_val);
						if (isset($portfolio_image_gallery_array) && count($portfolio_image_gallery_array) != 0) :
							foreach ($portfolio_image_gallery_array as $gimg_id) :
							$gimage_wp = wp_get_attachment_image_src($gimg_id, 'voip_blog-thumb', true);
							echo '<li class="wd-gallery-image-holder"><img src="' . esc_url($gimage_wp[0]) . ' " alt= "'.the_title().'"/></li>';
							endforeach;
						endif;
	  			?>
	  		</ul>
  		</div>
  		<div class="body text-secondary"><?php echo wp_trim_words(get_the_content(), 60); ?></div>
</article>