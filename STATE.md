# State
Updated: 2026-10-23 by Claude

## Now
1.3.0 is committed on `develop` (version header, `MAI_GALLERIES_VERSION` and changelog dated 10/23/26), waiting for Mike to release it. Mai Engine 2.41.0, which it needs for Masonry, was released the same day. 1.3.0 adds Masonry, a versioned stylesheet, `Requires PHP: 8.1`, and a guard in `run()` so the block is not loaded when Mai Engine skipped loading its functions (WP-CLI with `--skip-themes` used to fatal).

## Next
- Release 1.3.0: merge `develop` into `master` as `Merge branch 'release/1.3.0'`, push, then `gh release create 1.3.0 --target master --title "Mai Galleries v1.3.0" --notes-file CHANGES.md`. That is how 1.2.7 shipped.

## Blocked / waiting on
Mike releasing 1.3.0. The auto-mode permission check refuses tags and releases.

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
