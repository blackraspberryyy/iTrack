<?php

class AdminViolations_model extends CI_Model
{
    public function getUsers($where = null)
    {
        $table = 'user';
        if ($where !== null) {
            $this->db->where($where);
        }
        $query = $this->db->get($table);

        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    public function searchUsers($like = null, $where = null)
    {
        $table = 'user';
        if (!empty($like)) {
            $this->db->like('user_number', $like);
        }
        if ($where !== null) {
            $this->db->where($where);
        }
        $this->db->where(array('user_isactive' => 1));
        $query = $this->db->get($table);

        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    public function getTeachers($where = null)
    {
        $table = 'user';
        if ($where !== null) {
            $this->db->where($where);
        }
        $this->db->where(array('user_access' => 'teacher'));
        $query = $this->db->get($table);

        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    public function searchTeacher($like = null)
    {
        $table = 'user';
        if (!empty($like)) {
            $this->db->like('user_number', $like);
        }
        $this->db->where(array('user_access' => 1, 'user_access' => 'teacher'));
        $query = $this->db->get($table);

        return ($query->num_rows() > 0) ? $query->result() : false;
    }
}
