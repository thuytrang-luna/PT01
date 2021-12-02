<?php
/**
 * Fonts
 *
 * @package twentig
 */

/**
 * Returns custom Google fonts URL based on Customizer settings.
 */
function twentig_twentyone_fonts_url() {
	$fonts_url           = '';
	$fonts               = array();
	$body_font           = get_theme_mod( 'twentig_body_font' );
	$heading_font        = get_theme_mod( 'twentig_heading_font' );
	$heading_font_weight = get_theme_mod( 'twentig_heading_font_weight', '400' );
	$menu_font           = get_theme_mod( 'twentig_menu_font', 'body' );
	$menu_font_weight    = get_theme_mod( 'twentig_menu_font_weight', '400' );
	$tertiary_font       = get_theme_mod( 'twentig_secondary_elements_font', 'body' );
	$logo_font           = get_theme_mod( 'twentig_logo_font' );
	$logo_font           = $logo_font ? $logo_font : $heading_font;
	$logo_font_weight    = get_theme_mod( 'twentig_logo_font_weight', '400' );

	if ( $body_font ) {
		$fonts[ $body_font ] = array( '400', '700' );
		if ( 'body' === $menu_font ) {
			$fonts[ $body_font ][] = $menu_font_weight;
		}
	}

	if ( $heading_font ) {

		if ( ! isset( $fonts[ $heading_font ] ) ) {
			$fonts[ $heading_font ] = array();
		}
		$fonts[ $heading_font ][] = $heading_font_weight;

		if ( 'heading' === $menu_font ) {
			$fonts[ $heading_font ][] = $menu_font_weight;
		}

		if ( 'heading' === $tertiary_font ) {
			if ( ! in_array( '400', $fonts[ $heading_font ], true ) ) {
				$fonts[ $heading_font ][] = '400';
			}
		}
	}

	if ( isset( $fonts[ $logo_font ] ) ) {
		$fonts[ $logo_font ][] = $logo_font_weight;
	}

	if ( ! empty( $fonts ) ) {

		$args_url = '';
		foreach ( $fonts as $font_family => $variants ) {
			$variants = array_unique( $variants );
			sort( $variants );
			$family = explode( ',', $font_family )[0];
			$family = str_replace( "'", '', $family );
			if ( $font_family === $body_font ) {
				$args_url .= '&family=' . urlencode( $family . ':ital,wght@0,' . implode( ';0,', $variants ) . ';1,400' ); // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.urlencode_urlencode
			} else {
				$args_url .= '&family=' . urlencode( $family . ':wght@' . implode( ';', $variants ) ); // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.urlencode_urlencode
			}
		}
		$args_url .= '&display=swap';

		$fonts_url = 'https://fonts.googleapis.com/css2?' . trim( $args_url, '&' );
	}

	return apply_filters( 'twentig_google_fonts_url', esc_url_raw( $fonts_url ) );
}

/**
 * Returns custom Google fonts URL for the site title.
 */
function twentig_twentyone_logo_font_url() {

	$logo_font_url = '';

	if ( get_theme_mod( 'display_title_and_tagline', true ) ) {

		$logo_font_family = '';
		$logo_font        = get_theme_mod( 'twentig_logo_font' );
		$logo_font_weight = get_theme_mod( 'twentig_logo_font_weight', '400' );
		$body_font        = get_theme_mod( 'twentig_body_font' );
		$heading_font     = get_theme_mod( 'twentig_heading_font' );

		if ( ! $logo_font || $body_font === $logo_font || $heading_font === $logo_font ) {
			return '';
		}

		$logo_font        = explode( ',', $logo_font )[0];
		$logo_font        = str_replace( "'", '', $logo_font );
		$logo_font_family = $logo_font . ':wght@' . $logo_font_weight;
		$logo_transform   = get_theme_mod( 'twentig_logo_text_transform', 'uppercase' );
		$text             = get_bloginfo( 'name' );

		if ( 'uppercase' === $logo_transform ) {
			$text = strtoupper( $text );
		} elseif ( 'lowercase' === $logo_transform ) {
			$text = strtolower( $text );
		} elseif ( 'capitalize' === $logo_transform ) {
			$text = ucwords( $text );
		}

		$query_args = array(
			'family'  => urlencode( $logo_font_family ), // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.urlencode_urlencode
			'text'    => urlencode( $text ), // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.urlencode_urlencode
			'display' => 'swap',
		);

		$logo_font_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css2' );
	}

	return esc_url_raw( $logo_font_url );
}

