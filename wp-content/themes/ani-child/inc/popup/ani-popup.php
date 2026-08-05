<?php
/**
 * ANI Lead Popup — settings page + front-end modal render.
 *
 * Settings page:  Settings > פופאפ לידים  (capability: manage_options)
 * Option array:   ani_popup_settings  (single serialized option, sanitized on save)
 * Front-end:      wp_footer hook — outputs accessible dialog when enabled and in scope.
 * Assets:         popup.css + popup.js enqueued on front-end only, only when enabled.
 *
 * The popup embeds the existing [ani_callback_form] shortcode; no new form or handler.
 * RTL-Hebrew (he_IL) default. WPCS 3.x — escape output, sanitize input, i18n 'ani'.
 *
 * @package ani
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* =========================================================================
   1. Default option values
   ========================================================================= */

/**
 * Return the default settings array for first install.
 *
 * @return array
 */
function ani_popup_defaults() {
	return array(
		'enabled'        => false,
		'trigger'        => 'time_delay',
		'delay_seconds'  => 15,
		'scroll_percent' => 50,
		'display_scope'  => 'all_pages',
		'scope_ids'      => '',
		'frequency_days' => 7,
		'heading'        => 'מעוניינים בהצעת מחיר?',
		'subtext'        => 'השאירו פרטים ונחזור אליכם בהקדם.',
	);
}

/**
 * Get merged settings (defaults + saved option).
 *
 * @return array
 */
function ani_popup_get_settings() {
	$saved = get_option( 'ani_popup_settings', array() );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}
	return array_merge( ani_popup_defaults(), $saved );
}

/* =========================================================================
   2. Settings page registration
   ========================================================================= */

/**
 * Register the Settings submenu page.
 */
function ani_popup_add_settings_page() {
	add_options_page(
		esc_html__( 'פופאפ לידים', 'ani' ),
		esc_html__( 'פופאפ לידים', 'ani' ),
		'manage_options',
		'ani-popup-settings',
		'ani_popup_render_settings_page'
	);
}
add_action( 'admin_menu', 'ani_popup_add_settings_page' );

/**
 * Register settings, section, and fields via the Settings API.
 */
function ani_popup_register_settings() {
	register_setting(
		'ani_popup_settings_group',
		'ani_popup_settings',
		array(
			'sanitize_callback' => 'ani_popup_sanitize_settings',
			'default'           => ani_popup_defaults(),
		)
	);

	add_settings_section(
		'ani_popup_main',
		'',
		'__return_false',
		'ani-popup-settings'
	);

	$fields = array(
		array( 'enabled',        esc_html__( 'הפעל פופאפ', 'ani' ),        'ani_popup_field_enabled' ),
		array( 'trigger',        esc_html__( 'טריגר', 'ani' ),             'ani_popup_field_trigger' ),
		array( 'delay_seconds',  esc_html__( 'עיכוב (שניות)', 'ani' ),     'ani_popup_field_delay' ),
		array( 'scroll_percent', esc_html__( 'אחוז גלילה', 'ani' ),        'ani_popup_field_scroll' ),
		array( 'display_scope',  esc_html__( 'היקף הצגה', 'ani' ),         'ani_popup_field_scope' ),
		array( 'scope_ids',      esc_html__( 'מזהי / slugs של עמודים', 'ani' ), 'ani_popup_field_scope_ids' ),
		array( 'frequency_days', esc_html__( 'תדירות (ימים)', 'ani' ),     'ani_popup_field_frequency' ),
		array( 'heading',        esc_html__( 'כותרת הפופאפ', 'ani' ),      'ani_popup_field_heading' ),
		array( 'subtext',        esc_html__( 'טקסט משנה', 'ani' ),         'ani_popup_field_subtext' ),
	);

	foreach ( $fields as $field ) {
		add_settings_field(
			$field[0],
			$field[1],
			$field[2],
			'ani-popup-settings',
			'ani_popup_main'
		);
	}
}
add_action( 'admin_init', 'ani_popup_register_settings' );

/* =========================================================================
   3. Sanitize callback
   ========================================================================= */

/**
 * Sanitize and validate the submitted settings array.
 *
 * @param  mixed $input Raw $_POST value passed by the Settings API.
 * @return array        Sanitized settings ready for storage.
 */
