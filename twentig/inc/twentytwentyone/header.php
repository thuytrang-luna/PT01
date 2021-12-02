<?php
/**
 * Header
 *
 * @package twentig
 */

/**
 * Displays transparent logo on Hero Cover & Header Transparent template.
 *
 * @param string $html Custom logo HTML output.
 */
function twentig_twentyone_logo_transparent( $html ) {

	$custom_logo_id             = get_theme_mod( 'custom_logo' );
	$custom_logo_transparent_id = get_theme_mod( 'twentig_custom_logo_alt' );
	$header_sticky              = get_theme_mod( 'twentig_header_sticky' );
	$is_transparent             = false;

	if ( ! $custom_logo_id || ! $custom_logo_transparent_id ) {
		return $html;
	}

	if ( is_page_template( 'tw-header-transparent-light.php' ) ) {
		$is_transparent = true;
	} elseif ( is_singular() && ! is_page_template() ) {
		$post_type   = get_post_type();
		$hero_layout = get_theme_mod( 'twentig_' . $post_type . '_hero_layout' );
		if ( false === $hero_layout && twentig_twentyone_is_cpt_single() ) {
			$cpt_layout = get_theme_mod( 'twentig_cpt_single_layout' );
			if ( $cpt_layout ) {
				$hero_layout = get_theme_mod( 'twentig_' . $cpt_layout . '_hero_layout' );
			}
		}
		if ( false !== strpos( $hero_layout, 'cover' ) && has_post_thumbnail() ) {
			$is_transparent = true;
		}
	}

	if ( $is_transparent ) {
		$custom_logo_attr = array(
			'class'   => 'custom-logo',
			'loading' => false,
		);

		$unlink_homepage_logo = (bool) get_theme_support( 'custom-logo', 'unlink-homepage-logo' );

		if ( $unlink_homepage_logo && is_front_page() && ! is_paged() ) {
			$custom_logo_attr['alt'] = '';
		} else {
			$image_alt = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );
			if ( empty( $image_alt ) ) {
				$custom_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
			}
		}

		$custom_logo_transparent_attr = $custom_logo_attr;

		if ( $header_sticky ) {
			$custom_logo_attr['class']             = 'custom-logo logo-primary';
			$custom_logo_transparent_attr['class'] = 'custom-logo logo-transparent';
		}

		$image             = wp_get_attachment_image( $custom_logo_id, 'full', false, $custom_logo_attr );
		$image_transparent = wp_get_attachment_image( $custom_logo_transparent_id, 'full', false, $custom_logo_transparent_attr );
		$logo_output       = $header_sticky ? $image . ' ' . $image_transparent : $image_transparent;

		if ( $unlink_homepage_logo && is_front_page() && ! is_paged() ) {
			$html = sprintf(
				'<span class="custom-logo-link">%1$s</span>',
				$logo_output
			);
		} else {
			$aria_current = is_front_page() && ! is_paged() ? ' aria-current="page"' : '';

			$html = sprintf(
				'<a href="%1$s" class="custom-logo-link" rel="home"%2$s>%3$s</a>',
				esc_url( home_url( '/' ) ),
				$aria_current,
				$logo_output
			);
		}
	}

	remove_filter( 'get_custom_logo', 'twentig_twentyone_logo_transparent' );
	return $html;
}
add_filter( 'get_custom_logo', 'twentig_twentyone_logo_transparent' );

/**
 * Hide the tagline by returning an empty string.
 *
 * @param mixed  $output The requested non-URL site information.
 * @param string $show   Type of information requested.
 */
function twentig_twentyone_hide_tagline( $output, $show ) {
	if ( get_theme_mod( 'twentig_hide_tagline', false ) && 'description' === $show ) {
		return '';
	}
	return $output;
}
add_filter( 'bloginfo', 'twentig_twentyone_hide_tagline', 10, 2 );

require_once TWENTIG_PATH . 'inc/twentytwentyone/class-twentig-nav-menu.php';
new Twentig_Nav_Menu();
