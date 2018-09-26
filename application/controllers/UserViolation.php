<?php

class UserViolation extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->has_userdata('isloggedin') == FALSE) {
            //user is not yet logged in
            $this->session->set_flashdata("err_login", "Login First!");
            redirect(base_url() . 'login/');
        } else {
            if ($this->session->userdata("useraccess") == "student" || $this->session->userdata("useraccess") == "teacher") {
                //Do Nothing
            } else if ($this->session->userdata("useraccess") == "admin") {
                $this->session->set_flashdata("err_login", "Restricted Subpage");
                redirect(base_url() . 'userdashboard/');
            }
        }
    }

    public function index() {
        $violations = $this->UserValidation_model->get_validation(array('incident_report.user_id' => $this->session->userdata("userid")));
        $where = array(
            "user_id" => $this->session->userdata("userid")
        );
        $data = array(
            "title" => ucfirst($this->session->userdata("useraccess")) . "'s Violation",
            'currentuser' => $this->UserDashboard_model->getUser($where)[0],
            '$violations' => $violations,
        );
        $this->load->view("user_includes/nav_header", $data);
        $this->load->view("user_violation/main");
        $this->load->view("user_includes/footer");
    }

}
