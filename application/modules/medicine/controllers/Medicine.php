<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Medicine extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('medicine_model');
        $this->load->model('department/department_model');
        $this->load->model('pharmacist/pharmacist_model');
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
        if ($this->ion_auth->in_group(array('Accountant', 'Receptionist', 'Laboratorist', 'Patient'))) {

            redirect('home/permission');
        }
    }

    public function index() {
        if (!$this->ion_auth->in_group(array('admin', 'Pharmacist', 'Doctor')) && !in_array('Medicine', $this->pers)) {
            redirect('home/permission');
        }

        $data['medicines'] = $this->medicine_model->getMedicine();
        $data['departments'] = $this->department_model->getDepartment();
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $data['pharmacists'] = $this->pharmacist_model->getPharmacist();

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('medicine', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function medicineByPageNumber() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['medicines'] = $this->medicine_model->getMedicineByPageNumber($page_number);
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['pagee_number'] = $page_number;
        $data['p_n'] = $page_number;
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('medicine', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function medicineStockAlert() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = '0';
        $data['medicines'] = $this->medicine_model->getMedicineByStockAlert($page_number);
        //  $data['medicines'] = $this->medicine_model->getMedicineByStockAlertByPageNumber($page_number);
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['pagee_number'] = $page_number;
        $data['settings'] = $this->settings_model->getSettings();
        $data['alert'] = 'Alert Stock';
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('medicine_stock_alert', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function medicineStockAlertByPageNumber() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = $page_number;
        $data['medicines'] = $this->medicine_model->getMedicineByStockAlert($page_number);
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['pagee_number'] = $page_number;
        $data['alert'] = 'Alert Stock';
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('medicine_stock_alert', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function searchMedicine() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = $page_number;
        $key = $this->input->get('key');
        $data['medicines'] = $this->medicine_model->getMedicineByKey($page_number, $key);
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['key'] = $key;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('medicine', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function searchMedicineInAlertStock() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = $page_number;
        $key = $this->input->get('key');
        $data['medicines'] = $this->medicine_model->getMedicineByKeyByStockAlert($page_number, $key);
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['key'] = $key;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('medicine_stock_alert', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addMedicineView() {
        $data = array();
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['departments'] = $this->department_model->getDepartment();
        $data['pharmacists'] = $this->pharmacist_model->getPharmacist();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_medicine_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewMedicine() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $category = $this->input->post('category');
        $price = $this->input->post('price');
        $box = $this->input->post('box');
        $s_price = $this->input->post('s_price');
        $quantity = $this->input->post('quantity');
        $generic = $this->input->post('generic');
        $company = $this->input->post('company');
        $effects = $this->input->post('effects');
        $e_date = $this->input->post('e_date');
        $alpha_code = $this->input->post('alpha_code');
        $department = $this->input->post('department');
        $department_name = $this->department_model->getDepartmentById($department)->name;
        $pharmacist = $this->input->post('pharmacist');
        $pharmacist_name = $this->pharmacist_model->getPharmacistById($pharmacist)->name;
        if ((empty($id))) {
            $add_date = date('m/d/y');
        } else {
            $add_date = $this->db->get_where('medicine', array('id' => $id))->row()->add_date;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Category Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Purchase Price Field
        $this->form_validation->set_rules('price', 'Purchase Price', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Store Box Field
        $this->form_validation->set_rules('box', 'Store Box', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Selling Price Field
        $this->form_validation->set_rules('s_price', 'Selling Price', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Quantity Field
        // $this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Generic Name Field
        $this->form_validation->set_rules('generic', 'Generic Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Company Name Field
        $this->form_validation->set_rules('company', 'Company', 'trim|min_length[2]|max_length[100]|xss_clean');
        // Validating Effects Field
        $this->form_validation->set_rules('effects', 'Effects', 'trim|min_length[2]|max_length[100]|xss_clean');
        // Validating Expire Date Field
        $this->form_validation->set_rules('e_date', 'Expire Date', 'trim|required|min_length[1]|max_length[100]|xss_clean');
//alpha Code
        $this->form_validation->set_rules('alpha_code', 'Alpha Code', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $data = array();
            $data['categories'] = $this->medicine_model->getMedicineCategory();
            $data['settings'] = $this->settings_model->getSettings();
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('add_new_medicine_view', $data);
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            $data = array('name' => $name,
                'category' => $category,
                'price' => $price,
                'box' => $box,
                's_price' => $s_price,
                //'quantity' => $quantity,
                'generic' => $generic,
                'company' => $company,
                'effects' => $effects,
                'add_date' => $add_date,
                'e_date' => $e_date,
                'alpha_code' => $alpha_code,
                'department' => $department,
                'department_name' => $department_name,
                'pharmacist' => $department,
                'pharmacist_name' => $pharmacist_name
            );
            if (empty($id)) {
                $this->medicine_model->insertMedicine($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->medicine_model->updateMedicine($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('medicine');
        }
    }

    function editMedicine() {
        $data = array();
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $id = $this->input->get('id');
        $data['medicine'] = $this->medicine_model->getMedicineById($id);
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_medicine_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function load() {
        $id = $this->input->post('id');
        $qty = $this->input->post('qty');
        $previous_qty = $this->db->get_where('medicine', array('id' => $id))->row()->quantity;
        $new_qty = $previous_qty + $qty;
        $data = array();
        $data = array('quantity' => $new_qty);
        $this->medicine_model->updateMedicine($id, $data);
        $this->session->set_flashdata('feedback', lang('medicine_loaded'));
        redirect('medicine');
    }

    function editMedicineByJason() {
        $id = $this->input->get('id');
        $data['medicine'] = $this->medicine_model->getMedicineById($id);
        echo json_encode($data);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->medicine_model->deleteMedicine($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('medicine');
    }

    public function medicineCategory() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['settings'] = $this->settings_model->getSettings();

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('medicine_category', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addCategoryView() {
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_category_view');
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewCategory() {
        $id = $this->input->post('id');
        $category = $this->input->post('category');
        $description = $this->input->post('description');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Category Name Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Description Field
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $data['settings'] = $this->settings_model->getSettings();
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('add_new_category_view');
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            $data = array('category' => $category,
                'description' => $description
            );
            if (empty($id)) {
                $this->medicine_model->insertMedicineCategory($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->medicine_model->updateMedicineCategory($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('medicine/medicineCategory');
        }
    }

    function edit_category() {
        $data = array();
        $id = $this->input->get('id');
        $data['medicine'] = $this->medicine_model->getMedicineCategoryById($id);
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_category_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editMedicineCategoryByJason() {
        $id = $this->input->get('id');
        $data['medicinecategory'] = $this->medicine_model->getMedicineCategoryById($id);
        echo json_encode($data);
    }

    function deleteMedicineCategory() {
        $id = $this->input->get('id');
        $this->medicine_model->deleteMedicineCategory($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('medicine/medicineCategory');
    }

    function getMedicineList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        $order = $this->input->post("order");
        $columns_valid = array(
            "0" => "id",
            "3" => "price",
            "4" => "s_price",
            "6" => "quantity",
            "10" => "e_date",
        );
        $values = $this->settings_model->getColumnOrder($order, $columns_valid);
        $dir = $values[0];
        $order = $values[1];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['medicines'] = $this->medicine_model->getMedicineBysearch($search, $order, $dir);
            } else {
                $data['medicines'] = $this->medicine_model->getMedicineWithoutSearch($order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['medicines'] = $this->medicine_model->getMedicineByLimitBySearch($limit, $start, $search, $order, $dir);
            } else {
                $data['medicines'] = $this->medicine_model->getMedicineByLimit($limit, $start, $order, $dir);
            }
        }
        //  $data['appointments'] = $this->appointment_model->getAppointment();
        $i = 0;
        $permis = '';
        $permis_1 = '';
        foreach ($this->permission_access_group_explode as $perm) {
            $perm_explode = array();
            //$permis='';
            // $permis_1='';
            $perm_explode = explode(",", $perm);
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Medicine') {
                $permis = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Medicine') {
                $permis_1 = 'ok';
                //  break;
            }
        }
        $count = 0;
        foreach ($data['medicines'] as $medicine) {
            $i = $i + 1;
            $load = '';
            $option1 = '';
            $option2 = '';
            $settings = $this->settings_model->getSettings();
            if ($medicine->quantity <= 0) {
                $quan = '<p class="os">Stock Out</p>';
            } else {
                $quan = $medicine->quantity;
            }
            if ($this->ion_auth->in_group(array('admin', 'Pharmacist')) || $permis == 'ok') {
                // $load = '<button type="button" class="btn btn-info btn-xs btn_width load" data-toggle="modal" data-id="' . $medicine->id . '">' . lang('load') . '</button>';
                $option1 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $medicine->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</button>';
            }
            if ($this->ion_auth->in_group(array('admin', 'Pharmacist')) || $permis_1 == 'ok') {
                $option2 = '<a class="btn btn-info btn-xs btn_width delete_button" href="medicine/delete?id=' . $medicine->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i> ' . lang('delete') . '</a>';
            }
            $pharmacist = $this->pharmacist_model->getPharmacistById($medicine->pharmacist);
            if (empty($pharmacist)) {
                $pharmacist_name = $medicine->pharmacist_name;
            } else {
                $pharmacist_name = $pharmacist->name;
            }
            if ($this->ion_auth->in_group(array('admin'))) {
                $info[] = array(
                    $i,
                    $medicine->name,
                    $medicine->category,
                    $medicine->box,
                    $settings->currency . $medicine->price,
                    $settings->currency . $medicine->s_price,
                    $quan, //. '<br>' .// $load,
                    $medicine->generic,
                    $medicine->company,
                    $medicine->effects,
                    $medicine->e_date,
                    $medicine->department_name,
                    $option1 . ' ' . $option2
                        //  $options2
                );
                $count = $count + 1;
            } elseif ($this->ion_auth->in_group(array('Pharmacist'))) {
                $info[] = array(
                    $i,
                    $medicine->name,
                    $medicine->category,
                    $medicine->box,
                    $settings->currency . $medicine->price,
                    $settings->currency . $medicine->s_price,
                    $quan, //. '<br>' .// $load,
                    $medicine->generic,
                    $medicine->company,
                    $medicine->effects,
                    $medicine->e_date,
                    $option1 . ' ' . $option2
                        //  $options2
                );
                $count = $count + 1;
            } else {
                $user = $this->ion_auth->get_user_id();
                $department = $this->db->get_where('users', array('id' => $user))->row()->department;
                if ($department == $medicine->department) {
                    $info[] = array(
                        $i,
                        $medicine->name,
                        $medicine->category,
                        $medicine->box,
                        $settings->currency . $medicine->price,
                        $settings->currency . $medicine->s_price,
                        $quan, //. '<br>' .// $load,
                        $medicine->generic,
                        $medicine->company,
                        $medicine->effects,
                        $medicine->e_date,
                        $option1 . ' ' . $option2
                            //  $options2
                    );
                    $count = $count + 1;
                }
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

    function getMedicineExpireAlertList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        $order = $this->input->post("order");
        $columns_valid = array(
            "0" => "id",
            "3" => "price",
            "4" => "s_price",
            "6" => "quantity",
            "10" => "e_date",
        );
        $values = $this->settings_model->getColumnOrder($order, $columns_valid);
        $dir = $values[0];
        $order = $values[1];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['medicines'] = $this->medicine_model->getMedicineExpireAlertBysearch($search, $order, $dir);
            } else {
                $data['medicines'] = $this->medicine_model->getMedicineExpireAlertWithoutSearch($order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['medicines'] = $this->medicine_model->getMedicineByLimitExpireAlertBySearch($limit, $start, $search, $order, $dir);
            } else {
                $data['medicines'] = $this->medicine_model->getMedicineExpireAlertByLimit($limit, $start, $order, $dir);
            }
        }
        //  $data['appointments'] = $this->appointment_model->getAppointment();
        $i = 0;
        $count = 0;
        foreach ($data['medicines'] as $medicine) {
            $i = $i + 1;
            $settings = $this->settings_model->getSettings();
            if ($medicine->quantity <= 0) {
                $quan = '<p class="os">Stock Out</p>';
            } else {
                $quan = $medicine->quantity;
            }
            $load = '<button type="button" class="btn btn-info btn-xs btn_width load" data-toggle="modal" data-id="' . $medicine->id . '">' . lang('load') . '</button>';
            $option1 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $medicine->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</button>';

            $option2 = '<a class="btn btn-info btn-xs btn_width delete_button" href="medicine/delete?id=' . $medicine->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i> ' . lang('delete') . '</a>';
            $info[] = array(
                $i,
                $medicine->name,
                $medicine->category,
                $medicine->box,
                $settings->currency . $medicine->price,
                $settings->currency . $medicine->s_price,
                $quan . '<br>' . $load,
                $medicine->generic,
                $medicine->company,
                $medicine->effects,
                $medicine->e_date,
                $option1 . ' ' . $option2
                    //  $options2
            );
            $count = $count + 1;
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

    public function getMedicinenamelist() {
        $searchTerm = $this->input->post('searchTerm');

        $response = $this->medicine_model->getMedicineNameByAvailablity($searchTerm);
        $data = array();
        foreach ($response as $responses) {
            $data[] = array("id" => $responses->id, "data-id" => $responses->id, "data-med_name" => $responses->name, "text" => $responses->name);
        }

        echo json_encode($data);
    }

    public function getMedicineListForSelect2() {
// Search term
        $searchTerm = $this->input->post('searchTerm');

// Get users
        $response = $this->medicine_model->getMedicineInfo($searchTerm);

        echo json_encode($response);
    }

    public function getMedicineForPharmacyMedicine() {
// Search term
        $searchTerm = $this->input->post('searchTerm');

// Get users
        $response = $this->medicine_model->getMedicineInfoForPharmacySale($searchTerm);

        echo json_encode($response);
    }

    public function medicineExpireAlert() {

        $data['medicines'] = $this->medicine_model->getMedicineExpireAlert();
        //  $data['medicines'] = $this->medicine_model->getMedicineByStockAlertByPageNumber($page_number);
        $data['categories'] = $this->medicine_model->getMedicineCategory();

        $data['settings'] = $this->settings_model->getSettings();

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('medicine_expire_alert', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function getGenericNameInfo() {
// Search term
        $searchTerm = $this->input->post('searchTerm');

// Get users
        $response = $this->medicine_model->getGenericInfo($searchTerm);

        echo json_encode($response);
    }

    function getGenericNameInfoByEmergency() {
        $searchTerm = $this->input->post('searchTerm');

// Get users
        $response = $this->medicine_model->getGenericInfoByEmergency($searchTerm);

        echo json_encode($response);
    }

    function getGenericNameInfoByAll() {
        $searchTerm = $this->input->post('searchTerm');

// Get users
        $response = $this->medicine_model->getGenericInfoByAll($searchTerm);

        echo json_encode($response);
    }

    function getMedicineByGeneric() {
        $id = $this->input->get('id');
        $medicines = $this->medicine_model->getMedicineByGeneric($id);
        $option = '<option  value="select">' . lang('select') . '</option>';
        foreach ($medicines as $medicine) {
            $option .= '<option value="' . $medicine->id . '">' . $medicine->name . '</option>';
        }
        $data['response'] = $option;
        echo json_encode($data);
    }

    function getMedicine() {
        $id = $this->input->get('id');
        $data = array();
        $data['medicine'] = $this->medicine_model->getMedicineById($id);
        echo json_encode($data);
    }

    public function medicineInternalCategory() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if ($this->ion_auth->in_group(array('admin'))) {
            $data['categories'] = $this->medicine_model->getInternalMedicineCategory();
        } else {
            $user = $this->ion_auth->get_user_id();
            $department = $this->db->get_where('users', array('id' => $user))->department;
            $data['categories'] = $this->medicine_model->getInternalMedicineCategoryByDepartment($department);
        }

        $data['settings'] = $this->settings_model->getSettings();
        $data['departments'] = $this->department_model->getDepartment();

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('medicine_internal_category', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addInternalCategoryView() {
        $data['settings'] = $this->settings_model->getSettings();
        $data['departments'] = $this->department_model->getDepartment();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_internal_category_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewInternalCategory() {
        $id = $this->input->post('id');
        $category = $this->input->post('category');
        $description = $this->input->post('description');
        if ($this->ion_auth->in_group(array('admin'))) {
            $department = $this->input->post('department');
            $department_name = $this->department_model->getDepartmentById($department)->name;
        } else {
            $user = $this->ion_auth->get_user_id();
            $department = $this->db->get_where('users', array('id' => $user))->row()->department;
            $department_name = $this->department_model->getDepartmentById($department)->name;
        }
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Category Name Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Description Field
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $data['settings'] = $this->settings_model->getSettings();
            $data['departments'] = $this->department_model->getDepartment();
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('add_new_internal_category_view', $data);
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            $data = array('category' => $category,
                'description' => $description,
                'department' => $department,
                'department_name' => $department_name
            );

            if (empty($id)) {

                $this->medicine_model->insertInternalMedicineCategory($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->medicine_model->updateMedicineCategory($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('medicine/medicineInternalCategory');
        }
    }

    function editInternalcategory() {
        $data = array();
        $id = $this->input->get('id');
        $data['medicine'] = $this->medicine_model->getInternalMedicineCategoryById($id);
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_internal_category_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editInternalMedicineCategoryByJason() {
        $id = $this->input->get('id');
        $data['medicinecategory'] = $this->medicine_model->getInternalMedicineCategoryById($id);
        echo json_encode($data);
    }

    function deleteInternalMedicineCategory() {
        $id = $this->input->get('id');
        $this->medicine_model->deleteInternalMedicineCategory($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('medicine/medicineInternalCategory');
    }

    public function internalMedicine() {
        if (!$this->ion_auth->in_group(array('admin', 'Doctor')) && !in_array('Medicine', $this->pers)) {
            redirect('home/permission');
        }
        if ($this->ion_auth->in_group(array('admin', 'Doctor'))) {

            $data['departments'] = $this->department_model->getDepartment();
        } else {

            $department = $this->settings_model->getUserDepartment();
            $data['internal_medicines'] = $this->medicine_model->getInternalMedicineByDepartment($department->department);

            $i = 0;
            foreach ($data['internal_medicines'] as $internal) {
                $data['internal'][$i] = $internal->medicine_id;

                //array_push($data['internal'][$i], $internal->medicine_id);
                $i = $i + 1;
            }

            $data['medicines'] = $this->medicine_model->getMedicineByDepartment($department->department);
            $data['categories'] = $this->medicine_model->getInternalMedicineCategoryByDepartment($department->department);
        }
        // $data['medicines'] = $this->medicine_model->getMedicine();
        //$data['departments'] = $this->department_model->getDepartment();

        $data['settings'] = $this->settings_model->getSettings();
        //$data['pharmacists'] = $this->pharmacist_model->getPharmacist();

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('internal_medicine', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function getInternalMedicineNameAndCategoryByDepartment() {
        $id = $this->input->get('id');
        $medicine_list = $this->medicine_model->getMedicineByDepartment($id);
        $category = $this->medicine_model->getInternalMedicineCategoryByDepartment($id);
        $data['internal_medicines'] = $this->medicine_model->getInternalMedicineByDepartment($id);

        $i = 0;
        foreach ($data['internal_medicines'] as $internal) {
            $data['internal'][$i] = $internal->medicine_id;

            //array_push($data['internal'][$i], $internal->medicine_id);
            $i = $i + 1;
        }
        $option = $option1 = '';
        foreach ($medicine_list as $med) {
            if (!in_array($med->id, $data['internal'])) {
                $option .= '<option value="' . $med->id . '">' . $med->name . '</option>';
            }
        }
        foreach ($category as $cat) {
            $option1 .= '<option value="' . $cat->category . '">' . $cat->category . '</option>';
        }
        $data['option'] = $option;
        $data['option1'] = $option1;
        echo json_encode($data);
    }

    public function getInternalMedicineNameAndCategoryByDepartmentForEdit() {
        $id = $this->input->get('id');
        $med_id = $this->input->get('med_id');
        $med_details = $this->medicine_model->getInternalMedicineById($med_id);
        $medicine_list = $this->medicine_model->getMedicineByDepartment($id);
        $category = $this->medicine_model->getInternalMedicineCategoryByDepartment($id);
        $option = $option1 = '';
        $data['internal_medicines'] = $this->medicine_model->getInternalMedicineByDepartment($id);

        $i = 0;
        foreach ($data['internal_medicines'] as $internal) {
            $data['internal'][$i] = $internal->medicine_id;

            //array_push($data['internal'][$i], $internal->medicine_id);
            $i = $i + 1;
        }
        foreach ($medicine_list as $med) {
            if ($med->id == $med_details->medicine_id) {
                $option .= '<option value="' . $med->id . '">' . $med->name . '</option>';
            } elseif (!in_array($med->id,$data['internal'])) {
                $option .= '<option value="' . $med->id . '">' . $med->name . '</option>';
            }
        }
      
        foreach ($category as $cat) {
            $option1 .= '<option value="' . $cat->category . '">' . $cat->category . '</option>';
        }
        $data['option'] = $option;
        $data['option1'] = $option1;
        echo json_encode($data);
    }

    public function addInternalMedicineView() {
        $data = array();
        $data['settings'] = $this->settings_model->getSettings();
        if ($this->ion_auth->in_group(array('admin', 'Doctor'))) {

            $data['departments'] = $this->department_model->getDepartment();
        } else {

            $department = $this->settings_model->getUserDepartment();
            $data['medicines'] = $this->medicine_model->getMedicineByDepartment($department->department);
            $data['internal_medicines'] = $this->medicine_model->getInternalMedicineByDepartment($department->department);
            $i = 0;
            foreach ($data['internal_medicines'] as $internal) {
                $data['internal'][$i] = $internal->medicine_id;

                //array_push($data['internal'][$i], $internal->medicine_id);
                $i = $i + 1;
            }
            $data['categories'] = $this->medicine_model->getInternalMedicineCategoryByDepartment($department->department);
        }
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_internal_medicine_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewInternalMedicine() {
        $id = $this->input->post('id');
        $name_id = $this->input->post('name_id');
        $medicine = $this->medicine_model->getMedicineById($name_id);
        $name = $medicine->name;
        $category = $this->input->post('category');

        $s_price = $this->input->post('s_price');
        //  $quantity = $this->input->post('quantity');
        $generic = $medicine->generic;
        $company = $medicine->company;
        $effects = $medicine->effects;
        $e_date = $this->input->post('e_date');
        $alpha_code = $medicine->alpha_code;
        if ($this->ion_auth->in_group(array('admin', 'Doctor'))) {
            $department = $this->input->post('department');
            $department_name = $this->department_model->getDepartmentById($department)->name;
        } else {
            $department = $this->settings_model->getUserDepartment()->department;
            $department_name = $this->department_model->getDepartmentById($department)->name;
        }

        if ((empty($id))) {
            $add_date = date('m/d/y');
        } else {
            $add_date = $this->db->get_where('internal_medicine', array('id' => $id))->row()->add_date;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        //   $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Category Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Purchase Price Field
        // $this->form_validation->set_rules('price', 'Purchase Price', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Store Box Field
        // $this->form_validation->set_rules('box', 'Store Box', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Selling Price Field
        $this->form_validation->set_rules('s_price', 'Selling Price', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Quantity Field
        // $this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Generic Name Field
        //$this->form_validation->set_rules('generic', 'Generic Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Company Name Field
        //$this->form_validation->set_rules('company', 'Company', 'trim|min_length[2]|max_length[100]|xss_clean');
        // Validating Effects Field
        //$this->form_validation->set_rules('effects', 'Effects', 'trim|min_length[2]|max_length[100]|xss_clean');
        // Validating Expire Date Field
        $this->form_validation->set_rules('e_date', 'Expire Date', 'trim|required|min_length[1]|max_length[100]|xss_clean');
//alpha Code
        //$this->form_validation->set_rules('alpha_code', 'Alpha Code', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $data = array();
            $data['settings'] = $this->settings_model->getSettings();
            if ($this->ion_auth->in_group(array('admin', 'Doctor'))) {

                $data['departments'] = $this->department_model->getDepartment();
            } else {

                $department = $this->settings_model->getUserDepartment();
                $data['internal_medicines'] = $this->medicine_model->getInternalMedicineByDepartment($department->department);
                $data['medicines'] = $this->medicine_model->getMedicineByDepartment($department->department);
                $data['categories'] = $this->medicine_model->getInternalMedicineCategoryByDepartment($department->department);
            }
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('add_new_internal_medicine_view', $data);
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            $data = array('name' => $name,
                'category' => $category,
                'medicine_id' => $name_id,
                // 'price' => $price,
                //  'box' => $box,
                's_price' => $s_price,
                //'quantity' => $quantity,
                'generic' => $generic,
                'company' => $company,
                'effects' => $effects,
                'add_date' => $add_date,
                'e_date' => $e_date,
                'alpha_code' => $alpha_code,
                'department' => $department,
                'department_name' => $department_name,
                    //'pharmacist' => $department,
                    //  'pharmacist_name' => $pharmacist_name
            );
            if (empty($id)) {
                $this->medicine_model->insertInternalMedicine($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->medicine_model->updateInternalMedicine($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('medicine/internalMedicine');
        }
    }

    function editInternalMedicineByJason() {
        $id = $this->input->get('id');
        $data['medicine'] = $this->medicine_model->getInternalMedicineById($id);
        // if ($this->ion_auth->in_group(array('admin', 'Doctor'))) {
        $medicine_list = $this->medicine_model->getMedicineByDepartment($data['medicine']->department);
        $category = $this->medicine_model->getInternalMedicineCategoryByDepartment($data['medicine']->department);
        $option = $option1 = '';
        $data['internal_medicines'] = $this->medicine_model->getInternalMedicineByDepartment($data['medicine']->department);

        $i = 0;
        foreach ($data['internal_medicines'] as $internal) {
            $data['internal'][$i] = $internal->medicine_id;

            //array_push($data['internal'][$i], $internal->medicine_id);
            $i = $i + 1;
        }
        foreach ($medicine_list as $med) {
            if ($med->id == $data['medicine']->medicine_id) {

                $option .= '<option value="' . $med->id . '" selected>' . $med->name . '</option>';
            } else {
                if (!in_array($med->id,$data['internal'])) {
                    $option .= '<option value="' . $med->id . '">' . $med->name . '</option>';
                }
            }
        }
        foreach ($category as $cat) {
            if ($cat->category == $data['medicine']->category) {
                $option1 .= '<option value="' . $cat->category . '" selected>' . $cat->category . '</option>';
            } else {
                $option1 .= '<option value="' . $cat->category . '">' . $cat->category . '</option>';
            }
        }
        $data['option'] = $option;
        $data['option1'] = $option1;
        // }
        echo json_encode($data);
    }

    function getInternalMedicineList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        $order = $this->input->post("order");
        $columns_valid = array(
            "0" => "id",
            "3" => "price",
            "4" => "s_price",
            "6" => "quantity",
            "10" => "e_date",
        );
        $values = $this->settings_model->getColumnOrder($order, $columns_valid);
        $dir = $values[0];
        $order = $values[1];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['medicines'] = $this->medicine_model->getInternalMedicineBysearch($search, $order, $dir);
            } else {
                $data['medicines'] = $this->medicine_model->getInternalMedicineWithoutSearch($order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['medicines'] = $this->medicine_model->getInternalMedicineByLimitBySearch($limit, $start, $search, $order, $dir);
            } else {
                $data['medicines'] = $this->medicine_model->getInternalMedicineByLimit($limit, $start, $order, $dir);
            }
        }

        $i = 0;
        $permis = '';
        $permis_1 = '';
        foreach ($this->permission_access_group_explode as $perm) {
            $perm_explode = array();

            $perm_explode = explode(",", $perm);
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Medicine') {
                $permis = 'ok';
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Medicine') {
                $permis_1 = 'ok';
            }
        }
        $count = 0;
        foreach ($data['medicines'] as $medicine) {
            $i = $i + 1;
            $load = '';
            $option1 = '';
            $option2 = '';
            $settings = $this->settings_model->getSettings();
            if ($medicine->quantity <= 0) {
                $quan = '<p class="os">Stock Out</p>';
            } else {
                $quan = $medicine->quantity;
            }
            if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok') {
                // $load = '<button type="button" class="btn btn-info btn-xs btn_width load" data-toggle="modal" data-id="' . $medicine->id . '">' . lang('load') . '</button>';
                $option1 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $medicine->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</button>';
            }
            if ($this->ion_auth->in_group(array('admin')) || $permis_1 == 'ok') {
                $option2 = '<a class="btn btn-info btn-xs btn_width delete_button" href="medicine/deleteInternalMedicine?id=' . $medicine->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i> ' . lang('delete') . '</a>';
            }

            if ($this->ion_auth->in_group(array('admin'))) {
                $info[] = array(
                    $i,
                    $medicine->name,
                    $medicine->category,
                    $settings->currency . $medicine->s_price,
                    $quan,
                    $medicine->generic,
                    $medicine->e_date,
                    $medicine->department_name,
                    $option1 . ' ' . $option2
                );
                $count = $count + 1;
            } else {
                $user = $this->ion_auth->get_user_id();
                $department = $this->db->get_where('users', array('id' => $user))->row()->department;
                if ($department == $medicine->department) {
                    $info[] = array(
                        $i,
                        $medicine->name,
                        $medicine->category,
                        $settings->currency . $medicine->s_price,
                        $quan,
                        $medicine->generic,
                        $medicine->e_date,
                        $option1 . ' ' . $option2
                    );
                    $count = $count + 1;
                }
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

    function deleteInternalMedicine() {
        $id = $this->input->get('id');
        $this->medicine_model->deleteInternalMedicine($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('medicine/internalMedicine');
    }
    function editInternalMedicine() {
        $data = array();
       // $data['categories'] = $this->medicine_model->getMedicineCategory();
        $id = $this->input->get('id');
        $data['medicine'] = $this->medicine_model->getInternalMedicineById($id);
         if ($this->ion_auth->in_group(array('admin', 'Doctor'))) {

            $data['departments'] = $this->department_model->getDepartment();
             
        } else {

            $department = $this->settings_model->getUserDepartment();
            $data['internal_medicines'] = $this->medicine_model->getInternalMedicineByDepartment($department->department);

            $i = 0;
            foreach ($data['internal_medicines'] as $internal) {
                $data['internal'][$i] = $internal->medicine_id;

                //array_push($data['internal'][$i], $internal->medicine_id);
                $i = $i + 1;
            }

           
        }
         $data['medicines'] = $this->medicine_model->getMedicineByDepartment( $data['medicine']->department);
            $data['categories'] = $this->medicine_model->getInternalMedicineCategoryByDepartment( $data['medicine']->department);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_internal_medicine_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }
}

/* End of file medicine.php */
/* Location: ./application/modules/medicine/controllers/medicine.php */
