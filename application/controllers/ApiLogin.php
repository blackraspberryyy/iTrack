<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiLogin extends CI_Controller {
	public function index() {
    // post
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');
    $this->form_validation->set_rules('access', 'Access', 'required');
    
    if ($this->form_validation->run()) {
      $username = $this->input->post('username');
      $password = $this->input->post('password');
      $access = $this->input->post('access');
      
      if ($user = $this->Login_Model->checkUserCredentials($username, $password, $access)) {
        api_respond(TRUE, array(
          'msg' => 'User found',
          'user' => $user[0]
        ));
      } else {
        api_respond(FALSE, 'Incorrect username or password.');
      }
    } else {
      api_respond(FALSE, 'Username and password are required.');
    }
	}
}
