<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('api_respond')) {
  function api_respond($success = TRUE, $data = array(), $val = NULL) {
    // if $data is string
    if (is_string($data)) {
      // if $val is NULL, turn it into 'msg'
      // else, assign stuff
      if ($val == NULL) {
        $val = $data;
        $data = 'msg';
      }

      $data = array($data => $val);
    }

    // if $data is still not an array, force it!
    if (!is_array($data)) {
      $data = array();
    }

    // put that success!
    $data['success'] = $success;
    echo json_encode($data);
    exit;
  }   
}

if (!function_exists('api_params')) {
  function api_params($controller) {
    return json_decode($controller->input->raw_input_stream, TRUE);
  }
}
