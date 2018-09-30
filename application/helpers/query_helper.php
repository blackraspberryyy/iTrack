<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('query_result')) {
  function query_result($query, $type = 'object', $default = FALSE) {
    return $query->num_rows() > 0 ? $query->result($type) : $default;
  }   
}
