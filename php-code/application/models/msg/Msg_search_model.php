<?php

class Msg_search_model extends Api_Model
{

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