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
    function getComprehensiveIncidentReport($where = NULL){
        if($where !== NULL){
            $this->db->where($where);
        }
        $this->db->select('ir.*, u.*,'
            .'u2.user_id AS reportedby_id,'
            .'u2.user_number AS reportedby_number,'
            .'u2.user_firstname AS reportedby_firstname,'
            .'u2.user_lastname AS reportedby_lastname,'
            .'u2.user_middlename AS reportedby_middlename,'
            .'u2.user_password AS reportedby_password,'
            .'u2.user_picture AS reportedby_picture,'
            .'u2.user_course AS reportedby_course,'
            .'u2.user_access AS reportedby_access,'
            .'u2.user_isActive AS reportedby_isActive,'
            .'u2.user_added_at AS reportedby_added_at,'
            .'u2.user_updated_at AS reportedby_updated_at,'
            .'v.*,'
            .'e.*, e.effect_hours AS violation_hours'
        );
        $this->db->from('incident_report AS ir');
        
        $this->db->join('user AS u', 'ir.user_id = u.user_id','LEFT OUTER');
        $this->db->join('user AS u2', 'ir.user_reported_by = u2.user_id','LEFT OUTER');
        $this->db->join('violation AS v', 'ir.violation_id = v.violation_id','LEFT OUTER');
        $this->db->join('effects AS e', 'ir.effects_id = e.effect_id','LEFT OUTER');

        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    function getDistinctViolationOnIncidentReport($where = NULL){
        if($where !== NULL){
            $this->db->where($where);
        }
        $this->db->select('ir.violation_id, v.violation_name');
        $this->db->join('violation AS v', 'ir.violation_id = v.violation_id','LEFT OUTER');
        $this->db->from('incident_report AS ir');
        $this->db->distinct();

        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    function getIncidentReportCount($course, $violation_id = NULL, $year = NULL, $includeAssociates = FALSE){
        if($year !== NULL){
            $this->db->where(array('u.user_year' => $year));
        }
        if($violation_id !== NULL){
            $this->db->where('ir.violation_id', $violation_id);
        }

        if($includeAssociates){
            $this->db->where('u.user_access', 'teacher');
        }else{
            $this->db->like('u.user_course', $course);
            $this->db->where('u.user_access', 'student');
        }

        $this->db->select('ir.*, u.*,'
            .'u2.user_id AS reportedby_id,'
            .'u2.user_number AS reportedby_number,'
            .'u2.user_firstname AS reportedby_firstname,'
            .'u2.user_lastname AS reportedby_lastname,'
            .'u2.user_middlename AS reportedby_middlename,'
            .'u2.user_password AS reportedby_password,'
            .'u2.user_picture AS reportedby_picture,'
            .'u2.user_course AS reportedby_course,'
            .'u2.user_access AS reportedby_access,'
            .'u2.user_isActive AS reportedby_isActive,'
            .'u2.user_added_at AS reportedby_added_at,'
            .'u2.user_updated_at AS reportedby_updated_at,'
            .'v.*,'
            .'e.*, e.effect_hours AS violation_hours'
        );
        $this->db->from('incident_report AS ir');
        
        $this->db->join('user AS u', 'ir.user_id = u.user_id','LEFT OUTER');
        $this->db->join('user AS u2', 'ir.user_reported_by = u2.user_id','LEFT OUTER');
        $this->db->join('violation AS v', 'ir.violation_id = v.violation_id','LEFT OUTER');
        $this->db->join('effects AS e', 'ir.effects_id = e.effect_id','LEFT OUTER');

        
        $this->db->where('ir.incident_report_isAccepted', 1);
        $query = $this->db->get();
        return $query->num_rows();
    }
}