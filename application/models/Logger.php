<?php
class Logger extends CI_Model {
    function saveToAudit($user_id, $desc){
        $data = array(
            "user_id" => $user_id,
            'log_type' => 'log',
            "log_desc" => $desc
        );
        $this->db->insert("audit_trail", $data);
        return $this->db->affected_rows();
    }

    function saveToLogs($user_id, $desc){
        $data = array(
            "user_id" => $user_id,
            'log_type' => 'log',
            "log_desc" => $desc
        );
        $this->db->insert("audit_trail", $data);
        return $this->db->affected_rows();
    }
}
