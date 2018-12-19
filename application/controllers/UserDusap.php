<?php

class UserDusap extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->has_userdata('isloggedin') == FALSE) {
            //user is not yet logged in
            $this->session->set_flashdata("err_login", "Login First!");
            redirect(base_url() . 'Login/');
        } else {
            if ($this->session->userdata("useraccess") == "student" || $this->session->userdata("useraccess") == "teacher") {
                //Do Nothing
            } else if ($this->session->userdata("useraccess") == "admin") {
                $this->session->set_flashdata("err_login", "Restricted Subpage");
                redirect(base_url() . 'UserDashboard/');
            }
        }
    }

    public function get_month($month) {
        if ($month == 1) {
            return "January";
        } else if ($month == 2) {
            return "February";
        } else if ($month == 3) {
            return "March";
        } else if ($month == 4) {
            return "April";
        } else if ($month == 5) {
            return "May";
        } else if ($month == 6) {
            return "June";
        } else if ($month == 7) {
            return "July";
        } else if ($month == 8) {
            return "August";
        } else if ($month == 9) {
            return "September";
        } else if ($month == 10) {
            return "October";
        } else if ($month == 11) {
            return "November";
        } else if ($month == 12) {
            return "December";
        }
    }

    public function index() {
        $incidentReport = $this->UserIncidentReport_model->getIncidentReport(array('u.user_id' => $this->session->userdata("userid"), 'incident_report_status' => 1))[0];
        $attendance = $this->UserDusap_model->getAttendance(array('att.incident_report_id' => $incidentReport->incident_report_id, 'incident_report_status' => 1));
        $currentMonthAttendances = $this->UserDusap_model->getAttendance(array('att.incident_report_id' => $incidentReport->incident_report_id, 'MONTH(from_unixtime(attendance_starttime))' => date('m')));
        $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        $currentMonth = date('m');
        $where = array(
            "user_id" => $this->session->userdata("userid")
        );
        $data = array(
            "title" => "Home",
            'currentuser' => $this->UserDashboard_model->getUser($where)[0],
            'cms' => $this->AdminCMS_model->getCMS()[0],
            'currentMonthAttendances' => $currentMonthAttendances,
            'currentMonth' => $this->get_month($currentMonth),
            'overall_violation_hours'   => $this->AdminIncidentReport_model->getOverallViolationHours($this->session->userdata("userid"))[0]->violation_hours ? $this->AdminIncidentReport_model->getOverallViolationHours($this->session->userdata("userid"))[0]->violation_hours : 0,
            'overall_rendered_hours'    => $this->AdminIncidentReport_model->getOverallRenderedHours($this->session->userdata("userid"))[0]->rendered_hours ? $this->AdminIncidentReport_model->getOverallRenderedHours($this->session->userdata("userid"))[0]->rendered_hours : 0,
            'incident_report' => $incidentReport,
            'months' => $months,
            'attendance' => $attendance,
            'total_hours' => $this->AdminDusap_model->getAttendanceTotalHours(array('incident_report_id' => $incidentReport->incident_report_id))[0]
        );
        $this->load->view("user_includes/nav_header", $data);
        $this->load->view("user_dusap/main");
        $this->load->view("user_includes/footer");
    }

    public function change_month_exec() {
        $monthSelected = $this->input->post("month");
//        echo $monthSelected;
        $incidentReport = $this->UserIncidentReport_model->getIncidentReport(array('u.user_id' => $this->session->userdata("userid"), 'incident_report_status' => 1))[0];
        $attendance = $this->UserDusap_model->getAttendance(array('att.incident_report_id' => $incidentReport->incident_report_id, 'incident_report_status' => 1));
        $currentMonthAttendances = $this->UserDusap_model->getAttendance(array('att.incident_report_id' => $incidentReport->incident_report_id, 'MONTH(from_unixtime(attendance_starttime))' => $monthSelected));
        $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        $where = array(
            "user_id" => $this->session->userdata("userid")
        );
        $data = array(
            "title" => "Home",
            'currentuser' => $this->UserDashboard_model->getUser($where)[0],
            'cms' => $this->AdminCMS_model->getCMS()[0],
            'months' => $months,
            'currentMonthAttendances' => $currentMonthAttendances,
            'currentMonth' => $this->get_month($monthSelected),
            'overall_violation_hours'   => $this->AdminIncidentReport_model->getOverallViolationHours($this->session->userdata("userid"))[0]->violation_hours ? $this->AdminIncidentReport_model->getOverallViolationHours($this->session->userdata("userid"))[0]->violation_hours : 0,
            'overall_rendered_hours'    => $this->AdminIncidentReport_model->getOverallRenderedHours($this->session->userdata("userid"))[0]->rendered_hours ? $this->AdminIncidentReport_model->getOverallRenderedHours($this->session->userdata("userid"))[0]->rendered_hours : 0,
            'incident_report' => $incidentReport,
            'attendance' => $attendance,
            'total_hours' => $this->AdminDusap_model->getAttendanceTotalHours(array('incident_report_id' => $incidentReport->incident_report_id))[0]
        );
        $this->load->view("user_includes/nav_header", $data);
        $this->load->view("user_dusap/main");
        $this->load->view("user_includes/footer");
    }

}
