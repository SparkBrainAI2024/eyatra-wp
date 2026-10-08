<?php
/**
 * Plugin Name: eYatra eSIM
 * Description: Registers the [esim_buy_cta], [esim_browser], [esim_checkout] and [esim_recommended] shortcodes and their assets.
 * Version:     1.4.0
 * Author:      eYatra
 *
 * A regular plugin (no longer an mu-plugin) so every file below - PHP, the
 * card template, the stylesheet and the script - is editable from
 * wp-admin -> Plugins -> Plugin File Editor. It still survives theme updates,
 * which was the reason it was an mu-plugin in the first place.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Bumped 1.2.0 -> 1.2.1 because the CSS changed (checkout form spacing and the
// list-marker override). The constant is also the asset cache-buster, so a
// visitor with the old stylesheet cached would otherwise keep the stray bullets.
//
// 1.2.1 -> 1.3.0 for Phase K1: the shortcode defaults moved out of the
// shortcode callbacks into the eyatra_esim_*_defaults() helpers so that
// eyatra-esim-vc.php can build the WPBakery element maps from the very same
// values, and the four headings/subheadings are now rendered only when they
// are non-empty, so "leave the field blank" in the builder really does remove
// them instead of leaving an empty <h2>. No field is blank on any live page, so
// no rendered markup changed. The file the browser and stylesheet come from did,
// so the cache-buster moves too.
//
// 1.3.0 -> 1.3.1: the per-card action is now "Buy" instead of "Select". The text
// lived in esim-browser.js (cardHtml).
//
// 1.3.1 -> 1.4.0 for Phase L: the code moved out of mu-plugins/ into this
// regular plugin (editable in the dashboard), the card markup moved out of
// esim-browser.js into templates/card.php + eyatra_esim_js_strings(), and the
// payment block is now rendered permanently visible instead of being revealed
// by a wpcf7mailsent listener. Three user-visible files changed, so the
// cache-buster moves with it.
define( 'EYATRA_ESIM_VERSION', '1.4.0' );

/**
 * Where the FonePay payment QR lives, relative to the uploads directory.
 *
 * Kept as a constant so the checkout markup, the tests and
 * _backup/phase-F/copy_qr.php all name the same file. The image is a copy of
 * wp-content/contents/payment QR/LDT_QR.jpg.
 */
define( 'EYATRA_ESIM_QR_RELATIVE', 'uploads/esim/LDT_QR.jpg' );

/**
 * Absolute filesystem path to the package CSV.
 */
function eyatra_esim_csv_path() {
	return WP_CONTENT_DIR . '/uploads/esim/packages.csv';
}

/**
 * Public URL of the package CSV.
 */
function eyatra_esim_csv_url() {
	return content_url( 'uploads/esim/packages.csv' );
}

/**
 * The curated recommendation list. Hand-editable: rank,package_id,note.
 *
 * Kept in its own file so the featured grid can be changed without touching
 * PHP or JS. Every id is asserted against packages.csv by
 * _backup/phase-C/check_featured.php - a typo here silently drops a card.
 */
function eyatra_esim_featured_csv_path() {
	return WP_CONTENT_DIR . '/uploads/esim/best-sellers.csv';
}

function eyatra_esim_featured_csv_url() {
	return content_url( 'uploads/esim/best-sellers.csv' );
}

/* --------------------------------------------------- server-side catalogue */

/**
 * Every package in packages.csv, keyed by package id.
 *
 * The checkout page needs to resolve ?pkg= to a real row without trusting
 * anything the browser sends, so it reads the same CSV the browser JS reads. The
 * file is parsed once per request and cached in a static: 4,071 rows on every
 * checkout view would otherwise mean 4,071 fgetcsv() calls per page load.
 */
function eyatra_esim_packages() {
	static $rows = null;

	if ( null !== $rows ) {
		return $rows;
	}

	// Default to empty rather than null-on-error so the static is populated and a
	// missing CSV is not re-attempted on every call in the same request.
	$rows = array();

	$path = eyatra_esim_csv_path();

	if ( ! file_exists( $path ) ) {
		return $rows;
	}

	$handle = fopen( $path, 'r' );

	if ( ! $handle ) {
		return $rows;
	}

	$header = fgetcsv( $handle );

	if ( ! is_array( $header ) ) {
		fclose( $handle );
		return $rows;
	}

	$index = array_flip( array_map( function ( $name ) {
		return trim( (string) $name );
	}, $header ) );

	$needed = array( 'country', 'package_id', 'type', 'price_usd', 'data', 'sms', 'voice', 'networks', 'duration', 'kind' );

	foreach ( $needed as $column ) {
		if ( ! isset( $index[ $column ] ) ) {
			// A header the server cannot fully read means we would silently render
			// blanks, which on a payment page is worse than showing nothing.
			fclose( $handle );
			return $rows;
		}
	}

	while ( false !== ( $cells = fgetcsv( $handle ) ) ) {
		if ( ! is_array( $cells ) || count( $cells ) < count( $header ) ) {
			continue;
		}

		$pkg = trim( (string) $cells[ $index['package_id'] ] );

		if ( '' === $pkg ) {
			continue;
		}

		$rows[ $pkg ] = array(
			'country' => trim( (string) $cells[ $index['country'] ] ),
			'pkg'     => $pkg,
			'type'    => trim( (string) $cells[ $index['type'] ] ),
			'price'   => (float) str_replace( ',', '', (string) $cells[ $index['price_usd'] ] ),
			'data'    => trim( (string) $cells[ $index['data'] ] ),
			'sms'     => (int) $cells[ $index['sms'] ],
			'voice'   => (int) $cells[ $index['voice'] ],
			'net'     => trim( (string) $cells[ $index['networks'] ] ),
			'dur'     => trim( (string) $cells[ $index['duration'] ] ),
			'kind'    => trim( (string) $cells[ $index['kind'] ] ),
		);
	}

	fclose( $handle );

	return $rows;
}

