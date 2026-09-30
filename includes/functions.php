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
 * Gets a registered image size to fall back on when none is set.
 *
 * Mai Engine 2.41.0 added mai_get_default_image_size(), which picks a size the
 * site actually registers. Older versions do not have it, and this plugin runs
 * on whatever Mai Engine a site happens to have, so guard the call. Without the
 * guard an older Mai Engine fatals on every request, because the block's field
 * group is registered on acf/init.
 *
 * @since 1.2.7
 *
 * @return string
 */
function mai_gallery_get_default_image_size() {
	if ( function_exists( 'mai_get_default_image_size' ) ) {
		$size = mai_get_default_image_size();

		if ( $size ) {
			return $size;
		}
	}

	return 'landscape-md';
}

/**
 * Registers the gallery stylesheet, shared by the front end and the block editor.
 *
 * The version changes with the file, so browsers and CDNs fetch the new copy after
 * an update. Without one WordPress uses its own version, which the plugin never changes.
 *
 * @since TBD
 *
 * @return void
 */
function mai_gallery_register_style() {
	if ( wp_style_is( 'mai-galleries', 'registered' ) ) {
		return;
	}

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	$file   = "assets/css/mai-galleries{$suffix}.css";
	$path   = MAI_GALLERIES_PLUGIN_DIR . $file;

	wp_register_style( 'mai-galleries', MAI_GALLERIES_PLUGIN_URL . $file, [], MAI_GALLERIES_VERSION . '.' . date( 'njYHi', filemtime( $path ) ) );
	wp_style_add_data( 'mai-galleries', 'path', $path );
}
