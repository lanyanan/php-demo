<?php
class Res_information extends Api_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('res/res_information_model');
        
    }

    public function index()
    {
        $data = $this->res_information_model->get();
        $this -> response_page($data);
    }
    
    public function list_data($publish)
    {
        $data = $this->res_information_model->get($publish);
        $this -> response_page($data);
    }
    
    public function detail($id = NULL)
    {
        $data = $this->res_information_model->detail($id);
        $this -> response_found($data);
    }
    
    public function add() {
        $data = $this->res_information_model->add();
        if (empty($data)) {
            $this -> response_message($data, '0', '新增失败'); 
        } else {
            $this -> response_message($data, '1', '新增成功'); 
        }
    }
    
    public function edit($id = NULL) {
        $data = $this->res_information_model->edit($id);
        if (empty($data)) {
            $this -> response_message($data, '0', '修改失败'); 
        } else {
            $this -> response_message($data, '1', '修改成功'); 
        }
    }
    
    public function delete($id = NULL) {
        $this->res_information_model->delete($id);
        $this -> response_message($id, '1', '删除成功');
    }
    
    public function delete_batch() {
        $data = $this -> res_information_model -> delete_batch();
        $this -> response($data);
    }
    
    public function publish_batch() {
        $data = $this -> res_information_model -> publish_batch();
        $this -> response($data);
    }
    
    public function sold_out_batch() {
        $data = $this -> res_information_model -> sold_out_batch();
        $this -> response($data);
    }
    
}