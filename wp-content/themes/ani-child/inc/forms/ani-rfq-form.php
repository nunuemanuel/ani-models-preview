<?php
/**
 * ANI RFQ Form — render template.
 *
 * Shortcode: [ani_rfq_form]
 * Handler:   admin-post action ani_rfq_form
 *
 * Fields: שם מלא (text, required), אימייל (email, required, dir=ltr),
 *         טלפון (tel, required, dir=ltr), יכולת/שירות (select),
 *         פרטי הפרויקט (textarea), CAD file upload (up to 3 × 25MB),
 *         consent checkbox (required).
 *
 * RTL-Hebrew default; LTR isolation on email/phone.  WPCS 3.x.
 *
 * @package ani
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Success / error state from the redirect query args.
// phpcs:disable WordPress.Security.NonceVerification.Recommended -- read-only display state, no mutation.
$ani_rfq_status = isset( $_GET['ani_status'], $_GET['ani_form'] ) && 'rfq' === sanitize_key( wp_unslash( $_GET['ani_form'] ) )
	? sanitize_key( wp_unslash( $_GET['ani_status'] ) )
	: '';
// phpcs:enable WordPress.Security.NonceVerification.Recommended

$ani_rfq_show_success   = ( 'success' === $ani_rfq_status );
$ani_rfq_show_error     = ( 'error' === $ani_rfq_status );
$ani_rfq_show_ratelimit = ( 'ratelimit' === $ani_rfq_status );

$ani_rfq_privacy_url = get_permalink( get_page_by_path( 'privacy' ) ) ?: home_url( '/privacy/' );

$ani_rfq_services = ani_service_options();

// Accepted extensions for the file input attribute (comma-separated).
$ani_rfq_accept = '.step,.stp,.stl,.iges,.igs,.dxf,.sldprt,.pdf';
?>

<div
	class="ani-form-wrap"
	id="ani-rfq-form-wrap"
	dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>"
>

	<?php if ( $ani_rfq_show_success ) : ?>
		<div
			class="ani-form-notice ani-form-notice--success"
			role="alert"
			aria-live="assertive"
			tabindex="-1"
			id="ani-rfq-success"
		>
			<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
				<path d="M20 6 9 17l-5-5"/>
			</svg>
			<span><?php esc_html_e( 'תודה! קיבלנו את בקשתך ונחזור אליכם עם הצעת מחיר תוך 24 שעות עסקיות.', 'ani' ); ?></span>
		</div>

	<?php elseif ( $ani_rfq_show_ratelimit ) : ?>
		<div
			class="ani-form-notice ani-form-notice--error"
			role="alert"
			aria-live="assertive"
			tabindex="-1"
		>
			<?php esc_html_e( 'שלחת יותר מדי פניות בזמן קצר. אנא המתן מספר דקות ונסה שוב.', 'ani' ); ?>
		</div>

	<?php elseif ( $ani_rfq_show_error ) : ?>
		<div
			class="ani-form-notice ani-form-notice--error"
			role="alert"
			aria-live="assertive"
			tabindex="-1"
			id="ani-rfq-error-summary"
		>
			<?php esc_html_e( 'אירעה שגיאה. נא לבדוק את השדות ולנסות שוב.', 'ani' ); ?>
		</div>

	<?php endif; ?>

	<?php if ( ! $ani_rfq_show_success ) : ?>

	<form
		class="ani-form"
		id="ani-rfq-form"
		method="post"
		action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"
		novalidate
		enctype="multipart/form-data"
		aria-labelledby="ani-rfq-form-heading"
	>
		<?php wp_nonce_field( 'ani_rfq_submit', 'ani_rfq_nonce' ); ?>
		<input type="hidden" name="action" value="ani_rfq_form">

		<!-- Honeypot: must stay empty. Hidden from humans via CSS. -->
		<div class="ani-form__honeypot" aria-hidden="true" tabindex="-1">
			<label for="ani_hp_website_rfq"><?php esc_html_e( 'אל תמלא שדה זה', 'ani' ); ?></label>
			<input
				type="text"
				id="ani_hp_website_rfq"
				name="ani_hp_website"
				value=""
				autocomplete="off"
				tabindex="-1"
				focusable="false"
			>
		</div>

		<fieldset class="ani-form__fieldset">
			<legend class="ani-form__legend" id="ani-rfq-form-heading">
				<?php esc_html_e( 'בקשת הצעת מחיר', 'ani' ); ?>
			</legend>
			<p class="ani-form__subtitle">
				<?php esc_html_e( 'מלאו את הפרטים ונחזור אליכם עם הצעה מפורטת תוך 24 שעות עסקיות.', 'ani' ); ?>
			</p>

		<div class="ani-form__grid">

			<!-- שם מלא -->
			<div class="ani-form__field ani-form__field--half">
				<label class="ani-form__label" for="ani_rfq_name">
					<?php esc_html_e( 'שם מלא', 'ani' ); ?>
					<span class="ani-form__required" aria-hidden="true">*</span>
				</label>
				<input
					class="ani-form__input"
					type="text"
					id="ani_rfq_name"
					name="ani_rfq_name"
					value=""
					required
					aria-required="true"
					autocomplete="name"
					aria-describedby="ani_rfq_name_error"
					<?php echo $ani_rfq_show_error ? 'aria-invalid="true"' : ''; ?>
				>
				<span
					class="ani-form__error"
					id="ani_rfq_name_error"
					role="alert"
					aria-live="polite"
				>
					<?php if ( $ani_rfq_show_error ) : ?>
						<?php esc_html_e( 'נא להזין שם מלא.', 'ani' ); ?>
					<?php endif; ?>
				</span>
			</div>

			<!-- אימייל -->
			<div class="ani-form__field ani-form__field--half">
				<label class="ani-form__label" for="ani_rfq_email">
					<?php esc_html_e( 'אימייל', 'ani' ); ?>
					<span class="ani-form__required" aria-hidden="true">*</span>
				</label>
				<input
					class="ani-form__input ani-form__input--ltr"
					type="email"
					id="ani_rfq_email"
					name="ani_rfq_email"
					value=""
					required
					aria-required="true"
					autocomplete="email"
					inputmode="email"
					dir="ltr"
					aria-describedby="ani_rfq_email_error"
					<?php echo $ani_rfq_show_error ? 'aria-invalid="true"' : ''; ?>
				>
				<span
					class="ani-form__error"
					id="ani_rfq_email_error"
					role="alert"
					aria-live="polite"
				>
					<?php if ( $ani_rfq_show_error ) : ?>
						<?php esc_html_e( 'נא להזין כתובת אימייל תקינה.', 'ani' ); ?>
					<?php endif; ?>
				</span>
			</div>

			<!-- טלפון -->
			<div class="ani-form__field ani-form__field--half">
				<label class="ani-form__label" for="ani_rfq_phone">
					<?php esc_html_e( 'טלפון', 'ani' ); ?>
					<span class="ani-form__required" aria-hidden="true">*</span>
				</label>
				<input
					class="ani-form__input ani-form__input--ltr"
					type="tel"
					id="ani_rfq_phone"
					name="ani_rfq_phone"
					value=""
					required
					aria-required="true"
					autocomplete="tel"
					inputmode="tel"
					dir="ltr"
					aria-describedby="ani_rfq_phone_error ani_rfq_phone_hint"
					<?php echo $ani_rfq_show_error ? 'aria-invalid="true"' : ''; ?>
				>
				<span class="ani-form__hint" id="ani_rfq_phone_hint">
					<bdi><?php esc_html_e( 'לדוגמה: 050-1234567', 'ani' ); ?></bdi>
				</span>
				<span
					class="ani-form__error"
					id="ani_rfq_phone_error"
					role="alert"
					aria-live="polite"
				>
					<?php if ( $ani_rfq_show_error ) : ?>
						<?php esc_html_e( 'נא להזין מספר טלפון.', 'ani' ); ?>
					<?php endif; ?>
				</span>
			</div>

			<!-- יכולת / שירות -->
			<div class="ani-form__field ani-form__field--half">
				<label class="ani-form__label" for="ani_rfq_service">
					<?php esc_html_e( 'יכולת / שירות', 'ani' ); ?>
					<span class="ani-form__optional"><?php esc_html_e( '(אופציונלי)', 'ani' ); ?></span>
				</label>
				<select
					class="ani-form__select"
					id="ani_rfq_service"
					name="ani_rfq_service"
					autocomplete="off"
					aria-describedby="ani_rfq_service_error"
				>
					<?php foreach ( $ani_rfq_services as $val => $label ) : ?>
						<option value="<?php echo esc_attr( $val ); ?>">
							<?php echo esc_html( $label ); ?>
						</option>
					<?php endforeach; ?>
				</select>
				<span class="ani-form__error" id="ani_rfq_service_error" role="alert" aria-live="polite"></span>
			</div>

			<!-- פרטי הפרויקט -->
			<div class="ani-form__field">
				<label class="ani-form__label" for="ani_rfq_details">
					<?php esc_html_e( 'פרטי הפרויקט', 'ani' ); ?>
					<span class="ani-form__optional"><?php esc_html_e( '(אופציונלי)', 'ani' ); ?></span>
				</label>
				<textarea
					class="ani-form__textarea"
					id="ani_rfq_details"
					name="ani_rfq_details"
					rows="5"
					autocomplete="off"
					aria-describedby="ani_rfq_details_error"
				></textarea>
				<span class="ani-form__error" id="ani_rfq_details_error" role="alert" aria-live="polite"></span>
			</div>

			<!-- קבצי CAD -->
			<div class="ani-form__field">
				<label class="ani-form__label" for="ani_rfq_files">
					<?php esc_html_e( 'קובץ CAD / מפרט טכני', 'ani' ); ?>
					<span class="ani-form__optional"><?php esc_html_e( '(אופציונלי)', 'ani' ); ?></span>
				</label>
				<div class="ani-form__upload-zone" id="ani-upload-zone">
					<input
						class="ani-form__file"
						type="file"
						id="ani_rfq_files"
						name="ani_rfq_files[]"
						multiple
						accept="<?php echo esc_attr( $ani_rfq_accept ); ?>"
						aria-describedby="ani_rfq_files_hint ani_rfq_files_error"
					>
					<label class="ani-form__upload-label" for="ani_rfq_files">
						<span class="ani-form__upload-icon-chip" aria-hidden="true">
							<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
								<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
								<polyline points="17 8 12 3 7 8"/>
								<line x1="12" y1="3" x2="12" y2="15"/>
							</svg>
						</span>
						<span class="ani-form__upload-cta">
							<?php esc_html_e( 'גרור קבצים לכאן', 'ani' ); ?>
							&nbsp;<em><?php esc_html_e( 'או לחצו לבחירה', 'ani' ); ?></em>
						</span>
						<span class="ani-form__upload-formats">
							STEP &middot; STP &middot; STL &middot; IGES &middot; IGS &middot; DXF &middot; SLDPRT &middot; PDF
						</span>
					</label>
					<div class="ani-form__file-list" id="ani-file-list" aria-live="polite" aria-atomic="false"></div>
				</div>
				<p class="ani-form__hint" id="ani_rfq_files_hint">
					<?php esc_html_e( 'עד 3 קבצים, עד 25MB כל קובץ.', 'ani' ); ?>
				</p>
				<span class="ani-form__error" id="ani_rfq_files_error" role="alert" aria-live="polite"></span>
			</div>

			<!-- הסכמה -->
			<div class="ani-form__field ani-form__field--checkbox">
				<label class="ani-form__checkbox-label" for="ani_rfq_consent">
					<input
						class="ani-form__checkbox"
						type="checkbox"
						id="ani_rfq_consent"
						name="ani_rfq_consent"
						value="1"
						required
						aria-required="true"
						aria-describedby="ani_rfq_consent_error"
						<?php echo $ani_rfq_show_error ? 'aria-invalid="true"' : ''; ?>
					>
					<span class="ani-form__checkbox-text">
						<?php
						printf(
							/* translators: 1: opening <a> tag  2: closing </a> tag */
							esc_html__( 'קראתי ואני מסכים/ה ל%1$sמדיניות הפרטיות%2$s', 'ani' ),
							'<a href="' . esc_url( $ani_rfq_privacy_url ) . '" target="_blank" rel="noopener noreferrer">',
							'</a>'
						);
						?>
					</span>
				</label>
				<span
					class="ani-form__error"
					id="ani_rfq_consent_error"
					role="alert"
					aria-live="polite"
				>
					<?php if ( $ani_rfq_show_error ) : ?>
						<?php esc_html_e( 'יש לאשר את תנאי הפרטיות.', 'ani' ); ?>
					<?php endif; ?>
				</span>
			</div>

			<!-- Submit -->
			<div class="ani-form__field ani-form__field--submit">
				<button
					class="btn btn--primary ani-form__submit"
					type="submit"
					data-ani-submitting-text="<?php esc_attr_e( 'שולח...', 'ani' ); ?>"
				>
					<?php esc_html_e( 'בקשת הצעת מחיר', 'ani' ); ?>
					<svg class="ani-form__submit-arrow" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
						<path d="M5 12h14M12 5l7 7-7 7"/>
					</svg>
				</button>
			</div>

		</div><!-- .ani-form__grid -->

		</fieldset>

	</form>

	<?php endif; // ! $ani_rfq_show_success ?>

</div><!-- .ani-form-wrap -->
