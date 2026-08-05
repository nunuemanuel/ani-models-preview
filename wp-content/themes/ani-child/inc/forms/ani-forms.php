<?php
/**
 * ANI Forms — core: CPT, shortcode registration, admin-post handlers,
 * mail delivery, ani_lead logging, rate-limiting.
 *
 * Two forms:
 *   [ani_callback_form]  — callback request (name + phone + topic + consent)
 *   [ani_rfq_form]       — full RFQ (name + email + phone + service + details + CAD upload + consent)
 *
 * Delivery: wp_mail to ani_lead_email option (default info@ani-models.co.il)
 *           + CPT ani_lead for persistence.
 * Spam:     honeypot hidden field + transient-based rate-limit (IP-keyed).
 *
 * RTL-Hebrew (he_IL) is the default direction; LTR isolation applied to
 * email / phone / URL fields.  WPCS 3.x: escape output, wp_unslash+sanitize
 * input, wp_verify_nonce, text-domain 'ani'.
 *
 * @package ani
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* =========================================================================
   1. ANI_LEAD custom post type
   ========================================================================= */

/**
 * Register the private ani_lead CPT used to persist every form submission.
 */
function ani_register_lead_cpt() {
	$labels = array(
		'name'               => esc_html__( 'לידים', 'ani' ),
		'singular_name'      => esc_html__( 'ליד', 'ani' ),
		'menu_name'          => esc_html__( 'לידים', 'ani' ),
		'all_items'          => esc_html__( 'כל הלידים', 'ani' ),
		'view_item'          => esc_html__( 'הצג ליד', 'ani' ),
		'search_items'       => esc_html__( 'חפש לידים', 'ani' ),
		'not_found'          => esc_html__( 'לא נמצאו לידים.', 'ani' ),
		'not_found_in_trash' => esc_html__( 'לא נמצאו לידים בפח.', 'ani' ),
	);

	register_post_type(
		'ani_lead',
		array(
			'labels'              => $labels,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_icon'           => 'dashicons-email-alt',
			'menu_position'       => 25,
			'capability_type'     => 'post',
			'capabilities'        => array(
				'create_posts' => 'do_not_allow', // no manual creation from admin
			),
			'map_meta_cap'        => true,
			'supports'            => array( 'title' ),
			'has_archive'         => false,
			'rewrite'             => false,
			'query_var'           => false,
			'show_in_rest'        => false,
		)
	);
}
add_action( 'init', 'ani_register_lead_cpt' );

/* =========================================================================
   2. Admin columns for ani_lead
   ========================================================================= */

/**
 * Define custom admin columns for the ani_lead list table.
 *
 * @param  array $columns Default columns.
 * @return array
 */
function ani_lead_columns( $columns ) {
	return array(
		'cb'             => $columns['cb'],
		'title'          => esc_html__( 'נושא', 'ani' ),
		'ani_lead_type'  => esc_html__( 'סוג', 'ani' ),
		'ani_lead_name'  => esc_html__( 'שם', 'ani' ),
		'ani_lead_phone' => esc_html__( 'טלפון', 'ani' ),
		'ani_lead_email' => esc_html__( 'אימייל', 'ani' ),
		'date'           => esc_html__( 'תאריך', 'ani' ),
	);
}
add_filter( 'manage_ani_lead_posts_columns', 'ani_lead_columns' );

/**
 * Render values for custom admin columns.
 *
 * @param string $column  Column key.
 * @param int    $post_id Post ID.
 */
function ani_lead_column_content( $column, $post_id ) {
	$map = array(
		'ani_lead_type'  => '_ani_lead_type',
		'ani_lead_name'  => '_ani_lead_name',
		'ani_lead_phone' => '_ani_lead_phone',
		'ani_lead_email' => '_ani_lead_email',
	);

	if ( isset( $map[ $column ] ) ) {
		$val = get_post_meta( $post_id, $map[ $column ], true );
		// Phone + email rendered LTR-isolated; all escaped on output.
		if ( 'ani_lead_phone' === $column || 'ani_lead_email' === $column ) {
			echo '<span dir="ltr">' . esc_html( $val ) . '</span>';
		} else {
			echo esc_html( $val );
		}
	}
}
add_action( 'manage_ani_lead_posts_custom_column', 'ani_lead_column_content', 10, 2 );

