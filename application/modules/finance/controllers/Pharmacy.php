<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pharmacy extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('pharmacy_model');
        $this->load->model('medicine/medicine_model');
        $this->load->model('settings/settings_model');
        $this->load->model('department/department_model');
        $this->load->model('finance/finance_model');
        $this->load->model('pharmacist/pharmacist_model');
        $this->load->model('log/log_model');
        $this->load->library("excel");
        $data['settings'] = $this->settings_model->getSettings();
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
        if ($this->ion_auth->in_group(array('Patient', 'Receptionist', 'Nurse', 'Laboratorist', 'Doctor'))) {
            redirect('home/permission');
        }
    }

    function home() {
        if (!$this->ion_auth->in_group(array('admin', 'Accountant', 'Pharmacist')) && !in_array('Pharmacy', $this->pers)) {
            redirect('home/permission');
        }
        $data = array();
        $data['medicines'] = $this->medicine_model->getMedicine();
        $data['latest_medicines'] = $this->medicine_model->getLatestMedicine();
        $data['settings'] = $this->settings_model->getSettings();
        $data['payments'] = $this->pharmacy_model->getPayment();
        $data['expenses'] = $this->pharmacy_model->getExpense();
        $data['today_sales_amount'] = $this->pharmacy_model->todaySalesAmount();
        $data['today_expenses_amount'] = $this->pharmacy_model->todayExpensesAmount();



        $data['this_month']['payment'] = $this->pharmacy_model->thisMonthPayment();
        $data['this_month']['expense'] = $this->pharmacy_model->thisMonthExpense();


        $data['this_day']['payment'] = $this->pharmacy_model->thisDayPayment();
        $data['this_day']['expense'] = $this->pharmacy_model->thisDayExpense();


        $data['this_year']['payment'] = $this->pharmacy_model->thisYearPayment();
        $data['this_year']['expense'] = $this->pharmacy_model->thisYearExpense();



        $data['this_year']['payment_per_month'] = $this->pharmacy_model->getPaymentPerMonthThisYear();


        $data['this_year']['expense_per_month'] = $this->pharmacy_model->getExpensePerMonthThisYear();




        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('finance/pharmacy/home', $data);
        $this->load->view('home/footer');
    }

    public function index() {
        redirect('pharmacy/financial_report');
    }

    public function payment() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['settings'] = $this->settings_model->getSettings();
        $data['payments'] = $this->pharmacy_model->getPayment();
        // $data['payments'] = $this->pharmacy_model->getPaymentByPageNumber($page_number);


        $data['pagee_number'] = $page_number;
        $data['p_n'] = '0';

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/payment', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function paymentByPageNumber() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['payments'] = $this->pharmacy_model->getPaymentByPageNumber($page_number);
        $data['pagee_number'] = $page_number;
        $data['p_n'] = $page_number;
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/payment', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addPaymentView() {
        $data = array();
        $data['discount_type'] = $this->pharmacy_model->getDiscountType();
        $data['settings'] = $this->settings_model->getSettings();
        $data['medicines'] = $this->medicine_model->getMedicine();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/add_payment_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addPaymentViewDebug() {
        $data = array();
        $data['discount_type'] = $this->pharmacy_model->getDiscountType();
        $data['settings'] = $this->settings_model->getSettings();
        $data['medicines'] = $this->medicine_model->getMedicine();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/add_payment_view_new', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function getMedicineByKeyJason() {
        $key = $this->input->get('keyword');
        $medicines = $this->medicine_model->getMedicineByKeyForPos($key);

        $data[] = array();
        $lists = array();
        $options = array();
        $selected = array();
        foreach ($medicines as $medicine) {
            if ($medicine->quantity > 0) {
                $lists[] = '<li class="ooppttiioonn ms-elem-selectable" data-id="' . $medicine->id . '" data-s_price="' . (float) $medicine->s_price . '" data-m_name="' . $medicine->name . '" data-c_name="' . trim($medicine->company) . '" id="' . $medicine->id . '-selectable"><span>' . $medicine->name . '</span></li>';
                $options[] = '<option class="ooppttiioonn" data-id="' . $medicine->id . '" data-s_price="' . (float) $medicine->s_price . '" data-m_name="' . $medicine->name . '" data-c_name="' . trim($medicine->company) . '" value="' . $medicine->id . '">' . $medicine->name . '</option>';
                $selected[] = '<li class="ooppttiioonn ms-elem-selection" data-id="' . $medicine->id . '" data-s_price="' . (float) $medicine->s_price . '"data-m_name="' . $medicine->name . '"data-c_name="' . trim($medicine->company) . '" id="' . $medicine->id . '-selection" style="display: none;"><span> ' . $medicine->name . '  </span></li>';
            }
        }
        $data['ltst'] = $lists;
        $data['opp'] = $options;
        $data['slt'] = $selected;

        $lists = NULL;
        $options = NULL;
        $selected = NULL;

        echo json_encode($data);
    }

    function searchPayment() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = $page_number;
        $key = $this->input->get('key');
        $data['payments'] = $this->pharmacy_model->getPaymentByKey($page_number, $key);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['key'] = $key;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/payment', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addPayment() {
        $id = $this->input->post('id');
        $item_selected = array();
        $quantity = array();
        $item_selected = $this->input->post('medicine_id');
        $quantity = $this->input->post('quantity');

        if (empty($item_selected)) {
            $this->session->set_flashdata('feedback', lang('select_an_item'));
            redirect('finance/pharmacy/addPaymentView');
        } else {
            $item_quantity_array = array();
            $item_quantity_array = array_combine($item_selected, $quantity);
        }
        foreach ($item_quantity_array as $key => $value) {
            $current_medicine = $this->db->get_where('medicine', array('id' => $key))->row();
            $unit_price = $current_medicine->s_price;
            $cost = $current_medicine->price;
            $current_stock = (string) $current_medicine->quantity;
            $qty = $value;
            if ($current_stock < $qty) {
                $this->session->set_flashdata('quantity_check', 'Unsufficient Quantity selected for Medicine ' . $current_medicine->name);
                redirect('pharmacy/addPaymentView');
            }
            $item_price[] = $unit_price * $value;
            $category_name[] = $key . '*' . $unit_price . '*' . $qty . '*' . $cost;
        }

        $category_name = implode(',', $category_name);

        $patient = $this->input->post('patient');
        $date = time();
        $discount = $this->input->post('discount');
        $amount_received = $this->input->post('amount_received');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Price Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Price Field
        $this->form_validation->set_rules('discount', 'Discount', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            echo 'form validate noe nai re';
            // redirect('accountant/add_new'); 
        } else {
            $amount = array_sum($item_price);
            $sub_total = $amount;
            $discount_type = $this->pharmacy_model->getDiscountType();

            if ($discount_type == 'flat') {
                $flat_discount = $discount;
                $gross_total = $sub_total - $flat_discount;
            } else {
                $flat_discount = $amount * ($discount / 100);
                $gross_total = $sub_total - $flat_discount;
            }

            $data = array();
            if (empty($id)) {
                $data = array(
                    'category_name' => $category_name,
                    'patient' => $patient,
                    'date' => $date,
                    'amount' => $sub_total,
                    'discount' => $discount,
                    'flat_discount' => $flat_discount,
                    'gross_total' => $gross_total,
                    'amount_received' => $amount_received,
                    'status' => 'unpaid',
                );
                $this->pharmacy_model->insertPayment($data);
                $inserted_id = $this->db->insert_id();
                $this->log_model->insertLog($this->ion_auth->get_user_id(), date('d-m-Y H:i:s', time()), 'Add new Pharmacy Invoice(id='.$inserted_id.' )', $inserted_id);
                foreach ($item_quantity_array as $key => $value) {
                    $previous_qty = $this->db->get_where('medicine', array('id' => $key))->row()->quantity;
                    $new_qty = $previous_qty - $value;
                    $this->db->where('id', $key);
                    $this->db->update('medicine', array('quantity' => $new_qty));
                }
                $this->session->set_flashdata('feedback', lang('added'));
                redirect("finance/pharmacy/invoice?id=" . "$inserted_id");
            } else {
                $data = array(
                    'category_name' => $category_name,
                    'patient' => $patient,
                    'amount' => $sub_total,
                    'discount' => $discount,
                    'flat_discount' => $flat_discount,
                    'gross_total' => $gross_total,
                    'amount_received' => $amount_received,
                );

                $original_sale = $this->pharmacy_model->getPaymentById($id);
                $original_sale_quantity = array();
                $original_sale_quantity = explode(',', $original_sale->category_name);
                $o_s_value[] = array();
                foreach ($item_quantity_array as $key => $value) {
                    $previous_qty = $this->db->get_where('medicine', array('id' => $key))->row()->quantity;
                    foreach ($original_sale_quantity as $osq_key => $osq_value) {
                        $o_s_value = explode('*', $osq_value);
                        if ($o_s_value[0] == $key) {
                            $previous_qty1 = $previous_qty + $o_s_value[2];
                            $new_qty = $previous_qty1 - $value;
                            $this->db->where('id', $key);
                            $this->db->update('medicine', array('quantity' => $new_qty));
                        }
                    }
                }
                $this->pharmacy_model->updatePayment($id, $data);
                $this->log_model->insertLog($this->ion_auth->get_user_id(), date('d-m-Y H:i:s', time()), 'Edited Pharmacy Invoice(id='.$id.' )', $id);
                $this->session->set_flashdata('feedback', lang('updated'));
                redirect("finance/pharmacy/invoice?id=" . "$id");
            }
        }
    }

    function editPayment() {
        if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Pharmacist'))) {
            $data = array();
            $data['discount_type'] = $this->pharmacy_model->getDiscountType();
            $data['settings'] = $this->settings_model->getSettings();
            $data['medicines'] = $this->medicine_model->getMedicine();
            $id = $this->input->get('id');
            $data['payment'] = $this->pharmacy_model->getPaymentById($id);
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('pharmacy/add_payment_view', $data);
            $this->load->view('home/footer'); // just the footer file
        }
    }

    function delete() {
        if ($this->ion_auth->in_group('admin')) {
            $id = $this->input->get('id');
            $category_name = $this->pharmacy_model->getPaymentById($id)->category_name;
            $all_product_details = array();
            $all_product_details = explode(',', $category_name);

            foreach ($all_product_details as $key => $value) {
                $product_details = array();
                $product_details = explode('*', $value);
                $product_id = $product_details[0];
                $qty = $product_details[2];
                $previous_qty = $this->medicine_model->getMedicineById($product_details[0])->quantity;
                $new_qty = $previous_qty + $qty;
                $data = array();
                $data = array('quantity' => $new_qty);
                $this->medicine_model->updateMedicine($product_id, $data);
            }

            $this->pharmacy_model->deletePayment($id);
            $this->log_model->insertLog($this->ion_auth->get_user_id(), date('d-m-Y H:i:s', time()), 'Deleted Pharmacy Invoice(id='.$id.' )', $id);
            $this->session->set_flashdata('feedback', lang('deleted'));
            redirect('finance/pharmacy/payment');
        }
    }

    public function expense() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['settings'] = $this->settings_model->getSettings();
        $data['expenses'] = $this->pharmacy_model->getExpense();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/expense', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addExpenseView() {
        $data = array();
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->pharmacy_model->getExpenseCategory();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/add_expense_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addExpense() {
        $id = $this->input->post('id');
        $category = $this->input->post('category');
        $date = time();
        $amount = $this->input->post('amount');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Category Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Generic Name Field
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Company Name Field
        if ($this->form_validation->run() == FALSE) {
            $data = array();
            $data['settings'] = $this->settings_model->getSettings();
            $data['categories'] = $this->pharmacy_model->getExpenseCategory();
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('add_expense_view', $data);
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            if (empty($id)) {
                $data = array(
                    'category' => $category,
                    'date' => $date,
                    'amount' => $amount
                );
            } else {
                $data = array(
                    'category' => $category,
                    'amount' => $amount
                );
            }
            if (empty($id)) {
                $this->pharmacy_model->insertExpense($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->pharmacy_model->updateExpense($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('finance/pharmacy/expense');
        }
    }

    function editExpense() {
        $data = array();
        $data['categories'] = $this->pharmacy_model->getExpenseCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $id = $this->input->get('id');
        $data['expense'] = $this->pharmacy_model->getExpenseById($id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/add_expense_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function deleteExpense() {
        $id = $this->input->get('id');
        $this->pharmacy_model->deleteExpense($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('finance/pharmacy/expense');
    }

    public function expenseCategory() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->pharmacy_model->getExpenseCategory();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/expense_category', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addExpenseCategoryView() {
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/add_expense_category');
        $this->load->view('home/footer'); // just the header file
    }

    public function addExpenseCategory() {
        $id = $this->input->post('id');
        $category = $this->input->post('category');
        $description = $this->input->post('description');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Category Name Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Description Field
        $data['settings'] = $this->settings_model->getSettings();
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('pharmacy/add_expense_category');
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            $data = array('category' => $category,
                'description' => $description
            );
            if (empty($id)) {
                $this->pharmacy_model->insertExpenseCategory($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->pharmacy_model->updateExpenseCategory($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('finance/pharmacy/expenseCategory');
        }
    }

    function editExpenseCategory() {
        $data = array();
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['category'] = $this->pharmacy_model->getExpenseCategoryById($id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/add_expense_category', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function deleteExpenseCategory() {
        $id = $this->input->get('id');
        $this->pharmacy_model->deleteExpenseCategory($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('finance/pharmacy/expenseCategory');
    }

    function invoice() {
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['discount_type'] = $this->pharmacy_model->getDiscountType();
        $data['payment'] = $this->pharmacy_model->getPaymentById($id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/invoice', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function printInvoice() {
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['discount_type'] = $this->pharmacy_model->getDiscountType();
        $data['payment'] = $this->pharmacy_model->getPaymentById($id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/print_invoice', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function amountReceived() {
        $id = $this->input->post('id');
        $amount_received = $this->input->post('amount_received');
        $previous_amount_received = $this->db->get_where('pharmacy_payment', array('id' => $id))->row()->amount_received;
        $amount_received = $amount_received + $previous_amount_received;
        $data = array();
        $data = array('amount_received' => $amount_received);
        $this->pharmacy_model->amountReceived($id, $data);
        redirect('finance/pharmacy/invoice?id=' . $id);
    }

    function amountReceivedFromPT() {
        $id = $this->input->post('id');
        $amount_received = $this->input->post('amount_received');
        $payments = $this->pharmacy_model->getPaymentByPatientId($id);
        foreach ($payments as $payment) {
            if ($payment->gross_total != $payment->amount_received) {
                $due_balance = $payment->gross_total - $payment->amount_received;
                if ($amount_received <= $due_balance) {
                    $data = array();
                    $new_amount_received = $amount_received + $payment->amount_received;
                    $data = array('amount_received' => $new_amount_received);
                    $this->pharmacy_model->amountReceived($payment->id, $data);
                    break;
                } else {
                    $data = array();
                    $new_amount_received = $due_balance + $payment->amount_received;
                    $data = array('amount_received' => $new_amount_received);
                    $this->pharmacy_model->amountReceived($payment->id, $data);
                    $amount_received = $amount_received - $due_balance;
                }
            }
        }
        redirect('finance/pharmacy/invoicePatientTotal?id=' . $id);
    }

    function todaySales() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $hour = 0;
        $today = strtotime($hour . ':00:00');
        $today_last = strtotime($hour . ':00:00') + 24 * 60 * 60;
        $data['settings'] = $this->settings_model->getSettings();
        $data['payments'] = $this->pharmacy_model->getPaymentByDate($today, $today_last);

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/today_sales', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function todayExpense() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $hour = 0;
        $today = strtotime($hour . ':00:00');
        $today_last = strtotime($hour . ':00:00') + 24 * 60 * 60;
        $data['settings'] = $this->settings_model->getSettings();
        $data['expenses'] = $this->pharmacy_model->getExpenseByDate($today, $today_last);

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/today_expenses', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function todayNetCash() {
        $data['today_sales_amount'] = $this->pharmacy_model->todaySalesAmount();
        $data['today_expenses_amount'] = $this->pharmacy_model->todayExpensesAmount();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/today_net_cash', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function salesPerMonth() {

        $payments = $this->pharmacy_model->getPayment();
        foreach ($payments as $payment) {
            $date = $payment->date;
            $month = date('m', $date);
            $year = date('y', $date);
            if ($month = '01') {
                
            }
        }
    }

    function financialReport() {
        $date_from = strtotime($this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 24 * 60 * 60;
        }
        $data = array();
        $data['medicines'] = $this->medicine_model->getMedicine();
        $data['expense_categories'] = $this->pharmacy_model->getExpenseCategory();


        // if(empty($date_from)&&empty($date_to)) {
        //    $data['payments']=$this->pharmacy_model->get_payment();
        //     $data['ot_payments']=$this->pharmacy_model->get_ot_payment();
        //     $data['expenses']=$this->pharmacy_model->get_expense();
        // }
        // else{

        $data['payments'] = $this->pharmacy_model->getPaymentByDate($date_from, $date_to);
        $data['expenses'] = $this->pharmacy_model->getExpenseByDate($date_from, $date_to);
        // } 
        $data['from'] = $this->input->post('date_from');
        $data['to'] = $this->input->post('date_to');
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/financial_report', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function getPaymentList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];


        $order = $this->input->post("order");
        $columns_valid = array(
            "0" => "id",
            "1" => "date",
            "4" => "gross_total",
        );
        $values = $this->settings_model->getColumnOrder($order, $columns_valid);
        $dir = $values[0];
        $order = $values[1];


        if ($limit == -1) {
            if (!empty($search)) {
                $data['payments'] = $this->pharmacy_model->getPaymentBysearch($search, $order, $dir);
            } else {
                $data['payments'] = $this->pharmacy_model->getPaymentWithoutSearch($order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['payments'] = $this->pharmacy_model->getPaymentByLimitBySearch($limit, $start, $search, $order, $dir);
            } else {
                $data['payments'] = $this->pharmacy_model->getPaymentByLimit($limit, $start, $order, $dir);
            }
        }


        //  $data['patients'] = $this->patient_model->getVisitor();
        $i = 0;
        $option1 = '';
        $option2 = '';
        $option3 = '';
        $permis = '';
        $permis_1 = '';
        $permis_2 = '';
        foreach ($this->permission_access_group_explode as $perm) {
            $perm_explode = array();
            //$permis='';
            // $permis_1='';
            $perm_explode = explode(",", $perm);
            if (in_array('1', $perm_explode) && $perm_explode[0] == 'Pharmacy') {
                $permis = 'ok';
                //  break;
            }
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Pharmacy') {
                $permis_1 = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Pharmacy') {
                $permis_2 = 'ok';
                //  break;
            }
        }
        foreach ($data['payments'] as $payment) {
            //$i = $i + 1;
            $settings = $this->settings_model->getSettings();
            if ($this->ion_auth->in_group(array('admin', 'Pharmacist')) || $permis_1 == 'ok') {
                if (empty($payment->from_where)) {
                    $option1 = '<a class="btn btn-info btn-xs editbutton" href="finance/pharmacy/editPayment?id=' . $payment->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</a>';
                } else {
                    $option1 = '<a class="btn btn-info btn-xs editbutton" href="finance/pharmacy/editRequisition?id=' . $payment->requisition_id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</a>';
                }
            }
            if ($this->ion_auth->in_group('admin') || $permis_2 == 'ok') {
                if (empty($payment->from_where)) {
                    $option2 = '<a class="btn btn-info btn-xs btn_width delete_button" href="finance/pharmacy/delete?id=' . $payment->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i></a>';
                }
            }
            if (empty($payment->from_where)) {
                $option3 = '<a class="btn btn-xs green" style="color: #fff;" href="finance/pharmacy/invoice?id=' . $payment->id . '"><i class="fa fa-file-invoice"></i> ' . lang('invoice') . '</a>';
            } else {
                $option3 = '<a class="btn btn-xs green" style="color: #fff;" href="finance/pharmacy/invoiceRequisition?id=' . $payment->requisition_id . '"><i class="fa fa-file-invoice"></i> ' . lang('invoice') . '</a>';
            }
            $options4 = '<a class="btn btn-info btn-xs invoicebutton" title="' . lang('print') . '" style="color: #fff;" href="finance/pharmacy/printInvoice?id=' . $payment->id . '"target="_blank"> <i class="fa fa-print"></i> ' . lang('print') . '</a>';
            if (!empty($payment->flat_discount)) {
                $discount = number_format($payment->flat_discount, 2, '.', ',');
            } else {
                $discount = '0';
            }
            $info[] = array(
                $payment->id,
                date('d/m/y', $payment->date + 11 * 60 * 60),
                $settings->currency . '' . number_format($payment->amount, 2, '.', ','),
                $settings->currency . '' . $discount,
                $settings->currency . '' . number_format($payment->gross_total, 2, '.', ','),
                $option1 . ' ' . $option3 . ' ' . $options4 . ' ' . $option2
            );
            $i = $i + 1;
        }

        if ($data['payments']) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $i,
                "recordsFiltered" => $i,
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

    function previousInvoice() {
        $id = $this->input->get('id');
        $data1 = $this->pharmacy_model->getFirstRowPaymentById();
        if ($id == $data1->id) {
            $data = $this->pharmacy_model->getLastRowPaymentById();
            redirect('finance/pharmacy/invoice?id=' . $data->id);
        } else {
            for ($id1 = $id - 1; $id1 >= $data1->id; $id1--) {

                $data = $this->pharmacy_model->getPreviousPaymentById($id1);
                if (!empty($data)) {
                    redirect('finance/pharmacy/invoice?id=' . $data->id);
                    break;
                } elseif ($id1 == $data1->id) {
                    $data = $this->pharmacy_model->getLastRowPaymentById();
                    redirect('finance/pharmacy/invoice?id=' . $data->id);
                } else {
                    continue;
                }
            }
        }
    }

    function nextInvoice() {
        $id = $this->input->get('id');


        $data1 = $this->pharmacy_model->getLastRowPaymentById();


        //$id1 = $id + 1;
        if ($id == $data1->id) {
            $data = $this->pharmacy_model->getFirstRowPaymentById();
            redirect('finance/pharmacy/invoice?id=' . $data->id);
        } else {
            for ($id1 = $id + 1; $id1 <= $data1->id; $id1++) {

                $data = $this->pharmacy_model->getNextPaymentById($id1);


                if (!empty($data)) {
                    redirect('finance/pharmacy/invoice?id=' . $data->id);
                    break;
                } elseif ($id1 == $data1->id) {
                    $data = $this->pharmacy_model->getFirstRowPaymentById();
                    redirect('finance/pharmacy/invoice?id=' . $data->id);
                } else {
                    continue;
                }
            }
        }
    }

    function daily() {
        $data = array();
        $year = $this->input->get('year');
        $month = $this->input->get('month');

        if (empty($year)) {
            $year = date('Y');
        }
        if (empty($month)) {
            $month = date('m');
        }

        $first_minute = mktime(0, 0, 0, $month, 1, $year);
        $last_minute = mktime(23, 59, 59, $month, date("t", $first_minute), $year);

        $payments = $this->pharmacy_model->getPaymentByDate($first_minute, $last_minute);
        $all_payments = array();
        foreach ($payments as $payment) {
            $date = date('D d-m-y', $payment->date);
            if (array_key_exists($date, $all_payments)) {
                $all_payments[$date] = $all_payments[$date] + $payment->gross_total;
            } else {
                $all_payments[$date] = $payment->gross_total;
            }
        }

        $data['year'] = $year;
        $data['month'] = $month;
        $data['first_minute'] = $first_minute;
        $data['last_minute'] = $last_minute;
        $data['all_payments'] = $all_payments;

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/daily', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function dailyExpense() {
        $data = array();
        $year = $this->input->get('year');
        $month = $this->input->get('month');

        if (empty($year)) {
            $year = date('Y');
        }
        if (empty($month)) {
            $month = date('m');
        }

        $first_minute = mktime(0, 0, 0, $month, 1, $year);
        $last_minute = mktime(23, 59, 59, $month, date("t", $first_minute), $year);

        $expenses = $this->pharmacy_model->getExpenseByDate($first_minute, $last_minute);
        $all_expenses = array();
        foreach ($expenses as $expense) {
            $date = date('D d-m-y', $expense->date);
            if (array_key_exists($date, $all_expenses)) {
                $all_expenses[$date] = $all_expenses[$date] + $expense->amount;
            } else {
                $all_expenses[$date] = $expense->amount;
            }
        }

        $data['year'] = $year;
        $data['month'] = $month;
        $data['first_minute'] = $first_minute;
        $data['last_minute'] = $last_minute;
        $data['all_expenses'] = $all_expenses;



        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/daily_expense', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function monthly() {
        $data = array();
        $year = $this->input->get('year');

        if (empty($year)) {
            $year = date('Y');
        }


        $first_minute = mktime(0, 0, 0, 1, 1, $year);
        $last_minute = mktime(23, 59, 59, 12, 31, $year);

        $payments = $this->pharmacy_model->getPaymentByDate($first_minute, $last_minute);
        $all_payments = array();
        foreach ($payments as $payment) {
            $month = date('m-Y', $payment->date);
            if (array_key_exists($month, $all_payments)) {
                $all_payments[$month] = $all_payments[$month] + $payment->gross_total;
            } else {
                $all_payments[$month] = $payment->gross_total;
            }
        }

        $data['year'] = $year;
        $data['first_minute'] = $first_minute;
        $data['last_minute'] = $last_minute;
        $data['all_payments'] = $all_payments;

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/monthly', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function monthlyExpense() {
        $data = array();
        $year = $this->input->get('year');

        if (empty($year)) {
            $year = date('Y');
        }


        $first_minute = mktime(0, 0, 0, 1, 1, $year);
        $last_minute = mktime(23, 59, 59, 12, 31, $year);

        $expenses = $this->pharmacy_model->getExpenseByDate($first_minute, $last_minute);
        $all_expenses = array();
        foreach ($expenses as $expense) {
            $month = date('m-Y', $expense->date);
            if (array_key_exists($month, $all_expenses)) {
                $all_expenses[$month] = $all_expenses[$month] + $expense->amount;
            } else {
                $all_expenses[$month] = $expense->amount;
            }
        }

        $data['year'] = $year;
        $data['first_minute'] = $first_minute;
        $data['last_minute'] = $last_minute;
        $data['all_expenses'] = $all_expenses;

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/monthly_expense', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function download() {
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['discount_type'] = $this->pharmacy_model->getDiscountType();
        $data['payment'] = $this->pharmacy_model->getPaymentById($id);
        $data['redirect'] = 'download';
        $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
        $html = $this->load->view('pharmacy/invoice', $data, true);
        $mpdf->WriteHTML($html);

        $filename = "invoice--00" . $id . ".pdf";
        $mpdf->Output($filename, 'D');
    }

    function medicineRequisition() {
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/medicine_requisition', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function getRequisitionList() {
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
        );
        $values = $this->settings_model->getColumnOrder($order, $columns_valid);
        $dir = $values[0];
        $order = $values[1];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['requisitions'] = $this->medicine_model->getRequisitionBysearch($search, $order, $dir);
            } else {
                $data['requisitions'] = $this->medicine_model->getRequisitionWithoutSearch($order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['requisitions'] = $this->medicine_model->getRequisitionByLimitBySearch($limit, $start, $search, $order, $dir);
            } else {
                $data['requisitions'] = $this->medicine_model->getRequisitionByLimit($limit, $start, $order, $dir);
            }
        }

        $i = 0;


        $count = 0;
        foreach ($data['requisitions'] as $requisition) {
            $i = $i + 1;
            $load = '';
            $option1 = '';
            $option2 = $option3 = '';
            $settings = $this->settings_model->getSettings();
               $permis = '';
               $permis_1 = '';
                      $permis_2 = '';
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
             if (in_array('1', $perm_explode) && $perm_explode[0] == 'Medicine') {
                $permis_2 = 'ok';
                //  break;
            }
        }
            if ($this->ion_auth->in_group(array('Pharmacist')) || $permis == 'ok' ) {
                if ($requisition->status == 'unapproved' || empty($requisition->status)) {
                    $option1 = '<a class="btn btn-info btn-xs btn_width editbutton" href="finance/pharmacy/editRequisition?id=' . $requisition->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</a>';
                }
            }
            if ($requisition->status == 'unapproved' || empty($requisition->status)) {
                $status = lang('pending');
            } elseif ($requisition->status == 'approved') {
                $status = lang('confirmed');
            }

            $option3 = '<a class="btn btn-info btn-xs invoicebutton" title="' . lang('invoice') . '" style="color: #fff;" href="finance/pharmacy/invoiceRequisition?id=' . $requisition->id . '"><i class="fa fa-file-invoice"></i> ' . lang('invoice') . '</a>';

            if ($this->ion_auth->in_group(array('Pharmacist')) || $permis=='ok' || $permis_1=='ok' || $permis_2=='ok') {
                $info[] = array(
                    $i,
                    $requisition->date_string,
                    $settings->currency . $requisition->amount,
                    $settings->currency . $requisition->gross_total,
                    $status,
                    $requisition->department_name,
                    $option1 . ' ' . $option3
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

    function editRequisition() {
        $id = $this->input->get('id');
        $data['internal_requisition'] = $this->medicine_model->getRequisitionById($id);
        $data['discount_type'] = $this->pharmacy_model->getDiscountType();
        $data['settings'] = $this->settings_model->getSettings();

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/add_new_medicine_requisition', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function getMedicineForInternalMedicineByDepartment() {

        $searchTerm = $this->input->post('searchTerm');
        $department = $this->input->post('department');


        $response = $this->medicine_model->getMedicineForInternalMedicineByDepartment($department, $searchTerm);

        echo json_encode($response);
    }

    function addNewMedicineRequisition() {
        $id = $this->input->post('id');
        $invoice_id = $this->input->post('invoice_id');
        $item_selected = $this->input->post('medicine_id');
        $quantity = $this->input->post('quantity');

        $department = $this->medicine_model->getRequisitionById($id)->department;
        $department_name = $this->department_model->getDepartmentById($department)->name;


        $item_quantity_array = array();
        $item_quantity_array = array_combine($item_selected, $quantity);

        foreach ($item_quantity_array as $key => $value) {
            $internal_medicine = $this->medicine_model->getInternalMedicineById($key);
            $current_medicine = $this->db->get_where('medicine', array('id' => $internal_medicine->medicine_id))->row();
            $unit_price = $current_medicine->s_price;
            $cost = $current_medicine->price;

            $qty = $value;
            $item_price[] = $unit_price * $value;
            $category_name[] = $key . '*' . $unit_price . '*' . $qty . '*' . $cost . '*' . $current_medicine->id;
            $category_name1[] = $current_medicine->id . '*' . $unit_price . '*' . $qty . '*' . $cost . '*' . $key;
        }

        $category_name = implode(',', $category_name);
        $category_name1 = implode(',', $category_name1);
        $amount = array_sum($item_price);
        $sub_total = $amount;
        $discount_type = $this->finance_model->getDiscountType();
        $discount = $this->input->post('discount');
        if (!empty($discount)) {
            $discount = $discount;
        } else {
            $discount = '0';
        }
        if ($discount_type == 'flat') {
            $flat_discount = $discount;
            $gross = $sub_total - $flat_discount;
        } else {
            $flat_discount = $sub_total * ($discount / 100);
            $gross = $sub_total - $flat_discount;
        }

        if (empty($invoice_id)) {
            $date = time();
            $date_string = date('d-m-Y', $date);
        }
        $data = array();
        $data_requisition = array();
        $data_requisition = array(
            'category_name' => $category_name,
            'amount' => $sub_total,
            'gross_total' => $gross,
            'discount' => $flat_discount,
            'department' => $department,
            'department_name' => $department_name,
            'status' => 'approved'
        );

        if (empty($invoice_id)) {
            $data = array('category_name' => $category_name1,
                'amount' => $sub_total,
                'gross_total' => $gross,
                'discount' => $flat_discount,
                'date' => $date,
                'date_string' => $date_string,
                'status' => 'unpaid',
                'from_where' => 'requisition',
                'requisition_id' => $id,
            );
        } else {
            $data = array('category_name' => $category_name1,
                'amount' => $sub_total,
                'gross_total' => $gross,
                'discount' => $discount,
                'status' => 'unpaid',
                'from_where' => 'requisition',
                'requisition_id' => $id,
            );
        }

        if (empty($invoice_id)) {
            $this->pharmacy_model->insertPayment($data);
            $payment_id = $this->db->insert_id();
            $this->log_model->insertLog($this->ion_auth->get_user_id(), date('d-m-Y H:i:s', time()), 'Add new Pharmacy Invoice(id='.$payment_id.' )', $payment_id);
            $data_requisition['invoice_id'] = $payment_id;
            $this->medicine_model->updateRequisition($id, $data_requisition);
            foreach ($item_quantity_array as $key => $value) {
                $previous_qty_medicine = $this->db->get_where('internal_medicine', array('id' => $key))->row();
                $previous_qty = $this->db->get_where('medicine', array('id' => $previous_qty_medicine->medicine_id))->row()->quantity;
                $new_qty = $previous_qty - $value;
                $new_qty_internal = $previous_qty_medicine + $value;
                $this->db->where('id', $key);
                $this->db->update('internal_medicine', array('quantity' => $new_qty_internal));
                $this->db->where('id', $previous_qty_medicine->medicine_id);
                $this->db->update('medicine', array('quantity' => $new_qty));
            }
        } else {

            $this->medicine_model->updateRequisition($id, $data_requisition);
            $original_sale = $this->pharmacy_model->getPaymentById($invoice_id);
            $original_sale_quantity = array();
            $original_sale_quantity = explode(',', $original_sale->category_name);
            $o_s_value[] = array();
            foreach ($item_quantity_array as $key => $value) {
                $previous_qty_medicine = $this->db->get_where('internal_medicine', array('id' => $key))->row();
                $previous_qty = $this->db->get_where('medicine', array('id' => $previous_qty_medicine->medicine_id))->row()->quantity;
                foreach ($original_sale_quantity as $osq_key => $osq_value) {
                    $o_s_value = explode('*', $osq_value);
                    if ($o_s_value[0] == $previous_qty_medicine->medicine_id) {
                        $previous_qty1 = $previous_qty + $o_s_value[2];
                        $new_qty = $previous_qty1 - $value;
                        $new_qty_internal = $previous_qty_medicine->quantity + $o_s_value[2] - $value;
                        $this->db->where('id', $key);
                        $this->db->update('internal_medicine', array('quantity' => $new_qty_internal));
                        $this->db->where('id', $key);
                        $this->db->update('medicine', array('quantity' => $new_qty));
                    }
                }
            }
            $this->pharmacy_model->updatePayment($invoice_id, $data);
            $this->log_model->insertLog($this->ion_auth->get_user_id(), date('d-m-Y H:i:s', time()), 'Edit Pharmacy Invoice(id='.$invoice_id.' )', $invoice_id);
        }

        $this->session->set_flashdata('feedback', lang('requisition_medicine_approved'));
        redirect("finance/pharmacy/medicineRequisition");
    }

    function invoiceRequisition() {
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['discount_type'] = $this->settings_model->getDiscountType();
        $data['requisition'] = $this->medicine_model->getRequisitionById($id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/invoice_requisition', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function inventoryReport() {
        if ($this->ion_auth->in_group(array('admin'))) {
            $data['inventory'] = $this->pharmacy_model->getInventory();
        } else {
           $user = $this->ion_auth->get_user_id();
           $pharmacist = $this->db->get_where('users',array('id'=>$user))->row();
           $data['inventory'] = $this->pharmacy_model->getInventoryByPharmacist($pharmacist->id);
        }
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/inventory_report', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function addInventoryReport() {
        $data['date'] = $this->input->post('date');
        $data['title'] = $this->input->post('title');
        $data['description'] = $this->input->post('description');
        $user = $this->ion_auth->get_user_id();
        $data['pharmacist'] = $this->db->get_where('users',array('id'=>$user))->row();;
        $data['medicines'] = $this->medicine_model->getMedicineByPharmacist($data['pharmacist']->id);
        // print_r($data);
        //die();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/add_inventory_report_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function addInventoryReportExcel() {
        $ids = $this->input->post('id');
        $inventory_id = $this->input->post('inventory_id');
        $quantity = $this->input->post('quantity');
        $items = array();
        $items = array_combine($ids, $quantity);
        foreach ($items as $key => $value) {
            $item_list[] = $key . '**' . $value;
        }
        $item = implode(",", $item_list);
        $title = $this->input->post('title');
        $date = $this->input->post('date');
        $description = $this->input->post('description');
        $user = $this->ion_auth->get_user_id();
        $pharmacist = $this->db->get_where('users',array('id'=>$user))->row();
        $data = array();
        $data = array(
            'date' => $date,
            'description' => $description,
            'title' => $title,
            'pharmacist' => $pharmacist->id,
            'pharmacist_name' => $pharmacist->username,
            'item' => $item
        );
        if (empty($inventory_id)) {
            $this->pharmacy_model->insertInventory($data);
            $this->session->set_flashdata('feedback', lang('added'));
        } else {
            $this->pharmacy_model->updateInventory($inventory_id, $data);
            $this->session->set_flashdata('feedback', lang('updated'));
        }
        redirect("finance/pharmacy/inventoryReport");
    }

    function viewInventory() {
        $id = $this->input->get('id');
        $data['text'] = 'view';
        $data['inventories'] = $this->pharmacy_model->getInventoryById($id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/view_inventory_report', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function compareInventory() {
        $id = $this->input->get('id');
        $data['text'] = 'compare';
        $data['inventories'] = $this->pharmacy_model->getInventoryById($id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/view_inventory_report', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function deleteInventory() {
        $id = $this->input->get('id');
        $this->pharmacy_model->deleteInventory($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect("finance/pharmacy/inventoryReport");
    }

    function editInventory() {
        $id = $this->input->get('id');

        $data['inventories'] = $this->pharmacy_model->getInventoryById($id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pharmacy/edit_inventory_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

}

/* End of file pharmacy.php */
/* Location: ./application/modules/pharmacy/controllers/pharmacy.php */