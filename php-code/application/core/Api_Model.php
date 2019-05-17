<?php

abstract class Api_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('Api_request_helper');
    }
    
    protected function not_delete($tableAlias = FALSE) {
        if ($tableAlias === FALSE) {
           return $this->db->where('t.is_delete', 0);
        } 
        return $this->db->where($tableAlias.'.is_delete', 0);
    }
    
    protected function getCountPage($table) {
        $query = array();
        $query['count'] = $this->db->count_all_results($table.' t', FALSE);
        $data = get_limit($this);
        $this->db->limit($data['end'], $data['begin']);
        $query['data'] = $this->db->get() -> result_array();
        return $query;
    }
}