<?php

class AdminDashboard extends CI_Controller {

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
        $where = array(
            "admin_id" => $this->session->userdata("userid")
        );

        $data = array(
            'title'             => "Home",
            'currentadmin'      => $this->AdminDashboard_model->getAdmin($where)[0],
            'cms'               => $this->AdminCMS_model->getCMS()[0],
            'users'             => $this->AdminDashboard_model->getUsers(),
            'students_count'    => $this->AdminDashboard_model->getUsers(array("user_access" => "student")) != "" ? count($this->AdminDashboard_model->getUsers(array("user_access" => "student"))) : 0,
            'teacher_count'    => $this->AdminDashboard_model->getUsers(array("user_access" => "teacher")) != "" ? count($this->AdminDashboard_model->getUsers(array("user_access" => "teacher"))) : 0,
            'ongoing_incident_reports_count' => $this->AdminDashboard_model->getIncidentReports(array("incident_report_status" => 0)) != "" ? count($this->AdminDashboard_model->getIncidentReports(array("incident_report_status" => 0))) : 0,
            'finished_incident_reports_count' => $this->AdminDashboard_model->getIncidentReports(array("incident_report_status" => 1)) != "" ?  count($this->AdminDashboard_model->getIncidentReports(array("incident_report_status" => 1))) : 0

        );
        $this->load->view("admin_includes/nav_header", $data);
        $this->load->view("admin_dashboard/main");
        $this->load->view("admin_includes/footer");
    }
    
    public function reports(){
        $users = $this->AdminDashboard_model->getUsers();
        $students_count = $this->AdminDashboard_model->getUsers(array("user_access" => "student")) != "" ? count($this->AdminDashboard_model->getUsers(array("user_access" => "student"))) : 0;
        $teacher_count = $this->AdminDashboard_model->getUsers(array("user_access" => "teacher")) != "" ? count($this->AdminDashboard_model->getUsers(array("user_access" => "teacher"))) : 0;
        $ongoing_incident_reports_count = $this->AdminDashboard_model->getIncidentReports(array("incident_report_status" => 0)) != "" ? count($this->AdminDashboard_model->getIncidentReports(array("incident_report_status" => 0))) : 0;
        $finished_incident_reports_count = $this->AdminDashboard_model->getIncidentReports(array("incident_report_status" => 1)) != "" ? count($this->AdminDashboard_model->getIncidentReports(array("incident_report_status" => 1))) : 0;
        $wma = 0;
        $agd = 0;
        $da = 0;
        $emc = 0;
        $smba = 0;
        $cs = 0;
        $ece = 0;
        $ce = 0;
        $ee = 0;
        $cpe = 0;
        $me = 0;

        foreach($users as $user){
            if(strpos(strtolower($user->user_course), 'wma') !== false){
                $wma++;
            }else if(strpos(strtolower($user->user_course), 'agd') !== false){
                $agd++;
            }else if(strpos(strtolower($user->user_course), 'da') !== false){
                $da++;
            }else if(strpos(strtolower($user->user_course), 'emc') !== false){
                $emc++;
            }else if(strpos(strtolower($user->user_course), 'smba') !== false){
                $smba++;
            }else if(strpos(strtolower($user->user_course), 'cs') !== false){
                $cs++;
            }else if(strpos(strtolower($user->user_course), 'ece') !== false){
                $ece++;
            }else if(strpos(strtolower($user->user_course), 'ce') !== false){
                $ce++;
            }else if(strpos(strtolower($user->user_course), 'ee') !== false){
                $ee++;
            }else if(strpos(strtolower($user->user_course), 'cpe') !== false){
                $cpe++;
            }else if(strpos(strtolower($user->user_course), 'me') !== false){
                $me++;
            }
        }

        $legal_paper_size = array(215.9,355.6);
        $reports_title = "ITrack Reports";
        $samplePDF = new Pdf("P", "mm", $legal_paper_size, true, 'UTF-8', false);
        $samplePDF->SetMargins(PDF_MARGIN_LEFT, 12, PDF_MARGIN_RIGHT, true);
        $samplePDF->SetAutoPageBreak(TRUE, 20);
        $samplePDF->AddPage('P', $legal_paper_size);
        $samplePDF->setTitle($reports_title);

        $header = '
            <div style="text-align:center;">
                <img src="'.base_url().'images/logo.png'.'" width="120"/>
                <h5>REPORTS</h5>
            </div>
        ';

        $body = '
            <h4>Incident Reports: </h4>
            <table cellpadding="4" border="1">
                <tr>
                    <th style="width:15%;">WMA</th>
                    <td>'.$wma.'</td>
                    </tr>
                <tr>
                    <th>AGD</th>
                    <td>'.$agd.'</td>
                </tr>
                <tr>
                    <th>DA</th>
                    <td>'.$da.'</td>
                </tr>
                <tr>
                    <th>EMC</th>
                    <td>'.$emc.'</td>
                </tr>
                <tr>
                    <th>SMBA</th>
                    <td>'.$smba.'</td>
                </tr>
                <tr>
                    <th>CS</th>
                    <td>'.$cs.'</td>
                </tr>
                <tr>
                    <th>ECE</th>
                    <td>'.$ece.'</td>
                </tr>
                <tr>
                    <th>EE</th>
                    <td>'.$ee.'</td>
                </tr>
                <tr>
                    <th>CPE</th>
                    <td>'.$cpe.'</td>
                </tr>
                <tr>
                    <th>ME</th>
                    <td>'.$me.'</td>
                </tr>
                <tr>
                    <th>CS</th>
                    <td>'.$cs.'</td>
                </tr>
            </table>
            <br/><br/><br/>
            <table border="1">
                <tr>
                    <th align="center">Students</th>
                    <th align="center">Teacher</th>
                    <th align="center">Ongoing Incident Reports</th>
                    <th align="center">Finished Incident Reports</th>
                </tr>
                <tr>
                    <td align="center">'.$students_count.'</td>
                    <td align="center">'.$teacher_count.'</td>
                    <td align="center">'.$ongoing_incident_reports_count.'</td>
                    <td align="center">'.$finished_incident_reports_count.'</td>
                </tr>
            </table>
        ';

        $content = $header.$body;
        $samplePDF->writeHTML($content);
        $samplePDF->Output($reports_title);
        
        exit;
    }
}
