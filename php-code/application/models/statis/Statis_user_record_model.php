<?php

class statis_user_record_model extends Api_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }
    
    public function look($res_id) {
        
        // 获取当前用户
        $user = $this->session->tempdata('user');
        
        $res_type = get_request_field_array( array('res_type'), $this)['res_type'];
        
        $query = $this -> simpleQuery($res_id, $res_type, $user);
        
        if (empty($query)) {
            return  $this ->  createRecord( $res_id, $res_type, $query, $user);
        }
    }
    
    //不存在就新建
    protected  function createRecord( $res_id, $res_type, $query, $user) {
        $query = array(
            'res_id' =>  $res_id,
            'res_type' => $res_type,
            'user_id' => $user['id']
        );
        $this->db->insert('statis_user_record', $query);
        $id = $this->db->insert_id();
        return $this->db->get_where('statis_user_record', array('id' => $id)) ->row_array();
    }

    public function record($res_id)
    {
        // 获取当前用户
        $user = $this->session->tempdata('user');
        
        $param = array('type', 'res_type');
        $param = get_request_field_array($param, $this);
        $type = $param['type'];
        $res_type = $param['res_type'];
        
        $query = $this -> simpleQuery($res_id, $res_type, $user);
        
        if (empty($query)) {
            $query =  $this -> createRecord( $res_id, $res_type, $query, $user);
        }
        
        $query = $this -> packageQuery($query, 0, $type);
        
        $this->db->where('id', $query['id']);
        $this->db->update('statis_user_record', $query);
        return $query['id'];
    }
    
    protected function simpleQuery($res_id, $res_type, $user) {
        $this->db->select('*');
        $this->db->from('statis_user_record');
        $this->db->where('statis_user_record.res_id', $res_id);
        $this->db->where('statis_user_record.res_type', $res_type);
        $this->db->where('statis_user_record.user_id', $user['id']);
        return $this->db->get() -> row_array();
    }
    
    protected  function packageQuery($query, $value, $type){
        if ($type == '0') {
            $query['like'] = $value;
        } else if ($type == '1') {
            $query['collect'] = $value;
        } else if ($type == '2') {
            $query['oppose'] = $value;
        }
        return $query;
    }
    
    public function cancleRecord($res_id)
    {
        // 获取当前用户
        $user = $this->session->tempdata('user');
        
        $param = array('type', 'res_type');
        $param = get_request_field_array($param, $this);
        $type = $param['type'];
        $res_type = $param['res_type'];
        
        $query = $this -> simpleQuery($res_id, $res_type, $user);
        
        $query = $this ->  packageQuery($query, 0, $type);
        
        $this->db->where('id', $query['id']);
        $this->db->update('statis_user_record', $query);
        return $query['id'];
    }
}