<?php

class UserDashboard extends CI_Controller {

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
    
    public function index(){
        $where = array(
            "user_id" => $this->session->userdata("userid")
        );
        $data = array(
            "title" => "Home",
            'currentuser'  => $this->UserDashboard_model->getUser($where)[0]
        );
        $this->load->view("user_includes/nav_header", $data);
        $this->load->view("user_dashboard/main");
        $this->load->view("user_includes/footer");
    }

}
