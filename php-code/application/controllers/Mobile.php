<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mobile extends API_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('res/res_view_model');
        $this->load->model('msg/msg_term_model');
        $this->load->model('res/res_album_model');
        $this->load->model('res/res_video_model');
        $this->load->model('msg/msg_search_model');
    }

    public function index()
    {
        $this->home();
    }
    
    /**
     * 图集详情
     * @param unknown $id
     */
    public function res_album($id)
    {
        $data = $this->res_album_model->detail($id);
        $data = $this -> moreData($data);
//         echo json_encode($data);
        $this->load->view('details', $data);
    }
    
    /**
     * 视频详情
     * @param unknown $id
     */
    public function res_video($id)
    {
        $data = $this->res_video_model->detail($id);
        $data = $this -> moreData($data);
        $this->load->view('video_details', $data);
    }
    
    /**
     * 详情下面的更多数据，关键词
     */
    protected function moreData($data) {
        //分页
        $result = $this->res_view_model->get();
        $page = $this -> input->get('page');
        $limit = $this -> input->get('limit');
        $this->load->library('page',array('count'=> $result['count'], 'url'=> '/mobile/result_template','limit'=> $limit,'page'=>$page));
        $data['page']= $this-> page -> page_nums();
        $data['data'] = $result;
        $term = $this -> msg_term_model->get();
        $data['term'] = $term;
        return $data;
//         echo json_encode($data);
    }
    
    /**
     * @param string $type  0推荐  1热门 2更多
     */
    public function home($type = '0')
    {
        //分页
        $data = $this->res_view_model->get($type);
        $page = $this -> input->get('page');
        $limit = $this -> input->get('limit');
        //封装分页（加载更多）按钮
        $this->load->library('page',array('count'=> $data['count'], 'url'=> '/mobile/home_template/'.$type,'limit'=> $limit,'page'=>$page));
        $data['page']= $this-> page -> page_nums();
        $data['type'] = $type;
        $this->load->view('home', $data);
    }
    
    /**
     * @param string $type  0推荐  1热门 2更多
     */
    public function home_template($type = '0')
    {
        //分页
        $data = $this->res_view_model->get($type);
        $page = $this -> input->get('page');
        $limit = $this -> input->get('limit');
        $this->load->library('page',array('count'=> $data['count'], 'url'=> '/mobile/home_template/'.$type,'limit'=> $limit,'page'=>$page));
        $data['page']= $this-> page -> page_nums();
        $data['type'] = $type;
        $this->load->view('template', $data);
    }
    
    /**
     * @param string $type  NULL 全部  0视频  1图集
     */
    public function result($type = NULL)
    {
        $data = $this->res_view_model->get(NULL, $type);
        
        $title = $this -> input->get('title');
        $term_name = $this -> input->get('term_name');
        
        $this -> msg_search_model -> add($title);
        
        //分页
        $page = $this -> input->get('page');
        $limit = $this -> input->get('limit');
        $term_id = $this -> input->get('term_id');
        if (is_numeric($type)) {
            $this->load->library('page',array('count'=> $data['count'], 'url'=> '/mobile/result_template/'.$type.'?&title='.$title.'&term_id='.$term_id.'&term_name='.$term_name,'limit'=> $limit,'page'=>$page));
        } else {
            $this->load->library('page',array('count'=> $data['count'], 'url'=> '/mobile/result_template?&title='.$title.'&term_id='.$term_id.'&term_name='.$term_name,'limit'=> $limit,'page'=>$page));
        }
        
        $term = $this -> msg_term_model->get();
        $data['term'] = $term;
        $data['type'] = $type;
        $data['title'] = empty($title) ? $term_name : $title;
        $data['page']= $this-> page -> page_nums();
        $this->load->view('result', $data);
    }
    
    /**
     * @param string $type  NULL 全部  0视频  1图集
     */
    public function result_template($type = NULL)
    {
        $data = $this->res_view_model->get(NULL, $type);
        
        $title = $this -> input->get('title');
        $term_name = $this -> input->get('term_name');
        
        $this -> msg_search_model -> add($title);
        //分页
        $page = $this -> input->get('page');
        $limit = $this -> input->get('limit');
        $term_id = $this -> input->get('term_id');
        if (is_numeric($type)) {
            $this->load->library('page',array('count'=> $data['count'], 'url'=> '/mobile/result_template/'.$type.'?&title='.$title.'&term_id='.$term_id.'&term_name='.$term_name,'limit'=> $limit,'page'=>$page));
        } else {
            $this->load->library('page',array('count'=> $data['count'], 'url'=> '/mobile/result_template?&title='.$title.'&term_id='.$term_id.'&term_name='.$term_name,'limit'=> $limit,'page'=>$page));
        }
        
        $term = $this -> msg_term_model->get();
        $data['term'] = $term;
        $data['type'] = $type;
        $data['title'] = empty($title) ? $term_name : $title;
        $data['page']= $this-> page -> page_nums();
        $this->load->view('template', $data);
    }
}
