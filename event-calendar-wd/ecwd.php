<?php
/**
 * Plugin Name:     Event Calendar WD
 * Plugin URI:      https://10web.io/plugins/wordpress-event-calendar/
 * Description:     Event Calendar WD is an easy event management and planning tool with advanced features.
 * Version:         1.1.49
 * Author:          10Web
 * Author URI:      https://10web.io/plugins/
 * Text Domain: 	event-calendar-wd
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
require_once( 'ecwd_class.php' );

if( ! defined( 'ECWD_PRO' ) ) {
	define( 'ECWD_PRO', 0 );
}

if( ! defined( 'ECWD_MAIN_FILE' ) ) {
	define( 'ECWD_MAIN_FILE', plugin_basename(__FILE__));
}
if( ! defined( 'ECWD_DIR' ) ) {
	define( 'ECWD_DIR', dirname(__FILE__));

}
if(! defined( 'ECWD_URL' ) ){
    define ('ECWD_URL',plugins_url(plugin_basename(dirname(__FILE__))));
}

if (!defined('ECWD_VERSION')) {
  define('ECWD_VERSION', "1.1.49");
}

if (!defined('ECWD_PLUGIN_MAIN_FILE')) {
	define('ECWD_PLUGIN_MAIN_FILE', __FILE__);
}

if (!defined('ECWD_MENU_SLUG')) {
	define('ECWD_MENU_SLUG', "edit.php?post_type=ecwd_event");
}
if (!defined('ECWD_REST_NAMESPACE')) {
  define('ECWD_REST_NAMESPACE', 'ecwd/v1');
}

if(get_site_transient('ecwd_uninstall') === false) {
add_action('plugins_loaded', array('ECWD', 'reset_settings'), 9);
add_action( 'plugins_loaded', array( 'ECWD', 'get_instance' ) );
}

if(is_admin()) {
  require_once('ecwd_admin_class.php');

  add_action('admin_menu', array('ECWD_Admin', 'uninstall_menu'));
  if(get_site_transient('ecwd_uninstall') === false) {
  add_action('init', array('ECWD_Admin', 'check_silent_update'));
  add_action('plugins_loaded', array('ECWD_Admin', 'get_instance'));
  }

  register_activation_hook(__FILE__, array('ECWD_Admin', 'global_activate'));
  add_action('init', array('ECWD_Admin', 'ecwd_freemius'), 9);
  //register_deactivation_hook(__FILE__, array('ECWD_Admin', 'global_deactivate'));
  //register_uninstall_hook(__FILE__, array('ECWD_Admin', 'uninstall'));
}

add_filter('admin_init', 'ecwd_privacy_policy');
function ecwd_privacy_policy($content){
  if ( ! function_exists( 'wp_add_privacy_policy_content' ) ) {
    return;
  }
  $title = __('Event Calendar WD', "event-calendar-wd");

  $pp_link = '<a target="_blank" href="https://policies.google.com/privacy">' . __('Privacy Policy', "event-calendar-wd") . '</a>';
  $text = sprintf(__('Event Calendar WD plugin optionally embeds Google Maps on front end to display events on the map. Embedded Google Maps behave in the exact same way as if you has visited Google Maps site. Google may collect data about visitors, use cookies and tracking, included your logged-in experience interaction with Google platform. Google Maps are regulated under terms of Google %s.', "event-calendar-wd"), $pp_link);
  $text .= "<br/>";
  $text .= __('10Web Disclaimer: The above text is for informational purposes only and is not a legal advice. You must not rely on it as an alternative to legal advice. You should contact your legal counsel to obtain advice with respect to your particular case.', "event-calendar-wd");
  $pp_text = '<h3>' . $title . '</h3>' . '<p class="wp-policy-help">' . $text . '</p>';

  $content .= $pp_text;
  wp_add_privacy_policy_content( $title, wp_kses_post( wpautop( $content, false ) ) );
}
