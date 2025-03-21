<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getSum($field, $table) {
        $this->db->select_sum($field);
        $query = $this->db->get($table);
        return $query->result();
    }
    
    function addGroup($data){
        $this->db->insert('groups',$data);
    }
    
    function getGroupById($id) {
        $this->db->where('id',$id);
        $query = $this->db->get('groups')->row();
        return $query;
    }
    
    function getUserById($id) {
        $this->db->where('id',$id);
        $query = $this->db->get('users')->row();
        return $query;
    }
    
    function editGroup($id,$data){
        $this->db->where('id',$id);
        $this->db->update('groups',$data);
    }
    
    function editUser($id,$data){
        $this->db->where('id',$id);
        $this->db->update('users',$data);
    }
    
    
    function getGroup(){
        $this->db->select();
        $query = $this->db->get('groups');
        return $query->result();
    }
    
    function deleteGroup($id) {
        $this->db->where('id',$id);
        $this->db->delete('groups');
    }
  function getGroupNameAvailable($name) {
        $this->db->where('name',$name);
        $query = $this->db->get('groups')->row();
        return $query;
    }
    function insertGroupPermission($data){
        $this->db->insert('permission_access_group', $data);
    }
    function deletePermissionAccess($id) {
        $this->db->where('group_id',$id);
      
        $this->db->delete('permission_access_group');
    }
    function getPermissionAccess($id) {
        $this->db->where('group_id',$id);
        $query = $this->db->get('permission_access_group')->row();
        return $query;
    }
    function updateGroupPermission($id,$data){
        $this->db->where('id',$id);
        $this->db->update('permission_access_group', $data);
    }
}
