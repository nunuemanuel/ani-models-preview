<?php
/**
 * One-off: apply finished blog content + meta + slug + featured image, then publish.
 * Run: wp eval-file wp-content/themes/ani-child/.blog-build/apply-blogs.php
 */
if ( ! defined( 'WP_CLI' ) ) {
	return;
}

$dir = __DIR__;

$cat_thumb = array(
	'composites'          => 37,
	'3d-printing'         => 36,
	'reverse-engineering' => 38,
	'sourcing-guide'      => 39,
	'cnc-machining'       => 93,
);

$files = glob( $dir . '/*.html' );
$done  = 0;

foreach ( $files as $f ) {
	$id = (int) basename( $f, '.html' );
	if ( ! $id || ! get_post( $id ) ) {
		continue;
	}

	$content = file_get_contents( $f );
	$metaf   = "$dir/$id.meta.txt";
	$slugf   = "$dir/$id.slug.txt";
	$excerpt = file_exists( $metaf ) ? trim( file_get_contents( $metaf ) ) : '';

	$update = array(
		'ID'           => $id,
		'post_content' => $content,
		'post_status'  => 'publish',
	);
	if ( '' !== $excerpt ) {
		$update['post_excerpt'] = $excerpt;
	}
	if ( file_exists( $slugf ) ) {
		$slug = trim( file_get_contents( $slugf ) );
		if ( '' !== $slug ) {
			$update['post_name'] = $slug;
		}
	}

	$res = wp_update_post( wp_slash( $update ), true );
	if ( is_wp_error( $res ) ) {
		WP_CLI::warning( "post $id: " . $res->get_error_message() );
		continue;
	}

	$cats  = wp_get_post_terms( $id, 'category', array( 'fields' => 'slugs' ) );
	$thumb = 0;
	foreach ( (array) $cats as $c ) {
		if ( isset( $cat_thumb[ $c ] ) ) {
			$thumb = $cat_thumb[ $c ];
			break;
		}
	}
	if ( $thumb && wp_get_attachment_url( $thumb ) ) {
		set_post_thumbnail( $id, $thumb );
	}

	$done++;
	WP_CLI::log( "✓ $id  slug=" . get_post_field( 'post_name', $id ) . "  thumb=$thumb  meta=" . ( $excerpt ? 'Y' : '-' ) );
}

WP_CLI::success( "Applied + published $done posts." );
