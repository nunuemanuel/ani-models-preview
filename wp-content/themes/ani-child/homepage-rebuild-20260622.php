<?php
/**
 * Homepage rebuild — locked strategy spine — page ID 12.
 * Run via: wp eval-file homepage-rebuild-20260622.php
 *
 * Implements: 00-FOUNDATION-locked.md blueprint + homepage-copy-v2.md (FINAL).
 * DO NOT edit — derived from locked docs.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$page_id     = 12;
$upload_base = wp_upload_dir()['baseurl'];
$theme_uri   = get_stylesheet_directory_uri();

// ── s3 capabilities carousel ──────────────────────────────────────────────────
// Verbatim Hebrew copy — no AI Hebrew. spec + lead-time per card (copy-v2).
$capabilities = array(
	array(
		'slug'      => 'composites',
		'title'     => 'חומרים מרוכבים',
		'photo'     => $theme_uri . '/assets/hero/hero-composites-shell.webp',
		'photo_alt' => 'חלק מסיבי פחמן — composite manufacturing',
		'bullets'   => array(
			'סיבי פחמן וזכוכית, תכנון וייצור תבניות',
			'חלקים קלים וחזקים למערכות תעופה ורחפנים',
			'עד צביעה וגימור מוגמר',
		),
		'spec'      => 'Carbon · Fiberglass',
		'lead'      => '1–3 שבועות',
	),
	array(
		'slug'      => 'cnc',
		'title'     => 'עיבוד שבבי CNC',
		'photo'     => $theme_uri . '/assets/hero/hero-cnc-mount.webp',
		'photo_alt' => 'מכונת CNC בעבודה — עיבוד שבבי מדויק',
		'bullets'   => array(
			'כרסום 3, 4 ו־5 צירים באלומיניום, נירוסטה, טיטניום',
			'חלקים בודדים, סדרות קטנות, ג׳יגים וכלי ייצור',
			'דיוק גבוה בפלסטיק הנדסי ובמתכות מיוחדות',
		),
		'spec'      => '±0.01 mm · 3/4/5-axis',
		'lead'      => '3–7 ימים',
	),
	array(
		'slug'      => '3d-printing',
		'title'     => 'הדפסת תלת-ממד מתקדמת',
		'photo'     => $theme_uri . '/assets/hero/hero-3dprint-batch.webp',
		'photo_alt' => 'הדפסת תלת-ממד — אבות טיפוס וחלקי קצה',
		'bullets'   => array(
			'טכנולוגיות FDM, SLA, SLS ו־MJF',
			'אבות טיפוס, ג׳יגים, תבניות וחלקי קצה',
			'חומרים מתקדמים, במהירות',
		),
		'spec'      => 'FDM · SLA · SLS · MJF',
		'lead'      => '24–72 שעות',
	),
	array(
		'slug'      => 'scanning',
		'title'     => 'סריקה תלת-ממדית והנדסה לאחור',
		'photo'     => $theme_uri . '/assets/hero/hero-scanning.webp',
		'photo_alt' => 'סריקת תלת-ממד — 3D scanning and reverse engineering',
		'bullets'   => array(
			'סריקת חלקים ומכלולים, בניית מודל CAD',
			'בקרת איכות ומדידה (CMM)',
			'שחזור חלקים קיימים גם ללא שרטוט מקורי',
		),
		'spec'      => 'CMM metrology',
		'lead'      => '2–5 ימים',
	),
	array(
		'slug'      => 'integration',
		'title'     => 'הרכבות ואינטגרציה',
		'photo'     => $theme_uri . '/assets/hero/hero-integration.webp',
		'photo_alt' => 'הרכבות ואינטגרציה — assembly and integration',
		'bullets'   => array(
			'הרכבות מכניות ואלקטרו-מכניות',
			'שילוב רכיבים אלקטרוניים ואימות',
			'עד מוצר שלם ומוכן לשימוש',
		),
		'spec'      => 'Electro-mechanical',
		'lead'      => 'לפי פרויקט',
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
    <div class="cap-card__spec-row">
      <span class="cap-card__spec" dir="ltr">%5$s</span>
      <span class="cap-card__lead">%6$s</span>
    </div>
    <ul class="cap-card__bullets">%4$s</ul>
    <a class="cap-card__cta" href="%7$s">קרא עוד <span aria-hidden="true">&#x2190;</span></a>
  </div>
</article>',
		esc_url( $cap['photo'] ),
		esc_attr( $cap['photo_alt'] ),
		esc_html( $cap['title'] ),
		$bullets_html,
		esc_html( $cap['spec'] ),
		esc_html( $cap['lead'] ),
		esc_url( home_url( '/' . $cap['slug'] . '/' ) )
	);
}

$capabilities_html = '<div class="container" id="capabilities">
  <p class="section-eyebrow">יכולות הייצור שלנו</p>
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

// ── s4b: industries section ───────────────────────────────────────────────────
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
$logo_data = array(
	array( 'src' => $theme_uri . '/assets/logos/elbit.svg',       'alt' => 'Elbit Systems',                           'type' => 'img' ),
	array( 'src' => $theme_uri . '/assets/logos/iai.svg',         'alt' => 'Israel Aerospace Industries',             'type' => 'img' ),
	array( 'src' => $upload_base . '/2026/06/airobotics.png',     'alt' => 'Airobotics',                              'type' => 'img' ),
	array( 'src' => $theme_uri . '/assets/logos/bluebird.svg',    'alt' => 'BlueBird Aero Systems',                   'type' => 'img' ),
	array( 'src' => $theme_uri . '/assets/logos/hevendrones.svg', 'alt' => 'HevenDrones',                             'type' => 'img' ),
	array( 'src' => $upload_base . '/2026/06/gadfin.png',         'alt' => 'Gadfin',                                  'type' => 'img' ),
	array( 'src' => $upload_base . '/2026/06/iibr.png',           'alt' => 'Israel Institute for Biological Research', 'type' => 'img' ),
	array( 'src' => '',                                            'alt' => 'Aeronautics',                             'type' => 'text' ),
);

$logos_set = '';
foreach ( $logo_data as $logo ) {
	if ( 'img' === $logo['type'] ) {
		$logos_set .= sprintf(
			'<img class="trusted__logo" src="%s" alt="%s" loading="lazy">',
			esc_url( $logo['src'] ),
			esc_attr( $logo['alt'] )
		);
	} else {
		$logos_set .= sprintf(
			'<span class="trusted__name" lang="en" dir="ltr">%s</span>',
			esc_html( $logo['alt'] )
		);
	}
}

// Server-rendered CSS marquee: two identical logo sets end-to-end for a seamless
// infinite loop. No JavaScript needed to construct it (the @keyframes ani-marquee
// animation in components.css drives it), so it can never fail to start. The
// duplicate set is aria-hidden to avoid screen-reader repetition.
$trusted_html = '<div class="trusted--static trusted is-marquee container">
  <p class="trusted__eyebrow">מהם בוטחים בנו</p>
  <div class="trusted__track" role="list" aria-label="לקוחות ושותפים">
    <div class="trusted__set">' . $logos_set . '</div>
    <div class="trusted__set" aria-hidden="true">' . $logos_set . '</div>
  </div>
  <p class="trusted__tail">ועוד חברות מובילות בתעשייה, בביטחון ובעולם הרחפנים</p>
</div>';

// ── s-equip: equipment carousel with spec-table body ─────────────────────────
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
    <h3 class="equip-card__name" dir="ltr">%3$s</h3>
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

// ── s-float: floating + sticky contact UI ────────────────────────────────────
$wa_href      = esc_attr( 'https://wa.me/972549992742' );
$wa_href_bar  = esc_attr( 'https://wa.me/972549992742' );

$float_html = '<div class="ani-float-cluster" role="complementary" aria-label="יצירת קשר מהיר">
  <a class="ani-float-btn ani-float-btn--call"
     href="tel:+972549992742"
     aria-label="התקשרו אלינו — TODO: החליפו מספר">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81 19.79 19.79 0 01.1 1.23 2 2 0 012.11 1h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
  </a>
  <a class="ani-float-btn ani-float-btn--whatsapp"
     href="' . $wa_href . '"
     target="_blank"
     rel="noopener noreferrer"
     aria-label="שלחו הודעת וואטסאפ — TODO: החליפו מספר">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
  </a>
</div>

<div class="ani-sticky-bar" role="complementary" aria-label="פעולות מהירות">
  <a class="btn btn--primary ani-sticky-bar__cta" href="#contact">דברו איתנו</a>
  <a class="ani-sticky-bar__wa"
     href="' . $wa_href_bar . '"
     target="_blank"
     rel="noopener noreferrer"
     aria-label="וואטסאפ">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
  </a>
</div>';

// ── full Elementor data array ─────────────────────────────────────────────────
$elementor_data = array(

	// s1 — HERO: mosaic v2 + copy-v2 zone with new eyebrow/h1/sub/CTAs/spec-table.
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
							'html' => '<div class="hero-shot">

  <!-- FULL-BLEED HERO SHOT -->
  <div class="hero-shot__media" role="img" aria-label="מכונת CNC חמישה צירים מייצרת חלק אלומיניום מדויק">
    <img src="' . esc_url( $theme_uri . '/assets/hero/mosaic-cnc.webp' ) . '"
         alt="ייצור CNC מדויק של חלק אלומיניום בעבודה"
         loading="eager" fetchpriority="high" width="1600" height="893">
    <span class="hero-shot__scrim" aria-hidden="true"></span>
  </div>

  <!-- OVERLAID COPY (RTL start = right) -->
  <div class="hero-shot__inner">
    <div class="hero-shot__copy">
      <p class="hero-shot__eyebrow">תכנון · ייצור · אינטגרציה — תחת קורת גג אחת</p>
      <h1>מהרעיון ועד המוצר המוגמר. כל שלב, אצלנו.</h1>
      <p class="hero-shot__sub">בית הנדסי אחד לכל המסלול: תכנון וייצור אבות טיפוס, חומרים מרוכבים, עיבוד שבבי <span dir="ltr">CNC</span>, הדפסת תלת-ממד, סריקה ומטרולוגיה, והרכבה ואינטגרציה. נבחרנו על ידי אלביט, התעשייה האווירית ויצרניות הרחפנים המובילות בישראל.</p>
      <p class="hero-shot__tagline">מתכננים. מפתחים. מייצרים. מגשימים רעיונות.</p>
      <div class="hero-shot__actions">
        <a class="btn btn--primary" href="#contact">דברו איתנו</a>
        <a class="btn btn--outline-hero btn--on-dark" href="tel:+972549992742">דברו עם מהנדס</a>
      </div>
    </div>
  </div>

</div>',
						),
					),
				),
			),
		),
	),

	// s1b — STATS STRIP (verbatim from polish file).
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

	// s-trusted — CLIENT ROSTER STRIP.
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

	// s-onestop — ONE-STOP MODEL (NEW).
	array(
		'id'       => 's-onestop',
		'elType'   => 'section',
		'settings' => array(
			'css_classes' => 'section onestop-section',
			'layout'      => 'full_width',
			'padding'     => array( 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true ),
		),
		'elements' => array(
			array(
				'id'       => 's-onestopc1',
				'elType'   => 'column',
				'settings' => array( '_column_size' => 100 ),
				'elements' => array(
					array(
						'id'         => 's-onestopw1',
						'elType'     => 'widget',
						'widgetType' => 'html',
						'settings'   => array(
							'html' => '<div class="container onestop__inner">
  <div class="dimline dimline--top" aria-hidden="true">
    <span class="dimline__tick"></span>
    <span class="dimline__rule"></span>
    <span class="dimline__tick dimline__tick--blue"></span>
  </div>

  <p class="section-eyebrow">ONE-STOP SHOP</p>
  <h2 class="section-title section-title--center">מה שאחרים מפזרים בין ספקים — אצלנו במקום אחד</h2>
  <p class="onestop__intro">רוב הפרויקטים עוברים בין מתכנן, בית דפוס, מפעל שבבי וקבלן הרכבה. אצלנו כל השרשרת תחת קורת גג אחת — פחות זמן, פחות סיכון, ואחריות אחת מהשרטוט ועד החלק הבדוק והמורכב.</p>

  <div class="onestop__chain" role="list" aria-label="שרשרת הייצור הפנימית">
    <div class="onestop__step" role="listitem">
      <span class="onestop__step-num">01</span>
      <span class="onestop__step-label">תכנון</span>
    </div>
    <span class="onestop__connector" aria-hidden="true"></span>
    <div class="onestop__step" role="listitem">
      <span class="onestop__step-num">02</span>
      <span class="onestop__step-label">הדפסה</span>
    </div>
    <span class="onestop__connector" aria-hidden="true"></span>
    <div class="onestop__step" role="listitem">
      <span class="onestop__step-num">03</span>
      <span class="onestop__step-label">CNC</span>
    </div>
    <span class="onestop__connector" aria-hidden="true"></span>
    <div class="onestop__step" role="listitem">
      <span class="onestop__step-num">04</span>
      <span class="onestop__step-label">חומרים מרוכבים</span>
    </div>
    <span class="onestop__connector" aria-hidden="true"></span>
    <div class="onestop__step" role="listitem">
      <span class="onestop__step-num">05</span>
      <span class="onestop__step-label">מטרולוגיה</span>
    </div>
    <span class="onestop__connector" aria-hidden="true"></span>
    <div class="onestop__step" role="listitem">
      <span class="onestop__step-num">06</span>
      <span class="onestop__step-label">הרכבה</span>
    </div>
  </div>
</div>',
						),
					),
				),
			),
		),
	),

	// s3 — CAPABILITIES CAROUSEL (with spec-row per card).
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

	// s-process — PROCESS CHAIN 01→07 (NEW).
	array(
		'id'       => 's-process',
		'elType'   => 'section',
		'settings' => array(
			'css_classes' => 'section process-chain-section section--surface',
			'layout'      => 'full_width',
			'padding'     => array( 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true ),
		),
		'elements' => array(
			array(
				'id'       => 's-processc1',
				'elType'   => 'column',
				'settings' => array( '_column_size' => 100 ),
				'elements' => array(
					array(
						'id'         => 's-processw1',
						'elType'     => 'widget',
						'widgetType' => 'html',
						'settings'   => array(
							'html' => '<div class="container">
  <p class="section-eyebrow">01 → 07</p>
  <h2 class="section-title section-title--center">איך רעיון הופך לחומרה</h2>
</div>
<div class="process-chain" role="list" aria-label="שלבי הייצור">
  <div class="process-chain__step" role="listitem">
    <div class="process-chain__num-wrap">
      <span class="process-chain__num">01</span>
    </div>
    <span class="process-chain__label">רעיון ואפיון</span>
    <span class="process-chain__connector" aria-hidden="true"></span>
  </div>
  <div class="process-chain__step" role="listitem">
    <div class="process-chain__num-wrap">
      <span class="process-chain__num">02</span>
    </div>
    <span class="process-chain__label">תכנון הנדסי ו-<span dir="ltr">DFM</span></span>
    <span class="process-chain__connector" aria-hidden="true"></span>
  </div>
  <div class="process-chain__step" role="listitem">
    <div class="process-chain__num-wrap">
      <span class="process-chain__num">03</span>
    </div>
    <span class="process-chain__label">סריקה והנדסה לאחור</span>
    <span class="process-chain__connector" aria-hidden="true"></span>
  </div>
  <div class="process-chain__step" role="listitem">
    <div class="process-chain__num-wrap">
      <span class="process-chain__num">04</span>
    </div>
    <span class="process-chain__label">הדפסת תלת-ממד</span>
    <span class="process-chain__connector" aria-hidden="true"></span>
  </div>
  <div class="process-chain__step" role="listitem">
    <div class="process-chain__num-wrap">
      <span class="process-chain__num">05</span>
    </div>
    <span class="process-chain__label">עיבוד שבבי</span>
    <span class="process-chain__connector" aria-hidden="true"></span>
  </div>
  <div class="process-chain__step" role="listitem">
    <div class="process-chain__num-wrap">
      <span class="process-chain__num">06</span>
    </div>
    <span class="process-chain__label">חומרים מרוכבים</span>
    <span class="process-chain__connector" aria-hidden="true"></span>
  </div>
  <div class="process-chain__step process-chain__step--last" role="listitem">
    <div class="process-chain__num-wrap process-chain__num-wrap--blue">
      <span class="process-chain__num">07</span>
    </div>
    <span class="process-chain__label">הרכבה, בדיקה ומסירה</span>
  </div>
</div>',
						),
					),
				),
			),
		),
	),

	// s-equip — EQUIPMENT CAROUSEL (spec-table body).
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

	// s-certs — CERTIFICATIONS / QUALITY (NEW).
	array(
		'id'       => 's-certs',
		'elType'   => 'section',
		'settings' => array(
			'css_classes' => 'section certs-section',
			'layout'      => 'full_width',
			'padding'     => array( 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true ),
		),
		'elements' => array(
			array(
				'id'       => 's-certsc1',
				'elType'   => 'column',
				'settings' => array( '_column_size' => 100 ),
				'elements' => array(
					array(
						'id'         => 's-certsw1',
						'elType'     => 'widget',
						'widgetType' => 'html',
						'settings'   => array(
							'html' => '<div class="container certs__inner">
  <div class="dimline dimline--top" aria-hidden="true">
    <span class="dimline__tick dimline__tick--blue"></span>
    <span class="dimline__rule"></span>
    <span class="dimline__tick"></span>
  </div>

  <p class="section-eyebrow">QUALITY ASSURANCE</p>
  <h2 class="section-title section-title--center">איכות שעומדת בדרישות הקפדניות ביותר</h2>

  <div class="certs__badges" role="list" aria-label="תקני איכות">
    <div class="cert-badge" role="listitem">
      <span class="cert-badge__code" dir="ltr">ISO 9001</span>
      <span class="cert-badge__label">ניהול איכות</span>
    </div>
    <div class="cert-badge cert-badge--accent" role="listitem">
      <span class="cert-badge__code" dir="ltr">AS9100</span>
      <span class="cert-badge__label">תעשייה אווירית</span>
    </div>
    <div class="cert-badge" role="listitem">
      <span class="cert-badge__code" dir="ltr">ISO 13485</span>
      <span class="cert-badge__label">ציוד רפואי</span>
    </div>
  </div>

  <ul class="certs__features" role="list">
    <li class="certs__feature"><span class="certs__feature-dot" aria-hidden="true"></span>מטרולוגיית <span dir="ltr">CMM</span> פנימית</li>
    <li class="certs__feature"><span class="certs__feature-dot" aria-hidden="true"></span>עבודה תחת <span dir="ltr">NDA</span></li>
    <li class="certs__feature"><span class="certs__feature-dot" aria-hidden="true"></span>בקרת איכות בכל שלב</li>
  </ul>
</div>',
						),
					),
				),
			),
		),
	),

	// s4b — INDUSTRIES (heading + intro copy-v2; sectors kept).
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

	// s6 — RFQ / CTA BAND (restructured per blueprint).
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
  <p class="cta-band__eyebrow">SEND YOUR PART</p>
  <h2 class="cta-band__title">יש לכם חלק? נחזיר לכם הצעה.</h2>
  <p class="cta-band__sub">שלחו שרטוט, קובץ <span dir="ltr">CAD</span> (<span dir="ltr">STEP / STL / IGES / PDF</span>) או רק תיאור — ונחזור אליכם עם הצעה ולוח זמנים. קבצים גדולים? צרפו קישור ל-<span dir="ltr">Drive/WeTransfer</span>. <span dir="ltr">NDA</span> זמין על פי בקשה.</p>

  <div class="cta-band__actions">
    <a class="btn btn--primary" href="/contact">דברו איתנו</a>
    <a class="btn btn--outline-band" href="tel:+972549992742">דברו עם מהנדס</a>
  </div>

  <div class="cta-band__formats" aria-label="פורמטי קובץ נתמכים">
    <span class="cta-fmt" dir="ltr">STEP</span>
    <span class="cta-fmt" dir="ltr">STL</span>
    <span class="cta-fmt" dir="ltr">IGES</span>
    <span class="cta-fmt" dir="ltr">PDF</span>
  </div>

  <p class="cta-band__nda"><span dir="ltr">NDA</span> זמין על פי בקשה</p>
</div>',
						),
					),
				),
			),
		),
	),

	// s-float — FLOATING / STICKY ELEMENTS.
	array(
		'id'       => 's-float',
		'elType'   => 'section',
		'settings' => array(
			'css_classes' => 'ani-float-ui',
			'layout'      => 'full_width',
			'padding'     => array( 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true ),
		),
		'elements' => array(
			array(
				'id'       => 's-floatc1',
				'elType'   => 'column',
				'settings' => array( '_column_size' => 100 ),
				'elements' => array(
					array(
						'id'         => 's-floatw1',
						'elType'     => 'widget',
						'widgetType' => 'html',
						'settings'   => array( 'html' => $float_html ),
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
	WP_CLI::success( 'Done. Homepage rebuild applied: copy-v2 hero, stats, trusted, one-stop, caps+spec-row, process-chain, equip spec-table, certs, industries, CTA band, float UI. Page ID ' . $page_id . '.' );
} else {
	WP_CLI::success( 'Done. Homepage rebuild applied. Run: wp elementor flush-css. Page ID ' . $page_id . '.' );
}
