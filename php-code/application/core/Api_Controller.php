<?php
abstract class Api_Controller extends CI_Controller { 
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('sys/sys_token_model');
		$this->load->model('sys/sys_random_model');
		$this->load->helper('Api_request_helper');
		
		$ip = ip();
		/*
		 * 提供两种验证方式：1、请求头token,2、session
		 */
		$token = @$_SERVER['HTTP_TOKEN'];
		$user = $this->session->tempdata('user');

		$key = empty($user) ?  $this -> sys_random_model -> detail('token_key')['key_value'] : $user['login_name'];
		$token_database = $this -> sys_token_model -> detail($key.$ip)['token'];
		//tokenbase是空 或者tokenbase ！= token
		if (empty($user) && (empty($token_database) || $token_database != $token)) {
		    echo json_encode(array('code' => '101', 'msg' => '用户没有登录', 'data' => ''), JSON_UNESCAPED_UNICODE);
		    exit ;
		}
		//重新刷新session
		$data = array('user' => $user);
		$this -> session -> set_tempdata($data, NULL, 3600);
		$this->load->helper(array('form', 'url'));
	}
	
	#返回json格式结果
	public function response($data) {
	    if(empty($data)) {
	        echo json_encode(array('code' => '0', 'msg' => '获取数据失败', 'data' => ''), JSON_UNESCAPED_UNICODE);
	    } else {
	        echo json_encode(array('code' => '1', 'msg' => '调用成功！', 'data' => $data), JSON_UNESCAPED_UNICODE);
	    }
	}
	
	#返回json格式结果，自己封装信息
	public function response_message($data, $status, $message) {
	    echo json_encode(array('code' => $status, 'msg' => $message, 'data' => $data), JSON_UNESCAPED_UNICODE);
    }

    #返回json格式结果，自己封装信息
	public function response_page($data) {
	    if (empty($data)) {
	        echo json_encode(array('code' => '0', 'msg' => '获取数据失败', 'data' => ''), JSON_UNESCAPED_UNICODE);
	    } else if (empty($data['count'])) {
	        echo json_encode(array('code' => '1', 'msg' => '未查到数据', 'data' => ''), JSON_UNESCAPED_UNICODE);
	    } else {
	        echo json_encode(array('code' => '1', 'msg' => '获取成功', 'data' => $data['data'], 'count' => $data['count']), JSON_UNESCAPED_UNICODE);
	    }
    }
    
    public function response_found($data) {
        if (empty($data))
        {
            $this -> response_message($data, '0', '没有查到相关信息');
        } else {
            $this -> response_message($data, '1', '调用成功');
        }
    }
}