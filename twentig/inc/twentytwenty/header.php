<?php
/**
 * Header
 *
 * @package twentig
 */

/**
 * Displays transparent logo on Cover & Transparent Header templates.
 *
 * @param string $html Custom logo HTML output.
 */
function twentig_logo_transparent( $html ) {

	$custom_logo_id             = get_theme_mod( 'custom_logo' );
	$custom_logo_transparent_id = get_theme_mod( 'twentig_custom_logo_transparent' );

	if ( ! $custom_logo_id || ! $custom_logo_transparent_id ) {
		return $html;
	}

	// We have a logo. Logo is go.
	if ( is_page_template( array( 'templates/template-cover.php', 'tw-header-transparent-light.php' ) ) ) {
		$custom_logo_attr = array(
			'class' => 'custom-logo',
		);

		$image_alt = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );
		if ( empty( $image_alt ) ) {
			$custom_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
		}

		if ( get_theme_mod( 'twentig_header_sticky' ) ) {
			$custom_logo_attr['class']             = 'custom-logo logo-primary';
			$custom_logo_transparent_attr          = $custom_logo_attr;
			$custom_logo_transparent_attr['class'] = 'custom-logo logo-transparent';

			$html = sprintf(
				'<a href="%1$s" class="custom-logo-link" rel="home">%2$s</a>',
				esc_url( home_url( '/' ) ),
				wp_get_attachment_image( $custom_logo_id, 'full', false, $custom_logo_attr ) . ' ' .
				wp_get_attachment_image( $custom_logo_transparent_id, 'full', false, $custom_logo_transparent_attr )
			);
		} else {
			$html = sprintf(
				'<a href="%1$s" class="custom-logo-link" rel="home">%2$s</a>',
				esc_url( home_url( '/' ) ),
				wp_get_attachment_image( $custom_logo_transparent_id, 'full', false, $custom_logo_attr )
			);
		}
	}

	return $html;
}
add_filter( 'get_custom_logo', 'twentig_logo_transparent', 0 );

/**
 * Hide the tagline by returning an empty string.
 *
 * @param string $html  The HTML for the site description.
 */
function twentig_twentytenty_hide_tagline( $html ) {
	if ( ! get_theme_mod( 'twentig_header_tagline', true ) ) {
		return '';
	}
	return $html;
}
add_filter( 'twentytwenty_site_description', 'twentig_twentytenty_hide_tagline' );

/**
 * Determines if social icons should be displayed in the location.
 *
 * @param string $location Social location identifier.
 */
function twentig_twentytwenty_is_socials_location( $location ) {
	$locations = get_theme_mod( 'twentig_socials_location', array( 'modal-desktop', 'modal-mobile', 'footer' ) );
	return in_array( $location, $locations, true );
}

/**
 * Adds social links in the primary menu.
 *
 * @param string   $items The HTML list content for the menu items.
 * @param stdClass $args  An object containing wp_nav_menu() arguments.
 */
function twentig_twentytenty_nav_menu_social_icons( $items, $args ) {
	if ( 'primary' === $args->theme_location && has_nav_menu( 'social' ) && twentig_twentytwenty_is_socials_location( 'primary-menu' ) ) {
		$items = $items . '<li class="menu-item-socials"><ul class="social-menu reset-list-style social-icons fill-children-current-color">' .
			wp_nav_menu(
				array(
					'echo'            => false,
					'theme_location'  => 'social',
					'container'       => '',
					'container_class' => '',
					'items_wrap'      => '%3$s',
					'menu_id'         => '',
					'menu_class'      => '',
					'depth'           => 1,
					'link_before'     => '<span class="screen-reader-text">',
					'link_after'      => '</span>',
					'fallback_cb'     => '',
				)
			) . '</ul></li>';
	}

	return $items;
}
add_filter( 'wp_nav_menu_items', 'twentig_twentytenty_nav_menu_social_icons', 20, 2 );

/**
 * Disable the social icons menu inside the modal menu depending on the Customizer setting.
 */
function twentig_twentytenty_modal_menu() {
	remove_filter( 'wp_nav_menu_items', 'twentig_nav_menu_social_icons', 20 );
	if ( ! twentig_twentytwenty_is_socials_location( 'modal-mobile' ) && ! twentig_twentytwenty_is_socials_location( 'modal-desktop' ) ) {
		add_filter( 'has_nav_menu', 'twentig_twentytwenty_disable_socials', 10, 2 );
	}
}
add_action( 'get_template_part_template-parts/modal-menu', 'twentig_twentytenty_modal_menu', 10, 2 );

/**
 * Disable social icons menu for a given location.
 *
 * @param bool   $has_nav_menu Whether there is a social menu assigned to a location.
 * @param string $location     Social menu location.
 */
function twentig_twentytwenty_disable_socials( $has_nav_menu, $location ) {
	if ( 'social' === $location ) {
		return false;
	}
	return $has_nav_menu;
}

/**
 * Add support for excerpt to page.
 */
function twentig_twentytenty_support_page_excerpt() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'twentig_twentytenty_support_page_excerpt' );

/**
 * Set template for page cover with excerpt.
 *
 * @param string $template The path of the template to include.
 */
function twentig_twentytenty_page_cover_excerpt( $template ) {
	if ( is_page_template( 'templates/template-cover.php' ) && is_page() && has_excerpt() ) {
		return TWENTIG_PATH . 'inc/twentytwenty/templates/template-cover.php';
	}
	return $template;
}
add_filter( 'template_include', 'twentig_twentytenty_page_cover_excerpt' );
