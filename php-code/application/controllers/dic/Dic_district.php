<?php
class Dic_district extends Api_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('dic/dic_district_model');
        
    }
    
    public function get_list_by_parent($parent = '0') {
        $data = $this -> dic_district_model -> get_list_by_parent($parent);
        $this -> response($data);
    }
    
}