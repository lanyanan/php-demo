<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('PRC'); 
class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('sys/sys_user_model');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->model('sys/sys_random_model');
        $this->load->model('sys/sys_token_model');
        //$this->load->helper('Api_request_helper');
    }

    public function index()
    {
        $this->load->view('login');
    }

    // 登录认证
    function check()
    {
        // $public_key = "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAupXmT0T8HC3ea37YqwEOap82kAD5Ff+fIp7d8GrXAETElICqvjRTpzaNI+LCc4wSLajqUkZRAOPBlbOt9aL2ZE1TuZdbDljtoXFZYhMGuFJqYZzg6PsKKoNiCNDl+N9RxFB/wLAngS85U64lGUiaP8wZFrMPel44gEOtvStpvYyUoH1sSwEmvLnMYDhGNmX6vJuwurwYR18+F+J004Cy2wUqYFebKXA9QNkE07WCsbL2u9YubDqcf99W7si4wLdiI0gvwiuAxhxSrsU6eP6QAoao5z0HKMYASleNmlGP62tWqg5HpJMslChr67n/FlKWgVhANWxC9hSh3JABTCIYDwIDAQAB";
        $password = $this->input->post('password');
        // 密码解密
        //$password = $this->decode($password);

        $username = $this->input->post('username');
        $user = $this->sys_user_model->get_by_username($username);
        
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $user['password'] = '';
                // 重新封装用户数据
                $data = array(
                    'user' => array(
                        'id' => $user['id'],
                        'nick_name' => $user['nick_name'],
                        'login_name' => $user['login_name'],
                        'user_sex' => $user['user_sex'],
                        'mobile' => $user['mobile'],
                        'imageUrl' => $user['imageUrl'],
                        'is_system_user' => $user['is_system_user'],
                        'district_name' => $user['name'],
                        'email' => $user['email']
                    )
                );
                $this->sys_user_model->flushField('login_time', $user['id']);
                // 生成tocker
                $token = $this->generateTocken($username);
                $data['token'] = $token;
                $this->session->set_tempdata($data, NULL, 3600);
                echo json_encode(array(
                    'code' => '1',
                    'msg' => '登陆成功',
                    'data' => $data
                ), JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(array(
                    'code' => '0',
                    'msg' => '登录名或密码错误',
                    'data' => ''
                ), JSON_UNESCAPED_UNICODE);
            }
        } else {
            echo json_encode(array(
                'code' => '0',
                'msg' => '登录名或密码错误',
                'data' => ''
            ), JSON_UNESCAPED_UNICODE);
        }
    }

    private function decode($password)
    {
        $private_key = '-----BEGIN RSA PRIVATE KEY-----
MIIEowIBAAKCAQEAo3B+tB0SAStPKkMR1iKHWpuBog/uKjyza4MxOKNICpZ3rhNk73ciF3xUr8/48WRCgk6wu5Co8uC99AGavI6JQPJLRnT8wBZXQVufSKzvw0iinQE5c9/McjdQFROWcaDxfhWuaKzX3gFKLmd/ZuqWDa3EGV4ZdiV3x3mui+ILXBxwWB1f08fo83lEuU97Wr9MtQh0ixdGIgErV4VxToOeqTObM2xpruYqRN7ZQc4fNA7k20Nx2DWlHS0uQgnSXYTwPrGQ4nMw8MGi2djpgLOTKEnrJ3ThsNpoCuy4b6kA/TML8yDmGazUnYr7Xxd7T4DV90klpd4/hWU1/X6u7sQURQIDAQABAoIBAEEI3IITJzzr3N52Pby1lKKLSnQQXrbT3JklZQqifmIoKYtNEFbxUtGBmbkzyl1ThduQMGcSUwgCQdO8Z7QsC5WaVDW/C2vr9+B78s/acLWGS56qBBCFtzajp+wbFTw1zKJdQj9It8URQlFgwaNUKU1cHbHybbNDiXwIgVoMInUOAPEKev1YczYd5xq1ANr9TYoFumPnKkzFivGEGQ0ZL4R4+xQb0UKU/Dhc3EOkI7hpS4tD5EYlmSviTPA+Pl+Rlu9s9DMyz0INlprnhe/tI2hicYjZkQEZDR2SqUCgf1e7t/lCI7DmN1oeGMPcuq/3HniFnyELmi7vsmB6EWObLgECgYEA1vZNVGWdIhBGlQy9hnURhY8na2QiUCo2/LhCzcZGlEHDVPrnEoBllmegIcm1Px9nzn+zf5wso6pBIibk15cpYGeJU7UVl5QL0GGeli7d0kNLgwCBKz/kFVIfZ6mcvT0zKASkbYSFvsxOlYDq93UXjEcjb72VOO0j2QauEpGzBkECgYEAwqQo3aqku/I05I999Fj28koIBg3Af5Q//ECE1krcsYbn8b9GmS9sMLPJyygRQ4nBiLJ3HU9RAhAIpSSiqqcaBUcMjz5MoZ6NaP5/29YOL7rSmwJ2WtNEINPHz2B3lMZZsknq+mh80mSXDmvLbCYZl3Cc2Xn/Sk4Z4xkNGkaZtQUCgYAwTSvXGPYT32BcwX4cplWHk0EiSl/Db5jndGfeYP0e9x/zCmW9rIgnIaXDsdU+F8p1hhBJTkhhhjIYgHDPWLH9bYZX/sqZQrTc3/KIgINraZ+gEg70LukLOWbBHkWP6B6EkXZ4/VwoITRPN6aUcAUYiiuWQh0zq2VwsKWQmpiFgQKBgQCQTbyuevEfFnb4bRnoqnyLLS+9rTxmWbcGgZ76cQ4l3+reY/0nXO1NPj4BjHcgJ2WAvy9oX4GjkdeW+A5RjwnPl9lL6dhOioo0qVqJ1a023b9+hNjShYcg/2JH8TE278dYU00O0aCZK1KCspBiYezfRfJDmhsXL8gpgk0gie8zMQKBgDocQyFC5a1MH/Gzh9QfOTpf8dZGzSqLUvQ2yZDLCqNbq9L0BbOsvedacC1IpsTXe5f+j70hjZUrvFYNDwfW/fIoaswTycU1bHCnk7oTwIu5m29aC+aXhSj0WZ8QjI4PVO9rytPXNQdBKsoWWGd8la0gx/bl/GsHDLVdp0u1tltZ
-----END RSA PRIVATE KEY-----';
        openssl_private_decrypt(base64_decode($password), $decrypted, $private_key);
        return $decrypted;
    }

    function is_login()
    {
        $this->load->library('session');
        $data = $this->session->tempdata('user');
        if ($data) {
            echo json_encode(array(
                'code' => '1',
                'msg' => '用户已登录',
                'data' => $data
            ), JSON_UNESCAPED_UNICODE);
            ;
        } else {
            echo json_encode(array(
                'code' => '1',
                'msg' => '用户未登录',
                'data' => $data
            ), JSON_UNESCAPED_UNICODE);
            ;
        }
    }

    function logout()
    {
        $user = $this->session->tempdata('user');
        $this->session->sess_destroy();
        // 删token
        $this->sys_token_model->delete_token($user['login_name'], $token);
        $this->load->view('login');
    }

    public function getToken($key = NULL)
    {
        $token_key = $this->sys_random_model->detail('token_key')['key_value'];
        if ($token_key != $key) {
            echo json_encode(array(
                'code' => '1',
                'msg' => '无效key值',
                'data' => ''
            ), JSON_UNESCAPED_UNICODE);
            return;
        }
        $token = $this->generateTocken($key);
        echo json_encode(array(
            'code' => '1',
            'msg' => '成功获取token',
            'data' => $token
        ), JSON_UNESCAPED_UNICODE);
    }

    /**
     * 生成token，key可以用户名，也可以是数据库sys_random表中token
     *
     * @return boolean
     */
    public function generateTocken($key)
    {
        $ip = ip();
        $time = date('YmdHis');
        $header = array(
            'typ' => 'JWT'
        );
        $array = array(
            'iss' => 'dawn', // 权限验证作者
            'key' => $key . $ip, // 案例
            'iat' => $time
        );
        $token = base64_encode(json_encode($header)) . '.' . base64_encode(json_encode($array)); // 数组转成字符
        $token = urlencode($token); // 通过url转码
        $this->sys_token_model->save_token($key . $ip, $token); // 将用户token存放进用户数据库
        return $token;
    }
}