function ani_popup_sanitize_settings( $input ) {
	$defaults = ani_popup_defaults();

	if ( ! is_array( $input ) ) {
		return $defaults;
	}

	$clean = array();

	// enabled — checkbox: present = true, absent = false.
	$clean['enabled'] = ! empty( $input['enabled'] );

	// trigger — whitelist.
	$allowed_triggers = array( 'exit_intent', 'time_delay', 'scroll_depth' );
	$clean['trigger'] = isset( $input['trigger'] ) && in_array( $input['trigger'], $allowed_triggers, true )
		? $input['trigger']
		: $defaults['trigger'];

	// delay_seconds — positive integer.
	$clean['delay_seconds'] = isset( $input['delay_seconds'] )
		? max( 1, absint( $input['delay_seconds'] ) )
		: $defaults['delay_seconds'];

	// scroll_percent — 1-100.
	$clean['scroll_percent'] = isset( $input['scroll_percent'] )
		? min( 100, max( 1, absint( $input['scroll_percent'] ) ) )
		: $defaults['scroll_percent'];

	// display_scope — whitelist.
	$allowed_scopes = array( 'all_pages', 'include', 'exclude' );
	$clean['display_scope'] = isset( $input['display_scope'] ) && in_array( $input['display_scope'], $allowed_scopes, true )
		? $input['display_scope']
		: $defaults['display_scope'];

	// scope_ids — free text: comma-separated page IDs or slugs.
	$clean['scope_ids'] = isset( $input['scope_ids'] )
		? sanitize_textarea_field( wp_unslash( $input['scope_ids'] ) )
		: '';

	// frequency_days — positive integer.
	$clean['frequency_days'] = isset( $input['frequency_days'] )
		? max( 0, absint( $input['frequency_days'] ) )
		: $defaults['frequency_days'];

	// heading — plain text (no HTML).
	$clean['heading'] = isset( $input['heading'] )
		? sanitize_text_field( wp_unslash( $input['heading'] ) )
		: $defaults['heading'];

	// subtext — plain text.
	$clean['subtext'] = isset( $input['subtext'] )
		? sanitize_textarea_field( wp_unslash( $input['subtext'] ) )
		: $defaults['subtext'];

	return $clean;
}

/* =========================================================================
   4. Field render callbacks
   ========================================================================= */

/**
 * Helper: get current setting value with default fallback.
 *
 * @param  string $key Setting key.
 * @return mixed
 */
function ani_popup_setting( $key ) {
	$settings = ani_popup_get_settings();
	return $settings[ $key ] ?? ani_popup_defaults()[ $key ] ?? '';
}

/** Render: enabled checkbox. */
function ani_popup_field_enabled() {
	$val = ani_popup_setting( 'enabled' );
	?>
	<label>
		<input
			type="checkbox"
			name="ani_popup_settings[enabled]"
			value="1"
			<?php checked( $val, true ); ?>
		/>
		<?php esc_html_e( 'הצג את הפופאפ בצד הציבורי של האתר', 'ani' ); ?>
	</label>
	<?php
}

/** Render: trigger select. */
function ani_popup_field_trigger() {
	$val = ani_popup_setting( 'trigger' );
	$options = array(
		'exit_intent'  => esc_html__( 'כוונת יציאה (עכבר לכיוון הדפדפן)', 'ani' ),
		'time_delay'   => esc_html__( 'עיכוב זמן', 'ani' ),
		'scroll_depth' => esc_html__( 'עומק גלילה', 'ani' ),
	);
	?>
	<select name="ani_popup_settings[trigger]">
		<?php foreach ( $options as $key => $label ) : ?>
			<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $val, $key ); ?>>
				<?php echo esc_html( $label ); ?>
			</option>
		<?php endforeach; ?>
	</select>
	<?php
}

/** Render: delay_seconds input. */
function ani_popup_field_delay() {
	$val = absint( ani_popup_setting( 'delay_seconds' ) );
	?>
	<input
		type="number"
		name="ani_popup_settings[delay_seconds]"
		value="<?php echo esc_attr( $val ); ?>"
		min="1"
		max="3600"
		style="width:80px"
	/>
	<p class="description"><?php esc_html_e( 'רלוונטי רק כאשר הטריגר הוא "עיכוב זמן".', 'ani' ); ?></p>
	<?php
}

/** Render: scroll_percent input. */
function ani_popup_field_scroll() {
	$val = absint( ani_popup_setting( 'scroll_percent' ) );
	?>
	<input
		type="number"
		name="ani_popup_settings[scroll_percent]"
		value="<?php echo esc_attr( $val ); ?>"
		min="1"
		max="100"
		style="width:80px"
	/>
	<span>%</span>
	<p class="description"><?php esc_html_e( 'רלוונטי רק כאשר הטריגר הוא "עומק גלילה".', 'ani' ); ?></p>
	<?php
}

