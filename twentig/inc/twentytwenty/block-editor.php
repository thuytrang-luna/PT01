<?php
/**
 * Block editor
 *
 * @package twentig
 */

/**
 * Display custom CSS generated by the Customizer settings inside the block editor.
 */
function twentig_twentytwenty_print_editor_customizer_css() {

	wp_enqueue_style( // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		'twentig-fonts',
		twentig_fonts_url(),
		array(),
		null
	);

	wp_enqueue_style(
		'twentig-twentytwenty-editor-styles',
		TWENTIG_ASSETS_URI . '/css/twentytwenty-editor.css',
		array(),
		TWENTIG_VERSION
	);

	$css = '';

	$body_font              = get_theme_mod( 'twentig_body_font' );
	$body_font_size         = get_theme_mod( 'twentig_body_font_size', twentig_get_default_body_font_size() );
	$heading_font           = get_theme_mod( 'twentig_heading_font' );
	$heading_font_weight    = get_theme_mod( 'twentig_heading_font_weight', '700' );
	$secondary_font         = get_theme_mod( 'twentig_secondary_font', 'heading' );
	$body_line_height       = get_theme_mod( 'twentig_body_line_height' );
	$h1_font_size           = get_theme_mod( 'twentig_h1_font_size' );
	$heading_letter_spacing = get_theme_mod( 'twentig_heading_letter_spacing' );
	$body_font_stack        = twentig_get_font_stack( 'body' );
	$heading_font_stack     = twentig_get_font_stack( 'heading' );
	$secondary_font_stack   = 'body' === $secondary_font ? $body_font_stack : $heading_font_stack;
	$content_width          = get_theme_mod( 'twentig_text_width' );

	// Layout.
	if ( 'medium' === $content_width ) {
		$css .= '.wp-block,
		.wp-block-cover h2,
		.wp-block .wp-block[data-type="core/group"]:not([data-align="full"]):not([data-align="wide"]):not([data-align="left"]):not([data-align="right"]),
		.wp-block .wp-block[data-type="core/cover"]:not([data-align="full"]):not([data-align="wide"]):not([data-align="left"]):not([data-align="right"]),
		[data-align="wide"] > .wp-block-image figcaption,
		[data-align="full"] > .wp-block-image figcaption,
		hr.wp-block-separator:not(.is-style-wide):not(.is-style-dots) {
			max-width: 700px; 
		}';
	} elseif ( 'wide' === $content_width ) {
		$css .= '.wp-block,
		.wp-block-cover h2,
		.wp-block .wp-block[data-type="core/group"]:not([data-align="full"]):not([data-align="wide"]):not([data-align="left"]):not([data-align="right"]),
		.wp-block .wp-block[data-type="core/cover"]:not([data-align="full"]):not([data-align="wide"]):not([data-align="left"]):not([data-align="right"]),
		[data-align="wide"] > .wp-block-image figcaption,
		[data-align="full"] > .wp-block-image figcaption,
		hr.wp-block-separator:not(.is-style-wide):not(.is-style-dots) { 
			max-width: 800px; 
		}';
	}

	// Typography.
	if ( $body_font ) {
		$css .= '.editor-styles-wrapper > *,
			.editor-styles-wrapper p,
			.editor-styles-wrapper ol,
			.editor-styles-wrapper ul {
				font-family:' . $body_font_stack . ';
		}';
	}

	if ( 'small' === $body_font_size ) {
		$css .= '.editor-styles-wrapper > *, .editor-styles-wrapper .wp-block-latest-posts__post-excerpt { font-size: 17px; }';
	} elseif ( 'medium' === $body_font_size ) {
		$css .= '.editor-styles-wrapper > * { font-size: 19px; }';
	}

	if ( 'medium' === $body_line_height ) {
		$css .= '.edit-post-visual-editor.editor-styles-wrapper, .editor-styles-wrapper p, .editor-styles-wrapper p.wp-block-paragraph { line-height: 1.6;}';
	} elseif ( 'loose' === $body_line_height ) {
		$css .= '.edit-post-visual-editor.editor-styles-wrapper, .editor-styles-wrapper p, .editor-styles-wrapper p.wp-block-paragraph { line-height: 1.8;}';
	}

	$css .= '
		.editor-post-title__block .editor-post-title__input,
		.editor-styles-wrapper h1,
		.editor-styles-wrapper h2,
		.editor-styles-wrapper h3,
		.editor-styles-wrapper h4,
		.editor-styles-wrapper h5,
		.editor-styles-wrapper h6,
		.editor-styles-wrapper .wp-block h1,
		.editor-styles-wrapper .wp-block h2,
		.editor-styles-wrapper .wp-block h3,
		.editor-styles-wrapper .wp-block h4,
		.editor-styles-wrapper .wp-block h5,
		.editor-styles-wrapper .wp-block h6 {';

	if ( $heading_font ) {
		$css .= 'font-family:' . $heading_font_stack . ';';
	}

	if ( $heading_font_weight ) {
		$css .= 'font-weight:' . $heading_font_weight . ';';
	}

	if ( 'normal' === $heading_letter_spacing ) {
		$css .= 'letter-spacing: normal;';
	} else {
		$css .= 'letter-spacing: -0.015em;';
	}

	$css .= ';} ';

	$css .= '.editor-styles-wrapper h6, .editor-styles-wrapper .wp-block h6 { letter-spacing: 0.03125em; }';

	$accent = sanitize_hex_color( twentytwenty_get_color_for_area( 'content', 'accent' ) );
	$css   .= '.editor-styles-wrapper a { color: ' . $accent . '}';

	$css .= '
		.editor-styles-wrapper .wp-block-button .wp-block-button__link,
		.editor-styles-wrapper .wp-block-file .wp-block-file__button,
		.editor-styles-wrapper .wp-block-paragraph.has-drop-cap:not(:focus):first-letter,
		.editor-styles-wrapper .wp-block-pullquote, 
		.editor-styles-wrapper .wp-block-quote.is-style-large,
		.editor-styles-wrapper .wp-block-quote.is-style-tw-large-icon,
		.editor-styles-wrapper .wp-block-quote .wp-block-quote__citation,
		.editor-styles-wrapper .wp-block-pullquote .wp-block-pullquote__citation,				
		.editor-styles-wrapper figcaption { font-family: ' . $secondary_font_stack . '; }';

	if ( $h1_font_size ) {
		$css .= '@media (min-width: 1220px) {
			.editor-styles-wrapper div[data-type="core/pullquote"][data-align="wide"] blockquote p, 
			.editor-styles-wrapper div[data-type="core/pullquote"][data-align="full"] blockquote p {
				font-size: 48px;
			}
		}';

		if ( 'small' === $h1_font_size ) {
			$css .= '@media (min-width: 700px) {
				.editor-post-title__block .editor-post-title__input, 
				.editor-styles-wrapper h1,
				.editor-styles-wrapper .wp-block h1, 
				.editor-styles-wrapper .wp-block.has-h-1-font-size {
					font-size: 56px;
				}				
			}';
		} elseif ( 'medium' === $h1_font_size ) {
			$css .= '@media (min-width: 1220px) {
				.editor-post-title__block .editor-post-title__input, 
				.editor-styles-wrapper h1, 
				.editor-styles-wrapper .wp-block h1, 
				.editor-styles-wrapper .wp-block.has-h-1-font-size {
					font-size: 64px;
				}
			}';
		} elseif ( 'large' === $h1_font_size ) {
			$css .= '@media (min-width: 1220px) {
				.editor-post-title__block .editor-post-title__input,
				.editor-styles-wrapper h1,
				.editor-styles-wrapper .wp-block h1,
				.editor-styles-wrapper .wp-block.has-h-1-font-size {
					font-size: 72px;
				}
			}';
		}
	}

	// Layout blocks adjustments.
	if ( '#ffffff' === strtolower( twentytwenty_get_color_for_area( 'content', 'text' ) ) ) {
		$css .= ':root .has-background-background-color, :root .has-subtle-background-background-color{ color: #fff; }';
		$css .= '.editor-styles-wrapper .wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-text-color) { color: #000; }';
	}

	// Elements styling.
	if ( ! get_theme_mod( 'twentig_button_uppercase', true ) ) {
		$css .= '.editor-styles-wrapper .wp-block-button .wp-block-button__link,
		.editor-styles-wrapper .wp-block-file .wp-block-file__button { text-transform: none; }';
	}

	$button_shape = get_theme_mod( 'twentig_button_shape', 'square' );
	if ( 'rounded' === $button_shape ) {
		$css .= '.editor-styles-wrapper .wp-block-button__link { border-radius: 6px; }';
	} elseif ( 'pill' === $button_shape ) {
		$css .= '.editor-styles-wrapper .wp-block-button__link { border-radius: 50px; padding: 1.1em 1.8em; }';
	}

	if ( 'minimal' === get_theme_mod( 'twentig_separator_style' ) ) {
		$css .= '.editor-styles-wrapper hr:not(.is-style-dots ) { 
			background: currentColor !important;
		}

		.editor-styles-wrapper hr:not(.has-background):not(.is-style-dots) {
			color: currentColor;
			opacity: 0.15;
		}	

		.editor-styles-wrapper hr:not(.is-style-dots)::before,
		.editor-styles-wrapper hr:not(.is-style-dots)::after {
			background-color: transparent;
		}';
	}
	wp_add_inline_style( 'twentig-twentytwenty-editor-styles', $css );
}
add_action( 'enqueue_block_editor_assets', 'twentig_twentytwenty_print_editor_customizer_css', 20 );

