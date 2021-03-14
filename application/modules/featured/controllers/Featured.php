<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Featured extends MX_Controller {

    function __construct() {
        parent::__construct();


        $this->load->model('featured_model');
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
        if ($this->ion_auth->in_group(array('pharmacist', 'Receptionist', 'Laboratorist', 'Patient', 'Nurse', 'Doctor', 'Accountant'))) {
            redirect('home/permission');
        }
    }

    public function index() {
        if (!$this->ion_auth->in_group('admin')  && !in_array('Website', $this->pers)) {
            redirect('home/permission');
        }
        $data['featureds'] = $this->featured_model->getFeatured();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('featured', $data);
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
        $profile = $this->input->post('profile');
        $description = $this->input->post('description');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Profile Field
        $this->form_validation->set_rules('profile', 'Profile', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Description Field   
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[1]|max_length[500]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect("featured/editFeatured?id=$id");
            } else {
                $data['setval'] = 'setval';
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
                    'profile' => $profile,
                    'description' => $description,
                );
            } else {
                //$error = array('error' => $this->upload->display_errors());
                $data = array();
                $data = array(
                    'name' => $name,
                    'profile' => $profile,
                    'description' => $description,
                );
            }


            if (empty($id)) {     // Adding New Featured
                $this->featured_model->insertFeatured($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else { // Updating Featured
                $this->featured_model->updateFeatured($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            // Loading View
            redirect('featured');
        }
    }

    function getFeatured() {
        $data['featureds'] = $this->featured_model->getFeatured();
        $this->load->view('featured', $data);
    }

    function editFeatured() {
        $data = array();
        $id = $this->input->get('id');
        $data['featured'] = $this->featured_model->getFeaturedById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editFeaturedByJason() {
        $id = $this->input->get('id');
        $data['featured'] = $this->featured_model->getFeaturedById($id);
        echo json_encode($data);
    }

    function delete() {
        $data = array();
        $id = $this->input->get('id');
        $user_data = $this->db->get_where('featured', array('id' => $id))->row();
        $path = $user_data->img_url;

        if (!empty($path)) {
            unlink($path);
        }
        $ion_user_id = $user_data->ion_user_id;
        $this->db->where('id', $ion_user_id);
        $this->db->delete('users');
        $this->featured_model->delete($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('featured');
    }

}

/* End of file featured.php */
/* Location: ./application/modules/featured/controllers/featured.php */
