<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiNotifications extends CI_Controller {
  public function user() {
    // get
    // $user_id is required
    $user_id = $this->uri->segment(3);

    if ($user_id && $notifications = $this->Notification_model->getAll($user_id)) {
      api_respond(TRUE, array(
        'msg' => 'Notifications found.',
        'notifications' => $notifications
      ));
    } else {
      api_respond(FALSE, 'No notifications found.');
    }
  }
}
