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
        $this->load->library('encryption');
        $request =  json_decode(@file_get_contents("php://input") , true);
        $data = array(
            'nick_name' =>  $request['nick_name'],
            'login_name' => $request['login_name'],
            'password' => $this->encryption->encrypt($request['password']),
            'user_sex' =>  $request['user_sex'],
            'mobile' =>  $request['mobile'],
        );
        
        return $this->db->insert('sys_user', $data);
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
    
    public function delete($id = null) {
        $data = array(
            'is_delete' => '1',
        );
        $this->db->where('id', $id);
        return $this->db->update('sys_user', $data);
    }
    
}