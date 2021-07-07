<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notice extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('notice_model');
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
        if ($this->ion_auth->in_group(array('Receptionist', 'pharmacist'))) {
            redirect('home/permission');
        }
    }

    public function index() {
       
        $data['notices'] = $this->notice_model->getNotice();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('notice', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewView() {
        $data['notices'] = $this->notice_model->getNotice();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new');
        $this->load->view('home/footer'); // just the header file
    }

    public function addNew() {

        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $description = $this->input->post('description');
        $date = $this->input->post('date');
        if (!empty($date)) {
            $date = strtotime($date);
        } else {
            $date = time();
        }
        $type = $this->input->post('type');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Title Field
        $this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        // Validating Description Field
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        // Validating date Field
        $this->form_validation->set_rules('date', 'date', 'trim|required|min_length[5]|max_length[100]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect("notice/editNotice?id=$id");
            } else {
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_new');
                $this->load->view('home/footer'); // just the header file
            }
        } else {

            //$error = array('error' => $this->upload->display_errors());
            $data = array();
            $data = array(
                'title' => $title,
                'description' => $description,
                'date' => $date,
                'type' => $type
            );



            if (empty($id)) {     // Adding New Notice
                $this->notice_model->insertNotice($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else { // Updating Notice
                $this->notice_model->updateNotice($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            // Loading View
            redirect('notice');
        }
    }

    function getNotice() {
        $data['notices'] = $this->notice_model->getNotice();
        $this->load->view('notice', $data);
    }

    function editNotice() {
        $data = array();
        $id = $this->input->get('id');
        $data['notice'] = $this->notice_model->getNoticeById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editNoticeByJason() {
        $id = $this->input->get('id');
        $data['notice'] = $this->notice_model->getNoticeById($id);
        echo json_encode($data);
    }

    function delete() {
        $data = array();
        $id = $this->input->get('id');
        $this->notice_model->delete($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('notice');
    }

}

/* End of file notice.php */
/* Location: ./application/modules/notice/controllers/notice.php */
