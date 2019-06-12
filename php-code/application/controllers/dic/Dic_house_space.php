<?php
class Dic_house_space extends Api_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('dic/dic_house_space_model');
        
    }
    
    public function get_list() {
        $data = $this -> dic_house_space_model -> get_list();
        $this -> response($data);
    }
    
}