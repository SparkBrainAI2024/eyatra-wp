<?php


/*///////////////////////////////// Register Panel Scripts and Styles /////////////////////////////////////////*/

global $voip_fontArray;


function voip_admin_register($hooks) {

  if ($hooks){
	wp_register_script( 'wd-admin-main', get_template_directory_uri() . '/inc/js/script.js',
		array(
			'jquery',
			'jquery-ui-core',
			'jquery-ui-widget',
			'jquery-ui-mouse',
			'jquery-ui-tabs',
			'jquery-ui-droppable',
			'jquery-ui-sortable'
		), false, false );
  }
	wp_register_style( 'wd-style', get_template_directory_uri() . '/inc/css/style.css', array(), '20120208', 'all' );

	wp_enqueue_media();
	wp_register_style( 'wd-jquery-ui-fontSelector', get_template_directory_uri() . '/css/jquery.ui.fontSelector.css', array(), '4.3.1', 'all' );


	$voip_font_body_name         = voip_get_option( 'wd_body_font_familly' );
	$voip_font_weight_style      = voip_get_option( 'wd_body_font_weight' );
	$voip_main_text_font_subsets = voip_get_option( 'wd_main-text-font-subsets' );

	$voip_font_header_name          = voip_get_option( 'wd_head_font_familly' );
	$voip_heading_font_weight_style = voip_get_option( 'wd_heading-font-weight-style' );
	$voip_heading_text_font_subsets = voip_get_option( 'wd_heading-text-font-subsets' );

	$voip_navigation_font_familly      = voip_get_option( 'wd_navigation_font_familly' );
	$voip_navigation_font_weight_style = voip_get_option( 'wd_navigation-font-weight-style' );
	$voip_navigation_text_font_subsets = voip_get_option( 'wd_navigation-text-font-subsets' );
	$voip_protocol                     = is_ssl() ? 'https' : 'http';

	if ( $voip_font_body_name != "" && $voip_font_body_name != "default" ) {
		wp_register_style( 'wd-google-fonts-body', voip_fonts_url( esc_html( $voip_font_body_name ) , $voip_font_weight_style , $voip_main_text_font_subsets ), false, null, 'all' );
	}
	if ( $voip_font_header_name != "" && $voip_font_header_name != "default" ) {
		wp_register_style( 'wd-google-fonts-heading', voip_fonts_url( esc_html( $voip_font_header_name ) , $voip_heading_font_weight_style , $voip_heading_text_font_subsets ), false, null, 'all' );
	}
	if ( $voip_navigation_font_familly != "" && $voip_navigation_font_familly != "default" ) {
		wp_register_style( 'wd-google-fonts-navigation', voip_fonts_url( esc_html( $voip_navigation_font_familly ) , $voip_navigation_font_weight_style, $voip_navigation_text_font_subsets ), false, null, 'all' );
	}


	if ( isset( $_GET['page'] ) && $_GET['page'] == 'option panel' ) {


	}
	wp_enqueue_script( 'wd-admin-main' );
	wp_enqueue_style( 'wd-style' );
	wp_enqueue_style( 'wd-jquery-ui-fontSelector' );
	wp_enqueue_style( 'wd-google-fonts' );
	wp_enqueue_style( 'wd-google-fonts-body' );
	wp_enqueue_style( 'wd-google-fonts-heading' );
	wp_enqueue_style( 'wd-google-fonts-navigation' );

}

add_action( 'admin_enqueue_scripts', 'voip_admin_register' );


if ( ! function_exists( 'voip_load_color_picker' ) ) {
	add_action( 'load-widgets.php', 'voip_load_color_picker' );
	function voip_load_color_picker() {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
	}
}


/*///////////////////////////////// Theme Options /////////////////////////////////////////*/
if ( ! function_exists( 'voip_panel_option' ) ) {
	add_action( 'admin_menu', 'voip_panel_option' );
	function voip_panel_option() {
		if ( class_exists( 'WebdeviaMainPlugin' ) ) {
			add_theme_page( 'Voip Theme Options', 'Voip Theme Options', 'edit_theme_options', 'voip-theme-option', 'voip_theme_option' );
		}


	}
}


