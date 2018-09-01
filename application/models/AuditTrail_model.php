<?php

class AuditTrail_model extends CI_Model {
    function getAdmin($where = NULL) {
        $table = "admin";
        if ($where !== NULL) {
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }
    
    function getAuditTrails(){
        $table = "audit_trail";
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    function insertAudit($data){
        $table = "audit_trail";
        $this->db->insert("audit_trail", $data);
        return $this->db->affected_rows();
    }
}