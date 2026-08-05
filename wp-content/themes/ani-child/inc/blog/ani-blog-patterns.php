<?php
/**
 * ANI Child Theme — Blog block patterns.
 *
 * Registers the "ANI Article" block pattern under the 'ani' category.
 * Pure core blocks, RTL-safe, placeholder labels in Hebrew (no marketing copy).
 * Owner inserts the pattern when creating a new post and fills in text.
 *
 * @package ani
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the 'ani' block-pattern category.
 */
function ani_register_pattern_categories() {
	register_block_pattern_category(
		'ani',
		array(
			'label' => __( 'א.נ.י', 'ani' ),
		)
	);
}
add_action( 'init', 'ani_register_pattern_categories' );

/**
 * Register the ANI Article skeleton block pattern.
 *
 * Structure (top → bottom):
 *   1. Answer-first callout (Group / styled paragraph)
 *   2. Body section — H2 + paragraphs placeholder
 *   3. Comparison table placeholder
 *   4. FAQ block — 3 details/summary pairs (visible Q&A for FAQPage schema)
 *   5. Internal-link block — links up to pillar + across to capability page
 *   6. RFQ CTA block — button to /contact/
 *
 * Note: H1 comes from the post title; the Author byline and date are rendered
 * by single.php and styled via blog.css — not repeated inside the pattern.
 */
function ani_register_article_pattern() {
	register_block_pattern(
		'ani/ani-article',
		array(
			'title'       => __( 'ANI Article', 'ani' ),
			'description' => __( 'שלד מאמר מלא: תשובה ישירה, גוף, טבלת השוואה, שאלות נפוצות, קישורים פנימיים, CTA לבקשת הצעת מחיר.', 'ani' ),
			'categories'  => array( 'ani' ),
			'keywords'    => array( 'article', 'blog', 'ani', 'מאמר', 'בלוג' ),
			'content'     => ani_article_pattern_content(),
		)
	);
}
add_action( 'init', 'ani_register_article_pattern' );

/**
 * Returns the block markup string for the ANI Article pattern.
 *
 * Kept as a function so the heredoc is easy to read and edit.
 *
 * @return string
 */
