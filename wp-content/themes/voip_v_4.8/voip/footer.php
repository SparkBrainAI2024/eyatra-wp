        <!--.footer-columns -->
        <?php if ( is_active_sidebar('footer') || is_active_sidebar('footer_columns_three') || is_active_sidebar('footer_columns_tow') || is_active_sidebar('footer_columns_four') ) { ?>
  			<section class="l-footer-columns">
				  <h3 class="hide"><?php echo esc_html__('Footer', 'voip'); ?></h3>
  				<div class="row">
  					<section class="block">
  						<?php 
							if(voip_get_option('wd_footer_columns')=='one_columns'){
								$column_one = 12;
								$column_tow = '';
								$column_three = '';
								$column_four = '';

							}elseif(voip_get_option('wd_footer_columns')=='tow_a_columns'){
								$column_one = 4;
								$column_tow = 8;
								$column_three = '';
								$column_four = '';
							}elseif(voip_get_option('wd_footer_columns')=='tow_b_columns') {
								$column_one = 8;
								$column_tow = 4;
								$column_three = '';
								$column_four = '';
							}elseif(voip_get_option('wd_footer_columns')=='tow_c_columns') {
								$column_one = 6;
								$column_tow = 6;
								$column_three = '';
								$column_four = '';

							}elseif(voip_get_option('wd_footer_columns')=='three_columns') {
								$column_one = 4;
								$column_tow = 4;
								$column_three = 4;
								$column_four = '';
							}else {
								$column_one = 3;
								$column_tow = 3;
								$column_three = 3;
								$column_four = 3;
							}
  						 ?>
  						 <div class="large-<?php echo esc_attr($column_one) ?> columns">
  						 <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer') ) : ?><?php endif; ?>
  						 </div>	
  						 <?php  if(voip_get_option('wd_footer_columns')=='tow_a_columns' or voip_get_option('wd_footer_columns')=='four_columns' or voip_get_option('wd_footer_columns')=='three_columns' or  voip_get_option('wd_footer_columns')=='tow_b_columns' or voip_get_option('wd_footer_columns')=='tow_c_columns' ) { ?>
  						 	 <div class="large-<?php echo esc_attr($column_tow) ?> columns">
  						 	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer_columns_tow') ) : ?><?php endif; ?>
  						 	</div>
  						 	<?php }  
  						 	?>
  						 	
  						 	<?php  if(voip_get_option('wd_footer_columns')=='three_columns' or voip_get_option('wd_footer_columns')=='four_columns' ) { ?>
  						 	
  						 		 <div class="large-<?php echo esc_attr($column_three) ?> columns">
  						 		
  						 		<?php 
  						 		
  						 		if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer_columns_three') ) : ?><?php endif; 
  						 		
  						 		?>
  						 		</div>
  						 		<?php } ?>
  						 		
  						 		<?php  if(voip_get_option('wd_footer_columns')=='four_columns') { ?>
  						 	
  						 		 <div class="large-<?php echo esc_attr($column_four) ?> columns">
  						 		
  						 		<?php 
  						 		
  						 		if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer_columns_four') ) : ?><?php endif; 
  						 		
  						 		?>
  						 		</div>
  						 		<?php } ?>
  					</section>
  				</div>
  			</section>
  			<?php } ?>
  			<!--/.footer-columns-->
  
  			<!--.l-footer-->
  			<footer class="l-footer">
  				<div class="row">
  					<div class="footer large-4 columns">
  						<section class="block">
  							<span><?php echo esc_html__('Powered by', 'voip'); ?> <a href="<?php echo esc_url(home_url('/')); ?>"><?php echo  voip_get_option('wd_poweredby','voip') ?></a></span>
  						</section>
  					</div>
  					<div class="large-4 columns">
  						
  					</div>
  					<div class="copyright large-4 text-right columns">
  						<p>
  						<?php  echo esc_html(voip_get_option('wd_copyright','&copy; 2022 voip All rights reserved. '));   ?>
  						</p>
  					</div>
  				</div>
  			</footer>
  			<!--/.footer-->
  
  		  <!--/.page -->
  		
			<?php
				$menu_style = voip_get_option('wd_menu_style');
				if($menu_style == "offcanvas") { ?>
					<a class="exit-off-canvas"></a>
					</div></div>
				<?php } ?>
			<!-- end offcanvas -->
			<?php
		
			wp_footer();
		?>
	
	</body>
</html>