<?php

class UserDashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->has_userdata('isloggedin') == false) {
            //user is not yet logged in
            $this->session->set_flashdata('err_login', 'Login First!');
            redirect(base_url().'Login/');
        } else {
            if ($this->session->userdata('useraccess') == 'student' || $this->session->userdata('useraccess') == 'teacher') {
                //Do Nothing
            } elseif ($this->session->userdata('useraccess') == 'admin') {
                $this->session->set_flashdata('err_login', 'Restricted Subpage');
                redirect(base_url().'UserDashboard/');
            }
        }
    }

    public function index()
    {
        $incidentReport = $this->UserIncidentReport_model->getIncidentReport(array('u.user_id' => $this->session->userdata('userid'), 'incident_report_status' => 1))[0];

        $where = array(
            'user_id' => $this->session->userdata('userid'),
        );
        $currentUser = $this->UserDashboard_model->getUser($where)[0];
        // echo '<pre>';
        // print_r($currentUser);
        // echo '</pre>';
        // die;
        if ($currentUser->user_access == 'student') {
            $attendance = $this->UserDusap_model->getAttendance(array('att.incident_report_id' => $incidentReport->incident_report_id, 'incident_report_status' => 1));
            $data = array(
            'title' => 'Home',
            'currentuser' => $currentUser,
            'cms' => $this->AdminCMS_model->getCMS()[0],
            'total_hours' => $this->AdminDusap_model->getAttendanceTotalHours(array('incident_report_id' => $incidentReport->incident_report_id))[0],
            'attendance' => $attendance,
            'incident_report' => $incidentReport,
        );
        } else {
            $data = array(
                'title' => 'Home',
                'currentuser' => $currentUser,
                'cms' => $this->AdminCMS_model->getCMS()[0],
                'incident_report' => $incidentReport,
            );
        }
        $this->load->view('user_includes/nav_header', $data);
        $this->load->view('user_dashboard/main');
        $this->load->view('user_includes/footer');
    }
}
