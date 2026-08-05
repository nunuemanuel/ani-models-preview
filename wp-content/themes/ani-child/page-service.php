<?php
/**
 * Template Name: Capability / שירות
 *
 * Reusable capability detail page for A.N.I — Models & Prototypes.
 * All 5 capability pages use this single template; the per-page data
 * is keyed by the page slug so there is no ACF dependency.
 *
 * Content is the client's finalized copy (2026-08-01 hand-off), verbatim.
 * Imagery is the client's real part photography (assets/real/*).
 *
 * Section order (rendered conditionally per capability):
 *   1. Hero — title + lead + technical chips + real photo OR video (CNC)
 *   2. Lead body paragraph
 *   3. Capabilities / services list
 *   4. Technologies (3D-printing: FDM / SLS / SLA)
 *   5. Advantages (יתרונות) — dark technical band
 *   6. Process strip (composites hand lay-up)
 *   7. Proof gallery — real parts, lightbox
 *   8. Closing reassurance paragraph
 *   9. Related capabilities
 *  10. CTA band → /contact/
 *
 * RTL-Hebrew: logical-property CSS only; LTR isolation on latin/numbers/machine-names.
 * No hardcoded hex — all via tokens.css custom properties.
 * All user-facing strings escaped on output with the 'ani' text-domain.
 *
 * @package ani
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$assets_uri   = get_stylesheet_directory_uri() . '/assets';
$contact_url  = esc_url( home_url( '/contact/' ) );
$services_url = esc_url( home_url( '/services/' ) );
$slug         = get_post_field( 'post_name', get_queried_object_id() );

/**
 * Per-capability data, keyed by page slug.
 * Copy verbatim from the client hand-off (2026-08-01). Do not rewrite Hebrew.
 * 'chips' are short latin technical terms (rendered dir=ltr).
 */
