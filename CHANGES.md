# Changelog

## 1.2.7 (8/21/26)
* Fixed: A fatal error on sites running Mai Engine 2.40.1 or earlier. 1.2.6 called a Mai Engine function that only exists in 2.41.0, on every request.

## 1.2.6 (8/21/26)
* Fixed: Setting Image Orientation to Custom rendered full-size images, and picking the first size in the Image Size list appeared to do nothing. Neither select had a working default.
* Fixed: A gallery with no saved Columns value laid every image out at zero width instead of falling back to 3 columns.
* Fixed: Columns set to Fit sized each image wrongly, either stretching it across the full row or collapsing it to nothing. Fit columns are now sized to the chosen image size, which also lets the browser pick a smaller file.
* Fixed: A PHP warning when a cloned Columns field had no sub fields.
* Fixed: Removed a stray translation call in the Layout tab settings.

## 1.2.5 (5/27/26)
* Changed: Updated the updater for PHP 8.4 support.

## 1.2.4 (5/27/26)
* Changed: Updated blocks to Block API v3 for WP 6.9 compatibility.

## 1.2.3 (12/5/24)
* Changed: Updated the updater.
* Changed: Disable unnecessary block validation via ACF.
* Changed: [Performance] Only run ACF filters in the back end.

## 1.2.2 (11/27/23)
* Changed: Updated the updater.

## 1.2.1 (7/31/23)
* Fixed: Lightbox not launching overlay.

## 1.2.0 (7/10/23)
* Added: New block setting to enable linked images in your gallery.
* Changed: Better handling of inline styles via `wp_add_inline_style()`.
* Changed: Updated the updater.

## 1.1.1 (1/11/23)
* Fixed: Better support for SVG logos.

## 1.1.0 (11/4/22)
* Changed: Mai Gallery block now uses v2 block API.
* Changed: Updated the updater.
* Fixed: Border radius not being respected on images.

## 1.0.0 (7/20/22)
* Fixed: Missing alt and title attributes on images.
* Fixed: Undefined function error in certain scenarios when Mai Engine is not active.
* Version bump for consistency and to show the plugin has official been released.

## 0.3.4
* Changed: Uses engine columns sanitization helper function.

## 0.3.3
* Added: New "Fit" column size to fit the column to the size of the content inside.
* Changed: Updated block description and tweaked field labels.

## 0.3.1
* Changed: Fade in gallery arrows/icons.

## 0.3.0
* Changed: Switched from Parvus to gLightbox.

## 0.2.0
* Changed: Added border on arrows and close button on hover/focus/active.
* Fixed: Allow captions to work.

## 0.1.0
Initial release.
