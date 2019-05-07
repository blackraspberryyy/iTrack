<?php

class AdminMinorReports extends CI_Controller {

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

  public function index() {
    $where = array(
        "admin_id" => $this->session->userdata("userid")
    );
    
    $data = array(
        'title'         => "Minor Reports",
        'currentadmin'  => $this->AdminDashboard_model->getAdmin($where)[0],
        'cms'           => $this->AdminCMS_model->getCMS()[0],
        'minor_reports' => $this->AdminMinorReports_model->getMinorReports(array('mr.user_id !=' => NULL)),
        'pending_reports' => $this->AdminMinorReports_model->getPendingReports()
    );
    
    /* prettyPrint($data['pending_reports']);
    exit; */
    
    $this->load->view("admin_includes/nav_header", $data);
    $this->load->view("admin_minor_reports/main");
    $this->load->view("admin_includes/footer");
  }

  public function setUser_exec(){
    $this->session->set_userdata('mr_id', $this->uri->segment(3));
    redirect(base_url().'AdminMinorReports/setUser');
  }

  public function setUser(){
    $minor_report_id = $this->session->userdata('mr_id');
    $where = array(
      "admin_id" => $this->session->userdata("userid")
    );
    
    $data = array(
        'title'         => "Set User",
        'currentadmin'  => $this->AdminDashboard_model->getAdmin($where)[0],
        'cms'           => $this->AdminCMS_model->getCMS()[0],
        'minor_report'  => $this->AdminMinorReports_model->getPendingReports(array('mr.id' => $minor_report_id))[0]
    );
    
    /* prettyPrint($data['minor_report']);
    exit; */
    
    $this->load->view("admin_includes/nav_header", $data);
    $this->load->view("admin_minor_reports/setUser");
    $this->load->view("admin_includes/footer");
  }

  public function setUser_submit(){
    $incident_id = $this->uri->segment(3);
    $this->form_validation->set_rules('user_number', 'User Number', 'required|integer');
    $this->form_validation->set_rules('user_lastname', 'Lastname', 'required');
    $this->form_validation->set_rules('user_firstname', 'Firstname', 'required');
    $this->form_validation->set_rules('user_access', 'Access', 'required');
    $this->form_validation->set_rules('user_course', 'Course', 'required');
    if ($this->form_validation->run() == false) {
      $minor_report_id = $this->session->userdata('mr_id');
      $where = array(
        "admin_id" => $this->session->userdata("userid")
      );
      
      $data = array(
          'title'         => "Set User",
          'currentadmin'  => $this->AdminDashboard_model->getAdmin($where)[0],
          'cms'           => $this->AdminCMS_model->getCMS()[0],
          'minor_report'  => $this->AdminMinorReports_model->getPendingReports(array('mr.id' => $minor_report_id))[0]
      );
      
      /* prettyPrint($data['minor_report']);
      exit; */
      
      $this->load->view("admin_includes/nav_header", $data);
      $this->load->view("admin_minor_reports/setUser");
      $this->load->view("admin_includes/footer");
    }else{
        $data = [
          "user_id"   => $this->input->post('user_id')
        ];
        $this->AdminMinorReports_model->edit_minor_report($data, $incident_id);

          //-- AUDIT TRAIL
        $this->Logger->saveToAudit('admin', 'Set user to pending minor report.');

        redirect(base_url().'AdminMinorReports');
    }
  }
  
}