function ani_article_pattern_content() {
	/* translators: placeholder text for the author/date byline inside the pattern */
	$byline_label = __( 'שם מחבר | תאריך פרסום', 'ani' );
	/* translators: placeholder text for the answer-first callout */
	$answer_placeholder = __( '[תשובה ישירה — 40–60 מילה. ציין את הנושא, סיים בעובדה קונקרטית.]', 'ani' );
	/* translators: heading placeholder for first H2 */
	$h2_placeholder = __( 'שאלה ראשית — H2', 'ani' );
	/* translators: paragraph placeholder */
	$para_placeholder = __( '[פסקה — תוכן המאמר. כל נתון מספרי מאומת על ידי א.נ.י עם מקור מקושר.]', 'ani' );
	/* translators: table caption placeholder */
	$table_caption = __( 'טבלת השוואה — [ציין ממה להשוות]', 'ani' );
	/* translators: FAQ section heading */
	$faq_heading = __( 'שאלות נפוצות', 'ani' );
	/* translators: FAQ question 1 */
	$faq_q1 = __( 'שאלה ראשונה?', 'ani' );
	/* translators: FAQ answer 1 */
	$faq_a1 = __( '[תשובה — 40–60 מילה, ישירה, מסתיימת בעובדה.]', 'ani' );
	/* translators: FAQ question 2 */
	$faq_q2 = __( 'שאלה שנייה?', 'ani' );
	/* translators: FAQ answer 2 */
	$faq_a2 = __( '[תשובה.]', 'ani' );
	/* translators: FAQ question 3 */
	$faq_q3 = __( 'שאלה שלישית?', 'ani' );
	/* translators: FAQ answer 3 */
	$faq_a3 = __( '[תשובה.]', 'ani' );
	/* translators: related links heading */
	$related_heading = __( 'מאמרים קשורים וקישורים פנימיים', 'ani' );
	/* translators: pillar link placeholder text */
	$pillar_link = __( '← קרא עוד: [שם עמוד היכולת / מאמר הפילאר]', 'ani' );
	/* translators: capability link placeholder text */
	$cap_link = __( '← לעמוד היכולת: [/שם-עמוד-היכולת/]', 'ani' );
	/* translators: CTA heading */
	$cta_heading = __( 'מוכנים לצאת לדרך?', 'ani' );
	/* translators: CTA subtext */
	$cta_sub = __( 'שלחו לנו בקשת הצעת מחיר ותקבלו תגובה תוך 24 שעות.', 'ani' );
	/* translators: CTA button label */
	$cta_btn = __( 'בקשת הצעת מחיר', 'ani' );

	// phpcs:disable Generic.Files.LineLength.TooLong -- block markup requires long lines.
	return '<!-- wp:group {"className":"ani-answer-block","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}},"border":{"left":{"color":"var:preset|color|blue","width":"4px"},"radius":"4px"}},"backgroundColor":"surface"} -->
<div class="wp-block-group ani-answer-block">
<!-- wp:paragraph {"placeholder":"' . esc_attr( $answer_placeholder ) . '","fontSize":"medium"} -->
<p class="has-medium-font-size">' . esc_html( $answer_placeholder ) . '</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">' . esc_html( $h2_placeholder ) . '</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . esc_html( $para_placeholder ) . '</p>
<!-- /wp:paragraph -->

<!-- wp:table {"hasFixedLayout":false,"className":"ani-comparison-table"} -->
<figure class="wp-block-table ani-comparison-table"><table><caption>' . esc_html( $table_caption ) . '</caption><thead><tr><th>' . esc_html__( 'קריטריון', 'ani' ) . '</th><th>' . esc_html__( 'אפשרות א׳', 'ani' ) . '</th><th>' . esc_html__( 'אפשרות ב׳', 'ani' ) . '</th></tr></thead><tbody><tr><td>' . esc_html__( '[שורה 1]', 'ani' ) . '</td><td></td><td></td></tr><tr><td>' . esc_html__( '[שורה 2]', 'ani' ) . '</td><td></td><td></td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">' . esc_html( $faq_heading ) . '</h2>
<!-- /wp:heading -->

<!-- wp:details {"className":"ani-faq-item"} -->
<details class="wp-block-details ani-faq-item"><summary>' . esc_html( $faq_q1 ) . '</summary>
<!-- wp:paragraph -->
<p>' . esc_html( $faq_a1 ) . '</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details {"className":"ani-faq-item"} -->
<details class="wp-block-details ani-faq-item"><summary>' . esc_html( $faq_q2 ) . '</summary>
<!-- wp:paragraph -->
<p>' . esc_html( $faq_a2 ) . '</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details {"className":"ani-faq-item"} -->
<details class="wp-block-details ani-faq-item"><summary>' . esc_html( $faq_q3 ) . '</summary>
<!-- wp:paragraph -->
<p>' . esc_html( $faq_a3 ) . '</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:group {"className":"ani-related-links","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}},"border":{"top":{"color":"var:preset|color|border","width":"1px"}}}} -->
<div class="wp-block-group ani-related-links">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">' . esc_html( $related_heading ) . '</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p><a href="#">' . esc_html( $pillar_link ) . '</a></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p><a href="#">' . esc_html( $cap_link ) . '</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"ani-cta-block","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}},"border":{"radius":"8px"}},"backgroundColor":"ink","textColor":"white"} -->
<div class="wp-block-group ani-cta-block has-white-color has-ink-background-color">
<!-- wp:heading {"level":2,"textColor":"white","style":{"typography":{"fontSize":"1.4rem"}}} -->
<h2 class="wp-block-heading has-white-color has-text-color" style="font-size:1.4rem">' . esc_html( $cta_heading ) . '</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color">' . esc_html( $cta_sub ) . '</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"ani-btn ani-btn--primary"} -->
<div class="wp-block-button ani-btn ani-btn--primary"><a class="wp-block-button__link wp-element-button" href="/contact/">' . esc_html( $cta_btn ) . '</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->';
	// phpcs:enable
}
