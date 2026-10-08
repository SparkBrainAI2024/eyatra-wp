<?php 

/**
 * Plugin Name: Webdevia main plugin
 * Plugin URI: http://www.themeforest.net/user/Mymoun
 * Description: Add features to Mymoun themes.
 * Version: 2.8
 * Author: Mymoun
 * Author URI: http://www.themeforest.net/user/Mymoun
 */



class WebdeviaMainPlugin {
  function __construct()
  {
    require_once(plugin_dir_path(__FILE__) . 'post-types.php');
    require_once(plugin_dir_path(__FILE__) . 'meta-box.php');


    require_once(plugin_dir_path(__FILE__) . 'widgets/widget.php');
    require_once(plugin_dir_path(__FILE__) . 'widgets/adress.php');
    require_once(plugin_dir_path(__FILE__) . '/import/wd-import.php');


    include_once(plugin_dir_path(__FILE__) . 'shortcode/latsone.php');
    include_once(plugin_dir_path(__FILE__) . 'shortcode/wd_pricing_table.php');
    include_once(plugin_dir_path(__FILE__) . 'shortcode/wd_client.php');
    include_once(plugin_dir_path(__FILE__) . 'shortcode/wd_team.php');
    include_once(plugin_dir_path(__FILE__) . 'shortcode/wd_vc_portfolio.php');
    include_once(plugin_dir_path(__FILE__) . 'shortcode/wd_testimonial.php');
    include_once(plugin_dir_path(__FILE__) . 'shortcode/wd_single_post.php');
    include_once(plugin_dir_path(__FILE__) . 'shortcode/wd_countup.php');
    include_once(plugin_dir_path(__FILE__) . 'shortcode/wd_chartpie.php');
    include_once(plugin_dir_path(__FILE__) . 'shortcode/wd_icon_text.php');
    include_once(plugin_dir_path(__FILE__) . 'shortcode/wd_flip_image.php');
    include_once(plugin_dir_path(__FILE__) . 'shortcode/wd_recent_blog.php');
    include_once(plugin_dir_path(__FILE__) . 'shortcode/wd_google_map.php');
    include_once(plugin_dir_path(__FILE__) . 'shortcode/progress_bars.php');
    include_once(plugin_dir_path(__FILE__) . 'shortcode/wd_hero_image.php');
    include_once(plugin_dir_path(__FILE__) . 'shortcode/wd_modal.php');
    include_once(plugin_dir_path(__FILE__) . 'shortcode/wd_headings.php');
    include_once(plugin_dir_path(__FILE__) . 'shortcode/wd_empty_spaces.php');
    include_once(plugin_dir_path(__FILE__) . 'shortcode/wd_text_icon.php');
    include_once(plugin_dir_path(__FILE__) . 'shortcode/wd_team_member.php');
    include_once(plugin_dir_path(__FILE__) . 'shortcode/wd_image_with_text.php');
    include_once(plugin_dir_path(__FILE__) . 'shortcode/wd-maps.php');
      add_action( 'admin_enqueue_scripts', 'voip_plugin_script' );
      function voip_plugin_script(){
          wp_enqueue_script( 'voip-plugin-script', plugin_dir_url( __FILE__ ) . '/js/media-upload.js', array( 'jquery' ) );
          wp_enqueue_script( 'voip-plugin-import-script', plugin_dir_url( __FILE__ ) . '/js/import_js.js', array( 'jquery' ) );
      }

  }
}
new WebdeviaMainPlugin;
//Product Cat Create page
function voip_taxonomy_add_new_meta_field() {
    $admiral_posts = get_posts(array('post_type' => 'product_cat_disc','posts_per_page'   => '99999',));
    $admiral_posts_array = array();
    foreach ( $admiral_posts as $key => $post ) {
        $admiral_posts_array[$post->post_title] = $post->ID;
    }
    ?>

    <div class="form-field">
        <select name="voip_disc_cat">
            <?php  foreach ($admiral_posts_array as $key => $value ) {
                ?><option value="<?php echo $value ?>"><?php echo $key ?></option><?php
            } ?>
        </select>
    </div>
    <?php
}

//Product Cat Edit page
function voip_taxonomy_edit_meta_field($term) {

    //getting term ID
    $term_id = $term->term_id;

    // retrieve the existing value(s) for this meta field.
    $wh_meta_title = get_term_meta($term_id, 'voip_disc_cat', true);

    $admiral_posts = get_posts(array('post_type' => 'product_cat_disc','posts_per_page'   => '99999',));
    $admiral_posts_array = array();
    foreach ( $admiral_posts as $key => $post ) {
        $admiral_posts_array[$post->post_title] = $post->ID;
    }
    ?>

    <div class="form-field">
        <select name="voip_disc_cat">
            <?php  foreach ($admiral_posts_array as $key => $value ) {
                ?><option value="<?php echo $value ?>" <?php if($wh_meta_title == $value) echo "selected" ?>><?php echo $key ?></option><?php
            } ?>
        </select>
    </div>

    <?php
}

add_action('product_cat_add_form_fields', 'voip_taxonomy_add_new_meta_field', 10, 1);
add_action('product_cat_edit_form_fields', 'voip_taxonomy_edit_meta_field', 10, 1);

// Save extra taxonomy fields callback function.
function voip_save_taxonomy_custom_meta($term_id) {

    $wh_meta_title = filter_input(INPUT_POST, 'voip_disc_cat');

    update_term_meta($term_id, 'voip_disc_cat', $wh_meta_title);
}

add_action('edited_product_cat', 'voip_save_taxonomy_custom_meta', 10, 1);
add_action('create_product_cat', 'voip_save_taxonomy_custom_meta', 10, 1);