<?php 
function wd_pricing_table($atts) {
           
  extract( shortcode_atts( array(
    'title'       => 'Standard',
    'price'       => '$99.99',
    'description' => 'An awesome description',
    'button_text' => 'Buy Now',
    'button_link' => '#',
    'featured'    => '',
    'content_text'     => '<ul><li>Option #1</li><li>Option #2</li><li>Option #3</li><li>Option #4</li></ul>',
  ), $atts ) );

    $voip_button_link_array = vc_build_link($button_link);
    $button_link = $voip_button_link_array['url'];

  ob_start(); ?>
  
  
  <div class="pricing-table <?php echo $featured; ?>">
  <div class="pricing-table-info">
  	<div class="title"><h2><?php echo $title; ?></h2></div>
    <div class="price"><h4><?php echo $price; ?></h4></div>
    <div class="description"><p><?php echo $description; ?></p></div>
  </div>
  <div class="content-description"><?php echo $content_text; ?></div>
  <div class="pricing-table-button">
  	<i class="fa fa-arrow-down"></i>
  	<div class="cta-button">
  	 <a href="<?php echo $button_link;?>" class="button"><?php echo $button_text; ?></a>
  	 </div>
  </div>
  </div>
<?php return ob_get_clean();
}
add_shortcode( 'wd_pricing_table', 'wd_pricing_table' );