<?php

class AdminOffenseReport extends CI_Controller {
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
    redirect(base_url().'adminincidentreport');
  }
  function view_exec(){
    $this->session->set_userdata("incident_report_id", $this->uri->segment(3));
    redirect(base_url().'adminoffensereport/view');
  }
  function view(){
    $incident_report_id = $this->session->userdata("incident_report_id");
    echo "Under Construction";
  }
}
