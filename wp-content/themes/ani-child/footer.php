<?php
/**
 * ANI Child Theme — footer.php
 *
 * Multi-column coded footer:
 *   (a) Brand lockup + tagline + blurb
 *   (b) Quick links
 *   (c) Services list
 *   (d) Contact info
 * Bottom bar: copyright + legal links.
 * RTL-Hebrew safe: logical CSS only.
 *
 * @package ani
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Resolve legal page URLs safely — fall back to '#' if the slug doesn't exist yet.
$privacy_url     = get_permalink( get_page_by_path( 'privacy' ) )     ?: home_url( '/privacy/' );
$access_url      = get_permalink( get_page_by_path( 'accessibility' ) ) ?: home_url( '/accessibility/' );
$cookies_url     = get_permalink( get_page_by_path( 'cookies' ) )      ?: home_url( '/cookies/' );
$terms_url       = get_permalink( get_page_by_path( 'terms' ) )        ?: home_url( '/terms/' );

// Contact — confirmed client number +972 54-999-2742.
// WhatsApp link — wa.me carries encoded text; esc_attr() is correct here per php.md.
$phone_display   = '054-999-2742';
$phone_tel       = 'tel:+972549992742';
$whatsapp_url    = 'https://wa.me/972549992742?text=' . rawurlencode( __( 'שלום, הגעתי דרך האתר ואשמח לקבל הצעת מחיר.', 'ani' ) );
?>
</main><!-- #main .ani-site-main -->

<footer class="ani-site-footer ani-footer-full" role="contentinfo">
	<div class="ani-footer-columns">

		<!-- (a) Brand column -->
		<div class="ani-footer-col ani-footer-col--brand">
			<a class="ani-brand ani-brand--footer" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php esc_attr_e( 'א.נ.י — דף הבית', 'ani' ); ?>">
				<span class="ani-logo-mark" aria-hidden="true">
					<img
						src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/logo-sphere.png' ); ?>"
						alt=""
						width="40"
						height="40"
						loading="lazy"
					>
				</span>
				<span class="ani-brand__text">
					<span class="ani-brand__name"><?php echo esc_html__( 'א.נ.י', 'ani' ); ?></span>
					<span class="ani-brand__tagline"><?php echo esc_html__( 'פתרונות ייצור מתקדמים', 'ani' ); ?></span>
				</span>
			</a>
			<p class="ani-footer-blurb">
				<?php esc_html_e( 'פיתוח, תכנון וייצור מוצרים מתקדמים לתעשיות הביטחון, התעופה, הרחפנים, הרפואה והאלקטרוניקה.', 'ani' ); ?>
			</p>
		</div><!-- .ani-footer-col--brand -->

		<!-- (b) Quick links column -->
		<div class="ani-footer-col">
			<h3 class="ani-footer-col__heading"><?php esc_html_e( 'ניווט מהיר', 'ani' ); ?></h3>
			<ul class="ani-footer-links">
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'בית', 'ani' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'אודות', 'ani' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>"><?php esc_html_e( 'שירותים', 'ani' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/projects/' ) ); ?>"><?php esc_html_e( 'פרויקטים', 'ani' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'צור קשר', 'ani' ); ?></a></li>
			</ul>
		</div><!-- .ani-footer-col -->

		<!-- (c) Services column -->
		<div class="ani-footer-col">
			<h3 class="ani-footer-col__heading"><?php esc_html_e( 'שירותים', 'ani' ); ?></h3>
			<ul class="ani-footer-links">
				<li><a href="<?php echo esc_url( home_url( '/composites/' ) ); ?>"><?php esc_html_e( 'חומרים מרוכבים', 'ani' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/cnc/' ) ); ?>"><?php esc_html_e( 'עיבוד שבבי CNC', 'ani' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/3d-printing/' ) ); ?>"><?php esc_html_e( 'הדפסות תלת-ממד', 'ani' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/scanning/' ) ); ?>"><?php esc_html_e( 'סריקה והנדסה לאחור', 'ani' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/integration/' ) ); ?>"><?php esc_html_e( 'הרכבה ואינטגרציה', 'ani' ); ?></a></li>
			</ul>
		</div><!-- .ani-footer-col -->

		<!-- (d) Contact column -->
		<div class="ani-footer-col">
			<h3 class="ani-footer-col__heading"><?php esc_html_e( 'יצירת קשר', 'ani' ); ?></h3>
			<ul class="ani-footer-contact">
				<li>
					<a href="mailto:info@ani-models.co.il" dir="ltr">info@ani-models.co.il</a>
				</li>
				<li>
					<a href="<?php echo esc_attr( $phone_tel ); ?>" dir="ltr"><?php echo esc_html( $phone_display ); ?></a>
				</li>
				<li>
					<?php esc_html_e( 'רחובות, ישראל', 'ani' ); ?>
				</li>
				<li>
					<a href="<?php echo esc_attr( $whatsapp_url ); ?>" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'שלח הודעת WhatsApp', 'ani' ); ?>
					</a>
				</li>
			</ul>
		</div><!-- .ani-footer-col -->

	</div><!-- .ani-footer-columns -->

	<!-- Bottom bar: copyright + legal links -->
	<div class="ani-footer-bottom">
		<div class="ani-footer-bottom__inner">
			<p class="ani-footer-copy">
				<?php
				printf(
					/* translators: 1: current year */
					esc_html__( '© %s א.נ.י מודלים ואבי טיפוס. כל הזכויות שמורות.', 'ani' ),
					esc_html( gmdate( 'Y' ) )
				);
				?>
			</p>
			<nav class="ani-footer-legal" aria-label="<?php esc_attr_e( 'קישורים משפטיים', 'ani' ); ?>">
				<a href="<?php echo esc_url( $privacy_url ); ?>"><?php esc_html_e( 'מדיניות פרטיות', 'ani' ); ?></a>
				<a href="<?php echo esc_url( $access_url ); ?>"><?php esc_html_e( 'הצהרת נגישות', 'ani' ); ?></a>
				<a href="<?php echo esc_url( $cookies_url ); ?>"><?php esc_html_e( 'מדיניות עוגיות', 'ani' ); ?></a>
				<a href="<?php echo esc_url( $terms_url ); ?>"><?php esc_html_e( 'תקנון', 'ani' ); ?></a>
			</nav>
		</div>
	</div><!-- .ani-footer-bottom -->

