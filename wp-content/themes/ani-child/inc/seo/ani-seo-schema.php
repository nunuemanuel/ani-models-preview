<?php
/* ~ mano ~ */
/**
 * ANI — Entity & site JSON-LD (Organization / LocalBusiness / WebSite).
 *
 * The site previously emitted JSON-LD on blog posts only, so answer engines
 * (ChatGPT, Perplexity, AI Overviews, Gemini) could not resolve A.N.I as an
 * entity. This adds sitewide Organization + LocalBusiness + WebSite/SearchAction
 * graph, and a reusable Service-schema helper for the capability pages.
 *
 * Single source of company facts: ani_company_data(). JSON printed with
 * JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES so Hebrew stays readable.
 *
 * @package ani
 * @since   1.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Canonical company data — the one place NAP/equipment/clients live.
 *
 * @return array
 */
function ani_company_data() {
	return array(
		'name_he'    => 'א.נ.י מודלים ואבי טיפוס',
		'name_en'    => 'A.N.I — Models & Prototypes',
		'legal'      => 'A.N.I Models & Prototypes',
		'phone'      => '+972-54-999-2742',
		'phone_e164' => '+972549992742',
		'email'      => 'info@ani-models.co.il',
		'city'       => 'רחובות',
		'city_en'    => 'Rehovot',
		'country'    => 'IL',
		'capabilities' => array(
			'composites'  => 'חומרים מרוכבים',
			'cnc'         => 'עיבוד שבבי CNC',
			'3d-printing' => 'הדפסת תלת-ממד',
			'scanning'    => 'סריקה והנדסה לאחור',
			'integration' => 'הרכבה ואינטגרציה',
		),
		'knows_about' => array(
			'Carbon fiber composites manufacturing',
			'CNC machining (3/4/5-axis)',
			'Industrial 3D printing (FDM, SLS, SLA, MJF)',
			'3D scanning and reverse engineering',
			'Mechanical and electro-mechanical integration',
			'Rapid prototyping',
			'Low-volume manufacturing',
		),
		'sameas'      => array(), // TODO(client): add LinkedIn / Facebook / Google Business Profile URLs.
	);
}

/**
 * Print the sitewide Organization (as LocalBusiness) + WebSite JSON-LD graph.
 * Hooked early in <head> so it is the canonical entity reference (#organization).
 */
function ani_org_jsonld() {
	if ( is_admin() || is_feed() ) {
		return;
	}

	$c       = ani_company_data();
	$home    = home_url( '/' );
	$logo    = get_stylesheet_directory_uri() . '/assets/logo-sphere.png';

	$organization = array(
		'@type'         => array( 'Organization', 'LocalBusiness' ),
		'@id'           => $home . '#organization',
		'name'          => $c['name_he'],
		'alternateName' => $c['name_en'],
		'url'           => $home,
		'logo'          => array(
			'@type' => 'ImageObject',
			'url'   => $logo,
		),
		'image'         => $logo,
		'telephone'     => $c['phone'],
		'email'         => $c['email'],
		'address'       => array(
			'@type'           => 'PostalAddress',
			'addressLocality' => $c['city'],
			'addressCountry'  => $c['country'],
		),
		'areaServed'    => array(
			array( '@type' => 'Country', 'name' => 'Israel' ),
			array( '@type' => 'Place', 'name' => 'Worldwide (export)' ),
		),
		'knowsAbout'    => $c['knows_about'],
		'slogan'        => 'מתכננים. מפתחים. מייצרים. מגשימים רעיונות.',
		'description'   => 'חברת אב-טיפוס וייצור בכמויות קטנות ברחובות — חומרים מרוכבים, עיבוד שבבי CNC, הדפסת תלת-ממד, סריקה והנדסה לאחור והרכבה, הכל תחת קורת גג אחת.',
	);

	if ( ! empty( $c['sameas'] ) ) {
		$organization['sameAs'] = $c['sameas'];
	}

	$website = array(
		'@type'           => 'WebSite',
		'@id'             => $home . '#website',
		'url'             => $home,
		'name'            => $c['name_he'],
		'inLanguage'      => 'he-IL',
		'publisher'       => array( '@id' => $home . '#organization' ),
		'potentialAction' => array(
			'@type'       => 'SearchAction',
			'target'      => array(
				'@type'       => 'EntryPoint',
				'urlTemplate' => $home . '?s={search_term_string}',
			),
			'query-input' => 'required name=search_term_string',
		),
	);

	$graph = array(
		'@context' => 'https://schema.org',
		'@graph'   => array( $organization, $website ),
	);

	echo "\n" . '<script type="application/ld+json">'
		. wp_json_encode( $graph, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES )
		. '</script>' . "\n";
}
add_action( 'wp_head', 'ani_org_jsonld', 4 );

/**
 * Render Service + BreadcrumbList JSON-LD for a single capability page.
 * Called from page-service.php with the resolved $cap array + slug.
 *
 * @param array  $cap  The capability data (title, intro, what_we_do, materials).
 * @param string $slug The page slug (composites, cnc, …).
 */
function ani_service_jsonld( $cap, $slug ) {
	if ( empty( $cap ) ) {
		return;
	}

	$c          = ani_company_data();
	$home       = home_url( '/' );
	$page_url   = home_url( '/' . $slug . '/' );
	$services   = home_url( '/services/' );

	// OfferCatalog items from the capability's capabilities/services list.
	$offer_source = ! empty( $cap['capabilities'] ) ? $cap['capabilities'] : ( ! empty( $cap['what_we_do'] ) ? $cap['what_we_do'] : array() );
	$offer_items  = array();
	if ( ! empty( $offer_source ) && is_array( $offer_source ) ) {
		foreach ( $offer_source as $item ) {
			$offer_items[] = array(
				'@type' => 'Offer',
				'itemOffered' => array(
					'@type' => 'Service',
					'name'  => $item,
				),
			);
		}
	}

	$service = array(
		'@type'       => 'Service',
		'@id'         => $page_url . '#service',
		'serviceType' => $cap['title'],
		'name'        => $cap['title'],
		'description' => ! empty( $cap['lead'] ) ? $cap['lead'] : ( ! empty( $cap['intro'] ) ? $cap['intro'] : '' ),
		'url'         => $page_url,
		'provider'    => array( '@id' => $home . '#organization' ),
		'areaServed'  => array( '@type' => 'Country', 'name' => 'Israel' ),
	);

	if ( $offer_items ) {
		$service['hasOfferCatalog'] = array(
			'@type'           => 'OfferCatalog',
			'name'            => $cap['title'],
			'itemListElement' => $offer_items,
		);
	}

	$breadcrumb = array(
		'@type'           => 'BreadcrumbList',
		'itemListElement' => array(
			array(
				'@type'    => 'ListItem',
				'position' => 1,
				'name'     => 'דף הבית',
				'item'     => $home,
			),
			array(
				'@type'    => 'ListItem',
				'position' => 2,
				'name'     => 'השירותים שלנו',
				'item'     => $services,
			),
			array(
				'@type'    => 'ListItem',
				'position' => 3,
				'name'     => $cap['title'],
				'item'     => $page_url,
			),
		),
	);

	$graph = array(
		'@context' => 'https://schema.org',
		'@graph'   => array( $service, $breadcrumb ),
	);

	echo "\n" . '<script type="application/ld+json">'
		. wp_json_encode( $graph, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES )
		. '</script>' . "\n";
}
