<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Kelas untuk melakukan login dan register user
 * @author  Rangga Djatikusuma Lukman
 */
class Users extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model("UserModel", "user_model");
        
    }

    public function index()
    {
        $sess = $this->session->userdata('userData');
        // Get Detail User
        $user = $this->user_model->getUserDetailByUsername($sess['username']);

        // Cek Status Login
        if(!$sess['login_status'] || $user->status == 'deactive'){ 
            redirect(base_url('users/login'),'refresh');
        }

        $data = [
            'title' => "Home",
            'users' => $user,
            'sess'  => $sess
        ];

        $this->template->load('public/template', 'home', $data);
    }
    
    public function login($redirect = NULL){
		$this->load->library('form_validation');
		$input = $this->input->post(NULL,TRUE);
		$this->username_temp = @$input['username'];

		$this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|callback_password_check');
        $this->form_validation->set_message('required', '{field} masih kosong, silahkan diisi');


		if($this->form_validation->run() == FALSE){
			$this->template->load('public/template', 'login');
		}
		else{
            $redirectUrl = !is_null($redirect) ? $redirect : "";
            $getUser = $this->user_model->getUserDetailByUsername($input['username']);
            if($getUser->status == 'active'){
                $login_data = array(
                    'name'         => $getUser->name,
                    'username'     => $input['username'],
                    'email'        => $input['email'],
                    'id'           => $getUser->id,
                    'login_status' => TRUE
                );

                $this->session->set_userdata('userData', $login_data);

                redirect(base_url($redirect));
            }else{
                
                redirect('users/login','refresh');
                
            }
		}
		
	}

    /**
     * Fungsi untuk mengecek email yang sama pada database
     * @param   [string]    $str    inputan email user
     * @return  [boolean]   true/false
     * @author  Rangga Djatikusuma Lukman
     */
	public function email_check($str){
		if($this->user_model->exist_row_check('email', $str) > 0){
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
		if($this->user_model->exist_row_check('username', $str) > 0){
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
    
    public function logout(){
		$this->load->library('session');
		$this->session->sess_destroy();
		redirect(base_url());
	}

}

/* End of file User.php */
