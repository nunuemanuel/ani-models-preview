<?php
/**
 * Homepage polish — page ID 12.
 * Run via: wp eval-file homepage-polish-20260622.php
 *
 * Changes from homepage-edit-20260620.php:
 *  - HERO: New asymmetric CSS-grid mosaic (4 new webp images with varied spans);
 *          enhanced copy zone: eyebrow + H1 + full sub + tagline + paragraph + 2 CTAs
 *          + inline spec table (4 rows).
 *  - STATS: Refined labels from homepage-copy.md; "5" stat gear icon (was sun).
 *  - TRUSTED-BY strip: inserted immediately after stats (s1b) using existing logo assets.
 *  - CAPABILITIES (s3): Converted to RTL-aware horizontal scroll carousel with
 *                        prev/next arrow buttons and snap. Uses updated copy from
 *                        homepage-copy.md. Card: image + title + bullets + CTA.
 *  - INDUSTRIES (s4b): Sectors row KEPT (5 icons). Client logos REMOVED from this
 *                       section (now live in trusted-by strip above).
 *  - EQUIPMENT (s-equip): 5 distinct equip-*.webp images wired in (no more placeholders).
 *  - CTA BAND (s6): Updated copy from homepage-copy.md; blueprint-blue style preserved.
 *  - Overall CSS additions in components.css for: hero mosaic v2, hero spec table,
 *    cap-carousel, trusted-static strip.
 *
 * DB snapshot: snapshot-before-polish.sql (2026-06-22)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$page_id     = 12;
$upload_base = wp_upload_dir()['baseurl'];
$theme_uri   = get_stylesheet_directory_uri();

// ── s3 capabilities carousel ──────────────────────────────────────────────────
// Copy from homepage-copy.md (§3). Verbatim Hebrew — no AI Hebrew.
$capabilities = array(
	array(
		'slug'    => 'composites',
		'title'   => 'חומרים מרוכבים',
		'photo'   => $theme_uri . '/assets/hero/hero-composites-shell.webp',
		'photo_alt' => 'חלק מסיבי פחמן — composite manufacturing',
		'bullets' => array(
			'סיבי פחמן וזכוכית, תכנון וייצור תבניות',
			'חלקים קלים וחזקים למערכות תעופה ורחפנים',
			'עד צביעה וגימור מוגמר',
		),
	),
	array(
		'slug'    => 'cnc',
		'title'   => 'עיבוד שבבי CNC',
		'photo'   => $theme_uri . '/assets/hero/hero-cnc-mount.webp',
		'photo_alt' => 'מכונת CNC בעבודה — עיבוד שבבי מדויק',
		'bullets' => array(
			'כרסום 3, 4 ו־5 צירים באלומיניום, נירוסטה, טיטניום',
			'חלקים בודדים, סדרות קטנות, ג׳יגים וכלי ייצור',
			'דיוק גבוה בפלסטיק הנדסי ובמתכות מיוחדות',
		),
	),
	array(
		'slug'    => '3d-printing',
		'title'   => 'הדפסת תלת-ממד מתקדמת',
		'photo'   => $theme_uri . '/assets/hero/hero-3dprint-batch.webp',
		'photo_alt' => 'הדפסת תלת-ממד — אבות טיפוס וחלקי קצה',
		'bullets' => array(
			'טכנולוגיות FDM, SLA, SLS ו־MJF',
			'אבות טיפוס, ג׳יגים, תבניות וחלקי קצה',
			'חומרים מתקדמים, במהירות',
		),
	),
	array(
		'slug'    => 'scanning',
		'title'   => 'סריקה תלת-ממדית והנדסה לאחור',
		'photo'   => $theme_uri . '/assets/hero/hero-scanning.webp',
		'photo_alt' => 'סריקת תלת-ממד — 3D scanning and reverse engineering',
		'bullets' => array(
			'סריקת חלקים ומכלולים, בניית מודל CAD',
			'בקרת איכות ומדידה (CMM)',
			'שחזור חלקים קיימים גם ללא שרטוט מקורי',
		),
	),
	array(
		'slug'    => 'integration',
		'title'   => 'הרכבות ואינטגרציה',
		'photo'   => $theme_uri . '/assets/hero/hero-integration.webp',
		'photo_alt' => 'הרכבות ואינטגרציה — assembly and integration',
		'bullets' => array(
			'הרכבות מכניות ואלקטרו-מכניות',
			'שילוב רכיבים אלקטרוניים ואימות',
			'עד מוצר שלם ומוכן לשימוש',
		),
	),
);

$cap_cards = '';
foreach ( $capabilities as $cap ) {
	$bullets_html = '';
	foreach ( $cap['bullets'] as $bullet ) {
		$bullets_html .= '<li>' . esc_html( $bullet ) . '</li>';
	}
	$cap_cards .= sprintf(
		'<article class="cap-card" role="listitem">
  <div class="cap-card__media">
    <img src="%1$s" alt="%2$s" loading="lazy" width="460" height="307">
  </div>
  <div class="cap-card__body">
    <h3 class="cap-card__title">%3$s</h3>
    <ul class="cap-card__bullets">%4$s</ul>
    <a class="cap-card__cta" href="%5$s">קרא עוד <span aria-hidden="true">&#x2190;</span></a>
  </div>
</article>',
		esc_url( $cap['photo'] ),
		esc_attr( $cap['photo_alt'] ),
		esc_html( $cap['title'] ),
		$bullets_html,
		esc_url( home_url( '/' . $cap['slug'] . '/' ) )
	);
}

$capabilities_html = '<div class="container" id="capabilities">
  <p class="cap-eyebrow" aria-hidden="true">יכולות הייצור שלנו</p>
  <h2 class="section-title section-title--center">חמש יכולות. מפעל אחד. אחריות אחת.</h2>
  <p class="cap-intro">כל שלב בייצור נמצא אצלנו בבית, כך ששום חלק לא ממתין לספק חיצוני ושום פרט לא הולך לאיבוד בדרך.</p>
</div>
<div class="cap-carousel-wrap" dir="rtl">
  <button class="cap-nav cap-nav--prev" aria-label="הקודם" type="button">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>
  </button>
  <div class="cap-carousel" role="list" id="cap-track" aria-label="יכולות ייצור">
    ' . $cap_cards . '
  </div>
  <button class="cap-nav cap-nav--next" aria-label="הבא" type="button">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
  </button>
</div>
<script>
(function(){
  var track = document.getElementById(\'cap-track\');
  if (!track) return;
  var wrap = track.closest(\'.cap-carousel-wrap\');
  if (!wrap) return;
  var isRtl = document.documentElement.dir === \'rtl\';
  wrap.querySelector(\'.cap-nav--prev\').addEventListener(\'click\', function(){
    track.scrollBy({ left: isRtl ? 360 : -360, behavior: \'smooth\' });
  });
  wrap.querySelector(\'.cap-nav--next\').addEventListener(\'click\', function(){
    track.scrollBy({ left: isRtl ? -360 : 360, behavior: \'smooth\' });
  });
})();
</script>';

// ── s4b: "התעשיות שסומכות עלינו" — sector icons only (logos moved to s-trusted) ──
$sectors = array(
	array(
		'label' => 'ביטחון',
		'svg'   => '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
	),
	array(
		'label' => 'תעופה',
		'svg'   => '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15l-5-5L5 4 4 5l6 6-4 4H4l-1 1 3 1 1 3 1-1v-2l4-4 6 6 1-1-6-10z"/></svg>',
	),
	array(
		'label' => 'רחפנים',
		'svg'   => '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polygon points="12 2 22 8.5 22 15.5 12 22 2 15.5 2 8.5 12 2"/><circle cx="12" cy="12" r="3"/></svg>',
	),
	array(
		'label' => 'רפואה',
		'svg'   => '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/><path d="M8 12h8M12 8v8"/></svg>',
	),
	array(
		'label' => 'אלקטרוניקה',
		'svg'   => '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="5" y="5" width="14" height="14" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3"/></svg>',
	),
);

$sectors_html = '';
foreach ( $sectors as $sector ) {
	$sectors_html .= sprintf(
		'<div class="ind-sector" role="listitem">
      <span class="ind-sector__icon" aria-hidden="true">%1$s</span>
      <span class="ind-sector__label">%2$s</span>
    </div>',
		$sector['svg'],
		esc_html( $sector['label'] )
	);
}

$industries_html = '<div class="container" id="industries">
  <h2 class="section-title section-title--center">התעשיות שסומכות עלינו</h2>
  <p class="ind-intro">מערכות ביטחון, תעופה, רחפנים, רפואה ואלקטרוניקה מביאות אלינו את החלקים שאסור להם להיכשל. לצד יזמים וסטארט-אפים שהופכים רעיון למוצר ראשון.</p>
  <div class="ind-sectors" role="list" aria-label="תחומים בהם אנו פועלים">
    ' . $sectors_html . '
  </div>
</div>';

// ── s-trusted: client logos strip ─────────────────────────────────────────────
// All logos client-cleared (design-language.md). Grayscale, hover-to-color.
$logo_data = array(
	array( 'src' => $theme_uri . '/assets/logos/elbit.svg',       'alt' => 'Elbit Systems',                            'type' => 'img' ),
	array( 'src' => $theme_uri . '/assets/logos/iai.svg',         'alt' => 'Israel Aerospace Industries',              'type' => 'img' ),
	array( 'src' => $upload_base . '/2026/06/airobotics.png',     'alt' => 'Airobotics',                               'type' => 'img' ),
	array( 'src' => $theme_uri . '/assets/logos/bluebird.svg',    'alt' => 'BlueBird Aero Systems',                    'type' => 'img' ),
	array( 'src' => $theme_uri . '/assets/logos/hevendrones.svg', 'alt' => 'HevenDrones',                              'type' => 'img' ),
	array( 'src' => $upload_base . '/2026/06/gadfin.png',         'alt' => 'Gadfin',                                   'type' => 'img' ),
	array( 'src' => $upload_base . '/2026/06/iibr.png',           'alt' => 'Israel Institute for Biological Research',  'type' => 'img' ),
	array( 'src' => '',                                            'alt' => 'Aeronautics',                              'type' => 'text' ),
);

$logos_row = '';
foreach ( $logo_data as $logo ) {
	if ( 'img' === $logo['type'] ) {
		$logos_row .= sprintf(
			'<li><img class="trusted__logo" src="%s" alt="%s" loading="lazy"></li>',
			esc_url( $logo['src'] ),
			esc_attr( $logo['alt'] )
		);
	} else {
		$logos_row .= sprintf(
			'<li><span class="trusted__name" lang="en" dir="ltr">%s</span></li>',
			esc_html( $logo['alt'] )
		);
	}
}

$trusted_html = '<div class="trusted--static container">
  <p class="trusted__eyebrow">מהם בוטחים בנו</p>
  <ul class="trusted__row" role="list" aria-label="לקוחות ושותפים">
    ' . $logos_row . '
  </ul>
</div>';

// ── s-equip: 5 distinct equipment images ─────────────────────────────────────
$machines = array(
	array(
		'name'  => 'FlashForge Creator 4S',
		'tag'   => 'FDM',
		'photo' => $theme_uri . '/assets/equipment/equip-fdm.webp',
		'alt'   => 'FlashForge Creator 4S — מדפסת FDM תעשייתית',
	),
	array(
		'name'  => 'Sintratec S2',
		'tag'   => 'SLS',
		'photo' => $theme_uri . '/assets/equipment/equip-sls.webp',
		'alt'   => 'Sintratec S2 — מדפסת SLS לאבות טיפוס מתקדמים',
	),
	array(
		'name'  => '5-Axis CNC Centers',
		'tag'   => '3 / 4 / 5 Axis',
		'photo' => $theme_uri . '/assets/equipment/equip-cnc.webp',
		'alt'   => 'מרכז עיבוד CNC רב-ציר — כרסום מדויק',
	),
	array(
		'name'  => 'Industrial Metrology',
		'tag'   => 'CMM',
		'photo' => $theme_uri . '/assets/equipment/equip-cmm.webp',
		'alt'   => 'מדידת CMM תעשייתית — בקרת איכות מדויקת',
	),
	array(
		'name'  => '3D Scanning',
		'tag'   => 'Scanners',
		'photo' => $theme_uri . '/assets/equipment/equip-scanner.webp',
		'alt'   => 'סורק תלת-ממד תעשייתי — הנדסה לאחור',
	),
);

$equip_cards = '';
foreach ( $machines as $machine ) {
	$equip_cards .= sprintf(
		'<article class="equip-card" role="listitem">
  <div class="equip-card__img">
    <img src="%1$s" alt="%2$s" loading="lazy" width="320" height="240">
  </div>
  <div class="equip-card__body">
    <p class="equip-card__name" dir="ltr">%3$s</p>
    <span class="equip-card__tag" dir="ltr">%4$s</span>
  </div>
</article>',
		esc_url( $machine['photo'] ),
		esc_attr( $machine['alt'] ),
		esc_html( $machine['name'] ),
		esc_html( $machine['tag'] )
	);
}

$equipment_html = '<div class="container">
  <h2 class="section-title section-title--center">הציוד שמאחורי הדיוק</h2>
  <p class="equip-intro">מדפסות תלת-ממד תעשייתיות, מרכזי CNC רב-ציריים וסורקים מדויקים, עם תחנות גימור, ניקוי ובקרת איכות. כל מה שצריך כדי לספק חלק מוגמר, לא רק קובץ.</p>
</div>
<div class="equip-carousel-wrap">
  <button class="equip-nav equip-nav--prev" aria-label="הקודם" type="button">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>
  </button>
  <div class="equip-carousel" role="list" id="equip-track" aria-label="ציוד וטכנולוגיה">
    ' . $equip_cards . '
  </div>
  <button class="equip-nav equip-nav--next" aria-label="הבא" type="button">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
  </button>
</div>
<script>
(function(){
  var track = document.getElementById(\'equip-track\');
  if (!track) return;
  var wrap = track.closest(\'.equip-carousel-wrap\');
  if (!wrap) return;
  var isRtl = document.documentElement.dir === \'rtl\';
  wrap.querySelector(\'.equip-nav--prev\').addEventListener(\'click\', function(){
    track.scrollBy({ left: isRtl ? 280 : -280, behavior: \'smooth\' });
  });
  wrap.querySelector(\'.equip-nav--next\').addEventListener(\'click\', function(){
    track.scrollBy({ left: isRtl ? -280 : 280, behavior: \'smooth\' });
  });
})();
</script>';

// ── full Elementor data array ─────────────────────────────────────────────────
$elementor_data = array(

	// s1 — hero: asymmetric mosaic + enhanced copy zone with spec table.
	array(
		'id'       => 's1',
		'elType'   => 'section',
		'settings' => array(
			'css_classes' => 'hero',
			'layout'      => 'full_width',
			'padding'     => array( 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true ),
		),
		'elements' => array(
			array(
				'id'       => 's1c1',
				'elType'   => 'column',
				'settings' => array( '_column_size' => 100 ),
				'elements' => array(
					array(
						'id'         => 's1w1',
						'elType'     => 'widget',
						'widgetType' => 'html',
						'settings'   => array(
							/* Hero: copy LEFT (~40%), mosaic RIGHT (~60%).
							   Mosaic uses CSS grid-areas for asymmetric, editorial layout:
							   mosaic-cnc spans 2 rows (tall feature), carbon is tall portrait,
							   scan is square, print is smaller landscape. */
							'html' => '<div class="hero__inner">

  <!-- PHOTO MOSAIC — DOM-first = visual RIGHT in RTL -->
  <div class="hero__mosaic hero__mosaic--v2" role="img" aria-label="תמונות ייצור והנדסה של A.N.I">
    <!-- Asymmetric editorial grid: cnc (large, left col spanning 2 rows), carbon (tall portrait, top-right), scan (square, bottom-right-top), print (landscape, bottom-right-bottom) -->
    <div class="hero__tile hero__tile--feature">
      <img src="' . esc_url( $theme_uri . '/assets/hero/mosaic-cnc.webp' ) . '"
           alt="מכונת CNC בעבודה — ייצור מדויק"
           loading="eager" fetchpriority="high" width="760" height="540">
    </div>
    <div class="hero__tile hero__tile--portrait">
      <img src="' . esc_url( $theme_uri . '/assets/hero/mosaic-carbon.webp' ) . '"
           alt="חלק מסיבי פחמן — composite manufacturing"
           loading="lazy" width="360" height="480">
    </div>
    <div class="hero__tile hero__tile--square">
      <img src="' . esc_url( $theme_uri . '/assets/hero/mosaic-scan.webp' ) . '"
           alt="סריקת תלת-ממד — 3D scanning"
           loading="lazy" width="280" height="280">
    </div>
    <div class="hero__tile hero__tile--wide">
      <img src="' . esc_url( $theme_uri . '/assets/hero/mosaic-print.webp' ) . '"
           alt="הדפסת תלת-ממד — 3D printing"
           loading="lazy" width="360" height="210">
    </div>
  </div>

  <!-- COPY ZONE — DOM-second = visual LEFT in RTL -->
  <div class="hero__copy">
    <p class="eyebrow">דיוק. איכות. חדשנות.</p>
    <h1>פתרונות הנדסיים מתקדמים</h1>
    <p class="hero__sub">משלב הרעיון ועד למוצר המוגמר. תכנון, אבות טיפוס וייצור מדויק, תחת קורת גג אחת.</p>
    <span class="hero__rule" role="presentation" aria-hidden="true"></span>
    <p class="hero__tagline">מתכננים. מפתחים. מייצרים. מגשימים רעיונות.</p>
    <p class="hero__para">רוב המפעלים עושים שלב אחד. אנחנו לוקחים פרויקט מהשרטוט הראשון ועד החלק המורכב והבדוק, בלי להעביר אתכם בין ספקים.</p>
    <div class="hero__actions">
      <a class="btn btn--primary" href="#contact">קבלת הצעת מחיר</a>
      <a class="btn btn--outline-hero" href="' . esc_url( home_url( '/services/' ) ) . '">לצפייה ביכולות</a>
    </div>
    <!-- Engineering spec table: 4 rows. [VERIFY] flags on tolerance + standard. -->
    <table class="hero__spec-table" aria-label="מפרט טכני">
      <tbody>
        <tr>
          <th scope="row">דיוק</th>
          <td dir="ltr">עד ±0.01 מ״מ <span class="spec-badge" title="לאמת עם הלקוח לפני פרסום">[VERIFY]</span></td>
        </tr>
        <tr>
          <th scope="row">חומרים</th>
          <td>אלומיניום · טיטניום · נירוסטה · פחמן</td>
        </tr>
        <tr>
          <th scope="row">תהליכים</th>
          <td dir="ltr">CNC · הדפסת תלת-ממד · חומרים מרוכבים</td>
        </tr>
        <tr>
          <th scope="row">תקן</th>
          <td>עבודה לפי דרישות איכות ביטחוניות ותעופתיות <span class="spec-badge" title="ISO 9001 — לאמת לפני פרסום">[VERIFY]</span></td>
        </tr>
      </tbody>
    </table>
  </div>