/* =========================================================================
   3. Shortcode registration
   ========================================================================= */

/**
 * Shortcode: [ani_callback_form]
 *
 * @return string HTML output (buffered).
 */
function ani_callback_form_shortcode() {
	ob_start();
	require __DIR__ . '/ani-callback-form.php';
	return ob_get_clean();
}
add_shortcode( 'ani_callback_form', 'ani_callback_form_shortcode' );

/**
 * Shortcode: [ani_rfq_form]
 *
 * @return string HTML output (buffered).
 */
function ani_rfq_form_shortcode() {
	ob_start();
	require __DIR__ . '/ani-rfq-form.php';
	return ob_get_clean();
}
add_shortcode( 'ani_rfq_form', 'ani_rfq_form_shortcode' );

/* =========================================================================
   4. Asset enqueue — forms CSS + JS
   ========================================================================= */

/**
 * Enqueue forms.css and forms.js on every front-end page (shortcodes may
 * appear anywhere, so always-enqueue is the simpler safe choice).
 * forms.js is tiny and deferred; forms.css is lightweight.
 */
function ani_enqueue_forms_assets() {
	if ( is_admin() ) {
		return;
	}

	$theme_dir = get_stylesheet_directory();
	$theme_uri = get_stylesheet_directory_uri();

	wp_enqueue_style(
		'ani-forms',
		$theme_uri . '/assets/css/forms.css',
		array( 'ani-tokens', 'ani-components' ),
		file_exists( $theme_dir . '/assets/css/forms.css' )
			? filemtime( $theme_dir . '/assets/css/forms.css' )
			: wp_get_theme()->get( 'Version' )
	);

	wp_enqueue_script(
		'ani-forms',
		$theme_uri . '/assets/js/forms.js',
		array(),
		file_exists( $theme_dir . '/assets/js/forms.js' )
			? filemtime( $theme_dir . '/assets/js/forms.js' )
			: wp_get_theme()->get( 'Version' ),
		true // footer
	);
}
add_action( 'wp_enqueue_scripts', 'ani_enqueue_forms_assets', 15 );

/* =========================================================================
   5. Shared helpers
   ========================================================================= */

/**
 * Allowed service options for validation whitelist.
 *
 * @return array<string,string> value => display label
 */
function ani_service_options() {
	return array(
		''              => __( '— בחרו שירות —', 'ani' ),
		'composites'    => __( 'חומרים מרוכבים', 'ani' ),
		'cnc'           => __( 'עיבוד שבבי CNC', 'ani' ),
		'3d-printing'   => __( 'הדפסות תלת-ממד', 'ani' ),
		'scanning'      => __( 'סריקה והנדסה לאחור', 'ani' ),
		'integration'   => __( 'הרכבות ואינטגרציה', 'ani' ),
		'other'         => __( 'אחר', 'ani' ),
	);
}

/**
 * Allowed MIME types for CAD file uploads (mirrors ani_upload_mimes).
 *
 * @return array<string,string> extension => MIME type
 */
function ani_cad_allowed_mimes() {
	return array(
		'step'   => 'application/octet-stream',
		'stp'    => 'application/octet-stream',
		'stl'    => 'application/octet-stream',
		'iges'   => 'application/octet-stream',
		'igs'    => 'application/octet-stream',
		'dxf'    => 'application/octet-stream',
		'sldprt' => 'application/octet-stream',
		'pdf'    => 'application/pdf',
	);
}

/**
 * Rate-limit a form action per visitor IP using a transient.
 * Allows $limit submissions within $window_seconds.
 *
 * @param  string $action          Unique action key (e.g. 'callback' or 'rfq').
 * @param  int    $limit           Max submissions allowed.
 * @param  int    $window_seconds  Window length in seconds.
 * @return bool   True if the request is within the limit (allowed); false if throttled.
 */
