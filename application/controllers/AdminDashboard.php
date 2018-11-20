<?php

class AdminDashboard extends CI_Controller {

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
            'title'             => "Home",
            'currentadmin'      => $this->AdminDashboard_model->getAdmin($where)[0],
            'cms'               => $this->AdminCMS_model->getCMS()[0],
            'users'             => $this->AdminDashboard_model->getUsers(),
            'students_count'    => count($this->AdminDashboard_model->getUsers(array("user_access" => "student"))),
            'teacher_count'    => count($this->AdminDashboard_model->getUsers(array("user_access" => "teacher"))),
            'ongoing_incident_reports_count' => count($this->AdminDashboard_model->getIncidentReports(array("incident_report_status" => 0))),
            'finished_incident_reports_count' => count($this->AdminDashboard_model->getIncidentReports(array("incident_report_status" => 1)))

        );
        $this->load->view("admin_includes/nav_header", $data);
        $this->load->view("admin_dashboard/main");
        $this->load->view("admin_includes/footer");
    }
    
    public function pdfsample(){
        $legal_paper_size = array(215.9,355.6);
        $samplePDF = new Pdf("P", "mm", $legal_paper_size, true, 'UTF-8', false);
        $samplePDF->setTitle("Sample Title");
        $samplePDF->SetMargins(PDF_MARGIN_LEFT, 12, PDF_MARGIN_RIGHT, true);
        $samplePDF->SetAutoPageBreak(TRUE, 20);

        $samplePDF->AddPage('P', $legal_paper_size);
        
        $samplePDF->writeHTML("<h1>HEHE</h1>");
        $samplePDF->Output('Sample File output');
        exit;
    }
}
