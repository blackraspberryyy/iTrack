<?php
class AdminEmail extends CI_Controller{
  function __construct() {
    parent::__construct();
    if ($this->session->has_userdata('isloggedin') == FALSE) {
    //user is not yet logged in
      $this->session->set_flashdata("err_login", "Login First!");
      redirect(base_url() . 'AdminLogin/');
    } else {
      if($this->session->userdata("useraccess") == "student" || $this->session->userdata("useraccess") == "teacher"){
        $this->session->set_flashdata("err_login", "Restricted Subpage");
        redirect(base_url() . 'UserDashboard/');
      }else if($this->session->userdata("useraccess") == "admin"){
        //Do nothing
      }
    }
  }
  function index(){
    $data = array(
      'title'             => "Email",
      'currentadmin'      => $this->AdminDashboard_model->getAdmin(array("admin_id" => $this->session->userdata("userid")))[0],
      'cms'               => $this->AdminCMS_model->getCMS()[0],
      'incident_report'   => $this->AdminIncidentReport_model->getIncidentReport(array('ir.incident_report_id' => $this->session->userdata('incident_report_id')))[0],
      'attendance'        => $this->AdminDusap_model->getAttendance(array('att.incident_report_id' => $this->session->userdata('incident_report_id'))),
      'total_hours'       => $this->AdminDusap_model->getAttendanceTotalHours(array('incident_report_id' => $this->session->userdata('incident_report_id')))[0]
    );
    $this->load->view("admin_includes/nav_header", $data);
    $this->load->view("admin_email/main");
    $this->load->view("admin_includes/footer");
  }

  public function sendemail($email, $subject, $message) {
    $this->email->from("itracksolutions.123@gmail.com", 'iTrack Administrator');
    $this->email->to($email);
    $this->email->subject($subject);
    /* 
      $data = array('name' => $user['user_firstname'], 'code' => $user['user_verification_code']); 
      $this->email->message($this->load->view('register/verifyMessage', $data, true));
    */
    $data = array(
      "message" => $message
    );

    $this->email->message($this->load->view('admin_email/email_message', $data, true));

    if (!$this->email->send()) {
      echo $this->email->print_debugger();
    } else {
      $this->session->set_flashdata('success_email', "Email has been sent to ".$email );
      redirect(base_url().'AdminEmail');
    }
  }
  
  function send_email_exec(){
    $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
    $this->form_validation->set_rules('subject', 'Subject', 'required');
    $this->form_validation->set_rules('message', 'Message', 'required');
    if ($this->form_validation->run() == FALSE) {
      $data = array(
        'title'             => "Email",
        'currentadmin'      => $this->AdminDashboard_model->getAdmin(array("admin_id" => $this->session->userdata("userid")))[0],
        'cms'               => $this->AdminCMS_model->getCMS()[0],
        'incident_report'   => $this->AdminIncidentReport_model->getIncidentReport(array('ir.incident_report_id' => $this->session->userdata('incident_report_id')))[0],
        'attendance'        => $this->AdminDusap_model->getAttendance(array('att.incident_report_id' => $this->session->userdata('incident_report_id'))),
        'total_hours'       => $this->AdminDusap_model->getAttendanceTotalHours(array('incident_report_id' => $this->session->userdata('incident_report_id')))[0]
      );
      $this->load->view("admin_includes/nav_header", $data);
      $this->load->view("admin_email/main");
      $this->load->view("admin_includes/footer");

      $this->session->set_flashdata('error_email', "Please check the fields before submitting an email.");
    }else{
      $email = $this->input->post('email');
      $subject = $this->input->post('subject');
      $message = $this->input->post('message');
      $this->sendemail($email, $subject, $message);
    }
  }
}