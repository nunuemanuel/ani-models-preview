<?php
/**
 * Template Name: Clients & Industries / לקוחות ותעשיות
 *
 * Credibility page for A.N.I — Models & Prototypes.
 * Sections (RTL-Hebrew, verbatim client copy):
 *   1. Page hero — title + 1-line intro
 *   2. Sectors served — ביטחון · תעופה · רחפנים · רפואה · אלקטרוניקה · תעשייה
 *   3. Trusted-by client logo wall (reuses .ind-bare-logos from components.css)
 *   4. CTA band → /contact/
 *
 * RTL-Hebrew: logical-property CSS only; LTR isolation on latin/numbers/firm-names.
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
$logos_uri   = $assets_uri . '/logos';
$contact_url = esc_url( home_url( '/contact/' ) );
?>

<div class="ani-industries-page">

	<!-- ========================================================= SECTION 1: HERO -->
	<section class="ani-ind-hero section" aria-labelledby="ind-hero-title">
		<div class="ani-container">

			<p class="eyebrow"><?php esc_html_e( 'אמון ותעשייה', 'ani' ); ?></p>

			<h1 class="section-title" id="ind-hero-title">
				<?php esc_html_e( 'לקוחות ותעשיות', 'ani' ); ?>
			</h1>

			<p class="ani-ind-hero__intro">
				<?php esc_html_e( 'א.נ.י עובדת עם חלק מהשמות המובילים בתחומי הביטחון, התעופה, הרחפנים, הרפואה והטכנולוגיה בישראל — מחברות ביטחון גדולות ועד יזמים פרטיים המפתחים את המוצר הבא שלהם.', 'ani' ); ?>
			</p>

		</div><!-- .ani-container -->
	</section><!-- .ani-ind-hero -->


	<!-- ========================================================= SECTION 2: SECTORS SERVED -->
	<section class="section section--surface ani-ind-sectors-section" aria-labelledby="ind-sectors-title">
		<div class="ani-container">

			<h2 class="section-title section-title--center" id="ind-sectors-title">
				<?php esc_html_e( 'התעשיות שאנחנו משרתים', 'ani' ); ?>
			</h2>

			<?php
			/**
			 * Sector data — verbatim Hebrew names from company-profile.md.
			 * Descriptors are gloss summaries (not Hebrew marketing copy); client
			 * should provide verbatim Hebrew descriptors in Phase 2.
			 * TODO: provide verbatim Hebrew descriptor per sector — see copy gaps below.
			 */
			$sectors = array(
				array(
					'title'    => __( 'ביטחון', 'ani' ),
					'icon_svg' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
					/* TODO: get verbatim Hebrew sector descriptor from client */
					'desc'     => __( 'חלקים ומכלולים לתעשיית הביטחון — מרכזי עיבוד CNC, הדפסה תלת-ממד וחומרים מרוכבים.', 'ani' ),
				),
				array(
					'title'    => __( 'תעופה', 'ani' ),
					'icon_svg' => '<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>',
					/* TODO: get verbatim Hebrew sector descriptor from client */
					'desc'     => __( 'רכיבי תעופה — עיבוד טיטניום, אלומיניום וחומרים מרוכבים קלי-משקל לדרישות AS.', 'ani' ),
				),
				array(
					'title'    => __( 'רחפנים', 'ani' ),
					'icon_svg' => '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/>',
					/* TODO: get verbatim Hebrew sector descriptor from client */
					'desc'     => __( 'מבנים, מכסות ומכלולים לרחפנים (UAV) — סיבי פחמן, SLS ועיבוד שבבי משולב.', 'ani' ),
				),
				array(
					'title'    => __( 'רפואה', 'ani' ),
					'icon_svg' => '<path d="M22 12h-4l-3 9L9 3l-3 9H2"/>',
					/* TODO: get verbatim Hebrew sector descriptor from client */
					'desc'     => __( 'ציוד וחלקים לתחום הרפואי — דיוק גבוה, חומרים מאושרים ועמדות הרכבה נקיות.', 'ani' ),
				),
				array(
					'title'    => __( 'אלקטרוניקה', 'ani' ),
					'icon_svg' => '<rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/>',
					/* TODO: get verbatim Hebrew sector descriptor from client */
					'desc'     => __( 'מארזים, תבניות ומבנים לחברות אלקטרוניקה — אבות טיפוס מהירים וחלקי גימור.', 'ani' ),
				),
				array(
					'title'    => __( 'תעשייה מתקדמת', 'ani' ),
					'icon_svg' => '<circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/>',
					/* TODO: get verbatim Hebrew sector descriptor from client */
					'desc'     => __( 'מתקנים, כלי ייצור ופתרונות הנדסיים לחברות תעשייה מתקדמת וסטארט-אפים.', 'ani' ),
				),
			);
			?>

			<div class="ani-ind-sector-grid">
				<?php foreach ( $sectors as $sector ) : ?>
					<article class="ani-ind-sector-card">
						<div class="ani-ind-sector-card__icon" aria-hidden="true">
							<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
								<?php
								// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG path data, hardcoded in this file
								echo $sector['icon_svg'];
								?>
							</svg>
						</div>
						<h3 class="ani-ind-sector-card__title"><?php echo esc_html( $sector['title'] ); ?></h3>
						<p class="ani-ind-sector-card__desc"><?php echo esc_html( $sector['desc'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div><!-- .ani-ind-sector-grid -->

		</div><!-- .ani-container -->
	</section><!-- .ani-ind-sectors-section -->


	<!-- ========================================================= SECTION 3: CLIENT LOGO WALL -->
	<section class="section ani-ind-logos-section" aria-labelledby="ind-logos-title">
		<div class="ani-container">

			<h2 class="section-title section-title--center" id="ind-logos-title">
				<?php esc_html_e( 'לקוחות מובילים', 'ani' ); ?>
			</h2>

			<p class="ani-ind-logos-intro">
				<?php esc_html_e( 'עובדים עם חלק מהשמות המובילים בתחומי הביטחון, התעופה והטכנולוגיה בישראל.', 'ani' ); ?>
			</p>

			<div class="ind-bare-logos" role="list" aria-label="<?php esc_attr_e( 'לקוחות מובילים', 'ani' ); ?>">

				<?php
				$ind_logos = array(
					array( 'file' => 'elbit.svg',       'name' => 'Elbit Systems' ),
					array( 'file' => 'iai.svg',         'name' => 'Israel Aerospace Industries' ),
					array( 'file' => 'airobotics.png',  'name' => 'Airobotics' ),
					array( 'file' => 'bluebird.svg',    'name' => 'BlueBird Aero Systems' ),
					array( 'file' => 'hevendrones.svg', 'name' => 'HevenDrones' ),
					array( 'file' => 'gadfin.png',      'name' => 'Gadfin' ),
					array( 'file' => 'iibr.png',        'name' => 'IIBR' ),
				);
				foreach ( $ind_logos as $logo ) :
					?>
					<div role="listitem">
						<img
							src="<?php echo esc_url( $logos_uri . '/' . $logo['file'] ); ?>"
							alt="<?php echo esc_attr( $logo['name'] ); ?>"
							loading="lazy"
							decoding="async"
							class="ind-bare-logo"
						>
					</div>
				<?php endforeach; ?>

				<!-- Text-only: firms without a logo asset -->
				<div role="listitem">
					<span class="ind-logo-text" dir="ltr">Aeronautics</span>
				</div>

			</div><!-- .ind-bare-logos -->

			<p class="ani-ind-logos-footer">
				<?php esc_html_e( 'ועוד חברות מובילות בתחומי הביטחון, התעופה, הרחפנים, האלקטרוניקה והתעשייה.', 'ani' ); ?>
			</p>

		</div><!-- .ani-container -->
	</section><!-- .ani-ind-logos-section -->


	<!-- ========================================================= SECTION 4: CTA BAND -->
	<section class="cta-band ani-ind-cta" aria-labelledby="ind-cta-title">
		<div class="cta-band__inner">
			<h2 class="cta-band__title section-title" id="ind-cta-title">
				<?php esc_html_e( 'מוכנים לעבוד יחד?', 'ani' ); ?>
			</h2>
			<p class="cta-band__sub">
				<?php esc_html_e( 'שלחו לנו את פרטי הפרויקט ונחזור אליכם עם הצעת מחיר בתוך 24 שעות.', 'ani' ); ?>
			</p>
			<a class="ani-btn ani-btn--primary" href="<?php echo $contact_url; ?>">
				<?php esc_html_e( 'צרו קשר עכשיו', 'ani' ); ?>
				<svg class="ani-btn-arrow" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
					<line x1="14" y1="9" x2="4" y2="9"/>
					<polyline points="9 14 4 9 9 4"/>
				</svg>
			</a>
		</div><!-- .cta-band__inner -->
	</section><!-- .ani-ind-cta -->

</div><!-- .ani-industries-page -->

<?php
get_footer();
