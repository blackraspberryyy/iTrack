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
}
