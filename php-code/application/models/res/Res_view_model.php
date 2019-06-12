<?php

class res_view_model extends Api_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get($type = NULL, $res_type = NULL)
    {
        $user = $this->session->tempdata('user');
        if (!empty($user['id'])) {
            $queryField = 't.*, dic_district.name as district_name, dic_content_category.content_category_name, st.like_count, st.collect_count, pv.page_view, ur.like as isLike, ur.collect as isCollect, ur.look as isLook, ur.oppose as isOppose';
        } else {
            $queryField = 't.*, dic_district.name as district_name, dic_content_category.content_category_name, st.like_count, st.collect_count, pv.page_view';
        }
        $this->simpleQuery($queryField, TRUE);
        
        //根据搜索查找
        $this -> searchByVideoOrAlbumRequest();
        
        //根据关键词查找
        $this -> searchByTermId();

        // 更多、推荐、热门 排序规则
        if ($type == '0') {
            $this->recommend();
        } else if ($type == '1') {
            $this->hot();
        } else if ($type == '2') {
            $this->more();
        }
        
        if (is_numeric($res_type)) {
            $this->db->where('t.res_type', $res_type);
        }

        $data = $this->getCountPage('res_view');
        //echo $this->db->last_query();
        foreach ($data['data'] as $k => $val) {
            $path = $data['data'][$k]['attach_path'];
            if ($data['data'][$k]['res_type'] == '0') {
                $data['data'][$k]["attach_url"] =  $this->signatureVideoCoverurl($path);
                $data['data'][$k]["play_url"] =  $this->signatureurl($path);
            }else {
                $data['data'][$k]["attach_url"] =  $this->signatureurl($path);
            }
        }
        return $data;
    }
    
    protected  function searchByTermId() {
        $term_id = @get_request_field_array(array('term_id'), $this)['term_id'];
        if (@!is_numeric($term_id)) {
            $term_id = $this-> input->get('term_id');
        }
        if (@is_numeric($term_id)) {
            $this->db->join('msg_resource_term m', 'm.res_id = t.id and m.res_type = t.res_type ', 'left');
            $this->db->where('m.term_id', $term_id);
        }
    }

    /**
     * 推荐根据关键词排序，关键词出现多的数据排到上面
     */
    protected function recommend()
    {
        $this->db->join('statis_resource_id_type m', 'm.res_id = t.id and m.res_type = t.res_type', 'left');
        $this->db->order_by(' m.count DESC');
    }

    /**
     * 热门根据浏览量，喜欢、收藏数量排序
     */
    protected function hot()
    {
        $this->db->order_by('st.collect_count DESC, st.like_count DESC, pv.page_view DESC');
    }

    /**
     * 更多不排序
     */
    protected function more()
    {}

    protected function simpleQuery($queryField, $countQuery = FALSE)
    {
        $this->db->select($queryField);
        if ($countQuery === FALSE) {
            $this->db->from('res_view t');
        }
        $this->not_delete();
        $this->publish();
        $this->db->join('dic_content_category', 'dic_content_category.id = t.content_category_id', 'left');
        $this->db->join('dic_district', 'dic_district.id = t.district_id', 'left');
        $this->db->join('statis_res_like_collect st', 't.id = st.res_id  and st.res_type = t.res_type', 'left');
        $this->db->join('statis_page_view pv', 't.id = pv.res_id and pv.res_type = t.res_type', 'left');

        // 个人是否点过暂，收藏
        // 获取当前用户
        $user = $this->session->tempdata('user');
        if (! empty($user['id'])) {
            $this->db->join('statis_user_record ur', 't.id = ur.res_id and ur.res_type = t.res_type and ur.user_id = ' . $user['id'] . ' ', 'left');
        }
    }

    public function detail($id)
    {
        $user = $this->session->tempdata('user');
        if (!empty($user['id'])) {
            $queryField = 't.*,  dic_district.name as district_name, dic_district.pid as districtPid, dic_content_category.content_category_name, ht.house_type_name, st.like_count, st.collect_count, pv.page_view, ur.like as isLike, ur.collect as isCollect, ur.look as isLook, ur.oppose as isOppose';
        } else {
            $queryField = 't.*,  dic_district.name as district_name, dic_district.pid as districtPid, dic_content_category.content_category_name, ht.house_type_name, st.like_count, st.collect_count, pv.page_view';
        }
        $res_type = get_request_field_array(array('res_type'), $this)['res_type'];
        $this->simpleQuery($queryField);
        $this->db->join('dic_house_type as ht', 'ht.id = t.house_type_id', 'left');
        $this->db->where('t.id', $id);
        $this->db->where('t.res_type', $res_type);
        $row_data = $this->db->get()->row_array();
        $row_data['attach_url'] = $this->signatureurl($row_data['attach_path']);
        return $row_data;
    }
}