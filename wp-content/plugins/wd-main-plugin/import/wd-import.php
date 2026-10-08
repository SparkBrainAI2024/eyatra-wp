<?php
if (!function_exists ('add_action')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}


/**
 * Register styles and scripts
 */

function wd_admin_scripts_init() {

    wp_register_script('bootstrap.min', get_template_directory_uri().'/js/bootstrap.min.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-mouse', 'jquery-ui-tabs', 'jquery-ui-droppable', 'jquery-ui-sortable' ) , false , false );

}
add_action('admin_init', 'wd_admin_scripts_init');


class wd_Import {

    public $message = "";
    public $attachments = false;


    function init_wd_import() {
        if(isset($_REQUEST['import_option'])) {
            $import_option = $_REQUEST['import_option'];
            if($import_option == 'content'){
            }elseif($import_option == 'custom_sidebars') {
                $this->import_custom_sidebars('custom_sidebars.txt');
            } elseif($import_option == 'widgets') {
                $this->import_widgets('widgets.txt');
            } elseif($import_option == 'options'){
                $this->import_options('options.txt');
            }elseif($import_option == 'menus'){
                $this->import_menus('menus.txt');
            }elseif($import_option == 'settingpages'){
                $this->import_settings_pages('settingpages.txt');
            }elseif($import_option == 'complete_content'){
                $this->import_options('options.txt');
                $this->import_widgets('widgets.txt');
                $this->import_menus('menus.txt');
                $this->import_settings_pages('settingpages.txt');
                $this->message = esc_html__("Content imported successfully", "webdevia");
            }
        }
    }

    public function wd_import_content($file){
       // ob_start();
        if (!class_exists('WP_Importer')) {
            $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
            require_once($class_wp_importer);
        }
        if (!class_exists('WP_Import')) {
            require_once(plugin_dir_path( __FILE__ ) . '/class.wordpress-importer.php');
        }
            $wd_import = new WP_Import();
            set_time_limit(0);
            $path = plugin_dir_path( __FILE__ ) . '/files/' . $file;
            if(!file_exists($path)) {
                echo 'error';
                wp_send_json_error(esc_html__("Content file not found", "webdevia"));
            }
           // print $path;
            $wd_import->fetch_attachments = $this->attachments;
            $returned_value = $wd_import->import($path);
            if(is_wp_error($returned_value)){
                $this->message = esc_html__("An Error Occurred During Import", "webdevia");
                echo 'error';
                wp_send_json_error(esc_html__("An Error Occurred During Content Import", "webdevia"));
            }
            else {
                $this->message = esc_html__("Content imported successfully", "webdevia");
            }
         //   ob_get_clean();
    }

