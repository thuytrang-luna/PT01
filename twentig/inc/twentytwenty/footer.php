<?php
/**
 * Footer
 *
 * @package twentig
 */

/**
 * Add support for blocks inside widgets.
 */
function twentig_twentytwenty_support_widget_block() {
	add_filter( 'widget_text', 'do_blocks', 9 );
}
add_action( 'init', 'twentig_twentytwenty_support_widget_block' );

/**
 * Changes the footer "menu widgets" area based on selected layout.
 */
function twentig_footer_menu_widgets() {
	$footer_layout = get_theme_mod( 'twentig_footer_layout' );
	if ( $footer_layout ) {
		add_filter( 'has_nav_menu', 'twentig_disable_top_footer_menus', 10, 2 );
	} else {
		if ( twentig_twentytwenty_is_socials_location( 'footer' ) ) {
			remove_filter( 'has_nav_menu', 'twentig_twentytwenty_disable_socials' );
		} else {
			add_filter( 'has_nav_menu', 'twentig_twentytwenty_disable_socials', 10, 2 );
		}
	}
}
add_action( 'get_template_part_template-parts/footer-menus-widgets', 'twentig_footer_menu_widgets' );

/**
 * Disables default top footer menus.
 *
 * @param bool   $has_nav_menu Whether there is a menu assigned to a location.
 * @param string $location     Menu location.
 */
function twentig_disable_top_footer_menus( $has_nav_menu, $location ) {
	if ( 'footer' === $location || 'social' === $location ) {
		return false;
	}
	return $has_nav_menu;
}

/**
 * Displays custom footer based on Customizer settings.
 *
 * @param string|null $name Name of the specific footer file to use. null for the default footer.
 */
function twentig_get_footer( $name = null ) {

	$footer_layout = get_theme_mod( 'twentig_footer_layout' );
	$footer_credit = get_theme_mod( 'twentig_footer_credit' );
	$credit_text   = get_theme_mod( 'twentig_footer_credit_text' );

	if ( '' == $footer_credit && '' == $footer_layout ) {
		return;
	}

	if ( twentig_twentytwenty_footer_exists( $name ) ) {
		return;
	}

	if ( 'hidden' !== $footer_layout ) : ?>

		<?php if ( 'custom' === $footer_layout ) : ?>
			<footer id="site-footer" role="contentinfo" class="footer-custom header-footer-group">
			<?php
				$block_id = get_theme_mod( 'twentig_footer_content' );
				twentig_render_reusable_block( $block_id );
			?>
			</footer>
		<?php else : ?>
			<footer id="site-footer" role="contentinfo" class="header-footer-group">

				<?php if ( in_array( $footer_layout, array( 'inline-left', 'inline-right', 'inline-center' ), true ) ) : ?>
					<div class="section-inner footer-inline footer-<?php echo esc_attr( $footer_layout ); ?>">

						<?php twentig_get_footer_credits(); ?>
						<?php twentig_get_footer_menu(); ?>
						<?php twentig_get_footer_social_menu(); ?>			

					</div><!-- .section-inner -->

				<?php elseif ( 'stack' === $footer_layout ) : ?>

					<div class="section-inner footer-stack">

						<?php twentig_get_footer_social_menu(); ?>
						<?php twentig_get_footer_menu(); ?>
						<?php twentig_get_footer_credits(); ?>

					</div><!-- .section-inner -->

				<?php else : ?>

					<div class="section-inner">

						<?php twentig_get_footer_credits(); ?>

						<a class="to-the-top" href="#site-header">
							<span class="to-the-top-long">
								<?php
								/* translators: %s: HTML character for up arrow */
								printf( __( 'To the top %s', 'twentytwenty' ), '<span class="arrow" aria-hidden="true">&uarr;</span>' );
								?>
							</span>
							<span class="to-the-top-short">
								<?php
								/* translators: %s: HTML character for up arrow */
								printf( __( 'Up %s', 'twentytwenty' ), '<span class="arrow" aria-hidden="true">&uarr;</span>' );
								?>
							</span>
						</a><!-- .to-the-top -->

					</div><!-- .section-inner -->

				<?php endif; ?>	

			</footer><!-- #site-footer -->
		<?php endif; ?>

	<?php elseif ( in_array( 'footer-top-hidden', get_body_class(), true ) ) : ?>
		<div id="footer-placeholder"></div>
	<?php endif; ?>

	<?php wp_footer(); ?>

	</body>
</html>

	<?php
	$templates = array( 'footer.php' );

	ob_start();
	locate_template( $templates, true );
	ob_get_clean();
}
add_action( 'get_footer', 'twentig_get_footer', 9 );

