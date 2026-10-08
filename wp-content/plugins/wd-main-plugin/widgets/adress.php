<?php
class contactInfo extends WP_Widget {
    function __construct() {
        parent::__construct(false, $name = 'contact-info');	
    }
	
function form($instance) {				
        $title = esc_attr($instance['title']);
        $phoneNumber = esc_attr($instance['phoneNumber']);
        $fax = esc_attr($instance['fax']);
        $email = esc_attr($instance['email']);
        $adress = esc_attr($instance['adress']);
        ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> 
                    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
                </label>
            </p>
     		<p>
                <label for="<?php echo $this->get_field_id('phoneNumber'); ?>"><?php _e('Phone Number:'); ?> 
                    <input class="widefat" id="<?php echo $this->get_field_id('phoneNumber'); ?>" name="<?php echo $this->get_field_name('phoneNumber'); ?>" type="text" value="<?php echo $phoneNumber; ?>" />
                </label>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('fax'); ?>"><?php _e('fax Number:'); ?> 
                    <input class="widefat" id="<?php echo $this->get_field_id('fax'); ?>" name="<?php echo $this->get_field_name('fax'); ?>" type="text" value="<?php echo $fax; ?>" />
                </label>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('E-mail:'); ?> 
                    <input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo $email; ?>" />
                </label>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('adress'); ?>"><?php _e('Adress:'); ?> 
                    <input class="widefat" id="<?php echo $this->get_field_id('adress'); ?>" name="<?php echo $this->get_field_name('adress'); ?>" type="text" value="<?php echo $adress; ?>" />
                </label>
            </p>
        <?php 
    }	


function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
		$phoneNumber = $instance['phoneNumber'];
        $fax = $instance['fax'];
        $email = $instance['email'];
        $adress = $instance['adress'];
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
 <section class="block-block contact-details block-block-19 block-even clearfix">

                

                        <ul class="contact-details-list">
                            <li>
                                <i class="fa fa-phone"></i><span>Phone: <?php echo $phoneNumber ?></span>
                            </li>
                            <li>
                                <i class="fa fa-file-o"></i><span>Fax: <?php echo $fax ?></span>
                            </li>
                            <li>
                                <i class="fa fa-envelope-o"></i><span>Email: <a href="mailto:email@website.com"><?php echo $email ?></a></span>
                            </li>
                            <li>
                                <i class="fa fa-map-marker"></i><span>Adress: <?php echo $adress ?></span>
                            </li>
                        </ul>
                    </section>
               <?php echo $after_widget;

    }
}

 
add_action('widgets_init', function () {
    register_widget("contactInfo");
  });