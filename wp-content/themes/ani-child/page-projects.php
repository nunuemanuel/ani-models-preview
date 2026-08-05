<?php
/**
 * Template Name: Projects / פרויקטים
 *
 * Portfolio / projects gallery page for A.N.I — Models & Prototypes.
 * Sections (RTL-Hebrew, factual captions only):
 *   1. Page hero — "פרויקטים" + 1-line intro
 *   2. Filterable gallery — 5 capability categories + "הכל" (all)
 *      CSS/JS progressive enhancement: all items in DOM, data-category attr,
 *      vanilla JS toggles visibility; no-JS = all show.
 *   3. CTA band → /contact/
 *
 * Images: WebP primary + JPG fallback via <picture>; loading=lazy;
 *         width/height set to avoid CLS; alt text factual Hebrew captions.
 *
 * RTL-Hebrew: logical-property CSS only; LTR isolation on latin/numbers.
 * No hardcoded hex — all via tokens.css custom properties.
 * All user-facing strings wrapped in esc_html_e()/esc_html__() with 'ani' text-domain.
 *
 * @package ani
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$assets_uri  = get_stylesheet_directory_uri() . '/assets';
$portfolio   = $assets_uri . '/portfolio';
$contact_url = esc_url( home_url( '/contact/' ) );

/**
 * Portfolio items — 21 items across 5 capability categories.
 * Data source: .nexo/intake/photos/CURATION-manifest.md
 *
 * Keys:
 *   file     — base filename (no extension; both .webp + .jpg exist)
 *   category — matches a filter slug: composites | cnc | 3d-printing | scanning | integration
 *   alt      — factual Hebrew caption (part type + process); '' = decorative
 *   w, h     — intrinsic pixel dimensions for CLS prevention (approximate from manifest notes)
 */
