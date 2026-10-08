/**
 * eYatra eSIM package browser.
 *
 * Loads the full package CSV once, then filters client-side. 4,071 rows are
 * never all rendered at once - cards are appended in pages of `perPage` and
 * revealed by the "Show more" button.
 *
 * Two modes, picked from the markup:
 *   browser  - the full [esim_browser] block on /esim-packages/, with
 *              Recommended / All tabs. Buy is a link to the checkout page.
 *   teaser   - the compact [esim_recommended] preview, which renders only the
 *              curated list and deep-links into the browser.
 *
 * The card markup is NOT built here. It is the <template data-esim-card>
 * printed by eyatra_esim_card_template() from templates/card.php, cloned once
 * per row and filled into the [data-esim] slots - that file is editable in
 * wp-admin -> Plugins -> Plugin File Editor, so card markup and card labels
 * change there, not in this file. The words around the cards (count lines,
 * empty states, loading and error messages, the per-row formats) come from
 * eyatraEsim.strings, i.e. eyatra_esim_js_strings() in PHP for the same reason.
 *
 * The checkout page does not load this script at all: its summary and payment
 * block are PHP, and the payment block is visible from page load (Phase L - it
 * used to be revealed by a wpcf7mailsent listener; that listener, the
 * sessionStorage flag and the data-esim-form keying are all gone with it).
 *
 * The curated list lives in uploads/esim/best-sellers.csv and is hand-editable.
 * Every id in it is asserted against packages.csv by
 * _backup/phase-C/check_featured.php, because a typo drops a card silently.
 */
