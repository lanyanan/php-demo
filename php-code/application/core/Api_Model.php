<?php
require_once APPPATH.'third_party/oss-sdk/autoload.php';

use OSS\OssClient;
use OSS\Core\OssException;

abstract class Api_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('Api_request_helper');
        $this->load->model('sys/sys_config_model');
        $this->load->library('session');
    }
    
    protected function deleteTerms($resourceIds, $resType) {
        $this->db->where_in('res_id', $resourceIds);
        $this->db->where('res_type', $resType);
        $this->db->delete('msg_resource_term');
    }
    
    protected function saveTerms($terms, $resourceId, $resType) {
        if (empty($terms)) {
            return;
        }
        //本资源已包含的关键词
        $this->db->select(' t.id , k.name');
        $this->db->where('res_id', $resourceId);
        $this->db->where('res_type', $resType);
        $this->db->from('msg_resource_term t');
        $this->db->join('msg_term_keyword k ', 'k.id = t.term_id', 'left');
        $sourceTerms = $this->db->get() -> result_array();//a,b,c（旧的）
        
        $termArray = explode(',',$terms);//a,b,d(新的)
        //把已有的关键词和$term进行对比，c删掉，a,b不变，d新增
        $databaseTerms = array();
        foreach($sourceTerms as $k => $v) {
            $name = $sourceTerms[$k]['name'];
            if (!in_array($sourceTerms[$k]['name'], $termArray)) {
                //不在就删了
                $this->db->where('id', $sourceTerms[$k]['id']);
                $this->db->delete('msg_resource_term');
            } else {
                array_push($databaseTerms, $sourceTerms[$k]['name']);
            }
        }
        foreach ($termArray as $term) {
            //先查询有没有该关键词
            $this->db->select(' * ');
            $this->db->where('name', $term);
            $this->db->from('msg_term_keyword t');
            $data = $this->db->get()->row_array();
            
            if (empty($data)) {
                //没有的话新增，并更新关联表
                $data = array('name' => $term);
                $this->db->insert('msg_term_keyword', $data);
                $data['id'] = $this->db->insert_id('id');
            }
            //关联表有了就不更新
            if (in_array($term, $databaseTerms)) {
                continue;
            }
            $resourceTerm = array('term_id' => $data['id'], 'res_type' => $resType, 'res_id' => $resourceId);
            $this->db->insert('msg_resource_term', $resourceTerm);
        }
        return;
        
    }
    
    protected function not_delete($tableAlias = FALSE) {
        if ($tableAlias === FALSE) {
           return $this->db->where('t.is_delete', 0);
        } 
        return $this->db->where($tableAlias.'.is_delete', 0);
    }
    
    /**
            * 已发布
     * @param boolean $tableAlias
     * @return unknown
     */
    protected function publish($tableAlias = FALSE) {
        if ($tableAlias === FALSE) {
            return $this->db->where('t.publish_status', '1');
        }
        return $this->db->where($tableAlias.'.publish_status', '1');
    }
    
    protected function getCountPage($table) {
        $query = array();
        $query['count'] = $this->db->count_all_results($table.' t', FALSE);
        $data = get_limit($this);
        $this->db->limit($data['end'], $data['begin']);
        $query['data'] = $this->db->get() -> result_array();
        return $query;
    }
    
    //标题，类型，来源，作者，内容分类
    protected function searchByVideoOrAlbumRequest() {
        $fields = array('title', 'publish_type', 'source', 'author', 'content_category_id', 'area', 'style', 'res_type','floor_area','house_type_id');
        $data = get_request_field_array($fields, $this);
        if (empty($data)) {
            foreach ($fields as $field) {
                $data[$field] = $this->input->get($field);
            }
        }
        if (!empty(@$data['title'])) {
            $this->db->like('t.title', $data['title']);
        }
        if (is_numeric(@$data['publish_type'])) {
            $this->db->where('t.publish_type', $data['publish_type']);
        }
        if (!empty(@$data['source'])) {
            $this->db->like('t.source', $data['source']);
        }
        if (!empty(@$data['author'])) {
            $this->db->like('t.author', $data['author']);
        }
        if (is_numeric(@$data['content_category_id'])) {
            $this->db->where('t.content_category_id', $data['content_category_id']);
        }
        if (is_numeric(@$data['res_type'])) {
            $this->db->where('t.res_type', $data['res_type']);
        }
        if (is_numeric(@$data['style'])) {
            $this->db->where('t.style', $data['style']);
        }
        if (is_numeric(@$data['floor_area'])) {
            $this->db->where('t.floor_area', $data['floor_area']);
        }
        if (is_numeric(@$data['house_type_id'])) {
            $this->db->where('t.house_type_id', $data['house_type_id']);
        }
    }
    
    /**
     * 获取视频封面图签名url
     */
    protected function signatureVideoCoverurl($path){
        //OSS配置数据
        $endpoint =  $this->sys_config_model->detail('oss_url')['prop_value'];
        $accessKeyId =  $this->sys_config_model->detail('oss_access_key_id')['prop_value'];
        $accessKeySecret =  $this->sys_config_model->detail('oss_access_key_secret')['prop_value'];
        $bucket =  $this->sys_config_model->detail('oss_res_bucket')['prop_value'];
        $expire =  $this->sys_config_model->detail('oss_expire_time')['prop_value'];
        
        $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
       $options = array(
            OssClient::OSS_PROCESS => "video/snapshot,t_100,m_fast" );
        $signUrl = $ossClient -> signUrl($bucket, $path, $expire, 'GET', $options);
        return urldecode($signUrl);
    }
    
    /**
     * 获取签名url
     */
    protected function signatureurl($path){
        //OSS配置数据
        $endpoint =  $this->sys_config_model->detail('oss_url')['prop_value'];
        $accessKeyId =  $this->sys_config_model->detail('oss_access_key_id')['prop_value'];
        $accessKeySecret =  $this->sys_config_model->detail('oss_access_key_secret')['prop_value'];
        $bucket =  $this->sys_config_model->detail('oss_res_bucket')['prop_value'];
        $expire =  $this->sys_config_model->detail('oss_expire_time')['prop_value'];
        
        $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
        $signUrl = $ossClient -> signUrl($bucket, $path, $expire, 'GET');
        return urldecode($signUrl);
    }
    
    /**
     *  根据发布状态查找
     */
    function find_list_by_publis_status($publish) {
        if ($publish == 'wait_publish') {
            $this->db->order_by('gmt_create', 'DESC');
            $this->db->where('t.publish_status', 0)  ;
        } else if  ($publish == 'publish'){
            $this->db->order_by('publish_time', 'DESC');
            $this->db->where('t.publish_status', 1)  ;
        } else if  ($publish == 'sold_out'){
            $this->db->order_by('sold_out_time', 'DESC');
            $this->db->where('t.publish_status', 2)  ;
        }
    }
}