<?php
abstract class Api_Controller extends CI_Controller { 
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url_helper');
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
	    echo json_encode(array('msg' => $status, 'msg' => $message, 'data' => $data), JSON_UNESCAPED_UNICODE);
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