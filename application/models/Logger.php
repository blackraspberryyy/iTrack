<?php
class Logger extends CI_Model {
    function saveToAudit($user_id, $desc){
        if($user_id == "admin"){
            $user_id = "";
        }

        $data = array(
            "user_id" => $user_id,
            'log_type' => 'log',
            "log_desc" => $desc,
            'log_added_at' => time()
        );
        $this->db->insert("log", $data);
        return $this->db->affected_rows();
    }

    function saveToLogs($user_id, $type){
        $desc = $type == 'in' ? 'Logged in' : 'Logged out';

        $data = array(
            "user_id" => $user_id,
            'log_type' => 'log',
            'log_desc' => $desc,
            'log_added_at' => time()
        );
        $this->db->insert("log", $data);
        return $this->db->affected_rows();
    }
}