$portfolio_items = array(

	/* ---- חומרים מרוכבים (Composites) — 7 items ---- */
	array(
		'file'     => 'composite-fuselage-blue',
		'category' => 'composites',
		'alt'      => 'גוף מזלט מחומר מרוכב — ציפוי ג\'ל כחול',
		'w'        => 800,
		'h'        => 533,
	),
	array(
		'file'     => 'composite-aero-shell-grey',
		'category' => 'composites',
		'alt'      => 'קליפת אווירודינמית מחומר מרוכב — אפור חלק',
		'w'        => 800,
		'h'        => 533,
	),
	array(
		'file'     => 'composite-channel-blue',
		'category' => 'composites',
		'alt'      => 'פרופיל V מחומר מרוכב — כחול, לשימוש אווירי',
		'w'        => 800,
		'h'        => 533,
	),
	array(
		'file'     => 'composite-wing-shells-teal',
		'category' => 'composites',
		'alt'      => 'שתי חצאי כנף מחומר מרוכב — צבע כחול-ירקרק',
		'w'        => 690,
		'h'        => 460,
	),
	array(
		'file'     => 'composite-shell-green-mold',
		'category' => 'composites',
		'alt'      => 'קליפת חומר מרוכב ירוקה על תבנית — שלב ייצור',
		'w'        => 800,
		'h'        => 533,
	),
	array(
		'file'     => 'composite-intake-duct-teal',
		'category' => 'composites',
		'alt'      => 'תעלת אוויר מחומר מרוכב — צבע כחול-ירקרק',
		'w'        => 800,
		'h'        => 533,
	),
	array(
		'file'     => 'carbon-fiber-layup-hand',
		'category' => 'composites',
		'alt'      => 'הנחת בד סיבי פחמן ביד — תהליך ייצור',
		'w'        => 800,
		'h'        => 533,
	),

	/* ---- עיבוד שבבי CNC — 7 items ---- */
	array(
		'file'     => 'cnc-aluminum-bracket-lightweighted',
		'category' => 'cnc',
		'alt'      => 'סגר אלומיניום מקולף CNC — קל משקל לתעופה',
		'w'        => 800,
		'h'        => 533,
	),
	array(
		'file'     => 'cnc-composite-bracket-multibore',
		'category' => 'cnc',
		'alt'      => 'סגר שחור רב-נקבים — עיבוד CNC',
		'w'        => 800,
		'h'        => 533,
	),
	array(
		'file'     => 'cnc-aluminum-enclosure',
		'category' => 'cnc',
		'alt'      => 'מארז אלומיניום מחוזר CNC',
		'w'        => 800,
		'h'        => 533,
	),
	array(
		'file'     => 'cnc-flange-boltcircle-macro',
		'category' => 'cnc',
		'alt'      => 'פלאנג\' עגול עם מעגל ברגים — עיבוד מדויק CNC',
		'w'        => 800,
		'h'        => 533,
	),
	array(
		'file'     => 'cnc-structural-bracket-pair',
		'category' => 'cnc',
		'alt'      => 'סגר ייצור שחור לצד אב-טיפוס לבן — עיבוד CNC',
		'w'        => 800,
		'h'        => 533,
	),
	array(
		'file'     => 'stainless-tray-machined',
		'category' => 'cnc',
		'alt'      => 'מגש נירוסטה מלוטש — עיבוד CNC לתחום רפואי',
		'w'        => 800,
		'h'        => 533,
	),
	array(
		'file'     => 'stainless-vessel-lid',
		'category' => 'cnc',
		'alt'      => 'כלי נירוסטה עם מכסה — עיבוד CNC',
		'w'        => 800,
		'h'        => 533,
	),

	/* ---- הדפסות תלת-ממד — 3 items ---- */
	array(
		'file'     => '3dprint-bracket-green',
		'category' => '3d-printing',
		'alt'      => 'סגר ירוק מודפס תלת-ממד — FDM, עם בוסים להרכבה',
		'w'        => 800,
		'h'        => 533,
	),
	array(
		'file'     => '3dprint-parts-array-grey',
		'category' => '3d-printing',
		'alt'      => 'מגש חלקים אפורים מודפסי SLS — מנה קטנה',
		'w'        => 800,
		'h'        => 533,
	),
	array(
		'file'     => 'moldbase-cavity-array-black',
		'category' => '3d-printing',
		'alt'      => 'מערך חללי תבניות שחורות — כלי עזר לייצור',
		'w'        => 800,
		'h'        => 533,
	),

	/* ---- סריקה והנדסה לאחור — 2 items ---- */
	array(
		'file'     => 'scan-structured-light-aircraft',
		'category' => 'scanning',
		'alt'      => 'סריקת אור מובנה על מודל מטוס — תהליך הנדסה לאחור',
		'w'        => 800,
		'h'        => 533,
	),
	array(
		'file'     => 'scan-structured-light-turntable',
		'category' => 'scanning',
		'alt'      => 'סריקת חלק על שולחן סיבוב — אור מובנה',
		'w'        => 800,
		'h'        => 533,
	),

	/* ---- הרכבות ואינטגרציה — 3 items ---- */
	array(
		'file'     => 'integration-panel-black',
		'category' => 'integration',
		'alt'      => 'לוח בקרה שחור — הרכבה ואינטגרציה אלקטרונית',
		'w'        => 800,
		'h'        => 533,
	),
	array(
		'file'     => 'integration-enclosure-white',
		'category' => 'integration',
		'alt'      => 'מארז אלקטרוניקה לבן קומפקטי — חיתוך פורטים',
		'w'        => 800,
		'h'        => 533,
	),
	array(
		'file'     => 'drone-motor-mount-cnc',
		'category' => 'integration',
		'alt'      => 'מסגרת הרכבת מנועים CNC לרחפן רב-ציר',
		'w'        => 800,
		'h'        => 533,
	),
);

/**
 * Filter tabs — slug => Hebrew label.
 */
$filter_tabs = array(
	'all'         => __( 'הכל', 'ani' ),
	'composites'  => __( 'חומרים מרוכבים', 'ani' ),
	'cnc'         => __( 'עיבוד שבבי CNC', 'ani' ),
	'3d-printing' => __( 'הדפסות תלת-ממד', 'ani' ),
	'scanning'    => __( 'סריקה והנדסה לאחור', 'ani' ),
	'integration' => __( 'הרכבות ואינטגרציה', 'ani' ),
);
?>

