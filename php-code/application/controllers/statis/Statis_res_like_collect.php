<?php
class Statis_res_like_collect extends Api_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('statis/statis_res_like_collect_model');
        $this->load->model('statis/statis_user_record_model');
    }

    /**
             * 点赞收藏    res_type   0:video,1:img,2:information
     *       type    0:like   1:collect
     * @param unknown $res_id
     */
    public function likeOrCollect($res_id = NULL) {
        if (empty($res_id)) {
            return $this -> response_message('', '0', '操作失败');
        }
        $data = $this->statis_res_like_collect_model->likeOrCollect($res_id);
        //个人操作记录
        $data = $this->statis_user_record_model->record($res_id);
        return $this -> response_message($data, '1', '操作成功');
    }
    
    public function  cancleLikeOrCollect($res_id = NULL) {
        if (empty($res_id)) {
            return $this -> response_message('', '0', '操作失败');
        }
        $data = $this->statis_res_like_collect_model->cancleLikeOrCollect($res_id);
        //个人操作记录
        $data = $this->statis_user_record_model->cancleRecord($res_id);
        return $this -> response_message($data, '1', '操作成功');
    }
    
    
}