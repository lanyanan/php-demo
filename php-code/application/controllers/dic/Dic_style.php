<?php
class Dic_style extends Api_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('dic/dic_style_model');
        
    }
    
    public function get_list() {
        $data = $this -> dic_style_model -> get_list();
        $this -> response($data);
    }
    
}