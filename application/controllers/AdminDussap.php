<?php
    class AdminDussap extends CI_Controller{
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
            $data = array(
                'title'         => "DUSAP",
                'currentadmin'  => $this->AdminDashboard_model->getAdmin(array("admin_id" => $this->session->userdata("userid")))[0],
                'cms'           => $this->AdminCMS_model->getCMS()[0]
            );
            redirect(base_url().'adminincidentreport');
        }
        function view_exec(){
            $this->session->set_userdata('incident_report_id', $this->uri->segment(3));
            redirect(base_url().'admindussap/view');
        }
        function view(){
            $data = array(
                'title'             => "DUSAP",
                'currentadmin'      => $this->AdminDashboard_model->getAdmin(array("admin_id" => $this->session->userdata("userid")))[0],
                'cms'               => $this->AdminCMS_model->getCMS()[0],
                'incident_report'   => $this->AdminIncidentReport_model->getIncidentReport(array('ir.incident_report_id' => $this->session->userdata('incident_report_id')))[0],
                'attendance'        => $this->AdminDussap_model->getAttendance(array('att.incident_report_id' => $this->session->userdata('incident_report_id'))),
                'total_hours'       => $this->AdminDussap_model->getAttendanceTotalHours(array('incident_report_id' => $this->session->userdata('incident_report_id')))[0]
            );
            $this->load->view("admin_includes/nav_header", $data);
            $this->load->view("admin_dussap/main");
            $this->load->view("admin_includes/footer");
        }
        
        public function valid_endtime($endtime){
            $starttime = $this->input->post('starttime');
            $endtime = $this->input->post('endtime');
            
            if ($starttime > $endtime){
                $this->form_validation->set_message('valid_endtime', '{field} must be more recent than Start Date and Time');
                return FALSE;
            }
            else{
                return TRUE;
            }
        }

        function edit_attendance_exec(){
            $this->form_validation->set_rules('starttime', 'Start Date and Time', 'required');
            $this->form_validation->set_rules('endtime', 'End Date and Time', 'required|callback_valid_endtime');
            $this->form_validation->set_rules('department', 'Department', 'required');
            $this->form_validation->set_rules('supervisor', 'Supervisor', 'required');
            if ($this->form_validation->run() == FALSE) {
                $data = array(
                    'title'             => "DUSAP",
                    'currentadmin'      => $this->AdminDashboard_model->getAdmin(array("admin_id" => $this->session->userdata("userid")))[0],
                    'cms'               => $this->AdminCMS_model->getCMS()[0],
                    'incident_report'   => $this->AdminIncidentReport_model->getIncidentReport(array('ir.incident_report_id' => $this->session->userdata('incident_report_id')))[0],
                    'attendance'        => $this->AdminDussap_model->getAttendance(array('att.incident_report_id' => $this->session->userdata('incident_report_id'))),
                    'total_hours'       => $this->AdminDussap_model->getAttendanceTotalHours(array('incident_report_id' => $this->session->userdata('incident_report_id')))[0]
                );
                $this->load->view("admin_includes/nav_header", $data);
                $this->load->view("admin_dussap/main");
                $this->load->view("admin_includes/footer");
            }else{
                $attendance = array(
                    'attendance_starttime'  => strtotime($this->input->post('starttime')),
                    'attendance_endtime'    => strtotime($this->input->post('endtime')),
                    'attendance_department' => $this->input->post('department'),
                    'attendance_supervisor' => $this->input->post('supervisor')
                );
                prettyPrint($attendance);
                exit;
            }
            /* $this->session->set_userdata('attendance_id', $this->uri->segment(3));
            redirect(base_url().'admindussap/edit_attendance'); */
        }
        
    }