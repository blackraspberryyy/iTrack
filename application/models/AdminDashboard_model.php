<?php

class AdminDashboard_model extends CI_Model {
    function getAdmin($where = NULL) {
        $table = "admin";
        if ($where !== NULL) {
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }
    function getUsers($where = NULL){
        $table = "user";
        if ($where !== NULL) {
            $this->db->where($where);
        }
        $this->db->where(array("user_isactive" => 1));

        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }
    function getIncidentReports($where = NULL){
        $table = "incident_report";
        if ($where !== NULL) {
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }
}