/** Render: display_scope select. */
function ani_popup_field_scope() {
	$val = ani_popup_setting( 'display_scope' );
	$options = array(
		'all_pages' => esc_html__( 'כל הדפים', 'ani' ),
		'include'   => esc_html__( 'רק הדפים הבאים', 'ani' ),
		'exclude'   => esc_html__( 'כל הדפים חוץ מ…', 'ani' ),
	);
	?>
	<select name="ani_popup_settings[display_scope]">
		<?php foreach ( $options as $key => $label ) : ?>
			<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $val, $key ); ?>>
				<?php echo esc_html( $label ); ?>
			</option>
		<?php endforeach; ?>
	</select>
	<?php
}

/** Render: scope_ids textarea. */
function ani_popup_field_scope_ids() {
	$val = ani_popup_setting( 'scope_ids' );
	?>
	<textarea
		name="ani_popup_settings[scope_ids]"
		rows="3"
		cols="40"
		placeholder="<?php esc_attr_e( 'לדוגמה: about, 12, services', 'ani' ); ?>"
	><?php echo esc_textarea( $val ); ?></textarea>
	<p class="description"><?php esc_html_e( 'מזהי דף (מספרים) או slugs, מופרדים בפסיק. רלוונטי רק ב"רק הדפים הבאים" / "חוץ מ…".', 'ani' ); ?></p>
	<?php
}

/** Render: frequency_days input. */
function ani_popup_field_frequency() {
	$val = absint( ani_popup_setting( 'frequency_days' ) );
	?>
	<input
		type="number"
		name="ani_popup_settings[frequency_days]"
		value="<?php echo esc_attr( $val ); ?>"
		min="0"
		max="365"
		style="width:80px"
	/>
	<p class="description"><?php esc_html_e( 'הפופאפ לא יוצג שוב למבקר למשך N ימים לאחר סגירה או שליחה. 0 = הצג בכל ביקור.', 'ani' ); ?></p>
	<?php
}

/** Render: heading text input. */
function ani_popup_field_heading() {
	$val = ani_popup_setting( 'heading' );
	?>
	<input
		type="text"
		name="ani_popup_settings[heading]"
		value="<?php echo esc_attr( $val ); ?>"
		class="regular-text"
	/>
	<p class="description"><?php esc_html_e( 'כותרת הפופאפ (טקסט ללא HTML).', 'ani' ); ?></p>
	<?php
}

/** Render: subtext textarea. */
function ani_popup_field_subtext() {
	$val = ani_popup_setting( 'subtext' );
	?>
	<textarea
		name="ani_popup_settings[subtext]"
		rows="2"
		cols="50"
	><?php echo esc_textarea( $val ); ?></textarea>
	<p class="description"><?php esc_html_e( 'שורת משנה מתחת לכותרת (טקסט ללא HTML).', 'ani' ); ?></p>
	<?php
}

/* =========================================================================
   5. Settings page render
   ========================================================================= */

/**
 * Render the settings page HTML.
 */
function ani_popup_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'אין לך הרשאה לגשת לדף זה.', 'ani' ) );
	}
	?>
	<div class="wrap" dir="rtl">
		<h1><?php esc_html_e( 'פופאפ לידים', 'ani' ); ?></h1>
		<form method="post" action="options.php">
			<?php
			settings_fields( 'ani_popup_settings_group' );
			do_settings_sections( 'ani-popup-settings' );
			submit_button( esc_html__( 'שמור הגדרות', 'ani' ) );
			?>
		</form>
	</div>
	<?php
}

/* =========================================================================
   6. Scope check helper
   ========================================================================= */

/**
 * Determine whether the popup should appear on the current page.
 *
 * Always suppressed on: contact page (template page-contact.php or slug 'contact').
 *
 * @param  array $settings Merged settings array.
 * @return bool
 */
