<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('sys/sys_user_model');
        $this -> load -> library('session');
        $this->load->library('encryption');
        $this->load->model('sys/sys_random_model');
        $this->load->model('sys/sys_token_model');
        $this->load->helper('Api_request_helper');
        
    }
    
    public function index() {
        $this -> load -> view('login');
    }
    
    //登录认证
    function check() {
        $username = $this-> input->post('username');
        $password = $this-> input->post('password');
        $user = $this -> sys_user_model -> get_by_username($username);
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $user['password'] = '';
                //重新封装用户数据
                $data = array('user' => array('id' => $user['id'], 'nick_name' => $user['nick_name'], 'login_name' => $user['login_name']
                    , 'user_sex' => $user['user_sex'], 'mobile' => $user['mobile'], 'imageUrl' => $user['imageUrl']
                    , 'is_system_user' => $user['is_system_user'], 'district_name' => $user['name'], 'email' => $user['email']
                ));
                $this -> sys_user_model -> flushField('login_time', $user['id']);

                //生成tocker
                $token = $this -> generateTocken($username);
                $data['token'] = $token;
                $this -> session -> set_tempdata($data, NULL, 3600);
                echo json_encode(array('code' => '1', 'msg' => '登陆成功', 'data' => $data), JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(array('code' => '0', 'msg' => '登录名或密码错误', 'data' => ''), JSON_UNESCAPED_UNICODE);
            }
        } else {
            echo json_encode(array('code' => '0', 'msg' => '登录名或密码错误', 'data' => ''), JSON_UNESCAPED_UNICODE);
        }
    }
    
    function is_login() {
        $this -> load -> library('session');
        $data = $this -> session -> tempdata('user');
        if ($data) {
            echo json_encode(array('code' => '1', 'msg' => '用户已登录', 'data' => $data), JSON_UNESCAPED_UNICODE);;
        } else {
            echo json_encode(array('code' => '1', 'msg' => '用户未登录', 'data' => $data), JSON_UNESCAPED_UNICODE);;
        }
    }
    
    function logout() {
        $user = $this->session->tempdata('user');
        $this->session->sess_destroy();  
        //删token
        $this-> sys_token_model -> delete_token($user['login_name'], $token); 
        $this -> load -> view('login');
    }
    
    public function getToken($key = NULL) {
        $token_key = $this -> sys_random_model -> detail('token_key')['key_value'];
        if($token_key != $key) {
            echo json_encode(array('code' => '1', 'msg' => '无效key值', 'data' => ''), JSON_UNESCAPED_UNICODE);
            return;
        }
        $token = $this -> generateTocken($key);
        echo json_encode(array('code' => '1', 'msg' => '成功获取token', 'data' => $token), JSON_UNESCAPED_UNICODE);
    }
    
    /**
             * 生成token，key可以用户名，也可以是数据库sys_random表中token
     * @return boolean
     */
    public function generateTocken($key)
    {
        $ip = ip();
        $time = time();
        $header = array(
            'typ' => 'JWT'
        );
        $array = array(
            'iss' => 'dawn', // 权限验证作者
            'key' => $key.$ip, // 案例
            'iat' => $time
        );
        $token = base64_encode(json_encode($header)) . '.' . base64_encode(json_encode($array)); // 数组转成字符
        $token = urlencode($token); // 通过url转码
        $this-> sys_token_model -> save_token($key.$ip, $token); // 将用户token存放进用户数据库
        return $token;
    }
}