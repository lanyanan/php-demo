<?php
class statis_res_like_collect_model extends Api_Model
{
    public function likeOrCollect($res_id) {
        $param = array('type', 'res_type');
        $param = get_request_field_array($param, $this);
        $type = $param['type'];
        $res_type = $param['res_type'];
        
        $this->db->select('*');
        $this->db->from('statis_res_like_collect');
        $this->db->where('statis_res_like_collect.res_id', $res_id);
        $this->db->where('statis_res_like_collect.res_type', $res_type);
        $query = $this->db->get() -> row_array();
        
        if (empty($query)) {
            //不存在就新建
            $query = array(
                'res_id' =>  $res_id,
                'res_type' => $res_type,
            );
            $this->db->insert('statis_res_like_collect', $query);
            $id = $this->db->insert_id();
            $query = $this->db->get_where('statis_res_like_collect', array('id' => $id)) ->row_array();
        }
        
        if ($type == '0') {
            $query['like_count'] = $query['like_count'] + 1;
        } else if ($type == '1') {
            $query['collect_count'] = $query['collect_count'] + 1;
        } else if ($type == '2') {
            $query['oppose_count'] = $query['oppose_count'] + 1;
        }
        
        $this->db->where('id', $query['id']);
        return $this->db->update('statis_res_like_collect', $query);
        
    }
    
    public function cancleLikeOrCollect($res_id) {
        $param = array('type', 'res_type');
        $param = get_request_field_array($param, $this);
        $type = $param['type'];
        $res_type = $param['res_type'];
        
        $this->db->select('*');
        $this->db->from('statis_res_like_collect');
        $this->db->where('statis_res_like_collect.res_id', $res_id);
        $this->db->where('statis_res_like_collect.res_type', $res_type);
        $query = $this->db->get() -> row_array();
        
        if ($type == '0') {
            $query['like_count'] = $query['like_count'] - 1;
        } else if ($type == '1') {
            $query['collect_count'] = $query['collect_count'] - 1;
        } else if ($type == '2') {
            $query['oppose_count'] = $query['oppose_count'] + 1;
        }
        
        $this->db->where('id', $query['id']);
        return $this->db->update('statis_res_like_collect', $query);
        
    }
}