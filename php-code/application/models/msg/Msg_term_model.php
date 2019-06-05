<?php

class Msg_term_model extends Api_Model
{

    public function get()
    {
        $queryField = ' * ';
        $this->simpleQuery($queryField, TRUE);
        $this->db->order_by('count', 'DESC');

        $name = $this->input->get('name');
        if (!empty($name)) {
            $this->db->like('name', $name);
        }
        return $this->getCountPage('statis_count_resource');
    }

    protected function simpleQuery($queryField, $countQuery = FALSE)
    {
        $this->db->select($queryField);
        if ($countQuery === FALSE) {
            $this->db->from('statis_count_resource t');
        }
        $this->db->join('msg_term_keyword k', 'k.id = t.term_id', 'left');
    }

    public function detail($id)
    {
        $queryField = ' * ';
        $this->simpleQuery($queryField);
        $this->db->where('t.id', $id);

        return $this->db->get()->row_array();
    }

    public function add()
    {
        // 图集保存
        $fields = array(
            'name'
        );
        $data = get_request_field_array($fields);
        $this->db->insert('msg_term_keyword', $data);
        return $this->db->insert_id('id');
    }

    public function delete($id = null)
    {
        $this->db->where('id', $id);
        $this->db->delete('msg_term_keyword');
        $this->db->where('term_id', $id);
        $this->db->delete('msg_resource_term');
    }

    public function delete_batch()
    {
        $ids = get_request_field_array(array(
            'ids'
        ), $this)['ids'];
        if (empty($ids)) {
            return FALSE;
        }
        $this->db->where_in('id', $ids);
        $this->db->delete('msg_term_keyword');
        $this->db->where_in('term_id', $ids);
        return $this->db->delete('msg_resource_term');
    }
}