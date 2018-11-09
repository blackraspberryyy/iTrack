<?php

class UserViolation extends CI_Controller {

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

    public function index() {
        $violations = $this->UserViolation_model->get_violation(array('u.user_id' => $this->session->userdata("userid"), 'incident_report_isAccepted' => 1));
        $where = array(
            "user_id" => $this->session->userdata("userid")
        );
        $data = array(
            "title" => ucfirst($this->session->userdata("useraccess")) . "'s Violation",
            'currentuser' => $this->UserDashboard_model->getUser($where)[0],
            'violations' => $violations,
            'minor_reports' => $this->AdminMinorReports_model->getMinorReports(array('mr.user_id' => $this->session->userdata("userid")))
        );
        $this->load->view("user_includes/nav_header", $data);
        $this->load->view("user_violation/main");
        $this->load->view("user_includes/footer");
    }

}
