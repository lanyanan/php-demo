<?php
class Res_video extends Api_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('res/res_video_model');
        
    }

    public function index()
    {
        $data = $this->res_video_model->get();
        $this -> response_page($data);
    }
    
    public function detail($id = NULL)
    {
        $data = $this->res_video_model->detail($id);
        $this -> response_found($data);
    }
    
    public function add($isPublish = NULL) {
        $data = $this->res_video_model->add($isPublish);
        if (empty($data)) {
            $this -> response_message($data, '0', '新增失败'); 
        } else {
            $this -> response_message($data, '1', '新增成功'); 
        }
    }
    
    public function edit($id = NULL, $isPublish = NULL) {
        $data = $this->res_video_model->edit($id, $isPublish);
        if (empty($data)) {
            $this -> response_message($data, '0', '修改失败'); 
        } else {
            $this -> response_message($data, '1', '修改成功'); 
        }
    }
    
    public function delete($id = NULL) {
        $this->res_video_model->delete($id);
        $this -> response_message($id, '1', '删除成功');
    }
    
    public function delete_batch() {
        $data = $this -> res_video_model -> delete_batch();
        $this -> response($data);
    }
    
}