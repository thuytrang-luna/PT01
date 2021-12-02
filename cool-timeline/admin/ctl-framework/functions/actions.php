<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Get icons from admin ajax
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'ctl_get_icons' ) ) {
  function ctl_get_icons() {

    $nonce = ( ! empty( $_POST[ 'nonce' ] ) ) ? sanitize_text_field( wp_unslash( $_POST[ 'nonce' ] ) ) : '';

    if ( ! wp_verify_nonce( $nonce, 'ctl_icon_nonce' ) ) {
      wp_send_json_error( array( 'error' => esc_html__( 'Error: Invalid nonce verification.', 'ctl' ) ) );
    }

    ob_start();

    $icon_library = ( apply_filters( 'ctl_fa4', false ) ) ? 'fa4' : 'fa5';

    CTL::include_plugin_file( 'fields/icon/'. $icon_library .'-icons.php' );

    $icon_lists = apply_filters( 'ctl_field_icon_add_icons', ctl_get_default_icons() );

    if ( ! empty( $icon_lists ) ) {

      foreach ( $icon_lists as $list ) {

        echo ( count( $icon_lists ) >= 2 ) ? '<div class="ctl-icon-title">'. esc_attr( $list['title'] ) .'</div>' : '';

        foreach ( $list['icons'] as $icon ) {
          echo '<i title="'. esc_attr( $icon ) .'" class="'. esc_attr( $icon ) .'"></i>';
        }

      }

    } else {

      echo '<div class="ctl-error-text">'. esc_html__( 'No data available.', 'ctl' ) .'</div>';

    }

    $content = ob_get_clean();

    wp_send_json_success( array( 'content' => $content ) );

  }
  add_action( 'wp_ajax_ctl-get-icons', 'ctl_get_icons' );
}

/**
 *
 * Export
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'ctl_export' ) ) {
  function ctl_export() {

    $nonce  = ( ! empty( $_GET[ 'nonce' ] ) ) ? sanitize_text_field( wp_unslash( $_GET[ 'nonce' ] ) ) : '';
    $unique = ( ! empty( $_GET[ 'unique' ] ) ) ? sanitize_text_field( wp_unslash( $_GET[ 'unique' ] ) ) : '';

    if ( ! wp_verify_nonce( $nonce, 'ctl_backup_nonce' ) ) {
      die( esc_html__( 'Error: Invalid nonce verification.', 'ctl' ) );
    }

    if ( empty( $unique ) ) {
      die( esc_html__( 'Error: Invalid key.', 'ctl' ) );
    }

    // Export
    header('Content-Type: application/json');
    header('Content-disposition: attachment; filename=backup-'. gmdate( 'd-m-Y' ) .'.json');
    header('Content-Transfer-Encoding: binary');
    header('Pragma: no-cache');
    header('Expires: 0');

    echo json_encode( get_option( $unique ) );

    die();

  }
  add_action( 'wp_ajax_ctl-export', 'ctl_export' );
}

/**
 *
 * Import Ajax
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'ctl_import_ajax' ) ) {
  function ctl_import_ajax() {

    $nonce  = ( ! empty( $_POST[ 'nonce' ] ) ) ? sanitize_text_field( wp_unslash( $_POST[ 'nonce' ] ) ) : '';
    $unique = ( ! empty( $_POST[ 'unique' ] ) ) ? sanitize_text_field( wp_unslash( $_POST[ 'unique' ] ) ) : '';
    $data   = ( ! empty( $_POST[ 'data' ] ) ) ? wp_kses_post_deep( json_decode( wp_unslash( trim( $_POST[ 'data' ] ) ), true ) ) : array();

    if ( ! wp_verify_nonce( $nonce, 'ctl_backup_nonce' ) ) {
      wp_send_json_error( array( 'error' => esc_html__( 'Error: Invalid nonce verification.', 'ctl' ) ) );
    }

    if ( empty( $unique ) ) {
      wp_send_json_error( array( 'error' => esc_html__( 'Error: Invalid key.', 'ctl' ) ) );
    }

    if ( empty( $data ) || ! is_array( $data ) ) {
      wp_send_json_error( array( 'error' => esc_html__( 'Error: The response is not a valid JSON response.', 'ctl' ) ) );
    }

    // Success
    update_option( $unique, $data );

    wp_send_json_success();

  }
  add_action( 'wp_ajax_ctl-import', 'ctl_import_ajax' );
}

/**
 *
 * Reset Ajax
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'ctl_reset_ajax' ) ) {
  function ctl_reset_ajax() {

    $nonce  = ( ! empty( $_POST[ 'nonce' ] ) ) ? sanitize_text_field( wp_unslash( $_POST[ 'nonce' ] ) ) : '';
    $unique = ( ! empty( $_POST[ 'unique' ] ) ) ? sanitize_text_field( wp_unslash( $_POST[ 'unique' ] ) ) : '';

    if ( ! wp_verify_nonce( $nonce, 'ctl_backup_nonce' ) ) {
      wp_send_json_error( array( 'error' => esc_html__( 'Error: Invalid nonce verification.', 'ctl' ) ) );
    }

    // Success
    delete_option( $unique );

    wp_send_json_success();

  }
  add_action( 'wp_ajax_ctl-reset', 'ctl_reset_ajax' );
}

/**
 *
 * Chosen Ajax
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'ctl_chosen_ajax' ) ) {
  function ctl_chosen_ajax() {

    $nonce = ( ! empty( $_POST[ 'nonce' ] ) ) ? sanitize_text_field( wp_unslash( $_POST[ 'nonce' ] ) ) : '';
    $type  = ( ! empty( $_POST[ 'type' ] ) ) ? sanitize_text_field( wp_unslash( $_POST[ 'type' ] ) ) : '';
    $term  = ( ! empty( $_POST[ 'term' ] ) ) ? sanitize_text_field( wp_unslash( $_POST[ 'term' ] ) ) : '';
    $query = ( ! empty( $_POST[ 'query_args' ] ) ) ? wp_kses_post_deep( $_POST[ 'query_args' ] ) : array();

    if ( ! wp_verify_nonce( $nonce, 'ctl_chosen_ajax_nonce' ) ) {
      wp_send_json_error( array( 'error' => esc_html__( 'Error: Invalid nonce verification.', 'ctl' ) ) );
    }

    if ( empty( $type ) || empty( $term ) ) {
      wp_send_json_error( array( 'error' => esc_html__( 'Error: Invalid term ID.', 'ctl' ) ) );
    }

    $capability = apply_filters( 'ctl_chosen_ajax_capability', 'manage_options' );

    if ( ! current_user_can( $capability ) ) {
      wp_send_json_error( array( 'error' => esc_html__( 'Error: You do not have permission to do that.', 'ctl' ) ) );
    }

    // Success
    $options = CTL_Fields::field_data( $type, $term, $query );

    wp_send_json_success( $options );

  }
  add_action( 'wp_ajax_ctl-chosen', 'ctl_chosen_ajax' );
}
