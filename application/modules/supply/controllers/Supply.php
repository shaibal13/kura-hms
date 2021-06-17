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

        $data['medicines'] = $this->medicine_model->getMedicine();
        $data['settings'] = $this->settings_model->getSettings();       
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('medicine', $data);
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
   function addSupply(){
    $vendor_name= $this->input->post('vendor_name');
    $id= $this->input->post('id');
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
                $medicine[] = $key .'*' . $current_item->name . '*' . $category_price . '*' . $category_type . '*' . $qty;
                $amount_by_category[] = $category_price * $qty;
                $count = $count + 1;
            }
            $category_name = implode(',', $cat_and_price);
        }
        if()
        
   }

}

/* End of file medicine.php */
/* Location: ./application/modules/medicine/controllers/medicine.php */
