<?php
/**
 * eYatra eSIM - WPBakery Page Builder element maps.
 *
 * Required by eyatra-esim.php, the plugin's main file. Deliberately has NO
 * Plugin Name header: WordPress lists every root-level .php file that carries
 * one as its own plugin, so a header here would put a second, uninstallable
 * "plugin" in wp-admin -> Plugins that does nothing on its own.
 *
 * Maps the [esim_*] shortcodes onto native WPBakery Page Builder elements, so
 * they can be moved, restyled and copy-edited from the builder instead of being
 * opaque PHP. Editable in wp-admin -> Plugins -> Plugin File Editor.
 *
 * Why this file exists
 * --------------------
 * [esim_buy_cta], [esim_browser] and [esim_checkout] are PHP shortcodes. Their
 * markup is produced at request time, so before this file WPBakery saw them as
 * unrecognised shortcode text with nothing to click on.
 *
 * The browser and the checkout block must stay shortcodes:
 *   - [esim_browser] builds its 4,071 package cards in the browser from
 *     uploads/esim/packages.csv. esim-browser.js finds the filter controls by
 *     id (esim-q, esim-dest, esim-data, esim-type, esim-sort, esim-results) and
 *     buildFilters()/apply() dereference them with no null guard, so the block
 *     cannot be hand-written as static HTML.
 *   - [esim_checkout] resolves ?pkg= server-side against packages.csv, embeds
 *     the Contact Form 7 order form by form slug and renders the FonePay QR.
 *     Its hidden price fields are re-derived server-side on submission by
 *     eyatra_esim_rederive_posted_package_data().
 *
 * So instead of converting them, this file teaches the builder what they are.
 * vc_map() is WPBakery's own element API - the theme uses it the same way in
 * inc/vcomposer/extend.php.
 *
 * Every element is declared 'content_element' => false, which has two effects
 * worth keeping: the builder shows no inner "Text" tab for them, so the working
 * shortcode cannot be edited or deleted by hand from inside the editor; and the
 * copy that IS safe to change is exposed as named fields below.
 *
 * Field defaults are read from the eyatra_esim_*_defaults() helpers in
 * eyatra-esim.php rather than repeated here. WPBakery re-serialises a mapped
 * shortcode by writing only the fields whose value differs from the map's
 * default, so a field left blank in the builder is dropped from the saved
 * shortcode and the PHP default takes over. Sharing one source of truth means a
 * blank field behaves the way the builder shows it, instead of a deleted heading
 * silently reappearing from PHP.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Call vc_map() for one element, swallowing and logging a malformed map.
 *
 * An uncaught exception here would fatal on every front-end request, including
 * the checkout page. A broken map must degrade to "the shortcode still renders,
 * it just is not editable in the builder", which is strictly better than a white
 * screen. _backup/phase-K/verify_vc_map.php asserts all four registered, so a
 * swallowed failure is still caught rather than hidden.
 */
function eyatra_esim_vc_map( $map ) {
	try {
		vc_map( $map );
	} catch ( Exception $e ) {
		error_log( '[eYatra eSIM] vc_map failed for ' . $map['base'] . ': ' . $e->getMessage() );

		return false;
	}

	return true;
}

/**
 * A single-line text field whose default is the shortcode's own default.
 */
function eyatra_esim_vc_textfield( $heading, $param_name, $value, $description = '' ) {
	$field = array(
		'type'       => 'textfield',
		'heading'    => $heading,
		'param_name' => $param_name,
		'value'      => $value,
	);

	if ( '' !== $description ) {
		$field['description'] = $description;
	}

	return $field;
}

/**
 * A multi-line text field. Used for the long subtitle/note copy so it can be
 * rewrapped in the editor without escaping out of an attribute.
 */
function eyatra_esim_vc_textarea( $heading, $param_name, $value, $description = '' ) {
	$field = array(
		'type'       => 'textarea',
		'heading'    => $heading,
		'param_name' => $param_name,
		'value'      => $value,
	);

	if ( '' !== $description ) {
		$field['description'] = $description;
	}

	return $field;
}

/**
 * Register the four eSIM elements.
 *
 * Priority 3 on init: after the theme's own element maps, which the theme loads
 * at priority 2 from inc/plugins/plugins.php. The maps are built on init rather
 * than at file level because vc_map() only exists once js_composer has loaded,
 * whatever the plugin load order happens to be.
 */