<div class="ani-projects-page">

	<!-- ============================================================ SECTION 1: HERO -->
	<section class="ani-projects-hero section" aria-labelledby="projects-hero-title">
		<div class="ani-container">

			<p class="eyebrow"><?php esc_html_e( 'העבודות שלנו', 'ani' ); ?></p>

			<h1 class="section-title" id="projects-hero-title">
				<?php esc_html_e( 'פרויקטים', 'ani' ); ?>
			</h1>

			<p class="ani-projects-hero__intro">
				<?php /* TODO: confirm Hebrew intro with client */ ?>
				<?php esc_html_e( 'חלקים ומכלולים שייצרנו עבור לקוחות מתחומי הביטחון, התעופה, הרחפנים, הרפואה והאלקטרוניקה — מחומרים מרוכבים, עיבוד CNC, הדפסות תלת-ממד, סריקה והרכבות.', 'ani' ); ?>
			</p>

		</div><!-- .ani-container -->
	</section><!-- .ani-projects-hero -->


	<!-- ============================================================ SECTION 2: FILTERABLE GALLERY -->
	<section class="section section--surface ani-projects-gallery" aria-labelledby="projects-gallery-title">
		<div class="ani-container">

			<h2 class="screen-reader-text" id="projects-gallery-title">
				<?php esc_html_e( 'גלריית פרויקטים', 'ani' ); ?>
			</h2>

			<!-- Filter tabs — JS progressively enhances; no-JS: all visible -->
			<nav class="ani-projects-filters" aria-label="<?php esc_attr_e( 'סינון לפי יכולת', 'ani' ); ?>">
				<ul class="ani-projects-filter-list" role="list">
					<?php foreach ( $filter_tabs as $slug => $label ) : ?>
					<li role="listitem">
						<button
							class="ani-projects-filter-btn<?php echo ( 'all' === $slug ) ? ' is-active' : ''; ?>"
							data-filter="<?php echo esc_attr( $slug ); ?>"
							aria-pressed="<?php echo ( 'all' === $slug ) ? 'true' : 'false'; ?>"
							type="button"
						>
							<?php echo esc_html( $label ); ?>
						</button>
					</li>
					<?php endforeach; ?>
				</ul>
			</nav><!-- .ani-projects-filters -->

			<!-- Gallery grid — all items always rendered; JS toggles .is-hidden -->
			<div
				class="ani-projects-grid"
				role="list"
				aria-live="polite"
				aria-label="<?php esc_attr_e( 'פרויקטים', 'ani' ); ?>"
			>

				<?php foreach ( $portfolio_items as $item ) : ?>

				<figure
					class="ani-project-card"
					data-category="<?php echo esc_attr( $item['category'] ); ?>"
					role="listitem"
				>
					<div class="ani-project-card__media">
						<picture>
							<source
								srcset="<?php echo esc_url( $portfolio . '/' . $item['file'] . '.webp' ); ?>"
								type="image/webp"
							>
							<img
								src="<?php echo esc_url( $portfolio . '/' . $item['file'] . '.jpg' ); ?>"
								alt="<?php echo esc_attr( $item['alt'] ); ?>"
								width="<?php echo absint( $item['w'] ); ?>"
								height="<?php echo absint( $item['h'] ); ?>"
								loading="lazy"
								decoding="async"
							>
						</picture>
					</div><!-- .ani-project-card__media -->

					<?php if ( '' !== $item['alt'] ) : ?>
					<figcaption class="ani-project-card__caption">
						<?php echo esc_html( $item['alt'] ); ?>
					</figcaption>
					<?php endif; ?>

				</figure><!-- .ani-project-card -->

				<?php endforeach; ?>

			</div><!-- .ani-projects-grid -->

		</div><!-- .ani-container -->
	</section><!-- .ani-projects-gallery -->


	<!-- ============================================================ SECTION 3: CTA BAND -->
	<section class="cta-band ani-projects-cta" aria-labelledby="projects-cta-title">
		<div class="cta-band__inner">
			<h2 class="cta-band__title section-title" id="projects-cta-title">
				<?php esc_html_e( 'יש לכם פרויקט דומה?', 'ani' ); ?>
			</h2>
			<p class="cta-band__sub">
				<?php esc_html_e( 'שלחו לנו את פרטי הפרויקט וקובץ ה-CAD — נחזור אליכם עם הצעת מחיר בתוך 24 שעות.', 'ani' ); ?>
			</p>
			<a class="ani-btn ani-btn--primary" href="<?php echo $contact_url; ?>">
				<?php esc_html_e( 'צרו קשר עכשיו', 'ani' ); ?>
				<svg class="ani-btn-arrow" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
					<line x1="14" y1="9" x2="4" y2="9"/>
					<polyline points="9 14 4 9 9 4"/>
				</svg>
			</a>
		</div><!-- .cta-band__inner -->
	</section><!-- .ani-projects-cta -->

</div><!-- .ani-projects-page -->

<?php
get_footer();
