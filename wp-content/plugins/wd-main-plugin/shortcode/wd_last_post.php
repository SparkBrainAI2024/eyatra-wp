<?php
if(!function_exists('last_post_Code')){
  function last_post_Code($atts) {
    
    $atts = shortcode_atts(
              array(
               
                'title' => 'Block title',
                'text'  => 'Some text should be hrre...',
                'thumbnail' => ''
              ), 
              $atts);
              
    extract( shortcode_atts( array(
      'title' => 'Block title',
      'text'  => 'Some text should be hrre...',
      'thumbnail' => ''
    ), $atts ) );
    
    $category = (is_array(unserialize($category))) ? array_values(unserialize($category)) : '';
    
    ob_start(); ?>
    
    
    <section class="block block-views title-center block-views-blog-block">

								<h2 class="block-title"><?php echo $title ?></h2>

								<div class="view view-blog view-id-blog view-display-id-block">

									<div class="view-content">
										<h3></h3>

										<div class="row unique-d squares" style="padding: 0px;">

											<div class="large-4 columns  square-row square-bottom  color-4" style="padding: 0px; height: 486px;">
												<div class="square-txt color-4">
													<span class="arrow">&nbsp;</span>
													<h2><a href="#">Massa eu blandit</a></h2>
													<div class="post_text">
														<p>
															Sed odio orci, fringilla nec dolor et, euismod auctor mauris. Curabitur semper dui diam, nec accumsan mauris consequat sed. Interdum et malesuada fames ac ante ipsum p...
													</div>
													<div class="post-read-more right">
														<a href="#">Read more</a>
													</div>
												</div>
												<div class="square-img">
													<i class="fa fa-plus"></i><a href="#"><img src=images/img/252252892_6b8f6673db_b.jpg /></a>
												</div>
											</div>

											<div class="large-8 columns  p-0 m-0"  style="padding: 0px;">

												<div class="row square-row square-left color-5"  style="min-height: 243px;">
													<div class="square-txt color-5">
														<span class="arrow">&nbsp;</span>
														<h2><a href="#">Sed quis enim nibh</a></h2>
														<div class="post_text">
															<p>
																Donec condimentum gravida lacus, vitae mattis orci lacinia id. Mauris laoreet ligula in tellus ullamcorper, vitae semper urna volutpat. Donec sit amet felis eget nulla luctus pharetra. Pe...
														</div>
														<div class="post-read-more right">
															<a href="#">Read more</a>
														</div>
													</div>
													<div class="square-img">
														<i class="fa fa-plus"></i><a href="#"><img src=images/img/8749154615_26586761c6_b_0.jpg /></a>
													</div>
												</div>

												<div class="row square-row square-right color-3" style="min-height: 243px;">
													<div class="square-img">
														<i class="fa fa-plus"></i>
														<a href="#"><img src=images/img/5561385051_d6c5739e0f_b.jpg /></a>
													</div>
													<div class="square-txt color-3">
														<span class="arrow">&nbsp;</span>
														<h2><a href="#">Duis egestas augue</a></h2>
														<div class="post_text">
															<p>
																Fusce vitae sem posuere, ornare tellus et, ullamcorper felis. Mauris eget lacus id eros pulvinar rutrum. Aenean ac mauris in sem malesuada pulvinar. Ut sapien lacus, tincidunt in fringill...
														</div>
														<div class="post-read-more right">
															<a href="#">Read more</a>
														</div>
													</div>
												</div>

											</div>
										</div>
									</div>

								</div>
							</section>
      
      
    <?php return ob_get_clean();
  }
  add_shortcode( 'wd_last_post', 'last_post_Code' );
}