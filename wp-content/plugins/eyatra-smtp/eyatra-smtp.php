<?php
/**
 * Plugin Name:       eYatra SMTP
 * Description:       Routes wp_mail() (order mails, CF7) through an SMTP relay configured with EYATRA_SMTP_* constants in wp-config.php. With no EYATRA_SMTP_HOST constant the plugin is a no-op and PHP mail() keeps its default behaviour.
 * Version:           1.0.0
 * Author:            eYatra
 * License:           GPL-2.0-or-later
 * Text Domain:       eyatra-smtp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Configure PHPMailer's SMTP transport from the wp-config constants.
 *
 * No-op when EYATRA_SMTP_HOST is absent or empty, so removing that one
 * constant reverts the site to plain mail() (-> Mailpit locally).
 */
function eyatra_smtp_configure( $phpmailer ) {
	if ( ! defined( 'EYATRA_SMTP_HOST' ) || ! EYATRA_SMTP_HOST ) {
		return;
	}

	$phpmailer->isSMTP();
	$phpmailer->Host       = EYATRA_SMTP_HOST;
	$phpmailer->Port       = defined( 'EYATRA_SMTP_PORT' ) ? (int) EYATRA_SMTP_PORT : 465;
	$phpmailer->SMTPSecure = defined( 'EYATRA_SMTP_SECURE' ) ? EYATRA_SMTP_SECURE : 'ssl';
	$phpmailer->SMTPAuth   = true;
	$phpmailer->Username   = defined( 'EYATRA_SMTP_USERNAME' ) ? EYATRA_SMTP_USERNAME : '';
	$phpmailer->Password   = defined( 'EYATRA_SMTP_PASSWORD' ) ? EYATRA_SMTP_PASSWORD : '';
	$phpmailer->Timeout    = 30; // seconds; keeps CLI verification from hanging on a blocked port
}

/**
 * Gmail rejects a From that does not match the authenticated account, so the
 * sender is pinned to EYATRA_SMTP_FROM while the relay is on.
 */
function eyatra_smtp_from( $from ) {
	if ( defined( 'EYATRA_SMTP_HOST' ) && EYATRA_SMTP_HOST && defined( 'EYATRA_SMTP_FROM' ) ) {
		return EYATRA_SMTP_FROM;
	}

	return $from;
}

function eyatra_smtp_from_name( $from_name ) {
	if ( defined( 'EYATRA_SMTP_HOST' ) && EYATRA_SMTP_HOST && defined( 'EYATRA_SMTP_FROM_NAME' ) ) {
		return EYATRA_SMTP_FROM_NAME;
	}

	return $from_name;
}

add_action( 'phpmailer_init', 'eyatra_smtp_configure' );
add_filter( 'wp_mail_from', 'eyatra_smtp_from' );
add_filter( 'wp_mail_from_name', 'eyatra_smtp_from_name' );
