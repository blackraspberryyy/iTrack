<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('to_key_value')) {
  function to_key_value($arr, $mKey, $mValue = NULL, $cb = NULL) {
    // if $cb is not function
    // make sure it is always true
    if (!is_callable($cb)) {
      $cb = function() {
        return TRUE;
      };
    }

    $newArr = array();
    foreach ($arr as $value) {
      // if $mValue is not a string,
      // put whole object
      $actualValue = is_string($mValue) ? $value[$mValue] : $value;

      if ($cb($actualValue)) {
        $newArr[$value[$mKey]] = $actualValue;
      }
    }
    return $newArr;
  }
}
