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
    }
    
    protected function not_delete($tableAlias = FALSE) {
        if ($tableAlias === FALSE) {
           return $this->db->where('t.is_delete', 0);
        } 
        return $this->db->where($tableAlias.'.is_delete', 0);
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
        $fields = array('title', 'publish_type', 'source', 'author', 'content_category_id');
        $data = array();
        foreach ($fields as $field) {
            $data[$field] = $this-> input->get($field);
        }
        if (!empty($data['title'])) {
            $this->db->like('t.title', $data['title']);
        }
        if (is_numeric($data['publish_type'])) {
            $this->db->where('t.publish_type', $data['publish_type']);
        }
        if (!empty($data['source'])) {
            $this->db->like('t.source', $data['source']);
        }
        if (!empty($data['author'])) {
            $this->db->like('t.author', $data['author']);
        }
        if (is_numeric($data['content_category_id'])) {
            $this->db->where('t.content_category_id', $data['content_category_id']);
        }
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
        return $ossClient -> signUrl($bucket, $path, $expire, 'GET');
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