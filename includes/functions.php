<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Gets the gallery markup.
 *
 * @since 0.1.0
 *
 * @param array $args The gallery args.
 *
 * @return string
 */
function mai_get_gallery( $args ) {
	$gallery = new Mai_Gallery( $args );
	return $gallery->get();
}

/**
 * Enqueues gallery scripts.
 *
 * @since 0.1.0
 *
 * @return void
 */
function mai_enqueue_gallery_scripts() {
	$suffix = mai_galleries_get_suffix();

	wp_enqueue_script(
		'mai-galleries',
		MAI_GALLERIES_PLUGIN_URL . sprintf( 'assets/js/mai-galleries%s.js', $suffix ),
		[],
		MAI_GALLERIES_VERSION . '.' . date( 'njYHi', filemtime( MAI_GALLERIES_PLUGIN_DIR . sprintf( 'assets/js/mai-galleries%s.js', $suffix ) ) ),
		true
	);
}

/**
 * Enqueues gallery styles.
 *
 * @since 0.1.0
 *
 * @return void
 */
function mai_enqueue_gallery_styles() {
	$suffix = mai_galleries_get_suffix();

	wp_enqueue_style(
		'mai-galleries',
		MAI_GALLERIES_PLUGIN_URL . sprintf( 'assets/css/mai-galleries%s.css', $suffix ),
		[],
		MAI_GALLERIES_VERSION . '.' . date( 'njYHi', filemtime( MAI_GALLERIES_PLUGIN_DIR . sprintf( 'assets/css/mai-galleries%s.css', $suffix ) ) )
	);
}

/**
 * Gets the script/style `.min` suffix for minified files.
 *
 * @since 0.1.0
 *
 * @return string
 */
function mai_galleries_get_suffix() {
	static $suffix = null;

	if ( ! is_null( $suffix ) ) {
		return $suffix;
	}

	$debug  = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;
	$suffix = $debug ? '' : '.min';

	return $suffix;
}
