<?php
/**
 * Plugin Name: eYatra Modern UI
 * Description: Lightweight, removable modern styling. Enqueues one namespaced stylesheet that only styles elements carrying an "ey-*" class, so it is safe site-wide. Deactivate/delete this folder to fully revert.
 * Version: 1.1.0
 * Author: eYatra
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue the modern UI stylesheet on the front end.
 *
 * Phase R (2026-10-12) widened this from just Home (20) + About (2342) to the
 * whole front end. Every rule in the sheet targets an "ey-*" class, so on a page
 * whose content carries none of them it styles nothing — the only cost is the
 * ~11 KB request. Loading it everywhere is what lets the same authoring kit
 * (hero, headings, buttons, tick lists, form) be dropped onto any page through
 * content alone, with no per-page PHP change. It loads at priority 25, after the
 * theme, so where a class is used the modern rule wins.
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