</footer><!-- .ani-site-footer -->

<?php
/*
 * Site-wide floating contact cluster (WhatsApp + click-to-call).
 * The homepage already ships an Elementor float cluster, so render this on every
 * OTHER page (and on all breakpoints incl. mobile). Physical left/bottom so it
 * sits opposite the RTL bottom-right language switcher.
 */
if ( ! is_front_page() ) :
	?>
	<div class="ani-float-contact" role="complementary" aria-label="<?php esc_attr_e( 'יצירת קשר מהיר', 'ani' ); ?>">
		<a class="ani-float-contact__btn ani-float-contact__btn--whatsapp" href="<?php echo esc_attr( $whatsapp_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'שלחו הודעת WhatsApp', 'ani' ); ?>">
			<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884"/></svg>
			<span class="ani-float-contact__label"><?php esc_html_e( 'WhatsApp', 'ani' ); ?></span>
		</a>
		<a class="ani-float-contact__btn ani-float-contact__btn--call" href="<?php echo esc_attr( $phone_tel ); ?>" aria-label="<?php esc_attr_e( 'התקשרו אלינו', 'ani' ); ?>">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.39 19a19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2 4.18 2 2 0 0 1 4 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>
			<span class="ani-float-contact__label"><?php esc_html_e( 'חיוג', 'ani' ); ?></span>
		</a>
	</div>
	<?php
endif;

wp_footer();
?>
</body>
</html>
<?php
// Fallback footer nav is no longer needed; keeping function stub for back-compat
// if a menu is registered to 'footer' location by a future admin.
function ani_footer_nav_fallback() {
	// No-op — footer now uses coded columns rather than a registered menu.
}
