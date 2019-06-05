<?php

class res_information_model extends Api_Model
{

    public function get($publish = NULL)
    {
        $queryField = 't.*, dic_content_category.content_category_name, st.like_count, st.collect_count';
        $this->simpleQuery($queryField, TRUE);
        $this->db->join('statis_res_like_collect st', 't.id = st.res_id and st.res_type = "2"', 'left');

        $this->find_list_by_publis_status($publish);
        $this->searchByVideoOrAlbumRequest();
        $this->not_delete();

        return $this->getCountPage('res_information');
    }

    protected function simpleQuery($queryField, $countQuery = FALSE)
    {
        $this->db->select($queryField);
        if ($countQuery === FALSE) {
            $this->db->from('res_information t');
        }
        $this->db->join('dic_content_category', 'dic_content_category.id = t.content_category_id', 'left');
    }

    public function detail($id)
    {
        $queryField = 't.*, dic_content_category.content_category_name';
        $this->simpleQuery($queryField);
        $this->db->where('t.id', $id);
        $this->not_delete();
        $row_data = $this->db->get()->row_array();
        // 查询关联图片
        if (!empty($row_data['cover_id'])) {
            $this->db->select(" * ");
            $this->db->from('res_image t');
            $this->db->where('t.id', $row_data['cover_id']);
            $this->not_delete();
            $result_array = $this->db->get()->row_array();
            $result_array['attach_url'] = $this->signatureurl($result_array['attach_path']);
            $row_data['image'] = $result_array;    
        }
        return $row_data;
    }

    public function add()
    {
        $images = get_request_field_array(array(
            'images'
        ))['images'];
        $count = 0;
        foreach ($images as $k => $val) {
            $images[$k]["order_num"] = $count ++;
        }
        $this->db->insert('res_image', $images[0]);
        $imageId = $this->db->insert_id('id');

        $fields = array(
            'title',
            'description',
            'terms',
            'publish_type',
            'content_category_id',
            'source',
            'publish_time',
            'author',
            'publish_status', 'source_url'
        );
        $data = get_request_field_array($fields, $this);
        $data['cover_id'] = $imageId;

        if ($data['publish_status'] == '1') {
            $data['publish_time'] = date('YmdHis');
        }
        $this->db->insert('res_information', $data);
        $id =  $this->db->insert_id('id');
        //关键词保存
        $this -> saveTerms(@$data['terms'], $id, '2');
        return $id;
    }

    public function edit($id = null)
    {
        $images = get_request_field_array(array(
            'images'
        ))['images'];
        $count = 0;
        foreach ($images as $k => $val) {
            $images[$k]["order_num"] = $count ++;
        }
        $imageId = $images[0]['id'];
        if (!empty( $imageId)) {
            $this->db->where('id', $imageId);
            $this->db->update('res_image', $images[0]);
        } else {
            $this->db->insert('res_image', $images[0]);
            $imageId = $this->db->insert_id('id');
        }
        
        
        $fields = array(
            'title',
            'description',
            'terms',
            'publish_type',
            'content_category_id',
            'source',
            'publish_time',
            'author',
            'publish_status', 'source_url'
        );
        $data = get_request_field_array($fields);
        $data['cover_id'] = $imageId;
        if ($data['publish_status'] == '1') {
            $data['publish_time'] = date('YmdHis');
        }
        $this->db->where('id', $id);
        $update = $this->db->update('res_information', $data);
        //关键词保存
        $this -> saveTerms(@$data['terms'], $id, '2');
        return $update;
    }

    public function delete($id = null)
    {
        $data = array(
            'is_delete' => '1'
        );
        $this->db->where('id', $id);
        $this->db->update('res_information', $data);
        //删除term
        $this -> deleteTerms(array($id), '2');
    }

    public function delete_batch()
    {
        $ids = get_request_field_array(array(
            'ids'
        ), $this)['ids'];
        if (empty($ids)) {
            return FALSE;
        }
        $data = array(
            'is_delete' => '1'
        );
        $this->db->where_in('id', $ids);
        $update = $this->db->update('res_information', $data);
        //删除term
        $this -> deleteTerms($ids, '2');
        return $update;
    }

    public function publish_batch()
    {
        $ids = get_request_field_array(array(
            'ids'
        ), $this)['ids'];
        if (empty($ids)) {
            return FALSE;
        }
        $data = array(
            'publish_status' => '1',
            'publish_time' => date('YmdHis')
        );
        $this->db->where_in('id', $ids);
        return $this->db->update('res_information', $data);
    }

    public function sold_out_batch()
    {
        $ids = get_request_field_array(array(
            'ids'
        ), $this)['ids'];
        if (empty($ids)) {
            return FALSE;
        }
        $data = array(
            'publish_status' => '2',
            'sold_out_time' => date('YmdHis')
        );
        $this->db->where_in('id', $ids);
        return $this->db->update('res_information', $data);
    }
}