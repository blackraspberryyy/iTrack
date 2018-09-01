<?php

class Logout extends CI_Controller {

    function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $currentUser = $this->session->userdata("useraccess");
        $this->session->sess_destroy();
        echo $currentUser;
        if($currentUser == "admin"){
            redirect(base_url() . 'adminlogin/');
        }else{
            $this->Logger->saveToLogs($this->session->userdata("userid"), 'out');
            redirect(base_url() . 'login/');
        }
    }
}
