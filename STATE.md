# State
Updated: 2026-10-12 by Claude

## Now
Masonry is an Image Orientation choice (1.3.0, unreleased, on `develop`). The choice and its CSS now come from Mai Engine (its `develop` commit `5e5385baf`, shipping in 2.41.0). This plugin only adds `is-masonry` to the gallery and forces the Large size, and only when `mai_gallery_has_masonry()` finds that Mai Engine. Checked headless on a local site at 1440px and 390px: every image keeps its own ratio.

## Next
- Release Mai Engine 2.41.0 (or a beta with masonry) before or with 1.3.0. One live site has a masonry gallery from an earlier develop push. With a Mai Engine that lacks masonry it falls back to a normal grid using the saved Image Size.
- Release 1.3.0. Bump the version in `mai-galleries.php` header and `MAI_GALLERIES_VERSION`, which is stale at 1.2.5.

## Blocked / waiting on
Mai Engine with masonry being released.

## Verify
- Front end: a Masonry gallery has `has-columns is-masonry`, computes `display: block` with `column-count` matching the Columns setting, images fill their column, CLS near 0.
- Editor: same, plus row gap between stacked images.
- Stylesheet URL carries `ver=<version>.<file date>`, not the WordPress version.

## Gotchas
- Detect Mai Engine features with `function_exists()`, never a version number. 1.2.6 fataled on older Mai Engine by calling a 2.41.0 function.
- Never set aspect-ratio on masonry images. Lazy images with `sizes="auto"` get `contain: size` from Chrome, so their shape comes only from the width and height attributes.
- The editor and front end share one stylesheet handle, `mai-galleries`, registered in `mai_gallery_register_style()`. block.json points at the handle, not the file.
- Columns set to Fit do not work with Masonry. Left on purpose.
- `assets/css/mai-galleries.min.css` is edited by hand. There is no build step.
