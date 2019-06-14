<?php
date_default_timezone_set('PRC'); 
class LoginFilter
{
    protected $noNeedLogin = [
        'login',//登录controller
        'welcome',//欢迎页面
        'register',//注册接口
        'mobile',
        'statis_page_view/view_auto_increment',//浏览量自增接口
        'res_view',//前端列表接口
        'res_video/detail',//视频详情接口
        'res_album/detail',//图集详情接口
        'msg_term',//关键词接口
        'dic'//字典表接口
    ];
    
    public function checkLogin()
    {
        
        $uri = $_SERVER['REQUEST_URI'];
        foreach ($this -> noNeedLogin as $value) {
            if (strstr($uri,$value)){
                return;
            }
        }
        
        $this->CI = & get_instance();
        $class = $this->CI -> router->class;
        
        $this->CI->load->library('session');
        $this->CI->load->model('sys/sys_token_model');
        $this->CI->load->model('sys/sys_random_model');
        $this->CI->load->helper('Api_request_helper');

        $ip = ip();
        /*
         * 提供两种验证方式：1、请求头token,2、session
         */
        $token = $_SERVER['HTTP_TOKEN'];
        $user = $this->CI->session->tempdata('user');
        
        $token_database = $this->CI->sys_token_model->findByToken($token);
        $time = date('YmdHis');
        $preTime = $token_database['gmt_modified'];

        if (empty($token_database)) {
            $this->CI->sys_token_model->deleteByToken($token);
            echo json_encode(array(
                'code' => '101',
                'msg' => '用户没有登录',
                'data' => ''
            ), JSON_UNESCAPED_UNICODE);
            exit();
        }
        if (strtotime ($time) - strtotime ($preTime) > 3600) {
            $this->CI->sys_token_model->deleteByToken($token);
            echo json_encode(array(
                'code' => '101',
                'msg' => '用户没有登录',
                'data' => ''
            ), JSON_UNESCAPED_UNICODE);
            exit();
        }
        
        // 重新刷新session
        $this->CI->sys_token_model->updateByToken($token);
        $data = array(
            'user' => $user
        );
        $this->CI->session->set_tempdata($data, NULL, 3600);
    }
}