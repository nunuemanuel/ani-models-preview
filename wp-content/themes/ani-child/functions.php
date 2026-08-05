<?php
/**
 * ANI Child Theme — functions.php
 *
 * Hello Elementor child theme for A.N.I — Models & Prototypes.
 * RTL-Hebrew (he_IL). WPCS 3.x — escape output, sanitize input, i18n all strings.
 *
 * @package ani
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme setup: supports, image sizes, nav menus, Elementor compatibility.
 */
function ani_setup() {
	// Make theme available for translation.
	load_child_theme_textdomain( 'ani', get_stylesheet_directory() . '/languages' );

	// Core theme supports.
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	// Blog featured image sizes.
	// ani-blog-card: 16:9 card thumbnail used in the index grid.
	add_image_size( 'ani-blog-card', 640, 360, true );
	// ani-blog-banner: wide banner for the single post header.
	add_image_size( 'ani-blog-banner', 1280, 480, true );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );

	// Elementor compatibility: let Hello parent handle container/kit support.
	add_theme_support( 'elementor' );

	// Register primary navigation menu.
	register_nav_menus(
		array(
			'primary' => esc_html__( 'תפריט ראשי', 'ani' ),
			'footer'  => esc_html__( 'תפריט תחתון', 'ani' ),
		)
	);
}
add_action( 'after_setup_theme', 'ani_setup' );

/**
 * Enqueue parent theme stylesheet, child stylesheet, brand tokens, and Heebo font.
 */
