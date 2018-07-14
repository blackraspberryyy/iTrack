<?php

class AdminIncidentReport_model extends CI_Model {

    function getAdmin($where = NULL) {
        $table = "admin";
        if ($where !== NULL) {
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    function search_student($student_number) {
        $table = "user";
        if ($student_number !== NULL) {
            $this->db->where(array("user_access" => "student"));
            $this->db->like('user_number', $student_number);
        }
        $query = $this->db->get($table);

        return ($query->num_rows() > 0) ? $query->result() : false;
    }
    function getViolations() {
        $table = "violation";
        $this->db->where(array("violation_type" => "major", "violation_category" => "default"));
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }
    
    function insert_violation($violation){
        $this->db->insert("violation", $violation);
        return $this->db->affected_rows();
    }
    
    function insert_incident_report($incident_report){
        $this->db->insert("incident_report", $incident_report);
        return $this->db->affected_rows();
    }
    
    function get_student_id($student_number){
        $table = "user";
        $where = array(
            "user_access" => "student",
            "user_number" => $student_number
        );
        if ($where !== NULL) {
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }
    

}
