<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('upload_file')) {
  function upload_file($controller, $file_name = 'file', $allowed_types = NULL, $path = 'uploads/images/') {
    if (!$allowed_types) {
      $allowed_types = 'jpg|png|jpeg';
    }

    $config = array(
      'upload_path' => './../'.$path,
      'allowed_types' => $allowed_types,
      'max_size' => 5*1000*1024,
      'file_name' => 'IMG_' . time()
    );

    $controller->load->library('upload', $config);

    if (!$controller->upload->do_upload($file_name)) {
      $error = $controller->upload->display_errors();
      return array(
        'success' => FALSE,
        'error' => strip_tags($error)
      );
    }

    return array(
      'success' => TRUE,
      'data' => $controller->upload->data()
    );
  }
}
