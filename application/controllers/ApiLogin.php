<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiLogin extends CI_Controller {
  public function index() {
    // post
    $params = api_params($this);
    $username = $params['username'];
    $password = $params['password'];

    if ($user = $this->Login_model->hasValidCredentials($username, $password)) {
      api_respond(TRUE, array(
        'msg' => 'User found.',
        'user' => $user[0]
      ));
    } else {
      api_respond(FALSE, 'Incorrect username or password.');
    }
  }
}
