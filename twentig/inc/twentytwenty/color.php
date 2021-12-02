<?php
/**
 * Theme colors
 *
 * @package twentig
 */

/**
 * Add theme elements to colors array.
 *
 * @param array $elements Array of theme elements.
 */
function twentig_get_elements_array_for_colors( $elements ) {

	$elements['header-footer']['accent']['background-color'][] = '.primary-menu .social-menu a, .footer-widgets .faux-button, .footer-widgets .wp-block-button__link, .footer-widgets input[type="submit"], #site-header ul.primary-menu li.menu-button > a, .menu-modal ul.modal-menu > li.menu-button > .ancestor-wrapper > a';
	$elements['header-footer']['background']['color'][]        = '#site-header ul.primary-menu li.menu-button > a, .menu-modal ul.modal-menu > li.menu-button > .ancestor-wrapper > a';
	$elements['header-footer']['borders']['border-color'][]    = 'body.tw-header-border:not(.overlay-header) #site-header, body.tw-header-border.has-header-opaque #site-header, .tw-footer-widgets-row .footer-widgets.column-two';

	if ( get_theme_mod( 'twentig_header_sticky' ) ) {
		$elements['header-footer']['background']['background-color'][] = 'body.has-header-opaque #site-header';
		$elements['header-footer']['text']['color'][]                  = '.has-header-opaque #site-header .header-inner';
		$elements['header-footer']['secondary']['color'][]             = 'body.has-header-opaque .site-description, body.has-header-opaque .toggle-text';
	}

	// Change color if main background and header/footer background are not the same color.
	if ( get_theme_mod( 'twentig_page_header_no_background', false ) ) {
		// Get header/footer & content background color.
		$header_footer_background = get_theme_mod( 'header_footer_background_color', '#ffffff' );
		$header_footer_background = strtolower( '#' . ltrim( $header_footer_background, '#' ) );
		$background_color         = get_theme_mod( 'background_color', 'f5efe0' );
		$background_color         = strtolower( '#' . ltrim( $background_color, '#' ) );

		if ( $background_color !== $header_footer_background ) {
			$elements['content']['accent']['color'][]    = '.tw-entry-header-no-bg.singular:not(.overlay-header) .entry-categories a';
			$elements['content']['accent']['color'][]    = '.tw-entry-header-no-bg .archive-header .color-accent';
			$elements['content']['accent']['color'][]    = '.tw-entry-header-no-bg .archive-header a';
			$elements['content']['text']['color'][]      = '.singular.tw-entry-header-no-bg .entry-header';
			$elements['content']['text']['color'][]      = '.tw-entry-header-no-bg .archive-header';
			$elements['content']['secondary']['color'][] = '.singular.tw-entry-header-no-bg .entry-header .post-meta';
		}
	}

	return $elements;
}
add_filter( 'twentytwenty_get_elements_array', 'twentig_get_elements_array_for_colors' );

/**
 * Returns CSS generated for the footer colors.
 */
function twentig_get_footer_colors_css() {

	$footer_elements = array(
		'accent'     => array(
			'color'      => array(),
			'background' => array( '.footer-nav-widgets-wrapper .button', '.footer-nav-widgets-wrapper .faux-button', '.footer-nav-widgets-wrapper .wp-block-button__link', '.footer-nav-widgets-wrapper input[type="submit"]' ),
		),
		'background' => array(
			'color'      => array( '.footer-top .social-icons a', '#site-footer .social-icons a', '.footer-nav-widgets-wrapper button', '.footer-nav-widgets-wrapper .faux-button', '.footer-nav-widgets-wrapper .wp-block-button__link', '.footer-nav-widgets-wrapper input[type="submit"]' ),
			'background' => array( '.footer-nav-widgets-wrapper', '#site-footer' ),
		),
		'text'       => array(
			'color' => array( '#site-footer', '.footer-nav-widgets-wrapper' ),
		),
		'secondary'  => array(
			'color' => array( '.footer-nav-widgets-wrapper .widget .post-date', '.footer-nav-widgets-wrapper .widget .rss-date', '.footer-nav-widgets-wrapper .widget_archive li', '.footer-nav-widgets-wrapper .widget_categories li', '.footer-nav-widgets-wrapper .widget_pages li', '.footer-nav-widgets-wrapper .widget_nav_menu li', '.powered-by-wordpress', '.to-the-top' ),
		),
		'borders'    => array(
			'border-color' => array( '.footer-nav-widgets-wrapper', '#site-footer', '.footer-widgets-outer-wrapper', '.footer-top', '.tw-footer-widgets-row .footer-widgets.column-two', '.footer-nav-widgets-wrapper input' ),
		),
	);

	$footer_link_color    = get_theme_mod( 'twentig_footer_link_color' );
	$selector_link_footer = '.footer-widgets a, .footer-menu a';
	if ( 'text' === $footer_link_color ) {
		$footer_elements['text']['color'][] = $selector_link_footer;
	} elseif ( 'secondary' === $footer_link_color ) {
		$footer_elements['secondary']['color'][] = $selector_link_footer;
	} else {
		$footer_elements['accent']['color'][] = $selector_link_footer;
	}

	$colors_settings = get_theme_mod( 'twentig_accessible_colors' );

	ob_start();

	if ( isset( $colors_settings['footer'] ) ) {
		foreach ( $footer_elements as $key => $definitions ) {
			foreach ( $definitions as $property => $elements ) {
				if ( isset( $colors_settings['footer'][ $key ] ) ) {
					$val = $colors_settings['footer'][ $key ];
					twentytwenty_generate_css( implode( ',', $elements ), $property, $val );
				}
			}
		}
	}

	return ob_get_clean();
}

/**
 * Set the value of the accent color to the hexadecimal value for the theme element colors.
 *
 * @param array $value Array holding the colors derived from the accent hue.
 */
function twentig_filter_colors( $value ) {
	$hex = get_theme_mod( 'twentig_accent_hex_color' );
	if ( $hex && 'hex' === get_theme_mod( 'accent_hue_active' ) && is_array( $value ) && ! empty( $value ) ) {
		$value['content']['accent']       = sanitize_hex_color( $hex );
		$value['header-footer']['accent'] = sanitize_hex_color( $hex );
	}
	return $value;
}
add_filter( 'theme_mod_accent_accessible_colors', 'twentig_filter_colors' );

/**
 * Set the value of the accent color to the hexadecimal value for the footer colors.
 *
 * @param array $value Array holding the colors derived from the accent hue.
 */
function twentig_filter_footer_colors( $value ) {
	$hex = get_theme_mod( 'twentig_accent_hex_color' );
	if ( $hex && 'hex' === get_theme_mod( 'accent_hue_active' ) && is_array( $value ) && ! empty( $value ) ) {
		$value['footer']['accent'] = sanitize_hex_color( $hex );
	}
	return $value;
}
add_filter( 'theme_mod_twentig_accessible_colors', 'twentig_filter_footer_colors' );
