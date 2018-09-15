<?php

class AdminIncidentReport extends CI_Controller {

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
        $data = array(
            "title"             => "Incident Report",
            'currentadmin'      => $this->AdminDashboard_model->getAdmin(array("admin_id" => $this->session->userdata("userid")))[0],
            'major_violations'  => $this->AdminIncidentReport_model->getMajorViolations(),
            'minor_violations'  => $this->AdminIncidentReport_model->getMinorViolations(),
            'incident_reports'  => $this->AdminIncidentReport_model->getIncidentReport(),
            'cms'               => $this->AdminCMS_model->getCMS()[0]
        );
        
        $this->load->view("admin_includes/nav_header", $data);
        $this->load->view("admin_incident_report/main");
        $this->load->view("admin_includes/footer");
    }


    public function search_user_number() {
        $keyword = strval($this->input->post('id'));

        $query = $this->db->query("SELECT * FROM user WHERE user_number LIKE '%" . $keyword . "%'");
        $result = $query->result_array();
        $res = array();
        foreach ($result as $key => $arr) {
            $res[$key]['user_id'] = $arr['user_id'];
            $res[$key]['user_number'] = $arr['user_number'];
            $res[$key]['user_firstname'] = $arr['user_firstname'];
            $res[$key]['user_lastname'] = $arr['user_lastname'];
            $res[$key]['user_middlename'] = $arr['user_middlename'];
            $res[$key]['user_course'] = $arr['user_course'];
            $res[$key]['user_access'] = $arr['user_access'];
            $res[$key]['user_picture'] = $arr['user_picture'];
        }
        echo json_encode($res);
    }

    public function incident_report_exec() {
        if ($this->input->post("classification") == "0") {
            $this->form_validation->set_rules('classification_other', 'Name of Violation', 'required');
        }
        
        if ($this->input->post("user_course") == "student"){
            $this->form_validation->set_rules('user_course', 'Course', 'required');
            $this->form_validation->set_rules('user_section_year', 'Section/Year', 'required');
        }
        
        $this->form_validation->set_rules('date_time', 'Date and Time', 'required');
        $this->form_validation->set_rules('place', 'Place', 'required');
        $this->form_validation->set_rules('user_number', 'User Number', 'required|integer');
        $this->form_validation->set_rules('user_lastname', 'Lastname', 'required');
        $this->form_validation->set_rules('user_firstname', 'Firstname', 'required');
        $this->form_validation->set_rules('user_age', 'Age', 'required|max_length[3]|integer');
        $this->form_validation->set_rules('user_access', 'Access', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');

        if ($this->form_validation->run() == FALSE) {
            //ERROR
            $data = array(
                "title"             => "Incident Report",
                'currentadmin'      => $this->AdminDashboard_model->getAdmin(array("admin_id" => $this->session->userdata("userid")))[0],
                'major_violations'  => $this->AdminIncidentReport_model->getMajorViolations(),
                'minor_violations'  => $this->AdminIncidentReport_model->getMinorViolations(),
                'incident_reports'  => $this->AdminIncidentReport_model->getIncidentReport(),
                'cms'               => $this->AdminCMS_model->getCMS()[0]
            );

            $this->load->view("admin_includes/nav_header", $data);
            $this->load->view("admin_incident_report/main");
            $this->load->view("admin_includes/footer");
        } else {
            $currentAdmin = $this->AdminIncidentReport_model->getAdmin(array("admin_id" => $this->session->userdata("userid")))[0];
            if ($this->input->post("classification") == "0") {
                $violation = array(
                    "violation_name"    => $this->input->post("classification_other"),
                    "violation_type"    => $this->input->post("nature"),
                    "violation_category"=> "other",
                    "violation_added_at"=> time()
                );
                $this->AdminIncidentReport_model->insert_violation($violation);
                $violation_id = $this->db->insert_id();
            }else{
                $violation_id = $this->input->post("classification");
            }
            
            $incident_report = array(
                "user_reported_by" => NULL, //NULL if the ADMIN is the one to report
                "user_id" => $this->AdminIncidentReport_model->get_user_id($this->input->post("user_number"))[0]->user_id,
                "violation_id" => $violation_id,
                "incident_report_datetime" => strtotime($this->input->post("date_time")),
                "incident_report_place" => $this->input->post("place"),
                "incident_report_age" => $this->input->post("user_age"),
                "incident_report_section_year" => $this->input->post("user_section_year"),
                "incident_report_message" => $this->input->post("message"),
                "incident_report_added_at" => time()
            );
            $this->AdminIncidentReport_model->insert_incident_report($incident_report);
            $this->session->set_flashdata("success_incident_report", "Incident Report successfully recorded.");

            //-- AUDIT TRAIL
            $this->Logger->saveToAudit("admin", "Filed an incident report");

            redirect(base_url()."adminincidentreport");
        }
    }
}
