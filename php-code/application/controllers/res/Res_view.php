<?php
class Res_view extends Api_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('res/res_view_model');
        
    }

    public function index()
    {
        $data = $this->res_view_model->get();
        $this -> response_page($data);
    }
    
    public function list_data($type)
    {
        $data = $this->res_view_model->get($type);
        $this -> response_page($data);
    }
    
    public function detail($id = NULL)
    {
        $data = $this->res_view_model->detail($id);
        $this -> response_found($data);
    }
    
  
    
}