<?php

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->has_userdata('isloggedin') == TRUE) {
            $currentUserId = $this->session->userdata('userid');
        }
    }

    public function index() {
        $data = array(
            'title' => "Login"
        );
        $this->load->view("login/login", $data);
    }

    public function login_exec() {
        $credentials = array(
            "user_number" => $this->input->post("usernumber"),
            "user_password" => sha1($this->input->post("password"))
        );

        $getUser = $this->Login_model->getinfo("user", $credentials)[0];

        if (!$getUser) {
            //NO Account found
            $this->session->set_flashdata("err_login", "User Number and Password doesn't match any accounts");
            redirect(base_url() . "Login");
        } else {
            //Student Found
            if ($getUser->user_isactive == 0) {
                //Account is blocked
                $this->session->set_flashdata("err_login", "Account is blocked.");
                redirect(base_url() . "Login");
            } else {
                $this->session->set_userdata('isloggedin', true);
                $this->session->set_userdata('userid', $getUser->user_id);
                $this->session->set_userdata('useraccess', $getUser->user_access);

                //-- Insert to USER LOGS
                $this->Logger->saveToLogs($this->session->userdata("userid"), 'in');
                redirect(base_url() . 'UserDashboard/');
            }
        }
    }
}