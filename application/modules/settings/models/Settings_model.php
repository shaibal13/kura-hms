<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Settings_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getSettings() {
        $query = $this->db->get('settings');
        return $query->row();
    }

    function updateSettings($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('settings', $data);
    }

    function getColumnOrder($order, $columns_valid = array()) {
        $col = 0;
        $dir = "";
        $values = array();
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
        if (!isset($columns_valid[$col])) {
            $order = null;
        } else {
            $order = $columns_valid[$col];
        }
        $values[] = $dir;
        $values[] = $order;
        return $values;
    }

    function modules() {
        $id = $this->ion_auth->get_user_id();
        $this->db->where('id', $id);
        $query = $this->db->get('users')->row();
        $permissions = explode(',', $query->permissions);
        return $permissions;
    }

    function modules2($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('users')->row();
        $permissions = explode(',', $query->permissions);
        return $permissions;
    }
    function getUserDepartment(){
        return $this->db->where('id',$this->ion_auth->get_user_id())
                ->get('users')->row();
    }
     function getDiscountType() {
        $query = $this->db->get('settings');
        return $query->row()->discount;
    }


}