    public function wd_available_widgets() {

			global $wp_registered_widget_controls;

			$widget_controls = $wp_registered_widget_controls;

			$available_widgets = array();

			foreach ( $widget_controls as $widget ) {

				if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[$widget['id_base']] ) ) { // no dupes

					$available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
					$available_widgets[$widget['id_base']]['name'] = $widget['name'];

				}

			}

			return apply_filters( 'wie_available_widgets', $available_widgets );

		}

    public function import_widgets($file){

	    if(!file_exists(dirname(__FILE__) . '/files/' . $file)) {
            echo 'error';
            wp_send_json_error(esc_html__("Widgets file not found", "webdevia"));
	    } else {
		    $myfile = fopen( dirname(__FILE__) . '/files/' . $file, "r" ) or wp_die( "Unable to open file!" );
		    $data = fread( $myfile, filesize( dirname(__FILE__) . '/files/' . $file ) );
		    fclose( $myfile );
	    }

	    /*
	    $data = file_get_contents( "./demo-files/widgets.txt", FILE_USE_INCLUDE_PATH );
	    $data = json_decode( $data );

	    // Delete import file
	    unlink( $file );*/

	    $data = json_decode( $data );



	    global $wp_registered_sidebars;

	    // Have valid data?
	    // If no data or could not decode
	    if ( empty( $data ) || ! is_object( $data ) ) {
            echo 'error';
            wp_send_json_error(esc_html__( "Widgets import data file could not be read or is empty.", 'widget-importer-exporter' ));
		    wp_die(
			    __( 'Import data could not be read. Please try a different file.', 'widget-importer-exporter' ),
			    '',
			    array( 'back_link' => true )
		    );
	    }

	    // Hook before import
	    do_action( 'wie_before_import' );
	    $data = apply_filters( 'import_widgets', $data );

	    // Get all available widgets site supports
	    $available_widgets = $this->wd_available_widgets();

	    // Get all existing widget instances
	    $widget_instances = array();
	    foreach ( $available_widgets as $widget_data ) {
		    $widget_instances[$widget_data['id_base']] = get_option( 'widget_' . $widget_data['id_base'] );
	    }

	    // Begin results
	    $results = array();

	    // Loop import data's sidebars
	    foreach ( $data as $sidebar_id => $widgets ) {

		    // Skip inactive widgets
		    // (should not be in export file)
		    if ( 'wp_inactive_widgets' == $sidebar_id ) {
			    continue;
		    }

		    // Check if sidebar is available on this site
		    // Otherwise add widgets to inactive, and say so
		    if ( isset( $wp_registered_sidebars[$sidebar_id] ) ) {
			    $sidebar_available = true;
			    $use_sidebar_id = $sidebar_id;
			    $sidebar_message_type = 'success';
			    $sidebar_message = '';
		    } else {
			    $sidebar_available = false;
			    $use_sidebar_id = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
			    $sidebar_message_type = 'error';
			    $sidebar_message = __( 'Sidebar does not exist in theme (using Inactive)', 'widget-importer-exporter' );
		    }

		    // Result for sidebar
		    $results[$sidebar_id]['name'] = ! empty( $wp_registered_sidebars[$sidebar_id]['name'] ) ? $wp_registered_sidebars[$sidebar_id]['name'] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
		    $results[$sidebar_id]['message_type'] = $sidebar_message_type;
		    $results[$sidebar_id]['message'] = $sidebar_message;
		    $results[$sidebar_id]['widgets'] = array();

		    // Loop widgets
		    foreach ( $widgets as $widget_instance_id => $widget ) {

			    echo $sidebar_id .' - '. $widget_instance_id;

			    $fail = false;

			    // Get id_base (remove -# from end) and instance ID number
			    $id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
			    $instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );

			    // Does site support this widget?
			    if ( ! $fail && ! isset( $available_widgets[$id_base] ) ) {
				    $fail = true;
				    $widget_message_type = 'error';
				    $widget_message = __( 'Site does not support widget', 'widget-importer-exporter' ); // explain why widget not imported
			    }

			    // Filter to modify settings object before conversion to array and import
			    // Leave this filter here for backwards compatibility with manipulating objects (before conversion to array below)
			    // Ideally the newer wie_widget_settings_array below will be used instead of this
			    $widget = apply_filters( 'wie_widget_settings', $widget ); // object

			    // Convert multidimensional objects to multidimensional arrays
			    // Some plugins like Jetpack Widget Visibility store settings as multidimensional arrays
			    // Without this, they are imported as objects and cause fatal error on Widgets page
			    // If this creates problems for plugins that do actually intend settings in objects then may need to consider other approach: https://wordpress.org/support/topic/problem-with-array-of-arrays
			    // It is probably much more likely that arrays are used than objects, however
			    $widget = json_decode( json_encode( $widget ), true );

			    // Filter to modify settings array
			    // This is preferred over the older wie_widget_settings filter above
			    // Do before identical check because changes may make it identical to end result (such as URL replacements)
			    $widget = apply_filters( 'wie_widget_settings_array', $widget );

			    // Does widget with identical settings already exist in same sidebar?
			    if ( ! $fail && isset( $widget_instances[$id_base] ) ) {

				    // Get existing widgets in this sidebar
				    $sidebars_widgets = get_option( 'sidebars_widgets' );
				    $sidebar_widgets = isset( $sidebars_widgets[$use_sidebar_id] ) ? $sidebars_widgets[$use_sidebar_id] : array(); // check Inactive if that's where will go

				    // Loop widgets with ID base
				    $single_widget_instances = ! empty( $widget_instances[$id_base] ) ? $widget_instances[$id_base] : array();
				    foreach ( $single_widget_instances as $check_id => $check_widget ) {

					    // Is widget in same sidebar and has identical settings?
					    if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {

						    $fail = true;
						    $widget_message_type = 'warning';
						    $widget_message = __( 'Widget already exists', 'widget-importer-exporter' ); // explain why widget not imported

						    break;

					    }

				    }

			    }

			    // No failure
			    if ( ! $fail ) {

				    // Add widget instance
				    $single_widget_instances = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
				    $single_widget_instances = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to
				    $single_widget_instances[] = $widget; // add it

				    // Get the key it was given
				    end( $single_widget_instances );
				    $new_instance_id_number = key( $single_widget_instances );

				    // If key is 0, make it 1
				    // When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
				    if ( '0' === strval( $new_instance_id_number ) ) {
					    $new_instance_id_number = 1;
					    $single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
					    unset( $single_widget_instances[0] );
				    }

				    // Move _multiwidget to end of array for uniformity
				    if ( isset( $single_widget_instances['_multiwidget'] ) ) {
					    $multiwidget = $single_widget_instances['_multiwidget'];
					    unset( $single_widget_instances['_multiwidget'] );
					    $single_widget_instances['_multiwidget'] = $multiwidget;
				    }

				    // Update option with new widget
				    update_option( 'widget_' . $id_base, $single_widget_instances );

				    // Assign widget instance to sidebar
				    $sidebars_widgets = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
				    $new_instance_id = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
				    $sidebars_widgets[$use_sidebar_id][] = $new_instance_id; // add new instance to sidebar
				    update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data

				    // Success message
				    if ( $sidebar_available ) {
					    $widget_message_type = 'success';
					    $widget_message = __( 'Imported', 'widget-importer-exporter' );
				    } else {
					    $widget_message_type = 'warning';
					    $widget_message = __( 'Imported to Inactive', 'widget-importer-exporter' );
				    }

			    }

			    // Result for widget instance
			    $results[$sidebar_id]['widgets'][$widget_instance_id]['name'] = isset( $available_widgets[$id_base]['name'] ) ? $available_widgets[$id_base]['name'] : $id_base; // widget name or ID if name not available (not supported by site)
			    $results[$sidebar_id]['widgets'][$widget_instance_id]['title'] = ! empty( $widget['title'] ) ? $widget['title'] : __( 'No Title', 'widget-importer-exporter' ); // show "No Title" if widget instance is untitled
			    $results[$sidebar_id]['widgets'][$widget_instance_id]['message_type'] = $widget_message_type;
			    $results[$sidebar_id]['widgets'][$widget_instance_id]['message'] = $widget_message;

		    }

	    }
    }


    public function import_options($file){
        $options = $this->file_options($file,'Options');
        update_option( 'wd_options_wd', $options);
        $this->message = esc_html__("Options imported successfully", "webdevia");
    }

    public function import_menus($file){
        global $wpdb;
        $wd_terms_table = $wpdb->prefix . "terms";
        $wd_terms_table = esc_sql( $wd_terms_table );
        $this->menus_data = $this->file_options($file,'Menus');
        $menu_array = array();
      /*  foreach ($this->menus_data as $registered_menu => $menu_slug) {
            $term_rows = $wpdb->get_results("SELECT * FROM $wd_terms_table where slug='{$menu_slug}'", ARRAY_A);
            if(isset($term_rows[0]['term_id'])) {
                $term_id_by_slug = $term_rows[0]['term_id'];
            } else {
                $term_id_by_slug = null;
            }
            $menu_array[$registered_menu] = $term_id_by_slug;
        }
        set_theme_mod('nav_menu_locations', array_map('absint', $menu_array ) ); */

        $locations = get_theme_mod('nav_menu_locations');
        $menuname = 'main-men';
        $menu_exists = wp_get_nav_menu_object( $menuname );
        $menu_id = $menu_exists->term_id;
        $locations['primary'] = $menu_id;
        $menuname = 'secondary-menu';
        $menu_exists = wp_get_nav_menu_object( $menuname );
        $menu_id = $menu_exists->term_id;
        $locations['login-menu'] = $menu_id;

        set_theme_mod( 'nav_menu_locations', $locations );

    }
    public function import_settings_pages($file){
        $pages = $this->file_options($file,'Settings');

        foreach($pages as $wd_page_option => $wd_page_id){
            update_option( $wd_page_option, $wd_page_id);
        }
    }
    public function file_options($file,$text){
        $file_content = "";
        $file_for_import = plugin_dir_path( __FILE__ ) . '/files/' . $file;
        if ( file_exists($file_for_import) ) {
            $file_content = $this->wd_file_contents($file_for_import);
        } else {
            $this->message = esc_html__("File doesn't exist", "webdevia");
            echo 'error';
            wp_send_json_error(esc_html__($text." file doesn't exist", "webdevia"));
        }
        if ($file_content) {
            $unserialized_content = unserialize($file_content);
            $json_array = json_decode($file_content);
            /*print_r($json_array);*/
            /*if ($unserialized_content) {
                return $unserialized_content;

            }*/
            //print_r($json_array);
        return $unserialized_content;
        }  else{
            echo 'error';
            wp_send_json_error(esc_html__( $text." import data file could not be read or is empty.", 'widget-importer-exporter' ));
        }
        /*return false;*/
    }

    function wd_file_contents( $path ) {
        $wd_content = '';
        if ( function_exists('realpath') )
            $filepath = realpath($path);
        if ( !$filepath || !@is_file($filepath) ) {
            echo 'error';
            wp_send_json_error(esc_html__("File doesn't exist or not valid", "webdevia"));
            return '';
        }
        if( ini_get('allow_url_fopen') ) {
            $wd_file_method = 'fopen';
        } else {
            $wd_file_method = 'file_get_contents';
        }
        if ( $wd_file_method == 'fopen' ) {
            $wd_handle = fopen( $filepath, 'rb' );

            if( $wd_handle !== false ) {
                while (!feof($wd_handle)) {
                    $wd_content .= fread($wd_handle, 8192);
                }
                fclose( $wd_handle );
            }
            return $wd_content;
        } else {
            return file_get_contents($filepath);
        }
    }
}
global $my_wd_Import;
$my_wd_Import = new wd_Import();



