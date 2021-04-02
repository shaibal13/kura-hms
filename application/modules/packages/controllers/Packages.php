<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Packages extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('packages_model');
        $this->load->model('category/category_model');
        $this->load->model('patient/patient_model');
        $this->load->model('finance/finance_model');
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
        if ($this->ion_auth->in_group(array('Pharmacist', 'Patient', 'Accountant', 'Nurse'))) {
            redirect('home/permission');
        }
    }

    public function index() {
        $data = array();
        $data['categories'] = $this->category_model->getCategory();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('packages', $data);
        $this->load->view('home/footer'); // just the header file  
    }

    public function addPackagesView() {
        $data = array();
        $data['categories'] = $this->category_model->getCategory();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_packages_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function getPaymentProccedureByCategory() {
        $id = $this->input->get('id');
        $option = '';
        $payment_proccedure = $this->packages_model->getPaymentProccedureByCategory($id);
        foreach ($payment_proccedure as $payment_category) {
            $option .= '<option value="' . $payment_category->id . '">' . $payment_category->category . '</option>';
        }
        $data['option'] = $option;
        echo json_encode($data);
    }

    public function getTableTrValue() {
        $proccedure_id = $this->input->get('proccedure_id');
        $payment_proccedure = $this->finance_model->getPaymentCategoryById($proccedure_id);
        $category = $this->category_model->getCategoryById($payment_proccedure->type);
        $option2 = '<button class="btn btn-info btn-xs btn_width delete_button" id="td-' . $payment_proccedure->id . '"><i class="fa fa-trash"> </i></button>';
        $option = '<tr class="proccedure" id="tr-' . $payment_proccedure->id . '"> <td>' . $category->name . '</td><td><input type="hidden" name="type_id[]" id="input_id-' . $payment_proccedure->id . '" value="' . $payment_proccedure->id . '" readonly><input type="text" class="input-category" name="type[]" id="input-' . $payment_proccedure->id . '" value="' . $payment_proccedure->category . '"readonly></td><td><input class="price-indivudual" type="text" name="price[]" style="width:100px;" id="price-' . $payment_proccedure->id . '" value="' . $payment_proccedure->c_price . '" ></td><td>' . $option2 . '</td></tr>';
        $data['option'] = $option;
        echo json_encode($data);
    }

    public function addPackage() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $code = $this->input->post('code');
        $single_price = $this->input->post('single_price');
        $price = $this->input->post('price[]');
        $length = count($price);
        $type_id = $this->input->post('type_id[]');

        $type = $this->input->post('type[]');
        $total_price = $this->input->post('total_price');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('code', 'Code', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Category Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Price Field
        // $this->form_validation->set_rules('number', 'Bed Number', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Generic Name Field
        $this->form_validation->set_rules('single_price', 'Single Price', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Company Name Field

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $data = array();
                $data['categories'] = $this->category_model->getCategory();
                $data['package'] = $this->packages_model->getPackagesById($id);
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_packages_view', $data);
                $this->load->view('home/footer'); // just the footer file
            } else {
                $data = array();
                $data['setval'] = 'setval';
                $data['categories'] = $this->category_model->getCategory();
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_packages_view', $data);
                $this->load->view('home/footer'); // just the header file
            }
        } else {
            $array_price_cat = array();
            for ($i = 0; $i < $length; $i++) {
                $payment_category = $this->finance_model->getPaymentCategoryById($type_id[$i]);
                $cat = $this->category_model->getCategoryById($payment_category->type);
                $array_price_cat[] = $type[$i] . '**' . $type_id[$i] . '**' . $price[$i] . '**' . $cat->name;
            }
            $total = array_sum($price);
            $price_cat = implode("##", $array_price_cat);
            $data = array();
            $data = array(
                'code' => $code,
                'name' => $name,
                'single_price' => $single_price,
                'price_cat' => $price_cat,
                'total_price' => $total,
                'status'=> $this->input->post('status')
            );
            if (empty($id)) {
                $this->packages_model->insertPackages($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->packages_model->updatePackages($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('packages');
        }
    }

    function editPackages() {
        $id = $this->input->get('id');
        $data = array();
        $data['categories'] = $this->category_model->getCategory();
        $data['package'] = $this->packages_model->getPackagesById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_packages_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function delete() {
        $id = $this->input->get('id');
        $this->packages_model->deletePackages($id);
        redirect('packages');
    }

    function getPackagesList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['packages'] = $this->packages_model->getPackagesBysearch($search);
            } else {
                $data['packages'] = $this->packages_model->getPackages();
            }
        } else {
            if (!empty($search)) {
                $data['packages'] = $this->packages_model->getPackagesByLimitBySearch($limit, $start, $search);
            } else {
                $data['packages'] = $this->packages_model->getPackagesByLimit($limit, $start);
            }
        }


        //  $data['patients'] = $this->patient_model->getVisitor();
        $i = 0;
        $permis = '';
        $permis_1 = '';
        foreach ($this->permission_access_group_explode as $perm) {
            $perm_explode = array();

            $perm_explode = explode(",", $perm);
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Medical-Data') {
                $permis = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Medical-Data') {
                $permis_1 = 'ok';
                //  break;
            }
        }
        foreach ($data['packages'] as $packages) {

            $i = $i + 1;
            $option1 = '';
            $option2 = '';
            // $option1 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $category->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</button>';
            if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok') {
                $option1 = '<a class="btn btn-info btn-xs btn_width" href="packages/editPackages?id=' . $packages->id . '" ><i class="fa fa-edit"> </i> ' . lang('edit') . '</a>';
            }
            if ($this->ion_auth->in_group(array('admin')) || $permis_1 == 'ok') {
                $option2 = '<a class="btn btn-info btn-xs btn_width delete_button" href="category/delete?id=' . $packages->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i> ' . lang('delete') . '</a>';
            }
              $status = '';
            if ($packages->status == 'active') {
                $status = lang('active');
            } if ($packages->status == 'disable') {
                $status = lang('in_active');
            }
            $info[] = array(
                $i,
                $packages->code,
                $packages->name,
                $packages->total_price,
                $packages->single_price,
                $status,
                $option1 . ' ' . $option2
            );
        }

        if (!empty($data['packages'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('packages')->num_rows(),
                "recordsFiltered" => $this->db->get('packages')->num_rows(),
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
