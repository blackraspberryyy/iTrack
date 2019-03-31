<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('upload_file')) {
  function upload_file($controller, $file_name = 'file', $allowed_types = NULL, $path = 'uploads/images/') {
    $actualFileName = 'IMG_' . date('Y-m-d_h-i-s');
    $uploadPath = "./$path";

    // if $controller is falsy, do simple
    // use $file_name as content
    if (!$controller && $file_name) {
      // TODO: uses jpg by default looool
      $decoded = base64_decode("$file_name");
      $actualFileName = "$actualFileName.jpg";
      file_put_contents("$uploadPath$actualFileName", $decoded);
      return [
        'success' => TRUE,
        'data' => [
          'file_name' => $actualFileName
        ]
      ];
    }

    // actual ci stuff

    if (!$allowed_types) {
      $allowed_types = 'jpg|png|jpeg';
    }

    $config = array(
      'upload_path' => $uploadPath,
      'allowed_types' => $allowed_types,
      'max_size' => 5*1000*1024,
      'file_name' => $actualFileName
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
