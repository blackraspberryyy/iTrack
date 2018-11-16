<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiAttendance extends CI_Controller {
  public function hours() {
    // post
    $user_id = $this->uri->segment(3);

    // data should return user_id back
    // and should only return 1 row
    if (
      $user_id &&
      ($total_hours = $this->Api_model->getTotalHours($user_id)) &&
      $total_hours[0]['user_id']
    ) {
      api_respond(TRUE, array(
        'msg' => 'Attendance found.',
        'attendance' => $total_hours[0]
      ));
    } else {
      api_respond(TRUE, 'No attendance.');
    }
  }

  // public function add() {
  //   $v = $this->uri->segment(3);
  //   $this->db->set('attendance_hours_rendered', "attendance_hours_rendered + $v", FALSE);
  //   $this->db->update('attendance');
  // }
}
