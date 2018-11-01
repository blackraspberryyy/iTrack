<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model {

  public function getUserViaSerial($serial) {
    $this->db
      ->from('user')
      ->where('user_serial_no', $serial);

    $query = $this->db->get();
    return query_result($query, 'array');
  }

  public function getViolationsList($type = NULL) {
    $this->db->from('violation');

    if ($type) {
      $this->db->where('violation_type', $type);
    }

    $query = $this->db->get();
    return query_result($query, 'array');
  }
}
