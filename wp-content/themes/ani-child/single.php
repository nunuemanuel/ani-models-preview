<?php
/**
 * ANI Child Theme — single.php
 *
 * Single blog post template.
 * Layout: featured image banner (full-width, max 480px) → article with
 * back link, meta (category badge + date in mono), H1 title with blue
 * underline, draft notice (if applicable), readable body (~70ch, Heebo
 * 1.78 line-height) → CTA band → footer.
 *
 * RTL-Hebrew: logical CSS, no letter-spacing on body, LTR-isolated for
 * dates, codes, emails, numbers. Semantic <article> with ARIA.
 *
 * @package ani
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	// Categories — first one for meta display.
	$categories = get_the_category();
	$cat_name   = ! empty( $categories ) ? $categories[0]->name : '';
	$cat_link   = ! empty( $categories ) ? get_category_link( $categories[0]->term_id ) : '';

	// Date.
	$date_display  = get_the_date( 'd.m.Y' );
	$date_iso      = get_the_date( 'Y-m-d' );
	?>

<article
	id="post-<?php the_ID(); ?>"
	<?php post_class( 'ani-single-post' ); ?>
	aria-labelledby="ani-post-title-<?php the_ID(); ?>"
>

	<?php if ( has_post_thumbnail() ) : ?>
	<div class="ani-post-banner" role="img" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
		<?php
		the_post_thumbnail(
			'ani-blog-banner',
			array(
				'loading'  => 'eager',
				'fetchpriority' => 'high',
				'alt'      => esc_attr( get_the_title() ),
			)
		);
		?>
	</div><!-- .ani-post-banner -->
	<?php endif; ?>

	<div class="ani-post-inner">

		<!-- Back to blog -->
		<a class="ani-post-back" href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ?: home_url( '/blog/' ) ); ?>">
			→ <?php esc_html_e( 'חזרה לבלוג', 'ani' ); ?>
		</a>

		<!-- Meta: category + date -->
		<div class="ani-post-meta" role="group" aria-label="<?php esc_attr_e( 'מידע על הפוסט', 'ani' ); ?>">
			<?php if ( $cat_name ) : ?>
			<a class="ani-post-meta__cat" href="<?php echo esc_url( $cat_link ); ?>" rel="category">
				<?php echo esc_html( $cat_name ); ?>
			</a>
			<?php endif; ?>

			<time
				class="ani-post-meta__date"
				datetime="<?php echo esc_attr( $date_iso ); ?>"
				dir="ltr"
			>
				<?php echo esc_html( $date_display ); ?>
			</time>
		</div><!-- .ani-post-meta -->

		<!-- Post title -->
		<h1
			id="ani-post-title-<?php the_ID(); ?>"
			class="ani-post-title"
		>
			<?php the_title(); ?>
		</h1>

		<!-- Article body -->
		<div class="ani-post-content">
			<?php the_content(); ?>
		</div><!-- .ani-post-content -->

		<!-- CTA band -->
		<aside class="ani-post-cta" aria-label="<?php esc_attr_e( 'קריאה לפעולה', 'ani' ); ?>">
			<span class="ani-post-cta__eyebrow">
				<?php esc_html_e( 'מוכנים להתחיל?', 'ani' ); ?>
			</span>
			<h2 class="ani-post-cta__title">
				<?php esc_html_e( 'שלחו לנו בקשה לייצור', 'ani' ); ?>
			</h2>
			<p class="ani-post-cta__sub">
				<?php esc_html_e( 'צוות א.נ.י יחזור אליכם תוך 24 שעות עם הצעת מחיר מפורטת.', 'ani' ); ?>
			</p>
			<a
				class="ani-btn ani-btn--primary"
				href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"
			>
				<?php esc_html_e( 'צרו קשר עכשיו', 'ani' ); ?>
				<span class="ani-btn-arrow" aria-hidden="true">←</span>
			</a>
		</aside><!-- .ani-post-cta -->

	</div><!-- .ani-post-inner -->

</article><!-- .ani-single-post -->

<?php
endwhile;

get_footer();
?>
