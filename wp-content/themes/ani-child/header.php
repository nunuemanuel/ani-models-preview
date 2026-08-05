<?php
/**
 * ANI Child Theme — header.php
 *
 * Sticky RTL header: sphere logo + "א.נ.י" wordmark + tagline (inline-start),
 * horizontal nav (אודות · שירותים · פרויקטים), blue "צור קשר" CTA (inline-end).
 * Hides on scroll-down, reappears on scroll-up (via nav.js + CSS translateY).
 *
 * @package ani
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?> dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="ani-skip-link screen-reader-text" href="#main">
	<?php esc_html_e( 'דלג לתוכן הראשי', 'ani' ); ?>
</a>

<header class="ani-site-header" role="banner">
	<div class="ani-header-inner">

		<!-- Brand: sphere logo + wordmark + tagline (inline-start in RTL) -->
		<a class="ani-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php esc_attr_e( 'א.נ.י מודלים ואבות טיפוס — דף הבית', 'ani' ); ?>">
			<span class="ani-logo-mark" aria-hidden="true">
				<img
					src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/logo-sphere.png' ); ?>"
					alt=""
					width="48"
					height="48"
					loading="eager"
				>
			</span>
			<span class="ani-brand__text">
				<span class="ani-brand__name">
					<?php echo esc_html__( 'א.נ.י', 'ani' ); ?>
				</span>
				<span class="ani-brand__tagline">
					<?php echo esc_html__( 'פתרונות ייצור מתקדמים', 'ani' ); ?>
				</span>
			</span>
		</a>

		<!-- Primary navigation (desktop) -->
		<nav class="ani-header-nav" role="navigation" aria-label="<?php esc_attr_e( 'ניווט ראשי', 'ani' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_class'     => 'ani-nav-list',
					'container'      => false,
					'depth'          => 1,
					'fallback_cb'    => 'ani_header_nav_fallback',
				)
			);
			?>
		</nav>

		<!-- CTA: prominent blue "צור קשר" (desktop, inline-end in RTL) -->
		<a class="ani-btn ani-btn--primary ani-btn--contact ani-header-cta" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
			<?php esc_html_e( 'צור קשר', 'ani' ); ?>
		</a>

		<!-- Hamburger toggle — mobile only (CSS). Controls the mobile drawer. -->
		<button
			class="ani-nav-toggle"
			id="ani-nav-toggle"
			type="button"
			aria-expanded="false"
			aria-controls="ani-mobile-nav"
			aria-label="<?php esc_attr_e( 'פתיחת תפריט', 'ani' ); ?>"
		>
			<span class="ani-nav-toggle__box" aria-hidden="true">
				<span class="ani-nav-toggle__bar"></span>
				<span class="ani-nav-toggle__bar"></span>
				<span class="ani-nav-toggle__bar"></span>
			</span>
		</button>

	</div><!-- .ani-header-inner -->
</header><!-- .ani-site-header -->

<!-- Mobile nav drawer + backdrop — rendered OUTSIDE the sticky header so the
     header's transform/will-change doesn't trap these position:fixed elements. -->
<div class="ani-nav-backdrop" id="ani-nav-backdrop" hidden></div>
<aside class="ani-mobile-nav" id="ani-mobile-nav" aria-label="<?php esc_attr_e( 'תפריט נייד', 'ani' ); ?>">
	<nav class="ani-mobile-nav__nav" aria-label="<?php esc_attr_e( 'ניווט נייד', 'ani' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'menu_class'     => 'ani-mobile-nav__list',
				'container'      => false,
				'depth'          => 1,
				'fallback_cb'    => 'ani_header_nav_fallback',
			)
		);
		?>
	</nav>

	<a class="ani-btn ani-btn--primary ani-mobile-nav__cta" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
		<?php esc_html_e( 'צור קשר', 'ani' ); ?>
	</a>

	<div class="ani-mobile-actions">
		<a class="ani-mobile-action ani-mobile-action--whatsapp" href="https://wa.me/972549992742" target="_blank" rel="noopener noreferrer">
			<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884"/></svg>
			<?php esc_html_e( 'WhatsApp', 'ani' ); ?>
		</a>
		<a class="ani-mobile-action ani-mobile-action--call" href="tel:+972549992742">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.39 19a19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2 4.18 2 2 0 0 1 4 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>
			<?php esc_html_e( 'התקשרו עכשיו', 'ani' ); ?>
		</a>
	</div>
</aside><!-- .ani-mobile-nav -->

<main id="main" class="ani-site-main" role="main">
<?php
/**
 * Fallback nav: shown before an admin assigns a menu to the primary location.
 */
function ani_header_nav_fallback() {
	?>
	<ul class="ani-nav-list">
		<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'אודות', 'ani' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>"><?php esc_html_e( 'שירותים', 'ani' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/projects/' ) ); ?>"><?php esc_html_e( 'פרויקטים', 'ani' ); ?></a></li>
	</ul>
	<?php
}
