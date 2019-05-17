<?php
class Res_album_model extends Api_Model
{

    public function get()
    {
        $queryField = 't.*,  dic_district.name, dic_content_category.content_category_name, st.like_count, st.collect_count';
        $this -> simpleQuery($queryField, TRUE);
        $this->db->join('statis_res_like_collect st', 't.id = st.res_id and st.res_type = "2"', 'left');
        $this -> not_delete();
        
        return $this -> getCountPage('res_album');
    }
    
    protected function simpleQuery($queryField, $countQuery = FALSE) {
        $this->db->select($queryField);
        if ($countQuery === FALSE) {
            $this->db->from('res_album t');
        }
        $this->db->join('dic_content_category', 'dic_content_category.id = t.content_category_id', 'left');
        $this->db->join('dic_district', 'dic_district.id = t.district_id', 'left');
    }
    
    public function detail($id) {
        $queryField = 'res_album.*,  dic_district.name, dic_content_category.content_category_name, ht.house_type_name';
        $this -> simpleQuery($queryField);
        $this->db->join('dic_house_type as ht', 'ht.id = t.house_type_id', 'left');
        $this -> db -> where('t.id', $id);
        $this -> not_delete();
        return $this->db->get()->row_array();
        
    }
    
    public function add()
    {
        $fields = array('title', 'description', 'terms', 'publish_type', 'content_category_id', 'source', 'publish_time',
            'author', 'house_type', 'floor_area', 'district_id', 'building', 'cost', 'style', 'publish_status');
        $data = get_request_field_array($fields);
        $this->db->insert('res_album', $data);
        $album_id = $this->db->insert_id('id');

        $images = get_request_field_array(array('images'))['images'];
        $count = 0;
        foreach ( $images as $k => $val ) {
            $images[$k]["album_id"] = $album_id;
            $images[$k]["order_num"] = $count++;
        }
        $this->db->insert_batch('res_image', $images);
        return $album_id;
    }
    
    public function edit($id = null)
    {
        $fields = array('title', 'description', 'terms', 'publish_type', 'content_category_id', 'source', 'publish_time',
            'author', 'house_type', 'floor_area', 'district_id', 'building', 'cost', 'style', 'publish_status');
        $data = get_request_field_array($fields);
        $this->db->where('id', $id);
        $result = $this->db->update('res_album', $data);
        
        $images = get_request_field_array(array('images'))['images'];
        $count = 0;
        foreach ( $images as $k => $val ) {
            $images[$k]["album_id"] = $id;
            $images[$k]["order_num"] = $count++;
        }
        $this->db->update_batch('res_image', $images, 'id');
        return $result;
    }
    
    public function delete($id = null) {
        $data = array(
            'is_delete' => '1'
        );
        $this->db->where('id', $id);
        $this->db->update('res_album', $data);
        $this->db->where('album_id', $id);
        $this->db->update('res_image', $data);
    }
    
}