/**
 * Returns Google Fonts choices.
 *
 * @param string $type Font type.
 * @param bool   $curated Is is a curated font.
 */
function twentig_twentyone_get_font_choices( $type = 'heading', $curated = true ) {
	$font_options  = array();
	$curated_fonts = 'body' === $type ? twentig_twentyone_get_body_curated_fonts() : twentig_twentyone_get_heading_curated_fonts();

	$google_font_options = twentig_twentyone_get_fonts();
	foreach ( $google_font_options as $font ) {
		if ( $curated ) {
			if ( ! in_array( $font['name'], $curated_fonts, true ) ) {
				continue;
			}
		} else {
			if ( in_array( $font['name'], $curated_fonts, true ) ) {
				continue;
			}
		}
		$font_options[ $font['family'] ] = $font['name'];
	}
	return $font_options;
}

/**
 * Returns all Google fonts.
 */
function twentig_twentyone_get_fonts() {
	$fonts = twentig_get_data_from_file( TWENTIG_PATH . 'inc/theme-tools/webfonts.json' );
	return apply_filters( 'twentig_fonts', $fonts );
}

/**
 * Returns curated heading fonts.
 */
function twentig_twentyone_get_heading_curated_fonts() {
	$fonts = array(
		'Alegreya',
		'Alegreya Sans',
		'Anonymous Pro',
		'Archivo Narrow',
		'Arimo',
		'Arvo',
		'Arya',
		'Asap',
		'Asap Condensed',
		'B612',
		'Barlow',
		'Barlow Condensed',
		'Big Shoulders Display',
		'BioRhyme',
		'Bitter',
		'Cabin',
		'Cabin Condensed',
		'Cardo',
		'Chivo',
		'Comfortaa',
		'Cormorant Garamond',
		'Cousine',
		'Crimson Pro',
		'DM Sans',
		'Domine',
		'Dosis',
		'EB Garamond',
		'Eczar',
		'Exo 2',
		'Fira Sans',
		'Fira Sans Condensed',
		'Gentium Basic',
		'IBM Plex Mono',
		'IBM Plex Sans',
		'IBM Plex Sans Condensed',
		'IBM Plex Serif',
		'Inconsolata',
		'Inknut Antiqua',
		'Inria Sans',
		'Inria Serif',
		'Inter',
		'Josefin Sans',
		'Josefin Slab',
		'Jost',
		'Kalam',
		'Karla',
		'Lato',
		'Lekton',
		'Libre Baskerville',
		'Libre Franklin',
		'Lora',
		'Manrope',
		'Merriweather',
		'Merriweather Sans',
		'Montserrat',
		'Muli',
		'Neuton',
		'Noto Sans',		
		'Noto Sans Display',
		'Noto Serif',
		'Noto Serif Display',
		'Nunito',
		'Nunito Sans',
		'Old Standard TT',
		'Open Sans',
		'Oswald',
		'Overpass',
		'Playfair Display',
		'Poppins',
		'Proza Libre',
		'PT Sans',
		'PT Sans Narrow',
		'PT Serif',
		'Public Sans',
		'Quattrocento',
		'Quattrocento Sans',
		'Rajdhani',
		'Red Hat Display',
		'Red Hat Text',
		'Raleway',
		'Roboto',
		'Roboto Condensed',
		'Roboto Mono',
		'Roboto Slab',
		'Rubik',
		'Rufina',
		'Signika',
		'Source Code Pro',
		'Source Sans Pro',
		'Source Serif Pro',
		'Space Grotesk',
		'Space Mono',
		'Spectral',
		'Taviraj',
		'Tinos',
		'Titillium Web',
		'Ubuntu',
		'Ubuntu Mono',
		'Vollkorn',
		'Work Sans',
		'Yanone Kaffeesatz',
		'Zilla Slab',
	);
	return $fonts;

}

/**
 * Returns curated body fonts.
 */
