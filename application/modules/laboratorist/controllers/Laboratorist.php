<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Laboratorist extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('laboratorist_model');
        $this->load->model('category/category_model');
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
        if ($this->ion_auth->in_group(array('pharmacist', 'Accountant', 'Doctor', 'Receptionist', 'Nurse', 'Laboratorist', 'Patient'))) {

            redirect('home/permission');
        }
    }

    public function index() {
        if (!$this->ion_auth->in_group('admin') && !in_array('Laboratorist', $this->pers)) {
            redirect('home/permission');
        }
        $data['laboratorists'] = $this->laboratorist_model->getLaboratorist();
        $data['categories'] = $this->category_model->getCategoryByStatus();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('laboratorist', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewView() {
        $data['categories'] = $this->category_model->getCategoryByStatus();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNew() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');
        $category = $this->input->post('category');
        $category_implode = implode("***", $category);
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        // Validating Password Field
        if (empty($id)) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        }
        // Validating Email Field
        $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        // Validating Address Field   
        $this->form_validation->set_rules('address', 'Address', 'trim|required|min_length[5]|max_length[500]|xss_clean');
        // Validating Phone Field           
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[5]|max_length[50]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $data = array();
                $data['laboratorist'] = $this->laboratorist_model->getLaboratoristById($id);
                $data['categories'] = $this->category_model->getCategoryByStatus();
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_new', $data);
                $this->load->view('home/footer'); // just the footer file
            } else {
                $data = array();
                $data['setval'] = 'setval';
                $data['categories'] = $this->category_model->getCategoryByStatus();
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_new', $data);
                $this->load->view('home/footer'); // just the header file
            }
        } else {
            $file_name = $_FILES['img_url']['name'];
            $file_name_pieces = explode('_', $file_name);
            $new_file_name = '';
            $count = 1;
            foreach ($file_name_pieces as $piece) {
                if ($count !== 1) {
                    $piece = ucfirst($piece);
                }

                $new_file_name .= $piece;
                $count++;
            }
            $config = array(
                'file_name' => $new_file_name,
                'upload_path' => "./uploads/",
                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                'overwrite' => False,
                'max_size' => "20480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "1768",
                'max_width' => "2024"
            );

            $this->load->library('Upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('img_url')) {
                $path = $this->upload->data();
                $img_url = "uploads/" . $path['file_name'];
                $data = array();
                $data = array(
                    'img_url' => $img_url,
                    'name' => $name,
                    'email' => $email,
                    'address' => $address,
                    'phone' => $phone,
                    'category' => $category_implode
                );
            } else {
                //$error = array('error' => $this->upload->display_errors());
                $data = array();
                $data = array(
                    'name' => $name,
                    'email' => $email,
                    'address' => $address,
                    'phone' => $phone,
                    'category' => $category_implode
                );
            }
            $username = $this->input->post('name');
            if (empty($id)) {     // Adding New laboratorist
                if ($this->ion_auth->email_check($email)) {
                    $this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
                    redirect('laboratorist/addNewView');
                } else {
                    $dfg = 8;
                    $this->ion_auth->register($username, $password, $email, $dfg);
                    $ion_user_id = $this->db->get_where('users', array('email' => $email))->row()->id;
                    $this->laboratorist_model->insertLaboratorist($data);
                    $laboratorist_user_id = $this->db->get_where('laboratorist', array('email' => $email))->row()->id;
                    $id_info = array('ion_user_id' => $ion_user_id);
                    $this->laboratorist_model->updateLaboratorist($laboratorist_user_id, $id_info);
                    $this->session->set_flashdata('feedback', lang('added'));
                }
            } else { // Updating laboratorist
                $ion_user_id = $this->db->get_where('laboratorist', array('id' => $id))->row()->ion_user_id;
                if (empty($password)) {
                    $password = $this->db->get_where('users', array('id' => $ion_user_id))->row()->password;
                } else {
                    $password = $this->ion_auth_model->hash_password($password);
                }
                $this->laboratorist_model->updateIonUser($username, $email, $password, $ion_user_id);
                $this->laboratorist_model->updateLaboratorist($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            // Loading View
            redirect('laboratorist');
        }
    }

    function getLaboratorist() {
        $data['laboratorists'] = $this->laboratorist_model->getLaboratorist();
        $this->load->view('laboratorist', $data);
    }

    function editLboratorist() {
        $data = array();
        $id = $this->input->get('id');
        $data['laboratorist'] = $this->laboratorist_model->getLaboratoristById($id);
        $data['categories'] = $this->category_model->getCategoryByStatus();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editLaboratoristByJason() {
        $id = $this->input->get('id');
        $data['laboratorist'] = $this->laboratorist_model->getLaboratoristById($id);
        echo json_encode($data);
    }

    function delete() {
        $data = array();
        $id = $this->input->get('id');
        $user_data = $this->db->get_where('laboratorist', array('id' => $id))->row();
        $path = $user_data->img_url;

        if (!empty($path)) {
            unlink($path);
        }
        $ion_user_id = $user_data->ion_user_id;
        $this->db->where('id', $ion_user_id);
        $this->db->delete('users');
        $this->laboratorist_model->delete($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('laboratorist');
    }

}

/* End of file laboratorist.php */
/* Location: ./application/modules/laboratorist/controllers/laboratorist.php */
