<?php
/**
 * Template Name: About / אודות
 *
 * Full-width About page for A.N.I — Models & Prototypes.
 * Sections (RTL-Hebrew, verbatim client copy):
 *   1. Page hero — title + positioning line + one-line description + part photo
 *   2. One Stop Shop — full-chain step row (idea→…→serial production)
 *   3. "מה מייחד אותנו" — 5 value-prop cards
 *   4. "החזון שלנו" — vision paragraph in a highlighted band
 *   5. "הציוד והטכנולוגיות" — machine park in IBM Plex Mono spec style
 *   6. "לקוחות ותעשיות" — logo strip + sector tags
 *   7. CTA band — "מוכנים להפוך רעיון למוצר?" + /contact/ button
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
$logos_uri   = $assets_uri . '/logos';
$contact_url = esc_url( home_url( '/contact/' ) );
?>

<div class="ani-about-page">

	<!-- ========================================================= SECTION 1: HERO -->
	<section class="ani-about-hero" aria-labelledby="about-hero-title">
		<div class="ani-about-hero__inner ani-container">

			<div class="ani-about-hero__copy">
				<p class="eyebrow"><?php esc_html_e( 'מי אנחנו', 'ani' ); ?></p>

				<h1 class="section-title" id="about-hero-title">
					<?php esc_html_e( 'אודות א.נ.י', 'ani' ); ?>
				</h1>

				<p class="ani-about-hero__positioning">
					<?php esc_html_e( 'פתרונות הנדסיים מתקדמים – משלב הרעיון ועד למוצר המוגמר', 'ani' ); ?>
				</p>

				<p class="ani-about-hero__desc">
					<?php esc_html_e( 'חברה המתמחה בפיתוח, תכנון וייצור מוצרים מתקדמים עבור תעשיות הביטחון, התעופה, הרחפנים, הרפואה, האלקטרוניקה והתעשייה המתקדמת, לצד מתן שירותים ליזמים, סטארט-אפים ולקוחות פרטיים.', 'ani' ); ?>
				</p>
			</div><!-- .ani-about-hero__copy -->

			<div class="ani-about-hero__media" aria-hidden="true">
				<div class="hero__part">
					<img
						src="<?php echo esc_url( $assets_uri . '/part-hero.png' ); ?>"
						alt=""
						width="520"
						height="440"
						loading="eager"
						fetchpriority="high"
						decoding="async"
					>
				</div>
			</div><!-- .ani-about-hero__media -->

		</div><!-- .ani-about-hero__inner -->
	</section><!-- .ani-about-hero -->


	<!-- ========================================================= SECTION 2: ONE STOP SHOP CHAIN -->
	<section class="section section--surface ani-about-chain" aria-labelledby="about-chain-title">
		<div class="ani-container">

			<h2 class="section-title section-title--center" id="about-chain-title">
				<?php esc_html_e( 'One Stop Shop — תהליך מלא תחת קורת גג אחת', 'ani' ); ?>
			</h2>

			<p class="ani-about-chain__intro">
				<?php esc_html_e( 'ספק בודד לכל מסלול הפיתוח — החל מהרעיון ועד למוצר מוגמר או ייצור סדרתי. זה מה שמבדיל אותנו.', 'ani' ); ?>
			</p>

			<div class="process__steps ani-about-chain__steps" role="list">

				<?php
				$chain_steps = array(
					array( 'num' => '1', 'label' => "רעיון\nומפרט" ),
					array( 'num' => '2', 'label' => "תכנון\nהנדסי" ),
					array( 'num' => '3', 'label' => "אבות\nטיפוס" ),
					array( 'num' => '4', 'label' => "סריקה\nתלת-ממד" ),
					array( 'num' => '5', 'label' => "הדפסה\nתלת-ממד" ),
					array( 'num' => '6', 'label' => "עיבוד\nשבבי CNC" ),
					array( 'num' => '7', 'label' => "חומרים\nמרוכבים" ),
					array( 'num' => '8', 'label' => "הרכבה\nואינטגרציה" ),
					array( 'num' => '9', 'label' => "מוצר מוגמר\nייצור סדרתי" ),
				);
				foreach ( $chain_steps as $step ) :
					?>
					<div class="process__step" role="listitem">
						<span class="process__num" aria-hidden="true"><?php echo esc_html( $step['num'] ); ?></span>
						<span class="process__label"><?php echo nl2br( esc_html( $step['label'] ) ); ?></span>
					</div>
				<?php endforeach; ?>

			</div><!-- .process__steps -->

		</div><!-- .ani-container -->
	</section><!-- .ani-about-chain -->


	<!-- ========================================================= SECTION 3: VALUE PROPS CARDS -->
	<section class="section ani-about-values" aria-labelledby="about-values-title">
		<div class="ani-container">

			<h2 class="section-title section-title--center" id="about-values-title">
				<?php esc_html_e( 'מה מייחד אותנו', 'ani' ); ?>
			</h2>

			<div class="ani-about-values__grid">

				<!-- Card 1: One Stop Shop אמיתי -->
				<article class="card ani-about-value-card">
					<div class="card__icon" aria-hidden="true">
						<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
							<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
							<polyline points="9 22 9 12 15 12 15 22"/>
						</svg>
					</div>
					<h3 class="card__title"><?php esc_html_e( 'One Stop Shop אמיתי', 'ani' ); ?></h3>
					<p class="card__blurb">
						<?php esc_html_e( 'מעט מאוד חברות מספקות, במקום אחד: תכנון הנדסי, סריקה תלת-ממדית, הנדסה לאחור, עיבוד CNC, הדפסה תלת-ממדית, חומרים מרוכבים, יציקה ועיבוד תבניות, הרכבה ואינטגרציה.', 'ani' ); ?>
					</p>
				</article>

				<!-- Card 2: ניסיון בפרויקטים מורכבים -->
				<article class="card ani-about-value-card">
					<div class="card__icon" aria-hidden="true">
						<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
							<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
						</svg>
					</div>
					<h3 class="card__title"><?php esc_html_e( 'ניסיון בפרויקטים מורכבים', 'ani' ); ?></h3>
					<p class="card__blurb">
						<?php esc_html_e( 'עובדים עם גופי ביטחון, חברות תעופה, יצרני רחפנים, חברות טכנולוגיה ויזמים פרטיים; עומדים בדרישות המחמירות ביותר.', 'ani' ); ?>
					</p>
				</article>

				<!-- Card 3: גמישות ומהירות -->
				<article class="card ani-about-value-card">
					<div class="card__icon" aria-hidden="true">
						<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
							<circle cx="12" cy="12" r="10"/>
							<polyline points="12 6 12 12 16 14"/>
						</svg>
					</div>
					<h3 class="card__title"><?php esc_html_e( 'גמישות ומהירות', 'ani' ); ?></h3>
					<p class="card__blurb">
						<?php esc_html_e( 'כל השלבים במקום אחד — זמני אספקה קצרים משמעותית, עלות נמוכה יותר ואיכות מוצר גבוהה יותר.', 'ani' ); ?>
					</p>
				</article>

				<!-- Card 4: חשיבה הנדסית לצד יכולת ייצור -->
				<article class="card ani-about-value-card">
					<div class="card__icon" aria-hidden="true">
						<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
							<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
						</svg>
					</div>
					<h3 class="card__title"><?php esc_html_e( 'חשיבה הנדסית לצד יכולת ייצור', 'ani' ); ?></h3>
					<p class="card__blurb">
						<?php esc_html_e( 'לא רק ייצור לפי שרטוט — יועצים ללקוח על חומרים, תהליכי ייצור ופתרונות הנדסיים מתאימים.', 'ani' ); ?>
					</p>
				</article>

				<!-- Card 5: ליווי אישי לכל לקוח -->
				<article class="card ani-about-value-card">
					<div class="card__icon" aria-hidden="true">
						<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
							<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
							<circle cx="12" cy="7" r="4"/>
						</svg>
					</div>
					<h3 class="card__title"><?php esc_html_e( 'ליווי אישי לכל לקוח', 'ani' ); ?></h3>
					<p class="card__blurb">
						<?php esc_html_e( 'מחברות ביטחון ותעשייה גדולות ועד יזמים ולקוחות פרטיים — כל פרויקט מקבל ליווי אישי ומקצועי לאורך כל הדרך.', 'ani' ); ?>
					</p>
				</article>

			</div><!-- .ani-about-values__grid -->
		</div><!-- .ani-container -->
	</section><!-- .ani-about-values -->


	<!-- ========================================================= SECTION 4: VISION BAND -->
	<section class="ani-about-vision" aria-labelledby="about-vision-title">
		<div class="ani-container">
			<div class="ani-about-vision__inner">
				<p class="eyebrow"><?php esc_html_e( 'החזון שלנו', 'ani' ); ?></p>
				<h2 class="ani-about-vision__title" id="about-vision-title">
					<?php esc_html_e( 'החזון שלנו', 'ani' ); ?>
				</h2>
				<blockquote class="ani-about-vision__quote">
					<p>
						<?php esc_html_e( 'להוביל את תחום פיתוח המוצרים והייצור המתקדם בישראל באמצעות שילוב של חדשנות, מקצועיות, טכנולוגיה מתקדמת ושירות אישי, ולאפשר לכל לקוח – מחברה בינלאומית ועד יזם פרטי – להפוך רעיון למוצר איכותי, מדויק ומוכן לעולם האמיתי.', 'ani' ); ?>
					</p>
				</blockquote>
			</div>
		</div><!-- .ani-container -->
	</section><!-- .ani-about-vision -->




	<!-- ========================================================= SECTION 6: CLIENTS & INDUSTRIES -->
	<section class="section section--surface ani-about-clients" aria-labelledby="about-clients-title">
		<div class="ani-container">

			<h2 class="section-title section-title--center" id="about-clients-title">
				<?php esc_html_e( 'לקוחות ותעשיות', 'ani' ); ?>
			</h2>

			<p class="ani-about-clients__intro">
				<?php esc_html_e( 'עובדים עם חלק מהשמות המובילים בתחומי הביטחון, התעופה והטכנולוגיה בישראל.', 'ani' ); ?>
			</p>

			<!-- Sector tags -->
			<div class="ani-about-sectors" aria-label="<?php esc_attr_e( 'תחומי פעילות', 'ani' ); ?>">
				<?php
				$sectors = array(
					__( 'ביטחון', 'ani' ),
					__( 'תעופה', 'ani' ),
					__( 'רחפנים', 'ani' ),
					__( 'רפואה', 'ani' ),
					__( 'אלקטרוניקה', 'ani' ),
					__( 'תעשייה מתקדמת', 'ani' ),
				);
				foreach ( $sectors as $sector ) :
					?>
					<span class="ani-about-sector"><?php echo esc_html( $sector ); ?></span>
				<?php endforeach; ?>
			</div><!-- .ani-about-sectors -->

			<!-- Client logo strip -->
			<div class="ani-about-logos" role="list" aria-label="<?php esc_attr_e( 'לקוחות מובילים', 'ani' ); ?>">

				<?php
				$logos = array(
					array(
						'file' => 'elbit.svg',
						'name' => 'Elbit Systems',
					),
					array(
						'file' => 'iai.svg',
						'name' => 'Israel Aerospace Industries',
					),
					array(
						'file' => 'airobotics.png',
						'name' => 'Airobotics',
					),
					array(
						'file' => 'bluebird.svg',
						'name' => 'BlueBird Aero Systems',
					),
					array(
						'file' => 'hevendrones.svg',
						'name' => 'HevenDrones',
					),
					array(
						'file' => 'gadfin.png',
						'name' => 'Gadfin',
					),
					array(
						'file' => 'iibr.png',
						'name' => 'IIBR',
					),
				);
				foreach ( $logos as $logo ) :
					?>
					<div class="ani-about-logo-cell" role="listitem">
						<img
							src="<?php echo esc_url( $logos_uri . '/' . $logo['file'] ); ?>"
							alt="<?php echo esc_attr( $logo['name'] ); ?>"
							loading="lazy"
							decoding="async"
							class="ani-about-logo"
						>
					</div>
				<?php endforeach; ?>

				<!-- Text-only: firms without a logo asset -->
				<div class="ani-about-logo-cell ani-about-logo-cell--text" role="listitem">
					<span class="ani-about-logo-text" dir="ltr">Aeronautics</span>
				</div>
				<div class="ani-about-logo-cell ani-about-logo-cell--text" role="listitem">
					<span class="ani-about-logo-text" dir="ltr">Aerobotics</span>
				</div>

			</div><!-- .ani-about-logos -->

			<p class="ani-about-clients__footer">
				<?php esc_html_e( 'ועוד חברות מובילות בתעשייה, ביטחון, פיתוח ואלקטרוניקה.', 'ani' ); ?>
			</p>

		</div><!-- .ani-container -->
	</section><!-- .ani-about-clients -->


	<!-- ========================================================= SECTION 7: CTA BAND -->
	<section class="cta-band ani-about-cta" aria-labelledby="about-cta-title">
		<div class="cta-band__inner">
			<h2 class="cta-band__title section-title" id="about-cta-title">
				<?php esc_html_e( 'מוכנים להפוך רעיון למוצר?', 'ani' ); ?>
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
	</section><!-- .ani-about-cta -->

</div><!-- .ani-about-page -->

<?php
get_footer();
