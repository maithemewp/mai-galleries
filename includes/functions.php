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
