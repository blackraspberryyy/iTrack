<?php

class AdminViolations extends CI_Controller {
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

  public function index(){
    redirect(base_url().'student_violations');
  }

  public function student_violations(){

  }

  public function student_profile(){
    $data = array(
      "title"             => "Student Profile",   //Do not edit this title
      'currentadmin'      => $this->AdminDashboard_model->getAdmin(array("admin_id" => $this->session->userdata("userid")))[0],
      'users'             => $this->AdminViolations_model->getUsers(array("user_isActive" => 1, "user_access" => "student")),
      'incident_reports'  => $this->AdminIncidentReport_model->getIncidentReport(),
      'cms'               => $this->AdminCMS_model->getCMS()[0]
    );
  
    $this->load->view("admin_includes/nav_header", $data);
    $this->load->view("admin_violations/user_profile");
    $this->load->view("admin_includes/footer");
  }

  public function search_user() {
    $user_access = strtolower(str_replace('%20Profile', '', $this->uri->segment(3)));
    
    $word = $this->input->post("search_word");
    $matched_users = $this->AdminViolations_model->searchUsers($word, array("user_access" => $user_access));
    if ($word == "") {
      $all_users = $this->AdminViolations_model->getUsers();
      $data = array(
        "success" => 1,
        "result" => "",
        "users" => $all_users
      );
    } else {
      if (empty($matched_users)) {
        $data = array(
          "success" => 2,
          "result" => "No Matches Found",
          "users" => $matched_users
        );
      } else {
        $data = array(
          "success" => 3,
          "result" => count($matched_users) . " results found",
          "users" => $matched_users
        );
      }
    }
    echo json_encode($data);
  }

  public function teacher_profile(){
    $data = array(
      "title"             => "Teacher Profile",   //Do not edit this title
      'currentadmin'      => $this->AdminDashboard_model->getAdmin(array("admin_id" => $this->session->userdata("userid")))[0],
      'users'             => $this->AdminViolations_model->getUsers(array("user_isActive" => 1, "user_access" => "teacher")),
      'incident_reports'  => $this->AdminIncidentReport_model->getIncidentReport(),
      'cms'               => $this->AdminCMS_model->getCMS()[0]
    );
  
    $this->load->view("admin_includes/nav_header", $data);
    $this->load->view("admin_violations/user_profile");
    $this->load->view("admin_includes/footer");
  }

}