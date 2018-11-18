<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
		$this->load->library(array('form_validation'));
        $this->load->model("UserModel", "user_model");
        $this->load->model(array("post_model", "tickets_model"));
        
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
            'title'    => "Tiket {$user->name}",
            'users'    => $user,
            'projects' => $this->user_model->getUserProject($user->id),
            'sess'     => $sess
        ];

        $this->template->load('public/template', 'tickets/index', $data);
    }

    public function new_ticket()
    {
		$this->load->library('form_validation');
        $sess = $this->session->userdata('userData');
        // Cek Status Login
        if(!$sess['login_status']){ 
            redirect(base_url('users/login'),'refresh');
        }

        // Get Detail User
        $user = $this->user_model->getUserDetailByUsername($sess['username']);
        $data = [
            'title'       => "Tiket Baru {$user->name}",
            'users'       => $user,
            'projects'    => $this->user_model->getUserProject($user->id),
            'departments' => $this->post_model->read('groups')->result(),
            'priorities'  => $this->post_model->read('priorities')->result(),
            'sess'        => $sess
        ];

        $this->form_validation->set_rules('title', 'Subjek', 'required');
        $this->form_validation->set_rules('content', 'Deskripsi Tiket', 'required|min_length[20]');
        $this->form_validation->set_rules('department_id', 'Department', 'required');
        $this->form_validation->set_rules('priority_id', 'Prioritas', 'required');
        $this->form_validation->set_rules('project_id', 'Relasi Projek', 'required');
        $this->form_validation->set_message('required', '{field} masih kosong, silahkan diisi');
        $this->form_validation->set_message('min_length', 'Panjang minimal karakter 20');

		if($this->form_validation->run() == TRUE){
            $input = $this->input->post(NULL, TRUE);

            $data = [
                'ticket_code'   => "TID".time(),
                'title'         => $input['title'],
                'content'       => $input['content'],
                'department_id' => $input['department_id'],
                'priority_id'   => $input['priority_id'],
                'project_id'    => $input['project_id'],
                'client_id'     => $sess['id'],
                'created_at'    => date("Y-m-d h:i:s"),
                'date_open'     => date("Y-m-d h:i:s"),
                'status_id'     => 1
            ];

            //upload
			$config['upload_path']   = './users_uploads/file/';
			$config['allowed_types'] = 'jpg|jpeg|gif|png|zip|rar|gz|7z|txt|xls|xlsx|doc|docx|pdf|htm|html|csv|sql';
			$config['max_size']      = '100000';
			$config['encrypt_name']  = TRUE;
			
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
            $image = array();
            $files = $_FILES;
            for($i=0;$i<count($_FILES['attachments']['name']);$i++){
                $_FILES['attachment']['name']     = $files['attachments']['name'][$i];
                $_FILES['attachment']['type']     = $files['attachments']['type'][$i];
                $_FILES['attachment']['tmp_name'] = $files['attachments']['tmp_name'][$i];
                $_FILES['attachment']['error']    = $files['attachments']['error'][$i];
                $_FILES['attachment']['size']     = $files['attachments']['size'][$i];
                if($this->upload->do_upload('attachment'))
                {
                    $file     = $this->upload->data();
                    $file_img = $file['file_name'];
                    array_push($image, $file_img);
                }
            }
            $data['attachment'] = json_encode($image);
            
            $this->post_model->create('tickets', $data);
                
            redirect("users/tickets", 'refresh');
		}

        $this->template->load('public/template', 'tickets/add', $data);
    }

    public function ajax_list()
    {
        $sess = $this->session->userdata('userData');
        $option = array(
            'table'         => 'tickets',
            'where'         => array('client_id' => $sess['id']),
            'column_search' => array('title'),
            'column_order'  => array('department_id', 'title', 'status_id', 'created_at', null),
            'order'         => array('ticket_code' => 'asc')
        );
        $getData = $this->datatable_model->get_datatables($option);
        $data    = array();
        $no      = $_POST['start'];
        foreach ($getData as $res) {
            $no++;
            $row        = array();
            $department = $this->post_model->read('groups', ['id' => $res->department_id])->row();
            $solution   = $this->post_model->read('solutions', ['ticket_code' => $res->ticket_code])->result();
            if(count($solution) > 0 && $res->status_id != 3){
                $this->post_model->update("tickets", array("status_id" => 2), array("ticket_code" => $res->ticket_code));
            }
            $status     = $this->post_model->read('statuses', ['id' => $res->status_id])->row();
            $color      = array(1 => 'info', 'warning', 'danger');

            $row[] = $department->name;
            $row[] = "<a href='tickets/detail/{$res->ticket_code}' title='Detail'>#{$res->ticket_code} - {$res->title}</a>";
            $row[] = "<span class='label label-{$color[$res->status_id]}'>{$status->status_name}</span>";
            $row[] = tanggal_indo($res->created_at);
			$row[] = '<a class="btn btn-xs btn-primary" href="tickets/detail/'.$res->ticket_code.'" title="Detail"><i class="glyphicon glyphicon-eye-open"></i> Detail</a>';
			
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

    
    public function detail($id = NULL)
    {
        if($id != null){
            
            $sess = $this->session->userdata('userData');
            // Cek Status Login
            if(!$sess['login_status']){ 
                redirect(base_url('users/login'),'refresh');
            }
            else
            {    
                $user = $this->user_model->getUserDetailByUsername($sess['username']);

                $this->form_validation->set_rules('content', 'Message', 'required|min_length[20]');
                $this->form_validation->set_message('required', '{field} masih kosong, silahkan diisi');
                $this->form_validation->set_message('min_length', 'Panjang minimal karakter 20');
        
                if($this->form_validation->run() == TRUE){
                    $input = $this->input->post(NULL, TRUE);
        
                    $data = [
                        'content'     => $input['content'],
                        'client_id'   => $user->id,
                        'ticket_code' => $id
                    ];
        
                    //upload
                    $config['upload_path']   = './users_uploads/solution/';
                    $config['allowed_types'] = 'jpg|jpeg|gif|png|zip|rar|gz|7z|txt|xls|xlsx|doc|docx|pdf|htm|html|csv|sql';
                    $config['max_size']      = '100000';
                    $config['encrypt_name']  = TRUE;
                    
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    
                    $image = array();
                    $files = $_FILES;
                    for($i=0;$i<count($_FILES['attachments']['name']);$i++){
                        $_FILES['attachment']['name']     = $files['attachments']['name'][$i];
                        $_FILES['attachment']['type']     = $files['attachments']['type'][$i];
                        $_FILES['attachment']['tmp_name'] = $files['attachments']['tmp_name'][$i];
                        $_FILES['attachment']['error']    = $files['attachments']['error'][$i];
                        $_FILES['attachment']['size']     = $files['attachments']['size'][$i];
                        if($this->upload->do_upload('attachment'))
                        {
                            $file     = $this->upload->data();
                            $file_img = $file['file_name'];
                            array_push($image, $file_img);
                        }
                    }
                    $data['attachment'] = json_encode($image);
                    
                    $this->post_model->create('solutions', $data);
                    $this->post_model->update('tickets', ['status_id' => 2], ['ticket_code' => $id]);
                        
                    redirect("users/tickets/detail/{$input['ticket_code']}", 'refresh');
                }

                //list the users
                $data['users']     = $user;
                $data['sess']      = $sess;
                $data['solutions'] = $this->tickets_model->getSolutionData($id)->result();
                $data['result']    = $this->tickets_model->getTicketData($id)->row();
                // print_r($getData);
                $this->template->load('public/template', 'tickets/detail', $data);
            }
        }
    }
    
    public function close_ticket($id){
        if($id != null){
            
            $sess = $this->session->userdata('userData');
            // Cek Status Login
            if(!$sess['login_status']){ 
                redirect(base_url('users/login'),'refresh');
            }
            else
            {  
                $user = $this->user_model->getUserDetailByUsername($sess['username']);
                $this->post_model->update('tickets', ['status_id' => 3], ['ticket_code' => $id]);
                //list the users
                $data['users']     = $user;
                $data['sess']      = $sess;
                $data['solutions'] = $this->tickets_model->getSolutionData($id)->result();
                $data['result']    = $this->tickets_model->getTicketData($id)->row();
                redirect(base_url("users/tickets/detail/$id"));
            }
        }
    }

}

/* End of file Tickets.php */
