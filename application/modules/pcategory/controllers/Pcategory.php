<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pcategory extends MX_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('pcategory_model');
        $group_permission = $this->ion_auth->get_users_groups()->row();

        if ($group_permission->name == 'admin' || $group_permission->name == 'Patient' || $group_permission->name == 'Doctor' || $group_permission->name == 'Nurse' || $group_permission->name == 'Pharmacist' || $group_permission->name == 'Laboratorist' || $group_permission->name == 'Pcategory' || $group_permission->name == 'Receptionist' || $group_permission->name == 'members') {

            $this->pers = array();
            $this->permission_access_group_explode = array();
        } else {
            $this->pers = explode(',', $group_permission->description);

            $this->db->where('group_id', $group_permission->id);
            $query = $this->db->get('permission_access_group')->row();
            $permission_access_group = $query->permission_access;
            $this->permission_access_group_explode = explode('***', $permission_access_group);
        }
        if ($this->ion_auth->in_group(array('pharmacist', 'Accountant', 'Doctor', 'Receptionist', 'Nurse', 'Laboratorist', 'Patient'))) {

            redirect('home/permission');
        }
    }

    public function index() {

        $data['pcategorys'] = $this->pcategory_model->getPcategory();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('pcategory', $data);
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
        $discount = $this->input->post('discount');
        $status = $this->input->post('status');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Password Field

        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[1]|max_length[100]|xss_clean');

        // Validating Email Field
        //  $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Address Field   
        // $this->form_validation->set_rules('address', 'Address', 'trim|required|min_length[1]|max_length[500]|xss_clean');
        // Validating Phone Field           
        // $this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[1]|max_length[50]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect("pcategory/editPcategory?id=" . $id);
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
                'description' => $description,
                'discount' => $discount,
                'status' => $status
            );


            ///   $username = $this->input->post('name');

            if (empty($id)) {     // Adding New Pcategory
                $this->pcategory_model->insertPcategory($data);
            } else { // Updating Pcategory
                $this->pcategory_model->updatePcategory($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            // Loading View
            redirect('pcategory');
        }
    }

    function getPcategory() {
        $data['pcategorys'] = $this->pcategory_model->getPcategory();
        $this->load->view('pcategory', $data);
    }

    function editPcategory() {
        $data = array();
        $id = $this->input->get('id');
        $data['pcategory'] = $this->pcategory_model->getPcategoryById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editPcategoryByJason() {
        $id = $this->input->get('id');
        $data['pcategory'] = $this->pcategory_model->getPcategoryById($id);
        echo json_encode($data);
    }

    function delete() {
       
        $id = $this->input->get('id');
       
        $this->pcategory_model->delete($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('pcategory');
    }

    function getPcategoryList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        $order = $this->input->post("order");
        $columns_valid = array(
            "0" => "id",
            "1" => "name",
            "2" => "phone",
        );
        $values = $this->settings_model->getColumnOrder($order, $columns_valid);
        $dir = $values[0];
        $order = $values[1];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['pcategorys'] = $this->pcategory_model->getPcategoryBysearch($search, $order, $dir);
            } else {
                $data['pcategorys'] = $this->pcategory_model->getPcategoryWithoutSearch($order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['pcategorys'] = $this->pcategory_model->getPcategoryByLimitBySearch($limit, $start, $search, $order, $dir);
            } else {
                $data['pcategorys'] = $this->pcategory_model->getPcategoryByLimit($limit, $start, $order, $dir);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $permis = '';
        $permis_1 = '';
        $permis_2 = '';
        // $permis_finance='';
        //$permis_finance_2='';
        foreach ($this->permission_access_group_explode as $perm) {
            $perm_explode = array();
            $perm_explode = explode(",", $perm);
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Patient-Category') {
                $permis = 'ok';
                //  break;
            }
            if (in_array('1', $perm_explode) && $perm_explode[0] == 'Patient-Category') {
                $permis_2 = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Patient-Category') {
                $permis_1 = 'ok';
                //  break;
            }
        }
        $options1 = '';

        $options5 = '';

        $i = 1;
        foreach ($data['pcategorys'] as $pcategory) {

            if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok') {
                //   $options1 = '<a type="button" class="btn editbutton" title="Edit" data-toggle="modal" data-id="463"><i class="fa fa-edit"> </i> Edit</a>';
                $options1 = ' <a type="button" class="btn editbutton" title="' . lang('edit') . '" data-toggle = "modal" data-id="' . $pcategory->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</a>';
            }

            if ($this->ion_auth->in_group(array('admin')) || $permis_1 == 'ok') {
                $options5 = '<a class="btn delete_button" title="' . lang('delete') . '" href="pcategory/delete?id=' . $pcategory->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"></i> ' . lang('delete') . '</a>';
            }

            $status = '';
            if ($pcategory->status == 'active') {
                $status = lang('active');
            } else {
                $status = lang('in_active');
            }


            if ($this->ion_auth->in_group(array('admin')) || in_array('Patient-Category', $this->pers)) {
                $info[] = array(
                    $i,
                    $pcategory->name,
                    $pcategory->description,
                    $pcategory->discount,
                    $status,
                    $options1 . ' ' . $options5,
                        //  $options2
                );
                $i = $i + 1;
            }
        }

        if (!empty($data['pcategorys'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('patient_category')->num_rows(),
                "recordsFiltered" => $this->db->get('patient_category')->num_rows(),
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

/* End of file pcategory.php */
/* Location: ./application/modules/pcategory/controllers/pcategory.php */
