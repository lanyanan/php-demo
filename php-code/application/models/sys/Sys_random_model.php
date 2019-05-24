<?php

class Sys_random_model extends Api_Model
{

    public function get()
    {
        $this->db->select('*');
        $this->db->from('sys_config');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function detail($name = null) {
        $this->db->select('*');
        $this->db->from('sys_random t');
        $this->db->where('t.key_name', $name);
        return $this->db->get() -> row_array();;
    }
    
}