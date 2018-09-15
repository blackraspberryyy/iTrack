<?php

class AdminViolations_model extends CI_Model{
    function getStudents($where = NULL) {
        $table = "user";
        if ($where !== NULL) {
            $this->db->where($where);
        }
        $this->db->where(array("user_access" => 'student'));
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }
    public function searchStudents($like = NULL) {
        $table = "user";
        if (!empty($like)) {
            $this->db->like('user_number', $like);
        }
        $this->db->where(array("user_access" => 1, "user_access" => 'student'));
        $query = $this->db->get($table);
        return ($query->num_rows() > 0 ) ? $query->result() : FALSE;
    }
}