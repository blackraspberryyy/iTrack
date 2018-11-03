<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiMinorViolation extends CI_Controller {
  public function make() {
    // post
    $params = api_params($this);
    $serial = $params['serial'];
    $violation_id = $params['violation_id'];
    $location = $params['location'];
    $message = $params['message'];
    $timestamp = $params['timestamp'];

    // build report
    $report = array(
      'violation_id' => $violation_id,
      'location' => $location,
      'message' => $message,
      'tapped_at' => $timestamp,
      'created_at' => time()
    );

    if ($this->Api_model->addMinorReport($serial, $report)) {
      // TODO: check 15 minor offenses to group them
      api_respond(TRUE);
    } else {
      api_respond(FALSE, 'Unable to add violation report.');
    }
  }
}
