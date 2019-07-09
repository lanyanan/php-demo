<?php
require_once APPPATH.'third_party/oss-sdk/autoload.php';
date_default_timezone_set('PRC'); 
use OSS\OssClient;
use OSS\Core\OssException;

class Upload_oss extends Api_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('sys/sys_config_model');
    }
    
    /**
     * [testImg 上传文件到OSS]
     */
    public function upload($type = NULL){
//         echo '{"code":"1","msg":"上传成功！","data":{"file_type":"image\/png","file_path":"dawn\/img\/2019\/06\/13\/20190613193858645.png","file_name":"20190613193858645.png","original_name":"资源_5110.png","file_url":"https:\/\/zzj-file.oss-cn-shenzhen.aliyuncs.com\/dawn\/img\/2019\/06\/13\/20190613193858645.png"}}';
        $config = $this -> get_config($type);
        //OSS配置数据
        $endpoint =  $this->sys_config_model->detail('oss_url')['prop_value'];
        $accessKeyId =  $this->sys_config_model->detail('oss_access_key_id')['prop_value'];
        $accessKeySecret =  $this->sys_config_model->detail('oss_access_key_secret')['prop_value'];
        $bucket =  $this->sys_config_model->detail('oss_res_bucket')['prop_value'];
        
        $this->load->library('upload', $config);
        if($this->upload->do_upload('file')) {
            // 获取文件名
            $file_ext= $this->upload->data('file_ext');
            $original_name = $this->upload->data('file_name');
            $object =  $config['upload_path'].$original_name;
            $config['file_name'] = date('YmdHis').rand(111,999).$file_ext;
            $src=$config['upload_path'].$config["file_name"];

            //获取上传对象
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            $ossClient->setTimeout(3600);
            $ossClient->setConnectTimeout(20);
            
            try{
                //设置超时时间
                $ch = curl_init();
                curl_setopt ($ch, CURLOPT_URL, $endpoint);
                curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
                //设置curl默认访问为IPv4
                if(defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4')){
                    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                }
                //设置curl总执行动作的最长秒数，如果设置为0，则无限
                curl_setopt ($ch, CURLOPT_TIMEOUT,10000*3);
                $file_contents = curl_exec($ch);
                
                //上传文件
                $result = $ossClient->uploadFile($bucket, $src, $object);
            } catch(OssException $e) {
                $this -> response_message($e->getMessage(), '0', '上传失败，请重试');
                exit;
            }
            $data['file_type'] = $this->upload->data('file_type'); 
            $data['file_path'] = $src;
            $data['file_name'] = $config['file_name'];
            $data['original_name'] = $original_name;
            //$data['file_url'] = $this -> signatureurl($src);
            $data['file_url'] = $this -> getUrl($src);
            
            $this -> response_message($data, '1', '上传成功！'); 
            exit;
        } else {
            //获取上传失败以后的错误提示
            $info=$this->upload->display_errors();
            $this -> response_message($info, '0', '上传失败，请重试');
            exit;
        }
    }
    
    /**
     * 生成config
     */
    private function get_config($type) {
        $config = array();
        $config['max_size'] = 100 * 1024;
        if ($type == 'img') {
            $config['upload_path']      = 'dawn/img/'.date('Y').'/'.date('m').'/'.date('d').'/';
            $config['allowed_types']    = 'jpg|png|JPG|PNG';
        } else if ($type = 'video') {
            $config['upload_path']      = 'dawn/video/'.date('Y').'/'.date('m').'/'.date('d').'/';
            $config['allowed_types']    = 'mp4|MP4|avi|AVI|rmvb|RMVB|flv|FLV';
        }
        if(!is_dir($config['upload_path'])){
            if(!is_dir('dawn/')){
                mkdir('dawn/', 0777);
            }
            if(!is_dir('dawn/'.$type.'/')){
                mkdir('dawn/'.$type.'/', 0777);
            }
            if(!is_dir('dawn/'.$type.'/'.date('Y').'/')){
                mkdir('dawn/'.$type.'/'.date('Y').'/', 0777);
            }
            if(!is_dir('dawn/'.$type.'/'.date('Y').'/'.date('m').'/')){
                mkdir('dawn/'.$type.'/'.date('Y').'/'.date('m').'/', 0777);
            }
            if(!is_dir('dawn/'.$type.'/'.date('Y').'/'.date('m').'/'.date('d').'/')){
                mkdir('dawn/'.$type.'/'.date('Y').'/'.date('m').'/'.date('d').'/', 0777);
            }
            if(!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777);
            }
        }
        return $config;
    }
    
    /**
     * 不使用签名
     * @param unknown $path
     */
    private function getUrl($path){
        $url =  $this->sys_config_model->detail('oss_outnet_url')['prop_value'];
        return $url.$path;
    }
    
    /**
     * 获取签名url
     */
    private function signatureurl($path){
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