function ani_enqueue_styles() {
	$parent_version = wp_get_theme( 'hello-elementor' )->get( 'Version' );
	$child_version  = wp_get_theme()->get( 'Version' );

	// 1. Parent (Hello Elementor) stylesheet.
	wp_enqueue_style(
		'hello-elementor-style',
		get_template_directory_uri() . '/style.css',
		array(),
		$parent_version
	);

	// 2. Heebo — Google Fonts (Latin + Hebrew subset).
	//    family=Heebo:wght@300;400;500;600;700;800;900 covers all needed weights.
	wp_enqueue_style(
		'ani-heebo',
		'https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;500;600;700;800;900&display=swap',
		array(),
		null
	);

	// 2b. IBM Plex Mono — monospace font for spec lines, file formats, tolerances.
	//     Weights 400 (regular) + 500 (medium) are sufficient.
	wp_enqueue_style(
		'ani-ibm-plex-mono',
		'https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500&display=swap',
		array(),
		null
	);

	// 2c. Frank Ruhl Libre — editorial serif for large display headings (Hebrew + Latin).
	wp_enqueue_style(
		'ani-frank-ruhl',
		'https://fonts.googleapis.com/css2?family=Frank+Ruhl+Libre:wght@500;600;700;800;900&display=swap',
		array(),
		null
	);

	$theme_dir = get_stylesheet_directory();

	// 3. Brand design tokens CSS custom properties.
	wp_enqueue_style(
		'ani-tokens',
		get_stylesheet_directory_uri() . '/assets/css/tokens.css',
		array( 'hello-elementor-style' ),
		filemtime( $theme_dir . '/assets/css/tokens.css' )
	);

	// 4. Component styles — ported from homepage-proto/style.css, same class names.
	wp_enqueue_style(
		'ani-components',
		get_stylesheet_directory_uri() . '/assets/css/components.css',
		array( 'ani-tokens' ),
		filemtime( $theme_dir . '/assets/css/components.css' )
	);

	// 5. Child theme stylesheet (component overrides, RTL rules).
	wp_enqueue_style(
		'ani-child-style',
		get_stylesheet_uri(),
		array( 'ani-components' ),
		filemtime( $theme_dir . '/style.css' )
	);

	// 5b. Elevation layer — precision/blueprint design system, loaded last so it
	//     wins over components.css + style.css sitewide (2026-08 redesign).
	wp_enqueue_style(
		'ani-elevate',
		get_stylesheet_directory_uri() . '/assets/css/elevate.css',
		array( 'ani-child-style' ),
		filemtime( $theme_dir . '/assets/css/elevate.css' )
	);

	// 6. Nav JS — hide-on-scroll-down / show-on-scroll-up.
	wp_enqueue_script(
		'ani-nav',
		get_stylesheet_directory_uri() . '/assets/js/nav.js',
		array(),
		filemtime( $theme_dir . '/assets/js/nav.js' ),
		true // load in footer.
	);

	// 6b. Mobile hamburger menu — toggles the header collapse drawer.
	wp_enqueue_script(
		'ani-nav-menu',
		get_stylesheet_directory_uri() . '/assets/js/nav-menu.js',
		array(),
		filemtime( $theme_dir . '/assets/js/nav-menu.js' ),
		true // load in footer.
	);

	// 7. Scroll-reveal motion — IntersectionObserver fade+translateY for .reveal elements.
	wp_enqueue_script(
		'ani-reveal',
		get_stylesheet_directory_uri() . '/assets/js/reveal.js',
		array(),
		filemtime( $theme_dir . '/assets/js/reveal.js' ),
		true // load in footer.
	);

	// 7a. Elevation JS — scroll progress, staggered reveals, count-ups, scrollspy.
	wp_enqueue_script(
		'ani-elevate',
		get_stylesheet_directory_uri() . '/assets/js/elevate.js',
		array(),
		filemtime( $theme_dir . '/assets/js/elevate.js' ),
		true // load in footer.
	);

	// 7b. Trusted-logos marquee — upgrades the static logo row into a seamless loop.
	wp_enqueue_script(
		'ani-marquee',
		get_stylesheet_directory_uri() . '/assets/js/marquee.js',
		array(),
		filemtime( $theme_dir . '/assets/js/marquee.js' ),
		true // load in footer.
	);

	// 7c. Process-chain scroll-fill — circles fill blue in sequence on scroll.
	wp_enqueue_script(
		'ani-process-fill',
		get_stylesheet_directory_uri() . '/assets/js/process-fill.js',
		array(),
		filemtime( $theme_dir . '/assets/js/process-fill.js' ),
		true // load in footer.
	);

	// 7d. Certification badges scroll-fill (mobile) — fill blue + white text on scroll.
	wp_enqueue_script(
		'ani-cert-fill',
		get_stylesheet_directory_uri() . '/assets/js/cert-fill.js',
		array(),
		filemtime( $theme_dir . '/assets/js/cert-fill.js' ),
		true // load in footer.
	);

	// 8. Contact / RFQ page styles — loaded only on the contact page template.
	if ( is_page_template( 'page-contact.php' ) || is_page( 'contact' ) ) {
		wp_enqueue_style(
			'ani-contact',
			get_stylesheet_directory_uri() . '/assets/css/contact.css',
			array( 'ani-child-style' ),
			filemtime( $theme_dir . '/assets/css/contact.css' )
		);
	}

	// 8. About page styles — loaded only on the about page template.
	if ( is_page_template( 'page-about.php' ) || is_page( 'about' ) ) {
		wp_enqueue_style(
			'ani-about',
			get_stylesheet_directory_uri() . '/assets/css/about.css',
			array( 'ani-child-style' ),
			filemtime( $theme_dir . '/assets/css/about.css' )
		);
	}

	// 9. Services hub + capability pages styles.
	if ( is_page_template( 'page-services.php' ) || is_page_template( 'page-service.php' )
		|| is_page( 'services' )
		|| is_page( array( 'composites', 'cnc', '3d-printing', 'scanning', 'integration' ) )
	) {
		wp_enqueue_style(
			'ani-service',
			get_stylesheet_directory_uri() . '/assets/css/service.css',
			array( 'ani-child-style' ),
			filemtime( $theme_dir . '/assets/css/service.css' )
		);

		// Capability detail pages only: hero-video control + proof-gallery lightbox.
		if ( is_page_template( 'page-service.php' ) ) {
			wp_enqueue_script(
				'ani-svc-interactions',
				get_stylesheet_directory_uri() . '/assets/js/svc-interactions.js',
				array(),
				filemtime( $theme_dir . '/assets/js/svc-interactions.js' ),
				true // load in footer.
			);
		}
	}

	// 10. Blog index + single post + archive/search styles.
	if ( is_home() || is_single() || is_category() || is_archive() || is_search() ) {
		wp_enqueue_style(
			'ani-blog',
			get_stylesheet_directory_uri() . '/assets/css/blog.css',
			array( 'ani-child-style' ),
			filemtime( $theme_dir . '/assets/css/blog.css' )
		);
	}

	// 10b. Blog index filter JS — category tabs + client-side search.
	//      Only on the posts index (is_home()); enhances server-rendered cards.
	if ( is_home() ) {
		wp_enqueue_script(
			'ani-blog-filter',
			get_stylesheet_directory_uri() . '/assets/js/blog-filter.js',
			array(),
			filemtime( $theme_dir . '/assets/js/blog-filter.js' ),
			true // load in footer.
		);
	}

	// 11. Capabilities & Equipment page styles.
	if ( is_page_template( 'page-capabilities.php' ) || is_page( 'capabilities' ) ) {
		wp_enqueue_style(
			'ani-capabilities',
			get_stylesheet_directory_uri() . '/assets/css/capabilities.css',
			array( 'ani-child-style' ),
			filemtime( $theme_dir . '/assets/css/capabilities.css' )
		);
	}

	// 12. Clients & Industries page styles.
	if ( is_page_template( 'page-industries.php' ) || is_page( 'industries-clients' ) ) {
		wp_enqueue_style(
			'ani-industries-clients',
			get_stylesheet_directory_uri() . '/assets/css/industries-clients.css',
			array( 'ani-child-style' ),
			filemtime( $theme_dir . '/assets/css/industries-clients.css' )
		);
	}

	// 13. Projects / Portfolio page — styles + filter JS.
	if ( is_page_template( 'page-projects.php' ) || is_page( 'projects' ) ) {
		wp_enqueue_style(
			'ani-projects',
			get_stylesheet_directory_uri() . '/assets/css/projects.css',
			array( 'ani-child-style' ),
			filemtime( $theme_dir . '/assets/css/projects.css' )
		);
		wp_enqueue_script(
			'ani-projects-filter',
			get_stylesheet_directory_uri() . '/assets/js/projects-filter.js',
			array(),
			filemtime( $theme_dir . '/assets/js/projects-filter.js' ),
			true // load in footer.
		);
	}
}
add_action( 'wp_enqueue_scripts', 'ani_enqueue_styles' );

