<?php

class UserIncidentReport extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->has_userdata('isloggedin') == false) {
            //user is not yet logged in
            $this->session->set_flashdata('err_login', 'Login First!');
            redirect(base_url().'Login/');
        } else {
            if ($this->session->userdata('useraccess') == 'student' || $this->session->userdata('useraccess') == 'teacher') {
                //Do Nothing
            } elseif ($this->session->userdata('useraccess') == 'admin') {
                $this->session->set_flashdata('err_login', 'Restricted Subpage');
                redirect(base_url().'UserDashboard/');
            }
        }
    }

    public function search_user_number()
    {
        $keyword = strval($this->input->post('id'));

        $query = $this->db->query("SELECT * FROM user WHERE user_number LIKE '%".$keyword."%'");
        $result = $query->result_array();
        $res = array();
        foreach ($result as $key => $arr) {
            $res[$key]['user_id'] = $arr['user_id'];
            $res[$key]['user_number'] = $arr['user_number'];
            $res[$key]['user_firstname'] = $arr['user_firstname'];
            $res[$key]['user_lastname'] = $arr['user_lastname'];
            $res[$key]['user_middlename'] = $arr['user_middlename'];
            $res[$key]['user_course'] = $arr['user_course'];
            $res[$key]['user_access'] = $arr['user_access'];
            $res[$key]['user_picture'] = $arr['user_picture'];
        }
        echo json_encode($res);
    }

    public function index()
    {
        $majorViolations = $this->UserIncidentReport_model->getIncidentReport(array('u.user_id' => $this->session->userdata('userid'), 'incident_report_isAccepted' => 1));

        $where = array(
            'user_id' => $this->session->userdata('userid'),
        );
//        echo $this->db->last_query();
//        echo "<pre>";
//        print_r($majorViolations);
//        echo "</pre>";
//        die;
        $data = array(
            'title' => ucfirst($this->session->userdata('useraccess'))."'s Incident Reports",
            'currentuser' => $this->UserDashboard_model->getUser($where)[0],
            'majorViolations' => $majorViolations,
            'major_violations' => $this->UserIncidentReport_model->getMajorViolations(),
            'minor_violations' => $this->UserIncidentReport_model->getMinorViolations(),
            'cms' => $this->AdminCMS_model->getCMS()[0],
        );
        $this->load->view('user_includes/nav_header', $data);
        $this->load->view('user_incident_report/main');
        $this->load->view('user_includes/footer');
    }

    // public function incident_report_exec()
    // {
    //     if ($this->input->post('classification') == '0') {
    //         $this->form_validation->set_rules('classification_other', 'Name of Violation', 'required');
    //     }

    //     if ($this->input->post('user_course') == 'student') {
    //         $this->form_validation->set_rules('user_course', 'Course', 'required');
    //         $this->form_validation->set_rules('user_section_year', 'Section/Year', 'required');
    //     }

    //     $this->form_validation->set_rules('date_time', 'Date and Time', 'required');
    //     $this->form_validation->set_rules('place', 'Place', 'required');
    //     $this->form_validation->set_rules('user_number', 'User Number', 'required|integer');
    //     $this->form_validation->set_rules('user_lastname', 'Lastname', 'required');
    //     $this->form_validation->set_rules('user_firstname', 'Firstname', 'required');
    //     $this->form_validation->set_rules('user_age', 'Age', 'required|max_length[3]|integer');
    //     $this->form_validation->set_rules('user_access', 'Access', 'required');
    //     $this->form_validation->set_rules('message', 'Message', 'required');

    //     if ($this->form_validation->run() == false) {
    //         //ERROR
    //         $this->index();
    //     } else {
    //         if ($this->input->post('classification') == '0') {
    //             $violation = array(
    //                 'violation_name' => $this->input->post('classification_other'),
    //                 'violation_type' => $this->input->post('nature'),
    //                 'violation_category' => 'other',
    //                 'violation_added_at' => time(),
    //             );
    //             $this->AdminIncidentReport_model->insert_violation($violation);
    //             $violation_id = $this->db->insert_id();
    //         } else {
    //             $violation_id = $this->input->post('classification');
    //         }
    //         $this->UserIncidentReport_model->get_user_id($this->input->post('user_number'))[0]->user_id;
    //         // echo $this->db->last_query();
    //         $incident_report = array(
    //             'user_reported_by' => $this->session->userdata('userid'), //NULL if the ADMIN is the one to report
    //             'user_id' => $this->UserIncidentReport_model->get_user_id($this->input->post('user_number'))[0]->user_id,
    //             'violation_id' => $violation_id,
    //             'incident_report_datetime' => strtotime($this->input->post('date_time')),
    //             'incident_report_place' => $this->input->post('place'),
    //             'incident_report_age' => $this->input->post('user_age'),
    //             'incident_report_section_year' => $this->input->post('user_section_year'),
    //             'incident_report_message' => $this->input->post('message'),
    //             'incident_report_added_at' => time(),
    //         );
    //         $this->UserIncidentReport_model->insert_incident_report($incident_report);
    //         $this->session->set_flashdata('success_incident_report', 'Incident Report successfully recorded.');

    //         //-- AUDIT TRAIL
    //         $this->Logger->saveToAudit($this->session->userdata('userid'), 'Filed an incident report');

    //         redirect(base_url().'UserIncidentReport');
    //     }
    // }

    public function add_incident_report()
    {
        $allUsers = $this->UserIncidentReport_model->getUser($this->session->userdata('userid'));
        $courses = $this->UserIncidentReport_model->getCourse();
        // echo '<pre>';
        // print_r($courses);
        // echo '</pre>';
        // die;
        $where = array(
            'user_id' => $this->session->userdata('userid'),
        );
        $data = array(
            'title' => 'Add Incident Report',
            'currentuser' => $this->UserDashboard_model->getUser($where)[0],
            'cms' => $this->AdminCMS_model->getCMS()[0],
            'allUsers' => $allUsers,
            'courses' => $courses,
            'major_violations' => $this->UserIncidentReport_model->getMajorViolations(),
            'minor_violations' => $this->UserIncidentReport_model->getMinorViolations(),
        );
        $this->load->view('user_includes/nav_header', $data);
        $this->load->view('user_incident_report/add_incident_report');
        $this->load->view('user_includes/footer');
    }

    public function add_incident_report_exec()
    {
        $this->form_validation->set_rules('date_time', 'Date and Time', 'required');
        $this->form_validation->set_rules('place', 'Place', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');

        if ($this->form_validation->run() == false) {
            //ERROR
            $this->add_incident_report();
        } else {
            $this->UserIncidentReport_model->get_user_id($this->uri->segment(3))[0]->user_id;
            // echo $this->db->last_query();
            // die;
            $incident_report = array(
                'user_reported_by' => $this->session->userdata('userid'), //NULL if the ADMIN is the one to report
                'user_id' => $this->UserIncidentReport_model->get_user_id($this->uri->segment(3))[0]->user_id,
                'violation_id' => $this->input->post('classification'),
                'incident_report_datetime' => strtotime($this->input->post('date_time')),
                'incident_report_place' => $this->input->post('place'),
                'effects_id' => 1,
                'incident_report_age' => $this->input->post('user_age'),
                'incident_report_section_year' => $this->input->post('user_section_year'),
                'incident_report_message' => $this->input->post('message'),
                'incident_report_added_at' => time(),
            );
            $this->UserIncidentReport_model->insert_incident_report($incident_report);
            $this->session->set_flashdata('success_incident_report', 'Incident Report successfully recorded.');
            //-- AUDIT TRAIL
            $this->Logger->saveToAudit($this->session->userdata('userid'), 'Filed an incident report');

            redirect(base_url().'UserIncidentReport');
        }
    }

    public function search_user()
    {
        $word = $this->input->post('search_word');
        $matched_users = $this->UserIncidentReport_model->searchUsers($word, array('user_access' => 1));
        if ($word == '') {
            $allUsers = $this->UserIncidentReport_model->getUser($this->session->userdata('userid'));
            $data = array(
                'success' => 1,
                'result' => '',
                'users' => $allUsers,
            );
        } else {
            if (empty($matched_users)) {
                $data = array(
                    'success' => 2,
                    'result' => 'No Matches Found',
                    'users' => $matched_users,
                );
            } else {
                $data = array(
                    'success' => 3,
                    'result' => count($matched_users).' results found',
                    'users' => $matched_users,
                );
            }
        }
        echo json_encode($data);
    }

    public function filter_access()
    {
        $filter = $this->input->post('filter');
        $matched_users = $this->UserIncidentReport_model->filter_access($filter, $this->session->userdata('userid'));
        if ($filter == 'nofilter') {
            $allUsers = $this->UserIncidentReport_model->getUser($this->session->userdata('userid'));
            $data = array(
                'success' => 1,
                'result' => '',
                'users' => $allUsers,
            );
        } else {
            if (empty($matched_users)) {
                $data = array(
                    'success' => 2,
                    'result' => 'No Matches Found',
                    'users' => $matched_users,
                );
            } else {
                $data = array(
                    'success' => 3,
                    'result' => count($matched_users).' results found',
                    'users' => $matched_users,
                );
            }
        }

        echo json_encode($data);
    }

    public function filter_course()
    {
        $filter = $this->input->post('filter');
        $matched_users = $this->UserIncidentReport_model->filter_course($filter, $this->session->userdata('userid'));
        if ($filter == 'nofilter') {
            $allUsers = $this->UserIncidentReport_model->getUser($this->session->userdata('userid'));
            $data = array(
                'success' => 1,
                'result' => '',
                'users' => $allUsers,
            );
        } else {
            if (empty($matched_users)) {
                $data = array(
                    'success' => 2,
                    'result' => 'No Matches Found',
                    'users' => $matched_users,
                );
            } else {
                $data = array(
                    'success' => 3,
                    'result' => count($matched_users).' results found',
                    'users' => $matched_users,
                );
            }
        }

        echo json_encode($data);
    }
}
