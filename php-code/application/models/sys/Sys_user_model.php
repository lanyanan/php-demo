<?php

class Sys_user_model extends Api_Model
{

    public function get()
    {
        $this->db->select('*');
        $this->db->from('sys_user');
        $this->db->join('dic_district', 'dic_district.id = sys_user.district_id', 'left');
        $this -> not_delete('sys_user');
        $query = $this->db->get();
        #隐藏掉密码
        $result = $query->result_array();
        foreach ( $result as $k => $val ) {
            $result[$k]["password"] = null;
        }
        return $result;
    }
    
    public function get_by_username($login_name)
    {
        $this->db->select(' sys_user.id ,  sys_user.* , dic_district.name ');
        $this->db->from('sys_user');
        $this->db->join('dic_district', 'dic_district.id = sys_user.district_id', 'left');
        $this -> not_delete('sys_user');
        $this->db->where('sys_user.login_name', $login_name);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    public function detail($id = null) {
        $this->db->select('*');
        $this->db->from('sys_user');
        $this->db->join('dic_district', 'dic_district.id = sys_user.district_id', 'left');
        $this->db->where('sys_user.id', $id);
        $this -> not_delete('sys_user');
        $query = $this->db->get();
        #隐藏掉密码
        $result = $query->row_array();
        if (!empty($result)) {
            $result['password'] = null;
        }
        return $result;
    }
    
    public function add()
    {
        //登录名不能重复
        $fields = array('nick_name', 'login_name', 'password', 'user_sex', 'mobile');
        $request = get_request_field_array($fields, $this);
        if ($this -> validate($request['login_name'])) {
            return '登录名已存在'; 
        }
        $this->load->library('encryption');
        $data = array(
            'nick_name' =>  $request['nick_name'],
            'login_name' => $request['login_name'],
            'password' =>  password_hash($request['password'], PASSWORD_DEFAULT),
            'user_sex' =>  $request['user_sex'],
            'mobile' =>  $request['mobile'],
        );
        return $this->db->insert('sys_user', $data);
    }
    
    public function validate($login_name) {
        $this->db->select('*');
        $this->db->from('sys_user');
        $this->db->where('sys_user.login_name', $login_name);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    public function edit($id = null)
    {
        $request =  json_decode(@file_get_contents("php://input") , true);
        $data = array(
            'nick_name' => $request['nick_name'],
            'user_sex' => $request['user_sex'],
            'mobile' => $request['mobile'],
        );
        $this->db->where('id', $id);
        return $this->db->update('sys_user', $data);
    }
    
    public function flushField($field, $id) {
        $data = array(
            $field =>  date('YmdHis'),
        );
        $this->db->where('id', $id);
        return $this->db->update('sys_user', $data);
    }
    
    public function delete($id = null) {
        $data = array(
            'is_delete' => '1',
        );
        $this->db->where('id', $id);
        return $this->db->update('sys_user', $data);
    }
    
}