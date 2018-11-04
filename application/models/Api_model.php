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
        'reporter_id' => $report['reporter_id'],
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

  // group
  public function groupViolations($total = 15) {
    // check whole minor_reports table with 0 group_id

    // get only uids with 15+ offenses
    $query = $this->db
      ->select("
        user_id,
        LEAST($total, COUNT(*)) AS total
      ")
      ->from('minor_reports')
      ->where('group_id', 0)
      ->group_by('user_id')
      ->having('total', $total)
      ->get();

    $pair = query_result($query, 'array');

    // prettyPrint($pair);
    // echo count($pair);
    // echo $pair == 0;
    // exit;
    if (!$pair || count($pair) == 0) {
      // stop the recursion!
      // count($pair) should be falsy
      return;
    }

    foreach ($pair as $row) {
      $user_id = $row['user_id'];
      // assert that total is the same as $total

      $TIME = time();
      // first, insert group first!
      $this->db->insert('minor_reports_quota', array(
        'created_at' => $TIME
      ));
      $group_id = $this->db->insert_id();

      // update here
      $set = array(
        'group_id' => $group_id,
        'grouped_at' => $TIME
      );
      $where = array(
        'user_id' => $user_id,
        'group_id' => 0
      );
      $this->db->update('minor_reports', $set, $where, $total);
    }

    // once updated, call this function again because
    // why not
    // jk, to group ungrouped rows
    $this->groupViolations($total);
  }
}

//! some queries to save lives

// SELECT
// 	user_id,
//  LEAST(5, COUNT(*)) AS at_least
// FROM minor_reports
// WHERE group_id = 0
// GROUP BY user_id
// HAVING at_least = 5

// UPDATE minor_reports
// SET group_id = 1
// WHERE group_id = 0 AND user_id = 1
// LIMIT 5