function ani_popup_passes_scope( $settings ) {
	// Never on the contact/RFQ page — the form is already there.
	if ( is_page_template( 'page-contact.php' ) || is_page( 'contact' ) ) {
		return false;
	}

	$scope = $settings['display_scope'];

	if ( 'all_pages' === $scope ) {
		return true;
	}

	// Parse the scope_ids list into IDs and slugs.
	$raw_ids = $settings['scope_ids'];
	if ( '' === trim( $raw_ids ) ) {
		// No IDs specified: include mode = show nowhere; exclude mode = show everywhere.
		return ( 'exclude' === $scope );
	}

	$items = array_map( 'trim', explode( ',', $raw_ids ) );

	$current_id   = get_the_ID();
	$current_slug = get_post_field( 'post_name', $current_id );

	$match = false;
	foreach ( $items as $item ) {
		if ( '' === $item ) {
			continue;
		}
		if ( ctype_digit( $item ) ) {
			// Numeric — treat as page ID.
			if ( (int) $item === $current_id ) {
				$match = true;
				break;
			}
		} else {
			// Slug.
			if ( $item === $current_slug || is_page( $item ) ) {
				$match = true;
				break;
			}
		}
	}

	if ( 'include' === $scope ) {
		return $match;
	}

	// exclude.
	return ! $match;
}

/* =========================================================================
   7. Front-end modal render (wp_footer)
   ========================================================================= */

/**
 * Output the lead popup modal in the footer when conditions are met.
 */
function ani_popup_render_footer() {
	$settings = ani_popup_get_settings();

	// Exit early if disabled.
	if ( empty( $settings['enabled'] ) ) {
		return;
	}

	// Exit early if not on a singular page (archives, 404, etc. get no popup).
	if ( ! is_singular() && ! is_front_page() ) {
		return;
	}

	// Scope check.
	if ( ! ani_popup_passes_scope( $settings ) ) {
		return;
	}

	// Pass config to JS via a localized object (printed inline before popup.js).
	$js_config = array(
		'trigger'        => esc_js( $settings['trigger'] ),
		'delaySeconds'   => absint( $settings['delay_seconds'] ),
		'scrollPercent'  => absint( $settings['scroll_percent'] ),
		'frequencyDays'  => absint( $settings['frequency_days'] ),
	);

	// Output config as inline JSON before the popup markup.
	echo '<script id="ani-popup-config">var ANI_POPUP = ' . wp_json_encode( $js_config, JSON_UNESCAPED_UNICODE ) . ';</script>' . "\n";
	?>
	<div
		id="ani-popup-overlay"
		class="ani-popup-overlay"
		role="presentation"
		aria-hidden="true"
	>
		<div
			id="ani-popup-dialog"
			class="ani-popup-dialog"
			role="dialog"
			aria-modal="true"
			aria-labelledby="ani-popup-heading"
			tabindex="-1"
		>
			<button
				type="button"
				class="ani-popup__close"
				id="ani-popup-close"
				aria-label="<?php esc_attr_e( 'סגור חלון', 'ani' ); ?>"
			>
				<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
					<path d="M18 6 6 18M6 6l12 12"/>
				</svg>
			</button>

			<?php if ( ! empty( $settings['heading'] ) ) : ?>
				<h2 id="ani-popup-heading" class="ani-popup__heading">
					<?php echo esc_html( $settings['heading'] ); ?>
				</h2>
			<?php endif; ?>

			<?php if ( ! empty( $settings['subtext'] ) ) : ?>
				<p class="ani-popup__subtext">
					<?php echo esc_html( $settings['subtext'] ); ?>
				</p>
			<?php endif; ?>

			<div class="ani-popup__form">
				<?php echo do_shortcode( '[ani_callback_form]' ); ?>
			</div>
		</div>
	</div>
	<?php
}
add_action( 'wp_footer', 'ani_popup_render_footer', 20 );

/* =========================================================================
   8. Front-end asset enqueue
   ========================================================================= */

/**
 * Enqueue popup.css and popup.js on the front end, only when popup is enabled.
 */
function ani_popup_enqueue_assets() {
	if ( is_admin() ) {
		return;
	}

	$settings = ani_popup_get_settings();
	if ( empty( $settings['enabled'] ) ) {
		return;
	}

	$theme_dir = get_stylesheet_directory();
	$theme_uri = get_stylesheet_directory_uri();

	wp_enqueue_style(
		'ani-popup',
		$theme_uri . '/assets/css/popup.css',
		array( 'ani-tokens', 'ani-components', 'ani-forms' ),
		file_exists( $theme_dir . '/assets/css/popup.css' )
			? filemtime( $theme_dir . '/assets/css/popup.css' )
			: wp_get_theme()->get( 'Version' )
	);

	wp_enqueue_script(
		'ani-popup',
		$theme_uri . '/assets/js/popup.js',
		array(),
		file_exists( $theme_dir . '/assets/js/popup.js' )
			? filemtime( $theme_dir . '/assets/js/popup.js' )
			: wp_get_theme()->get( 'Version' ),
		true // footer
	);
}
add_action( 'wp_enqueue_scripts', 'ani_popup_enqueue_assets', 15 );
