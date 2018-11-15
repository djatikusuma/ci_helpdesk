<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function create($table,$data){
        $this->db->insert($table,$data);
        
        return $this->db->insert_id();
	}

	public function _read($table, $where=NULL, $order=NULL, $type=NULL, $limit=NULL, $offset=NULL) {
		if ($where!=NULL)
			$this->db->where($where);
        $this->db->order_by($order,$type);
        $query = $this->db->get($table, $limit, $offset);
        return $query;
    }

	public function read($table, $where=NULL, $order=NULL, $type=NULL, $limit=NULL, $offset=NULL){
		$this->db->from($table);

		if($where)
            $this->db->where($where);
        if($limit && $offset)
            $this->db->limit($limit,$offset);
        if($order && $type)
			$this->db->order_by($order, $type);

		$query = $this->db->get();

		return $query;
	}

	public function edit($table, $where=NULL){
		if($where)
            $this->db->where($where);
		$query = $this->db->get($table);
		if($query->num_rows() > 0){
			$data = $query->row();
			$query->free_result();
		}
		else{
			$data = NULL;
		}

		return $data;
	}

	public function update($table, $data, $where=NULL){
		if($where)
            $this->db->where($where);

        $this->db->set($data);

		$this->db->update($table,$data);	
		
		return $this->db->affected_rows();
	}
	

	public function delete($table, $where=NULL){
		if($where)
            $this->db->where($where);
		$this->db->delete($table);
	}

	public function checkData($table=NULL,$where=NULL){
    	if($where)
    		$this->db->where($where);
    	return $this->db->get($table);
    }

	public function total_rows($table){
		return $this->db->count_all_results($table);
	}

}

/* End of file Post_model.php */
/* Location: ./application/models/Post_model.php */