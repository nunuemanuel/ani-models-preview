<?php
/**
 * Template Name: Services Hub / שירותים
 *
 * Services hub page for A.N.I — Models & Prototypes.
 * Sections (RTL-Hebrew, verbatim client copy):
 *   1. Page hero — "השירותים שלנו" + one-stop-shop framing
 *   2. Capability card grid — 5 cards (photo + name + bullets + "פרטים נוספים" link)
 *   3. CTA band → /contact/
 *
 * Card pattern per Protolabs pattern (competitor-section-design.md §3):
 * real part photo + capability name + 2–3 bullets + detail link.
 *
 * RTL-Hebrew: logical-property CSS only; LTR isolation on latin/numbers.
 * No hardcoded hex — all via tokens.css custom properties.
 * All user-facing strings wrapped in esc_html_e() with 'ani' text-domain.
 *
 * @package ani
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$assets_uri  = get_stylesheet_directory_uri() . '/assets';
$contact_url = esc_url( home_url( '/contact/' ) );

/**
 * 5 capability cards — data-driven so the hub and detail pages share one source.
 * Each entry:
 *   slug  → page URL slug
 *   title → capability title (Hebrew)
 *   photo → filename under assets/ (or assets/parts/)
 *   photo_alt → alt text (empty string because decorative; title in card heading)
 *   bullets → array of 2–3 Hebrew bullet strings (verbatim client copy)
 */
$capabilities = array(

	array(
		'slug'      => 'composites',
		'title'     => __( 'חומרים מרוכבים', 'ani' ),
		'photo'     => 'real/heroes/composites.webp',
		'photo_alt' => '',
		'bullets'   => array(
			__( 'סיבי פחמן ופייברגלס — חלקים קלי משקל בעלי חוזק גבוה', 'ani' ),
			__( 'תכנון וייצור תבניות, צביעה וגימור למוצר סופי', 'ani' ),
			__( 'מכלולים לתעופה ולרחפנים', 'ani' ),
		),
	),

	array(
		'slug'      => 'cnc',
		'title'     => __( 'עיבוד שבבי CNC', 'ani' ),
		'photo'     => 'real/gallery/cnc-02.webp',
		'photo_alt' => '',
		'bullets'   => array(
			__( 'כרסום 3/4/5 צירים — חלקים מדויקים, בודדים וסדרות קטנות', 'ani' ),
			__( 'מתקנים, ג\'יגים וכלי עזר לייצור', 'ani' ),
			__( 'אלומיניום, פלדות, נירוסטה, טיטניום, פלסטיקה הנדסית וחומרים מרוכבים', 'ani' ),
		),
	),

	array(
		'slug'      => '3d-printing',
		'title'     => __( 'הדפסות תלת-ממד', 'ani' ),
		'photo'     => 'real/heroes/printing.webp',
		'photo_alt' => '',
		'bullets'   => array(
			__( 'FDM · SLS · SLA — טכנולוגיות הדפסה מתקדמות', 'ani' ),
			__( 'חלקים הנדסיים, אבות טיפוס, מתקנים, תבניות וחלקים סופיים', 'ani' ),
			__( 'ייצור מהיר ומדויק במגוון רחב של חומרים', 'ani' ),
		),
	),

	array(
		'slug'      => 'scanning',
		'title'     => __( 'סריקה והנדסה לאחור', 'ani' ),
		'photo'     => 'real/heroes/scanning.webp',
		'photo_alt' => '',
		'bullets'   => array(
			__( 'סריקת CMM, הנדסה לאחור, בניית מודלים תלת-ממדיים', 'ani' ),
			__( 'בקרת איכות ומדידות — השוואת CAD מול חלק מיוצר', 'ani' ),
			__( 'שחזור חלקים ללא שרטוט', 'ani' ),
		),
	),

	array(
		'slug'      => 'integration',
		'title'     => __( 'הרכבות ואינטגרציה', 'ani' ),
		'photo'     => 'real/heroes/integration.webp',
		'photo_alt' => '',
		'bullets'   => array(
			__( 'הרכבות מכניות ואלקטרו-מכניות', 'ani' ),
			__( 'שילוב רכיבים אלקטרוניים ואינטגרציה של מכלולים', 'ani' ),
			__( 'בדיקות ותהליכי אימות', 'ani' ),
		),
	),

);
?>

