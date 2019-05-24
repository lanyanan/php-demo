<?php

class Sys_token_model extends Api_Model
{

    public function detail($key = null) {
        $this->db->select('*');
        $this->db->from('sys_token t');
        $this->db->where('t.key', $key);
        return $this->db->get() -> row_array();;
    }
    
    public function save_token($key, $token) {
        $data = $this -> detail($key);
        if ($data) {
            $data['token'] = $token;
            $this->db->where('id', $data['id']);
            return $this->db->update('sys_token', $data);
        }
        $data = array(
            'key' => $key,
            'token' => $token,
        );
        return $this->db->insert('sys_token', $data);
    }
    
    
    public function delete_token($login_name) {
        if (empty($login_name)) {
            return;
        }
        $this->db->where('key', $login_name);
        $this->db->delete('sys_token');
    }
    
}