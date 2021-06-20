<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Supply_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertSupply($data) {
        return $this->db->insert('supply', $data);
    }

    function updateSupply($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('supply', $data);
    }

    function getSupplyById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('supply');
        return $query->row();
    }
   function getSupplyBySearch($search, $order, $dir) {
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
        $query = $this->db->get('supply');
        return $query->result();
    }

    function getSupplyByLimit($limit, $start, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get('supply');
        return $query->result();
    }

    function getSupplyByLimitBySearch($limit, $start, $search, $order, $dir) {
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
        $query = $this->db->get('supply');
        return $query->result();
    }
      function getSupplyWithoutSearch($order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'asc');
        }
        $query = $this->db->get('supply');
        return $query->result();
    }
}