<?php
date_default_timezone_set('PRC'); 
class Res_album_model extends Api_Model
{

    public function get($publish = NULL)
    {
        $user = $this->session->tempdata('user');
        $queryField = 't.*,  dic_district.name, dic_content_category.content_category_name, st.like_count, st.collect_count, pv.page_view';
        if (!empty($user['id'])) {
            $queryField = $queryField.", ur.like as isLike, ur.collect as isCollect, ur.look as isLook, ur.oppose as isOppose";
        }
        $this -> simpleQuery($queryField, TRUE);
        
        $this -> not_delete();
        
        $this -> find_list_by_publis_status($publish);
        $this -> searchByVideoOrAlbumRequest();
        return $this -> getCountPage('res_album');
    }
    
    protected function simpleQuery($queryField, $countQuery = FALSE) {
        $this->db->select($queryField);
        if ($countQuery === FALSE) {
            $this->db->from('res_album t');
        }
        $this->db->join('dic_content_category', 'dic_content_category.id = t.content_category_id', 'left');
        $this->db->join('dic_district', 'dic_district.id = t.district_id', 'left');
        $this->db->join('statis_res_like_collect st', 't.id = st.res_id and st.res_type = "2"', 'left');
        $this->db->join('statis_page_view pv', 't.id = pv.res_id and pv.res_type = "0" ', 'left');
        
        $user = $this->session->tempdata('user');
        if (! empty($user['id'])) {
            $this->db->join('statis_user_record ur', 't.id = ur.res_id and ur.res_type = "0" and ur.user_id = ' . $user['id'] . ' ', 'left');
        }
    }
    
    public function detail($id) {
        $user = $this->session->tempdata('user');
        $queryField = 't.*,  dic_district.name, dic_district.pid as districtPid,  dic_content_category.content_category_name, ht.house_type_name, st.like_count, st.collect_count, pv.page_view';
        if (!empty($user['id'])) {
            $queryField = $queryField.", ur.like as isLike, ur.collect as isCollect, ur.look as isLook, ur.oppose as isOppose";
        }
        $this -> simpleQuery($queryField);
        $this->db->join('dic_house_type as ht', 'ht.id = t.house_type_id', 'left');
        $this -> db -> where('t.id', $id);
        $this -> not_delete();
        
        #查询关联图片
        $data = $this->db->get()->row_array();
        $this->db->select(" * ");
        $this->db->from('res_image t');
        $this -> db -> where('t.album_id', $id);
        $this -> not_delete();
        $result_array = $this->db->get() -> result_array();
        foreach ( $result_array as $k => $val ) {
            $result_array[$k]['attach_url'] = $this -> signatureurl( $result_array[$k]['attach_path']);
        }
        $data['images'] = $result_array;
        
        return $data;
        
    }
    
    public function add()
    {
        //图集保存
        $fields = array('title', 'description', 'terms', 'publish_type', 'content_category_id', 'source', 'publish_time', 'source_url',
            'author', 'house_type_id', 'floor_area', 'district_id', 'building', 'cost', 'style', 'publish_status');
        $data = get_request_field_array($fields);
        if ($data['publish_status'] == '1') {
            $data['publish_time'] =  date('YmdHis');
        }
        $this->db->insert('res_album', $data);
        $album_id = $this->db->insert_id('id');
        //图片保存
        $images = get_request_field_array(array('images'))['images'];
        $count = 0;
        foreach ( $images as $k => $val ) {
            $images[$k]["album_id"] = $album_id;
            $images[$k]["order_num"] = $count++;
        }
        $this->db->insert_batch('res_image', $images);
        
        //关键词保存
        $content = '';
        if (array_key_exists('terms', $data)) {
            $content = $data['terms'];
        }
        $this -> saveTerms($content, $album_id, '1');
        return $album_id;
    }
    
    public function edit($id = null)
    {
        $fields = array('title', 'description', 'terms', 'publish_type', 'content_category_id', 'source', 'publish_time', 'source_url',
            'author', 'house_type_id', 'floor_area', 'district_id', 'building', 'cost', 'style', 'publish_status');
        $data = get_request_field_array($fields);
        if ($data['publish_status'] == '1') {
            $data['publish_time'] =  date('YmdHis');
        }
        $this->db->where('id', $id);
        $result = $this->db->update('res_album', $data);
        
        $images = get_request_field_array(array('images'))['images'];
        $count = 0;
        $imagesAdd = array();
        $imagesUpdate = array();
        foreach ( $images as $k => $val ) {
            $images[$k]["album_id"] = $id;
            $images[$k]["order_num"] = $count++;
            if (empty($images[$k]["id"])) {
                array_push($imagesAdd, $images[$k]);
            } else {
                array_push($imagesUpdate, $images[$k]);
            }
        }
        if (!empty($imagesUpdate)) {
            $this->db->update_batch('res_image', $imagesUpdate, 'id');
        }
        if (!empty($imagesAdd)) {
            $this->db->insert_batch('res_image', $imagesAdd);
        }
        //关键词保存
        $content = '';
        if (array_key_exists('terms', $data)) {
            $content = $data['terms'];
        }
        $this -> saveTerms($content, $id, '1');
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
        //删除term
        $this -> deleteTerms(array($id), '1');
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
        $update = $this->db->update('res_album', $data);
        
        //删除term
        $this -> deleteTerms($ids, '1');
        return $update;
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
        return $this->db->update('res_album', $data);
    }
    
    public function sold_out_batch() {
        $ids = get_request_field_array(array('ids'), $this)['ids'];
        if (empty($ids)) {
            return FALSE;
        }
        $data = array(
            'publish_status' => '2',
            'sold_out_time' =>  date('YmdHis')
        );
        $this->db->where_in('id', $ids);
        return $this->db->update('res_album', $data);
    }
    
}