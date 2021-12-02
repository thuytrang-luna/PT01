<?php
if(isset($_GET['edit']) && !empty($_GET['edit']) && $_GET['edit'] != "undefined" && isset($_GET["shortcode"])){
  $ecwd_edit_shortcode = str_replace('\"' , '"' ,$_GET['shortcode']);
  $ecwd_edit_shortcode_data = (shortcode_parse_atts($ecwd_edit_shortcode));
}


$args = array(
  'post_type' => ECWD_PLUGIN_PREFIX . '_calendar',
  'post_status' => 'publish',
  'posts_per_page' => - 1,
  'ignore_sticky_posts' => 1
);

$calendar_posts = get_posts($args);
$ECWD_filters_is_active = false;
if (defined('ECWD_FILTERS_EVENT_MAIN_FILE') && is_plugin_active(ECWD_FILTERS_EVENT_MAIN_FILE)) {
  $ECWD_filters_is_active = true;
}
?>
<form id="ecwd_shortcode_form">
<div class="ecwd_shortcode">
  <div class="ecwd_shortcode_menu">
    <div class="ecwd_shortcode_menu_item ecwd_active_shortcode_menu" data-menu_name="ecwd_general_menu"><?php _e('General','event-calendar-wd');?></div>
    <div class="ecwd_shortcode_menu_item" data-menu_name="ecwd_views_menu"><?php _e('Views','event-calendar-wd');?></div>
    <div class="ecwd_shortcode_menu_item" data-menu_name="ecwd_filters_menu"><?php _e('Filters','event-calendar-wd');?></div>
  </div>
  <div class="ecwd_shortcode_content">
    <div class="ecwd_tab ecwd_general_menu ecwd_active_tab">
      <?php if(isset($calendar_posts) && is_array($calendar_posts)): ?>
      <div class="ecwd_shortcode_params">
        <label for="ecwd_select_calendar"><?php _e('Select Calendar','event-calendar-wd');?></label>
        <select name="ecwd_select_calendar" id="ecwd_select_calendar">
          <?php
          foreach ($calendar_posts as $calendar){
            $ecwd_selected_option = "";
            if(isset($ecwd_edit_shortcode_data) && isset($ecwd_edit_shortcode_data["id"])){
              if(intval($ecwd_edit_shortcode_data["id"]) === intval($calendar->ID)){
                $ecwd_selected_option = "selected";
              }
            }
            echo'<option value="'.$calendar->ID.'" '.$ecwd_selected_option.'>'.$calendar->post_title.'</option>';
          }
          ?>
        </select>
      </div>
      <?php endif;?>