/**
 * Dequeue Elementor's default Roboto / Roboto Slab Google Fonts.
 * Elementor loads these from the active kit's system typography defaults.
 * We replace them with Heebo (enqueued above) for Hebrew legibility.
 * Runs at priority 100 to fire after Elementor's own wp_enqueue_scripts.
 */
function ani_dequeue_elementor_fonts() {
	wp_dequeue_style( 'elementor-gf-roboto' );
	wp_dequeue_style( 'elementor-gf-robotoslab' );
	wp_deregister_style( 'elementor-gf-roboto' );
	wp_deregister_style( 'elementor-gf-robotoslab' );

	// Elementor's kit also loads Heebo from Google Fonts — we already enqueue it
	// once (ani-heebo). Drop the duplicate to avoid a second blocking font fetch.
	wp_dequeue_style( 'elementor-gf-heebo' );
	wp_deregister_style( 'elementor-gf-heebo' );
}
add_action( 'wp_enqueue_scripts', 'ani_dequeue_elementor_fonts', 100 );

/**
 * RTL stylesheet — loaded only when is_rtl() is true (he_IL default).
 * Gate on is_rtl() so the LTR English translation is unaffected.
 */
function ani_enqueue_rtl() {
	if ( ! is_rtl() ) {
		return;
	}

	if ( file_exists( get_stylesheet_directory() . '/assets/css/rtl.css' ) ) {
		wp_enqueue_style(
			'ani-rtl',
			get_stylesheet_directory_uri() . '/assets/css/rtl.css',
			array( 'ani-child-style' ),
			wp_get_theme()->get( 'Version' )
		);
	}
}
add_action( 'wp_enqueue_scripts', 'ani_enqueue_rtl', 20 );

/**
 * Add preconnect hint for Google Fonts to reduce font-load latency.
 */
