<?php

class Login_model extends CI_Model {
    function getinfo($table, $where = NULL) {
        if ($where !== NULL) {
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    public function hasValidCredentials($username, $password) {
        // check if username exists in db
        // get its password
        // compare it
        // return that user if match
        $this->db
            ->from('user')
            ->where(array(
                'user_number' => $username,
                'user_password' => sha1($password),
                'user_isactive' => 1
            ));

        $query = $this->db->get();
        return query_result($query, 'array');
    }
}