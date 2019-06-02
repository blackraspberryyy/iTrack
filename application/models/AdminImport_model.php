<?php
class AdminImport_model extends CI_Model{
    function add_students($students){
        $this->db->insert_batch("user", $students);
        return $this->db->affected_rows();
    }

    function getUsers($where = NULL){
        $table = "user";
        if ($where !== NULL) {
            $this->db->where($where);
        }

        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }
}