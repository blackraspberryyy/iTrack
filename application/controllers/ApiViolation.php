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

  public function make() {
    // post
    $params = api_params($this);
    $serial = $params['serial'];
    $reporter_id = $params['reporter_id'];
    $violation_id = $params['violation_id'];
    $location = $params['location'];
    $message = $params['message'];
    $timestamp = $params['timestamp'];

    // get type of violation first
    $type = '';
    if ($types = $this->Api_model->getTypeOfViolation($violation_id)) {
      $type = $types[0]['violation_type'];
    }

    if ($type == 'minor') {
      // build report
      $report = array(
        'reporter_id' => $reporter_id,
        'violation_id' => $violation_id,
        'location' => $location,
        'message' => $message,
        'tapped_at' => $timestamp,
        'created_at' => time()
      );

      if ($this->Api_model->addMinorReport($serial, $report)) {
        // check 15 minor offenses to group them
        $this->Api_model->groupViolations();
        api_respond(TRUE, 'Minor report added.');
      }
    } else if ($type == 'major') {
      // some params for major :D
      $age = $params['age'];
      $year_section = $params['year_section'];

      // build report
      $report = array(
        'user_reported_by' => $reporter_id,
        'violation_id' => $violation_id,
        'effects_id' => 1,
        'incident_report_datetime' => $timestamp,
        'incident_report_place' => $location,
        'incident_report_age' => $age,
        'incident_report_section_year' => $year_section,
        'incident_report_message' => $message,
        'incident_report_status' => 1,
        'incident_report_isAccepted' => 0,
        'incident_report_added_at' => time()
      );

      if ($this->Api_model->addIncidentReport($serial, $report)) {
        api_respond(TRUE, 'Incident report added.');
      }
    }

    api_respond(FALSE, 'Unable to add violation report.');
  }

  public function batch() {
    $params = api_params($this);
    $reports = $params['reports'];

    if ($res = $this->Api_model->addReports($reports)) {
      // check 15 minor offenses to group them
      $this->Api_model->groupViolations();
      api_respond(TRUE, 'Minor report batch added.');
    } else {
      api_respond(FALSE, 'Unable to add batch violation reports.');
    }
  }

  /* 
  public function test() {
    echo strtotime('today') . "\n";
    echo strtotime('tomorrow +2 day') . "\n";
    echo time() . "\n";
    $this->Api_model->groupViolations(15);
  }

  public function test2() {
    $res = $this->Api_model->getGroupedUidVidPair(1);
    prettyPrint($res);
  }

  public function reset() {
    $this->db->update('minor_reports', array(
      'group_id' => 0,
      'grouped_at' => 0
    ));
    $this->db->truncate('minor_reports_quota');
  }
  */
}
