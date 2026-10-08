<?php

class wd_recent_post extends WP_Widget {
    function __construct() {
        parent::__construct(false, $name = 'Last Posts'); 
    }
  
function form($instance) {        
        $title = esc_attr($instance['title']);
        $dis_posts = esc_attr($instance['dis_posts']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('dis_posts'); ?>"><?php _e('Number of Posts Displayed:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('dis_posts'); ?>" name="<?php echo $this->get_field_name('dis_posts'); ?>" type="text" value="<?php echo $dis_posts; ?>" /></label></p>
        <?php 
    } 


function widget($args, $instance) {   
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
    $dis_posts = $instance['dis_posts'];
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; 
                        global $wp_registered_sidebars;
            foreach ($wp_registered_sidebars as $value){
              
                  if($value['name']=='footer'){
                    $class="black-separateur";
                  }else{
                    $class="";
                  }
              }
                        
                        ?>
 <div class="latest-posts <?php echo $class ?>">
                           <ul>
                             <?php
                             global $post;
                             global $wp_query;
                             $args = array( 'posts_per_page' => $dis_posts);
                             $loop = new WP_Query($args);
														 while ( $loop->have_posts() ) : $loop->the_post();
                              ?>
                             <li>

                              <div class="blog-image <?php if(is_rtl()) { echo 'right'; }else{ echo 'left'; }?>">
                    <a href="#"><?php the_post_thumbnail('wd_sidebar-thumb'); ?></a>
                  </div>
                  <h3 class="blog-title"><a href="#"><?php the_title(); ?></a></h3>
                  <div class="subheader">
                    <?php the_time('d') ?> <?php the_time('F') ?>,<?php the_time('Y') ?>
                  </div>
                </li>

                             <?php endwhile; ?>
                           </ul>
</div>
               <?php echo $after_widget; ?>
<?php
    }
} 
 
add_action('widgets_init', function () {
  register_widget("wd_recent_post");
});