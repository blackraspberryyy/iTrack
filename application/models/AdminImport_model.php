<?php
class AdminImport_model extends CI_Model{
    function add_students($students){
        $this->db->insert_batch("user", $students);
        return $this->db->affected_rows();
    }
}