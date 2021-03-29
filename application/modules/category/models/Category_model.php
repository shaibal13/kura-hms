<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertCategory($data) {
        $this->db->insert('category', $data);
    }

    function getCategory() {
        $query = $this->db->get('category');
        return $query->result();
    }

    function getCategoryBySearch($search) {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
      //  $this->db->or_like('bed_id', $search);
        $this->db->or_like('description', $search);
         $this->db->or_like('code', $search);
           $this->db->or_like('name', $search);
        $query = $this->db->get('category');
        return $query->result();
    }

    function getCategoryByLimit($limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('category');
        return $query->result();
    }

    function getCategoryByLimitBySearch($limit, $start, $search) {

        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

       //$this->db->or_like('bed_id', $search);
        $this->db->or_like('description', $search);
           $this->db->or_like('code', $search);
           $this->db->or_like('name', $search);
        $this->db->limit($limit, $start);
        $query = $this->db->get('category');
        return $query->result();
    }

    function getCategoryById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('category');
        return $query->row();
    }

    function updateCategory($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('category', $data);
    }





    function deleteCategory($id) {
        $this->db->where('id', $id);
        $this->db->delete('category');
    }




}
