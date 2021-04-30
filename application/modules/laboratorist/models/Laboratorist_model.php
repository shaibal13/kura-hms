<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Laboratorist_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertLaboratorist($data) {

        $this->db->insert('laboratorist', $data);
    }

    function getLaboratorist() {
        $query = $this->db->get('laboratorist');
        return $query->result();
    }

    function getLaboratoristById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('laboratorist');
        return $query->row();
    }

    function updateLaboratorist($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('laboratorist', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('laboratorist');
    }

    function updateIonUser($username, $email, $password, $ion_user_id) {
        $uptade_ion_user = array(
            'username' => $username,
            'email' => $email,
            'password' => $password
        );
        $this->db->where('id', $ion_user_id);
        $this->db->update('users', $uptade_ion_user);
    }
function getLaboratoristInfo($searchTerm) {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where("name like '%" . $searchTerm . "%' ");
            $this->db->or_where("id like '%" . $searchTerm . "%' ");
            $fetched_records = $this->db->get('laboratorist');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            // $this->db->where("name like '%".$searchTerm."%' ");
            //  $this->db->or_where("id like '%".$searchTerm."%' ");
            $this->db->limit(10);
            $fetched_records = $this->db->get('laboratorist');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['id'], "text" => $user['name'] . ' (' . lang('id') . ': ' . $user['id'] . ')');
        }
        return $data;
    }

}
