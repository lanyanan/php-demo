<?php

class statis_page_view_model extends Api_Model
{

    public function view_auto_increment($res_id)
    {
        $res_type = get_request_field_array(array('res_type'), $this)['res_type'];

        $this->db->select('*');
        $this->db->from('statis_page_view');
        $this->db->where('statis_page_view.res_id', $res_id);
        $this->db->where('statis_page_view.res_type', $res_type);
        $query = $this->db->get()->row_array();

        if (empty($query)) {
            // 不存在就新建
            $query = array(
                'res_id' => $res_id,
                'res_type' => $res_type
            );
            $this->db->insert('statis_page_view', $query);
            $id = $this->db->insert_id();
            $query = $this->db->get_where('statis_page_view', array(
                'id' => $id
            ))->row_array();
        }

        $query['page_view'] = $query['page_view'] + 1;

        $this->db->where('id', $query['id']);
        return $this->db->update('statis_page_view', $query);
    }
}