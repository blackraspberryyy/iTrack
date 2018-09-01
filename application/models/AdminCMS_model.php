<?php
    class AdminCMS_model extends CI_Model{
        function getCMS() {
            $table = "cms";
            $query = $this->db->get($table);
            return ($query->num_rows() > 0) ? $query->result() : false;
        }
    }