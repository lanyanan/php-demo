<?php
class Dic_house_type extends Api_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('dic/dic_house_type_model');
        
    }
    
    public function get_list() {
        $data = $this -> dic_house_type_model -> get_list();
        $this -> response($data);
    }
    
}