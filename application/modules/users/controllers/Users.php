<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('ion_auth_model');
        $this->load->model('finance/finance_model');
        $this->load->model('appointment/appointment_model');
        $this->load->model('customer/customer_model');
        $this->load->model('order/order_model');
        $this->load->model('dispatch/dispatch_model');
        $this->load->library('upload');
        $this->load->library('encrypt');
        $language = $this->db->get('settings')->row()->language;
        $this->lang->load('system_syntax', $language);
        $this->load->model('settings/settings_model');
        //$this->load->model('home_model');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        //$this->load->model('settings/settings_model');
        $permissions = $this->settings_model->modules();
        $class = ucfirst($this->router->fetch_class());
        if (!in_array($class, $permissions)) {
            redirect('home/permission');
        }
    }

    public function index() {
        $data['users'] = $this->db->get('users')->result();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('users',$data);
        $this->load->view('home/footer');
    }
    
    function addUser() {
        $data['groups'] = $this->db->get('groups')->result();
        $data['permissions'] = $this->db->get('permission_features')->result();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_users',$data);
        $this->load->view('home/footer');
    }
    
    function addGroup() {
        $data['permissions'] = $this->db->get('permission_features')->result();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_group',$data);
        $this->load->view('home/footer');    
    }
    
    function editGroup() {
        $id = $this->input->get('id');
        $this->db->where('id',$id);
        $data['group'] = $this->db->get('groups')->row();
        $data['permissions'] = $this->db->get('permission_features')->result();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_group',$data);
        $this->load->view('home/footer');
    }
    
    function editUser() {
        $id = $this->input->get('id');
        $this->db->where('id',$id);
        $data['user'] = $this->db->get('users')->row();
        $data['groups'] = $this->db->get('groups')->result();
        $this->db->where('user_id',$id);
        $data['gid'] = $this->db->get('users_groups')->row();
        $data['permissions'] = $this->db->get('permission_features')->result();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_users',$data);
        $this->load->view('home/footer');
        
    }
    
    function addNew() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $last_name = $this->input->post('last_name');
        $password = $this->input->post('password');
        $group = $this->input->post('group');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
        $check = $this->input->post('manual');
        $this->form_validation->set_rules('name','First Name','required|trim|xss_clean');
        $this->form_validation->set_rules('phone','Phone','required|trim|xss_clean');
        $this->form_validation->set_rules('email','Email','required|trim|xss_clean');
        $this->form_validation->set_rules('last_name','Last Name','required|trim|xss_clean');
        $this->form_validation->set_rules('group','Group','required|trim|xss_clean');
        
        if($group == 0) {
            if(empty($id)) {
              $this->session->set_flashdata('feedback', 'Select Group Properly!'); 
              redirect('users/addUser');
            } else {
                $this->session->set_flashdata('feedback', 'Select Group Properly!'); 
              redirect('users/editUser?id='.$id);
            }
        }
        if((empty($id) || !empty($id)) && ($group == -1 || $check == 'ok')) {
            $permission = $this->input->post('permission');
            $per = implode(',', $permission);
            $this->form_validation->set_rules('permission[]','Permission','required|trim|xss_clean'); 
        }
        if(empty($id)) {
            $this->form_validation->set_rules('password','Password','required|trim|xss_clean');
        }
        if(!empty($id)) {
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('feedback', 'Validation Error !');
                redirect('users/editUser?id=' . $id);
            } else {
                if($group != -1 && $check != 'ok') {
                    $this->db->where('id',$group);
                    $per = $this->db->get('groups')->row()->description;
                }
                if (!empty($password)) {
                    $data = array(
                        'username' => $username,
                        'first_name' => $name,
                        'last_name' => $last_name,
                        'phone' => $phone,
                        'email' => $email,
                        'password' => $password,
                        'permissions' => $per,
                        'permission' => $check
                    );
                } else {
                    $data = array(
                        'username' => $username,
                        'first_name' => $name,
                        'last_name' => $last_name,
                        'phone' => $phone,
                        'email' => $email,
                        'permissions' => $per,
                        'permission' => $check
                    );
                }
                $this->ion_auth->update($id,$data);
                $this->ion_auth->remove_from_group(NULL, $id);
                if($group == -1) {
                    $group = 2;
                }
                $this->ion_auth->add_to_group($group, $id);
                $this->session->set_flashdata('feedback', 'Edited!');
                redirect('users');
            }
        } else {
            if($this->form_validation->run()==false) {
                $this->session->set_flashdata('feedback', 'Validation Error !');
                redirect('users/addUser');
            } else {
                if($group != -1 && $check != 'ok') {
                    $this->db->where('id',$group);
                    $per = $this->db->get('groups')->row()->description;
                }
                $data = array(
                    'first_name' => $name,
                    'last_name' => $last_name,
                    'phone' => $phone,
                    'password' => $password,
                    'permissions' => $per,
                    'permission' => $check
                );
                if ($group == -1) {
                    $group = 2;
                }
                $dgf = array($group);
                $this->ion_auth->register($name, $password, $email, $dgf, $data);
                $this->session->set_flashdata('feedback', 'Added!');
                redirect('users');
            }
        }
    }
    
    function addNewGroup() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $permission = $this->input->post('permission');
        $per = implode(",", $permission);
        
        $this->form_validation->set_rules('name','Name','required|trim|xss_clean');
        $this->form_validation->set_rules('permission[]','Permissions','required|trim|xss_clean');
        
        if(!empty($id)) {
            if($this->form_validation->run() == false) {
                $this->session->set_flashdata('feedback', 'Validation Error!');
                redirect('users/editGroup?id='.$id);
            } else {
                $data = array(
                    'description' => $per
                );
                $this->ion_auth->update_group($id, $name, $data);
                $this->session->set_flashdata('feedback', 'Edited!');
                redirect('users/group');
            }
        } else {
            if($this->form_validation->run() == false) {
                $this->session->set_flashdata('feedback', 'Validation Error!');
                redirect('users/add_group');
            } else {
                $this->ion_auth->create_group($name, $per);
                $this->session->set_flashdata('feedback', 'Added!');
                redirect('users/group');
            }
            
        }
    }
    
    function group() {
        $data['groups'] = $this->db->get('groups')->result();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('group',$data);
        $this->load->view('home/footer');
    }
    
    function deleteGroup() {
        $id = $this->input->get('id');
        $this->ion_auth->delete_group($id);
        $this->session->set_flashdata('feedback', 'Group Deleted!');
        redirect('users/group');
    }
    
    function deleteUser() {
        $id = $this->input->get('id');
        $this->ion_auth->delete_user($id);
        $this->session->set_flashdata('feedback', 'User Deleted!');
        redirect('users/users');
    }
    
    function getPermissions() {
        $id = $this->input->get('id');
        $view = '';
        $permissions = $this->db->get('permission_features')->result();
        $this->db->where('id',$id);
        $per = $this->db->get('groups')->row()->description;
        $pers = explode(',',$per);
        foreach ($permissions as $permission) {
            if(in_array($permission->feature,$pers)){
                $view .= '<input type="checkbox" name="permission[]" value="' . $permission->feature . '" checked /> <label for="exampleInputEmail1">' . $permission->feature . '</label><br>';
            } else {
                $view .= '<input type="checkbox" name="permission[]" value="' . $permission->feature . '"/> <label for="exampleInputEmail1">' . $permission->feature . '</label><br>';
            }  
        }
        
        $data['view'] = array (
            'view' => $view
        );
        
        echo json_encode($data);
    }

    

    

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
