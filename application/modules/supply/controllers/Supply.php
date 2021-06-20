<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Supply extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('medicine/medicine_model');
        $this->load->model('department/department_model');
        $this->load->model('pharmacist/pharmacist_model');
        $this->load->model('supply_model');
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
        if (!$this->ion_auth->in_group(array('admin', 'Pharmacist'))) {
            redirect('home/permission');
        }

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('supply', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewSupply() {
        if (!$this->ion_auth->in_group(array('admin', 'Pharmacist'))) {
            redirect('home/permission');
        }

        $data['medicines'] = $this->medicine_model->getMedicine();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_supply', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function addSupply() {
        $vendor_name = $this->input->post('vendor_name');
        $id = $this->input->post('id');
        $item_selected = $this->input->post('medicine_id');
        $quantity = array();
        $category_selected = array();
        $item_quantity_array = array();
        $quantity = $this->input->post('quantity');
        $item_quantity_array = array_combine($item_selected, $quantity);
        if (!empty($item_quantity_array)) {
            foreach ($item_quantity_array as $key => $value) {
                $current_item = $this->medicine_model->getMedicineById($key);
                $category_price = $current_item->price;
                $category_type = $current_item->category;
                $qty = $value;
                $medicine[] = $key . '*' . $current_item->name . '*' . $category_price . '*' . $category_type . '*' . $qty;
                $amount_by_category[] = $category_price * $qty;
                $count = $count + 1;
            }
            $category_name = implode(',', $medicine);
        }
        if (empty($id)) {
            $date = time();
            $date_string = date('d-m-Y', $date);
        }
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('vendor_name', 'Vendor Name', 'trim|min_length[1]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            redirect("supply/addNewSupply");
        } else {
            $data = array();
            if (empty($id)) {
                $data = array(
                    'vendor_name' => $vendor_name,
                    'supply_medicine' => $category_name,
                    'date' => $date,
                    'date_string' => $date_string,
                    'address' => $this->input->post('address'),
                    'phone' => $this->input->post('phone'),
                    'nipt' => $this->input->post('nipt'),
                    'user' => $this->ion_auth->get_user_id()
                );
            } else {
                $data = array(
                    'vendor_name' => $vendor_name,
                    'supply_medicine' => $category_name,
                    'address' => $this->input->post('address'),
                    'phone' => $this->input->post('phone'),
                    'nipt' => $this->input->post('nipt'),
                   
                );
            }
            if (empty($id)) {
                $supply = $this->supply_model->insertSupply($data);
                if ($supply) {
                    if (!empty($item_quantity_array)) {
                        foreach ($item_quantity_array as $key => $value) {
                            $medicine_list = $this->medicine_model->getMedicineById($key);
                            if (is_null($medicine_list->quantity) || empty($medicine_list->quantity) || $medicine_list->quantity == '0') {
                                $quantity_update = $value;
                            } else {
                                $quantity_update = $medicine_list->quantity + $value;
                            }
                            $data_med = array();
                            $data_med = array('quantity' => $quantity_update);
                            $this->medicine_model->updateMedicine($key, $data_med);
                        }
                    }
                }
                $this->session->set_flashdata('feedback', lang('quantity_updated_in_medicine'));
            } else {
                $previous_supply = $this->supply_model->getSupplyById($id);
                if (!empty($item_quantity_array)) {
                    $supply_previous_explode1 = explode(",", $previous_supply->supply_medicine);
                    foreach ($supply_previous_explode1 as $supply_individual_medicine) {
                        $medicine_supply_explode1 = explode("*", $supply_individual_medicine);
                        if (!in_array($supply_individual_medicine1[0], $item_selected)) {
                            $medicine_list1 = $this->medicine_model->getMedicineById($supply_individual_medicine1[0]);
                            $med_quan = $medicine_list1->quantity - $medicine_supply_explode[4];
                            $data_med = array();
                            $data_med = array('quantity' => $med_quan);
                            $this->medicine_model->updateMedicine($key, $data_med);
                        }
                    }

                    foreach ($item_quantity_array as $key => $value) {
                        $medicine_list = $this->medicine_model->getMedicineById($key);
                        if (empty($medicine_list->quantity)) {
                            $quantity_update = $value;
                        } else {
                            $supply_previous_explode = explode(",", $previous_supply->supply_medicine);
                            foreach ($supply_previous_explode as $supply_individual_medicine) {
                                $medicine_supply_explode = explode("*", $supply_individual_medicine);
                                if ($medicine_supply_explode[0] == $key) {
                                    $quantity_update = $medicine_list->quantity - $medicine_supply_explode[4] + $value;
                                }
                            }
                        }
                        $data_med = array();
                        $data_med = array('quantity' => $quantity_update);
                        $this->medicine_model->updateMedicine($key, $data_med);
                    }
                }
                
                $supply = $this->supply_model->updateSupply($id, $data);
                  $this->session->set_flashdata('feedback', lang('quantity_updated_in_medicine'));
            }
            redirect("supply");
        }
    }

    function editSupply() {

        $id = $this->input->get('id');
        $data['supply'] = $this->supply_model->getSupplyById($id);
        $data['medicines'] = $this->medicine_model->getMedicine();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_supply', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function getSupplyList() {
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
                $data['supplies'] = $this->supply_model->getSupplyBysearch($search, $order, $dir);
            } else {
                $data['supplies'] = $this->supply_model->getSupplyWithoutSearch($order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['supplies'] = $this->supply_model->getSupplyByLimitBySearch($limit, $start, $search, $order, $dir);
            } else {
                $data['supplies'] = $this->supply_model->getSupplyByLimit($limit, $start, $order, $dir);
            }
        }

        $i = 0;

        $count = 0;
        foreach ($data['supplies'] as $supply) {
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

            if ($this->ion_auth->in_group(array('admin', 'Pharmacist'))) {
                $option1 = '<a class="btn btn-info btn-xs invoicebutton" title="' . lang('invoice') . '" style="color: #fff;" href="supply/invoice?id=' . $supply->id . '"><i class="fa fa-file-invoice"></i> ' . lang('invoice') . '</a>';
                $option2 = '<a class="btn btn-info btn-xs btn_width editbutton" href="supply/editSupply?id=' . $supply->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</a>';
            }

            if ($this->ion_auth->in_group(array('admin', 'Pharmacist'))) {
                $info[] = array(
                    $i,
                    '00-'.$supply->id,
                    $supply->date_string,
                    $supply->vendor_name,
                    $supply->address,
                    $supply->phone,
                    $supply->nipt,
                    $option1 . ' ' . $option2
                        //  $options2
                );
                $count = $count + 1;
            } else {
                $info[] = array(
                    $i,
                    '00' - $supply->id,
                    $supply->date_string,
                    $supply->vendor_name,
                    $supply->address,
                    $supply->phone,
                    $supply->nipt,
                    $option1 . ' ' . $option2
                        //  $options2
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
   function invoice(){
        $id= $this->input->get('id');
         $data['settings']= $this->settings_model->getSettings();
        $data['supply']= $this->supply_model->getSupplyById($id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('invoice', $data);
        $this->load->view('home/footer'); // just the header file
   }
}

/* End of file medicine.php */
/* Location: ./application/modules/medicine/controllers/medicine.php */
