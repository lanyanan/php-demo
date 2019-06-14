<?php
class Res_image_model extends Api_Model
{
    public function get($house_space_id = NULL, $style = NULL) {
        $queryField = " * ";
        $this -> simpleQuery($queryField, TRUE);
        if (!empty($house_space_id)) {
            $this->db->where('t.house_space_id', $house_space_id);
        }
        if (!empty($style)) {
            $this->db->where('t.style', $style);
        }
        $data = $this -> getCountPage('res_image');
        foreach ($data['data'] as $k => $val) {
            $path = $data['data'][$k]['attach_path'];
            $data['data'][$k]["attach_url"] =  $this->signatureurl($path);
        }
        return $data;
    }
    
    protected function simpleQuery($queryField, $countQuery = FALSE) {
        $this->db->select($queryField);
        if ($countQuery === FALSE) {
            $this->db->from('res_image t');
        }
        $this->db->where('t.is_delete', '0');
        $this->db->join('res_album a', 'a.id = t.album_id and a.publish_status = "1" and a.is_delete = "0"' , 'left');
    }

    public function delete($id = null) {
        if ($id == null) {
            return;
        }
        $data = array(
            'is_delete' => '1'
        );
        $this->db->where('id', $id);
        $this->db->update('res_image', $data);
    }
    
}