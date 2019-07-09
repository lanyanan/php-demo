<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mobile extends Api_Controller
{
    
    public function phpinfo() {
        $this->load->view('phpinfo');
    }
    
     /*  public function get_redis($key) {
       $redis =connectRedis();
       echo json_encode($redis->sMembers($key));
    }
    
    public function set_redis($key) {
        $redis = connectRedis();
        $redis->sAdd($key, ip()); 
    }  */
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('res/res_view_model');
        $this->load->model('msg/msg_term_model');
        $this->load->model('res/res_album_model');
        $this->load->model('res/res_image_model');
        $this->load->model('res/res_video_model');
        $this->load->model('msg/msg_search_model');
    }

    public function index()
    {
        $this->home();
    }
    
    /**
     * 更多
     */
    public function moreSelect() {
        $this->load->model('dic/dic_house_type_model');
        $this->load->model('dic/dic_house_space_model');
        $this->load->model('dic/dic_content_category_model');
        $this->load->model('dic/dic_style_model');
        $data = array();
        $data['house_type'] = $this -> dic_house_type_model -> get_list();
        $data['house_space'] = $this -> dic_house_space_model -> get_list();
        $data['style'] = $this -> dic_style_model -> get_list();
        $data['search'] = $this -> msg_search_model -> get();
        $this->load->view('moreSelect', $data);
    }
    
    /**
     * 大家都爱搜
     */
    public function loveSearch() {
        $data =  array();
        $data['data'] = $this -> msg_search_model -> get();
        //echo json_encode($data);
        $this->load->view('loveSearch', $data);
    }
    
    /**
     * 图集详情
     * @param unknown $id
     */
    public function res_album($id)
    {
        $data = $this->res_album_model->detail($id);
        //不同ip访问作为一次喜欢
        saveRequestIpForLike($id, 'res_album');
        $data = getLike($data, 'res_album');
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
        //不同ip访问作为一次喜欢
        saveRequestIpForLike($id, 'res_video');
        $data = getLike($data, 'res_video');
        
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
        
        //echo json_encode($data);
        return $data;
    }
    
    /**
     * @param string $type  0推荐  1热门 2更多
     */
    public function home($type = '0')
    {
        $page = $this -> input->get('page');
        $limit = $this -> input->get('limit');

        log_message('info','page:'.$page."  limit:".$limit);
        //分页
        $data = $this->res_view_model->get($type);


        if (empty($page)){
            $page = 1;
        }
        if (empty($limit)){
            $limit = 10;
        }
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
     * 图片搜索页
     * @param string $type  NULL 全部  0视频  1图集
     */
    public function image_select()
    {
        $data = $this -> image_data();
        $this->load->view('image_select', $data);
    }
    
    public function image_select_template()
    {
        
        $data = $this -> image_data();
        $this->load->view('image_template', $data);
    }
    
    private function image_data(){
        $this->load->model('dic/dic_style_model');
        $term_name = $this->input-> get('term_name');
        $house_space_id = $this->input-> get('house_space_id');
        $style = $this->input-> get('style');
        
        //分页
        $page = $this -> input->get('page');
        $limit = $this -> input->get('limit');
        
        //列表数据
        $data = $this->res_image_model -> get($house_space_id, $style);
        
        //空间类型
        $this->load->model('dic/dic_house_space_model');
        $data['house_space_list'] = $this -> dic_house_space_model -> get_list();
        //分页
        $url = '/mobile/image_select_template?term_name='.$term_name.'&house_space_id='.$house_space_id;
        $this->load->library('page',array('count'=> $data['count'], 'url'=> $url,'limit'=> $limit,'page'=>$page));
        
        $data['house_space_id'] = $house_space_id;
        $data['style'] = $style;
        $data['showTitle'] = $term_name;
        $data['page']= $this-> page -> page_nums();
        //关键词
        $data['term'] = $this -> msg_term_model->get();
        $data['style_list'] = $this -> dic_style_model -> get_list();
        return $data;
    }
    
    
    /**
     * 搜索词搜索页
     * @param string $type  NULL 全部  0视频  1图集
     */
    public function result($type = NULL)
    {
        $data = $this->result_data($type);
        $this->load->view('result', $data);
    }
    
    /**
     * @param string $type  NULL 全部  0视频  1图集
     */
    public function result_template($type = NULL)
    {
        $data = $this->result_data($type);
        $this->load->view('template', $data);
    }
    
    /**
     * 组合搜索页
     * @param string $type  NULL 全部  0视频  1图集
     */
    public function select($type = NULL)
    {
        $data = $this->result_data($type);
        
        $this->load->model('dic/dic_house_type_model');
        $this->load->model('dic/dic_content_category_model');
        $this->load->model('dic/dic_style_model');
        $data['house_type_list'] = $this -> dic_house_type_model -> get_list();
        $data['style_list'] = $this -> dic_style_model -> get_list();
        $data['search'] = $this -> msg_search_model -> get();
        
        $this->load->view('select', $data);
    }
    
    private function result_data($type = NULL) {
        $data = $this->res_view_model->get(NULL, $type);
        
        /**
         * 获取前台参数返回给前台
         * @var unknown $title
         */
        $title = $this -> input->get('title');
        $floor_area= $this -> input->get('floor_area');
        $house_type_id= $this -> input->get('house_type_id');
        $style= $this -> input->get('style');
        $cost= $this -> input->get('cost');
        $term_name = $this -> input->get('term_name');
        
        if (!empty($title)) {
            $this -> msg_search_model -> add($title);
        }
        //分页
        $page = $this -> input->get('page');
        $limit = $this -> input->get('limit');
        $term_id = $this -> input->get('term_id');
        if (is_numeric($type)) {
            $url = '/mobile/result_template/'.$type.'?&title='.$title.'&term_id='.$term_id.'&term_name='.$term_name;
        } else {
            $url = '/mobile/result_template?&title='.$title.'&term_id='.$term_id.'&term_name='.$term_name;
        }
        //下一页的时候要带参数
        $url = $url.'&floor_area='.$floor_area.'&house_type_id='.$house_type_id.'&style='.$style.'&cost='.$cost;
        $this->load->library('page',array('count'=> $data['count'], 'url'=> $url,'limit'=> $limit,'page'=>$page));
        
        $term = $this -> msg_term_model->get();
        $data['floor_area'] = $floor_area;
        $data['house_type_id'] = $house_type_id;
        $data['style'] = $style;
        $data['cost'] = $cost;
        $data['term'] = $term;
        $data['type'] = $type;
        $data['showTitle'] =  empty($title) ? $term_name : $title;
        $data['title'] = $title;
        $data['page']= $this-> page -> page_nums();
        
        return $data;
    }
}
