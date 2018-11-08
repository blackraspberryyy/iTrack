<?php

class StudentHandbook extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->has_userdata('isloggedin') == FALSE) {
            //user is not yet logged in
            $this->session->set_flashdata("err_login", "Login First!");
            redirect(base_url() . 'Login/');
        }
    }

    public function index() {
        if ($this->session->userdata("useraccess") == "admin") {
            //ADMIN
            $where = array(
                "admin_id" => $this->session->userdata("userid")
            );
            $data = array(
                'title' => "Student Handbook",
                'currentadmin' => $this->AdminDashboard_model->getAdmin($where)[0],
                'cms'   => $this->AdminCMS_model->getCMS()[0]
            );
            $this->load->view("admin_includes/nav_header", $data);
            $this->load->view("student_handbook/student_handbook");
            $this->load->view("admin_includes/footer");
        } else {
            //USER
            $where = array(
                "user_id" => $this->session->userdata("userid")
            );
            $data = array(
                "title" => "Student Handbook",
                'currentuser' => $this->UserDashboard_model->getUser($where)[0],
                'cms'   => $this->AdminCMS_model->getCMS()[0]
            );
            $this->load->view("user_includes/nav_header", $data);
            $this->load->view("student_handbook/student_handbook");
            $this->load->view("user_includes/footer");
        }
    }

}
