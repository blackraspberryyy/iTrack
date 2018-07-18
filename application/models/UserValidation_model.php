<?php

class UserValidation_model extends CI_Model {

    public function get_validation($where = NULL) {
        $table = "incident_report";
        $join = "user";
        $on = "incident_report.user_id = user.user_id";
        $join2 = "violation";
        $on2 = "incident_report.violation_id = violation.violation_id";
        $this->db->join($join, $on, "left outer");
        $this->db->join($join2, $on2, "left outer");
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->order_by("incident_report_added_at", "DESC");
        $query = $this->db->get($table);
        return ($query->num_rows() > 0 ) ? $query->result() : FALSE;
    }

}
