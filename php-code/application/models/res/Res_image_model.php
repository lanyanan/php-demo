<?php
class Res_image_model extends Api_Model
{

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