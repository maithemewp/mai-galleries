<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Mai_Gallery.
 */
class Mai_Gallery {
	/**
	 * Args.
	 *
	 * @var array $args.
	 */
	protected $args;

	/**
	 * Image size.
	 *
	 * @var string $image_size.
	 */
	protected $image_size;

	/**
	 * Mai_Gallery constructor.
	 *
	 * @since TBD
	 *
	 * @param array $args Gallery args.
	 *
	 * @return void
	 */
	function __construct( $args ) {
		$args = wp_parse_args( $args,
			[
				'preview'                => false,
				'align'                  => '',
				'class'                  => '',
				'images'                 => [],
				'image_orientation'      => 'landscape',
				'image_size'             => 'sm',
				'shadow'                 => false,
				'lightbox'               => false,
				'columns'                => 3,
				'columns_responsive'     => '',
				'columns_md'             => '',
				'columns_sm'             => '',
				'columns_xs'             => '',
				'align_columns'          => '',
				'align_columns_vertical' => '',
				'column_gap'             => 'md',
				'row_gap'                => 'md',
				'margin_top'             => '',
				'margin_bottom'          => '',
			]
		);

		// Sanitize.
		$args['preview']           = mai_sanitize_bool( $args['preview'] );
		$args['align']             = esc_attr( $args['align'] );
		$args['class']             = esc_html( $args['class'] );
		$args['images']            = $args['images'] ? array_map( 'absint', (array) $args['images'] ) : [];
		$args['image_orientation'] = esc_html( $args['image_orientation'] );
		$args['image_size']        = esc_html( $args['image_size'] );
		$args['shadow']            = mai_sanitize_bool( $args['shadow'] );
		$args['lightbox']          = mai_sanitize_bool( $args['lightbox'] );

		// Layout.
		$args                      = array_merge( $args, mai_get_columns_sanitized( $args ) );

		$this->args       = $args;
		$this->image_size = $this->get_image_size();
	}

	/**
	 * Displays gallery.
	 *
	 * @since TBD
	 *
	 * @return void
	 */
	function render() {
		echo $this->get();
	}

	/**
	 * Gets gallery.
	 *
	 * @since TBD
	 *
	 * @return string
	 */
	function get() {
		static $count = 1;
		$html         = '';

		if ( ! $this->args['images'] ) {
			if ( $this->args['preview'] ) {
				$text  = __( 'Add gallery images in the block sidebar settings.', 'mai-galleries' );
				$html .= sprintf( '<p style="display:flex;justify-content:center;align-items:center;color:var(--body-color);font-family:var(--body-font-family);font-weight:var(--body-font-weight);font-size:var(--body-font-size);opacity:0.62;"><span class="dashicons dashicons-format-gallery"></span>&nbsp;&nbsp;%s</p>', $text );
			}

			return $html;
		}

		if ( ! $this->args['preview'] && $this->args['lightbox'] ) {
			$this->enqueue_lightbox_styles();
			$this->enqueue_lightbox_scripts();
		}

		$atts = [
			'id'    => 'mai-gallery-' . $count,
			'class' => 'mai-gallery',
		];

		$atts = mai_get_columns_atts( $atts, $this->args );

		if ( $this->args['align'] ) {
			$atts['class'] = mai_add_classes( 'align' . $this->args['align'], $atts['class'] );
		}

		if ( $this->args['class'] ) {
			$atts['class'] = mai_add_classes( $this->args['class'], $atts['class'] );
		}

		if ( $this->args['margin_top'] ) {
			$atts['class'] = mai_add_classes( sprintf( 'has-%s-margin-top', $this->args['margin_top'] ), $atts['class'] );
		}

		if ( $this->args['margin_bottom'] ) {
			$atts['class'] = mai_add_classes( sprintf( 'has-%s-margin-bottom', $this->args['margin_bottom'] ), $atts['class'] );
		}

		if ( $this->args['shadow'] ) {
			$atts['style'] .= '--image-filter:var(--drop-shadow);';
		}

		$html .= genesis_markup(
			[
				'open'    => '<div %s>',
				'context' => 'mai-gallery',
				'echo'    => false,
				'atts'    => $atts,
				'params'  => [
					'args' => $this->args,
				],
			]
		);

			$html .= $this->get_css();

			foreach ( $this->args['images'] as $image_id ) {
				$image = wp_get_attachment_image(
					$image_id,
					$this->image_size,
					false,
					[
						'alt'   => get_post_meta( $image_id, '_wp_attachment_image_alt', true ),
						'class' => "mai-gallery-image size-{$this->image_size}",
						'title' => get_the_title( $image_id ),
					]
				);

				if ( ! $image ) {
					continue;
				}

				$caption = wp_get_attachment_caption( $image_id );

				if ( $this->args['lightbox'] ) {
					$href   = wp_get_attachment_image_url( $image_id, 'medium' );
					$sizes  = wp_get_attachment_image_sizes( $image_id, 'cover' );
					$srcset = wp_get_attachment_image_srcset( $image_id, 'cover' );
					$image  = sprintf( '<a class="mai-gallery-image-link mai-gallery-lightbox" href="%s" data-gallery="mai-gallery-%s" data-sizes="%s" data-srcset="%s" data-glightbox="description:%s">%s</a>',
						esc_url( $href ),
						$count,
						esc_attr( $sizes ),
						esc_attr( $srcset ),
						esc_attr( $caption ),
						$image
					);
				}

				if ( $caption ) {
					$image .= sprintf( '<figcaption class="mai-gallery-image-caption">%s</figcaption>', $caption );
				}

				$html .= genesis_markup(
					[
						'open'    => '<figure %s>',
						'close'   => '</figure>',
						'context' => 'mai-gallery-item',
						'content' => $image,
						'echo'    => false,
						'atts'    => [
							'class' => 'mai-gallery-item is-column',
						],
						'params'  => [
							'args' => $this->args,
						],
					]
				);
			}

		$html .= genesis_markup(
			[
				'close'   => '</div>',
				'context' => 'mai-gallery',
				'echo'    => false,
				'params'  => [
					'args' => $this->args,
				],
			]
		);

		$count++;

		return $html;
	}

