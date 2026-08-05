<?php
/**
 * One-off: fix internal links in all published posts.
 * - wrong capability path /cnc-machining/ -> real page /cnc/
 * - blog-to-blog links that used assumed slugs -> real slugs
 * - ugly date-based /YYYY/MM/DD/ blog links -> clean /blog/ (permalink is now /blog/%postname%/)
 */
if ( ! defined( 'WP_CLI' ) ) {
	return;
}

$map = array(
	// capability page
	'href="/cnc-machining/"'             => 'href="/cnc/"',
	// blog slug mismatches (wrong -> real)
	'/blog/reverse-engineering/'         => '/blog/reverse-engineering-scan-to-cad/',
	'/blog/recreate-legacy-part/'        => '/blog/reverse-engineer-legacy-part/',
	'/blog/cmm-inspection/'              => '/blog/cmm-dimensional-inspection/',
	'/blog/3d-printing-vs-cnc/'          => '/blog/3d-printing-vs-cnc-machining/',
	'/blog/3d-printing-materials/'       => '/blog/3d-printing-materials-guide/',
	'/blog/dfam-design-for-3d-printing/' => '/blog/design-for-3d-printing/',
	'/blog/cnc-tolerances/'              => '/blog/cnc-machining-tolerances/',
	// date-based blog links -> clean /blog/ prefix
	'/2026/06/22/'                       => '/blog/',
	'/2026/06/20/'                       => '/blog/',
);

$posts   = get_posts( array( 'post_type' => 'post', 'post_status' => 'publish', 'numberposts' => -1, 'fields' => 'ids' ) );
$changed = 0;

foreach ( $posts as $id ) {
	$content = get_post_field( 'post_content', $id );
	$new     = strtr( $content, $map );
	if ( $new !== $content ) {
		wp_update_post( wp_slash( array( 'ID' => $id, 'post_content' => $new ) ) );
		$changed++;
	}
}

WP_CLI::success( "Link fix applied to $changed posts." );