function ani_preconnect_fonts() {
	echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action( 'wp_head', 'ani_preconnect_fonts', 1 );

/**
 * Per-page Hebrew meta description fallback.
 *
 * Pages render content from PHP templates / Elementor, so there is no excerpt to
 * derive a description from. This map keeps the SERP snippet + social card from
 * being blank on the highest-value commercial pages. Text reuses the client's
 * own positioning line + factual capability lists (not invented marketing copy).
 *
 * NOTE(client): refine this Hebrew before launch — keep ~150-160 chars.
 *
 * @return string
 */
function ani_page_meta_description() {
	if ( is_front_page() || is_home() && is_front_page() ) {
		return 'פתרונות הנדסיים מתקדמים — משלב הרעיון ועד למוצר המוגמר. אב טיפוס מהיר, חומרים מרוכבים, עיבוד שבבי CNC, הדפסת תלת-ממד, סריקה והנדסה לאחור והרכבה — הכל תחת קורת גג אחת ברחובות.';
	}

	if ( ! is_page() ) {
		return get_bloginfo( 'description' );
	}

	$slug = get_post_field( 'post_name', get_queried_object_id() );

	$map = array(
		'services'           => 'כל יכולות הייצור של א.נ.י תחת קורת גג אחת — חומרים מרוכבים, עיבוד שבבי CNC, הדפסת תלת-ממד, סריקה והנדסה לאחור והרכבה ואינטגרציה. מהרעיון ועד המוצר המוגמר.',
		'composites'         => 'ייצור חלקים קלי משקל בעלי חוזק גבוה מסיבי פחמן ופייברגלס — מתכנון התבנית ועד מוצר סופי מוגמר. לתעופה, רחפנים וביטחון.',
		'cnc'                => 'עיבוד שבבי CNC בכרסום 3/4/5 צירים לחלקים מדויקים — מחלק בודד ועד סדרות קטנות, במגוון רחב של חומרים כולל טיטניום.',
		'3d-printing'        => 'הדפסת תלת-ממד תעשייתית — FDM, SLA, SLS ו-MJF — לחלקים הנדסיים, אבות טיפוס פונקציונליים ומוצרים סופיים, מקובץ CAD לחלק בתוך שעות.',
		'scanning'           => 'סריקה תלת-ממדית מדויקת, הנדסה לאחור ובקרת איכות CMM — כולל שחזור חלקים קיימים ללא שרטוט מקורי.',
		'integration'        => 'הרכבות מכניות ואלקטרו-מכניות, שילוב רכיבים אלקטרוניים ואינטגרציה של מכלולים — עד מוצר מאומת ומוכן לשימוש.',
		'capabilities'       => 'מפרט היכולות והציוד של א.נ.י — מכונות, חומרים וטכנולוגיות לעיבוד שבבי, הדפסת תלת-ממד, חומרים מרוכבים, סריקה והרכבה.',
		'industries-clients' => 'א.נ.י משרתת את תעשיות הביטחון, התעופה, הרחפנים, הרפואה והאלקטרוניקה — לצד יזמים וממציאים פרטיים.',
		'projects'           => 'פרויקטים נבחרים של א.נ.י — חלקים ומכלולים מוגמרים בעיבוד שבבי, הדפסת תלת-ממד וחומרים מרוכבים.',
		'about'              => 'א.נ.י — מודלים ואבי טיפוס: One Stop Shop לפיתוח וייצור מוצרים מתקדמים, משלב הרעיון ועד למוצר המוגמר, ברחובות.',
		'contact'            => 'דברו עם א.נ.י — בקשת הצעת מחיר לאב טיפוס, חומרים מרוכבים, CNC, הדפסת תלת-ממד וסריקה. בוואטסאפ או בטלפון 054-999-2742, מענה תוך 24 שעות.',
	);

	if ( isset( $map[ $slug ] ) ) {
		return $map[ $slug ];
	}

	// Last-resort site default — never empty.
	return 'א.נ.י — מודלים ואבי טיפוס: אב טיפוס מהיר וייצור בכמויות קטנות, חומרים מרוכבים, CNC, הדפסת תלת-ממד, סריקה והרכבה. רחובות.';
}

/**
 * SEO + AEO meta tags (no SEO plugin active).
 * Emits a <meta name="description"> + Open Graph + Twitter card. The description
 * is sourced from the post/page excerpt (which is also the BlogPosting JSON-LD
 * `description`), keeping the snippet, the social card, and the schema in sync.
 */
function ani_seo_meta_tags() {
	if ( is_admin() || is_feed() ) {
		return;
	}

	$site_name = get_bloginfo( 'name' );
	$default_img = get_stylesheet_directory_uri() . '/assets/real/heroes/integration.webp';

	if ( is_singular() ) {
		$post  = get_queried_object();
		$desc  = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_trim_words( wp_strip_all_tags( $post->post_content ), 30, '…' );
		$url   = get_permalink( $post );
		$type  = is_singular( 'post' ) ? 'article' : 'website';
		$img   = $default_img;
		if ( has_post_thumbnail( $post ) ) {
			$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'large' );
			if ( $src ) {
				$img = $src[0];
			}
		}
	} else {
		$desc = get_bloginfo( 'description' );
		$url  = home_url( '/' );
		$type = 'website';
		$img  = $default_img;
	}

	// Pages store content in PHP templates / Elementor, so the excerpt fallback
	// is empty. Backfill a per-page Hebrew description so the snippet + social
	// card are never blank (the highest-value commercial pages had no meta desc).
	if ( empty( trim( wp_strip_all_tags( (string) $desc ) ) ) ) {
		$desc = ani_page_meta_description();
	}

	$desc  = trim( wp_strip_all_tags( (string) $desc ) );
	$title = wp_get_document_title();

	echo "\n";
	if ( $desc ) {
		echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
	}
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	if ( $desc ) {
		echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
	}
	echo '<meta property="og:type" content="' . esc_attr( $type ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	echo '<meta property="og:image" content="' . esc_url( $img ) . '">' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( $site_name ) . '">' . "\n";
	echo '<meta property="og:locale" content="' . esc_attr( get_locale() ) . '">' . "\n";
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
}
add_action( 'wp_head', 'ani_seo_meta_tags', 5 );

/**
 * Drop Hello Elementor's own meta-description tag — ani_seo_meta_tags() replaces it
 * (same excerpt source) and adds Open Graph + Twitter, so we avoid a duplicate.
 */
function ani_remove_hello_description_meta() {
	remove_action( 'wp_head', 'hello_elementor_add_description_meta_tag' );
}
add_action( 'init', 'ani_remove_hello_description_meta' );

/**
 * Blog index: render ALL published posts (no pagination) so the client-side
 * category filter + search cover the whole set, not just the first page.
 * The 5 sticky pillars surface in the featured row; the rest fill the grid.
 */
function ani_blog_index_show_all( $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_home() ) {
		$query->set( 'posts_per_page', -1 );
	}
}
add_action( 'pre_get_posts', 'ani_blog_index_show_all' );

