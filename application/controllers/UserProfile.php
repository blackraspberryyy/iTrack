<?php

class UserProfile extends CI_Controller {

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
        $where = array(
            "user_id" => $this->session->userdata("userid")
        );
        $data = array(
            "title" => "Home",
            'currentuser' => $this->UserDashboard_model->getUser($where)[0]
        );
        $this->load->view("user_includes/nav_header", $data);
        $this->load->view("user_profile/main");
        $this->load->view("user_includes/footer");
    }

    public function change_picture_exec() {
        $currentUser = $this->UserProfile_model->getInfo("user", array("user_id" => $this->session->userdata("userid")))[0];
        $useraccess = $this->session->userdata("useraccess");
        if ($useraccess == "admin") {
            $config['upload_path'] = './images/admin/';
        } else if ($useraccess == "teacher") {
            $config['upload_path'] = './images/teacher/';
        } else {
            $config['upload_path'] = './images/student/';
        }
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 5120;
        $config['file_ext_tolower'] = true;
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);

        if (!empty($_FILES["picture"]["name"])) {
            // IF PICTURE IS EMPTY
            if ($this->upload->do_upload('picture')) {
                switch ($useraccess) {
                    case "admin": {
                            $imagePath = "images/admin/" . $this->upload->data("file_name");
                            break;
                        }
                    case "teacher": {
                            $imagePath = "images/teacher/" . $this->upload->data("file_name");
                            break;
                        }
                    case "student": {
                            $imagePath = "images/student/" . $this->upload->data("file_name");
                            break;
                        }
                    default: {
                            break;
                        }
                }
                unlink($currentUser->user_picture);
            } else {
                echo $this->upload->display_errors();
                $this->session->set_flashdata("uploading_error", "Please make sure that the max size is 5MB the types may only be .jpg, .jpeg, .gif, .png");
                redirect(base_url()."userprofile");
                
            }
        } else {
            // IF PICTURE IS EMPTY
            $imagePath = $currentUser->user_picture;
        }

        $data = array(
            "user_picture"      => $imagePath,
            "user_updated_at"   => time()
        );
        
        if($this->UserProfile_model->update_user($data, $this->session->userdata("userid"))){
            $this->session->set_flashdata("uploading_success", "Picture Successfully Changed");
            redirect(base_url()."userprofile");
        }else{
            $this->session->set_flashdata("uploading_error", "Something went wrong. Reupload your picture");
            redirect(base_url()."userprofile");
        }
    }

}
