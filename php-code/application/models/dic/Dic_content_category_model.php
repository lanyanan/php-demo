<?php
class Dic_content_category_model extends Api_Model
{

    public function get_list() {
        $queryField = 't.*';
        $this -> simpleQuery($queryField);
        return $this->db->get() -> result_array();
    }
    
    protected function simpleQuery($queryField, $countQuery = FALSE) {
        $this->db->select($queryField);
        if ($countQuery === FALSE) {
            $this->db->from('dic_content_category t');
        }
    }
    
}