</div>',
						),
					),
				),
			),
		),
	),

	// s1b — stats bar with refined labels + gear icon on "5".
	array(
		'id'       => 's1b',
		'elType'   => 'section',
		'settings' => array(
			'css_classes' => 'hero-stats-section',
			'layout'      => 'full_width',
			'padding'     => array( 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true ),
		),
		'elements' => array(
			array(
				'id'       => 's1bc1',
				'elType'   => 'column',
				'settings' => array( '_column_size' => 100 ),
				'elements' => array(
					array(
						'id'         => 's1bw1',
						'elType'     => 'widget',
						'widgetType' => 'html',
						'settings'   => array(
							/* TODO: VERIFY 35+ clients and 24/7 with client before launch. */
							'html' => '<div class="hero-stats" role="list">

  <div class="hero-stats__item" role="listitem">
    <span class="hero-stats__icon" aria-hidden="true">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="9" cy="7" r="3.5"/>
        <path d="M2 20c0-3.866 3.134-7 7-7s7 3.134 7 7"/>
        <circle cx="18" cy="8" r="2.5"/>
        <path d="M22 20c0-2.761-1.791-5-4-5"/>
      </svg>
    </span>
    <div class="hero-stats__text">
      <span class="hero-stats__num" dir="ltr">35+</span>
      <span class="hero-stats__label">לקוחות בתעשייה הביטחונית והאזרחית</span>
    </div>
  </div>

  <div class="hero-stats__item" role="listitem">
    <span class="hero-stats__icon" aria-hidden="true">
      <!-- gear / cog icon -->
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
      </svg>
    </span>
    <div class="hero-stats__text">
      <span class="hero-stats__num" dir="ltr">5</span>
      <span class="hero-stats__label">יכולות ייצור תחת קורת גג אחת</span>
    </div>
  </div>

  <div class="hero-stats__item" role="listitem">
    <span class="hero-stats__icon" aria-hidden="true">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="9"/>
        <polyline points="12 7 12 12 15 15"/>
      </svg>
    </span>
    <div class="hero-stats__text">
      <span class="hero-stats__num" dir="ltr">24/7</span>
      <span class="hero-stats__label">ייצור רציף בלוחות זמנים קריטיים</span>
    </div>
  </div>

  <div class="hero-stats__item" role="listitem">
    <span class="hero-stats__icon" aria-hidden="true">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="9"/>
        <circle cx="12" cy="12" r="5"/>
        <circle cx="12" cy="12" r="1" fill="currentColor" stroke="none"/>
      </svg>
    </span>
    <div class="hero-stats__text">
      <span class="hero-stats__num" dir="ltr">100%</span>
      <span class="hero-stats__label">מהתכנון ועד ההרכבה — אצלנו</span>
    </div>
  </div>

</div>',
						),
					),
				),
			),
		),
	),

	// s-trusted — client logos strip: directly under stats.
	array(
		'id'       => 's-trusted',
		'elType'   => 'section',
		'settings' => array(
			'css_classes' => 'trusted--static-section',
			'layout'      => 'full_width',
			'padding'     => array( 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true ),
		),
		'elements' => array(
			array(
				'id'       => 's-trustedc1',
				'elType'   => 'column',
				'settings' => array( '_column_size' => 100 ),
				'elements' => array(
					array(
						'id'         => 's-trustedw1',
						'elType'     => 'widget',
						'widgetType' => 'html',
						'settings'   => array( 'html' => $trusted_html ),
					),
				),
			),
		),
	),

	// s3 — capabilities carousel.
	array(
		'id'       => 's3',
		'elType'   => 'section',
		'settings' => array(
			'css_classes' => 'section cap-section',
			'layout'      => 'full_width',
			'padding'     => array( 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true ),
		),
		'elements' => array(
			array(
				'id'       => 's3c1',
				'elType'   => 'column',
				'settings' => array( '_column_size' => 100 ),
				'elements' => array(
					array(
						'id'         => 's3w1',
						'elType'     => 'widget',
						'widgetType' => 'html',
						'settings'   => array( 'html' => $capabilities_html ),
					),
				),
			),
		),
	),

	// s4b — industries section (sectors only — logos moved to s-trusted).
	array(
		'id'       => 's4b',
		'elType'   => 'section',
		'settings' => array(
			'css_classes' => 'industries industries--tight section--surface',
			'layout'      => 'full_width',
			'padding'     => array( 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true ),
		),
		'elements' => array(
			array(
				'id'       => 's4bc1',
				'elType'   => 'column',
				'settings' => array( '_column_size' => 100 ),
				'elements' => array(
					array(
						'id'         => 's4bw1',
						'elType'     => 'widget',
						'widgetType' => 'html',
						'settings'   => array( 'html' => $industries_html ),
					),
				),
			),
		),
	),

	// s-equip — equipment carousel with 5 distinct images.
	array(
		'id'       => 's-equip',
		'elType'   => 'section',
		'settings' => array(
			'css_classes' => 'section section--surface',
			'layout'      => 'full_width',
			'padding'     => array( 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true ),
		),
		'elements' => array(
			array(
				'id'       => 's-equipc1',
				'elType'   => 'column',
				'settings' => array( '_column_size' => 100 ),
				'elements' => array(
					array(
						'id'         => 's-equipw1',
						'elType'     => 'widget',
						'widgetType' => 'html',
						'settings'   => array( 'html' => $equipment_html ),
					),
				),
			),
		),
	),

	// s6 — CTA band with approved copy from homepage-copy.md.
	array(
		'id'       => 's6',
		'elType'   => 'section',
		'settings' => array(
			'css_classes' => 'cta-band cta-band--blueprint',
			'layout'      => 'full_width',
			'padding'     => array( 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true ),
		),
		'elements' => array(
			array(
				'id'       => 's6c1',
				'elType'   => 'column',
				'settings' => array( '_column_size' => 100 ),
				'elements' => array(
					array(
						'id'         => 's6w1',
						'elType'     => 'widget',
						'widgetType' => 'html',
						'settings'   => array(
							'html' => '<div class="cta-band__inner" id="contact">
  <h2 class="cta-band__title">יש לכם רעיון? אנחנו נהפוך אותו למוצר אמיתי.</h2>
  <p class="cta-band__sub">שלחו שרטוט, קובץ <span dir="ltr">CAD</span> או אפילו סקיצה ראשונית. נחזור אליכם עם הצעת מחיר ותכנית ייצור.</p>
  <a class="btn btn--primary" href="mailto:info@ani-models.co.il">בואו נדבר <span class="arrow" aria-hidden="true">&#x2190;</span></a>
</div>',
						),
					),
				),
			),
		),
	),
);

// ── write to DB ───────────────────────────────────────────────────────────────
$json = wp_json_encode( $elementor_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );

if ( ! $json ) {
	WP_CLI::error( 'Failed to encode Elementor data to JSON.' );
	return;
}

$result = update_post_meta( $page_id, '_elementor_data', wp_slash( $json ) );

if ( false === $result ) {
	WP_CLI::error( 'update_post_meta returned false — data may be unchanged or write failed.' );
	return;
}

// Flush Elementor CSS cache.
if ( class_exists( '\Elementor\Plugin' ) ) {
	\Elementor\Plugin::$instance->files_manager->clear_cache();
	WP_CLI::success( 'Done. Polish applied: hero v2 mosaic + spec table, refined stats, trusted-by strip, cap carousel, sector-only industries, 5-image equip carousel, updated CTA. Page ID ' . $page_id . '.' );
} else {
	WP_CLI::success( 'Done. Polish applied. Run: wp elementor flush-css. Page ID ' . $page_id . '.' );
}
