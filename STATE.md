# State
Updated: 2026-10-23 by Claude

## Now
1.3.0 is released (2026-10-23): GitHub release `1.3.0` on `master` at `f949979`. It adds Masonry (needs Mai Engine 2.41.0, released the same day), a versioned stylesheet, `Requires PHP: 8.1`, and a guard in `run()` so the block is not loaded when Mai Engine skipped loading its functions (WP-CLI with `--skip-themes` used to fatal).

## Next
- Nothing open. Releases go like 1.2.7 and 1.3.0: a version commit on `develop` (header, `MAI_GALLERIES_VERSION`, dated changelog), merge into `master` as `Merge branch 'release/X.Y.Z'`, then `gh release create X.Y.Z --target master --title "Mai Galleries vX.Y.Z" --notes-file CHANGES.md`. `release-qa.sh postrelease` warns about the develop tip because this repo doesn't merge the tag back. Ignore it.

## Blocked / waiting on
Nothing. The auto-mode permission check refuses tags and releases, so Mike runs those.

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