function ani_rate_limit_check( $action, $limit = 3, $window_seconds = 600 ) {
	$ip  = isset( $_SERVER['HTTP_CF_CONNECTING_IP'] )
		? sanitize_text_field( wp_unslash( $_SERVER['HTTP_CF_CONNECTING_IP'] ) )
		: ( isset( $_SERVER['REMOTE_ADDR'] )
			? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) )
			: 'unknown' );

	// Hash the IP — transient keys are visible in DB; we store no raw PII.
	$key   = 'ani_rl_' . $action . '_' . md5( $ip );
	$count = (int) get_transient( $key );

	if ( $count >= $limit ) {
		return false; // throttled
	}

	set_transient( $key, $count + 1, $window_seconds );
	return true;
}

/**
 * Store a lead as an ani_lead CPT post with meta fields.
 * Returns the new post ID on success, WP_Error on failure.
 *
 * @param  string $type   'callback' or 'rfq'.
 * @param  array  $fields Sanitized field values.
 * @param  array  $files  Array of uploaded file URLs (may be empty).
 * @return int|WP_Error
 */
function ani_save_lead( $type, $fields, $files = array() ) {
	$title = sprintf(
		/* translators: 1: lead type label 2: submitter name */
		'%1$s — %2$s',
		'rfq' === $type
			? esc_html__( 'הצעת מחיר', 'ani' )
			: esc_html__( 'בקשת חזרה', 'ani' ),
		$fields['name']
	);

	$post_id = wp_insert_post(
		array(
			'post_type'   => 'ani_lead',
			'post_status' => 'publish',
			'post_title'  => sanitize_text_field( $title ),
		),
		true
	);

	if ( is_wp_error( $post_id ) ) {
		return $post_id;
	}

	update_post_meta( $post_id, '_ani_lead_type', sanitize_key( $type ) );
	update_post_meta( $post_id, '_ani_lead_name', sanitize_text_field( $fields['name'] ) );
	update_post_meta( $post_id, '_ani_lead_phone', sanitize_text_field( $fields['phone'] ?? '' ) );
	update_post_meta( $post_id, '_ani_lead_email', sanitize_email( $fields['email'] ?? '' ) );
	update_post_meta( $post_id, '_ani_lead_service', sanitize_key( $fields['service'] ?? '' ) );
	update_post_meta( $post_id, '_ani_lead_details', sanitize_textarea_field( $fields['details'] ?? '' ) );

	if ( ! empty( $files ) ) {
		// Store file URLs as a JSON blob — no PII, just attachment paths.
		update_post_meta( $post_id, '_ani_lead_files', wp_json_encode( $files ) );
	}

	return $post_id;
}

/**
 * Send the lead notification email and an optional autoresponder.
 *
 * @param  string $type    'callback' or 'rfq'.
 * @param  array  $fields  Sanitized fields.
 * @param  array  $files   File URLs (RFQ only).
 * @return bool   Whether wp_mail succeeded for the notification.
 */