/**
 * Build-time convenience: stop the browser caching the front-end HTML so the
 * client always sees the current build (they repeatedly viewed stale pages).
 * Front-end, non-admin only. Remove before production if a page cache is added.
 */
function ani_no_front_html_cache() {
	if ( ! is_admin() ) {
		nocache_headers();
	}
}
add_action( 'send_headers', 'ani_no_front_html_cache' );

/**
 * Body class additions: rtl flag, page slug, Elementor-active flag.
 *
 * @param  array $classes Existing body classes.
 * @return array
 */
function ani_body_classes( $classes ) {
	if ( is_rtl() ) {
		$classes[] = 'ani-rtl';
	}

	if ( is_singular() ) {
		$classes[] = 'ani-singular';
	}

	return $classes;
}
add_filter( 'body_class', 'ani_body_classes' );

/**
 * Elementor: register site identity global widgets / color palette hooks.
 * Minimal — Elementor's own Kit handles most global tokens;
 * this just ensures our child theme is not overriding Elementor's container.
 */
function ani_elementor_register_support() {
	// Remove Hello's default header/footer — we code our own in header.php / footer.php.
	remove_action( 'elementor/page_templates/header-footer/before_content', 'hello_elementor_add_header' );
	remove_action( 'elementor/page_templates/header-footer/after_content', 'hello_elementor_add_footer' );
}
add_action( 'init', 'ani_elementor_register_support' );

/**
 * Allow CAD / engineering file types in the WordPress media library.
 *
 * WP blocks unknown MIMEs at two points:
 *   1. upload_mimes  — controls which extensions are allowed at the uploader UI.
 *   2. wp_check_filetype_and_ext — validates the real file type against its extension.
 *      For format-agnostic types (e.g. STEP, STL) WP cannot detect the real MIME
 *      from file content, so we whitelist by returning the declared type unchanged.
 *
 * Extensions: step|stp (STEP), stl (STL), iges|igs (IGES), dxf (DXF),
 *             sldprt (SolidWorks), pdf (already in WP core — belt-and-suspenders).
 *
 * @param  array $mimes Existing MIME map [ extension => MIME-type ].
 * @return array
 */
