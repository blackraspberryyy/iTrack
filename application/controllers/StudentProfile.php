<?php

class StudentProfile extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->has_userdata('isloggedin') == FALSE) {
            //user is not yet logged in
            $this->session->set_flashdata("err_login", "Login First!");
            redirect(base_url() . 'login/');
        } else {
            if ($this->session->userdata("useraccess") == "student") {
                //Do Nothing
            } else if ($this->session->userdata("useraccess") == "admin") {
                $this->session->set_flashdata("err_login", "Restricted Subpage");
                redirect(base_url() . 'studentdashboard/');
            }
        }
    }

    public function index(){
        $where = array(
            "student_id" => $this->session->userdata("userid")
        );
        $data = array(
            "title" => "Student Profile",
            'currentstudent'  => $this->StudentDashboard_model->getStudent($where)[0]
        );
        $this->load->view("student_includes/nav_header", $data);
        $this->load->view("student_profile/main");
        $this->load->view("student_includes/footer");
    }
}
