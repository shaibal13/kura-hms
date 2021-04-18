<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Surgery_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertSurgery($data) {

        $this->db->insert('surgery', $data);
    }
     function updateSurgery($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('surgery', $data);
    }
       function getSurgeryById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('surgery');
        return $query->row();
    }
    function getSurgery() {
        $query = $this->db->get('surgery');
        return $query->result();
    }
      function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('surgery');
    }
    function insertSurgeryCheckin($data) {

        $this->db->insert('surgery_checkin', $data);
    }
    function getSurgeryCheckinById($surgery){
        $this->db->where('surgery_id', $surgery);
        $query = $this->db->get('surgery_checkin');
        return $query->row();
    }
    function updateSurgeryCheckin($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('surgery_checkin', $data);
    }
}