if(!function_exists('wd_dataImport'))
{
    function wd_dataImport()
    {
        global $my_wd_Import;

        if ($_POST['import_attachments'] == 1)
            $my_wd_Import->attachments = true;
        else
            $my_wd_Import->attachments = false;

        $folder = "files/";
        if (!empty($_POST['example']))
            $folder = $_POST['example']."/";

        $my_wd_Import->wd_import_content($folder.$_POST['xml']);

        wp_die();
    }

    add_action('wp_ajax_wd_dataImport', 'wd_dataImport');
}


if(!function_exists('wd_menuImport'))
{
    function wd_menuImport()
    {
        global $my_wd_Import;

        if ($_POST['delete_menus'] == 1){
            delete_nav_menus();
        }

        if ($_POST['import_attachments'] == 1)
            $my_wd_Import->attachments = true;
        else
            $my_wd_Import->attachments = false;

        $folder = "files/";
        if (!empty($_POST['example']))
            $folder = $_POST['example']."/";

        $my_wd_Import->wd_import_content($folder.'menus.xml');

        $locations = get_theme_mod('nav_menu_locations');
        $menuname = 'main-men';
        $menu_exists = wp_get_nav_menu_object( $menuname );
        $menu_id = $menu_exists->term_id;
        $locations['primary'] = $menu_id;
        $menuname = 'secondary-menu';
        $menu_exists = wp_get_nav_menu_object( $menuname );
        $menu_id = $menu_exists->term_id;
        $locations['login-menu'] = $menu_id;

        set_theme_mod( 'nav_menu_locations', $locations );



        wp_die();
    }

    add_action('wp_ajax_wd_menuImport', 'wd_menuImport');
}

