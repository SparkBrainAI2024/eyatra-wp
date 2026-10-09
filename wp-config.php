<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

/**
 * Load environment-specific settings from .env (schema in .env.placeholder).
 *
 * WordPress does not read .env files itself, so this tiny parser runs before
 * any constant is defined. Each non-blank, non-comment line is KEY=value; a
 * value may be wrapped in single or double quotes. Keys already defined are
 * left alone, and missing keys simply fall through to the defaults below - so
 * the site still boots when .env has not been created yet.
 */
$eyatra_env_file = __DIR__ . '/.env';
if ( is_readable( $eyatra_env_file ) ) {
	foreach ( file( $eyatra_env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES ) as $eyatra_env_line ) {
		$eyatra_env_line = trim( $eyatra_env_line );
		if ( '' === $eyatra_env_line || '#' === $eyatra_env_line[0] ) {
			continue;
		}
		if ( false === strpos( $eyatra_env_line, '=' ) ) {
			continue;
		}
		list( $eyatra_env_key, $eyatra_env_value ) = explode( '=', $eyatra_env_line, 2 );
		$eyatra_env_key   = trim( $eyatra_env_key );
		$eyatra_env_value = trim( $eyatra_env_value );
		if ( strlen( $eyatra_env_value ) >= 2 && ( '"' === $eyatra_env_value[0] || "'" === $eyatra_env_value[0] ) && substr( $eyatra_env_value, -1 ) === $eyatra_env_value[0] ) {
			$eyatra_env_value = substr( $eyatra_env_value, 1, -1 );
		}
		if ( ! defined( $eyatra_env_key ) ) {
			define( $eyatra_env_key, $eyatra_env_value );
		}
		putenv( $eyatra_env_key . '=' . $eyatra_env_value );
	}
	unset( $eyatra_env_file, $eyatra_env_line, $eyatra_env_key, $eyatra_env_value );
}

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', getenv( 'DB_NAME' ) ?: 'eYatraWorld' );

/** Database username */
define( 'DB_USER', getenv( 'DB_USER' ) ?: 'root' );

/** Database password */
define( 'DB_PASSWORD', getenv( 'DB_PASSWORD' ) ?: '' );

/** Database hostname */
define( 'DB_HOST', getenv( 'DB_HOST' ) ?: 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

// WP_HOME/WP_SITEURL come from .env when present (see above). Otherwise fall
// back to the requested host so the site works on any domain/IP without edits.
if ( ( ! defined( 'WP_SITEURL' ) || ! defined( 'WP_HOME' ) ) && ! defined( 'WP_CLI' ) ) {
	$eyatra_scheme = ! empty( $_SERVER['REQUEST_SCHEME'] )
		? $_SERVER['REQUEST_SCHEME']
		: ( ( ! empty( $_SERVER['HTTPS'] ) && 'off' !== strtolower( $_SERVER['HTTPS'] ) ) ? 'https' : 'http' );
	$eyatra_host   = isset( $_SERVER['HTTP_HOST'] ) ? $_SERVER['HTTP_HOST'] : 'localhost';
	if ( ! defined( 'WP_SITEURL' ) ) {
		define( 'WP_SITEURL', $eyatra_scheme . '://' . $eyatra_host );
	}
	if ( ! defined( 'WP_HOME' ) ) {
		define( 'WP_HOME', $eyatra_scheme . '://' . $eyatra_host );
	}
	unset( $eyatra_scheme, $eyatra_host );
}



/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'IqPybpMs57n5DSYZzzr04PIelV1AskRJsBXDwQJQZmYUdNJWSgPJgahlBac3auon' );
define( 'SECURE_AUTH_KEY',  'IqPybpMs57n5DSYZzzr04PIelV1AskRJsBXDwQJQZmYUdNJWSgPJgahlBac3auon' );
define( 'LOGGED_IN_KEY',    'IqPybpMs57n5DSYZzzr04PIelV1AskRJsBXDwQJQZmYUdNJWSgPJgahlBac3auon' );
define( 'NONCE_KEY',        'IqPybpMs57n5DSYZzzr04PIelV1AskRJsBXDwQJQZmYUdNJWSgPJgahlBac3auon' );
define( 'AUTH_SALT',        'IqPybpMs57n5DSYZzzr04PIelV1AskRJsBXDwQJQZmYUdNJWSgPJgahlBac3auon' );
define( 'SECURE_AUTH_SALT', 'IqPybpMs57n5DSYZzzr04PIelV1AskRJsBXDwQJQZmYUdNJWSgPJgahlBac3auon' );
define( 'LOGGED_IN_SALT',   'IqPybpMs57n5DSYZzzr04PIelV1AskRJsBXDwQJQZmYUdNJWSgPJgahlBac3auon' );
define( 'NONCE_SALT',       'IqPybpMs57n5DSYZzzr04PIelV1AskRJsBXDwQJQZmYUdNJWSgPJgahlBac3auon' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */

/**
 * eYatra SMTP relay (Gmail App Password) - plugin: eyatra-smtp.
 *
 * Values are read from .env by the loader at the top of this file (schema in
 * .env.placeholder). Nothing is hardcoded here on purpose: with no EYATRA_SMTP_HOST
 * constant the plugin stays a no-op and wp_mail() keeps plain mail(), and the
 * plugin defaults port/secure and treats an empty username/password as "not
 * configured". Full instructions + cPanel steps:
 * C:\laragon\www\eYatraWorld_progress\TRACKING.md
 */

/*
 * Never print PHP errors into page HTML.
 *
 * The server's php.ini is set to display_errors=Off for the same reason, but
 * Apache here runs as a service and cannot be restarted on demand, so that
 * setting does not take effect until the next machine restart. Enforcing it
 * here means a notice can never leak absolute server paths to a visitor.
 * Errors are still written to the PHP error log.
 */
@ini_set( 'display_errors', '0' );
@ini_set( 'log_errors', '1' );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
