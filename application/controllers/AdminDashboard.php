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
        $incident_reports = $this->AdminDashboard_model->getComprehensiveIncidentReport();
        $distinct_violations = $this->AdminDashboard_model->getDistinctViolationOnIncidentReport();
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

        foreach($incident_reports as $report){
            if(strpos(strtolower($report->user_course), 'wma') !== false){
                $wma++;
            }else if(strpos(strtolower($report->user_course), 'agd') !== false){
                $agd++;
            }else if(strpos(strtolower($report->user_course), 'da') !== false){
                $da++;
            }else if(strpos(strtolower($report->user_course), 'emc') !== false){
                $emc++;
            }else if(strpos(strtolower($report->user_course), 'smba') !== false){
                $smba++;
            }else if(strpos(strtolower($report->user_course), 'cs') !== false){
                $cs++;
            }else if(strpos(strtolower($report->user_course), 'ece') !== false){
                $ece++;
            }else if(strpos(strtolower($report->user_course), 'ce') !== false){
                $ce++;
            }else if(strpos(strtolower($report->user_course), 'ee') !== false){
                $ee++;
            }else if(strpos(strtolower($report->user_course), 'cpe') !== false){
                $cpe++;
            }else if(strpos(strtolower($report->user_course), 'me') !== false){
                $me++;
            }
        }

        $legal_paper_size = array(215.9,355.6);
        $reports_title = "ITrack Reports";
        $samplePDF = new Pdf("p", "mm", $legal_paper_size, true, 'UTF-8', false);
        $samplePDF->SetMargins(PDF_MARGIN_LEFT, 12, PDF_MARGIN_RIGHT, true);
        $samplePDF->SetAutoPageBreak(TRUE, 20);
        $samplePDF->AddPage('L', $legal_paper_size);
        $samplePDF->setTitle($reports_title);

        $header = '
            <div style="text-align:center;">
                <img src="'.base_url().'images/logo.png'.'" width="120"/>
                <h5>REPORTS</h5>
            </div>
        ';

        $table = '
            <tr>
                <td style="width: 16%; text-align: center;">Major/Minor</td>
                <td style="text-align: center; width: 84%">Program</td>
            </tr>
            <tr>
                <td rowspan="2" style="text-align: center;">Nature of Offense</td>
                <td style="width:6%;" colspan="5">CE</td>
                <td style="width:6%;" colspan="5">CPE</td>
                <td style="width:6%;" colspan="5">ECE</td>
                <td style="width:6%;" colspan="5">EE</td>
                <td style="width:6%;" colspan="5">EMC</td>
                <td style="width:6%;" colspan="5">DA</td>
                <td style="width:6%;" colspan="5">ME</td>
                <td style="width:6%;" colspan="5">CS</td>
                <td style="width:6%;" colspan="5">WMA</td> 
                <td style="width:6%;" colspan="5">AGD</td>
                <td style="width:6%;" colspan="5">SMBA</td>
                <td style="width:6%;" colspan="5">ACT</td>
                <td style="text-align: center;" colspan="10">TOTAL</td>
            </tr>
            <tr>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>T</td>
                <!-- CE -->
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>T</td>
                <!-- CPE -->
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>T</td>
                <!-- ECE -->
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>T</td>
                <!-- EE -->
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>T</td>
                <!-- EMC -->
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>T</td>
                <!-- DA -->
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>T</td>
                <!-- ME -->
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>T</td>
                <!-- CS -->
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>T</td>
                <!-- WMA -->
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>T</td>
                <!-- AGD -->
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>T</td>
                <!-- SMBA -->
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>T</td>
                <!-- ACT -->
                <td colspan="10"> </td>
            </tr>
        ';
        
        $plot = $this->plot($incident_reports, $distinct_violations);
        $body = '<table border="1" cellpadding="1">'.$table.$plot.'</table>';

        $content = $header.$body;
        $samplePDF->writeHTML($content);
        $samplePDF->Output($reports_title);
    }


    public function plot($incident_reports, $distinct_violations) {
        $returnString = '';
        foreach($distinct_violations as $violation){
            // start with <tr>
            $returnString = $returnString.'<tr>';
            
            // do plotting here
            $returnString = 
                $returnString.'<td>'.$violation->violation_name.'</td>'.$this->plotToTerm($incident_reports, $violation->violation_id)
            ;
            
            // end with </tr>
            $returnString = $returnString.'</tr>';
        }
        return $returnString;
    }

    public function plotToTerm($incident_reports, $violation_id){
        $total = 0;
        $str = '';

        $courses = ['CE', 'CPE', 'ECE', 'EE', 'EMC', 'DA', 'ME', 'CS', 'WMA', 'AGD', 'SMBA'];

        // for student user
        foreach($courses as $c){
            $first = $this->AdminDashboard_model->getIncidentReportCount($c, $violation_id, '1st');
            $second = $this->AdminDashboard_model->getIncidentReportCount($c, $violation_id, '2nd');
            $third = $this->AdminDashboard_model->getIncidentReportCount($c, $violation_id, '3rd');
            $fourth = $this->AdminDashboard_model->getIncidentReportCount($c, $violation_id, '4th');
            $terminal = $this->AdminDashboard_model->getIncidentReportCount($c, $violation_id, 'Terminal');
            $str = $str.
                '<td>'.($first == 0 ? ' ' : $first).'</td>'.
                '<td>'.($second == 0 ? ' ' : $second).'</td>'.
                '<td>'.($third == 0 ? ' ' : $third).'</td>'.
                '<td>'.($fourth == 0 ? ' ' : $fourth).'</td>'.
                '<td>'.($terminal == 0 ? ' ' : $terminal).'</td>'
            ;
            $total = $total + $first + $second + $third + $fourth + $terminal;
        }

        $firstA = $this->AdminDashboard_model->getIncidentReportCount($c, $violation_id, '1st', TRUE);
        $secondA = $this->AdminDashboard_model->getIncidentReportCount($c, $violation_id, '2nd', TRUE);
        $thirdA = $this->AdminDashboard_model->getIncidentReportCount($c, $violation_id, '3rd', TRUE);
        $fourthA = $this->AdminDashboard_model->getIncidentReportCount($c, $violation_id, '4th', TRUE);
        $terminalA = $this->AdminDashboard_model->getIncidentReportCount($c, $violation_id, 'Terminal', TRUE);

        // for teacher user
        $str = $str.
            '<td>'.($firstA == 0 ? ' ' : $first).'</td>'.
            '<td>'.($secondA == 0 ? ' ' : $secondA).'</td>'.
            '<td>'.($thirdA == 0 ? ' ' : $thirdA).'</td>'.
            '<td>'.($fourthA == 0 ? ' ' : $fourthA).'</td>'.
            '<td>'.($terminalA == 0 ? ' ' : $terminalA).'</td>'
        ;

        $total = $total + $firstA + $secondA + $thirdA + $fourthA + $terminalA;
        //TOTAL
        $str = $str.
            '<td colspan="10" style="text-align:center;">'.$total.'</td>'
        ;
        return $str;
    }

    public function formatReport($course) {
        return $course === 0 ? 'No' : $course;
    }
}
