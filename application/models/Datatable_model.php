<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Datatable_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
 
    private function _get_datatables_query($data)
    {
        
        if($data['where'] != null || !empty($data['where']) || isset($data['where']))
            $this->db->where($data['where']);
         
        $this->db->from($data['table']);
        
        
 
        $i = 0;
     
        foreach ($data['column_search'] as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($data['column_search']) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($data['column_order'][$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($order))
        {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables($data)
    {
        $this->_get_datatables_query($data);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($data)
    {
        $this->_get_datatables_query($data);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($data)
    {
        $this->db->from($data['table']);
        return $this->db->count_all_results();
    }

    public function delete_by_id($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->delete($data['table']);
    }

}

/* End of file DatatableModel.php */
