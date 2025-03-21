<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Patient extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('patient_model');
        $this->load->model('donor/donor_model');
        $this->load->model('appointment/appointment_model');
        $this->load->model('bed/bed_model');
        $this->load->model('lab/lab_model');
        $this->load->model('packages/packages_model');
        $this->load->model('pcategory/pcategory_model');
        $this->load->model('category/category_model');
        $this->load->model('finance/finance_model');
        $this->load->model('finance/pharmacy_model');
        $this->load->model('sms/sms_model');
        $this->load->module('sms');
        $this->load->model('prescription/prescription_model');
        require APPPATH . 'third_party/stripe/stripe-php/init.php';
        $this->load->model('medicine/medicine_model');
        $this->load->model('doctor/doctor_model');
        $this->load->model('surgery/surgery_model');
        $this->load->model('pgateway/pgateway_model');
        $this->load->model('log/log_model');
        $this->load->library('zend');
        $this->zend->load('Zend/Barcode');
        $this->load->module('paypal');

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
        if ($this->ion_auth->in_group(array('Patient'))) {
            redirect('home/permission');
        }
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['groups'] = $this->donor_model->getBloodBank();
        $data['pcategory'] = $this->pcategory_model->getPcategoryByStatus();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('patient', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function calendar() {
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('calendar', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewView() {
        if ($this->ion_auth->in_group(array('Patient'))) {
            redirect('home/permission');
        }
        $data = array();
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['groups'] = $this->donor_model->getBloodBank();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNew() {

        if ($this->ion_auth->in_group(array('Patient'))) {
            redirect('home/permission');
        }

        $id = $this->input->post('id');
        $redirect = $this->input->get('redirect');
        if (empty($redirect)) {
            $redirect = $this->input->post('redirect');
        }
        $name = $this->input->post('name');
        $password = $this->input->post('password');
        $sms = $this->input->post('sms');
        $doctor = $this->input->post('doctor');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');
        $sex = $this->input->post('sex');
        $birthdate = $this->input->post('birthdate');
        $bloodgroup = $this->input->post('bloodgroup');
        $patient_id = $this->input->post('p_id');
        if (empty($patient_id)) {
            $patient_id = rand(10000, 1000000);
        }
        if ((empty($id))) {
            $add_date = date('m/d/y');
            $registration_time = time();
        } else {
            $add_date = $this->patient_model->getPatientById($id)->add_date;
            $registration_time = $this->patient_model->getPatientById($id)->registration_time;
        }


        $email = $this->input->post('email');
        if (empty($email)) {
            $email = $name . '@' . $phone . '.com';
        }

        $category = $this->input->post('category');
        if ($category != '0') {
            $category_name = $this->pcategory_model->getPcategoryById($category)->description;
        } else {
            $category_name = "";
        }
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Password Field
        if (empty($id)) {
            $this->form_validation->set_rules('password', 'Password', 'trim|min_length[3]|max_length[100]|xss_clean');
        }
        // Validating Email Field
        $this->form_validation->set_rules('email', 'Email', 'trim|min_length[2]|max_length[100]|xss_clean');
        // Validating Doctor Field
        //   $this->form_validation->set_rules('doctor', 'Doctor', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Address Field   
        $this->form_validation->set_rules('address', 'Address', 'trim|required|min_length[2]|max_length[500]|xss_clean');
        // Validating Phone Field           
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[2]|max_length[50]|xss_clean');
        // Validating Email Field
        $this->form_validation->set_rules('sex', 'Sex', 'trim|min_length[2]|max_length[100]|xss_clean');
        // Validating Address Field   
        $this->form_validation->set_rules('birthdate', 'Birth Date', 'trim|min_length[2]|max_length[500]|xss_clean');
        // Validating Phone Field           
        $this->form_validation->set_rules('bloodgroup', 'Blood Group', 'trim|min_length[1]|max_length[10]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $this->session->set_flashdata('feedback', lang('validation_error'));
                redirect("patient/editPatient?id=$id");
            } else {
                $data = array();
                $data['setval'] = 'setval';
                $data['doctors'] = $this->doctor_model->getDoctor();
                $data['groups'] = $this->donor_model->getBloodBank();
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
                'max_size' => "10000000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
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
                    'patient_id' => $patient_id,
                    'img_url' => $img_url,
                    'name' => $name,
                    'email' => $email,
                    'address' => $address,
                    'doctor' => $doctor,
                    'phone' => $phone,
                    'sex' => $sex,
                    'birthdate' => $birthdate,
                    'bloodgroup' => $bloodgroup,
                    'add_date' => $add_date,
                    'registration_time' => $registration_time,
                    'category' => $category,
                    'category_name' => $category_name
                );
            } else {
                //$error = array('error' => $this->upload->display_errors());
                $data = array();
                $data = array(
                    'patient_id' => $patient_id,
                    'name' => $name,
                    'email' => $email,
                    'doctor' => $doctor,
                    'address' => $address,
                    'phone' => $phone,
                    'sex' => $sex,
                    'birthdate' => $birthdate,
                    'bloodgroup' => $bloodgroup,
                    'add_date' => $add_date,
                    'registration_time' => $registration_time,
                    'category' => $category,
                    'category_name' => $category_name
                );
            }

            $username = $this->input->post('name');

            if (empty($id)) {     // Adding New Patient
                if ($this->ion_auth->email_check($email)) {
                    $this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
                    redirect('patient/addNewView');
                } else {
                    $dfg = 5;
                    $this->ion_auth->register($username, $password, $email, $dfg);
                    $ion_user_id = $this->db->get_where('users', array('email' => $email))->row()->id;
                    $this->patient_model->insertPatient($data);
                    $patient_user_id = $this->db->get_where('patient', array('email' => $email))->row()->id;
                    $barcodeOptions = array('text' => '010102-' . $patient_user_id . '-XYDfSX', 'barHeight' => '50');

                    $barcode = 'barcode-' . $patient_user_id . '-' . rand() . '.png';
                    $imageResource = Zend_Barcode::factory('Code128', 'image', $barcodeOptions, array())->draw();

                    imagepng($imageResource, './files/barcode/' . $barcode);
                    $id_info = array('ion_user_id' => $ion_user_id, 'barcode_url' => $barcode);
                    $this->patient_model->updatePatient($patient_user_id, $id_info);
                    $this->log_model->insertLog($this->ion_auth->get_user_id(), date('d-m-Y H:i:s', time()), 'Add New Patient(id=' . $patient_user_id . ' )', $patient_user_id);
                    //sms
                    $set['settings'] = $this->settings_model->getSettings();
                    $autosms = $this->sms_model->getAutoSmsByType('patient');
                    $message = $autosms->message;
                    $doctorname = $this->doctor_model->getDoctorById($doctor)->name;
                    $to = $phone;
                    $name1 = explode(' ', $name);
                    if (!isset($name1[1])) {
                        $name1[1] = null;
                    }
                    $data1 = array(
                        'firstname' => $name1[0],
                        'lastname' => $name1[1],
                        'name' => $name,
                        'doctor' => $doctorname,
                        'company' => $set['settings']->system_vendor
                    );
                    //   if (!empty($sms)) {
                    // $this->sms->sendSmsDuringPatientRegistration($patient_user_id);
                    if ($autosms->status == 'Active') {
                        $messageprint = $this->parser->parse_string($message, $data1);
                        $data2[] = array($to => $messageprint);
                        $this->sms->sendSms($to, $message, $data2);
                    }
                    //end
                    //  }
                    //email

                    $autoemail = $this->email_model->getAutoEmailByType('patient');
                    if ($autoemail->status == 'Active') {
                        $mail_provider = $this->settings_model->getSettings()->emailtype;
                        $settngs_name = $this->settings_model->getSettings()->system_vendor;
                        $email_Settings = $this->email_model->getEmailSettingsByType($mail_provider);
                        $message1 = $autoemail->message;
                        $messageprint1 = $this->parser->parse_string($message1, $data1);
                        if ($mail_provider == 'Domain Email') {
                            $this->email->from($email_Settings->admin_email);
                        }
                        if ($mail_provider == 'Smtp') {
                            $this->email->from($email_Settings->user, $settngs_name);
                        }
                        //  $this->email->from($emailSettings->admin_email);
                        $this->email->to($email);
                        $this->email->subject('Registration confirmation');
                        $this->email->message($messageprint1);
                        $this->email->send();

                        $mail_provider = $this->settings_model->getSettings()->emailtype;
                        $settngs_name = $this->settings_model->getSettings()->system_vendor;
                        $emailSettings = $this->email_model->getEmailSettingsByType($mail_provider);
                        $base_url = str_replace(array('http://', 'https://', '/'), '', base_url());
                        $subject = $base_url . ' - Patient Registration Details';
                        $message = 'Dear ' . $name . ', Thank you for the registration. <br> Here is your login details.<br> <br> Link: ' . base_url() . 'auth/login <br> Username: ' . $email . ' <br> Password: ' . $password . '<br><br> Thank You, <br>' . $this->settings->title;
                        if ($mail_provider == 'Domain Email') {
                            $this->email->from($emailSettings->admin_email);
                        }
                        if ($mail_provider == 'Smtp') {
                            $this->email->from($emailSettings->user, $settngs_name);
                        }
                        $this->email->to($email);
                        $this->email->subject($subject);
                        $this->email->message($message);
                        $this->email->send();
                    }

                    //end



                    $this->session->set_flashdata('feedback', lang('added'));
                }
                //    }
            } else { // Updating Patient
                $ion_user_id = $this->db->get_where('patient', array('id' => $id))->row()->ion_user_id;
                if (empty($password)) {
                    $password = $this->db->get_where('users', array('id' => $ion_user_id))->row()->password;
                } else {
                    $password = $this->ion_auth_model->hash_password($password);
                }
                //  $this->log_model->insertLog($this->ion_auth->get_user_id(), date('d-m-Y H:i:s', time()), 'Edit Patient', $id);
                $this->patient_model->updateIonUser($username, $email, $password, $ion_user_id);
                $this->patient_model->updatePatient($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            // Loading View
            if (!empty($redirect)) {
                redirect($redirect);
            } else {
                redirect('patient');
            }
        }
    }

    function editPatient() {
        $data = array();
        $id = $this->input->get('id');
        $data['patient'] = $this->patient_model->getPatientById($id);
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['groups'] = $this->donor_model->getBloodBank();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editPatientByJason() {
        $id = $this->input->get('id');
        $data['patient'] = $this->patient_model->getPatientById($id);
        $data['doctor'] = $this->doctor_model->getDoctorById($data['patient']->doctor);
        echo json_encode($data);
    }

    function getPatientByJason() {
        $id = $this->input->get('id');
        $data['patient'] = $this->patient_model->getPatientById($id);

        $doctor = $data['patient']->doctor;
        $data['doctor'] = $this->doctor_model->getDoctorById($doctor);

        if (!empty($data['patient']->birthdate)) {
            $birthDate = strtotime($data['patient']->birthdate);
            $birthDate = date('m/d/Y', $birthDate);
            $birthDate = explode("/", $birthDate);
            $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y") - $birthDate[2]) - 1) : (date("Y") - $birthDate[2]));
            $data['age'] = $age . ' Year(s)';
        }

        echo json_encode($data);
    }

    function patientDetails() {
        $data = array();
        $id = $this->input->get('id');
        $data['patient'] = $this->patient_model->getPatientById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('details', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function report() {
        $data = array();
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['payment'] = $this->finance_model->getPaymentById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('diagnostic_report_details', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function addDiagnosticReport() {
        $id = $this->input->post('id');
        $invoice = $this->input->post('invoice');
        $patient = $this->input->post('patient');
        $report = $this->input->post('report');

        $date = time();

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Name Field
        $this->form_validation->set_rules('invoice', 'Invoice', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Password Field

        $this->form_validation->set_rules('report', 'Report', 'trim|min_length[1]|max_length[10000]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('feedback', lang('validation_error'));
            redirect('patient/report?id=' . $invoice);
        } else {

            //$error = array('error' => $this->upload->display_errors());
            $data = array();
            $data = array(
                'invoice' => $invoice,
                'date' => $date,
                'report' => $report
            );

            if (empty($id)) {     // Adding New department
                $this->patient_model->insertDiagnosticReport($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else { // Updating department
                $this->patient_model->updateDiagnosticReport($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            // Loading View
            redirect('patient/report?id=' . $invoice);
        }
    }

    function patientPayments() {
        $data['groups'] = $this->donor_model->getBloodBank();
        $data['pcategory'] = $this->pcategory_model->getPcategoryByStatus();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('patient_payments', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function caseList() {
        $data['settings'] = $this->settings_model->getSettings();
        $data['patients'] = $this->patient_model->getPatient();
        $data['medical_histories'] = $this->patient_model->getMedicalHistory();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('case_list', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function documents() {
        $data['patients'] = $this->patient_model->getPatient();
        $data['files'] = $this->patient_model->getPatientMaterial();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('documents', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function myCaseList() {
        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $patient_id = $this->patient_model->getPatientByIonUserId($patient_ion_id)->id;
            $data['medical_histories'] = $this->patient_model->getMedicalHistoryByPatientId($patient_id);
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('my_case_list', $data);
            $this->load->view('home/footer'); // just the footer file
        }
    }

    function myDocuments() {
        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $patient_id = $this->patient_model->getPatientByIonUserId($patient_ion_id)->id;
            $data['files'] = $this->patient_model->getPatientMaterialByPatientId($patient_id);
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('my_documents', $data);
            $this->load->view('home/footer'); // just the footer file
        }
    }

    function myPrescription() {
        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $patient_id = $this->patient_model->getPatientByIonUserId($patient_ion_id)->id;
            $data['doctors'] = $this->doctor_model->getDoctor();
            $data['prescriptions'] = $this->prescription_model->getPrescriptionByPatientId($patient_id);
            $data['settings'] = $this->settings_model->getSettings();
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('my_prescription', $data);
            $this->load->view('home/footer'); // just the header file
        }
    }

    public function myPayment() {
        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $patient_id = $this->patient_model->getPatientByIonUserId($patient_ion_id)->id;
            $data['settings'] = $this->settings_model->getSettings();
            $data['payments'] = $this->finance_model->getPaymentByPatientId($patient_id);
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('my_payment', $data);
            $this->load->view('home/footer'); // just the header file
        }
    }

    function myPaymentHistory() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }


        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $patient = $this->patient_model->getPatientByIonUserId($patient_ion_id)->id;
        }
        $data['settings'] = $this->settings_model->getSettings();
        $date_from = strtotime($this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 86399;
        }

        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;

        if (!empty($date_from)) {
            $data['payments'] = $this->finance_model->getPaymentByPatientIdByDate($patient, $date_from, $date_to);
            $data['deposits'] = $this->finance_model->getDepositByPatientIdByDate($patient, $date_from, $date_to);
            $data['gateway'] = $this->finance_model->getGatewayByName($data['settings']->payment_gateway);
        } else {
            $data['payments'] = $this->finance_model->getPaymentByPatientId($patient);
            $data['pharmacy_payments'] = $this->pharmacy_model->getPaymentByPatientId($patient);
            $data['ot_payments'] = $this->finance_model->getOtPaymentByPatientId($patient);
            $data['deposits'] = $this->finance_model->getDepositByPatientId($patient);
            $data['gateway'] = $this->finance_model->getGatewayByName($data['settings']->payment_gateway);
        }



        $data['patient'] = $this->patient_model->getPatientByid($patient);
        $data['settings'] = $this->settings_model->getSettings();

        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('my_payments_history', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function deposit() {
        $id = $this->input->post('id');

        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $patient = $this->patient_model->getPatientByIonUserId($patient_ion_id)->id;
        } else {
            $this->session->set_flashdata('feedback', lang('undefined_patient_id'));
            redirect('patient/myPaymentsHistory');
        }



        $payment_id = $this->input->post('payment_id');
        $date = time();
        $remarks = $this->input->post('remarks');
        /*  $payment_details = $this->finance_model->getPaymentById($payment_id);
          if ($payment_details->payment_from == 'bed' || $payment_details->payment_from == 'bed_service') {
          if (empty($payment_details->remarks)) {
          $data_payment = array('remarks' => $remarks);
          $this->finance_model->updatePayment($payment_id, $data_payment);
          }
          } */
        $deposited_amount = $this->input->post('deposited_amount');

        $deposit_type = $this->input->post('deposit_type');

        if ($deposit_type != 'Card') {
            $this->session->set_flashdata('feedback', lang('undefined_payment_type'));
            redirect('patient/myPaymentsHistory');
        }

        $user = $this->ion_auth->get_user_id();

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Patient Name Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Deposited Amount Field
        $this->form_validation->set_rules('deposited_amount', 'Deposited Amount', 'trim|min_length[1]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            redirect('patient/myPaymentsHistory');
        } else {
            $data = array();
            $data = array(
                'patient' => $patient,
                // 'date' => $date,
                'payment_id' => $payment_id,
                'deposited_amount' => $deposited_amount,
                'deposit_type' => $deposit_type,
                'user' => $user
            );
            if (empty($id)) {
                $data['date'] = $date;
            }
            if (empty($id)) {
                if ($deposit_type == 'Card') {
                    $payment_details = $this->finance_model->getPaymentById($payment_id);

                    $gateway = $this->settings_model->getSettings()->payment_gateway;

                    if ($gateway == 'PayPal') {
                        $card_type = $this->input->post('card_type');
                        $card_number = $this->input->post('card_number');
                        $expire_date = $this->input->post('expire_date');
                        $cvv = $this->input->post('cvv_number');
                        $cardholdername = $this->input->post('cardholder');
                        $all_details = array(
                            'patient' => $payment_details->patient,
                            'date' => $payment_details->date,
                            'amount' => $payment_details->amount,
                            'doctor' => $payment_details->doctor_name,
                            'discount' => $payment_details->discount,
                            'flat_discount' => $payment_details->flat_discount,
                            'gross_total' => $payment_details->gross_total,
                            'status' => 'unpaid',
                            'patient_name' => $payment_details->patient_name,
                            'patient_phone' => $payment_details->patient_phone,
                            'patient_address' => $payment_details->patient_address,
                            'deposited_amount' => $deposited_amount,
                            'payment_id' => $payment_details->id,
                            'card_type' => $card_type,
                            'card_number' => $card_number,
                            'expire_date' => $expire_date,
                            'cvv' => $cvv,
                            'from' => 'patient_payment_details',
                            'user' => $user,
                            'cardholdername' => $cardholdername
                        );

                        $this->paypal->paymentPaypal($all_details);
                    } elseif ($gateway == '2Checkout') {

                        $card_type = $this->input->post('card_type');
                        $card_number = $this->input->post('card_number');
                        $expire_date = $this->input->post('expire_date');
                        $cvv = $this->input->post('cvv');
                        $ref = date('Y') . rand() . date('d');
                        $amount = $deposited_amount;
                        $token = $this->input->post('token');
                        //   $token = $this->input->post('token');
                        //  $card_number = base64_encode($card_number);
                        //   $cvv = base64_encode($cvv);
                        //     if ($configuration) {
                        $datapayment = array(
                            'ref' => $ref,
                            'amount' => $amount,
                            'patient' => $patient,
                            'insertid' => $payment_id,
                            'card_type' => $card_type,
                            'card_number' => $card_number,
                            'expire_date' => $expire_date,
                            'cvv' => $cvv,
                            'cardholder' => $this->input->post('cardholder')
                        );

                        $this->load->module('twocheckoutpay');
                        $charge = $this->twocheckoutpay->createCharge($ref, $token, $amount, $datapayment);

                        if ($charge['response']['responseCode'] == 'APPROVED') {
                            $date = time();
                            $data1 = array(
                                'date' => $date,
                                'patient' => $patient,
                                'deposited_amount' => $deposited_amount,
                                'payment_id' => $payment_id,
                                'gateway' => '2Checkout',
                                'deposit_type' => $deposit_type,
                                'user' => $user
                            );
                            $this->finance_model->insertDeposit($data1);
                            $this->log_model->insertLog($this->ion_auth->get_user_id(), date('d-m-Y H:i:s', time()), 'Add new Payment(id=' . $this->db->insert_id() . ' )', $this->db->insert_id());
                            $this->session->set_flashdata('feedback', lang('added'));
                            redirect('patient/myPaymentHistory');
                        } else {
                            $this->session->set_flashdata('feedback', lang('transaction_failed'));
                            redirect('patient/myPaymentHistory');
                        }
                    } elseif ($gateway == 'Authorize.Net') {

                        $card_type = $this->input->post('card_type');
                        $card_number = $this->input->post('card_number');
                        $expire_date = $this->input->post('expire_date');
                        $cvv = $this->input->post('cvv_number');
                        $ref = date('Y') . rand() . date('d');
                        $amount = $deposited_amount;

                        $card_number = base64_encode($card_number);
                        $cvv = base64_encode($cvv);
                        //     if ($configuration) {
                        $datapayment = array(
                            'ref' => $ref,
                            'amount' => $amount,
                            'patient' => $patient,
                            'insertid' => $payment_id,
                            'card_type' => $card_type,
                            'card_number' => $card_number,
                            'expire_date' => $expire_date,
                            'cvv' => $cvv,
                                //  'email'=>$patient_email
                        );

                        $this->load->module('authorizenet');
                        $response = $this->authorizenet->paymentAuthorize($datapayment, 'patdep');
                        //  $this->authorizenet->reponseRedirectPageAuthorizenet($respose, $datapayment,'pos');
                        // $this->load->view('paytm/paytminfo', $datapayment);
                        //    }
                        // $email=$patient_email;
                    } elseif ($gateway == 'Stripe') {
                        $card_number = $this->input->post('card_number');
                        $expire_date = $this->input->post('expire_date');
                        $cvv = $this->input->post('cvv_number');
                        $token = $this->input->post('token');

                        $stripe = $this->db->get_where('paymentGateway', array('name =' => 'Stripe'))->row();
                        \Stripe\Stripe::setApiKey($stripe->secret);
                        $charge = \Stripe\Charge::create(array(
                                    "amount" => $deposited_amount * 100,
                                    "currency" => "usd",
                                    "source" => $token
                        ));
                        $chargeJson = $charge->jsonSerialize();
                        if ($chargeJson['status'] == 'succeeded') {
                            $data1 = array(
                                'patient' => $patient,
                                'date' => $date,
                                'payment_id' => $payment_id,
                                'deposited_amount' => $deposited_amount,
                                'deposit_type' => $deposit_type,
                                'gateway' => 'Stripe',
                                'deposit_type' => 'Card',
                                'user' => $user
                            );
                            $this->finance_model->insertDeposit($data1);
                            $this->log_model->insertLog($this->ion_auth->get_user_id(), date('d-m-Y H:i:s', time()), 'Add new Payment(id=' . $this->db->insert_id() . ' )', $this->db->insert_id());
                            $this->session->set_flashdata('feedback', 'Added');
                            redirect('patient/myPaymentHistory');
                        } else {
                            $this->session->set_flashdata('feedback', 'Payment failed.');
                            redirect('patient/myPaymentHistory');
                        }
                    } elseif ($gateway == 'Paystack') {

                        $ref = date('Y') . '-' . rand() . date('d') . '-' . date('m');
                        $amount_in_kobo = $deposited_amount;
                        $this->load->module('paystack');
                        $this->paystack->paystack_standard($amount_in_kobo, $ref, $patient, $payment_id, $user, '1');
                    } elseif ($gateway == 'SSLCOMMERZ') {
                        $this->load->module('sslcommerzpayment');
                        $this->sslcommerzpayment->request_api_hosted($deposited_amount, $patient, $payment_id, $user, '0');
                    } elseif ($gateway == 'Paytm') {


                        $ref = date('Y') . '-' . rand() . date('d') . '-' . date('m') . '-1';
                        $amount = $deposited_amount;
                        $this->load->module('paytm');
                        // $configuration=$this->paytm->Configuration();
                        //   if($configuration){
                        $datapayment = array(
                            'ref' => $ref,
                            'amount' => $amount,
                            'patient' => $patient,
                            'insertid' => $payment_id,
                            'channel_id' => 'WEB',
                            'industry_type' => 'Retail',
                                //  'email'=>$patient_email
                        );
                        //  $this->load->module('paytm/pgRedirects');
                        $this->paytm->PaytmGateway($datapayment);
                        //}
                        // $email=$patient_email;
                    } elseif ($gateway == 'Pay U Money') {
                        redirect("payu/check?deposited_amount=" . "$deposited_amount" . '&payment_id=' . $payment_id);
                    } else {
                        $this->session->set_flashdata('feedback', lang('payment_failed_no_gateway_selected'));
                        redirect('patient/myPaymentHistory');
                    }
                } else {
                    $this->finance_model->insertDeposit($data);
                    $this->log_model->insertLog($this->ion_auth->get_user_id(), date('d-m-Y H:i:s', time()), 'Add new Payment(id=' . $this->db->insert_id() . ' )', $this->db->insert_id());
                    $this->session->set_flashdata('feedback', lang('added'));
                }
            } else {
                $this->finance_model->updateDeposit($id, $data);
                $this->log_model->insertLog($this->ion_auth->get_user_id(), date('d-m-Y H:i:s', time()), 'Edited Payment(id=' . $id . ' )', $id);
                $amount_received_id = $this->finance_model->getDepositById($id)->amount_received_id;
                if (!empty($amount_received_id)) {
                    $amount_received_payment_id = explode('.', $amount_received_id);
                    $payment_id = $amount_received_payment_id[0];
                    $data_amount_received = array('amount_received' => $deposited_amount);
                    $this->finance_model->updatePayment($amount_received_payment_id[0], $data_amount_received);
                }

                $this->session->set_flashdata('feedback', lang('updated'));
                redirect('patient/myPaymentHistory');
            }
        }
    }

    function myInvoice() {
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['discount_type'] = $this->finance_model->getDiscountType();
        $data['payment'] = $this->finance_model->getPaymentById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('myInvoice', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function addMedicalHistory() {
        $id = $this->input->post('id');
        $patient_id = $this->input->post('patient_id');

        $date = $this->input->post('date');

        $title = $this->input->post('title');
        $status = $this->input->post('status');
        if (!empty($date)) {
            $date = strtotime($date);
        } else {
            $date = time();
        }
        $from = $this->input->post('from[]');
        $length = count($from);
        $date_to_done = $this->input->post('date_to_done[]');
        $done = $this->input->post('done[]');
        $price = $this->input->post('price[]');
        $type_id = $this->input->post('type_id[]');
        $type = $this->input->post('type[]');
        $discount = $this->input->post('discount_case[]');
        // $deposit_type = $this->input->post('deposit_type');
        // $pay_now_case = $this->input->post('pay_now_case');
        // $description = $this->input->post('description');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $redirect = $this->input->post('redirect');
        /* if (empty($redirect)) {
          $redirect = 'patient/medicalHistory?id=' . $patient_id;
          } */

        // Validating Name Field
        $this->form_validation->set_rules('date', 'Date', 'trim|min_length[1]|max_length[100]|xss_clean');

        // Validating Title Field
        $this->form_validation->set_rules('title', 'Title', 'trim|min_length[1]|max_length[100]|xss_clean');

        // Validating Password Field
        // $this->form_validation->set_rules('description', 'Description', 'trim|min_length[5]|max_length[10000]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect("patient/editCaseHistory?id=$id");
            } else {
                $data['settings'] = $this->settings_model->getSettings();
                $data['patients'] = $this->patient_model->getPatient();
                $data['packages'] = $this->packages_model->getPackages();
                $data['payment_category'] = $this->finance_model->getPaymentCategory();
                //   $data['medical_histories'] = $this->patient_model->getMedicalHistory();
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_case_list', $data);
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
                $array_price_cat[] = $from[$i] . '**' . $type[$i] . '**' . $type_id[$i] . '**' . $price[$i] . '**' . $date_to_done[$i] . '**' . $done[$i]. '**' . $discount[$i];
            }
            $total = array_sum($price);
            $discount_price=array_sum($discount);
            $grand_total=$total-$discount_price;
            $price_cat = implode("##", $array_price_cat);
            $data = array();
            $data = array(
                'patient_id' => $patient_id,
                'date' => $date,
                'title' => $title,
                'description' => $price_cat,
                'status' => $status,
                'patient_name' => $patient_name,
                'patient_phone' => $patient_phone,
                'patient_address' => $patient_address,
                'total_price' => $total,
                'discount'=>$discount_price,
                'grand_total'=>$grand_total,
                'remarks' => $this->input->post('remarks')
            );
            $data_case = array();
            $data_case = array(
                'category_name' => $price_cat,
                'patient' => $patient_id,
                'amount' => $total,
                'discount' => $discount_price,
                'flat_discount' => '0',
                'gross_total' => $grand_total,
                'status' => 'unpaid',
                'hospital_amount' => $grand_total,
                'doctor_amount' => '0',
                'user' => $this->ion_auth->get_user_id(),
                'patient_name' => $patient_details->name,
                'patient_phone' => $patient_details->phone,
                'patient_address' => $patient_details->address,
                'remarks' => $this->input->post('remarks'),
                'payment_from' => 'case',
                'case_status' => $status
            );
            if (empty($id)) {     // Adding New department
                $data['payment_status'] = 'unpaid';
                $data_case['status'] = 'unpaid';
                //  $data_case['case_status'] = $status;
                $data_case['date'] = time();
                $data_case['date_string'] = date('d-m-Y');

                $this->patient_model->insertMedicalHistory($data);
                $inserted_id_medical = $this->db->insert_id('medical_history');
                $this->log_model->insertLog($this->ion_auth->get_user_id(), date('d-m-Y H:i:s', time()), 'Add New Case(id=' . $inserted_id_medical . ' )', $inserted_id_medical);
                $data_case['case_id'] = $inserted_id_medical;

                $this->finance_model->insertPayment($data_case);

                $inserted_id = $this->db->insert_id('payment');

                $data_up = array('payment_id' => $inserted_id);
                $this->patient_model->updateMedicalHistory($inserted_id_medical, $data_up);

                $this->session->set_flashdata('feedback', lang('added'));
            } else { // Updating department
                $medical_history = $this->patient_model->getMedicalHistoryById($id);
                $this->patient_model->updateMedicalHistory($id, $data);
                //$data_case['case_status'] = $status;
                $this->finance_model->updatePayment($medical_history->payment_id, $data_case);
                $this->session->set_flashdata('feedback', lang('updated'));
            }




            if ($redirect == 'case_list_history') {
                redirect('patient/medicalHistory?id=' . $patient_id);
            } elseif ($redirect == 'case_list') {
                redirect('patient/caseList');
            }
            // Loading View
            //  redirect($redirect);
        }
    }

    public function medicalHistoryPayment($deposit_type, $data, $patient, $doctor, $total, $date, $inserted_id, $redirectlink) {
        $patient_details = $this->patient_model->getPatientById($patient);
        $user = $this->ion_auth->get_user_id();
        // $doctorname = $this->doctor_model->getDoctorById($doctor)->name;
        if ($deposit_type == 'Card') {
            $gateway = $this->settings_model->getSettings()->payment_gateway;
            if ($gateway == 'PayPal') {

                $card_type = $data['cardtype'];
                $card_number = $data['card_number'];
                $expire_date = $data['expire_date'];
                $cardHoldername = $data['cardHoldername'];
                $cvv = $data['cvv'];

                $all_details = array(
                    'patient' => $patient,
                    'date' => $date,
                    'amount' => $total,
                    // 'doctor' => $doctor,
                    'gross_total' => $total,
                    //'hospital_amount' => $hospital_amount,
                    // 'doctor_amount' => $doctor_amount,
                    'patient_name' => $patient_details->name,
                    'patient_phone' => $patient_details->phone,
                    'patient_address' => $patient_details->address,
                    //   'doctor_name' => $doctorname,
                    'date_string' => date('d-m-y', $date),
                    'deposited_amount' => $total,
                    'payment_id' => $inserted_id,
                    'card_type' => $card_type,
                    'card_number' => $card_number,
                    'expire_date' => $expire_date,
                    'cvv' => $cvv,
                    'from' => 'case',
                    'user' => $this->ion_auth->get_user_id(),
                    'cardholdername' => $cardHoldername,
                    'from' => $redirectlink
                );

                $this->paypal->paymentPaypal($all_details);
            } elseif ($gateway == 'Stripe') {

                $card_number = $data['card_number'];
                $expire_date = $data['expire_date'];

                $cvv = $data['cvv'];

                $token = $data['token'];
                $stripe = $this->db->get_where('paymentGateway', array('name =' => 'Stripe'))->row();
                \Stripe\Stripe::setApiKey($stripe->secret);
                $charge = \Stripe\Charge::create(array(
                            "amount" => $consultant_fee * 100,
                            "currency" => "usd",
                            "source" => $token
                ));
                $chargeJson = $charge->jsonSerialize();
                if ($chargeJson['status'] == 'succeeded') {
                    $data1 = array(
                        'date' => $date,
                        'patient' => $patient,
                        'payment_id' => $inserted_id,
                        'deposited_amount' => $consultant_fee,
                        'amount_received_id' => $inserted_id . '.' . 'gp',
                        'gateway' => 'Stripe',
                        'user' => $user,
                        'payment_from' => 'appointment'
                    );
                    $this->finance_model->insertDeposit($data1);
                    $data_payment = array('amount_received' => $consultant_fee, 'deposit_type' => $deposit_type, 'status' => 'paid', 'date' => time(), 'date_string' => date('d-m-y', time()));
                    $this->finance_model->updatePayment($inserted_id, $data_payment);
                    $appointment_id = $this->finance_model->getPaymentById($inserted_id)->appointment_id;

                    $appointment_details = $this->appointment_model->getAppointmentById($appointment_id);
                    if ($appointment_details->status == 'Requested') {
                        $data_appointment_status = array('status' => 'Confirmed', 'payment_status' => 'paid');
                    } else {
                        $data_appointment_status = array('payment_status' => 'paid');
                    }

                    $this->appointment_model->updateAppointment($appointment_id, $data_appointment_status);
                    $this->session->set_flashdata('feedback', lang('payment_successful'));
                } else {
                    $this->session->set_flashdata('feedback', lang('transaction_failed'));
                }
            } elseif ($gateway == 'Pay U Money') {
                redirect("payu/check4?deposited_amount=" . $consultant_fee . '&payment_id=' . $inserted_id . '&redirectlink=' . $redirectlink);
            } elseif ($gateway == 'Paystack') {

                $ref = date('Y') . '-' . rand() . date('d') . '-' . date('m');
                $amount_in_kobo = $consultant_fee;
                $this->load->module('paystack');
                $this->paystack->paystack_standard($amount_in_kobo, $ref, $patient, $inserted_id, $this->ion_auth->get_user_id(), $redirectlink);

                // $email=$patient_email;
            } elseif ($gateway == 'Paytm') {

                if ($redirectlink == '10') {
                    $ref = date('Y') . '-' . rand() . date('d') . '-' . date('m') . '-10';
                } elseif ($redirectlink == 'my_today') {
                    $ref = date('Y') . '-' . rand() . date('d') . '-' . date('m') . '-11';
                } elseif ($redirectlink == 'upcoming') {
                    $ref = date('Y') . '-' . rand() . date('d') . '-' . date('m') . '-12';
                } elseif ($redirectlink == 'med_his') {
                    $ref = date('Y') . '-' . rand() . date('d') . '-' . date('m') . '-13';
                } elseif ($redirectlink == 'request') {
                    $ref = date('Y') . '-' . rand() . date('d') . '-' . date('m') . '-14';
                }
                $amount = $consultant_fee;
                $this->load->module('paytm');
                // $configuration=$this->paytm->Configuration();
                //   if($configuration){
                $datapayment = array(
                    'ref' => $ref,
                    'amount' => $amount,
                    'patient' => $patient,
                    'insertid' => $inserted_id,
                    'channel_id' => 'WEB',
                    'industry_type' => 'Retail',
                    'email' => $patient_details->email,
                );
                //  $this->load->module('paytm/pgRedirects');
                $this->paytm->PaytmGateway($datapayment);
                //}
                // $email=$patient_email;
            } elseif ($gateway == 'Authorize.Net') {

                $card_type = $data['cardtype'];
                $card_number = $data['card_number'];
                $expire_date = $data['expire_date'];
                //  $cardHoldername =  $data['cardHoldername'];
                $cvv = $data['cvv'];
                $ref = date('Y') . rand() . date('d');
                $amount = $consultant_fee;

                $card_number = base64_encode($card_number);
                $cvv = base64_encode($cvv);
                //     if ($configuration) {
                $datapayment = array(
                    'ref' => $ref,
                    'amount' => $amount,
                    'patient' => $patient,
                    'insertid' => $inserted_id,
                    'card_type' => $card_type,
                    'card_number' => $card_number,
                    'expire_date' => $expire_date,
                    'cvv' => $cvv,
                );
                //  print_r($datapayment);
                //    die();
                $this->load->module('authorizenet');
                $response = $this->authorizenet->paymentAuthorize($datapayment, $redirectlink);
            } elseif ($gateway == '2Checkout') {

                $card_type = $data['cardtype'];
                $card_number = $data['card_number'];
                $expire_date = $data['expire_date'];
                $cardHoldername = $data['cardHoldername'];
                $cvv = $data['cvv'];
                $ref = date('Y') . rand() . date('d');
                $amount = $consultant_fee;
                $token = $this->input->post('token');
                //   $token = $this->input->post('token');
                //  $card_number = base64_encode($card_number);
                //   $cvv = base64_encode($cvv);
                //     if ($configuration) {
                $datapayment = array(
                    'ref' => $ref,
                    'amount' => $consultant_fee,
                    'patient' => $patient,
                    'insertid' => $inserted_id,
                    'card_type' => $card_type,
                    'card_number' => $card_number,
                    'expire_date' => $expire_date,
                    'cvv' => $cvv,
                    'cardholder' => $cardHoldername
                );

                $this->load->module('twocheckoutpay');
                $charge = $this->twocheckoutpay->createCharge($ref, $token, $amount, $datapayment);

                if ($charge['response']['responseCode'] == 'APPROVED') {
                    $data1 = array(
                        'date' => $date,
                        'patient' => $patient,
                        'deposited_amount' => $consultant_fee,
                        'payment_id' => $inserted_id,
                        'amount_received_id' => $inserted_id . '.' . 'gp',
                        'deposit_type' => $deposit_type,
                        'user' => $user,
                        'payment_from' => 'appointment'
                    );
                    $this->finance_model->insertDeposit($data1);

                    $data_payment = array('amount_received' => $consultant_fee, 'deposit_type' => $deposit_type, 'status' => 'paid', 'date' => time(), 'date_string' => date('d-m-y', time()));
                    $this->finance_model->updatePayment($inserted_id, $data_payment);
                    $appointment_id = $this->finance_model->getPaymentById($inserted_id)->appointment_id;
                    $appointment_details = $this->appointment_model->getAppointmentById($appointment_id);
                    if ($appointment_details->status == 'Requested') {
                        $data_appointment_status = array('status' => 'Confirmed', 'payment_status' => 'paid');
                    } else {
                        $data_appointment_status = array('payment_status' => 'paid');
                    }
                    $this->appointment_model->updateAppointment($appointment_id, $data_appointment_status);
                    $this->session->set_flashdata('feedback', lang('added'));
                } else {
                    $this->session->set_flashdata('feedback', lang('transaction_failed'));
                }
            } elseif ($gateway == 'SSLCOMMERZ') {

                //   $SSLCOMMERZ = $this->db->get_where('paymentGateway', array('name =' => 'SSLCOMMERZ'))->row();


                $this->load->module('sslcommerzpayment');

                $this->sslcommerzpayment->request_api_hosted($consultant_fee, $patient, $inserted_id, $this->ion_auth->get_user_id(), $redirectlink);
            } else {
                $this->session->set_flashdata('feedback', lang('payment_failed_no_gateway_selected'));
                $appointment_id = $this->finance_model->getPaymentById($inserted_id)->appointment_id;
                $data_appointment_status = array('payment_status' => 'unpaid');
                $this->appointment_model->updateAppointment($appointment_id, $data_appointment_status);
            }
        } else {
            $data1 = array();
            $data1 = array(
                'date' => $date,
                'patient' => $patient,
                'deposited_amount' => $consultant_fee,
                'payment_id' => $inserted_id,
                'amount_received_id' => $inserted_id . '.' . 'gp',
                'deposit_type' => $deposit_type,
                'user' => $this->ion_auth->get_user_id(),
                'payment_from' => 'appointment'
            );
            $this->finance_model->insertDeposit($data1);

            $data_payment = array('amount_received' => $consultant_fee, 'deposit_type' => 'Cash', 'status' => 'paid');
            $this->finance_model->updatePayment($inserted_id, $data_payment);
            $appointment_id = $this->finance_model->getPaymentById($inserted_id)->appointment_id;
            $data_appointment_status = array('payment_status' => 'paid');
            $this->appointment_model->updateAppointment($appointment_id, $data_appointment_status);
            $this->session->set_flashdata('feedback', lang('payment_successful'));
        }
        if ($redirectlink == '10') {
            redirect("appointment");
        } elseif ($redirectlink == 'my_today') {
            redirect("appointment/todays");
        } elseif ($redirectlink == 'upcoming') {
            redirect("appointment/upcoming");
        } elseif ($redirectlink == 'med_his') {
            redirect("patient/medicalHistory?id=" . $patient);
        } elseif ($redirectlink == 'request') {
            redirect("appointment/request");
        }
    }

    public function diagnosticReport() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        if ($this->ion_auth->in_group(array('Patient'))) {
            $current_user = $this->ion_auth->get_user_id();
            $patient_user_id = $this->patient_model->getPatientByIonUserId($current_user)->id;
            $data['payments'] = $this->finance_model->getPaymentByPatientId($patient_user_id);
        } else {
            $data['payments'] = $this->finance_model->getPayment();
        }

        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('diagnostic_report', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function medicalHistory() {
        $data = array();
        $id = $this->input->get('id');

        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $id = $this->patient_model->getPatientByIonUserId($patient_ion_id)->id;
        }

        $data['patient'] = $this->patient_model->getPatientById($id);
        $data['appointments'] = $this->appointment_model->getAppointmentByPatient($data['patient']->id);
        $data['patients'] = $this->patient_model->getPatient();
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['prescriptions'] = $this->prescription_model->getPrescriptionByPatientId($id);
        $data['labs'] = $this->lab_model->getLabByPatientId($id);
        $data['beds'] = $this->bed_model->getBedAllotmentsByPatientId($id);
        $data['medical_histories'] = $this->patient_model->getMedicalHistoryByPatientId($id);
        $data['patient_materials'] = $this->patient_model->getPatientMaterialByPatientId($id);
        $data['settings'] = $this->settings_model->getSettings();
        $data['gateway'] = $this->pgateway_model->getPaymentGatewaySettingsByName($data['settings']->payment_gateway);

        foreach ($data['appointments'] as $appointment) {
            $doctor_details = $this->doctor_model->getDoctorById($appointment->doctor);
            if (!empty($doctor_details)) {
                $doctor_name = $doctor_details->name;
            } else {
                $doctor_name = '';
            }
            $timeline[$appointment->date + 1] = '<div class="panel-body profile-activity" >
                <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('appointment') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $appointment->date) . '</h5>
                                            <div class="activity terques">
                                                <span>
                                                    <i class="fa fa-stethoscope"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $appointment->date) . '</h4>
                                                            <p></p>
                                                            <i class=" fa fa-user-md"></i>
                                                                <h4>' . $doctor_name . '</h4>
                                                                    <p></p>
                                                                    <i class=" fa fa-clock-o"></i>
                                                                <p>' . $appointment->s_time . ' - ' . $appointment->e_time . '</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['prescriptions'] as $prescription) {
            $doctor_details = $this->doctor_model->getDoctorById($prescription->doctor);
            if (!empty($doctor_details)) {
                $doctor_name = $doctor_details->name;
            } else {
                $doctor_name = '';
            }
            $timeline[$prescription->date + 2] = '<div class="panel-body profile-activity" >
                                           <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('prescription') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $prescription->date) . '</h5>
                                            <div class="activity purple">
                                                <span>
                                                    <i class="fa fa-medkit"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $prescription->date) . '</h4>
                                                            <p></p>
                                                            <i class=" fa fa-user-md"></i>
                                                                <h4>' . $doctor_name . '</h4>
                                                                    <a class="btn btn-info btn-xs detailsbutton" title="View" href="prescription/viewPrescription?id=' . $prescription->id . '"><i class="fa fa-eye"> View</i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['labs'] as $lab) {

            $doctor_details = $this->doctor_model->getDoctorById($lab->doctor);
            if (!empty($doctor_details)) {
                $lab_doctor = $doctor_details->name;
            } else {
                $lab_doctor = '';
            }

            $timeline[$lab->date + 3] = '<div class="panel-body profile-activity" >
                                            <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('lab') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $lab->date) . '</h5>
                                            <div class="activity blue">
                                                <span>
                                                    <i class="fa fa-flask"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $lab->date) . '</h4>
                                                            <p></p>
                                                             <i class=" fa fa-user-md"></i>
                                                                <h4>' . $lab_doctor . '</h4>
                                                                    <a class="btn btn-xs invoicebutton" title="Lab" style="color: #fff;" href="lab/invoice?id=' . $lab->id . '"><i class="fa fa-file-text"></i>' . lang('report') . '</a>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['medical_histories'] as $medical_history) {
            $timeline[$medical_history->date + 4] = '<div class="panel-body profile-activity" >
                                            <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('case_history') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $medical_history->date) . '</h5>
                                            <div class="activity greenn">
                                                <span>
                                                    <i class="fa fa-file"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $medical_history->date) . '</h4>
                                                            <p></p>
                                                             <i class=" fa fa-note"></i> 
                                                                <p>' . $medical_history->description . '</p>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['patient_materials'] as $patient_material) {
            $timeline[$patient_material->date + 5] = '<div class="panel-body profile-activity" >
                                           <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('documents') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $patient_material->date) . '</h5>
                                            <div class="activity purplee">
                                                <span>
                                                    <i class="fa fa-file-o"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $patient_material->date) . ' <a class="pull-right" title="' . lang('download') . '"  href="' . $patient_material->url . '" download=""> <i class=" fa fa-download"></i> </a> </h4>
                                                                
                                                                 <h4>' . $patient_material->title . '</h4>
                                                            
                                                                
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        if (!empty($timeline)) {
            $data['timeline'] = $timeline;
        }
        $data['packages'] = $this->packages_model->getPackages();
        $data['payment_category'] = $this->finance_model->getPaymentCategory();
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
        $data['surgeries'] = $this->surgery_model->getSurgery();
        $data['blood_group'] = $this->bed_model->getBloodGroup();

        $data['room_no'] = $this->bed_model->getBedCategory();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('medical_history', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editMedicalHistoryByJason() {
        $id = $this->input->get('id');
        $data['medical_history'] = $this->patient_model->getMedicalHistoryById($id);
        $data['patient'] = $this->patient_model->getPatientById($data['medical_history']->patient_id);
        echo json_encode($data);
    }

    function getCaseDetailsByJason() {
        $id = $this->input->get('id');
        $data['case'] = $this->patient_model->getMedicalHistoryById($id);
        $patient = $data['case']->patient_id;
        $data['patient'] = $this->patient_model->getPatientById($patient);
        echo json_encode($data);
    }

    function getPatientByAppointmentByDctorId($doctor_id) {
        $data = array();
        $appointments = $this->appointment_model->getAppointmentByDoctor($doctor_id);
        foreach ($appointments as $appointment) {
            $patient_exists = $this->patient_model->getPatientById($appointment->patient);
            if (!empty($patient_exists)) {
                $patients[] = $appointment->patient;
            }
        }

        if (!empty($patients)) {
            $patients = array_unique($patients);
        } else {
            $patients = '';
        }

        return $patients;
    }

    function patientMaterial() {
        $data = array();
        $id = $this->input->get('patient');
        $data['settings'] = $this->settings_model->getSettings();
        $data['patient'] = $this->patient_model->getPatientById($id);
        $data['patient_materials'] = $this->patient_model->getPatientMaterialByPatientId($id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('patient_material', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function addPatientMaterial() {
        $title = $this->input->post('title');
        $patient_id = $this->input->post('patient');
        $img_url = $this->input->post('img_url');
        $date = time();
        $redirect = $this->input->post('redirect');

        if ($this->ion_auth->in_group(array('Patient'))) {
            if (empty($patient_id)) {
                $current_patient = $this->ion_auth->get_user_id();
                $patient_id = $this->patient_model->getPatientByIonUserId($current_patient)->id;
            }
        }


        if (empty($redirect)) {
            $redirect = "patient/medicalHistory?id=" . $patient_id;
        }
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Patient Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('feedback', lang('validation_error'));
            redirect($redirect);
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
                'allowed_types' => "gif|jpg|png|jpeg|pdf|docx|doc|odt",
                'overwrite' => False,
                'max_size' => "48000000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
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
                    'date' => $date,
                    'title' => $title,
                    'url' => $img_url,
                    'patient' => $patient_id,
                    'patient_name' => $patient_name,
                    'patient_address' => $patient_address,
                    'patient_phone' => $patient_phone,
                    'date_string' => date('d-m-y', $date),
                );
            } else {
                $data = array();
                $data = array(
                    'date' => $date,
                    'title' => $title,
                    'patient' => $patient_id,
                    'patient_name' => $patient_name,
                    'patient_address' => $patient_address,
                    'patient_phone' => $patient_phone,
                    'date_string' => date('d-m-y', $date),
                );
                $this->session->set_flashdata('feedback', lang('upload_error'));
            }

            $this->patient_model->insertPatientMaterial($data);
            $this->session->set_flashdata('feedback', lang('added'));

            redirect($redirect);
        }
    }

    function deleteCaseHistory() {
        $id = $this->input->get('id');
        $redirect = $this->input->get('redirect');
        $case_history = $this->patient_model->getMedicalHistoryById($id);
        $this->patient_model->deleteMedicalHistory($id);
        $this->log_model->insertLog($this->ion_auth->get_user_id(), date('d-m-Y H:i:s', time()), 'Delete Case History(id=' . $id . ' )', $id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        if ($redirect == 'case') {
            redirect('patient/caseList');
        } else {
            redirect("patient/MedicalHistory?id=" . $case_history->patient_id);
        }
    }

    function deletePatientMaterial() {
        $id = $this->input->get('id');
        $redirect = $this->input->get('redirect');
        $patient_material = $this->patient_model->getPatientMaterialById($id);
        $path = $patient_material->url;
        if (!empty($path)) {
            unlink($path);
        }
        $this->patient_model->deletePatientMaterial($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        if ($redirect == 'documents') {
            redirect('patient/documents');
        } else {
            redirect("patient/MedicalHistory?id=" . $patient_material->patient);
        }
    }

    function delete() {
        $data = array();
        $id = $this->input->get('id');
        $user_data = $this->db->get_where('patient', array('id' => $id))->row();
        $path = $user_data->img_url;

        if (!empty($path)) {
            unlink($path);
        }
        $ion_user_id = $user_data->ion_user_id;
        $this->db->where('id', $ion_user_id);
        $this->db->delete('users');
        $this->patient_model->delete($id);
        $this->log_model->insertLog($this->ion_auth->get_user_id(), date('d-m-Y H:i:s', time()), 'Delete Patient(id=' . $id . ' )', $id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('patient');
    }

    function getPatient() {
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
                $data['patients'] = $this->patient_model->getPatientBysearch($search, $order, $dir);
            } else {
                $data['patients'] = $this->patient_model->getPatientWithoutSearch($order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['patients'] = $this->patient_model->getPatientByLimitBySearch($limit, $start, $search, $order, $dir);
            } else {
                $data['patients'] = $this->patient_model->getPatientByLimit($limit, $start, $order, $dir);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $permis = '';
        $permis_1 = '';
        $permis_2 = '';
        $permis_finance = '';
        $permis_finance_2 = '';
        foreach ($this->permission_access_group_explode as $perm) {
            $perm_explode = array();
            $perm_explode = explode(",", $perm);
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Patient') {
                $permis = 'ok';
                //  break;
            }
            if (in_array('1', $perm_explode) && $perm_explode[0] == 'Patient') {
                $permis_2 = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Patient') {
                $permis_1 = 'ok';
                //  break;
            }
            if (in_array('1', $perm_explode) && $perm_explode[0] == 'Finance') {
                $permis_finance = 'ok';
                //  break;
            }
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Finance') {
                $permis_finance_2 = 'ok';
                //  break;
            }
        }
        $options1 = '';
        $options2 = '';
        $options3 = '';
        $options4 = '';
        $options5 = '';
        $options6 = '';
        $barcode = '';
        foreach ($data['patients'] as $patient) {

            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Laboratorist', 'Nurse', 'Doctor')) || $permis == 'ok') {
                //   $options1 = '<a type="button" class="btn editbutton" title="Edit" data-toggle="modal" data-id="463"><i class="fa fa-edit"> </i> Edit</a>';
                $barcode = '<a class="btn btn-info btn-xs invoicebutton" title="' . lang('print') . ' ' . lang('barcode') . '" style="color: #fff;background: #022c2f !important;" href="patient/printBarcode?id=' . $patient->id . '"target="_blank"> <i class="fa fa-print"></i> ' . lang('print') . ' ' . lang('barcode') . '</a>';
                $options1 = ' <a type="button" class="btn editbutton" title="' . lang('edit') . '" data-toggle = "modal" data-id="' . $patient->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</a>';
            }
            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Nurse', 'Doctor', 'Laboratorist', 'Receptionist')) || $permis_2 == 'ok') {
                $options2 = '<a class="btn detailsbutton" title="' . lang('info') . '" style="color: #fff;" href="patient/patientDetails?id=' . $patient->id . '"><i class="fa fa-info"></i> ' . lang('info') . '</a>';
                $options6 = ' <a type="button" class="btn detailsbutton inffo" title="' . lang('info') . '" data-toggle = "modal" data-id="' . $patient->id . '"><i class="fa fa-info"> </i> ' . lang('info') . '</a>';
                $options3 = '<a class="btn green" title="' . lang('history') . '" style="color: #fff;" href="patient/medicalHistory?id=' . $patient->id . '"><i class="fa fa-stethoscope"></i> ' . lang('history') . '</a>';
            }
            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Nurse', 'Doctor', 'Laboratorist', 'Receptionist')) || $permis_finance == 'ok' || $permis_finance_2 == 'ok') {
                $options4 = '<a class="btn invoicebutton" title="' . lang('payment') . '" style="color: #fff;" href="finance/patientPaymentHistory?patient=' . $patient->id . '"><i class="fa fa-money-bill-alt"></i> ' . lang('payment') . '</a>';
            }
            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Laboratorist', 'Nurse', 'Doctor')) || $permis_1 == 'ok') {
                $options5 = '<a class="btn delete_button" title="' . lang('delete') . '" href="patient/delete?id=' . $patient->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"></i> ' . lang('delete') . '</a>';
            }




            if ($this->ion_auth->in_group('Doctor')) {
                $options7 = '<a class="btn green detailsbutton" title="' . lang('instant_meeting') . '" style="color: #fff;" href="meeting/instantLive?id=' . $patient->id . '" onclick="return confirm(\'Are you sure you want to start a live meeting with this patient? SMS and Email will be sent to the Patient.\');"><i class="fa fa-headphones"></i> ' . lang('start_live') . '</a>';
            } else {
                $options7 = '';
            }


            if ($this->ion_auth->in_group(array('admin')) || in_array('Patient', $this->pers)) {
                $info[] = array(
                    $patient->id,
                    $patient->name,
                    $patient->phone,
                    $this->settings_model->getSettings()->currency . $this->patient_model->getDueBalanceByPatientId($patient->id),
                    $options1 . ' ' . $options6 . ' ' . $options3 . ' ' . $options4 . ' ' . $barcode . ' ' . $options5,
                        //  $options2
                );
            }

            if ($this->ion_auth->in_group(array('Accountant', 'Receptionist'))) {
                $info[] = array(
                    $patient->id,
                    $patient->name,
                    $patient->phone,
                    $this->settings_model->getSettings()->currency . $this->patient_model->getDueBalanceByPatientId($patient->id),
                    $options1 . ' ' . $options6 . ' ' . $barcode . ' ' . $options4,
                        //  $options2
                );
            }

            if ($this->ion_auth->in_group(array('Laboratorist', 'Nurse', 'Doctor'))) {
                $info[] = array(
                    $patient->id,
                    $patient->name,
                    $patient->phone,
                    $options1 . ' ' . $options6 . ' ' . $barcode . ' ' . $options3,
                        //  $options2
                );
            }
        }

        if (!empty($data['patients'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('patient')->num_rows(),
                "recordsFiltered" => $this->db->get('patient')->num_rows(),
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

    function getPatientPayments() {
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
                $data['patients'] = $this->patient_model->getPatientBysearch($search, $order, $dir);
            } else {
                $data['patients'] = $this->patient_model->getPatientWithoutSearch($order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['patients'] = $this->patient_model->getPatientByLimitBySearch($limit, $start, $search, $order, $dir);
            } else {
                $data['patients'] = $this->patient_model->getPatientByLimit($limit, $start, $order, $dir);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();

        foreach ($data['patients'] as $patient) {

            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Laboratorist', 'Nurse', 'Doctor'))) {
                //   $options1 = '<a type="button" class="btn editbutton" title="Edit" data-toggle="modal" data-id="463"><i class="fa fa-edit"> </i> Edit</a>';
                $options1 = ' <a type="button" class="btn editbutton" title="' . lang('edit') . '" data-toggle = "modal" data-id="' . $patient->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</a>';
            }

            $options2 = '<a class="btn detailsbutton" title="' . lang('info') . '" style="color: #fff;" href="patient/patientDetails?id=' . $patient->id . '"><i class="fa fa-info"></i> ' . lang('info') . '</a>';

            $options3 = '<a class="btn green" title="' . lang('history') . '" style="color: #fff;" href="patient/medicalHistory?id=' . $patient->id . '"><i class="fa fa-stethoscope"></i> ' . lang('history') . '</a>';

            $options4 = '<a class="btn btn-xs green" title="' . lang('payment') . ' ' . lang('history') . '" style="color: #fff;" href="finance/patientPaymentHistory?patient=' . $patient->id . '"><i class="fa fa-money-bill-alt"></i> ' . lang('payment') . ' ' . lang('history') . '</a>';

            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Laboratorist', 'Nurse', 'Doctor'))) {
                $options5 = '<a class="btn delete_button" title="' . lang('delete') . '" href="patient/delete?id=' . $patient->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"></i> ' . lang('delete') . '</a>';
            }

            $due = $this->settings_model->getSettings()->currency . $this->patient_model->getDueBalanceByPatientId($patient->id);

            $info[] = array(
                $patient->id,
                $patient->name,
                $patient->phone,
                $due,
                //  $options1 . ' ' . $options2 . ' ' . $options3 . ' ' . $options4 . ' ' . $options5,
                $options4
            );
        }

        if (!empty($data['patients'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('patient')->num_rows(),
                "recordsFiltered" => $this->db->get('patient')->num_rows(),
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

    function getCaseList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        $order = $this->input->post("order");
        $columns_valid = array(
            "0" => "date",
            "1" => "patient",
            "2" => "title",
        );
        $values = $this->settings_model->getColumnOrder($order, $columns_valid);
        $dir = $values[0];
        $order = $values[1];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->patient_model->getMedicalHistoryBySearch($search, $order, $dir);
            } else {
                $data['cases'] = $this->patient_model->getMedicalHistoryWithoutSearch($order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->patient_model->getMedicalHistoryByLimitBySearch($limit, $start, $search, $order, $dir);
            } else {
                $data['cases'] = $this->patient_model->getMedicalHistoryByLimit($limit, $start, $order, $dir);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $permis = '';
        $permis_1 = '';
        $permis_2 = '';
        foreach ($this->permission_access_group_explode as $perm) {
            $perm_explode = array();
            //$permis='';
            // $permis_1='';
            $perm_explode = explode(",", $perm);
            if (in_array('1', $perm_explode) && $perm_explode[0] == 'Patient') {
                $permis = 'ok';
                //  break;
            }
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Patient') {
                $permis_1 = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Patient') {
                $permis_2 = 'ok';
                //  break;
            }
        }
        $options1 = $options2 = $options3 = '';
        foreach ($data['cases'] as $case) {

            if ($this->ion_auth->in_group(array('admin')) || $permis_1 == 'ok') {
                //   $options1 = '<a type="button" class="btn editbutton" title="Edit" data-toggle="modal" data-id="463"><i class="fa fa-edit"> </i> Edit</a>';
                // $options1 = ' <a type="button" class="btn btn-info btn-xs btn_width editbutton" title="' . lang('edit') . '" data-toggle = "modal" data-id="' . $case->id . '"><i class="fa fa-edit"> </i> </a>';
                $options1 = '<a class="btn btn-info btn-xs btn_width" title="' . lang('edit') . '" href="patient/editCaseHistory?id=' . $case->id . '&redirect=case" ><i class="fa fa-edit"></i></a>';
            }
            if ($this->ion_auth->in_group(array('admin')) || $permis_2 == 'ok') {
                $options2 = '<a class="btn btn-info btn-xs btn_width delete_button" title="' . lang('delete') . '" href="patient/deleteCaseHistory?id=' . $case->id . '&redirect=case" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"></i></a>';
            }
            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Laboratorist')) || in_array('Patient', $this->pers)) {
                if ($case->status == 'Confirmed') {
                    $options3 = '<a class="btn btn-success btn-xs btn_width" title="' . lang('invoice') . '" href="finance/invoice?id=' . $case->payment_id . '" ><i class="fa fa-file-invoice"></i></a>';
                } else {
                    $options3 = '';
                }
            }

            /* if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Laboratorist', 'Nurse', 'Doctor')) || in_array('Patient', $this->pers)) {
              $options3 = ' <a type="button" class="btn btn-info btn-xs btn_width detailsbutton case" title="' . lang('case') . '" data-toggle = "modal" data-id="' . $case->id . '"><i class="fa fa-file"> </i> </a>';
              } */

            if (!empty($case->patient_id)) {
                $patient_info = $this->patient_model->getPatientById($case->patient_id);
                if (!empty($patient_info)) {
                    $patient_details = $patient_info->name . '</br>' . $patient_info->address . '</br>' . $patient_info->phone . '</br>';
                } else {
                    $patient_details = $case->patient_name . '</br>' . $case->patient_address . '</br>' . $case->patient_phone . '</br>';
                }
            } else {
                $patient_details = '';
            }
            if ($case->status == 'Pending Confirmation') {
                $status = lang('pending_confirmation');
            }
            if ($case->status == 'Confirmed') {
                $status = lang('confirmed');
            }
            $description = array();
            $option_description = '';
            $descriptions = explode('##', $case->description);
            foreach ($descriptions as $description) {
                $description_single = array();
                $description_single = explode('**', $description);
                if ($description_single[0] == 'Package') {
                    $option_description .= '<ul><li>' . $description_single[0] . '-' . $description_single[1] . '</li></ul>';
                } else {
                    $option_description .= '<ul><li>' . $description_single[1] . '</li></ul>';
                }
            }
            $info[] = array(
                date('d-m-Y', $case->date),
                $patient_details,
                $case->title,
                $option_description,
                $status,
                $options3 . ' ' . $options1 . ' ' . $options2
                    // $options4
            );
        }

        if (!empty($data['cases'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('medical_history')->num_rows(),
                "recordsFiltered" => $this->db->get('medical_history')->num_rows(),
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

    function getDocuments() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        $order = $this->input->post("order");
        $columns_valid = array(
            "0" => "date",
            "1" => "patient",
        );
        $values = $this->settings_model->getColumnOrder($order, $columns_valid);
        $dir = $values[0];
        $order = $values[1];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['documents'] = $this->patient_model->getDocumentBySearch($search, $order, $dir);
            } else {
                $data['documents'] = $this->patient_model->getPatientMaterialWithoutSearch($order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['documents'] = $this->patient_model->getDocumentByLimitBySearch($limit, $start, $search, $order, $dir);
            } else {
                $data['documents'] = $this->patient_model->getDocumentByLimit($limit, $start, $order, $dir);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $permis = '';
        $permis_1 = '';
        $permis_2 = '';
        foreach ($this->permission_access_group_explode as $perm) {
            $perm_explode = array();
            //$permis='';
            // $permis_1='';
            $perm_explode = explode(",", $perm);
            if (in_array('1', $perm_explode) && $perm_explode[0] == 'Patient') {
                $permis = 'ok';
                //  break;
            }
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Patient') {
                $permis_1 = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Patient') {
                $permis_2 = 'ok';
                //  break;
            }
        }
        $options1 = $options2 = $options3 = '';
        foreach ($data['documents'] as $document) {

            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Laboratorist', 'Nurse', 'Doctor')) || in_array("Patient", $this->pers)) {
                //   $options1 = '<a type="button" class="btn editbutton" title="Edit" data-toggle="modal" data-id="463"><i class="fa fa-edit"> </i> Edit</a>';
                $options1 = '<a class="btn btn-info btn-xs" href="' . $document->url . '" download> ' . lang('download') . ' </a>';
            }
            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Laboratorist', 'Nurse', 'Doctor')) || $permis_2 == 'ok') {
                $options2 = '<a class="btn btn-info btn-xs delete_button" href="patient/deletePatientMaterial?id=' . $document->id . '&redirect=documents"onclick="return confirm(\'You want to delete the item??\');"> X </a>';
            }

            if (!empty($document->patient)) {
                $patient_info = $this->patient_model->getPatientById($document->patient);
                if (!empty($patient_info)) {
                    $patient_details = $patient_info->name . '</br>' . $patient_info->address . '</br>' . $patient_info->phone . '</br>';
                } else {
                    $patient_details = $document->patient_name . '</br>' . $document->patient_address . '</br>' . $document->patient_phone . '</br>';
                }
            } else {
                $patient_details = '';
            }
            $extension_url = explode(".", $document->url);

            $length = count($extension_url);
            $extension = $extension_url[$length - 1];

            if (strtolower($extension) == 'pdf') {
                $files = '<a class="example-image-link" href="' . $document->url . '" data-title="' . $document->title . '" target="_blank">' . '<img class="example-image" src="uploads/image/pdf.png" width="100px" height="100px"alt="image-1">' . '</a>';
            } elseif (strtolower($extension) == 'docx') {
                $files = '<a class="example-image-link" href="' . $document->url . '" data-title="' . $document->title . '">' . '<img class="example-image" src="uploads/image/docx.png" width="100px" height="100px"alt="image-1">' . '</a>';
            } elseif (strtolower($extension) == 'doc') {
                $files = '<a class="example-image-link" href="' . $document->url . '" data-title="' . $document->title . '">' . '<img class="example-image" src="uploads/image/doc.png" width="100px" height="100px"alt="image-1">' . '</a>';
            } elseif (strtolower($extension) == 'odt') {
                $files = '<a class="example-image-link" href="' . $document->url . '" data-title="' . $document->title . '">' . '<img class="example-image" src="uploads/image/odt.png" width="100px" height="100px"alt="image-1">' . '</a>';
            } else {
                $files = '<a class="example-image-link" href="' . $document->url . '" data-lightbox="example-1" data-title="' . $document->title . '">' . '<img class="example-image" src="' . $document->url . '" width="100px" height="100px"alt="image-1">' . '</a>';
            }
            $info[] = array(
                date('d-m-y', $document->date),
                $patient_details,
                $document->title,
                $files,
                $options1 . ' ' . $options2
                    // $options4
            );
        }

        if (!empty($data['documents'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('patient_material')->num_rows(),
                "recordsFiltered" => $this->db->get('patient_material')->num_rows(),
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

    function getMedicalHistoryByJason() {
        $data = array();

        $from_where = $this->input->get('from_where');
        $id = $this->input->get('id');

        if (!empty($from_where)) {
            $this->db->where('id', $id);
            $id = $this->db->get('appointment')->row()->patient;
        }


        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $id = $this->patient_model->getPatientByIonUserId($patient_ion_id)->id;
        }

        $patient = $this->patient_model->getPatientById($id);
        $appointments = $this->appointment_model->getAppointmentByPatient($patient->id);
        $patients = $this->patient_model->getPatient();
        $doctors = $this->doctor_model->getDoctor();
        $data['prescriptions'] = $this->prescription_model->getPrescriptionByPatientId($id);
        $beds = $this->bed_model->getBedAllotmentsByPatientId($id);
        //  $orders = $this->order_model->getOrderByPatientId($id);
        $labs = $this->lab_model->getLabByPatientId($id);
        $medical_histories = $this->patient_model->getMedicalHistoryByPatientId($id);
        $patient_materials = $this->patient_model->getPatientMaterialByPatientId($id);

        foreach ($appointments as $appointment) {

            $doctor_details = $this->doctor_model->getDoctorById($appointment->doctor);
            if (!empty($doctor_details)) {
                $doctor_name = $doctor_details->name;
            } else {
                $doctor_name = '';
            }

            $timeline[$appointment->date + 1] = '<div class="panel-body profile-activity" >
                <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('appointment') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $appointment->date) . '</h5>
                                            <div class="activity terques">
                                                <span>
                                                    <i class="fa fa-stethoscope"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $appointment->date) . '</h4>
                                                            <p></p>
                                                            <i class=" fa fa-user-md"></i>
                                                                <h4>' . $doctor_name . '</h4>
                                                                    <p></p>
                                                                    <i class=" fa fa-clock-o"></i>
                                                                <p>' . $appointment->s_time . ' - ' . $appointment->e_time . '</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
        }


        foreach ($data['prescriptions'] as $prescription) {
            $doctor_details = $this->doctor_model->getDoctorById($prescription->doctor);
            if (!empty($doctor_details)) {
                $doctor_name = $doctor_details->name;
            } else {
                $doctor_name = '';
            }
            $timeline[$prescription->date + 6] = '<div class="panel-body profile-activity" >
                                           <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('prescription') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $prescription->date) . '</h5>
                                            <div class="activity purple">
                                                <span>
                                                    <i class="fa fa-medkit"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $prescription->date) . '</h4>
                                                            <p></p>
                                                            <i class=" fa fa-user-md"></i>
                                                                <h4>' . $doctor_name . '</h4>
                                                                    <a class="btn btn-info btn-xs detailsbutton" title="View" href="prescription/viewPrescription?id=' . $prescription->id . '"><i class="fa fa-eye"> View</i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
        }
        foreach ($labs as $lab) {

            $doctor_details = $this->doctor_model->getDoctorById($lab->doctor);
            if (!empty($doctor_details)) {
                $lab_doctor = $doctor_details->name;
            } else {
                $lab_doctor = '';
            }

            $timeline[$lab->date + 3] = '<div class="panel-body profile-activity" >
                                            <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('lab') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $lab->date) . '</h5>
                                            <div class="activity blue">
                                                <span>
                                                    <i class="fa fa-flask"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $lab->date) . '</h4>
                                                            <p></p>
                                                             <i class=" fa fa-user-md"></i>
                                                                <h4>' . $lab_doctor . '</h4>
                                                                    <a class="btn btn-xs invoicebutton" title="Lab" style="color: #fff;" href="lab/invoice?id=' . $lab->id . '"><i class="fa fa-file-text"></i>' . lang('report') . '</a>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($medical_histories as $medical_history) {
            $timeline[$medical_history->date + 4] = '<div class="panel-body profile-activity" >
                                            <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('case_history') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $medical_history->date) . '</h5>
                                            <div class="activity greenn">
                                                <span>
                                                    <i class="fa fa-file"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $medical_history->date) . '</h4>
                                                            <p></p>
                                                             <i class=" fa fa-note"></i> 
                                                                <p>' . $medical_history->description . '</p>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($patient_materials as $patient_material) {
            $timeline[$patient_material->date + 5] = '<div class="panel-body profile-activity" >
                                           <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('documents') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $patient_material->date) . '</h5>
                                            <div class="activity purplee">
                                                <span>
                                                    <i class="fa fa-file-o"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $patient_material->date) . ' <a class="pull-right" title="' . lang('download') . '"  href="' . $patient_material->url . '" download=""> <i class=" fa fa-download"></i> </a> </h4>
                                                                
                                                                 <h4>' . $patient_material->title . '</h4>
                                                            
                                                                
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }





        if (!empty($timeline)) {
            krsort($timeline);
            $timeline_value = '';
            foreach ($timeline as $key => $value) {
                $timeline_value .= $value;
            }
        }















        $all_appointments = '';
        foreach ($appointments as $appointment) {

            $doctor_details = $this->doctor_model->getDoctorById($appointment->doctor);
            if (!empty($doctor_details)) {
                $appointment_doctor = $doctor_details->name;
            } else {
                $appointment_doctor = "";
            }



            $patient_appointments = '<tr class = "">

        <td>' . date("d-m-Y", $appointment->date) . '
        </td>
        <td>' . $appointment->time_slot . '</td>
        <td>'
                    . $appointment_doctor . '
        </td>
        <td>' . $appointment->status . '</td>
        <td><a type="button" href="appointment/editAppointment?id=' . $appointment->id . '" class="btn btn-info btn-xs btn_width" title="Edit" data-id="' . $appointment->id . '">' . lang('edit') . '</a></td>

        </tr>';

            $all_appointments .= $patient_appointments;
        }




        if (empty($all_appointments)) {
            $all_appointments = '';
        }



        $all_case = '';

        foreach ($medical_histories as $medical_history) {
            $patient_case = ' <tr class="">
                                                    <td>' . date("d-m-Y", $medical_history->date) . '</td>
                                                    <td>' . $medical_history->title . '</td>
                                                    <td>' . $medical_history->description . '</td>
                                                </tr>';

            $all_case .= $patient_case;
        }


        if (empty($all_case)) {
            $all_case = '';
        }
        $all_prescription = '';

        foreach ($data['prescriptions'] as $prescription) {
            $doctor_details = $this->doctor_model->getDoctorById($prescription->doctor);
            if (!empty($doctor_details)) {
                $prescription_doctor = $doctor_details->name;
            } else {
                $prescription_doctor = '';
            }
            $medicinelist = '';
            if (!empty($prescription->medicine)) {
                $medicine = explode('###', $prescription->medicine);

                foreach ($medicine as $key => $value) {
                    $medicine_id = explode('***', $value);
                    $medicine_details = $this->medicine_model->getMedicineById($medicine_id[0]);
                    if (!empty($medicine_details)) {
                        $medicine_name_with_dosage = $medicine_details->name . ' -' . $medicine_id[1];
                        $medicine_name_with_dosage = $medicine_name_with_dosage . ' | ' . $medicine_id[3] . '<br>';
                        rtrim($medicine_name_with_dosage, ',');
                        $medicinelist .= '<p>' . $medicine_name_with_dosage . '</p>';
                    }
                }
            } else {
                $medicinelist = '';
            }

            $option1 = '<a class="btn btn-info btn-xs btn_width" href="prescription/viewPrescription?id=' . $prescription->id . '"><i class="fa fa-eye">' . lang('view') . '</i></a>';
            $prescription_case = ' <tr class="">
                                                    <td>' . date('m/d/Y', $prescription->date) . '</td>
                                                    <td>' . $prescription_doctor . '</td>
                                                    <td>' . $medicinelist . '</td>
                                                         <td>' . $option1 . '</td>
                                                </tr>';

            $all_prescription .= $prescription_case;
        }


        if (empty($all_prescription)) {
            $all_prescription = '';
        }


        $all_lab = '';

        foreach ($labs as $lab) {
            $doctor_details = $this->doctor_model->getDoctorById($lab->doctor);
            if (!empty($doctor_details)) {
                $lab_doctor = $doctor_details->name;
            } else {
                $lab_doctor = "";
            }
            $option1 = '<a class="btn btn-info btn-xs btn_width" href="lab/invoice?id=' . $lab->id . '"><i class="fa fa-eye">' . lang('report') . '</i></a>';
            $lab_class = ' <tr class="">
                                                    <td>' . $lab->id . '</td>
                                                    <td>' . date("m/d/Y", $lab->date) . '</td>
                                                    <td>' . $lab_doctor . '</td>
                                                         <td>' . $option1 . '</td>
                                                </tr>';

            $all_lab .= $lab_class;
        }


        if (empty($all_lab)) {
            $all_lab = '';
        }
        $all_bed = '';

        foreach ($beds as $bed) {


            $bed_case = ' <tr class="">
                                                    <td>' . $bed->bed_id . '</td>
                                                    <td>' . $bed->a_time . '</td>
                                                    <td>' . $bed->d_time . '</td>
                                                         
                                                </tr>';

            $all_bed .= $bed_case;
        }


        if (empty($all_bed)) {
            $all_bed = '';
        }


        $all_material = '';
        foreach ($patient_materials as $patient_material) {

            if (!empty($patient_material->title)) {
                $patient_documents = $patient_material->title;
            }


            $patient_material = '
            
                                            <div class="panel col-md-3"  style="height: 200px; margin-right: 10px; margin-bottom: 36px; background: #f1f1f1; padding: 34px;">

                                                <div class="post-info">
                                                    <img src="' . $patient_material->url . '" height="100" width="100">
                                                </div>
                                                <div class="post-info">
                                                    
                                                ' . $patient_documents . '

                                                </div>
                                                <p></p>
                                                <div class="post-info">
                                                    <a class="btn btn-info btn-xs btn_width" href="' . $patient_material->url . '" download> ' . lang("download") . ' </a>
                                                    <a class="btn btn-info btn-xs btn_width" title="' . lang("delete") . '" href="patient/deletePatientMaterial?id=' . $patient_material->id . '"onclick="return confirm("Are you sure you want to delete this item?");"> X </a>
                                                </div>

                                                <hr>

                                            </div>';
            $all_material .= $patient_material;
        }

        if (empty($all_material)) {
            $all_material = ' ';
        }


        if (!empty($patient->img_url)) {
            $profile_image = '<a href="#">
                            <img src="' . $patient->img_url . '" alt="">
                        </a>';
        } else {
            $profile_image = '';
        }



        $data['view'] = '
        <section class="col-md-3">
            <header class="panel-heading clearfix">
                <div class="">
                    ' . lang("patient") . ' ' . lang("info") . ' 
                </div>

            </header> 




            <aside class="profile-nav">
                <section class="">
                    <div class="user-heading round">
                        ' . $profile_image . '
                        <h1>' . $patient->name . '</h1>
                        <p> ' . $patient->email . ' </p>
                    </div>

                    <ul class="nav nav-pills nav-stacked">
                        <li class="active"> ' . lang("patient") . ' ' . lang("name") . '<span class="label pull-right r-activity">' . $patient->name . '</span></li>
                        <li>  ' . lang("patient_id") . ' <span class="label pull-right r-activity">' . $patient->id . '</span></li>
                        <li>  ' . lang("phone") . '<span class="label pull-right r-activity">' . $patient->phone . '</span></li>
                        <li>  ' . lang("email") . '<span class="label pull-right r-activity">' . $patient->email . '</span></li>
                        <li>  ' . lang("gender") . '<span class="label pull-right r-activity">' . $patient->sex . '</span></li>
                        <li>  ' . lang("birth_date") . '<span class="label pull-right r-activity">' . $patient->birthdate . '</span></li>
                        <li style="height: 200px;">  ' . lang("address") . '<span class="pull-right r-activity" style="height: 200px;">' . $patient->address . '</span></li>
                    </ul>

                </section>
            </aside>


        </section>





        <section class="col-md-9">
            <header class="panel-heading clearfix">
                <div class="col-md-7">
                    ' . lang("history") . ' | ' . $patient->name . '
                </div>

            </header>

            <section class="panel-body">   
                <header class="panel-heading tab-bg-dark-navy-blueee">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#appointments">' . lang("appointments") . '</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#home">' . lang("case_history") . '</a>
                        </li>
                         <li class="">
                            <a data-toggle="tab" href="#prescription">' . lang("prescription") . '</a>
                        </li>
                        
                        <li class="">
                            <a data-toggle="tab" href="#lab">' . lang("lab") . '</a>
                        </li>
                        
                        <li class="">
                            <a data-toggle="tab" href="#profile">' . lang("documents") . '</a>
                        </li>
                         <li class="">
                            <a data-toggle="tab" href="#bed">' . lang("bed") . '</a>
                        </li>
                        <li class=""> 
                            <a data-toggle="tab" href="#emergency-med">' . lang("emergency-med") . '</a> 
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#timeline">' . lang("timeline") . '</a> 
                        </li>
                    </ul>
                </header>
                <div class="panel">
                    <div class="tab-content">
                        <div id="appointments" class="tab-pane active">
                            <div class="">

                                <div class="adv-table editable-table ">
                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th>' . lang("date") . '</th>
                                                <th>' . lang("time_slot") . '</th>
                                                <th>' . lang("doctor") . '</th>
                                                <th>' . lang("status") . '</th>
                                                <th>' . lang("option") . '</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . $all_appointments . '
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="home" class="tab-pane">
                            <div class="">



                                <div class="adv-table editable-table ">


                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th>' . lang("date") . '</th>
                                                <th>' . lang("title") . '</th>
                                                <th>' . lang("description") . '</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . $all_case . '
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>
            
                                    <div id="prescription" class="tab-pane">
                                           <div class="">



                                       <div class="adv-table editable-table ">


                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th>' . lang("date") . '</th>
                                                <th>' . lang("doctor") . '</th>
                                                <th>' . lang("medicine") . '</th>
                                                <th>' . lang("options") . '</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . $all_prescription . '
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>
                        <div id="lab" class="tab-pane"> <div class="">
                                <div class="adv-table editable-table ">
                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th>' . lang("id") . '</th>
                                                <th>' . lang("date") . '</th>
                                                <th>' . lang("doctor") . '</th>
                                                <th>' . lang("options") . '</th>
                                            </tr>
                                        </thead>
                                        <tbody>'
                . $all_lab .
                '</tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                           <div id="bed" class="tab-pane"> <div class="">
                                <div class="adv-table editable-table ">
                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th>' . lang("bed_id") . '</th>
                                                <th>' . lang("alloted_time") . '</th>
                                                <th>' . lang("discharge_time") . '</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>'
                . $all_bed .
                '</tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <div id="profile" class="tab-pane"> <div class="">

                                <div class="adv-table editable-table ">
                                    <div class="">
                                        ' . $all_material . '
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="timeline" class="tab-pane"> 
                            <div class="">
                                <div class="">
                                    <section class="panel ">
                                        <header class="panel-heading">
                                            Timeline
                                        </header>


                                        ' . $timeline_value . '

                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</section>



</section>';

        echo json_encode($data);
    }

    public function getPatientinfo() {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->patient_model->getPatientInfo($searchTerm);

        echo json_encode($response);
    }

    public function getPatientinfoWithAddNewOption() {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->patient_model->getPatientinfoWithAddNewOption($searchTerm);

        echo json_encode($response);
    }

    function addcaseListView() {
        $data['settings'] = $this->settings_model->getSettings();
        $data['patients'] = $this->patient_model->getPatient();
        $data['packages'] = $this->packages_model->getPackages();
        $data['payment_category'] = $this->finance_model->getPaymentCategory();
        //   $data['medical_histories'] = $this->patient_model->getMedicalHistory();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_case_list', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    public function getTableTrValue() {
        $medical_analysis = $this->input->get('medical_analysis');
        $package = $this->input->get('package');
        $medical_analysis_details = $this->finance_model->getPaymentCategoryById($medical_analysis);
        $packages = $this->packages_model->getPackagesById($package);
        $option2 = $option5 = $discount_field = " ";

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
            if ($this->ion_auth->in_group(array('admin'))) {
                $discount_field = '<input style="width:41px;" type="number" min="0" step="0.01" name="discount_case[]" value="0" class="discount-price-case" id="case-discount-med-' . $medical_analysis_details->id . '">';
            } else {
                $discount_field = '<input style="width:41px;"type="number" min="0"step="0.01"  name="discount_case[]" value="0" class="discount-price-case" id="case-discount-med-' . $medical_analysis_details->id . '"readonly>';
            }
            $option .= '<tr class="proccedure" id="tr-med-' . $medical_analysis_details->id . '"><td><input type="hidden" name="type_id[]" id="input_id-med-' . $medical_analysis_details->id . '" value="' . $medical_analysis_details->id . '" readonly><input type="text" class="input-category" name="type[]" id="input-med-' . $medical_analysis_details->id . '" value="' . $medical_analysis_details->category . '"readonly></td><td>' . lang('medical_analysis') . ' <input type="hidden" name="from[]" class="from_where" value="Medical Analysis"></td><td><input class="price-indivudual" type="text" name="price[]" style="width:58px;" id="price-med-' . $medical_analysis_details->id . '" value="' . $medical_analysis_details->c_price . '" ></td><td>' . $discount_field . '</td><td class="grand-case" id="grand-case-med-' . $medical_analysis_details->id . '">' . $medical_analysis_details->c_price . '</td><td>' . $option3 . '</td><td>' . $option4 . '</td><td>' . $option2 . '</td></tr>';
        }
        if (!empty($packages)) {
            if ($this->ion_auth->in_group(array('admin'))){
            $discount_field='<input style="width:41px;" type="number" min="0"step="0.01" name="discount_case[]" value="0" class="discount-price-case" id="case-discount-pack-'.$packages->id.'">';
        }else{
            $discount_field='<input style="width:41px;"type="number" min="0" step="0.01" name="discount_case[]" value="0" class="discount-price-case" id="case-discount-pack-'.$packages->id.'"readonly>';
        }
            $option .= '<tr class="proccedure" id="tr-pack-' . $packages->id . '"><td><input type="hidden" name="type_id[]" id="input_id-pack-' . $packages->id . '" value="' . $packages->id . '" readonly><input type="text" class="input-category" name="type[]" id="input-pack-' . $packages->id . '" value="' . $packages->name . '"readonly></td><td>' . lang('package') . '<input type="hidden" class="from_where" name="from[]" value="Package"></td><td><input class="price-indivudual" type="text" name="price[]" style="width:58px;" id="price-pack-' . $packages->id . '" value="' . $packages->single_price . '" ></td><td>' . $discount_field . '</td><td class="grand-case" id="grand-case-pack-' . $packages->id . '">' . $packages->single_price . '</td><td>' . $option3 . '</td><td>' . $option4 . '</td><td>' . $option5 . '</td></tr>';
        }
        $data['option'] = $option;
        echo json_encode($data);
    }

    public function editCaseHistory() {
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['patients'] = $this->patient_model->getPatient();
        $data['packages'] = $this->packages_model->getPackages();
        $data['payment_category'] = $this->finance_model->getPaymentCategory();
        $data['case'] = $this->patient_model->getMedicalHistoryById($id);
        //   $data['medical_histories'] = $this->patient_model->getMedicalHistory();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_case_list', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    public function printBarcode() {


        $id = $this->input->get('id');
        $patient_info = $this->patient_model->getPatientById($id);
        if (!empty($patient_info->barcode_url)) {
            $data['barcode_image'] = $patient_info->barcode_url;
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('print_barcode', $data);
            $this->load->view('home/footer'); // just the footer file
        } else {
            $barcodeOptions = array('text' => '010102-' . $id . '-XYDfSX', 'barHeight' => '50');

            $barcode = 'barcode-' . $id . '-' . rand() . '.png';
            $imageResource = Zend_Barcode::factory('Code128', 'image', $barcodeOptions, array())->draw();

            imagepng($imageResource, './files/barcode/' . $barcode);
            $patient_array = array('barcode_url' => $barcode);
            $this->patient_model->updatePatient($id, $patient_array);
            $data['barcode_image'] = $barcode;
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('print_barcode', $data);
            $this->load->view('home/footer'); // just the footer file
        }
    }

}

/* End of file patient.php */
/* Location: ./application/modules/patient/controllers/patient.php */
