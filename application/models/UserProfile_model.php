<?php

class UserProfile_model extends CI_Model {

    function getinfo($table, $where = NULL) {
        if ($where !== NULL) {
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    function update_user($data, $user_id) {
        $this->db->where(array("user_id" => $user_id));
        $this->db->update("user", $data);
        return $this->db->affected_rows();
    }

}
