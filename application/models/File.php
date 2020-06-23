<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File extends CI_Model {

    function _construct() {
        $this->tableName = 'images';
    }

	public function getRows($id = '')
	{
        $this->db->select('id, file_name, uploaded_on');
        $this->db->from('images');
        if ($id) {
            $this->db->where('id', $id);
            $query = $this->db->get();
            $result  = $query->row_array();
        } else {
            $this->db->order_by('uploaded_on', 'desc');
            $query = $this->db->get();
            $result = $query->result_array();
        }

        return !empty($result)?$result:false;
    }
    
    public function insert($data = array()) {
        $insert = $this->db->insert_batch('images', $data);
        return $insert?true:false;
    }
}
