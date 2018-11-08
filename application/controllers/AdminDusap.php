<?php
    class AdminDusap extends CI_Controller{
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
        function index(){
            $data = array(
                'title'         => "DUSAP",
                'currentadmin'  => $this->AdminDashboard_model->getAdmin(array("admin_id" => $this->session->userdata("userid")))[0],
                'cms'           => $this->AdminCMS_model->getCMS()[0]
            );
            redirect(base_url().'AdminIncidentReport');
        }
        function view_exec(){
            $this->session->set_userdata('incident_report_id', $this->uri->segment(3));
            redirect(base_url().'AdminDusap/view');
        }
        function view(){
            $data = array(
                'title'             => "DUSAP",
                'currentadmin'      => $this->AdminDashboard_model->getAdmin(array("admin_id" => $this->session->userdata("userid")))[0],
                'cms'               => $this->AdminCMS_model->getCMS()[0],
                'incident_report'   => $this->AdminIncidentReport_model->getIncidentReport(array('ir.incident_report_id' => $this->session->userdata('incident_report_id')))[0],
                'attendance'        => $this->AdminDusap_model->getAttendance(array('att.incident_report_id' => $this->session->userdata('incident_report_id'))),
                'total_hours'       => $this->AdminDusap_model->getAttendanceTotalHours(array('incident_report_id' => $this->session->userdata('incident_report_id')))[0]
            );
            $this->load->view("admin_includes/nav_header", $data);
            $this->load->view("admin_dusap/main");
            $this->load->view("admin_includes/footer");
        }
        
        public function valid_endtime($endtime){
            $starttime = strtotime($this->input->post('starttime'));
            $endtime = strtotime($this->input->post('endtime'));
            
            if ($starttime >= $endtime){
                $this->form_validation->set_message('valid_endtime', '{field} must be more recent than Start Date and Time');
                return FALSE;
            }
            else{
                return TRUE;
            }
        }

        function get_timestamp_diff_in_hours($unix1, $unix2){
            return floor((abs($unix1-$unix2))/360/10);
        }

        function edit_attendance_exec(){
            $attendance_id = $this->uri->segment(3);
            $this->form_validation->set_rules('starttime', 'Start Date and Time', 'required');
            $this->form_validation->set_rules('endtime', 'End Date and Time', 'required|callback_valid_endtime');
            $this->form_validation->set_rules('department', 'Department', 'required');
            $this->form_validation->set_rules('supervisor', 'Supervisor', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_userdata('error_modal', $this->input->post('modal_type'));
                $data = array(
                    'title'             => "DUSAP",
                    'currentadmin'      => $this->AdminDashboard_model->getAdmin(array("admin_id" => $this->session->userdata("userid")))[0],
                    'cms'               => $this->AdminCMS_model->getCMS()[0],
                    'incident_report'   => $this->AdminIncidentReport_model->getIncidentReport(array('ir.incident_report_id' => $this->session->userdata('incident_report_id')))[0],
                    'attendance'        => $this->AdminDusap_model->getAttendance(array('att.incident_report_id' => $this->session->userdata('incident_report_id'))),
                    'total_hours'       => $this->AdminDusap_model->getAttendanceTotalHours(array('incident_report_id' => $this->session->userdata('incident_report_id')))[0]
                );

                /* prettyPrint($this->input->post());
                echo '-----------'.'<br/>';
                echo strtotime($this->input->post('starttime')).'<br/>';
                echo strtotime($this->input->post('endtime'));
                exit; */

                $this->load->view("admin_includes/nav_header", $data);
                $this->load->view("admin_dusap/main");
                $this->load->view("admin_includes/footer");
            }else{
                $starttime = strtotime($this->input->post('starttime'));
                $endtime = strtotime($this->input->post('endtime'));

                $attendance = array(
                    'incident_report_id'        => $this->session->userdata('incident_report_id'),
                    'attendance_dept'           => $this->input->post('department'),
                    'attendance_supervisor'     => $this->input->post('supervisor'),
                    'attendance_hours_rendered' => $this->get_timestamp_diff_in_hours($starttime, $endtime),
                    'attendance_status'         => 1,
                    'attendance_starttime'      => $starttime,
                    'attendance_endtime'        => $endtime
                );

               /*  prettyPrint($attendance);
                exit; */
                $this->AdminIncidentReport_model->edit_attendance($attendance, $attendance_id);
                $this->session->set_flashdata("success_incident_report", "Incident Report successfully recorded.");

                //-- AUDIT TRAIL
                $this->Logger->saveToAudit("admin", "Edited attendance in DUSAP");
                redirect(base_url().'AdminDusap/view');
            }
        }

        function add_attendance_exec(){
            $this->form_validation->set_rules('starttime', 'Start Date and Time', 'required');
            $this->form_validation->set_rules('endtime', 'End Date and Time', 'required|callback_valid_endtime');
            $this->form_validation->set_rules('department', 'Department', 'required');
            $this->form_validation->set_rules('supervisor', 'Supervisor', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_userdata('error_modal', $this->input->post('modal_type'));
                $data = array(
                    'title'             => "DUSAP",
                    'currentadmin'      => $this->AdminDashboard_model->getAdmin(array("admin_id" => $this->session->userdata("userid")))[0],
                    'cms'               => $this->AdminCMS_model->getCMS()[0],
                    'incident_report'   => $this->AdminIncidentReport_model->getIncidentReport(array('ir.incident_report_id' => $this->session->userdata('incident_report_id')))[0],
                    'attendance'        => $this->AdminDusap_model->getAttendance(array('att.incident_report_id' => $this->session->userdata('incident_report_id'))),
                    'total_hours'       => $this->AdminDusap_model->getAttendanceTotalHours(array('incident_report_id' => $this->session->userdata('incident_report_id')))[0]
                );

                /* prettyPrint($this->input->post());
                echo '-----------'.'<br/>';
                echo strtotime($this->input->post('starttime')).'<br/>';
                echo strtotime($this->input->post('endtime'));
                exit; */

                $this->load->view("admin_includes/nav_header", $data);
                $this->load->view("admin_dusap/main");
                $this->load->view("admin_includes/footer");
            }else{
                $starttime = strtotime($this->input->post('starttime'));
                $endtime = strtotime($this->input->post('endtime'));

                $attendance = array(
                    'incident_report_id'        => $this->session->userdata('incident_report_id'),
                    'attendance_dept'           => $this->input->post('department'),
                    'attendance_supervisor'     => $this->input->post('supervisor'),
                    'attendance_hours_rendered' => $this->get_timestamp_diff_in_hours($starttime, $endtime),
                    'attendance_status'         => 1,
                    'attendance_starttime'      => $starttime,
                    'attendance_endtime'        => $endtime,
                    'attendance_created_at'     => time()
                );

               /*  prettyPrint($attendance);
                exit; */
                $this->AdminIncidentReport_model->add_attendance($attendance);
                $this->session->set_flashdata("success_incident_report", "Attendance successfully recorded.");

                //-- AUDIT TRAIL
                $this->Logger->saveToAudit("admin", "Add attendance in DUSAP");
                redirect(base_url().'AdminDusap/view');
            }
        }
        
        function finish_attendance_exec(){
            $incident_report_id = $this->session->userdata('incident_report_id');
            $hours_rendered = $this->input->post('hours_rendered');
            $violation_hours = $this->input->post('violation_hours');
            if($hours_rendered >= $violation_hours){
                // do not add attendance
            }else{
                // add attendance
                $attendance = array(
                    'incident_report_id'        => $incident_report_id,
                    'attendance_dept'           => '-',
                    'attendance_supervisor'     => '-',
                    'attendance_hours_rendered' => $violation_hours - $hours_rendered,
                    'attendance_status'         => 1,
                    'attendance_starttime'      => 0,
                    'attendance_endtime'        => 0,
                    'attendance_created_at'     => time()
                );

                $incident_report = array( 'incident_report_status' => 0);
            }
            $this->AdminIncidentReport_model->add_attendance($attendance);
            $this->AdminIncidentReport_model->edit_incident_report($incident_report, $incident_report_id);
            
            $this->session->set_flashdata("success_incident_report", "Finished attendance");

            //-- AUDIT TRAIL
            $this->Logger->saveToAudit("admin", "Finish attendance in DUSAP");
            redirect(base_url().'AdminDusap/view');
        }
        
    }