/**
 * Set up theme defaults and register support for various features.
 */
function twentig_twentytwenty_theme_support() {

	// Set editor font sizes based on body font-size.
	$body_font_size = get_theme_mod( 'twentig_body_font_size', twentig_get_default_body_font_size() );

	$font_sizes = current( (array) get_theme_support( 'editor-font-sizes' ) );

	// Add medium font size option in the editor dropdown.
	$medium = array(
		'name' => esc_html_x( 'Medium', 'Name of the medium font size in the block editor', 'twentig' ),
		'size' => 23,
		'slug' => 'medium',
	);
	array_splice( $font_sizes, 2, 0, array( $medium ) );

	if ( 'small' === $body_font_size || 'medium' === $body_font_size ) {
		$size_s      = 14;
		$size_normal = 17;
		$size_m      = 19;
		$size_l      = 21;
		$size_xl     = 25;

		if ( 'medium' === $body_font_size ) {
			$size_s      = 16;
			$size_normal = 19;
			$size_m      = 21;
			$size_l      = 24;
			$size_xl     = 28;
		}

		foreach ( $font_sizes as $index => $settings ) {
			if ( 'small' === $settings['slug'] ) {
				$font_sizes[ $index ]['size'] = $size_s;
			} elseif ( 'normal' === $settings['slug'] ) {
				$font_sizes[ $index ]['size'] = $size_normal;
			} elseif ( 'medium' === $settings['slug'] ) {
				$font_sizes[ $index ]['size'] = $size_m;
			} elseif ( 'large' === $settings['slug'] ) {
				$font_sizes[ $index ]['size'] = $size_l;
			} elseif ( 'larger' === $settings['slug'] ) {
				$font_sizes[ $index ]['size'] = $size_xl;
			}
		}
	}

	$font_sizes = array_merge( $font_sizes, twentig_twentytwenty_get_heading_font_sizes() );

	add_theme_support( 'editor-font-sizes', $font_sizes );

	// Update subtle color.
	$color_palette     = current( (array) get_theme_support( 'editor-color-palette' ) );
	$subtle_background = get_theme_mod( 'twentig_subtle_background_color' );

	if ( $subtle_background ) {
		foreach ( $color_palette as $index => $settings ) {
			if ( 'subtle-background' === $settings['slug'] ) {
				$color_palette[ $index ]['color'] = $subtle_background;
			}
		}
	}

	add_theme_support( 'editor-color-palette', $color_palette );

	// Set content-width based on text width.
	$text_width = get_theme_mod( 'twentig_text_width' );
	if ( $text_width ) {
		global $content_width;
		if ( 'medium' === $text_width ) {
			$content_width = 700;
		} elseif ( 'wide' === $text_width ) {
			$content_width = 800;
		}
	}

	// Add support for custom units.
	// This was removed in WordPress 5.6 but is still required to properly support WP 5.5.
	add_theme_support( 'custom-units' );

	// Add support for custom line height controls.
	add_theme_support( 'custom-line-height' );

	// Add support for custom spacing.
	add_theme_support( 'custom-spacing' );
}
add_action( 'after_setup_theme', 'twentig_twentytwenty_theme_support', 12 );