/**
 * One package by id, or null when the id is unknown or absent.
 *
 * Returning null for an unrecognised id is deliberate: the checkout page must
 * never render an order summary from values it could not verify against the
 * catalogue.
 */
function eyatra_esim_find_package( $package_id ) {
	$package_id = trim( (string) $package_id );

	if ( '' === $package_id ) {
		return null;
	}

	$all = eyatra_esim_packages();

	return isset( $all[ $package_id ] ) ? $all[ $package_id ] : null;
}

/**
 * The package id carried in the current URL's ?pkg=.
 *
 * No nonce: this is a public GET page view, and a nonce would break bookmarking
 * and every shared catalogue link. The value is only ever used as a lookup key
 * into packages.csv, never rendered unescaped.
 */
function eyatra_esim_requested_package_id() {
	if ( ! isset( $_GET['pkg'] ) || is_array( $_GET['pkg'] ) ) {
		return '';
	}

	return sanitize_text_field( wp_unslash( $_GET['pkg'] ) );
}

/**
 * "134 networks supported" from "134 networks supported - Learn more on Partner".
 *
 * Matches netLabel() in esim-browser.js so the server summary and the catalogue
 * card describe the same thing.
 */
function eyatra_esim_net_label( $networks ) {
	return trim( preg_replace( '/\s*-\s*Learn more on Partner\b.*$/i', '', (string) $networks ) );
}

/**
 * Format a price the same way the catalogue cards do: "$12.00 USD".
 */
function eyatra_esim_price_label( $package ) {
	$symbol = '$';

	if ( function_exists( 'apply_filters' ) ) {
		$symbol = apply_filters( 'eyatra_esim_currency_symbol', $symbol );
	}

	return $symbol . number_format_i18n( (float) $package['price'], 2 ) . ' USD';
}

/**
 * Resolve a permalink for one of the eSIM flow pages by slug.
 *
 * Every page in the purchase flow is addressed by slug rather than by a stored
 * post ID, so re-creating a page cannot leave a shortcode pointing at nothing,
 * and a staging copy of the site resolves its own pages.
 */
function eyatra_esim_page_url( $slug, $fallback_path ) {
	$page = get_page_by_path( $slug );

	if ( $page ) {
		return get_permalink( $page );
	}

	return home_url( '/' . trim( $fallback_path, '/' ) . '/' );
}

/**
 * The page the package browser lives on: /esim-packages/.
 *
 * The catalogue used to sit on /esim/ and was inlined into the enquiry form. It
 * now has its own page, so the homepage teaser's "Browse all packages" button and
 * its ?dest= deep links must resolve here instead.
 */
function eyatra_esim_browser_url() {
	return eyatra_esim_page_url( 'esim-packages', 'esim-packages' );
}

/**
 * The page a selected package is bought on: /esim-checkout/.
 */
function eyatra_esim_checkout_url() {
	return eyatra_esim_page_url( 'esim-checkout', 'esim-checkout' );
}

/**
 * Checkout URL for one package. The package id is what the checkout page looks
 * up server-side, so it is the only thing carried across the redirect.
 */
function eyatra_esim_checkout_url_for( $package_id ) {
	return add_query_arg( 'pkg', rawurlencode( (string) $package_id ), eyatra_esim_checkout_url() );
}

/* --------------------------------------------------------------- payment QR */

/**
 * Filesystem path and public URL for the FonePay QR.
 */
function eyatra_esim_qr_path() {
	return WP_CONTENT_DIR . '/' . EYATRA_ESIM_QR_RELATIVE;
}

function eyatra_esim_qr_url() {
	return content_url( EYATRA_ESIM_QR_RELATIVE );
}

/**
 * Payment instructions, one source of truth.
 *
 * Two routes to the same account: scan the FonePay QR, or transfer directly.
 * The account name is a different legal entity from the site name, so the
 * disclosure is part of the payment block rather than a footnote - a customer
 * seeing "eYatra" on a page and "Lotus Digital Technology Pvt. Ltd." on a bank
 * transfer is exactly the pattern that reads as payment interception.
 */
function eyatra_esim_payment_details() {
	$details = array(
		'company'        => 'Lotus Digital Technology Pvt. Ltd.',
		'disclosure'     => 'eYatra is a website of Lotus Digital Technology Pvt. Ltd. The account name below is ours.',
		'qr_url'         => eyatra_esim_qr_url(),
		'qr_file'        => eyatra_esim_qr_path(),
		'qr_wallets'     => 'eSewa, FonePay or any Nepalese banking app',
		'terminal'       => '2222110021662270',
		'bank'           => 'Sanima Bank Ltd.',
		'branch'         => 'Kantipath',
		'account_name'   => 'Lotus Digital Technology Pvt. Ltd.',
		'account_number' => '0750 1001 0000 922',
	);

	return apply_filters( 'eyatra_esim_payment_details', $details );
}

