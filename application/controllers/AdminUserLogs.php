<?php
    class AdminUserLogs extends CI_Controller{
        function __construct() {
            parent::__construct();
            if ($this->session->has_userdata('isloggedin') == FALSE) {
                //user is not yet logged in
                $this->session->set_flashdata("err_login", "Login First!");
                redirect(base_url() . 'adminlogin/');
            } else {
                if($this->session->userdata("useraccess") == "student" || $this->session->userdata("useraccess") == "teacher"){
                    $this->session->set_flashdata("err_login", "Restricted Subpage");
                    redirect(base_url() . 'userdashboard/');
                }else if($this->session->userdata("useraccess") == "admin"){
                    //Do nothing
                }
            }
        }

        function index() {
            $where = array(
                "admin_id" => $this->session->userdata("userid")
            );
            
            $data = array(
                'title'         => "User Logs",
                'currentadmin'  => $this->AdminDashboard_model->getAdmin($where)[0],
                'cms'           => $this->AdminCMS_model->getCMS()[0],
                'logs'          => $this->AdminUserLogs_model->getUserLogs()
            );
            $this->load->view("admin_includes/nav_header", $data);
            $this->load->view("admin_user_logs/main");
            $this->load->view("admin_includes/footer");
        }
    }