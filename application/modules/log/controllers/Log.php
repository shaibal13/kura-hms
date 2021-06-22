<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Log extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('log_model');
        $this->load->model('patient/patient_model');

        if (!$this->ion_auth->in_group(array('admin'))) {
            redirect('home/permission');
        }
    }

    public function index() {

        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('category');
        $this->load->view('home/footer'); // just the header file  
    }

}

/* End of file bed.php */
    /* Location: ./application/modules/bed/controllers/bed.php */
    