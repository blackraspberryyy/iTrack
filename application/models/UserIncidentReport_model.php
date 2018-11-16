<?php

class UserIncidentReport_model extends CI_Model {

    function getMajorViolations() {
        $table = "violation";
        $this->db->where(array("violation_type" => "major", "violation_category" => "default"));
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    function getMinorViolations() {
        $table = "violation";
        $this->db->where(array("violation_type" => "minor", "violation_category" => "default"));
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    function getIncidentReport($where = NULL) {
        if ($where !== NULL) {
            $this->db->where($where);
        }
        $this->db->select('ir.*, u.*,'
            . 'u2.user_id AS reportedby_id,'
            . 'u2.user_number AS reportedby_number,'
            . 'u2.user_firstname AS reportedby_firstname,'
            . 'u2.user_lastname AS reportedby_lastname,'
            . 'u2.user_middlename AS reportedby_middlename,'
            . 'u2.user_password AS reportedby_password,'
            . 'u2.user_picture AS reportedby_picture,'
            . 'u2.user_course AS reportedby_course,'
            . 'u2.user_access AS reportedby_access,'
            . 'u2.user_isActive AS reportedby_isActive,'
            . 'u2.user_added_at AS reportedby_added_at,'
            . 'u2.user_updated_at AS reportedby_updated_at,'
            . 'v.*'
            . 'e.*, e.effect_hours AS violation_hours'

        );
        $this->db->from('incident_report AS ir');

        $this->db->join('user AS u', 'ir.user_id = u.user_id', 'LEFT OUTER');
        $this->db->join('user AS u2', 'ir.user_reported_by = u2.user_id', 'LEFT OUTER');
        $this->db->join('violation AS v', 'ir.violation_id = v.violation_id', 'LEFT OUTER');
        $this->db->join('effects AS e', 'v.effect_id = e.effect_id','LEFT OUTER');

        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    function get_user_id($user_number) {
        $table = "user";
        $where = array(
            "user_number" => $user_number
        );
        if ($where !== NULL) {
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    function insert_incident_report($incident_report) {
        $this->db->insert("incident_report", $incident_report);
        return $this->db->affected_rows();
    }

}
