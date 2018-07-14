<?php

class AdminLogin extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->has_userdata('isloggedin') == TRUE) {
            $currentUserId = $this->session->userdata('userid');
        }
    }

    public function index() {
        $data = array(
            'title' => "Admin Login"
        );
        $this->load->view("admin_login/login", $data);
    }

    public function login_exec() {
        $credentials = array(
            "admin_number" => $this->input->post("adminnumber"),
            "admin_password" => sha1($this->input->post("password"))
        );

        $getAdmin = $this->Login_model->getinfo("admin", $credentials)[0];

        if (!$getAdmin) {
            //NO Account found
            $this->session->set_flashdata("err_login", "Username and Password doesn't match any accounts");
            redirect(base_url() . "adminlogin");
        } else {
            //Student Found
            if ($getAdmin->admin_isactive == 0) {
                //Account is blocked
                $this->session->set_flashdata("err_login", "Account is blocked.");
                redirect(base_url() . "adminlogin");
            } else {
                $this->session->set_userdata('isloggedin', true);
                $this->session->set_userdata('userid', $getAdmin->admin_id);
                $this->session->set_userdata('useraccess', "admin");
                redirect(base_url() . 'admindashboard/');
            }
        }
    }
}
