<?php
/**
 * Additional options for Twenty Twenty-One.
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

if ( 'twentytwentyone' === get_template() ) {
	require_once TWENTIG_PATH . 'inc/twentytwentyone/template-tags.php';
	require_once TWENTIG_PATH . 'inc/theme-tools/class-twentig-page-templater.php';
	require_once TWENTIG_PATH . 'inc/theme-tools/404.php';
}

/**
 * Include theme files "after_setup_theme".
 */
function twentig_twentyone_load_theme_files() {
	if ( 'twentytwentyone' !== get_template() ) {
		return;
	}

	require TWENTIG_PATH . 'inc/twentytwentyone/customizer.php';	
	require TWENTIG_PATH . 'inc/theme-tools/starters.php';
	require TWENTIG_PATH . 'inc/twentytwentyone/starters.php';
	require TWENTIG_PATH . 'inc/twentytwentyone/block-editor.php';
	require TWENTIG_PATH . 'inc/twentytwentyone/front-style.php';
	require TWENTIG_PATH . 'inc/twentytwentyone/font.php';
	require TWENTIG_PATH . 'inc/twentytwentyone/color.php';
	require TWENTIG_PATH . 'inc/twentytwentyone/header.php';
	require TWENTIG_PATH . 'inc/twentytwentyone/footer.php';
	require TWENTIG_PATH . 'inc/twentytwentyone/blog.php';
	require TWENTIG_PATH . 'inc/twentytwentyone/plugins.php';
}
add_action( 'after_setup_theme', 'twentig_twentyone_load_theme_files', -1 );
