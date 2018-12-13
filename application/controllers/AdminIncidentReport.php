<?php

class AdminIncidentReport extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->has_userdata('isloggedin') == FALSE) {
            //user is not yet logged in
            $this->session->set_flashdata("err_login", "Login First!");
            redirect(base_url() . 'AdminLogin/');
        } else {
            if ($this->session->userdata("useraccess") == "student" || $this->session->userdata("useraccess") == "teacher") {
                $this->session->set_flashdata("err_login", "Restricted Subpage");
                redirect(base_url() . 'UserDashboard/');
            } else if ($this->session->userdata("useraccess") == "admin") {
                //Do nothing
            }
        }
    }

    public function index() {
        $data = array(
            "title" => "Incident Report",
            'currentadmin' => $this->AdminDashboard_model->getAdmin(array("admin_id" => $this->session->userdata("userid")))[0],
            'major_violations' => $this->AdminIncidentReport_model->getMajorViolations(),
            'minor_violations' => $this->AdminIncidentReport_model->getMinorViolations(),
            'incident_reports' => $this->AdminIncidentReport_model->getIncidentReport(array('ir.incident_report_isAccepted' => 1)),
            'request_reports' => $this->AdminIncidentReport_model->getIncidentReport(array('ir.incident_report_isAccepted' => 0)),
            'effects' => $this->AdminIncidentReport_model->getEffects(),
            'cms' => $this->AdminCMS_model->getCMS()[0]
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

        if ($this->input->post("user_course") == "student") {
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
                "title" => "Incident Report",
                'currentadmin' => $this->AdminDashboard_model->getAdmin(array("admin_id" => $this->session->userdata("userid")))[0],
                'major_violations' => $this->AdminIncidentReport_model->getMajorViolations(),
                'minor_violations' => $this->AdminIncidentReport_model->getMinorViolations(),
                'incident_reports' => $this->AdminIncidentReport_model->getIncidentReport(array('ir.incident_report_isAccepted' => 1)),
                'request_reports' => $this->AdminIncidentReport_model->getIncidentReport(array('ir.incident_report_isAccepted' => 0)),
                'effects' => $this->AdminIncidentReport_model->getEffects(),            
                'cms' => $this->AdminCMS_model->getCMS()[0]
            );

            $this->load->view("admin_includes/nav_header", $data);
            $this->load->view("admin_incident_report/main");
            $this->load->view("admin_includes/footer");
        } else {
            $currentAdmin = $this->AdminIncidentReport_model->getAdmin(array("admin_id" => $this->session->userdata("userid")))[0];
            if ($this->input->post("classification") == "0") {
                $violation = array(
                    "violation_name" => $this->input->post("classification_other"),
                    "violation_type" => $this->input->post("nature"),
                    "violation_category" => "other",
                    "violation_added_at" => time()
                );
                $this->AdminIncidentReport_model->insert_violation($violation);
                $violation_id = $this->db->insert_id();
            } else {
                $violation_id = $this->input->post("classification");
            }

            $user = $this->AdminIncidentReport_model->get_user_id($this->input->post("user_number"))[0];

            $incident_report = array(
                "user_reported_by" => NULL, //NULL if the ADMIN is the one to report
                "user_id" => $user->user_id,
                "violation_id" => $violation_id,
                "effects_id" =>  $this->input->post("effect"),
                "incident_report_datetime" => strtotime($this->input->post("date_time")),
                "incident_report_place" => $this->input->post("place"),
                "incident_report_age" => $this->input->post("user_age"),
                "incident_report_section_year" => $this->input->post("user_section_year"),
                "incident_report_message" => $this->input->post ("message"),
                "incident_report_isAccepted" => 1,
                "incident_report_added_at" => time()
            );
            $this->AdminIncidentReport_model->insert_incident_report($incident_report);
            $this->session->set_flashdata("success_incident_report", "Incident Report successfully recorded.");

            //Firabase
            $violation_details = $this->AdminIncidentReport_model->getViolations($violation_id)[0];
            $this->Notification_model->send($user->user_id, "You have been reported.", "Your violation is " + $violation_details->violation_name + ".");

            //-- AUDIT TRAIL
            $this->Logger->saveToAudit("admin", "Filed an incident report");

            //-- CallSlip
            $this->sendCallSlip($user, "iTrack Call Slip", "Please See the Discipline Officer for some important matter");

            redirect(base_url() . "AdminIncidentReport");
        }
    }

    public function sendCallSlip_exec() {
        $userId = $this->uri->segment(3);
        $incidentReportId = $this->uri->segment(4);
        $user = $this->AdminIncidentReport_model->get_user_id($userId)[0];
        $data = array(
            'effects_id' => $this->input->post('effect'),
            'incident_report_isAccepted' => 1,
        );

        //Firabase
        $incidentReport = $this->AdminIncidentReport_model->getIncidentReport($incidentReportId)[0];
        $this->Notification_model->send($user->user_id, "You have been reported.", "Your violation is " + $incidentReport->violation_name + ".");

        //-- AUDIT TRAIL
        $this->Logger->saveToAudit("admin", "Filed an incident report");

        //-- CallSlip
        $this->sendCallSlip($user, "iTrack Call Slip", "Please See the Discipline Officer for some important matter");
        if ($this->AdminIncidentReport_model->edit_incident_report($data, $incidentReportId)) {
            redirect(base_url() . "AdminIncidentReport");
        }
    }

    public function sendCallSlip($user, $subject, $message) {
        $this->email->from("itracksolutions.123@gmail.com", 'iTrack Administrator');
        $this->email->to($user->user_email);
        $this->email->subject($subject);
        $data = array(
            "message" => $message,
            "username" => $user->user_firstname . " " . $user->user_lastname,
            "datetime" => time()
        );

        $this->email->message($this->load->view('admin_email/email_callslip', $data, true));

        if (!$this->email->send()) {
            echo $this->email->print_debugger();
        } else {
            $this->session->set_flashdata('success_email', "Call Slip has been sent to " . $user->user_email);
            //redirect(base_url().'AdminEmail');
        }
    }

    /* function sample(){
      $data = array(
      "message"   => "Please See the Discipline Officer for some important matter",
      "username"  => "Juan Dela Cruz",
      "datetime"  => 1541521453
      );
      $this->load->view('admin_email/email_callslip', $data);
      } */

    function edit_exec() {
        $this->session->set_userdata("incident_report_id", $this->uri->segment(3));
        redirect(base_url() . 'AdminIncidentReport/edit');
    }

    function edit() {
        $data = array(
            "title" => "Edit Incident Report",
            'currentadmin' => $this->AdminDashboard_model->getAdmin(array("admin_id" => $this->session->userdata("userid")))[0],
            'incident_report' => $this->AdminIncidentReport_model->getIncidentReport(array('ir.incident_report_id' => $this->session->userdata('incident_report_id')))[0],
            'major_violations' => $this->AdminIncidentReport_model->getMajorViolations(),
            'minor_violations' => $this->AdminIncidentReport_model->getMinorViolations(),
            'effects' => $this->AdminIncidentReport_model->getEffects()
        );
        /* prettyPrint($data['incident_report']);
          exit; */
        $this->load->view("admin_includes/nav_header", $data);
        $this->load->view("admin_incident_report/edit");
        $this->load->view("admin_includes/footer");
    }

    function edit_submit_exec() {
        $incident_report_id = $this->uri->segment(3);
        if ($this->input->post("classification") == "0") {
            $this->form_validation->set_rules('classification_other', 'Name of Violation', 'required');
        }

        if ($this->input->post("user_course") == "student") {
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
            $data = array(
                "title" => "Edit Incident Report",
                'currentadmin' => $this->AdminDashboard_model->getAdmin(array("admin_id" => $this->session->userdata("userid")))[0],
                'incident_report' => $this->AdminIncidentReport_model->getIncidentReport(array('ir.incident_report_id' => $this->session->userdata('incident_report_id')))[0],
                'major_violations' => $this->AdminIncidentReport_model->getMajorViolations(),
                'minor_violations' => $this->AdminIncidentReport_model->getMinorViolations(),
                'effects' => $this->AdminIncidentReport_model->getEffects()
            );

            $this->load->view("admin_includes/nav_header", $data);
            $this->load->view("admin_incident_report/edit");
            $this->load->view("admin_includes/footer");
        } else {
            $currentAdmin = $this->AdminIncidentReport_model->getAdmin(array("admin_id" => $this->session->userdata("userid")))[0];
            if ($this->input->post("classification") == "0") {
                $violation = array(
                    "violation_name" => $this->input->post("classification_other"),
                    "violation_type" => $this->input->post("nature"),
                    "violation_category" => "other",
                    "violation_added_at" => time()
                );
                $this->AdminIncidentReport_model->insert_violation($violation);
                $violation_id = $this->db->insert_id();
            } else {
                $violation_id = $this->input->post("classification");
            }

            $incident_report = array(
                "user_reported_by" => NULL, //NULL if the ADMIN is the one to report
                "user_id" => $this->AdminIncidentReport_model->get_user_id($this->input->post("user_number"))[0]->user_id,
                "violation_id" => $violation_id,
                "effects_id" => $this->input->post("effect"), 
                "incident_report_datetime" => strtotime($this->input->post("date_time")),
                "incident_report_place" => $this->input->post("place"),
                "incident_report_age" => $this->input->post("user_age"),
                "incident_report_section_year" => $this->input->post("user_section_year"),
                "incident_report_message" => $this->input->post("message"),
                "incident_report_added_at" => time()
            );
            $this->AdminIncidentReport_model->edit_incident_report($incident_report, $incident_report_id);
            $this->session->set_flashdata("success_incident_report", "Incident Report successfully recorded.");

            //-- AUDIT TRAIL
            $this->Logger->saveToAudit("admin", "Filed an incident report");

            redirect(base_url() . "AdminIncidentReport");
        }
    }

}