<?php
?>

      <div class="ecwd_shortcode_params">
        <label for="ecwd_select_view_type"><?php _('Select View type','event-calendar-wd');?></label>
        <select name="ecwd_select_view_type" id="ecwd_select_view_type">
          <?php
          if(isset($ecwd_edit_shortcode_data) && isset($ecwd_edit_shortcode_data["type"]) && $ecwd_edit_shortcode_data["type"] === "mini"){
                echo '<option value="full">'.__('Full','event-calendar-wd').'</option>
                      <option value="mini" selected>'.__('Mini','event-calendar-wd').'</option>';
          }else{

            echo '<option value="full" selected>'.__('Full','event-calendar-wd').'</option>
                      <option value="mini">'.__('Mini','event-calendar-wd').'</option>';
          }
          ?>

        </select>
      </div>
      <div class="ecwd_shortcode_params">
        <label for="ecwd_per_page_count"><?php _e('Events per page in list view', 'event-calendar-wd');?></label>
        <?php
        $ecwd_shortcode_data_page_items = "5";
        if(isset($ecwd_edit_shortcode_data) && isset($ecwd_edit_shortcode_data["page_items"])){
          $ecwd_shortcode_data_page_items = $ecwd_edit_shortcode_data["page_items"];
        }
        ?>
        <input name="ecwd_per_page_count" id="ecwd_per_page_count" value="<?php echo $ecwd_shortcode_data_page_items;?>" type="text">
      </div>
      <div class="ecwd_shortcode_params">
        <label for="ecwd_calendar_start_date"><?php _e('Calendar start date','event-calendar-wd');?></label>
        <?php
        $ecwd_edit_shortcode_data_date = "";
        if(isset($ecwd_edit_shortcode_data) && isset($ecwd_edit_shortcode_data["calendar_start_date"])){
          $ecwd_edit_shortcode_data_date = $ecwd_edit_shortcode_data["calendar_start_date"];
        }
        ?>
        <input name="ecwd_calendar_start_date" value="<?php echo $ecwd_edit_shortcode_data_date;?>" id="ecwd_calendar_start_date" type="text">
      </div>
      <p class="ecwd_shortcode_notice"><?php _e('Date format Y-m(2016-05) or empty for current date','event-calendar-wd');?></p>
      <div class="ecwd_shortcode_params">
        <label for="ecwd_event_search"><?php _e('Enable event search','event-calendar-wd');?></label>
        <?php
        $checked = (isset($ecwd_edit_shortcode_data["event_search"]) && $ecwd_edit_shortcode_data["event_search"] == 'yes') ? 'checked' : '';
        ?>
        <input name="ecwd_event_search" id="ecwd_event_search" type="checkbox" <?php echo $checked ?> />
      </div>
      <a class="ecwd_iframe_update_premium" href="https://10web.io/plugins/wordpress-event-calendar/?utm_source=event_calendar&utm_medium=free_plugin" target="_blank"><?php _e('Upgrade to Premium version.','event-calendar-wd');?></a>
    </div>
    <div class="ecwd_tab ecwd_views_menu">
      <?php
      $ecwd_displays_list = array(
        "full"=>__("Month",'event-calendar-wd'),
        "list" => __("List",'event-calendar-wd'),
        "week" => __("Week",'event-calendar-wd'),
        "day" => __("Day",'event-calendar-wd'),
      );
      $ecwd_displays = array(
        "full",
        "list",
        "week",
        "day",
      );
      $edited_displays = array();
      if(isset($ecwd_edit_shortcode_data)  && isset($ecwd_edit_shortcode_data["displays"])){
        $edited_displays = explode(",",$ecwd_edit_shortcode_data["displays"]);
      }

      for ($i = 1 ; $i<5; $i++ ){
        $ecwd_selected_options = "";
        $temp = 0;
        foreach ($ecwd_displays_list as $val=>$title) {
          $temp++;
          $checked = "";
          if(empty($edited_displays)){
            if($i === $temp){
              $checked = "selected";
            }
          }else if($edited_displays[$i-1] === $val){
            $checked = "selected";
          }

          $ecwd_selected_options .= '<option value="' . $val . '" '.$checked.'>' . $title . '</option>';
        }

        echo '
        <div class="ecwd_shortcode_params">
          <label for="ecwd_view_'.$i.'">'.__('View','event-calendar-wd').' '.$i.'</label>
          <select name="ecwd_view_[]" id="ecwd_view_'.$i.'">
            <option value="none">'.__('None','event-calendar-wd').'</option>
            '.$ecwd_selected_options.'
          </select>
        </div>
        ';
      }
      ?>
      <p style="color: rgb(191, 27, 2); padding: 10px"><?php _e('Upgrade to Premium version to access three more view options: posterboard, map and 4 days.','event-calendar-wd');?></p>
    </div>
    <div class="ecwd_tab ecwd_filters_menu">
        <p style="color: rgb(191, 27, 2); padding: 10px;"><?php _e('Filter addon should be purchased separately.','event-calendar-wd');?></p>
    </div>
  </div>
  <div class="ecwd_shortcode_buttons">
    <button class="ecwd_add_shortcode button button-primary button-large">OK</button>
    <!--<span class="ecwd_close_iframe button media-modal-close">Cancel</span>-->
  </div>
</div>
</form>



