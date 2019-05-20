<?php
class Dic_content_category extends Api_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('dic/dic_content_category_model');
        
    }
    
    public function get_list() {
        $data = $this -> dic_content_category_model -> get_list();
        $this -> response($data);
    }
    
}