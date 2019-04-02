<?php

use PhpOffice\PhpSpreadsheet\IOFactory;

class AdminImport extends CI_Controller {

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
            'title'         => "Import Student",
            'currentadmin'  => $this->AdminDashboard_model->getAdmin(array("admin_id" => $this->session->userdata("userid")))[0]
        );
        $this->load->view("admin_includes/nav_header", $data);
        $this->load->view("admin_import/main");
        $this->load->view("admin_includes/footer");
    }

    public function importExcel() {
        $inputFileName = base_url('uploads/user.xlsx');

        /** Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = IOFactory::load($inputFileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        
        var_dump($sheetData);
        exit;

        $student = array(
            
        );

        $this->AdminImport_model->add_student($student);
        $this->session->set_flashdata("success_incident_report", "Incident Report successfully recorded.");

      //-- AUDIT TRAIL
        $this->Logger->saveToAudit("admin", "Edited attendance in DUSAP");
        redirect(base_url().'AdminDusap/view');
    }
    
}
