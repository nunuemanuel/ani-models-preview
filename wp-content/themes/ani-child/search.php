<?php
/* ~ mano ~ */
/**
 * ANI Child Theme — search.php
 *
 * Search results template. Reuses the blog index hero + `.ani-blog-row` cards
 * so results are styled like the rest of the site (not the bare parent theme).
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

global $wp_query;
$ani_search_q     = get_search_query();
$ani_search_found = (int) $wp_query->found_posts;
?>

<div class="ani-blog-index ani-archive ani-search">

	<header class="ani-blog-hero ani-archive-hero" role="banner">
		<div
			class="ani-blog-hero__bg"
			style="background-image:url('<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/hero/hero-scanning.webp' ); ?>');"
			aria-hidden="true"
		></div>
		<div class="ani-blog-hero__scrim" aria-hidden="true"></div>

		<div class="ani-blog-hero__inner ani-container">
			<p class="ani-blog-hero__eyebrow">
				<?php esc_html_e( 'תוצאות חיפוש', 'ani' ); ?>
			</p>
			<h1 class="ani-blog-hero__title">
				&ldquo;<?php echo esc_html( $ani_search_q ); ?>&rdquo;
			</h1>
			<p class="ani-blog-hero__subtitle">
				<span dir="ltr"><?php echo esc_html( number_format_i18n( $ani_search_found ) ); ?></span>
				<?php echo esc_html( _n( 'תוצאה', 'תוצאות', $ani_search_found, 'ani' ) ); ?>
			</p>
		</div>
	</header>

	<div class="ani-blog-body ani-archive-body ani-container">
		<main class="ani-blog-main" id="main-content">

			<?php if ( have_posts() ) : ?>

				<ol class="ani-blog-rows" role="list">
					<?php
					while ( have_posts() ) :
						the_post();

						$categories = get_the_category();
						$cat_name   = ! empty( $categories ) ? $categories[0]->name : '';
						$cat_link   = ! empty( $categories ) ? get_category_link( $categories[0]->term_id ) : '';

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
								<?php echo esc_html( get_the_date( 'd.m.Y' ) ); ?>
							</time>
						</div>

					</li>
					<?php endwhile; ?>
				</ol>

				<?php
				the_posts_pagination(
					array(
						'mid_size'           => 1,
						'prev_text'          => '‹',
						'next_text'          => '›',
						'screen_reader_text' => __( 'ניווט בין עמודי התוצאות', 'ani' ),
						'class'              => 'ani-archive-pagination',
					)
				);
				?>

			<?php else : ?>

				<p class="ani-blog-empty">
					<?php esc_html_e( 'לא נמצאו תוצאות. נסו מילות חיפוש אחרות.', 'ani' ); ?>
				</p>
				<p class="ani-archive-backlink">
					<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">
						→ <?php esc_html_e( 'חזרה לבלוג', 'ani' ); ?>
					</a>
				</p>

			<?php endif; ?>

		</main>
	</div>

</div><!-- .ani-blog-index -->

<?php get_footer(); ?>
