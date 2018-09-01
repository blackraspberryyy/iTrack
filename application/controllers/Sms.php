<?php

class Sms extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->has_userdata('isloggedin') == FALSE) {
            //user is not yet logged in
            $this->session->set_flashdata("err_login", "Login First!");
            redirect(base_url() . 'login/');
        } else {
            if($this->session->userdata("useraccess") == "student" || $this->session->userdata("useraccess") == "teacher"){
                $this->session->set_flashdata("err_login", "Restricted Subpage");
                redirect(base_url() . 'userdashboard/');
            }else if($this->session->userdata("useraccess") == "admin"){
                //Do nothing
            }
        }
    }

    public function index() {
        $where = array(
            "admin_id" => $this->session->userdata("userid")
        );
        $data = array(
            'title' => "Admin SMS",
            'currentadmin' => $this->AdminDashboard_model->getAdmin($where)[0]
        );
        $this->load->view("admin_includes/nav_header", $data);
        $this->load->view("admin_sms/sms");
        $this->load->view("admin_includes/footer");
    }

    public function send_sms_exec() {
        $this->form_validation->set_rules('mobile', "Mobile Number", "trim|required|regex_match[/^\d{10}$/]");
        $this->form_validation->set_rules('message', "Message", "trim|required");
        if ($this->form_validation->run() == FALSE) {
            $string = "";
            if (strip_tags(form_error("mobile"))) {
                $string = $string . strip_tags(form_error("mobile"));
            }
            if (strip_tags(form_error("message"))) {
                $string = $string . " " . strip_tags(form_error("message"));
            }
            $this->session->set_flashdata("err_sms", $string);
            redirect(base_url() . "sms");
        } else {
            $mobile_str = "0" . $this->input->post("mobile");
            $message_str = $this->input->post("message");

            $where = array(
                "admin_id" => $this->session->userdata("userid")
            );
            $currentAdmin = $this->Sms_model->getinfo("admin", $where)[0];
            $message_intro = "Administrator ".$currentAdmin->admin_firstname." ".$currentAdmin->admin_lastname." sent this message: \n\n";
            $message_footer = "\n\nSent from ITrack \nPowered by Semaphore";
            
            $ch = curl_init();
            $parameters = array(
                'apikey' => '28c2a09d550e3edc25fc03449441b0b0', //Your API KEY
                'number' => $mobile_str,
                'message' => $message_intro.$message_str.$message_footer
            );
            curl_setopt($ch, CURLOPT_URL, 'http://api.semaphore.co/api/v4/messages');
            curl_setopt($ch, CURLOPT_POST, 1);

            //Send the parameters set above with the request
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

            // Receive response from server
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            curl_close($ch);

            $this->session->set_flashdata("success_sms", "Successfully messaged " . $mobile_str . ".");

            //-- AUDIT TRAIL
            $this->Logger->saveToAudit("admin", "Send an SMS to ".$mobile_str);
            
            redirect(base_url() . "sms");
        }
    }

}
