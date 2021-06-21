<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Medicine_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertMedicine($data) {
        $this->db->insert('medicine', $data);
    }

    function getMedicine() {
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('medicine');
        return $query->result();
    }

    function getMedicineWithoutSearch($order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'asc');
        }
        $query = $this->db->get('medicine');
        return $query->result();
    }

    function getLatestMedicine() {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('medicine');
        return $query->result();
    }

    function getMedicineLimitByNumber($number) {
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('medicine', $number);
        return $query->result();
    }

    function getMedicineByPageNumber($page_number) {
        $data_range_1 = 50 * $page_number;
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('medicine', 50, $data_range_1);
        return $query->result();
    }

    function getMedicineByStockAlert() {
        $this->db->where('quantity <=', 20);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('medicine');
        return $query->result();
    }

    function getMedicineByStockAlertByPageNumber($page_number) {
        $data_range_1 = 50 * $page_number;
        $this->db->where('quantity <=', 20);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('medicine', 50, $data_range_1);
        return $query->result();
    }

    function getMedicineById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('medicine');
        return $query->row();
    }

    function getMedicineByKeyByStockAlert($page_number, $key) {
        $data_range_1 = 50 * $page_number;

        $this->db->where('quantity <=', 20);
        $this->db->or_like('name', $key);
        $this->db->or_like('company', $key);



        $this->db->order_by('id', 'asc');
        $query = $this->db->get('medicine', 50, $data_range_1);
        return $query->result();
    }

    function getMedicineByKey($page_number, $key) {
        $data_range_1 = 50 * $page_number;
        $this->db->like('name', $key);
        $this->db->or_like('company', $key);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('medicine', 50, $data_range_1);
        return $query->result();
    }

    function getMedicineByKeyForPos($key) {
        $this->db->like('name', $key);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('medicine');
        return $query->result();
    }

    function updateMedicine($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('medicine', $data);
    }

    function insertMedicineCategory($data) {

        $this->db->insert('medicine_category', $data);
    }

    function getMedicineCategory() {
        $query = $this->db->get('medicine_category');
        return $query->result();
    }

    function getMedicineCategoryById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('medicine_category');
        return $query->row();
    }

    function totalStockPrice() {
        $query = $this->db->get('medicine')->result();
        $stock_price = array();
        foreach ($query as $medicine) {
            $stock_price[] = $medicine->price * $medicine->quantity;
        }

        if (!empty($stock_price)) {
            return array_sum($stock_price);
        } else {
            return 0;
        }
    }

    function updateMedicineCategory($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('medicine_category', $data);
    }

    function deleteMedicine($id) {
        $this->db->where('id', $id);
        $this->db->delete('medicine');
    }

    function deleteMedicineCategory($id) {
        $this->db->where('id', $id);
        $this->db->delete('medicine_category');
    }

    function getMedicineBySearch($search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->like('id', $search);
        $this->db->or_like('category', $search);
        $this->db->or_like('name', $search);
        $this->db->or_like('e_date', $search);
        $this->db->or_like('generic', $search);
        $this->db->or_like('company', $search);
        $this->db->or_like('effects', $search);
        $query = $this->db->get('medicine');
        return $query->result();
    }

    function getMedicineByLimit($limit, $start, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get('medicine');
        return $query->result();
    }

    function getMedicineByLimitBySearch($limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->like('id', $search);
        $this->db->or_like('category', $search);
        $this->db->or_like('name', $search);
        $this->db->or_like('e_date', $search);
        $this->db->or_like('generic', $search);
        $this->db->or_like('company', $search);
        $this->db->or_like('effects', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('medicine');
        return $query->result();
    }

    function getMedicineNameByAvailablity($searchTerm) {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where("name like '%" . $searchTerm . "%' ");
            $fetched_records = $this->db->get('medicine');
            $query = $fetched_records->result();
        } else {
            $this->db->select('*');
            $this->db->limit(10);
            $fetched_records = $this->db->get('medicine');
            $query = $fetched_records->result();
        }

        return $query;
    }

    function getMedicineInfo($searchTerm) {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            //   $this->db->where('quantity >', '0');
            $this->db->where("name like '%" . $searchTerm . "%' ");
            $this->db->or_where("id like '%" . $searchTerm . "%' ");
            $fetched_records = $this->db->get('medicine');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            // $this->db->where('quantity >', '0');
            $this->db->limit(10);
            $fetched_records = $this->db->get('medicine');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['id'] . '*' . $user['name'], "text" => $user['name']);
        }
        return $data;
    }

    function getMedicineInfoForPharmacySale($searchTerm) {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where('quantity >', '0');
            $this->db->where("name like '%" . $searchTerm . "%' ");
            $this->db->or_where("id like '%" . $searchTerm . "%' ");
            $fetched_records = $this->db->get('medicine');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            $this->db->where('quantity >', '0');
            $this->db->limit(10);
            $fetched_records = $this->db->get('medicine');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['id'] . '*' . (float) $user['s_price'] . '*' . $user['name'] . '*' . $user['company'] . '*' . $user['quantity'], "text" => $user['name']);
        }
        return $data;
    }

    function getMedicineExpireAlertBySearch($search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('e_date <', time() + (86500 * 5));
        $this->db->like('id', $search);
        $this->db->or_like('category', $search);
        $this->db->or_like('name', $search);
        $this->db->or_like('e_date', $search);
        $this->db->or_like('generic', $search);
        $this->db->or_like('company', $search);
        $this->db->or_like('effects', $search);
        $query = $this->db->get('medicine');
        return $query->result();
    }

    function getMedicineExpireAlertByLimit($limit, $start, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $this->db->where('e_date <', time() + (86500 * 5));
        $query = $this->db->get('medicine');
        return $query->result();
    }

    function getMedicineExpireAlertByLimitBySearch($limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('e_date <', time() + (86500 * 5));
        $this->db->like('id', $search);
        $this->db->or_like('category', $search);
        $this->db->or_like('name', $search);
        $this->db->or_like('e_date', $search);
        $this->db->or_like('generic', $search);
        $this->db->or_like('company', $search);
        $this->db->or_like('effects', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('medicine');
        return $query->result();
    }

    function getMedicineExpireAlert() {
        $this->db->order_by('id', 'asc');
        $this->db->where('e_date <', time() + (86500 * 5));
        $query = $this->db->get('medicine');
        return $query->result();
    }

    function getMedicineExpireAlertWithoutSearch($order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'asc');
        }
        $this->db->where('e_date <', time() + (86500 * 5));
        $query = $this->db->get('medicine');
        return $query->result();
    }

    function getGenericInfo($searchTerm) {
        $this->db->where('name', 'surgery');
        $this->db->or_where('name', 'Surgery');
        $query1 = $this->db->get('department')->row();
        if (!empty($searchTerm)) {
            $this->db->select('*');

            $this->db->where('department', $query1->id);
            $this->db->where("id LIKE '%" . $searchTerm . "%' OR generic LIKE '%" . $searchTerm . "%' OR medicine_id LIKE '%" . $searchTerm . "%'");

            $fetched_records = $this->db->get('internal_medicine');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');

            // $this->db->where('quantity >', '0');
            $this->db->where('department', $query1->id);
            $this->db->or_where('department_name', 'Surgery');
            $this->db->limit(10);
            $fetched_records = $this->db->get('internal_medicine');
            $users = $fetched_records->result_array();
        }

        $user_gen = array();
        foreach ($users as $user) {
            $user_gen[] = $user['generic'];
        }
        $result = array_unique($user_gen);

        $data = array();
        $i = 0;
        foreach ($result as $user) {
            //  echo $user[$i];
            $data[] = array("id" => $user, "text" => $user);
        }

        return $data;
    }

    function getGenericInfoByEmergency($searchTerm) {
        $this->db->where('name', 'emergency');
        $this->db->or_where('name', 'Emergency');
        $query1 = $this->db->get('department')->row();
        if (!empty($searchTerm)) {
            $this->db->select('*');

            $this->db->where('department', $query1->id);
            $this->db->where("id LIKE '%" . $searchTerm . "%' OR generic LIKE '%" . $searchTerm . "%'OR medicine_id LIKE '%" . $searchTerm . "%'");

            $fetched_records = $this->db->get('internal_medicine');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');

            // $this->db->where('quantity >', '0');
            $this->db->where('department', $query1->id);

            $this->db->limit(10);
            $fetched_records = $this->db->get('internal_medicine');
            $users = $fetched_records->result_array();
        }

        $user_gen = array();
        foreach ($users as $user) {
            $user_gen[] = $user['generic'];
        }
        $result = array_unique($user_gen);

        $data = array();
        $i = 0;
        foreach ($result as $user) {
            //  echo $user[$i];
            $data[] = array("id" => $user, "text" => $user);
        }

        return $data;
    }

    function getGenericInfoByAll($searchTerm) {
        $this->db->where('name', 'emergency');
        $this->db->or_where('name', 'Emergency');
        $query1 = $this->db->get('department')->row();

        $this->db->where('name', 'surgery');
        $this->db->or_where('name', 'Surgery');
        $query2 = $this->db->get('department')->row();
        if (!empty($searchTerm)) {
            $this->db->select('*');


            $this->db->where("id LIKE '%" . $searchTerm . "%' OR generic LIKE '%" . $searchTerm . "%' OR medicine_id LIKE '%" . $searchTerm . "%'");

            $fetched_records = $this->db->get('internal_medicine');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            $this->db->limit(10);
            $fetched_records = $this->db->get('internal_medicine');
            $users = $fetched_records->result_array();
        }

        $user_gen = array();
        foreach ($users as $user) {
            if ($user['department'] != $query1->id && $user['department'] != $query2->id) {
                $user_gen[] = $user['generic'];
            }
        }
        $result = array_unique($user_gen);

        $data = array();
        $i = 0;
        foreach ($result as $user) {
            //  echo $user[$i];
            $data[] = array("id" => $user, "text" => $user);
        }

        return $data;
    }

    function getMedicineByGeneric($id) {
        return $this->db->where('generic', $id)
                        ->get('internal_medicine')
                        ->result();
    }

    function insertInternalMedicineCategory($data) {

        $this->db->insert('internal_medicine_category', $data);
    }

    function getInternalMedicineCategory() {
        $query = $this->db->get('internal_medicine_category');
        return $query->result();
    }

    function getInternalMedicineCategoryByDepartment($department) {
        $this->db->where('department', $department);
        $query = $this->db->get('internal_medicine_category');
        return $query->result();
    }

    function getInternalMedicineCategoryById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('internal_medicine_category');
        return $query->row();
    }

    function updateInternalMedicineCategory($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('internal_medicine_category', $data);
    }

    function deleteInternalMedicineCategory($id) {
        $this->db->where('id', $id);
        $this->db->delete('internal_medicine_category');
    }

    function getMedicineByDepartment($department) {
        $this->db->order_by('id', 'asc');
        $this->db->where('department', $department);
        $query = $this->db->get('medicine');
        return $query->result();
    }

    function getInternalMedicineByDepartment($department) {
        $this->db->where('department', $department);
        $query = $this->db->get('internal_medicine');
        return $query->result();
    }

    function insertInternalMedicine($data) {
        $this->db->insert('internal_medicine', $data);
    }

    function updateInternalMedicine($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('internal_medicine', $data);
    }

    function getInternalMedicineById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('internal_medicine');
        return $query->row();
    }

    function getInternalMedicineBySearch($search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->like('id', $search);
        $this->db->or_like('category', $search);
        $this->db->or_like('name', $search);
        $this->db->or_like('e_date', $search);
        $this->db->or_like('generic', $search);
        $this->db->or_like('company', $search);
        $this->db->or_like('effects', $search);
        $query = $this->db->get('internal_medicine');
        return $query->result();
    }

    function getInternalMedicineByLimit($limit, $start, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get('internal_medicine');
        return $query->result();
    }

    function getInternalMedicineByLimitBySearch($limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->like('id', $search);
        $this->db->or_like('category', $search);
        $this->db->or_like('name', $search);
        $this->db->or_like('e_date', $search);
        $this->db->or_like('generic', $search);
        $this->db->or_like('company', $search);
        $this->db->or_like('effects', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('internal_medicine');
        return $query->result();
    }

    function getInternalMedicineWithoutSearch($order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'asc');
        }
        $query = $this->db->get('internal_medicine');
        return $query->result();
    }

    function deleteInternalMedicine($id) {
        $this->db->where('id', $id);
        $this->db->delete('internal_medicine');
    }

    function getInternalMedicineByGenericId($id) {
        return $this->db->where('generic', $id)
                        ->get('internal_medicine')->result();
    }

    function getMedicineForInternalMedicineByDepartment($department, $searchTerm) {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where('department', $department);
            $this->db->where("name like '%" . $searchTerm . "%' ");
            $this->db->or_where("id like '%" . $searchTerm . "%' ");
            $fetched_records = $this->db->get('internal_medicine');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');

            $this->db->limit(10);
            $this->db->where('department', $department);
            $fetched_records = $this->db->get('internal_medicine');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $medicine = $this->db->where('id', $user['medicine_id'])->get('medicine')->row();
            $data[] = array("id" => $user['id'] . '*' . (float) $medicine->s_price . '*' . $medicine->name . '*' . $medicine->company . '*' . $medicine->quantity . '*' . $medicine->id, "text" => $medicine->name);
        }
        return $data;
    }

    function insertRequisition($data) {
        $this->db->insert('requisition', $data);
    }

    function updateRequisition($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('requisition', $data);
    }

    function getRequisitionBySearch($search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->like('id', $search);
        $this->db->or_like('date_string', $search);

        $query = $this->db->get('requisition');
        return $query->result();
    }

    function getRequisitionByLimit($limit, $start, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get('requisition');
        return $query->result();
    }

    function getRequisitionByLimitBySearch($limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->like('id', $search);
        $this->db->or_like('date_string', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('requisition');
        return $query->result();
    }

    function getRequisitionWithoutSearch($order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'asc');
        }
        $query = $this->db->get('requisition');
        return $query->result();
    }

    function deleteRequisition($id) {
        $this->db->where('id', $id);
        $this->db->delete('requisition');
    }

    function getRequisitionById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('requisition');
        return $query->row();
    }
      function getInternalMedicineByStockAlert() {
        $this->db->where('quantity <=', '20');
        $this->db->or_where(array('quantity' => NULL));
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('internal_medicine');
        return $query->result();
    }
     function getMedicineByPharmacist($id) {
        $this->db->where('pharmacist', $id);
        $query = $this->db->get('medicine');
        return $query->row();
    }


}
