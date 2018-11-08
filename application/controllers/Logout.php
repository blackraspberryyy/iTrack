<?php

class Logout extends CI_Controller {

    function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $currentUser = $this->session->userdata("useraccess");
        if($currentUser == "admin"){
            $this->session->sess_destroy();
            redirect(base_url() . 'AdminLogin/');
        }else{
            $this->Logger->saveToLogs($this->session->userdata("userid"), 'out');
            $this->session->sess_destroy();
            redirect(base_url() . 'Login/');
        }
    }
}