function ani_send_lead_email( $type, $fields, $files = array() ) {
	$to      = sanitize_email( (string) get_option( 'ani_lead_email', 'info@ani-models.co.il' ) );
	$site    = get_bloginfo( 'name' );
	$domain  = wp_parse_url( home_url(), PHP_URL_HOST );

	if ( 'rfq' === $type ) {
		/* translators: site name */
		$subject = sprintf( __( '[%s] בקשת הצעת מחיר חדשה', 'ani' ), $site );
	} else {
		/* translators: site name */
		$subject = sprintf( __( '[%s] בקשת חזרה חדשה', 'ani' ), $site );
	}

	// Build plain-text body — no PII in server logs, only in this email.
	$body  = "=== " . ( 'rfq' === $type ? __( 'בקשת הצעת מחיר', 'ani' ) : __( 'בקשת חזרה', 'ani' ) ) . " ===\n\n";
	$body .= __( 'שם:', 'ani' ) . ' ' . $fields['name'] . "\n";

	if ( ! empty( $fields['phone'] ) ) {
		$body .= __( 'טלפון:', 'ani' ) . ' ' . $fields['phone'] . "\n";
	}
	if ( ! empty( $fields['email'] ) ) {
		$body .= __( 'אימייל:', 'ani' ) . ' ' . $fields['email'] . "\n";
	}

	$service_options = ani_service_options();
	$service_key     = $fields['service'] ?? '';
	if ( $service_key && isset( $service_options[ $service_key ] ) ) {
		$body .= __( 'שירות:', 'ani' ) . ' ' . $service_options[ $service_key ] . "\n";
	}

	if ( ! empty( $fields['details'] ) ) {
		$body .= "\n" . __( 'פרטי הפרויקט:', 'ani' ) . "\n" . $fields['details'] . "\n";
	}

	if ( ! empty( $files ) ) {
		$body .= "\n" . __( 'קבצים מצורפים:', 'ani' ) . "\n";
		foreach ( $files as $url ) {
			$body .= '  - ' . $url . "\n";
		}
	}

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'From: ' . $site . ' <noreply@' . $domain . '>',
	);

	// Reply-To the submitter if they provided an email.
	$reply_email = sanitize_email( $fields['email'] ?? '' );
	if ( $reply_email ) {
		$headers[] = 'Reply-To: ' . $fields['name'] . ' <' . $reply_email . '>';
	}

	$sent = wp_mail( $to, $subject, $body, $headers );

	// Autoresponder to the submitter (RFQ only, when email was provided).
	if ( 'rfq' === $type && $reply_email ) {
		$auto_subject = sprintf(
			/* translators: site name */
			__( 'קיבלנו את בקשתך — %s', 'ani' ),
			$site
		);

		$auto_body  = sprintf(
			/* translators: submitter name */
			__( 'שלום %s,', 'ani' ),
			$fields['name']
		) . "\n\n";
		$auto_body .= __(
			'קיבלנו את בקשת הצעת המחיר שלך ונחזור אליך בהקדם, תוך 24 שעות עסקיות.',
			'ani'
		) . "\n\n";
		$auto_body .= '— ' . $site . "\n";

		$auto_headers = array(
			'Content-Type: text/plain; charset=UTF-8',
			'From: ' . $site . ' <noreply@' . $domain . '>',
		);

		wp_mail( $reply_email, $auto_subject, $auto_body, $auto_headers );
	}

	return $sent;
}

/**
 * Build the redirect URL with a success or error flag.
 *
 * @param  string $base  The URL to redirect to.
 * @param  string $state 'success' or 'error'.
 * @param  string $form  'callback' or 'rfq'.
 * @return string
 */
function ani_form_redirect_url( $base, $state, $form ) {
	return add_query_arg(
		array(
			'ani_form'   => rawurlencode( $form ),
			'ani_status' => rawurlencode( $state ),
		),
		$base
	);
}

/* =========================================================================
   6. admin-post handler — Callback form
   ========================================================================= */

/**
 * Handle callback form POST (both logged-in and guest users).
 */
