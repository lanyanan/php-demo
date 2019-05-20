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
}