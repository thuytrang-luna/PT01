<?php
/**
 * Twentig Dashboard.
 *
 * @package twentig
 */

/**
 * Adds a new wp-admin menu page for the Twentig.
 */
function twentig_menu_page() {

	add_menu_page(
		'Twentig',
		'Twentig',
		'edit_pages',
		'twentig',
		'twentig_render_menu_page',
		'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyMCAyMCI+PHBhdGggZmlsbD0iYmxhY2siIGQ9Ik0yMCA1LjUzOXEtLjAwMi0uMzAyLS4wMS0uNjAzYTguNzI1IDguNzI1IDAgMDAtLjExNS0xLjMxMyA0LjQzNiA0LjQzNiAwIDAwLS40MTItMS4yNUE0LjIgNC4yIDAgMDAxNy42MjcuNTM3IDQuNDUyIDQuNDUyIDAgMDAxNi4zOC4xMjUgOC43MjUgOC43MjUgMCAwMDE1LjA2NC4wMXEtLjMtLjAwOC0uNjAzLS4wMUg1LjU0cS0uMzAyLjAwMi0uNjA0LjAxYTguODI3IDguODI3IDAgMDAtMS4zMTMuMTE1IDQuNDQ0IDQuNDQ0IDAgMDAtMS4yNDguNDEyQTQuMiA0LjIgMCAwMC41MzggMi4zNzNhNC40MjIgNC40MjIgMCAwMC0uNDEyIDEuMjVBOC42MDQgOC42MDQgMCAwMC4wMSA0LjkzNXEtLjAwNy4zMDItLjAwOC42MDRDMCA1Ljc3OSAwIDYuMDE3IDAgNi4yNTZ2Ny40ODhjMCAuMjM5IDAgLjQ3Ny4wMDIuNzE2IDAgLjIwMS4wMDMuNDAzLjAwOC42MDRhOC43ODQgOC43ODQgMCAwMC4xMTYgMS4zMTMgNC40MzEgNC40MzEgMCAwMC40MTIgMS4yNSA0LjIgNC4yIDAgMDAxLjgzNiAxLjgzNSA0LjQyOSA0LjQyOSAwIDAwMS4yNDguNDEzIDguNzE1IDguNzE1IDAgMDAxLjMxNC4xMTVxLjMwMS4wMDguNjAzLjAxaDguMjA1bC43MTctLjAwMnEuMzAyIDAgLjYwMy0uMDA5YTguNzI0IDguNzI0IDAgMDAxLjMxNS0uMTE1IDQuNDI2IDQuNDI2IDAgMDAxLjI0OC0uNDEyIDQuMiA0LjIgMCAwMDEuODM2LTEuODM2IDQuNDE3IDQuNDE3IDAgMDAuNDEyLTEuMjQ5IDguNzM1IDguNzM1IDAgMDAuMTE1LTEuMzEzYy4wMDUtLjIwMS4wMDgtLjQwMy4wMS0uNjA0VjUuODQyek0xNS4xMTMgMTRoLTEuMkwxMi4zNSA5LjcyNyAxMC43ODcgMTRIOS42TDcuNzMxIDguODM3SDUuMjY0djIuNjI5YTEuMTYgMS4xNiAwIDAwMS4yIDEuMjI2IDIuMDM4IDIuMDM4IDAgMDAuNTEyLS4wOGwuMDggMS4zMmExLjkyNiAxLjkyNiAwIDAxLS44MDguMTYyIDIuMzUgMi4zNSAwIDAxLTIuNDgtMi41NlY4LjgzNkgyLjVWNy40MDhoMS4yNjdWNS42NDJoMS40OTd2MS43NjZoMy41NTRsMS4zODkgNC4yNzMgMS41MzctNC4yNzNoMS4yMTNsMS41NSA0LjI3MyAxLjM4OS00LjI3M0gxNy41eiIvPjwvc3ZnPg=='
	);

	add_submenu_page(
		'twentig',
		esc_html__( 'Twentig Home', 'twentig' ),
		esc_html__( 'Home', 'twentig' ),
		'edit_pages',
		'twentig',
		'twentig_render_menu_page'
	);

	add_submenu_page(
		'twentig',
		esc_html__( 'Twentig Settings', 'twentig' ),
		esc_html__( 'Settings', 'twentig' ),
		'manage_options',
		'twentig-settings',
		'twentig_render_settings_page'
	);
}
add_action( 'admin_menu', 'twentig_menu_page' );

