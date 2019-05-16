<?php

/**
 * Created by PhpStorm.
 * User: landsnail
 * Date: 2019/5/16
 * Time: 3:44 PM
 */
class Search extends CI_Controller
{

    public function restroom(){
        
        echo json_encode($this->uri->segment_array());

        $a = $this->uri->segment(1);
        $b = $this->uri->segment(2);

        echo $a."  ".$b;
    }
}