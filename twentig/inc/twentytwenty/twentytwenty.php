<?php
/**
 * Additional options for Twenty Twenty
 *
 * @package twentig
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Include files.
 */
require_once TWENTIG_PATH . 'inc/theme-tools/customizer-functions.php';

if ( 'twentytwenty' === get_template() ) {
	require_once TWENTIG_PATH . 'inc/theme-tools/class-twentig-page-templater.php';
	require_once TWENTIG_PATH . 'inc/theme-tools/404.php';
}

/**
 * Include theme files "after_setup_theme".
 */
function twentig_twentytenty_load_theme_files() {
	if ( 'twentytwenty' !== get_template() ) {
		return;
	}

	require TWENTIG_PATH . 'inc/twentytwenty/customizer.php';		
	require TWENTIG_PATH . 'inc/theme-tools/starters.php';
	require TWENTIG_PATH . 'inc/twentytwenty/starters.php';
	require TWENTIG_PATH . 'inc/twentytwenty/block-editor.php';
	require TWENTIG_PATH . 'inc/twentytwenty/front-style.php';
	require TWENTIG_PATH . 'inc/twentytwenty/font.php';
	require TWENTIG_PATH . 'inc/twentytwenty/color.php';
	require TWENTIG_PATH . 'inc/twentytwenty/header.php';
	require TWENTIG_PATH . 'inc/twentytwenty/footer.php';
	require TWENTIG_PATH . 'inc/twentytwenty/blog.php';
	require TWENTIG_PATH . 'inc/twentytwenty/plugins.php';
}
add_action( 'after_setup_theme', 'twentig_twentytenty_load_theme_files', -1 );
