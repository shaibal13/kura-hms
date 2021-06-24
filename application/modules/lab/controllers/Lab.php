<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lab extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('lab_model');
        $this->load->model('doctor/doctor_model');
        $this->load->model('patient/patient_model');
        $this->load->model('accountant/accountant_model');
        $this->load->model('finance/finance_model');
        $this->load->model('surgery/surgery_model');
        $this->load->model('receptionist/receptionist_model');
        $this->load->model('packages/packages_model');
        $this->load->model('laboratorist/laboratorist_model');
        $this->load->model('log/log_model');
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
        if ($this->ion_auth->in_group(array('pharmacist'))) {
            redirect('home/permission');
        }
    }

    public function index() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        if ($this->ion_auth->in_group(array('Patient'))) {
            redirect('home/permission');
        }

        if ($this->ion_auth->in_group(array('Receptionist'))) {
            redirect('lab/lab1');
        }

        $id = $this->input->get('id');

        $data['settings'] = $this->settings_model->getSettings();
        $data['labs'] = $this->lab_model->getLab();

        if (!empty($id)) {
            $data['lab_single'] = $this->lab_model->getLabById($id);
            $data['patients'] = $this->patient_model->getPatientById($data['lab_single']->patient);
            $data['doctors'] = $this->doctor_model->getDoctorById($data['lab_single']->doctor);
            $data['laboratorist'] = $this->laboratorist_model->getLaboratoristById($data['lab_single']->laboratorist);
            $data['laboratorists'] = $this->laboratorist_model->getLaboratorist();
        }

        $data['templates'] = $this->lab_model->getTemplate();
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->lab_model->getLabCategory();


        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('lab', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function lab() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        if ($this->ion_auth->in_group(array('Patient'))) {
            redirect('home/permission');
        }

        $id = $this->input->get('id');



        $data['templates'] = $this->lab_model->getTemplate();
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->lab_model->getLabCategory();
        $data['patients'] = $this->patient_model->getPatient();
        $data['doctors'] = $this->doctor_model->getDoctor();

        $data['settings'] = $this->settings_model->getSettings();
        $data['labs'] = $this->lab_model->getLab();

        if (!empty($id)) {
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('add_lab_view', $data);
            $this->load->view('home/footer'); // just the header file
        } else {
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('lab', $data);
            $this->load->view('home/footer'); // just the header file
        }
    }

    public function lab1() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $id = $this->input->get('id');

        $data['settings'] = $this->settings_model->getSettings();
        $data['labs'] = $this->lab_model->getLab();

        if (!empty($id)) {
            $data['lab_single'] = $this->lab_model->getLabById($id);
            $data['laboratorist'] = $this->laboratorist_model->getLaboratoristById($data['lab_single']->laboratorist);
        }

        $data['templates'] = $this->lab_model->getTemplate();
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->lab_model->getLabCategory();
        $data['patients'] = $this->patient_model->getPatient();
        $data['doctors'] = $this->doctor_model->getDoctor();

        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('lab_1', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addLabView() {
        $data = array();


        $id = $this->input->get('id');

        if (!empty($id)) {
            $data['lab'] = $this->lab_model->getLabById($id);
            $data['patients'] = $this->patient_model->getPatientById($data['lab_single']->patient);
            $data['doctors'] = $this->doctor_model->getDoctorById($data['lab_single']->doctor);
        }

        $data['templates'] = $this->lab_model->getTemplate();
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->lab_model->getLabCategory();
        // $data['patients'] = $this->patient_model->getPatient();
        // $data['doctors'] = $this->doctor_model->getDoctor();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_lab_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addLab() {
        $id = $this->input->post('id');

        $report = $this->input->post('report');

        $patient = $this->input->post('patient');
        $laboratorist = $this->input->post('laboratorist');
        $redirect = $this->input->post('redirect');

        $p_name = $this->input->post('p_name');
        $p_email = $this->input->post('p_email');
        if (empty($p_email)) {
            $p_email = $p_name . '-' . rand(1, 1000) . '-' . $p_name . '-' . rand(1, 1000) . '@example.com';
        }
        if (!empty($p_name)) {
            $password = $p_name . '-' . rand(1, 100000000);
        }
        $p_phone = $this->input->post('p_phone');
        $p_age = $this->input->post('p_age');
        $p_gender = $this->input->post('p_gender');
        $add_date = date('m/d/y');


        $patient_id = rand(10000, 1000000);



        $d_name = $this->input->post('d_name');
        $d_email = $this->input->post('d_email');
        if (empty($d_email)) {
            $d_email = $d_name . '-' . rand(1, 1000) . '-' . $d_name . '-' . rand(1, 1000) . '@example.com';
        }
        if (!empty($d_name)) {
            $password = $d_name . '-' . rand(1, 100000000);
        }
        $d_phone = $this->input->post('d_phone');

        $doctor = $this->input->post('doctor');
        $date = $this->input->post('date');
        if (!empty($date)) {
            $date = strtotime($date);
        } else {
            $date = time();
        }
        $date_string = date('d-m-y', $date);
        $discount = $this->input->post('discount');
        $amount_received = $this->input->post('amount_received');
        $user = $this->ion_auth->get_user_id();

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

// Validating Category Field
// $this->form_validation->set_rules('category_amount[]', 'Category', 'min_length[1]|max_length[100]');
// Validating Price Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Price Field
        $this->form_validation->set_rules('discount', 'Discount', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            redirect('lab/addLabView');
        } else {
            if (!empty($p_name)) {

                $data_p = array(
                    'patient_id' => $patient_id,
                    'name' => $p_name,
                    'email' => $p_email,
                    'phone' => $p_phone,
                    'sex' => $p_gender,
                    'age' => $p_age,
                    'add_date' => $add_date,
                    'how_added' => 'from_pos'
                );
                $username = $this->input->post('p_name');
// Adding New Patient
                if ($this->ion_auth->email_check($p_email)) {
                    $this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
                } else {
                    $dfg = 5;
                    $this->ion_auth->register($username, $password, $p_email, $dfg);
                    $ion_user_id = $this->db->get_where('users', array('email' => $p_email))->row()->id;
                    $this->patient_model->insertPatient($data_p);
                    $patient_user_id = $this->db->get_where('patient', array('email' => $p_email))->row()->id;
                    $id_info = array('ion_user_id' => $ion_user_id);
                    $this->patient_model->updatePatient($patient_user_id, $id_info);
                }
//    }
            }

            if (!empty($d_name)) {

                $data_d = array(
                    'name' => $d_name,
                    'email' => $d_email,
                    'phone' => $d_phone,
                );
                $username = $this->input->post('d_name');
// Adding New Patient
                if ($this->ion_auth->email_check($d_email)) {
                    $this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
                } else {
                    $dfgg = 4;
                    $this->ion_auth->register($username, $password, $d_email, $dfgg);
                    $ion_user_id = $this->db->get_where('users', array('email' => $d_email))->row()->id;
                    $this->doctor_model->insertDoctor($data_d);
                    $doctor_user_id = $this->db->get_where('doctor', array('email' => $d_email))->row()->id;
                    $id_info = array('ion_user_id' => $ion_user_id);
                    $this->doctor_model->updateDoctor($doctor_user_id, $id_info);
                }
            }


            if ($patient == 'add_new') {
                $patient = $patient_user_id;
            }

            if ($doctor == 'add_new') {
                $doctor = $doctor_user_id;
            }

            if (!empty($patient)) {
                $patient_details = $this->patient_model->getPatientById($patient);
                $patient_name = $patient_details->name;
                $patient_phone = $patient_details->phone;
                $patient_address = $patient_details->address;
            } else {
                $patient_name = 0;
                $patient_phone = 0;
                $patient_address = 0;
            }

            if (!empty($doctor)) {
                $doctor_details = $this->doctor_model->getDoctorById($doctor);
                $doctor_name = $doctor_details->name;
            } else {
                $doctor_name = 0;
            }

            $data = array();

            if (empty($id)) {
                $data = array(
                    // 'category_name' => $category_name,
                    'report' => $report,
                    'patient' => $patient,
                    'date' => $date,
                    'doctor' => $doctor,
                    'laboratorist' => $laboratorist,
                    'user' => $user,
                    'patient_name' => $patient_name,
                    'patient_phone' => $patient_phone,
                    'patient_address' => $patient_address,
                    'doctor_name' => $doctor_name,
                    'date_string' => $date_string,
                    'to_be_id' => $this->input->post('id_from_to_be')
                );


                $this->lab_model->insertLab($data);
                $inserted_id = $this->db->insert_id();
                $this->log_model->insertLog($this->ion_auth->get_user_id(), date('d-m-Y H:i:s', time()), 'Add New Lab Reports (id='.$inserted_id.' )', $inserted_id);
                $this->session->set_flashdata('feedback', lang('added'));
                redirect($redirect);
            } else {
                $data = array(
                    //   'category_name' => $category_name,
                    'report' => $report,
                    'patient' => $patient,
                    'doctor' => $doctor,
                    'user' => $user,
                    'patient_name' => $patient_details->name,
                    'patient_phone' => $patient_details->phone,
                    'patient_address' => $patient_details->address,
                    'doctor_name' => $doctor_details->name,
                    'laboratorist' => $laboratorist,
                    'to_be_id' => $this->input->post('id_from_to_be')
                );
                $this->lab_model->updateLab($id, $data);
                $this->log_model->insertLog($this->ion_auth->get_user_id(), date('d-m-Y H:i:s', time()), 'Edit Lab Reports (id=' . $id . ')', $id);
                $this->session->set_flashdata('feedback', lang('updated'));
                redirect($redirect);
            }
        }
    }

    function editLab() {
        if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Laboratorist', 'Nurse', 'Patient'))) {
            $data = array();
            $data['settings'] = $this->settings_model->getSettings();
            $data['categories'] = $this->lab_model->getLabCategory();
            $data['patients'] = $this->patient_model->getPatient();
            $data['doctors'] = $this->doctor_model->getDoctor();
            $id = $this->input->get('id');
            $data['lab'] = $this->lab_model->getLabById($id);
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('add_lab_view', $data);
            $this->load->view('home/footer'); // just the footer file
        }
    }

    function delete() {
        if ($this->ion_auth->in_group(array('admin', 'Laboratorist'))) {
            $id = $this->input->get('id');
            $this->lab_model->deleteLab($id);
            $this->log_model->insertLog($this->ion_auth->get_user_id(), date('d-m-Y H:i:s', time()), 'Deleted Lab Reports (id=' . $id . ')', $id);
            $this->session->set_flashdata('feedback', lang('deleted'));
            redirect('lab/lab');
        } else {
            redirect('home/permission');
        }
    }

    public function template() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['settings'] = $this->settings_model->getSettings();
        $data['templates'] = $this->lab_model->getTemplate();

        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('template', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addTemplateView() {
        $data = array();
        $id = $this->input->get('id');
        if (!empty($id)) {
            $data['template'] = $this->lab_model->getTemplateById($id);
        }

        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_template', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function getTemplateByIdByJason() {
        $id = $this->input->get('id');
        $data['template'] = $this->lab_model->getTemplateById($id);
        echo json_encode($data);
    }

    public function addTemplate() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $template = $this->input->post('template');
        $user = $this->ion_auth->get_user_id();


        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('report', 'Report', 'trim|min_length[1]|max_length[10000]|xss_clean');
// Validating Price Field
        $this->form_validation->set_rules('user', 'User', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            redirect('lab/addTemplate');
        } else {
            $data = array();
            if (empty($id)) {
                $data = array(
                    'name' => $name,
                    'template' => $template,
                    'user' => $user,
                );
                $this->lab_model->insertTemplate($data);
                $inserted_id = $this->db->insert_id();
                $this->session->set_flashdata('feedback', lang('added'));
                redirect("lab/addTemplateView?id=" . "$inserted_id");
            } else {
                $data = array(
                    'name' => $name,
                    'template' => $template,
                    'user' => $user,
                );
                $this->lab_model->updateTemplate($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
                redirect("lab/addTemplateView?id=" . "$id");
            }
        }
    }

    function editTemplate() {
        $permis = '';
        //  $permis_1 = '';
        foreach ($this->permission_access_group_explode as $perm) {
            $perm_explode = array();
            //$permis='';
            // $permis_1='';
            $perm_explode = explode(",", $perm);
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Lab') {
                $permis = 'ok';
                //  break;
            }
        }
        if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Laboratorist', 'Nurse', 'Patient')) || $permis == 'ok') {
            $data = array();
            $data['settings'] = $this->settings_model->getSettings();
            $id = $this->input->get('id');
            $data['template'] = $this->lab_model->getTemplateById($id);
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('add_template', $data);
            $this->load->view('home/footer'); // just the footer file
        }
    }

    function deleteTemplate() {
        $id = $this->input->get('id');
        $this->lab_model->deleteTemplate($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('lab/template');
    }

    public function labCategory() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['categories'] = $this->lab_model->getLabCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('lab_category', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addLabCategoryView() {
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_lab_category');
        $this->load->view('home/footer'); // just the header file
    }

    public function addLabCategory() {
        $id = $this->input->post('id');
        $category = $this->input->post('category');
        $description = $this->input->post('description');
        $reference = $this->input->post('reference_value');


        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
// Validating Category Name Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[1]|max_length[100]|xss_clean');
// Validating Description Field
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Description Field
        $this->form_validation->set_rules('reference_value', 'Reference Value', 'trim|required|min_length[1]|max_length[1000]|xss_clean');
// Validating Description Field
        $this->form_validation->set_rules('type', 'Type', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $this->session->set_flashdata('feedback', lang('vaidation_error'));
                redirect('lab/editLabCategory?id=' . $id);
            } else {
                $data = array();
                $data['setval'] = 'setval';
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_lab_category', $data);
                $this->load->view('home/footer'); // just the header file
            }
        } else {
            $data = array();
            $data = array('category' => $category,
                'description' => $description,
                'reference_value' => $reference,
            );
            if (empty($id)) {
                $this->lab_model->insertLabCategory($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->lab_model->updateLabCategory($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('lab/labCategory');
        }
    }

    function editLabCategory() {
        $data = array();
        $id = $this->input->get('id');
        $data['category'] = $this->lab_model->getLabCategoryById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_lab_category', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function deleteLabCategory() {
        $id = $this->input->get('id');
        $this->lab_model->deleteLabCategory($id);
        redirect('lab/labCategory');
    }

    function invoice() {
        $data = array();
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['lab'] = $this->lab_model->getLabById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('invoice', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function patientLabHistory() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $patient = $this->input->get('patient');
        if (empty($patient)) {
            $patient = $this->input->post('patient');
        }

        $date_from = strtotime($this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 86399;
        }

        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;

        if (!empty($date_from)) {
            $data['labs'] = $this->lab_model->getLabByPatientIdByDate($patient, $date_from, $date_to);
            $data['deposits'] = $this->lab_model->getDepositByPatientIdByDate($patient, $date_from, $date_to);
        } else {
            $data['labs'] = $this->lab_model->getLabByPatientId($patient);
            $data['pharmacy_labs'] = $this->pharmacy_model->getLabByPatientId($patient);
            $data['ot_labs'] = $this->lab_model->getOtLabByPatientId($patient);
            $data['deposits'] = $this->lab_model->getDepositByPatientId($patient);
        }



        $data['patient'] = $this->patient_model->getPatientByid($patient);
        $data['settings'] = $this->settings_model->getSettings();



        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('patient_deposit', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function financialReport() {
        $date_from = strtotime($this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 86399;
        }
        $data = array();
        $data['lab_categories'] = $this->lab_model->getLabCategory();
        $data['expense_categories'] = $this->lab_model->getExpenseCategory();


// if(empty($date_from)&&empty($date_to)) {
//    $data['labs']=$this->lab_model->get_lab();
//     $data['ot_labs']=$this->lab_model->get_ot_lab();
//     $data['expenses']=$this->lab_model->get_expense();
// }
// else{

        $data['labs'] = $this->lab_model->getLabByDate($date_from, $date_to);
        $data['ot_labs'] = $this->lab_model->getOtLabByDate($date_from, $date_to);
        $data['deposits'] = $this->lab_model->getDepositsByDate($date_from, $date_to);
        $data['expenses'] = $this->lab_model->getExpenseByDate($date_from, $date_to);
// } 
        $data['from'] = $this->input->post('date_from');
        $data['to'] = $this->input->post('date_to');
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('financial_report', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function getLab() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        $order = $this->input->post("order");
        $columns_valid = array(
            "0" => "id",
            "2" => "date",
        );
        $values = $this->settings_model->getColumnOrder($order, $columns_valid);
        $dir = $values[0];
        $order = $values[1];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['labs'] = $this->lab_model->getLabBysearch($search, $order, $dir);
            } else {
                $data['labs'] = $this->lab_model->getLabWithoutSearch($order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['labs'] = $this->lab_model->getLabByLimitBySearch($limit, $start, $search, $order, $dir);
            } else {
                $data['labs'] = $this->lab_model->getLabByLimit($limit, $start, $order, $dir);
            }
        }

        $permis = '';
        $permis_1 = '';
        foreach ($this->permission_access_group_explode as $perm) {
            $perm_explode = array();

            $perm_explode = explode(",", $perm);
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Lab') {
                $permis = 'ok';
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Lab') {
                $permis_1 = 'ok';
            }
        }
        $count = 0;
        foreach ($data['labs'] as $lab) {
            $date = date('d-m-y', $lab->date);
            if ($this->ion_auth->in_group(array('admin', 'Laboratorist', 'Doctor')) || $permis == 'ok') {
                $options1 = ' <a class="btn btn-info btn-xs editbutton" title="' . lang('edit') . '" href="lab?id=' . $lab->id . '"><i class="fa fa-edit"> </i> ' . lang('') . '</a>';
            } else {
                $options1 = '';
            }

            $options2 = '<a class="btn btn-xs invoicebutton" title="' . lang('lab') . '" style="color: #fff;" href="lab/invoice?id=' . $lab->id . '"><i class="fa fa-file"></i> ' . lang('') . '</a>';

            if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Laboratorist')) || $permis_1 == 'ok') {
                $options3 = '<a class="btn btn-info btn-xs delete_button" title="' . lang('delete') . '" href="lab/delete?id=' . $lab->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"></i>' . lang('') . '</a>';
            } else {
                $options3 = '';
            }

            $doctor_info = $this->doctor_model->getDoctorById($lab->doctor);
            if (!empty($doctor_info)) {
                $doctor = $doctor_info->name;
            } else {
                if (!empty($lab->doctor_name)) {
                    $doctor = $lab->doctor_name;
                } else {
                    $doctor = ' ';
                }
            }


            $patient_info = $this->patient_model->getPatientById($lab->patient);
            if (!empty($patient_info)) {
                $patient_details = $patient_info->name . '</br>' . $patient_info->address . '</br>' . $patient_info->phone . '</br>';
            } else {
                $patient_details = ' ';
            }
            if ($this->ion_auth->in_group(array('Laboratorist'))) {
                $user = $this->ion_auth->get_user_id();
                $laboratorist_details = $this->db->get_where('laboratorist', array('ion_user_id' => $user))->row();
                if ($lab->laboratorist == $laboratorist_details->id) {
                    $info[] = array(
                        $lab->id,
                        $patient_details,
                        $date,
                        $options1 . ' ' . $options2 . ' ' . $options3,
                    );
                    $count = $count + 1;
                }
            } else {
                $info[] = array(
                    $lab->id,
                    $patient_details,
                    $date,
                    $options1 . ' ' . $options2 . ' ' . $options3,
                );
                $count = $count + 1;
            }
        }


        if ($count != 0) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
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

    public function myLab() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $data['templates'] = $this->lab_model->getTemplate();
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->lab_model->getLabCategory();
        $data['patients'] = $this->patient_model->getPatient();
        $data['doctors'] = $this->doctor_model->getDoctor();

        $data['settings'] = $this->settings_model->getSettings();

        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('my_lab', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function getMyLab() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        $order = $this->input->post("order");
        $columns_valid = array(
            "0" => "id",
            "2" => "date",
        );
        $values = $this->settings_model->getColumnOrder($order, $columns_valid);
        $dir = $values[0];
        $order = $values[1];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['labs'] = $this->lab_model->getLabBysearch($search, $order, $dir);
            } else {
                $data['labs'] = $this->lab_model->getLabWithoutSearch($order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['labs'] = $this->lab_model->getLabByLimitBySearch($limit, $start, $search, $order, $dir);
            } else {
                $data['labs'] = $this->lab_model->getLabByLimit($limit, $start, $order, $dir);
            }
        }

        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_user_id = $this->ion_auth->get_user_id();
            $patient_id = $this->patient_model->getPatientByIonUserId($patient_user_id)->id;
        }

        foreach ($data['labs'] as $lab) {
            if ($patient_id == $lab->patient) {
                $date = date('d-m-y', $lab->date);

                $options2 = '<a class="btn btn-xs invoicebutton" title="' . lang('lab') . '" style="color: #fff;" href="lab/invoice?id=' . $lab->id . '"><i class="fa fa-file"></i> ' . lang('') . '</a>';

                $doctor_info = $this->doctor_model->getDoctorById($lab->doctor);
                if (!empty($doctor_info)) {
                    $doctor = $doctor_info->name;
                } else {
                    if (!empty($lab->doctor_name)) {
                        $doctor = $lab->doctor_name;
                    } else {
                        $doctor = ' ';
                    }
                }


                $patient_info = $this->patient_model->getPatientById($lab->patient);
                if (!empty($patient_info)) {
                    $patient_details = $patient_info->name . '</br>' . $patient_info->address . '</br>' . $patient_info->phone . '</br>';
                } else {
                    $patient_details = ' ';
                }
                $info[] = array(
                    $lab->id,
                    $patient_details,
                    $date,
                    $options2,
                        // $options2 . ' ' . $options3
                );
            }
        }


        if (!empty($data['labs'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('lab')->num_rows(),
                "recordsFiltered" => $this->db->get('lab')->num_rows(),
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

    function toBeDone() {

        //   if ($this->ion_auth->in_group(array('Laboratorist'))) {
        //  $this->load->view('home/dashboard'); // just the header file
        //  $this->load->view('to_be_done_laboratorist', $data);
        // $this->load->view('home/footer'); // just the header file
        // } else {
        $data['cases_manager'] = $this->patient_model->getMedicalHistoryByStatus('Confirmed');
        $data['pre_medical_surgery'] = $this->surgery_model->getPreSurgeryMedicalAnalysisByStatus('Confirmed');
        $data['on_medical_surgery'] = $this->surgery_model->getOnSurgeryMedicalAnalysisByStatus('Confirmed');
        $data['post_medical_surgery'] = $this->surgery_model->getPostSurgeryMedicalAnalysisByStatus('Confirmed');
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('to_be_done', $data);
        $this->load->view('home/footer'); // just the header file
        //  }
    }

    function getLabTestFromCases() {
        if ($this->ion_auth->in_group(array('Laboratorist'))) {
            $user = $this->ion_auth->get_user_id();
            $laboratorist_details = $this->laboratorist_model->getLaboratoristByIonId($user);
            $laboratorist_category = explode("***", $laboratorist_details->category);
        }
        $id = $this->input->get('id');
        $id_split = explode("-", $id);
        $option = $option1 = '';
        if ($id_split[0] == 'case') {
            $cases = $this->patient_model->getMedicalHistoryById($id_split[1]);
        }
        if ($id_split[0] == 'precase') {
            $cases = $this->surgery_model->getPreSurgeryMedicalAnalysisById($id_split[1]);
        }
        if ($id_split[0] == 'oncase') {
            $cases = $this->surgery_model->getOnSurgeryMedicalAnalysisById($id_split[1]);
        }
        if ($id_split[0] == 'postcase') {
            $cases = $this->surgery_model->getPostSurgeryMedicalAnalysisById($id_split[1]);
        }
        $cases_payments = explode("##", $cases->description);
        $patient_name = $this->patient_model->getPatientById($cases->patient_id)->name;
        foreach ($cases_payments as $key => $payments) {
            $payments_invidual = explode("**", $payments);
            if ($payments_invidual[0] == 'Package' || $payments_invidual[0] == 'Package_pre_surgery_medical' || $payments_invidual[0] == 'Package_on_surgery_medical' || $payments_invidual[0] == 'Package_post_surgery_medical') {
                $packages = $this->packages_model->getPackagesById($payments_invidual[2]);
                $package_explode = explode("##", $packages->price_cat);
                foreach ($package_explode as $key => $package) {
                    $package_individual = explode("**", $package);
                    $category = $this->finance_model->getPaymentCategoryById($package_individual[1]);
                    if ($this->ion_auth->in_group(array('Laboratorist'))) {
                        if (in_array($category->type, $laboratorist_category)) {
                            if ($id_split[0] == 'case') {
                                $text = 'case-package-' . $id_split[1] . '-' . $package_individual[1];
                                $edit = '<a class="btn btn-info btn-xs btn_width editbutton_edit" href="lab/addLabReport?id=case-package-' . $id_split[1] . '-' . $package_individual[1] . '" ><i class="fa fa-edit"> </i></a>';
                            }
                            if ($id_split[0] == 'precase') {
                                $text = 'precase-package-' . $id_split[1] . '-' . $package_individual[1];
                                $edit = '<a class="btn btn-info btn-xs btn_width editbutton_edit" href="lab/addLabReport?id=precase-package-' . $id_split[1] . '-' . $package_individual[1] . '" ><i class="fa fa-edit"> </i></a>';
                            }
                            if ($id_split[0] == 'oncase') {
                                $text = 'oncase-package-' . $id_split[1] . '-' . $package_individual[1];
                                $edit = '<a class="btn btn-info btn-xs btn_width editbutton_edit" href="lab/addLabReport?id=oncase-package-' . $id_split[1] . '-' . $package_individual[1] . '" ><i class="fa fa-edit"> </i></a>';
                            }
                            if ($id_split[0] == 'postcase') {
                                $text = 'postcase-package-' . $id_split[1] . '-' . $package_individual[1];
                                $edit = '<a class="btn btn-info btn-xs btn_width editbutton_edit" href="lab/addLabReport?id=postcase-package-' . $id_split[1] . '-' . $package_individual[1] . '" ><i class="fa fa-edit"> </i></a>';
                            }

                            $exist_lab_report = $this->lab_model->getLabByToBeId($text);
                            if (!empty($exist_lab_report)) {
                                $lang = lang('done');
                                $laboratorist_name = $this->laboratorist_model->getLaboratoristById($exist_lab_report->laboratorist)->name;
                                $report = '<a class="btn btn-success btn-xs btn_width" href="lab/invoice?id=' . $exist_lab_report->id . '" target="_blank"><i class="fa fa-file-invoice"> </i></a>';
                            } else {
                                $laboratorist_name = '';
                                $lang = lang('undone');
                                $report = ' ';
                            }
                            //  $edit = '<button type="button" class="btn btn-info btn-xs btn_width editbutton_edit" data-toggle="modal" data-id="case-package-' .$id_split[1].'-'. $package_individual[1] . '"><i class="fa fa-edit"> ' . lang('edit') . '</i></button>';
                            $payment_proccedures = $this->finance_model->getPaymentCategoryById($package_individual[1]);
                            $option1 .= '<tr><td>' . $patient_name . '</td><td>' . $payment_proccedures->department_name . '</td><td>' . $payment_proccedures->type_name . '</td><td>' . $payment_proccedures->category . '</td><td>' . $payments_invidual[4] . '</td><td>' . $laboratorist_name . '</td><td>' . $lang . '</td><td>' . $edit . ' ' . $report . ' </td></tr>';
                        }
                    } else {
                        if ($id_split[0] == 'case') {
                            $text = 'case-package-' . $id_split[1] . '-' . $package_individual[1];
                            $edit = '<a class="btn btn-info btn-xs btn_width editbutton_edit" href="lab/addLabReport?id=case-package-' . $id_split[1] . '-' . $package_individual[1] . '" ><i class="fa fa-edit"> </i></a>';
                        }
                        if ($id_split[0] == 'precase') {
                            $text = 'precase-package-' . $id_split[1] . '-' . $package_individual[1];
                            $edit = '<a class="btn btn-info btn-xs btn_width editbutton_edit" href="lab/addLabReport?id=precase-package-' . $id_split[1] . '-' . $package_individual[1] . '" ><i class="fa fa-edit"> </i></a>';
                        }
                        if ($id_split[0] == 'oncase') {
                            $text = 'oncase-package-' . $id_split[1] . '-' . $package_individual[1];
                            $edit = '<a class="btn btn-info btn-xs btn_width editbutton_edit" href="lab/addLabReport?id=oncase-package-' . $id_split[1] . '-' . $package_individual[1] . '" ><i class="fa fa-edit"> </i></a>';
                        }
                        if ($id_split[0] == 'postcase') {
                            $text = 'postcase-package-' . $id_split[1] . '-' . $package_individual[1];
                            $edit = '<a class="btn btn-info btn-xs btn_width editbutton_edit" href="lab/addLabReport?id=postcase-package-' . $id_split[1] . '-' . $package_individual[1] . '" ><i class="fa fa-edit"> </i></a>';
                        }

                        $exist_lab_report = $this->lab_model->getLabByToBeId($text);
                        if (!empty($exist_lab_report)) {
                            $lang = lang('done');
                            $laboratorist_name = $this->laboratorist_model->getLaboratoristById($exist_lab_report->laboratorist)->name;
                            $report = '<a class="btn btn-success btn-xs btn_width" href="lab/invoice?id=' . $exist_lab_report->id . '" target="_blank"><i class="fa fa-file-invoice"> </i></a>';
                        } else {
                            $laboratorist_name = '';
                            $lang = lang('undone');
                            $report = ' ';
                        }
                        //  $edit = '<button type="button" class="btn btn-info btn-xs btn_width editbutton_edit" data-toggle="modal" data-id="case-package-' .$id_split[1].'-'. $package_individual[1] . '"><i class="fa fa-edit"> ' . lang('edit') . '</i></button>';
                        $payment_proccedures = $this->finance_model->getPaymentCategoryById($package_individual[1]);
                        $option1 .= '<tr><td>' . $patient_name . '</td><td>' . $payment_proccedures->department_name . '</td><td>' . $payment_proccedures->type_name . '</td><td>' . $payment_proccedures->category . '</td><td>' . $payments_invidual[4] . '</td><td>' . $laboratorist_name . '</td><td>' . $lang . '</td><td>' . $edit . ' ' . $report . ' </td></tr>';
                    }
                }
            } else {
                $category = $this->finance_model->getPaymentCategoryById($payments_invidual[2]);
                if ($this->ion_auth->in_group(array('Laboratorist'))) {
                    if (in_array($category->type, $laboratorist_category)) {
                        if ($id_split[0] == 'case') {
                            $text = 'case-medical-' . $id_split[1] . '-' . $payments_invidual[2];
                            $edit = '<a class="btn btn-info btn-xs btn_width editbutton_edit" href="lab/addLabReport?id=case-medical-' . $id_split[1] . '-' . $payments_invidual[2] . '" ><i class="fa fa-edit"> </i></a>';
                        }
                        if ($id_split[0] == 'precase') {
                            $text = 'precase-medical-' . $id_split[1] . '-' . $payments_invidual[2];
                            $edit = '<a class="btn btn-info btn-xs btn_width editbutton_edit" href="lab/addLabReport?id=precase-medical-' . $id_split[1] . '-' . $payments_invidual[2] . '" ><i class="fa fa-edit"> </i></a>';
                        }
                        if ($id_split[0] == 'oncase') {
                            $text = 'oncase-medical-' . $id_split[1] . '-' . $payments_invidual[2];
                            $edit = '<a class="btn btn-info btn-xs btn_width editbutton_edit" href="lab/addLabReport?id=oncase-medical-' . $id_split[1] . '-' . $payments_invidual[2] . '" ><i class="fa fa-edit"> </i></a>';
                        }
                        if ($id_split[0] == 'postcase') {
                            $text = 'postcase-medical-' . $id_split[1] . '-' . $payments_invidual[2];
                            $edit = '<a class="btn btn-info btn-xs btn_width editbutton_edit" href="lab/addLabReport?id=postcase-medical-' . $id_split[1] . '-' . $payments_invidual[2] . '" ><i class="fa fa-edit"> </i></a>';
                        }
                        $exist_lab_report = $this->lab_model->getLabByToBeId($text);
                        if (!empty($exist_lab_report)) {
                            $lang = lang('done');
                            $laboratorist_name = $this->laboratorist_model->getLaboratoristById($exist_lab_report->laboratorist)->name;
                            $report = '<a class="btn btn-success btn-xs btn_width" href="lab/invoice?id=' . $exist_lab_report->id . '" target="_blank"><i class="fa fa-file-invoice"> </i></a>';
                        } else {
                            $laboratorist_name = '';
                            $lang = lang('undone');
                            $report = ' ';
                        }


                        $payment_proccedures = $this->finance_model->getPaymentCategoryById($payments_invidual[2]);
                        $option .= '<tr><td>' . $patient_name . '</td><td>' . $payment_proccedures->department_name . '</td><td>' . $payment_proccedures->type_name . '</td><td>' . $payment_proccedures->category . '</td><td>' . $payments_invidual[4] . '</td><td>' . $laboratorist_name . '</td><td>' . $lang . '</td><td>' . $edit . ' ' . $report . '</td></tr>';
                    }
                } else {
                    if ($id_split[0] == 'case') {
                        $text = 'case-medical-' . $id_split[1] . '-' . $payments_invidual[2];
                        $edit = '<a class="btn btn-info btn-xs btn_width editbutton_edit" href="lab/addLabReport?id=case-medical-' . $id_split[1] . '-' . $payments_invidual[2] . '" ><i class="fa fa-edit"> </i></a>';
                    }
                    if ($id_split[0] == 'precase') {
                        $text = 'precase-medical-' . $id_split[1] . '-' . $payments_invidual[2];
                        $edit = '<a class="btn btn-info btn-xs btn_width editbutton_edit" href="lab/addLabReport?id=precase-medical-' . $id_split[1] . '-' . $payments_invidual[2] . '" ><i class="fa fa-edit"> </i></a>';
                    }
                    if ($id_split[0] == 'oncase') {
                        $text = 'oncase-medical-' . $id_split[1] . '-' . $payments_invidual[2];
                        $edit = '<a class="btn btn-info btn-xs btn_width editbutton_edit" href="lab/addLabReport?id=oncase-medical-' . $id_split[1] . '-' . $payments_invidual[2] . '" ><i class="fa fa-edit"> </i></a>';
                    }
                    if ($id_split[0] == 'postcase') {
                        $text = 'postcase-medical-' . $id_split[1] . '-' . $payments_invidual[2];
                        $edit = '<a class="btn btn-info btn-xs btn_width editbutton_edit" href="lab/addLabReport?id=postcase-medical-' . $id_split[1] . '-' . $payments_invidual[2] . '" ><i class="fa fa-edit"> </i></a>';
                    }
                    $exist_lab_report = $this->lab_model->getLabByToBeId($text);
                    if (!empty($exist_lab_report)) {
                        $lang = lang('done');
                        $laboratorist_name = $this->laboratorist_model->getLaboratoristById($exist_lab_report->laboratorist)->name;
                        $report = '<a class="btn btn-success btn-xs btn_width" href="lab/invoice?id=' . $exist_lab_report->id . '" target="_blank"><i class="fa fa-file-invoice"> </i></a>';
                    } else {
                        $laboratorist_name = '';
                        $lang = lang('undone');
                        $report = ' ';
                    }


                    $payment_proccedures = $this->finance_model->getPaymentCategoryById($payments_invidual[2]);
                    $option .= '<tr><td>' . $patient_name . '</td><td>' . $payment_proccedures->department_name . '</td><td>' . $payment_proccedures->type_name . '</td><td>' . $payment_proccedures->category . '</td><td>' . $payments_invidual[4] . '</td><td>' . $laboratorist_name . '</td><td>' . $lang . '</td><td>' . $edit . ' ' . $report . '</td></tr>';
                }
            }
        }
        $data['option'] = $option;
        $data['option1'] = $option1;
        echo json_encode($data);
    }

    function addLabReport() {
        $id = $this->input->get('id');
        $exist_lab_report = $this->lab_model->getLabByToBeId($id);
        $data = array();
        if (!empty($exist_lab_report)) {
            $data['lab'] = $this->lab_model->getLabById($exist_lab_report->id);
            $data['laboratorist'] = $this->laboratorist_model->getLaboratoristById($data['lab']->laboratorist);
            $data['doctors'] = $this->doctor_model->getDoctorById($data['lab']->doctor);
        }
        $id_split = explode("-", $id);
        if ($id_split[0] == 'case') {
            $cases = $this->patient_model->getMedicalHistoryById($id_split[2]);
        }
        if ($id_split[0] == 'precase') {
            $cases = $this->surgery_model->getPreSurgeryMedicalAnalysisById($id_split[2]);
        }
        if ($id_split[0] == 'oncase') {
            $cases = $this->surgery_model->getOnSurgeryMedicalAnalysisById($id_split[2]);
        }
        if ($id_split[0] == 'postcase') {
            $cases = $this->surgery_model->getPostSurgeryMedicalAnalysisById($id_split[2]);
        }
        $data['category_payment_procccedures'] = $this->finance_model->getPaymentCategoryById($id_split[3])->type;
        $data['laboratorists'] = $this->laboratorist_model->getLaboratorist();
        $data['patients'] = $this->patient_model->getPatientById($cases->patient_id);
        $data['templates'] = $this->lab_model->getTemplate();
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->lab_model->getLabCategory();
        $data['id_from_to_be'] = $id;
        // $data['patients'] = $this->patient_model->getPatient();
        // $data['doctors'] = $this->doctor_model->getDoctor();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_lab_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function getLaboratoristinfo() {
// Search term
        $searchTerm = $this->input->post('searchTerm');

// Get users
        $response = $this->laboratorist_model->getLaboratoristInfo($searchTerm);

        echo json_encode($response);
    }

}

/* End of file lab.php */
/* Location: ./application/modules/lab/controllers/lab.php */