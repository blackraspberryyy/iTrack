<?php
    class AdminDussap_model extends CI_Model{
        function getAttendance($where = NULL){
            if($where !== NULL){
                $this->db->where($where);
            }
            $this->db->select('att.*, ir.*, u.*,'
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
                .'v.*'
            );
            $this->db->from('attendance AS att');
            $this->db->join('incident_report AS ir', 'att.incident_report_id = ir.incident_report_id','LEFT OUTER');
            $this->db->join('user AS u', 'ir.user_id = u.user_id','LEFT OUTER');
            $this->db->join('user AS u2', 'ir.user_reported_by = u2.user_id','LEFT OUTER');
            $this->db->join('violation AS v', 'ir.violation_id = v.violation_id','LEFT OUTER');
            $this->db->order_by("att.attendance_created_at", "asc");
            $query = $this->db->get();
            return ($query->num_rows() > 0) ? $query->result() : false;
        }
        function getAttendanceTotalHours($where = NULL){
            if($where !== NULL){
                $this->db->where($where);
            }
            $this->db->select('SUM(attendance_hours_rendered) AS hours_rendered');
            $this->db->from('attendance');
            $this->db->order_by("attendance_created_at", "asc");
            $query = $this->db->get();
            return ($query->num_rows() > 0) ? $query->result() : false;
        }
        function getActiveIncidentReport(){
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
            .'v.*'
        );
        $this->db->from('incident_report AS ir');
        $this->db->where(array('ir.incident_report_status' => 1));
        $this->db->join('user AS u', 'ir.user_id = u.user_id','LEFT OUTER');
        $this->db->join('user AS u2', 'ir.user_reported_by = u2.user_id','LEFT OUTER');
        $this->db->join('violation AS v', 'ir.violation_id = v.violation_id','LEFT OUTER');

        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result() : false;
        }

    }