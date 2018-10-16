<?php
class AdminEmail extends CI_Controller{
  function __construct() {
    parent::__construct();
    if ($this->session->has_userdata('isloggedin') == FALSE) {
    //user is not yet logged in
      $this->session->set_flashdata("err_login", "Login First!");
      redirect(base_url() . 'adminlogin/');
    } else {
      if($this->session->userdata("useraccess") == "student" || $this->session->userdata("useraccess") == "teacher"){
        $this->session->set_flashdata("err_login", "Restricted Subpage");
        redirect(base_url() . 'userdashboard/');
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
      'attendance'        => $this->AdminDussap_model->getAttendance(array('att.incident_report_id' => $this->session->userdata('incident_report_id'))),
      'total_hours'       => $this->AdminDussap_model->getAttendanceTotalHours(array('incident_report_id' => $this->session->userdata('incident_report_id')))[0]
    );
    $this->load->view("admin_includes/nav_header", $data);
    $this->load->view("admin_email/main");
    $this->load->view("admin_includes/footer");
  }
}