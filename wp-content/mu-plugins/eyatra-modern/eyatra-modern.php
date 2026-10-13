<?php
/**
 * Plugin Name: eYatra Modern UI
 * Description: Lightweight, removable modern styling. Enqueues one namespaced stylesheet that styles "ey-*" page content plus the global site footer, so it is safe site-wide and deletes cleanly. Deactivate/delete this folder to fully revert the look (the footer's reworded bottom line lives in the theme's footer.php — see TRACKING.md).
 * Version: 1.2.0
 * Author: eYatra
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue the modern UI stylesheet on the front end.
 *
 * Phase R (2026-10-12) widened this from just Home (20) + About (2342) to the
 * whole front end. The page-content rules in the sheet target an "ey-*" class, so
 * on a page whose content carries none of them they style nothing — the only cost
 * is the ~11 KB request. Loading it everywhere is what lets the same authoring kit
 * (hero, headings, buttons, tick lists, form) be dropped onto any page through
 * content alone, with no per-page PHP change. It loads at priority 25, after the
 * theme, so where a class is used the modern rule wins.
 *
 * Phase S5 (2026-10-13) appended a footer block: it targets the theme's own
 * .l-footer-columns / .l-footer (the footer is not builder content, so it cannot
 * carry ey-* classes) to bring the site footer onto the same navy + orange kit.
 */
function eyatra_modern_enqueue_assets() {
	if ( is_admin() ) {
		return;
	}

	$css_path = __DIR__ . '/eyatra-modern.css';
	$css_url  = plugins_url( 'eyatra-modern.css', __FILE__ );
	$version  = file_exists( $css_path ) ? filemtime( $css_path ) : '1.1.0';

	wp_enqueue_style( 'eyatra-modern', $css_url, array(), $version );
}
add_action( 'wp_enqueue_scripts', 'eyatra_modern_enqueue_assets', 25 );