/**
 * Renders Twentig dashboard page.
 */
function twentig_render_menu_page() {

	$theme         = get_template();
	$default_theme = 'twentytwenty' !== $theme && 'twentytwentyone' !== $theme ? false : true;
	?>

	<div class="tw-about__container">

		<div class="tw-about__section hero-section">
			<img src="<?php echo esc_url( TWENTIG_ASSETS_URI . '/images/welcome/rocket.png' ); ?>" width="80" height="80" alt="" />
			<h1>
				<?php esc_html_e( 'Welcome to Twentig', 'twentig' ); ?>
			</h1>
			<?php if ( ! $default_theme ) : ?>
				<p>
					<?php esc_html_e( 'Twentig helps you customize the default theme and build pages easily. To take full advantage of Twentig, we recommend that you use the Twenty Twenty-One theme.', 'twentig' ); ?>
				</p>
				<p>
					<?php
					if ( current_user_can( 'switch_themes' ) ) :
						$installed_themes = search_theme_directories();
						if ( in_array( 'twentytwentyone', array_keys( $installed_themes ), true ) ) {
							$install_url = wp_nonce_url( admin_url( 'themes.php?action=activate&amp;stylesheet=twentytwentyone' ), 'switch-theme_twentytwentyone' );
							printf( '<a href="%s" class="button button-primary">%s</a>', esc_url( $install_url ), esc_html__( 'Activate Twenty Twenty-One', 'twentig' ) );
						} else {
							$install_url = admin_url( 'theme-install.php?search=twentytwentyone' );
							printf( '<a href="%s" class="button button-primary">%s</a>', esc_url( $install_url ), esc_html__( 'Install Twenty Twenty-One', 'twentig' ) );
						}
					endif;
					?>
				</p>
			<?php else : ?>
				<p>
					<?php esc_html_e( 'Twentig helps you customize your theme and build pages easily. To get started, take a quick tour to learn the basics.', 'twentig' ); ?>
				</p>
				<?php 
					$tour_url = current_user_can( 'edit_theme_options' ) ?
						admin_url( 'customize.php' ) . '?twentig_tour=1&return=' . rawurlencode( admin_url() . '?page=twentig' )
						:
						admin_url( 'post-new.php?post_type=page&twentig_tour=1' );
				?>
				<a href="<?php echo esc_url( $tour_url ); ?>" class="button button-primary">
					<?php esc_html_e( 'Start Tour', 'twentig' ); ?>
				</a>
			<?php endif; ?>
		</div> <!-- .hero-section-->
		
		<div class="tw-about__section links-section">
			<?php $extra_class = $default_theme && current_user_can( 'edit_theme_options' ) ? 'has-3-panels' : 'has-2-panels'; ?>
			<div class="tw-about__grid <?php echo esc_attr( $extra_class ); ?>">
				<?php if ( $default_theme && current_user_can( 'edit_theme_options' ) ) : ?>		
					<div class="about-panel customizer-panel">
						<?php
						$customizer_links = array(								
							'starter'     => array(
								'title' => __( 'Starter websites', 'twentig' ),
								'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M20.5 16h-.7V8c0-1.1-.9-2-2-2H6.2c-1.1 0-2 .9-2 2v8h-.7c-.8 0-1.5.7-1.5 1.5h20c0-.8-.7-1.5-1.5-1.5zM5.7 8c0-.3.2-.5.5-.5h11.6c.3 0 .5.2.5.5v7.6H5.7V8z" /></svg>',
								'url'   => admin_url( 'customize.php?autofocus[section]=twentig_starter_websites' ),
							),
							'logo'        => array(
								'title' => __( 'Site logo', 'twentig' ),
								'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M12 3c-5 0-9 4-9 9s4 9 9 9 9-4 9-9-4-9-9-9zm0 1.5c4.1 0 7.5 3.4 7.5 7.5v.1c-1.4-.8-3.3-1.7-3.4-1.8-.2-.1-.5-.1-.8.1l-2.9 2.1L9 11.3c-.2-.1-.4 0-.6.1l-3.7 2.2c-.1-.5-.2-1-.2-1.5 0-4.2 3.4-7.6 7.5-7.6zm0 15c-3.1 0-5.7-1.9-6.9-4.5l3.7-2.2 3.5 1.2c.2.1.5 0 .7-.1l2.9-2.1c.8.4 2.5 1.2 3.5 1.9-.9 3.3-3.9 5.8-7.4 5.8z" /></svg>',
								'url'   => admin_url( 'customize.php?autofocus[control]=custom_logo' ),
							),
							'colors'      => array(
								'title' => __( 'Colors', 'twentig' ),
								'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M12 21a6.854 6.854 0 01-6.846-6.847 7.723 7.723 0 011.074-3.335 29.362 29.362 0 012.38-3.69 54.959 54.959 0 012.385-2.976L12 3l1.006 1.15a55.143 55.143 0 012.386 2.978 29.396 29.396 0 012.38 3.69 7.727 7.727 0 011.074 3.335A6.854 6.854 0 0112 21zm0-15.717a53.29 53.29 0 00-2.187 2.739 27.825 27.825 0 00-2.257 3.494 6.163 6.163 0 00-.902 2.637 5.346 5.346 0 1010.692 0 6.166 6.166 0 00-.902-2.637 27.86 27.86 0 00-2.257-3.494A52.882 52.882 0 0012 5.282z" /></svg>',
								'url'  => admin_url( 'customize.php?autofocus[section]=colors' ),
							),
							'typography'  => array(
								'title' => __( 'Fonts', 'twentig' ),
								'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M6.9 7L3 17.8h1.7l1-2.8h4.1l1 2.8h1.7L8.6 7H6.9zm-.7 6.6l1.5-4.3 1.5 4.3h-3zM21.6 17c-.1.1-.2.2-.3.2-.1.1-.2.1-.4.1s-.3-.1-.4-.2c-.1-.1-.1-.3-.1-.6V12c0-.5 0-1-.1-1.4-.1-.4-.3-.7-.5-1-.2-.2-.5-.4-.9-.5-.4 0-.8-.1-1.3-.1s-1 .1-1.4.2c-.4.1-.7.3-1 .4-.2.2-.4.3-.6.5-.1.2-.2.4-.2.7 0 .3.1.5.2.8.2.2.4.3.8.3.3 0 .6-.1.8-.3.2-.2.3-.4.3-.7 0-.3-.1-.5-.2-.7-.2-.2-.4-.3-.6-.4.2-.2.4-.3.7-.4.3-.1.6-.1.8-.1.3 0 .6 0 .8.1.2.1.4.3.5.5.1.2.2.5.2.9v1.1c0 .3-.1.5-.3.6-.2.2-.5.3-.9.4-.3.1-.7.3-1.1.4-.4.1-.8.3-1.1.5-.3.2-.6.4-.8.7-.2.3-.3.7-.3 1.2 0 .6.2 1.1.5 1.4.3.4.9.5 1.6.5.5 0 1-.1 1.4-.3.4-.2.8-.6 1.1-1.1 0 .4.1.7.3 1 .2.3.6.4 1.2.4.4 0 .7-.1.9-.2.2-.1.5-.3.7-.4h-.3zm-3-.9c-.2.4-.5.7-.8.8-.3.2-.6.2-.8.2-.4 0-.6-.1-.9-.3-.2-.2-.3-.6-.3-1.1 0-.5.1-.9.3-1.2s.5-.5.8-.7c.3-.2.7-.3 1-.5.3-.1.6-.3.7-.6v3.4z" /></svg>',
								'url'   => admin_url( 'customize.php?autofocus[section]=twentig_fonts_section' ),
							),
							'layout'      => array(
								'title' => __( 'Site layout', 'twentig' ),
								'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M18 5.5H6a.5.5 0 00-.5.5v3h13V6a.5.5 0 00-.5-.5zm.5 5H10v8h8a.5.5 0 00.5-.5v-7.5zm-10 0h-3V18a.5.5 0 00.5.5h2.5v-8zM6 4h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2z" /></svg>',
								'url'   => admin_url( 'customize.php?autofocus[section]=twentig_layout_section' ),
							),
							'header'      => array(
								'title' => __( 'Header', 'twentig' ),
								'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M18.5 10.5H10v8h8a.5.5 0 00.5-.5v-7.5zm-10 0h-3V18a.5.5 0 00.5.5h2.5v-8zM6 4h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2z" /></svg>',
								'url' => admin_url( 'customize.php?autofocus[section]=twentig_header_section' ),
							),
							'footer'      => array(
								'title' => __( 'Footer', 'twentig' ),
								'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path fill-rule="evenodd" d="M18 5.5h-8v8h8.5V6a.5.5 0 00-.5-.5zm-9.5 8h-3V6a.5.5 0 01.5-.5h2.5v8zM6 4h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2z" /></svg>',
								'url'   => admin_url( 'customize.php?autofocus[section]=twentig_footer_section' ),
							),					
							'blog-layout' => array(
								'title' => __( 'Blog', 'twentig' ),
								'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M6 5.5h3a.5.5 0 01.5.5v3a.5.5 0 01-.5.5H6a.5.5 0 01-.5-.5V6a.5.5 0 01.5-.5zM4 6a2 2 0 012-2h3a2 2 0 012 2v3a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm11-.5h3a.5.5 0 01.5.5v3a.5.5 0 01-.5.5h-3a.5.5 0 01-.5-.5V6a.5.5 0 01.5-.5zM13 6a2 2 0 012-2h3a2 2 0 012 2v3a2 2 0 01-2 2h-3a2 2 0 01-2-2V6zm5 8.5h-3a.5.5 0 00-.5.5v3a.5.5 0 00.5.5h3a.5.5 0 00.5-.5v-3a.5.5 0 00-.5-.5zM15 13a2 2 0 00-2 2v3a2 2 0 002 2h3a2 2 0 002-2v-3a2 2 0 00-2-2h-3zm-9 1.5h3a.5.5 0 01.5.5v3a.5.5 0 01-.5.5H6a.5.5 0 01-.5-.5v-3a.5.5 0 01.5-.5zM4 15a2 2 0 012-2h3a2 2 0 012 2v3a2 2 0 01-2 2H6a2 2 0 01-2-2v-3z" fill-rule="evenodd" clip-rRule="evenodd" /></svg>',
								'url'   => admin_url( 'customize.php?autofocus[section]=twentig_blog_section' ),
							),									
							'page-layout' => array(
								'title' => __( 'Page', 'twentig' ),
								'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M19 3H5c-.6 0-1 .4-1 1v7c0 .5.4 1 1 1h14c.5 0 1-.4 1-1V4c0-.6-.4-1-1-1zM5.5 10.5v-.4l1.8-1.3 1.3.8c.3.2.7.2.9-.1L11 8.1l2.4 2.4H5.5zm13 0h-2.9l-4-4c-.3-.3-.8-.3-1.1 0L8.9 8l-1.2-.8c-.3-.2-.6-.2-.9 0l-1.3 1V4.5h13v6zM4 20h9v-1.5H4V20zm0-4h16v-1.5H4V16z" /></svg>',
								'url'   => admin_url( 'customize.php?autofocus[section]=twentig_page_section' ),
							),
							'menus'       => array(
								'title' => __( 'Menus', 'twentig' ),
								'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M12 3a9 9 0 109 9 9.01 9.01 0 00-9-9zm0 16.5a7.5 7.5 0 117.5-7.5 7.508 7.508 0 01-7.5 7.5zm-1.705-8.24l5.064-3.396-1.648 5.38-5.07 3.36z" /></svg>',
								'url'   => admin_url( 'customize.php?autofocus[panel]=nav_menus' ),
							),	
							'homepage'    => array(
								'title' => __( 'Set up your homepage', 'twentig' ),
								'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M12 4L4 7.9V20h16V7.9L12 4zm6.5 14.5H14V13h-4v5.5H5.5V8.8L12 5.7l6.5 3.1v9.7z" /></svg>',
								'url'   => admin_url( 'customize.php?autofocus[section]=static_front_page' ),
							),
						);
						?>
							
						<h2>
							<?php esc_html_e( 'Customize Theme', 'twentig' ); ?>
						</h2>
						<ul>
							<?php
							foreach ( $customizer_links as $key => $link ) {
								if( 'homepage' !== $key ) {
									echo '<li><a href="' . esc_url( $link['url'] ) . '">' . $link['icon'] . esc_html( $link['title'] ) . '</a></li>';
								}
							}
							if ( 'page' !== get_option( 'show_on_front' ) ) {
								$link = $customizer_links['homepage'];
								echo '<li><a href="' . esc_url( $link['url'] ) . '">' . $link['icon'] . esc_html( $link['title'] ) . '</a></li>';
							}
							?>
						</ul>

					</div><!-- .about-panel -->

				<?php endif; ?>
					
				<?php 
				$editor_icons = array(
					'edit-front' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M12 4L4 7.9V20h16V7.9L12 4zm6.5 14.5H14V13h-4v5.5H5.5V8.8L12 5.7l6.5 3.1v9.7z" /></svg>',
					'add-page'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M7 13.8h6v-1.5H7v1.5zM18 16V4c0-1.1-.9-2-2-2H6c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2zM5.5 16V4c0-.3.2-.5.5-.5h10c.3 0 .5.2.5.5v12c0 .3-.2.5-.5.5H6c-.3 0-.5-.2-.5-.5zM7 10.5h8V9H7v1.5zm0-3.3h8V5.8H7v1.4zM20.2 6v13c0 .7-.6 1.2-1.2 1.2H8v1.5h11c1.5 0 2.7-1.2 2.7-2.8V6h-1.5z" /></svg>',
					'add-post'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M20.1 5.1L16.9 2 6.2 12.7l-1.3 4.4 4.5-1.3L20.1 5.1zM4 20.8h8v-1.5H4v1.5z" /></svg>',
					'tour'      => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M12 15.8c-3.7 0-6.8-3-6.8-6.8s3-6.8 6.8-6.8c3.7 0 6.8 3 6.8 6.8s-3.1 6.8-6.8 6.8zm0-12C9.1 3.8 6.8 6.1 6.8 9s2.4 5.2 5.2 5.2c2.9 0 5.2-2.4 5.2-5.2S14.9 3.8 12 3.8zM8 17.5h8V19H8zM10 20.5h4V22h-4z" /></svg>'
				);
				?>
						
				<div class="about-panel editor-panel">					
					<h2>
						<?php esc_html_e( 'Create Pages', 'twentig' ); ?>
					</h2>
					<ul>
						<li><?php printf( '<a href="%s">' . $editor_icons[ 'tour'] . esc_html__( 'See Twentig features', 'twentig' ) . '</a>', esc_url( admin_url( 'post-new.php?post_type=page&twentig_tour=1' ) ) ); ?></li>
					<?php if ( 'page' === get_option( 'show_on_front' ) && ! get_option( 'page_for_posts' ) ) : ?>
						<li><?php printf( '<a href="%s">' . $editor_icons[ 'edit-front'] . esc_html__( 'Edit your front page' ) . '</a>', esc_url( get_edit_post_link( get_option( 'page_on_front' ) ) ) ); ?></li>
						<li><?php printf( '<a href="%s">' . $editor_icons[ 'add-page'] . esc_html__( 'Add additional pages' ) . '</a>', esc_url( admin_url( 'post-new.php?post_type=page' ) ) ); ?></li>
					<?php elseif ( 'page' === get_option( 'show_on_front' ) ) : ?>
						<li><?php printf( '<a href="%s">' . $editor_icons[ 'edit-front'] . esc_html__( 'Edit your front page' ) . '</a>', esc_url( get_edit_post_link( get_option( 'page_on_front' ) ) ) ); ?></li>
						<li><?php printf( '<a href="%s">' . $editor_icons[ 'add-page'] . esc_html__( 'Add additional pages' ) . '</a>', esc_url( admin_url( 'post-new.php?post_type=page' ) ) ); ?></li>
						<li><?php printf( '<a href="%s">' . $editor_icons[ 'add-post'] . esc_html__( 'Add a blog post' ) . '</a>', esc_url( admin_url( 'post-new.php' ) ) ); ?></li>
					<?php else : ?>
						<li><?php printf( '<a href="%s">' . $editor_icons[ 'add-post'] . esc_html__( 'Add a blog post' ) . '</a>', esc_url( admin_url( 'post-new.php' ) ) ); ?></li>
						<li><?php printf( '<a href="%s">' . $editor_icons[ 'add-page'] . esc_html__( 'Add additional pages' ) . '</a>', esc_url( admin_url( 'post-new.php?post_type=page' ) ) ); ?></li>
					<?php endif; ?>						
					</ul>
				</div> <!-- .about-panel -->

				<div class="about-panel more-panel">					
					<h2>
						<?php esc_html_e( 'Explore More', 'twentig' ); ?>
					</h2>
					<ul>
						<li>
							<a href="https://twentig.com/quickstart-guide/?utm_source=wp-dash&utm_medium=home&utm_campaign=guide" target="_blank" rel="noopener noreferrer">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M17.9 3H6.1A2.2 2.2 0 004 5.286v13.428A2.2 2.2 0 006.1 21h11.8a2.2 2.2 0 002.1-2.286V5.286A2.2 2.2 0 0017.9 3zm.6 15.714a.722.722 0 01-.6.786H6.1a.722.722 0 01-.6-.786V5.286a.722.722 0 01.6-.786h4.4v8.926L13 10.3l2.5 3.126V4.5h2.4a.722.722 0 01.6.786z" /></svg>
								<?php esc_html_e( 'Quickstart guide', 'twentig' ); ?>
							</a>
						</li>
						<li>
							<a href="https://wordpress.org/support/plugin/twentig/" target="_blank" rel="noopener noreferrer">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M18 4H6c-1.1 0-2 .9-2 2v12.9c0 .6.5 1.1 1.1 1.1.3 0 .5-.1.8-.3L8.5 17H18c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm.5 11c0 .3-.2.5-.5.5H7.9l-2.4 2.4V6c0-.3.2-.5.5-.5h12c.3 0 .5.2.5.5v9z" /></svg>
								<?php esc_html_e( 'Support forum', 'twentig' ); ?>
							</a>
						</li>
						<li>
							<a href="https://www.youtube.com/channel/UCHZglgs5eTxkpRFl2r5RsGA?sub_confirmation=1" target="_blank" rel="noopener noreferrer">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M12 7a47.6 47.6 0 016.63.33.79.79 0 01.54.58A22.7 22.7 0 0119.5 12a22.32 22.32 0 01-.33 4.1.79.79 0 01-.54.57A47.65 47.65 0 0112 17a47.6 47.6 0 01-6.63-.33.79.79 0 01-.54-.58A22.7 22.7 0 014.5 12a22.32 22.32 0 01.33-4.1.79.79 0 01.54-.57A47.66 47.66 0 0112 7m0-1.5a52.15 52.15 0 00-7.03.39 2.3 2.3 0 00-1.6 1.64A24.92 24.92 0 003 12a24.92 24.92 0 00.38 4.47 2.3 2.3 0 001.59 1.64 52.15 52.15 0 007.03.39 52.15 52.15 0 007.03-.39 2.3 2.3 0 001.6-1.64A24.92 24.92 0 0021 12a24.92 24.92 0 00-.38-4.47 2.3 2.3 0 00-1.59-1.64A52.15 52.15 0 0012 5.5zm-2 3.85L15 12l-5 2.65z" /></svg>
								<?php esc_html_e( 'YouTube channel', 'twentig' ); ?>
							</a>
						</li>
						<li>
							<a href="https://wordpress.org/support/plugin/twentig/reviews/" target="_blank" rel="noopener noreferrer">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M12 3a9 9 0 109 9 9.01 9.01 0 00-9-9zm0 16.5a7.5 7.5 0 117.5-7.5 7.508 7.508 0 01-7.5 7.5zM7.5 9.75a1.35 1.35 0 111.35 1.35A1.35 1.35 0 017.5 9.75zM7.582 14h8.836A4.865 4.865 0 0112 17.4 4.865 4.865 0 017.582 14zM16.5 9.75a1.35 1.35 0 11-1.35-1.35 1.35 1.35 0 011.35 1.35z" /></svg>
								<?php esc_html_e( 'Rate us on WordPress.org', 'twentig' ); ?>
							</a>
						</li>
					</ul>
				</div> <!-- .about-panel -->

			</div><!-- .tw-about__grid -->

		</div> <!-- .links-section-->

		<div class="tw-about__section more-section">
			<div class="about-panel">
				<div class="form-content">
					<h2>
						<?php esc_html_e( 'Get more out of Twentig', 'twentig' ); ?>
					</h2>
					<p>
						<?php esc_html_e( 'Subscribe to our newsletter to receive exclusive content, tips and updates.', 'twentig' ); ?>
					</p>
					<form action="https://twentig.us19.list-manage.com/subscribe/post?u=08ece541d27a16ce5099c42ad&amp;id=b360357220" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" target="_blank">
						<label class="screen-reader-text" for="mce-EMAIL">
							<?php esc_html_e( 'Your email address', 'twentig' ); ?>
						</label>
						<input required type="email" value="" placeholder="<?php esc_attr_e( 'Your email address', 'twentig' ); ?>" name="EMAIL" id="mce-EMAIL">
						<div class="screen-reader-text" aria-hidden="true">
							<input type="text" name="b_08ece541d27a16ce5099c42ad_b360357220" tabindex="-1" value="">
						</div>
						<input type="submit" value="<?php esc_attr_e( 'Subscribe', 'twentig' ); ?>" name="subscribe" id="mc-embedded-subscribe" class="button">		
						<p class="privacy">
							<?php
								printf(
									__( 'By entering your email, you agree to our <a href="%s" target="_blank" rel="noopener noreferrer">Privacy Policy</a>.', 'twentig' ),
									'https://twentig.com/privacy/'
								);
							?>
						</p>
						<div class="mc-status"></div>
					</form>
				</div>
				<img src="<?php echo esc_url( TWENTIG_ASSETS_URI . '/images/welcome/newsletter.png' ); ?>" width="104" height="102" alt="" />
			</div>
		</div> <!-- .more-section-->

	</div>

	<?php
}

