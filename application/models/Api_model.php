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

  public function addMinorReport($serial, $report) {
    // get uid via serial
    if ($users = $this->getUserViaSerial($serial)) {
      $user = $users[0];
    } else {
      return FALSE;
    }

    // attach uid to $report
    $report['user_id'] = $user['user_id'];

    return $this->db->insert('minor_reports', $report);
  }

  public function addMinorReports($reports) {
    foreach ($reports as $key => $report) {
      // get user via serial
      $serial = $report['serial'];
      if ($users = $this->getUserViaSerial($serial)) {
        $user = $users[0];
      } else {
        // if no user, do not insert
        return FALSE;
      }

      // build report
      $mReport = array(
        'user_id' => $user['user_id'],
        'violation_id' => $report['violation_id'],
        'location' => $report['location'],
        'message' => $report['message'],
        'tapped_at' => $report['timestamp'],
        'created_at' => time()
      );

      // set to $reports
      $reports[$key] = $mReport;
    }

    return $this->db->insert_batch('minor_reports', $reports);
  }
}
