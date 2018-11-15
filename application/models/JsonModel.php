<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class JsonModel extends CI_Model {

    public function getJsonItem($table = 'provinces', $where = NULL)
    {
        $this->db->from($table);

        if($where!=NULL)
            $this->db->where($where);
        
        $query = $this->db->get();

        return $query;
    }

}

/* End of file Json_model.php */
