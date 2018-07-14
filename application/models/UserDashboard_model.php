<?php

class UserDashboard_model extends CI_Model {
    function getUser($where = NULL) {
        $table = "user";
        if ($where !== NULL) {
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }
}