/**
 * Renders Twentig settings page.
 */
function twentig_render_settings_page() {
	?>
	<div class="wrap">
		<h1>
			<?php esc_html_e( 'Twentig Settings', 'twentig' ); ?>
		</h1>
		<?php settings_errors(); ?>
		<form method="post" action="options.php">
			<?php
				settings_fields( 'twentig-options' );
				do_settings_sections( 'twentig-options' );
				submit_button();
			?>
		</form>
	</div>

	<p class="tw-rate-plugin">
		<?php
			echo sprintf(
				/* translators: %s: https://wordpress.org/support/plugin/twentig/reviews/ */
				__( 'Enjoying Twentig? Rate it <a href="%1$s" target="_blank" rel="noopener noreferrer">★★★★★</a> on <a href="%2$s" target="_blank" rel="noopener noreferrer">WordPress.org</a>.', 'twentig' ),
				'https://wordpress.org/support/plugin/twentig/reviews/',
				'https://wordpress.org/support/plugin/twentig/reviews/'
			);
		?>
	</p>
	<?php
}

/**
 * Loads scripts for the Twentig page.
 */
function twentig_admin_enqueue_about_scripts() {
	if ( in_array( get_current_screen()->base, array( 'toplevel_page_twentig', 'twentig_page_twentig-settings' ), true ) ) {
		wp_enqueue_style( 'twentig-about', plugins_url( 'dist/css/about.css', __DIR__ ), false, TWENTIG_VERSION );
	}
	if ( in_array( get_current_screen()->base, array( 'toplevel_page_twentig' ), true ) ) {
		wp_enqueue_script( 'twentig-about', plugins_url( 'dist/js/about.js', __DIR__ ), false, TWENTIG_VERSION, true );
	}
}
add_action( 'admin_enqueue_scripts', 'twentig_admin_enqueue_about_scripts' );

