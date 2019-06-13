<?php
class Msg_term extends Api_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('msg/msg_term_model');
        
    }

    public function index()
    {
        $data = $this->msg_term_model->get();
        $this -> response_page($data);
    }
    
    public function list_data()
    {
        $data = $this->msg_term_model->get();
        $this -> response_page($data);
    }
    
    public function detail($id = NULL)
    {
        $data = $this->msg_term_model->detail($id);
        $this -> response_found($data);
    }
    
    public function add() {
        $data = $this->msg_term_model->add();
        if (empty($data)) {
            $this -> response_message($data, '0', '新增失败'); 
        } else {
            $this -> response_message($data, '1', '新增成功'); 
        }
    }
    
    public function delete($id = NULL) {
        $this->msg_term_model->delete($id);
        $this -> response_message($id, '1', '删除成功');
    }
    
    public function delete_batch() {
        $data = $this -> msg_term_model -> delete_batch();
        $this -> response($data);
    }
}