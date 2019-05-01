<?php
    class AdminDepartment_model extends CI_Model{
        function getDepartments() {
            $table = "dept";
            $query = $this->db->get($table);
            return ($query->num_rows() > 0) ? $query->result() : false;
        }
        function editDepartment($id, $data){
            $this->db->where(array("dept_id" => $id));
            $this->db->update("dept", $data);
            return $this->db->affected_rows();
        }
        function addDepartment($data){
            $this->db->insert("dept", $data);
            return $this->db->affected_rows();
        }
        function deleteDepartment($id){
            $data = [
                "dept_status" => 0
            ];
            $this->db->where(array("dept_id" => $id));
            $this->db->update("dept", $data);
            return $this->db->affected_rows();
        }
        function restoreDepartment($id){
            $data = [
                "dept_status" => 1
            ];
            $this->db->where(array("dept_id" => $id));
            $this->db->update("dept", $data);
            return $this->db->affected_rows();
        }
    }