$capabilities = array(

	// ---------------------------------------------------------------- composites
	'composites' => array(
		'eyebrow'    => __( 'חומרים מרוכבים', 'ani' ),
		'title'      => __( 'ייצור מוצרים מחומרים מרוכבים', 'ani' ),
		'lead'       => __( 'א.נ.י מודלים ואבות טיפוס מתמחה בפיתוח, ייצור והרכבה של מוצרים מחומרים מרוכבים (Composites) עבור תעשיות הביטחון, התעופה, הרפואה והתעשייה המתקדמת.', 'ani' ),
		'body'       => __( 'אנו מלווים את הלקוח משלב התכנון ועד למוצר המוגמר. יכולות החברה כוללות תכנון תבניות, JIGS וייצור חלקים מרוכבים בעלי גיאומטריות מורכבות, כולל שילוב רכיבים מכניים ואלקטרוניים ואינטגרציות מלאות בהתאם לדרישות הלקוח.', 'ani' ),
		'hero'       => array(
			'type' => 'image',
			'img'  => 'real/heroes/composites',
		),
		'chips'      => array( 'Composites', 'Carbon Fiber', 'Fiberglass', 'JIGS', 'Prepreg' ),
		'industries' => array( __( 'ביטחון', 'ani' ), __( 'תעופה', 'ani' ), __( 'רפואה', 'ani' ), __( 'תעשייה מתקדמת', 'ani' ) ),
		'cap_label'  => __( 'היכולות שלנו', 'ani' ),
		'capabilities' => array(
			__( 'תכנון תבניות ו-JIGS', 'ani' ),
			__( 'ייצור חלקים מרוכבים בעלי גיאומטריות מורכבות', 'ani' ),
			__( 'שילוב רכיבים מכניים ואלקטרוניים', 'ani' ),
			__( 'אינטגרציות מלאות בהתאם לדרישות הלקוח', 'ani' ),
		),
		'process'    => array(
			array( 'img' => 'real/process/composites-02', 'cap' => __( 'הנחת יריעות סיבי פחמן על התבנית', 'ani' ) ),
			array( 'img' => 'real/process/composites-01', 'cap' => __( 'החדרת שרף וגימור פני השטח', 'ani' ) ),
		),
		'gallery_label' => __( 'תבניות וחלקים לדוגמה', 'ani' ),
		'gallery'    => array( 'composites-03', 'composites-04', 'composites-05', 'composites-01', 'composites-02' ),
		// No client-provided closing line for composites — left empty (section hidden).
		'closing'    => '',
	),

	// ---------------------------------------------------------------- cnc
	'cnc' => array(
		'eyebrow'    => __( 'עיבוד שבבי', 'ani' ),
		'title'      => __( 'ייצור CNC', 'ani' ),
		'lead'       => __( 'א.נ.י מודלים ואבות טיפוס מספקת שירותי עיבוד שבבי (CNC) מדויקים לייצור חלקים, מכלולים ואבות טיפוס עבור תעשיות הביטחון, התעופה, הרפואה והתעשייה המתקדמת.', 'ani' ),
		'body'       => __( 'אנו מתמחים בייצור רכיבים בעלי דיוק גבוה, החל מפריטים בודדים ועד לסדרות ייצור, תוך עמידה בדרישות הנדסיות.', 'ani' ),
		'hero'       => array(
			'type'   => 'video',
			'video'  => 'real/video/cnc-tooling.mp4',
			'poster' => 'real/video/cnc-tooling-poster',
		),
		'chips'      => array( '3/4/5-Axis', 'TOOLING BLOCK', 'DFM', 'CNC Milling' ),
		'industries' => array( __( 'ביטחון', 'ani' ), __( 'תעופה', 'ani' ), __( 'רפואה', 'ani' ), __( 'תעשייה מתקדמת', 'ani' ) ),
		'cap_label'  => __( 'יכולות עיקריות', 'ani' ),
		'capabilities' => array(
			__( 'כרסום CNC ב-3, 4 ו-5 צירים', 'ani' ),
			__( 'כרסום תבניות גדולות (TOOLING BLOCK) במכונות פתוחות 3+4 צירים', 'ani' ),
			__( 'עיבוד חלקים בעלי גיאומטריות מורכבות', 'ani' ),
			__( 'ייצור מתקנים, ג\'יגים ותבניות', 'ani' ),
			__( 'עיבוד לאחר טיפולי שטח וציפויים', 'ani' ),
			__( 'בקרת איכות ומדידות באמצעות סריקה', 'ani' ),
		),
		'gallery_label' => __( 'חלקים ותבניות לדוגמה', 'ani' ),
		'gallery'    => array( 'cnc-02', 'cnc-01', 'cnc-06', 'cnc-07', 'cnc-04', 'cnc-05', 'cnc-03', 'cnc-08', 'cnc-09' ),
		'closing'    => __( 'אנו מלווים את הלקוח משלב התכנון ועד לאספקת החלק המוגמר, תוך שילוב יכולות הנדסיות, תכנון לייצור (DFM), בקרת איכות וניהול שרשרת אספקה — לקבלת מוצר מדויק, איכותי ובזמן.', 'ani' ),
	),

	// ---------------------------------------------------------------- 3d-printing
	'3d-printing' => array(
		'eyebrow'    => __( 'הדפסה תלת-ממד', 'ani' ),
		'title'      => __( 'ייצור בהדפסה תלת-ממדית', 'ani' ),
		'lead'       => __( 'א.נ.י מודלים ואבות טיפוס מספקת שירותי הדפסה תלת-ממדית מתקדמים בטכנולוגיות FDM, SLS ו-SLA, המאפשרות ייצור מהיר ומדויק של אבות טיפוס, חלקים פונקציונליים ומוצרים סופיים במגוון רחב של חומרים.', 'ani' ),
		'body'       => __( 'הודות לשילוב בין יכולות הנדסיות, תכנון לייצור וניסיון מעשי, אנו מסייעים ללקוחות לקצר זמני פיתוח, להפחית עלויות ולהאיץ את המעבר מרעיון למוצר.', 'ani' ),
		'hero'       => array(
			'type' => 'image',
			'img'  => 'real/heroes/printing',
			'fit'  => 'contain',
		),
		'chips'      => array( 'FDM', 'SLS', 'SLA' ),
		'industries' => array( __( 'ביטחון', 'ani' ), __( 'תעופה', 'ani' ), __( 'רפואה', 'ani' ), __( 'תעשייה מתקדמת', 'ani' ) ),
		'technologies' => array(
			array(
				'term' => 'FDM',
				'sub'  => __( 'הדפסת פולימרים הנדסיים', 'ani' ),
				'desc' => __( 'פתרון אידיאלי לייצור אבות טיפוס, מתקנים, ג\'יגים, חלקים גדולים ורכיבים פונקציונליים במגוון רחב של חומרים הנדסיים.', 'ani' ),
			),
			array(
				'term' => 'SLS',
				'sub'  => __( 'הדפסת אבקת פולימר', 'ani' ),
				'desc' => __( 'ייצור חלקים חזקים ומדויקים ללא צורך בתמיכות, המתאימים לגיאומטריות מורכבות, סדרות קטנות ומכלולים פונקציונליים.', 'ani' ),
			),
			array(
				'term' => 'SLA',
				'sub'  => __( 'הדפסת שרף ברזולוציה גבוהה', 'ani' ),
				'desc' => __( 'ייצור חלקים בעלי דיוק גבוה במיוחד, איכות פני שטח מעולה ופרטים עדינים — למודלים הנדסיים, תבניות ויישומים הדורשים גימור איכותי.', 'ani' ),
			),
		),
		'cap_label'  => __( 'השירותים שלנו', 'ani' ),
		'capabilities' => array(
			__( 'ייצור אבות טיפוס מהיר (Rapid Prototyping)', 'ani' ),
			__( 'חלקים פונקציונליים לבדיקות ופיתוח', 'ani' ),
			__( 'ייצור סדרות קטנות', 'ani' ),
			__( 'מתקנים, ג\'יגים וכלי עזר לייצור', 'ani' ),
			__( 'חלקים מורכבים בעלי גיאומטריות מתקדמות', 'ani' ),
			__( 'שילוב הדפסה תלת-ממדית עם עיבוד CNC והרכבות', 'ani' ),
		),
		'adv_label'  => __( 'היתרונות שלנו', 'ani' ),
		'advantages' => array(
			__( 'התאמת טכנולוגיית ההדפסה לדרישות היישום', 'ani' ),
			__( 'דיוק גבוה ואיכות גימור מעולה', 'ani' ),
			__( 'זמני אספקה קצרים', 'ani' ),
			__( 'מגוון רחב של חומרים הנדסיים', 'ani' ),
			__( 'ליווי הנדסי משלב הרעיון ועד למוצר המוגמר', 'ani' ),
		),
		'closing'    => __( 'באמצעות שילוב טכנולוגיות ההדפסה המתקדמות עם יכולות החברה בתחומי התכנון, העיבוד השבבי, הסריקה התלת-ממדית וההרכבות, אנו מספקים ללקוחות פתרון מלא לפיתוח, ייצור ואספקת מוצרים ברמת איכות גבוהה.', 'ani' ),
	),

	// ---------------------------------------------------------------- scanning
	'scanning' => array(
		'eyebrow'    => __( 'סריקה והנדסה לאחור', 'ani' ),
		'title'      => __( 'סריקות תלת-ממד, Reverse Engineering ובדיקות CMM', 'ani' ),
		'lead'       => __( 'א.נ.י מודלים ואבות טיפוס מספקת שירותי סריקה תלת-ממדית מתקדמים המאפשרים לכידה מדויקת של גיאומטריות מורכבות, יצירת מודלים הנדסיים וביצוע בקרת איכות ברמת דיוק גבוהה.', 'ani' ),
		'body'       => __( 'באמצעות טכנולוגיית הסריקה המתקדמת ניתן לבצע תיעוד מלא של רכיבים קיימים, השוואה למודל CAD, הפקת מודלים הנדסיים (Reverse Engineering) ובדיקות ממדיות מדויקות (CMM Inspection).', 'ani' ),
		'hero'       => array(
			'type' => 'image',
			'img'  => 'real/heroes/scanning',
		),
		'chips'      => array( 'CMM', 'Reverse Engineering', 'CAD' ),
		'industries' => array( __( 'ביטחון', 'ani' ), __( 'תעופה', 'ani' ), __( 'רפואה', 'ani' ), __( 'תעשייה מתקדמת', 'ani' ) ),
		'cap_label'  => __( 'השירותים שלנו', 'ani' ),
		'capabilities' => array(
			__( 'סריקה תלת-ממדית ברזולוציה גבוהה', 'ani' ),
			__( 'Reverse Engineering והפקת מודלי CAD', 'ani' ),
			__( 'השוואת סריקה למודל CAD (Deviation Analysis)', 'ani' ),
			__( 'בדיקות ממדיות (CMM Inspection)', 'ani' ),
			__( 'יצירת דוחות מדידה צבעוניים', 'ani' ),
			__( 'שחזור חלקים ללא שרטוטים', 'ani' ),
			__( 'בקרת איכות לייצור ואימות חלקים', 'ani' ),
			__( 'דיגיטציה של רכיבים ומכלולים מורכבים', 'ani' ),
		),
		'adv_label'  => __( 'יתרונות', 'ani' ),
		'advantages' => array(
			__( 'דיוק גבוה ומהירות סריקה', 'ani' ),
			__( 'מדידה ללא מגע וללא פגיעה ברכיב', 'ani' ),
			__( 'יכולת סריקה של חלקים קטנים וגדולים', 'ani' ),
			__( 'הפקת דוחות מקצועיים ותיעוד מלא', 'ani' ),
			__( 'קיצור זמני פיתוח ובקרת איכות', 'ani' ),
		),
		'closing'    => __( 'אנו מספקים פתרון מקיף החל מסריקת הרכיב, דרך יצירת מודל תלת-ממדי הניתן לעריכה, ועד לבדיקות איכות והשוואה למודל ההנדסי — ומאפשרים ללקוחותינו לשחזר, לשפר ולייצר חלקים בדיוק מרבי.', 'ani' ),
	),

	// ---------------------------------------------------------------- integration
	'integration' => array(
		'eyebrow'    => __( 'הרכבה ואינטגרציה', 'ani' ),
		'title'      => __( 'אינטגרציה והרכבת מערכות', 'ani' ),
		'lead'       => __( 'א.נ.י מודלים ואבות טיפוס מספקת שירותי אינטגרציה והרכבה למערכות בלתי מאוישות (UAV) ולמכלולים מכניים ואלקטרוניים, החל משלב אב הטיפוס ועד למערכות מוכנות לניסויים ולהפעלה.', 'ani' ),
		'body'       => __( 'אנו מתמחים בשילוב מדויק של רכיבים מכניים, אלקטרוניים וחשמליים, תוך הקפדה על איכות ההרכבה, אמינות המערכת ועמידה בדרישות ההנדסיות של הלקוח.', 'ani' ),
		'hero'       => array(
			'type' => 'image',
			'img'  => 'real/heroes/integration',
		),
		'chips'      => array( 'UAV', 'Electro-Mechanical', 'PCB', 'QA' ),
		'industries' => array( __( 'ביטחון', 'ani' ), __( 'תעופה', 'ani' ), __( 'רפואה', 'ani' ), __( 'תעשייה מתקדמת', 'ani' ) ),
		'cap_label'  => __( 'השירותים שלנו', 'ani' ),
		'capabilities' => array(
			__( 'אינטגרציה של רחפנים וכלי טיס בלתי מאוישים (UAV)', 'ani' ),
			__( 'הרכבת מכלולים מכניים ואלקטרו-מכניים', 'ani' ),
			__( 'שילוב מנועים, בקרים, חיווט ומערכות הנעה', 'ani' ),
			__( 'התקנת חיישנים, מצלמות ומטענים ייעודיים', 'ani' ),
			__( 'בניית אבות טיפוס פונקציונליים', 'ani' ),
			__( 'הרכבות סדרתיות בכמויות קטנות ובינוניות', 'ani' ),
			__( 'בדיקות תקינות, תיעוד ובקרת איכות', 'ani' ),
		),
		'adv_label'  => __( 'היתרונות שלנו', 'ani' ),
		'advantages' => array(
			__( 'הרכבה מדויקת לפי שרטוטים ומפרטים הנדסיים', 'ani' ),
			__( 'ניסיון במערכות מורכבות לתעשיות הביטחון והתעופה', 'ani' ),
			__( 'ליווי מלא משלב הפיתוח ועד למסירת מערכת מוכנה להפעלה', 'ani' ),
		),
		'closing'    => __( 'אנו מספקים פתרון אינטגרציה מקיף המאפשר ללקוחות לקבל מכלולים ומערכות מורכבות כשהם מורכבים, נבדקים ומוכנים לשלב הפיתוח, הניסויים או הייצור הסדרתי.', 'ani' ),
	),

);

