<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email extends MX_Controller {

    function __construct() {
        parent::__construct();

//    $this->load->model('email_model');
        $this->load->model('patient/patient_model');

        $this->load->model('donor/donor_model');
        $this->load->model('doctor/doctor_model');

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
    }

    public function index() {
        $data = array();
        $id = $this->ion_auth->get_user_id();
        $data['email'] = $this->email_model->getProfileById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('profile', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    public function sendView() {
        $data = array();
        $data['groups'] = $this->donor_model->getBloodBank();
        $data['patients'] = $this->patient_model->getPatient();
        $data['email'] = $this->email_model->getEmailSettings();
        $data['teams'] = $this->doctor_model->getDoctor();
        $type = 'email';
        $data['templates'] = $this->email_model->getManualEmailTemplate($type);
        $data['shortcode'] = $this->email_model->getManualEmailShortcodeTag($type);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('sendview', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    public function settings() {
        $data = array();
        $id = $this->ion_auth->get_user_id();
        $gateway_id = $this->input->get('id');
        $data['settings'] = $this->email_model->getEmailSettingsById($gateway_id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('settings', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    public function addNewSettings() {

        $id = $this->input->post('id');
        $email = $this->input->post('email');
        $type = $this->input->post('type');
        $password = $this->input->post('password');
        $user = $this->input->post('user');
        $email_company = $this->input->post('email_company');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
// Validating Name Field
        if ($type == 'Domain Email') {
            $this->form_validation->set_rules('email', 'Admin Email', 'trim|required|min_length[1]|max_length[100]|xss_clean');
// Validating Password Field
            $this->form_validation->set_rules('password', 'Password', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Email Field
            $this->form_validation->set_rules('api_id', 'Api Id', 'trim|min_length[1]|max_length[100]|xss_clean');
        }
        if ($type == 'Smtp') {
            $this->form_validation->set_rules('email_company', 'Email Company', 'trim|required|min_length[1]|max_length[100]|xss_clean');
// Validating Password Field
            $this->form_validation->set_rules('user', 'Email Address', 'trim|required|min_length[1]|max_length[100]|xss_clean');
// Validating Email Field
            $this->form_validation->set_rules('password', 'Email Password', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        }
        if ($this->form_validation->run() == FALSE) {
            redirect('email/settings?id=' . $id);
        } else {
            $extension = "";
            $smtp_host = '';
            $smtp_port = '';
            $send_multipart = "";

            if ($email_company == 'gmail') {
                $extension = $user . '@gmail.com';
                $smtp_host = 'smtp.gmail.com';
                $smtp_port = '587';
                $send_multipart = TRUE;
            }
            if ($email_company == 'yahoo') {
                $extension = $user . '@yahoo.com';
                $smtp_host = 'smtp.mail.yahoo.com';
                $smtp_port = '587';
                $send_multipart = TRUE;
            }
            /*  if ($emailcompany == 'outlook') {
              $extension = $user . '@outlook.com';
              $smtp_host = 'smtp.office365.com';
              $smtp_port = '587';
              $send_multipart = TRUE;
              }
              if ($emailcompany == 'hotmail') {
              $extension = $user . '@hotmail.com';
              $send_multipart = TRUE;
              } */
            if ($email_company == 'zoho') {
                $extension = $user . '@zohomail.com';
                $smtp_host = 'smtp.zoho.com';
                $smtp_port = '587';
                $send_multipart = TRUE;
            }
            $password = base64_encode($password);
            $data = array();
            $data = array(
                'admin_email' => $email,
                'user' => $extension,
                'smtp_host' => $smtp_host,
                'smtp_port' => $smtp_port,
                'send_multipart' => $send_multipart,
                'mail_provider' => $email_company,
                'password' => $password
            );

//  if (empty($this->email_model->getEmailSettings()->admin_email)) {
//      $this->email_model->addEmailSettings($data);
//      $this->session->set_flashdata('feedback', lang('added'));
//   } else {
            $this->email_model->updateEmailSettings($id, $data);
            $this->session->set_flashdata('feedback', lang('updated'));
//  }
            redirect('email/settings?id=' . $id);
        }
    }

    function send() {
        $userId = $this->ion_auth->get_user_id();
        $is_v_v = $this->input->post('radio');

        $settngsname = $this->settings_model->getSettings()->system_vendor;
        if ($is_v_v == 'allpatient') {
            $patients = $this->patient_model->getpatient();
            foreach ($patients as $patient) {
                $message = $this->input->post('message');
                $name = explode(' ', $patient->name);
                if (!isset($name[1])) {
                    $name[1] = null;
                }
                $data1 = array(
                    'firstname' => $name[0],
                    'lastname' => $name[1],
                    'name' => $patient->name,
                    'phone' => $patient->phone,
                    'email' => $patient->email,
                    'address' => $patient->address,
                    'company' => $settngsname
                );
                $messageprint = $this->parser->parse_string($message, $data1);
                $data2[] = array($patient->email => $messageprint);
                $to[] = $patient->email;
            }
            $recipient = 'All Patient';
        }

        if ($is_v_v == 'alldoctor') {
            $doctors = $this->doctor_model->getDoctor();
            foreach ($doctors as $doctor) {
                $message = $this->input->post('message');
                $name = explode(' ', $doctor->name);
                if (!isset($name[1])) {
                    $name[1] = null;
                }
                $data1 = array(
                    'firstname' => $name[0],
                    'lastname' => $name[1],
                    'name' => $doctor->name,
                    'phone' => $doctor->phone,
                    'email' => $doctor->email,
                    'address' => $doctor->address,
                    'company' => $settngsname,
                    'department' => $doctor->department
                );
                $messageprint = $this->parser->parse_string($message, $data1);
                $data2[] = array($doctor->email => $messageprint);
                $to[] = $doctor->email;
            }
            $recipient = 'All Doctor';
        }

        if ($is_v_v == 'bloodgroupwise') {
            $blood_group = $this->input->post('bloodgroup');
            $donors = $this->donor_model->getDonor();
            foreach ($donors as $donor) {
                if ($donor->group == $blood_group) {
                    $message = $this->input->post('message');
                    $name = explode(' ', $donor->name);
                    if (!isset($name[1])) {
                        $name[1] = null;
                    }
                    $data1 = array(
                        'firstname' => $name[0],
                        'lastname' => $name[1],
                        'name' => $donor->name,
                        'phone' => $donor->phone,
                        'email' => $donor->email,
                        'company' => $settngsname
                    );
                    $messageprint = $this->parser->parse_string($message, $data1);
                    $data2[] = array($donor->email => $messageprint);
                    $to[] = $donor->email;
                }
            }
            $recipient = 'All Blood Donors With Blood Group ' . $blood_group;
        }


        if ($is_v_v == 'single_patient') {
            $patient = $this->input->post('patient');

            $patient_detail = $this->patient_model->getPatientById($patient);
            $message = $this->input->post('message');
            $name = explode(' ', $patient_detail->name);
            if (!isset($name[1])) {
                $name[1] = null;
            }
            $data1 = array(
                'firstname' => $name[0],
                'lastname' => $name[1],
                'name' => $patient_detail->name,
                'phone' => $patient_detail->phone,
                'email' => $patient_detail->email,
                'address' => $patient_detail->address,
                'company' => $settngsname
            );
            $messageprint = $this->parser->parse_string($message, $data1);
            $data2[] = array($patient_detail->email => $messageprint);
            $single_patient_email = $patient_detail->email;
            $recipient = 'Patient Id: ' . $patient_detail->id . '<br> Patient Name: ' . $patient_detail->name . '<br> Patient Email: ' . $patient_detail->email;
        }


        if ($is_v_v == 'other') {
            $other_email = $this->input->post('other_email');
            $message = $this->input->post('message');
            $data2[] = array($other_email => $message);
            $recipient = $other_email;
        }

        if (!empty($single_patient_email)) {
            $to = $single_patient_email;
        } elseif (!empty($other_email)) {
            $to = $other_email;
        } else {
            if (!empty($to)) {
                $to = implode(',', $to);
            }
        }
// $message = urlencode("Test Message");
        if (!empty($to)) {
// $message = $this->input->post('message');
            $subject = $this->input->post('subject');

            $mail_provider = $this->settings_model->getSettings()->emailtype;
            $email_settings = $this->email_model->getEmailSettingsByType($mail_provider);

            foreach ($data2 as $key => $value) {
                foreach ($value as $key2 => $value2) {


                    if ($mail_provider == 'Domain Email') {
                        $this->email->from($email_settings->admin_email);
                    }
                    if ($mail_provider == 'Smtp') {
                        $this->email->from($email_settings->user, $settngsname);
                    }

                    $this->email->to($key2);
                    $this->email->subject($subject);
                    $this->email->message($value2);


                    $this->email->send();

                    $data = array();
                    $date = time();
                    $data = array(
                        'subject' => $subject,
                        'message' => $message,
                        'date' => $date,
                        'reciepient' => $recipient,
                        'user' => $this->ion_auth->get_user_id()
                    );
                    $this->email_model->insertEmail($data);
                }
            }
            $this->session->set_flashdata('feedback', lang('message_sent'));
        } else {
            $this->session->set_flashdata('feedback', lang('not_sent'));
        }
        redirect('email/sendView');
    }

    function appointmentReminder() {
        $id = $this->input->post('id');
        $appointment_details = $this->appointment_model->getAppointmentById($id);
        $emailSettings = $this->email_model->getEmailSettings();
        $username = $emailSettings->username;
        $password = $emailSettings->password;
        $api_id = $emailSettings->api_id;

        $patient_detail = $this->patient_model->getPatientById($appointment_details->patient);
        $doctor_detail = $this->doctor_model->getDoctorById($appointment_details->doctor);
        $recipient_p = 'Patient Id: ' . $patient_detail->id . '<br> Patient Name: ' . $patient_detail->name . '<br> Patient Email: ' . $patient_detail->email;
        $to = $patient_detail->email;

// $message = urlencode("Test Message");
        if (!empty($to)) {
            $message = 'Reminder: Appointment is scheduled for you With Doctor ' . $doctor_detail->name . ' Date: ' . date('d-m-Y', $appointment_details->date) . ' Time: ' . $appointment_details->s_time;
            $message1 = urlencode($message);
            file_get_contents('https://platform.clickatell.com/messages/http/send?apiKey=' . $api_id . '==&to=' . $to . '&content=' . $message1);           // file_get_contents('https://api.clickatell.com/http/sendmsg?user=' . $username . '&password=' . $password . '&api_id=' . $api_id . '&to=' . $to . '&text=' . $message1);
            $data_p = array();
            $date = time();
            $data_p = array(
                'message' => $message,
                'date' => $date,
                'recipient' => $recipient_p,
                'user' => $this->ion_auth->get_user_id()
            );
            $this->email_model->insertEmail($data_p);
            $this->session->set_flashdata('feedback', lang('message_sent'));
        }

        redirect('appointment/upcoming');
    }

    function sendEmailDuringAppointment($patient, $doctor, $date, $s_time, $e_time) {
        $emailSettings = $this->email_model->getEmailSettings();
        $username = $emailSettings->username;
        $password = $emailSettings->password;
        $api_id = $emailSettings->api_id;

        $patient_detail = $this->patient_model->getPatientById($patient);
        $doctor_detail = $this->doctor_model->getDoctorById($doctor);

        $recipient_p = 'Patient Id: ' . $patient_detail->id . '<br> Patient Name: ' . $patient_detail->name . '<br> Patient Email: ' . $patient_detail->email;
        $recipient_d = 'Doctor Id: ' . $doctor_detail->id . '<br> Patient Name: ' . $doctor_detail->name . '<br> Doctor Email: ' . $doctor_detail->email;


        $to = $patient_detail->email . ', ' . $doctor_detail->email;

// $message = urlencode("Test Message");
        if (!empty($patient)) {
            $message = 'Appointment is scheduled for you With Doctor ' . $doctor_detail->name . ' Date: ' . date('d-m-Y', $date) . ' Time: ' . $s_time;
            $message1 = urlencode($message);
            file_get_contents('https://platform.clickatell.com/messages/http/send?apiKey=' . $api_id . '==&to=' . $to . '&content=' . $message1);           // file_get_contents('https://api.clickatell.com/http/sendmsg?user=' . $username . '&password=' . $password . '&api_id=' . $api_id . '&to=' . $to . '&text=' . $message1);
            $data_p = array();
            $date = time();
            $data_p = array(
                'message' => $message,
                'date' => $date,
                'recipient' => $recipient_p,
                'user' => $this->ion_auth->get_user_id()
            );
            $this->email_model->insertEmail($data_p);
        }

        if (!empty($doctor)) {
            $message = 'Appointment is scheduled for you With Patient ' . $patient_detail->name . ' Date: ' . date('d-m-Y', $date) . ' Time: ' . $s_time;
            $message1 = urlencode($message);
            file_get_contents('https://platform.clickatell.com/messages/http/send?apiKey=' . $api_id . '==&to=' . $to . '&content=' . $message1);           // file_get_contents('https://api.clickatell.com/http/sendmsg?user=' . $username . '&password=' . $password . '&api_id=' . $api_id . '&to=' . $to . '&text=' . $message1);
            $data_d = array();
            $date = time();
            $data_d = array(
                'message' => $message,
                'date' => $date,
                'recipient' => $recipient_d,
                'user' => $this->ion_auth->get_user_id()
            );
            $this->email_model->insertEmail($data_d);
        }
    }

    function appointmentApproved() {
        $id = $this->input->post('id');
        $appointment_details = $this->appointment_model->getAppointmentById($id);
        $emailSettings = $this->email_model->getEmailSettings();
        $username = $emailSettings->username;
        $password = $emailSettings->password;
        $api_id = $emailSettings->api_id;

        $patient_detail = $this->patient_model->getPatientById($appointment_details->patient);
        $doctor_detail = $this->doctor_model->getDoctorById($appointment_details->doctor);
        $recipient_p = 'Patient Id: ' . $patient_detail->id . '<br> Patient Name: ' . $patient_detail->name . '<br> Patient Email: ' . $patient_detail->email;
        $to = $patient_detail->email;

// $message = urlencode("Test Message");
        if (!empty($to)) {
            $message = 'Approval: Appointment is scheduled for you With Doctor ' . $doctor_detail->name . ' Date: ' . date('d-m-Y', $appointment_details->date) . ' Time: ' . $appointment_details->s_time;
            $message1 = urlencode($message);
            file_get_contents('https://platform.clickatell.com/messages/http/send?apiKey=' . $api_id . '==&to=' . $to . '&content=' . $message1);
            $data_p = array();
            $date = time();
            $data_p = array(
                'message' => $message,
                'date' => $date,
                'recipient' => $recipient_p,
                'user' => $this->ion_auth->get_user_id()
            );
            $this->email_model->insertEmail($data_p);
        }
    }

    function sendEmailDuringPayment($patient, $amount, $date) {
        $emailSettings = $this->email_model->getEmailSettings();
        $username = $emailSettings->username;
        $password = $emailSettings->password;
        $api_id = $emailSettings->api_id;

        $patient_detail = $this->patient_model->getPatientById($patient);

        $recipient_p = 'Patient Id: ' . $patient_detail->id . '<br> Patient Name: ' . $patient_detail->name . '<br> Patient Email: ' . $patient_detail->email;

// $message = urlencode("Test Message");
        if (!empty($patient)) {
            $to = $patient_detail->email;
            $message = 'Bill For Patient ' . $patient_detail->name . 'Amount: ' . $amount . ' Date: ' . date('d-m-Y', $date);
            $message1 = urlencode($message);
            file_get_contents('https://platform.clickatell.com/messages/http/send?apiKey=' . $api_id . '==&to=' . $to . '&content=' . $message1);           // file_get_contents('http://bhashemail.com/api/sendmsg.php?user=' . $username . '&pass=' . $password . '&sender=SKESWA&email=' . $to . '&text=' . $message1 . '&priority=ndnd&stype=normal');
            $data_p = array();
            $date = time();
            $data_p = array(
                'message' => $message,
                'date' => $date,
                'recipient' => $recipient_p,
                'user' => $this->ion_auth->get_user_id()
            );
            $this->email_model->insertEmail($data_p);
        }
    }

    function sendEmailDuringPatientRegistration($patient) {
        $emailSettings = $this->email_model->getEmailSettings();
        $username = $emailSettings->username;
        $password = $emailSettings->password;
        $api_id = $emailSettings->api_id;

        $patient_detail = $this->patient_model->getPatientById($patient);

        $recipient_p = 'Patient Id: ' . $patient_detail->id . '<br> Patient Name: ' . $patient_detail->name . '<br> Patient Email: ' . $patient_detail->email;

// $message = urlencode("Test Message");
        if (!empty($patient)) {
            $to = $patient_detail->email;
            $message = 'Patient Registration' . $patient_detail->name . 'is successfully registerred';
            $message1 = urlencode($message);
            file_get_contents('https://platform.clickatell.com/messages/http/send?apiKey=' . $api_id . '==&to=' . $to . '&content=' . $message1);           // file_get_contents('https://api.clickatell.com/http/sendmsg?user=' . $username . '&password=' . $password . '&api_id=' . $api_id . '&to=' . $to . '&text=' . $message1);
            $data_p = array();
            $date = time();
            $data_p = array(
                'message' => $message,
                'date' => $date,
                'recipient' => $recipient_p,
                'user' => $this->ion_auth->get_user_id()
            );
            $this->email_model->insertEmail($data_p);
        }
    }

    function sent() {
        if ($this->ion_auth->in_group(array('admin'))) {
            $data['sents'] = $this->email_model->getEmail();
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $data['sents'] = $this->email_model->getEmailByUser($current_user_id);
        }
        $permis = '';
        $permis_2 = '';
        foreach ($this->permission_access_group_explode as $perm) {
            $perm_explode = array();
            $perm_explode = explode(",", $perm);
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Email') {
                $permis = 'ok';
                //  break;
            }
        }
        $data['permis'] = $permis;
        $this->load->view('home/dashboard');
        $this->load->view('email', $data);
        $this->load->view('home/footer');
    }

    function delete() {
        $id = $this->input->get('id');
        $this->email_model->delete($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('email/sent');
    }

    public function autoEmailTemplate() {
        $data['settings'] = $this->settings_model->getSettings();
        $data['shortcode'] = $this->email_model->getAutoEmailTemplate();
        $this->load->view('home/dashboard', $data);
        $this->load->view('autoemailtemplate', $data);
        $this->load->view('home/footer', $data);
    }

    function getAutoEmailTemplateList() {
        $type = $this->input->post('type');
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->email_model->getAutoEmailTemplateBySearch($search);
            } else {
                $data['cases'] = $this->email_model->getAutoEmailTemplate();
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->email_model->getAutoEmailTemplateByLimitBySearch($limit, $start, $search);
            } else {
                $data['cases'] = $this->email_model->getAutoEmailTemplateByLimit($limit, $start);
            }
        }
//  $data['patients'] = $this->patient_model->getVisitor();
        $i = 0;
        $count = 0;
        $options1 = '';
        $permis = '';
        $permis_1 = '';
        foreach ($this->permission_access_group_explode as $perm) {
            $perm_explode = array();
            $perm_explode = explode(",", $perm);
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Email') {
                $permis = 'ok';
                //  break;
            }
        }
        foreach ($data['cases'] as $case) {
            $i = $i + 1;
            if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok') {

                $options1 = ' <a type="button" class="btn btn-success btn-xs btn_width editbutton1" title="' . lang('edit') . '" data-toggle = "modal" data-id="' . $case->id . '"><i class="fa fa-edit"> </i></a>';
// $options1 = '<a type='button" class="btn btn-success btn-xs btn_width" title="" . lang('edit') . '"data-toggle = "modal" data-id="' . $case->id . '"><i class="fa fa-edit"></i></a>';
//    $options2 = '<a class="btn btn-danger btn-xs btn_width" title="' . lang('delete') . '" href="sms/deleteTemplate?id=' . $case->id . '&redirect=sms/smsTemplate" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash-o"></i></a>';
            }
            $info[] = array(
                $i,
                $case->name,
                $case->message,
                $case->status,
                $options1
            );
            $count = $count + 1;
        }

        if (!empty($data['cases'])) {
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

    public function editAutoEmailTemplate() {
        $id = $this->input->get('id');
        $data['autotemplatename'] = $this->email_model->getAutoEmailTemplateById($id);
        $data['autotag'] = $this->email_model->getAutoEmailTemplateTag($data['autotemplatename']->type);
        if ($data['autotemplatename']->status == 'Active') {
            $data['status_options'] = '<option value="Active" selected>' . lang("active") . '
                            </option>
                            <option value="Inactive"> ' . lang("inactive") . '
        </option>';
        } else {
            $data['status_options'] = '<option value="Active">' . lang("active") . '
                            </option>
                            <option value="Inactive" selected> ' . lang("inactive") . '
        </option>';
        }
        echo json_encode($data);
    }

    public function addNewAutoEmailTemplate() {
        $message = $this->input->post('message');
        $name = $this->input->post('category');
        $id = $this->input->post('id');
        $status = $this->input->post('status');

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('message', 'Message', 'trim|xss_clean|required');
        if ($this->form_validation->run() == FALSE) {

            $data['settings'] = $this->settings_model->getSettings();
            $data['shortcode'] = $this->email_model->getTag();
            $this->load->view('home/dashboard', $data);
            $this->load->view('autoemailtemplate', $data);
            $this->load->view('home/footer', $data);
        } else {
            $data = array();
            $data = array(
                'name' => $name,
                'message' => $message,
                'status' => $status,
            );

            $this->email_model->updateAutoEmailTemplate($data, $id);
            $this->session->set_flashdata('feedback', lang('updated'));

            redirect('email/autoEmailTemplate');
        }
    }

    public function addNewManualTemplate() {
        $message = $this->input->post('message');
        $name = $this->input->post('name');
        $type = $this->input->post('type');
        $id = $this->input->post('id');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
// Validating 
        $this->form_validation->set_rules('message', 'Message', 'trim|xss_clean|required');

// Validating 
        $this->form_validation->set_rules('name', 'Name', 'trim|xss_clean|required');
        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $data = array();
                $data['settings'] = $this->settings_model->getSettings();
                $data['templatename'] = $this->email_model->getManualEmailTemplateById($id, $type);
                $data['shortcode'] = $this->email_model->getManualEmailShortcodeTag($type);
                $this->load->view('home/dashboard', $data); // just the header file
                $this->load->view('add_manual_template', $data);
                $this->load->view('home/footer', $data); // just the footer file
            } else {
                $data = array();
                $data['setval'] = 'setval';
                $data['settings'] = $this->settings_model->getSettings();
                $data['shortcode'] = $this->email_model->getManualEmailShortcodeTag($type);
                $this->load->view('home/dashboard', $data); // just the header file
                $this->load->view('add_manual_template', $data);
                $this->load->view('home/footer', $data); // just the footer file
            }
        } else {
            $data = array();
            $data = array(
                'name' => $name,
                'message' => $message,
                'type' => $type
            );
            if (empty($id)) {
                $this->email_model->addManualEmailTemplate($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->email_model->updateManualEmailTemplate($data, $id);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('email/sendView');
        }
    }

    public function manualEmailTemplate() {
        $data['settings'] = $this->settings_model->getSettings();
        $type = 'email';
        $data['shortcode'] = $this->email_model->getManualEmailShortcodeTag($type);
        $this->load->view('home/dashboard', $data);
        $this->load->view('manual_email_template', $data);
        $this->load->view('home/footer', $data);
    }

    function getManualEmailTemplateList() {
        $type = $this->input->post('type');
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->email_model->getManualEmailTemplateBySearch($search, $type);
            } else {
                $data['cases'] = $this->email_model->getManualEmailTemplate($type);
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->email_model->getManualEmailTemplateByLimitBySearch($limit, $start, $search, $type);
            } else {
                $data['cases'] = $this->email_model->getManualEmailTemplateByLimit($limit, $start, $type);
            }
        }
//  $data['patients'] = $this->patient_model->getVisitor();
        $i = 0;
        $count = 0;
        $permis = '';
        $permis_1 = '';
        foreach ($this->permission_access_group_explode as $perm) {
            $perm_explode = array();
            $perm_explode = explode(",", $perm);
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Email') {
                $permis = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Email') {
                $permis_1 = 'ok';
                //  break;
            }
        }
        foreach ($data['cases'] as $case) {
            $options1='';
            $options2='';
            $i = $i + 1;
            if ($this->ion_auth->in_group(array('admin')) || $permis = 'ok' || $permis_1 = 'ok') {
               if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok') {
                    $options1 = ' <a type="button" class="btn btn-success btn-xs btn_width editbutton1" title="' . lang('edit') . '" data-toggle = "modal" data-id="' . $case->id . '"><i class="fa fa-edit"> </i></a>';
                } if ($this->ion_auth->in_group(array('admin')) || $permis_1 == 'ok') {
// $options1 = '<a type='button" class="btn btn-success btn-xs btn_width" title="" . lang('edit') . '"data-toggle = "modal" data-id="' . $case->id . '"><i class="fa fa-edit"></i></a>';
                    $options2 = '<a class="btn btn-danger btn-xs btn_width" title="' . lang('delete') . '" href="email/deleteManualEmailTemplate?id=' . $case->id . '&redirect=sms/smsTemplate" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"></i></a>';
                }
            }
            $info[] = array(
                $i,
                $case->name,
                ' ' . $options1 . ' ' . $options2
            );
            $count = $count + 1;
        }

        if (!empty($data['cases'])) {
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

    public function deleteManualEmailTemplate() {
        $id = $this->input->get('id');
        $this->email_model->deleteManualEmailTemplate($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('email/manualEmailTemplate');
    }

    public function editManualEmailTemplate() {
        $id = $this->input->get('id');
        $type = $this->input->get('type');

        $data['templatename'] = $this->email_model->getManualEmailTemplateById($id, $type);

        echo json_encode($data);
    }

    public function getManualEmailTemplateinfo() {
// Search term
        $searchTerm = $this->input->post('searchTerm');
        $type = 'email';
// Get users
        $response = $this->email_model->getManualEmailTemplateListSelect2($searchTerm, $type);

        echo json_encode($response);
    }

    public function getManualEmailTemplateMessageboxText() {
        $id = $this->input->get('id');
        $type = $this->input->get('type');
        $data['user'] = $this->email_model->getManualEmailTemplateById($id, $type);
        echo json_encode($data);
    }

    /*  public function sendSmtp() {


      $htmlContent = '<h1>Sending email via Gmail SMTP server</h1>';
      $htmlContent .= '<p>This email has sent via Gmail SMTP server from CodeIgniter application.</p>';

      $this->smtpCredentials1();

      $this->load->library('email');
      $this->email->to('sahashaibal22@gmail.com');
      $this->email->from('sahashaiibal2011@zoho.com', 'dfggdf');
      $this->email->subject('How to send email via Gmail SMTP server in CodeIgniter');
      $this->email->message($htmlContent);

      //Send email
      $this->email->send();
      echo $this->email->print_debugger();
      }

      public function smtpCredentials1() {

      $config['protocol'] = 'smtp';
      $config['mailpath'] = '/usr/sbin/sendmail';
      $config['smtp_host'] = 'smtp.zoho.com';
      $config['smtp_port'] = 587;
      $config['smtp_user'] = 'sahashaiibal2011@zoho.com';
      $config['smtp_pass'] = 'Ohmygod11';
      $config['smtp_crypto'] = 'tls';
      $config['mailtype'] = 'html';
      $config['charset'] = 'utf-8';
      $config['wordwrap'] = TRUE;
      $config['$send_multipart'] = FALSE;
      $config['newline'] = "\r\n";
      $this->email->initialize($config);
      }
     */
    /*  public function smtpCredentials($type) {

      $emailSettings = $this->email_model->getEmailSettingsByType($type);
      $config['protocol'] = 'smtp';
      $config['mailpath'] = '/usr/sbin/sendmail';
      $config['smtp_host'] = $emailSettings->smtp_host;
      $config['smtp_port'] = number_format($emailSettings->smtp_port);
      $config['smtp_user'] = $emailSettings->user;
      $config['smtp_pass'] = base64_decode($emailSettings->password);
      $config['smtp_crypto'] = 'tls';
      $config['mailtype'] = 'html';
      $config['charset'] = 'utf-8';
      $config['wordwrap'] = TRUE;
      $config['$send_multipart'] = FALSE;
      $config['newline'] = "\r\n";
      //   $this->load->library('email');
      $this->email->initialize($config);
      }
     */

    public function emailSettings() {
        $data['email'] = $this->email_model->getEmailSettings();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('email_settings', $data);
        $this->load->view('home/footer'); // just the footer file
    }

}

/* End of file profile.php */
/* Location: ./application/modules/profile/controllers/profile.php */
