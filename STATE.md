# State
Updated: 2026-09-30 by Claude

## Now
Masonry layout added as an Image Orientation choice (1.3.0, unreleased). CSS columns, no JS. Tested on musekirwan.com (stairs page, post 4555) and local musekirwan.test.

## Next
- Release 1.3.0. Bump the version in `mai-galleries.php` header and `MAI_GALLERIES_VERSION`, which is stale at 1.2.5.
- Masonry in the editor needs Mai Engine 2.41.0 (`--columns-display`, editor column margins).

## Blocked / waiting on
Nothing.

## Verify
- Front end: a Masonry gallery computes `display: block` with `column-count` matching the Columns setting, images fill their column, CLS near 0.
- Editor (Mai Engine 2.41.0+): same, plus row gap between stacked images.
- Stylesheet URL carries `ver=<version>.<file date>`, not the WordPress version.

## Gotchas
- `--columns` is a fraction like `1 / 3`, so the count is `calc(1 / (var(--columns)))`. Without the inner parentheses it silently computes 1 column.
- The editor and front end share one stylesheet handle, `mai-galleries`, registered in `mai_gallery_register_style()`. block.json points at the handle, not the file.
- Columns set to Fit do not work with Masonry. Left on purpose.
- Masonry forces the Large size. On musekirwan Large is 1920 wide.