function ani_handle_callback_form() {
	// 1. Nonce.
	if ( ! isset( $_POST['ani_callback_nonce'] )
		|| ! wp_verify_nonce(
			sanitize_text_field( wp_unslash( $_POST['ani_callback_nonce'] ) ),
			'ani_callback_submit'
		)
	) {
		wp_die( esc_html__( 'בקשה לא חוקית.', 'ani' ), 403 );
	}

	// 2. Honeypot — must be empty.
	if ( ! empty( $_POST['ani_hp_website'] ) ) {
		// Silently redirect as success to confuse bots.
		$referer = esc_url_raw( wp_get_referer() ?: home_url() );
		wp_safe_redirect( ani_form_redirect_url( $referer, 'success', 'callback' ) );
		exit;
	}

	// 3. Rate limit — 3 per 10 minutes per IP.
	if ( ! ani_rate_limit_check( 'callback' ) ) {
		$referer = esc_url_raw( wp_get_referer() ?: home_url() );
		wp_safe_redirect( ani_form_redirect_url( $referer, 'ratelimit', 'callback' ) );
		exit;
	}

	// 4. Sanitize.
	$name    = sanitize_text_field( wp_unslash( $_POST['ani_cb_name'] ?? '' ) );
	$phone   = sanitize_text_field( wp_unslash( $_POST['ani_cb_phone'] ?? '' ) );
	$service = sanitize_key( wp_unslash( $_POST['ani_cb_service'] ?? '' ) );
	$consent = ! empty( $_POST['ani_cb_consent'] );

	// 5. Validate.
	$errors = array();
	if ( '' === $name ) {
		$errors['name'] = __( 'נא להזין שם מלא.', 'ani' );
	}
	if ( '' === $phone ) {
		$errors['phone'] = __( 'נא להזין מספר טלפון.', 'ani' );
	}
	if ( ! $consent ) {
		$errors['consent'] = __( 'יש לאשר את תנאי הפרטיות.', 'ani' );
	}
	// Validate service if provided.
	if ( $service && ! array_key_exists( $service, ani_service_options() ) ) {
		$service = '';
	}

	if ( $errors ) {
		// Redirect back with error flag — field re-population happens via session
		// or GET params. For simplicity, redirect back and the form shows errors.
		$referer = esc_url_raw( wp_get_referer() ?: home_url() );
		wp_safe_redirect( ani_form_redirect_url( $referer, 'error', 'callback' ) );
		exit;
	}

	// 6. Save lead CPT.
	$fields = compact( 'name', 'phone', 'service' );
	ani_save_lead( 'callback', $fields );

	// 7. Send email.
	ani_send_lead_email( 'callback', $fields );

	// 8. Redirect with success flag.
	$referer = esc_url_raw( wp_get_referer() ?: home_url() );
	wp_safe_redirect( ani_form_redirect_url( $referer, 'success', 'callback' ) );
	exit;
}
add_action( 'admin_post_nopriv_ani_callback_form', 'ani_handle_callback_form' );
add_action( 'admin_post_ani_callback_form', 'ani_handle_callback_form' );

/* =========================================================================
   7. admin-post handler — RFQ form
   ========================================================================= */

/**
 * Handle RFQ form POST (both logged-in and guest users).
 */