/**
 * Contact details shown beside the enquiry form.
 *
 * One source of truth: change the number here and every block that renders it
 * (the contact panel, and anything filtering `eyatra_esim_contact_details`)
 * updates at once. The office address and support hours that used to live here
 * were removed on request; if a real office address is supplied later, add an
 * `address` key and a matching branch in eyatra_esim_render_contact().
 */
function eyatra_esim_contact_details() {
	$details = array(
		'email'    => get_option( 'admin_email' ),
		'phone'    => '+9779812449811',
		'whatsapp' => '9779812449811',
	);

	return apply_filters( 'eyatra_esim_contact_details', $details );
}

/**
 * Digits-only version of a phone number, for tel: and wa.me links.
 * Strips spaces, dashes, brackets and a leading plus so "+977 98124 49811"
 * and "9779812449811" both become "9779812449811".
 */
function eyatra_esim_phone_digits( $number ) {
	return preg_replace( '/\D+/', '', (string) $number );
}

/**
 * Human-readable phone number, grouped for legibility: "+977 98124 49811".
 * Any digits that do not fit the expected shape are left untouched at the end
 * rather than mangled.
 */
function eyatra_esim_format_phone( $number ) {
	$digits = eyatra_esim_phone_digits( $number );

	if ( '' === $digits ) {
		return '';
	}

	// Country code + 10-digit national number, the shape this site uses.
	if ( 13 === strlen( $digits ) && 0 === strpos( $digits, '977' ) ) {
		return '+977 ' . substr( $digits, 3, 5 ) . ' ' . substr( $digits, 8 );
	}

	if ( 11 === strlen( $digits ) && 0 === strpos( $digits, '0' ) ) {
		return '+' . substr( $digits, 0, 3 ) . ' ' . substr( $digits, 3, 3 ) . ' ' . substr( $digits, 6 );
	}

	return $digits;
}

/**
 * The order form's post id, looked up by slug rather than hardcoded so a
 * re-created form cannot leave the shortcode pointing at nothing.
 *
 * The operator moved the order form to a new one in October 2026: post 2440,
 * slug `esim-package-order`, fields `customer-name` / `customer-email` /
 * `customer-phone` (was `your-*` on the older `esim-package-enquiry` form).
 */
function eyatra_esim_enquiry_form_id() {
	static $id = null;

	if ( null !== $id ) {
		return $id;
	}

	$id = 0;

	if ( ! post_type_exists( 'wpcf7_contact_form' ) ) {
		return $id;
	}

	$found = get_posts(
		array(
			'post_type'        => 'wpcf7_contact_form',
			'name'             => 'esim-package-order',
			'post_status'      => 'publish',
			'numberposts'      => 1,
			'suppress_filters' => true,
			'no_found_rows'    => true,
		)
	);

	if ( $found ) {
		$id = (int) $found[0]->ID;
	}

	return $id;
}

/**
 * Every string esim-browser.js writes outside the card itself: the count lines,
 * the empty states, the loading/error messages and the per-row formats the
 * script substitutes into them.
 *
 * Phase L moved these out of the script so they are editable in
 * wp-admin -> Plugins -> Plugin File Editor instead of inside a JS file. The
 * card's own static labels (Zone, Top-up, Buy, USD) are in templates/card.php,
 * next to the markup they label; only strings the script has to substitute a
 * value into ({dur}, {n}) live here.
 *
 * Placeholders replaced by the script: {shown}, {total}, {plural}, {ofTotal},
 * {dur}, {n}. Anything else in a value is output as-is - these strings are
 * written into innerHTML, so an edit may contain markup (the count lines use
 * <strong> and &middot;) but must never contain a value from the CSV; those go
 * through the script's textContent slots.
 */
function eyatra_esim_js_strings() {
	$strings = array(
		// Chrome around the grid.
		'loading'               => 'Loading package data&hellip;',
		'loadError'             => 'Package data could not be loaded. Please refresh the page or contact us.',
		'noResults'             => 'No packages found.',
		'emptyAll'              => 'No packages match those filters. Try widening your search.',
		'emptyFeatured'         => 'Our recommended list is empty right now.',
		'emptyFeaturedUpdating' => 'Our recommended list is being updated. Use the All packages tab to browse every package.',
		'emptyTeaserUpdating'   => 'Our recommended list is being updated.',
		'countAll'              => 'Showing <strong>{shown}</strong> of <strong>{total}</strong> package{plural} &middot; prices in USD',
		'countRecommended'      => 'Showing <strong>{shown}</strong> of <strong>{total}</strong> recommended package{plural} &middot; prices in USD',
		'countTeaser'           => 'Showing <strong>{shown}</strong>{ofTotal} recommended package{plural} &middot; prices in USD',
		// Per-row formats the script fills into the card's textContent slots.
		'valid'                 => 'Valid {dur}',
		'sms'                   => '{n} SMS',
		'voice'                 => '{n} voice mins',
		// Spaced middle dot, as a literal because the script joins with
		// textContent (an HTML entity would show up as raw text).
		'extrasSep'             => " \u{00B7} ",
		// Shown as the Buy link's title when checkoutUrl is missing from the
		// localised config: the anchor then has no href and cannot be clicked.
		'checkoutGone'          => 'Checkout is temporarily unavailable',
	);

	return apply_filters( 'eyatra_esim_js_strings', $strings );
}

