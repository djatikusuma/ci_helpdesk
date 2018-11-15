<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets_model extends CI_Model {

    public function getTicketData($id = NULL)
    {
        $this->db->select('t.*, u.name');
        $this->db->from('tickets t'); 
        $this->db->join('groups g', 'g.id=t.department_id', 'left');
        $this->db->join('projects p', 'p.id=t.project_id', 'left');
        $this->db->join('clients u', 'u.id=t.client_id', 'left');
        $this->db->where('t.ticket_code',$id);      
        $query = $this->db->get(); 
        if($query->num_rows() != 0)
        {
            return $query;
        }
        else
        {
            return false;
        }
    }    

    public function getSolutionData($id = NULL)
    {
        $this->db->select('s.*, u.first_name, u.last_name, c.name');
        $this->db->from('solutions s');
        $this->db->join('users u', 'u.id=s.user_id', 'left');
        $this->db->join('clients c', 'c.id=s.client_id', 'left');
        $this->db->order_by('created_at', 'DESC');
        $this->db->where('s.ticket_code',$id);      
        $query = $this->db->get(); 
        return $query;
    }    

}

/* End of file Tickets_model.php */