function ani_upload_mimes( $mimes ) {
	// STEP — ISO 10303, standard interchange format.
	$mimes['step'] = 'application/octet-stream';
	$mimes['stp']  = 'application/octet-stream';

	// STL — stereolithography / 3D printing format.
	$mimes['stl']  = 'application/octet-stream';

	// IGES — Initial Graphics Exchange Specification.
	$mimes['iges'] = 'application/octet-stream';
	$mimes['igs']  = 'application/octet-stream';

	// DXF — AutoCAD 2D drawing exchange format.
	$mimes['dxf']  = 'application/octet-stream';

	// SolidWorks Part file.
	$mimes['sldprt'] = 'application/octet-stream';

	// PDF — belt-and-suspenders; already in WP core.
	$mimes['pdf'] = 'application/pdf';

	return $mimes;
}
add_filter( 'upload_mimes', 'ani_upload_mimes' );

/**
 * Allow CAD files to pass WP's real-file-type check.
 *
 * For binary formats (STEP/STL/IGES/DXF/SLDPRT) the finfo/mime-detection returns
 * 'application/octet-stream' or an empty string, which WP then rejects because it
 * can't confirm the MIME matches the extension.  We intercept and confirm the type
 * for our whitelisted extensions.
 *
 * @param  array       $data     { ext, type, proper_filename }.
 * @param  string      $file     Path to the tmp file.
 * @param  string      $filename Original client filename.
 * @param  array|null  $mimes    Allowed mimes (may be null).
 * @param  string|bool $real_mime Real MIME detected by finfo (WP 5.1+).
 * @return array
 */
function ani_check_filetype_and_ext( $data, $file, $filename, $mimes, $real_mime = false ) {
	// Extensions this filter is responsible for.
	$cad_ext_map = array(
		'step'   => 'application/octet-stream',
		'stp'    => 'application/octet-stream',
		'stl'    => 'application/octet-stream',
		'iges'   => 'application/octet-stream',
		'igs'    => 'application/octet-stream',
		'dxf'    => 'application/octet-stream',
		'sldprt' => 'application/octet-stream',
	);

	$ext = strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) );

	if ( isset( $cad_ext_map[ $ext ] ) ) {
		$data['ext']  = $ext;
		$data['type'] = $cad_ext_map[ $ext ];
	}

	return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'ani_check_filetype_and_ext', 10, 5 );

/**
 * Load coded forms: CPT, shortcodes, admin-post handlers, enqueue.
 */
require_once get_stylesheet_directory() . '/inc/forms/ani-forms.php';

/**
 * Load lead popup: Settings API page, scope logic, footer render, enqueue.
 */
require_once get_stylesheet_directory() . '/inc/popup/ani-popup.php';

/**
 * Load blog: reusable article block pattern + post JSON-LD (BlogPosting +
 * BreadcrumbList). No SEO plugin is active, so this is the schema source.
 */
require_once get_stylesheet_directory() . '/inc/blog/ani-blog-patterns.php';
require_once get_stylesheet_directory() . '/inc/blog/ani-blog-schema.php';

/**
 * Load entity & site JSON-LD (Organization / LocalBusiness / WebSite) + the
 * reusable Service-schema helper for capability pages.
 */
require_once get_stylesheet_directory() . '/inc/seo/ani-seo-schema.php';

/**
 * Front-page <title>: the WP tagline alone is brand-only. Inject the primary
 * capabilities + city so the most important page carries ranking keywords.
 * NOTE(client): refine the Hebrew before launch.
 *
 * @param  array $parts Document title parts.
 * @return array
 */
function ani_front_title_parts( $parts ) {
	if ( is_front_page() ) {
		$parts['title']   = 'א.נ.י מודלים ואבי טיפוס';
		$parts['tagline'] = 'אב טיפוס · CNC · הדפסת תלת-ממד · חומרים מרוכבים · רחובות';
	}
	return $parts;
}
add_filter( 'document_title_parts', 'ani_front_title_parts' );

/**
 * Serve /llms.txt — a plain-text map for AI crawlers (PROJECT.md requirement).
 * Kept in the theme (in git) via a rewrite + template_redirect rather than a
 * static web-root file.
 */
