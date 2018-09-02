<?php
    class AdminCMS_model extends CI_Model{
        function getCMS() {
            $table = "cms";
            $query = $this->db->get($table);
            return ($query->num_rows() > 0) ? $query->result() : false;
        }
        function editCMS($cms_id, $data){
            $this->db->where(array("cms_id" => $cms_id));
            $this->db->update("cms", $data);
            return $this->db->affected_rows();
        }
    }