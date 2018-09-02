<?php

class AdminCms extends CI_Controller {

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
    
    public function index() {
        $where = array(
            "admin_id" => $this->session->userdata("userid")
        );
        
        $data = array(
            'title'         => "CMS",
            'currentadmin'  => $this->AdminDashboard_model->getAdmin($where)[0],
            'cms'           => $this->AdminCMS_model->getCMS()[0]
        );
        $this->load->view("admin_includes/nav_header", $data);
        $this->load->view("admin_cms/main");
        $this->load->view("admin_includes/footer");
    }
    public function edit_cms_exec(){
        $this->form_validation->set_rules('incident_report_title', 'Incident Report Title', 'required');
        $this->form_validation->set_rules('google_drive_title', 'Google Drive Title', 'required');
        $this->form_validation->set_rules('dussap_title', 'DUSSAP Title', 'required');
        $this->form_validation->set_rules('sms_title', 'SMS Title', 'required');
        $this->form_validation->set_rules('cms_title', 'CMS Title', 'required');
        $this->form_validation->set_rules('audit_trail_title', 'Audit Trail Title', 'required');
        $this->form_validation->set_rules('user_logs_title', 'User Logs Title', 'required');
        $this->form_validation->set_rules('student_handbook_title', 'Student Handbook Title', 'required');
        $this->form_validation->set_rules('monthly_report_title', 'Monthly Report Title', 'required');
        
        if($this->form_validation->run() == FALSE){
            //FORM ERROR
            $this->session->set_flashdata("form_errors", validation_errors('<li>','</li>'));
            redirect(base_url().'admincms/repeat_form');

        }else{
            //FORM SUCCESS
            $this->session->set_userdata("cms_id", $this->uri->segment(3));
            $this->session->set_flashdata("cms_post_data", $this->input->post());
            redirect(base_url().'admincms/edit_cms');
        }
    }

    public function repeat_form(){
        $where = array(
            "admin_id" => $this->session->userdata("userid")
        );
        
        $data = array(
            'title'         => "CMS",
            'currentadmin'  => $this->AdminDashboard_model->getAdmin($where)[0],
            'cms'           => $this->AdminCMS_model->getCMS()[0]
        );

        $this->session->set_flashdata("cms_error", $this->session->flashdata("form_errors"));
        $this->load->view("admin_includes/nav_header", $data);
        $this->load->view("admin_cms/main");
        $this->load->view("admin_includes/footer");
    }

    public function edit_cms(){
        $cms_id = $this->session->userdata("cms_id");
        $this->AdminCMS_model->editCMS($cms_id, $this->session->flashdata('cms_post_data'));
        
        //--AUDTI TRAIL
        $this->Logger->saveToAudit("admin", "Made changes to the CMS");

        redirect(base_url()."admincms/");
    }
}
