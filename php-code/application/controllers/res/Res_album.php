<?php
class Res_album extends Api_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('res/res_album_model');
        
    }

    public function index()
    {
        $data = $this->res_album_model->get();
        $this -> response_page($data);
    }
    
    public function detail($id = NULL)
    {
        $data = $this->res_album_model->detail($id);
        $this -> response_found($data);
    }
    
    public function add() {
        $data = $this->res_album_model->add();
        if (empty($data)) {
            $this -> response_message($data, '0', '新增失败'); 
        } else {
            $this -> response_message($data, '1', '新增成功'); 
        }
    }
    
    public function edit($id = NULL) {
        $data = $this->res_album_model->edit($id);
        if (empty($data)) {
            $this -> response_message($data, '0', '修改失败'); 
        } else {
            $this -> response_message($data, '1', '修改成功'); 
        }
    }
    
    public function delete($id = NULL) {
        $this->res_album_model->delete($id);
        $this -> response_message($id, '1', '删除成功');
    }
    
}