if ( ! function_exists( 'voip_theme_option' ) ) {
	function voip_theme_option() {

		wp_enqueue_media();


		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );


		wp_enqueue_script( 'colorpick', get_template_directory_uri() . "/js/bootstrap-colorpicker.min.js", array( 'jquery' ) );
		wp_enqueue_style( 'colorpick', get_template_directory_uri() . "/css/bootstrap-colorpicker.min.css" );

		wp_enqueue_style( 'voip_font_selector_css', get_template_directory_uri() . "/css/jquery.ui.fontSelector.css" );
		wp_enqueue_script( 'voip-js-panel', get_template_directory_uri() . "/inc/js/panel_script.js", array( 'jquery' ) );
		?>

		<?php


		if ( ! empty( $_POST ) ) {
			if ( isset( $_POST['wd_show_logo'] ) ) {
				voip_save_option( 'wd_show_logo', sanitize_text_field( $_POST['wd_show_logo'] ) );
			} else {
				voip_save_option( 'wd_show_logo', 'off' );
			}


			if ( isset( $_POST['wd_show_cart'] ) ) {
				voip_save_option( 'wd_show_cart', sanitize_text_field( $_POST['wd_show_cart'] ) );
			} else {
				voip_save_option( 'wd_show_cart', '' );
			}

			if ( isset( $_POST['wd_show_top_social_bare'] ) ) {
				voip_save_option( 'wd_show_top_social_bare', sanitize_text_field( $_POST['wd_show_top_social_bare'] ) );
			} else {
				voip_save_option( 'wd_show_top_social_bare', '' );
			}

			if ( isset( $_POST['wd_box_wrapper'] ) ) {
				voip_save_option( 'wd_box_wrapper', sanitize_text_field( $_POST['wd_box_wrapper'] ) );
			} else {
				voip_save_option( 'wd_box_wrapper', 'of' );
			}


			if ( isset( $_POST['wd_menu_in_grid'] ) ) {
				voip_save_option( 'wd_menu_in_grid', sanitize_text_field( $_POST['wd_menu_in_grid'] ) );
			} else {
				voip_save_option( 'wd_menu_in_grid', 'off' );
			}

			if ( isset( $_POST['wd_menu_sticky'] ) ) {
				voip_save_option( 'wd_menu_sticky', sanitize_text_field( $_POST['wd_menu_sticky'] ) );
			} else {
				voip_save_option( 'wd_menu_sticky', 'off' );
			}


			if ( isset( $_POST['wd_show_title'] ) ) {
				voip_save_option( 'wd_show_title', sanitize_text_field( $_POST['wd_show_title'] ) );
			} else {
				voip_save_option( 'wd_show_title', 'of' );
			}

			if ( isset( $_POST['settings']['_wd_footer_bg_image'] ) && sanitize_text_field( $_POST['settings']['_wd_footer_bg_image'] ) != "" ) {
				voip_save_option( 'wd_footer_bg_image', sanitize_text_field( $_POST['settings']['_wd_footer_bg_image'] ) );
			}

			voip_save_option( 'footer_bg_color', sanitize_text_field( $_POST['footer_bg_color'] ) );
			voip_save_option( 'footer_text_color', sanitize_text_field( $_POST['footer_text_color'] ) );
			voip_save_option( 'wd_copyright', sanitize_text_field( $_POST['wd_copyright'] ) );
			voip_save_option( 'wd_poweredby', sanitize_text_field( $_POST['wd_poweredby'] ) );
			voip_save_option( 'copyright_text_color', sanitize_text_field( $_POST['copyright_text_color'] ) );

			if ( isset( $_POST['settings']['_wd_logo'] ) && $_POST['settings']['_wd_logo'] != "" ) {
				voip_save_option( 'wd_logo', sanitize_text_field( $_POST['settings']['_wd_logo'] ) );
			}

			if ( isset( $_POST['settings']['_voip_title_bg_image'] ) && $_POST['settings']['_voip_title_bg_image'] != "" ) {
				voip_save_option( 'voip_title_bg_image', esc_attr( $_POST['settings']['_voip_title_bg_image'] ) );
			}

			if ( isset( $_POST['settings']['_wd_bg_404_page'] ) && $_POST['settings']['_wd_bg_404_page'] != "" ) {
				voip_save_option( 'wd_404_page', sanitize_text_field( $_POST['settings']['_wd_bg_404_page'] ) );
			}

			if ( isset( $_POST['settings']['_wd_bg_home_page'] ) && $_POST['settings']['_wd_bg_home_page'] != "" ) {
				voip_save_option( 'wd_home_page', sanitize_text_field( $_POST['settings']['_wd_bg_home_page'] ) );
			}


			if ( ! function_exists( 'has_site_icon' ) ) {
				voip_save_option( 'wd_favicon', sanitize_text_field( $_POST['settings']['_wd_favicon'] ) );
			}

			voip_save_option( 'wd_theme_custom_css', str_replace( "\\", "", $_POST['wd_theme_custom_css'] ) );

			voip_save_option( 'wrapper_bg_color', sanitize_text_field( $_POST['wrapper_bg_color'] ) );
			voip_save_option( 'primary_color', sanitize_text_field( $_POST['primary_color'] ) );
			voip_save_option( 'secondary_color', sanitize_text_field( $_POST['secondary_color'] ) );
			voip_save_option( 'adress_bar_bgcolor', sanitize_text_field( $_POST['adress_bar_bgcolor'] ) );
			voip_save_option( 'adress_bar_color', sanitize_text_field( $_POST['adress_bar_color'] ) );
			voip_save_option( 'social_bar_color', sanitize_text_field( $_POST['social_bar_color'] ) );

			voip_save_option( 'time', htmlentities( stripslashes( $_POST['time'] ) ) );
			voip_save_option( 'copyright_bg', sanitize_text_field( $_POST['copyright_bg'] ) );
			voip_save_option( 'header_bg', sanitize_text_field( $_POST['header_bg'] ) );
			voip_save_option( 'container_bg', sanitize_text_field( $_POST['container_bg'] ) );
			voip_save_option( 'wd_footer_columns', sanitize_text_field( $_POST['wd_footer_columns'] ) );
			voip_save_option( 'navigation_text_color', sanitize_text_field( $_POST['navigation_text_color'] ) );
			voip_save_option( 'navigation_bg_color_sticky', sanitize_text_field( $_POST['navigation_bg_color_sticky'] ) );
			voip_save_option( 'footer_text_color', sanitize_text_field( $_POST['footer_text_color'] ) );

			voip_save_option( 'twitter', sanitize_text_field( $_POST['twitter'] ) );
			voip_save_option( 'facebook', sanitize_text_field( $_POST['facebook'] ) );
			voip_save_option( 'flickr', sanitize_text_field( $_POST['flickr'] ) );
			voip_save_option( 'vimeo', sanitize_text_field( $_POST['vimeo'] ) );


			if ( isset( $_POST['voip_show_wpml_widget'] ) ) {
				voip_save_option( 'voip_show_wpml_widget', sanitize_text_field( $_POST['voip_show_wpml_widget'] ) );
			}

			voip_save_option( 'phone', sanitize_text_field( $_POST['phone'] ) );
			voip_save_option( 'adress', sanitize_text_field( $_POST['adress'] ) );


			voip_save_option( 'wd_body_font_familly', sanitize_text_field( $_POST['wd_body_font_familly'] ) );
			voip_save_option( 'wd_body_font_weight', sanitize_text_field( $_POST['wd_body_font_weight'] ) );
			voip_save_option( 'wd_main-text-font-subsets', sanitize_text_field( $_POST['wd_main-text-font-subsets'] ) );
			voip_save_option( 'wd_main_text_lettre_spacing', sanitize_text_field( $_POST['wd_main_text_lettre_spacing'] ) );

			voip_save_option( 'wd_head_font_familly', sanitize_text_field( $_POST['wd_head_font_familly'] ) );
			voip_save_option( 'wd_heading-font-weight-style', sanitize_text_field( $_POST['wd_heading-font-weight-style'] ) );
			voip_save_option( 'wd_heading-text-font-subsets', sanitize_text_field( $_POST['wd_heading-text-font-subsets'] ) );
			voip_save_option( 'wd_heading_text_lettre_spacing', sanitize_text_field( $_POST['wd_heading_text_lettre_spacing'] ) );

			voip_save_option( 'wd_navigation_font_familly', sanitize_text_field( $_POST['wd_navigation_font_familly'] ) );
			voip_save_option( 'wd_navigation-font-weight-style', sanitize_text_field( $_POST['wd_navigation-font-weight-style'] ) );
			voip_save_option( 'wd_navigation-text-font-subsets', sanitize_text_field( $_POST['wd_navigation-text-font-subsets'] ) );
			voip_save_option( 'wd_navigation_text_lettre_spacing', sanitize_text_field( $_POST['wd_navigation_text_lettre_spacing'] ) );


			voip_save_option( 'voip_google_map_key', sanitize_text_field( $_POST['voip_google_map_key'] ) );
			voip_save_option( 'wd_menu_style', sanitize_text_field( $_POST['wd_menu_style'] ) );
			voip_save_option( 'social_bar_bg_color', sanitize_text_field( $_POST['social_bar_bg_color'] ) );

		} ?>


		<?php if ( ! empty( $_POST ) ): ?>
      <div id="message" class="updated fade">
        <p><?php echo esc_html__( 'Configuration updated!!', 'voip' ); ?>  </p>
      </div>
		<?php endif; ?>


    
    <div class="wd-cpanel" style="display: none;">
      <form id="wd-Panel" method="POST" action="">
        <div id="tabs" class="ui-tabs-vertical ui-helper-clearfix">
          <ul class="ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header" role="tablist">
              <div class="panel-logo">
                <h2>Flooring Theme Options</h2><span> 3.7</span>
              </div>
              <li role="tab" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab ui-tabs-active ui-state-active" aria-controls="GeneralSettings" aria-labelledby="ui-id-1" aria-selected="true" aria-expanded="true">
                <a href="#GeneralSettings" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-1"><?php echo esc_html__( 'General Settings', 'voip' ); ?></a>
              </li>
              <li role="tab" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab" aria-controls="topbar" aria-labelledby="ui-id-2" aria-selected="false" aria-expanded="false">
                <a href="#topbar" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-2"><?php echo esc_html__( 'Top Header Settings', 'voip' ); ?></a>
              </li>

              <li role="tab" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab" aria-controls="ColorsSettings" aria-labelledby="ui-id-4" aria-selected="false" aria-expanded="false">
                <a href="#ColorsSettings" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-4"><?php echo esc_html__( 'Colors Settings', 'voip' ); ?></a>
              </li>

              <li role="tab" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab" aria-controls="FontsSettings" aria-labelledby="ui-id-5" aria-selected="false" aria-expanded="false">
                <a href="#FontsSettings" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-5"><?php echo esc_html__( 'Fonts Settings', 'voip' ); ?></a>
              </li>
              <li role="tab" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab" aria-controls="customcssandjs" aria-labelledby="ui-id-6" aria-selected="false" aria-expanded="false">
                <a href="#customcssandjs" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-6"><?php echo esc_html__( 'Theme Custom Css', 'voip' ); ?></a>
              </li>
              <li role="tab" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab" aria-controls="FooterSettings" aria-labelledby="ui-id-7" aria-selected="false" aria-expanded="false">
                <a href="#FooterSettings" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-7"><?php echo esc_html__( 'Footer settings', 'voip' ); ?> </a>
              </li>
              <li role="tab" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab" aria-controls="importer" aria-labelledby="ui-id-7" aria-selected="false" aria-expanded="false">
                <a href="#importer" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-8"><?php echo esc_html__( 'Import Demos', 'voip' ); ?></a>
              </li>
            </ul>
         

           <!-- Tab GeneralSettings --->
           <div id="GeneralSettings" class="ui-tabs-panel ui-corner-bottom ui-widget-content" aria-labelledby="ui-id-1" role="tabpanel" aria-hidden="false">
            <table class="form-table">
              <tbody>
                <tr>
                  <td>
                    <!-- Tabs title ------>
                    <div class="groups_tabs">
                      <ul class="g_tab">
                        <li data-tab="GeneralSettings_tab" class="current">
                          <h3>General Settings</h3>
                        </li>
                      </ul>
                    </div>
                    <!-- Tabs content ------>
                    <!-- General Settings --->
                    <div id="GeneralSettings_tab" class="tab-content current">
                      <ul class="assets_options">

                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Boxed Layout:', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                          <input type="checkbox" <?php if ( voip_get_option( 'wd_box_wrapper', 'of' ) != 'of' ) {  print 'checked'; } ?> name="wd_box_wrapper" value="on" id="wd_box_wrapper" class="cmn-toggle cmn-toggle-round"/>
                          <label for="wd_box_wrapper"></label>
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Menu style:', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                            <?php $voip_menu_style = voip_get_option( 'wd_menu_style', 'creative' );
                              ?>
                              <select name="wd_menu_style">
                                <option value="corporate" <?php if ( $voip_menu_style == "corporate" ) {
                                  echo "selected";
                                } ?>><?php echo esc_html__( 'Corporate', 'voip' ); ?></option>

                                <option value="creative" <?php if ( $voip_menu_style != "corporate" ) {
                                  echo "selected";
                                } ?>><?php echo esc_html__( 'Creative', 'voip' ); ?></option>
                              </select>
                          </div>
                        </li>
                        <li  class="imgset">
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Default Title Bar background image', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                                <?php $voip_path           = get_template_directory_uri() . "/images/title-bg.jpg";
                                $voip_title_bg_image = voip_get_option( 'voip_title_bg_image', $voip_path );
                                if ( ! empty( $voip_title_bg_image ) ): ?>
                                  <img src="<?php print esc_url( $voip_title_bg_image ); ?>" style="max-height: 70px;"/>
                                <?php endif; ?>
                              <input type="hidden" name="settings[_voip_title_bg_image]" id="voip_title_bg_filed"/>
                              <input class="button add_image" name="_unique_title_bg_button" id="voip_title_bg_btn"  value="<?php echo esc_html__( 'Upload', 'voip' ); ?>"/>
                          </div>
                        </li>
                        <li class="imgset">
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Background image:', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                            <input type="hidden" name="settings[_wd_bg_home_page]" id="wd_home_page_filed" value="<?php echo esc_attr( voip_get_option( 'wd_home_page' ) ) ?>"/>
                            <input class="button add_image" name="bg_home_page" id="wd_bg_home_page" value="<?php echo esc_html__( 'Upload', 'voip' ); ?>"/>
                            <input type="button" value="<?php echo esc_html__( 'Delete', 'voip' ); ?>" class="button" onclick="wd_home_page_filed.value=''"/>
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Show Website Title', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                            <input type="checkbox" <?php if ( voip_get_option( 'wd_show_title' ) != 'of' ) { print 'checked'; } ?> name="wd_show_title" value="on" id="wd_show_title" class="cmn-toggle cmn-toggle-round"/>
                            <label for="wd_show_title"></label>
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Show the menu in the grid', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                              <input type="checkbox" <?php if ( voip_get_option( 'wd_menu_in_grid' ) == 'on' ) {  print 'checked'; } ?> name="wd_menu_in_grid" value="on" id="wd_menu_in_grid" class="cmn-toggle cmn-toggle-round"/>
                              <label for="wd_menu_in_grid"></label>
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Stick the menu to Top', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                            <input type="checkbox" <?php if ( voip_get_option( 'wd_menu_sticky' ) != 'off' ) { print 'checked'; } ?> name="wd_menu_sticky" value="on" id="wd_menu_sticky" class="cmn-toggle cmn-toggle-round"/>
                            <label for="wd_menu_sticky"></label>
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Show The Logo', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                              <input type="checkbox" <?php if ( voip_get_option( 'wd_show_logo' ) == 'on' ) { print 'checked'; } ?> name="wd_show_logo" value="on" id="wd_show_logo"  class="chekbox_logo cmn-toggle cmn-toggle-round"/>
                              <label for="wd_show_logo"></label>
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Show the cart on header', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                            <input type="checkbox" <?php if ( voip_get_option( 'wd_show_cart' ) == 'on' ) { print 'checked'; } ?> name="wd_show_cart" value="on" id="wd_show_cart"  class="chekbox_cart cmn-toggle cmn-toggle-round"/>
                            <label for="wd_show_cart"></label>
                          </div>
                        </li>
                        <li class="imgset">
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Logo link', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                            <?php $voip_logo_path = get_template_directory_uri() . "/images/logogvoip.png";
									                $voip_logo      = voip_get_option( 'wd_logo', $voip_logo_path );
									         
                                    $voip_logo_path = get_template_directory_uri() . "/images/logogvoip.png";
                                   $voip_logo      = voip_get_option( 'wd_logo', $voip_logo_path );
                                  if ( ! empty( $voip_logo ) ): ?> <img src="<?php print esc_url( $voip_logo ); ?>" style="max-height: 70px;"/> <?php endif; 
                              ?>
                            <input type="hidden" name="settings[_wd_logo]" id="wd_logo_filed" value="<?php echo esc_url( esc_attr($voip_logo) ) ?>"/>
                            <input class="button add_image" name="_unique_name_button" id="wd_upload_btn" value="<?php echo esc_html__( 'Upload', 'voip' ); ?>"/>
                 
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Google Maps Key', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                              <?php
                                $voip_google_map_key = voip_get_option( 'voip_google_map_key' );
                                ?>
                                <input type="text" name="voip_google_map_key" id="voip_google_map_key"  value="<?php echo esc_attr( $voip_google_map_key ) ?>"/>
                          </div>
                        </li>

                        <li class="imgset">
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Favicon link', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                          <?php
                              $voip_favicon = voip_get_option( 'wd_favicon' );
                              if ( ! empty( $voip_favicon ) ): ?> <img src="<?php print esc_url( $voip_favicon ); ?>"
                                                                      style="max-height: 30px;"/> <?php endif; ?>
                              <input type="hidden" name="settings[_wd_favicon]" id="wd_favicon_filed"/>
                              <input class="button add_image" name="_unique_name_favicon" id="wd_upload_favicon"  value="<?php echo esc_html__( 'Upload', 'voip' ); ?>"/>
                            
                          </div>
                        </li>
                      </ul>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
           </div>
           
           

          <div id="ColorsSettings" class="ui-tabs-panel ui-corner-bottom ui-widget-content" aria-labelledby="ui-id-3" role="tabpanel" aria-hidden="false">
            <table class="form-table">
              <tbody>
                <tr>
                  <td>
                    <!-- Tabs title ------>
                    <div class="groups_tabs">
                      <ul class="g_tab">
                        <li data-tab="GeneralSettings_tab" class="current">
                          <h3>General Settings</h3>
                        </li>
                      </ul>
                    </div>
                    <!-- Tabs content ------>
                    <!-- General Settings --->
                    <div id="GeneralSettings_tab" class="tab-content current">
                      <ul class="assets_options">
                      <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Background Color:', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                            <?php $wrapper_bg_color = voip_get_option( 'wrapper_bg_color' ); ?>
                                <input name="wrapper_bg_color" type="text" value="<?php print esc_attr( $wrapper_bg_color ); ?>" class="wd-color-picker" data-default-color="#C0392B">
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Primary Color:', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                          <?php $primary_color = voip_get_option( 'primary_color', '#106EAA' ); ?>
                          <input name="primary_color" type="text" value="<?php print esc_attr( $primary_color ); ?>" class="wd-color-picker" data-default-color="#106EAA">
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Secondary color:', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                          <?php $secondary_color = voip_get_option( 'secondary_color' ); ?>
                            <input name="secondary_color" type="text" value="<?php print esc_attr( $secondary_color ); ?>"  class="wd-color-picker" data-default-color="#C0392B">
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Address Bar Background color:', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                          <?php $adress_bar_bgcolor = voip_get_option( 'adress_bar_bgcolor' ); ?>
                              <input name="adress_bar_bgcolor" type="text" value="<?php print esc_attr( $adress_bar_bgcolor ); ?>" class="wd-color-picker" data-default-color="#C0392B">
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Address Bar color:', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                          <?php $adress_bar_color = voip_get_option( 'adress_bar_color' ); ?>
                              <input name="adress_bar_color" type="text" value="<?php print esc_attr( $adress_bar_color ); ?>"  class="wd-color-picker" data-default-color="#C0392B">
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Container background color :', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                            <?php $container_bg = voip_get_option( 'container_bg' ); ?>
                            <input name="container_bg" type="text" value="<?php print esc_attr( $container_bg ); ?>"  class="wd-color-picker" data-default-color="#C0392B">
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Header background color :', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                                <?php $header_bg = voip_get_option( 'header_bg' ); ?>
                                <input name="header_bg" type="text" value="<?php print esc_attr( $header_bg ); ?>"  class="wd-color-picker" data-default-color="#C0392B">
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Navigation Text Color', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                              <?php $navigation_text_color = voip_get_option( 'navigation_text_color', '#fff' ); ?>
                              <input name="navigation_text_color" type="text" value="<?php print esc_attr( $navigation_text_color ); ?>" class="wd-color-picker" data-default-color="#ffffff">
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Navigation (sticky) background color', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                          <?php $navigation_bg_color_sticky = voip_get_option( 'navigation_bg_color_sticky' ); ?>
                              <input name="navigation_bg_color_sticky" type="text" value="<?php print esc_attr( $navigation_bg_color_sticky ); ?>" class="wd-color-picker" data-default-color="#C0392B">
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Footer background color', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                             <?php $footer_bg_color = voip_get_option( 'footer_bg_color' ); ?>
                             <input name="footer_bg_color" type="text" value="<?php print esc_attr( $footer_bg_color ); ?>" class="wd-color-picker" data-default-color="#C0392B">
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Footer text color', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                          <?php $footer_text_color = voip_get_option( 'footer_text_color' ); ?>
                            <input name="footer_text_color" type="text" value="<?php print esc_attr( $footer_text_color ); ?>"  class="wd-color-picker" data-default-color="#C0392B">
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Copyright background color :', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                          <?php $copyright_bg = voip_get_option( 'copyright_bg' ); ?>
                            <input name="copyright_bg" type="text" value="<?php print esc_attr( $copyright_bg ); ?>"  class="wd-color-picker" data-default-color="#C0392B">
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Copyright bar text color', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                              <?php $copyright_text_color = voip_get_option( 'copyright_text_color' ); ?>
                              <input name="copyright_text_color" type="text" value="<?php print esc_attr( $copyright_text_color ); ?>" class="wd-color-picker" data-default-color="#C0392B">
                          </div>
                        </li>
                      </ul>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          
                        <!-- TopBar --->
          <div id="topbar" class="ui-tabs-panel ui-corner-bottom ui-widget-content" aria-labelledby="ui-id-2" role="tabpanel" aria-hidden="false">
            <table class="form-table">
              <tbody>
                <tr>
                  <td>
                    <!-- Tabs title ------>
                    <div class="groups_tabs">
                      <ul class="g_tab">
                        <li data-tab="socialSettings_tab" class="current">
                          <h3>General Settings</h3>
                        </li>
                      </ul>
                    </div>
                    <!-- Tabs content ------>
                    <!-- General Settings --->
                    <div id="socialSettings_tab" class="tab-content current">
                      <ul class="assets_options">
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Show Top bare', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                              <input type="checkbox" <?php if ( voip_get_option( 'wd_show_top_social_bare' ) == 'on' ) { print 'checked'; } ?> name="wd_show_top_social_bare" value="on" id="wd_show_top_social_bare"  class="checkbox_social cmn-toggle cmn-toggle-round"/>
                              <label for="wd_show_top_social_bare"></label>
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Social bar color:', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                            <?php $social_bar_color = voip_get_option( 'social_bar_color' ); ?>
                            <input name="social_bar_color" type="text" value="<?php print esc_attr( $social_bar_color ); ?>" class="wd-color-picker" data-default-color="#C0392B">
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Social bar Background Color:', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                            <?php $social_bar_bg_color = voip_get_option( 'social_bar_bg_color' ); ?>
                            <input name="social_bar_bg_color" type="text" value="<?php print esc_attr( $social_bar_bg_color ); ?>" class="wd-color-picker" data-default-color="#C0392B">
                          </div>
                        </li>
                        <?php if ( do_action( 'icl_language_selector' ) ) { ?>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Show WPML Widget', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                            <input type="checkbox" <?php if ( voip_get_option( 'voip_show_wpml_widget', 'on' ) == 'on' ) { print 'checked'; } ?>  name="voip_show_wpml_widget" value="on" id="voip_show_wpml_widget"  class="cmn-toggle cmn-toggle-round"/>
                            <label for="voip_show_wpml_widget"></label>
                          </div>
                        </li>
                        <?php } ?>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Twitter', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                          <input type="text" name="twitter"  placeholder="<?php echo esc_html__( 'Your twitter profile link', 'voip' ) ?>"  value="<?php echo esc_attr( voip_get_option( 'twitter' ) ); ?>">
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Facebook', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                          <input type="text" name="facebook" placeholder="<?php echo esc_html__( 'Your Facebook page link', 'voip' ) ?>" value="<?php echo esc_attr( voip_get_option( 'facebook' ) ); ?>">
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Flickr', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                            <input type="text" name="flickr" placeholder="<?php echo esc_html__( 'Your Flickr page link', 'voip' ) ?>" value="<?php echo esc_attr( voip_get_option( 'flickr' ) ); ?>">
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'vimeo', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                            <input type="text" name="vimeo" placeholder="<?php echo esc_html__( 'Your vimeo link', 'voip' ) ?>" value="<?php echo esc_attr( voip_get_option( 'vimeo' ) ); ?>">
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Phone', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                          <input type="text" name="phone"  placeholder="<?php echo esc_html__( 'Your Phone number', 'voip' ) ?>" value="<?php echo esc_attr( voip_get_option( 'phone' ) ); ?>">
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Address', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                            <input type="text" name="adress" placeholder="<?php echo esc_html__( 'Your Address', 'voip' ) ?>" value="<?php echo esc_attr( voip_get_option( 'adress' ) ); ?>">
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Tiems', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                            <input type="text" name="time" placeholder="<?php echo esc_html__( 'Your time', 'voip' ) ?>" value="<?php echo html_entity_decode( voip_get_option( 'time', '' ) ); ?>">
                          </div>
                        </li>
                      </ul>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          


         <!-- Tab FontsSettings --->
          <div id="FontsSettings" class="ui-tabs-panel ui-corner-bottom ui-widget-content" aria-labelledby="ui-id-5" role="tabpanel" aria-hidden="false">
            <table class="form-table">
              <tbody>
                <tr>
                  <td>
                    <!-- Tabs title ------>
                    <div class="groups_tabs">
                      <ul class="g_tab">
                        <li data-tab="mainfont_tab" class="current">
                          <h3>Main text font</h3>
                        </li>
                        <li data-tab="headerfont_tab" class="">
                          <h3>Header text font</h3>
                        </li>
                        <li data-tab="navfont_tab" class="">
                          <h3>nav text font</h3>
                        </li>

                      </ul>

                      <!-- Tabs content ------>
                      <!-- General Settings --->
                      <div id="mainfont_tab" class="tab-content current">
                          <?php $voip_body_font_familly = voip_get_option( 'wd_body_font_familly' );
                              $voip_fontArray               = array(
                                'Abel',
                                'Abril Fatface',
                                'Aclonica',
                                'Actor',
                                'Adamina',
                                'Aguafina Script',
                                'Aladin',
                                'Aldrich',
                                'Alice',
                                'Alike Angular',
                                'Alike',
                                'Allan',
                                'Allerta Stencil',
                                'Allerta',
                                'Amaranth',
                                'Amatic SC',
                                'Andada',
                                'Andika',
                                'Annie Use Your Telescope',
                                'Anonymous Pro',
                                'Antic',
                                'Anton',
                                'Arapey',
                                'Architects Daughter',
                                'Arimo',
                                'Artifika',
                                'Arvo',
                                'Asset',
                                'Astloch',
                                'Atomic Age',
                                'Aubrey',
                                'Bangers',
                                'Bentham',
                                'Bevan',
                                'Bigshot One',
                                'Bitter',
                                'Black Ops One',
                                'Bowlby One SC',
                                'Bowlby One',
                                'Brawler',
                                'Bubblegum Sans',
                                'Buda',
                                'Butcherman Caps',
                                'Cabin Condensed',
                                'Cabin Sketch',
                                'Cabin',
                                'Cagliostro',
                                'Calligraffitti',
                                'Candal',
                                'Cantarell',
                                'Cardo',
                                'Carme',
                                'Carter One',
                                'Caudex',
                                'Cedarville Cursive',
                                'Changa One',
                                'Cherry Cream Soda',
                                'Chewy',
                                'Chicle',
                                'Chivo',
                                'Coda Caption',
                                'Coda',
                                'Comfortaa',
                                'Coming Soon',
                                'Contrail One',
                                'Convergence',
                                'Cookie',
                                'Copse',
                                'Corben',
                                'Cousine',
                                'Coustard',
                                'Covered By Your Grace',
                                'Crafty Girls',
                                'Creepster Caps',
                                'Crimson Text',
                                'Crushed',
                                'Cuprum',
                                'Damion',
                                'Dancing Script',
                                'Dawning of a New Day',
                                'Days One',
                                'Delius Swash Caps',
                                'Delius Unicase',
                                'Delius',
                                'Devonshire',
                                'Didact Gothic',
                                'Dorsa',
                                'Dr Sugiyama',
                                'Droid Sans Mono',
                                'Droid Sans',
                                'Droid Serif',
                                'EB Garamond',
                                'Eater Caps',
                                'Expletus Sans',
                                'Fanwood Text',
                                'Federant',
                                'Federo',
                                'Fjord One',
                                'Fondamento',
                                'Fontdiner Swanky',
                                'Forum',
                                'Francois One',
                                'Gentium Basic',
                                'Gentium Book Basic',
                                'Geo',
                                'Geostar Fill',
                                'Geostar',
                                'Give You Glory',
                                'Gloria Hallelujah',
                                'Goblin One',
                                'Gochi Hand',
                                'Goudy Bookletter 1911',
                                'Gravitas One',
                                'Gruppo',
                                'Hammersmith One',
                                'Herr Von Muellerhoff',
                                'Holtwood One SC',
                                'Hind Vadodara',
                                'Homemade Apple',
                                'IM Fell DW Pica SC',
                                'IM Fell DW Pica',
                                'IM Fell Double Pica SC',
                                'IM Fell Double Pica',
                                'IM Fell English SC',
                                'IM Fell English',
                                'IM Fell French Canon SC',
                                'IM Fell French Canon',
                                'IM Fell Great Primer SC',
                                'IM Fell Great Primer',
                                'Iceland',
                                'Inconsolata',
                                'Indie Flower',
                                'Irish Grover',
                                'Istok Web',
                                'Jockey One',
                                'Josefin Sans',
                                'Josefin Slab',
                                'Judson',
                                'Julee',
                                'Jura',
                                'Just Another Hand',
                                'Just Me Again Down Here',
                                'Kameron',
                                'Kelly Slab',
                                'Kenia',
                                'Knewave',
                                'Kranky',
                                'Kreon',
                                'Kristi',
                                'La Belle Aurore',
                                'Lancelot',
                                'Lato',
                                'League Script',
                                'Leckerli One',
                                'Lekton',
                                'Lemon',
                                'Limelight',
                                'Linden Hill',
                                'Lobster Two',
                                'Lobster',
                                'Lora',
                                'Love Ya Like A Sister',
                                'Loved by the King',
                                'Luckiest Guy',
                                'Maiden Orange',
                                'Mako',
                                'Marck Script',
                                'Marvel',
                                'Mate SC',
                                'Mate',
                                'Maven Pro',
                                'Meddon',
                                'MedievalSharp',
                                'Megrim',
                                'Merienda One',
                                'Merriweather',
                                'Metrophobic',
                                'Michroma',
                                'Miltonian Tattoo',
                                'Miltonian',
                                'Miss Fajardose',
                                'Miss Saint Delafield',
                                'Modern Antiqua',
                                'Molengo',
                                'Monofett',
                                'Monoton',
                                'Monsieur La Doulaise',
                                'Montez',
                                'Mountains of Christmas',
                                'Montserrat',
                                'Mr Bedford',
                                'Mr Dafoe',
                                'Mr De Haviland',
                                'Mrs Sheppards',
                                'Muli',
                                'Neucha',
                                'Neuton',
                                'News Cycle',
                                'Niconne',
                                'Nixie One',
                                'Nobile',
                                'Nosifer Caps',
                                'Nothing You Could Do',
                                'Nova Cut',
                                'Nova Flat',
                                'Nova Mono',
                                'Nova Oval',
                                'Nova Round',
                                'Nova Script',
                                'Nova Slim',
                                'Nova Square',
                                'Numans',
                                'Nunito',
                                'Old Standard TT',
                                'Open Sans Condensed',
                                'Open Sans',
                                'Orbitron',
                                'Oswald',
                                'Over the Rainbow',
                                'Ovo',
                                'PT Sans Caption',
                                'PT Sans Narrow',
                                'PT Sans',
                                'PT Serif Caption',
                                'PT Serif',
                                'Pacifico',
                                'Passero One',
                                'Patrick Hand',
                                'Paytone One',
                                'Permanent Marker',
                                'Petrona',
                                'Philosopher',
                                'Piedra',
                                'Pinyon Script',
                                'Play',
                                'Playfair Display',
                                'Podkova',
                                'Poller One',
                                'Poly',
                                'Pompiere',
                                'Poppins',
                                'Prata',
                                'Prociono',
                                'Puritan',
                                'Quattrocento Sans',
                                'Quattrocento',
                                'Questrial',
                                'Quicksand',
                                'Radley',
                                'Raleway',
                                'Rammetto One',
                                'Rancho',
                                'Rationale',
                                'Redressed',
                                'Reenie Beanie',
                                'Ribeye Marrow',
                                'Ribeye',
                                'Righteous',
                                'Rochester',
                                'Rock Salt',
                                'Rokkitt',
                                'Rosario',
                                'Ruslan Display',
                                'Salsa',
                                'Sancreek',
                                'Sansita One',
                                'Satisfy',
                                'Schoolbell',
                                'Shadows Into Light',
                                'Shanti',
                                'Short Stack',
                                'Sigmar One',
                                'Signika Negative',
                                'Signika',
                                'Six Caps',
                                'Slackey',
                                'Smokum',
                                'Smythe',
                                'Sniglet',
                                'Snippet',
                                'Sorts Mill Goudy',
                                'Source Sans Pro',
                                'Special Elite',
                                'Spinnaker',
                                'Spirax',
                                'Stardos Stencil',
                                'Sue Ellen Francisco',
                                'Sunshiney',
                                'Supermercado One',
                                'Swanky and Moo Moo',
                                'Syncopate',
                                'Tangerine',
                                'Tenor Sans',
                                'Terminal Dosis',
                                'The Girl Next Door',
                                'Tienne',
                                'Tinos',
                                'Tulpen One',
                                'Ubuntu Condensed',
                                'Ubuntu Mono',
                                'Ubuntu',
                                'Ultra',
                                'UnifrakturCook',
                                'UnifrakturMaguntia',
                                'Unkempt',
                                'Unlock',
                                'Unna',
                                'VT323',
                                'Varela Round',
                                'Varela',
                                'Vast Shadow',
                                'Vibur',
                                'Vidaloka',
                                'Volkhov',
                                'Vollkorn',
                                'Voltaire',
                                'Waiting for the Sunrise',
                                'Wallpoet',
                                'Walter Turncoat',
                                'Wire One',
                                'Yanone Kaffeesatz',
                                'Yellowtail',
                                'Yeseva One',
                                'Zeyada'
                              );
                              ?>
                        <ul class="assets_options">
                        
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Font family', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                              <select name="wd_body_font_familly" id="wd_body_font_familly" class="font_familly">
                              <option value="default">Default</option>
                              <?php foreach ( $voip_fontArray as $pititablo ) {
                                $font_name = $pititablo;
                                ?>
                                <option
                                  value="<?php echo esc_attr( $pititablo ) ?>" <?php if ( voip_get_option( 'wd_body_font_familly' ) == $font_name )
                                  echo "selected='selected'" ?> ><?php echo esc_attr( $pititablo ) ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Font weight and style', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                          <select name="wd_body_font_weight" id="wd_body_font_weight" class="font_weight">
                          <option value="400" <?php if ( voip_get_option( 'wd_body_font_weight' ) == 400 ) {
														echo 'selected';
													} ?>><?php echo esc_html__( 'Normal 400', 'voip' ); ?></option>
                          <option value="300" <?php if ( voip_get_option( 'wd_body_font_weight' ) == 300 ) {
														echo 'selected';
													} ?>><?php echo esc_html__( 'Light 300', 'voip' ); ?></option>
                          <option value="600" <?php if ( voip_get_option( 'wd_body_font_weight' ) == 600 ) {
														echo 'selected';
													} ?>><?php echo esc_html__( 'Semi-bold 600', 'voip' ); ?></option>
                          <option value="700" <?php if ( voip_get_option( 'wd_body_font_weight' ) == 700 ) {
														echo 'selected';
													} ?>><?php echo esc_html__( 'Bold 700', 'voip' ); ?></option>
                          <option value="800" <?php if ( voip_get_option( 'wd_body_font_weight' ) == 800 ) {
														echo 'selected';
													} ?>><?php echo esc_html__( 'Extra-Bold 800', 'voip' ); ?></option>
                        </select>
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Lettre Spacing', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                          <?php
                              $voip_main_text_lettre_spacing = voip_get_option( 'wd_main_text_lettre_spacing' );
                              $voip_main_text_lettre_spacing = ( ! empty( $voip_main_text_lettre_spacing ) ) ? voip_get_option( 'wd_main_text_lettre_spacing' ) : ''; ?>
                              <input type="text" class="wd_txt_big" name="wd_main_text_lettre_spacing" placeholder="<?php echo esc_html__( 'example 1px', 'voip' ) ?>" value="<?php echo esc_attr( $voip_main_text_lettre_spacing ); ?>">
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Font subsets', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                          <select id="wd_main-text-font-subsets" name="wd_main-text-font-subsets" class="font_subsets">
                          <option value="latin"<?php if ( voip_get_option( 'wd_main-text-font-subsets' ) == 'latin' ) {
														echo "selected";
													} ?>><?php echo esc_html__( 'Latin', 'voip' ); ?></option>
                          <option
                            value="cyrillic-ext"<?php if ( voip_get_option( 'wd_main-text-font-subsets' ) == 'cyrillic-ext' ) {
														echo "selected";
													} ?>><?php echo esc_html__( 'Cyrillic Extended', 'voip' ); ?></option>
                          <option
                            value="greek-ext"<?php if ( voip_get_option( 'wd_main-text-font-subsets' ) == 'greek-ext' ) {
														echo "selected";
													} ?>><?php echo esc_html__( 'Greek Extended', 'voip' ); ?></option>
                          <option value="greek"<?php if ( voip_get_option( 'wd_main-text-font-subsets' ) == 'greek' ) {
														echo "selected";
													} ?>><?php echo esc_html__( 'Greek', 'voip' ); ?></option>
                          <option
                            value="vietnamese"<?php if ( voip_get_option( 'wd_main-text-font-subsets' ) == 'vietnamese' ) {
														echo "selected";
													} ?>><?php echo esc_html__( 'Vietnamese', 'voip' ); ?></option>
                          <option
                            value="latin-ext"<?php if ( voip_get_option( 'wd_main-text-font-subsets' ) == 'latin-ext' ) {
														echo "selected";
													} ?>><?php echo esc_html__( 'Latin Extended', 'voip' ); ?></option>
                          <option
                            value="cyrillic"<?php if ( voip_get_option( 'wd_main-text-font-subsets' ) == 'cyrillic' ) {
														echo "selected";
													} ?>><?php echo esc_html__( 'Cyrillic', 'voip' ); ?></option>
                        </select>
                        <p class="body_font_result"
                           style="font-family: '<?php echo esc_html( voip_get_option( 'wd_body_font_familly' ) ); ?>'; font-weight: <?php echo esc_html( voip_get_option( 'wd_body_font_weight' ) ); ?>;">
                          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
													<?php echo esc_html__( 'tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'voip' ); ?></p>
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                          
                          </div>
                        </li>
                        <li>
                          <div class="title-option">
                            <label></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                          
                          </div>
                        </li>
                        </ul>
                      </div>


                      <div id="headerfont_tab" class="tab-content">
                        <ul class="assets_options">
                          <li>
                              <div class="title-option">
                                <label><?php echo esc_html__('Font family', 'flooring'); ?></label>
                                <p></p>
                              </div>
                              <div class="value-option">
                                <select name="wd_head_font_familly" id="wd_head_font_familly" class="font_familly">
                                  <option value="default">Default</option>
                                  <?php
                                  $voip_head_font_familly = voip_get_option( 'wd_head_font_familly' );
                                  foreach ( $voip_fontArray as $pititablo ) {
                                    $font_name = $pititablo; ?>

                                    <option
                                      value="<?php echo esc_attr( $font_name ) ?>" <?php if ( voip_get_option( 'wd_head_font_familly' ) == $font_name )
                                      echo "selected='selected'" ?> ><?php echo esc_attr( $font_name ) ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                          </li>
                          <li>
                              <div class="title-option">
                                <label><?php echo esc_html__( 'Font weight and style', 'voip' ); ?></label>
                                <p></p>
                              </div>
                              <div class="value-option">
                                      <select name="wd_heading-font-weight-style" id="wd_heading-font-weight-style"
                                        class="font_weight">
                                  <option value="400" <?php if ( voip_get_option( 'wd_heading-font-weight-style' ) == 400 ) {
                                    echo 'selected';
                                  } ?>><?php echo esc_html__( 'Normal 400', 'voip' ); ?></option>
                                  <option value="300" <?php if ( voip_get_option( 'wd_heading-font-weight-style' ) == 300 ) {
                                    echo 'selected';
                                  } ?>><?php echo esc_html__( 'Light 300', 'voip' ); ?></option>
                                  <option value="600" <?php if ( voip_get_option( 'wd_heading-font-weight-style' ) == 600 ) {
                                    echo 'selected';
                                  } ?>><?php echo esc_html__( 'Semi-bold 600', 'voip' ); ?></option>
                                  <option value="700" <?php if ( voip_get_option( 'wd_heading-font-weight-style' ) == 700 ) {
                                    echo 'selected';
                                  } ?>><?php echo esc_html__( 'Bold 700', 'voip' ); ?></option>
                                  <option value="800" <?php if ( voip_get_option( 'wd_heading-font-weight-style' ) == 800 ) {
                                    echo 'selected';
                                  } ?>><?php echo esc_html__( 'Extra-Bold 800', 'voip' ); ?></option>
                                </select>
                              </div>
                          </li>
                          <li>
                              <div class="title-option">
                                <label><?php echo esc_html__( 'Lettre Spacing', 'voip' ); ?></label>
                                <p></p>
                              </div>
                              <div class="value-option">
                                  <?php
                                    $voip_heading_text_lettre_spacing = voip_get_option( 'wd_heading_text_lettre_spacing' );
                                    $voip_heading_text_lettre_spacing = ( ! empty( $voip_heading_text_lettre_spacing ) ) ? voip_get_option( 'wd_heading_text_lettre_spacing' ) : ''; ?>
                                    <input type="text" class="wd_txt_big" name="wd_heading_text_lettre_spacing"
                                          placeholder="<?php echo esc_html__( 'example 1px', 'voip' ) ?>"
                                          value="<?php echo esc_attr( $voip_heading_text_lettre_spacing ); ?>">
                              </div>
                          </li>
                          <li>
                              <div class="title-option">
                                <label><?php echo esc_html__( 'Font subsets', 'voip' ); ?></label>
                                <p></p>
                              </div>
                              <div class="value-option">
                                    <select id="wd_heading-text-font-subsets" name="wd_heading-text-font-subsets"
                                      class="font_subsets">
                                <option
                                  value="latin"<?php if ( voip_get_option( 'wd_heading-text-font-subsets' ) == 'latin' ) {
                                  echo "selected";
                                } ?>><?php echo esc_html__( 'Latin', 'voip' ); ?></option>
                                <option
                                  value="cyrillic-ext"<?php if ( voip_get_option( 'wd_heading-text-font-subsets' ) == 'cyrillic-ext' ) {
                                  echo "selected";
                                } ?>><?php echo esc_html__( 'Cyrillic Extended', 'voip' ); ?></option>
                                <option
                                  value="greek-ext"<?php if ( voip_get_option( 'wd_heading-text-font-subsets' ) == 'greek-ext' ) {
                                  echo "selected";
                                } ?>><?php echo esc_html__( 'Greek Extended', 'voip' ); ?></option>
                                <option
                                  value="greek"<?php if ( voip_get_option( 'wd_heading-text-font-subsets' ) == 'greek' ) {
                                  echo "selected";
                                } ?>><?php echo esc_html__( 'Greek', 'voip' ); ?></option>
                                <option
                                  value="vietnamese"<?php if ( voip_get_option( 'wd_heading-text-font-subsets' ) == 'vietnamese' ) {
                                  echo "selected";
                                } ?>><?php echo esc_html__( 'Vietnamese', 'voip' ); ?></option>
                                <option
                                  value="latin-ext"<?php if ( voip_get_option( 'wd_heading-text-font-subsets' ) == 'latin-ext' ) {
                                  echo "selected";
                                } ?>><?php echo esc_html__( 'Latin Extended', 'voip' ); ?></option>
                                <option
                                  value="cyrillic"<?php if ( voip_get_option( 'wd_heading-text-font-subsets' ) == 'cyrillic' ) {
                                  echo "selected";
                                } ?>><?php echo esc_html__( 'Cyrillic', 'voip' ); ?></option>
                              </select>
                              </div>
                          </li>
                        </ul>
                      </div>

                      <!-- General Settings --->
                      <div id="navfont_tab" class="tab-content">
                        <ul class="assets_options">
                          <li>
                            <div class="title-option">
                              <label><?php echo esc_html__('Font family', 'flooring'); ?></label>
                              <p></p>
                            </div>
                            <div class="value-option">
                                  <select name="wd_navigation_font_familly" id="wd_navigation_font_familly" class="font_familly">
                                <option value="default"><?php echo esc_html__( 'Default', 'voip' ); ?></option>
                                <?php
                                $voip_navigation_font_familly = voip_get_option( 'wd_navigation_font_familly' );
                                foreach ( $voip_fontArray as $pititablo ) {
                                  $font_name = $pititablo; ?>

                                  <option
                                    value="<?php echo esc_attr( $font_name ) ?>" <?php if ( voip_get_option( 'wd_navigation_font_familly' ) == $font_name )
                                    echo "selected='selected'" ?> ><?php echo esc_attr( $font_name ) ?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </li>
                          <li>
                            <div class="title-option">
                              <label><?php echo esc_html__( 'Font weight and style', 'voip' ); ?></label>
                              <p></p>
                            </div>
                            <div class="value-option">
                                <select name="wd_navigation-font-weight-style" id="wd_navigation-font-weight-style"
                                    class="font_weight">
                              <option value="400" <?php if ( voip_get_option( 'wd_navigation-font-weight-style' ) == 400 ) {
                                echo 'selected';
                              } ?>><?php echo esc_html__( 'Normal 400', 'voip' ); ?></option>
                              <option value="300" <?php if ( voip_get_option( 'wd_navigation-font-weight-style' ) == 300 ) {
                                echo 'selected';
                              } ?>><?php echo esc_html__( 'Light 300', 'voip' ); ?></option>
                              <option value="600" <?php if ( voip_get_option( 'wd_navigation-font-weight-style' ) == 600 ) {
                                echo 'selected';
                              } ?>><?php echo esc_html__( 'Semi-bold 600', 'voip' ); ?></option>
                              <option value="700" <?php if ( voip_get_option( 'wd_navigation-font-weight-style' ) == 700 ) {
                                echo 'selected';
                              } ?>><?php echo esc_html__( 'Bold 700', 'voip' ); ?></option>
                              <option value="800" <?php if ( voip_get_option( 'wd_navigation-font-weight-style' ) == 800 ) {
                                echo 'selected';
                              } ?>><?php echo esc_html__( 'Extra-Bold 800', 'voip' ); ?></option>
                            </select>
                            </div>
                          </li>
                          <li>
                            <div class="title-option">
                              <label><?php echo esc_html__( 'Lettre Spacing', 'voip' ); ?></label>
                              <p></p>
                            </div>
                            <div class="value-option">
                              <?php
                                $voip_navigation_text_lettre_spacing = voip_get_option( 'wd_navigation_text_lettre_spacing' );
                                $voip_navigation_text_lettre_spacing = ( ! empty( $voip_navigation_text_lettre_spacing ) ) ? voip_get_option( 'wd_navigation_text_lettre_spacing' ) : ''; ?>
                                <input type="text" class="wd_txt_big" name="wd_navigation_text_lettre_spacing"
                                      placeholder="<?php echo esc_html__( 'example 1px', 'voip' ) ?>"
                                      value="<?php echo esc_attr( $voip_navigation_text_lettre_spacing ); ?>">
                            </div>
                          </li>
                          <li>
                            <div class="title-option">
                              <label><?php echo esc_html__( 'Font subsets', 'voip' ); ?></label>
                              <p></p>
                            </div>
                            <div class="value-option">
                            <select id="wd_navigation-text-font-subsets" name="wd_navigation-text-font-subsets"
                                class="font_subsets">
                          <option
                            value="latin"<?php if ( voip_get_option( 'wd_navigation-text-font-subsets' ) == 'latin' ) {
														echo "selected";
													} ?>><?php echo esc_html__( 'Latin', 'voip' ); ?></option>
                          <option
                            value="cyrillic-ext"<?php if ( voip_get_option( 'wd_navigation-text-font-subsets' ) == 'cyrillic-ext' ) {
														echo "selected";
													} ?>><?php echo esc_html__( 'Cyrillic Extended', 'voip' ); ?></option>
                          <option
                            value="greek-ext"<?php if ( voip_get_option( 'wd_navigation-text-font-subsets' ) == 'greek-ext' ) {
														echo "selected";
													} ?>><?php echo esc_html__( 'Greek Extended', 'voip' ); ?></option>
                          <option
                            value="greek"<?php if ( voip_get_option( 'wd_navigation-text-font-subsets' ) == 'greek' ) {
														echo "selected";
													} ?>><?php echo esc_html__( 'Greek', 'voip' ); ?></option>
                          <option
                            value="vietnamese"<?php if ( voip_get_option( 'wd_navigation-text-font-subsets' ) == 'vietnamese' ) {
														echo "selected";
													} ?>><?php echo esc_html__( 'Vietnamese', 'voip' ); ?></option>
                          <option
                            value="latin-ext"<?php if ( voip_get_option( 'wd_navigation-text-font-subsets' ) == 'latin-ext' ) {
														echo "selected";
													} ?>><?php echo esc_html__( 'Latin Extended', 'voip' ); ?></option>
                          <option
                            value="cyrillic"<?php if ( voip_get_option( 'wd_navigation-text-font-subsets' ) == 'cyrillic' ) {
														echo "selected";
													} ?>><?php echo esc_html__( 'Cyrillic', 'voip' ); ?></option>
                        </select>
                            </div>
                          </li>
                          <li>
                            <div class="title-option">
                              <label></label>
                              <p></p>
                            </div>
                            <div class="value-option">
                                  
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          
          <!-- Tab footerSettings --->
          <div id="FooterSettings" class="ui-tabs-panel ui-corner-bottom ui-widget-content" aria-labelledby="ui-id-1" role="tabpanel" aria-hidden="false">
            <table class="form-table">
              <tbody>
                <tr>
                  <td>
                    <!-- Tabs title ------>
                    <div class="groups_tabs">
                      <ul class="g_tab">
                        <li data-tab="GeneralSettings_tab" class="current">
                          <h3>General Settings</h3>
                        </li>
                      </ul>
                    </div>
                    <!-- Tabs content ------>
                    <!-- General Settings --->
                    <div id="GeneralSettings_tab" class="tab-content current">
                      <ul class="assets_options">
                      <li class="imgset">
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Background image', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                          <input type="hidden" name="settings[_wd_bg_404_page]" id="wd_404_page_filed"  value="<?php echo esc_attr( voip_get_option( 'wd_404_page' ) ) ?>"/>
                              <input class="button add_image" name="bg_404_page" id="wd_bg_404_page" value="Upload"/>
                          </div>
                      </li>
                      <li class="voip_footer_columns">
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Footer columns', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                          <?php $logo_position = voip_get_option( 'wd_footer_columns', 'three_columns' ) ?>
                            <input id="voip_footer1" type="radio" name="wd_footer_columns" value="one_columns" <?php if ( $logo_position == 'one_columns' ) { echo 'checked'; } ?> />

                            <label for="voip_footer1" class="voip_footer1 <?php if ( $logo_position == 'one_columns' ) { echo 'label_selected '; } ?>"></label>

                            <input id="voip_footer2" type="radio" name="wd_footer_columns"  value="tow_a_columns" <?php if ( $logo_position == 'tow_a_columns' ) { echo 'checked'; } ?> />
                            <label for="voip_footer2" class="voip_footer2 <?php if ( $logo_position == 'tow_a_columns' ) { echo 'label_selected '; } ?>"></label>

                            <input id="voip_footer3" type="radio" name="wd_footer_columns" value="tow_b_columns" <?php if ( $logo_position == 'tow_b_columns' ) { echo 'checked'; } ?> />
                            <label for="voip_footer3" class="voip_footer3 <?php if ( $logo_position == 'tow_b_columns' ) { echo 'label_selected '; } ?>"></label>

                            <input id="voip_footer4" type="radio" name="wd_footer_columns"  value="tow_c_columns" <?php if ( $logo_position == 'tow_c_columns' ) { echo 'checked'; 	} ?> />
                            <label for="voip_footer4" class="voip_footer4 <?php if ( $logo_position == 'tow_c_columns' ) { echo 'label_selected '; } ?>"></label>

                            <input id="voip_footer5" type="radio" name="wd_footer_columns"  value="three_columns" <?php if ( $logo_position == 'three_columns' ) { echo 'checked'; } ?> />
                            <label for="voip_footer5" class="voip_footer5 <?php if ( $logo_position == 'three_columns' ) { 	echo 'label_selected '; } ?>"></label>

                            <input id="voip_footer6" type="radio" name="wd_footer_columns"  value="four_columns" <?php if ( $logo_position == 'four_columns' ) { echo 'checked'; } ?> />
                            <label for="voip_footer6" class="voip_footer6 <?php if ( $logo_position == 'four_columns' ) { echo 'label_selected '; } ?>"></label>

                          </div>
                      </li>
                      <li class="imgset">
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Footer background image', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                            <?php $voip_footer_bg_image = voip_get_option( 'wd_footer_bg_image' );

									            if ( ! empty( $voip_footer_bg_image ) and ( $voip_footer_bg_image != ' ' ) ): ?> <img  src="<?php print esc_attr( $voip_footer_bg_image ); ?>" style="max-height: 70px;"/> <?php endif; ?>
                            <input type="hidden" name="settings[_wd_footer_bg_image]" id="wd_footer_bg_filed"/>
                            <input class="button add_image" name="_unique_footer_bg_button" id="wd_footer_bg_btn" value="Upload"/></br>
                            <input type="button" value="Delete" class="button" onclick="wd_footer_bg_filed.value=' '"/>
                          </div>
                      </li>
                      <li class="">
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Footer Copyright text', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                                <?php
                                  $copyright = voip_get_option( 'wd_copyright' );
                                  $copyright = ( ! empty( $copyright ) ) ? voip_get_option( 'wd_copyright' ) : '&copy; 2022 voip All rights reserved.'; ?>
                                  <input type="text" class="wd_txt_big" name="wd_copyright" placeholder="<?php echo esc_html__( 'Footer Copyright text', 'voip' ) ?>" value="<?php echo esc_attr( $copyright ); ?>">
                          </div>
                      </li>
                      <li class="">
                          <div class="title-option">
                            <label><?php echo esc_html__( 'Powered by text', 'voip' ); ?></label>
                            <p></p>
                          </div>
                          <div class="value-option">
                                <?php
                                  $poweredby = voip_get_option( 'wd_poweredby' );
                                  $poweredby = ( ! empty( $poweredby ) ) ? voip_get_option( 'wd_poweredby' ) : 'voip'; ?>
                                  <input type="text" class="wd_txt_big" name="wd_poweredby"
                                        placeholder="<?php echo esc_html__( 'Powered by', 'voip' ) ?>"
                                        value="<?php echo esc_attr( $poweredby ); ?>">
                          </div>
                      </li>
                      </ul>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          
                <!-- Tab Cistom css & js --->
          <div id="customcssandjs" class="ui-tabs-panel ui-corner-bottom ui-widget-content" aria-labelledby="ui-id-1" role="tabpanel" aria-hidden="false">
            <table class="form-table">
              <tbody>
                <tr>
                  <td>
                    <!-- Tabs title ------>
                    <div class="groups_tabs">
                      <ul class="g_tab">
                        <li data-tab="GeneralSettings_tab" class="current">
                          <h3>General Settings</h3>
                        </li>
                      </ul>
                    </div>
                    <!-- Tabs content ------>
                    <!-- General Settings --->
                    <div id="GeneralSettings_tab" class="tab-content current">
                      <ul class="assets_options">
                          <li>
                            <div class="title-option">
                              <label><?php echo esc_html__( 'Custom css', 'voip' ); ?></label>
                              <p></p>
                            </div>
                            <div class="value-option">
                             <textarea rows="10" cols="70" name="wd_theme_custom_css" placeholder="<?php echo esc_html__( 'Put your style here', 'voip' ) ?>"><?php echo voip_get_option( 'wd_theme_custom_css' ); ?></textarea>
                            </div>
                        </li>
                          
                      </ul>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

         <!-- Tab Importer --->
          <div id="importer" class="ui-tabs-panel ui-corner-bottom ui-widget-content" aria-labelledby="ui-id-1" role="tabpanel" aria-hidden="false">
            <table class="form-table">
              <tbody>
                <tr>
                  <td>
                    <div class="import-demo-screenshot">
                                    <div id="wd-metaboxes-general" class="wrap wd-page wd-page-info"
                 style="padding: 20px;background-color: #FFF;">
              <table class="form-table">
                <tbody>
                <tr>
                  <td style="display: none;"></td>
                  <td class="import-demo-screenshot" style="padding-left: 250px;">
                    <em class="wd-field-description"><?php echo esc_html__( 'Select demo to import', 'voip' ); ?>
                      : </em>
                    <select name="Demo_selector" id="Demo_selector" class="form-control wd-form-element">
                      <option value="demo-1">Demo 1</option>
                      <option value="demo-2">Demo 2</option>
                      <option value="demo-3">Demo 3</option>
                      <option value="demo-4">Demo 4</option>
                    </select><br>
                    <label class="demo-1 primary demos_label" for="primary"></label>

                    <label class="demo-2 creative  demos_label" for="creative" style="display:none"></label>

                    <label class="demo-3 financial  demos_label" for="financial" style="display:none"></label>

                    <label class="demo-4 business  demos_label" for="business" style="display:none"></label>


                  </td>
                </tr>
                <tr>
                  <td style="display:none;">

                  </td>
                  <td style="padding-left: 250px;">
                    <em class="wd-field-description"><?php echo esc_html__( 'Import Type', 'voip' ); ?> : </em>
                    <select name="import_option" id="import_option" class="form-control wd-form-element">
                      <option value=""><?php echo esc_html__( 'Please Select', 'voip' ); ?></option>
                      <option value="complete_content"><?php echo esc_html__( 'All', 'voip' ); ?></option>
                      <option value="content"><?php echo esc_html__( 'Content', 'voip' ); ?></option>
                      <option value="widgets"><?php echo esc_html__( 'Widgets', 'voip' ); ?></option>
                      <option value="options"><?php echo esc_html__( 'Options', 'voip' ); ?></option>
                      <option value="menus"><?php echo esc_html__( 'Menus', 'voip' ); ?></option>
                    </select>
                  </td>
                </tr>
                <tr id="tr_import_attachments" style="display:none;">
                  <td style="display: none;">
                  </td>
                  <td style="padding-left: 250px;">
                    <p><?php echo esc_html__( 'Do you want to import media files?', 'voip' ); ?></p>
                    <input type="checkbox" value="1" class="wd-form-element" name="import_attachments"
                           id="import_attachments"/>
                  </td>
                </tr>
                <tr id="tr_delete_menus" style="display:none;">
                  <td style="display: none;">
                  </td>
                  <td style="padding-left: 250px;">
                    <p><?php echo esc_html__( 'Do you want to delete all existing menus?', 'voip' ); ?></p>
                    <input type="checkbox" value="1" class="wd-form-element" name="delete_menus" id="delete_menus"/>
                  </td>
                </tr>
                <tr>
                  <td style="display: none;">

                  </td>
                  <td style="padding-left: 250px;">
                    <input type="submit" class="button button-primary"
                           value="<?php echo esc_html__( 'Import', 'voip' ); ?>" name="import" id="import_demo_data"/>
                    <img id="loading_gif" src="<?php echo get_template_directory_uri() . '/images/loading.gif'; ?>"
                         style="margin-left:20px; display:none"/>
                    <img id="OK_result" src="<?php echo get_template_directory_uri() . '/images/OK_result.png'; ?>"
                         style="margin-left:20px; display:none"/>
                    <img id="NOK_result" src="<?php echo get_template_directory_uri() . '/images/NOK_result.png'; ?>"
                         style="margin-left:20px; display:none"/>
                  </td>
                </tr>
                <tr>
                  <td style="display: none;">
                  </td>
                  <td style="padding-left: 250px;">
                    <span><?php esc_html_e( 'The import process may take some time. Please be patient.', 'voip' ) ?> </span><br/>
                    <div class="import_load">
                      <div class="wd-progress-bar-wrapper html5-progress-bar">
                        <div class="progress-bar-wrapper">
                          <progress id="progressbar" value="0" max="100"></progress>
                        </div>
                        <div class="progress-value">0%</div>
                        <div class="progress-bar-message"></div>
                        <div class="error-message" style="color:#990000; font-weight:bold;"></div>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td style="display: none;"></td>
                  <td style="text-align: center;">
                    <div class="alert alert-warning">
                      <strong><?php esc_html_e( 'Important notes:', 'voip' ) ?></strong>
                      <ul>
                        <li><?php esc_html_e( 'Please note that import process will take time needed to download all attachments from demo web site.', 'voip' ); ?></li>
                        <li> <?php _e( 'If you plan to use shop, please install <b>WooCommerce</b> before you run import.', 'voip' ) ?></li>
                      </ul>
                    </div>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          
         
        
        </div>
    
    
        <div class="height columns wp-core-ui wd-validate">
          <button type="button" name="reset" class="button panel-reset"> Reset Options </button>
          <button type="submit" name="search" value="Update Options" class="button success button-primary">Update Options</button>
        </div>
        <div class="height columns wp-core-ui wd-validate down">
          <button type="button" name="reset" class="button panel-reset">Reset Options</button>
          <button type="submit" name="search" value="Update Options" class="button success button-primary">Update Options</button>
        </div>
    </form>
    </div>
		<?php
	}
}
