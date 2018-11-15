<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Kelas untuk melakukan komunikasi antara database users
 * @author  Rangga Djatikusuma Lukman
 */
class UserModel extends CI_Model {
    protected $table   = 'clients';
    protected $project = 'clients_projects';
    protected $pk      = 'id';
    
    /**
     * Fungsi untuk mendaftarkan data user kedalam database
     * @param   [array]     $input  Array data inputan user
     * @author  Rangga Djatikusuma Lukman
     */
    public function userRegister($input){
		$encrypt_password = bCrypt($input['password'],12);
		$array_user = array(
				'name'     => $input['name'],
				'username' => $input['username'],
				'password' => $encrypt_password,
				'email'    => $input['email'],
				'company'  => $input['company'],
                'phone'    => $input['phone'],
                'created_at' => date("Y-m-d h:i:s")
			);

        $this->db->insert($this->table, $array_user);
        
        $id = $this->db->insert_id();
        if(isset($input['projects']) && count($input['projects'])> 0){
            foreach($input['projects'] as $project){
                $this->db->insert($this->project, [
                    'project_id' => $project,
                    'client_id'  => $id
                ]);
            }
        }
	}

    /**
     * Fungsi untuk mengecek data user
     * @param   [string]    $field  kolom pada database
     * @param   [string]    $data   data acuan
     * @return  [int]       jumlah data yang sesuai
     * @author  Rangga Djatikusuma Lukman
     */
	public function exist_row_check($field,$data){
		$this->db->where($field, $data);
		$this->db->from($this->table);
		$query = $this->db->get();
		return $query->num_rows();
	}

    /**
     * Fungsi untuk mengambil detail data user
     * @param   [string]    $username   acuan username yang akan diambil
     * @return  [array]     array data user
     * @author  Rangga Djatikusuma Lukman
     */
	public function getUserDetailByUsername($username){
		$this->db->where("username", $username);
		$query = $this->db->get($this->table);

		if($query->num_rows() > 0){
			$data = $query->row();
			$query->free_result();
		}
		else{
			$data = NULL;
		}

		return $data;
	}

	public function updateProfile($input, $where=NULL){
		if($where)
            $this->db->where('id', $where);

        $data = [
            'name'    => $input['name'],
            'company' => $input['company'],
            'phone'   => $input['phone'],
            'email'   => $input['email']
        ];
        if(isset($input['password']) && !empty($input['password']) && !is_null($input['password'])){
            $data['password'] = bCrypt($input['password'],12);
        }
        $this->db->set($data);
		if($this->db->update($this->table, $data)){
            if(isset($input['projects']) && count($input['projects'])> 0){
                $this->db->where('client_id', $where);
		        $this->db->delete($this->project);
                foreach($input['projects'] as $project){
                    $this->db->insert($this->project, [
                        'project_id' => $project,
                        'client_id'  => $where
                    ]);
                }
            }
            return true;
        }else{
            return false;
        }
    }

    public function updateProfileUser($input, $where=NULL){
		if($where)
            $this->db->where('username', $where);

        $data = [
            'name'    => $input['name'],
            'company' => $input['company'],
            'phone'   => $input['phone'],
            'email'   => $input['email'],
            'address' => $input['address']
        ];
        if(!empty($input['current_password']) && !empty($input['new_password'])){
            $data['password'] = bCrypt($input['new_password'],12);
        }
        $this->db->set($data);
		if($this->db->update($this->table, $data)){
            return true;
        }else{
            return false;
        }
    }
    
    public function updateStatus($data, $where=NULL){
		if($where)
            $this->db->where('id', $where);

        $this->db->set($data);
		if($this->db->update($this->table, $data)){
            return true;
        }else{
            return false;
        }
	}

    public function getUserProject($id)
    {
        $this->db->select('*');
        $this->db->from($this->project.' a'); 
        $this->db->join('projects b', 'b.id=a.project_id');
        $this->db->where('a.client_id',$id);       
        $query = $this->db->get(); 
        if($query->num_rows() != 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }
}

/* End of file User_model.php */
