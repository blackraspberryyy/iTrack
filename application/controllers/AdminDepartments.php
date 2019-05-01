<?php

class AdminDepartments extends CI_Controller{
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
            'title'             => "Departments",
            'currentadmin'      => $this->AdminDashboard_model->getAdmin($where)[0],
            'cms'               => $this->AdminCMS_model->getCMS()[0],
            'departments'       => $this->AdminDepartment_model->getDepartments()
        );
        $this->load->view("admin_includes/nav_header", $data);
        $this->load->view("admin_departments/main");
        $this->load->view("admin_includes/footer");
    }

    public function add_department_exec(){
        $this->form_validation->set_rules('name', 'Department Name', 'required');
        $this->form_validation->set_rules('supervisor', 'Supervisor Full Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $where = array(
                "admin_id" => $this->session->userdata("userid")
            );
    
            $data = array(
                'title'             => "Departments",
                'currentadmin'      => $this->AdminDashboard_model->getAdmin($where)[0],
                'cms'               => $this->AdminCMS_model->getCMS()[0],
                'departments'       => $this->AdminDepartment_model->getDepartments(),
                'modal_type'        => 'add'
            );
            $this->load->view("admin_includes/nav_header", $data);
            $this->load->view("admin_departments/main");
            $this->load->view("admin_includes/footer");
        }else{
            $data = [
                "dept_name"         => $this->input->post('name'),
                "dept_supervisor"   => $this->input->post('supervisor'),
                "dept_status"       => 1
            ];

            $this->AdminDepartment_model->addDepartment($data);
            $this->session->set_flashdata("success_incident_report", "Deparment successfully added");
            //-- AUDIT TRAIL
            $this->Logger->saveToAudit("admin", "Added deparment.");
            redirect(base_url().'AdminDepartments');
        }
    }

    public function edit_department_exec(){
        $dept_id = $this->uri->segment(3);
        $this->form_validation->set_rules('name', 'Department Name', 'required');
        $this->form_validation->set_rules('supervisor', 'Supervisor Full Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $where = array(
                "admin_id" => $this->session->userdata("userid")
            );
    
            $data = array(
                'title'             => "Departments",
                'currentadmin'      => $this->AdminDashboard_model->getAdmin($where)[0],
                'cms'               => $this->AdminCMS_model->getCMS()[0],
                'departments'       => $this->AdminDepartment_model->getDepartments(),
                'modal_type'        => 'edit',
                'modal_id'          => '#edit_'.$dept_id,
                
            );
            $this->load->view("admin_includes/nav_header", $data);
            $this->load->view("admin_departments/main");
            $this->load->view("admin_includes/footer");
        }else{
            $data = [
                "dept_name"         => $this->input->post('name'),
                "dept_supervisor"   => $this->input->post('supervisor'),
                "dept_status"       => 1
            ];

            $this->AdminDepartment_model->editDepartment($dept_id, $data);
            $this->session->set_flashdata("success_incident_report", "Deparment successfully edited");
            //-- AUDIT TRAIL
            $this->Logger->saveToAudit("admin", "Edited deparment");
            redirect(base_url().'AdminDepartments');
        }
    }

    public function delete_department(){
        $dept_id = $this->uri->segment(3);
        $this->AdminDepartment_model->deleteDepartment($dept_id);
        $this->session->set_flashdata("success_incident_report", "Deparment successfully deleted");
        //-- AUDIT TRAIL
        $this->Logger->saveToAudit("admin", "Deleted deparment");
        redirect(base_url().'AdminDepartments');
    }

    public function restore_department(){
        $dept_id = $this->uri->segment(3);
        $this->AdminDepartment_model->restoreDepartment($dept_id);
        $this->session->set_flashdata("success_incident_report", "Deparment successfully restored");
        //-- AUDIT TRAIL
        $this->Logger->saveToAudit("admin", "Restored deparment");
        redirect(base_url().'AdminDepartments');
    }
}