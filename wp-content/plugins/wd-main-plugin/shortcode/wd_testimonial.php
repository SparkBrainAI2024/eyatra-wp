<?php 
function webdevia_testimonials($atts) {
  global $webdevia_fonts_to_enqueue_array;
  $custom_testimonial_name_inline_style = $custom_testimonial_job_title_inline_style = $custom_testimonial_text_inline_style = "";
  extract( shortcode_atts( array(
    'layout_style' => 'carousel',
    'testimonial_title_tag' => 'h6',
    'testimonial_title_font_family' => 'Montserrat',
    'testimonial_title_font_size' => '18',
    'testimonial_title_color' => '#FFF',
    'webdevia_testimonial_categories' => '',
    'testimonial_title_font_weight' => '700',
    'testimonial_items_to_show' => '4',
    'testimonial_title_text_transform' => 'uppercase',
    'testimonial_title_line_height' => '',
    'testimonial_title_letter_spacing' => '',
    'testimonial_title_font_style' => 'normal',

    'testimonial_job_title_tag' => 'span',
    'testimonial_job_title_font_family' => 'Montserrat',
    'testimonial_job_title_font_size' => '13',
    'testimonial_job_title_color' => '#CCC',
    'testimonial_job_title_font_weight' => '400',
    'testimonial_job_title_text_transform' => 'none',
    'testimonial_job_title_line_height' => '',
    'testimonial_job_title_letter_spacing' => '',
    'testimonial_job_title_font_style' => 'normal',

    'testimonial_text_font_family' => 'open sans',
    'testimonial_text_font_size' => '24',
    'testimonial_text_color' => '#fff',
    'testimonial_text_font_weight' => '400',
    'testimonial_text_text_transform' => 'inherit',
    'testimonial_text_line_height' => '37',
    'testimonial_text_letter_spacing' => '0',
    'testimonial_text_font_style' => 'italic',

    'testimonial_text_margin' => '90px',
    'testimonial_quotes_margin' => '60px',

    'thumbnail_position' => 'bottom',

    'testimonial_quotes_font_size' => '48',
    'testimonial_quotes_color' => '#FFF',
    'testimonial_quotes_opacity' => '25',
    'infinity_scroll' => '',

    'show_thumbnail' => 'yes',

    
  ), $atts ) );




    $webdevia_font_family_testimonial_to_enqueue = "";
    // Testimonial Title inline style
    if($testimonial_title_font_family != '') {
      $custom_testimonial_name_inline_style .= 'font-family:'.esc_attr($testimonial_title_font_family).';';
      $webdevia_font_family_testimonial_to_enqueue .= esc_attr($testimonial_title_font_family) . ":";
    }
    if($testimonial_title_font_weight != '' && $testimonial_title_font_family != '') {
      $custom_testimonial_name_inline_style .= 'font-weight:'.esc_attr($testimonial_title_font_weight).';';
      $webdevia_font_family_testimonial_to_enqueue .= esc_attr($testimonial_title_font_weight) . "%7C";
    }
    if($testimonial_title_font_size != '') {
      $custom_testimonial_name_inline_style .= 'font-size:'.esc_attr($testimonial_title_font_size).'px;';
    }
    if($testimonial_title_color != '') {
      $custom_testimonial_name_inline_style .= 'color:'.esc_attr($testimonial_title_color).';';
    }
    if($testimonial_title_text_transform != '') {
      $custom_testimonial_name_inline_style .= 'text-transform:'.esc_attr($testimonial_title_text_transform).';';
    }
    if($testimonial_title_line_height != '') {
      $custom_testimonial_name_inline_style .= 'line-height:'.esc_attr($testimonial_title_line_height).'px;';
    }
    if($testimonial_title_letter_spacing != '') {
      $custom_testimonial_name_inline_style .= 'letter-spacing:'.esc_attr($testimonial_title_letter_spacing).'px;';
    }
    if($testimonial_title_font_style != '') {
      $custom_testimonial_name_inline_style .= 'font-style:'.esc_attr($testimonial_title_font_style).';';
    }

    $webdevia_fonts_to_enqueue_array[] = esc_attr($webdevia_font_family_testimonial_to_enqueue);

    $webdevia_font_family_testimonial_to_enqueue = "";

    // Testimonial Job Title inline style
    if($testimonial_job_title_font_family != '') {
      $custom_testimonial_job_title_inline_style .= 'font-family:'.esc_attr($testimonial_job_title_font_family).';';
      $webdevia_font_family_testimonial_to_enqueue .= esc_attr($testimonial_job_title_font_family) . ":";
    }
    if($testimonial_job_title_font_weight != '' && $testimonial_job_title_font_family != '') {
      $custom_testimonial_job_title_inline_style .= 'font-weight:'.esc_attr($testimonial_job_title_font_weight).';';
      $webdevia_font_family_testimonial_to_enqueue .= esc_attr($testimonial_job_title_font_weight) . "%7C";
    }
    if($testimonial_job_title_font_size != '') {
      $custom_testimonial_job_title_inline_style .= 'font-size:'.esc_attr($testimonial_job_title_font_size).'px;';
    }
    if($testimonial_job_title_color != '') {
      $custom_testimonial_job_title_inline_style .= 'color:'.esc_attr($testimonial_job_title_color).';';
    }
    if($testimonial_job_title_text_transform != '') {
      $custom_testimonial_job_title_inline_style .= 'text-transform:'.esc_attr($testimonial_job_title_text_transform).';';
    }
    if($testimonial_job_title_line_height != '') {
      $custom_testimonial_job_title_inline_style .= 'line-height:'.esc_attr($testimonial_job_title_line_height).'px;';
    }
    if($testimonial_job_title_letter_spacing != '') {
      $custom_testimonial_job_title_inline_style .= 'letter-spacing:'.esc_attr($testimonial_job_title_letter_spacing).'px;';
    }
    if($testimonial_job_title_font_style != '') {
      $custom_testimonial_job_title_inline_style .= 'font-style:'.esc_attr($testimonial_job_title_font_style).';';
    }
    $webdevia_fonts_to_enqueue_array[] = esc_attr($webdevia_font_family_testimonial_to_enqueue);

    $webdevia_font_family_testimonial_to_enqueue = "";

    // Testimonial text inline style
    if($testimonial_text_font_family != '') {
      $custom_testimonial_text_inline_style .= 'font-family:'.esc_attr($testimonial_text_font_family).';';
      $webdevia_font_family_testimonial_to_enqueue .= esc_attr($testimonial_text_font_family) . ":";
    }
    if($testimonial_text_font_weight != '' && $testimonial_text_font_family != '') {
      $custom_testimonial_text_inline_style .= 'font-weight:'.esc_attr($testimonial_text_font_weight).';';
      $webdevia_font_family_testimonial_to_enqueue .= esc_attr($testimonial_job_title_font_weight) . "%7C";
    }
    if($testimonial_text_font_size != '') {
      $custom_testimonial_text_inline_style .= 'font-size:'.esc_attr($testimonial_text_font_size).'px;';
    }
    if($testimonial_text_color != '') {
      $custom_testimonial_text_inline_style .= 'color:'.esc_attr($testimonial_text_color).';';
    }
    if($testimonial_text_text_transform != '') {
      $custom_testimonial_text_inline_style .= 'text-transform:'.esc_attr($testimonial_text_text_transform).';';
    }
    if($testimonial_text_line_height != '') {
      $custom_testimonial_text_inline_style .= 'line-height:'.esc_attr($testimonial_text_line_height).'px;';
    }
    if($testimonial_text_letter_spacing != '') {
      $custom_testimonial_text_inline_style .= 'letter-spacing:'.esc_attr($testimonial_text_letter_spacing).'px;';
    }
    if($testimonial_text_font_style != '') {
      $custom_testimonial_text_inline_style .= 'font-style:'.esc_attr($testimonial_text_font_style).';';
    }
    if($testimonial_quotes_margin != '') {
      $custom_testimonial_text_inline_style .= 'padding: '.esc_attr($testimonial_quotes_margin).';';
    }

    $webdevia_category_array = explode(",", $webdevia_testimonial_categories);

    $webdevia_fonts_to_enqueue_array[] = esc_attr($webdevia_font_family_testimonial_to_enqueue);



  ob_start(); ?>
<?php if ($layout_style == "carousel"){ ?>


<?php if ($thumbnail_position == "top"){ ?>
  <?php if ($show_thumbnail == "yes"){ ?>
  <div class="owl-thumb-navigation">
    <ul class="owl-thumbs" data-slider-id="1">
    <li class="owl-thumb-item"><a class="testimonial-prev"><i class="fa fa-angle-left"></i></a></li>
    <?php 
    global $wp_query;
    if( $webdevia_testimonial_categories == "" )
    {
      query_posts( array( 'post_type' => 'testimonials', 'posts_per_page' => $testimonial_items_to_show ));
    }
    if( $webdevia_testimonial_categories != "" ) {
      query_posts( array( 
                          'post_type' => 'testimonials', 
                          'posts_per_page' => $testimonial_items_to_show,
                          'tax_query' => array( 
                                                 'relation' => 'AND',
                                                 array( 
                                                        'taxonomy' => 'testimonials_categories', 
                                                        'field' => 'slug',
                                                        'terms' => $webdevia_category_array
                                                      ) 
                                              ) 
                        ) 
      );
    }
    while ( have_posts() ) : the_post();  ?>
          <li class="owl-thumb-item">
            <?php 
                  $image_url = get_post_meta(get_the_ID(), 'testimonail_image', true);
                  
                  $image_id = voip_get_image_id($image_url);

                  print wp_get_attachment_image( $image_id, 'webdevia_testimonial' );
                ?>
          </li>
        <?php endwhile;

        wp_reset_query();
        ?>
        <li class="owl-thumb-item"><a class="testimonial-next"><i class="fa fa-angle-right"></i></a></li>
    </ul>
  </div>
    
  <?php } } ?>
  <div class="owl-testimonail wd-testimonail" <?php if ($show_thumbnail == "yes") { echo 'data-slider-id="1"'; } if ($infinity_scroll == "yes") { echo 'data-infinity="true"'; } ?>>
  <?php 
    if( $webdevia_testimonial_categories == "" )
    {
      query_posts( array( 'post_type' => 'testimonials', 'posts_per_page' => $testimonial_items_to_show ));
    }
    if( $webdevia_testimonial_categories != "" ) {
      query_posts( array( 
                          'post_type' => 'testimonials', 
                          'posts_per_page' => $testimonial_items_to_show,
                          'tax_query' => array( 
                                                 'relation' => 'AND',
                                                 array( 
                                                        'taxonomy' => 'testimonials_categories', 
                                                        'field' => 'slug',
                                                        'terms' => $webdevia_category_array
                                                      ) 
                                              ) 
                        ) 
      );
    }
    while ( have_posts() ) : the_post();  ?>
            <blockquote class="wd-testimonail-item" style="margin: <?php echo esc_attr($testimonial_text_margin); ?>">

                <div class="testimonial-text" data-quotesize="<?php echo esc_attr($testimonial_quotes_font_size); ?>" data-quotecolor="<?php echo esc_attr($testimonial_quotes_color) ?>" data-quoteopacity="<?php echo esc_attr($testimonial_quotes_opacity); ?>" style="<?php echo esc_attr($custom_testimonial_text_inline_style); ?>">
                   <?php echo get_the_excerpt(); ?>
                </div>


                <<?php echo esc_attr($testimonial_title_tag); ?> class="testimonial-title" style="<?php echo esc_attr($custom_testimonial_name_inline_style); ?>">
                   <?php the_title(); ?>
                </<?php echo esc_attr($testimonial_title_tag); ?>>

                <<?php echo esc_attr($testimonial_job_title_tag); ?> class="job-title" style="<?php echo esc_attr($custom_testimonial_job_title_inline_style); ?>">
                   <?php echo get_post_meta(get_the_ID(), 'job_title', true) ?>
                </<?php echo esc_attr($testimonial_job_title_tag); ?>>
            </blockquote>
    <?php endwhile;
    wp_reset_query();
    ?>
  </div>
  <?php if ($thumbnail_position == "bottom"){ ?>
    <?php if ($show_thumbnail == "yes"){ ?>
    <div class="owl-thumb-navigation">
      <ul class="owl-thumbs" data-slider-id="1">
      <li class="owl-thumb-item"><a class="testimonial-prev"><i class="fa fa-angle-left"></i></a></li>
       <?php 
        if( $webdevia_testimonial_categories == "" )
        {
          query_posts( array( 'post_type' => 'testimonials', 'posts_per_page' => $testimonial_items_to_show ));
        }
        if( $webdevia_testimonial_categories != "" ) {
          query_posts( array( 
                              'post_type' => 'testimonials', 
                              'posts_per_page' => $testimonial_items_to_show,
                              'tax_query' => array( 
                                                     'relation' => 'AND',
                                                     array( 
                                                            'taxonomy' => 'testimonials_categories', 
                                                            'field' => 'slug',
                                                            'terms' => $webdevia_category_array
                                                          ) 
                                                  ) 
                            ) 
          );
        }
        while ( have_posts() ) : the_post();  ?>
            <li class="owl-thumb-item">

              <?php 
                  $image_url = get_post_meta(get_the_ID(), 'testimonail_image', true);
                  $image = aq_resize( $image_url, 70, 70, true, true, true );
              ?>
                <img src="<?php echo $image ?>" alt="<?php the_title(); ?>"/> 
            </li>
          <?php endwhile;
          wp_reset_query();
          ?>
          <li class="owl-thumb-item"><a class="testimonial-next"><i class="fa fa-angle-right"></i></a></li>
      </ul>
    </div>
      
    <?php } } ?>
  <?php }

         if ($layout_style == "slider"){ ?>
         <div class="testimonial-slider" <?php if ($infinity_scroll == "yes") { echo 'data-infinity="true"'; } ?>>
           <?php 
              if( $webdevia_testimonial_categories == "" )
              {
                query_posts( array( 'post_type' => 'testimonials', 'posts_per_page' => $testimonial_items_to_show ));
              }
              if( $webdevia_testimonial_categories != "" ) {
                query_posts( array( 
                                    'post_type' => 'testimonials', 
                                    'posts_per_page' => $testimonial_items_to_show,
                                    'tax_query' => array( 
                                                           'relation' => 'AND',
                                                           array( 
                                                                  'taxonomy' => 'testimonials_categories', 
                                                                  'field' => 'slug',
                                                                  'terms' => $webdevia_category_array
                                                                ) 
                                                        ) 
                                  ) 
                );
              }
              while ( have_posts() ) : the_post();  ?>
              <div class="testimonial-slider-item row">
              <div class="testimonial-picture large-6 column">
                 <?php 
                    $image_url = get_post_meta(get_the_ID(), 'testimonail_image', true);
                    
                    $image_id = voip_get_image_id($image_url);

                    print wp_get_attachment_image( $image_id, 'webdevia_testimonial_large' );
                  ?>
              </div>
                <div class="testimonial-text-container large-6 column">
                   <div class="testimonial-text" data-quotesize="<?php echo esc_attr($testimonial_quotes_font_size); ?>" data-quotecolor="<?php echo esc_attr($testimonial_quotes_color) ?>" data-quoteopacity="<?php echo esc_attr($testimonial_quotes_opacity); ?>" style="<?php echo esc_attr($custom_testimonial_text_inline_style); ?>">
                      <?php the_excerpt(); ?>
                   </div>
                   <div class="clearfix">
                     <div class="testimonial-name left">
                       <<?php echo esc_attr($testimonial_title_tag); ?> class="testimonial-title" style="<?php echo esc_attr($custom_testimonial_name_inline_style); ?>">
                          <?php the_title(); ?>
                       </<?php echo esc_attr($testimonial_title_tag); ?>>
                     </div>
                     <div class="testimonial-job-title">
                       <<?php echo esc_attr($testimonial_job_title_tag); ?> class="job-title" style="<?php echo esc_attr($custom_testimonial_job_title_inline_style); ?>">
                      <?php echo get_post_meta(get_the_ID(), 'job_title', true) ?>
                   </<?php echo esc_attr($testimonial_job_title_tag); ?>>
                     </div>
                   </div>
                  
                </div>
             
              </div>
             <?php endwhile; 
             wp_reset_query();
             ?>
            </div>
           <?php } ?>


           <?php if ($layout_style == "boxes-carousel"){ ?>
           <div class="wd-sly-carousel-container">
             <div class="wd-sly-carousel">
                <ul class="clearfix">
                <?php 
                  if( $webdevia_testimonial_categories == "" )
                  {
                    query_posts( array( 'post_type' => 'testimonials', 'posts_per_page' => $testimonial_items_to_show ));
                  }
                  if( $webdevia_testimonial_categories != "" ) {
                    query_posts( array( 
                                        'post_type' => 'testimonials', 
                                        'posts_per_page' => $testimonial_items_to_show,
                                        'tax_query' => array( 
                                                               'relation' => 'AND',
                                                               array( 
                                                                      'taxonomy' => 'testimonials_categories', 
                                                                      'field' => 'slug',
                                                                      'terms' => $webdevia_category_array
                                                                    ) 
                                                            ) 
                                      ) 
                    );
                  }
                  while ( have_posts() ) : the_post();  ?>
                  <li>
                  <?php 
                      $image_url = get_post_meta(get_the_ID(), 'testimonail_image', true);
                      $image = aq_resize( $image_url, 90, 90, true, true, true );
                  ?>
                    <img src="<?php echo $image ?>" alt="<?php the_title(); ?>"/> 
                    <div class="sly-text">
                        <<?php echo esc_attr($testimonial_title_tag); ?> class="testimonial-title" style="<?php echo esc_attr($custom_testimonial_name_inline_style); ?>">
                            <?php the_title(); ?>
                        </<?php echo esc_attr($testimonial_title_tag); ?>>
                        <div style="<?php echo esc_attr($custom_testimonial_text_inline_style); ?>">
                          <?php the_excerpt(); ?>
                        </div>
                    </div>
                  </li>
                <?php endwhile; 
                wp_reset_query();
                ?>
                </ul>
              </div>
              <div class="scrollbar">
                  <div class="handle">
                      <div class="mousearea"></div>
                  </div>
              </div>
            </div>
           <?php } ?>
  
<?php return ob_get_clean();
}
add_shortcode( 'webdevia_testimonials', 'webdevia_testimonials' );