<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('category_model');
        $this->load->model('patient/patient_model');
        $group_permission = $this->ion_auth->get_users_groups()->row();

        if ($group_permission->name == 'admin' || $group_permission->name == 'Patient' || $group_permission->name == 'Doctor' || $group_permission->name == 'Nurse' || $group_permission->name == 'Pharmacist' || $group_permission->name == 'Laboratorist' || $group_permission->name == 'Accountant' || $group_permission->name == 'Receptionist' || $group_permission->name == 'members') {

            $this->pers = array();
            $this->permission_access_group_explode = array();
        } else {
            $this->pers = explode(',', $group_permission->description);

            $this->db->where('group_id', $group_permission->id);
            $query = $this->db->get('permission_access_group')->row();
            $permission_access_group = $query->permission_access;
            $this->permission_access_group_explode = explode('***', $permission_access_group);
        }
        if ($this->ion_auth->in_group(array('Pharmacist', 'Patient', 'Accountant', 'Nurse'))) {
            redirect('home/permission');
        }
    }

    public function index() {

        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('category');
        $this->load->view('home/footer'); // just the header file  
    }

    public function addCategoryView() {
        $data = array();

        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_category_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addCategory() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $description = $this->input->post('description');
        $code = $this->input->post('code');
        $status = $this->input->post('status');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('code', 'Code', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Category Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Price Field
        // $this->form_validation->set_rules('number', 'Bed Number', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Generic Name Field
        $this->form_validation->set_rules('description', 'Description', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Company Name Field

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $data = array();

                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_category_view', $data);
                $this->load->view('home/footer'); // just the footer file
            } else {
                $data = array();
                $data['setval'] = 'setval';

                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_category_view', $data);
                $this->load->view('home/footer'); // just the header file
            }
        } else {

            $data = array();
            $data = array(
                'code' => $code,
                'name' => $name,
                'description' => $description,
                'status' => $status
            );
            if (empty($id)) {
                $this->category_model->insertCategory($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->category_model->updateCategory($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('category');
        }
    }

    function editCategoryByJason() {
        $id = $this->input->get('id');
        $data['category'] = $this->category_model->getCategoryById($id);
        echo json_encode($data);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->category_model->deleteCategory($id);
        redirect('category');
    }

    function getCategoryList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['categorys'] = $this->category_model->getCategoryBysearch($search);
            } else {
                $data['categorys'] = $this->category_model->getCategory();
            }
        } else {
            if (!empty($search)) {
                $data['categorys'] = $this->category_model->getCategoryByLimitBySearch($limit, $start, $search);
            } else {
                $data['categorys'] = $this->category_model->getCategoryByLimit($limit, $start);
            }
        }


        //  $data['patients'] = $this->patient_model->getVisitor();
        $i = 0;
        $permis = '';
        $permis_1 = '';
        foreach ($this->permission_access_group_explode as $perm) {
            $perm_explode = array();

            $perm_explode = explode(",", $perm);
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Medical-Data') {
                $permis = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Medical-Data') {
                $permis_1 = 'ok';
                //  break;
            }
        }
        foreach ($data['categorys'] as $category) {
            $i = $i + 1;
            $option1 = '';
            $option2 = '';
            if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok') {
                $option1 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $category->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</button>';
            }
            if ($this->ion_auth->in_group(array('admin')) || $permis_1 == 'ok') {
                $option2 = '<a class="btn btn-info btn-xs btn_width delete_button" href="category/delete?id=' . $category->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i> ' . lang('delete') . '</a>';
            }
            $status = '';
            if ($category->status == 'active') {
                $status = lang('active');
            } else {
                $status = lang('in_active');
            }
            $info[] = array(
                $i,
                $category->code,
                $category->name,
                $category->description,
                $status,
                $option1 . ' ' . $option2
            );
        }

        if (!empty($data['categorys'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('category')->num_rows(),
                "recordsFiltered" => $this->db->get('category')->num_rows(),
                "data" => $info
            );
        } else {
            $output = array(
                // "draw" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            );
        }

        echo json_encode($output);
    }

}

/* End of file bed.php */
    /* Location: ./application/modules/bed/controllers/bed.php */
    