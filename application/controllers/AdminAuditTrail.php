<?php

class AdminAuditTrail extends CI_Controller {

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
        $data = array(
            'title'         => "Audit Trail",
            'currentadmin'  => $this->AdminDashboard_model->getAdmin(array("admin_id" => $this->session->userdata("userid")))[0],
            'cms'        => $this->AdminCMS_model->getCMS()[0],
            'audits'        => $this->AuditTrail_model->getAuditTrails()
        );
        $this->load->view("admin_includes/nav_header", $data);
        $this->load->view("admin_audit_trail/main");
        $this->load->view("admin_includes/footer");
    }
    
}