	/**
	 * Gets the image size.
	 *
	 * @since TBD
	 *
	 * @return string
	 */
	public function get_image_size() {
		if ( mai_has_image_orientiation( $this->args['image_orientation'] ) ) {
			$image_size = 'sm';
			$image_size = sprintf( '%s-%s', $this->args['image_orientation'], $image_size );

		} else {
			$image_size = $this->args['image_size'];
		}

		// Filter.
		$image_size = apply_filters( 'mai_gallery_image_size', $image_size, $this->args );

		return esc_attr( $image_size );
	}

	/**
	 * Enqueues gallery scripts.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	function enqueue_lightbox_scripts() {
		wp_enqueue_script(
			'mai-galleries',
			MAI_GALLERIES_PLUGIN_URL . sprintf( 'assets/js/mai-galleries-lightbox%s.js', $this->get_suffix() ),
			[],
			MAI_GALLERIES_VERSION . '.' . date( 'njYHi', filemtime( MAI_GALLERIES_PLUGIN_DIR . sprintf( 'assets/js/mai-galleries-lightbox%s.js', $this->get_suffix() ) ) ),
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
	function enqueue_lightbox_styles() {
		wp_enqueue_style(
			'mai-galleries',
			MAI_GALLERIES_PLUGIN_URL . sprintf( 'assets/css/mai-galleries-lightbox%s.css', $this->get_suffix() ),
			[],
			MAI_GALLERIES_VERSION . '.' . date( 'njYHi', filemtime( MAI_GALLERIES_PLUGIN_DIR . sprintf( 'assets/css/mai-galleries-lightbox%s.css', $this->get_suffix() ) ) )
		);
	}

	/**
	 * Gets toc css link if it hasn't been loaded yet.
	 *
	 * @since 0.1.0
	 *
	 * @return string
	 */
	public function get_css() {
		static $first = false;

		if ( $first ) {
			return;
		}

		$css = file_get_contents( MAI_GALLERIES_PLUGIN_DIR . sprintf( 'assets/css/mai-galleries%s.css', $this->get_suffix() ) );

		if ( $this->args['preview'] ) {
			$css .= '.mai-gallery a {pointer-events: none;}';
		}

		$first = true;

		return sprintf( '<style>%s</style>', $css );
	}

	/**
	 * Gets the script/style `.min` suffix for minified files.
	 *
	 * @since 0.1.0
	 *
	 * @return string
	 */
	function get_suffix() {
		static $suffix = null;

		if ( ! is_null( $suffix ) ) {
			return $suffix;
		}

		$debug  = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;
		$suffix = $debug ? '' : '.min';

		return $suffix;
	}
}