/**
 * Enqueue browser assets, but only when a shortcode is actually on the page.
 */
function eyatra_esim_register_assets() {
	$base = plugins_url( 'assets/', __FILE__ );

	wp_register_style( 'eyatra-esim', $base . 'esim-browser.css', array(), EYATRA_ESIM_VERSION );
	wp_register_script( 'eyatra-esim', $base . 'esim-browser.js', array(), EYATRA_ESIM_VERSION, true );

	wp_localize_script(
		'eyatra-esim',
		'eyatraEsim',
		array(
			'csvUrl'      => eyatra_esim_csv_url(),
			'featuredUrl' => eyatra_esim_featured_csv_url(),
			'esimUrl'     => eyatra_esim_browser_url(),
			'checkoutUrl' => eyatra_esim_checkout_url(),
			'perPage'     => 60,
			'currency'    => 'USD',
			'symbol'      => '$',
			// Phase L: every user-visible string the script used to hardcode
			// now comes from PHP, so it can be edited without touching JS.
			'strings'     => eyatra_esim_js_strings(),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'eyatra_esim_register_assets' );

/**
 * Enqueue on pages using either shortcode, up-front so CSS lands in <head>
 * rather than being flushed late by the shortcode.
 */
function eyatra_esim_maybe_enqueue() {
	if ( ! is_page() ) {
		return;
	}

	$post = get_post();
	if ( ! $post ) {
		return;
	}

	// has_shortcode() also matches text inside HTML comments, which previously
	// kept wd-maps.js loading on the homepage. Strip comments before testing.
	$content = preg_replace( '/<!--.*?-->/s', '', (string) $post->post_content );

	if ( has_shortcode( $content, 'esim_browser' )
		|| has_shortcode( $content, 'esim_recommended' )
		|| has_shortcode( $content, 'esim_checkout' )
		|| has_shortcode( $content, 'esim_buy_cta' ) ) {
		wp_enqueue_style( 'eyatra-esim' );
	}

	// Phase L: the checkout page deliberately gets no eSIM script. Its payment
	// block is rendered visible by PHP and the wpcf7mailsent reveal listener
	// no longer exists, so the only script the catalogue and the teaser need
	// is the one that filters the CSV - loading it on checkout would just be
	// dead weight over a payment page.
	if ( has_shortcode( $content, 'esim_browser' )
		|| has_shortcode( $content, 'esim_recommended' )
		|| has_shortcode( $content, 'esim_buy_cta' ) ) {
		wp_enqueue_script( 'eyatra-esim' );
	}
}
add_action( 'wp_enqueue_scripts', 'eyatra_esim_maybe_enqueue', 20 );

/**
 * Render the contact-details block. Any empty field shows a marked
 * placeholder rather than vanishing, so the gap is visible.
 */
function eyatra_esim_render_contact( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'title' => 'Talk to a person',
			'note'  => 'Enquiries are answered by our team, usually the same working day.',
		)
	);

	$details = eyatra_esim_contact_details();

	ob_start();
	?>
	<div class="ey-esim-contact">
		<h4><?php echo esc_html( $args['title'] ); ?></h4>

		<?php if ( $args['note'] ) : ?>
			<p class="ey-esim-contact-note"><?php echo esc_html( $args['note'] ); ?></p>
		<?php endif; ?>

		<ul class="ey-esim-contact-list">
			<?php if ( ! empty( $details['email'] ) ) : ?>
				<li>
					<span class="ey-esim-contact-key">Email</span>
					<a href="<?php echo esc_url( 'mailto:' . $details['email'] ); ?>"><?php echo esc_html( $details['email'] ); ?></a>
				</li>
			<?php endif; ?>

			<?php if ( ! empty( $details['phone'] ) ) : ?>
				<li>
					<span class="ey-esim-contact-key">Phone</span>
					<a href="<?php echo esc_url( 'tel:' . eyatra_esim_phone_digits( $details['phone'] ) ); ?>"><?php echo esc_html( eyatra_esim_format_phone( $details['phone'] ) ); ?></a>
				</li>
			<?php endif; ?>

			<?php if ( ! empty( $details['whatsapp'] ) ) : ?>
				<li>
					<span class="ey-esim-contact-key">WhatsApp</span>
					<a href="<?php echo esc_url( 'https://wa.me/' . eyatra_esim_phone_digits( $details['whatsapp'] ) ); ?>" rel="noopener nofollow" target="_blank"><?php echo esc_html( eyatra_esim_format_phone( $details['whatsapp'] ) ); ?></a>
				</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * The payment block: FonePay QR plus the bank transfer details.
 *
 * Phase L: rendered permanently visible. It used to ship with [hidden] and be
 * revealed by a wpcf7mailsent listener in esim-browser.js once the order form
 * reported a successful send. That reveal was ordering only, never a security
 * boundary - the markup was in the page source either way (see J-3 in
 * PROGRESS.md) - and on request the block now shows from page load, which also
 * removed the last reason the checkout page loads the eSIM script.
 */
function eyatra_esim_render_payment() {
	$pay = eyatra_esim_payment_details();

	$has_qr = ! empty( $pay['qr_url'] ) && file_exists( $pay['qr_file'] );

	ob_start();
	?>
	<div id="esim-payment" class="ey-esim-payment">
		<h3>Pay for your package</h3>

		<?php if ( '' !== (string) $pay['disclosure'] ) : ?>
			<p class="ey-esim-payment-disclosure"><?php echo esc_html( $pay['disclosure'] ); ?></p>
		<?php endif; ?>

		<div class="ey-esim-payment-options">
			<?php if ( $has_qr ) : ?>
				<div class="ey-esim-payment-option ey-esim-payment-option--qr">
					<h4>Scan to pay</h4>

					<img class="ey-esim-qr"
						src="<?php echo esc_url( $pay['qr_url'] ); ?>"
						alt="<?php echo esc_attr( 'FonePay payment QR for ' . $pay['account_name'] . ', ' . $pay['bank'] ); ?>"
						width="600" height="900" loading="lazy" decoding="async">

					<p class="ey-esim-payment-hint">
						Scan with <?php echo esc_html( $pay['qr_wallets'] ); ?>.
					</p>

					<?php if ( '' !== (string) $pay['terminal'] ) : ?>
						<p class="ey-esim-payment-terminal">
							Terminal <code><?php echo esc_html( $pay['terminal'] ); ?></code>
						</p>
					<?php endif; ?>
				</div>
			<?php else : ?>
				<p class="ey-esim-error">
					The payment QR could not be loaded. Please use the bank transfer
					details below, or email us and we will send the QR.
				</p>
			<?php endif; ?>

			<div class="ey-esim-payment-option ey-esim-payment-option--bank">
				<h4>Bank transfer</h4>

				<dl class="ey-esim-bank">
					<dt>Bank</dt>
					<dd><?php echo esc_html( $pay['bank'] ); ?></dd>

					<dt>Branch</dt>
					<dd><?php echo esc_html( $pay['branch'] ); ?></dd>

					<dt>Account name</dt>
					<dd><?php echo esc_html( $pay['account_name'] ); ?></dd>

					<dt>Account number</dt>
					<dd><code><?php echo esc_html( $pay['account_number'] ); ?></code></dd>
				</dl>
			</div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Default attributes for [esim_buy_cta].
 *
 * One source of truth, read by two consumers:
 *   1. eyatra_esim_buy_cta_shortcode() below, via shortcode_atts().
 *   2. eyatra-esim-vc.php, to build the WPBakery element map.
 *
 * They must agree exactly. WPBakery re-serialises a mapped shortcode by writing
 * out only the fields whose value differs from the map's default, so a field
 * left blank in the builder would be dropped from the saved shortcode and the
 * PHP default would take over. If the two defaults ever drifted, a heading the
 * editor had cleared would come back from PHP instead of staying empty - the
 * one failure mode the builder cannot show you.
 *
 * Filterable so copy can be changed without touching either file.
 */
function eyatra_esim_buy_cta_defaults() {
	$defaults = array(
		'heading' => 'Buy your eSIM package',
		'sub'     => 'Live pricing across 209 countries and 6 regional zones. Browse every package we sell, then pay by QR or bank transfer.',
		'button'  => 'Browse all eSIM packages',
		'note'    => 'Recommended packages first, with every package available under All packages.',
	);

	return apply_filters( 'eyatra_esim_buy_cta_defaults', $defaults );
}

/**
 * Render the [esim_buy_cta] shortcode - the landing page's purchase section.
 *
 * The catalogue used to be inlined here behind a "Find your eSIM package" heading.
 * It now lives on its own page so the landing page is not a 4,071-row
 * catalogue, and this section is a single button into that page.
 */
function eyatra_esim_buy_cta_shortcode( $atts ) {
	$atts = shortcode_atts( eyatra_esim_buy_cta_defaults(), $atts, 'esim_buy_cta' );

	wp_enqueue_style( 'eyatra-esim' );

	ob_start();
	?>
	<section class="eyatra-esim ey-esim-buy-cta" id="esim-buy-cta">
		<?php if ( '' !== $atts['heading'] || '' !== $atts['sub'] ) : ?>
			<header class="ey-esim-head">
				<?php if ( '' !== $atts['heading'] ) : ?>
					<h2><?php echo esc_html( $atts['heading'] ); ?></h2>
				<?php endif; ?>

				<?php if ( '' !== $atts['sub'] ) : ?>
					<p class="ey-esim-sub"><?php echo esc_html( $atts['sub'] ); ?></p>
				<?php endif; ?>
			</header>
		<?php endif; ?>

		<p class="ey-esim-buy-cta-action">
			<a class="ey-btn" href="<?php echo esc_url( eyatra_esim_browser_url() ); ?>">
				<?php echo esc_html( $atts['button'] ); ?>
			</a>
		</p>

		<?php if ( $atts['note'] ) : ?>
			<p class="ey-esim-buy-cta-note"><?php echo esc_html( $atts['note'] ); ?></p>
		<?php endif; ?>
	</section>
	<?php
	return ob_get_clean();
}
add_shortcode( 'esim_buy_cta', 'eyatra_esim_buy_cta_shortcode' );

/**
 * Default attributes for [esim_checkout]. See eyatra_esim_buy_cta_defaults()
 * for why this has to be one source of truth shared with the WPBakery map.
 */
function eyatra_esim_checkout_defaults() {
	$defaults = array(
		'heading' => 'Complete your order',
	);

	return apply_filters( 'eyatra_esim_checkout_defaults', $defaults );
}

/**
 * Render the [esim_checkout] shortcode: summary, contact form, payment block.
 *
 * The package arrives as ?pkg=<package_id>. It is resolved against packages.csv
 * here, on the server, and an unrecognised id renders a "not recognised" state
 * rather than an order. The summary is the authoritative price: the same values
 * are re-derived server-side on submission by
 * eyatra_esim_rederive_posted_package_data(), so a tampered hidden field cannot
 * change what the operator is told to expect.
 */
function eyatra_esim_render_checkout( $atts ) {
	$atts = shortcode_atts( eyatra_esim_checkout_defaults(), $atts, 'esim_checkout' );

	// Style only: Phase L removed the script from the checkout page - the
	// summary is PHP and the payment block is now visible without a listener.
	wp_enqueue_style( 'eyatra-esim' );

	$requested = eyatra_esim_requested_package_id();
	$package   = eyatra_esim_find_package( $requested );
	$form_id   = eyatra_esim_enquiry_form_id();

	if ( ! file_exists( eyatra_esim_csv_path() ) ) {
		return '<div class="ey-esim-error">Package data is unavailable right now. Please try again shortly.</div>';
	}

	ob_start();
	?>
	<section class="eyatra-esim ey-esim-checkout" id="esim-checkout">
		<?php if ( '' !== $atts['heading'] ) : ?>
			<header class="ey-esim-head">
				<h2><?php echo esc_html( $atts['heading'] ); ?></h2>
			</header>
		<?php endif; ?>

		<?php if ( ! $package ) : ?>
			<div class="ey-esim-empty">
				<?php if ( '' === $requested ) : ?>
					<p>No package selected yet.</p>
				<?php else : ?>
					<p>
						We could not match that package. It may have been renamed or removed
						from the catalogue.
					</p>
				<?php endif; ?>
				<p>
					<a class="ey-btn" href="<?php echo esc_url( eyatra_esim_browser_url() ); ?>">
						Browse all eSIM packages
					</a>
				</p>
			</div>
		<?php else : ?>
			<h3 class="ey-esim-checkout-title">Your package</h3>

			<dl class="ey-esim-summary">
				<dt>Destination</dt>
				<dd><?php echo esc_html( $package['country'] ); ?></dd>

				<dt>Data</dt>
				<dd><?php echo esc_html( $package['data'] ); ?></dd>

				<?php if ( $package['dur'] ) : ?>
					<dt>Validity</dt>
					<dd><?php echo esc_html( $package['dur'] ); ?></dd>
				<?php endif; ?>

				<?php if ( eyatra_esim_net_label( $package['net'] ) ) : ?>
					<dt>Networks</dt>
					<dd><?php echo esc_html( eyatra_esim_net_label( $package['net'] ) ); ?></dd>
				<?php endif; ?>

				<dt>Package ID</dt>
				<dd><code><?php echo esc_html( $package['pkg'] ); ?></code></dd>

				<dt class="ey-esim-summary-price">Total</dt>
				<dd class="ey-esim-summary-price"><?php echo esc_html( eyatra_esim_price_label( $package ) ); ?></dd>
			</dl>

			<h3 class="ey-esim-checkout-title">Your details</h3>

			<div class="ey-esim-checkout-form" id="esim-checkout-form">
				<?php if ( $form_id ) : ?>
					<?php echo do_shortcode( '[contact-form-7 id="' . (int) $form_id . '" html_id="ey-esim-order-form"]' ); ?>
				<?php else : ?>
					<p class="ey-esim-error">
						The order form could not be loaded. Please email us from the
						contact details below.
					</p>
				<?php endif; ?>
			</div>

			<?php echo eyatra_esim_render_payment(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in the helper ?>

			<?php
			echo eyatra_esim_render_contact( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in the helper
				array(
					'title' => 'Questions before you pay?',
					'note'  => 'Send us a message and we will help you pick the right package.',
				)
			);
			?>
		<?php endif; ?>
	</section>
	<?php
	return ob_get_clean();
}
add_shortcode( 'esim_checkout', 'eyatra_esim_render_checkout' );

/**
 * Re-derive the hidden package fields server-side on every submission.
 *
 * The checkout form posts esim-destination / esim-package / esim-data /
 * esim-duration / esim-price, which is what the notification email quotes. Those
 * values are all attacker-controlled in the POST body, so they are overwritten
 * here from ?pkg= looked up in packages.csv. The result is that the email can
 * only ever describe a real catalogue price for a real package id.
 */
function eyatra_esim_rederive_posted_package_data( $posted ) {
	$package_id = eyatra_esim_requested_package_id();

	// CF7 posts to /wp-json/.../feedback, so ?pkg= is not in $_GET here.
	// Fall back to the hidden field Step 1 filled at render time. It is only
	// ever a lookup key into packages.csv - every field below is overwritten
	// from that row, so edited input can select a real package but can never
	// put free text into the mail.
	if ( '' === $package_id && isset( $_POST['esim-package'] ) && ! is_array( $_POST['esim-package'] ) ) {
		$package_id = sanitize_text_field( wp_unslash( $_POST['esim-package'] ) );
	}

	$package = eyatra_esim_find_package( $package_id );

	if ( ! $package ) {
		return $posted;
	}

	$posted['esim-package']     = $package['pkg'];
	$posted['esim-destination'] = $package['country'];
	$posted['esim-data']        = $package['data'];
	$posted['esim-duration']    = $package['dur'];
	$posted['esim-price']       = eyatra_esim_price_label( $package );

	return $posted;
}
add_filter( 'wpcf7_posted_data', 'eyatra_esim_rederive_posted_package_data' );

/**
 * Fill the checkout form's hidden package fields at render time.
 *
 * The five [hidden esim-*] fields ship with empty defaults, and CF7 submits
 * via the REST endpoint, so ?pkg= is gone by the time the mail is assembled.
 * Writing the catalogue values into the inputs here means the posted data
 * already describes the package; eyatra_esim_rederive_posted_package_data()
 * then re-derives the same values from the posted id as a tamper check.
 */
function eyatra_esim_fill_hidden_package_fields( $scanned_tag ) {
	if ( empty( $scanned_tag['name'] ) || 'hidden' !== $scanned_tag['basetype'] ) {
		return $scanned_tag;
	}

	$map = array(
		'esim-destination' => 'country',
		'esim-package'     => 'pkg',
		'esim-data'        => 'data',
		'esim-duration'    => 'dur',
		'esim-price'       => 'price',
	);

	if ( ! isset( $map[ $scanned_tag['name'] ] ) ) {
		return $scanned_tag;
	}

	static $package = false;

	if ( false === $package ) {
		$package = eyatra_esim_find_package( eyatra_esim_requested_package_id() );
	}

	if ( ! $package ) {
		return $scanned_tag;
	}

	$field = $map[ $scanned_tag['name'] ];
	$value = ( 'price' === $field )
		? eyatra_esim_price_label( $package )
		: (string) $package[ $field ];

	$scanned_tag['values']     = array( $value );
	$scanned_tag['raw_values'] = array( $value );

	return $scanned_tag;
}
add_filter( 'wpcf7_form_tag', 'eyatra_esim_fill_hidden_package_fields', 10, 1 );

/**
 * Default attributes for [esim_browser]. See eyatra_esim_buy_cta_defaults()
 * for why this has to be one source of truth shared with the WPBakery map.
 */
function eyatra_esim_browser_defaults() {
	$defaults = array(
		'heading' => 'Choose your eSIM package',
		'sub'     => 'Live pricing across 209 countries and 6 regional zones. Prices in USD.',
	);

	return apply_filters( 'eyatra_esim_browser_defaults', $defaults );
}

/**
 * Print the <template data-esim-card> element esim-browser.js clones for every
 * card. The markup itself is templates/card.php - the file to edit to change
 * what a card looks like.
 *
 * Called by both card-producing shortcodes. Printing it once per call (rather
 * than at most once per request) keeps every render of a shortcode identical:
 * a static "already printed" flag would silently strip the template from the
 * second call in the same request, which is exactly the kind of
 * works-the-first-time difference suites cannot see coming. Duplicates are
 * harmless - the script clones document.querySelector()'s first template, and
 * a page carrying both shortcodes would render both sections from it.
 *
 * Placement matters: it must sit OUTSIDE #esim-results and #esim-featured,
 * because apply()/renderTeaser() empty those containers on every filter change
 * and would delete the template with them. esim-browser.js logs a console
 * error if a page that needs the template does not carry it.
 */
function eyatra_esim_card_template() {
	$file = __DIR__ . '/templates/card.php';

	if ( ! file_exists( $file ) ) {
		return '';
	}

	ob_start();
	include $file;

	return ob_get_clean();
}

/**
 * Render the [esim_browser] shortcode.
 */
function eyatra_esim_browser_shortcode( $atts ) {
	$atts = shortcode_atts( eyatra_esim_browser_defaults(), $atts, 'esim_browser' );

	wp_enqueue_style( 'eyatra-esim' );
	wp_enqueue_script( 'eyatra-esim' );

	if ( ! file_exists( eyatra_esim_csv_path() ) ) {
		return '<div class="ey-esim-error">Package data is unavailable right now. Please try again shortly.</div>';
	}

	ob_start();
	?>
	<section class="eyatra-esim" id="esim-browser">
		<?php if ( '' !== $atts['heading'] || '' !== $atts['sub'] ) : ?>
			<header class="ey-esim-head">
				<?php if ( '' !== $atts['heading'] ) : ?>
					<h2><?php echo esc_html( $atts['heading'] ); ?></h2>
				<?php endif; ?>

				<?php if ( '' !== $atts['sub'] ) : ?>
					<p class="ey-esim-sub"><?php echo esc_html( $atts['sub'] ); ?></p>
				<?php endif; ?>
			</header>
		<?php endif; ?>

		<div class="ey-esim-tabs" id="esim-tabs" role="tablist" aria-label="Package lists">
			<button type="button" class="ey-esim-tab is-active" id="esim-tab-featured"
				role="tab" aria-selected="true" aria-controls="esim-results" data-view="featured">
				Recommended
			</button>
			<button type="button" class="ey-esim-tab" id="esim-tab-all"
				role="tab" aria-selected="false" aria-controls="esim-results" data-view="all">
				All packages
			</button>
		</div>

		<form class="ey-esim-filters" id="esim-filters" onsubmit="return false;">
			<fieldset class="ey-esim-filter-row">
				<legend class="screen-reader-text">Search and destination</legend>
				<div class="ey-esim-field">
					<label for="esim-q">Search</label>
					<input type="search" id="esim-q" placeholder="Country or package ID&hellip;" autocomplete="off">
				</div>

				<div class="ey-esim-field">
					<label for="esim-dest">Destination</label>
					<select id="esim-dest"><option value="">Loading&hellip;</option></select>
				</div>
			</fieldset>

			<fieldset class="ey-esim-filter-row">
				<legend class="screen-reader-text">Package attributes</legend>
				<div class="ey-esim-field">
					<label for="esim-data">Data allowance</label>
					<select id="esim-data"><option value="">All data</option></select>
				</div>

				<div class="ey-esim-field">
					<label for="esim-type">Package type</label>
					<select id="esim-type">
						<option value="New eSIM" selected>New eSIM</option>
						<option value="Top-up">Top-up</option>
						<option value="">All types</option>
					</select>
				</div>
			</fieldset>

			<fieldset class="ey-esim-filter-row">
				<legend class="screen-reader-text">Sorting and reset</legend>
				<div class="ey-esim-field">
					<label for="esim-sort">Sort by</label>
					<select id="esim-sort">
						<option value="price">Price: low to high</option>
						<option value="pricedesc">Price: high to low</option>
						<option value="data">Data allowance</option>
						<option value="country">Destination (A&ndash;Z)</option>
					</select>
				</div>

				<div class="ey-esim-field ey-esim-field-reset">
					<button type="button" class="ey-esim-reset" id="esim-reset">Reset</button>
				</div>
			</fieldset>
		</form>

		<p class="ey-esim-count" id="esim-count" role="status" aria-live="polite">Loading package data&hellip;</p>

		<div class="ey-esim-results" id="esim-results"></div>

		<?php echo eyatra_esim_card_template(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- raw markup from templates/card.php ?>

		<button type="button" class="ey-esim-more" id="esim-more" hidden>Show more packages</button>
	</section>
	<?php
	return ob_get_clean();
}
add_shortcode( 'esim_browser', 'eyatra_esim_browser_shortcode' );

/**
 * Default attributes for [esim_recommended]. See eyatra_esim_buy_cta_defaults()
 * for why this has to be one source of truth shared with the WPBakery map.
 */
function eyatra_esim_recommended_defaults() {
	$defaults = array(
		'heading' => 'Recommended eSIM packages',
		'sub'     => 'The plans we suggest most often, across our busiest destinations.',
		// A string, not an int, because WPBakery field values are always strings
		// and vc_map_get_defaults() is compared against these defaults verbatim.
		// An int here would read as "changed" on every builder save and write
		// limit="12" explicitly. The renderer casts with (int) before printing.
		'limit'   => '12',
		'button'  => 'Browse all packages',
	);

	return apply_filters( 'eyatra_esim_recommended_defaults', $defaults );
}

/**
 * Render the [esim_recommended] shortcode - a compact preview of the curated
 * list for pages that are not the full browser.
 *
 * Each card's Buy deep-links into the browser with that destination already
 * applied, so the teaser never becomes a dead end.
 */
function eyatra_esim_recommended_shortcode( $atts ) {
	$atts = shortcode_atts( eyatra_esim_recommended_defaults(), $atts, 'esim_recommended' );

	wp_enqueue_style( 'eyatra-esim' );
	wp_enqueue_script( 'eyatra-esim' );

	if ( ! file_exists( eyatra_esim_csv_path() ) || ! file_exists( eyatra_esim_featured_csv_path() ) ) {
		return '';
	}

	ob_start();
	?>
	<section class="eyatra-esim ey-esim-teaser" id="esim-recommended" data-limit="<?php echo esc_attr( (int) $atts['limit'] ); ?>">
		<?php if ( '' !== $atts['heading'] || '' !== $atts['sub'] ) : ?>
			<header class="ey-esim-head">
				<?php if ( '' !== $atts['heading'] ) : ?>
					<h2><?php echo esc_html( $atts['heading'] ); ?></h2>
				<?php endif; ?>

				<?php if ( '' !== $atts['sub'] ) : ?>
					<p class="ey-esim-sub"><?php echo esc_html( $atts['sub'] ); ?></p>
				<?php endif; ?>
			</header>
		<?php endif; ?>

		<p class="ey-esim-count" id="esim-featured-count" role="status" aria-live="polite">Loading&hellip;</p>

		<div class="ey-esim-results" id="esim-featured"></div>

		<?php echo eyatra_esim_card_template(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- raw markup from templates/card.php ?>

		<p class="ey-esim-teaser-cta">
			<a class="ey-btn" href="<?php echo esc_url( eyatra_esim_browser_url() ); ?>">
				<?php echo esc_html( $atts['button'] ); ?>
			</a>
		</p>
	</section>
	<?php
	return ob_get_clean();
}
add_shortcode( 'esim_recommended', 'eyatra_esim_recommended_shortcode' );

// The WPBakery element maps live in their own file so the dashboard's Plugin
// File Editor can open each of them at a comfortable size. Required here, at
// the very end, so every shortcode and helper above exists before the map
// builders read the defaults.
require_once __DIR__ . '/eyatra-esim-vc.php';