/**
 * Retrieves heading font sizes.
 */
function twentig_twentytwenty_get_heading_font_sizes() {
	$h1_font_size = get_theme_mod( 'twentig_h1_font_size' );
	$h1_size_px   = 84;

	if ( 'small' === $h1_font_size ) {
		$h1_size_px = 56;
	} elseif ( 'medium' === $h1_font_size ) {
		$h1_size_px = 64;
	} elseif ( 'large' === $h1_font_size ) {
		$h1_size_px = 72;
	}

	$sizes = array(
		array(
			'name' => 'H6',
			'size' => 18.01,
			'slug' => 'h6',
		),
		array(
			'name' => 'H5',
			'size' => 24.01,
			'slug' => 'h5',
		),
		array(
			'name' => 'H4',
			'size' => 32.01,
			'slug' => 'h4',
		),
		array(
			'name' => 'H3',
			'size' => 40.01,
			'slug' => 'h3',
		),
		array(
			'name' => 'H2',
			'size' => 48.01,
			'slug' => 'h2',
		),
		array(
			'name' => 'H1',
			'size' => $h1_size_px,
			'slug' => 'h1',
		),
	);

	return $sizes;
}

/**
 * Registers block styles.
 */
function twentig_twentytwenty_register_block_styles() {
	register_block_style(
		'core/quote',
		array(
			'name'  => 'tw-icon',
			'label' => esc_html__( 'Icon', 'twentig' ),
		)
	);
	register_block_style(
		'core/quote',
		array(
			'name'  => 'tw-large-icon',
			'label' => esc_html__( 'Large icon', 'twentig' ),
		)
	);

	register_block_style(
		'core/quote',
		array(
			'name'  => 'tw-minimal',
			'label' => esc_html_x( 'Minimal', 'block style', 'twentig' ),
		)
	);

	register_block_style(
		'core/pullquote',
		array(
			'name'  => 'tw-minimal',
			'label' => esc_html_x( 'Minimal', 'block style', 'twentig' ),
		)
	);
}
add_action( 'init', 'twentig_twentytwenty_register_block_styles', 30 );
