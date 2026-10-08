<?php
if(!function_exists('wd_modal')){
  function wd_modal($atts) {
              
    extract( shortcode_atts( array(
      'modal_title' => '',
      'modal_text'  => 'Some text should be hrre...',
    ), $atts ) );
    

    ob_start(); ?>

<a data-effect="modal" class="open-first" data-reveal-id="tc_modal" data-options="animation:'none'" ><?php echo $modal_title; ?></a>
   <div id="tc_modal" class="reveal-modal small" data-reveal data-options="close_on_background_click: false;">
    <div class="row">
        <div class="large-12 columns tc_content">
            <?php echo $modal_text; ?>
        </div>
    </div>
    <a class="close-reveal-modal">&#215;</a>
</div>
      
    <?php return ob_get_clean();
  }
  add_shortcode( 'wd_modal', 'wd_modal' );
}  
?>