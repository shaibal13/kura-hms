<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Log_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertLog($user_id, $date, $action, $action_id) {
        $user_email = $this->db->get_where('users', array('id' => $user_id))->row()->email;
        $data = array();
        $data = array(
            'user_id' => $user_id,
            'user_email' => $user_email,
            'date_time' => $date,
            'date'=>date('d-m-Y', strtotime($date)),
            'action' => $action,
            'action_id' => $action_id
        );
        $this->db->insert('logs', $data);
    }
    function getLogBySearch($search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
         $this->db->like('id', $search);
        $this->db->or_like('user_email', $search);
        $this->db->or_like('date', $search);
        $query = $this->db->get('logs');
        return $query->result();
    }

    function getLogByLimit($limit, $start, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get('logs');
        return $query->result();
    }

    function getLogByLimitBySearch($limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->like('id', $search);
        $this->db->or_like('user_email', $search);
        $this->db->or_like('date', $search);
       

        $this->db->limit($limit, $start);
        $query = $this->db->get('logs');
        return $query->result();
    }
     function getLog($order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'asc');
        }
        $query = $this->db->get('logs');
        return $query->result();
    }

}