function twentig_twentyone_get_body_curated_fonts() {
	$fonts = array(
		'Alegreya',
		'Alegreya Sans',
		'Anonymous Pro',
		'Arimo',
		'Arvo',
		'Asap',
		'B612',
		'Barlow',
		'Bitter',
		'Cabin',
		'Cardo',
		'Chivo',
		'Cousine',
		'Crimson Pro',
		'DM Sans',
		'EB Garamond',
		'Exo 2',
		'Fira Sans',
		'Gentium Basic',
		'IBM Plex Mono',
		'IBM Plex Sans',
		'IBM Plex Serif',
		'Inria Sans',
		'Inria Serif',
		'Inter',
		'Josefin Sans',
		'Josefin Slab',
		'Jost',
		'Karla',
		'Lato',
		'Lekton',
		'Libre Baskerville',
		'Libre Franklin',
		'Lora',
		'Merriweather',
		'Merriweather Sans',
		'Montserrat',
		'Muli',
		'Neuton',
		'Noto Sans',
		'Noto Serif',
		'Nunito',
		'Nunito Sans',
		'Old Standard TT',
		'Open Sans',
		'Overpass',
		'Poppins',
		'Proza Libre',
		'PT Sans',
		'PT Serif',
		'Public Sans',
		'Quattrocento Sans',
		'Red Hat Text',
		'Raleway',
		'Roboto',
		'Roboto Mono',
		'Rubik',
		'Source Code Pro',
		'Source Sans Pro',
		'Source Serif Pro',
		'Space Mono',
		'Spectral',
		'Taviraj',
		'Tinos',
		'Titillium Web',
		'Ubuntu',
		'Ubuntu Mono',
		'Vollkorn',
		'Work Sans',
		'Zilla Slab',
	);
	return $fonts;

}

/**
 * Returns font weight choices.
 */
function twentig_twentyone_get_font_styles() {

	$list_font_weights = array(
		''    => esc_html__( 'Default', 'twentig' ),
		'100' => 'Thin 100',
		'200' => 'Extra-light 200',
		'300' => 'Light 300',
		'400' => 'Regular 400',
		'500' => 'Medium 500',
		'600' => 'Semi-Bold 600',
		'700' => 'Bold 700',
		'800' => 'Extra-Bold 800',
		'900' => 'Black 900',
	);
	return $list_font_weights;
}

/**
 * Returns font presets.
 */
