<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mobile extends API_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('res/res_view_model');
        $this->load->model('msg/msg_term_model');
    }

    public function index()
    {
        $this->load->view('mobile');
    }

    /**
     * @param string $type  0推荐  1热门 2更多
     */
    public function home($type = '0')
    {
        $data = $this->res_view_model->get($type);
        $data['type'] = $type;
        $this->load->view('home', $data);
    }
    
    /**
     * @param string $type  NULL 全部  0视频  1图集
     */
    public function result($type = NULL)
    {
        $data = $this->res_view_model->get(NULL, $type);
        
        $title = $this -> input->get('title');
        
        $term = $this -> msg_term_model->get();
        $result = array('data' => $data, 'term' => $term);
        $result['type'] = $type;
        $result['title'] = $title;
        $this->load->view('result', $result);
    }
}