<style>
  body{
    margin: 0;
  }
  .ecwd_iframe_update_premium{
    cursor: pointer;
    color: #2980b9;
    padding: 10px;
  }
  .ecwd_shortcode_buttons{
    padding: 10px;
  }
  .ecwd_shortcode_header h1{
    color: #444;
    font-size: 18px;
    font-weight: 600;
    line-height: 36px;
    margin: 0;
    padding: 5px 36px 5px 16px;
  }
  .ecwd_tab{
    display: none;
  }
  .ecwd_shortcode_content .ecwd_active_tab{
    display: block;
  }
  .ecwd_shortcode{
    background-color: #fff;
  }
  .ecwd_shortcode_notice{
    margin-left: 196px;
    margin-top: 0px;
  }
  .ecwd_shortcode_params{
    padding: 12px;
  }
  .ecwd_shortcode_content *{
    font-size: 14px;
  }
  .ecwd_shortcode_content{
      margin-top: 5px;
  }
  .ecwd_shortcode_params label{
    display: inline-block;
  }
  .ecwd_shortcode_content{
    background: #fff;
  }
  .ecwd_shortcode_header{
    background: #ffffff;
    /*border-bottom: 1px solid #ddd;*/
    padding: 0;
    min-height: 36px;
  }
  .ecwd_shortcode_menu{
    background: #FFF;
    display: block;
    border-bottom: 1px solid #e6e6e6;
    height: 35px;
  }
  .ecwd_shortcode_menu div{
    float:left;
    border-left: 1px solid #e6e6e6;
    background: #ffffff;
    padding: 11px 8px;
    text-shadow: 0 1px 1px rgba(255,255,255,0.75);
    height: 13px;
    cursor: pointer;
    text-align: center;
    width: 82px;
  }
  .ecwd_shortcode_menu .ecwd_active_shortcode_menu{
    background: #FDFDFD;
    border-bottom-color: transparent;
    margin-bottom: -1px;
    height: 12px;
    border-top: 2px solid #1b7aa6;
  }
  .ecwd_shortcode_menu .ecwd_active_shortcode_menu:focus{
    box-shadow: 0 0 0 1px #5b9dd9, 0 0 2px 1px rgba(30,140,190,.8);
  }
.ecwd_shortcode_menu:after{
  content: '';
  clear:both;
  display: table;
}


  .button,
  .button-primary,
  .button-secondary {
    display: inline-block;
    text-decoration: none;
    font-size: 13px;
    line-height: 26px;
    height: 28px;
    margin: 0;
    padding: 0 10px 1px;
    cursor: pointer;
    border-width: 1px;
    border-style: solid;
    -webkit-appearance: none;
    -webkit-border-radius: 3px;
    border-radius: 3px;
    white-space: nowrap;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
  }

  .button,
  .button-secondary {
    color: #555;
    border-color: #cccccc;
    background: #f7f7f7;
    -webkit-box-shadow: inset 0 1px 0 #fff, 0 1px 0 rgba(0,0,0,.08);
    box-shadow: inset 0 1px 0 #fff, 0 1px 0 rgba(0,0,0,.08);
    vertical-align: top;
  }

  p .button {
    vertical-align: baseline;
  }

  .button:hover,
  .button-secondary:hover,
  .button:focus,
  .button-secondary:focus {
    background: #fafafa;
    border-color: #999;
    color: #222;
  }

  .button:focus,
  .button-secondary:focus {
    -webkit-box-shadow: 1px 1px 1px rgba(0,0,0,.2);
    box-shadow: 1px 1px 1px rgba(0,0,0,.2);
  }

  .button:active,
  .button-secondary:active {
    background: #eee;
    border-color: #999;
    color: #333;
    -webkit-box-shadow: inset 0 2px 5px -3px rgba( 0, 0, 0, 0.5 );
    box-shadow: inset 0 2px 5px -3px rgba( 0, 0, 0, 0.5 );
  }

  .button-primary {
    background: #2ea2cc;
    border-color: #0074a2;
    -webkit-box-shadow: inset 0 1px 0 rgba(120,200,230,0.5), 0 1px 0 rgba(0,0,0,.15);
    box-shadow: inset 0 1px 0 rgba(120,200,230,0.5), 0 1px 0 rgba(0,0,0,.15);
    color: #fff;
    text-decoration: none;
  }

  .button-primary:hover,
  .button-primary:focus {
    background: #1e8cbe;
    border-color: #0074a2;
    -webkit-box-shadow: inset 0 1px 0 rgba(120,200,230,0.6);
    box-shadow: inset 0 1px 0 rgba(120,200,230,0.6);
    color: #fff;
  }

  .button-primary:focus {
    border-color: #0e3950;
    -webkit-box-shadow: inset 0 1px 0 rgba(120,200,230,0.6), 1px 1px 2px rgba(0,0,0,0.4);
    box-shadow: inset 0 1px 0 rgba(120,200,230,0.6), 1px 1px 2px rgba(0,0,0,0.4);
  }

  .button-primary:active {
    background: #1b7aa6;
    border-color: #005684;
    color: rgba(255,255,255,0.95);
    -webkit-box-shadow: inset 0 1px 0 rgba(0,0,0,0.1);
    box-shadow: inset 0 1px 0 rgba(0,0,0,0.1);
    vertical-align: top;
  }

  .ecwd_shortcode_buttons{
      float:right;
  }

  #ecwd_shortcode_form{
      font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
  }

    #ecwd_shortcode_form .ecwd_general_menu select,
    #ecwd_shortcode_form .ecwd_general_menu input[type="text"]{
        width: 190px;
    }

  #ecwd_shortcode_form .ecwd_general_menu .ecwd_shortcode_params label {
      width: 180px;
  }

  #ecwd_shortcode_form .ecwd_views_menu select{
      width: 310px;
  }

  #ecwd_shortcode_form .ecwd_views_menu .ecwd_shortcode_params label {
      width: 60px;
  }

  #ecwd_shortcode_form .ecwd_filters_menu select{
      width: 310px;
  }

  #ecwd_shortcode_form .ecwd_filters_menu .ecwd_shortcode_params label {
      width: 60px;
  }

  #ecwd_shortcode_form .ecwd_filters_menu .ecwd_no_filter_text{
      margin-left: 12px;
  }

    #ecwd_shortcode_form select,
    #ecwd_shortcode_form input[type="text"]{
        height: 22px;
    }

    .ecwd_shortcode_menu_item.ecwd_active_shortcode_menu[data-menu_name="ecwd_filters_menu"]{
        border-right: 1px solid #c5c5c5;
    }