function ani_llms_txt_rewrite() {
	add_rewrite_rule( '^llms\.txt/?$', 'index.php?ani_llms=1', 'top' );
}
add_action( 'init', 'ani_llms_txt_rewrite' );

function ani_llms_txt_query_var( $vars ) {
	$vars[] = 'ani_llms';
	return $vars;
}
add_filter( 'query_vars', 'ani_llms_txt_query_var' );

/**
 * Output llms.txt early (on parse_request, before redirect_canonical can add a
 * trailing slash and 301 the request away).
 *
 * @param WP $wp The WordPress environment instance.
 */
function ani_llms_txt_output( $wp ) {
	$is_llms = ! empty( $wp->query_vars['ani_llms'] );
	if ( ! $is_llms && isset( $_SERVER['REQUEST_URI'] ) ) {
		$is_llms = (bool) preg_match( '#^/?llms\.txt/?(\?|$)#', wp_unslash( $_SERVER['REQUEST_URI'] ) );
	}
	if ( ! $is_llms ) {
		return;
	}

	$c    = function_exists( 'ani_company_data' ) ? ani_company_data() : array();
	$home = home_url( '/' );

	header( 'Content-Type: text/plain; charset=utf-8' );
	$lines   = array();
	$lines[] = '# A.N.I — Models & Prototypes (א.נ.י מודלים ואבי טיפוס)';
	$lines[] = '';
	$lines[] = '> B2B industrial rapid-prototyping & low-volume manufacturing bureau in Rehovot, Israel.';
	$lines[] = '> One Stop Shop: from CAD/concept to a finished physical product under one roof.';
	$lines[] = '> Slogan: מתכננים. מפתחים. מייצרים. מגשימים רעיונות.';
	$lines[] = '';
	$lines[] = '## Capabilities';
	$lines[] = '- [חומרים מרוכבים / Composites](' . $home . 'composites/) — carbon fiber & fiberglass, mold design, finishing.';
	$lines[] = '- [עיבוד שבבי CNC / CNC machining](' . $home . 'cnc/) — 3/4/5-axis milling; metals incl. titanium, polymers, composites.';
	$lines[] = '- [הדפסת תלת-ממד / 3D printing](' . $home . '3d-printing/) — FDM, SLA, SLS, MJF.';
	$lines[] = '- [סריקה והנדסה לאחור / Scanning & reverse engineering](' . $home . 'scanning/) — CMM metrology, reverse engineering, QC.';
	$lines[] = '- [הרכבה ואינטגרציה / Integration](' . $home . 'integration/) — mechanical & electro-mechanical assembly.';
	$lines[] = '';
	$lines[] = '## Equipment';
	$lines[] = '- FlashForge Creator 4S (FDM), Sintratec S2 (SLS), Sonic Mega V2 (SLA), Formlabs Fuse (SLS), industrial CNC machining centres, industrial 3D scanners, CMM.';
	$lines[] = '';
	$lines[] = '## Industries served';
	$lines[] = '- Defense, aerospace, drones/UAV, medical, electronics, advanced industry; startups, inventors, private clients.';
	$lines[] = '';
	$lines[] = '## Pages';
	$lines[] = '- [Home](' . $home . ')';
	$lines[] = '- [Services hub](' . $home . 'services/)';
	$lines[] = '- [About](' . $home . 'about/)';
	$lines[] = '- [Capabilities & equipment](' . $home . 'capabilities/)';
	$lines[] = '- [Projects](' . $home . 'projects/)';
	$lines[] = '- [Blog](' . $home . 'blog/)';
	$lines[] = '- [Contact](' . $home . 'contact/)';
	$lines[] = '';
	$lines[] = '## Contact';
	$lines[] = '- Phone / WhatsApp: ' . ( isset( $c['phone'] ) ? $c['phone'] : '+972-54-999-2742' );
	$lines[] = '- Email: ' . ( isset( $c['email'] ) ? $c['email'] : 'info@ani-models.co.il' );
	$lines[] = '- Location: Rehovot, Israel';

	// Plain-text response: do NOT HTML-escape (would render &amp;/&gt; literally).
	// All lines are static, developer-controlled strings — no user input.
	echo implode( "\n", $lines ) . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	exit;
}
add_action( 'parse_request', 'ani_llms_txt_output' );
