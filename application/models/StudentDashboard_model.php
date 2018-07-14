<?php

class StudentDashboard_model extends CI_Model {
    function getStudent($where = NULL) {
        $table = "student";
        if ($where !== NULL) {
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }
}