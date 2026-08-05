<?php
/**
 * Template Name: Contact / RFQ
 *
 * Contact page — NO form. A blue-branded contact surface built around two
 * primary actions: a prominent WhatsApp button and click-to-call, plus the
 * bureau's contact details and a map. RTL-Hebrew; tel/WhatsApp/email are
 * LTR-isolated.
 *
 * @package ani
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

/*
 * Contact data. Phone confirmed by client: +972 54-999-2742.
 *   - $phone_e164   → digits only, for tel: and wa.me.
 *   - $phone_display→ human-readable, LTR-isolated in the markup.
 * NOTE: $whatsapp_prefill is a DEFAULT prompt — replace with the client's
 *       exact prepared message when supplied (Hebrew copy is the client's).
 */
$phone_e164      = '972549992742';
$phone_display   = '054-999-2742';
$tel_href        = 'tel:+' . $phone_e164;
$email_display   = 'info@ani-models.co.il';
$email_href      = 'mailto:info@ani-models.co.il';
$address_line    = __( 'רחובות, ישראל', 'ani' );

$whatsapp_prefill = __( 'שלום, הגעתי דרך האתר ואשמח לקבל הצעת מחיר.', 'ani' );
// wa.me link: encode the prefilled text. Use esc_attr (NOT esc_url) so encoded
// characters survive — esc_url strips %0A/%0D (house rule).
$whatsapp_href = 'https://wa.me/' . $phone_e164 . '?text=' . rawurlencode( $whatsapp_prefill );

// Keyless Google Maps embed — swap q= for the exact street address at launch.
$map_src = 'https://maps.google.com/maps?q=Rehovot%2C%20Israel&z=13&output=embed';
?>

<div class="ani-contact">

	<!-- ===================================================== HERO (brand blue) -->
	<section class="ani-contact-hero">
		<div class="ani-contact-hero__inner ani-container">
			<p class="ani-contact-hero__eyebrow">
				<?php esc_html_e( 'בואו נדבר', 'ani' ); ?>
			</p>
			<h1 class="ani-contact-hero__title">
				<?php esc_html_e( 'צור קשר', 'ani' ); ?>
			</h1>
			<p class="ani-contact-hero__intro">
				<?php esc_html_e( 'יש לכם חלק, שרטוט או רעיון? דברו איתנו ישירות בוואטסאפ או בטלפון — נחזור אליכם עם הצעת מחיר תוך 24 שעות עסקיות.', 'ani' ); ?>
			</p>

			<!-- Primary actions: WhatsApp + Call -->
			<div class="ani-contact-hero__actions">
				<a
					class="ani-contact-cta ani-contact-cta--whatsapp"
					href="<?php echo esc_attr( $whatsapp_href ); ?>"
					target="_blank"
					rel="noopener noreferrer"
				>
					<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false">
						<path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
					</svg>
					<span class="ani-contact-cta__text">
						<span class="ani-contact-cta__label"><?php esc_html_e( 'שלחו הודעת WhatsApp', 'ani' ); ?></span>
						<span class="ani-contact-cta__sub" dir="ltr"><?php echo esc_html( $phone_display ); ?></span>
					</span>
				</a>

				<a class="ani-contact-cta ani-contact-cta--call" href="<?php echo esc_attr( $tel_href ); ?>">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
						<path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.39 19a19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2 4.18 2 2 0 0 1 4 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92Z"/>
					</svg>
					<span class="ani-contact-cta__text">
						<span class="ani-contact-cta__label"><?php esc_html_e( 'התקשרו עכשיו', 'ani' ); ?></span>
						<span class="ani-contact-cta__sub" dir="ltr"><?php echo esc_html( $phone_display ); ?></span>
					</span>
				</a>
			</div>
		</div>
	</section><!-- .ani-contact-hero -->

	<!-- ===================================================== DETAILS + MAP -->
	<section class="ani-contact-body ani-container">

		<div class="ani-contact-grid">

			<!-- Compact contact buttons (call + email). Address is on the map. -->
			<div class="ani-contact-buttons" aria-label="<?php esc_attr_e( 'פרטי יצירת קשר', 'ani' ); ?>">
				<a class="ani-contact-btn" href="<?php echo esc_attr( $tel_href ); ?>">
					<span class="ani-contact-btn__icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" focusable="false">
							<path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.39 19a19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2 4.18 2 2 0 0 1 4 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92Z"/>
						</svg>
					</span>
					<span class="ani-contact-btn__text">
						<span class="ani-contact-btn__label"><?php esc_html_e( 'טלפון', 'ani' ); ?></span>
						<span class="ani-contact-btn__value ani-ltr" dir="ltr"><?php echo esc_html( $phone_display ); ?></span>
					</span>
				</a>

				<a class="ani-contact-btn" href="<?php echo esc_attr( $email_href ); ?>">
					<span class="ani-contact-btn__icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" focusable="false">
							<rect x="2" y="4" width="20" height="16" rx="2"/>
							<path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
						</svg>
					</span>
					<span class="ani-contact-btn__text">
						<span class="ani-contact-btn__label"><?php esc_html_e( 'אימייל', 'ani' ); ?></span>
						<span class="ani-contact-btn__value ani-ltr" dir="ltr"><?php echo esc_html( $email_display ); ?></span>
					</span>
				</a>
			</div><!-- .ani-contact-buttons -->

			<!-- Map -->
			<div class="ani-contact-map">
				<iframe
					src="<?php echo esc_url( $map_src ); ?>"
					width="100%"
					height="100%"
					style="border:0"
					loading="lazy"
					referrerpolicy="no-referrer-when-downgrade"
					title="<?php esc_attr_e( 'מפה — רחובות, ישראל', 'ani' ); ?>"
				></iframe>
			</div>

		</div><!-- .ani-contact-grid -->

	</section><!-- .ani-contact-body -->

</div><!-- .ani-contact -->

<?php
get_footer();
