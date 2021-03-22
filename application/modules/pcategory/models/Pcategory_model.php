<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pcategory_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertPcategory($data) {

        $this->db->insert('patient_category', $data);
    }

    function getPcategory() {
        $query = $this->db->get('patient_category');
        return $query->result();
    }

    function getPcategoryById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('patient_category');
        return $query->row();
    }

    function updatePcategory($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('patient_category', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('patient_category');
    }

    function getPcategoryBysearch($search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->like('id', $search);
        $this->db->or_like('name', $search);
        $this->db->or_like('description', $search);
        $query = $this->db->get('patient_category');
        return $query->result();
    }

    function getPcategoryByLimit($limit, $start, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get('patient_category');
        return $query->result();
    }

    function getPcategoryByLimitBySearch($limit, $start, $search, $order, $dir) {

        $this->db->like('id', $search);

        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }


        $this->db->or_like('name', $search);
        $this->db->or_like('description', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('patient_category');
        return $query->result();
    }

    function getPcategoryWithoutSearch($order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->get('patient_category');
        return $query->result();
    }

}
