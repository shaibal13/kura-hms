<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Packages_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertPackages($data) {
        $this->db->insert('packages', $data);
    }

    function getPackages() {
        $query = $this->db->get('packages');
        return $query->result();
    }

    function getPackagesBySearch($search) {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
      //  $this->db->or_like('bed_id', $search);
      
         $this->db->or_like('code', $search);
           $this->db->or_like('name', $search);
        $query = $this->db->get('packages');
        return $query->result();
    }

    function getPackagesByLimit($limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('packages');
        return $query->result();
    }

    function getPackagesByLimitBySearch($limit, $start, $search) {

        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

       //$this->db->or_like('bed_id', $search);
       
           $this->db->or_like('code', $search);
           $this->db->or_like('name', $search);
        $this->db->limit($limit, $start);
        $query = $this->db->get('packages');
        return $query->result();
    }

    function getPackagesById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('packages');
        return $query->row();
    }

    function updatePackages($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('packages', $data);
    }





    function deletePackages($id) {
        $this->db->where('id', $id);
        $this->db->delete('packages');
    }

    function getPaymentProccedureByCategory($id){
        $this->db->where('type',$id);
        return $this->db->get('payment_category')->result();
    }


}
