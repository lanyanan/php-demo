<?php
class Statis_page_view extends Api_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('statis/statis_page_view_model');
    }
    
    /**
     *    浏览次数
             res_type   0:video,1:img,2:information
     * @param unknown $res_id  : 资源id
     */
    public function view_auto_increment($res_id = NULL) {
        if (empty($res_id)) {
            return $this -> response_message('', '0', '操作失败');
        }
        $data = $this->statis_page_view_model->view_auto_increment($res_id);
        return $this -> response_message($data, '1', '操作成功');
    }
    
    
}