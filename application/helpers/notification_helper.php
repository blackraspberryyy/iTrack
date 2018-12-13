<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('notificate')) {
  function notificate($id, $user_id, $user_token, $title, $body, $timestamp, $with_response = FALSE) {
    $url = 'https://fcm.googleapis.com/fcm/send';
    $API_KEY = fcm_keys('server');

    $headers = array(
      'Authorization: key=' . $API_KEY,
      'Content-Type: application/json'
    );

    $fields = array(
      'priority' => 'high',
      'registration_ids' => array($user_token),
      'message_id' => 'm-' . $id,
      'notification' => array(
        'title' => $title,
        'body' => $body
      ),
      'data' => array(
        'id' => $id,
        'user_id' => $user_id,
        'title' => $title,
        'body' => $body,
        'timestamp' => $timestamp
      )
    );

    $fields = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

    $result = curl_exec($ch);

    if ($with_response) {
      echo $result;
    }

    curl_close($ch);
  }
}
