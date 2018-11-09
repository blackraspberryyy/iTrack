<?php

class AdminMinorReports_model extends CI_Model {
  function getMinorReports($where = NULL) {
    $table = "minor_reports";

    $this->db->select(
      '
      u.user_id AS user_id,
      u.user_firstname AS user_fname,
      u.user_middlename AS user_mname,
      u.user_lastname AS user_lname,

      r.user_id AS reporter_id,
      r.user_firstname AS reporter_fname,
      r.user_middlename AS reporter_mname,
      r.user_lastname AS reporter_lname,

      v.violation_id AS violation_id,
      v.violation_name AS violation_name,
      
      mr.id AS mr_id,
      mr.location AS location,
      mr.message AS message, 
      mr.tapped_at AS tapped_at,
      mr.created_at AS created_at,

      mr.group_id AS group_id,
      mr.grouped_at AS grouped_at
      '
    );

    $this->db->from('minor_reports AS mr');
    $this->db->join('user AS u', 'u.user_id = mr.user_id', 'INNER JOIN');
    $this->db->join('user AS r', 'r.user_id = mr.reporter_id', 'INNER JOIN');
    $this->db->join('violation AS v', 'v.violation_id = mr.violation_id', 'INNER JOIN');

    if ($where !== NULL) {
      $this->db->where($where);
    }
    
    $this->db->order_by("mr.tapped_at", "DESC");
    $this->db->order_by("mr.created_at", "DESC");
    
    $query = $this->db->get();
    
    return ($query->num_rows() > 0) ? $query->result() : false;
  }
}