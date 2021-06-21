<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Surgery extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('finance/finance_model');
        $this->load->model('patient/patient_model');
        $this->load->model('category/category_model');
        $this->load->model('packages/packages_model');
        $this->load->model('bed/bed_model');
        $this->load->model('medicine/medicine_model');
        $this->load->model('pservice/pservice_model');
        $this->load->model('nurse/nurse_model');
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
                'remarks' => $this->input->post('remarks')
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
                'remarks' => $this->input->post('remarks'),
                'payment_from' => 'surgery',
                'case_status' => $status
            );
            if (empty($id)) {     // Adding New department
                $data['payment_status'] = 'unpaid';
                $data['date'] = $date;
                $data_surgery['status'] = 'unpaid';
                //  $data_case['case_status'] = $status;
                $data_surgery['date'] = time();

                $data_surgery['date_string'] = date('d-m-Y', time());
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

    function surgeryDetails() {
        $id = $this->input->get('id');
        $data['surgeries'] = $this->surgery_model->getSurgeryById($id);
        $data['checkin'] = $this->surgery_model->getSurgeryCheckinById($data['surgeries']->id);
        $data['pre_surgery_medical_analysis'] = $this->surgery_model->getPreSurgeryMedicalAnalysisBySurgeryId($data['surgeries']->id);
        $data['bed_id'] = $this->bed_model->getBedByCategory($data['checkin']->category);
        foreach ($data['bed_id'] as $bed) {
            if ($bed->id == $data['checkin']->bed_id) {
                $option .= '<option value="' . $bed->id . '" selected>' . $bed->number . '</option>';
            } else {
                $option .= '<option value="' . $bed->id . '">' . $bed->number . '</option>';
            }
        }
        $data['option'] = $option;
        $data['patients'] = $this->patient_model->getPatientById($data['checkin']->patient);
        $data['room_no'] = $this->bed_model->getBedCategory();
        $data['packages'] = $this->packages_model->getPackages();
        $data['pservice'] = $this->pservice_model->getPserviceByActive();
        $data['pre_medical'] = $this->surgery_model->getPreSurgeryMedicalAnalysisBySurgeryIdAll($data['surgeries']->id);
        $data['post_medical'] = $this->surgery_model->getPostSurgeryMedicalAnalysisBySurgeryIdAll($data['surgeries']->id);
        $data['on_medical'] = $this->surgery_model->getOnSurgeryMedicalAnalysisBySurgeryIdAll($data['surgeries']->id);
        $data['daily_medicine_pre'] = $this->surgery_model->getMedicineForPreSurgery($data['surgeries']->id);
        $data['daily_medicine_on'] = $this->surgery_model->getMedicineForOnSurgery($data['surgeries']->id);
        $data['daily_service_pre'] = $this->surgery_model->getPreServiceBySurgeryId($data['surgeries']->id);
        $data['daily_medicine_post'] = $this->surgery_model->getMedicineForPostSurgery($data['surgeries']->id);
        $data['bed_checkout'] = $this->surgery_model->getCheckoutBySurgeryId($data['surgeries']->id);
        $date_exist = $this->surgery_model->getPreServicesByDate(date('d-m-Y', time()));
        if (!empty($date_exist)) {
            $data['checked'] = explode("**", $date_exist->service);
        } else {
            $data['checked'] = array();
        }
        $data['daily_service_on'] = $this->surgery_model->getOnServiceBySurgeryId($data['surgeries']->id);
        $date_exist_on = $this->surgery_model->getOnServicesByDate(date('d-m-Y', time()));
        if (!empty($date_exist_on)) {
            $data['checked_on'] = explode("**", $date_exist_on->service);
        } else {
            $data['checked_on'] = array();
        }
        $data['daily_service_post'] = $this->surgery_model->getPostServiceBySurgeryId($data['surgeries']->id);
        $date_exist_post = $this->surgery_model->getPostServicesByDate(date('d-m-Y', time()));
        if (!empty($date_exist_post)) {
            $data['checked_post'] = explode("**", $date_exist_post->service);
        } else {
            $data['checked_post'] = array();
        }

        $data['payment_category'] = $this->finance_model->getPaymentCategory();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('view_more', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function updateCheckin() {
        $id = $this->input->post('id');
        $category_status = $this->input->post('category_status');

        $category_status_update = implode(',', $category_status); //done

        $covid_19 = $this->input->post('covid_19'); //done
        $reaksione = $this->input->post('reaksione'); //done
        $transferred_from = $this->input->post('transferred_from'); //done
        $diagnoza_klinike = $this->input->post('diagnoza_klinike'); //done
        // $doctor = $this->input->post('doctor');
        $actual_illness = $this->input->post('actual_illness'); //done
        $addtional_illness = $this->input->post('addtional_illness'); //done
        $other_risk_factor = $this->input->post('other_risk_factor'); //done
        $diagnoza_pranimit = $this->input->post('diagnoza_pranimit'); //done
        $surgery_id = $this->input->post('surgery_id');
        $patient = $this->surgery_model->getSurgeryById($surgery_id)->patient_id;
        $category = $this->input->post('category'); //done
        // $patient = $this->input->post('patient'); //done
        $a_time = $this->input->post('a_time'); //done
        $diagnoza_imazherike = $this->input->post('diagnoza_imazherike'); //done
        $diagnoza_perfundimtare = $this->input->post('diagnoza_perfundimtare'); //done
        $bed_id = $this->input->post('bed_id'); //done

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Category Field
        $this->form_validation->set_rules('bed_id', 'Bed', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Patient Field
        //  $this->form_validation->set_rules('patient', 'Patient', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Alloted Time Field
        $this->form_validation->set_rules('a_time', 'Alloted Time', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Discharge Time Field
        // $this->form_validation->set_rules('d_time', 'Discharge Time', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Status Field
        //$this->form_validation->set_rules('status', 'Status', 'trim|min_length[1]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $id = $this->input->get('id');
            $data['surgeries'] = $this->surgery_model->getSurgeryById($id);
            $data['checkin'] = $this->surgery_model->getSurgeryCheckinById($data['surgeries']->id);
            $data['bed_id'] = $this->bed_model->getBedByCategory($data['checkin']->category);
            $option = '';
            foreach ($data['bed_id'] as $bed) {
                if ($bed->id == $data['checkin']->bed_id) {
                    $option .= '<option value="' . $bed->id . '" selected>' . $bed->number . '</option>';
                } else {
                    $option .= '<option value="' . $bed->id . '">' . $bed->number . '</option>';
                }
            }
            $data['option'] = $option;
            $data['room_no'] = $this->bed_model->getBedCategory();

            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('view_more', $data);
            $this->load->view('home/footer'); // just the footer file
        } else {
            $data = array();
            $patientname = $this->patient_model->getPatientById($patient)->name;
            $data = array(
                'bed_id' => $bed_id,
                'patient' => $patient,
                'a_time' => $a_time,
                'category' => $category,
                'category_status' => $category_status_update,
                'reaksione' => $reaksione,
                'covid_19' => $covid_19,
                'transferred_from' => $transferred_from,
                'diagnoza_klinike' => $diagnoza_klinike,
                'actual_illness' => $actual_illness,
                'addtional_illness' => $addtional_illness,
                'other_risk_factor' => $other_risk_factor,
                'diagnoza_pranimit' => $diagnoza_pranimit,
                'diagnoza_imazherike' => $diagnoza_imazherike,
                'diagnoza_perfundimtare' => $diagnoza_perfundimtare,
                'patientname' => $patientname,
                'surgery_id' => $surgery_id
            );

            $data1 = array(
                'last_a_time' => $a_time,
                    // 'last_d_time' => $d_time,
            );

            if (empty($id)) {
                // print_r($data);
                $this->surgery_model->insertSurgeryCheckin($data);
                $insert = $this->db->insert_id('surgery_checkin');

                $this->bed_model->updateBedByBedId($bed_id, $data1);
                $arr = array('message' => lang('added'), 'title' => lang('added'), 'inserted' => $insert);
                echo json_encode($arr);
            } else {
                $this->surgery_model->updateSurgeryCheckin($id, $data);
                $this->bed_model->updateBedByBedId($bed_id, $data1);
                // $arr['inserted']= $this->db->insert_id('surgery_checkin');
                $arr = array('message' => lang('updated'), 'title' => lang('updated'), 'inserted' => $id);
                echo json_encode($arr);
            }
        }
    }

    function preSurgeryMedicalAnalysisAdd() {
        $id = $this->input->post('id');
        $surgery_id = $this->input->post('surgery_id');
        $surgery = $this->surgery_model->getSurgeryById($surgery_id);
        $patient_id = $surgery->patient_id;

        //  $date = $this->input->post('date');

        $title = $this->input->post('title');
        $status = $this->input->post('status');
        /* if (!empty($date)) {
          $date = strtotime($date);
          } else {
          $date = time();
          } */
        $from = $this->input->post('from[]');
        $length = count($from);
        $date_to_done = $this->input->post('date_to_done[]');
        $done = $this->input->post('done[]');
        $price = $this->input->post('price[]');
        $type_id = $this->input->post('type_id[]');
        $type = $this->input->post('type[]');
        $total_discount = $this->input->post('total_discount');
        $grand_total = $this->input->post('grand_total');
        $discount_price = $this->input->post('discount_price[]');
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
        $array_price_cat = array();
        for ($i = 0; $i < $length; $i++) {
            $array_price_cat[] = $from[$i] . '**' . $type[$i] . '**' . $type_id[$i] . '**' . $price[$i] . '**' . $date_to_done[$i] . '**' . $done[$i] . '**' . $discount_price[$i];
        }
        $total = array_sum($price);
        $price_cat = implode("##", $array_price_cat);
        $data = array();
        $data = array(
            'patient_id' => $patient_id,
            //  'date' => $date,
            'title' => $title,
            'description' => $price_cat,
            'status' => $status,
            'patient_name' => $patient_name,
            'patient_phone' => $patient_phone,
            'patient_address' => $patient_address,
            'total_price' => $total,
            'remarks' => $this->input->post('remarks'),
            'grand_total' => $grand_total,
            'total_discount' => $total_discount,
            'surgery_id' => $surgery_id
        );
        $data_pre_medical_surgery = array();
        $data_pre_medical_surgery = array(
            'category_name' => $price_cat,
            'patient' => $patient_id,
            'amount' => $total,
            'discount' => $total_discount,
            'flat_discount' => '0',
            'gross_total' => $grand_total,
            'hospital_amount' => $grand_total,
            'doctor_amount' => '0',
            'user' => $this->ion_auth->get_user_id(),
            'patient_name' => $patient_name,
            'patient_phone' => $patient_phone,
            'patient_address' => $patient_address,
            'remarks' => $this->input->post('remarks'),
            'payment_from' => 'pre_surgery_medical_analysis',
            'case_status' => $status
        );
        $arr = array();
        if (empty($id)) {     // Adding New department
            $data['payment_status'] = 'unpaid';
            $data['date'] = time();
            $this->surgery_model->insertPreSurgeryMedicalAnalysis($data);
            $insert = $this->db->insert_id('pre_surgery_medical_analysis');
            $data_pre_medical_surgery['status'] = 'unpaid';
            $data_pre_medical_surgery['date'] = time();
            $data_pre_medical_surgery['pre_medical_surgery_id'] = $insert;
            $this->finance_model->insertPayment($data_pre_medical_surgery);
            $insert_payment = $this->db->insert_id('payment');
            $data_payment = array('payment_id' => $insert_payment);
            $this->surgery_model->updatePreSurgeryMedicalAnalysis($insert, $data_payment);
            $option_description = '';
            $descriptions = explode('##', $price_cat);
            foreach ($descriptions as $description) {
                $description_single = array();
                $description_single = explode('**', $description);
                if ($description_single[0] == 'Package_pre_surgery_medical') {
                    $option_description .= '<ul><li>' . lang('package') . '-' . $description_single[1] . '</li></ul>';
                } else {
                    $option_description .= '<ul><li>' . $description_single[1] . '</li></ul>';
                }
            }
            if ($data['status'] == 'Pending Confirmation') {
                $status = lang('pending_confirmation');
            } if ($data['status'] == 'Confirmed') {
                $status = lang('confirmed');
            }
            $option1 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton_pre_medical_surgery" data-toggle="modal" data-id="' . $insert . '"><i class="fa fa-edit"></i></button>';
            $option2 = '<a class="btn btn-success btn-xs btn_width" title="' . lang('invoice') . '" href="finance/invoice?id=' . $insert_payment . '" target="_blank"><i class="fa fa-file-invoice"></i></a>';
            $option3 = '<button class="btn btn-danger btn-xs btn_width delete_button_medical_pre" id="delete-pre-surgery-medical-' . $insert . '"><i class="fa fa-trash"> </i></button>';
            $option = '<tr id="table-' . $insert . '"><td>' . date('d-m-Y', $data['date']) . '</td><td>' . $data['title'] . '</td><td>' . $option_description . '</td><td>' . $status . '</td><td>' . $data['grand_total'] . '</td><td>' . $option1 . ' ' . $option2 . ' ' . $option3 . '</td></tr>';
            $arr = array('message' => lang('added'), 'title' => lang('added'), 'inserted' => $insert, 'option' => $option, 'how' => 'added');
            echo json_encode($arr);
        } else { // Updating department
            $this->surgery_model->updatePreSurgeryMedicalAnalysis($id, $data);

            $pre_surgery = $this->surgery_model->getPreSurgeryMedicalAnalysisById($id);
            $this->finance_model->updatePayment($pre_surgery->payment_id, $data_pre_medical_surgery);
            $insert = $id;
            $option_description = '';
            $descriptions = explode('##', $price_cat);
            foreach ($descriptions as $description) {
                $description_single = array();
                $description_single = explode('**', $description);
                if ($description_single[0] == 'Package_pre_surgery_medical') {
                    $option_description .= '<ul><li>' . lang('package') . '-' . $description_single[1] . '</li></ul>';
                } else {
                    $option_description .= '<ul><li>' . $description_single[1] . '</li></ul>';
                }
            }
            if ($data['status'] == 'Pending Confirmation') {
                $status = lang('pending_confirmation');
            } if ($data['status'] == 'Confirmed') {
                $status = lang('confirmed');
            }
            $option1 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton_pre_medical_surgery" data-toggle="modal" data-id="' . $insert . '"><i class="fa fa-edit"></i></button>';
            $option2 = '<a class="btn btn-success btn-xs btn_width" title="' . lang('invoice') . '" href="finance/invoice?id=' . $pre_surgery->payment_id . '" target="_blank"><i class="fa fa-file-invoice"></i></a>';
            $option3 = '<button class="btn btn-danger btn-xs btn_width delete_button_medical_pre" id="delete-pre-surgery-medical-' . $insert . '"><i class="fa fa-trash"> </i></button>';
            $option = '<tr id="table-' . $insert . '"><td>' . date('d-m-Y', $pre_surgery->date) . '</td><td>' . $data['title'] . '</td><td>' . $option_description . '</td><td>' . $status . '</td><td>' . $data['grand_total'] . '</td><td>' . $option1 . ' ' . $option2 . ' ' . $option3 . '</td></tr>';
            $arr = array('message' => lang('updated'), 'title' => lang('updated'), 'inserted' => $insert, 'option' => $option, 'how' => 'updated');
            echo json_encode($arr);
        }
    }

    public function getTableTrValueForPreSurgeryMedicalAnalysis() {
        $medical_analysis = $this->input->get('medical_analysis');
        $package = $this->input->get('package');
        $medical_analysis_details = $this->finance_model->getPaymentCategoryById($medical_analysis);
        $packages = $this->packages_model->getPackagesById($package);
        $option2 = $option5 = " ";
//$category = $this->category_model->getCategoryById($medical_analysis_details->type);
        $option4 = '<select class="form-control js-example-basic-single" name="done[]"><option value="done">Done</option><option value="undone">Undone</option></select>';
        $option3 = '<input type="text" class="form-control  default-date-picker" name="date_to_done[]"  readonly>';
        if (!empty($medical_analysis_details) && $this->ion_auth->in_group(array('admin'))) {
            $option2 = '<button class="btn btn-info btn-xs btn_width delete_button" id="td-med-' . $medical_analysis_details->id . '"><i class="fa fa-trash"> </i></button>';
        }
        if (!empty($packages) && $this->ion_auth->in_group(array('admin'))) {
            $option5 = '<button class="btn btn-info btn-xs btn_width delete_button" id="td-pack-' . $packages->id . '"><i class="fa fa-trash"> </i></button>';
        }
        $option = '';
        if (!empty($medical_analysis_details)) {
            $option .= '<tr class="proccedure" id="tr-med-' . $medical_analysis_details->id . '"><td><input type="hidden" name="type_id[]" id="input_id-med-' . $medical_analysis_details->id . '" value="' . $medical_analysis_details->id . '" readonly><input type="text" class="input-category" name="type[]" id="input-med-' . $medical_analysis_details->id . '" value="' . $medical_analysis_details->category . '"readonly></td><td>' . lang('medical_analysis') . ' <input type="hidden" name="from[]" class="from_where" value="MedicalAnalysis_pre_surgery"></td><td><input class="price-indivudual" type="text" name="price[]" style="width:100px;" id="price-' . $medical_analysis_details->id . '" value="' . $medical_analysis_details->c_price . '" readonly></td><td><input class="discount-price-indivudual" type="number" min="0" name="discount_price[]" style="width:100px;" id="discount-price-' . $medical_analysis_details->id . '" value="0" ></td><td>' . $option3 . '</td><td>' . $option4 . '</td><td>' . $option2 . '</td></tr>';
        }
        if (!empty($packages)) {
            $option .= '<tr class="proccedure" id="tr-pack-' . $packages->id . '"><td><input type="hidden" name="type_id[]" id="input_id-pack-' . $packages->id . '" value="' . $packages->id . '" readonly><input type="text" class="input-category" name="type[]" id="input-pack-' . $packages->id . '" value="' . $packages->name . '"readonly></td><td>' . lang('package') . '<input type="hidden" class="from_where" name="from[]" value="Package_pre_surgery_medical"></td><td><input class="price-indivudual" type="text" name="price[]" style="width:100px;" id="price-' . $packages->id . '" value="' . $packages->single_price . '" readonly ></td><td><input class="discount-price-indivudual" type="number" min="0" name="discount_price[]" style="width:100px;" id="discount-price-' . $packages->id . '" value="0" ></td><td>' . $option3 . '</td><td>' . $option4 . '</td><td>' . $option5 . '</td></tr>';
        }
        $data['option'] = $option;
        echo json_encode($data);
    }

    function editPreMedicalSurgery() {
        $id = $this->input->get('id');
        $data = array();
        $data['surgery_pre'] = $this->surgery_model->getPreSurgeryMedicalAnalysisById($id);
        $cat_price = explode("##", $data['surgery_pre']->description);
        $option = '';

        foreach ($cat_price as $cat_individual) {

            $individual = array();
            $individual = explode("**", $cat_individual);
            if ($individual[5] == 'done') {
                $select = ' <select class="form-control js-example-basic-single" name="done[]">' .
                        '<option value="done" selected>Done</option>' .
                        '<option value="undone">Undone</option>' .
                        '</select>';
            } else {
                $select = ' <select class="form-control js-example-basic-single" name="done[]">' .
                        '<option value="done" >Done</option>'
                        . '<option value="undone" selected>Undone</option>' .
                        '</select>';
            }

            if ($individual[0] == 'Package_pre_surgery_medical') {
                if ($this->ion_auth->in_group(array('admin'))) {
                    $delete_buton = '<button class="btn btn-info btn-xs btn_width delete_button" id="td-pack-' . $individual[2] . '"><i class="fa fa-trash"> </i></button>';
                } else {
                    $delete_buton = '';
                }
                $option .= '<tr class="proccedure" id="tr-pack-' . $individual[2] . '"><td><input type="hidden" name="type_id[]" id="input_id-pack-' . $individual[2] . '" value="' . $individual[2] . '" readonly><input type="text" class="input-category" name="type[]" id="input-pack-' . $individual[1] . '" value="' . $individual[1] . '">' .
                        '</td><td>' . lang('package') . '<input type="hidden" name="from[]" class="from_where" value="Package_pre_surgery_medical">' .
                        ' </td><td><input class="price-indivudual" type="text" name="price[]" style="width:100px;" id="price-' . $individual[2] . '" value="' . $individual[3] . '" readonly>' .
                        '</td><td><input class="discount-price-indivudual" type="number" min="0" name="discount_price[]" style="width:100px;" id="discount-price-' . $individual[2] . '" value="' . $individual[6] . '" >' .
                        '</td><td><input type="text" class="form-control  default-date-picker" name="date_to_done[]" value="' . $individual[4] . ' " readonly></td><td>' . $select . '</td><td>' . $delete_buton . '</td></tr>';
            } else {
                if ($this->ion_auth->in_group(array('admin'))) {
                    $delete_buton = '<button class="btn btn-info btn-xs btn_width delete_button" id="td-med-' . $individual[2] . '"><i class="fa fa-trash"> </i></button>';
                } else {
                    $delete_buton = '';
                }
                $option .= '<tr class="proccedure" id="tr-med-' . $individual[2] . '"><td><input type="hidden" name="type_id[]" id="input_id-med-' . $individual[2] . '" value="' . $individual[2] . '" readonly><input type="text" class="input-category" name="type[]" id="input-med-' . $individual[1] . '" value="' . $individual[1] . '">' .
                        '</td><td>' . lang('medical_analysis') . '<input type="hidden" name="from[]" class="from_where" value="MedicalAnalysis_pre_surgery">' .
                        '</td><td><input class="price-indivudual" type="text" name="price[]" style="width:100px;" id="price-' . $individual[2] . '" value="' . $individual[3] . '" readonly="" >' .
                        '</td>  <td><input class="discount-price-indivudual" type="number" min="0" name="discount_price[]" style="width:100px;" id="discount-price-' . $individual[2] . '" value="' . $individual[6] . '" ></td>' .
                        '<td><input type="text" class="form-control  default-date-picker" name="date_to_done[]" value="' . $individual[4] . '" readonly></td><td>' . $select . '</td><td>' . $delete_buton . '</td></tr>';
            }
        }
        $data['option'] = $option;
        $dara['edited'] = '1';
        $data['message'] = array('message' => lang('updated'), 'title' => lang('updated'));
        echo json_encode($data);
    }

    function deletePreMedicalSurgery() {
        $id = $this->input->get('id');
        $this->surgery_model->deletePreMedicalSurgery($id);
        $arr = array('message' => lang('deleted'), 'title' => lang('deleted'));
        echo json_encode($arr);
    }

    function onSurgeryMedicalAnalysisAdd() {
        $id = $this->input->post('id');
        $surgery_id = $this->input->post('surgery_id');
        $surgery = $this->surgery_model->getSurgeryById($surgery_id);
        $patient_id = $surgery->patient_id;

        //  $date = $this->input->post('date');

        $title = $this->input->post('title');
        $status = $this->input->post('status');
        /* if (!empty($date)) {
          $date = strtotime($date);
          } else {
          $date = time();
          } */
        $from = $this->input->post('from[]');
        $length = count($from);
        $date_to_done = $this->input->post('date_to_done[]');
        $done = $this->input->post('done[]');
        $price = $this->input->post('price_on[]');
        $type_id = $this->input->post('type_id[]');
        $type = $this->input->post('type[]');
        $total_discount = $this->input->post('total_discount');
        $grand_total = $this->input->post('grand_total');
        $discount_price = $this->input->post('discount_price_on[]');
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
        $array_price_cat = array();
        for ($i = 0; $i < $length; $i++) {
            $array_price_cat[] = $from[$i] . '**' . $type[$i] . '**' . $type_id[$i] . '**' . $price[$i] . '**' . $date_to_done[$i] . '**' . $done[$i] . '**' . $discount_price[$i];
        }
        $total = array_sum($price);
        $price_cat = implode("##", $array_price_cat);
        $data = array();
        $data = array(
            'patient_id' => $patient_id,
            //  'date' => $date,
            'title' => $title,
            'description' => $price_cat,
            'status' => $status,
            'patient_name' => $patient_name,
            'patient_phone' => $patient_phone,
            'patient_address' => $patient_address,
            'total_price' => $total,
            'remarks' => $this->input->post('remarks'),
            'grand_total' => $grand_total,
            'total_discount' => $total_discount,
            'surgery_id' => $surgery_id
        );
        /*  $data_pre_medical_surgery = array();
          $data_pre_medical_surgery = array(
          'category_name' => $price_cat,
          'patient' => $patient_id,
          'amount' => $total,
          'discount' => $total_discount,
          'flat_discount' => '0',
          'gross_total' => $grand_total,

          'hospital_amount' => $grand_total,
          'doctor_amount' => '0',
          'user' => $this->ion_auth->get_user_id(),
          'patient_name' => $patient_name,
          'patient_phone' => $patient_phone,
          'patient_address' => $patient_address,
          'remarks' => $this->input->post('remarks'),
          'payment_from' => 'pre_surgery_medical_analysis',
          'case_status' => $status
          ); */
        if (empty($id)) {     // Adding New department
            //  $data['payment_status'] = 'unpaid';
            $data['date'] = time();
            $this->surgery_model->insertOnSurgeryMedicalAnalysis($data);
            $insert = $this->db->insert_id('on_surgery_medical_analysis');
            //   $data_pre_medical_surgery['status']= 'unpaid';
            //  $data_pre_medical_surgery['date']= time();
            //  $data_pre_medical_surgery['pre_medical_surgery_id']= $insert;
            //  $this->finance_model->insertPayment($data_pre_medical_surgery);
            //   $insert_payment = $this->db->insert_id('payment');
            //  $data_payment=array('payment_id'=>$insert_payment);
            //   $this->surgery_model->updatePreSurgeryMedicalAnalysis($insert,$data_payment);
            $option_description = '';
            $descriptions = explode('##', $price_cat);
            foreach ($descriptions as $description) {
                $description_single = array();
                $description_single = explode('**', $description);
                if ($description_single[0] == 'Package_on_surgery_medical') {
                    $option_description .= '<ul><li>' . lang('package') . '-' . $description_single[1] . '</li></ul>';
                } else {
                    $option_description .= '<ul><li>' . $description_single[1] . '</li></ul>';
                }
            }
            if ($data['status'] == 'Pending Confirmation') {
                $status = lang('pending_confirmation');
            } if ($data['status'] == 'Confirmed') {
                $status = lang('confirmed');
            }
            $option1 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton_on_medical_surgery" data-toggle="modal" data-id="' . $insert . '"><i class="fa fa-edit"></i></button>';
            //  $option2 = '<a class="btn btn-success btn-xs btn_width" title="' . lang('invoice') . '" href="finance/invoice?id=' . $insert_payment . '" target="_blank"><i class="fa fa-file-invoice"></i></a>';
            $option3 = '<button class="btn btn-danger btn-xs btn_width delete_button_medical_on" id="delete-on-surgery-medical-' . $insert . '"><i class="fa fa-trash"> </i></button>';
            $option = '<tr id="table--on-' . $insert . '"><td>' . date('d-m-Y', $data['date']) . '</td><td>' . $data['title'] . '</td><td>' . $option_description . '</td><td>' . $status . '</td><td>' . $data['grand_total'] . '</td><td>' . $option1 . ' ' . $option3 . '</td></tr>';
            $arr = array('message' => lang('added'), 'title' => lang('added'), 'inserted' => $insert, 'option' => $option, 'how' => 'added');
            echo json_encode($arr);
        } else { // Updating department
            $this->surgery_model->updatePreSurgeryMedicalAnalysis($id, $data);

            //$pre_surgery = $this->surgery_model->getPreSurgeryMedicalAnalysisById($id);
            // $this->finance_model->updatePayment($pre_surgery->payment_id,$data_pre_medical_surgery);
            $insert = $id;
            $option_description = '';
            $descriptions = explode('##', $price_cat);
            foreach ($descriptions as $description) {
                $description_single = array();
                $description_single = explode('**', $description);
                if ($description_single[0] == 'Package_on_surgery_medical') {
                    $option_description .= '<ul><li>' . lang('package') . '-' . $description_single[1] . '</li></ul>';
                } else {
                    $option_description .= '<ul><li>' . $description_single[1] . '</li></ul>';
                }
            }
            if ($data['status'] == 'Pending Confirmation') {
                $status = lang('pending_confirmation');
            } if ($data['status'] == 'Confirmed') {
                $status = lang('confirmed');
            }
            $option1 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton_on_medical_surgery" data-toggle="modal" data-id="' . $insert . '"><i class="fa fa-edit"></i></button>';
            //  $option2 = '<a class="btn btn-success btn-xs btn_width" title="' . lang('invoice') . '" href="finance/invoice?id=' . $pre_surgery->payment_id . '" target="_blank"><i class="fa fa-file-invoice"></i></a>';
            $option3 = '<button class="btn btn-danger btn-xs btn_width delete_button_medical_on" id="delete-on-surgery-medical-' . $insert . '"><i class="fa fa-trash"> </i></button>';
            $option = '<tr id="table-on-' . $insert . '"><td>' . date('d-m-Y', $pre_surgery->date) . '</td><td>' . $data['title'] . '</td><td>' . $option_description . '</td><td>' . $status . '</td><td>' . $data['grand_total'] . '</td><td>' . $option1 . ' ' . $option2 . ' ' . $option3 . '</td></tr>';
            $arr = array('message' => lang('updated'), 'title' => lang('updated'), 'inserted' => $insert, 'option' => $option, 'how' => 'updated');
            echo json_encode($arr);
        }
    }

    public function getTableTrValueForOnSurgeryMedicalAnalysis() {
        $medical_analysis = $this->input->get('medical_analysis');
        $package = $this->input->get('package');
        $medical_analysis_details = $this->finance_model->getPaymentCategoryById($medical_analysis);
        $packages = $this->packages_model->getPackagesById($package);
        $option2 = $option5 = " ";
//$category = $this->category_model->getCategoryById($medical_analysis_details->type);
        $option4 = '<select class="form-control js-example-basic-single" name="done[]"><option value="done">Done</option><option value="undone">Undone</option></select>';
        $option3 = '<input type="text" class="form-control  default-date-picker" name="date_to_done[]"  readonly>';
        if (!empty($medical_analysis_details) && $this->ion_auth->in_group(array('admin'))) {
            $option2 = '<button class="btn btn-info btn-xs btn_width delete_button" id="td-med-' . $medical_analysis_details->id . '"><i class="fa fa-trash"> </i></button>';
        }
        if (!empty($packages) && $this->ion_auth->in_group(array('admin'))) {
            $option5 = '<button class="btn btn-info btn-xs btn_width delete_button" id="td-pack-' . $packages->id . '"><i class="fa fa-trash"> </i></button>';
        }
        $option = '';
        if (!empty($medical_analysis_details)) {
            $option .= '<tr class="proccedure" id="tr-med-' . $medical_analysis_details->id . '"><td><input type="hidden" name="type_id[]" id="input_id-med-' . $medical_analysis_details->id . '" value="' . $medical_analysis_details->id . '" readonly><input type="text" class="input-category" name="type[]" id="input-med-' . $medical_analysis_details->id . '" value="' . $medical_analysis_details->category . '"readonly></td><td>' . lang('medical_analysis') . ' <input type="hidden" name="from[]" class="from_where" value="MedicalAnalysis_on_surgery"></td><td><input class="price-indivudual" type="text" name="price_on[]" style="width:100px;" id="price-' . $medical_analysis_details->id . '" value="' . $medical_analysis_details->c_price . '" readonly></td><td><input class="discount-price-indivudual" type="number" min="0" name="discount_price_on[]" style="width:100px;" id="discount-price-' . $medical_analysis_details->id . '" value="0" ></td><td>' . $option3 . '</td><td>' . $option4 . '</td><td>' . $option2 . '</td></tr>';
        }
        if (!empty($packages)) {
            $option .= '<tr class="proccedure" id="tr-pack-' . $packages->id . '"><td><input type="hidden" name="type_id[]" id="input_id-pack-' . $packages->id . '" value="' . $packages->id . '" readonly><input type="text" class="input-category" name="type[]" id="input-pack-' . $packages->id . '" value="' . $packages->name . '"readonly></td><td>' . lang('package') . '<input type="hidden" class="from_where" name="from[]" value="Package_on_surgery_medical"></td><td><input class="price-indivudual" type="text" name="price_on[]" style="width:100px;" id="price-' . $packages->id . '" value="' . $packages->single_price . '" readonly ></td><td><input class="discount-price-indivudual" type="number" min="0" name="discount_price_on[]" style="width:100px;" id="discount-price-' . $packages->id . '" value="0" ></td><td>' . $option3 . '</td><td>' . $option4 . '</td><td>' . $option5 . '</td></tr>';
        }
        $data['option'] = $option;
        echo json_encode($data);
    }

    function editOnMedicalSurgery() {
        $id = $this->input->get('id');
        $data['surgery_pre'] = $this->surgery_model->getOnSurgeryMedicalAnalysisById($id);
        $cat_price = explode("##", $data['surgery_pre']->description);
        $option = '';
        foreach ($cat_price as $cat_individual) {

            $individual = array();
            $individual = explode("**", $cat_individual);
            if ($individual[5] == 'done') {
                $select = ' <select class="form-control js-example-basic-single" name="done[]">' .
                        '<option value="done" selected>Done</option>' .
                        '<option value="undone">Undone</option>' .
                        '</select>';
            } else {
                $select = ' <select class="form-control js-example-basic-single" name="done[]">' .
                        '<option value="done" >Done</option>'
                        . '<option value="undone" selected>Undone</option>' .
                        '</select>';
            }

            if ($individual[0] == 'Package_on_surgery_medical') {
                if ($this->ion_auth->in_group(array('admin'))) {
                    $delete_buton = '<button class="btn btn-info btn-xs btn_width delete_button" id="td-pack-' . $individual[2] . '"><i class="fa fa-trash"> </i></button>';
                } else {
                    $delete_buton = '';
                }
                $option .= '<tr class="proccedure" id="tr-pack-' . $individual[2] . '"><td><input type="hidden" name="type_id[]" id="input_id-pack-' . $individual[2] . '" value="' . $individual[2] . '" readonly><input type="text" class="input-category" name="type[]" id="input-pack-' . $individual[1] . '" value="' . $individual[1] . '">' .
                        '</td><td>' . lang('package') . '<input type="hidden" name="from[]" class="from_where" value="Package_on_surgery_medical">' .
                        ' </td><td><input class="price-indivudual" type="text" name="price_on[]" style="width:100px;" id="price-' . $individual[2] . '" value="' . $individual[3] . '" readonly>' .
                        '</td><td><input class="discount-price-indivudual" type="number" min="0" name="discount_price_on[]" style="width:100px;" id="discount-price-' . $individual[2] . '" value="' . $individual[6] . '" >' .
                        '</td><td><input type="text" class="form-control  default-date-picker" name="date_to_done[]" value="' . $individual[4] . ' " readonly></td><td>' . $select . '</td><td>' . $delete_buton . '</td></tr>';
            } else {
                if ($this->ion_auth->in_group(array('admin'))) {
                    $delete_buton = '<button class="btn btn-info btn-xs btn_width delete_button" id="td-med-' . $individual[2] . '"><i class="fa fa-trash"> </i></button>';
                } else {
                    $delete_buton = '';
                }
                $option .= '<tr class="proccedure" id="tr-med-' . $individual[2] . '"><td><input type="hidden" name="type_id[]" id="input_id-med-' . $individual[2] . '" value="' . $individual[2] . '" readonly><input type="text" class="input-category" name="type[]" id="input-med-' . $individual[1] . '" value="' . $individual[1] . '">' .
                        '</td><td>' . lang('medical_analysis') . '<input type="hidden" name="from[]" class="from_where" value="MedicalAnalysis_on_surgery">' .
                        '</td><td><input class="price-indivudual" type="text" name="price_on[]" style="width:100px;" id="price-' . $individual[2] . '" value="' . $individual[3] . '" readonly="" >' .
                        '</td>  <td><input class="discount-price-indivudual" type="number" min="0" name="discount_price_on[]" style="width:100px;" id="discount-price-' . $individual[2] . '" value="' . $individual[6] . '" ></td>' .
                        '<td><input type="text" class="form-control  default-date-picker" name="date_to_done[]" value="' . $individual[4] . '" readonly></td><td>' . $select . '</td><td>' . $delete_buton . '</td></tr>';
            }
        }
        $data['option'] = $option;
        $dara['edited'] = '1';
        $data['message'] = array('message' => lang('updated'), 'title' => lang('updated'));
        echo json_encode($data);
    }

    function deleteOnMedicalSurgery() {
        $id = $this->input->get('id');
        $this->surgery_model->deleteOnMedicalSurgery($id);
        $arr = array('message' => lang('deleted'), 'title' => lang('deleted'));
        echo json_encode($arr);
    }

    function postSurgeryMedicalAnalysisAdd() {
        $id = $this->input->post('id');
        $surgery_id = $this->input->post('surgery_id');
        $surgery = $this->surgery_model->getSurgeryById($surgery_id);
        $patient_id = $surgery->patient_id;

        //  $date = $this->input->post('date');

        $title = $this->input->post('title');
        $status = $this->input->post('status');
        /* if (!empty($date)) {
          $date = strtotime($date);
          } else {
          $date = time();
          } */
        $from = $this->input->post('from[]');
        $length = count($from);
        $date_to_done = $this->input->post('date_to_done[]');
        $done = $this->input->post('done[]');
        $price = $this->input->post('price_post[]');
        $type_id = $this->input->post('type_id[]');
        $type = $this->input->post('type[]');
        $total_discount = $this->input->post('total_discount');
        $grand_total = $this->input->post('grand_total');
        $discount_price = $this->input->post('discount_price_post[]');
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
        $array_price_cat = array();
        for ($i = 0; $i < $length; $i++) {
            $array_price_cat[] = $from[$i] . '**' . $type[$i] . '**' . $type_id[$i] . '**' . $price[$i] . '**' . $date_to_done[$i] . '**' . $done[$i] . '**' . $discount_price[$i];
        }
        $total = array_sum($price);
        $price_cat = implode("##", $array_price_cat);
        $data = array();
        $data = array(
            'patient_id' => $patient_id,
            //  'date' => $date,
            'title' => $title,
            'description' => $price_cat,
            'status' => $status,
            'patient_name' => $patient_name,
            'patient_phone' => $patient_phone,
            'patient_address' => $patient_address,
            'total_price' => $total,
            'remarks' => $this->input->post('remarks'),
            'grand_total' => $grand_total,
            'total_discount' => $total_discount,
            'surgery_id' => $surgery_id
        );
        $data_post_medical_surgery = array();
        $data_post_medical_surgery = array(
            'category_name' => $price_cat,
            'patient' => $patient_id,
            'amount' => $total,
            'discount' => $total_discount,
            'flat_discount' => '0',
            'gross_total' => $grand_total,
            'hospital_amount' => $grand_total,
            'doctor_amount' => '0',
            'user' => $this->ion_auth->get_user_id(),
            'patient_name' => $patient_name,
            'patient_phone' => $patient_phone,
            'patient_address' => $patient_address,
            'remarks' => $this->input->post('remarks'),
            'payment_from' => 'post_surgery_medical_analysis',
            'case_status' => $status
        );
        $arr = array();
        if (empty($id)) {     // Adding New department
            $data['payment_status'] = 'unpaid';
            $data['date'] = time();
            $this->surgery_model->insertPostSurgeryMedicalAnalysis($data);
            $insert = $this->db->insert_id('post_surgery_medical_analysis');
            $data_post_medical_surgery['status'] = 'unpaid';
            $data_post_medical_surgery['date'] = time();
            $data_post_medical_surgery['post_medical_surgery_id'] = $insert;
            $this->finance_model->insertPayment($data_post_medical_surgery);
            $insert_payment = $this->db->insert_id('payment');
            $data_payment = array('payment_id' => $insert_payment);
            $this->surgery_model->updatePostSurgeryMedicalAnalysis($insert, $data_payment);
            $option_description = '';
            $descriptions = explode('##', $price_cat);
            foreach ($descriptions as $description) {
                $description_single = array();
                $description_single = explode('**', $description);
                if ($description_single[0] == 'Package_post_surgery_medical') {
                    $option_description .= '<ul><li>' . lang('package') . '-' . $description_single[1] . '</li></ul>';
                } else {
                    $option_description .= '<ul><li>' . $description_single[1] . '</li></ul>';
                }
            }
            if ($data['status'] == 'Pending Confirmation') {
                $status = lang('pending_confirmation');
            } if ($data['status'] == 'Confirmed') {
                $status = lang('confirmed');
            }
            $option1 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton_post_medical_surgery" data-toggle="modal" data-id="' . $insert . '"><i class="fa fa-edit"></i></button>';
            $option2 = '<a class="btn btn-success btn-xs btn_width" title="' . lang('invoice') . '" href="finance/invoice?id=' . $insert_payment . '" target="_blank"><i class="fa fa-file-invoice"></i></a>';
            $option3 = '<button class="btn btn-danger btn-xs btn_width delete_button_medical_post" id="delete-post-surgery-medical-' . $insert . '"><i class="fa fa-trash"> </i></button>';
            $option = '<tr id="table-post-' . $insert . '"><td>' . date('d-m-Y', $data['date']) . '</td><td>' . $data['title'] . '</td><td>' . $option_description . '</td><td>' . $status . '</td><td>' . $data['grand_total'] . '</td><td>' . $option1 . ' ' . $option2 . ' ' . $option3 . '</td></tr>';
            $arr = array('message' => lang('added'), 'title' => lang('added'), 'inserted' => $insert, 'option' => $option, 'how' => 'added');
            echo json_encode($arr);
        } else { // Updating department
            $this->surgery_model->updatePostSurgeryMedicalAnalysis($id, $data);

            $post_surgery = $this->surgery_model->getPostSurgeryMedicalAnalysisById($id);
            $this->finance_model->updatePayment($post_surgery->payment_id, $data_post_medical_surgery);
            $insert = $id;
            $option_description = '';
            $descriptions = explode('##', $price_cat);
            foreach ($descriptions as $description) {
                $description_single = array();
                $description_single = explode('**', $description);
                if ($description_single[0] == 'Package_post_surgery_medical') {
                    $option_description .= '<ul><li>' . lang('package') . '-' . $description_single[1] . '</li></ul>';
                } else {
                    $option_description .= '<ul><li>' . $description_single[1] . '</li></ul>';
                }
            }
            if ($data['status'] == 'Pending Confirmation') {
                $status = lang('pending_confirmation');
            } if ($data['status'] == 'Confirmed') {
                $status = lang('confirmed');
            }
            $option1 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton_post_medical_surgery" data-toggle="modal" data-id="' . $insert . '"><i class="fa fa-edit"></i></button>';
            $option2 = '<a class="btn btn-success btn-xs btn_width" title="' . lang('invoice') . '" href="finance/invoice?id=' . $post_surgery->payment_id . '" target="_blank"><i class="fa fa-file-invoice"></i></a>';
            $option3 = '<button class="btn btn-danger btn-xs btn_width delete_button_medical_post" id="delete-post-surgery-medical-' . $insert . '"><i class="fa fa-trash"> </i></button>';
            $option = '<tr id="table-post-' . $insert . '"><td>' . date('d-m-Y', $post_surgery->date) . '</td><td>' . $data['title'] . '</td><td>' . $option_description . '</td><td>' . $status . '</td><td>' . $data['grand_total'] . '</td><td>' . $option1 . ' ' . $option2 . ' ' . $option3 . '</td></tr>';
            $arr = array('message' => lang('updated'), 'title' => lang('updated'), 'inserted' => $insert, 'option' => $option, 'how' => 'updated');
            echo json_encode($arr);
        }
    }

    public function getTableTrValueForPostSurgeryMedicalAnalysis() {
        $medical_analysis = $this->input->get('medical_analysis');
        $package = $this->input->get('package');
        $medical_analysis_details = $this->finance_model->getPaymentCategoryById($medical_analysis);
        $packages = $this->packages_model->getPackagesById($package);
        $option2 = $option5 = " ";
//$category = $this->category_model->getCategoryById($medical_analysis_details->type);
        $option4 = '<select class="form-control js-example-basic-single" name="done[]"><option value="done">Done</option><option value="undone">Undone</option></select>';
        $option3 = '<input type="text" class="form-control  default-date-picker" name="date_to_done[]"  readonly>';
        if (!empty($medical_analysis_details) && $this->ion_auth->in_group(array('admin'))) {
            $option2 = '<button class="btn btn-info btn-xs btn_width delete_button" id="td-med-' . $medical_analysis_details->id . '"><i class="fa fa-trash"> </i></button>';
        }
        if (!empty($packages) && $this->ion_auth->in_group(array('admin'))) {
            $option5 = '<button class="btn btn-info btn-xs btn_width delete_button" id="td-pack-' . $packages->id . '"><i class="fa fa-trash"> </i></button>';
        }
        $option = '';
        if (!empty($medical_analysis_details)) {
            $option .= '<tr class="proccedure" id="tr-med-' . $medical_analysis_details->id . '"><td><input type="hidden" name="type_id[]" id="input_id-med-' . $medical_analysis_details->id . '" value="' . $medical_analysis_details->id . '" readonly><input type="text" class="input-category" name="type[]" id="input-med-' . $medical_analysis_details->id . '" value="' . $medical_analysis_details->category . '"readonly></td><td>' . lang('medical_analysis') . ' <input type="hidden" name="from[]" class="from_where" value="MedicalAnalysis_pre_surgery"></td><td><input class="price-indivudual" type="text" name="price_post[]" style="width:100px;" id="price-' . $medical_analysis_details->id . '" value="' . $medical_analysis_details->c_price . '" readonly></td><td><input class="discount-price-indivudual" type="number" min="0" name="discount_price_post[]" style="width:100px;" id="discount-price-' . $medical_analysis_details->id . '" value="0" ></td><td>' . $option3 . '</td><td>' . $option4 . '</td><td>' . $option2 . '</td></tr>';
        }
        if (!empty($packages)) {
            $option .= '<tr class="proccedure" id="tr-pack-' . $packages->id . '"><td><input type="hidden" name="type_id[]" id="input_id-pack-' . $packages->id . '" value="' . $packages->id . '" readonly><input type="text" class="input-category" name="type[]" id="input-pack-' . $packages->id . '" value="' . $packages->name . '"readonly></td><td>' . lang('package') . '<input type="hidden" class="from_where" name="from[]" value="Package_post_surgery_medical"></td><td><input class="price-indivudual" type="text" name="price_post[]" style="width:100px;" id="price-' . $packages->id . '" value="' . $packages->single_price . '" readonly ></td><td><input class="discount-price-indivudual" type="number" min="0" name="discount_price_post[]" style="width:100px;" id="discount-price-' . $packages->id . '" value="0" ></td><td>' . $option3 . '</td><td>' . $option4 . '</td><td>' . $option5 . '</td></tr>';
        }
        $data['option'] = $option;
        echo json_encode($data);
    }

    function editPostMedicalSurgery() {
        $id = $this->input->get('id');
        $data = array();
        $data['surgery_post'] = $this->surgery_model->getPostSurgeryMedicalAnalysisById($id);
        $cat_price = explode("##", $data['surgery_post']->description);
        $option = '';

        foreach ($cat_price as $cat_individual) {

            $individual = array();
            $individual = explode("**", $cat_individual);
            if ($individual[5] == 'done') {
                $select = ' <select class="form-control js-example-basic-single" name="done[]">' .
                        '<option value="done" selected>Done</option>' .
                        '<option value="undone">Undone</option>' .
                        '</select>';
            } else {
                $select = ' <select class="form-control js-example-basic-single" name="done[]">' .
                        '<option value="done" >Done</option>'
                        . '<option value="undone" selected>Undone</option>' .
                        '</select>';
            }

            if ($individual[0] == 'Package_post_surgery_medical') {
                if ($this->ion_auth->in_group(array('admin'))) {
                    $delete_buton = '<button class="btn btn-info btn-xs btn_width delete_button" id="td-pack-' . $individual[2] . '"><i class="fa fa-trash"> </i></button>';
                } else {
                    $delete_buton = '';
                }
                $option .= '<tr class="proccedure" id="tr-pack-' . $individual[2] . '"><td><input type="hidden" name="type_id[]" id="input_id-pack-' . $individual[2] . '" value="' . $individual[2] . '" readonly><input type="text" class="input-category" name="type[]" id="input-pack-' . $individual[1] . '" value="' . $individual[1] . '">' .
                        '</td><td>' . lang('package') . '<input type="hidden" name="from[]" class="from_where" value="Package_post_surgery_medical">' .
                        ' </td><td><input class="price-indivudual" type="text" name="price_post[]" style="width:100px;" id="price-' . $individual[2] . '" value="' . $individual[3] . '" readonly>' .
                        '</td><td><input class="discount-price-indivudual" type="number" min="0" name="discount_price_post[]" style="width:100px;" id="discount-price-' . $individual[2] . '" value="' . $individual[6] . '" >' .
                        '</td><td><input type="text" class="form-control  default-date-picker" name="date_to_done[]" value="' . $individual[4] . ' " readonly></td><td>' . $select . '</td><td>' . $delete_buton . '</td></tr>';
            } else {
                if ($this->ion_auth->in_group(array('admin'))) {
                    $delete_buton = '<button class="btn btn-info btn-xs btn_width delete_button" id="td-med-' . $individual[2] . '"><i class="fa fa-trash"> </i></button>';
                } else {
                    $delete_buton = '';
                }
                $option .= '<tr class="proccedure" id="tr-med-' . $individual[2] . '"><td><input type="hidden" name="type_id[]" id="input_id-med-' . $individual[2] . '" value="' . $individual[2] . '" readonly><input type="text" class="input-category" name="type[]" id="input-med-' . $individual[1] . '" value="' . $individual[1] . '">' .
                        '</td><td>' . lang('medical_analysis') . '<input type="hidden" name="from[]" class="from_where" value="MedicalAnalysis_post_surgery">' .
                        '</td><td><input class="price-indivudual" type="text" name="price_post[]" style="width:100px;" id="price-' . $individual[2] . '" value="' . $individual[3] . '" readonly="" >' .
                        '</td>  <td><input class="discount-price-indivudual" type="number" min="0" name="discount_price_post[]" style="width:100px;" id="discount-price-' . $individual[2] . '" value="' . $individual[6] . '" ></td>' .
                        '<td><input type="text" class="form-control  default-date-picker" name="date_to_done[]" value="' . $individual[4] . '" readonly></td><td>' . $select . '</td><td>' . $delete_buton . '</td></tr>';
            }
        }
        $data['option'] = $option;
        $dara['edited'] = '1';
        $data['message'] = array('message' => lang('updated'), 'title' => lang('updated'));
        echo json_encode($data);
    }

    function deletePostMedicalSurgery() {
        $id = $this->input->get('id');
        $this->surgery_model->deletePostMedicalSurgery($id);
        $arr = array('message' => lang('deleted'), 'title' => lang('deleted'));
        echo json_encode($arr);
    }

    function updatePreSurgeryMedicine() {
        //  $id = $this->input->post('daily_progress_id');
        $date = date('d-m-Y', time());
        $quantity = $this->input->post('quantity');
        $sales_price = $this->input->post('sales_price');
        $medicine_id = $this->input->post('medicine_name');
        $generic_name = $this->input->post('generic_name');
        $surgery_id = $this->input->post('surgery_id');
        $total = $this->input->post('total');
        $medicine_name = $this->medicine_model->getInternalMedicineById($medicine_id);





        $data = array();
        //  $patientname = $this->patient_model->getPatientById($patient)->name;
        $data = array(
            'date' => $date,
            'quantity' => $quantity,
            'surgery_id' => $surgery_id,
            's_price' => $sales_price,
            'medicine_id' => $medicine_id,
            'medicine_name' => $medicine_name->name,
            'pharmacy_medicine_id' => $medicine_name->id,
            'generic_name' => $generic_name,
            'total' => $total
        );




        $this->surgery_model->insertPreSurgeryMedicine($data);
        $insert_id = $this->db->insert_id('pre_surgery_medicine');
        //  $inserted_id=$this->db->inserted_id('daily_progress');
        $arr['info'] = $this->surgery_model->getPreSurgeryMedicineById($insert_id);
        $arr['medicine'] = $this->medicine_model->getMedicineById($arr['info']->medicine_id);
        // $arr['insert']=$insert_id;
        $arr['message'] = array('message' => lang('added'), 'title' => lang('added'));
        // $arr['added'] = array('redir' => 'added');
        echo json_encode($arr);
    }

    function deletePreSurgeryMedicine() {
        $id = $this->input->get('id');
        $med_details = $this->surgery_model->getPreSurgeryMedicineById($id);
        $payments = $this->finance_model->getPaymentById($med_details->payment_id);
        if (!empty($payments->category_name)) {
            $category = explode("#", $payments->category_name);
            foreach ($category as $cat) {
                $individual = explode('*', $cat);
                if ($individual[5] != $med_details->id) {
                    $price[] = $individual[4];
                    $cat_new[] = $cat;
                } else {
                    $medicine_internal = array();
                    $medicine_internal = $this->db->get_where('internal_medicine', array('id' => $med_details->medicine_id))->row();
                    $new_quantity = $medicine_internal->quantity + $individual[3];
                    $data_internal_med = array('quantity' => $new_quantity);
                    $this->medicine_model->updateInternalMedicine($medicine_internal->id, $data_internal_med);
                }
            }

            if (empty($cat_new)) {
                $this->finance_model->deletePayment($med_details->payment_id);
                $data_bed = array('payment_id' => '');
                $this->surgery_model->updatePreSurgeryMedicine($med_details->id, $data_bed);
            } else {
                $cat_new_update = implode("#", $cat_new);
                $total = array_sum($price);
                $data = array(
                    'category_name' => $cat_new_update,
                    'amount' => $total,
                    'gross_total' => $total,
                    'hospital_amount' => $total,
                );
                $data_bed = array('payment_id' => '');
                $this->surgery_model->updatePreSurgeryMedicine($med_details->id, $med_detailss);
                $this->finance_model->updatePayment($med_details->payment_id, $data);
            }
        }
        $this->surgery_model->deletePreSurgeryMedicine($id);
        $arr['message'] = array('message' => lang('delete'), 'title' => lang('delete'));
        echo json_encode($arr);
    }

    public function createPreSurgeryMedicineInvoice() {
        $id = $this->input->get('id');
        $medicine_list = $this->surgery_model->getMedicineForPreSurgery($id);
        foreach ($medicine_list as $medicine) {
            if (empty($medicine->payment_id)) {
                $medicine_con[] = $medicine->medicine_id . '*' . $medicine->medicine_name . '*' . $medicine->s_price . '*' . $medicine->quantity . '*' . $medicine->total . '*' . $medicine->id . '*' . $medicine->pharmacy_medicine_id;
                $price[] = $medicine->total;
                $quantity[] = $medicine->quantity;

                $medicine_id[] = $medicine->medicine_id;
                // $medicine_name[] = $medicine->medicine_name;
                //  $sale_price[] = $medicine->s_price;
                $ids[] = $medicine->id;
            }
        }
        if (!empty($medicine_id)) {
            foreach ($medicine_list as $medicine) {
                $medicine_internal = array();
                $medicine_internal = $this->db->get_where('internal_medicine', array('id' => $medicine->medicine_id))->row();
                $new_quantity = $medicine_internal->quantity - $medicine->quantity;
                $data_internal_med = array('quantity' => $new_quantity);
                $this->medicine_model->updateInternalMedicine($medicine_internal->id, $data_internal_med);
            }
            // $length = count($medicine_id);
            $total = array_sum($price);
            $arr['ids'] = implode(",", $ids);
            /* for ($i = 0; $i < $length; $i++) {
              $medicine_con[] = $medicine_id[$i] . '*' . $medicine_name[$i] . '*' . $sale_price[$i] . '*' . $quantity[$i] . '*' . $price[$i].'*'.$ids[$i];
              } */
            $medicine_include = implode("#", $medicine_con);

            $data = array();
            $bed_alloted = $this->surgery_model->getSurgeryById($id);
            $patient = $this->patient_model->getPatientById($bed_alloted->patient_id);
            // $doctor = $this->doctor_model->getDoctorById($bed_alloted->doctor);
            $date = time();
            $date_string = date('d-m-Y');
            $data = array(
                'category_name' => $medicine_include,
                'patient' => $patient->id,
                'date' => $date,
                'amount' => $total,
                // 'doctor' => $bed_alloted->doctor,
                'gross_total' => $total,
                'status' => 'unpaid',
                'hospital_amount' => $total,
                'doctor_amount' => '0',
                'user' => $this->ion_auth->get_user_id(),
                'patient_name' => $patient->name,
                'patient_phone' => $patient->phone,
                'patient_address' => $patient->address,
                // 'doctor_name' => $doctor->name,
                'date_string' => $date_string,
                'payment_from' => 'pre_surgery_medicine'
            );
            $this->finance_model->insertPayment($data);
            $inserted_id = $this->db->insert_id('payment');
            $data_update_medicine = array('payment_id' => $inserted_id);
            foreach ($ids as $id_bed_medicine) {
                $this->surgery_model->updatePreSurgeryMedicine($id_bed_medicine, $data_update_medicine);
            }
            $arr['message'] = array('message' => lang('invoice') . ' ' . lang('generated'), 'title' => lang('invoice') . ' ' . lang('generated'));
        } else {
            $arr['ids'] = '1';
            $arr['message'] = array('message' => lang('no_new_medicine_add'), 'title' => lang('no_new_medicine_add'));
        }
        echo json_encode($arr);
    }

    //on SUrgery Medicine
    function updateOnSurgeryMedicine() {
        //  $id = $this->input->post('daily_progress_id');
        $date = date('d-m-Y', time());
        $quantity = $this->input->post('quantity');
        $sales_price = $this->input->post('sales_price');
        $medicine_id = $this->input->post('medicine_name');
        $generic_name = $this->input->post('generic_name');
        $surgery_id = $this->input->post('surgery_id');
        $total = $this->input->post('total');
        $medicine_name = $this->medicine_model->getInternalMedicineById($medicine_id);





        $data = array();
        //  $patientname = $this->patient_model->getPatientById($patient)->name;
        $data = array(
            'date' => $date,
            'quantity' => $quantity,
            'surgery_id' => $surgery_id,
            's_price' => $sales_price,
            'medicine_id' => $medicine_id,
            'medicine_name' => $medicine_name->name,
            'pharmacy_medicine_id' => $medicine_name->id,
            'generic_name' => $generic_name,
            'total' => $total
        );




        $this->surgery_model->insertOnSurgeryMedicine($data);
        $insert_id = $this->db->insert_id('on_surgery_medicine');
        //  $inserted_id=$this->db->inserted_id('daily_progress');
        $arr['info'] = $this->surgery_model->getOnSurgeryMedicineById($insert_id);
        $arr['medicine'] = $this->medicine_model->getMedicineById($arr['info']->medicine_id);
        // $arr['insert']=$insert_id;
        $arr['message'] = array('message' => lang('added'), 'title' => lang('added'));
        // $arr['added'] = array('redir' => 'added');
        echo json_encode($arr);
    }

    function deleteOnSurgeryMedicine() {
        $id = $this->input->get('id');
        $med_details = $this->surgery_model->getOnSurgeryMedicineById($id);
        $payments = $this->finance_model->getPaymentById($med_details->payment_id);
        if (!empty($payments->category_name)) {
            $category = explode("#", $payments->category_name);
            foreach ($category as $cat) {
                $individual = explode('*', $cat);
                if ($individual[5] != $med_details->id) {
                    $price[] = $individual[4];
                    $cat_new[] = $cat;
                }
            }

            if (empty($cat_new)) {
                $this->finance_model->deletePayment($med_details->payment_id);
                $data_bed = array('payment_id' => '');
                $this->surgery_model->updateOnSurgeryMedicine($med_details->id, $data_bed);
            } else {
                $cat_new_update = implode("#", $cat_new);
                $total = array_sum($price);
                $data = array(
                    'category_name' => $cat_new_update,
                    'amount' => $total,
                    'gross_total' => $total,
                    'hospital_amount' => $total,
                );
                $data_bed = array('payment_id' => '');
                $this->surgery_model->updateOnSurgeryMedicine($med_details->id, $med_detailss);
                $this->finance_model->updatePayment($med_details->payment_id, $data);
            }
        }
        $this->surgery_model->deleteOnSurgeryMedicine($id);
        $arr['message'] = array('message' => lang('delete'), 'title' => lang('delete'));
        echo json_encode($arr);
    }

    public function createOnSurgeryMedicineInvoice() {
        $id = $this->input->get('id');
        $medicine_list = $this->surgery_model->getMedicineForOnSurgery($id);
        foreach ($medicine_list as $medicine) {
            if (empty($medicine->payment_id)) {
                $medicine_con[] = $medicine->medicine_id . '*' . $medicine->medicine_name . '*' . $medicine->s_price . '*' . $medicine->quantity . '*' . $medicine->total . '*' . $medicine->id . '*' . $medicine->pharmacy_medicine_id;
                $price[] = $medicine->total;
                // $quantity[] = $medicine->quantity;
                $medicine_id[] = $medicine->medicine_id;
                // $medicine_name[] = $medicine->medicine_name;
                //  $sale_price[] = $medicine->s_price;
                $ids[] = $medicine->id;
            }
        }
        if (!empty($medicine_id)) {
            // $length = count($medicine_id);
            $total = array_sum($price);
            $arr['ids'] = implode(",", $ids);
            /* for ($i = 0; $i < $length; $i++) {
              $medicine_con[] = $medicine_id[$i] . '*' . $medicine_name[$i] . '*' . $sale_price[$i] . '*' . $quantity[$i] . '*' . $price[$i].'*'.$ids[$i];
              } */
            $medicine_include = implode("#", $medicine_con);

            $data = array();
            $bed_alloted = $this->surgery_model->getSurgeryById($medicine_list->surgery_id);
            $patient = $this->patient_model->getPatientById($bed_alloted->patient_id);
            // $doctor = $this->doctor_model->getDoctorById($bed_alloted->doctor);
            $date = time();
            $date_string = date('d-m-Y');
            $data = array(
                'category_name' => $medicine_include,
                'patient' => $patient->id,
                'date' => $date,
                'amount' => $total,
                // 'doctor' => $bed_alloted->doctor,
                'gross_total' => $total,
                'status' => 'unpaid',
                'hospital_amount' => $total,
                'doctor_amount' => '0',
                'user' => $this->ion_auth->get_user_id(),
                'patient_name' => $patient->name,
                'patient_phone' => $patient->phone,
                'patient_address' => $patient->address,
                // 'doctor_name' => $doctor->name,
                'date_string' => $date_string,
                'payment_from' => 'on_surgery_medicine'
            );
            $this->finance_model->insertPayment($data);
            $inserted_id = $this->db->insert_id('payment');
            $data_update_medicine = array('payment_id' => $inserted_id);
            foreach ($ids as $id_bed_medicine) {
                $this->surgery_model->updateOnSurgeryMedicine($id_bed_medicine, $data_update_medicine);
            }
            $arr['message'] = array('message' => lang('invoice') . ' ' . lang('generated'), 'title' => lang('invoice') . ' ' . lang('generated'));
        } else {
            $arr['message'] = array('message' => lang('no_new_medicine_add'), 'title' => lang('no_new_medicine_add'));
        }
        echo json_encode($arr);
    }

    //post medicine

    function updatePostSurgeryMedicine() {
        //  $id = $this->input->post('daily_progress_id');
        $date = date('d-m-Y', time());
        $quantity = $this->input->post('quantity');
        $sales_price = $this->input->post('sales_price');
        $medicine_id = $this->input->post('medicine_name');
        $generic_name = $this->input->post('generic_name');
        $surgery_id = $this->input->post('surgery_id');
        $total = $this->input->post('total');
        $medicine_name = $this->medicine_model->getInternalMedicineById($medicine_id);





        $data = array();
        //  $patientname = $this->patient_model->getPatientById($patient)->name;
        $data = array(
            'date' => $date,
            'quantity' => $quantity,
            'surgery_id' => $surgery_id,
            's_price' => $sales_price,
            'medicine_id' => $medicine_id,
            'medicine_name' => $medicine_name->name,
            'pharmacy_medicine_id' => $medicine_name->id,
            'generic_name' => $generic_name,
            'total' => $total
        );




        $this->surgery_model->insertPostSurgeryMedicine($data);
        $insert_id = $this->db->insert_id('post_surgery_medicine');
        //  $inserted_id=$this->db->inserted_id('daily_progress');
        $arr['info'] = $this->surgery_model->getPostSurgeryMedicineById($insert_id);
        $arr['medicine'] = $this->medicine_model->getMedicineById($arr['info']->medicine_id);
        // $arr['insert']=$insert_id;
        $arr['message'] = array('message' => lang('added'), 'title' => lang('added'));
        // $arr['added'] = array('redir' => 'added');
        echo json_encode($arr);
    }

    function deletePostSurgeryMedicine() {
        $id = $this->input->get('id');
        $med_details = $this->surgery_model->getPostSurgeryMedicineById($id);
        $payments = $this->finance_model->getPaymentById($med_details->payment_id);
        if (!empty($payments->category_name)) {
            $category = explode("#", $payments->category_name);
            foreach ($category as $cat) {
                $individual = explode('*', $cat);
                if ($individual[5] != $med_details->id) {
                    $price[] = $individual[4];
                    $cat_new[] = $cat;
                } else {
                    $medicine_internal = array();
                    $medicine_internal = $this->db->get_where('internal_medicine', array('id' => $med_details->medicine_id))->row();
                    $new_quantity = $medicine_internal->quantity + $individual[3];
                    $data_internal_med = array('quantity' => $new_quantity);
                    $this->medicine_model->updateInternalMedicine($medicine_internal->id, $data_internal_med);
                }
            }

            if (empty($cat_new)) {
                $this->finance_model->deletePayment($med_details->payment_id);
                $data_bed = array('payment_id' => '');
                $this->surgery_model->updatePostSurgeryMedicine($med_details->id, $data_bed);
            } else {
                $cat_new_update = implode("#", $cat_new);
                $total = array_sum($price);
                $data = array(
                    'category_name' => $cat_new_update,
                    'amount' => $total,
                    'gross_total' => $total,
                    'hospital_amount' => $total,
                );
                $data_bed = array('payment_id' => '');
                $this->surgery_model->updatePostSurgeryMedicine($med_details->id, $med_detailss);
                $this->finance_model->updatePayment($med_details->payment_id, $data);
            }
        }
        $this->surgery_model->deletePostSurgeryMedicine($id);
        $arr['message'] = array('message' => lang('delete'), 'title' => lang('delete'));
        echo json_encode($arr);
    }

    public function createPostSurgeryMedicineInvoice() {
        $id = $this->input->get('id');
        $medicine_list = $this->surgery_model->getMedicineForPostSurgery($id);
        foreach ($medicine_list as $medicine) {
            if (empty($medicine->payment_id)) {
                $medicine_con[] = $medicine->medicine_id . '*' . $medicine->medicine_name . '*' . $medicine->s_price . '*' . $medicine->quantity . '*' . $medicine->total . '*' . $medicine->id . '*' . $medicine->pharmacy_medicine_id;
                $price[] = $medicine->total;
                $quantity[] = $medicine->quantity;
                $medicine_id[] = $medicine->medicine_id;
                // $medicine_name[] = $medicine->medicine_name;
                //  $sale_price[] = $medicine->s_price;
                $ids[] = $medicine->id;
            }
        }
        if (!empty($medicine_id)) {
            foreach ($medicine_list as $medicine) {
                $medicine_internal = array();
                $medicine_internal = $this->db->get_where('internal_medicine', array('id' => $medicine->medicine_id))->row();
                $new_quantity = $medicine_internal->quantity - $medicine->quantity;
                $data_internal_med = array('quantity' => $new_quantity);
                $this->medicine_model->updateInternalMedicine($medicine_internal->id, $data_internal_med);
            }
            // $length = count($medicine_id);
            $total = array_sum($price);
            $arr['ids'] = implode(",", $ids);
            /* for ($i = 0; $i < $length; $i++) {
              $medicine_con[] = $medicine_id[$i] . '*' . $medicine_name[$i] . '*' . $sale_price[$i] . '*' . $quantity[$i] . '*' . $price[$i].'*'.$ids[$i];
              } */
            $medicine_include = implode("#", $medicine_con);

            $data = array();
            $bed_alloted = $this->surgery_model->getSurgeryById($id);
            $patient = $this->patient_model->getPatientById($bed_alloted->patient_id);
            // $doctor = $this->doctor_model->getDoctorById($bed_alloted->doctor);
            $date = time();
            $date_string = date('d-m-Y');
            $data = array(
                'category_name' => $medicine_include,
                'patient' => $patient->id,
                'date' => $date,
                'amount' => $total,
                // 'doctor' => $bed_alloted->doctor,
                'gross_total' => $total,
                'status' => 'unpaid',
                'hospital_amount' => $total,
                'doctor_amount' => '0',
                'user' => $this->ion_auth->get_user_id(),
                'patient_name' => $patient->name,
                'patient_phone' => $patient->phone,
                'patient_address' => $patient->address,
                // 'doctor_name' => $doctor->name,
                'date_string' => $date_string,
                'payment_from' => 'post_surgery_medicine'
            );
            $this->finance_model->insertPayment($data);
            $inserted_id = $this->db->insert_id('payment');
            $data_update_medicine = array('payment_id' => $inserted_id);
            foreach ($ids as $id_bed_medicine) {
                $this->surgery_model->updatePostSurgeryMedicine($id_bed_medicine, $data_update_medicine);
            }
            $arr['message'] = array('message' => lang('invoice') . ' ' . lang('generated'), 'title' => lang('invoice') . ' ' . lang('generated'));
        } else {
            $arr['ids'] = '1';
            $arr['message'] = array('message' => lang('no_new_medicine_add'), 'title' => lang('no_new_medicine_add'));
        }
        echo json_encode($arr);
    }

    public function getNurseInfo() {
// Search term
        $searchTerm = $this->input->post('searchTerm');

// Get users
        $response = $this->nurse_model->getNurseInfo($searchTerm);

        echo json_encode($response);
    }

    function deletePreSurgeryServices() {
        $id = $this->input->get('id');
        $service = explode("**", $id);
        $service_details = $this->surgery_model->getPreServiceById($service[0]);
        $surgery_id = $service_details->surgery_id;
        $services_database = explode("**", $service_details->service);
        $prices_database = explode("**", $service_details->price);
        $discount_database = explode("**", $service_details->discount);
        if (!empty($service_details->payment_id)) {
            $payment_explode = explode(",", $service_details->payment_id);
            for ($i = 0; $i < count($payment_explode); $i++) {
                $payment_details = array();
                $payment_details = $this->finance_model->getPaymentById($payment_explode[$i]);
                $payment_d = array();
                $price_update = array();
                $price_up = array();
                $payment_d = explode("#", $payment_details->category_name);
                foreach ($payment_d as $key => $value) {
                    $pay_service = array();
                    $pay_service = explode("*", $value);
                    if ($service[1] == $pay_service[0]) {
                        continue;
                    } else {
                        $price_update[] = $pay_service[0] . '*' . $pay_service[1] . '*' . $pay_service[2];
                        $price_up[] = $pay_service[1];
                        $discount_up[] = $pay_service[2];
                    }
                }
                if (!empty($price_update)) {
                    $pay_update = implode("#", $pay_update);
                    $total = array_sum($price_up);
                    $discount = array_sum($discount_up);
                    $grand_total = $total - $discount;
                    $data_payment = array();
                    $data_payment = array(
                        'category_name' => $cat_new_update,
                        'amount' => $total,
                        'gross_total' => $grand_total,
                        'hospital_amount' => $total,
                        'discount' => $discount
                    );
                    $this->finance_model->updatePayment($payment_explode[$i], $data_payment);
                    $payment_id[] = $payment_explode[$i];
                } else {
                    $this->finance_model->deletePayment($payment_explode[$i]);
                }
            }
        }
        for ($i = 0; $i < sizeof($services_database); $i++) {
            if ($service[1] != $services_database[$i]) {
                $service_new[] = $services_database[$i];
                $price_new[] = $prices_database[$i];
                $discount_new[] = $discount_database[$i];
            }
        }
        $data = array(
            'price' => implode("**", $price_new),
            'service' => implode("**", $service_new),
            'discount' => implode("**", $discount_new),
            'payment_id' => implode(",", $payment_id),
        );
        if (empty($price_new)) {
            $this->surgery_model->deletePreServices($id);
        } else {
            $this->surgery_model->updatePreServices($id, $data);
        }
        $services_all = $this->surgery_model->getPreServiceBySurgeryId($surgery_id);
        if (empty($services_all)) {
            $price_total = '0';
            $discount_total_new = '0';
            $grand_total_new = '0';
        } else {
            foreach ($services_all as $services) {
                $price_u = explode("**", $services->price);
                $discount_u = explode("**", $services->discount);
                $price_ups[] = array_sum($price_u);
                $discount_ups[] = array_sum($discount_u);
            }

            $price_total = array_sum($price_ups);
            $discount_total_new = array_sum($discount_ups);
            $grand_total_new = $price_total - $discount_total_new;
        }

        $arr['message'] = array('message' => lang('delete'), 'title' => lang('delete'), 'date' => $service_details->date, 'total' => $price_total, 'discount' => $discount_total_new, 'grand' => $grand_total_new);
        // $arr['date1'] = array();
        echo json_encode($arr);
    }

    function updateServicesPreSurgery() {
        $pservice = $this->input->post('arr');
//$discount_id= $this->input->post('discount_id');
//$discount= $this->input->post('discount');
//if(!empty(discount))
        $surgery_id = $this->input->post('alloted');
        $nurse = $this->input->post('nurse');
        $date = date('d-m-Y', time());
        $date_exist1 = $this->surgery_model->getPreServicesByDate($date);

        if (!empty($pservice)) {
            foreach ($pservice as $p_service) {
                $price_pservice = $this->pservice_model->getPserviceById($p_service);
                $price[] = $price_pservice->price;
                if (empty($date_exist1)) {
                    $discount[] = '0';
                } else {
                    $pservice_update_for_discount = array();
                    $for_discount = array();
                    $pservice_update_for_discount = explode("**", $date_exist1->service);
                    $for_discount = explode("**", $date_exist1->discount);
                    $i = 0;
                    if (in_array($p_service, $pservice_update_for_discount)) {
                        $key = array_search($p_service, $pservice_update_for_discount);
                        $discount[] = $for_discount[$key];
                    } else {
                        $discount[] = '0';
                    }
                }
                //
            }
            $price_update = implode("**", $price);
            $pservice_update = implode("**", $pservice);
            $discount_update = implode("**", $discount);
            //  $discounr_update=implode('**',$discount);
            $data = array();
            $data = array('date' => $date,
                'nurse' => $nurse,
                'service' => $pservice_update,
                'price' => $price_update,
                'discount' => $discount_update,
                'surgery_id' => $this->input->post('alloted')
            );
        }
        $date_exist = $this->surgery_model->getPreServicesByDate($date);
        if (!empty($date_exist)) {
            if (empty($pservice)) {
                $payment_ids = explode(",", $date_exist->payment_id);
                if (!empty($payment_ids)) {
                    for ($i = 0; $i < count($payment_ids); $i++) {
                        $this->finance_model->deletePayment($payment_ids[$i]);
                    }
                }
                $this->surgery_model->deletePreServices($date_exist->id);
                $arr['message'] = array('message' => lang('updated'), 'title' => lang('updated'));
            } else {
                $this->surgery_model->updatePreServices($date_exist->id, $data);
                $inserted_id = $date_exist->id;
                $arr['message'] = array('message' => lang('updated'), 'title' => lang('updated'));
            }
        } else {
            $this->surgery_model->insertPreServices($data);
            $inserted_id = $this->db->insert_id('pre_service');
            $arr['message'] = array('message' => lang('added'), 'title' => lang('added'));
        }
        $daily_service = $this->surgery_model->getPreServiceBySurgeryId($this->input->post('alloted'));

        $settings = $this->settings_model->getSettings();


        foreach ($daily_service as $service) {
            $pay_service = array();
            $pay_service_new = array();
            if (!empty($service->payment_id)) {
                $payment_explode = explode(",", $service->payment_id);
                for ($i = 0; $i < count($payment_explode); $i++) {
                    $payment_details = array();
                    $payment_details = $this->finance_model->getPaymentById($payment_explode[$i]);
                    $payment_d = array();
                    $payment_d = explode("#", $payment_details->category_name);
                    foreach ($payment_d as $key => $value) {
                        $pay_service = explode("*", $value);
                        $pay_service_new[] = $pay_service[0];
                    }
                }
            }
            $price = explode("**", $service->price);
            $discount_pre = explode("**", $service->discount);
            $total_price = array_sum($price);
            $total_discount = array_sum($discount_pre);
            $grand_total = $total_price - $total_discount;
            $service_update = explode("**", $service->service);
            //  print_r($price);
            // die();
            //$array = array_combine($service, $price);
            $length = sizeof($price);
            $length1 = sizeof($service_update);
            if ($length == $length1) {
                $i = 0;
                for ($i = 0; $i < $length; $i++) {
                    $servicename = $this->db->get_where('pservice', array('id' => $service_update[$i]))->row();

                    if (!empty($service->nurse)) {
                        $nursename = $this->db->get_where('nurse', array('id' => $service->nurse))->row()->name;
                    } else {
                        $nursename = " ";
                    }
                    $date_explode = explode("-", $service->date);
                    if ($this->ion_auth->in_group(array('admin'))) {
                        $option .= '<tr id="pre-' . $service->date . '-' . $service_update[$i] . '">
                                                        <td>' . $servicename->name . '</td>
                                                        <td>' . $service->date . '</td>
                                                        <td>' . $nursename . '</td>
                                                        <td><input type="number" min="0" name="price_pre_service[]" value="' . $price[$i] . '"class="price-pre-services" id="pre-service-price-' . $servicename->id . '"readonly></td>
                                                        <td> 1 </td>
                                                        <td>' . $settings->currency . ' ' . $price[$i] . '</td>
                                                        <td><input type="number" min="0" name="discount_pre_service[]" value="' . $discount_pre[$i] . '"class="discount-price-pre-services" id="pre-service-discount-' . $servicename->id . '-' . $service->date . '"></td>
 <td id="discount-pre-' . $service->date . '-' . $servicename->id . '">' . $settings->currency . ' ' . ($price[$i] - $discount_pre[$i]) . '</td>                                                       
<td class="no-print" id="delete-service-' . $date_explode[0] . '-' . $servicename->id . '"><button type="button" class="btn btn-danger btn-xs btn_width delete_service" title=' . lang('delete') . ' data-toggle=" "data-id="' . $service->id . "**" . $service_update[$i] . '"><i class="fa fa-trash"></i></button></td>
                                                    </tr>';
                    } else {
                        if (empty($service->payment_id)) {
                            $option .= '<tr id="pre-' . $service->date . '-' . $service_update[$i] . '">
                                                        <td>' . $servicename->name . '</td>
                                                        <td>' . $service->date . '</td>
                                                        <td>' . $nursename . '</td>
                                                        <td><input type="number" min="0" name="price_pre_service[]" value="' . $price[$i] . '"class="price-pre-services" id="pre-service-price-' . $servicename->id . '"readonly></td>
                                                        <td> 1 </td>
                                                        <td>' . $settings->currency . ' ' . $price[$i] . '</td>
                                                                 <td><input type="number" min="0" name="discount_pre_service[]" value="' . $discount_pre[$i] . '"class="discount-price-pre-services" id="pre-service-discount-' . $servicename->id . '-' . $service->date . '"></td>
 <td id="discount-pre-' . $service->date . '-' . $servicename->id . '">' . $settings->currency . ' ' . ($price[$i] - $discount_pre[$i]) . '</td>                                                        
<td class="no-print" id="delete-service-' . $date_explode[0] . '-' . $servicename->id . '"><button type="button" class="btn btn-danger btn-xs btn_width delete_service" title=' . lang('delete') . ' data-toggle=" "data-id="' . $service->id . "**" . $service_update[$i] . '"><i class="fa fa-trash"></i></button></td>
                                                    </tr>';
                        } else {
                            if (in_array($servicename->id, $pay_service_new)) {
                                $option .= '<tr id="pre-' . $service->date . '-' . $service_update[$i] . '">
                                                        <td>' . $servicename->name . '</td>
                                                        <td>' . $service->date . '</td>
                                                        <td>' . $nursename . '</td>
                                                        <td><input type="number" min="0" name="price_pre_service[]" value="' . $price[$i] . '"class="price-pre-services" id="pre-service-price-' . $servicename->id . '"readonly></td>
                                                        <td> 1 </td>
                                                        <td>' . $settings->currency . ' ' . $price[$i] . '</td>
                                                        <td><input type="number" min="0" name="discount_pre_service[]" value="' . $discount_pre[$i] . '"class="discount-price-pre-services" id="pre-service-discount-' . $servicename->id . '-' . $service->date . '"></td>
                                                        <td id="discount-pre-' . $service->date . '-' . $servicename->id . '">' . $settings->currency . ' ' . ($price[$i] - $discount_pre[$i]) . '</td>                                                      
                                                        <td></td>
                                                    </tr>';
                            } else {
                                $option .= '<tr id="pre-' . $service->date . '-' . $service_update[$i] . '">
                                                        <td>' . $servicename->name . '</td>
                                                        <td>' . $service->date . '</td>
                                                        <td>' . $nursename . '</td>
                                                        <td><input type="number" min="0" name="price_pre_service[]" value="' . $price[$i] . '"class="price-pre-services" id="pre-service-price-' . $servicename->id . '"readonly></td>
                                                        <td> 1 </td>
                                                        <td>' . $settings->currency . ' ' . $price[$i] . '</td>
                                                       <td><input type="number" min="0" name="discount_pre_service[]" value="' . $discount_pre[$i] . '"class="discount-price-pre-services" id="pre-service-discount-' . $servicename->id . '-' . $service->date . '"></td>
 <td id="discount-pre-' . $service->date . '-' . $servicename->id . '">' . $settings->currency . ' ' . ($price[$i] - $discount_pre[$i]) . '</td>                                                     
<td class="no-print" id="delete-service-' . $date_explode[0] . '-' . $servicename->id . '"><button type="button" class="btn btn-danger btn-xs btn_width delete_service" title=' . lang('delete') . ' data-toggle=" "data-id="' . $service->id . "**" . $service_update[$i] . '"><i class="fa fa-trash"></i></button></td>
                                                    </tr>';
                            }
                        }
                    }
                }
            }
        }
        $services_all = $this->surgery_model->getPreServiceBySurgeryId($surgery_id);
        if (empty($services_all)) {
            $price_total = '0';
            $discount_total_new = '0';
            $grand_total_new = '0';
        } else {

            foreach ($services_all as $services) {
                $price_u = explode("**", $services->price);
                $discount_u = explode("**", $services->discount);
                $price_ups[] = array_sum($price_u);
                $discount_ups[] = array_sum($discount_u);
            }

            $price_total = array_sum($price_ups);
            $discount_total_new = array_sum($discount_ups);
            $grand_total_new = $price_total - $discount_total_new;
        }

        $arr['option'] = array('option' => $option, 'title' => lang('added'), 'total' => $price_total, 'discount' => $discount_total_new, 'grand' => $grand_total_new);
        $arr['nurses'] = $this->nurse_model->getNurseById($nurse);

        echo json_encode($arr);
    }

    function updateDiscount() {
        $discount = $this->input->post('discount');
        //$discount_update = implode("**", $discount);
        $id = $this->input->post('alloted');
        $date = $this->input->post('date');
        $service_id = $this->input->post('service');
        //$date = date('d-m-Y', time());
        $date_exist = $this->surgery_model->getPreServicesByDate($date);
        $service_update = explode("**", $date_exist->service);
        $discount_update = explode("**", $date_exist->discount);
        for ($i = 0; $i < count($service_update); $i++) {
            if ($service_update[$i] == $service_id) {
                $discount_new[] = $discount;
            } else {
                $discount_new[] = $discount_update[$i];
            }
        }
        $discount_update_new = implode("**", $discount_new);
        $data = array();
        $data = array('discount' => $discount_update_new);
        $this->surgery_model->updatePreServices($date_exist->id, $data);
        $price = $this->input->post('price');
        $services_all = $this->surgery_model->getPreServiceBySurgeryId($date_exist->surgery_id);
        if (empty($services_all)) {
            $price_total = '0';
            $discount_total_new = '0';
            $grand_total_new = '0';
        } else {
            foreach ($services_all as $services) {
                $price_u = explode("**", $services->price);
                $discount_u = explode("**", $services->discount);
                $price_ups[] = array_sum($price_u);
                $discount_ups[] = array_sum($discount_u);
            }

            $price_total = array_sum($price_ups);
            $discount_total_new = array_sum($discount_ups);
            $grand_total_new = $price_total - $discount_total_new;
        }
        $data['total'] = $price_total;
        $data['discount'] = $discount_total_new;
        $data['grand_total'] = $grand_total_new;

        echo json_encode($data);
    }

    public function createPreServiceInvoice() {
        $id = $this->input->get('id');
        $service_list = $this->surgery_model->getPreServicedByIdByDate($id);
        $previous_payment_ids = $service_list->payment_id;
        if (!empty($service_list)) {
            $price = explode("**", $service_list->price);
            $services = explode("**", $service_list->service);
            $discounts = explode("**", $service_list->discount);
            $i = 0;
            if (!empty($service_list->payment_id)) {
                $paymentid = explode(",", $service_list->payment_id);
                foreach ($paymentid as $key => $payment) {
                    $payment_details = $this->finance_model->getPaymentById($payment);
                    $payment_cat = explode("#", $payment_details->category_name);
                    foreach ($payment_cat as $key => $pay) {
                        $cat_name = explode("*", $pay);
                        $previous_invoice_service[] = $cat_name[0];
                    }
                }
            } else {
                $previous_invoice_service = [];
            }
            for ($i = 0; $i < count($services); $i++) {
                if (!in_array($services[$i], $previous_invoice_service)) {
                    $service_new[] = $services[$i] . '*' . $price[$i] . '*' . $discounts[$i];
                    $arr['ids'] = $services[$i];
                }
                //$i++;
            }
            if (!empty($service_new)) {
                $service_implode = implode("#", $service_new);
                $total = array_sum($price);
                $discount = array_sum($discounts);
                $grand = $total - $discount;
                $bed_alloted = $this->surgery_model->getSurgeryById($id);
                $patient = $this->patient_model->getPatientById($bed_alloted->patient_id);
                // $doctor = $this->doctor_model->getDoctorById($bed_alloted->doctor);
                $date = time();
                $date_string = date('d-m-Y');
                $data = array(
                    'category_name' => $service_implode,
                    'patient' => $patient->id,
                    'date' => $date,
                    'amount' => $total,
                    'discount' => $discount,
                    // 'doctor' => $bed_alloted->doctor,
                    'gross_total' => $grand,
                    'status' => 'unpaid',
                    'hospital_amount' => $grand,
                    'doctor_amount' => '0',
                    'user' => $this->ion_auth->get_user_id(),
                    'patient_name' => $patient->name,
                    'patient_phone' => $patient->phone,
                    'patient_address' => $patient->address,
                    // 'doctor_name' => $doctor->name,
                    'date_string' => $date_string,
                    'payment_from' => 'pre_service'
                );
                $this->finance_model->insertPayment($data);
                $inserted_id = $this->db->insert_id('payment');
                if (!empty($previous_payment_ids)) {
                    $new_payment_id = $previous_payment_ids . ',' . $inserted_id;
                } else {
                    $new_payment_id = $inserted_id;
                }
                $data = array('payment_id' => $new_payment_id);
                $this->surgery_model->updatePreServices($service_list->id, $data);
                $arr['date'] = date('d');
                $arr['message'] = array('message' => lang('invoice') . ' ' . lang('generated'), 'title' => lang('invoice') . ' ' . lang('generated'));
            } else {
                $arr['ids'] = '1';
                $arr['message'] = array('message' => lang('no_new_service_add'), 'title' => lang('no_new_service_add'));
            }
        } else {
            $arr['ids'] = '1';
            $arr['message'] = array('message' => lang('no_new_service_add'), 'title' => lang('no_new_service_add'));
        }

        echo json_encode($arr);
    }

    function deleteOnSurgeryServices() {
        $id = $this->input->get('id');
        $service = explode("**", $id);
        $service_details = $this->surgery_model->getOnServiceById($service[0]);
        $surgery_id = $service_details->surgery_id;
        $services_database = explode("**", $service_details->service);
        $prices_database = explode("**", $service_details->price);
        $discount_database = explode("**", $service_details->discount);
        if (!empty($service_details->payment_id)) {
            $payment_explode = explode(",", $service_details->payment_id);
            for ($i = 0; $i < count($payment_explode); $i++) {
                $payment_details = array();
                $payment_details = $this->finance_model->getPaymentById($payment_explode[$i]);
                $payment_d = array();
                $price_update = array();
                $price_up = array();
                $payment_d = explode("#", $payment_details->category_name);
                foreach ($payment_d as $key => $value) {
                    $pay_service = array();
                    $pay_service = explode("*", $value);
                    if ($service[1] == $pay_service[0]) {
                        continue;
                    } else {
                        $price_update[] = $pay_service[0] . '*' . $pay_service[1] . '*' . $pay_service[2];
                        $price_up[] = $pay_service[1];
                        $discount_up[] = $pay_service[2];
                    }
                }
                if (!empty($price_update)) {
                    $pay_update = implode("#", $pay_update);
                    $total = array_sum($price_up);
                    $discount = array_sum($discount_up);
                    $grand_total = $total - $discount;
                    $data_payment = array();
                    $data_payment = array(
                        'category_name' => $cat_new_update,
                        'amount' => $total,
                        'gross_total' => $grand_total,
                        'hospital_amount' => $total,
                        'discount' => $discount
                    );
                    $this->finance_model->updatePayment($payment_explode[$i], $data_payment);
                    $payment_id[] = $payment_explode[$i];
                } else {
                    $this->finance_model->deletePayment($payment_explode[$i]);
                }
            }
        }
        for ($i = 0; $i < sizeof($services_database); $i++) {
            if ($service[1] != $services_database[$i]) {
                $service_new[] = $services_database[$i];
                $price_new[] = $prices_database[$i];
                $discount_new[] = $discount_database[$i];
            }
        }
        $data = array(
            'price' => implode("**", $price_new),
            'service' => implode("**", $service_new),
            'discount' => implode("**", $discount_new),
            'payment_id' => implode(",", $payment_id),
        );
        if (empty($price_new)) {
            $this->surgery_model->deleteOnServices($id);
        } else {
            $this->surgery_model->updateOnServices($id, $data);
        }
        $services_all = $this->surgery_model->getOnServiceBySurgeryId($surgery_id);
        if (empty($services_all)) {
            $price_total = '0';
            $discount_total_new = '0';
            $grand_total_new = '0';
        } else {
            foreach ($services_all as $services) {
                $price_u = explode("**", $services->price);
                $discount_u = explode("**", $services->discount);
                $price_ups[] = array_sum($price_u);
                $discount_ups[] = array_sum($discount_u);
            }

            $price_total = array_sum($price_ups);
            $discount_total_new = array_sum($discount_ups);
            $grand_total_new = $price_total - $discount_total_new;
        }

        $arr['message'] = array('message' => lang('delete'), 'title' => lang('delete'), 'date' => $service_details->date, 'total' => $price_total, 'discount' => $discount_total_new, 'grand' => $grand_total_new);
        // $arr['date1'] = array();
        echo json_encode($arr);
    }

    function updateServicesOnSurgery() {
        $pservice = $this->input->post('arr');
//$discount_id= $this->input->post('discount_id');
//$discount= $this->input->post('discount');
//if(!empty(discount))
        $surgery_id = $this->input->post('alloted');
        $nurse = $this->input->post('nurse');
        $date = date('d-m-Y', time());
        $date_exist1 = $this->surgery_model->getOnServicesByDate($date);

        if (!empty($pservice)) {
            foreach ($pservice as $p_service) {
                $price_pservice = $this->pservice_model->getPserviceById($p_service);
                $price[] = $price_pservice->price;
                if (empty($date_exist1)) {
                    $discount[] = '0';
                } else {
                    $pservice_update_for_discount = array();
                    $for_discount = array();
                    $pservice_update_for_discount = explode("**", $date_exist1->service);
                    $for_discount = explode("**", $date_exist1->discount);
                    $i = 0;
                    if (in_array($p_service, $pservice_update_for_discount)) {
                        $key = array_search($p_service, $pservice_update_for_discount);
                        $discount[] = $for_discount[$key];
                    } else {
                        $discount[] = '0';
                    }
                }
                //
            }
            $price_update = implode("**", $price);
            $pservice_update = implode("**", $pservice);
            $discount_update = implode("**", $discount);
            //  $discounr_update=implode('**',$discount);
            $data = array();
            $data = array('date' => $date,
                'nurse' => $nurse,
                'service' => $pservice_update,
                'price' => $price_update,
                'discount' => $discount_update,
                'surgery_id' => $this->input->post('alloted')
            );
        }
        $date_exist = $this->surgery_model->getOnServicesByDate($date);
        if (!empty($date_exist)) {
            if (empty($pservice)) {
                $payment_ids = explode(",", $date_exist->payment_id);
                if (!empty($payment_ids)) {
                    for ($i = 0; $i < count($payment_ids); $i++) {
                        $this->finance_model->deletePayment($payment_ids[$i]);
                    }
                }
                $this->surgery_model->deleteOnServices($date_exist->id);
                $arr['message'] = array('message' => lang('updated'), 'title' => lang('updated'));
            } else {
                $this->surgery_model->updateOnServices($date_exist->id, $data);
                $inserted_id = $date_exist->id;
                $arr['message'] = array('message' => lang('updated'), 'title' => lang('updated'));
            }
        } else {
            $this->surgery_model->insertOnServices($data);
            $inserted_id = $this->db->insert_id('pre_service');
            $arr['message'] = array('message' => lang('added'), 'title' => lang('added'));
        }
        $daily_service = $this->surgery_model->getOnServiceBySurgeryId($this->input->post('alloted'));

        $settings = $this->settings_model->getSettings();


        foreach ($daily_service as $service) {
            $pay_service = array();
            $pay_service_new = array();
            if (!empty($service->payment_id)) {
                $payment_explode = explode(",", $service->payment_id);
                for ($i = 0; $i < count($payment_explode); $i++) {
                    $payment_details = array();
                    $payment_details = $this->finance_model->getPaymentById($payment_explode[$i]);
                    $payment_d = array();
                    $payment_d = explode("#", $payment_details->category_name);
                    foreach ($payment_d as $key => $value) {
                        $pay_service = explode("*", $value);
                        $pay_service_new[] = $pay_service[0];
                    }
                }
            }
            $price = explode("**", $service->price);
            $discount_pre = explode("**", $service->discount);
            $total_price = array_sum($price);
            $total_discount = array_sum($discount_pre);
            $grand_total = $total_price - $total_discount;
            $service_update = explode("**", $service->service);
            //  print_r($price);
            // die();
            //$array = array_combine($service, $price);
            $length = sizeof($price);
            $length1 = sizeof($service_update);
            if ($length == $length1) {
                $i = 0;
                for ($i = 0; $i < $length; $i++) {
                    $servicename = $this->db->get_where('pservice', array('id' => $service_update[$i]))->row();

                    if (!empty($service->nurse)) {
                        $nursename = $this->db->get_where('nurse', array('id' => $service->nurse))->row()->name;
                    } else {
                        $nursename = " ";
                    }
                    $date_explode = explode("-", $service->date);
                    if ($this->ion_auth->in_group(array('admin'))) {
                        $option .= '<tr id="on-' . $service->date . '-' . $service_update[$i] . '">
                                                        <td>' . $servicename->name . '</td>
                                                        <td>' . $service->date . '</td>
                                                        <td>' . $nursename . '</td>
                                                        <td><input type="number" min="0" name="price_on_service[]" value="' . $price[$i] . '"class="price-on-services" id="on-service-price-' . $servicename->id . '"readonly></td>
                                                        <td> 1 </td>
                                                        <td>' . $settings->currency . ' ' . $price[$i] . '</td>
                                                        <td><input type="number" min="0" name="discount_on_service[]" value="' . $discount_pre[$i] . '"class="discount-price-on-services" id="on-service-discount-' . $servicename->id . '-' . $service->date . '"></td>
 <td id="discount-on-' . $service->date . '-' . $servicename->id . '">' . $settings->currency . ' ' . ($price[$i] - $discount_pre[$i]) . '</td>                                                       
<td class="no-print" id="delete-service-on-' . $date_explode[0] . '-' . $servicename->id . '"><button type="button" class="btn btn-danger btn-xs btn_width delete_service" title=' . lang('delete') . ' data-toggle=" "data-id="' . $service->id . "**" . $service_update[$i] . '"><i class="fa fa-trash"></i></button></td>
                                                    </tr>';
                    } else {
                        if (empty($service->payment_id)) {
                            $option .= '<tr id="on-' . $service->date . '-' . $service_update[$i] . '">
                                                        <td>' . $servicename->name . '</td>
                                                        <td>' . $service->date . '</td>
                                                        <td>' . $nursename . '</td>
                                                        <td><input type="number" min="0" name="price_on_service[]" value="' . $price[$i] . '"class="price-on-services" id="on-service-price-' . $servicename->id . '"readonly></td>
                                                        <td> 1 </td>
                                                        <td>' . $settings->currency . ' ' . $price[$i] . '</td>
                                                                 <td><input type="number" min="0" name="discount_on_service[]" value="' . $discount_pre[$i] . '"class="discount-price-on-services" id="on-service-discount-' . $servicename->id . '-' . $service->date . '"></td>
 <td id="discount-pre-' . $service->date . '-' . $servicename->id . '">' . $settings->currency . ' ' . ($price[$i] - $discount_pre[$i]) . '</td>                                                        
<td class="no-print" id="delete-service-on-' . $date_explode[0] . '-' . $servicename->id . '"><button type="button" class="btn btn-danger btn-xs btn_width delete_service" title=' . lang('delete') . ' data-toggle=" "data-id="' . $service->id . "**" . $service_update[$i] . '"><i class="fa fa-trash"></i></button></td>
                                                    </tr>';
                        } else {
                            if (in_array($servicename->id, $pay_service_new)) {
                                $option .= '<tr id="on-' . $service->date . '-' . $service_update[$i] . '">
                                                        <td>' . $servicename->name . '</td>
                                                        <td>' . $service->date . '</td>
                                                        <td>' . $nursename . '</td>
                                                        <td><input type="number" min="0" name="price_on_service[]" value="' . $price[$i] . '"class="price-on-services" id="on-service-price-' . $servicename->id . '"readonly></td>
                                                        <td> 1 </td>
                                                        <td>' . $settings->currency . ' ' . $price[$i] . '</td>
                                                        <td><input type="number" min="0" name="discount_on_service[]" value="' . $discount_pre[$i] . '"class="discount-price-on-services" id="on-service-discount-' . $servicename->id . '-' . $service->date . '"></td>
                                                        <td id="discount-on-' . $service->date . '-' . $servicename->id . '">' . $settings->currency . ' ' . ($price[$i] - $discount_pre[$i]) . '</td>                                                      
                                                        <td></td>
                                                    </tr>';
                            } else {
                                $option .= '<tr id="on-' . $service->date . '-' . $service_update[$i] . '">
                                                        <td>' . $servicename->name . '</td>
                                                        <td>' . $service->date . '</td>
                                                        <td>' . $nursename . '</td>
                                                        <td><input type="number" min="0" name="price_on_service[]" value="' . $price[$i] . '"class="price-on-services" id="on-service-price-' . $servicename->id . '"readonly></td>
                                                        <td> 1 </td>
                                                        <td>' . $settings->currency . ' ' . $price[$i] . '</td>
                                                       <td><input type="number" min="0" name="discount_on_service[]" value="' . $discount_pre[$i] . '"class="discount-price-on-services" id="on-service-discount-' . $servicename->id . '-' . $service->date . '"></td>
 <td id="discount-on-' . $service->date . '-' . $servicename->id . '">' . $settings->currency . ' ' . ($price[$i] - $discount_pre[$i]) . '</td>                                                     
<td class="no-print" id="delete-service-on-' . $date_explode[0] . '-' . $servicename->id . '"><button type="button" class="btn btn-danger btn-xs btn_width delete_service" title=' . lang('delete') . ' data-toggle=" "data-id="' . $service->id . "**" . $service_update[$i] . '"><i class="fa fa-trash"></i></button></td>
                                                    </tr>';
                            }
                        }
                    }
                }
            }
        }
        $services_all = $this->surgery_model->getOnServiceBySurgeryId($surgery_id);
        if (empty($services_all)) {
            $price_total = '0';
            $discount_total_new = '0';
            $grand_total_new = '0';
        } else {

            foreach ($services_all as $services) {
                $price_u = explode("**", $services->price);
                $discount_u = explode("**", $services->discount);
                $price_ups[] = array_sum($price_u);
                $discount_ups[] = array_sum($discount_u);
            }

            $price_total = array_sum($price_ups);
            $discount_total_new = array_sum($discount_ups);
            $grand_total_new = $price_total - $discount_total_new;
        }

        $arr['option'] = array('option' => $option, 'title' => lang('added'), 'total' => $price_total, 'discount' => $discount_total_new, 'grand' => $grand_total_new);
        $arr['nurses'] = $this->nurse_model->getNurseById($nurse);

        echo json_encode($arr);
    }

    function updateOnDiscount() {
        $discount = $this->input->post('discount');
        //$discount_update = implode("**", $discount);
        $id = $this->input->post('alloted');
        $date = $this->input->post('date');
        $service_id = $this->input->post('service');
        //$date = date('d-m-Y', time());
        $date_exist = $this->surgery_model->getOnServicesByDate($date);
        $service_update = explode("**", $date_exist->service);
        $discount_update = explode("**", $date_exist->discount);
        for ($i = 0; $i < count($service_update); $i++) {
            if ($service_update[$i] == $service_id) {
                $discount_new[] = $discount;
            } else {
                $discount_new[] = $discount_update[$i];
            }
        }
        $discount_update_new = implode("**", $discount_new);
        $data = array();
        $data = array('discount' => $discount_update_new);
        $this->surgery_model->updateOnServices($date_exist->id, $data);
        $price = $this->input->post('price');
        $services_all = $this->surgery_model->getOnServiceBySurgeryId($date_exist->surgery_id);
        if (empty($services_all)) {
            $price_total = '0';
            $discount_total_new = '0';
            $grand_total_new = '0';
        } else {
            foreach ($services_all as $services) {
                $price_u = explode("**", $services->price);
                $discount_u = explode("**", $services->discount);
                $price_ups[] = array_sum($price_u);
                $discount_ups[] = array_sum($discount_u);
            }

            $price_total = array_sum($price_ups);
            $discount_total_new = array_sum($discount_ups);
            $grand_total_new = $price_total - $discount_total_new;
        }
        $data['total'] = $price_total;
        $data['discount'] = $discount_total_new;
        $data['grand_total'] = $grand_total_new;

        echo json_encode($data);
    }

    public function createOnServiceInvoice() {
        $id = $this->input->get('id');
        $service_list = $this->surgery_model->getOnServicedByIdByDate($id);
        $previous_payment_ids = $service_list->payment_id;
        if (!empty($service_list)) {
            $price = explode("**", $service_list->price);
            $services = explode("**", $service_list->service);
            $discounts = explode("**", $service_list->discount);
            $i = 0;
            if (!empty($service_list->payment_id)) {
                $paymentid = explode(",", $service_list->payment_id);
                foreach ($paymentid as $key => $payment) {
                    $payment_details = $this->finance_model->getPaymentById($payment);
                    $payment_cat = explode("#", $payment_details->category_name);
                    foreach ($payment_cat as $key => $pay) {
                        $cat_name = explode("*", $pay);
                        $previous_invoice_service[] = $cat_name[0];
                    }
                }
            } else {
                $previous_invoice_service = [];
            }
            for ($i = 0; $i < count($services); $i++) {
                if (!in_array($services[$i], $previous_invoice_service)) {
                    $service_new[] = $services[$i] . '*' . $price[$i] . '*' . $discounts[$i];
                    $arr['ids'] = $services[$i];
                }
                //$i++;
            }
            if (!empty($service_new)) {
                $service_implode = implode("#", $service_new);
                $total = array_sum($price);
                $discount = array_sum($discounts);
                $grand = $total - $discount;
                $bed_alloted = $this->surgery_model->getSurgeryById($id);
                $patient = $this->patient_model->getPatientById($bed_alloted->patient_id);
                // $doctor = $this->doctor_model->getDoctorById($bed_alloted->doctor);
                $date = time();
                $date_string = date('d-m-Y');
                $data = array(
                    'category_name' => $service_implode,
                    'patient' => $patient->id,
                    'date' => $date,
                    'amount' => $total,
                    'discount' => $discount,
                    // 'doctor' => $bed_alloted->doctor,
                    'gross_total' => $grand,
                    'status' => 'unpaid',
                    'hospital_amount' => $grand,
                    'doctor_amount' => '0',
                    'user' => $this->ion_auth->get_user_id(),
                    'patient_name' => $patient->name,
                    'patient_phone' => $patient->phone,
                    'patient_address' => $patient->address,
                    // 'doctor_name' => $doctor->name,
                    'date_string' => $date_string,
                    'payment_from' => 'pre_service'
                );
                $this->finance_model->insertPayment($data);
                $inserted_id = $this->db->insert_id('payment');
                if (!empty($previous_payment_ids)) {
                    $new_payment_id = $previous_payment_ids . ',' . $inserted_id;
                } else {
                    $new_payment_id = $inserted_id;
                }
                $data = array('payment_id' => $new_payment_id);
                $this->surgery_model->updateOnServices($service_list->id, $data);
                $arr['date'] = date('d');
                $arr['message'] = array('message' => lang('invoice') . ' ' . lang('generated'), 'title' => lang('invoice') . ' ' . lang('generated'));
            } else {
                $arr['ids'] = '1';
                $arr['message'] = array('message' => lang('no_new_service_add'), 'title' => lang('no_new_service_add'));
            }
        } else {
            $arr['ids'] = '1';
            $arr['message'] = array('message' => lang('no_new_service_add'), 'title' => lang('no_new_service_add'));
        }

        echo json_encode($arr);
    }

    function deletePostSurgeryServices() {
        $id = $this->input->get('id');
        $service = explode("**", $id);
        $service_details = $this->surgery_model->getPostServiceById($service[0]);
        $surgery_id = $service_details->surgery_id;
        $services_database = explode("**", $service_details->service);
        $prices_database = explode("**", $service_details->price);
        $discount_database = explode("**", $service_details->discount);
        if (!empty($service_details->payment_id)) {
            $payment_explode = explode(",", $service_details->payment_id);
            for ($i = 0; $i < count($payment_explode); $i++) {
                $payment_details = array();
                $payment_details = $this->finance_model->getPaymentById($payment_explode[$i]);
                $payment_d = array();
                $price_update = array();
                $price_up = array();
                $payment_d = explode("#", $payment_details->category_name);
                foreach ($payment_d as $key => $value) {
                    $pay_service = array();
                    $pay_service = explode("*", $value);
                    if ($service[1] == $pay_service[0]) {
                        continue;
                    } else {
                        $price_update[] = $pay_service[0] . '*' . $pay_service[1] . '*' . $pay_service[2];
                        $price_up[] = $pay_service[1];
                        $discount_up[] = $pay_service[2];
                    }
                }
                if (!empty($price_update)) {
                    $pay_update = implode("#", $pay_update);
                    $total = array_sum($price_up);
                    $discount = array_sum($discount_up);
                    $grand_total = $total - $discount;
                    $data_payment = array();
                    $data_payment = array(
                        'category_name' => $cat_new_update,
                        'amount' => $total,
                        'gross_total' => $grand_total,
                        'hospital_amount' => $total,
                        'discount' => $discount
                    );
                    $this->finance_model->updatePayment($payment_explode[$i], $data_payment);
                    $payment_id[] = $payment_explode[$i];
                } else {
                    $this->finance_model->deletePayment($payment_explode[$i]);
                }
            }
        }
        for ($i = 0; $i < sizeof($services_database); $i++) {
            if ($service[1] != $services_database[$i]) {
                $service_new[] = $services_database[$i];
                $price_new[] = $prices_database[$i];
                $discount_new[] = $discount_database[$i];
            }
        }
        $data = array(
            'price' => implode("**", $price_new),
            'service' => implode("**", $service_new),
            'discount' => implode("**", $discount_new),
            'payment_id' => implode(",", $payment_id),
        );
        if (empty($price_new)) {
            $this->surgery_model->deletePostServices($id);
        } else {
            $this->surgery_model->updatePostServices($id, $data);
        }
        /*   $services_post = $this->surgery_model->getPostServiceById($id);
          $payment_update=array();
          if(!empty($services_post->payment_id)){
          $payments= explode(",",$services_post->payment_id);
          foreach ($payments as $payment_p){
          $payment_pk= $this->finance_model->getPaymentById($payment_p);
          if(empty($payment_pk->category_name)){
          $this->finance_model->deletePayment($payment_p);
          }else{
          array_push($payment_update, $payment_p);
          }
          }
          $data_up=array('payment_id'=> implode(",", $payment_update));
          $this->surgery_model->updatePostServices($id, $data_up);
          } */
        $services_all = $this->surgery_model->getPostServiceBySurgeryId($surgery_id);
        if (empty($services_all)) {
            $price_total = '0';
            $discount_total_new = '0';
            $grand_total_new = '0';
        } else {
            foreach ($services_all as $services) {
                $price_u = explode("**", $services->price);
                $discount_u = explode("**", $services->discount);
                $price_ups[] = array_sum($price_u);
                $discount_ups[] = array_sum($discount_u);
            }

            $price_total = array_sum($price_ups);
            $discount_total_new = array_sum($discount_ups);
            $grand_total_new = $price_total - $discount_total_new;
        }

        $arr['message'] = array('message' => lang('delete'), 'title' => lang('delete'), 'date' => $service_details->date, 'total' => $price_total, 'discount' => $discount_total_new, 'grand' => $grand_total_new);
        // $arr['date1'] = array();
        echo json_encode($arr);
    }

    function updateServicesPostSurgery() {
        $pservice = $this->input->post('arr');
//$discount_id= $this->input->post('discount_id');
//$discount= $this->input->post('discount');
//if(!empty(discount))
        $surgery_id = $this->input->post('alloted');
        $nurse = $this->input->post('nurse');
        $date = date('d-m-Y', time());
        $date_exist1 = $this->surgery_model->getPostServicesByDate($date);

        if (!empty($pservice)) {
            foreach ($pservice as $p_service) {
                $price_pservice = $this->pservice_model->getPserviceById($p_service);
                $price[] = $price_pservice->price;
                if (empty($date_exist1)) {
                    $discount[] = '0';
                } else {
                    $pservice_update_for_discount = array();
                    $for_discount = array();
                    $pservice_update_for_discount = explode("**", $date_exist1->service);
                    $for_discount = explode("**", $date_exist1->discount);
                    $i = 0;
                    if (in_array($p_service, $pservice_update_for_discount)) {
                        $key = array_search($p_service, $pservice_update_for_discount);
                        $discount[] = $for_discount[$key];
                    } else {
                        $discount[] = '0';
                    }
                }
                //
            }
            $price_update = implode("**", $price);
            $pservice_update = implode("**", $pservice);
            $discount_update = implode("**", $discount);
            //  $discounr_update=implode('**',$discount);
            $data = array();
            $data = array('date' => $date,
                'nurse' => $nurse,
                'service' => $pservice_update,
                'price' => $price_update,
                'discount' => $discount_update,
                'surgery_id' => $this->input->post('alloted')
            );
        }
        $date_exist = $this->surgery_model->getPostServicesByDate($date);
        if (!empty($date_exist)) {
            if (empty($pservice)) {
                $payment_ids = explode(",", $date_exist->payment_id);
                if (!empty($payment_ids)) {
                    for ($i = 0; $i < count($payment_ids); $i++) {
                        $this->finance_model->deletePayment($payment_ids[$i]);
                    }
                }
                $this->surgery_model->deletePostServices($date_exist->id);
                $arr['message'] = array('message' => lang('updated'), 'title' => lang('updated'));
            } else {
                $this->surgery_model->updatePostServices($date_exist->id, $data);
                $inserted_id = $date_exist->id;
                $arr['message'] = array('message' => lang('updated'), 'title' => lang('updated'));
            }
        } else {
            $this->surgery_model->insertPostServices($data);
            $inserted_id = $this->db->insert_id('pre_service');
            $arr['message'] = array('message' => lang('added'), 'title' => lang('added'));
        }
        $daily_service = $this->surgery_model->getPostServiceBySurgeryId($this->input->post('alloted'));

        $settings = $this->settings_model->getSettings();


        foreach ($daily_service as $service) {
            $pay_service = array();
            $pay_service_new = array();
            if (!empty($service->payment_id)) {
                $payment_explode = explode(",", $service->payment_id);
                for ($i = 0; $i < count($payment_explode); $i++) {
                    $payment_details = array();
                    $payment_details = $this->finance_model->getPaymentById($payment_explode[$i]);
                    $payment_d = array();
                    $payment_d = explode("#", $payment_details->category_name);
                    foreach ($payment_d as $key => $value) {
                        $pay_service = explode("*", $value);
                        $pay_service_new[] = $pay_service[0];
                    }
                }
            }
            $price = explode("**", $service->price);
            $discount_pre = explode("**", $service->discount);
            $total_price = array_sum($price);
            $total_discount = array_sum($discount_pre);
            $grand_total = $total_price - $total_discount;
            $service_update = explode("**", $service->service);
            //  print_r($price);
            // die();
            //$array = array_combine($service, $price);
            $length = sizeof($price);
            $length1 = sizeof($service_update);
            if ($length == $length1) {
                $i = 0;
                for ($i = 0; $i < $length; $i++) {
                    $servicename = $this->db->get_where('pservice', array('id' => $service_update[$i]))->row();

                    if (!empty($service->nurse)) {
                        $nursename = $this->db->get_where('nurse', array('id' => $service->nurse))->row()->name;
                    } else {
                        $nursename = " ";
                    }
                    $date_explode = explode("-", $service->date);
                    if ($this->ion_auth->in_group(array('admin'))) {
                        $option .= '<tr id="post-' . $service->date . '-' . $service_update[$i] . '">
                                                        <td>' . $servicename->name . '</td>
                                                        <td>' . $service->date . '</td>
                                                        <td>' . $nursename . '</td>
                                                        <td><input type="number" min="0" name="price_post_service[]" value="' . $price[$i] . '"class="price-post-services" id="post-service-price-' . $servicename->id . '"readonly></td>
                                                        <td> 1 </td>
                                                        <td>' . $settings->currency . ' ' . $price[$i] . '</td>
                                                        <td><input type="number" min="0" name="discount_post_service[]" value="' . $discount_pre[$i] . '"class="discount-price-post-services" id="post-service-discount-' . $servicename->id . '-' . $service->date . '"></td>
 <td id="discount-post-' . $service->date . '-' . $servicename->id . '">' . $settings->currency . ' ' . ($price[$i] - $discount_pre[$i]) . '</td>                                                       
<td class="no-print" id="delete-service-post-' . $date_explode[0] . '-' . $servicename->id . '"><button type="button" class="btn btn-danger btn-xs btn_width delete_service" title=' . lang('delete') . ' data-toggle=" "data-id="' . $service->id . "**" . $service_update[$i] . '"><i class="fa fa-trash"></i></button></td>
                                                    </tr>';
                    } else {
                        if (empty($service->payment_id)) {
                            $option .= '<tr id="on-' . $service->date . '-' . $service_update[$i] . '">
                                                        <td>' . $servicename->name . '</td>
                                                        <td>' . $service->date . '</td>
                                                        <td>' . $nursename . '</td>
                                                        <td><input type="number" min="0" name="price_post_service[]" value="' . $price[$i] . '"class="price-post-services" id="post-service-price-' . $servicename->id . '"readonly></td>
                                                        <td> 1 </td>
                                                        <td>' . $settings->currency . ' ' . $price[$i] . '</td>
                                                                 <td><input type="number" min="0" name="discount_post_service[]" value="' . $discount_pre[$i] . '"class="discount-price-post-services" id="post-service-discount-' . $servicename->id . '-' . $service->date . '"></td>
 <td id="discount-post-' . $service->date . '-' . $servicename->id . '">' . $settings->currency . ' ' . ($price[$i] - $discount_pre[$i]) . '</td>                                                        
<td class="no-print" id="delete-service-post-' . $date_explode[0] . '-' . $servicename->id . '"><button type="button" class="btn btn-danger btn-xs btn_width delete_service" title=' . lang('delete') . ' data-toggle=" "data-id="' . $service->id . "**" . $service_update[$i] . '"><i class="fa fa-trash"></i></button></td>
                                                    </tr>';
                        } else {
                            if (in_array($servicename->id, $pay_service_new)) {
                                $option .= '<tr id="on-' . $service->date . '-' . $service_update[$i] . '">
                                                        <td>' . $servicename->name . '</td>
                                                        <td>' . $service->date . '</td>
                                                        <td>' . $nursename . '</td>
                                                        <td><input type="number" min="0" name="price_post_service[]" value="' . $price[$i] . '"class="price-post-services" id="post-service-price-' . $servicename->id . '"readonly></td>
                                                        <td> 1 </td>
                                                        <td>' . $settings->currency . ' ' . $price[$i] . '</td>
                                                        <td><input type="number" min="0" name="discount_post_service[]" value="' . $discount_pre[$i] . '"class="discount-price-post-services" id="post-service-discount-' . $servicename->id . '-' . $service->date . '"></td>
                                                        <td id="discount-post-' . $service->date . '-' . $servicename->id . '">' . $settings->currency . ' ' . ($price[$i] - $discount_pre[$i]) . '</td>                                                      
                                                        <td></td>
                                                    </tr>';
                            } else {
                                $option .= '<tr id="on-' . $service->date . '-' . $service_update[$i] . '">
                                                        <td>' . $servicename->name . '</td>
                                                        <td>' . $service->date . '</td>
                                                        <td>' . $nursename . '</td>
                                                        <td><input type="number" min="0" name="price_post_service[]" value="' . $price[$i] . '"class="price-post-services" id="post-service-price-' . $servicename->id . '"readonly></td>
                                                        <td> 1 </td>
                                                        <td>' . $settings->currency . ' ' . $price[$i] . '</td>
                                                       <td><input type="number" min="0" name="discount_post_service[]" value="' . $discount_pre[$i] . '"class="discount-price-post-services" id="post-service-discount-' . $servicename->id . '-' . $service->date . '"></td>
 <td id="discount-post-' . $service->date . '-' . $servicename->id . '">' . $settings->currency . ' ' . ($price[$i] - $discount_pre[$i]) . '</td>                                                     
<td class="no-print" id="delete-service-post-' . $date_explode[0] . '-' . $servicename->id . '"><button type="button" class="btn btn-danger btn-xs btn_width delete_service" title=' . lang('delete') . ' data-toggle=" "data-id="' . $service->id . "**" . $service_update[$i] . '"><i class="fa fa-trash"></i></button></td>
                                                    </tr>';
                            }
                        }
                    }
                }
            }
        }
        $services_all = $this->surgery_model->getPostServiceBySurgeryId($surgery_id);
        if (empty($services_all)) {
            $price_total = '0';
            $discount_total_new = '0';
            $grand_total_new = '0';
        } else {

            foreach ($services_all as $services) {
                $price_u = explode("**", $services->price);
                $discount_u = explode("**", $services->discount);
                $price_ups[] = array_sum($price_u);
                $discount_ups[] = array_sum($discount_u);
            }

            $price_total = array_sum($price_ups);
            $discount_total_new = array_sum($discount_ups);
            $grand_total_new = $price_total - $discount_total_new;
        }

        $arr['option'] = array('option' => $option, 'title' => lang('added'), 'total' => $price_total, 'discount' => $discount_total_new, 'grand' => $grand_total_new);
        $arr['nurses'] = $this->nurse_model->getNurseById($nurse);

        echo json_encode($arr);
    }

    function updatePostDiscount() {
        $discount = $this->input->post('discount');
        //$discount_update = implode("**", $discount);
        $id = $this->input->post('alloted');
        $date = $this->input->post('date');
        $service_id = $this->input->post('service');
        //$date = date('d-m-Y', time());
        $date_exist = $this->surgery_model->getPostServicesByDate($date);
        $service_update = explode("**", $date_exist->service);
        $discount_update = explode("**", $date_exist->discount);
        for ($i = 0; $i < count($service_update); $i++) {
            if ($service_update[$i] == $service_id) {
                $discount_new[] = $discount;
            } else {
                $discount_new[] = $discount_update[$i];
            }
        }
        $discount_update_new = implode("**", $discount_new);
        $data = array();
        $data = array('discount' => $discount_update_new);
        $this->surgery_model->updatePostServices($date_exist->id, $data);
        $price = $this->input->post('price');
        $services_all = $this->surgery_model->getPostServiceBySurgeryId($date_exist->surgery_id);
        if (empty($services_all)) {
            $price_total = '0';
            $discount_total_new = '0';
            $grand_total_new = '0';
        } else {
            foreach ($services_all as $services) {
                $price_u = explode("**", $services->price);
                $discount_u = explode("**", $services->discount);
                $price_ups[] = array_sum($price_u);
                $discount_ups[] = array_sum($discount_u);
            }

            $price_total = array_sum($price_ups);
            $discount_total_new = array_sum($discount_ups);
            $grand_total_new = $price_total - $discount_total_new;
        }
        $data['total'] = $price_total;
        $data['discount'] = $discount_total_new;
        $data['grand_total'] = $grand_total_new;

        echo json_encode($data);
    }

    public function createPostServiceInvoice() {
        $id = $this->input->get('id');
        $service_list = $this->surgery_model->getPostServicedByIdByDate($id);
        $previous_payment_ids = $service_list->payment_id;
        if (!empty($service_list)) {
            $price = explode("**", $service_list->price);
            $services = explode("**", $service_list->service);
            $discounts = explode("**", $service_list->discount);
            $i = 0;
            if (!empty($service_list->payment_id)) {

                $paymentid = explode(",", $service_list->payment_id);
                foreach ($paymentid as $key => $payment) {

                    $payment_details = $this->finance_model->getPaymentById($payment);
                    // print_r($payment_details);
                    $k = 0;
                    $payment_cat = explode("#", $payment_details->category_name);
                    foreach ($payment_cat as $key => $pay) {
                        $cat_name = explode("*", $pay);
                        //array_push($previous_invoice_service, $cat_name[0]);
                        $previous_invoice_service[$k] = $cat_name[0];
                        $k++;
                    }
                }
            } else {
                $previous_invoice_service = array();
            }

            for ($i = 0; $i < count($services); $i++) {
                if (!in_array($services[$i], $previous_invoice_service)) {
                    $service_new[$i] = $services[$i] . '*' . $price[$i] . '*' . $discounts[$i];
                    //  array_push($arr['ids'], $services[$i]);
                    $arr['ids'] = $services[$i];
                }
                //$i++;
            }

            if (!empty($service_new)) {
                $service_implode = implode("#", $service_new);
                $total = array_sum($price);
                $discount = array_sum($discounts);
                $grand = $total - $discount;
                $bed_alloted = $this->surgery_model->getSurgeryById($id);
                $patient = $this->patient_model->getPatientById($bed_alloted->patient_id);
                // $doctor = $this->doctor_model->getDoctorById($bed_alloted->doctor);
                $date = time();
                $date_string = date('d-m-Y');
                $data = array(
                    'category_name' => $service_implode,
                    'patient' => $patient->id,
                    'date' => $date,
                    'amount' => $total,
                    'discount' => $discount,
                    // 'doctor' => $bed_alloted->doctor,
                    'gross_total' => $grand,
                    'status' => 'unpaid',
                    'hospital_amount' => $grand,
                    'doctor_amount' => '0',
                    'user' => $this->ion_auth->get_user_id(),
                    'patient_name' => $patient->name,
                    'patient_phone' => $patient->phone,
                    'patient_address' => $patient->address,
                    // 'doctor_name' => $doctor->name,
                    'date_string' => $date_string,
                    'payment_from' => 'post_service'
                );
                $this->finance_model->insertPayment($data);
                $inserted_id = $this->db->insert_id('payment');
                if (!empty($previous_payment_ids)) {
                    $new_payment_id = $previous_payment_ids . ',' . $inserted_id;
                } else {
                    $new_payment_id = $inserted_id;
                }
                $data = array('payment_id' => $new_payment_id);
                $this->surgery_model->updatePostServices($service_list->id, $data);
                $arr['date'] = date('d');
                $arr['message'] = array('message' => lang('invoice') . ' ' . lang('generated'), 'title' => lang('invoice') . ' ' . lang('generated'));
            } else {
                $arr['ids'] = '1';
                $arr['message'] = array('message' => lang('no_new_service_add'), 'title' => lang('no_new_service_add'));
            }
        } else {
            $arr['ids'] = '1';
            $arr['message'] = array('message' => lang('no_new_service_add'), 'title' => lang('no_new_service_add'));
        }

        echo json_encode($arr);
    }

    function updateCheckout() {
        $id = $this->input->post('id');

        $doctor = $this->input->post('doctors_checkout');
        $surgery_id = $this->input->post('surgery_id');
        $d_time = $this->input->post('d_time');
        $type_of_admission = implode(",", $this->input->post('type_of_admission'));

        $diagnosis_at_admission = $this->input->post('diagnosis_at_admission');
        $patient_status_at_admission_objective_admission = $this->input->post('patient_status_at_admission_objective_admission');
        $course_of_disease = $this->input->post('course_of_disease');
        $laboratory_examination_results = $this->input->post('laboratory_examination_results');
        $applied_therapy = $this->input->post('applied_therapy');
        $diagnosis_at_discharge = $this->input->post('diagnosis_at_discharge');
        $result = implode(",", $this->input->post('result'));
        $therapy = $this->input->post('therapy');

        $next_examination = $this->input->post('next_examination');
        $ability_to_work = $this->input->post('ability_to_work');
        $advises_given_to = $this->input->post('advises_given_to');
        $hospital_name = $this->input->post('hospital_name');
        $physican_name = $this->input->post('physican_name');
        $contact_no = $this->input->post('contact_no');
        $legal_custodiam = $this->input->post('legal_custodiam');
        $data = array();
        $data = array('date' => $d_time,
            'type_of_admission' => $type_of_admission,
            'surgery_id' => $surgery_id,
            'doctor' => $doctor,
            'diagnosis_at_admission' => $diagnosis_at_admission,
            'patient_status_at_admission_objective_admission' => $patient_status_at_admission_objective_admission,
            'course_of_disease' => $course_of_disease,
            'laboratory_examination_results' => $laboratory_examination_results,
            'applied_therapy' => $applied_therapy,
            'diagnosis_at_discharge' => $diagnosis_at_discharge,
            'result' => $result,
            'therapy' => $therapy,
            'next_examination' => $next_examination,
            'ability_to_work' => $ability_to_work,
            'advises_given_to' => $advises_given_to,
            'hospital_name' => $hospital_name,
            'physican_name' => $physican_name,
            'contact_no' => $contact_no,
            'legal_custodiam' => $legal_custodiam,
        );

        if (!empty($id)) {
            $this->surgery_model->updateCheckout($id, $data);
            $inserted_id = $id;
            $data['message'] = array('message' => lang('updated'), 'title' => lang('updated'));
        } else {
            $this->surgery_model->insertCheckout($data);
            $inserted_id = $this->db->insert_id();
            $data['message'] = array('message' => lang('added'), 'title' => lang('added'));
        }
        $data['checkout'] = $this->surgery_model->getCheckoutdById($inserted_id);
        //  $checkin= $this->surgery_model->getSurgeryCheckinById($surgery_id);
        //  $d_time_array = array();
        // $d_time_array = explode("-", $d_time);
        //  $d_timestamp = strtotime($d_time_array[0] . ' ' . $d_time_array[1]);
        //   $data_update = array('d_time' => $d_time, 'd_timestamp' => $d_timestamp);
        //  $this->bed_model->updateAllotment($alloted_bed_id, $data_update);
        echo json_encode($data);
    }

}