/**
 * Determines whether the given footer template name exists.
 *
 * @param string|null $name Name of the specific footer file.
 */
function twentig_twentytwenty_footer_exists( $name ) {
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
 * Determines whether a registered nav menu location inside the footer has a menu assigned to it.
 * Rewrites the 'has_nav_menu' function to avoid the 'has_nav_menu' filter.
 *
 * @param string $location Menu location identifier.
 */
function twentig_footer_has_nav_menu( $location ) {
	$has_nav_menu = false;

	$registered_nav_menus = get_registered_nav_menus();
	if ( isset( $registered_nav_menus[ $location ] ) ) {
		$locations    = get_nav_menu_locations();
		$has_nav_menu = ! empty( $locations[ $location ] );
	}

	return $has_nav_menu;
}

/**
 * Displays footer menu.
 */
function twentig_get_footer_menu() {

	if ( twentig_footer_has_nav_menu( 'footer' ) ) {
		?>

		<nav aria-label="<?php esc_attr_e( 'Footer', 'twentytwenty' ); ?>" role="navigation" class="footer-menu-wrapper">

			<ul class="footer-menu reset-list-style">
				<?php
					wp_nav_menu(
						array(
							'container'      => '',
							'depth'          => 1,
							'items_wrap'     => '%3$s',
							'theme_location' => 'footer',
						)
					);
				?>
			</ul>

		</nav>
		<?php
	}
}

/**
 * Displays footer social menu.
 */
function twentig_get_footer_social_menu() {

	if ( twentig_footer_has_nav_menu( 'social' ) && twentig_twentytwenty_is_socials_location( 'footer' ) ) {
		?>

		<nav aria-label="<?php esc_attr_e( 'Social links', 'twentytwenty' ); ?>" class="footer-social-wrapper">

			<ul class="social-menu footer-social reset-list-style social-icons fill-children-current-color">

				<?php
					wp_nav_menu(
						array(
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
					);
				?>

			</ul>

		</nav>
		<?php
	}
}

/**
 * Displays footer credits.
 */
function twentig_get_footer_credits() {

	$footer_credit = get_theme_mod( 'twentig_footer_credit' );
	$credit_text   = get_theme_mod( 'twentig_footer_credit_text' );

	if ( 'none' !== $footer_credit ) :
		?>

	<div class="footer-credits">			

		<p class="footer-copyright">
		<?php if ( 'custom' === $footer_credit && $credit_text ) { ?>
			<?php echo do_shortcode( twentig_twentytwenty_sanitize_credit( str_replace( '[Y]', date_i18n( 'Y' ), $credit_text ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<?php } else { ?>
			&copy;
			<?php
			echo date_i18n(
				/* translators: Copyright date format, see https://secure.php.net/date */
				_x( 'Y', 'copyright date format', 'twentytwenty' )
			);
			?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo bloginfo( 'name' ); ?></a>			
		<?php } ?>
		</p>

		<?php if ( '' === $footer_credit ) { ?>
			<p class="powered-by-wordpress">
				<a href="<?php echo esc_url( 'https://wordpress.org/' ); ?>">
					<?php esc_html_e( 'Powered by WordPress', 'twentytwenty' ); ?>
				</a>
			</p>
		<?php } ?>

	</div><!-- .footer-credits -->

	<?php endif; ?>

	<?php
}
