<?php

/**
 * Shortcodes
 */

/**
 *  [ecwd_calendar] shortcode
 */
include_once(ABSPATH . 'wp-admin/includes/plugin.php');
function ecwd_shortcode($attr) {

  global $wp;

  if(!empty($wp->query_vars['rest_route'])) {
    return "";//for gutenberg
  }

    if(get_post_type() == "ecwd_event"){
      return "";
    }

  extract(shortcode_atts(array(
	'id' => null,
	'page_items' => '5',
	'event_search' => 'yes',
	'display' => 'full',
	'displays' => null,
	'filters' => null,
	'calendar_start_date' => null
	), $attr, ECWD_PLUGIN_PREFIX.'_calendar'));

  // If no ID is specified then return
  if ( empty($attr['id']) ) {
  return;
  }

  $type = (isset($attr['type']) && $attr['type'] === 'mini') ? 'mini' : 'full';

  $ecwd_displays_list = array('none',$type,"list","week","day");

    //for gutenberg
    if($type === 'mini'){
      $displays = str_replace('full', 'mini', $displays);
    }else{
      $displays = str_replace('mini', 'full', $displays);
    }

    $ecwd_displays = explode(",",$displays);
    $display = $ecwd_displays[0];

    foreach ($ecwd_displays as $ecwd_key => $ecwd_display_name){
      if(!in_array($ecwd_display_name ,$ecwd_displays_list)){
        $ecwd_displays[$ecwd_key] = $type;
      }
    }

    $displays = implode(",",$ecwd_displays);

    if ( get_post_status($attr['id']) === "private" && !current_user_can('read_private_posts') ){
      return;
    }

  $args = array('displays'=>$displays, 'filters'=>$attr['filters'], 'page_items'=>$attr['page_items'], 'event_search'=>$attr['event_search']);

  if ( $calendar_start_date !== null ) {
    $calendar_start_date = strtotime($calendar_start_date);
    if($calendar_start_date === false || $calendar_start_date === -1){
	 $calendar_start_date = null;
    }
  }

  if ( $calendar_start_date !== null ) {
    $args['date'] = ECWD::ecwd_date('Y-m-d',$calendar_start_date);
  }

  $calendar_ids = explode(',', str_replace(' ', '', $id));

  array_walk( $calendar_ids,  function ( &$value ) { $value = ( int ) $value; } );
  $result = ecwd_print_calendar($calendar_ids, $display, $args);
  return $result;
}

add_shortcode(ECWD_PLUGIN_PREFIX, ECWD_PLUGIN_PREFIX.'_shortcode');