( function () {
	'use strict';

	var cfg = window.eyatraEsim || {};
	var PER_PAGE = cfg.perPage || 60;
	var SYMBOL = cfg.symbol || '$';
	var S = cfg.strings || {};

	var el = {
		q:           document.getElementById( 'esim-q' ),
		dest:        document.getElementById( 'esim-dest' ),
		data:        document.getElementById( 'esim-data' ),
		type:        document.getElementById( 'esim-type' ),
		sort:        document.getElementById( 'esim-sort' ),
		reset:       document.getElementById( 'esim-reset' ),
		count:       document.getElementById( 'esim-count' ),
		results:     document.getElementById( 'esim-results' ),
		more:        document.getElementById( 'esim-more' ),
		tabs:        document.getElementById( 'esim-tabs' ),
		teaser:      document.getElementById( 'esim-recommended' ),
		teaserCount: document.getElementById( 'esim-featured-count' ),
		teaserList:  document.getElementById( 'esim-featured' )
	};

	var MODE = el.results ? 'browser' : ( el.teaserList ? 'teaser' : null );

	if ( ! MODE ) {
		return;
	}

	// The card markup lives in PHP (templates/card.php, printed by
	// eyatra_esim_card_template()). Without it the page would show counts over
	// an empty grid, so stop here and say why instead of failing per card.
	var cardTpl = document.querySelector( 'template[data-esim-card]' );

	if ( ! cardTpl ) {
		if ( window.console ) {
			window.console.error( '[eYatra eSIM] <template data-esim-card> is missing - templates/card.php did not render.' );
		}
		return;
	}

	var DEFAULT_TYPE = 'New eSIM';

	var rows = [];
	var byPkg = {};
	var featured = [];
	var filtered = [];
	var shown = 0;
	var view = 'featured';
	var loadFailed = false;
	var featuredFailed = false;

	/* ---------------------------------------------------------------- utils */

	/**
	 * Replace {placeholders} in a PHP-supplied string (eyatraEsim.strings).
	 * Values go in as text via textContent - never innerHTML - so a CSV value
	 * cannot inject markup. Unknown keys are left literal so a typo in PHP
	 * shows up on the page instead of silently vanishing.
	 */
	function fillStr( template, vars ) {
		return String( template == null ? '' : template ).replace( /\{(\w+)\}/g, function ( m, key ) {
			return Object.prototype.hasOwnProperty.call( vars, key ) ? vars[ key ] : m;
		} );
	}

	/**
	 * Split a CSV line, honouring double-quote escaping.
	 * Avoids a full CSV library for a file with a known, simple shape.
	 */
	function parseLine( line ) {
		var out = [];
		var cur = '';
		var inQuotes = false;

		for ( var i = 0; i < line.length; i++ ) {
			var ch = line.charAt( i );

			if ( inQuotes ) {
				if ( ch === '"' ) {
					if ( line.charAt( i + 1 ) === '"' ) {
						cur += '"';
						i++;
					} else {
						inQuotes = false;
					}
				} else {
					cur += ch;
				}
			} else if ( ch === '"' ) {
				inQuotes = true;
			} else if ( ch === ',' ) {
				out.push( cur );
				cur = '';
			} else {
				cur += ch;
			}
		}

		out.push( cur );
		return out;
	}

	/** header name -> column index */
	function headerIndex( header ) {
		var idx = {};
		header.forEach( function ( name, i ) {
			idx[ name.trim() ] = i;
		} );
		return idx;
	}

	/** Convert "200 MB" -> 0.195, "5 GB" -> 5, "Unlimited" -> 1000000 */
	function dataRank( label ) {
		if ( /unlimited/i.test( label ) ) {
			return 1000000;
		}
		var m = /(\d+(?:\.\d+)?)\s*(kb|mb|gb|tb)/i.exec( label );
		if ( ! m ) {
			return 0;
		}
		var mult = { kb: 1 / 1048576, mb: 1 / 1024, gb: 1, tb: 1024 }[ m[ 2 ].toLowerCase() ];
		return parseFloat( m[ 1 ] ) * mult;
	}

	/**
	 * The source workbook ends zone network strings with a truncated
	 * partner-link marker, so cards render "134 networks supported - Learn more
	 * on Partner". Cut it back to the useful part.
	 */
	function netLabel( net ) {
		return String( net == null ? '' : net )
			.replace( /\s*-\s*Learn more on Partner\b.*$/i, '' )
			.trim();
	}

	function fetchText( url ) {
		return fetch( url, { cache: 'force-cache' } ).then( function ( res ) {
			if ( ! res.ok ) {
				throw new Error( 'HTTP ' + res.status );
			}
			return res.text();
		} );
	}

	/** Read ?dest= / ?type= so teaser cards can deep-link into a filtered browser. */
	function readQuery() {
		var out = {};
		var raw = ( window.location.search || '' ).replace( /^\?/, '' );

		if ( ! raw ) {
			return out;
		}

		raw.split( '&' ).forEach( function ( pair ) {
			if ( ! pair ) {
				return;
			}
			var i = pair.indexOf( '=' );
			if ( i < 1 ) {
				return;
			}
			try {
				out[ decodeURIComponent( pair.slice( 0, i ) ) ] =
					decodeURIComponent( pair.slice( i + 1 ).replace( /\+/g, ' ' ) );
			} catch ( e ) {
				/* a malformed query string must not stop the page working */
			}
		} );

		return out;
	}

	function withQuery( url, key, value ) {
		return url + ( url.indexOf( '?' ) === -1 ? '?' : '&' ) +
			encodeURIComponent( key ) + '=' + encodeURIComponent( value );
	}

	/* --------------------------------------------------------------- loading */

	function parsePackages( text ) {
		var lines = text.split( /\r?\n/ );
		var idx = headerIndex( parseLine( lines.shift() || '' ) );
		var out = [];

		lines.forEach( function ( line ) {
			if ( ! line.trim() ) {
				return;
			}
			var c = parseLine( line );
			if ( c.length < Object.keys( idx ).length ) {
				return;
			}
			var row = {
				country: c[ idx.country ],
				pkg: c[ idx.package_id ],
				type: c[ idx.type ],
				price: parseFloat( c[ idx.price_usd ] ) || 0,
				data: c[ idx.data ],
				sms: parseInt( c[ idx.sms ], 10 ) || 0,
				voice: parseInt( c[ idx.voice ], 10 ) || 0,
				net: c[ idx.networks ],
				dur: c[ idx.duration ],
				kind: c[ idx.kind ]
			};
			row.pkg = String( row.pkg || '' ).trim();
			out.push( row );
			byPkg[ row.pkg ] = row;
		} );

		return out;
	}

	function parseFeatured( text ) {
		var lines = text.split( /\r?\n/ );
		var idx = headerIndex( parseLine( lines.shift() || '' ) );

		// Compare against the key's presence, not its value: headerIndex stores
		// the column INDEX, so 'package_id' === idx.package_id is never true.
		if ( ! Object.prototype.hasOwnProperty.call( idx, 'package_id' ) ) {
			throw new Error( 'best-sellers.csv header must contain package_id' );
		}

		var out = [];

		lines.forEach( function ( line ) {
			if ( ! line.trim() ) {
				return;
			}
			var c = parseLine( line );
			var id = String( c[ idx.package_id ] || '' ).trim();
			if ( ! id ) {
				return;
			}
			var rank = parseInt( c[ idx.rank ], 10 );
			out.push( {
				rank: isNaN( rank ) ? out.length + 1 : rank,
				id: id
			} );
		} );

		out.sort( function ( a, b ) {
			return a.rank - b.rank;
		} );

		return out;
	}

	/** Curated rows, in file order. Ids that no longer resolve are skipped. */
	function featuredRows() {
		var out = [];

		featured.forEach( function ( f ) {
			if ( byPkg[ f.id ] ) {
				out.push( byPkg[ f.id ] );
			} else if ( window.console ) {
				window.console.warn( '[eYatra eSIM] featured id not in packages.csv:', f.id );
			}
		} );

		return out;
	}

	function load() {
		var target = el.results || el.teaserList;
		target.innerHTML = '<div class="ey-esim-loading">' + S.loading + '</div>';

		fetchText( cfg.csvUrl )
			.then( parsePackages )
			.then( function ( parsed ) {
				rows = parsed;

				return fetchText( cfg.featuredUrl )
					.then( parseFeatured )
					.then( function ( list ) {
						featured = list;
					} )
					.catch( function ( err ) {
						// A bad or missing recommendations file must never break
						// the page: fall back to the full catalogue.
						featuredFailed = true;
						if ( window.console ) {
							window.console.error( '[eYatra eSIM] recommendations unavailable, using all packages:', err );
						}
					} );
			} )
			.then( function () {
				start();
			} )
			.catch( function ( err ) {
				loadFailed = true;
				target.innerHTML =
					'<div class="ey-esim-error">' + S.loadError + '</div>';
				if ( el.count ) {
					el.count.textContent = '';
				}
				if ( el.teaserCount ) {
					el.teaserCount.textContent = '';
				}
				if ( window.console ) {
					window.console.error( '[eYatra eSIM] load failed:', err );
				}
			} );
	}

	function start() {
		if ( 'teaser' === MODE ) {
			renderTeaser();
			return;
		}

		buildFilters();

		// If the recommendations file is unusable, show the catalogue rather
		// than an empty shortlist with a note asking the visitor to click tabs.
		if ( featuredFailed ) {
			setView( 'all' );
		}

		applyDeepLink();
		bind();
		apply();
	}

	/* ------------------------------------------------------------ filters */

	function uniqueSorted( values ) {
		var seen = {};
		var list = [];
		values.forEach( function ( v ) {
			if ( ! seen[ v ] ) {
				seen[ v ] = 1;
				list.push( v );
			}
		} );
		return list;
	}

	function buildFilters() {
		// destinations: zones first, then countries alphabetically
		var zones = uniqueSorted( rows.filter( function ( r ) {
			return r.kind === 'zone';
		} ).map( function ( r ) {
			return r.country;
		} ) ).sort();

		var countries = uniqueSorted( rows.filter( function ( r ) {
			return r.kind !== 'zone';
		} ).map( function ( r ) {
			return r.country;
		} ) ).sort( function ( a, b ) {
			return a.localeCompare( b );
		} );

		el.dest.innerHTML = '';

		var all = document.createElement( 'option' );
		all.value = '';
		all.textContent = 'All destinations (' + countries.length + ' countries, ' + zones.length + ' zones)';
		el.dest.appendChild( all );

		if ( zones.length ) {
			var gz = document.createElement( 'optgroup' );
			gz.label = 'Regional zones';
			zones.forEach( function ( z ) {
				var o = document.createElement( 'option' );
				o.value = z;
				o.textContent = z;
				gz.appendChild( o );
			} );
			el.dest.appendChild( gz );
		}

		var gc = document.createElement( 'optgroup' );
		gc.label = 'Countries';
		countries.forEach( function ( c ) {
			var o = document.createElement( 'option' );
			o.value = c;
			o.textContent = c;
			gc.appendChild( o );
		} );
		el.dest.appendChild( gc );

		// data tiers, smallest to largest
		var tiers = uniqueSorted( rows.map( function ( r ) {
			return r.data;
		} ) ).sort( function ( a, b ) {
			return dataRank( a ) - dataRank( b );
		} );

		tiers.forEach( function ( t ) {
			var o = document.createElement( 'option' );
			o.value = t;
			o.textContent = t;
			el.data.appendChild( o );
		} );
	}

	/** Apply ?dest= and ?type= from the URL, e.g. a teaser card deep link. */
	function applyDeepLink() {
		var qs = readQuery();
		var linked = false;

		if ( qs.dest ) {
			el.dest.value = qs.dest;
			// A destination that is not in the list silently leaves the select
			// on "All destinations", so compare rather than trust the write.
			if ( el.dest.value === qs.dest ) {
				linked = true;
			}
		}

		if ( qs.type && el.type.querySelector( 'option[value="' + qs.type.replace( /"/g, '' ) + '"]' ) ) {
			el.type.value = qs.type;
			linked = true;
		}

		if ( linked ) {
			setView( 'all' );
		}
	}

	/* ------------------------------------------------------- browser mode */

	function setView( next ) {
		view = next;

		if ( ! el.tabs ) {
			return;
		}

		var buttons = el.tabs.querySelectorAll( '.ey-esim-tab' );

		for ( var i = 0; i < buttons.length; i++ ) {
			var on = buttons[ i ].getAttribute( 'data-view' ) === next;
			buttons[ i ].classList.toggle( 'is-active', on );
			buttons[ i ].setAttribute( 'aria-selected', on ? 'true' : 'false' );
		}
	}

	function apply( opts ) {
		if ( loadFailed ) {
			return;
		}

		opts = opts || {};

		// Touching any filter means the visitor wants the catalogue, not the
		// shortlist, so jump tabs rather than silently ignoring the input.
		if ( opts.fromUser && 'featured' === view ) {
			setView( 'all' );
		}

		if ( 'featured' === view ) {
			filtered = featuredRows();
		} else {
			filtered = rows.filter( function ( r ) {
				if ( el.dest.value && r.country !== el.dest.value ) { return false; }
				if ( el.data.value && r.data !== el.data.value ) { return false; }
				if ( el.type.value && r.type !== el.type.value ) { return false; }
				if ( opts.term ) {
					var hay = r.country.toLowerCase() + ' ' + r.pkg.toLowerCase();
					if ( hay.indexOf( opts.term ) === -1 ) { return false; }
				}
				return true;
			} );

			filtered.sort( function ( a, b ) {
				switch ( el.sort.value ) {
					case 'pricedesc': return b.price - a.price;
					case 'data':      return dataRank( b.data ) - dataRank( a.data ) || a.price - b.price;
					case 'country':   return a.country.localeCompare( b.country ) || a.price - b.price;
					default:          return a.price - b.price;
				}
			} );
		}

		shown = 0;
		el.results.innerHTML = '';
		render();
	}

	function render() {
		var featuredView = 'featured' === view;

		if ( ! filtered.length ) {
			el.results.innerHTML = '<div class="ey-esim-empty">' +
				( featuredView && featuredFailed ? S.emptyFeaturedUpdating
					: featuredView ? S.emptyFeatured : S.emptyAll ) +
				'</div>';
			el.count.textContent = featuredView ? '' : S.noResults;
			el.more.hidden = true;
			return;
		}

		var total = filtered.length;

		// The shortlist is small enough to render in one pass; the catalogue
		// is paginated.
		var slice = featuredView
			? filtered
			: filtered.slice( shown, shown + PER_PAGE );

		slice.forEach( function ( r ) {
			// Buy is a link to the checkout page for this package id. The
			// checkout page resolves the id server-side, so the id is the only
			// thing that crosses the redirect.
			el.results.appendChild( fillCard( r, checkoutHref( r ) ) );
		} );

		shown += slice.length;

		el.count.innerHTML = fillStr( featuredView ? S.countRecommended : S.countAll, {
			shown: shown,
			total: total,
			plural: total === 1 ? '' : 's'
		} );

		el.more.hidden = featuredView || shown >= total;
	}

	/* -------------------------------------------------------- teaser mode */

	function renderTeaser() {
		var list = featuredRows();
		var limit = parseInt( el.teaser.getAttribute( 'data-limit' ), 10 );

		if ( ! list.length ) {
			el.teaserList.innerHTML = '<div class="ey-esim-empty">' +
				( featuredFailed ? S.emptyTeaserUpdating : S.emptyFeatured ) +
				'</div>';
			el.teaserCount.textContent = '';
			return;
		}

		if ( isNaN( limit ) || limit < 1 ) {
			limit = list.length;
		}

		var shownList = list.slice( 0, limit );

		shownList.forEach( function ( r ) {
			// A teaser page has no filters to apply, so hand off to the browser
			// with this destination already applied.
			el.teaserList.appendChild( fillCard( r, withQuery( cfg.esimUrl || '', 'dest', r.country ) ) );
		} );

		el.teaserCount.innerHTML = fillStr( S.countTeaser, {
			shown: shownList.length,
			ofTotal: shownList.length < list.length ? ' of <strong>' + list.length + '</strong>' : '',
			plural: shownList.length === 1 ? '' : 's'
		} );
	}

	/* ----------------------------------------------------------- rendering */

	function checkoutHref( row ) {
		var base = cfg.checkoutUrl || '';

		if ( ! base ) {
			return '';
		}

		return withQuery( base, 'pkg', row.pkg );
	}

	/**
	 * Clone the PHP-rendered card template (templates/card.php) and fill it
	 * for one row.
	 *
	 * Everything structural - element order, class names, the static "Buy" /
	 * "Zone" / "Top-up" labels - is in that file; this function only writes
	 * values into its [data-esim] slots with textContent and toggles the
	 * optional slots (badges, duration, extras) the row does not need.
	 */
	function fillCard( r, href ) {
		var frag = cardTpl.content.cloneNode( true );

		function slot( name ) {
			return frag.querySelector( '[data-esim="' + name + '"]' );
		}
		function setSlot( name, text ) {
			var node = slot( name );
			if ( node ) {
				node.textContent = text;
			}
		}
		function toggleSlot( name, on ) {
			var node = slot( name );
			if ( node ) {
				node.hidden = !on;
			}
		}

		setSlot( 'country', r.country );
		setSlot( 'data', r.data );
		setSlot( 'net', netLabel( r.net ) );
		setSlot( 'price', SYMBOL + r.price.toFixed( 2 ) );

		// A Top-up is never a zone, so the two badges cannot both show.
		toggleSlot( 'badge-zone', r.kind === 'zone' );
		toggleSlot( 'badge-topup', r.type === 'Top-up' );

		toggleSlot( 'dur', !!r.dur );
		if ( r.dur ) {
			setSlot( 'dur', fillStr( S.valid, { dur: r.dur } ) );
		}

		var extras = [];
		if ( r.sms > 0 ) {
			extras.push( fillStr( S.sms, { n: r.sms } ) );
		}
		if ( r.voice > 0 ) {
			extras.push( fillStr( S.voice, { n: r.voice } ) );
		}
		toggleSlot( 'extras', extras.length > 0 );
		if ( extras.length ) {
			setSlot( 'extras', extras.join( S.extrasSep || ' \u00b7 ' ) );
		}

		// Buy is always a link: to the checkout page for this package in
		// browser mode, to the filtered browser in teaser mode. Without an href
		// (eyatraEsim.checkoutUrl missing from the localised config) the anchor
		// cannot be clicked, so say why rather than looking live and doing
		// nothing.
		var buy = slot( 'buy' );
		if ( buy && href ) {
			buy.setAttribute( 'href', href );
		} else if ( buy ) {
			buy.setAttribute( 'aria-disabled', 'true' );
			buy.setAttribute( 'title', S.checkoutGone || '' );
		}

		return frag;
	}

	/* -------------------------------------------------------------- events */

	function bind() {
		[ el.q, el.dest, el.data, el.type, el.sort ].forEach( function ( node ) {
			if ( ! node ) { return; }
			node.addEventListener( 'input', function () {
				apply( { fromUser: true, term: ( el.q.value || '' ).trim().toLowerCase() } );
			} );
			node.addEventListener( 'change', function () {
				apply( { fromUser: true, term: ( el.q.value || '' ).trim().toLowerCase() } );
			} );
		} );

		if ( el.tabs ) {
			el.tabs.addEventListener( 'click', function ( e ) {
				var tab = e.target.closest( '.ey-esim-tab' );
				if ( ! tab ) { return; }
				setView( tab.getAttribute( 'data-view' ) );
				apply();
			} );

			el.tabs.addEventListener( 'keydown', function ( e ) {
				if ( 'ArrowLeft' !== e.key && 'ArrowRight' !== e.key ) { return; }
				var tabs = el.tabs.querySelectorAll( '.ey-esim-tab' );
				var i = 0;
				for ( var n = 0; n < tabs.length; n++ ) {
					if ( tabs[ n ].classList.contains( 'is-active' ) ) { i = n; }
				}
				var next = tabs[ ( i + ( 'ArrowRight' === e.key ? 1 : tabs.length - 1 ) ) % tabs.length ];
				next.focus();
				setView( next.getAttribute( 'data-view' ) );
				apply();
				e.preventDefault();
			} );
		}

		if ( el.more ) {
			el.more.addEventListener( 'click', render );
		}

		if ( el.reset ) {
			el.reset.addEventListener( 'click', function () {
				el.q.value = '';
				el.dest.value = '';
				el.data.value = '';
				el.type.value = DEFAULT_TYPE;
				el.sort.value = 'price';
				setView( 'featured' );
				apply();
			} );
		}
	}

	load();
} )();