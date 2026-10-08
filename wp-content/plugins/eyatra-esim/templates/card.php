<?php
/**
 * The package card, as a <template> element that esim-browser.js clones once
 * per row and fills from the CSV.
 *
 * This file IS the card UI: change the element order, the classes the
 * stylesheet targets, or the static labels (Zone, Top-up, Buy, USD) here and
 * the change shows on /esim-packages/ and the [esim_recommended] teaser with
 * no JavaScript edit. It is editable in wp-admin -> Plugins -> Plugin File
 * Editor alongside this plugin's other files.
 *
 * Two rules if you change it:
 *
 *   1. Keep every data-esim="..." slot the script fills: country, data, net,
 *      price, dur, extras, badge-zone, badge-topup, buy. The script toggles
 *      `hidden` on the optional slots (badges, duration, extras) per row, so
 *      leave them in the markup even when a row rarely shows them.
 *
 *   2. This template is printed OUTSIDE #esim-results / #esim-featured - the
 *      script empties those containers on every filter change and would delete
 *      the template with them (eyatra_esim_card_template() places it).
 *
 * Parameterised copy is NOT here but in eyatra_esim_js_strings() in
 * ../eyatra-esim.php, because the script has to substitute a value per row:
 * "Valid {dur}", "{n} SMS", the count lines and the empty states. The card's
 * own words - Zone, Top-up, Buy, USD - live right below, next to the markup
 * they label.
 *
 * The script logs a console error if this element is missing from the page.
 */
?>
<template data-esim-card>
	<article class="ey-esim-card">
		<div class="ey-esim-card-top">
			<div class="ey-esim-dest" data-esim="country"></div>
			<span class="ey-esim-badge ey-esim-badge--zone" data-esim="badge-zone" hidden>Zone</span>
			<span class="ey-esim-badge ey-esim-badge--topup" data-esim="badge-topup" hidden>Top-up</span>
		</div>
		<div class="ey-esim-data" data-esim="data"></div>
		<div class="ey-esim-meta">
			<span data-esim="dur" hidden></span>
			<span data-esim="extras" hidden></span>
		</div>
		<div class="ey-esim-net" data-esim="net"></div>
		<div class="ey-esim-card-foot">
			<div class="ey-esim-price"><span data-esim="price"></span> <small>USD</small></div>
			<a class="ey-esim-buy" data-esim="buy">Buy</a>
		</div>
	</article>
</template>