if(!function_exists('wd_widgetsImport'))
{
    function wd_widgetsImport()
    {
        global $my_wd_Import;

        $folder = "/files/";
        if (!empty($_POST['example']))
            $folder = $_POST['example']."/";

	     $my_wd_Import->import_widgets($folder.'widgets.txt');

        wp_die();
    }

    add_action('wp_ajax_wd_widgetsImport', 'wd_widgetsImport');
}

if(!function_exists('wd_optionsImport'))
{
    function wd_optionsImport()
    {
        global $my_wd_Import;

        $folder = "/files/";
        if (!empty($_POST['example']))
            $folder = $_POST['example']."/";

        $my_wd_Import->import_options($folder.'options.txt');

        wp_die();
    }

    add_action('wp_ajax_wd_optionsImport', 'wd_optionsImport');
}

if(!function_exists('wd_otherImport'))
{
    function wd_otherImport()
    {
        global $my_wd_Import;

        $folder = "/files/";
        if (!empty($_POST['example']))
            $folder = $_POST['example']."/";

        // wd_import_options();
        // $my_wd_Import->import_widgets($folder.'widgets.txt');
        // wd_menuImport();
        $my_wd_Import->import_settings_pages($folder.'settingpages.txt');

        wp_die();
    }

    add_action('wp_ajax_wd_otherImport', 'wd_otherImport');
}

