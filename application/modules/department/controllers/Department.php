<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Department extends MX_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('department_model');
        $group_permission = $this->ion_auth->get_users_groups()->row();
        if ($group_permission->name == 'admin' || $group_permission->name == 'Patient' || $group_permission->name == 'Doctor' || $group_permission->name == 'Nurse' || $group_permission->name == 'Pharmacist' || $group_permission->name == 'Laboratorist' || $group_permission->name == 'Accountant' || $group_permission->name == 'Receptionist' || $group_permission->name == 'members') {

            $this->pers = array();
        } else {
            $this->pers = explode(',', $group_permission->description);
        }
        if ($this->ion_auth->in_group(array('Pharmacist', 'Accountant', 'Doctor', 'Receptionist', 'Nurse', 'Laboratorist', 'Patient'))) {
            redirect('home/permission');
        }
    }

    public function index() {
        if (!$this->ion_auth->in_group('admin') && !in_array('Department', $this->pers)) {
            redirect('home/permission');
        }
        $data['departments'] = $this->department_model->getDepartment();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('department', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewView() {
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new');
        $this->load->view('home/footer'); // just the header file
    }

    public function addNew() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $description = $this->input->post('description');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Password Field    
        // Validating Email Field
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[2]|max_length[1000]|xss_clean');
        // Validating Address Field   
        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $data = array();
                $data['department'] = $this->department_model->getDepartmentById($id);
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_new', $data);
                $this->load->view('home/footer'); // just the footer file
            } else {
                $data['setval'] = 'setval';
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_new', $data);
                $this->load->view('home/footer'); // just the header file
            }
        } else {
            //$error = array('error' => $this->upload->display_errors());
            $data = array();
            $data = array(
                'name' => $name,
                'description' => $description
            );
            if (empty($id)) {     // Adding New department
                $this->department_model->insertDepartment($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else { // Updating department
                $this->department_model->updateDepartment($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            // Loading View
            redirect('department');
        }
    }

    function getDepartment() {
        $data['departments'] = $this->department_model->getDepartment();
        $this->load->view('department', $data);
    }

    function editDepartment() {
        $data = array();
        $id = $this->input->get('id');
        $data['department'] = $this->department_model->getDepartmentById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editDepartmentByJason() {
        $id = $this->input->get('id');
        $data['department'] = $this->department_model->getDepartmentById($id);
        echo json_encode($data);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->department_model->delete($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('department');
    }

}

/* End of file department.php */
/* Location: ./application/modules/department/controllers/department.php */