<div class="ani-services-page">

	<!-- =========================================================== SECTION 1: HERO -->
	<section class="ani-services-hero section" aria-labelledby="services-hero-title">
		<div class="ani-container">

			<p class="eyebrow"><?php esc_html_e( 'יכולות הליבה שלנו', 'ani' ); ?></p>

			<h1 class="section-title" id="services-hero-title">
				<?php esc_html_e( 'השירותים שלנו', 'ani' ); ?>
			</h1>

			<p class="ani-services-hero__intro">
				<?php esc_html_e( 'א.נ.י מספקת את כל שלבי הפיתוח והייצור תחת קורת גג אחת — מתכנון הנדסי ועד מוצר מוגמר. גמישות, מהירות ואיכות ללא פשרות.', 'ani' ); ?>
			</p>

			<!-- One-stop-shop value summary -->
			<div class="ani-services-hero__props">
				<div class="ani-services-hero__prop">
					<span class="ani-services-hero__prop-icon" aria-hidden="true">
						<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
							<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
							<polyline points="9 22 9 12 15 12 15 22"/>
						</svg>
					</span>
					<span><?php esc_html_e( 'One Stop Shop אמיתי', 'ani' ); ?></span>
				</div>
				<div class="ani-services-hero__prop">
					<span class="ani-services-hero__prop-icon" aria-hidden="true">
						<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
							<circle cx="12" cy="12" r="10"/>
							<polyline points="12 6 12 12 16 14"/>
						</svg>
					</span>
					<span><?php esc_html_e( 'זמני אספקה קצרים', 'ani' ); ?></span>
				</div>
				<div class="ani-services-hero__prop">
					<span class="ani-services-hero__prop-icon" aria-hidden="true">
						<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
							<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
						</svg>
					</span>
					<span><?php esc_html_e( 'ביטחון, תעופה ותעשייה מתקדמת', 'ani' ); ?></span>
				</div>
			</div><!-- .ani-services-hero__props -->

		</div><!-- .ani-container -->
	</section><!-- .ani-services-hero -->


	<!-- =========================================================== SECTION 2: CAPABILITY CARDS GRID -->
	<section class="section section--surface ani-services-grid" aria-labelledby="services-grid-title">
		<div class="ani-container">

			<h2 class="section-title section-title--center" id="services-grid-title">
				<?php esc_html_e( 'יכולות הייצור שלנו', 'ani' ); ?>
			</h2>

			<div class="ani-cap-grid" role="list">

				<?php foreach ( $capabilities as $cap ) : ?>

				<article class="ani-cap-card" role="listitem">

					<!-- Part photo -->
					<div class="ani-cap-card__photo" aria-hidden="true">
						<img
							src="<?php echo esc_url( $assets_uri . '/' . $cap['photo'] ); ?>"
							alt="<?php echo esc_attr( $cap['photo_alt'] ); ?>"
							loading="lazy"
							decoding="async"
							width="400"
							height="260"
						>
					</div><!-- .ani-cap-card__photo -->

					<div class="ani-cap-card__body">

						<h3 class="ani-cap-card__title">
							<?php echo esc_html( $cap['title'] ); ?>
						</h3>

						<ul class="ani-cap-card__bullets" aria-label="<?php echo esc_attr( $cap['title'] ); ?>">
							<?php foreach ( $cap['bullets'] as $bullet ) : ?>
								<li><?php echo esc_html( $bullet ); ?></li>
							<?php endforeach; ?>
						</ul>

						<a
							class="ani-cap-card__link link-arrow"
							href="<?php echo esc_url( home_url( '/' . $cap['slug'] . '/' ) ); ?>"
							aria-label="<?php printf( esc_attr__( 'פרטים נוספים על %s', 'ani' ), esc_attr( $cap['title'] ) ); ?>"
						>
							<?php esc_html_e( 'פרטים נוספים', 'ani' ); ?>
							<svg width="16" height="16" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
								<line x1="14" y1="9" x2="4" y2="9"/>
								<polyline points="9 14 4 9 9 4"/>
							</svg>
						</a>

					</div><!-- .ani-cap-card__body -->

				</article><!-- .ani-cap-card -->

				<?php endforeach; ?>

			</div><!-- .ani-cap-grid -->

		</div><!-- .ani-container -->
	</section><!-- .ani-services-grid -->


	<!-- =========================================================== SECTION 3: CTA BAND -->
	<section class="cta-band ani-services-cta" aria-labelledby="services-cta-title">
		<div class="cta-band__inner">
			<h2 class="cta-band__title section-title" id="services-cta-title">
				<?php esc_html_e( 'מוכנים להתחיל פרויקט?', 'ani' ); ?>
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
	</section><!-- .ani-services-cta -->

</div><!-- .ani-services-page -->

<?php
get_footer();