function ani_handle_rfq_form() {
	// 1. Nonce.
	if ( ! isset( $_POST['ani_rfq_nonce'] )
		|| ! wp_verify_nonce(
			sanitize_text_field( wp_unslash( $_POST['ani_rfq_nonce'] ) ),
			'ani_rfq_submit'
		)
	) {
		wp_die( esc_html__( 'בקשה לא חוקית.', 'ani' ), 403 );
	}

	// 2. Honeypot.
	if ( ! empty( $_POST['ani_hp_website'] ) ) {
		$referer = esc_url_raw( wp_get_referer() ?: home_url() );
		wp_safe_redirect( ani_form_redirect_url( $referer, 'success', 'rfq' ) );
		exit;
	}

	// 3. Rate limit — 3 per 10 minutes per IP.
	if ( ! ani_rate_limit_check( 'rfq' ) ) {
		$referer = esc_url_raw( wp_get_referer() ?: home_url() );
		wp_safe_redirect( ani_form_redirect_url( $referer, 'ratelimit', 'rfq' ) );
		exit;
	}

	// 4. Sanitize text fields.
	$name    = sanitize_text_field( wp_unslash( $_POST['ani_rfq_name'] ?? '' ) );
	$email   = sanitize_email( wp_unslash( $_POST['ani_rfq_email'] ?? '' ) );
	$phone   = sanitize_text_field( wp_unslash( $_POST['ani_rfq_phone'] ?? '' ) );
	$service = sanitize_key( wp_unslash( $_POST['ani_rfq_service'] ?? '' ) );
	$details = sanitize_textarea_field( wp_unslash( $_POST['ani_rfq_details'] ?? '' ) );
	$consent = ! empty( $_POST['ani_rfq_consent'] );

	// 5. Validate.
	$errors = array();
	if ( '' === $name ) {
		$errors['name'] = __( 'נא להזין שם מלא.', 'ani' );
	}
	if ( '' === $email || ! is_email( $email ) ) {
		$errors['email'] = __( 'נא להזין כתובת אימייל תקינה.', 'ani' );
	}
	if ( '' === $phone ) {
		$errors['phone'] = __( 'נא להזין מספר טלפון.', 'ani' );
	}
	if ( ! $consent ) {
		$errors['consent'] = __( 'יש לאשר את תנאי הפרטיות.', 'ani' );
	}
	// Validate service if provided.
	if ( $service && ! array_key_exists( $service, ani_service_options() ) ) {
		$service = '';
	}

	if ( $errors ) {
		$referer = esc_url_raw( wp_get_referer() ?: home_url() );
		wp_safe_redirect( ani_form_redirect_url( $referer, 'error', 'rfq' ) );
		exit;
	}

	// 6. Handle file uploads (up to 3 files).
	$uploaded_urls = array();
	$upload_errors = array();

	if ( ! empty( $_FILES['ani_rfq_files']['name'][0] ) ) {
		// Temporarily override allowed mimes for this upload.
		add_filter( 'upload_mimes', 'ani_upload_mimes' );
		add_filter( 'wp_check_filetype_and_ext', 'ani_check_filetype_and_ext', 10, 5 );

		$allowed_mimes = ani_cad_allowed_mimes();
		$max_bytes     = 25 * 1024 * 1024; // 25 MB per file.
		$max_files     = 3;

		$file_count = min( count( $_FILES['ani_rfq_files']['name'] ), $max_files );

		for ( $i = 0; $i < $file_count; $i++ ) {
			// Skip empty slots.
			if ( empty( $_FILES['ani_rfq_files']['name'][ $i ] )
				|| UPLOAD_ERR_NO_FILE === $_FILES['ani_rfq_files']['error'][ $i ]
			) {
				continue;
			}

			// File-size guard before wp_handle_upload.
			if ( $_FILES['ani_rfq_files']['size'][ $i ] > $max_bytes ) {
				/* translators: filename */
				$upload_errors[] = sprintf( __( 'הקובץ "%s" גדול מ-25MB.', 'ani' ), sanitize_file_name( $_FILES['ani_rfq_files']['name'][ $i ] ) );
				continue;
			}

			// Server-side extension check against our allowlist.
			$ext = strtolower( pathinfo( $_FILES['ani_rfq_files']['name'][ $i ], PATHINFO_EXTENSION ) );
			if ( ! isset( $allowed_mimes[ $ext ] ) ) {
				/* translators: filename */
				$upload_errors[] = sprintf( __( 'סוג הקובץ "%s" אינו נתמך.', 'ani' ), sanitize_file_name( $_FILES['ani_rfq_files']['name'][ $i ] ) );
				continue;
			}

			// Slice the $_FILES superglobal into a single-file array.
			$file_slice = array(
				'name'     => $_FILES['ani_rfq_files']['name'][ $i ],
				'type'     => $_FILES['ani_rfq_files']['type'][ $i ],
				'tmp_name' => $_FILES['ani_rfq_files']['tmp_name'][ $i ],
				'error'    => $_FILES['ani_rfq_files']['error'][ $i ],
				'size'     => $_FILES['ani_rfq_files']['size'][ $i ],
			);

			// Use wp_handle_upload — applies WP's own security + virus-scan hooks.
			$result = wp_handle_upload(
				$file_slice,
				array(
					'test_form' => false,
					'mimes'     => $allowed_mimes,
				)
			);

			if ( isset( $result['error'] ) ) {
				$upload_errors[] = esc_html( $result['error'] );
			} elseif ( isset( $result['url'] ) ) {
				$uploaded_urls[] = esc_url_raw( $result['url'] );
			}
		}
	}

	// 7. Save CPT lead.
	$fields = compact( 'name', 'email', 'phone', 'service', 'details' );
	ani_save_lead( 'rfq', $fields, $uploaded_urls );

	// 8. Send emails.
	ani_send_lead_email( 'rfq', $fields, $uploaded_urls );

	// 9. Redirect with success.
	$referer = esc_url_raw( wp_get_referer() ?: home_url() );
	wp_safe_redirect( ani_form_redirect_url( $referer, 'success', 'rfq' ) );
	exit;
}
add_action( 'admin_post_nopriv_ani_rfq_form', 'ani_handle_rfq_form' );
add_action( 'admin_post_ani_rfq_form', 'ani_handle_rfq_form' );
