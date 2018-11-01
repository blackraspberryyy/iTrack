<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiViolation extends CI_Controller {
  public function index() {
    $type = $this->uri->segment(3);
    // post
    if ($violations = $this->Api_model->getViolationsList($type)) {
      api_respond(TRUE, array(
        'msg' => 'Violations found.',
        'violations' => $violations
      ));
    } else {
      api_respond(FALSE, 'No list of violations found.');
    }
  }
}
