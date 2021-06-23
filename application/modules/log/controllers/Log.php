<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Log extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('log_model');
        $this->load->model("settings/settings_model");
        if (!$this->ion_auth->in_group(array('admin'))) {
            redirect('home/permission');
        }
    }

    public function index() {

        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('log');
        $this->load->view('home/footer'); // just the header file  
    }

    function getLogList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        $order = $this->input->post("order");
        $columns_valid = array(
            "0" => "id",
            "3" => "name",
            "4" => "s_price",
            "6" => "quantity",
            "10" => "e_date",
        );
        $values = $this->settings_model->getColumnOrder($order, $columns_valid);
        $dir = $values[0];
        $order = $values[1];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['logs'] = $this->log_model->getLogBysearch($search, $order, $dir);
            } else {
                $data['logs'] = $this->log_model->getLog($order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['logs'] = $this->log_model->getLogByLimitBySearch($limit, $start, $search, $order, $dir);
            } else {
                $data['logs'] = $this->log_model->getLogByLimit($limit, $start, $order, $dir);
            }
        }

        $i = 0;


        foreach ($data['logs'] as $log) {
            $i = $i + 1;


            $info[] = array(
                $i,
                $log->user_email,
                $log->date_time,
                $log->action,
            );
        }

        if (!empty($data['logs'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('logs')->num_rows(),
                "recordsFiltered" => $this->db->get('logs')->num_rows(),
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
    