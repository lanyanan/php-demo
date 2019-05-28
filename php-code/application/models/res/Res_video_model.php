<?php
class res_video_model extends Api_Model
{

    public function get($publish = NULL)
    {
        $queryField = 't.*,  dic_district.name, dic_content_category.content_category_name, st.like_count, st.collect_count';
        $this -> simpleQuery($queryField, TRUE);
        $this->db->join('statis_res_like_collect st', 't.id = st.res_id and st.res_type = "0"', 'left');
        
        $this -> find_list_by_publis_status($publish);
        $this -> searchByVideoOrAlbumRequest();
        $this -> not_delete();
        
        return $this -> getCountPage('res_video');
    }
    
    protected function simpleQuery($queryField, $countQuery = FALSE) {
        $this->db->select($queryField);
        if ($countQuery === FALSE) {
            $this->db->from('res_video t');
        }
        $this->db->join('dic_content_category', 'dic_content_category.id = t.content_category_id', 'left');
        $this->db->join('dic_district', 'dic_district.id = t.district_id', 'left');
    }
    
    public function detail($id) {
        $queryField = 't.*,  dic_district.name, dic_district.pid as districtPid, dic_content_category.content_category_name, ht.house_type_name, ht.parent_type as houseTypePid';
        $this -> simpleQuery($queryField);
        $this->db->join('dic_house_type as ht', 'ht.id = t.house_type_id', 'left');
        $this -> db -> where('t.id', $id);
        $this -> not_delete();
        $row_data = $this->db->get()->row_array();
        $row_data['attach_url'] = $this -> signatureurl($row_data['attach_path']);
        return $row_data;
        
    }
    
    public function add()
    {
        $fields = array('title', 'description', 'terms', 'publish_type', 'content_category_id', 'source', 'publish_time', 
            'author', 'house_type_id', 'floor_area', 'district_id', 'building', 'cost', 'style', 'publish_status', 'attach_path', 
            'attach_name', 'attach_suffix', 'remark');
        $data = get_request_field_array($fields, $this);
        if ($data['publish_status'] == '1') {
            $data['publish_time'] =  date('YmdHis');
        }
        $this->db->insert('res_video', $data);
        return $this->db->insert_id('id');
    }
    
    public function edit($id = null)
    {
        $fields = array('title', 'description', 'terms', 'publish_type', 'content_category_id', 'source', 'publish_time',
            'author', 'house_type_id', 'floor_area', 'district_id', 'building', 'cost', 'style', 'publish_status', 'attach_path',
            'attach_name', 'attach_suffix', 'remark');
        $data = get_request_field_array($fields);
        if ($data['publish_status'] == '1') {
            $data['publish_time'] =  date('YmdHis');
        }
        $this->db->where('id', $id);
        return $this->db->update('res_video', $data);
    }
    
    public function delete($id = null) {
        $data = array(
            'is_delete' => '1'
        );
        $this->db->where('id', $id);
        $this->db->update('res_video', $data);
    }
    
    public function delete_batch() {
        $ids = get_request_field_array(array('ids'), $this)['ids'];
        if (empty($ids)) {
            return FALSE;
        }
        $data = array(
            'is_delete' => '1'
        );
        $this->db->where_in('id', $ids);
        return $this->db->update('res_video', $data);
    }
    
    public function publish_batch() {
        $ids = get_request_field_array(array('ids'), $this)['ids'];
        if (empty($ids)) {
            return FALSE;
        }
        $data = array(
            'publish_status' => '1',
            'publish_time' =>  date('YmdHis')
        );
        $this->db->where_in('id', $ids);
        return $this->db->update('res_video', $data);
    }
    
    public function sold_out_batch() {
        $ids = get_request_field_array(array('ids'), $this)['ids'];
        if (empty($ids)) {
            return FALSE;
        }
        $data = array(
            'publish_status' => '2',
            'sold_out_time' => date('YmdHis')
        );
        $this->db->where_in('id', $ids);
        return $this->db->update('res_video', $data);
    }
    
}