<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        
        $this->load->model(array('datatable_model', 'UserModel', 'post_model'));
    }
    
    public function index()
    {
        if (!$this->ion_auth->logged_in())
		{
			redirect('bigadmin/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin())
		{
			redirect('bigadmin/login', 'refresh');
		}
		else
		{    
        
            //list the users
			$this->data['users'] = $this->post_model->read("users", ["id" => $this->ion_auth->get_user_id()])->row();
			$this->template->load('template', 'clients/view', $this->data);
        }
    }

    public function add()
    {
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('bigadmin/login', 'refresh');
		}
		else
		{
            // validate form input
            $this->form_validation->set_rules('username', 'Username', 'required|callback_username_check');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
            $this->form_validation->set_rules('name', 'Nama Lengkap', 'required|max_length[30]');
            $this->form_validation->set_rules('phone', 'No Telp/Handphone', 'required|max_length[13]');
            $this->form_validation->set_rules('company', 'Perusahaan', 'required');
            $this->form_validation->set_message('required', '{field} masih kosong, silahkan diisi');
            $this->form_validation->set_message('valid_email', 'silahkan ketikkan format email yang benar');
            $this->form_validation->set_message('min_length', 'password kurang dari 5 digit');

            $post = $this->input->post(NULL, TRUE);
            if ($this->form_validation->run() === TRUE)
            {
                $this->UserModel->userRegister($post);
                redirect("bigadmin/clients", 'refresh');
            }
            else
            {
                // display the create user form
                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
            }
            //get project
            $this->data['projects'] = $this->post_model->read('projects')->result();
            //list the users
			$this->data['users'] = $this->post_model->read("users", ["id" => $this->ion_auth->get_user_id()])->row();
			$this->template->load('template', 'clients/add', $this->data);
        }
    }
    
    public function edit($id)
    {
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('bigadmin/login', 'refresh');
		}
		else
		{
            // validate form input
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('name', 'Nama Lengkap', 'required|max_length[30]');
            $this->form_validation->set_rules('phone', 'No Telp/Handphone', 'required|max_length[13]');
            $this->form_validation->set_rules('company', 'Perusahaan', 'required');
            $this->form_validation->set_message('required', '{field} masih kosong, silahkan diisi');
            $this->form_validation->set_message('valid_email', 'silahkan ketikkan format email yang benar');
            $this->form_validation->set_message('min_length', 'password kurang dari 5 digit');

            $this->data['client'] = $this->UserModel->getUserDetailByUsername($id);

            $input = $this->input->post(NULL, TRUE);
            if ($this->form_validation->run() === TRUE)
            {
                $this->UserModel->updateProfile($input, $this->data['client']->id);
                $this->redirects();
            }
            

            $this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
            //get project
            $this->data['projects'] = $this->post_model->read('projects')->result();
            //list the users
            $this->data['users'] = $this->post_model->read("users", ["id" => $this->ion_auth->get_user_id()])->row();
            $this->data['id'] = $this->data['client']->id;
			$this->template->load('template', 'clients/edit', $this->data);
        }
    }

    public function look($username)
    {
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('bigadmin/login', 'refresh');
		}
		else
		{
            $result = $this->UserModel->getUserDetailByUsername($username);
            if(count($result) > 0){
                $this->data['client'] = $result;
                $this->data['projects'] = $this->UserModel->getUserProject($result->id);
                //list the users
                $this->data['users'] = $this->post_model->read("users", ["id" => $this->ion_auth->get_user_id()])->row();
                $this->template->load('template', 'clients/look', $this->data);
            }else{
                $this->redirects();
            }
        }
    }

    public function ajax_list()
    {
        $option = array(
            'table'         => 'clients',
            'where'         => null,
            'column_search' => array('name', 'company', 'email', 'phone'),
            'column_order'  => array(NULL, 'name', 'company', 'email', 'phone', 'status', 'updated_at', null),
            'order'         => array('id' => 'asc')
        );
        $getData = $this->datatable_model->get_datatables($option);
        $data    = array();
        $no      = $_POST['start'];
        foreach ($getData as $res) {
            $no++;
            $status = $res->status == 'active' ? 'info' : 'danger';
            $stat   = $res->status == 'active' ? 'deactive' : 'active';
            $ic     = $res->status == 'active' ? 'ban-circle' : 'ok-sign';

            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$res->id.'">';
            $row[] = $res->name;
            $row[] = $res->company;
            $row[] = $res->email;
            $row[] = $res->phone;
            $row[] = "<span class='label label-{$status}'>{$res->status}</span>";
            $row[] = date('j F Y', strtotime($res->updated_at));
            $row[] = '<a class="btn btn-xs btn-success" href="clients/look/'.$res->username.'" title="Lihat"><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a class="btn btn-xs btn-primary" href="clients/edit/'.$res->username.'" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a>
                  <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="'.$stat.'" onclick="delete_clients('."'".$res->id."'".', '."'".$stat."'".')"><i class="glyphicon glyphicon-'.$ic.'"></i></a>';
			
            $data[] = $row;
        }
 
        $output = array(
                        "draw"            => $_POST['draw'],
                        "recordsTotal"    => $this->datatable_model->count_all($option),
                        "recordsFiltered" => $this->datatable_model->count_filtered($option),
                        "data"            => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_delete($id)
    {
        $status = $this->uri->segment(5);
        
        $this->UserModel->updateStatus([
            'status' => $status
        ], $id);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->UserModel->updateStatus([
                'status' => 'deactive'
            ], $id);
        }
        echo json_encode(array("status" => TRUE));
    }
    
    private function redirects()
	{
		if ($this->ion_auth->is_admin()){
			redirect('bigadmin/clients', 'refresh');
		}
		redirect('/', 'refresh');
    }
    
    /**
     * Fungsi untuk mengecek email yang sama pada database
     * @param   [string]    $str    inputan email user
     * @return  [boolean]   true/false
     * @author  Rangga Djatikusuma Lukman
     */
	public function email_check($str){
		if($this->UserModel->exist_row_check('email', $str) > 0){
            $this->form_validation->set_error_delimiters('', '');
			$this->form_validation->set_message('email_check', 'Email telah digunakan');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

    /**
     * Fungsi untuk mengecek username yang sama pada database
     * @param   [string]    $str    inputan username user
     * @return  [boolean]   true/false
     * @author  Rangga Djatikusuma Lukman
     */
	public function username_check($str){
		if($this->UserModel->exist_row_check('username', $str) > 0){
            $this->form_validation->set_error_delimiters('', '');
			$this->form_validation->set_message('username_check', 'Username telah digunakan');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}	

    /**
     * Fungsi untuk mengecek password yang sama pada database pada saat login
     * @param   [string]    $str    inputan password user
     * @return  [boolean]   true/false
     * @author  Rangga Djatikusuma Lukman
     */
	public function password_check($str){
        
        if($this->UserModel->exist_row_check('username', $this->username_temp) > 0){
            $user_detail = $this->UserModel->getUserDetailByUsername($this->username_temp);
            if($user_detail->password == crypt($str,$user_detail->password)){
                return TRUE;
            }
            else{
                $this->form_validation->set_message('password_check','Password yang dimasukkan tidak sesuai');
                return FALSE;
            }
        }else{
            $this->form_validation->set_message('password_check','Username yang dimasukkan tidak sesuai');
            return FALSE;
        }
  
    }

}

/* End of file Clients.php */
