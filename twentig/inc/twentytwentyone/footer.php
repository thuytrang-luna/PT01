<?php
/**
 * Footer
 *
 * @package twentig
 */

/**
 * Renders the "white logo" for dark background footer.
 *
 * @param string $mods_name The value of the current theme modification.
 */
function twentig_twentyone_footer_logo( $mods_name ) {

	$custom_logo_transparent_id = get_theme_mod( 'twentig_custom_logo_alt' );
	if ( ! $custom_logo_transparent_id ) {
		return $mods_name;
	}

	$footer_bg = get_theme_mod( 'twentig_footer_background_color' );

	if ( empty( $footer_bg ) ) {
		$footer_bg = get_theme_mod( 'background_color', 'D1E4DD' );
		if ( get_theme_mod( 'twentig_site_width' ) ) {
			$footer_bg = get_theme_mod( 'twentig_inner_background_color', $footer_bg );
		}
	}

	if ( 127 > Twenty_Twenty_One_Custom_Colors::get_relative_luminance_from_hex( $footer_bg ) ) {
		return $custom_logo_transparent_id;
	}

	return $mods_name;
}

/**
 * Displays custom footer based on Customizer settings.
 *
 * @param string|null $name Name of the specific footer file to use. null for the default footer.
 */
function twentig_twentyone_get_footer( $name = null ) {

	if ( get_theme_mod( 'custom_logo' ) ) {
		add_filter( 'theme_mod_custom_logo', 'twentig_twentyone_footer_logo' );
	}

	if ( ! get_theme_mod( 'twentig_footer_social_icons', true ) ) {
		remove_filter( 'walker_nav_menu_start_el', 'twenty_twenty_one_nav_menu_social_icons', 10, 4 );
	}

	remove_filter( 'walker_nav_menu_start_el', 'twenty_twenty_one_add_sub_menu_toggle', 10, 4 );
	twentig_twentyone_remove_image_inline_size_style();

	$footer_layout   = get_theme_mod( 'twentig_footer_layout' );
	$footer_branding = get_theme_mod( 'twentig_footer_branding', true );
	$footer_credit   = get_theme_mod( 'twentig_footer_credit' );
	$has_sidebar     = twentig_twentyone_has_sidebar();

	if ( empty( $footer_credit ) && empty( $footer_layout ) && ! $has_sidebar && $footer_branding ) {
		return;
	}

	if ( twentig_twentyone_footer_exists( $name ) ) {
		return;
	}

	?>

			</main><!-- #main -->

			<?php if ( $has_sidebar ) : ?>
				<aside class="blog-sidebar">
					<?php dynamic_sidebar( 'sidebar-blog' ); ?>
				</aside> 
			<?php endif; ?>

			</div><!-- #primary -->
	</div><!-- #content -->

	<?php get_template_part( 'template-parts/footer/footer-widgets' ); ?>

	<?php

	if ( 'hidden' !== $footer_layout ) :
		$extra_class = '';
		if ( $footer_layout ) {
			$extra_class .= ' footer-' . $footer_layout;
		}
		?>
		<footer id="colophon" class="site-footer<?php echo esc_attr( $extra_class ); ?>" role="contentinfo">
			<?php if ( 'inline' === $footer_layout ) : ?>
				<div class="site-info">
					<?php twentig_twentyone_get_footer_branding(); ?>
					<?php twentig_twentyone_get_footer_credits(); ?>
					<?php twentig_twentyone_get_footer_menu(); ?>			
				</div><!-- .site-info -->
			<?php elseif ( 'stack' === $footer_layout ) : ?>
				<div class="site-info">
					<?php twentig_twentyone_get_footer_branding(); ?>
					<?php twentig_twentyone_get_footer_menu(); ?>
					<?php twentig_twentyone_get_footer_credits(); ?>
				</div><!-- .site-info -->
			<?php elseif ( 'custom' === $footer_layout ) :
				remove_filter( 'the_content', '__return_empty_string' );
				$block_id = get_theme_mod( 'twentig_footer_content' );
				twentig_render_reusable_block( $block_id );
				?>
			<?php else : ?>
				<?php twentig_twentyone_get_footer_menu(); ?>
				<div class="site-info">
					<?php twentig_twentyone_get_footer_branding(); ?>
					<?php twentig_twentyone_get_footer_credits(); ?>
				</div><!-- .site-info -->			
			<?php endif; ?>	
		</footer><!-- #site-footer -->

	<?php endif; ?>

	</div><!-- #page -->

	<?php wp_footer(); ?>

</body>
</html>

	<?php
	$templates = array( 'footer.php' );
	ob_start();
	locate_template( $templates, true );
	ob_get_clean();
}
add_action( 'get_footer', 'twentig_twentyone_get_footer', 9 );

/**
 * Determines whether the given footer template name exists.
 *
 * @param string|null $name Name of the specific footer file.
 */
function twentig_twentyone_footer_exists( $name ) {
	if ( null === $name ) {
		return false;
	}

	$template_name = "footer-{$name}.php";
	if ( 'embed' === $name || file_exists( STYLESHEETPATH . '/' . $template_name ) || file_exists( TEMPLATEPATH . '/' . $template_name ) ) {
		return true;
	}
	return false;
}

