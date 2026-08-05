<?php
/* ~ mano ~ */
/**
 * ANI Child Theme — archive.php
 *
 * Generic archive template — category, tag, date and author archives.
 * Reuses the blog index hero + `.ani-blog-row` card list so category pages
 * match the main blog instead of falling through to the bare parent theme
 * (which rendered unstyled, maroon-link pages).
 *
 * RTL-Hebrew: logical CSS, LTR-isolated dates. Native pagination.
 *
 * @package ani
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$ani_archive_title = single_term_title( '', false );
if ( ! $ani_archive_title ) {
	$ani_archive_title = get_the_archive_title();
}
$ani_archive_desc = term_description();
?>

<div class="ani-blog-index ani-archive">

	<!-- ============================================================ HERO -->
	<header class="ani-blog-hero ani-archive-hero" role="banner">
		<div
			class="ani-blog-hero__bg"
			style="background-image:url('<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/hero/hero-scanning.webp' ); ?>');"
			aria-hidden="true"
		></div>
		<div class="ani-blog-hero__scrim" aria-hidden="true"></div>

		<div class="ani-blog-hero__inner ani-container">
			<p class="ani-blog-hero__eyebrow">
				<?php esc_html_e( 'בלוג', 'ani' ); ?>
			</p>
			<h1 class="ani-blog-hero__title">
				<?php echo esc_html( $ani_archive_title ); ?>
			</h1>
			<?php if ( $ani_archive_desc ) : ?>
			<p class="ani-blog-hero__subtitle">
				<?php echo esc_html( wp_strip_all_tags( $ani_archive_desc ) ); ?>
			</p>
			<?php endif; ?>
		</div>
	</header><!-- .ani-blog-hero -->

	<div class="ani-blog-body ani-archive-body ani-container">
		<main class="ani-blog-main" id="main-content">

			<?php if ( have_posts() ) : ?>

				<p class="ani-archive-backlink">
					<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">
						→ <?php esc_html_e( 'כל המאמרים', 'ani' ); ?>
					</a>
				</p>

				<ol class="ani-blog-rows" role="list">
					<?php
					while ( have_posts() ) :
						the_post();

						$categories = get_the_category();
						$cat_name   = ! empty( $categories ) ? $categories[0]->name : '';
						$cat_link   = ! empty( $categories ) ? get_category_link( $categories[0]->term_id ) : '';

						$date_formatted = get_the_date( 'd.m.Y' );

						$excerpt = get_the_excerpt();
						if ( ! $excerpt ) {
							$excerpt = wp_trim_words( get_the_content(), 26, '…' );
						}
						?>
					<li class="ani-blog-row" id="post-<?php the_ID(); ?>">

						<?php if ( has_post_thumbnail() ) : ?>
						<a class="ani-blog-row__thumb" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
							<?php
							the_post_thumbnail(
								'ani-blog-card',
								array(
									'loading' => 'lazy',
									'alt'     => esc_attr( get_the_title() ),
								)
							);
							?>
						</a>
						<?php endif; ?>

						<div class="ani-blog-row__body">
							<?php if ( $cat_name ) : ?>
							<a class="ani-blog-row__cat" href="<?php echo esc_url( $cat_link ); ?>" rel="category">
								<?php echo esc_html( $cat_name ); ?>
							</a>
							<?php endif; ?>

							<h2 class="ani-blog-row__title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>

							<p class="ani-blog-row__excerpt"><?php echo esc_html( $excerpt ); ?></p>

							<time class="ani-blog-row__date" datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>" dir="ltr">
								<?php echo esc_html( $date_formatted ); ?>
							</time>
						</div><!-- .ani-blog-row__body -->

					</li><!-- .ani-blog-row -->
					<?php endwhile; ?>
				</ol><!-- .ani-blog-rows -->

				<?php
				the_posts_pagination(
					array(
						'mid_size'           => 1,
						'prev_text'          => '‹',
						'next_text'          => '›',
						'screen_reader_text' => __( 'ניווט בין עמודי המאמרים', 'ani' ),
						'class'              => 'ani-archive-pagination',
					)
				);
				?>

			<?php else : ?>

				<p class="ani-blog-empty">
					<?php esc_html_e( 'אין מאמרים בקטגוריה זו עדיין. חזרו בקרוב.', 'ani' ); ?>
				</p>

			<?php endif; ?>

		</main><!-- .ani-blog-main -->
	</div><!-- .ani-blog-body -->

	<!-- ============================================================ CTA BAND -->
	<section class="cta-band ani-blog-cta" aria-labelledby="ani-archive-cta-title">
		<div class="cta-band__inner">
			<p class="cta-band__eyebrow ani-blog-cta__eyebrow">
				<?php esc_html_e( 'מוכנים להתחיל?', 'ani' ); ?>
			</p>
			<h2 class="cta-band__title section-title" id="ani-archive-cta-title">
				<?php esc_html_e( 'יש לכם חלק? נחזיר לכם הצעה.', 'ani' ); ?>
			</h2>
			<p class="cta-band__sub">
				<?php esc_html_e( 'שלחו שרטוט, קובץ או רק תיאור — ונחזור אליכם עם הצעת מחיר ולוח זמנים.', 'ani' ); ?>
			</p>
			<div class="cta-band__actions">
				<a class="ani-btn ani-btn--primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
					<?php esc_html_e( 'דברו איתנו', 'ani' ); ?>
				</a>
			</div>
		</div>
	</section><!-- .ani-blog-cta -->

</div><!-- .ani-blog-index -->

<?php get_footer(); ?>
