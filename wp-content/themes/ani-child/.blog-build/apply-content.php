<?php
/**
 * Apply optimized content + meta (excerpt) only — leaves slug/status/thumbnail as-is.
 * Run: wp eval-file wp-content/themes/ani-child/.blog-build/apply-content.php
 */
if ( ! defined( 'WP_CLI' ) ) {
	return;
}

$dir   = __DIR__;
$ids   = array( 53, 54, 55, 57, 58, 61, 63, 65, 67, 68, 69, 71, 73, 74, 75, 76, 78, 79, 80, 81, 83, 84, 90, 91, 92 );
$done  = 0;

foreach ( $ids as $id ) {
	$hf = "$dir/$id.html";
	if ( ! file_exists( $hf ) || ! get_post( $id ) ) {
		continue;
	}
	$update  = array( 'ID' => $id, 'post_content' => file_get_contents( $hf ) );
	$mf      = "$dir/$id.meta.txt";
	if ( file_exists( $mf ) ) {
		$update['post_excerpt'] = trim( file_get_contents( $mf ) );
	}
	$res = wp_update_post( wp_slash( $update ), true );
	if ( is_wp_error( $res ) ) {
		WP_CLI::warning( "post $id: " . $res->get_error_message() );
		continue;
	}
	$done++;
}

WP_CLI::success( "Applied optimized content to $done posts." );