/**
 * Displays footer branding.
 */
function twentig_twentyone_get_footer_branding() {
	if ( get_theme_mod( 'twentig_footer_branding', true ) ) :
		?>
		<div class="site-name">
			<?php if ( has_custom_logo() ) : ?>
				<div class="site-logo"><?php the_custom_logo(); ?></div>
			<?php else : ?>
				<?php if ( get_bloginfo( 'name' ) && get_theme_mod( 'display_title_and_tagline', true ) ) : ?>
					<?php if ( is_front_page() && ! is_paged() ) : ?>
						<?php bloginfo( 'name' ); ?>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
					<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>
		</div>
		<?php
	endif;
}

/**
 * Displays footer menu.
 */
function twentig_twentyone_get_footer_menu() {
	if ( has_nav_menu( 'footer' ) ) :
		?>
		<nav aria-label="<?php esc_attr_e( 'Secondary menu', 'twentytwentyone' ); ?>" class="footer-navigation">
			<ul class="footer-navigation-wrapper">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'items_wrap'     => '%3$s',
						'container'      => false,
						'depth'          => 1,
						'link_before'    => '<span>',
						'link_after'     => '</span>',
						'fallback_cb'    => false,
					)
				);
				?>
			</ul><!-- .footer-navigation-wrapper -->
		</nav><!-- .footer-navigation -->
		<?php
	endif;
}

/**
 * Displays footer credits.
 */
function twentig_twentyone_get_footer_credits() {

	$footer_credit = get_theme_mod( 'twentig_footer_credit' );
	$credit_text   = get_theme_mod( 'twentig_footer_credit_text' );

	if ( 'none' !== $footer_credit ) :
		?>

		<div class="powered-by">
			<?php if ( 'custom' === $footer_credit && $credit_text ) : ?>
				<?php echo do_shortcode( wp_kses_post( str_replace( '[Y]', date_i18n( 'Y' ), $credit_text ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php else : ?>
				<?php
				printf(
					/* translators: %s: WordPress. */
					esc_html__( 'Proudly powered by %s.', 'twentytwentyone' ),
					'<a href="' . esc_url( __( 'https://wordpress.org/', 'twentytwentyone' ) ) . '">WordPress</a>'
				);
				?>
			<?php endif; ?>				
		</div>
		<?php
	endif;
}

/**
 * Add a social-item class to help styling.
 *
 * @param array    $menu_items The menu items, sorted by each menu item's menu order.
 * @param stdClass $args       An object containing wp_nav_menu() arguments.
 */
function twentig_twentyone_wp_nav_menu_objects_footer( $menu_items, $args ) {

	if ( 'footer' === $args->theme_location && get_theme_mod( 'twentig_footer_social_icons', true ) ) {
		foreach ( $menu_items as $index => &$item ) {
			$svg = twenty_twenty_one_get_social_link_svg( $item->url );
			if ( ! empty( $svg ) ) {
				$item->classes[] = 'social-item';
			}
		}
	}
	return $menu_items;
}
add_filter( 'wp_nav_menu_objects', 'twentig_twentyone_wp_nav_menu_objects_footer', 10, 2 );

/**
 * Add support for blocks inside widgets.
 */
function twentig_twentyone_support_widget_block() {
	add_filter( 'widget_text', 'do_blocks', 9 );
}
add_action( 'init', 'twentig_twentyone_support_widget_block' );

/**
 * Detect if custom built footer has background.
 */
function twentig_twentyone_has_footer_block_background() {

	$footer_layout = get_theme_mod( 'twentig_footer_layout' );

	if ( 'custom' !== $footer_layout ) {
		return false;
	}

	$block_id       = get_theme_mod( 'twentig_footer_content' );
	$reusable_block = get_post( $block_id );

	if ( $reusable_block ) {
		$blocks = parse_blocks( $reusable_block->post_content );

		if ( isset( $blocks[0] ) ) {
			if ( 'core/group' === $blocks[0]['blockName'] && isset( $blocks[0]['innerHTML'] ) && false !== strpos( $blocks[0]['innerHTML'], 'has-background' ) ) {
				return true;
			}
			if ( 'core/cover' === $blocks[0]['blockName'] ) {
				return true;
			}
		}
	}

	return false;
}

/**
 * Add script to fix anchor tag that toggle the burger menu.
 */
function twentig_twentyone_add_footer_script() {
	if ( twentig_is_amp_endpoint() ) {
		return;
	}
	?>
	<script>
	(function() {
		document.addEventListener( 'click', function( event ) {
			if ( event.target.hash && event.target.hash.includes( '#' ) && ! document.getElementById( 'site-navigation' ).contains( event.target ) ) {
				var mobileButton = document.getElementById( 'primary-mobile-menu' );
				twentytwentyoneToggleAriaExpanded( mobileButton );
			}
		} );
	})();
	</script>
	<?php
}
add_action( 'wp_footer', 'twentig_twentyone_add_footer_script' );
