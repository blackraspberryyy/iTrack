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

  public function getUserViaId($id) {
    $this->db
      ->from('user')
      ->where('user_id', $id);

    $query = $this->db->get();
    return query_result($query, 'array');
  }

  public function getTypeOfViolation($vid) {
    $this->db
      ->select('violation_type')
      ->from('violation')
      ->where('violation_id', $vid);

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

  public function addIncidentReport($serial, $report) {
    // get uid via serial
    if ($users = $this->getUserViaSerial($serial)) {
      $user = $users[0];
    } else {
      return FALSE;
    }

    // attach uid to $report
    $report['user_id'] = $user['user_id'];

    return $this->db->insert('incident_report', $report);
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

  public function addReports($reports) {
    $allMinors = array();
    $allMajors = array();

    foreach ($reports as $key => $report) {
      // get user via serial
      $serial = $report['serial'];
      if ($users = $this->getUserViaSerial($serial)) {
        $user = $users[0];
      } else {
        // if no user, do not insert
        return FALSE;
      }

      // get type of violation
      if ($types = $this->getTypeOfViolation($report['violation_id'])) {
        $type = $types[0]['violation_type'];
      } else {
        return FALSE;
      }

      // build report
      if ($type == 'minor') {
        array_push($allMinors, array(
          'user_id' => $user['user_id'],
          'reporter_id' => $report['reporter_id'],
          'violation_id' => $report['violation_id'],
          'location' => $report['location'],
          'message' => $report['message'],
          'tapped_at' => $report['timestamp'],
          'created_at' => time()
        ));
      } else if ($type == 'major') {
        array_push($allMajors, array(
          'user_id' => $user['user_id'],
          'user_reported_by' => $report['reporter_id'],
          'violation_id' => $report['violation_id'],
          'effects_id' => 1,
          'incident_report_datetime' => $report['timestamp'],
          'incident_report_place' => $report['location'],
          'incident_report_age' => $report['age'],
          'incident_report_section_year' => $report['year_section'],
          'incident_report_message' => $report['message'],
          'incident_report_status' => 1,
          'incident_report_isAccepted' => 0,
          'incident_report_added_at' => time()
        ));
      }
    }

    $res = TRUE;
    if (count($allMinors) > 0) {
      $res = $res && $this->db->insert_batch('minor_reports', $allMinors);
    }
    if (count($allMajors) > 0) {
      $res = $res && $this->db->insert_batch('incident_report', $allMajors);
    }

    return $res;
  }

  public function saveToken($user_id, $token) {
    // make sure user exists first
    if (!($users = $this->getUserViaId($user_id))) {
      return FALSE;
    }

    return $this->db
      ->set('user_fcm_token', $token)
      ->where('user_id', $user_id)
      ->update('user');
  }

  // group
  public function groupViolations($total = 15) {
    // check whole minor_reports table with 0 group_id

    // get only uids with 15+ offenses
    $pair = $this->getGroupableUids($total);
    
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

      // QUERY AGAAAAIINN
      // use the subquery from last time
      $UVPair = $this->getGroupedUidVidPair($user_id);

      // if no pair, move to next iteration
      if (!$UVPair || count($UVPair) == 0) {
        continue;
      }

      // loop on pair
      foreach ($UVPair as $uId => $vIds) {
        // update here
        $set = array(
          'group_id' => $group_id,
          'grouped_at' => $TIME
        );
        $where = array(
          'user_id' => $uId,
          'group_id' => 0
        );

      $this->db
        ->set($set)
        ->where($where)
        ->where_in('violation_id', $vIds)
        ->update('minor_reports');
      }

    }

    // once updated, call this function again because
    // why not
    // jk, to group ungrouped rows
    $this->groupViolations($total);
  }

  private function getGroupableUids($total) {
    $query = $this->db
      ->select("
        user_id,
        LEAST($total, COUNT(*)) AS total
      ")
      ->from("
        (
          SELECT
            user_id,
            violation_id,
            tapped_at,
            DAY(FROM_UNIXTIME(tapped_at)) AS daily
          FROM minor_reports
          WHERE group_id = 0
          GROUP BY daily, user_id, violation_id
        ) AS mr_temp
      ", FALSE)
      ->group_by('user_id')
      ->having('total', $total)
      ->get();

    return query_result($query, 'array');
  }

  public function getGroupedUidVidPair($user_id = FALSE) {
    $this->db
      ->select('
        user_id,
        violation_id,
        DAY(FROM_UNIXTIME(tapped_at)) AS daily
      ')
      ->from('minor_reports')
      ->where(array(
        'group_id' => 0
      ));

    if ($user_id) {
      $this->db->where('user_id', $user_id);
    }

    $this->db
      ->group_by(array('daily', 'user_id', 'violation_id'))
      ->order_by(array(
        'user_id' => 'ASC',
        'violation_id' => 'ASC',
        'daily' => 'ASC'
      ));

    $query = $this->db->get();
    $res = query_result($query, 'array');

    // transform to user_id => [violation_id, violation_id, ...]

    // stop heree
    if (!$res || count($res) == 0) {
      return array();
    }

    $arr = array();
    foreach ($res as $row) {
      $uid = $row['user_id'];
      $vid = $row['violation_id'];

      // set array if not array yet :D
      if (!array_key_exists($uid, $arr)) {
        $arr[$uid] = array();
      }

      // then push those vIds in the $arr
      array_push($arr[$uid], $vid);
    }

    return $arr;
  }


  // student
  public function getTotalHours($uid = FALSE) {
    // TODO: get hours per incident_report
    $this->db
      ->select('
        u.user_id AS user_id,
        SUM(a.attendance_hours_rendered) AS hours_rendered,
        e.effect_hours AS violation_hours
      ')
      ->from('attendance a')
      ->join('incident_report ir', 'ir.incident_report_id = a.incident_report_id')
      ->join('user u', 'u.user_id = ir.user_id')
      ->join('violation v', 'v.violation_id = ir.violation_id')
      ->join('effects e', 'e.effect_id = ir.effects_id')
      ->where(array(
        'a.attendance_status' => 1,
        'ir.incident_report_status' => 1,
        'u.user_isactive' => 1,
        'u.user_access' => 'student'
      ))
      ->group_by(array('u.user_id', 'v.violation_id', 'ir.incident_report_id'));

    if ($uid) {
      $this->db->where('u.user_id', $uid);
    }

    $query = $this->db->get();
    return query_result($query, 'array');
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

// OMG

// SELECT
// *,
// LEAST(2, COUNT(*)) as total
// FROM (
//   SELECT
//   user_id,
//   violation_id,
//   tapped_at,
//   FROM_UNIXTIME(tapped_at) AS formatted,
//   DAY(FROM_UNIXTIME(tapped_at)) AS dayx
//   FROM minor_reports
//   WHERE group_id = 0
//   GROUP BY dayx, user_id, violation_id
//   ORDER BY user_id, violation_id, dayx
// ) AS mr_temp
// GROUP BY user_id
// HAVING total = 2
  
// OLDDD
// SELECT
// *
// FROM minor_reports
// WHERE group_id = 0
// GROUP BY user_id, violation_id

// HAHAHHAHAHA
// SELECT 

// mrq.id AS group_id,
// u.user_firstname AS fname,
// u.user_middlename AS mname,
// u.user_lastname AS lname,
// v.violation_name AS violation_name,
// FROM_UNIXTIME(mr.tapped_at) AS tapped_at,
// DAY(FROM_UNIXTIME(tapped_at)) AS daily

// FROM minor_reports_quota mrq
// JOIN minor_reports mr ON mr.group_id = mrq.id
// JOIN user u ON u.user_id = mr.user_id
// JOIN violation v ON v.violation_id = mr.violation_id

// GROUP BY mr.user_id, mr.violation_id, daily
// ORDER BY group_id



// get total hours
// SELECT
// u.user_id AS user_id,
// SUM(a.attendance_hours_rendered) AS total_hours
// FROM incident_report ir
// JOIN user u ON u.user_id = ir.user_id
// JOIN attendance a ON a.incident_report_id = ir.incident_report_id
// WHERE
// 	ir.incident_report_status = 1 AND
//   u.user_isactive = 1 AND
//   a.attendance_status = 1 AND
//   u.user_id = 5


// SELECT
// u.user_id AS user_id,
// ir.incident_report_id AS incident_report_id,
// v.violation_name AS violation_name,
// SUM(a.attendance_hours_rendered) AS hours_rendered,
// v.violation_hours AS violation_hours

// FROM attendance a
// JOIN incident_report ir ON ir.incident_report_id = a.incident_report_id
// JOIN user u ON u.user_id = ir.user_id
// JOIN violation v ON v.violation_id = ir.violation_id
// WHERE
// 	a.attendance_status = 1 AND
// 	ir.incident_report_status = 1 AND
// 	u.user_isactive = 1 AND
// 	u.user_id = 2
// GROUP BY u.user_id, v.violation_id, ir.incident_report_id