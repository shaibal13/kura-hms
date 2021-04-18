<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Surgery extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('finance/finance_model');
        $this->load->model('patient/patient_model');
        $this->load->model('category/category_model');
        $this->load->model('surgery_model');
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

        if ($this->ion_auth->in_group(array('Accountant', 'pharmacist'))) {
            redirect('home/permission');
        }
    }

    public function getTableTrValue() {
        $medical_analysis = $this->input->get('medical_analysis');

        $medical_analysis_details = $this->finance_model->getPaymentCategoryById($medical_analysis);
        //$packages = $this->packages_model->getPackagesById($package);
        $option2 = $option5 = " ";
//$category = $this->category_model->getCategoryById($medical_analysis_details->type);
        $option4 = '<select class="form-control js-example-basic-single" name="done_surgery[]"><option value="done">Done</option><option value="undone">Undone</option></select>';
        $option3 = '<input type="text" class="form-control  default-date-picker" name="date_to_done_surgery[]"  readonly>';
        if (!empty($medical_analysis_details)) {
            $option2 = '<button class="btn btn-info btn-xs btn_width delete_button" id="td-med-surgery-' . $medical_analysis_details->id . '"><i class="fa fa-trash"> </i></button>';
        }

        $option = '';
        if (!empty($medical_analysis_details)) {
            $option .= '<tr class="proccedure" id="tr-med-surgery-' . $medical_analysis_details->id . '"><td><input type="hidden" name="type_id_surgery[]" id="input_id-med-surgery-' . $medical_analysis_details->id . '" value="' . $medical_analysis_details->id . '" readonly><input type="text" class="input-category" name="type_surgery[]" id="input-med-surgery-' . $medical_analysis_details->id . '" value="' . $medical_analysis_details->category . '"readonly></td><td>' . lang('surgery') . ' <input type="hidden" name="from_surgery[]" class="from_where" value="Surgery"></td><td><input class="price-indivudual" type="text" name="price_surgery[]" style="width:100px;" id="price-surgery-' . $medical_analysis_details->id . '" value="' . $medical_analysis_details->c_price . '" ></td><td>' . $option3 . '</td><td>' . $option4 . '</td><td>' . $option2 . '</td></tr>';
        }

        $data['option'] = $option;
        echo json_encode($data);
    }

    function addSurgery() {
        $id = $this->input->post('id');
        $patient_id = $this->input->post('patient_id');

        $time_to_be_done = $this->input->post('time_to_be_done');

        $title = $this->input->post('title');
        $status = $this->input->post('status');
        if (empty($id)) {
            $date = time();
        }
        $from = $this->input->post('from_surgery[]');
        $length = count($from);
        $date_to_done = $this->input->post('date_to_done_surgery[]');
        $done = $this->input->post('done_surgery[]');
        $price = $this->input->post('price_surgery[]');
        $type_id = $this->input->post('type_id_surgery[]');
        $type = $this->input->post('type_surgery[]');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $redirect = $this->input->post('redirect');
        /* if (empty($redirect)) {
          $redirect = 'patient/medicalHistory?id=' . $patient_id;
          } */

// Validating Name Field
        $this->form_validation->set_rules('time_to_be_done', 'Date', 'trim|min_length[1]|max_length[100]|xss_clean');

// Validating Title Field
        $this->form_validation->set_rules('title', 'Title', 'trim|min_length[1]|max_length[100]|xss_clean');

// Validating Password Field
// $this->form_validation->set_rules('description', 'Description', 'trim|min_length[5]|max_length[10000]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect("surgery/editSurgery?id=$id");
            } else {
                $data['settings'] = $this->settings_model->getSettings();
                $data['patients'] = $this->patient_model->getPatient();
                //   $data['packages'] = $this->packages_model->getPackages();
                $data['payment_category'] = $this->finance_model->getPaymentCategory();
                $cat_update = '';
                foreach ($data['payment_category'] as $cat) {
                    $cat_name = strtolower($cat->category);
                    if ($cat_name == 'surgery') {
                        $cat_update = $cat->category;
                    }
                }
                if (!empty($cat_update)) {
                    $data['surgery_category'] = $this->finance_model->getPaymentCategoryBySurgery('Surgery');
                }
//   $data['medical_histories'] = $this->patient_model->getMedicalHistory();
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_new_surgery', $data);
                $this->load->view('home/footer'); // just the footer file
            }
        } else {

            if (!empty($patient_id)) {
                $patient_details = $this->patient_model->getPatientById($patient_id);
                $patient_name = $patient_details->name;
                $patient_phone = $patient_details->phone;
                $patient_address = $patient_details->address;
            } else {
                $patient_name = 0;
                $patient_phone = 0;
                $patient_address = 0;
            }

//$error = array('error' => $this->upload->display_errors());
            $array_price_cat = array();
            for ($i = 0; $i < $length; $i++) {
// $payment_category = $this->finance_model->getPaymentCategoryById($type_id[$i]);
// $cat = $this->category_model->getCategoryById($payment_category->type);
                $array_price_cat[] = $from[$i] . '**' . $type[$i] . '**' . $type_id[$i] . '**' . $price[$i] . '**' . $date_to_done[$i] . '**' . $done[$i];
            }
            $total = array_sum($price);
            $price_cat = implode("##", $array_price_cat);
            $data = array();
            $data = array(
                'patient_id' => $patient_id,
                //'date' => $date,
                'title' => $title,
                'time_to_be_done' => $time_to_be_done,
                'description' => $price_cat,
                'status' => $status,
                'patient_name' => $patient_name,
                'patient_phone' => $patient_phone,
                'patient_address' => $patient_address,
                'total_price' => $total,
                    // 'remarks' => $this->input->post('remarks')
            );
            $data_surgery = array();
            $data_surgery = array(
                'category_name' => $price_cat,
                'patient' => $patient_id,
                'amount' => $total,
                'discount' => '0',
                'flat_discount' => '0',
                'gross_total' => $total,
                'status' => 'unpaid',
                'hospital_amount' => $total,
                'doctor_amount' => '0',
                'user' => $this->ion_auth->get_user_id(),
                'patient_name' => $patient_details->name,
                'patient_phone' => $patient_details->phone,
                'patient_address' => $patient_details->address,
                // 'remarks' => $this->input->post('remarks'),
                'payment_from' => 'surgery',
                'case_status' => $status
            );
            if (empty($id)) {     // Adding New department
                $data['payment_status'] = 'unpaid';
                $data['date'] = $date;
                $data_surgery['status'] = 'unpaid';
                //  $data_case['case_status'] = $status;
                $data_surgery['date'] = time();


                $this->surgery_model->insertSurgery($data);
                $inserted_id_medical = $this->db->insert_id('surgery');
                $data_surgery['surgery_id'] = $inserted_id_medical;

                $this->finance_model->insertPayment($data_surgery);

                $inserted_id = $this->db->insert_id('payment');

                $data_up = array('payment_id' => $inserted_id);
                $this->surgery_model->updateSurgery($inserted_id_medical, $data_up);

                $this->session->set_flashdata('feedback', lang('added'));
            } else { // Updating department
                $medical_history = $this->surgery_model->getSurgeryById($id);
                $this->surgery_model->updateSurgery($id, $data);
                //$data_case['case_status'] = $status;
                $this->finance_model->updatePayment($medical_history->payment_id, $data_surgery);
                $this->session->set_flashdata('feedback', lang('updated'));
            }




            if ($redirect == 'surgery') {
                redirect('patient/medicalHistory?id=' . $patient_id);
            } elseif ($redirect == 'surgery_add') {
                redirect('surgery/addSurgeryView');
            }
// Loading View
//  redirect($redirect);
        }
    }

    function addSurgeryView() {
        $data['settings'] = $this->settings_model->getSettings();
        $data['patients'] = $this->patient_model->getPatient();
        //   $data['packages'] = $this->packages_model->getPackages();
        $data['categories_pay'] = $this->category_model->getCategory();
        $cat_update = '';
        foreach ($data['categories_pay'] as $cat) {
            $cat_name = strtolower($cat->name);
            if ($cat_name == 'surgery') {
                $cat_update = $cat->name;
            }
        }
        if (!empty($cat_update)) {
            $data['surgery_category'] = $this->finance_model->getPaymentCategoryBySurgery($cat_update);
        }

//   $data['medical_histories'] = $this->patient_model->getMedicalHistory();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new_surgery', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editSurgery() {
        $id = $this->input->get('id');
        $data['surgeries'] = $this->surgery_model->getSurgeryById($id);
        $data['settings'] = $this->settings_model->getSettings();
        $data['patients'] = $this->patient_model->getPatient();
        //   $data['packages'] = $this->packages_model->getPackages();
        $data['categories_pay'] = $this->category_model->getCategory();
        $cat_update = '';
        foreach ($data['categories_pay'] as $cat) {
            $cat_name = strtolower($cat->name);
            if ($cat_name == 'surgery') {
                $cat_update = $cat->name;
            }
        }
        if (!empty($cat_update)) {
            $data['surgery_category'] = $this->finance_model->getPaymentCategoryBySurgery($cat_update);
        }

//   $data['medical_histories'] = $this->patient_model->getMedicalHistory();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new_surgery', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function deleteSurgery() {
        $data = array();
        $id = $this->input->get('id');
        $user_data = $this->db->get_where('surgery', array('id' => $id))->row()->patient_id;

        $this->surgery_model->delete($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('patient/medicalHistory?id=' . $user_data);
    }

}
