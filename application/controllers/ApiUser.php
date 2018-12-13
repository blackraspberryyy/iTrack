<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiUser extends CI_Controller {
  public function index() {
    // post
    $params = api_params($this);
    $serial = $params['serial'];

    if ($users = $this->Api_model->getUserViaSerial($serial)) {
      api_respond(TRUE, array(
        'msg' => 'User found.',
        'user' => $users[0]
      ));
    } else {
      api_respond(FALSE, 'No student found.');
    }
  }

  public function token() {
    // post
    $params = api_params($this);
    $user_id = $params['user_id'];
    $token = $params['token'];

    if ($this->Api_model->saveToken($user_id, $token)) {
      api_respond(TRUE, 'User token saved.');
    } else {
      api_respond(FALSE, 'User token not saved.');
    }
  }
}