// Determine the current capability from the slug.
$cap = isset( $capabilities[ $slug ] ) ? $capabilities[ $slug ] : null;

// Fallback: redirect to hub if slug unknown.
if ( null === $cap ) {
	wp_safe_redirect( home_url( '/services/' ) );
	exit;
}

// Service + BreadcrumbList JSON-LD for this capability (helper in inc/seo).
if ( function_exists( 'ani_service_jsonld' ) ) {
	ani_service_jsonld( $cap, $slug );
}

// Whatsapp deep-link for the secondary hero CTA.
$wa_href = 'https://wa.me/972549992742';

// Other capabilities for the "related services" rail (exclude current).
$other_caps = array_filter(
	$capabilities,
	static function ( $key ) use ( $slug ) {
		return $key !== $slug;
	},
	ARRAY_FILTER_USE_KEY
);

// Alt text: reuse the client-approved capability eyebrow — factual, not invented copy.
$photo_alt = $cap['eyebrow'];
?>
<div class="ani-service-page" data-svc="<?php echo esc_attr( $slug ); ?>">

	<!-- =========================================================== HERO -->
	<section class="ani-svc-hero" aria-labelledby="service-hero-title">
		<div class="ani-svc-hero__inner ani-container">

			<div class="ani-svc-hero__copy" data-reveal>
				<nav class="ani-svc-breadcrumb" aria-label="<?php esc_attr_e( 'מיקום באתר', 'ani' ); ?>">
					<a href="<?php echo $services_url; ?>"><?php esc_html_e( 'השירותים שלנו', 'ani' ); ?></a>
					<span class="ani-svc-breadcrumb__sep" aria-hidden="true">/</span>
					<span class="ani-svc-breadcrumb__current"><?php echo esc_html( $cap['eyebrow'] ); ?></span>
				</nav>

				<h1 class="ani-svc-hero__title" id="service-hero-title">
					<?php echo esc_html( $cap['title'] ); ?>
				</h1>

				<p class="ani-svc-hero__intro">
					<?php echo esc_html( $cap['lead'] ); ?>
				</p>

				<!-- Technical spec rail: short latin terms as mono chips. -->
				<?php if ( ! empty( $cap['chips'] ) ) : ?>
				<ul class="ani-svc-chips" aria-label="<?php esc_attr_e( 'טכנולוגיות ושיטות', 'ani' ); ?>">
					<?php foreach ( $cap['chips'] as $chip ) : ?>
						<li class="ani-svc-chip" dir="ltr"><?php echo esc_html( $chip ); ?></li>
					<?php endforeach; ?>
				</ul>
				<?php endif; ?>

				<div class="ani-svc-hero__actions">
					<a class="ani-btn ani-btn--primary" href="<?php echo $contact_url; ?>">
						<?php esc_html_e( 'בקשת הצעת מחיר', 'ani' ); ?>
						<svg class="ani-btn-arrow" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
							<line x1="14" y1="9" x2="4" y2="9"/>
							<polyline points="9 14 4 9 9 4"/>
						</svg>
					</a>
					<a class="ani-btn ani-btn--ghost-svc" href="<?php echo esc_attr( $wa_href ); ?>" target="_blank" rel="noopener noreferrer">
						<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false" width="18" height="18"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884"/></svg>
						<?php esc_html_e( 'שלחו הודעה', 'ani' ); ?>
					</a>
				</div>
			</div><!-- .ani-svc-hero__copy -->

			<div class="ani-svc-hero__media" data-reveal>
				<?php if ( 'video' === $cap['hero']['type'] ) : ?>
					<div class="ani-svc-video">
						<video
							class="ani-svc-video__el"
							poster="<?php echo esc_url( $assets_uri . '/' . $cap['hero']['poster'] . '.jpg' ); ?>"
							muted
							loop
							playsinline
							preload="none"
							autoplay
							aria-label="<?php echo esc_attr( $photo_alt ); ?>"
						>
							<source src="<?php echo esc_url( $assets_uri . '/' . $cap['hero']['video'] ); ?>" type="video/mp4">
						</video>
						<button type="button" class="ani-svc-video__toggle" aria-label="<?php esc_attr_e( 'השהה / נגן', 'ani' ); ?>" hidden>
							<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><rect x="6" y="5" width="4" height="14" rx="1"/><rect x="14" y="5" width="4" height="14" rx="1"/></svg>
						</button>
					</div>
				<?php else : ?>
					<img
						src="<?php echo esc_url( $assets_uri . '/' . $cap['hero']['img'] . '.webp' ); ?>"
						alt="<?php echo esc_attr( $photo_alt ); ?>"
						<?php if ( ! empty( $cap['hero']['fit'] ) && 'contain' === $cap['hero']['fit'] ) : ?>class="is-contain"<?php endif; ?>
						width="640"
						height="480"
						loading="eager"
						fetchpriority="high"
						decoding="async"
					>
				<?php endif; ?>
				<span class="ani-svc-hero__badge" dir="ltr" aria-hidden="true">A.N.I</span>
			</div>
		</div>
	</section><!-- .ani-svc-hero -->


	<!-- =========================================================== LEAD BODY -->
	<?php if ( ! empty( $cap['body'] ) ) : ?>
	<section class="ani-svc-lead" aria-label="<?php esc_attr_e( 'תיאור', 'ani' ); ?>">
		<div class="ani-container">
			<p class="ani-svc-lead__text" data-reveal><?php echo esc_html( $cap['body'] ); ?></p>
			<?php if ( ! empty( $cap['industries'] ) ) : ?>
			<ul class="ani-svc-industries" data-reveal aria-label="<?php esc_attr_e( 'תעשיות', 'ani' ); ?>">
				<?php foreach ( $cap['industries'] as $ind ) : ?>
					<li class="ani-svc-industry"><?php echo esc_html( $ind ); ?></li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
		</div>
	</section>
	<?php endif; ?>


	<!-- =========================================================== CAPABILITIES -->
	<section class="ani-svc-section" aria-labelledby="service-what-title">
		<div class="ani-container">
			<header class="ani-svc-head" data-reveal>
				<h2 class="ani-svc-head__title" id="service-what-title"><?php echo esc_html( $cap['cap_label'] ); ?></h2>
			</header>

			<div class="ani-svc-features">
				<?php foreach ( $cap['capabilities'] as $item ) : ?>
					<div class="ani-svc-feature" data-reveal>
						<span class="ani-svc-feature__icon" aria-hidden="true">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><path d="M20 6 9 17l-5-5"/></svg>
						</span>
						<p class="ani-svc-feature__text"><?php echo esc_html( $item ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>


	<!-- =========================================================== TECHNOLOGIES (3D-printing) -->
	<?php if ( ! empty( $cap['technologies'] ) ) : ?>
	<section class="ani-svc-section ani-svc-tech-block" aria-labelledby="service-tech-title">
		<div class="ani-container">
			<header class="ani-svc-head" data-reveal>
				<span class="ani-svc-head__eyebrow"><?php esc_html_e( 'הטכנולוגיות שלנו', 'ani' ); ?></span>
				<h2 class="ani-svc-head__title" id="service-tech-title"><?php esc_html_e( 'שלוש טכנולוגיות הדפסה', 'ani' ); ?></h2>
			</header>
			<div class="ani-svc-techs">
				<?php foreach ( $cap['technologies'] as $tech ) : ?>
					<article class="ani-svc-techcard" data-reveal>
						<span class="ani-svc-techcard__term" dir="ltr"><?php echo esc_html( $tech['term'] ); ?></span>
						<span class="ani-svc-techcard__sub"><?php echo esc_html( $tech['sub'] ); ?></span>
						<p class="ani-svc-techcard__desc"><?php echo esc_html( $tech['desc'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>


	<!-- =========================================================== ADVANTAGES (dark technical) -->
	<?php if ( ! empty( $cap['advantages'] ) ) : ?>
	<section class="ani-svc-section ani-svc-section--dark" aria-labelledby="service-adv-title">
		<div class="ani-container">
			<header class="ani-svc-head ani-svc-head--on-dark" data-reveal>
				<span class="ani-svc-head__eyebrow"><?php echo esc_html( $cap['adv_label'] ); ?></span>
				<h2 class="ani-svc-head__title" id="service-adv-title"><?php echo esc_html( $cap['adv_label'] ); ?></h2>
			</header>
			<ul class="ani-svc-adv">
				<?php foreach ( $cap['advantages'] as $i => $adv ) : ?>
					<li class="ani-svc-adv__item" data-reveal>
						<span class="ani-svc-adv__num" dir="ltr" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
						<span class="ani-svc-adv__text"><?php echo esc_html( $adv ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
	<?php endif; ?>


	<!-- =========================================================== PROCESS STRIP (composites) -->
	<?php if ( ! empty( $cap['process'] ) ) : ?>
	<section class="ani-svc-section ani-svc-section--surface" aria-labelledby="service-proc-title">
		<div class="ani-container">
			<header class="ani-svc-head" data-reveal>
				<span class="ani-svc-head__eyebrow"><?php esc_html_e( 'התהליך', 'ani' ); ?></span>
				<h2 class="ani-svc-head__title" id="service-proc-title"><?php esc_html_e( 'מהיריעה ועד החלק', 'ani' ); ?></h2>
			</header>
			<div class="ani-svc-process">
				<?php foreach ( $cap['process'] as $i => $step ) : ?>
					<figure class="ani-svc-process__step" data-reveal>
						<span class="ani-svc-process__num" dir="ltr" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
						<img
							src="<?php echo esc_url( $assets_uri . '/' . $step['img'] . '.webp' ); ?>"
							alt="<?php echo esc_attr( $step['cap'] ); ?>"
							width="700"
							height="500"
							loading="lazy"
							decoding="async"
						>
						<figcaption class="ani-svc-process__cap"><?php echo esc_html( $step['cap'] ); ?></figcaption>
					</figure>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>


	<!-- =========================================================== PROOF GALLERY -->
	<?php if ( ! empty( $cap['gallery'] ) ) : ?>
	<section class="ani-svc-section ani-svc-gallery-sec" aria-labelledby="service-gallery-title">
		<div class="ani-container">
			<header class="ani-svc-head" data-reveal>
				<span class="ani-svc-head__eyebrow"><?php esc_html_e( 'עבודות נבחרות', 'ani' ); ?></span>
				<h2 class="ani-svc-head__title" id="service-gallery-title"><?php echo esc_html( $cap['gallery_label'] ); ?></h2>
			</header>
			<div class="ani-svc-gallery" data-lightbox>
				<?php foreach ( $cap['gallery'] as $g ) : ?>
					<?php $g_url = esc_url( $assets_uri . '/real/gallery/' . $g . '.webp' ); ?>
					<button type="button" class="ani-svc-gallery__item" data-reveal data-full="<?php echo $g_url; ?>" aria-label="<?php esc_attr_e( 'הגדלת תמונה', 'ani' ); ?>">
						<img
							src="<?php echo $g_url; ?>"
							alt="<?php echo esc_attr( $cap['eyebrow'] ); ?>"
							width="450"
							height="450"
							loading="lazy"
							decoding="async"
						>
					</button>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>


	<!-- =========================================================== CLOSING -->
	<?php if ( ! empty( $cap['closing'] ) ) : ?>
	<section class="ani-svc-closing" aria-label="<?php esc_attr_e( 'סיכום', 'ani' ); ?>">
		<div class="ani-container">
			<p class="ani-svc-closing__text" data-reveal><?php echo esc_html( $cap['closing'] ); ?></p>
		</div>
	</section>
	<?php endif; ?>


	<!-- =========================================================== RELATED CAPABILITIES -->
	<section class="ani-svc-section ani-svc-related" aria-labelledby="service-related-title">
		<div class="ani-container">
			<header class="ani-svc-head" data-reveal>
				<span class="ani-svc-head__eyebrow"><?php esc_html_e( 'יכולות נוספות', 'ani' ); ?></span>
				<h2 class="ani-svc-head__title" id="service-related-title"><?php esc_html_e( 'שירותים נוספים שלנו', 'ani' ); ?></h2>
			</header>
			<div class="ani-svc-related__grid">
				<?php foreach ( $other_caps as $okey => $ocap ) : ?>
					<a class="ani-svc-related__card" href="<?php echo esc_url( home_url( '/' . $okey . '/' ) ); ?>" data-reveal>
						<span class="ani-svc-related__name"><?php echo esc_html( $ocap['eyebrow'] ); ?></span>
						<span class="ani-svc-related__arrow" aria-hidden="true">
							<svg viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" focusable="false"><line x1="14" y1="9" x2="4" y2="9"/><polyline points="9 14 4 9 9 4"/></svg>
						</span>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>


	<!-- =========================================================== CTA BAND -->
	<section class="cta-band ani-service-cta" aria-labelledby="service-cta-title">
		<div class="cta-band__inner">
			<h2 class="cta-band__title section-title" id="service-cta-title">
				<?php esc_html_e( 'מוכנים להתחיל?', 'ani' ); ?>
			</h2>
			<p class="cta-band__sub">
				<?php
				printf(
					/* translators: %s is the capability name */
					esc_html__( 'שלחו לנו פרטים על הפרויקט שלכם ב%s ונחזור עם הצעת מחיר בתוך 24 שעות.', 'ani' ),
					esc_html( $cap['eyebrow'] )
				);
				?>
			</p>
			<div class="cta-band__actions">
				<a class="ani-btn ani-btn--primary" href="<?php echo $contact_url; ?>">
					<?php esc_html_e( 'צרו קשר עכשיו', 'ani' ); ?>
					<svg class="ani-btn-arrow" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
						<line x1="14" y1="9" x2="4" y2="9"/>
						<polyline points="9 14 4 9 9 4"/>
					</svg>
				</a>
			</div>
		</div>
	</section>

</div><!-- .ani-service-page -->

<?php
get_footer();
