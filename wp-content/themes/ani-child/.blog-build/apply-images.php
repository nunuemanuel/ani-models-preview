<?php
/**
 * Assign a varied, topic-relevant REAL part photo as each post's featured image.
 * Imports each unique photo into the media library once, then sets the thumbnail.
 * Run: wp eval-file wp-content/themes/ani-child/.blog-build/apply-images.php
 */
if ( ! defined( 'WP_CLI' ) ) {
	return;
}

require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

$base = '/var/www/html/wp-content/themes/ani-child/assets/portfolio/';

$map = array(
	53 => '3dprint-parts-array-grey.webp',
	54 => 'carbon-fiber-layup-hand.webp',
	55 => 'cnc-composite-bracket-multibore.webp',
	57 => '3dprint-bracket-green.webp',
	58 => 'composite-fuselage-blue.webp',
	61 => 'cnc-structural-bracket-pair.webp',
	63 => 'carbon-fiber-weave-macro.webp',
	65 => 'cnc-blue-channels-extrusion.webp',
	67 => 'composite-aero-shell-grey.webp',
	68 => 'integration-enclosure-white.webp',
	69 => '3dprint-bracket-green.webp',
	71 => 'integration-panel-black.webp',
	73 => 'composite-carbon-aramid-hand.webp',
	74 => '3dprint-parts-array-grey.webp',
	75 => 'moldbase-cavity-array-black.webp',
	76 => 'composite-enclosure-white.webp',
	78 => 'scan-structured-light-turntable.webp',
	79 => 'cnc-aluminum-bracket-lightweighted.webp',
	80 => 'scan-rig-camera-tripod.webp',
	81 => 'composite-wing-shells-teal.webp',
	83 => 'cnc-flange-boltcircle-macro.webp',
	84 => 'scan-structured-light-aircraft.webp',
	90 => 'cnc-structural-bracket-pair.webp',
	91 => 'stainless-vessel-lid.webp',
	92 => 'stainless-tray-machined.webp',
);

$cache = array();
function ani_import( $src ) {
	if ( ! file_exists( $src ) ) {
		return 0;
	}
	$up = wp_upload_bits( basename( $src ), null, file_get_contents( $src ) );
	if ( ! empty( $up['error'] ) ) {
		return 0;
	}
	$type = wp_check_filetype( $up['file'] );
	$id   = wp_insert_attachment(
		array(
			'post_mime_type' => $type['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $up['file'] ) ),
			'post_status'    => 'inherit',
		),
		$up['file']
	);
	wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $up['file'] ) );
	return $id;
}

$done = 0;
foreach ( $map as $pid => $file ) {
	if ( ! isset( $cache[ $file ] ) ) {
		$cache[ $file ] = ani_import( $base . $file );
	}
	$att = $cache[ $file ];
	if ( $att && get_post( $pid ) ) {
		set_post_thumbnail( $pid, $att );
		$done++;
	}
}

WP_CLI::success( "Assigned real-photo featured images to $done posts." );