function twentig_twentyone_get_font_presets() {

	$presets = array(
		array(
			'name'  => 'Default',
			'image' => 'system.png',
			'mods'  => array(
				'twentig_body_font'               => '',
				'twentig_body_font_size'          => '20',
				'twentig_body_line_height'        => '1.7',
				'twentig_heading_font'            => '',
				'twentig_heading_font_weight'     => '400',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '96',
				'twentig_secondary_elements_font' => 'body',
				'twentig_menu_font'               => 'body',
				'twentig_menu_font_weight'        => '400',
				'twentig_menu_font_size'          => '20',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
		array(
			'name'  => 'Roboto + Roboto',
			'image' => 'roboto.png',
			'mods'  => array(
				'twentig_body_font'               => "'Roboto', sans-serif",
				'twentig_body_font_size'          => '18',
				'twentig_body_line_height'        => '1.6',
				'twentig_heading_font'            => "'Roboto', sans-serif",
				'twentig_heading_font_weight'     => '500',
				'twentig_heading_letter_spacing'  => '-0.015',
				'twentig_h1_font_size'            => '68',
				'twentig_secondary_elements_font' => 'body',
				'twentig_menu_font'               => 'body',
				'twentig_menu_font_weight'        => '500',
				'twentig_menu_font_size'          => '16',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
		array(
			'name'  => 'Playfair Display + Lato',
			'image' => 'playfair-display-1.png',
			'mods'  => array(
				'twentig_body_font'               => "'Lato', sans-serif",
				'twentig_body_font_size'          => '18',
				'twentig_body_line_height'        => '1.6',
				'twentig_heading_font'            => "'Playfair Display', serif",
				'twentig_heading_font_weight'     => '700',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'body',
				'twentig_menu_font'               => 'body',
				'twentig_menu_font_weight'        => '700',
				'twentig_menu_font_size'          => '14',
				'twentig_menu_letter_spacing'     => '0.04',
				'twentig_menu_text_transform'     => 'uppercase',
			),
		),
		array(
			'name'  => 'Merriweather Sans + Merriweather',
			'image' => 'merriweather-sans.png',
			'mods'  => array(
				'twentig_body_font'               => "'Merriweather', serif",
				'twentig_body_font_size'          => '18',
				'twentig_body_line_height'        => '1.8',
				'twentig_heading_font'            => "'Merriweather Sans', sans-serif",
				'twentig_heading_font_weight'     => '700',
				'twentig_heading_letter_spacing'  => '-0.015',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'heading',
				'twentig_menu_font'               => 'heading',
				'twentig_menu_font_weight'        => '400',
				'twentig_menu_font_size'          => '16',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
		array(
			'name'  => 'Source Serif Pro + Source Sans Pro',
			'image' => 'source-serif-pro.png',
			'mods'  => array(
				'twentig_body_font'               => "'Source Sans Pro', sans-serif",
				'twentig_body_font_size'          => '20',
				'twentig_body_line_height'        => '1.6',
				'twentig_heading_font'            => "'Source Serif Pro', serif",
				'twentig_heading_font_weight'     => '600',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'body',
				'twentig_menu_font'               => 'heading',
				'twentig_menu_font_weight'        => '600',
				'twentig_menu_font_size'          => '18',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
		array(
			'name'  => 'Inter + Inter',
			'image' => 'inter.png',
			'mods'  => array(
				'twentig_body_font'               => "'Inter', sans-serif",
				'twentig_body_font_size'          => '18',
				'twentig_body_line_height'        => '1.6',
				'twentig_heading_font'            => "'Inter', sans-serif",
				'twentig_heading_font_weight'     => '700',
				'twentig_heading_letter_spacing'  => '-0.015',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'body',
				'twentig_menu_font'               => 'body',
				'twentig_menu_font_weight'        => '400',
				'twentig_menu_font_size'          => '18',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
		array(
			'name'  => 'Libre Franklin + Libre Baskerville',
			'image' => 'libre-franklin.png',
			'mods'  => array(
				'twentig_body_font'               => "'Libre Baskerville', serif",
				'twentig_body_font_size'          => '18',
				'twentig_body_line_height'        => '1.8',
				'twentig_heading_font'            => "'Libre Franklin', sans-serif",
				'twentig_heading_font_weight'     => '700',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'heading',
				'twentig_menu_font'               => 'heading',
				'twentig_menu_font_weight'        => '700',
				'twentig_menu_font_size'          => '16',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
		array(
			'name'  => 'Raleway + Raleway',
			'image' => 'raleway.png',
			'mods'  => array(
				'twentig_body_font'               => "'Raleway', sans-serif",
				'twentig_body_font_size'          => '18',
				'twentig_body_line_height'        => '1.6',
				'twentig_heading_font'            => "'Raleway', sans-serif",
				'twentig_heading_font_weight'     => '500',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'body',
				'twentig_menu_font'               => 'body',
				'twentig_menu_font_weight'        => '500',
				'twentig_menu_font_size'          => '16',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
		array(
			'name'  => 'Alegreya + Alegreya Sans',
			'image' => 'alegreya.png',
			'mods'  => array(
				'twentig_body_font'               => "'Alegreya Sans', sans-serif",
				'twentig_body_font_size'          => '20',
				'twentig_body_line_height'        => '1.5',
				'twentig_heading_font'            => "'Alegreya', serif",
				'twentig_heading_font_weight'     => '700',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '72',
				'twentig_secondary_elements_font' => 'body',
				'twentig_menu_font'               => 'body',
				'twentig_menu_font_weight'        => '700',
				'twentig_menu_font_size'          => '20',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
		array(
			'name'  => 'Cabin + Crimson Pro',
			'image' => 'cabin.png',
			'mods'  => array(
				'twentig_body_font'               => "'Crimson Pro', serif",
				'twentig_body_font_size'          => '22',
				'twentig_body_line_height'        => '1.5',
				'twentig_heading_font'            => "'Cabin', sans-serif",
				'twentig_heading_font_weight'     => '600',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '72',
				'twentig_secondary_elements_font' => 'heading',
				'twentig_menu_font'               => 'heading',
				'twentig_menu_font_weight'        => '400',
				'twentig_menu_font_size'          => '18',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
		array(
			'name'  => 'Barlow Condensed + Barlow',
			'image' => 'barlow-condensed.png',
			'mods'  => array(
				'twentig_body_font'               => "'Barlow', sans-serif",
				'twentig_body_font_size'          => '18',
				'twentig_body_line_height'        => '1.6',
				'twentig_heading_font'            => "'Barlow Condensed', sans-serif",
				'twentig_heading_font_weight'     => '600',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '84',
				'twentig_secondary_elements_font' => 'body',
				'twentig_menu_font'               => 'heading',
				'twentig_menu_font_weight'        => '600',
				'twentig_menu_font_size'          => '18',
				'twentig_menu_letter_spacing'     => '0.04',
				'twentig_menu_text_transform'     => 'uppercase',
			),
		),
		array(
			'name'  => 'Rufina + Tinos',
			'image' => 'rufina.png',
			'mods'  => array(
				'twentig_body_font'               => "'Tinos', serif",
				'twentig_body_font_size'          => '20',
				'twentig_body_line_height'        => '1.5',
				'twentig_heading_font'            => "'Rufina', serif",
				'twentig_heading_font_weight'     => '700',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'body',
				'twentig_menu_font'               => 'body',
				'twentig_menu_font_weight'        => '400',
				'twentig_menu_font_size'          => '18',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
		array(
			'name'  => 'Open Sans + Open Sans',
			'image' => 'open-sans.png',
			'mods'  => array(
				'twentig_body_font'               => "'Open Sans', sans-serif",
				'twentig_body_font_size'          => '18',
				'twentig_body_line_height'        => '1.6',
				'twentig_heading_font'            => "'Open Sans', sans-serif",
				'twentig_heading_font_weight'     => '700',
				'twentig_heading_letter_spacing'  => '-0.015',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'body',
				'twentig_menu_font'               => 'body',
				'twentig_menu_font_weight'        => '400',
				'twentig_menu_font_size'          => '16',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
		array(
			'name'  => 'Domine + Arimo',
			'image' => 'domine.png',
			'mods'  => array(
				'twentig_body_font'               => "'Arimo', sans-serif",
				'twentig_body_font_size'          => '18',
				'twentig_body_line_height'        => '1.6',
				'twentig_heading_font'            => "'Domine', serif",
				'twentig_heading_font_weight'     => '700',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'body',
				'twentig_menu_font'               => 'body',
				'twentig_menu_font_weight'        => '400',
				'twentig_menu_font_size'          => '18',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
		array(
			'name'  => 'IBM Plex Sans + IBM Plex Serif',
			'image' => 'ibm-plex-sans-1.png',
			'mods'  => array(
				'twentig_body_font'               => "'IBM Plex Serif', serif",
				'twentig_body_font_size'          => '18',
				'twentig_body_line_height'        => '1.8',
				'twentig_heading_font'            => "'IBM Plex Sans', sans-serif",
				'twentig_heading_font_weight'     => '600',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'heading',
				'twentig_menu_font'               => 'heading',
				'twentig_menu_font_weight'        => '600',
				'twentig_menu_font_size'          => '18',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
		array(
			'name'  => 'Quattrocento + Quattrocento Sans',
			'image' => 'quattrocento.png',
			'mods'  => array(
				'twentig_body_font'               => "'Quattrocento Sans', sans-serif",
				'twentig_body_font_size'          => '20',
				'twentig_body_line_height'        => '1.6',
				'twentig_heading_font'            => "'Quattrocento', serif",
				'twentig_heading_font_weight'     => '700',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'body',
				'twentig_menu_font'               => 'body',
				'twentig_menu_font_weight'        => '700',
				'twentig_menu_font_size'          => '18',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
		array(
			'name'  => 'Montserrat + Montserrat',
			'image' => 'montserrat.png',
			'mods'  => array(
				'twentig_body_font'               => "'Montserrat', sans-serif",
				'twentig_body_font_size'          => '18',
				'twentig_body_line_height'        => '1.6',
				'twentig_heading_font'            => "'Montserrat', sans-serif",
				'twentig_heading_font_weight'     => '700',
				'twentig_heading_letter_spacing'  => '-0.015',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'body',
				'twentig_menu_font'               => 'body',
				'twentig_menu_font_weight'        => '400',
				'twentig_menu_font_size'          => '16',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
		array(
			'name'  => 'Nunito + Nunito Sans',
			'image' => 'nunito.png',
			'mods'  => array(
				'twentig_body_font'               => "'Nunito Sans', sans-serif",
				'twentig_body_font_size'          => '18',
				'twentig_body_line_height'        => '1.6',
				'twentig_heading_font'            => "'Nunito', sans-serif",
				'twentig_heading_font_weight'     => '600',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'body',
				'twentig_menu_font'               => 'heading',
				'twentig_menu_font_weight'        => '600',
				'twentig_menu_font_size'          => '18',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
		array(
			'name'  => 'Old Standard TT + Nunito Sans',
			'image' => 'old-standard-tt.png',
			'mods'  => array(
				'twentig_body_font'               => "'Nunito Sans', sans-serif",
				'twentig_body_font_size'          => '18',
				'twentig_body_line_height'        => '1.6',
				'twentig_heading_font'            => "'Old Standard TT', serif",
				'twentig_heading_font_weight'     => '700',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'body',
				'twentig_menu_font'               => 'body',
				'twentig_menu_font_weight'        => '700',
				'twentig_menu_font_size'          => '14',
				'twentig_menu_letter_spacing'     => '0.04',
				'twentig_menu_text_transform'     => 'uppercase',
			),
		),
		array(
			'name'  => 'Work Sans + Work Sans',
			'image' => 'work-sans.png',
			'mods'  => array(
				'twentig_body_font'               => "'Work Sans', sans-serif",
				'twentig_body_font_size'          => '18',
				'twentig_body_line_height'        => '1.6',
				'twentig_heading_font'            => "'Work Sans', sans-serif",
				'twentig_heading_font_weight'     => '600',
				'twentig_heading_letter_spacing'  => '-0.015',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'body',
				'twentig_menu_font'               => 'body',
				'twentig_menu_font_weight'        => '600',
				'twentig_menu_font_size'          => '18',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
		array(
			'name'  => 'Oswald + Roboto',
			'image' => 'oswald.png',
			'mods'  => array(
				'twentig_body_font'               => "'Roboto', sans-serif",
				'twentig_body_font_size'          => '18',
				'twentig_body_line_height'        => '1.6',
				'twentig_heading_font'            => "'Oswald', sans-serif",
				'twentig_heading_font_weight'     => '700',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '72',
				'twentig_secondary_elements_font' => 'body',
				'twentig_menu_font'               => 'body',
				'twentig_menu_font_weight'        => '400',
				'twentig_menu_font_size'          => '14',
				'twentig_menu_letter_spacing'     => '0.04',
				'twentig_menu_text_transform'     => 'uppercase',
			),
		),
		array(
			'name'  => 'Spectral + Spectral',
			'image' => 'spectral.png',
			'mods'  => array(
				'twentig_body_font'               => "'Spectral', serif",
				'twentig_body_font_size'          => '20',
				'twentig_body_line_height'        => '1.5',
				'twentig_heading_font'            => "'Spectral', serif",
				'twentig_heading_font_weight'     => '700',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'body',
				'twentig_menu_font'               => 'body',
				'twentig_menu_font_weight'        => '700',
				'twentig_menu_font_size'          => '18',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
		array(
			'name'  => 'Lato + Lora',
			'image' => 'lato.png',
			'mods'  => array(
				'twentig_body_font'               => "'Lora', serif",
				'twentig_body_font_size'          => '18',
				'twentig_body_line_height'        => '1.6',
				'twentig_heading_font'            => "'Lato', sans-serif",
				'twentig_heading_font_weight'     => '700',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'heading',
				'twentig_menu_font'               => 'heading',
				'twentig_menu_font_weight'        => '400',
				'twentig_menu_font_size'          => '16',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
		array(
			'name'  => 'Roboto Slab + Roboto',
			'image' => 'roboto-slab.png',
			'mods'  => array(
				'twentig_body_font'               => "'Roboto', sans-serif",
				'twentig_body_font_size'          => '18',
				'twentig_body_line_height'        => '1.6',
				'twentig_heading_font'            => "'Roboto Slab', serif",
				'twentig_heading_font_weight'     => '700',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'body',
				'twentig_menu_font'               => 'heading',
				'twentig_menu_font_weight'        => '400',
				'twentig_menu_font_size'          => '18',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
		array(
			'name'  => 'Rubik + Rubik',
			'image' => 'rubik.png',
			'mods'  => array(
				'twentig_body_font'               => "'Rubik', sans-serif",
				'twentig_body_font_size'          => '18',
				'twentig_body_line_height'        => '1.6',
				'twentig_heading_font'            => "'Rubik', sans-serif",
				'twentig_heading_font_weight'     => '500',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'body',
				'twentig_menu_font'               => 'body',
				'twentig_menu_font_weight'        => '500',
				'twentig_menu_font_size'          => '18',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
		array(
			'name'  => 'BioRhyme + Cabin',
			'image' => 'biorhyme.png',
			'mods'  => array(
				'twentig_body_font'               => "'Cabin', sans-serif",
				'twentig_body_font_size'          => '20',
				'twentig_body_line_height'        => '1.6',
				'twentig_heading_font'            => "'BioRhyme', serif",
				'twentig_heading_font_weight'     => '400',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'body',
				'twentig_menu_font'               => 'heading',
				'twentig_menu_font_weight'        => '400',
				'twentig_menu_font_size'          => '18',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
		array(
			'name'  => 'Noto Sans Display + Noto Serif',
			'image' => 'noto-sans.png',
			'mods'  => array(
				'twentig_body_font'               => "'Noto Serif', serif",
				'twentig_body_font_size'          => '18',
				'twentig_body_line_height'        => '1.8',
				'twentig_heading_font'            => "'Noto Sans Display', sans-serif",
				'twentig_heading_font_weight'     => '700',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'heading',
				'twentig_menu_font'               => 'heading',
				'twentig_menu_font_weight'        => '400',
				'twentig_menu_font_size'          => '14',
				'twentig_menu_letter_spacing'     => '0.04',
				'twentig_menu_text_transform'     => 'uppercase',
			),
		),
		array(
			'name'  => 'PT Serif + PT Sans',
			'image' => 'pt-serif.png',
			'mods'  => array(
				'twentig_body_font'               => "'PT Sans', sans-serif",
				'twentig_body_font_size'          => '18',
				'twentig_body_line_height'        => '1.6',
				'twentig_heading_font'            => "'PT Serif', serif",
				'twentig_heading_font_weight'     => '700',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'body',
				'twentig_menu_font'               => 'heading',
				'twentig_menu_font_weight'        => '400',
				'twentig_menu_font_size'          => '18',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
		array(
			'name'  => 'IBM Plex Sans + IBM Plex Sans',
			'image' => 'ibm-plex-sans-2.png',
			'mods'  => array(
				'twentig_body_font'               => "'IBM Plex Sans', sans-serif",
				'twentig_body_font_size'          => '18',
				'twentig_body_line_height'        => '1.6',
				'twentig_heading_font'            => "'IBM Plex Sans', sans-serif",
				'twentig_heading_font_weight'     => '700',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'body',
				'twentig_menu_font'               => 'body',
				'twentig_menu_font_weight'        => '400',
				'twentig_menu_font_size'          => '18',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
		array(
			'name'  => 'Playfair Display + Lora',
			'image' => 'playfair-display-2.png',
			'mods'  => array(
				'twentig_body_font'               => "'Lora', serif",
				'twentig_body_font_size'          => '18',
				'twentig_body_line_height'        => '1.6',
				'twentig_heading_font'            => "'Playfair Display', serif",
				'twentig_heading_font_weight'     => '700',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'body',
				'twentig_menu_font'               => 'body',
				'twentig_menu_font_weight'        => '700',
				'twentig_menu_font_size'          => '14',
				'twentig_menu_letter_spacing'     => '0.04',
				'twentig_menu_text_transform'     => 'uppercase',
			),
		),
		array(
			'name'  => 'Arimo + Bitter',
			'image' => 'arimo.png',
			'mods'  => array(
				'twentig_body_font'               => "'Bitter', serif",
				'twentig_body_font_size'          => '18',
				'twentig_body_line_height'        => '1.8',
				'twentig_heading_font'            => "'Arimo', sans-serif",
				'twentig_heading_font_weight'     => '700',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'heading',
				'twentig_menu_font'               => 'heading',
				'twentig_menu_font_weight'        => '700',
				'twentig_menu_font_size'          => '16',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
		array(
			'name'  => 'Red Hat Display + Red Hat Text',
			'image' => 'red-hat-display.png',
			'mods'  => array(
				'twentig_body_font'               => "'Red Hat Text', sans-serif",
				'twentig_body_font_size'          => '18',
				'twentig_body_line_height'        => '1.6',
				'twentig_heading_font'            => "'Red Hat Display', sans-serif",
				'twentig_heading_font_weight'     => '700',
				'twentig_heading_letter_spacing'  => '0',
				'twentig_h1_font_size'            => '64',
				'twentig_secondary_elements_font' => 'body',
				'twentig_menu_font'               => 'body',
				'twentig_menu_font_weight'        => '400',
				'twentig_menu_font_size'          => '18',
				'twentig_menu_letter_spacing'     => '0',
				'twentig_menu_text_transform'     => '',
			),
		),
	);

	return $presets;
}
add_filter( 'twentig_font_presets', 'twentig_twentyone_get_font_presets' );
