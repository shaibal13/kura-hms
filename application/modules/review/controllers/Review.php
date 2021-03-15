<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Review extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('frontend/frontend_model');
        $this->load->model('doctor/doctor_model');
        $this->load->model('patient/patient_model');
        $this->load->model('slide/slide_model');
        $this->load->model('service/service_model');
        $this->load->model('email/email_model');
        $this->load->model('featured/featured_model');
        $this->load->model('review/review_model');
        $language = $this->db->get('settings')->row()->language;
        $this->lang->load('system_syntax', $language);
    }
    
    public function index() {
        $data = array();
        $data['settings'] = $this->frontend_model->getSettings();
        $data['reviews'] = $this->review_model->getReview();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('reviews', $data);
        $this->load->view('home/footer'); // just the footer file
    }
    
    public function addNew() {
        
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $designation = $this->input->post('designation');
        $review = $this->input->post('review');
        $status = $this->input->post('status');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Text 1 Field
        $this->form_validation->set_rules('designation', 'Designation', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Text 2 Field
        $this->form_validation->set_rules('review', 'Review', 'trim|required|min_length[1]|max_length[1000]|xss_clean');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|min_length[1]|max_length[50]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect("review/editReview?id=$id");
            } else {
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_new');
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
                'max_height' => "10000",
                'max_width' => "10000"
            );

            $this->load->library('Upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('img_url')) {
                $path = $this->upload->data();
                $img_url = "uploads/" . $path['file_name'];
                $data = array();
                $data = array(
                    'img' => $img_url,
                    'name' => $name,
                    'designation' => $designation,
                    'review' => $review,
                    'status' => $status
                );
            } else {
                //$error = array('error' => $this->upload->display_errors());
                $data = array();
                $data = array(
                    'name' => $name,
                    'designation' => $designation,
                    'review' => $review,
                    'status' => $status
                );
            }

            //$username = $this->input->post('name');

            if (empty($id)) {     // Adding New Slide
                $this->review_model->insertReview($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else { // Updating Slide
                $this->review_model->updateReview($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            // Loading View
            redirect('review');
        }
        
    }
    
    function editReviewByJason() {
        $id = $this->input->get('id');
        $data['review'] = $this->review_model->getReviewById($id);
        echo json_encode($data);
    }
    
    function editReview() {
        $id = $this->input->get('id');
        $data['review'] = $this->review_model->getReviewById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the header file
    }
    
    function delete() {
        $id = $this->input->get('id');
        $user_data = $this->db->get_where('site_review', array('id' => $id))->row();
        $path = $user_data->img;
        if (!empty($path)) {
            unlink($path);
        }
        $this->review_model->deleteReview($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('review');
    }
}