/**
 * Redirects to the Twentig page on single plugin activation.
 */
function twentig_dashboard_redirect() {
	if ( get_transient( '_twentig_activation_redirect' ) && apply_filters( 'twentig_enable_activation_redirect', true ) ) {
		$do_redirect = true;
		delete_transient( '_twentig_activation_redirect' );

		if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
			$do_redirect = false;
		}
	
		if ( $do_redirect ) {			
			wp_safe_redirect( esc_url( admin_url( 'admin.php?page=twentig' ) ) );
			exit;
		}
	}
}
add_action( 'admin_init', 'twentig_dashboard_redirect' );

/**
 * Adds a notice when Twenty Twenty-One is activated.
 */
function twentig_theme_admin_notices(){
	global $pagenow;
	if ( 'themes.php' === $pagenow && isset( $_GET['activated'] ) && 'twentytwentyone' === get_template() ) {
		?>
		<div class="notice notice-success is-dismissible">
			<h2 style="margin: 16px 0 0 2px">
				<?php esc_html_e( 'You’re ready to go', 'twentig' ); ?>
			</h2>
			<p>
				<?php esc_html_e( 'Take a quick tour to learn the basics of Twentig.', 'twentig' ); ?>
			</p>
			<a style="margin: 4px 0 16px 2px" href="<?php echo esc_url( admin_url( 'customize.php' ) . '?twentig_tour=1&return=' . rawurlencode( admin_url() . '?page=twentig' ) ); ?>" class="button button-primary">
				<?php esc_html_e( 'Start Tour', 'twentig' ); ?>
			</a>
		</div>
	<?php
	}
}
add_action( 'admin_notices', 'twentig_theme_admin_notices' );
