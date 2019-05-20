<?php
class Dic_house_type_model extends Api_Model
{

    public function get_list_by_parent($parent) {
        $queryField = 't.*';
        $this -> simpleQuery($queryField);
        $this -> db -> where('t.parent_type', $parent);
        return $this->db->get() -> result_array();
    }
    
    protected function simpleQuery($queryField, $countQuery = FALSE) {
        $this->db->select($queryField);
        if ($countQuery === FALSE) {
            $this->db->from('dic_house_type t');
        }
    }
    
}