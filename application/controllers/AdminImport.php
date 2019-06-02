<?php

class AdminImport extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->has_userdata('isloggedin') == FALSE) {
            //user is not yet logged in
            $this->session->set_flashdata("err_login", "Login First!");
            redirect(base_url() . 'AdminLogin/');
        } else {
            if($this->session->userdata("useraccess") == "student" || $this->session->userdata("useraccess") == "teacher"){
                $this->session->set_flashdata("err_login", "Restricted Subpage");
                redirect(base_url() . 'UserDashboard/');
            }else if($this->session->userdata("useraccess") == "admin"){
                //Do nothing
            }
        }
    }
    
    public function index() {
        $data = array(
            'title'         => "Import Student",
            'currentadmin'  => $this->AdminDashboard_model->getAdmin(array("admin_id" => $this->session->userdata("userid")))[0]
        );
        $this->load->view("admin_includes/nav_header", $data);
        $this->load->view("admin_import/main");
        $this->load->view("admin_includes/footer");
    }

    public function importExcel() {
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        if(isset($_FILES['xlsx_file']['name']) && in_array($_FILES['xlsx_file']['type'], $file_mimes)) {
            $arr_file = explode('.', $_FILES['xlsx_file']['name']);
            $extension = end($arr_file);
            if('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($_FILES['xlsx_file']['tmp_name']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            
            $messages = array();
            $students = array();
            foreach($sheetData as $key => $data){
                if($key === 1){
                    // row is a header
                    // ignore this loop
                }else{
                    $tmp = array(
                        "user_number"       => $data['A'],
                        "user_serial_no"    => '',
                        "user_firstname"    => $data['B'],
                        "user_lastname"     => $data['C'],
                        "user_middlename"   => $data['D'],
                        "user_password"     => sha1($data['E']),
                        "user_fcm_token"    => '',
                        "user_email"        => $data['F'],
                        "user_picture"      => 'images/admin/200900001.gif',
                        "user_course"       => $data['G'],
                        "user_section"      => $data['H'],
                        "user_year"         => $data['I'],
                        "user_isActive"     => 1,
                        "user_added_at"     => time(),
                        "user_updated_at"   => time()
                    );

                    if(!$this->isExistingInUsers($tmp['user_number'])){
                        $students[] = $tmp;
                    }else{
                        $messages[] = 'User with '.$tmp['user_number'].' is already existing.<br/>';
                    }
                }
            }

            if(!empty($students)){
                $this->AdminImport_model->add_students($students);
            }
            if(empty($messages)){
                $this->session->set_flashdata("success_import", "Students imported successfully.");
            }else{
                $this->session->set_flashdata("success_import", "Students imported successfully. With some errors: <br/>".$this->displayMessages($messages));
            }

            //-- AUDIT TRAIL
            $this->Logger->saveToAudit("admin", "Import Students from Excel File");
            redirect(base_url().'AdminImport');

        }else{
            $this->session->set_flashdata("error_import", "There have been errors in importing the excel file.");
            redirect(base_url().'AdminImport');            
        }
    }
    
    public function isExistingInUsers($user_number){
        $user_number = trim($user_number);
        $user_number = strip_tags($user_number);
        $existingUsers = $this->AdminImport_model->getUsers();
        $bool = false;
        foreach($existingUsers as $user){
            if($user->user_number == $user_number ){
                $bool = true;
                break;
            }
        }
        return $bool;
    }

    public function displayMessages($messages){
        $str = '';
        foreach($messages as $m){
            $str = $str.$m;
        }
        return $str;
    }
}
