<?php
/**
 * ANI Callback Form — render template.
 *
 * Shortcode: [ani_callback_form]
 * Handler:   admin-post action ani_callback_form
 *
 * Fields: שם מלא (text, required), טלפון (tel, required, dir=ltr),
 *         נושא/שירות (select, optional), consent checkbox (required).
 *
 * RTL-Hebrew default; LTR isolation on phone.  WPCS 3.x.
 *
 * @package ani
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Success / error state from the redirect query args.
// phpcs:disable WordPress.Security.NonceVerification.Recommended -- read-only display state, no mutation.
$ani_cb_status = isset( $_GET['ani_status'], $_GET['ani_form'] ) && 'callback' === sanitize_key( wp_unslash( $_GET['ani_form'] ) )
	? sanitize_key( wp_unslash( $_GET['ani_status'] ) )
	: '';
// phpcs:enable WordPress.Security.NonceVerification.Recommended

$ani_cb_show_success   = ( 'success' === $ani_cb_status );
$ani_cb_show_error     = ( 'error' === $ani_cb_status );
$ani_cb_show_ratelimit = ( 'ratelimit' === $ani_cb_status );

$ani_cb_privacy_url = get_permalink( get_page_by_path( 'privacy' ) ) ?: home_url( '/privacy/' );

$ani_cb_services = ani_service_options();
?>

<div
	class="ani-form-wrap"
	id="ani-callback-form-wrap"
	dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>"
>

	<?php if ( $ani_cb_show_success ) : ?>
		<div
			class="ani-form-notice ani-form-notice--success"
			role="alert"
			aria-live="assertive"
			tabindex="-1"
			id="ani-callback-success"
		>
			<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
				<path d="M20 6 9 17l-5-5"/>
			</svg>
			<span><?php esc_html_e( 'תודה! קיבלנו את פנייתך ונחזור אליכם בהקדם.', 'ani' ); ?></span>
		</div>

	<?php elseif ( $ani_cb_show_ratelimit ) : ?>
		<div
			class="ani-form-notice ani-form-notice--error"
			role="alert"
			aria-live="assertive"
			tabindex="-1"
		>
			<?php esc_html_e( 'שלחת יותר מדי פניות בזמן קצר. אנא המתן מספר דקות ונסה שוב.', 'ani' ); ?>
		</div>

	<?php elseif ( $ani_cb_show_error ) : ?>
		<div
			class="ani-form-notice ani-form-notice--error"
			role="alert"
			aria-live="assertive"
			tabindex="-1"
			id="ani-callback-error-summary"
		>
			<?php esc_html_e( 'אירעה שגיאה. נא לבדוק את השדות ולנסות שוב.', 'ani' ); ?>
		</div>

	<?php endif; ?>

	<?php if ( ! $ani_cb_show_success ) : ?>

	<form
		class="ani-form"
		id="ani-callback-form"
		method="post"
		action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"
		novalidate
		enctype="application/x-www-form-urlencoded"
		aria-labelledby="ani-callback-form-heading"
	>
		<?php wp_nonce_field( 'ani_callback_submit', 'ani_callback_nonce' ); ?>
		<input type="hidden" name="action" value="ani_callback_form">

		<!-- Honeypot: must stay empty. Hidden from humans via CSS. -->
		<div class="ani-form__honeypot" aria-hidden="true" tabindex="-1">
			<label for="ani_hp_website_cb"><?php esc_html_e( 'אל תמלא שדה זה', 'ani' ); ?></label>
			<input
				type="text"
				id="ani_hp_website_cb"
				name="ani_hp_website"
				value=""
				autocomplete="off"
				tabindex="-1"
				focusable="false"
			>
		</div>

		<fieldset class="ani-form__fieldset">
			<legend class="ani-form__legend" id="ani-callback-form-heading">
				<?php esc_html_e( 'בקשת חזרה', 'ani' ); ?>
			</legend>

			<!-- שם מלא -->
			<div class="ani-form__field">
				<label class="ani-form__label" for="ani_cb_name">
					<?php esc_html_e( 'שם מלא', 'ani' ); ?>
					<span class="ani-form__required" aria-hidden="true">*</span>
				</label>
				<input
					class="ani-form__input"
					type="text"
					id="ani_cb_name"
					name="ani_cb_name"
					value=""
					required
					aria-required="true"
					autocomplete="name"
					aria-describedby="ani_cb_name_error"
					<?php echo $ani_cb_show_error ? 'aria-invalid="true"' : ''; ?>
				>
				<span
					class="ani-form__error"
					id="ani_cb_name_error"
					role="alert"
					aria-live="polite"
				>
					<?php if ( $ani_cb_show_error ) : ?>
						<?php esc_html_e( 'נא להזין שם מלא.', 'ani' ); ?>
					<?php endif; ?>
				</span>
			</div>

			<!-- טלפון -->
			<div class="ani-form__field">
				<label class="ani-form__label" for="ani_cb_phone">
					<?php esc_html_e( 'טלפון', 'ani' ); ?>
					<span class="ani-form__required" aria-hidden="true">*</span>
				</label>
				<input
					class="ani-form__input ani-form__input--ltr"
					type="tel"
					id="ani_cb_phone"
					name="ani_cb_phone"
					value=""
					required
					aria-required="true"
					autocomplete="tel"
					inputmode="tel"
					dir="ltr"
					aria-describedby="ani_cb_phone_error ani_cb_phone_hint"
					<?php echo $ani_cb_show_error ? 'aria-invalid="true"' : ''; ?>
				>
				<span class="ani-form__hint" id="ani_cb_phone_hint">
					<?php /* translators: phone hint example using <bdi> to isolate LTR digits */ ?>
					<bdi><?php esc_html_e( 'לדוגמה: 050-1234567', 'ani' ); ?></bdi>
				</span>
				<span
					class="ani-form__error"
					id="ani_cb_phone_error"
					role="alert"
					aria-live="polite"
				>
					<?php if ( $ani_cb_show_error ) : ?>
						<?php esc_html_e( 'נא להזין מספר טלפון.', 'ani' ); ?>
					<?php endif; ?>
				</span>
			</div>

			<!-- נושא / שירות -->
			<div class="ani-form__field">
				<label class="ani-form__label" for="ani_cb_service">
					<?php esc_html_e( 'נושא / שירות', 'ani' ); ?>
					<span class="ani-form__optional"><?php esc_html_e( '(אופציונלי)', 'ani' ); ?></span>
				</label>
				<select
					class="ani-form__select"
					id="ani_cb_service"
					name="ani_cb_service"
					autocomplete="off"
					aria-describedby="ani_cb_service_error"
				>
					<?php foreach ( $ani_cb_services as $val => $label ) : ?>
						<option value="<?php echo esc_attr( $val ); ?>">
							<?php echo esc_html( $label ); ?>
						</option>
					<?php endforeach; ?>
				</select>
				<span class="ani-form__error" id="ani_cb_service_error" role="alert" aria-live="polite"></span>
			</div>

			<!-- הסכמה -->
			<div class="ani-form__field ani-form__field--checkbox">
				<label class="ani-form__checkbox-label" for="ani_cb_consent">
					<input
						class="ani-form__checkbox"
						type="checkbox"
						id="ani_cb_consent"
						name="ani_cb_consent"
						value="1"
						required
						aria-required="true"
						aria-describedby="ani_cb_consent_error"
						<?php echo $ani_cb_show_error ? 'aria-invalid="true"' : ''; ?>
					>
					<span class="ani-form__checkbox-text">
						<?php
						printf(
							/* translators: 1: opening <a> tag  2: closing </a> tag */
							esc_html__( 'קראתי ואני מסכים/ה ל%1$sמדיניות הפרטיות%2$s', 'ani' ),
							'<a href="' . esc_url( $ani_cb_privacy_url ) . '" target="_blank" rel="noopener noreferrer">',
							'</a>'
						);
						?>
					</span>
				</label>
				<span
					class="ani-form__error"
					id="ani_cb_consent_error"
					role="alert"
					aria-live="polite"
				>
					<?php if ( $ani_cb_show_error ) : ?>
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
					<?php esc_html_e( 'בקשת חזרה', 'ani' ); ?>
				</button>
			</div>

		</fieldset>

	</form>

	<?php endif; // ! $ani_cb_show_success ?>

</div><!-- .ani-form-wrap -->
