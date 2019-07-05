<?php
class Res_image extends Api_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('res/res_image_model');
        
    }
    
    public function delete($id = NULL) {
        $this->res_image_model->delete($id);
        $this -> response_message($id, '1', '下架成功');
    }
}