</style>
<script>
  jQuery(".ecwd_shortcode_menu_item").click(function () {
    jQuery(".ecwd_shortcode_menu_item").removeClass("ecwd_active_shortcode_menu");
    jQuery(this).addClass("ecwd_active_shortcode_menu");
    jQuery(".ecwd_shortcode_content .ecwd_tab").removeClass("ecwd_active_tab");
    var ecwd_tab_name = jQuery(this).data("menu_name");
    jQuery("."+ecwd_tab_name).addClass("ecwd_active_tab");
  });
  jQuery(".ecwd_close_iframe").click(function (e) {
    e.preventDefault();
  });

  jQuery(".ecwd_add_shortcode").click(function (e) {
    e.preventDefault();
    var ecwd_shortcode_data =  jQuery("#ecwd_shortcode_form").serializeArray();
    window.parent['wdg_cb_tw/ecwd'](ecwd_generate_ecwd_shortcode(ecwd_shortcode_data));
  });

  function ecwd_generate_ecwd_shortcode(data) {
    var ecwd_view = '';
    var ecwd_filter = '';
    var ecwd_calendar = '%s';
    var page_items = '5';
    var event_search = '';
    var display = 'full';
    var ecwd_calendar_start_date = '';
    for(i in data){
      var param_name = data[i].name;
      var param_value = data[i].value;
      if(param_name === "ecwd_select_calendar"){
        var ecwd_calendar = param_value;
      }
      if(param_name === "ecwd_per_page_count"){
        var page_items = param_value;
      }
      if(param_name === "ecwd_calendar_start_date"){
        var ecwd_calendar_start_date =param_value;
      }
      if(param_name === "ecwd_event_search"){
        var event_search = "yes";
      }
      if(param_name === "ecwd_select_view_type"){
        var display = param_value;
      }
      if(param_name === "ecwd_view_[]"){
        if(ecwd_view === ""){
          ecwd_view += param_value;
        }else{
          ecwd_view += ","+param_value;
        }
      }
      if(param_name === "ecwd_filter_[]"){
        if(ecwd_filter === ""){
          ecwd_filter += param_value;
        }else{
          ecwd_filter += ","+param_value;
        }
      }
    }

    var ecwd_shortcode = '[ecwd id="'+ecwd_calendar+'" type="'+display+'" page_items="'+page_items+'" calendar_start_date="'+ecwd_calendar_start_date+'" event_search="'+event_search+'" display="'+display+'" displays="'+ecwd_view+'" filters="'+ecwd_filter+'" ]'
    return ecwd_shortcode;
  }
</script>