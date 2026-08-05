<?php
/**
 * ANI Child Theme — home.php
 *
 * WordPress blog posts index template.
 * Used when Reading Settings → "Posts page" is set to "בלוג".
 *
 * Layout (top → bottom):
 *   1. Full-bleed hero (real image background + flat dark scrim, NO gradients).
 *   2. Two-column body — FEATURED column (sticky posts) on the RIGHT in RTL,
 *      MAIN column (controls bar + row list + JS pagination) on the LEFT.
 *   3. Full-bleed CTA band (reuses the shared .cta-band markup).
 *
 * 100% NATIVE: sticky posts drive the featured column; categories drive the
 * filter tabs; the main loop (posts_per_page=-1 via pre_get_posts) renders
 * every non-sticky post and JS paginates/filters client-side.
 *
 * RTL-Hebrew: logical CSS, no letter-spacing on Hebrew, LTR-isolated dates.
 * Featured/row images use the registered `ani-blog-card` size, loading="lazy".
 *
 * @package ani
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// Native published-post count for the hero detail line.
$ani_published = (int) wp_count_posts()->publish;

// Sticky post IDs drive the featured column AND are excluded from the main row
// list so they never render twice. Set in Posts → Edit → "Stick to the top".
$sticky_ids = get_option( 'sticky_posts' );
$sticky_ids = is_array( $sticky_ids ) ? array_map( 'intval', $sticky_ids ) : array();
?>

<div class="ani-blog-index">

	<!-- ============================================================ HERO -->
	<header class="ani-blog-hero" role="banner">
		<div
			class="ani-blog-hero__bg"
			style="background-image:url('<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/hero/hero-scanning.webp' ); ?>');"
			aria-hidden="true"
		></div>
		<div class="ani-blog-hero__scrim" aria-hidden="true"></div>

		<div class="ani-blog-hero__inner ani-container">
			<h1 class="ani-blog-hero__title">
				<?php esc_html_e( 'בלוג', 'ani' ); ?>
			</h1>
			<p class="ani-blog-hero__subtitle">
				<?php esc_html_e( 'תובנות מקצועיות על ייצור, חומרים, הדפסת תלת-ממד והנדסה לאחור', 'ani' ); ?>
			</p>
			<p class="ani-blog-hero__detail">
				<span class="ani-blog-hero__count" dir="ltr">
					<?php echo esc_html( number_format_i18n( $ani_published ) ); ?>
				</span>
				<?php
				/* translators: %s: number of published articles (rendered in the adjacent span). */
				echo ' ' . esc_html( _n( 'מאמר', 'מאמרים', $ani_published, 'ani' ) );
				?>
				<span class="ani-blog-hero__sep" aria-hidden="true">·</span>
				<?php esc_html_e( 'עדכון שוטף', 'ani' ); ?>
			</p>
		</div>
	</header><!-- .ani-blog-hero -->

	<div class="ani-blog-body ani-container">

		<?php
		// --------------------------------------------------------------
		// FEATURED COLUMN (first grid item → lands on the RIGHT in RTL).
		// --------------------------------------------------------------
		if ( ! empty( $sticky_ids ) ) :
			$ani_featured = new WP_Query(
				array(
					'post_type'           => 'post',
					'post__in'            => $sticky_ids,
					'orderby'             => 'post__in',
					'ignore_sticky_posts' => 1,
					'posts_per_page'      => 5,
					'no_found_rows'       => true,
				)
			);

			if ( $ani_featured->have_posts() ) :
				?>
		<aside class="ani-blog-featured" aria-labelledby="ani-featured-title">
			<h2 class="ani-blog-featured__title" id="ani-featured-title">
				<?php esc_html_e( 'מומלצים', 'ani' ); ?>
			</h2>

			<ol class="ani-blog-featured__list" role="list">
				<?php
				while ( $ani_featured->have_posts() ) :
					$ani_featured->the_post();

					$f_categories = get_the_category();
					$f_cat_name   = ! empty( $f_categories ) ? $f_categories[0]->name : '';
					$f_cat_link   = ! empty( $f_categories ) ? get_category_link( $f_categories[0]->term_id ) : '';
					?>
				<li class="ani-feat-card" id="featured-post-<?php the_ID(); ?>">

					<?php if ( has_post_thumbnail() ) : ?>
					<a
						class="ani-feat-card__thumb"
						href="<?php the_permalink(); ?>"
						tabindex="-1"
						aria-hidden="true"
					>
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

					<div class="ani-feat-card__body">
						<?php if ( $f_cat_name ) : ?>
						<a
							class="ani-feat-card__cat"
							href="<?php echo esc_url( $f_cat_link ); ?>"
							rel="category"
						>
							<?php echo esc_html( $f_cat_name ); ?>
						</a>
						<?php endif; ?>

						<h3 class="ani-feat-card__title">
							<a href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						</h3>
					</div><!-- .ani-feat-card__body -->

				</li><!-- .ani-feat-card -->
				<?php endwhile; ?>
			</ol><!-- .ani-blog-featured__list -->
		</aside><!-- .ani-blog-featured -->
				<?php
			endif;
			wp_reset_postdata();
		endif;
		?>

		<?php
		// --------------------------------------------------------------
		// MAIN COLUMN (controls bar + row list + pagination). On the LEFT.
		// --------------------------------------------------------------
		?>
		<main class="ani-blog-main" id="main-content">

			<?php if ( have_posts() ) : ?>

				<?php
				// Category filter tabs — native categories, default one excluded.
				$ani_cats = get_categories(
					array(
						'hide_empty' => true,
						'exclude'    => array( (int) get_option( 'default_category' ) ),
					)
				);
				// Belt-and-suspenders: also drop the 'uncategorized' slug if present.
				$ani_cats = array_filter(
					$ani_cats,
					static function ( $term ) {
						return 'uncategorized' !== $term->slug;
					}
				);
				?>

				<div class="ani-blog-controls">

					<?php if ( ! empty( $ani_cats ) ) : ?>
					<div
						class="ani-blog-tabs"
						role="group"
						aria-label="<?php esc_attr_e( 'סינון מאמרים לפי קטגוריה', 'ani' ); ?>"
					>
						<button
							type="button"
							class="ani-blog-tab is-active"
							data-cat-filter="all"
							aria-pressed="true"
						>
							<?php esc_html_e( 'הכל', 'ani' ); ?>
						</button>
						<?php foreach ( $ani_cats as $ani_cat ) : ?>
						<button
							type="button"
							class="ani-blog-tab"
							data-cat-filter="<?php echo esc_attr( $ani_cat->slug ); ?>"
							aria-pressed="false"
						>
							<?php echo esc_html( $ani_cat->name ); ?>
						</button>
						<?php endforeach; ?>
					</div><!-- .ani-blog-tabs -->
					<?php endif; ?>

					<div class="ani-blog-controls__row">

						<div class="ani-blog-search">
							<label class="ani-blog-search__label" for="ani-blog-search-input">
								<?php esc_html_e( 'חיפוש מאמרים', 'ani' ); ?>
							</label>
							<input
								type="search"
								id="ani-blog-search-input"
								class="ani-blog-search__input"
								placeholder="<?php esc_attr_e( 'חיפוש לפי כותרת או תוכן…', 'ani' ); ?>"
								autocomplete="off"
								data-blog-search
							>
						</div>

						<div class="ani-blog-perpage">
							<label class="ani-blog-perpage__label" for="ani-blog-perpage-select">
								<?php esc_html_e( 'הצג:', 'ani' ); ?>
							</label>
							<select
								id="ani-blog-perpage-select"
								class="ani-blog-perpage__select"
								data-blog-perpage
							>
								<option value="10" selected>10</option>
								<option value="20">20</option>
								<option value="50">50</option>
							</select>
						</div>

					</div><!-- .ani-blog-controls__row -->

					<p class="ani-blog-showing" aria-live="polite">
						<?php esc_html_e( 'מציג', 'ani' ); ?>
						<span class="ani-blog-showing__num" data-count dir="ltr">0</span>
						<?php
						/* translators: shown after the live count, e.g. "מציג 12 מאמרים". */
						esc_html_e( 'מאמרים', 'ani' );
						?>
					</p>

				</div><!-- .ani-blog-controls -->

				<p class="ani-blog-noresults" data-blog-noresults hidden>
					<?php esc_html_e( 'לא נמצאו מאמרים', 'ani' ); ?>
				</p>

				<ol class="ani-blog-rows" role="list" data-blog-grid>

					<?php
					while ( have_posts() ) :
						the_post();

						// Skip sticky posts — they already appear in the featured column.
						if ( in_array( (int) get_the_ID(), $sticky_ids, true ) ) {
							continue;
						}

						$categories = get_the_category();
						$cat_name   = ! empty( $categories ) ? $categories[0]->name : '';
						$cat_link   = ! empty( $categories ) ? get_category_link( $categories[0]->term_id ) : '';

						// Slug list for the JS category filter (data-cat).
						$cat_slugs = wp_list_pluck( $categories, 'slug' );
						$cat_attr  = implode( ' ', array_map( 'sanitize_html_class', $cat_slugs ) );

						$date_formatted = get_the_date( 'd.m.Y' );

						// Excerpt — reused for display + the search haystack.
						$excerpt = get_the_excerpt();
						if ( ! $excerpt ) {
							$excerpt = wp_trim_words( get_the_content(), 26, '…' );
						}
						$search_haystack = mb_strtolower( wp_strip_all_tags( get_the_title() . ' ' . $excerpt ) );
						?>

					<li
						class="ani-blog-row"
						id="post-<?php the_ID(); ?>"
						data-cat="<?php echo esc_attr( $cat_attr ); ?>"
						data-search="<?php echo esc_attr( $search_haystack ); ?>"
					>

						<?php if ( has_post_thumbnail() ) : ?>
						<a
							class="ani-blog-row__thumb"
							href="<?php the_permalink(); ?>"
							tabindex="-1"
							aria-hidden="true"
						>
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
							<a
								class="ani-blog-row__cat"
								href="<?php echo esc_url( $cat_link ); ?>"
								rel="category"
							>
								<?php echo esc_html( $cat_name ); ?>
							</a>
							<?php endif; ?>

							<h2 class="ani-blog-row__title">
								<a href="<?php the_permalink(); ?>">
									<?php the_title(); ?>
								</a>
							</h2>

							<p class="ani-blog-row__excerpt">
								<?php echo esc_html( $excerpt ); ?>
							</p>

							<time
								class="ani-blog-row__date"
								datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"
								dir="ltr"
							>
								<?php echo esc_html( $date_formatted ); ?>
							</time>

						</div><!-- .ani-blog-row__body -->

					</li><!-- .ani-blog-row -->

					<?php endwhile; ?>

				</ol><!-- .ani-blog-rows -->

				<nav
					class="ani-blog-pagination"
					aria-label="<?php esc_attr_e( 'ניווט בין עמודי המאמרים', 'ani' ); ?>"
					data-blog-pagination
					hidden
				></nav>

			<?php else : ?>

				<p class="ani-blog-empty">
					<?php esc_html_e( 'אין פוסטים להצגה כרגע. חזרו בקרוב.', 'ani' ); ?>
				</p>

			<?php endif; ?>

		</main><!-- .ani-blog-main -->

	</div><!-- .ani-blog-body -->

	<!-- ============================================================ CTA BAND -->
	<section class="cta-band ani-blog-cta" aria-labelledby="ani-blog-cta-title">
		<div class="cta-band__inner">
			<p class="cta-band__eyebrow ani-blog-cta__eyebrow">
				<?php esc_html_e( 'מוכנים להתחיל?', 'ani' ); ?>
			</p>
			<h2 class="cta-band__title section-title" id="ani-blog-cta-title">
				<?php esc_html_e( 'יש לכם חלק? נחזיר לכם הצעה.', 'ani' ); ?>
			</h2>
			<p class="cta-band__sub">
				<?php esc_html_e( 'שלחו שרטוט, קובץ או רק תיאור — ונחזור אליכם עם הצעת מחיר ולוח זמנים.', 'ani' ); ?>
			</p>
			<div class="cta-band__actions">
				<a class="ani-btn ani-btn--primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
					<?php esc_html_e( 'בקשת הצעת מחיר', 'ani' ); ?>
					<svg class="ani-btn-arrow" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
						<line x1="14" y1="9" x2="4" y2="9"/>
						<polyline points="9 14 4 9 9 4"/>
					</svg>
				</a>
			</div><!-- .cta-band__actions -->
		</div><!-- .cta-band__inner -->
	</section><!-- .ani-blog-cta -->

</div><!-- .ani-blog-index -->

<?php get_footer(); ?>
