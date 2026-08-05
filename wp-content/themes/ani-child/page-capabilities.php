<?php
/**
 * Template Name: Capabilities & Equipment / יכולות וציוד
 *
 * Technical-buyer proof page for A.N.I — Models & Prototypes.
 * Sections (RTL-Hebrew, verbatim client copy):
 *   1. Page hero — title + 1-line intro
 *   2. 3D Printing machine park — spec cards grouped by process
 *   3. CNC machining centers — materials + axes spec
 *   4. Scanning & CMM — industrial scanners, reverse engineering
 *   5. Finishing, QC & Integration — stations
 *   6. Materials overview — per-process chip groups
 *   7. CTA band → /contact/
 *
 * RTL-Hebrew: logical-property CSS only; LTR isolation on latin/numbers/machine-names.
 * No hardcoded hex — all via tokens.css custom properties.
 * All user-facing strings wrapped in esc_html_e() / esc_html__() with 'ani' text-domain.
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
?>

<div class="ani-capabilities-page">

	<!-- ========================================================= SECTION 1: HERO -->
	<section class="ani-cap-hero section" aria-labelledby="cap-hero-title">
		<div class="ani-container">

			<p class="eyebrow"><?php esc_html_e( 'הציוד והטכנולוגיות שלנו', 'ani' ); ?></p>

			<h1 class="section-title" id="cap-hero-title">
				<?php esc_html_e( 'יכולות וציוד', 'ani' ); ?>
			</h1>

			<p class="ani-cap-hero__intro">
				<?php esc_html_e( 'מכונות תעשייתיות אמיתיות, מוכחות בפרויקטים מורכבים — זו ההוכחה שלנו ליכולת. מרכזי עיבוד CNC, מדפסות תלת-ממד מתקדמות, ציוד CMM וסריקה ותחנות גימור — הכל תחת קורת גג אחת.', 'ani' ); ?>
			</p>

		</div><!-- .ani-container -->
	</section><!-- .ani-cap-hero -->


	<!-- ========================================================= SECTION 2: 3D PRINTING -->
	<section class="section section--surface ani-cap-group" aria-labelledby="cap-3dp-title">
		<div class="ani-container">

			<div class="ani-cap-group__header">
				<span class="ani-cap-group__icon" aria-hidden="true">
					<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
						<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
					</svg>
				</span>
				<h2 class="section-title" id="cap-3dp-title">
					<?php esc_html_e( 'הדפסה תלת-ממד', 'ani' ); ?>
				</h2>
			</div>

			<p class="ani-cap-group__intro">
				<?php esc_html_e( 'ארבע טכנולוגיות הדפסה תעשייתיות — FDM, SLA, SLS — לחלקים הנדסיים, אבות טיפוס ומוצרים סופיים.', 'ani' ); ?>
			</p>

			<div class="ani-cap-spec-grid">

				<!-- FlashForge Creator 4S -->
				<div class="ani-cap-spec-card">
					<span class="ani-cap-spec-card__name" dir="ltr">FlashForge Creator 4S</span>
					<span class="ani-cap-spec-card__process" dir="ltr">FDM</span>
					<ul class="ani-cap-spec-card__details">
						<li><?php esc_html_e( 'פולימרים הנדסיים מתקדמים', 'ani' ); ?></li>
						<li><bdi dir="ltr">ABS · ASA · PETG · TPU · PA-CF</bdi></li>
						<li><?php esc_html_e( 'חלקים הנדסיים ואבות טיפוס', 'ani' ); ?></li>
					</ul>
				</div>

				<!-- Sintratec S2 -->
				<div class="ani-cap-spec-card">
					<span class="ani-cap-spec-card__name" dir="ltr">Sintratec S2</span>
					<span class="ani-cap-spec-card__process" dir="ltr">SLS</span>
					<ul class="ani-cap-spec-card__details">
						<li><?php esc_html_e( 'ניילון ופולימרים ללא תמיכות', 'ani' ); ?></li>
						<li><bdi dir="ltr">PA12 · PA11</bdi></li>
						<li><?php esc_html_e( 'חלקים מורכבים ופונקציונליים', 'ani' ); ?></li>
					</ul>
				</div>

				<!-- Sonic Mega V2 -->
				<div class="ani-cap-spec-card">
					<span class="ani-cap-spec-card__name" dir="ltr">Sonic Mega V2</span>
					<span class="ani-cap-spec-card__process" dir="ltr">SLA (Resin)</span>
					<ul class="ani-cap-spec-card__details">
						<li><?php esc_html_e( 'רזולוציה גבוהה, גימור חלק', 'ani' ); ?></li>
						<li><?php esc_html_e( 'שרף אנדסי ורפואי', 'ani' ); ?></li>
						<li><?php esc_html_e( 'אבות טיפוס ויציקות ישירות', 'ani' ); ?></li>
					</ul>
				</div>

				<!-- Formlabs Fuse -->
				<div class="ani-cap-spec-card">
					<span class="ani-cap-spec-card__name" dir="ltr">Formlabs Fuse</span>
					<span class="ani-cap-spec-card__process" dir="ltr">SLS — Industrial</span>
					<ul class="ani-cap-spec-card__details">
						<li><?php esc_html_e( 'SLS תעשייתי לחלקים מתקדמים', 'ani' ); ?></li>
						<li><bdi dir="ltr">Nylon PA12</bdi></li>
						<li><?php esc_html_e( 'ייצור חלקים סופיים', 'ani' ); ?></li>
					</ul>
				</div>

			</div><!-- .ani-cap-spec-grid -->

			<!-- Section image -->
			<div class="ani-cap-group__img" aria-hidden="true">
				<img
					src="<?php echo esc_url( $assets_uri . '/sections/composite.png' ); ?>"
					alt=""
					loading="lazy"
					decoding="async"
					width="1200"
					height="480"
				>
			</div>

		</div><!-- .ani-container -->
	</section><!-- .ani-cap-group -->


	<!-- ========================================================= SECTION 3: CNC -->
	<section class="section ani-cap-group" aria-labelledby="cap-cnc-title">
		<div class="ani-container">

			<div class="ani-cap-group__header">
				<span class="ani-cap-group__icon" aria-hidden="true">
					<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
						<circle cx="12" cy="12" r="3"/>
						<path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/>
					</svg>
				</span>
				<h2 class="section-title" id="cap-cnc-title">
					<?php esc_html_e( 'עיבוד שבבי CNC', 'ani' ); ?>
				</h2>
			</div>

			<p class="ani-cap-group__intro">
				<?php esc_html_e( 'כרסום 3, 4 ו-5 צירים לחלקים מדויקים — מחלק בודד ועד סדרות קטנות, עם יכולת לעבד מגוון רחב של חומרים לדרישות ביטחון, תעופה ורפואה.', 'ani' ); ?>
			</p>

			<div class="ani-cap-cnc-split">

				<!-- Equipment -->
				<div class="ani-cap-cnc-equip">
					<h3 class="ani-cap-subhead"><?php esc_html_e( 'הציוד', 'ani' ); ?></h3>
					<ul class="ani-service-equip-list">
						<li class="ani-service-equip-item">
							<span class="ani-service-equip-item__name" dir="ltr">CNC Machining Centers (3/4/5-axis)</span>
							<span class="ani-service-equip-item__desc"><?php esc_html_e( 'מרכזי עיבוד CNC — 3/4/5 צירים, חלקים מדויקים לדרישות מחמירות', 'ani' ); ?></span>
						</li>
					</ul>

					<h3 class="ani-cap-subhead" style="margin-block-start: 28px;"><?php esc_html_e( 'יכולות', 'ani' ); ?></h3>
					<ul class="ani-service-bullets">
						<li class="ani-service-bullets__item">
							<span class="ani-service-bullets__dot" aria-hidden="true"></span>
							<?php esc_html_e( 'כרסום בצירים 3, 4 ו-5 — חלקים מדויקים לדרישות מחמירות', 'ani' ); ?>
						</li>
						<li class="ani-service-bullets__item">
							<span class="ani-service-bullets__dot" aria-hidden="true"></span>
							<?php esc_html_e( 'חלקים בודדים וסדרות קטנות — גמישות מלאה בהיקף הייצור', 'ani' ); ?>
						</li>
						<li class="ani-service-bullets__item">
							<span class="ani-service-bullets__dot" aria-hidden="true"></span>
							<?php esc_html_e( 'מתקנים, ג\'יגים וכלי עזר לקווי ייצור', 'ani' ); ?>
						</li>
						<li class="ani-service-bullets__item">
							<span class="ani-service-bullets__dot" aria-hidden="true"></span>
							<?php esc_html_e( 'מוקאפים ודגמי הדגמה לתכנון ואבות טיפוס', 'ani' ); ?>
						</li>
					</ul>
				</div>

				<!-- Materials -->
				<div class="ani-cap-cnc-mats">
					<h3 class="ani-cap-subhead"><?php esc_html_e( 'חומרים', 'ani' ); ?></h3>

					<?php
					$cnc_materials = array(
						array( 'term' => 'Aluminum 6061/7075', 'desc' => __( 'אלומיניום — קל, יחס חוזק/משקל מצוין', 'ani' ) ),
						array( 'term' => 'Steel / Stainless', 'desc' => __( 'פלדות ונירוסטה — חוזק ועמידות גבוהים', 'ani' ) ),
						array( 'term' => 'Titanium',           'desc' => __( 'טיטניום — ביצועים גבוהים לביטחון ותעופה', 'ani' ) ),
						array( 'term' => 'Copper / Brass',     'desc' => __( 'נחושת — מוליכות חשמלית ותרמית', 'ani' ) ),
						array( 'term' => 'Engineering Plastics', 'desc' => __( 'פלסטיקה הנדסית — Delrin, PEEK, Nylon', 'ani' ) ),
						array( 'term' => 'Composites',          'desc' => __( 'חומרים מרוכבים — עיבוד שבבי של פחמן ופייברגלס', 'ani' ) ),
					);
					?>
					<div class="ani-service-mat-grid">
						<?php foreach ( $cnc_materials as $mat ) : ?>
							<div class="ani-service-mat-card">
								<span class="ani-service-mat-card__term" dir="ltr"><?php echo esc_html( $mat['term'] ); ?></span>
								<span class="ani-service-mat-card__desc"><?php echo esc_html( $mat['desc'] ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
				</div>

			</div><!-- .ani-cap-cnc-split -->

			<!-- Section image -->
			<div class="ani-cap-group__img" aria-hidden="true">
				<img
					src="<?php echo esc_url( $assets_uri . '/sections/cnc.png' ); ?>"
					alt=""
					loading="lazy"
					decoding="async"
					width="1200"
					height="480"
				>
			</div>

		</div><!-- .ani-container -->
	</section><!-- .ani-cap-group (CNC) -->


	<!-- ========================================================= SECTION 4: SCANNING & CMM -->
	<section class="section section--surface ani-cap-group" aria-labelledby="cap-scan-title">
		<div class="ani-container">

			<div class="ani-cap-group__header">
				<span class="ani-cap-group__icon" aria-hidden="true">
					<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
						<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
						<circle cx="12" cy="12" r="3"/>
					</svg>
				</span>
				<h2 class="section-title" id="cap-scan-title">
					<?php esc_html_e( 'סריקה תלת-ממדית ו-CMM', 'ani' ); ?>
				</h2>
			</div>

			<p class="ani-cap-group__intro">
				<?php esc_html_e( 'סריקה תעשייתית מדויקת, הנדסה לאחור ובקרת איכות — כולל שחזור חלקים ללא שרטוט מקורי.', 'ani' ); ?>
			</p>

			<div class="ani-cap-spec-grid">

				<div class="ani-cap-spec-card">
					<span class="ani-cap-spec-card__name" dir="ltr">Precision Industrial Scanners</span>
					<span class="ani-cap-spec-card__process"><?php esc_html_e( 'סריקה תעשייתית', 'ani' ); ?></span>
					<ul class="ani-cap-spec-card__details">
						<li><?php esc_html_e( 'סריקת חלקים ומכלולים מורכבים', 'ani' ); ?></li>
						<li><?php esc_html_e( 'הנדסה לאחור ובניית מודלים תלת-ממדיים', 'ani' ); ?></li>
						<li><?php esc_html_e( 'שחזור חלקים קיימים ללא שרטוט מקורי', 'ani' ); ?></li>
					</ul>
				</div>

				<div class="ani-cap-spec-card">
					<span class="ani-cap-spec-card__name" dir="ltr">CMM Equipment</span>
					<span class="ani-cap-spec-card__process"><?php esc_html_e( 'מטרולוגיה ובקרת איכות', 'ani' ); ?></span>
					<ul class="ani-cap-spec-card__details">
						<li><?php esc_html_e( 'מדידת CMM — נקודות ומשטחים בדיוק מיקרון', 'ani' ); ?></li>
						<li><?php esc_html_e( 'בקרת איכות — השוואת מודל CAD לחלק מיוצר', 'ani' ); ?></li>
						<li><?php esc_html_e( 'אימות פרופיל חלק מול מפרט לפני אספקה', 'ani' ); ?></li>
					</ul>
				</div>

			</div><!-- .ani-cap-spec-grid -->

			<!-- Section image -->
			<div class="ani-cap-group__img" aria-hidden="true">
				<img
					src="<?php echo esc_url( $assets_uri . '/sections/cmm.png' ); ?>"
					alt=""
					loading="lazy"
					decoding="async"
					width="1200"
					height="480"
				>
			</div>

		</div><!-- .ani-container -->
	</section><!-- .ani-cap-group (scanning) -->


	<!-- ========================================================= SECTION 5: FINISHING, QC & INTEGRATION -->
	<section class="section ani-cap-group" aria-labelledby="cap-finish-title">
		<div class="ani-container">

			<div class="ani-cap-group__header">
				<span class="ani-cap-group__icon" aria-hidden="true">
					<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
						<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
					</svg>
				</span>
				<h2 class="section-title" id="cap-finish-title">
					<?php esc_html_e( 'גימור, בקרת איכות והרכבה', 'ani' ); ?>
				</h2>
			</div>

			<p class="ani-cap-group__intro">
				<?php esc_html_e( 'לאחר הייצור — עמדות גימור, ניקוי וחציץ, בקרת איכות מקצועית והרכבות מכניות ואלקטרו-מכניות לפני אספקה.', 'ani' ); ?>
			</p>

			<ul class="ani-service-equip-list">

				<li class="ani-service-equip-item">
					<span class="ani-service-equip-item__name"><?php esc_html_e( 'עמדות גימור וניקוי', 'ani' ); ?></span>
					<span class="ani-service-equip-item__desc"><?php esc_html_e( 'ניקוי, חציץ (sandblasting), גימור שטח', 'ani' ); ?></span>
				</li>

				<li class="ani-service-equip-item">
					<span class="ani-service-equip-item__name"><?php esc_html_e( 'עמדות בקרת איכות', 'ani' ); ?></span>
					<span class="ani-service-equip-item__desc"><?php esc_html_e( 'ציוד מדידה ובקרת איכות מקצועי', 'ani' ); ?></span>
				</li>

				<li class="ani-service-equip-item">
					<span class="ani-service-equip-item__name"><?php esc_html_e( 'הרכבה ואינטגרציה', 'ani' ); ?></span>
					<span class="ani-service-equip-item__desc"><?php esc_html_e( 'הרכבות מכניות, אלקטרו-מכניות ואלקטרוניות', 'ani' ); ?></span>
				</li>

				<li class="ani-service-equip-item">
					<span class="ani-service-equip-item__name"><?php esc_html_e( 'בדיקות ואימות', 'ani' ); ?></span>
					<span class="ani-service-equip-item__desc"><?php esc_html_e( 'בדיקות פונקציונליות ותהליכי אימות לפני אספקה', 'ani' ); ?></span>
				</li>

			</ul>

			<!-- Section image -->
			<div class="ani-cap-group__img" aria-hidden="true">
				<img
					src="<?php echo esc_url( $assets_uri . '/sections/facility.png' ); ?>"
					alt=""
					loading="lazy"
					decoding="async"
					width="1200"
					height="480"
				>
			</div>

		</div><!-- .ani-container -->
	</section><!-- .ani-cap-group (finishing) -->


	<!-- ========================================================= SECTION 6: MATERIALS OVERVIEW -->
	<section class="section section--surface ani-cap-materials" aria-labelledby="cap-mats-title">
		<div class="ani-container">

			<h2 class="section-title section-title--center" id="cap-mats-title">
				<?php esc_html_e( 'חומרים לפי תהליך', 'ani' ); ?>
			</h2>

			<div class="mat-chip-grid">

				<!-- 3D Printing materials -->
				<div class="mat-chip-group">
					<span class="mat-chip-group__label"><?php esc_html_e( 'הדפסה תלת-ממד', 'ani' ); ?></span>
					<div class="mat-chip-row">
						<?php
						$fdm_mats = array( 'ABS', 'ASA', 'PETG', 'TPU', 'PA-CF', 'PA12 (SLS)', 'Resin (SLA)' );
						foreach ( $fdm_mats as $m ) :
							?>
							<span class="mat-chip">
								<span class="mat-chip__name"><?php echo esc_html( $m ); ?></span>
							</span>
						<?php endforeach; ?>
					</div>
				</div>

				<!-- CNC materials -->
				<div class="mat-chip-group">
					<span class="mat-chip-group__label"><?php esc_html_e( 'עיבוד שבבי CNC', 'ani' ); ?></span>
					<div class="mat-chip-row">
						<?php
						$cnc_mats = array( 'Aluminum 6061', 'Aluminum 7075', 'Steel', 'Stainless Steel', 'Titanium', 'Copper', 'PEEK', 'Delrin', 'Nylon', 'Carbon Fiber Composites' );
						foreach ( $cnc_mats as $m ) :
							?>
							<span class="mat-chip">
								<span class="mat-chip__name"><?php echo esc_html( $m ); ?></span>
							</span>
						<?php endforeach; ?>
					</div>
				</div>

				<!-- Composites -->
				<div class="mat-chip-group">
					<span class="mat-chip-group__label"><?php esc_html_e( 'חומרים מרוכבים', 'ani' ); ?></span>
					<div class="mat-chip-row">
						<?php
						$comp_mats = array( 'Carbon Fiber', 'Fiberglass', 'Epoxy Resin', 'Prepreg', 'Hand Lay-Up' );
						foreach ( $comp_mats as $m ) :
							?>
							<span class="mat-chip">
								<span class="mat-chip__name"><?php echo esc_html( $m ); ?></span>
							</span>
						<?php endforeach; ?>
					</div>
				</div>

			</div><!-- .mat-chip-grid -->

		</div><!-- .ani-container -->
	</section><!-- .ani-cap-materials -->


	<!-- ========================================================= SECTION 7: CTA BAND -->
	<section class="cta-band ani-cap-cta" aria-labelledby="cap-cta-title">
		<div class="cta-band__inner">
			<h2 class="cta-band__title section-title" id="cap-cta-title">
				<?php esc_html_e( 'מוכנים לדבר על הפרויקט שלכם?', 'ani' ); ?>
			</h2>
			<p class="cta-band__sub">
				<?php esc_html_e( 'שלחו לנו קובץ CAD ופרטי הפרויקט — נחזור עם הצעת מחיר בתוך 24 שעות.', 'ani' ); ?>
			</p>
			<a class="ani-btn ani-btn--primary" href="<?php echo $contact_url; ?>">
				<?php esc_html_e( 'צרו קשר עכשיו', 'ani' ); ?>
				<svg class="ani-btn-arrow" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
					<line x1="14" y1="9" x2="4" y2="9"/>
					<polyline points="9 14 4 9 9 4"/>
				</svg>
			</a>
		</div><!-- .cta-band__inner -->
	</section><!-- .ani-cap-cta -->

</div><!-- .ani-capabilities-page -->

<?php
get_footer();
