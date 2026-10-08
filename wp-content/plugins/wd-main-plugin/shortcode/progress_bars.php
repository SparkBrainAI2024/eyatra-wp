<?php
if(!function_exists('wd_progress_bars')){
  function wd_progress_bars($atts) {
              
    extract( shortcode_atts( array(
    'title' => '',
		'progress_title1'=>'',
    'progress_meter1'=>'',
		'progress_title2'=>'',
    'progress_meter2'=>'',
		'progress_title3'=>'',
    'progress_meter3'=>'',
		'progress_title4'=>'',
    'progress_meter4'=>'',
    
    ), $atts ) );
    
    ob_start(); ?>
						<div class="block-content">
							<h3 class="progress_title">
								<?php echo $progress_title1 ?> 
							</h3>
							<div class="progress  round">
								<span style="width: <?php echo $progress_meter1 ?>%" class="meter orange"></span>
							</div>
							<h3 class="progress_title">
								<?php echo $progress_title2 ?> 
							</h3>
							<div class="progress  round">
								<span style="width: <?php echo $progress_meter2 ?>%" class="meter green"></span>
							</div>
							<h3 class="progress_title">
								<?php echo $progress_title3 ?> 
							</h3>
							<div class="progress  round">
								<span style="width: <?php echo $progress_meter3 ?>%" class="meter blue"></span>
							</div>
							<h3 class="progress_title">
								<?php echo $progress_title4 ?> 
							</h3>
							<div class="progress  round">
								<span style="width: <?php echo $progress_meter4 ?>%" class="meter pink"></span>
							</div>
						</div>
    <?php return ob_get_clean();
  }
  add_shortcode( 'wd_progress_bars', 'wd_progress_bars' );
}  
?>