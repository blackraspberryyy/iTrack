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
      "title"             => "Student Profile",
      'currentadmin'      => $this->AdminDashboard_model->getAdmin(array("admin_id" => $this->session->userdata("userid")))[0],
      'students'          => $this->AdminViolations_model->getStudents(array("user_isActive" => 1)),
      'incident_reports'  => $this->AdminIncidentReport_model->getIncidentReport(),
      'cms'               => $this->AdminCMS_model->getCMS()[0]
    );
  
    $this->load->view("admin_includes/nav_header", $data);
    $this->load->view("admin_violations/student_profile");
    $this->load->view("admin_includes/footer");
  }

  public function search_student() {
    $word = $this->input->post("search_word");
    $matched_students = $this->AdminViolations_model->searchStudents($word);
    if ($word == "") {
        $all_students = $this->AdminViolations_model->getStudents();
        $data = array(
            "success" => 1,
            "result" => "",
            "students" => $all_students
        );
    } else {
        if (empty($matched_students)) {
            $data = array(
                "success" => 2,
                "result" => "No Matches Found",
                "students" => $matched_students
            );
        } else {
            $data = array(
                "success" => 3,
                "result" => count($matched_students) . " results found",
                "students" => $matched_students
            );
        }
    }

    echo json_encode($data);
  }
}