<?php
    class AdminImport_model extends CI_Model{
		function add_student($student){
			$this->db->insert("user", $student);
			return $this->db->affected_rows();
		}
    }