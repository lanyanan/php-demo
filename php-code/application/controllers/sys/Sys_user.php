<?php
class Sys_user extends Api_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('sys/sys_user_model');
        
    }

    public function index()
    {
        $data['sys_user'] = $this->sys_user_model->get();
        $this -> response($data['sys_user']);
    }
    
    public function detail($id = NULL)
    {
        $data = $this->sys_user_model->detail($id);
        $this -> response_found($data);
    }
    
    public function register() {
        $data = $this->sys_user_model->add();
        if ($data === TRUE) {
            $this -> response_message($data, '1', '注册成功'); 
        } else {
            $this -> response_message($data, '0', '注册失败'); 
        }
    }
    
    public function edit($id = NULL) {
        $data = $this->sys_user_model->edit($id);
        if ($data == TRUE) {
            $this -> response_message($data, '1', '修改成功'); 
        } else {
            $this -> response_message($data, '0', '修改失败'); 
        }
    }
    
    public function delete($id = NULL) {
        $this->sys_user_model->delete($id);
        $this -> response_message($id, '1', '删除成功');
    }
    
}