<?php
/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Plugin:
 * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
 */
require_once get_template_directory() . '/inc/plugins/lib/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'wd_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function wd_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		array(
			'name'      => esc_html__( 'WPBakery Visual Composer','voip' ), // The plugin name
			'slug'      => 'js_composer', // The plugin slug (typically the folder name)
			'source'      => 'https://demo.webdevia.com/api/v1/download.php?file=js_composer', // The plugin source
			'required'      => false, // If false, the plugin is only 'recommended' instead of required
			'version'     => '7.7.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation'    => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'  => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'    => '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'      => esc_html__('Slider Revolution' ,'voip' ),
			'slug'      => 'revslider',
			'source'      => 'https://demo.webdevia.com/api/v1/download.php?file=revslider',
			'required'      => false,
			'version'     => '6.7.14',
			'force_activation'    => false,
			'force_deactivation'  => false,
			'external_url'    => '',
		),
		array(
			'name'      => esc_html__('wd main plugin' ,'voip' ), // The plugin name
			'slug'      => 'wd-main-plugin', // The plugin slug (typically the folder name)
			'source'      => get_template_directory() . '/inc/plugins/lib/plugins/wd-main-plugin.zip', // The plugin source
			'required'      => false, // If false, the plugin is only 'recommended' instead of required
			'version'     => '2.8', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation'    => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'  => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'    => '', // If set, overrides default API URL and points to an external URL
		),
        array(

            'name'    => 'contact form7',
            'slug'    => 'contact-form-7',
            'required'  => false,
            'force_activation'    => false,
        ),
				array(

            'name'    => 'WooCommerce',
            'slug'    => 'woocommerce',
            'required'  => false,
            'force_activation'    => false,
        )
	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}








if(function_exists('vc_set_as_theme')) vc_set_as_theme(true);

// Initialising Shortcodes
if (class_exists('WPBakeryVisualComposerAbstract')) {
  function require_composer_Extend(){
    require_once get_template_directory() . '/inc/vcomposer/extend.php';
  }
  add_action('init', 'require_composer_Extend',2);
}