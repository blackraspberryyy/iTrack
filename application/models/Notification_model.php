<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends CI_Model {
  public function getAll($user_id) {
    $query = $this->db
      ->from('notifications')
      ->where('user_id', $user_id)
      ->order_by('created_at', 'desc')
      ->order_by('id', 'desc')
      ->get();

    return query_result($query, 'array');
  }

  // TODO: in live env, change $notify to TRUE
  public function send($user_id, $title, $body, $notify = FALSE) {
    $created_at = time();

    // build dat set
    $set = array(
      'user_id' => $user_id,
      'title' => $title,
      'body' => $body,
      'created_at' => $created_at
    );
    
    // check if user exists first then get
    if ($users = $this->Api_model->getUserViaId($user_id)) {
      $user = $users[0];
    } else {
      return FALSE;
    }

    // if not successful
    if (!$this->db->insert('notifications', $set)) {
      return FALSE;
    }

    if ($notify) {
      // get last inserted id
      $notif_id = $this->db->insert_id();
      notificate($notif_id, $user_id, $user['user_fcm_token'], $title, $body, $created_at);
    }

    return TRUE;
  }
}
