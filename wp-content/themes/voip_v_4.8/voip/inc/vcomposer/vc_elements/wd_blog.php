<?php

global $vc_add_css_animation;
/* recent blog
---------------------------------------------------------- */
vc_map(array(
  "name" => esc_html__("Recent blog", 'voip'),
  "base" => "wd_blog",
  "icon" => get_template_directory_uri() . "/images/icon/meknes.png",
  "content_element" => true,
  "is_container" => FALSE,
  "params" => array(
    array(
      "type" => "dropdown", // it will bind a textfield in WP
      "heading" => esc_html__("Style", 'voip'),
      "param_name" => "blog_style",
      "value" => array(
        'Default' => 'style2',
        'Small' => 'style1'
      ),
    ),
    array(
      "type" => "textfield", // it will bind a textfield in WP
      "heading" => esc_html__("Items to display", 'voip'),
      "param_name" => "itemperpage",
    ),
    array(
      "type" => "dropdown", // it will bind a textfield in WP
      "heading" => esc_html__("Columns", 'voip'),
      "param_name" => "columns",
      "value" => array('1', '2', '3', '4', '5', '6', '7'),
    ),
    array(
      "type" => "checkbox",
      "heading" => esc_html__("Display thumbnail", 'voip'),
      "param_name" => "show_thumbnail",
      "std" => "yes",
      'value' => array(esc_html__('Yes, please', 'voip') => 'yes'),
    ),
    array(
      "type" => "checkbox",
      "heading" => esc_html__("Display Pagination", 'voip'),
      "param_name" => "show_pagination",
    ),
    $vc_add_css_animation


  )
));