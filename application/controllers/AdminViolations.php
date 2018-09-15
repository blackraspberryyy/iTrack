<?php

class AdminViolations extends CI_Controller {
  function __construct() {
    parent::__construct();
    if ($this->session->has_userdata('isloggedin') == FALSE) {
      //user is not yet logged in
      $this->session->set_flashdata("err_login", "Login First!");
      redirect(base_url() . 'login/');
    } else {
      if($this->session->userdata("useraccess") == "student" || $this->session->userdata("useraccess") == "teacher"){
        $this->session->set_flashdata("err_login", "Restricted Subpage");
        redirect(base_url() . 'userdashboard/');
      }else if($this->session->userdata("useraccess") == "admin"){
        //Do nothing
      }
    }
  }

  public function index(){
    redirect(base_url().'student_violations');
  }

  public function student_violations(){

  }
  public function student_profile(){
    $data = array(
      "title"             => "Incident Report",
      'currentadmin'      => $this->AdminDashboard_model->getAdmin(array("admin_id" => $this->session->userdata("userid")))[0],
      'students'          => $this->AdminViolations_model->getStudents(array("user_isActive" => 1)),
      'incident_reports'  => $this->AdminIncidentReport_model->getIncidentReport(),
      'cms'               => $this->AdminCMS_model->getCMS()[0]
    );
  
    $this->load->view("admin_includes/nav_header", $data);
    $this->load->view("admin_violations/student_profile");
    $this->load->view("admin_includes/footer");
  }
}