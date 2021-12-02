<?php
/**
 * Theme colors
 *
 * @package twentig
 */

/**
 * Generates the color CSS variables.
 */
function twentig_twentyone_generate_color_variables() {
	$colors = array(
		array( 'twentig_primary_color', '--global--color-primary' ),
		array( 'twentig_primary_color', '--global--color-secondary' ),
		array( 'twentig_content_link_color', '--content--color--link' ),
		array( 'twentig_header_background_color', '--header--color-background' ),
		array( 'twentig_branding_color', '--branding--color-text' ),
		array( 'twentig_header_link_color', '--header--color-text' ),
		array( 'twentig_header_link_hover_color', '--header--color-link-hover' ),
		array( 'twentig_footer_background_color', '--footer--color-background' ),
		array( 'twentig_footer_text_color', '--footer--color-text' ),
		array( 'twentig_footer_text_color', '--footer--color-link' ),
		array( 'twentig_footer_text_color', '--footer--color-link-hover' ),
		array( 'twentig_footer_link_color', '--footer--color-link' ),
		array( 'twentig_footer_link_color', '--footer--color-link-hover' ),
		array( 'twentig_widgets_background_color', '--widgets--color-background' ),
		array( 'twentig_widgets_text_color', '--widgets--color-text' ),
		array( 'twentig_widgets_link_color', '--widgets--color-link' ),
	);

	$colors =  apply_filters( 'twentig_twentyone_color_variables', $colors );

	$theme_css = '';

	foreach ( $colors as $color ) {
		$custom_color = get_theme_mod( "$color[0]" );
		if ( $custom_color ) {
			$theme_css .= "$color[1]" . ':' . $custom_color . ';';
		}
	}

	return $theme_css;
}

/**
 * Detects the site theme color according to the body background color.
 */
function twentig_twentyone_is_light_theme() {
	$background_color = get_theme_mod( 'background_color', 'D1E4DD' );
	if ( 127 < Twenty_Twenty_One_Custom_Colors::get_relative_luminance_from_hex( $background_color ) ) {
		return true;
	}
	return false;
}
