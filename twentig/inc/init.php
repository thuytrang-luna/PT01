<?php
/**
 * Twentig plugin file.
 *
 * @package twentig
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueues block assets for frontend and backend editor.
 */
function twentig_block_assets() {

	if ( ! twentig_is_option_enabled( 'twentig_block_options' ) ) {
		return;
	}

	$asset_file = include TWENTIG_PATH . 'dist/index.asset.php';

	wp_enqueue_style(
		'twentig-blocks',
		plugins_url( 'dist/style-index.css', dirname( __FILE__ ) ),
		array(),
		$asset_file['version']
	);

	wp_style_add_data( 'twentig-blocks', 'rtl', 'replace' );
}
add_action( 'enqueue_block_assets', 'twentig_block_assets' );

/**
 * Enqueues block assets for backend editor.
 */
function twentig_block_editor_assets() {

	if ( ! twentig_is_option_enabled( 'twentig_block_options' ) ) {
		return;
	}

	$asset_file = include TWENTIG_PATH . 'dist/index.asset.php';

	wp_enqueue_script(
		'twentig-blocks-editor',
		plugins_url( '/dist/index.js', dirname( __FILE__ ) ),
		$asset_file['dependencies'],
		$asset_file['version'],
		false
	);

	$config = apply_filters(
		'twentig_blocks_editor_config',
		array(
			'theme'                => get_template(),
			'branch'               => str_replace( array( '.', ',' ), '-', (float) get_bloginfo( 'version' ) ),
			'cssClasses'           => twentig_get_block_css_classes(),
			'pageLayoutCategories' => twentig_get_registered_page_categories(),
			'pageLayouts'          => Twentig_Block_Patterns_Registry::get_instance()->get_all_registered(),
			'guideAssetsUri'       => TWENTIG_ASSETS_URI . '/images/welcome/',
		)
	);

	wp_localize_script( 'twentig-blocks-editor', 'twentigEditorConfig', $config );

	if ( function_exists( 'wp_set_script_translations' ) ) {
		wp_set_script_translations( 'twentig-blocks-editor', 'twentig' );
	}

	wp_enqueue_style(
		'twentig-editor',
		plugins_url( 'dist/index.css', dirname( __FILE__ ) ),
		array( 'wp-edit-blocks' ),
		$asset_file['version']
	);

	wp_style_add_data( 'twentig-editor', 'rtl', 'replace' );

}
add_action( 'enqueue_block_editor_assets', 'twentig_block_editor_assets' );

require TWENTIG_PATH . 'inc/about.php';
require TWENTIG_PATH . 'inc/settings.php';
require TWENTIG_PATH . 'inc/block-presets.php';
require TWENTIG_PATH . 'inc/block-patterns.php';
require TWENTIG_PATH . 'inc/twentytwenty/twentytwenty.php';
require TWENTIG_PATH . 'inc/twentytwentyone/twentytwentyone.php';

/**
 * Redirects the Twentig editor tour to edit the front page or add a new page.
 */
function twentig_redirect_editor_tour() {
	global $pagenow;
	
	if ( 'post-new.php' === $pagenow && isset( $_GET['twentig_tour_editor'] ) ) {
		if ( 'page' === get_option( 'show_on_front' ) ) {
			$home_id = (int) get_option( 'page_on_front' );
			if ( $home_id ) {
				wp_safe_redirect( admin_url( 'post.php?post=' . $home_id . '&action=edit&twentig_tour=1' ) );
				exit;
			}
		} else {
			wp_safe_redirect( admin_url( 'post-new.php?post_type=page&twentig_tour=1' ) );
			exit;
		}
	}
}
add_action( 'admin_init', 'twentig_redirect_editor_tour' );
