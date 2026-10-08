<?php
if(!function_exists('last_Code')){
  function last_Code($atts) {
    
    $atts = shortcode_atts(
              array(
               
                'title' => 'Block title',
                'text'  => '',
                'thumbnail' => ''
              ), 
              $atts);
              
    extract( shortcode_atts( array(
      'title' => 'Block title',
      'text'  => '',
      'thumbnail' => ''
    ), $atts ) );
    
    $category = (is_array(unserialize($category))) ? array_values(unserialize($category)) : '';
    
    ob_start(); ?>
    
    
    <?php if($style=='style1'){$class='small';}else{$class='text-center';} ?>
      <div class="boxes <?php echo $class ?>">
        <div class="box-container">
              <div class="box-icon">
               <i class="fa <?php echo $icon; ?>"></i>
             </div>
             <h3 class="box-title"><?php echo $title; ?></h3>
             <p class="box-body"> <?php echo $text; ?></p>
         </div>
      </div>
      
      
    <?php return ob_get_clean();
  }
  add_shortcode( 'wd_last', 'last_Code' );
}