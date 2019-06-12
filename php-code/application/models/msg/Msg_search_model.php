<?php

class Msg_search_model extends Api_Model
{
    
    public function get()
    {
        $queryField = ' * ';
        $this->db->from('msg_search_keyword t');
        $this->db->order_by('search_count', 'DESC');
        //查询前三十个
        $this->db->limit(50, 0);
        return $this->db->get() -> result_array();
        //return $this->getCountPage('msg_search_keyword');
    }
    
    public function add($title)
    {
        $queryField = ' * ';
        $this->db->select($queryField);
        $this->db->from('msg_search_keyword t');
        $this->db->where('t.search_name', $title);

        $result = $this->db->get()->row_array();
        
        if (empty($result)) {
            $result = array(
                'search_name' => $title,
                'search_count' => 1
            );
            $this->db->insert('msg_search_keyword', $result);
        } else {
            $result['search_count'] += 1;
            $this->db->where('id', $result['id']);
            $this->db->update('msg_search_keyword', $result);
        }
        
        return $this->db->insert_id('id');
    }
}