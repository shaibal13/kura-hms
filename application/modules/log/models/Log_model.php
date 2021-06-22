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
            'action' => $action,
            'action_id' => $action_id
        );
        $this->db->insert('logs', $data);
    }

}
