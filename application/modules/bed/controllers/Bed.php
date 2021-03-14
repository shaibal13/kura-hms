<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bed extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('bed_model');
        $this->load->model('patient/patient_model');
        $this->load->model('doctor/doctor_model');
        $this->load->model('nurse/nurse_model');
        $this->load->model('medicine/medicine_model');
        $this->load->model('pservice/pservice_model');
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
        if ($this->ion_auth->in_group(array('pharmacist', 'Receptionist', 'Laboratorist', 'Patient'))) {
            redirect('home/permission');
        }
    }

    public function index() {
        if (!$this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Accountant')) && !in_array('Bed', $this->pers)) {
            redirect('home/permission');
        }
        $data['beds'] = $this->bed_model->getBed();
        $data['categories'] = $this->bed_model->getBedCategory();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('bed', $data);
        $this->load->view('home/footer'); // just the header file  
    }

    public function addBedView() {
        $data = array();
        $data['categories'] = $this->bed_model->getBedCategory();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_bed_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addBed() {
        $id = $this->input->post('id');
        $number = $this->input->post('number');
        $description = $this->input->post('description');
        $status = $this->input->post('status');
        $category = $this->input->post('category');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Category Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Price Field
        $this->form_validation->set_rules('number', 'Bed Number', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Generic Name Field
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Company Name Field

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $data = array();
                $data['categories'] = $this->bed_model->getBedCategory();
                $data['bed'] = $this->bed_model->getBedById($id);
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_bed_view', $data);
                $this->load->view('home/footer'); // just the footer file
            } else {
                $data = array();
                $data['setval'] = 'setval';
                $data['categories'] = $this->bed_model->getBedCategory();
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_bed_view', $data);
                $this->load->view('home/footer'); // just the header file
            }
        } else {
            $bed_id = implode('-', array($category, $number));
            $data = array();
            $data = array(
                'category' => $category,
                'number' => $number,
                'description' => $description,
                'bed_id' => $bed_id
            );
            if (empty($id)) {
                $this->bed_model->insertBed($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->bed_model->updateBed($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('bed');
        }
    }

    function editBed() {
        $data = array();
        $data['categories'] = $this->bed_model->getBedCategory();
        $id = $this->input->get('id');
        $data['bed'] = $this->bed_model->getBedById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_bed_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editBedByJason() {
        $id = $this->input->get('id');
        $data['bed'] = $this->bed_model->getBedById($id);
        echo json_encode($data);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->bed_model->deleteBed($id);
        redirect('bed');
    }

    public function bedCategory() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Accountant')) && !in_array('Bed', $this->pers)) {
            redirect('home/permission');
        }
        $data['categories'] = $this->bed_model->getBedCategory();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('bed_category', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addCategoryView() {

        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_category_view');
        $this->load->view('home/footer'); // just the header file
    }

    public function addCategory() {
        $id = $this->input->post('id');
        $category = $this->input->post('category');
        $description = $this->input->post('description');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Category Name Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Description Field
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $data = array();
                $data['bed'] = $this->bed_model->getBedCategoryById($id);
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_category_view', $data);
                $this->load->view('home/footer'); // just the footer file
            } else {
                $data = array();
                $data['setval'] = 'setval';
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_category_view', $data);
                $this->load->view('home/footer'); // just the header file
            }
        } else {
            $data = array();
            $data = array('category' => $category,
                'description' => $description
            );
            if (empty($id)) {
                $this->bed_model->insertBedCategory($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->bed_model->updateBedCategory($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('bed/bedCategory');
        }
    }

    function editCategory() {
        $data = array();
        $id = $this->input->get('id');
        $data['bed'] = $this->bed_model->getBedCategoryById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_category_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editBedCategoryByJason() {
        $id = $this->input->get('id');
        $data['bedcategory'] = $this->bed_model->getBedCategoryById($id);
        echo json_encode($data);
    }

    function deleteBedCategory() {
        $id = $this->input->get('id');
        $this->bed_model->deleteBedCategory($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('bed/bedCategory');
    }

    function bedAllotment() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Accountant')) && !in_array('Bed', $this->pers)) {
            redirect('home/permission');
        }
        $data['blood_group'] = $this->bed_model->getBloodGroup();

        $data['room_no'] = $this->bed_model->getBedCategory();
        $data['patients'] = $this->patient_model->getPatient();
        $data['alloted_beds'] = $this->bed_model->getAllotment();

        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('bed_allotment', $data);
        $this->load->view('home/footer'); // just 
    }

    function addAllotmentView() {
        $data = array();
        $data['blood_group'] = $this->bed_model->getBloodGroup();

        $data['room_no'] = $this->bed_model->getBedCategory();
        $data['patients'] = $this->patient_model->getPatient();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_allotment_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function addAllotment() {
        $id = $this->input->post('id');
        $category_status = $this->input->post('category_status');

        $category_status_update = implode(',', $category_status);

        $covid_19 = $this->input->post('covid_19');
        $reaksione = $this->input->post('reaksione');
        $transferred_from = $this->input->post('transferred_from');
        $diagnoza_a_shtrimit = $this->input->post('diagnoza_a_shtrimit');
        $doctor = $this->input->post('doctor');
        $diagnosis = $this->input->post('diagnosis');
        $other_illnesses = $this->input->post('other_illnesses');
        $anamneza = $this->input->post('anamneza');
        $blood_group = $this->input->post('blood_group');
        $accepting_doctor = $this->input->post('accepting_doctor');
        $category = $this->input->post('category');
        $patient = $this->input->post('patient');
        $a_time = $this->input->post('a_time');
        $a_time_array = array();
        $a_time_array = explode("-", $a_time);
        $a_timestamp = strtotime($a_time_array[0] . ' ' . $a_time_array[1]);

        //$d_time = $this->input->post('d_time');
        // $status = $this->input->post('status');
        $bed_id = $this->input->post('bed_id');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Category Field
        $this->form_validation->set_rules('bed_id', 'Bed', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Patient Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Alloted Time Field
        $this->form_validation->set_rules('a_time', 'Alloted Time', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Discharge Time Field
        // $this->form_validation->set_rules('d_time', 'Discharge Time', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Status Field
        //$this->form_validation->set_rules('status', 'Status', 'trim|min_length[1]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $data = array();
            $data['blood_group'] = $this->bed_model->getBloodGroup();

            $data['room_no'] = $this->bed_model->getBedCategory();
            $data['patients'] = $this->patient_model->getPatient();
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('add_allotment_view', $data);
            $this->load->view('home/footer'); // just the header file
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
                'anamneza' => $anamneza,
                'accepting_doctor' => $accepting_doctor,
                'doctor' => $doctor,
                'diagnosis' => $diagnosis,
                'diagnoza_a_shtrimit' => $diagnoza_a_shtrimit,
                'blood_group' => $blood_group,
                'other_illnesses' => $other_illnesses,
                // 'd_time' => $d_time,
                // 'status' => $status,
                'patientname' => $patientname,
                'a_timestamp' => $a_timestamp
            );
            $data1 = array(
                'last_a_time' => $a_time,
                    // 'last_d_time' => $d_time,
            );

            if (empty($id)) {
                $this->bed_model->insertAllotment($data);
                $this->bed_model->updateBedByBedId($bed_id, $data1);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->bed_model->updateAllotment($id, $data);
                $this->bed_model->updateBedByBedId($bed_id, $data1);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('bed/bedAllotment');
        }
    }

    function editAllotment() {
        $data = array();
        $data['beds'] = $this->bed_model->getBed();
        $data['patients'] = $this->patient_model->getPatient();
        $id = $this->input->get('id');
        $data['allotment'] = $this->bed_model->getAllotmentById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_allotment_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editAllotmentByJason() {
        $id = $this->input->get('id');
        $data['allotment'] = $this->bed_model->getAllotmentById($id);
        $data['patient'] = $this->patient_model->getPatientById($data['allotment']->patient);
        echo json_encode($data);
    }

    function deleteAllotment() {
        $id = $this->input->get('id');
        $this->bed_model->deleteBedAllotment($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('bed/bedAllotment');
    }

    function getBedList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        $order = $this->input->post("order");
        $columns_valid = array(
            "0" => "bed_id",
            "1" => "description",
            "2" => "status",
        );
        $values = $this->settings_model->getColumnOrder($order, $columns_valid);
        $dir = $values[0];
        $order = $values[1];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['beds'] = $this->bed_model->getBedBysearch($search, $order, $dir);
            } else {
                $data['beds'] = $this->bed_model->getBedWithoutSearch($order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['beds'] = $this->bed_model->getBedByLimitBySearch($limit, $start, $search, $order, $dir);
            } else {
                $data['beds'] = $this->bed_model->getBedByLimit($limit, $start, $order, $dir);
            }
        }


        //  $data['patients'] = $this->patient_model->getVisitor();
        $i = 0;
        $permis = '';
        $permis_1 = '';
        foreach ($this->permission_access_group_explode as $perm) {
            $perm_explode = array();
            $permis='';
            $permis_1='';
            $perm_explode = explode(",", $perm);
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Bed') {
                $permis = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Bed') {
                $permis_1 = 'ok';
                //  break;
            }
        }
        foreach ($data['beds'] as $bed) {
            $i = $i + 1;
             $option1=''; $option2='';
            if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Accountant')) || $permis == 'ok') {
                $option1 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $bed->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</button>';
            }
            if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Accountant')) || $permis_1 == 'ok') {
                $option2 = '<a class="btn btn-info btn-xs btn_width delete_button" href="bed/delete?id=' . $bed->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i> ' . lang('delete') . '</a>';
            }
            $last_a_time = explode('-', $bed->last_a_time);
            $last_d_time = explode('-', $bed->last_d_time);
            if (!empty($last_d_time[1])) {
                $last_d_h_am_pm = explode(' ', $last_d_time[1]);
                $last_d_h = explode(':', $last_d_h_am_pm[1]);
                if ($last_d_h_am_pm[2] == 'AM') {
                    $last_d_m = ($last_d_h[0] * 60 * 60) + ($last_d_h[1] * 60);
                } else {
                    $last_d_m = (12 * 60 * 60) + ($last_d_h[0] * 60 * 60) + ($last_d_h[1] * 60);
                }
                $last_d_time = strtotime($last_d_time[0]) + $last_d_m;
            }
            if (!empty($bed->last_a_time)) {
                if (empty($bed->last_d_time)) {
                    $bedstatus = '<button type="button" class="btn btn-primary">' . lang('alloted') . '</button>';
                } elseif ((time() > $last_d_time)) {
                    $bedstatus = '<button type="button" class="btn btn-success">' . lang('available') . '</button>';
                } elseif ((time() < $last_d_time)) {
                    $bedstatus = '<button type="button" class="btn btn-primary">' . lang('alloted') . '</button>';
                }
            } else {
                $bedstatus = '<button type="button" class="btn btn-success">' . lang('available') . '</button>';
            }


            $info[] = array(
                $bed->bed_id,
                $bed->description,
                $bedstatus,
                $option1 . ' ' . $option2
            );
        }

        if (!empty($data['beds'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('bed')->num_rows(),
                "recordsFiltered" => $this->db->get('bed')->num_rows(),
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

    function getBedAllotmentList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        $order = $this->input->post("order");
        $columns_valid = array(
            "0" => "id",
            "2" => "a_time",
            "3" => "d_time",
        );
        $values = $this->settings_model->getColumnOrder($order, $columns_valid);
        $dir = $values[0];
        $order = $values[1];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['beds'] = $this->bed_model->getBedAllotmentBysearch($search, $order, $dir);
            } else {
                $data['beds'] = $this->bed_model->getAllotmentWithoutSearch($order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['beds'] = $this->bed_model->getBedAllotmentByLimitBySearch($limit, $start, $search, $order, $dir);
            } else {
                $data['beds'] = $this->bed_model->getBedAllotmentByLimit($limit, $start, $order, $dir);
            }
        }


        //  $data['patients'] = $this->patient_model->getVisitor();
        $i = 0;
        foreach ($this->permission_access_group_explode as $perm) {
            $perm_explode = array();
            $permis='';
            $permis_1='';
            $perm_explode = explode(",", $perm);
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Bed') {
                $permis = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Bed') {
                $permis_1 = 'ok';
                //  break;
            }
        }
        foreach ($data['beds'] as $bed) {
            $i = $i + 1;
            $option1=''; $option2='';
            if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Accountant')) || $permis == 'ok') {
                $option1 = '<a class="btn btn-info btn-xs btn_width editbutton" href="bed/bedAllotmentDetails?id=' . $bed->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</a>';
            }
            if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Accountant')) || $permis_1 == 'ok') {
                $option2 = '<a class="btn btn-info btn-xs btn_width delete_button" href="bed/deleteAllotment?id=' . $bed->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i> ' . lang('delete') . '</a>';
            }
            $patientdetails = $this->patient_model->getPatientById($bed->patient);
            if (!empty($patientdetails)) {
                $patientname = $patientdetails->name;
            } else {
                $patientname = $bed->patientname;
            }

            $info[] = array(
                $bed->bed_id,
                $patientname,
                $bed->a_time,
                $bed->d_time,
                $option1 . ' ' . $option2
            );
        }

        if (!empty($data['beds'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('alloted_bed')->num_rows(),
                "recordsFiltered" => $this->db->get('alloted_bed')->num_rows(),
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

    function getNotAvailableBed() {
        $date = $this->input->get('date');
        $dateexplode = explode('-', $date);
        $timesttamp = strtotime($dateexplode[0] . ' ' . $dateexplode[1]);
        $category = $this->input->get('category');
        $data = array();
        $data['bedlist'] = $this->bed_model->getNotBedAvailableList($timesttamp, $category);
        $data['date'] = $timesttamp;
        echo json_encode($data);
    }

    function getNotAvailableBedFromEdit() {
        $date = $this->input->get('date');
        $dateexplode = explode('-', $date);
        $timesttamp = strtotime($dateexplode[0] . ' ' . $dateexplode[1]);
        $category = $this->input->get('category');
        $id = $this->input->get('id');
        $data = array();
        $data['bedlist'] = $this->bed_model->getNotBedAvailableListFromEdit($timesttamp, $category, $id);
        $data['date'] = $timesttamp;
        echo json_encode($data);
    }

    function getBedByRoomNo() {
        $id = $this->input->get('id');
        $alloted_time = $this->input->get('alloted_time');
        // echo $alloted_time;
        $alloted_time_array = array();
        $alloted_time_array = explode("-", $alloted_time);
        $alloted_timestamp = strtotime($alloted_time_array[0] . ' ' . $alloted_time_array[1]);
        $beds = $this->bed_model->getBedByCategory($id);
        $option = '';
        $option = '<option  value="select">' . lang('select') . '</option>';
        foreach ($beds as $bed) {
            $alloted_bed = array();
            $alloted_bed = $this->bed_model->getAllotedBedByBedIdByDate($bed->id, $alloted_timestamp);

            if (empty($alloted_bed)) {

                $option .= '<option value="' . $bed->id . '">' . $bed->number . '</option>';
            } else {
                foreach ($alloted_bed as $al_bed) {
                    if ($al_bed->d_timestamp >= $alloted_timestamp || empty($al_bed->d_timestamp)) {
                        $option1 = "1";
                    } else {

                        $option .= '<option value="' . $bed->id . '">' . $bed->number . '</option>';
                    }
                }
            }
        }
        $data['response'] = $option;
        echo json_encode($data);
    }

    function bedAllotmentDetails() {
        $id = $this->input->get('id');
        $data = array();
        $data['settings'] = $this->settings_model->getSettings();
        $data['allotment'] = $this->bed_model->getBedAllotmentsById($id);
        $data['bed_id'] = $this->bed_model->getBedByCategory($data['allotment']->category);
        $data['patient'] = $this->patient_model->getPatientById($data['allotment']->patient);
        $data['pservice'] = $this->pservice_model->getPserviceByActive();
        $data['doctor'] = $this->doctor_model->getDoctorById($data['allotment']->doctor);
        $data['daily_progress'] = $this->bed_model->getDailyProgressByBedId($id);
        $data['daily_medicine'] = $this->bed_model->getMedicineAllotedByBedId($id);
        $data['daily_service'] = $this->bed_model->getServiceAllotedByBedId($id);
        $data['bed_checkout'] = $this->bed_model->getCheckoutByBedId($id);
        $date_exist = $this->bed_model->getServicesByDate(date('d-m-Y', time()));
        if (!empty($date_exist)) {
            $data['checked'] = explode("**", $date_exist->service);
        } else {
            $data['checked'] = array();
        }

        $data['accepting_doctor'] = $this->doctor_model->getDoctorById($data['allotment']->accepting_doctor);
        foreach ($data['bed_id'] as $bed) {
            if ($bed->id == $data['allotment']->bed_id) {
                $option .= '<option value="' . $bed->id . '" selected>' . $bed->number . '</option>';
            } else {
                $option .= '<option value="' . $bed->id . '">' . $bed->number . '</option>';
            }
        }
        $data['option'] = $option;
        $data['blood_group'] = $this->bed_model->getBloodGroup();

        $data['room_no'] = $this->bed_model->getBedCategory();
        $this->load->view('home/dashboard', $data);
        $this->load->view('edit_allotment_bed', $data);
        $this->load->view('home/footer', $data);
    }

    function updateCheckin() {
        $id = $this->input->post('id');
        $category_status = $this->input->post('category_status');

        $category_status_update = implode(',', $category_status);

        $covid_19 = $this->input->post('covid_19');
        $reaksione = $this->input->post('reaksione');
        $transferred_from = $this->input->post('transferred_from');
        $diagnoza_a_shtrimit = $this->input->post('diagnoza_a_shtrimit');
        $doctor = $this->input->post('doctor');
        $diagnosis = $this->input->post('diagnosis');
        $other_illnesses = $this->input->post('other_illnesses');
        $anamneza = $this->input->post('anamneza');
        $blood_group = $this->input->post('blood_group');
        $accepting_doctor = $this->input->post('accepting_doctor');
        $category = $this->input->post('category');
        $patient = $this->input->post('patient');
        $a_time = $this->input->post('a_time');
        //$d_time = $this->input->post('d_time');
        // $status = $this->input->post('status');
        $bed_id = $this->input->post('bed_id');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Category Field
        $this->form_validation->set_rules('bed_id', 'Bed', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Patient Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Alloted Time Field
        $this->form_validation->set_rules('a_time', 'Alloted Time', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Discharge Time Field
        // $this->form_validation->set_rules('d_time', 'Discharge Time', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Status Field
        //$this->form_validation->set_rules('status', 'Status', 'trim|min_length[1]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $data = array();
            $data['blood_group'] = $this->bed_model->getBloodGroup();

            $data['room_no'] = $this->bed_model->getBedCategory();
            $data['patients'] = $this->patient_model->getPatient();
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('add_allotment_view', $data);
            $this->load->view('home/footer'); // just the header file
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
                'anamneza' => $anamneza,
                'accepting_doctor' => $accepting_doctor,
                'doctor' => $doctor,
                'diagnosis' => $diagnosis,
                'diagnoza_a_shtrimit' => $diagnoza_a_shtrimit,
                'blood_group' => $blood_group,
                'other_illnesses' => $other_illnesses,
                // 'd_time' => $d_time,
                // 'status' => $status,
                'patientname' => $patientname
            );
            $data1 = array(
                'last_a_time' => $a_time,
                    // 'last_d_time' => $d_time,
            );

            if (empty($id)) {
                $this->bed_model->insertAllotment($data);
                $this->bed_model->updateBedByBedId($bed_id, $data1);
                //  $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->bed_model->updateAllotment($id, $data);
                $this->bed_model->updateBedByBedId($bed_id, $data1);

                $arr = array('message' => lang('updated'), 'title' => lang('updated'));
                echo json_encode($arr);
            }
        }
    }

    function updateDailyProgress() {
        $id = $this->input->post('daily_progress_id');
        $date = $this->input->post('date');
        $time = $this->input->post('time');
        $description = $this->input->post('description');
        $daily_description = $this->input->post('daily_description');
        $nurse = $this->input->post('nurse');
        $alloted_bed_id = $this->input->post('alloted_bed_id');


        //  $this->load->library('form_validation');
        //   $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Category Field
        //  $this->form_validation->set_rules('date', 'Date', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        //  // Validating Patient Field
        //  $this->form_validation->set_rules('time', 'Time', 'trim|required|min_length[1]|max_length[100]|xss_clean');


        $data = array();
        //  $patientname = $this->patient_model->getPatientById($patient)->name;
        $data = array(
            'date' => $date,
            'datestamp' => strtotime($date),
            'time' => $time,
            'alloted_bed_id' => $alloted_bed_id,
            'description' => $description,
            'daily_description' => $daily_description,
            'nurse' => $nurse,
        );


        if (empty($id)) {

            $this->bed_model->insertDailyProgress($data);
            $insert_id = $this->db->insert_id();
            //  $inserted_id=$this->db->inserted_id('daily_progress');
            $arr['info'] = $this->bed_model->getDailyProgressById($insert_id);
            $arr['nurse'] = $this->nurse_model->getNurseById($arr['info']->nurse);
            $arr['message'] = array('message' => lang('added'), 'title' => lang('added'));
            $arr['added'] = array('redir' => 'added');
            echo json_encode($arr);
        } else {
            $this->bed_model->updateDailyProgress($id, $data);
            //$this->bed_model->updateBedByBedId($bed_id, $data1);
            $arr['info'] = $this->bed_model->getDailyProgressById($id);
            $arr['nurse'] = $this->nurse_model->getNurseById($arr['info']->nurse);
            $arr['message'] = array('message' => lang('updated'), 'title' => lang('updated'));
            $arr['added'] = array('redir' => 'updated');
            echo json_encode($arr);
        }
    }

    function getDailyProgress() {
        $id = $this->input->get('id');
        $data = array();
        $data['info'] = $this->bed_model->getDailyProgressById($id);
        $data['nurse'] = $this->nurse_model->getNurseById($data['info']->nurse);
        echo json_encode($data);
    }

    function updateMedicine() {
        //  $id = $this->input->post('daily_progress_id');
        $date = date('d-m-Y', time());
        $quantity = $this->input->post('quantity');
        $sales_price = $this->input->post('sales_price');
        $medicine_id = $this->input->post('medicine_name');
        $generic_name = $this->input->post('generic_name');
        $alloted_bed_id = $this->input->post('alloted_bed_id');
        $total = $this->input->post('total');
        $medicine_name = $this->medicine_model->getMedicineById($medicine_id)->name;





        $data = array();
        //  $patientname = $this->patient_model->getPatientById($patient)->name;
        $data = array(
            'date' => $date,
            'quantity' => $quantity,
            'alloted_bed_id' => $alloted_bed_id,
            's_price' => $sales_price,
            'medicine_id' => $medicine_id,
            'medicine_name' => $medicine_name,
            'generic_name' => $generic_name,
            'total' => $total
        );




        $this->bed_model->insertMedicineAllotedPatient($data);
        $insert_id = $this->db->insert_id();
        //  $inserted_id=$this->db->inserted_id('daily_progress');
        $arr['info'] = $this->bed_model->getMedicineAllotedPatientById($insert_id);
        $arr['medicine'] = $this->medicine_model->getMedicineById($arr['info']->medicine_id);
        $arr['message'] = array('message' => lang('added'), 'title' => lang('added'));
        // $arr['added'] = array('redir' => 'added');
        echo json_encode($arr);
    }

    function deleteMedicine() {
        $id = $this->input->get('id');
        $this->bed_model->deleteMedicine($id);
        $arr['message'] = array('message' => lang('delete'), 'title' => lang('delete'));
        echo json_encode($arr);
    }

    function updateServices() {
        $pservice = $this->input->post('arr');

        $nurse = $this->input->post('nurse');
        $date = date('d-m-Y', time());
        if (!empty($pservice)) {
            foreach ($pservice as $p_service) {
                $price_pservice = $this->pservice_model->getPserviceById($p_service);
                $price[] = $price_pservice->price;
            }
            $price_update = implode("**", $price);
            $pservice_update = implode("**", $pservice);
            $data = array();
            $data = array('date' => $date,
                'nurse' => $nurse,
                'service' => $pservice_update,
                'price' => $price_update,
                'alloted_bed_id' => $this->input->post('alloted')
            );
        }
        $date_exist = $this->bed_model->getServicesByDate($date);
        if (!empty($date_exist)) {
            if (empty($pservice)) {
                $this->bed_model->deleteServices($date_exist->id);
                $arr['message'] = array('message' => lang('updated'), 'title' => lang('updated'));
            } else {
                $this->bed_model->updateServices($date_exist->id, $data);
                $arr['message'] = array('message' => lang('updated'), 'title' => lang('updated'));
            }
        } else {
            $this->bed_model->insertServices($data);
            $arr['message'] = array('message' => lang('added'), 'title' => lang('added'));
        }
        $daily_service = $this->bed_model->getServiceAllotedByBedId($this->input->post('alloted'));

        $settings = $this->settings_model->getSettings();

        foreach ($daily_service as $service) {
            $price = explode("**", $service->price);

            $service_update = explode("**", $service->service);
            //  print_r($price);
            // die();
            //$array = array_combine($service, $price);
            $length = sizeof($price);
            $length1 = sizeof($service_update);
            if ($length == $length1) {
                $i = 0;
                for ($i = 0; $i < $length; $i++) {
                    $servicename = $this->db->get_where('pservice', array('id' => $service_update[$i]))->row()->name;

                    if (!empty($service->nurse)) {
                        $nursename = $this->db->get_where('nurse', array('id' => $service->nurse))->row()->name;
                    } else {
                        $nursename = " ";
                    }

                    $option .= '<tr id="' . $service->date . '-' . $service_update[$i] . '">
                                                        <td>' . $servicename . '</td>
                                                        <td>' . $service->date . '</td>
                                                        <td>' . $nursename . '</td>
                                                        <td>' . $settings->currency . ' ' . $price[$i] . '</td>
                                                        <td> 1 </td>
                                                        <td>' . $settings->currency . ' ' . $price[$i] . '</td>
                                                        <td class="no-print"><button type="button" class="btn btn-danger btn-xs btn_width delete_service" title=' . lang('delete') . ' data-toggle=" "data-id="' . $service->id . "**" . $service_update[$i] . '"><i class="fa fa-trash"></i></button></td>
                                                    </tr>';
                }
            }
        }


        $arr['option'] = array('option' => $option, 'title' => lang('added'));
        $arr['nurses'] = $this->nurse_model->getNurseById($nurse);

        echo json_encode($arr);
    }

    function deleteServices() {
        $id = $this->input->get('id');
        $service = explode("**", $id);
        $service_details = $this->bed_model->getServicedById($service[0]);
        $services_database = explode("**", $service_details->service);
        $prices_database = explode("**", $service_details->price);
        for ($i = 0; $i < sizeof($services_database); $i++) {
            if ($service[1] != $services_database[$i]) {
                $service_new[] = $services_database[$i];
                $price_new[] = $prices_database[$i];
            }
        }
        $data = array(
            'price' => implode("**", $price_new),
            'service' => implode("**", $service_new)
        );
        if (empty($price_new)) {
            $this->bed_model->deleteServices($id);
        } else {
            $this->bed_model->updateServices($id, $data);
        }

        $arr['message'] = array('message' => lang('delete'), 'title' => lang('delete'), 'date' => $service_details->date);
        // $arr['date1'] = array();
        echo json_encode($arr);
    }

    function updateCheckout() {
        $id = $this->input->post('id');

        $doctor = $this->input->post('doctors_checkout');
        $alloted_bed_id = $this->input->post('alloted_bed_id');
        $epicrisis = $this->input->post('epicrisis');
        $checkout_state = $this->input->post('checkout_state');
        $checkout_diagnosis = $this->input->post('checkout_diagnosis');
        $dikordance = $this->input->post('dikordance');
        $anatomopatologic_diagnosis = $this->input->post('anatomopatologic_diagnosis');
        $final_diagnosis = $this->input->post('final_diagnosis');
        $d_time = $this->input->post('d_time');
        $data = array();
        $data = array('date' => $d_time,
            'final_diagnosis' => $final_diagnosis,
            'anatomopatologic_diagnosis' => $anatomopatologic_diagnosis,
            'dikordance' => $dikordance,
            'alloted_bed_id' => $alloted_bed_id,
            'doctor' => $doctor,
            'epicrisis' => $epicrisis,
            'checkout_state' => $checkout_state,
            'checkout_diagnosis' => $checkout_diagnosis,
        );

        if (!empty($id)) {
            $this->bed_model->updateCheckout($id, $data);
            $inserted_id = $id;
            $data['message'] = array('message' => lang('updated'), 'title' => lang('updated'));
        } else {
            $this->bed_model->insertCheckout($data);
            $inserted_id = $this->db->insert_id();
            $data['message'] = array('message' => lang('added'), 'title' => lang('added'));
        }
        $data['checkout'] = $this->bed_model->getCheckoutdById($inserted_id);
        $d_time_array = array();
        $d_time_array = explode("-", $d_time);
        $d_timestamp = strtotime($d_time_array[0] . ' ' . $d_time_array[1]);
        $data_update = array('d_time' => $d_time, 'd_timestamp' => $d_timestamp);

        $this->bed_model->updateAllotment($alloted_bed_id, $data_update);
        echo json_encode($data);
    }

    public function getNurseInfo() {
// Search term
        $searchTerm = $this->input->post('searchTerm');

// Get users
        $response = $this->nurse_model->getNurseInfo($searchTerm);

        echo json_encode($response);
    }

}

/* End of file bed.php */
/* Location: ./application/modules/bed/controllers/bed.php */