if (!function_exists('wd_import_options')) {
    function wd_import_options()
    {
        global $my_wd_Import;


        $folder = "files/";
        if (!empty($_POST['example'])) {
            $demo_name = $_POST['example'];
        }

        if ($demo_name == 'demo-1') {
            $file = 'a:55:{s:12:"wd_show_logo";s:2:"on";s:12:"wd_show_cart";s:0:"";s:23:"wd_show_top_social_bare";s:0:"";s:14:"wd_box_wrapper";s:2:"of";s:15:"wd_menu_in_grid";s:3:"off";s:14:"wd_menu_sticky";s:2:"on";s:13:"wd_show_title";s:2:"of";s:18:"wd_footer_bg_image";s:0:"";s:15:"footer_bg_color";s:0:"";s:17:"footer_text_color";s:0:"";s:12:"wd_copyright";s:33:"© 2017 voip All rights reserved.";s:12:"wd_poweredby";s:4:"voip";s:20:"copyright_text_color";s:0:"";s:7:"wd_logo";s:83:"http://themes.webdevia.com/voip-wordpress-theme/wp-content/uploads/2016/11/logo.png";s:11:"wd_404_page";s:0:"";s:12:"wd_home_page";s:0:"";s:10:"wd_favicon";s:0:"";s:19:"wd_theme_custom_css";s:0:"";s:16:"wrapper_bg_color";s:0:"";s:13:"primary_color";s:16:"rgba(93,162,4,1)";s:15:"secondary_color";s:0:"";s:16:"adress_bar_color";s:0:"";s:16:"social_bar_color";s:0:"";s:12:"copyright_bg";s:0:"";s:9:"header_bg";s:0:"";s:12:"container_bg";s:0:"";s:17:"wd_footer_columns";s:12:"four_columns";s:21:"navigation_text_color";s:19:"rgba(255,255,255,1)";s:26:"navigation_bg_color_sticky";s:0:"";s:18:"language_area_html";s:0:"";s:21:"voip_show_wpml_widget";s:0:"";s:7:"twitter";s:0:"";s:8:"facebook";s:0:"";s:6:"flickr";s:0:"";s:5:"vimeo";s:0:"";s:5:"phone";s:0:"";s:6:"adress";s:0:"";s:20:"wd_body_font_familly";s:7:"Poppins";s:20:"wd_font-weight-style";s:0:"";s:27:"wd_main_text_lettre_spacing";s:0:"";s:25:"wd_main-text-font-subsets";s:5:"latin";s:20:"wd_head_font_familly";s:7:"Poppins";s:28:"wd_heading-font-weight-style";s:3:"700";s:28:"wd_heading-text-font-subsets";s:5:"latin";s:30:"wd_heading_text_lettre_spacing";s:0:"";s:26:"wd_navigation_font_familly";s:7:"default";s:31:"wd_navigation-font-weight-style";s:3:"400";s:31:"wd_navigation-text-font-subsets";s:5:"latin";s:33:"wd_navigation_text_lettre_spacing";s:0:"";s:13:"wd_menu_style";s:8:"creative";s:18:"wd_theme_custom_js";s:0:"";s:18:"adress_bar_bgcolor";s:0:"";s:4:"time";s:0:"";s:19:"wd_body_font_weight";s:3:"300";s:19:"voip_google_map_key";s:39:"AIzaSyAmgQr8mjqkLQgcEqGNzjd7YgHZs7EIYrg";}';
            $home = get_page_by_title('Home');
        }
        if ($demo_name == 'demo-2') {
            $file = 'a:55:{s:12:"wd_show_logo";s:2:"on";s:12:"wd_show_cart";s:0:"";s:23:"wd_show_top_social_bare";s:0:"";s:14:"wd_box_wrapper";s:2:"of";s:15:"wd_menu_in_grid";s:3:"off";s:14:"wd_menu_sticky";s:2:"on";s:13:"wd_show_title";s:2:"of";s:18:"wd_footer_bg_image";s:0:"";s:15:"footer_bg_color";s:0:"";s:17:"footer_text_color";s:0:"";s:12:"wd_copyright";s:33:"© 2017 voip All rights reserved.";s:12:"wd_poweredby";s:4:"voip";s:20:"copyright_text_color";s:0:"";s:7:"wd_logo";s:83:"http://themes.webdevia.com/voip-wordpress-theme/wp-content/uploads/2016/11/logo.png";s:11:"wd_404_page";s:0:"";s:12:"wd_home_page";s:0:"";s:10:"wd_favicon";s:0:"";s:19:"wd_theme_custom_css";s:0:"";s:16:"wrapper_bg_color";s:0:"";s:13:"primary_color";s:16:"rgba(93,162,4,1)";s:15:"secondary_color";s:0:"";s:16:"adress_bar_color";s:0:"";s:16:"social_bar_color";s:0:"";s:12:"copyright_bg";s:0:"";s:9:"header_bg";s:0:"";s:12:"container_bg";s:0:"";s:17:"wd_footer_columns";s:12:"four_columns";s:21:"navigation_text_color";s:19:"rgba(255,255,255,1)";s:26:"navigation_bg_color_sticky";s:0:"";s:18:"language_area_html";s:0:"";s:21:"voip_show_wpml_widget";s:0:"";s:7:"twitter";s:0:"";s:8:"facebook";s:0:"";s:6:"flickr";s:0:"";s:5:"vimeo";s:0:"";s:5:"phone";s:0:"";s:6:"adress";s:0:"";s:20:"wd_body_font_familly";s:7:"Poppins";s:20:"wd_font-weight-style";s:0:"";s:27:"wd_main_text_lettre_spacing";s:0:"";s:25:"wd_main-text-font-subsets";s:5:"latin";s:20:"wd_head_font_familly";s:7:"Poppins";s:28:"wd_heading-font-weight-style";s:3:"700";s:28:"wd_heading-text-font-subsets";s:5:"latin";s:30:"wd_heading_text_lettre_spacing";s:0:"";s:26:"wd_navigation_font_familly";s:7:"default";s:31:"wd_navigation-font-weight-style";s:3:"400";s:31:"wd_navigation-text-font-subsets";s:5:"latin";s:33:"wd_navigation_text_lettre_spacing";s:0:"";s:13:"wd_menu_style";s:8:"creative";s:18:"wd_theme_custom_js";s:0:"";s:18:"adress_bar_bgcolor";s:0:"";s:4:"time";s:0:"";s:19:"wd_body_font_weight";s:3:"300";s:19:"voip_google_map_key";s:39:"AIzaSyAmgQr8mjqkLQgcEqGNzjd7YgHZs7EIYrg";}';
            $home = get_page_by_title('Home Two');
        }

        if ($demo_name == 'demo-3') {
            $file = 'a:55:{s:12:"wd_show_logo";s:2:"on";s:12:"wd_show_cart";s:0:"";s:23:"wd_show_top_social_bare";s:0:"";s:14:"wd_box_wrapper";s:2:"on";s:15:"wd_menu_in_grid";s:3:"off";s:14:"wd_menu_sticky";s:2:"on";s:13:"wd_show_title";s:2:"of";s:18:"wd_footer_bg_image";s:0:"";s:15:"footer_bg_color";s:0:"";s:17:"footer_text_color";s:0:"";s:12:"wd_copyright";s:33:"© 2017 voip All rights reserved.";s:12:"wd_poweredby";s:4:"voip";s:20:"copyright_text_color";s:0:"";s:7:"wd_logo";s:83:"http://themes.webdevia.com/voip-wordpress-theme/wp-content/uploads/2016/11/logo.png";s:11:"wd_404_page";s:0:"";s:12:"wd_home_page";s:0:"";s:10:"wd_favicon";s:0:"";s:19:"wd_theme_custom_css";s:0:"";s:16:"wrapper_bg_color";s:0:"";s:13:"primary_color";s:16:"rgba(93,162,4,1)";s:15:"secondary_color";s:0:"";s:16:"adress_bar_color";s:0:"";s:16:"social_bar_color";s:0:"";s:12:"copyright_bg";s:0:"";s:9:"header_bg";s:0:"";s:12:"container_bg";s:0:"";s:17:"wd_footer_columns";s:12:"four_columns";s:21:"navigation_text_color";s:19:"rgba(255,255,255,1)";s:26:"navigation_bg_color_sticky";s:0:"";s:18:"language_area_html";s:0:"";s:21:"voip_show_wpml_widget";s:0:"";s:7:"twitter";s:0:"";s:8:"facebook";s:0:"";s:6:"flickr";s:0:"";s:5:"vimeo";s:0:"";s:5:"phone";s:0:"";s:6:"adress";s:0:"";s:20:"wd_body_font_familly";s:7:"Poppins";s:20:"wd_font-weight-style";s:0:"";s:27:"wd_main_text_lettre_spacing";s:0:"";s:25:"wd_main-text-font-subsets";s:5:"latin";s:20:"wd_head_font_familly";s:7:"Poppins";s:28:"wd_heading-font-weight-style";s:3:"700";s:28:"wd_heading-text-font-subsets";s:5:"latin";s:30:"wd_heading_text_lettre_spacing";s:0:"";s:26:"wd_navigation_font_familly";s:7:"default";s:31:"wd_navigation-font-weight-style";s:3:"400";s:31:"wd_navigation-text-font-subsets";s:5:"latin";s:33:"wd_navigation_text_lettre_spacing";s:0:"";s:13:"wd_menu_style";s:8:"creative";s:18:"wd_theme_custom_js";s:0:"";s:18:"adress_bar_bgcolor";s:0:"";s:4:"time";s:0:"";s:19:"wd_body_font_weight";s:3:"300";s:19:"voip_google_map_key";s:39:"AIzaSyAmgQr8mjqkLQgcEqGNzjd7YgHZs7EIYrg";}';			$home = get_page_by_title('Home Three');
        }


        $options_array = array();

        $options_array = unserialize($file);

        update_option("wd_options_array",$options_array);

    }
    add_action('wp_ajax_wd_import_options', 'wd_import_options');
}

function delete_nav_menus(){
    $menus_list=get_terms( 'nav_menu', array( 'hide_empty' => false ) );
    foreach($menus_list as $menu){
        wp_delete_nav_menu($menu->term_id);
    }
}