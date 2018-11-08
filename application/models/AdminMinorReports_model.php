<?php

class AdminMinorReports_model extends CI_Model {
  function getMinorReports() {
    $table = "minor_reports_quota";

    $this->db->select(
      '
      mrq.id AS group_id,
      mr.id AS mr_id,
      u.user_firstname AS fname,
      u.user_middlename AS mname,
      u.user_lastname AS lname,
      mr.location AS location,
      mr.message AS message,
      v.violation_name AS violation_name,
      FROM_UNIXTIME(mr.tapped_at) AS tapped_at,
      DAY(FROM_UNIXTIME(tapped_at)) AS daily
      '
    );

    $this->db->from('minor_reports_quota AS mrq');
    $this->db->join('minor_reports AS mr', 'mr.group_id = mrq.id', 'INNER JOIN');
    $this->db->join('user AS u', 'u.user_id = mr.user_id', 'INNER JOIN');
    $this->db->join('violation AS v', 'v.violation_id = mr.violation_id', 'INNER JOIN');
    $query = $this->db->get($table);
    return ($query->num_rows() > 0) ? $query->result() : false;
  }
}