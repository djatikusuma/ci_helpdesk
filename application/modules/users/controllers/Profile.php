<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->model("UserModel", "user_model");
        
    }

    public function index()
    {
        $sess = $this->session->userdata('userData');
        // Cek Status Login
        if(!$sess['login_status']){ 
            redirect(base_url('users/login'),'refresh');
        }

        // Get Detail User
        $user = $this->user_model->getUserDetailByUsername($sess['username']);
        $data = [
            'title'    => "Profile {$user->name}",
            'users'    => $user,
            'projects' => $this->user_model->getUserProject($user->id),
            'sess'     => $sess
        ];

        $this->template->load('public/template', 'profile/view', $data);
    }

    /**
     * Fungsi update profil user
     * @author Rangga Djatikusuma Lukman
     */
    public function update($username)
    {
        $sess = $this->session->userdata('userData');
        // Cek Status Login
        if(!$sess['login_status']){ 
            redirect(base_url('users/login'),'refresh');
        }

        $this->load->library('form_validation');
        $post = $this->input->post(NULL, TRUE);
        $this->username_temp = @$sess['username'];

        if($username != $sess['username']){
            redirect(base_url('users'));
        }

        // Get Detail User
        $user = $this->user_model->getUserDetailByUsername($sess['username']);
        $data = [
            'title'    => "Edit Profile {$user->name}",
            'users'    => $user,
            'sess'     => $sess
        ];

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('name', 'Nama Lengkap', 'required|max_length[30]');
        $this->form_validation->set_rules('phone', 'No Telp/Handphone', 'required|max_length[13]');
        $this->form_validation->set_rules('company', 'Perusahaan', 'required');
        $this->form_validation->set_rules('address', 'Alamat Perusahaan', 'required');
        if(!empty($post['current_password']) && !empty($post['new_password'])){
            $this->form_validation->set_rules('new_password', 'New Password', 'min_length[5]');
            $this->form_validation->set_rules('current_password', 'Current Password', 'callback_password_check');
        }
        $this->form_validation->set_message('required', '{field} masih kosong, silahkan diisi');
        $this->form_validation->set_message('min_length', '{field} kurang dari 5 digit');


		if($this->form_validation->run() == FALSE){
            $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			$this->template->load('public/template', 'profile/edit', $data);
        }else{
            if($this->user_model->updateProfileUser($post, $sess['username']))
                redirect(base_url('users/profile'),'refresh');
        }
    }

    /**
     * Fungsi untuk mengecek password yang sama pada database pada saat login
     * @param   [string]    $str    inputan password user
     * @return  [boolean]   true/false
     * @author  Rangga Djatikusuma Lukman
     */
	public function password_check($str){
        
        if($this->user_model->exist_row_check('username', $this->username_temp) > 0){
            $user_detail = $this->user_model->getUserDetailByUsername($this->username_temp);
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

/* End of file Profile.php */
