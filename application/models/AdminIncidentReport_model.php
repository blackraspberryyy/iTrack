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
    
    function get_user_id($user_number){
        $table = "user";
        $where = array(
            "user_access" => "student",
            "user_number" => $user_number
        );
        if ($where !== NULL) {
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }
    
    function getIncidentReport(){
        $join1 = "user AS user1";
        $join2 = "violation";
        $join3 = "admin";
        $join4 = "user AS student_reported_by";
        $on1 = "incident_report.user_id = user1.user_id";
        $on2 = "incident_report.violation_id = violation.violation_id";
        $on3 = "incident_report.admin_reported_by = admin.admin_id";
        $on4 = "incident_report.student_reported_by = student_reported_by.user_id";
        
        $this->db->join($join1, $on1, "left outer");
        $this->db->join($join2, $on2, "left outer");
        $this->db->join($join3, $on3, "left outer");
        $this->db->join($join4, $on4, "left outer");
        
        $this->db->select("admin.*, incident_report.*, violation.*, user1.*, "
                . "`student_reported_by`.`user_id` AS `student_reported_by_id`, `student_reported_by`.`user_number` AS `student_reported_by_number`, `student_reported_by`.`user_firstname` AS `student_reported_by_firstname`, `student_reported_by`.`user_lastname` AS `student_reported_by_lastname`, `student_reported_by`.`user_middlename` AS `student_reported_by_middlename`, `student_reported_by`.`user_password` AS `student_reported_by_password`, `student_reported_by`.`user_picture` AS `student_reported_by_picture`, `student_reported_by`.`user_course` AS `student_reported_by_course`, `student_reported_by`.`user_access` AS `student_reported_by_access`, `student_reported_by`.`user_isactive` AS `student_reported_by_isactive`, `student_reported_by`.`user_added_at` AS `student_reported_by_added_at`, `student_reported_by`.`user_updated_at` AS `student_reported_by_updated_at`");
        $this->db->from("incident_report");
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result() : false;
    }
    
}
