<?php
/**
 * ANI Child Theme — blog JSON-LD schema.
 *
 * Emits BlogPosting + BreadcrumbList structured data in the document head on
 * single posts. No SEO plugin is active in this build (Rank Math is NOT
 * installed), so there is no schema to duplicate; if Rank Math is added later,
 * disable ONE of the two schema sources to avoid duplicate Article markup.
 *
 * RTL/Hebrew safe: wp_json_encode with JSON_UNESCAPED_UNICODE keeps Hebrew
 * readable; JSON_UNESCAPED_SLASHES keeps URLs clean.
 *
 * @package ani
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Output BlogPosting + BreadcrumbList JSON-LD for single posts.
 */
function ani_blog_jsonld() {
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	$post_id   = get_the_ID();
	$permalink = get_permalink( $post_id );
	$site_name = get_bloginfo( 'name' );
	$home      = home_url( '/' );

	// Organization publisher (logo: theme logo.png if present).
	$logo_path = get_stylesheet_directory() . '/assets/logo.png';
	$publisher = array(
		'@type' => 'Organization',
		'name'  => $site_name,
		'url'   => $home,
	);
	if ( file_exists( $logo_path ) ) {
		$publisher['logo'] = array(
			'@type' => 'ImageObject',
			'url'   => get_stylesheet_directory_uri() . '/assets/logo.png',
		);
	}

	// BlogPosting.
	$posting = array(
		'@context'         => 'https://schema.org',
		'@type'            => 'BlogPosting',
		'mainEntityOfPage' => array(
			'@type' => 'WebPage',
			'@id'   => $permalink,
		),
		'headline'         => wp_strip_all_tags( get_the_title() ),
		'datePublished'    => get_the_date( 'c', $post_id ),
		'dateModified'     => get_the_modified_date( 'c', $post_id ),
		'author'           => array(
			'@type' => 'Person',
			'name'  => get_the_author_meta( 'display_name', (int) get_post_field( 'post_author', $post_id ) ),
		),
		'publisher'        => $publisher,
		'inLanguage'       => get_bloginfo( 'language' ),
	);

	$excerpt = wp_strip_all_tags( get_the_excerpt( $post_id ) );
	if ( $excerpt ) {
		$posting['description'] = $excerpt;
	}

	if ( has_post_thumbnail( $post_id ) ) {
		$img = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'ani-blog-banner' );
		if ( $img ) {
			$posting['image'] = array(
				'@type'  => 'ImageObject',
				'url'    => $img[0],
				'width'  => $img[1],
				'height' => $img[2],
			);
		}
	}

	// BreadcrumbList: Home → Blog → Category → Post.
	$items = array(
		array(
			'@type'    => 'ListItem',
			'position' => 1,
			'name'     => __( 'בית', 'ani' ),
			'item'     => $home,
		),
	);
	$pos        = 2;
	$posts_page = get_option( 'page_for_posts' );
	if ( $posts_page ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $pos,
			'name'     => get_the_title( $posts_page ),
			'item'     => get_permalink( $posts_page ),
		);
		++$pos;
	}
	$cats = get_the_category( $post_id );
	if ( ! empty( $cats ) ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $pos,
			'name'     => $cats[0]->name,
			'item'     => get_category_link( $cats[0]->term_id ),
		);
		++$pos;
	}
	$items[] = array(
		'@type'    => 'ListItem',
		'position' => $pos,
		'name'     => wp_strip_all_tags( get_the_title() ),
		'item'     => $permalink,
	);

	$breadcrumb = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $items,
	);

	$flags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
	echo "\n<script type=\"application/ld+json\">" . wp_json_encode( $posting, $flags ) . "</script>\n";
	echo '<script type="application/ld+json">' . wp_json_encode( $breadcrumb, $flags ) . "</script>\n";
}
add_action( 'wp_head', 'ani_blog_jsonld', 20 );