function eyatra_esim_vc_register_elements() {
	static $registered = false;

	if ( $registered ) {
		return;
	}

	// WPBakery deactivated, or replaced by a different page builder: the
	// shortcodes keep working because they are registered by eyatra-esim.php.
	if ( ! function_exists( 'vc_map' ) ) {
		return;
	}

	$registered = true;

	$browser = eyatra_esim_browser_defaults();
	$checkout = eyatra_esim_checkout_defaults();
	$cta = eyatra_esim_buy_cta_defaults();
	$recommended = eyatra_esim_recommended_defaults();

	/* ------------------------------------------------ the package catalogue */

	eyatra_esim_vc_map(
		array(
			'name'        => 'eSIM Package Browser',
			'base'        => 'esim_browser',
			'category'    => 'eYatra',
			'icon'        => 'icon-wpb-layout',
			'description' => 'The live package catalogue: Recommended / All packages tabs, the destination, data, type and sort filters, and the "Show more" paging. The cards are assembled by JavaScript from the package data file, using the card template in templates/card.php, so the block itself has no editable text - only the heading and subheading below. The filters cannot be reordered or added to from here.',
			// No inner content element: the shortcode text is the block, and a
			// text tab would let the working markup be deleted by accident.
			'content_element' => false,
			'params'      => array(
				eyatra_esim_vc_textfield(
					'Heading',
					'heading',
					$browser['heading'],
					'Leave empty to remove the heading entirely.'
				),
				eyatra_esim_vc_textarea(
					'Subheading',
					'sub',
					$browser['sub'],
					'Leave empty to remove the subheading entirely.'
				),
			),
		)
	);

	/* ------------------------------------------------------ the checkout block */

	eyatra_esim_vc_map(
		array(
			'name'        => 'eSIM Checkout',
			'base'        => 'esim_checkout',
			'category'    => 'eYatra',
			'icon'        => 'icon-wpb-call-to-action',
			'description' => 'The order block: the selected package summary, the Contact Form 7 order form, and the FonePay QR plus bank transfer details below it. The summary, price and form are produced by PHP from the ?pkg= parameter, so there is no editable text here - only the heading. This block must stay on /esim-checkout/; the package id arrives in the link from the package browser.',
			'content_element' => false,
			'params'      => array(
				eyatra_esim_vc_textfield(
					'Heading',
					'heading',
					$checkout['heading'],
					'Leave empty to remove the heading entirely.'
				),
			),
		)
	);

	/* ---------------------------------------------------- the landing page CTA */

	eyatra_esim_vc_map(
		array(
			'name'        => 'eSIM Buy CTA',
			'base'        => 'esim_buy_cta',
			'category'    => 'eYatra',
			'icon'        => 'icon-wpb-ui-button',
			'description' => 'The purchase section on /esim/: a heading, a short paragraph and one button into the package catalogue. The button always points at the catalogue page, whatever you do to the label.',
			'content_element' => false,
			'params'      => array(
				eyatra_esim_vc_textfield(
					'Heading',
					'heading',
					$cta['heading'],
					'Leave empty to remove the heading entirely.'
				),
				eyatra_esim_vc_textarea(
					'Paragraph',
					'sub',
					$cta['sub'],
					'Leave empty to remove the paragraph entirely.'
				),
				eyatra_esim_vc_textfield(
					'Button label',
					'button',
					$cta['button'],
					'The label only. The link is always the package catalogue page.'
				),
				eyatra_esim_vc_textarea(
					'Note under the button',
					'note',
					$cta['note'],
					'Leave empty to remove the note entirely.'
				),
			),
		)
	);

	/* -------------------------------------------------- the homepage teaser */

	eyatra_esim_vc_map(
		array(
			'name'        => 'eSIM Recommended Packages',
			'base'        => 'esim_recommended',
			'category'    => 'eYatra',
			'icon'        => 'icon-wpb-pricing-table',
			'description' => 'A compact preview of the hand-curated recommended packages, for pages that are not the full catalogue. Each card links into the catalogue with that destination already applied. "Limit" is how many of the curated packages to show - it cannot exceed the number of packages on the curated list.',
			'content_element' => false,
			'params'      => array(
				eyatra_esim_vc_textfield(
					'Heading',
					'heading',
					$recommended['heading'],
					'Leave empty to remove the heading entirely.'
				),
				eyatra_esim_vc_textarea(
					'Subheading',
					'sub',
					$recommended['sub'],
					'Leave empty to remove the subheading entirely.'
				),
				eyatra_esim_vc_textfield(
					'How many packages',
					'limit',
					(string) $recommended['limit'],
					'A number, e.g. 6 or 12.'
				),
				eyatra_esim_vc_textfield(
					'Button label',
					'button',
					$recommended['button'],
					'The label only. The link is always the package catalogue page.'
				),
			),
		)
	);
}
add_action( 'init', 'eyatra_esim_vc_register_elements', 3 );