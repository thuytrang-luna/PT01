<?php

/**
 * Class FMViewForm_maker_fmc
 */
class FMViewForm_maker_fmc {
  /**
   * PLUGIN = 2 points to Contact Form Maker
   */
  const PLUGIN = 2;

  private $model;

  /**
   * FMViewForm_maker constructor.
   *
   * @param $model
   */
  private $fm_nonce = null;
  public function __construct( $model = array() ) {
    $this->fm_nonce = wp_create_nonce('fm_ajax_nonce');
    $this->model = $model;
  }

  /**
   * Display.
   *
   * @param array  $result
   * @param array  $fm_settings
   * @param int    $form_id
   * @param string $formType
   *
   * @return string
   */
  public function display( $result = array(), $fm_settings = array(), $form_id = 0, $formType = 'embedded' ) {
	WDFMInstance(self::PLUGIN)->fm_form_nonce = sprintf( WDFMInstance(self::PLUGIN)->fm_form_nonce, $form_id );
	if ( $form_id ) {
		WDW_FM_Library(self::PLUGIN)->start_session();
		$_SESSION['fm_empty_field_validation' . $form_id] = md5(uniqid(rand(), TRUE));
	}

    if ( $fm_settings['fm_developer_mode'] ) {
      wp_enqueue_style(WDFMInstance(self::PLUGIN)->handle_prefix . '-icons', WDFMInstance(self::PLUGIN)->plugin_url . '/css/fonts.css', array(), '1.0.1');
    }

    if ( !WDW_FM_Library(self::PLUGIN)->elementor_is_active() ) {
      wp_enqueue_style(WDFMInstance(self::PLUGIN)->handle_prefix . '-frontend');
      wp_enqueue_script(WDFMInstance(self::PLUGIN)->handle_prefix . '-frontend');
    }
    $current_user = wp_get_current_user();
    if ( $current_user->ID != 0 ) {
      $wp_username = $current_user->display_name;
      $wp_useremail = $current_user->user_email;
    }
    else {
      $wp_username = '';
      $wp_useremail = '';
    }
    $current_url = htmlentities($_SERVER['REQUEST_URI']);

    $row = $result[0];
    if ( !isset($row->header_hide) ) {
      $row->header_hide = 1;
    }
    $form_theme = $result[4];

    $theme_id = WDW_FM_Library(self::PLUGIN)->get('test_theme', $row->theme);
    if ( $theme_id == '' ) {
      $theme_id = $row->theme;
    }

    $header_pos = isset($form_theme['HPAlign']) && ($form_theme['HPAlign'] == 'left' || $form_theme['HPAlign'] == 'right') ? (($row->header_title || $row->header_description || $row->header_image_url) ? 'header_left_right' : 'no_header') : '';
    $pagination_align = $row->pagination == 'steps' && isset($form_theme['PSAPAlign']) ? 'fm-align-' . $form_theme['PSAPAlign'] : '';
    $form_currency = '$';
    if ( $row->payment_currency ) {
      $form_currency = WDW_FM_Library(self::PLUGIN)->replace_currency_code( $row->payment_currency );
    }
    WDW_FM_Library(self::PLUGIN)->start_session();
    $form_maker_front_end = '';
    $form_maker_front_end .= '<div id="fm-pages' . $form_id . '" class="fm-pages wdform_page_navigation ' . $pagination_align . '" show_title="' . $row->show_title . '" show_numbers="' . $row->show_numbers . '" type="' . $row->pagination . '"></div>';
    $form_maker_front_end .= '<form name="form' . $form_id . '" action="' . $current_url . '" method="post" id="form' . $form_id . '" class="fm-form form' . $form_id . ' ' . $header_pos . ' ' . (((isset($_SESSION['form_submit_type' . $form_id]) && $_SESSION['form_submit_type' . $form_id]) || (isset($_SESSION['massage_after_submit' . $form_id]) && $_SESSION['massage_after_submit' . $form_id])) ? 'fm-form-submitted' : '') . '" enctype="multipart/form-data">';
    // Form messages.
    $fm_hide_form_after_submit = 0;
    if ( isset($_SESSION['form_submit_type' . $form_id]) ) {
      $type_and_id = $_SESSION['form_submit_type' . $form_id];
      $type_and_id = explode(',', $type_and_id);
      $form_get_type = $type_and_id[0];
      $form_get_id = isset($type_and_id[1]) ? $type_and_id[1] : '';
      $group_id = isset($type_and_id[2]) ? $type_and_id[2] : '';
      $_SESSION['form_submit_type' . $form_id] = 0;
      if ( $form_get_type == 3 ) {
        $_SESSION['massage_after_submit' . $form_id] = "";
        $after_submission_text = $this->model->get_after_submission_text($form_get_id, $group_id);
        $form_maker_front_end .= WDW_FM_Library(self::PLUGIN)->message(wpautop(html_entity_decode($after_submission_text)), '', $form_id);
        $fm_hide_form_after_submit = 1;
      }
    }
    if ( isset($_SESSION['redirect_paypal' . $form_id]) && ($_SESSION['redirect_paypal' . $form_id] == 1) ) {
      $_SESSION['redirect_paypal' . $form_id] = 0;
      if ( isset($_GET['succes']) ) {
        if ( $_GET['succes'] == 0 ) {
          $form_maker_front_end .= WDW_FM_Library(self::PLUGIN)->message(__('Error, email was not sent.', WDFMInstance(self::PLUGIN)->prefix), 'fm-notice-error');
        }
        else {
          $form_maker_front_end .= WDW_FM_Library(self::PLUGIN)->message(__('Your form was successfully submitted.', WDFMInstance(self::PLUGIN)->prefix), 'fm-notice-success');
        }
      }
    }
    elseif ( isset($_SESSION['massage_after_submit' . $form_id]) && $_SESSION['massage_after_submit' . $form_id] != "" ) {
      $message = $_SESSION['massage_after_submit' . $form_id];
      $_SESSION['massage_after_submit' . $form_id] = "";
      if ( $_SESSION['error_or_no' . $form_id] ) {
        $error = 'fm-notice-error';
      }
      else {
        $error = 'fm-notice-success';
      }
      if ( !isset($_SESSION['message_captcha']) || $message != $_SESSION['message_captcha'] ) {
        if( is_array($message) ) {
          foreach( $message as $msg ) {
            $form_maker_front_end .= WDW_FM_Library(self::PLUGIN)->message($msg, $error, $form_id);
          }
        }
        else {
          $form_maker_front_end .= WDW_FM_Library(self::PLUGIN)->message($message, $error, $form_id);
        }
      }
    }
    if ( isset($_SESSION['massage_after_save' . $form_id]) && $_SESSION['massage_after_save' . $form_id] != "" ) {
      $save_message = $_SESSION['massage_after_save' . $form_id];
      $_SESSION['massage_after_save' . $form_id] = '';
      if ( isset($_SESSION['save_error' . $form_id]) && $_SESSION['save_error' . $form_id] == 2 ) {
        echo $save_message;
      }
      else {
        $save_error = $_SESSION['save_error' . $form_id] ? 'fm-notice-error' : 'fm-notice-success';
        $form_maker_front_end .= WDW_FM_Library(self::PLUGIN)->message($save_message, $save_error, $form_id);
      }
    }
    if ( isset($_SESSION['show_submit_text' . $form_id]) ) {
      if ( $_SESSION['show_submit_text' . $form_id] == 1 ) {
        $_SESSION['show_submit_text' . $form_id] = 0;
        $form_maker_front_end .= $row->submit_text;
      }
    }
    if ( isset($_SESSION['fm_hide_form_after_submit' . $form_id]) && $_SESSION['fm_hide_form_after_submit' . $form_id] == 1 ) {
      $_SESSION['fm_hide_form_after_submit' . $form_id] = 0;
      $fm_hide_form_after_submit = 1;
    }

    $form_maker_front_end .= '<input type="hidden" id="counter' . $form_id . '" value="' . $row->counter . '" name="counter' . $form_id . '" />';
    $form_maker_front_end .= '<input type="hidden" id="Itemid' . $form_id . '" value="" name="Itemid' . $form_id . '" />';
    $form_maker_front_end .= '<input type="text" class="fm-hide" id="fm_bot_validation' . $form_id . '" value="" name="fm_bot_validation' . $form_id . '" />';
    if( !empty($_SESSION['fm_empty_field_validation' . $form_id]) ) {
      $form_maker_front_end .= '<input type="text" class="fm-hide" id="fm_empty_field_validation' . $form_id . '" value="" name="fm_empty_field_validation' . $form_id . '" data-value="' . $_SESSION['fm_empty_field_validation' . $form_id] . '" />';
    }
    if (isset($fm_settings['fm_ajax_submit']) && $fm_settings['fm_ajax_submit']) {
      $form_submit_url = add_query_arg( array(
        'action' => 'fmc_submit_form',
        'current_id' => $form_id,
        'formType' =>  $formType ), admin_url('admin-ajax.php'));
      $form_maker_front_end .= '<input type="hidden" id="fm_ajax_url' . $form_id.'" data-ajax_url="'. $form_submit_url .'" />';
      if($row->submit_text_type == 1 || $row->submit_text_type == 3) {
        $action_after_sub = 0;
      } else {
        $action_after_sub = $row->article_id;
      }
      $form_maker_front_end .= '<input type="hidden" id="fm_ajax_redirect_url' . $form_id.'" data-ajax_redirect_url="'. $action_after_sub .'" />';
    }
    $form_maker_front_end .= $this->get_nonce_field();

    if ( !$fm_hide_form_after_submit ) {
      if( $row->header_hide ) {
        // Form header.
        $image_pos = isset($form_theme['HIPAlign']) && ($form_theme['HIPAlign'] == 'left' || $form_theme['HIPAlign'] == 'right') ? 'image_left_right' : '';
        $image_width = isset($form_theme['HIPWidth']) && $form_theme['HIPWidth'] ? 'width="' . $form_theme['HIPWidth'] . 'px"' : '';
        $image_height = isset($form_theme['HIPHeight']) && $form_theme['HIPHeight'] ? 'height="' . $form_theme['HIPHeight'] . 'px"' : '';
        $hide_header_image_class = wp_is_mobile() && $row->header_hide_image ? 'fm_hide_mobile' : '';
        $header_image_animation = $formType == 'embedded' ? $row->header_image_animation : '';
        if ( !isset($form_theme['HPAlign']) || ($form_theme['HPAlign'] == 'left' || $form_theme['HPAlign'] == 'top') ) {
          if ( $row->header_title || $row->header_description || $row->header_image_url ) {
            $form_maker_front_end .= '<div class="fm-header-bg"><div class="fm-header ' . $image_pos . '">';
            if ( !isset($form_theme['HIPAlign']) || $form_theme['HIPAlign'] == 'left' || $form_theme['HIPAlign'] == 'top' ) {
              if ( $row->header_image_url ) {
                $form_maker_front_end .= '<div class="fm-header-img ' . $hide_header_image_class . ' fm-animated ' . $header_image_animation . '"><img src="' . $row->header_image_url . '" ' . $image_width . ' ' . $image_height . '/></div>';
              }
            }
            if ( $row->header_title || $row->header_description ) {
              $form_maker_front_end .= '<div class="fm-header-text">
          <div class="fm-header-title">
            ' . $row->header_title . '
          </div>
          <div class="fm-header-description">
            ' . $row->header_description . '
          </div>
        </div>';
            }
            if ( isset($form_theme['HIPAlign']) && ($form_theme['HIPAlign'] == 'right' || $form_theme['HIPAlign'] == 'bottom') ) {
              if ( $row->header_image_url ) {
                $form_maker_front_end .= '<div class="fm-header-img"><img src="' . $row->header_image_url . '" ' . $image_width . ' ' . $image_height . '/></div>';
              }
            }
            $form_maker_front_end .= '</div></div>';
          }
        }
      }
    }

    $is_type = array();
    $id1s = array();
    $types = array();
    $labels = array();
    $paramss = array();
    $fields = explode('*:*new_field*:*', $row->form_fields);
    $fields = array_slice($fields, 0, count($fields) - 1);
    foreach ( $fields as $field ) {
      $temp = explode('*:*id*:*', $field);
      array_push($id1s, $temp[0]);
      $temp = explode('*:*type*:*', $temp[1]);
      array_push($types, $temp[0]);
      $temp = explode('*:*w_field_label*:*', $temp[1]);
      array_push($labels, $temp[0]);
      array_push($paramss, $temp[1]);
    }

    $symbol_begin = array();
    $symbol_end = array();

    // Get extension Calculator data.
    $calculator_data = array();
    if (WDFMInstance(self::PLUGIN)->is_free != 2) {
      $calculator_data = apply_filters('fm_calculator_get_data_init', $calculator_data, $form_id);
    }
    if ( !empty($calculator_data) ) {
      $symbol_end = json_decode($calculator_data->symbol_end, TRUE);
      $symbol_begin = json_decode($calculator_data->symbol_begin, TRUE);
    }

    if ( $row->autogen_layout == 0 ) {
      $form = $row->custom_front;
    }
    else {
      $form = $row->form_front;
    }

    $privacy = json_decode($row->privacy);
    $row->gdpr_checkbox = isset($privacy->gdpr_checkbox) ? $privacy->gdpr_checkbox : 0;
    $row->gdpr_checkbox_text = isset($privacy->gdpr_checkbox_text) ? $privacy->gdpr_checkbox_text : __('I consent collecting this data and processing it according to {{privacy_policy}} of this website.', WDFMInstance(self::PLUGIN)->prefix);

    // Remove unnecessary classes.
    $form = str_replace(array('ui-sortable-handle', 'ui-sortable-disabled', 'ui-sortable'), '', $form);
    foreach ( $id1s as $id1s_key => $id1 ) {
      $label = $labels[$id1s_key];
      $type = $types[$id1s_key];
      $params = $paramss[$id1s_key];
      if ( strpos($form, '%' . $id1 . ' - ' . $label . '%') || strpos($form, '%' . $id1 . ' -' . $label . '%') ) {
        $rep = '';
        $param = array();
        $param['label'] = $label;
        $param['attributes'] = '';
        $is_type[$type] = TRUE;
        switch ( $type ) {
          case 'type_section_break': {
            $params_names = array( 'w_editor' );
            $temp = $params;
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $rep = '<div type="type_section_break" class="wdform-field-section-break"><div class="wdform_section_break">' . html_entity_decode($param['w_editor']) . '</div></div>';
            break;
          }
          case 'type_editor': {
            $params_names = array( 'w_editor' );
            $temp = $params;
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $rep = '<div type="type_editor" class="wdform-field">' . html_entity_decode($param['w_editor']) . '</div>';
            break;
          }
          case 'type_send_copy': {
            $params_names = array( 'w_field_label_size', 'w_field_label_pos', 'w_first_val', 'w_required' );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_first_val',
                'w_required',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            if ( $temp ) {
              $temp = explode('*:*w_attr_name*:*', $temp);
              $attrs = array_slice($temp, 0, count($temp) - 1);
              foreach ( $attrs as $attr ) {
                $param['attributes'] = $param['attributes'] . ' ' . $attr;
              }
            }
            $input_active = ($param['w_first_val'] == 'true' ? "checked='checked'" : "");
            if ( isset($_POST["counter" . $form_id]) ) {
              $input_active = (isset($_POST['wdform_' . $id1 . '_element' . $form_id]) ? "checked='checked'" : "");
            }
            $param['id'] = $id1;
            $param['w_class'] = ' checkbox-div wd-flex-row-reverse wd-align-items-center wd-justify-content-right';

            // Use label size as field size.
            $param['w_size'] = $param['w_field_label_size'];
            $html = '<input type="checkbox"
                             class="wd-flex-row"
                             id="wdform_' . $id1 . '_element' . $form_id . '"
                             name="wdform_' . $id1 . '_element' . $form_id . '"
                             ' . $input_active . '
                             ' . $param['attributes'] . ' />';
            $html .= '<label class="wd-align-items-center wd-flex wd-flex-row-reverse" for="wdform_' . $id1 . '_element' . $form_id . '" class="wdform-label"><span></span>' . $param['label'] . '</label>';
            if ( isset($param['w_required']) && $param['w_required'] == "yes" ) {
              $requiredmark = isset($row->requiredmark) ? $row->requiredmark : '';
              $html .= '<span class="wdform-required">' . $requiredmark . '</span>';
            }


            // Generate field.
            $rep = $this->wdform_field($type, $param, $row, $html, FALSE);

            break;
          }
          case 'type_text': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_size',
              'w_first_val',
              'w_title',
              'w_required',
              'w_unique',
            );
            $temp = $params;
            if ( strpos($temp, 'w_regExp_status') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_size',
                'w_first_val',
                'w_title',
                'w_required',
                'w_regExp_status',
                'w_regExp_value',
                'w_regExp_common',
                'w_regExp_arg',
                'w_regExp_alert',
                'w_unique',
              );
            }
            if ( strpos($temp, 'w_readonly') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_size',
                'w_first_val',
                'w_title',
                'w_required',
                'w_regExp_status',
                'w_regExp_value',
                'w_regExp_common',
                'w_regExp_arg',
                'w_regExp_alert',
                'w_unique',
                'w_readonly',
              );
            }
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_size',
                'w_first_val',
                'w_title',
                'w_required',
                'w_regExp_status',
                'w_regExp_value',
                'w_regExp_common',
                'w_regExp_arg',
                'w_regExp_alert',
                'w_unique',
                'w_readonly',
              );
            }
            if ( strpos($temp, 'w_class') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_size',
                'w_first_val',
                'w_title',
                'w_required',
                'w_regExp_status',
                'w_regExp_value',
                'w_regExp_common',
                'w_regExp_arg',
                'w_regExp_alert',
                'w_unique',
                'w_readonly',
                'w_class',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            if ( $temp ) {
              $temp = explode('*:*w_attr_name*:*', $temp);
              $attrs = array_slice($temp, 0, count($temp) - 1);
              foreach ( $attrs as $attr ) {
                $param['attributes'] = $param['attributes'] . ' ' . $attr;
              }
            }
            $param['w_first_val'] = (isset($_POST['wdform_' . $id1 . '_element' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . '_element' . $form_id])) : $param['w_first_val']);
            $param['w_regExp_status'] = (isset($param['w_regExp_status']) ? $param['w_regExp_status'] : "no");
            $readonly = (isset($param['w_readonly']) && $param['w_readonly'] == "yes" ? "readonly='readonly'" : '');
            $param['w_class'] = (isset($param['w_class']) ? $param['w_class'] : "");
            $param['id'] = $id1;
            $param['w_class'] .= ' wd-flex-row wd-align-items-center';

            $html = '';
            if ( isset($symbol_begin[$id1]) ) {
              $html .= '<span>' . $symbol_begin[$id1] . '</span>&nbsp;';
            }
            $html .= '<input type="text"
                           class="wd-width-100"
                           id="wdform_' . $id1 . '_element' . $form_id . '"
                           name="wdform_' . $id1 . '_element' . $form_id . '"
                           value="' . htmlentities($param['w_first_val'], ENT_COMPAT) . '"
                           title="' . htmlentities($param['w_title'], ENT_COMPAT) . '"
                           placeholder="' . htmlentities($param['w_title'], ENT_COMPAT) . '"
                           ' . $readonly . '
                           ' . $param['attributes'] . ' />';
            if ( isset($symbol_end[$id1]) ) {
              $html .= '&nbsp;<span>' . $symbol_end[$id1] . '</span>';
            }

            // Generate field.
            $rep = $this->wdform_field($type, $param, $row, $html);

            break;
          }
          case 'type_number': { // To do: deprecated
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_size',
              'w_first_val',
              'w_title',
              'w_required',
              'w_unique',
              'w_class',
            );
            $temp = $params;
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            if ( $temp ) {
              $temp = explode('*:*w_attr_name*:*', $temp);
              $attrs = array_slice($temp, 0, count($temp) - 1);
              foreach ( $attrs as $attr ) {
                $param['attributes'] = $param['attributes'] . ' ' . $attr;
              }
            }
            $param['w_first_val'] = (isset($_POST['wdform_' . $id1 . '_element' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . '_element' . $form_id])) : $param['w_first_val']);
            $wdformfieldsize = ($param['w_field_label_pos'] == "left" ? $param['w_field_label_size'] + $param['w_size'] + 10 : max($param['w_field_label_size'], $param['w_size']));
            $param['id'] = $id1;

            $rep = '<div type="type_number" class="wdform-field" style="width: ' . $wdformfieldsize . 'px">';

            $rep .= $this->field_label($param, $row);

            $classes = array('wdform-element-section');
            if ( isset($param['w_class']) ) {
              $classes[] = $param['w_class'];
            }
            if ( isset($param['w_field_label_pos']) && $param['w_field_label_pos'] != "left" ) {
              $classes[] = 'wd-block';
            }

            $rep .= '<div class="' . implode(' ', $classes) . '" style="width: ' . $param['w_size'] . 'px;">
              <input type="text"
                     class="wd-width-100"
                     id="wdform_' . $id1 . '_element' . $form_id . '"
                     name="wdform_' . $id1 . '_element' . $form_id . '"
                     value="' . htmlentities($param['w_first_val'], ENT_COMPAT) . '"
                     title="' . htmlentities($param['w_title'], ENT_COMPAT) . '"
                     ' . $param['attributes'] . '>
              </div>';
            $rep .= '</div>';
            break;
          }
          case 'type_password': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_size',
              'w_required',
              'w_unique',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_size',
                'w_required',
                'w_unique',
                'w_class',
              );
            }
            if ( strpos($temp, 'w_verification') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_size',
                'w_required',
                'w_unique',
                'w_class',
                'w_verification',
                'w_verification_label',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            if ( $temp ) {
              $temp = explode('*:*w_attr_name*:*', $temp);
              $attrs = array_slice($temp, 0, count($temp) - 1);
              foreach ( $attrs as $attr ) {
                $param['attributes'] = $param['attributes'] . ' ' . $attr;
              }
            }
            $param['id'] = $id1;

            $message_confirm = addslashes(__("Password values don't match", WDFMInstance(self::PLUGIN)->prefix));
            $onchange = (isset($param['w_verification']) && $param['w_verification'] == "yes") ? ' onchange="wd_check_confirmation_pass(\'' . $id1 . '\', \'' . $form_id . '\', \'' . $message_confirm . '\')"' : "";

            $html = '<input type="password"
                   class="wd-width-100"
                   id="wdform_' . $id1 . '_element' . $form_id . '"
                   name="wdform_' . $id1 . '_element' . $form_id . '"
                   ' . $param['attributes'] . $onchange . ' />';
            // Generate field.
            $rep = $this->wdform_field($type, $param, $row, $html);
            if ( isset($param['w_verification']) && $param['w_verification'] == "yes" ) {
              $param['label'] = $param['w_verification_label'];
              $param['id'] = 'wdform_' . $id1 . '_1_element' . $form_id;
              $param['label'] = $param['w_verification_label'];

              $html = '<input type="password"
                     class="wd-width-100"
                     id="wdform_' . $id1 . '_1_element' . $form_id . '"
                     name="wdform_' . $id1 . '_1_element' . $form_id . '"
                     ' . $param['attributes'] . '
                     onchange="wd_check_confirmation_pass(\'' . $id1 . '\', \'' . $form_id . '\', \'' . $message_confirm . '\')" />';
              // Generate field.
              $rep .= $this->wdform_field('type_password_confirmation', $param, $row, $html);
            }

            break;
          }
          case 'type_textarea': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_size_w',
              'w_size_h',
              'w_first_val',
              'w_title',
              'w_required',
              'w_unique',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_size_w',
                'w_size_h',
                'w_first_val',
                'w_title',
                'w_required',
                'w_unique',
                'w_class',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            if ( $temp ) {
              $temp = explode('*:*w_attr_name*:*', $temp);
              $attrs = array_slice($temp, 0, count($temp) - 1);
              foreach ( $attrs as $attr ) {
                $param['attributes'] = $param['attributes'] . ' ' . $attr;
              }
            }
            $param['w_first_val'] = (isset($_POST['wdform_' . $id1 . '_element' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . '_element' . $form_id])) : $param['w_first_val']);
            $textarea_value = str_replace(array( "\r\n", "\n\r", "\n", "\r" ), "&#13;", $param['w_first_val']);

            $param['id'] = $id1;
            $param['w_size'] = $param['w_size_w'];

            $html = '<textarea class="wd-width-100"
                      id="wdform_' . $id1 . '_element' . $form_id . '"
                      name="wdform_' . $id1 . '_element' . $form_id . '"
                      placeholder="' . htmlentities($param['w_title'], ENT_COMPAT) . '"
                      style="height: ' . $param['w_size_h'] . 'px;"
                      ' . $param['attributes'] . '>' . $textarea_value . '</textarea>';

            // Generate field.
            $rep = $this->wdform_field($type, $param, $row, $html);

            break;
          }
          case 'type_phone': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_size',
              'w_first_val',
              'w_title',
              'w_mini_labels',
              'w_required',
              'w_unique',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_size',
                'w_first_val',
                'w_title',
                'w_mini_labels',
                'w_required',
                'w_unique',
                'w_class',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            if ( $temp ) {
              $temp = explode('*:*w_attr_name*:*', $temp);
              $attrs = array_slice($temp, 0, count($temp) - 1);
              foreach ( $attrs as $attr ) {
                $param['attributes'] = $param['attributes'] . ' ' . $attr;
              }
            }
            $w_first_val = explode('***', $param['w_first_val']);
            $w_title = explode('***', $param['w_title']);
            $param['w_first_val'] = (isset($_POST['wdform_' . $id1 . '_element_first' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . '_element_first' . $form_id])) : $w_first_val[0]) . '***' . (isset($_POST['wdform_' . $id1 . '_element_last' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . '_element_last' . $form_id])) : $w_first_val[1]);
            $w_first_val = explode('***', $param['w_first_val']);
            $w_mini_labels = explode('***', $param['w_mini_labels']);

            $param['id'] = 'wdform_' . $id1 . '_element_first' . $form_id;
            $param['w_class'] .= ' wd-flex-row';

            $html = '<div class="wd-flex wd-flex-column wd-width-20">
                <input type="text" class="wd-phone-first" id="wdform_' . $id1 . '_element_first' . $form_id . '" name="wdform_' . $id1 . '_element_first' . $form_id . '" value="' . htmlentities($w_first_val[0], ENT_COMPAT) . '" title="' . htmlentities($w_title[0], ENT_COMPAT) . '" placeholder="' . htmlentities($w_title[0], ENT_COMPAT) . '" ' . $param['attributes'] . '>
                <label for="wdform_' . $id1 . '_element_first' . $form_id . '" class="mini_label wd-flex-column">' . $w_mini_labels[0] . '</label>
              </div>
              <div>
                <div class="wd-flex wd-flex-column ">&nbsp;-&nbsp;</div>
              </div>
              <div class="wd-flex wd-flex-column wd-width-80">
                <input type="text" class="wd-flex-column wd-width-100" id="wdform_' . $id1 . '_element_last' . $form_id . '" name="wdform_' . $id1 . '_element_last' . $form_id . '" value="' . htmlentities($w_first_val[1], ENT_COMPAT) . '" title="' . htmlentities($w_title[1], ENT_COMPAT) . '" placeholder="' . htmlentities($w_title[1], ENT_COMPAT) . '" ' . $param['attributes'] . ' />
                <label for="wdform_' . $id1 . '_element_last' . $form_id . '" class="wd-flex-column mini_label">' . $w_mini_labels[1] . '</label>
              </div>';

            // Generate field.
            $rep = $this->wdform_field($type, $param, $row, $html);

            break;
          }
          case 'type_phone_new': {
			if ( $fm_settings['fm_developer_mode'] ) {
				wp_enqueue_style(WDFMInstance(self::PLUGIN)->handle_prefix . '-phone_field_css');
				wp_enqueue_script(WDFMInstance(self::PLUGIN)->handle_prefix . '-phone_field');
			}
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_hide_label',
              'w_size',
              'w_first_val',
              'w_top_country',
              'w_required',
              'w_unique',
              'w_class',
            );
            $temp = $params;
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            if ( $temp ) {
              $temp = explode('*:*w_attr_name*:*', $temp);
              $attrs = array_slice($temp, 0, count($temp) - 1);
              foreach ( $attrs as $attr ) {
                $param['attributes'] = $param['attributes'] . ' ' . $attr;
              }
            }
            $param['w_first_val'] = (isset($_POST['wdform_' . $id1 . '_element' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . '_element' . $form_id])) : $param['w_first_val']);
            $param['id'] = $id1;

            $html = '<input type="text"
                       class="wd-width-100"
                       id="wdform_' . $id1 . '_element' . $form_id . '"
                       name="wdform_' . $id1 . '_element' . $form_id . '"
                       value="' . htmlentities($param['w_first_val'], ENT_COMPAT) . '"
                       placeholder="" ' . htmlentities($param['attributes'], ENT_COMPAT) . ' />';

            // Generate field.
            $rep = $this->wdform_field($type, $param, $row, $html);

            break;
          }
          case 'type_name': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_first_val',
              'w_title',
              'w_mini_labels',
              'w_size',
              'w_name_format',
              'w_required',
              'w_unique',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_name_fields') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_first_val',
                'w_title',
                'w_mini_labels',
                'w_size',
                'w_name_format',
                'w_required',
                'w_unique',
                'w_class',
                'w_name_fields',
              );
            }
            if ( strpos($temp, 'w_autofill') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_first_val',
                'w_title',
                'w_mini_labels',
                'w_size',
                'w_name_format',
                'w_required',
                'w_unique',
                'w_class',
                'w_name_fields',
                'w_autofill',
              );
            }
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_first_val',
                'w_title',
                'w_mini_labels',
                'w_size',
                'w_name_format',
                'w_required',
                'w_unique',
                'w_class',
                'w_name_fields',
                'w_autofill',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            if ( $temp ) {
              $temp = explode('*:*w_attr_name*:*', $temp);
              $attrs = array_slice($temp, 0, count($temp) - 1);
              foreach ( $attrs as $attr ) {
                $param['attributes'] = $param['attributes'] . ' ' . $attr;
              }
            }
            $w_first_val = explode('***', $param['w_first_val']);
            $w_title = explode('***', $param['w_title']);
            $w_mini_labels = explode('***', $param['w_mini_labels']);
            $param['w_name_fields'] = isset($param['w_name_fields']) ? $param['w_name_fields'] : ($param['w_name_format'] == 'normal' ? 'no***no' : 'yes***yes');
            $w_name_fields = explode('***', $param['w_name_fields']);
            $param['w_autofill'] = isset($param['w_autofill']) ? $param['w_autofill'] : 'no';
            $element_title = isset($_POST['wdform_' . $id1 . '_element_title' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . '_element_title' . $form_id])) : NULL;
            $element_middle = isset($_POST['wdform_' . $id1 . '_element_middle' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . '_element_middle' . $form_id])) : NULL;
            $element_first = isset($_POST['wdform_' . $id1 . '_element_first' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . '_element_first' . $form_id])) : NULL;
            if ( isset($element_title) || isset($element_middle) ) {
              $param['w_first_val'] = (isset($_POST['wdform_' . $id1 . '_element_first' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . '_element_first' . $form_id])) : $w_first_val[0]) . '***' . (isset($_POST['wdform_' . $id1 . '_element_last' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . '_element_last' . $form_id])) : $w_first_val[1]) . '***' . (isset($_POST['wdform_' . $id1 . '_element_title' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . '_element_title' . $form_id])) : $w_first_val[2]) . '***' . (isset($_POST['wdform_' . $id1 . '_element_middle' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . '_element_middle' . $form_id])) : $w_first_val[3]);
            }
            else {
              if ( isset($element_first) ) {
                $param['w_first_val'] = (isset($_POST['wdform_' . $id1 . '_element_first' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . '_element_first' . $form_id])) : $w_first_val[0]) . '***' . (isset($_POST['wdform_' . $id1 . '_element_last' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . '_element_last' . $form_id])) : $w_first_val[1]);
              }
            }
            $w_first_val = explode('***', $param['w_first_val']);
            if ( $param['w_autofill'] == 'yes' && $wp_username ) {
              $user_display_name = explode(' ', $wp_username);
              $w_first_val[0] = $user_display_name[0];
              $w_first_val[1] = isset($user_display_name[1]) ? $user_display_name[1] : $w_first_val[1];
            }

            $first_field_id = 'wdform_' . $id1 . '_element_first' . $form_id;
            $html = '';
            if ( $w_name_fields[0] == 'yes' ) {
              $first_field_id = 'wdform_' . $id1 . '_element_title' . $form_id;
              $html .= '<div class="wd-flex wd-flex-column wd-width-10">';
              $html .= '<input type="text" id="wdform_' . $id1 . '_element_title' . $form_id . '" name="wdform_' . $id1 . '_element_title' . $form_id . '" value="' . htmlentities($w_first_val[2], ENT_COMPAT) . '" title="' . htmlentities($w_title[2], ENT_COMPAT) . '" placeholder="' . htmlentities($w_title[2], ENT_COMPAT) . '" />';
              $html .= '<label class="mini_label" for="wdform_' . $id1 . '_element_title' . $form_id . '">' . $w_mini_labels[0] . '</label>';
              $html .= '</div>';
              $html .= '<div class="wd-flex wd-flex-column wd-name-separator"></div>';
            }
            $html .= '<div class="wd-flex wd-flex-column wd-width-50">';
            $html .= '<input type="text" class="wd-width-100" id="wdform_' . $id1 . '_element_first' . $form_id . '" name="wdform_' . $id1 . '_element_first' . $form_id . '" value="' . htmlentities($w_first_val[0], ENT_COMPAT) . '" title="' . htmlentities($w_title[0], ENT_COMPAT) . '" placeholder="' . htmlentities($w_title[0], ENT_COMPAT) . '" ' . $param['attributes'] . ' />';
            $html .= '<label class="mini_label" for="wdform_' . $id1 . '_element_first' . $form_id . '">' . $w_mini_labels[1] . '</label>';
            $html .= '</div>';
            $html .= '<div class="wd-flex wd-flex-column wd-name-separator"></div>';
            $html .= '<div class="wd-flex wd-flex-column wd-width-50">';
            $html .= '<input type="text" class="wd-width-100" id="wdform_' . $id1 . '_element_last' . $form_id . '" name="wdform_' . $id1 . '_element_last' . $form_id . '" value="' . htmlentities($w_first_val[1], ENT_COMPAT) . '" title="' . htmlentities($w_title[1], ENT_COMPAT) . '" placeholder="' . htmlentities($w_title[1], ENT_COMPAT) . '" ' . $param['attributes'] . ' />';
            $html .= '<label class="mini_label" for="wdform_' . $id1 . '_element_last' . $form_id . '">' . $w_mini_labels[2] . '</label>';
            $html .= '</div>';

            if ( $w_name_fields[1] == 'yes' ) {
              $html .= '<div class="wd-flex wd-flex-column wd-name-separator"></div>';
              $html .= '<div class="wd-flex wd-flex-column wd-width-50">';
              $html .= '<input type="text" class="wd-width-100" id="wdform_' . $id1 . '_element_middle' . $form_id . '" name="wdform_' . $id1 . '_element_middle' . $form_id . '" value="' . htmlentities($w_first_val[3], ENT_COMPAT) . '" title="' . htmlentities($w_title[3], ENT_COMPAT) . '" placeholder="' . htmlentities($w_title[3], ENT_COMPAT) . '" />';
              $html .= '<label class="mini_label" for="wdform_' . $id1 . '_element_middle' . $form_id . '">' . $w_mini_labels[3] . '</label>';
              $html .= '</div>';
            }

            $param['id'] = $first_field_id;
            $param['w_class'] .= ' wd-flex-row';

            // Generate field.
            $rep = $this->wdform_field($type, $param, $row, $html);

            break;
          }
          case 'type_address': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_size',
              'w_mini_labels',
              'w_disabled_fields',
              'w_required',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_size',
                'w_mini_labels',
                'w_disabled_fields',
                'w_required',
                'w_class',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            if ( $temp ) {
              $temp = explode('*:*w_attr_name*:*', $temp);
              $attrs = array_slice($temp, 0, count($temp) - 1);
              foreach ( $attrs as $attr ) {
                $param['attributes'] = $param['attributes'] . ' ' . $attr;
              }
            }
            $w_mini_labels = explode('***', $param['w_mini_labels']);
            $w_disabled_fields = explode('***', $param['w_disabled_fields']);

            $param['id'] = 'wdform_' . $id1 . '_street1' . $form_id;
            $param['w_class'] .= ' wd-flex-column';

            $html = '';
            if ( isset($w_disabled_fields[0]) && $w_disabled_fields[0] == 'no' ) {
              $html .= '<span class="wd-width-100 wd-address">
                <input class="wd-width-100" type="text" id="wdform_' . $id1 . '_street1' . $form_id . '" name="wdform_' . $id1 . '_street1' . $form_id . '" value="' . (isset($_POST['wdform_' . $id1 . '_street1' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . '_street1' . $form_id])) : "") . '" ' . $param['attributes'] . ' />
                <label for="wdform_' . $id1 . '_street1' . $form_id . '" class="mini_label">' . $w_mini_labels[0] . '</label></span>';
            }
            if ( isset($w_disabled_fields[1]) && $w_disabled_fields[1] == 'no' ) {
              $html .= '<span class="wd-width-100 wd-address">
                <input class="wd-width-100" type="text" id="wdform_' . $id1 . '_street2' . $form_id . '" name="wdform_' . ($id1 + 1) . '_street2' . $form_id . '" value="' . (isset($_POST['wdform_' . ($id1 + 1) . '_street2' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . ($id1 + 1) . '_street2' . $form_id])) : "") . '" ' . $param['attributes'] . ' />
                <label for="wdform_' . $id1 . '_street2' . $form_id . '" class="mini_label">' . $w_mini_labels[1] . '</label></span>';
            }
            $html .= '<span class="wd-width-100 wd-flex wd-flex-row wd-flex-wrap wd-justify-content">';
            if ( isset($w_disabled_fields[2]) && $w_disabled_fields[2] == 'no' ) {
              $html .= '<span class="wd-width-49 wd-address">
                <input class="wd-width-100" type="text" id="wdform_' . $id1 . '_city' . $form_id . '" name="wdform_' . ($id1 + 2) . '_city' . $form_id . '" value="' . (isset($_POST['wdform_' . ($id1 + 2) . '_city' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . ($id1 + 2) . '_city' . $form_id])) : "") . '" ' . $param['attributes'] . ' />
                <label for="wdform_' . $id1 . '_city' . $form_id . '" class="mini_label">' . $w_mini_labels[2] . '</label></span>';
            }
            $post_country = isset($_POST['wdform_' . ($id1 + 5) . '_country' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . ($id1 + 5) . '_country' . $form_id])) : "";
            if ( isset($w_disabled_fields[3]) && $w_disabled_fields[3] == 'no' ) {
              if ( isset($w_disabled_fields[5]) && $w_disabled_fields[5] == 'no'
                && isset($w_disabled_fields[6]) && $w_disabled_fields[6] == 'yes'
                && $post_country == 'United States' ) {
                $w_states = WDW_FM_Library(self::PLUGIN)->get_states();
                $w_state_options = '';
                $post_state = isset($_POST['wdform_' . ($id1 + 3) . '_state' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . ($id1 + 3) . '_state' . $form_id])) : "";
                foreach ( $w_states as $w_state_key => $w_state ) {
                  $selected = (($w_state_key == $post_state) ? 'selected="selected"' : '');
                  $w_state_options .= '<option value="' . $w_state_key . '" ' . $selected . '>' . $w_state . '</option>';
                }
                $html .= '<span class="wd-width-49 wd-address">
                <select class="wd-width-100" type="text" id="wdform_' . $id1 . '_state' . $form_id . '" name="wdform_' . ($id1 + 3) . '_state' . $form_id . '" ' . $param['attributes'] . '>' . $w_state_options . '</select>
                <label for="wdform_' . $id1 . '_state' . $form_id . '" class="mini_label wd-block" id="' . $id1 . '_mini_label_state">' . $w_mini_labels[3] . '</label></span>';
              }
              else if ( isset($w_disabled_fields[5]) && $w_disabled_fields[5] == 'no'
                && isset($w_disabled_fields[6]) && $w_disabled_fields[6] == 'yes'
                && $post_country == 'Canada' ) {
                $w_states = WDW_FM_Library(self::PLUGIN)->get_provinces_canada();
                $w_state_options = '';
                $post_state = isset($_POST['wdform_' . ($id1 + 3) . '_state' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . ($id1 + 3) . '_state' . $form_id])) : "";
                foreach ( $w_states as $w_state_key => $w_state ) {
                  $selected = (($w_state_key == $post_state) ? 'selected="selected"' : '');
                  $w_state_options .= '<option value="' . $w_state_key . '" ' . $selected . '>' . $w_state . '</option>';
                }
                $html .= '<span class="wd-width-49 wd-address">
                <select class="wd-width-100" type="text" id="wdform_' . $id1 . '_state' . $form_id . '" name="wdform_' . ($id1 + 3) . '_state' . $form_id . '" ' . $param['attributes'] . '>' . $w_state_options . '</select>
                <label for="wdform_' . $id1 . '_state' . $form_id . '" class="mini_label wd-block" id="' . $id1 . '_mini_label_state">' . $w_mini_labels[3] . '</label></span>';
              }
              else {
                $html .= '<span class="wd-width-49 wd-address">
                <input class="wd-width-100" type="text" id="wdform_' . $id1 . '_state' . $form_id . '" name="wdform_' . ($id1 + 3) . '_state' . $form_id . '" value="' . (isset($_POST['wdform_' . ($id1 + 3) . '_state' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . ($id1 + 3) . '_state' . $form_id])) : "") . '" ' . $param['attributes'] . ' />
                <label for="wdform_' . $id1 . '_state' . $form_id . '" class="mini_label">' . $w_mini_labels[3] . '</label></span>';
              }
            }
            if ( isset($w_disabled_fields[4]) && $w_disabled_fields[4] == 'no' ) {
              $html .= '<span class="wd-width-49 wd-address">
              <input class="wd-width-100" type="text" id="wdform_' . $id1 . '_postal' . $form_id . '" name="wdform_' . ($id1 + 4) . '_postal' . $form_id . '" value="' . (isset($_POST['wdform_' . ($id1 + 4) . '_postal' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . ($id1 + 4) . '_postal' . $form_id])) : "") . '" ' . $param['attributes'] . ' />
              <label for="wdform_' . $id1 . '_postal' . $form_id . '" class="mini_label">' . $w_mini_labels[4] . '</label></span>';
            }
            if ( isset($w_disabled_fields[5]) && $w_disabled_fields[5] == 'no' ) {
              $w_countries = WDW_FM_Library(self::PLUGIN)->get_countries();
              $w_options = '';
              foreach ( $w_countries as $w_country_key => $w_country ) {
                if ( $w_country_key == $post_country ) {
                  $selected = 'selected="selected"';
                }
                else {
                  $selected = '';
                }
                $w_options .= '<option value="' . $w_country_key . '" ' . $selected . '>' . $w_country . '</option>';
              }
              $html .= '<span class="wd-width-49 wd-address">
              <select class="wd-width-100"
                      type="text"
                      id="wdform_' . $id1 . '_country' . $form_id . '"
                      name="wdform_' . ($id1 + 5) . '_country' . $form_id . '"
                      ' . (( isset($w_disabled_fields[6]) && $w_disabled_fields[6] == 'yes' ) ? 'onchange="wd_change_state_input(\'wdform_' . $id1 . '\', \'' . $form_id . '\')"' : '') . '
                      ' . $param['attributes'] . '>' . $w_options . '</select>
              <label for="wdform_' . $id1 . '_country' . $form_id . '" class="mini_label">' . $w_mini_labels[5] . '</label></span>';
            }
            $html .= '</span>';

            // Generate field.
            $rep = $this->wdform_field($type, $param, $row, $html);

            break;
          }
          case 'type_submitter_mail': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_size',
              'w_first_val',
              'w_title',
              'w_required',
              'w_unique',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_autofill') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_size',
                'w_first_val',
                'w_title',
                'w_required',
                'w_unique',
                'w_class',
                'w_autofill',
              );
            }
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_size',
                'w_first_val',
                'w_title',
                'w_required',
                'w_unique',
                'w_class',
                'w_autofill',
              );
            }
            if ( strpos($temp, 'w_verification') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_size',
                'w_first_val',
                'w_title',
                'w_required',
                'w_unique',
                'w_class',
                'w_verification',
                'w_verification_label',
                'w_verification_placeholder',
                'w_autofill',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            if ( $temp ) {
              $temp = explode('*:*w_attr_name*:*', $temp);
              $attrs = array_slice($temp, 0, count($temp) - 1);
              foreach ( $attrs as $attr ) {
                $param['attributes'] = $param['attributes'] . ' ' . $attr;
              }
            }

            $param['w_autofill'] = isset($param['w_autofill']) ? $param['w_autofill'] : 'no';
            if ( $param['w_autofill'] == 'yes' && $wp_useremail ) {
              $param['w_first_val'] = (isset($_POST['wdform_' . $id1 . '_element' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . '_element' . $form_id])) : $wp_useremail);
            }
            else {
              $param['w_first_val'] = (isset($_POST['wdform_' . $id1 . '_element' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . '_element' . $form_id])) : $param['w_first_val']);
            }

            $param['id'] = $id1;
            $param['w_class'] .= ' wd-flex-row';

            $message_confirm = addslashes(__("The email addresses don't match", WDFMInstance(self::PLUGIN)->prefix));
            $message_check_email = addslashes(__('This is not a valid email address.', WDFMInstance(self::PLUGIN)->prefix));
            $onchange = (isset($param['w_verification']) && $param['w_verification'] == "yes") ? '; wd_check_confirmation_email(\'' . $id1 . '\', \'' . $form_id . '\', \'' . $message_confirm . '\')' : '';

            $html = '<input type="text" class="wd-width-100" id="wdform_' . $id1 . '_element' . $form_id . '" name="wdform_' . $id1 . '_element' . $form_id . '" value="' . htmlentities($param['w_first_val'], ENT_COMPAT) . '" title="' . htmlentities($param['w_title'], ENT_COMPAT) . '" placeholder="' . htmlentities($param['w_title'], ENT_COMPAT) . '"  ' . $param['attributes'] . ' onchange="wd_check_email(\'' . $id1 . '\', \'' . $form_id . '\', \'' . $message_check_email . '\')' . $onchange . '" />';

            // Generate field.
            $rep = $this->wdform_field($type, $param, $row, $html);

            if ( isset($param['w_verification']) && $param['w_verification'] == "yes" ) {
              $param['w_verification_placeholder'] = (isset($_POST['wdform_' . $id1 . '_1_element' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . '_1_element' . $form_id])) : $param['w_verification_placeholder']);
              $param['label'] = $param['w_verification_label'];
              $param['id'] = 'wdform_' . $id1 . '_1_element' . $form_id;

              $html = '<input type="text" class="wd-width-100" id="wdform_' . $id1 . '_1_element' . $form_id . '" name="wdform_' . $id1 . '_1_element' . $form_id . '" placeholder="' . htmlentities($param['w_verification_placeholder'], ENT_COMPAT) . '" title="' . htmlentities($param['w_verification_placeholder'], ENT_COMPAT) . '"  ' . $param['attributes'] . 'onchange="wd_check_confirmation_email(\'' . $id1 . '\', \'' . $form_id . '\', \'' . $message_confirm . '\')" />';

              // Generate field.
              $rep .= $this->wdform_field($type, $param, $row, $html);
            }
            break;
          }
          case 'type_checkbox': {
            $rep = $this->type_checkbox($params, $row, $form_id, $id1, $type, $param);
            break;
          }
          case 'type_radio': {
            $rep = $this->type_radio($params, $row, $form_id, $id1, $type, $param);
            break;
          }
          case 'type_own_select': {
            $rep = $this->type_own_select($params, $row, $form_id, $id1, $type, $param);
            break;
          }
          case 'type_country': {
            $rep = $this->type_country($params, $row, $form_id, $id1, $type, $param);
            break;
          }
          case 'type_time': {
            $rep = $this->type_time($params, $row, $form_id, $id1, $type, $param);
            break;
          }
          case 'type_date': { //Todo: Depricated.
            wp_enqueue_script('jquery-ui-datepicker');
            if ( function_exists('wp_add_inline_script') ) { // Since Wordpress 4.5.0
              wp_add_inline_script('jquery-ui-datepicker', WDW_FM_Library(self::PLUGIN)->localize_ui_datepicker());
            }
            else {
              echo '<script>' . WDW_FM_Library(self::PLUGIN)->localize_ui_datepicker() . '</script>';
            }

            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_date',
              'w_required',
              'w_class',
              'w_format',
              'w_but_val',
            );
            $temp = $params;
            if ( strpos($temp, 'w_disable_past_days') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_date',
                'w_required',
                'w_class',
                'w_format',
                'w_but_val',
                'w_disable_past_days',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            if ( $temp ) {
              $temp = explode('*:*w_attr_name*:*', $temp);
              $attrs = array_slice($temp, 0, count($temp) - 1);
              foreach ( $attrs as $attr ) {
                $param['attributes'] = $param['attributes'] . ' ' . $attr;
              }
            }
            $param['w_disable_past_days'] = isset($param['w_disable_past_days']) ? $param['w_disable_past_days'] : 'no';
            $param['w_date'] = (isset($_POST['wdform_' . $id1 . "_element" . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . "_element" . $form_id])) : $param['w_date']);

            $rep = '<div type="type_date" class="wdform-field">';

            $rep .= $this->field_label($param, $row, $id1);

            $classes = array('wdform-element-section');
            if ( isset($param['w_class']) ) {
              $classes[] = $param['w_class'];
            }
            if ( isset($param['w_field_label_pos']) && $param['w_field_label_pos'] != "left" ) {
              $classes[] = 'wd-block';
            }

            $rep .= '<div class="' . implode(' ', $classes) . '">
            <input type="text" autocomplete="off" value="' . $param['w_date'] . '" class="wdform-date wd-datepicker" data-format="' . $param['w_format'] . '" id="wdform_' . $id1 . '_element' . $form_id . '" name="wdform_' . $id1 . '_element' . $form_id . '" maxlength="10" ' . $param['attributes'] . ' /></div></div>';
            break;
          }
          case 'type_date_new': {
            $rep = $this->type_date_new($params, $row, $form_id, $id1, $type, $param);
            break;
          }
          case 'type_date_range': {
            $rep = $this->type_date_range($params, $row, $form_id, $id1, $type, $param);
            break;
          }
          case 'type_date_fields': {
            $rep = $this->type_date_fields($params, $row, $form_id, $id1, $type, $param);
            break;
          }
          case 'type_file_upload': {
            $rep = $this->type_file_upload($params, $row, $id1, $form_id, $param);
            break;
          }
          case 'type_captcha': {
            $params_names = array( 'w_field_label_size', 'w_field_label_pos', 'w_digit', 'w_class' );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array( 'w_field_label_size', 'w_field_label_pos', 'w_hide_label', 'w_digit', 'w_class' );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            if ( $temp ) {
              $temp = explode('*:*w_attr_name*:*', $temp);
              $attrs = array_slice($temp, 0, count($temp) - 1);
              foreach ( $attrs as $attr ) {
                $param['attributes'] = $param['attributes'] . ' ' . $attr;
              }
            }

            $param['id'] = 'wd_captcha_input' . $form_id;
            $param['w_class'] .= ' wd-flex-row wd-align-items-center';

            $html = '<img type="captcha"
                           digit="' . $param['w_digit'] . '"
                           src=" ' . add_query_arg(array('action' => 'formmakerwdcaptcha' . WDFMInstance(self::PLUGIN)->plugin_postfix, 'nonce' => $this->fm_nonce, 'digit' => $param['w_digit'], 'i' => $form_id), admin_url('admin-ajax.php')) . '"
                           id="wd_captcha' . $form_id . '"
                           class="captcha_img wd-hidden"
                           ' . $param['attributes'] . ' />';
            $html .= '<div class="captcha_refresh" id="_element_refresh' . $form_id . '" ' . $param['attributes'] . '></div>';
            $html .= '<input type="text"
                              class="captcha_input"
                              id="wd_captcha_input' . $form_id . '"
                              name="captcha_input"
                              style="width: ' . ($param['w_digit'] * 10 + 20) . 'px;"
                              ' . $param['attributes'] . ' />';

            // Generate field.
            $rep = $this->wdform_field($type, $param, $row, $html);
            WDW_FM_Library(self::PLUGIN)->start_session();
            if ( isset($_SESSION['message_captcha']) && $_SESSION['message_captcha'] != "" ) {
              $rep .= '<div class="fm-not-filled message_captcha">' . $_SESSION['message_captcha'] . '</div>';
              unset($_SESSION['message_captcha']);
            }

            break;
          }
          case 'type_arithmetic_captcha': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_count',
              'w_operations',
              'w_class',
              'w_input_size',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_count',
                'w_operations',
                'w_class',
                'w_input_size',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            if ( $temp ) {
              $temp = explode('*:*w_attr_name*:*', $temp);
              $attrs = array_slice($temp, 0, count($temp) - 1);
              foreach ( $attrs as $attr ) {
                $param['attributes'] = $param['attributes'] . ' add_' . $attr;
              }
            }

            $param['w_count'] = $param['w_count'] ? $param['w_count'] : 1;
            $param['w_operations'] = $param['w_operations'] ? $param['w_operations'] : '+, -, *, /';
            $param['w_input_size'] = $param['w_input_size'] ? $param['w_input_size'] : 60;

            $param['id'] = 'wd_arithmetic_captcha_input' . $form_id;
            $param['w_class'] .= ' wd-flex-row wd-align-items-center';

            $html = '<img type="captcha"
                          operations_count="' . $param['w_count'] . '"
                          operations="' . $param['w_operations'] . '"
                          src="' . add_query_arg(array('action' => 'formmakerwdmathcaptcha' . WDFMInstance(self::PLUGIN)->plugin_postfix, 'nonce' => $this->fm_nonce, 'operations_count' => $param['w_count'], 'operations' => urlencode($param['w_operations']), 'i' => $form_id), admin_url('admin-ajax.php')) . '"
                          id="wd_arithmetic_captcha' . $form_id . '"
                          class="arithmetic_captcha_img"
                          ' . $param['attributes'] . ' />';
            $html .= '<div class="captcha_refresh" id="_element_refresh' . $form_id . '" ' . $param['attributes'] . '></div>';
            $html .= '<input type="text"
                              class="arithmetic_captcha_input"
                              id="wd_arithmetic_captcha_input' . $form_id . '"
                              name="arithmetic_captcha_input"
                              onkeypress="return check_isnum(event)"
                              style="width: ' . $param['w_input_size'] . 'px;"
                              ' . $param['attributes'] . ' />';

            // Generate field.
            $rep = $this->wdform_field($type, $param, $row, $html);
            WDW_FM_Library(self::PLUGIN)->start_session();
            if ( isset($_SESSION['message_captcha']) && $_SESSION['message_captcha'] != "" ) {
              $rep .= '<div class="fm-not-filled message_captcha">' . $_SESSION['message_captcha'] . '</div>';
              unset($_SESSION['message_captcha']);
            }

            break;
          }
          case 'type_recaptcha': {
            if ( WDW_FM_Library(self::PLUGIN)->elementor_is_active() ) {
              $html = '<span style="color: red; font-style: italic;">' . __('No preview available for reCAPTCHA.', WDFMInstance(self::PLUGIN)->prefix) . '</span>';
              $rep = '<div class="fm-not-filled message_captcha">' . $html . '</div>';
              break;
            }
            $params_names = array( 'w_field_label_size', 'w_field_label_pos', 'w_public', 'w_private', 'w_class' );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_public',
                'w_private',
                'w_class',
              );
            }
            if ( strpos($temp, 'w_type') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_type',
                'w_position',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $invisible = isset($param['w_type']) && $param['w_type'] == 'invisible' ? 1 : 0;
            $badge = isset($param['w_position']) ? $param['w_position'] : 0;
            $class = '';
            if ('hidden' == $badge && $invisible) {
              $badge = 'inline';
              $class = ' fm-hide';
            }
            if ($invisible) {
              $param['w_hide_label'] = 'yes';
            }
            $publickey = isset($fm_settings['public_key']) && $fm_settings['public_key'] ? $fm_settings['public_key'] : 'invalid sitekey';
            if ('invalid sitekey' == $publickey) {
              $badge = 'inline';
              $class = '';
            }

            if($param['w_type'] == 'v3' && $publickey != "invalid sitekey") {
              wp_enqueue_script(WDFMInstance(self::PLUGIN)->handle_prefix . '-g-recaptcha-v3');
              $html = '<input type="hidden" name="recaptcha_response' . $form_id . '" class="g-recaptcha" data-size="v3" id="recaptchaV3Response_' . $form_id . $id1 . '" data-id="'.$id1.'" data-form-id="'.$form_id.'" data-badge="inline" data-sitekey="' . $publickey . '">';
            } else {
              wp_enqueue_script(WDFMInstance(self::PLUGIN)->handle_prefix . '-g-recaptcha');
              $html = '<div id="recaptcha' . $form_id . $id1 . '" class="g-recaptcha' . $class . '" data-sitekey="' . $publickey . '" data-form_id="' . $form_id . '"' . ($invisible ? ' data-size="invisible"' : '') . ($badge ? ' data-badge="' . $badge . '"' : '') . '></div>';
            }

            $param['id'] = '';
            $param['w_class'] = 'wd-flex-row';


            // Generate field.
            $rep = $this->wdform_field($type, $param, $row, $html);
            WDW_FM_Library(self::PLUGIN)->start_session();
            if ( isset($_SESSION['message_captcha']) && $_SESSION['message_captcha'] != "" ) {
              $rep .= '<div class="fm-not-filled message_captcha"' . (isset($_SESSION['recaptcha_score']) ? ' data-score="' . $_SESSION['recaptcha_score'] . '"' : '') . '>' . $_SESSION['message_captcha'] . '</div>';
              unset($_SESSION['message_captcha']);
            }

            break;
          }
          case 'type_hidden': {
            $params_names = array( 'w_name', 'w_value' );
            $temp = $params;
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            if ( $temp ) {
              $temp = explode('*:*w_attr_name*:*', $temp);
              $attrs = array_slice($temp, 0, count($temp) - 1);
              foreach ( $attrs as $attr ) {
                $param['attributes'] = $param['attributes'] . ' ' . $attr;
              }
            }

            $param['id'] = '';

            // todo: remove hidden input label
            // $rep .= '<div class="wdform-label-section" class="wd-table-cell"></div>';
            $html = '<input type="hidden" value="' . $param['w_value'] . '" id="wdform_' . $id1 . '_element' . $form_id . '" name="' . $param['w_name'] . '" ' . $param['attributes'] . ' />';

            // Generate field.
            $rep = $this->wdform_field($type, $param, $row, $html, FALSE);

            break;
          }
          case 'type_mark_map': {
			if ( $fm_settings['fm_developer_mode'] ) {
				wp_enqueue_script(WDFMInstance(self::PLUGIN)->handle_prefix . '-gmap_form');
			}
			else {
				wp_enqueue_script('google-maps');
			}
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_center_x',
              'w_center_y',
              'w_long',
              'w_lat',
              'w_zoom',
              'w_width',
              'w_height',
              'w_info',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_center_x',
                'w_center_y',
                'w_long',
                'w_lat',
                'w_zoom',
                'w_width',
                'w_height',
                'w_info',
                'w_class',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            if ( $temp ) {
              $temp = explode('*:*w_attr_name*:*', $temp);
              $attrs = array_slice($temp, 0, count($temp) - 1);
              foreach ( $attrs as $attr ) {
                $param['attributes'] = $param['attributes'] . ' ' . $attr;
              }
            }

            $param['id'] = '';
            $param['w_class'] .= ' wd-flex-row';

            $html = '<input type="hidden" id="wdform_' . $id1 . '_long' . $form_id . '" name="wdform_' . $id1 . '_long' . $form_id . '" value="' . $param['w_long'] . '" />';
            $html .= '<input type="hidden" id="wdform_' . $id1 . '_lat' . $form_id . '" name="wdform_' . $id1 . '_lat' . $form_id . '" value="' . $param['w_lat'] . '" />';
            $html .= '<div class="wd-width-100" id="wdform_' . $id1 . '_element' . $form_id . '" long0="' . $param['w_long'] . '" lat0="' . $param['w_lat'] . '" zoom="' . $param['w_zoom'] . '" info0="' . str_replace(array("\r\n", "\n", "\r"), '<br />', $param['w_info']) . '" center_x="' . $param['w_center_x'] . '" center_y="' . $param['w_center_y'] . '" style="' . ($param['w_width'] != '' ? 'max-width: ' . $param['w_width'] . 'px; ' : '') . 'height: ' . $param['w_height'] . 'px;" ' . $param['attributes'] . '></div>';

            // Generate field.
            $rep = $this->wdform_field($type, $param, $row, $html);

            break;
          }
          case 'type_map': {
            $rep = $this->type_map($params, $id1, $row, $param);
            break;
          }
          case 'type_paypal_price': { // Todo: Depricated.
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_first_val',
              'w_title',
              'w_mini_labels',
              'w_size',
              'w_required',
              'w_hide_cents',
              'w_class',
              'w_range_min',
              'w_range_max',
            );
            $temp = $params;
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            if ( $temp ) {
              $temp = explode('*:*w_attr_name*:*', $temp);
              $attrs = array_slice($temp, 0, count($temp) - 1);
              foreach ( $attrs as $attr ) {
                $param['attributes'] = $param['attributes'] . ' ' . $attr;
              }
            }
            $w_first_val = explode('***', $param['w_first_val']);
            $param['w_first_val'] = (isset($_POST['wdform_' . $id1 . '_element_dollars' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . '_element_dollars' . $form_id])) : $w_first_val[0]) . '***' . (isset($_POST['wdform_' . $id1 . '_element_cents' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . '_element_cents' . $form_id])) : $w_first_val[1]);
            $hide_cents = ($param['w_hide_cents'] == "yes" ? "wd-hidden" : "wd-table-cell");
            $w_first_val = explode('***', $param['w_first_val']);
            $w_title = explode('***', $param['w_title']);
            $w_mini_labels = explode('***', $param['w_mini_labels']);

            $rep = '<div type="type_paypal_price" class="wdform-field">';

            $rep .= $this->field_label($param, $row, 'wdform_' . $id1 . '_element_dollars' . $form_id);

            $classes = array('wdform-element-section');
            if ( isset($param['w_class']) ) {
              $classes[] = $param['w_class'];
            }
            if ( isset($param['w_field_label_pos']) && $param['w_field_label_pos'] != "left" ) {
              $classes[] = 'wd-block';
            }

            $rep .= '<div class="' . implode(' ', $classes) . '">';

            $rep .= '<input type="hidden" value="' . $param['w_range_min'] . '" name="wdform_' . $id1 . '_range_min' . $form_id . '" id="wdform_' . $id1 . '_range_min' . $form_id . '" />';
            $rep .= '<input type="hidden" value="' . $param['w_range_max'] . '" name="wdform_' . $id1 . '_range_max' . $form_id . '" id="wdform_' . $id1 . '_range_max' . $form_id . '" />';
            $rep .= '<div id="wdform_' . $id1 . '_table_price" class="wd-table">';
            $rep .= '<div id="wdform_' . $id1 . '_tr_price1" class="wd-table-row">';
            $rep .= '<div id="wdform_' . $id1 . '_td_name_currency" class="wd-table-cell">';
            $rep .= '<span class="wdform_colon wd-vertical-middle">&nbsp;' . $form_currency . '&nbsp;</span>';
            $rep .= '</div>';
            $rep .= '<div id="wdform_' . $id1 . '_td_name_dollars" class="wd-table-cell">';
            $rep .= '<input type="text" id="wdform_' . $id1 . '_element_dollars' . $form_id . '" name="wdform_' . $id1 . '_element_dollars' . $form_id . '" value="' . htmlentities($w_first_val[0], ENT_COMPAT) . '" title="' . $w_title[0] . '" onkeypress="return check_isnum(event)" style="width: ' . $param['w_size'] . 'px;" ' . $param['attributes'] . ' />';
            $rep .= '</div>';
            $rep .= '<div id="wdform_' . $id1 . '_td_name_divider" class="' . $hide_cents . '">';
            $rep .= '<span class="wdform_colon wd-vertical-middle">&nbsp;.&nbsp;</span>';
            $rep .= '</div>';
            $rep .= '<div id="wdform_' . $id1 . '_td_name_cents" class="' . $hide_cents . '">';
            $rep .= '<input type="text" class="wd-paypal-cent" id="wdform_' . $id1 . '_element_cents' . $form_id . '" name="wdform_' . $id1 . '_element_cents' . $form_id . '" value="' . htmlentities($w_first_val[1], ENT_COMPAT) . '" title="' . $w_title[1] . '" ' . $param['attributes'] . ' />';
            $rep .= '</div></div>';
            $rep .= '<div id="wdform_' . $id1 . '_tr_price2" class="wd-table-row">';
            $rep .= '<div class="wd-table-cell"><label class="mini_label"></label></div>';
            $rep .= '<div align="left" class="wd-table-cell"><label class="mini_label">' . $w_mini_labels[0] . '</label></div>';
            $rep .= '<div id="wdform_' . $id1 . '_td_name_label_divider" class="' . $hide_cents . '"><label class="mini_label"></label></div>';
            $rep .= '<div align="left" id="wdform_' . $id1 . '_td_name_label_cents" class="' . $hide_cents . '"><label class="mini_label">' . $w_mini_labels[1] . '</label></div>';
            $rep .= '</div></div></div></div>';
            break;
          }
          case 'type_paypal_price_new': {
            $rep = $this->type_paypal_price_new($params, $row, $id1, $form_id, $param, $form_currency, $symbol_begin, $symbol_end);
            break;
          }
          case 'type_paypal_select': {
            $rep = $this->type_paypal_select($params, $row, $id1, $form_id, $param);
            break;
          }
          case 'type_paypal_checkbox': {
            $rep = $this->type_paypal_checkbox($params, $row, $id1, $form_id, $param);
            break;
          }
          case 'type_paypal_radio': {
            $rep = $this->type_paypal_radio($params, $row, $id1, $form_id, $param);
            break;
          }
          case 'type_paypal_shipping': {
            $rep = $this->type_paypal_shipping($params, $row, $id1, $form_id, $param);
            break;
          }
          case 'type_submit_reset': {
            $params_names = array( 'w_submit_title', 'w_reset_title', 'w_class', 'w_act' );
            $temp = $params;
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            if ( $temp ) {
              $temp = explode('*:*w_attr_name*:*', $temp);
              $attrs = array_slice($temp, 0, count($temp) - 1);
              foreach ( $attrs as $attr ) {
                $param['attributes'] = $param['attributes'] . ' ' . $attr;
              }
            }
            $param['w_act'] = ($param['w_act'] == "false" ? 'wd-hidden' : "");

            $param['id'] = $id1;
            $param['w_class'] .= ' wd-flex-row';
            if ( isset($form_theme['SPAlign']) && $form_theme['SPAlign'] != '' ) {
              $param['w_class'] .= ' wd-justify-content-' . $form_theme['SPAlign'];
            }

            $submit_onclick = 'onclick="fm_submit_form(\'' . $form_id . '\');"';
            $reset_onclick  = 'onclick="fm_reset_form(' . $form_id . ');"';
            $disabled_submit = '';
            $disabled_reset = '';

            if ( WDW_FM_Library(self::PLUGIN)->elementor_is_active() ) {
              $submit_onclick = '';
              $reset_onclick = '';
              $disabled_submit = 'disabled="disabled"';
              $disabled_reset = 'disabled="disabled"';
            }

            $rep = '';
            if ( $row->gdpr_checkbox && $row->gdpr_checkbox_text ) {
              $privacy_policy_page = WDW_FM_Library(self::PLUGIN)->get_privacy_policy_url();
              $privacy_policy_link = $privacy_policy_page['title'];
              if ( !empty($privacy_policy_page['url']) ) {
                $privacy_policy_link = ' <a href="' . $privacy_policy_page['url'] . '" target="_blank">' . $privacy_policy_page['title'] . '</a>';
              }
              $row->gdpr_checkbox_text = str_replace('{{privacy_policy}}', $privacy_policy_link, $row->gdpr_checkbox_text);
              $gdpr_checkbox_html = '<label for="fm_privacy_policy' . $form_id . '" class="wdform-label">
                                       <input id="fm_privacy_policy' . $form_id . '" name="fm_privacy_policy' . $form_id . '" class="wd-flex-row fm-gdpr-checkbox" onclick="' . ($disabled_submit ? '' : 'fm_privacy_policy_check(this)') . '" type="checkbox" value="1">'
                                        . $row->gdpr_checkbox_text .
                                     '</label>';
              $rep = $this->wdform_field('type_gdpr_compliance_checkbox', $param, $row, $gdpr_checkbox_html, FALSE);
              $disabled_submit = 'disabled="disabled"';
            }
            $ajax_submit_status = isset($fm_settings['fm_ajax_submit']) ? $fm_settings['fm_ajax_submit'] : 0;
            $html = '<button ' . $disabled_submit . ' type="button" class="button-submit" ' . $submit_onclick . ' ' . $param['attributes'] . ' data-ajax="'.$ajax_submit_status.'">';
            $html .= '<span class="fm-submit-loading spinner fm-ico-spinner"></span>' . $param['w_submit_title'];
            $html .= '</button>';
            $html .= '<button ' . $disabled_reset . ' type="button" class="button-reset ' . $param['w_act'] . '" ' . $reset_onclick . ' ' . $param['attributes'] . '>' . $param['w_reset_title'] . '</button>';

            // Generate field.
            $rep .= $this->wdform_field($type, $param, $row, $html, FALSE);

            break;
          }
          case 'type_button': {
            $params_names = array( 'w_title', 'w_func', 'w_class' );
            $temp = $params;
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            if ( $temp ) {
              $temp = explode('*:*w_attr_name*:*', $temp);
              $attrs = array_slice($temp, 0, count($temp) - 1);
              foreach ( $attrs as $attr ) {
                $param['attributes'] = $param['attributes'] . ' ' . $attr;
              }
            }
            $param['w_title'] = explode('***', $param['w_title']);
            $param['w_func'] = explode('***', $param['w_func']);

            $param['id'] = '';
            $param['w_class'] .= ' wd-flex-row';

            // Todo: Delete field label.
            //            $rep .= '<div class="wdform-label-section wd-table-cell">';
            //            $rep .= '<span class="wd-hidden">button_' . $id1 . '</span>';
            //            $rep .= '</div>';
            $html = '';
            foreach ( $param['w_title'] as $key => $title ) {
              $html .= '<button type="button" name="wdform_' . $id1 . '_element' . $form_id . $key . '" onclick="' . $param['w_func'][$key] . '" ' . $param['attributes'] . '>' . $title . '</button>';
            }

            // Generate field.
            $rep = $this->wdform_field($type, $param, $row, $html, FALSE);

            break;
          }
          case 'type_star_rating': {
            $rep = $this->type_star_rating($params, $row, $form_id, $id1, $type, $param);
            break;
          }
          case 'type_scale_rating': {
            $rep = $this->type_scale_rating($params, $row, $form_id, $id1, $type, $param);
            break;
          }
          case 'type_spinner': {
            $rep = $this->type_spinner($params, $row, $form_id, $id1, $type, $param);
            break;
          }
          case 'type_slider': {
            $rep = $this->type_slider($params, $row, $form_id, $id1, $type, $param);
            break;
          }
          case 'type_range': {
            $rep = $this->type_range($params, $row, $form_id, $id1, $type, $param);
            break;
          }
          case 'type_grading': {
            $rep = $this->type_grading($params, $row, $form_id, $id1, $type, $param);
            break;
          }
          case 'type_matrix': {
            $rep = $this->type_matrix($params, $row, $form_id, $id1, $type, $param);
            break;
          }
          case 'type_paypal_total': {
            $rep = $this->type_paypal_total($params, $row, $id1, $form_id, $param);
            break;
          }
          case 'type_stripe': {
            /* get stripe extension form */
            $stripe_data = array('form_view' => $this, 'form' => $row, 'attributes' => $params, 'input_index' => $id1, 'form_id' => $form_id, 'html' => '');
            if ( WDFMInstance(self::PLUGIN)->is_free != 2 && $row->paypal_mode == 2 ) {
              $stripe_data = apply_filters('fm_addon_stripe_form_init', $stripe_data);
            }
            $rep .= !empty($stripe_data['html']) ? $stripe_data['html'] : '';
            break;
          }
        }
        $form = str_replace('%' . $id1 . ' - ' . $labels[$id1s_key] . '%', $rep, $form);
        $form = str_replace('%' . $id1 . ' -' . $labels[$id1s_key] . '%', $rep, $form);
      }
    }
    $rep1 = array( 'form_id_temp' );
    $rep2 = array( $form_id );
    $form = str_replace($rep1, $rep2, $form);
    if ( !$fm_hide_form_after_submit ) {
      $form_maker_front_end .= $form;
      if ( isset($form_theme['HPAlign']) && ($form_theme['HPAlign'] == 'right' || $form_theme['HPAlign'] == 'bottom') ) {
        if ( $row->header_hide && $row->header_title || $row->header_description || $row->header_image_url ) {
          $form_maker_front_end .= '<div class="fm-header-bg"><div class="fm-header ' . $image_pos . '">';
          if ( $form_theme['HIPAlign'] == 'left' || $form_theme['HIPAlign'] == 'top' ) {
            if ( $row->header_image_url ) {
              $form_maker_front_end .= '<div class="fm-header-img ' . $hide_header_image_class . ' fm-animated ' . $header_image_animation . '"><img src="' . $row->header_image_url . '" ' . $image_width . ' ' . $image_height . '/></div>';
            }
          }
          if ( $row->header_title || $row->header_description ) {
            $form_maker_front_end .= '<div class="fm-header-text">
                <div class="fm-header-title">
                  ' . $row->header_title . '
                </div>
                <div class="fm-header-description">
                  ' . $row->header_description . '
                </div>
              </div>';
          }
          if ( $form_theme['HIPAlign'] == 'right' || $form_theme['HIPAlign'] == 'bottom' ) {
            if ( $row->header_image_url ) {
              $form_maker_front_end .= '<div class="fm-header-img"><img src="' . $row->header_image_url . '" ' . $image_width . ' ' . $image_height . '/></div>';
            }
          }
          $form_maker_front_end .= '</div></div>';
        }
      }
    }
    $form_maker_front_end .= '<div class="wdform_preload"></div>';
    $form_maker_front_end .= '</form>';
    $jsversion = $row->jsversion ? $row->jsversion : 1;
  	$front_urls = WDFMInstance(self::PLUGIN)->front_urls;
    $frontend_dir ='/form-maker-frontend/';
    $wp_upload_dir = wp_upload_dir();
    $fm_script_dir = $wp_upload_dir['basedir'] . $frontend_dir . 'js/fm-script-' . $form_id . '.js';
    $fm_script_url = $front_urls['upload_url'] . $frontend_dir . 'js/fm-script-' . $form_id . '.js';

    WDW_FM_Library(self::PLUGIN)->create_js($form_id);
    if ( !file_exists($fm_script_dir) ) {
      if ( function_exists('wp_add_inline_script') ) {
        wp_add_inline_script(WDFMInstance(self::PLUGIN)->handle_prefix.'-frontend', WDW_FM_Library(self::PLUGIN)->get_fm_js_content());
      }
      else {
        echo '<script>' . WDW_FM_Library(self::PLUGIN)->get_fm_js_content() . '</script>';
      }
    }
    else {
      wp_register_script(WDFMInstance(self::PLUGIN)->handle_prefix . '-script-' . $form_id, $fm_script_url, array(), $jsversion);
      if ( WDW_FM_Library(self::PLUGIN)->elementor_is_active() ) {
        wp_print_scripts(WDFMInstance(self::PLUGIN)->handle_prefix . '-script-' . $form_id);
      }
      else {
        wp_enqueue_script(WDFMInstance(self::PLUGIN)->handle_prefix . '-script-' . $form_id);
      }
    }

    $_GET['addon_view'] = 'frontend';
    $_GET['form_id'] = $form_id;
    if (WDFMInstance(self::PLUGIN)->is_free != 2) {
      $save_progress_params = array();
      $save_progress_params['form'] = $row;
      $save_progress_params['form_id'] = $form_id;

      do_action('WD_FM_SAVE_PROG_init', $save_progress_params);
    }
    return $formType == 'embedded' ? WDW_FM_Library(self::PLUGIN)->fm_container($theme_id, $form_maker_front_end) : $form_maker_front_end;
  }

  /**
   * Autoload form.
   *
   * @param array $params
   * @return string
   */
  public function autoload_form( $params = array() ) {
	$id = $params['id'];
	$type = $params['type'];
	$form = $params['form'];
	$display_on_this = $params['display_on_this'];
	$show_for_admin = $params['show_for_admin'];
	$form_result = $params['form_result'];
	$fm_settings = $params['fm_settings'];
	$error = $params['error'];
	$message = $params['message'];
	$onload_js = '';
    $fm_form = '';
    switch ($type) {
      case 'topbar': {
        $top_bottom = $form->topbar_position ? 'top' : 'bottom';
        $fixed_relative = !$form->topbar_remain_top && $form->topbar_position ? 'absolute' : 'fixed';
        $closing = $form->topbar_closing;
        $hide_duration = $form->topbar_hide_duration;
        $hide_mobile = wp_is_mobile() && $form->hide_mobile ? FALSE : TRUE;
        if ( $display_on_this && $hide_mobile || $fm_settings['fm_ajax_submit'] ) {
          WDW_FM_Library(self::PLUGIN)->start_session();
          if (isset($_SESSION['fm_hide_form_after_submit' . $id]) && $_SESSION['fm_hide_form_after_submit' . $id] == 1) {
            if ($error == 'success') {
              if ($message) {
                $onload_js .= '
								jQuery("#fm-form' . $id . '").css("display", "none");
								jQuery("#fm-pages' . $id . '").css("display", "none");
								jQuery("#fm-topbar' . $id . '").css("visibility", "");
								fm_hide_form(' . $id . ', ' . $hide_duration . ');';
              }
              else {
                $onload_js .= '
								fm_hide_form(' . $id . ', ' . $hide_duration . ');';
              }
            }
          }
          else {
            $onload_js .= '
								if (' . $hide_duration . ' == 0) {
									localStorage.removeItem("hide-"+' . $id . ');
								}
								var hide_topbar = localStorage.getItem("hide-"+' . $id . ');
								if(hide_topbar == null || fm_currentDate.getTime() >= hide_topbar || ' . $show_for_admin . '){
									jQuery("#fm-topbar' . $id . '").css("visibility", "");
									jQuery("#fm-topbar' . $id . ' .fm-header-img").addClass("fm-animated ' . ($form->header_image_animation) . '");
								}';
          }

          $fm_form .= '<div id="fm-topbar' . $id . '" class="fm-topbar" style="position: ' . $fixed_relative . '; ' . $top_bottom . ': 0px; visibility:hidden;">';
          $fm_form .= $this->display($form_result, $fm_settings, $id, $type);
          $fm_form .= '<div id="fm-action-buttons' . $id . '" class="fm-action-buttons">';
          if ($closing) {
            $fm_form .= '<span id="closing-form' . $id . '" class="closing-form fm-ico-delete" onclick="fm_hide_form(' . $id . ', ' . $hide_duration . ', function(){
									jQuery(\'#fm-topbar' . $id . '\').css(\'display\', \'none\');
								})">
							  </span>';
          }
          $fm_form .= '</div>';
          $fm_form .= '</div>';
          /* one more closing div for closing buttons */
        }
        break;
      }
      case 'scrollbox': {
        $left_right = $form->scrollbox_position ? 'right' : 'left';
        $trigger_point = (int)$form->scrollbox_trigger_point;
        $closing = $form->scrollbox_closing;
        $minimize = $form->scrollbox_minimize;
        $minimize_text = $form->scrollbox_minimize_text;
        $hide_duration = $form->scrollbox_hide_duration;
        $hide_mobile_class = wp_is_mobile() ? 'fm_mobile_full' : '';
        $hide_mobile = wp_is_mobile() && $form->hide_mobile ? FALSE : TRUE;
        $left_right_class = $form->scrollbox_position ? 'float-right' : 'float-left';
        if ($display_on_this && $hide_mobile || $fm_settings['fm_ajax_submit']) {
          WDW_FM_Library(self::PLUGIN)->start_session();
          if ( isset($_SESSION['fm_hide_form_after_submit' . $id]) && $_SESSION['fm_hide_form_after_submit' . $id] == 1 ) {
            if ( $error == 'success' ) {
              if ( $message ) {
                $onload_js .= '
									jQuery("#fm-form' . $id . ', #fm-pages' . $id . '").addClass("fm-hide");
									jQuery("#fm-scrollbox' . $id . '").removeClass("fm-animated fadeOutDown").addClass("fm-animated fadeInUp");
									jQuery("#fm-scrollbox' . $id . '").css("visibility", "");
									jQuery("#minimize-form' . $id . '").css("visibility", "hidden");
								';
              }
              $onload_js .= 'fm_hide_form(' . $id . ', ' . $hide_duration . ');';
            }
          }
          else {
            if ( isset($_SESSION['error_occurred' . $id]) && $_SESSION['error_occurred' . $id] == 1 ) {
              $_SESSION['error_occurred' . $id] = 0;
              if ( $message ) {
                $onload_js .= '
									jQuery("#fm-scrollbox' . $id . '").removeClass("fm-animated fadeOutDown").addClass("fm-animated fadeInUp");
									jQuery("#fm-scrollbox' . $id . '").removeClass("fm-animated fadeOutDown").addClass("fm-animated fadeInUp");
									jQuery("#fm-scrollbox' . $id . '").css("visibility", "");
								';
              }
            }
            else {
              $onload_js .= '
								if (' . $hide_duration . ' == 0) {
									localStorage.removeItem("hide-"+' . $id . ');
								}
								var hide_scrollbox = localStorage.getItem("hide-"+' . $id . ');';
              if ($trigger_point > 0) {
                $onload_js .= '
									if(hide_scrollbox == null || fm_currentDate.getTime() >= hide_scrollbox || ' . $show_for_admin . '){
										jQuery(window).scroll(function () {
											fmscrollHandler(' . $id . ');
										  });
										}';
              }
              else {
                $onload_js .= '
								if(hide_scrollbox == null || fm_currentDate.getTime() >= hide_scrollbox || ' . $show_for_admin . '){
									fmscrollHandler(' . $id . ');
								}';
              }
            }
          }
          if ($minimize) {
            $fm_form .= '<div id="fm-minimize-text' . $id . '" class="fm-minimize-text ' . $hide_mobile_class . '" onclick="fm_show_scrollbox(' . $id . ');" style="' . $left_right . ': 0px; display:none;">
								<div>' . $minimize_text . '</div>
							</div>';
          }

          $fm_form .= '<div id="fm-scrollbox' . $id . '" class="fm-scrollbox ' . $hide_mobile_class . '" style="' . $left_right . ': 0px; visibility:hidden;">';
          $fm_form .= '<div class="fm-scrollbox-form ' . $left_right_class . '">';
          $fm_form .= $this->display($form_result, $fm_settings, $id, $type);
          $fm_form .= '<div id="fm-action-buttons' . $id . '" class="fm-action-buttons">';
          if ($minimize) {
            $fm_form .= '<span id="minimize-form' . $id . '" class="minimize-form fm-ico-expand" onclick="minimize_form(' . $id . ')"></span>';
          }
          if ($closing) {
            $fm_form .= '<span id="closing-form' . $id . '" class="closing-form fm-ico-delete" onclick="fm_hide_form(' . $id . ', ' . $hide_duration . ', function(){ jQuery(\'#fm-scrollbox' . $id . '\').removeClass(\'fm-show\').addClass(\'fm-hide\'); });"></span>';
          }
          $fm_form .= '</div>';
          $fm_form .= '</div>';
          $fm_form .= '</div>';
          /* one more closing div for cloasing buttons */
        }
        break;
      }
      case 'popover': {
        $animate_effect = $form->popover_animate_effect;
        $loading_delay = (int)$form->popover_loading_delay;
        $frequency = $form->popover_frequency;
        $hide_mobile = wp_is_mobile() && $form->hide_mobile ? FALSE : TRUE;
        $hide_mobile_class = wp_is_mobile() ? 'fm_mobile_full' : '';
        if ($display_on_this && $hide_mobile || $fm_settings['fm_ajax_submit']) {
          WDW_FM_Library(self::PLUGIN)->start_session();
          if (isset($_SESSION['fm_hide_form_after_submit' . $id]) && $_SESSION['fm_hide_form_after_submit' . $id] == 1) {
            if ($error == 'success') {
              if ($message) {
                $onload_js .= '
									jQuery("#fm-form' . $id . '").addClass("fm-hide");
									jQuery("#fm-pages' . $id . '").addClass("fm-hide");
									jQuery("#fm-popover-background' . $id . '").css("display", "block");
									jQuery("#fm-popover' . $id . '").css("visibility", "");

									fm_hide_form(' . $id . ', ' . $frequency . ');
								';
              }
              else {
                $onload_js .= '
									jQuery("#fm-form' . $id . '").addClass("fm-hide");
									jQuery("#fm-pages' . $id . '").addClass("fm-hide");
									fm_hide_form(' . $id . ', ' . $frequency . ', function(){
										jQuery("#fm-popover-background' . $id . '").css("display", "none");
										jQuery("#fm-popover' . $id . '").css("display", "none");
									});
								';
              }
            }
          }
          else {
            if (isset($_SESSION['error_occurred' . $id]) && $_SESSION['error_occurred' . $id] == 1) {
              $_SESSION['error_occurred' . $id] = 0;
              if ($message) {
                $onload_js .= '
									jQuery("#fm-popover-background' . $id . '").css("display", "block");
									jQuery("#fm-popover' . $id . '").css("visibility", "");
								';
              }
            }
            else {
              $onload_js .= '
								if(' . $frequency . ' == 0){
									localStorage.removeItem("hide-"+' . $id . ');
								}
								var hide_popover = localStorage.getItem("hide-"+' . $id . ');
								if(hide_popover == null || fm_currentDate.getTime() >= hide_popover || ' . $show_for_admin . '){
									setTimeout(function(){
										jQuery("#fm-popover-background' . $id . '").css("display", "block");
										jQuery("#fm-popover' . $id . '").css("visibility", "");
										jQuery(".fm-popover-content").addClass("fm-animated ' . ($animate_effect) . '");
										jQuery("#fm-popover' . $id . ' .fm-header-img").addClass("fm-animated ' . ($form->header_image_animation) . '");
									}, ' . ($loading_delay * 1000) . ');
								}';
            }
          }

          $onload_js .= '
							jQuery("#fm-popover-inner-background' . $id . '").on("click", function(){
								fm_hide_form(' . $id . ', ' . $frequency . ', function(){
								  jQuery("#fm-popover-background' . $id . '").css("display", "none");
								  jQuery("#fm-popover' . $id . '").css("display", "none");
								});
							});
						';

          $fm_form .= '<div class="fm-popover-background" id="fm-popover-background' . $id . '" style="display:none;"></div>
						<div id="fm-popover' . $id . '" class="fm-popover ' . $hide_mobile_class . '" style="visibility:hidden;">
							<div class="fm-popover-container" id="fm-popover-container' . $id . '">
								<div class="fm-popover-inner-background" id="fm-popover-inner-background' . $id . '"></div>
								<div class="fm-popover-content">';
		  $fm_form .= $this->display($form_result, $fm_settings, $id, $type);
		  $fm_form .= '<div id="fm-action-buttons' . $id . '" class="fm-action-buttons">';
          $fm_form .= '<span id="closing-form' . $id . '" class="closing-form fm-ico-delete" onclick="fm_hide_form(' . $id . ', ' . $frequency . ', function(){
												jQuery(\'#fm-popover-background' . $id . '\').css(\'display\', \'none\');
												jQuery(\'#fm-popover' . $id . '\').css(\'display\', \'none\');
											});"></span>
								</div>
							</div>
						</div>';

          /* one more closing div for cloasing buttons */
        }
        break;
      }
    }
    if ( $onload_js ) {
      $onload_js = 'jQuery(document).ready( function () {' . $onload_js . '})';
    }
    if ( function_exists('wp_add_inline_script') ) { // Since Wordpress 4.5.0
      wp_add_inline_script( WDFMInstance(self::PLUGIN)->handle_prefix . '-script-' . $id, $onload_js);
    }
    else {
      echo '<script>' . $onload_js . '</script>';
    }

    return WDW_FM_Library(self::PLUGIN)->fm_container($form->theme, $fm_form);
  }

  /**
   * Type file upload.
   *
   * @param array $params
   * @param array $row
   * @param int $id1
   * @param int $form_id
   * @param array $param
   * @return string
   */
  private function type_file_upload( $params = array(), $row = array(), $id1 = 0, $form_id = 0, $param = array() ) {
    return '';
  }

  /**
   * Type paypal price new.
   *
   * @param array $params
   * @param array $row
   * @param int $id1
   * @param int $form_id
   * @param array $param
   * @param string $form_currency
   * @param string $symbol_begin
   * @param string $symbol_end
   * @return string
   */
  private function type_paypal_price_new( $params = array(), $row = array(), $id1 = 0, $form_id = 0, $param = array(), $form_currency = '', $symbol_begin = '', $symbol_end = '' ) {
    return '';
  }

  /**
   * Type paypal select.
   *
   * @param array $params
   * @param array $row
   * @param int $id1
   * @param int $form_id
   * @param array $param
   * @return string
   */
  private function type_paypal_select( $params = array(), $row = array(), $id1 = 0, $form_id = 0, $param = array() ) {
    return '';
  }

  /**
   * Type paypal radio.
   *
   * @param array $params
   * @param array $row
   * @param int $id1
   * @param int $form_id
   * @param array $param
   * @return string
   */
  private function type_paypal_radio( $params = array(), $row = array(), $id1 = 0, $form_id = 0, $param = array() ) {
    return '';
  }

  /**
   * Type paypal checkbox.
   *
   * @param array $params
   * @param array $row
   * @param int $id1
   * @param int $form_id
   * @param array $param
   * @return string
   */
  private function type_paypal_checkbox( $params = array(), $row = array(), $id1 = 0, $form_id = 0, $param = array() ) {
    return '';
  }

  /**
   * Type paypal shipping.
   *
   * @param array $params
   * @param array $row
   * @param int $id1
   * @param int $form_id
   * @param array $param
   * @return string
   */
  private function type_paypal_shipping( $params = array(), $row = array(), $id1 = 0, $form_id = 0, $param = array() ) {
    return '';
  }

  /**
   * Type paypal total.
   *
   * @param array $params
   * @param array $row
   * @param int $id1
   * @param int $form_id
   * @param array $param
   * @return string
   */
  private function type_paypal_total( $params = array(), $row = array(), $id1 = 0, $form_id = 0, $param = array() ) {
    return '';
  }

  /**
   * Type map.
   *
   * @param array $params
   * @param int $id1
   * @param array $row
   * @param array $param
   * @return string
   */
  private function type_map( $params = array(), $id1 = 0, $row = array(), $param = array() ) {
	$fm_settings = WDFMInstance(self::PLUGIN)->fm_settings;
	if ( $fm_settings['fm_developer_mode'] ) {
		wp_enqueue_script(WDFMInstance(self::PLUGIN)->handle_prefix . '-gmap_form');
	}
	else {
		wp_enqueue_script('google-maps');
	}

    $params_names = array(
      'w_center_x',
      'w_center_y',
      'w_long',
      'w_lat',
      'w_zoom',
      'w_width',
      'w_height',
      'w_info',
      'w_class',
    );
    $temp = $params;
    foreach ( $params_names as $params_name ) {
      $temp = explode('*:*' . $params_name . '*:*', $temp);
      $param[$params_name] = $temp[0];
      $temp = $temp[1];
    }
    if ( $temp ) {
      $temp = explode('*:*w_attr_name*:*', $temp);
      $attrs = array_slice($temp, 0, count($temp) - 1);
      foreach ( $attrs as $attr ) {
        $param['attributes'] = $param['attributes'] . ' ' . $attr;
      }
    }
    $marker = '';
    $param['w_long'] = explode('***', $param['w_long']);
    $param['w_lat'] = explode('***', $param['w_lat']);
    $param['w_info'] = explode('***', $param['w_info']);
    foreach ( $param['w_long'] as $key => $w_long ) {
      $marker .= 'long' . $key . '="' . $w_long . '" lat' . $key . '="' . $param['w_lat'][$key] . '" info' . $key . '="' . str_replace(array("\r\n", "\n", "\r"), '<br />', $param['w_info'][$key]) . '"';
    }

    $param['id'] = $id1;
    $param['w_class'] .= ' wd-flex-row';
    $type = 'type_map';

    $html = '<div class="wd-width-100" id="wdform_' . $id1 . '_element' . $row->id . '" zoom="' . $param['w_zoom'] . '" center_x="' . $param['w_center_x'] . '" center_y="' . $param['w_center_y'] . '" style="' . ($param['w_width'] != '' ? 'max-width: ' . $param['w_width'] . 'px; ' : '') . 'height: ' . $param['w_height'] . 'px;" ' . $marker . ' ' . $param['attributes'] . '></div>';

    // Generate field.
    $rep = $this->wdform_field($type, $param, $row, $html, FALSE);

    return $rep;
  }

  /**
   * Type checkbox.
   *
   * @param array $params
   * @param array $row
   * @param int $form_id
   * @param int $id1
   * @param string $type
   * @param array $param
   * @return string
   */
  private function type_checkbox( $params = array(), $row = array(), $form_id = 0, $id1 = 0, $type = '', $param = array() ) {
    return '';
  }

  /**
   * Type radio.
   *
   * @param array $params
   * @param array $row
   * @param int $form_id
   * @param int $id1
   * @param string $type
   * @param array $param
   * @return string
   */
  private function type_radio( $params = array(), $row = array(), $form_id = 0, $id1 = 0, $type = '', $param = array() ) {
    return '';
  }

  /**
   * Type own select.
   *
   * @param array $params
   * @param array $row
   * @param int $form_id
   * @param int $id1
   * @param string $type
   * @param array $param
   * @return string
   */
  private function type_own_select( $params = array(), $row = array(), $form_id = 0, $id1 = 0, $type = '', $param = array() ) {
    return '';
  }

  /**
   * Type date new.
   *
   * @param array $params
   * @param array $row
   * @param int $form_id
   * @param int $id1
   * @param string $type
   * @param array $param
   * @return string
   */
  private function type_date_new( $params = array(), $row = array(), $form_id = 0, $id1 = 0, $type = '', $param = array() ) {
    return '';
  }

  /**
   * Type date fields.
   *
   * @param array $params
   * @param array $row
   * @param int $form_id
   * @param int $id1
   * @param string $type
   * @param array $param
   * @return string
   */
  private function type_date_fields( $params = array(), $row = array(), $form_id = 0, $id1 = 0, $type = '', $param = array() ) {
    return '';
  }

  /**
   * Type date range
   *
   * @param array $params
   * @param array $row
   * @param int $form_id
   * @param int $id1
   * @param string $type
   * @param array $param
   * @return string
   */
  private function type_date_range( $params = array(), $row = array(), $form_id = 0, $id1 = 0, $type = '', $param = array() ) {
    return '';
  }


  /**
   * Type time.
   *
   * @param array $params
   * @param array $row
   * @param int $form_id
   * @param int $id1
   * @param string $type
   * @param array $param
   * @return string
   */
  private function type_time( $params = array(), $row = array(), $form_id = 0, $id1 = 0, $type = '', $param = array() ) {
    return '';
  }

  /**
   * Type country.
   *
   * @param array $params
   * @param array $row
   * @param int $form_id
   * @param int $id1
   * @param string $type
   * @param array $param
   * @return string
   */
  private function type_country( $params = array(), $row = array(), $form_id = 0, $id1 = 0, $type = '', $param = array() ) {
    return '';
  }

  /**
   * Type spinner.
   *
   * @param array $params
   * @param array $row
   * @param int $form_id
   * @param int $id1
   * @param string $type
   * @param array $param
   * @return string
   */
  private function type_spinner( $params = array(), $row = array(), $form_id = 0, $id1 = 0, $type = '', $param = array() ) {
    return '';
  }

  /**
   * Type star rating.
   *
   * @param array $params
   * @param array $row
   * @param int $form_id
   * @param int $id1
   * @param string $type
   * @param array $param
   * @return string
   */
  private function type_star_rating( $params = array(), $row = array(), $form_id = 0, $id1 = 0, $type = '', $param = array() ) {
    return '';
  }

  /**
   * Type scale rating.
   *
   * @param array $params
   * @param array $row
   * @param int $form_id
   * @param int $id1
   * @param string $type
   * @param array $param
   * @return string
   */
  private function type_scale_rating( $params = array(), $row = array(), $form_id = 0, $id1 = 0, $type = '', $param = array() ) {
    return '';
  }

  /**
   * Type slider.
   *
   * @param array $params
   * @param array $row
   * @param int $form_id
   * @param int $id1
   * @param string $type
   * @param array $param
   * @return string
   */
  private function type_slider( $params = array(), $row = array(), $form_id = 0, $id1 = 0, $type = '', $param = array() ) {
    return '';
  }

  /**
   * Type range.
   *
   * @param array $params
   * @param array $row
   * @param int $form_id
   * @param int $id1
   * @param string $type
   * @param array $param
   * @return string
   */
  private function type_range( $params = array(), $row = array(), $form_id = 0, $id1 = 0, $type = '', $param = array() ) {
    return '';
  }

  /**
   * Type grading.
   *
   * @param array $params
   * @param array $row
   * @param int $form_id
   * @param int $id1
   * @param string $type
   * @param array $param
   * @return string
   */
  private function type_grading( $params = array(), $row = array(), $form_id = 0, $id1 = 0, $type = '', $param = array() ) {
    return '';
  }

  /**
   * Type matrix.
   *
   * @param array $params
   * @param array $row
   * @param int $form_id
   * @param int $id1
   * @param string $type
   * @param array $param
   * @return string
   */
  private function type_matrix( $params = array(), $row = array(), $form_id = 0, $id1 = 0, $type = '', $param = array() ) {
    return '';
  }

  /**
   * WD form field.
   *
   * @param string $type
   * @param array $param
   * @param array $row
   * @param string $html
   * @param bool $label
   * @return string
   */
  public function wdform_field( $type = '', $param = array(), $row = array(), $html = '', $label = TRUE) {
    ob_start();
    $param['w_hide_label'] = (isset($param['w_hide_label']) ? $param['w_hide_label'] : "no");
    $param['w_size'] = (isset($param['w_size']) ? $param['w_size'] : "");
    $param['w_field_label_pos'] = (isset($param['w_field_label_pos']) ? $param['w_field_label_pos'] : "top");

    $classes = array('wdform-field', 'wd-width-100', 'wd-flex');
    $classes[] = ($param['w_field_label_pos'] ==  "top" ? 'wd-flex-column' : 'wd-flex-row');
    ?><div type="<?php echo $type; ?>" class="<?php echo implode(' ', $classes); ?>"><?php

    if ( $label ) {
      echo $this->field_label($param, $row);
    }

    echo $this->field_section($html, $param);

    ?></div><?php

    return ob_get_clean();
  }
  /**
   * Return form field label HTML.
   *
   * @param array $param
   * @param array $form
   *
   * @return string
   */
  private function field_label( $param = array(), $form = array() ) {
    ob_start();
    $label = isset($param['label']) ? $param['label'] : '';
    $field_id = $param['id'];
    if ( is_numeric($field_id) ) {
      $field_id = 'wdform_' . $field_id . '_element' . $form->id;
    }
    $classes = array('wdform-label-section');
    $classes[] = isset($param['w_field_label_pos']) && $param['w_field_label_pos'] == "left" ? 'wd-width-30' : 'wd-width-100';
    if ( isset($param['w_class']) ) {
      $classes[] = $param['w_class'];
    }
    if ( isset($param['w_hide_label']) && $param['w_hide_label'] == "yes" ) {
      $classes[] = 'wd-hidden';
    }
    if ( isset($param['label_class']) ) {
      $classes[] = $param['label_class'];
    }
    $label_width = (isset($param['w_field_label_size']) && $param['w_field_label_size'] != '') ? ' style="max-width: ' . $param['w_field_label_size'] . 'px;"' : '';
    ?><div class="<?php echo implode(' ', $classes); ?>"<?php echo $label_width; ?>>
    <label <?php echo ($field_id ? ' for="' . $field_id . '"' : ''); ?> class="wdform-label"><?php echo $label; ?></label><?php
    if ( isset($param['w_required']) && $param['w_required'] == "yes" ) {
      $requiredmark = isset($form->requiredmark) ? $form->requiredmark : '';
      ?><span class="wdform-required"><?php echo $requiredmark; ?></span><?php
    }
    ?></div><?php

    return ob_get_clean();
  }

  /**
   * Return form field section HTML.
   *
   * @param string $html
   * @param array $param
   *
   * @return string
   */
  private function field_section( $html = '', $param = array() ) {
    ob_start();
    $classes = array( 'wdform-element-section', 'wd-flex' );
    if ( isset($param['w_class']) ) {
      $classes[] = $param['w_class'];
    }
    $classes[] = (($param['w_field_label_pos'] == "top" || $param['w_hide_label'] == "yes") ? 'wd-width-100' : 'wd-width-70');
    ?><div class="<?php echo implode(' ', $classes); ?>" <?php echo ($param['w_size'] != '' ? 'style="max-width: ' . $param['w_size'] . 'px;"' : ''); ?>><?php echo $html; ?></div><?php

    return ob_get_clean();
  }

  /**
   * Get custom fields
   * @return array
   */
 private function get_custom_fields() {
	$userid = '';
	$username = '';
	$useremail = '';
	$adminemail = get_option( 'admin_email' );
	$current_user = wp_get_current_user();
	if ( $current_user->ID != 0 ) {
	  $userid = $current_user->ID;
	  $username = $current_user->display_name;
	  $useremail = $current_user->user_email;
	}
	$custom_fields = array(
		"ip" => $_SERVER['REMOTE_ADDR'],
		"userid" => $userid,
		'adminemail' => $adminemail,
		"useremail" => $useremail,
		"username" => $username
	);
	return $custom_fields;
  }

  /**
   * Get nonce field
   *
   * @return false|string
   */
  private function get_nonce_field() {
    ob_start();
    wp_nonce_field(WDFMInstance(self::PLUGIN)->fm_form_nonce, WDFMInstance(self::PLUGIN)->fm_form_nonce);

    return ob_get_clean();
  }
}
