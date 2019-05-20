<?php

class Upload extends Api_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('sys/sys_config_model');
    }

    public function upload_video()
    {
        $attachUrl =  $this->sys_config_model->detail('attach_ip')['prop_value'];
        
        $config['upload_path']      = $this->sys_config_model->detail('video_attach_path')['prop_value'];
        $config['allowed_types']    = 'mp4';
        $config['max_size']     = 100 * 1024;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('file'))
        {
            $error = array('error' => $this->upload->display_errors());
            $this -> response_message($error, 0 , "上传失败");
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $this -> response_message($data, 1 , "上传成功");
        }
    }
}
?>