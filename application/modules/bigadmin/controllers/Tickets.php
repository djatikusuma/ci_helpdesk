<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        
        $this->load->model(array('datatable_model', 'post_model', 'tickets_model'));
        
        $this->load->model("UserModel", "user_model");
        
    }

    public function index()
    {
        if (!$this->ion_auth->logged_in())
		{
			redirect('bigadmin/login', 'refresh');
		}
		else
		{    
        
            //list the users
			$data['users']  = $this->post_model->read("users", ["id" => $this->ion_auth->get_user_id()])->row();
			$this->template->load('template', 'tickets/index', $data);
        }
    }

    public function ajax_list()
    {
        $users = $this->ion_auth->users()->result();
        $sess = $this->session->userdata('userData');
        $did = $this->ion_auth->get_users_groups($this->ion_auth->get_user_id())->result();

        $groupId = "";
        $i = 0;
        foreach($did as $d){
            $groupId .= "'$d->id'";
            if($i < count($did)-1) $groupId .=",";
            $i++;
        }

        if (!$this->ion_auth->is_admin())
            $where = array("department_id IN($groupId)" => null);
        else
            $where = null;

        $option = array(
            'table'         => 'tickets',
            'where'         => $where,
            'column_search' => array('title'),
            'column_order'  => array('department_id', 'title', 'status_id', 'project_id', 'created_at', null),
            'order'         => array('ticket_code' => 'asc')
        );
        $getData = $this->datatable_model->get_datatables($option);
        $data    = array();
        $no      = $_POST['start'];
        foreach ($getData as $res) {
            $no++;
            $row        = array();
            $department = $this->post_model->read('groups', ['id' => $res->department_id])->row();
            $status     = $this->post_model->read('statuses', ['id' => $res->status_id])->row();
            $project     = $this->post_model->read('projects', ['id' => $res->project_id])->row();
            $color      = array(1 => 'info', 'warning', 'danger');

            $row[] = $department->name;
            $row[] = "<a href='tickets/detail/{$res->ticket_code}' title='Detail'>#{$res->ticket_code} - {$res->title}</a>";
            $row[] = $project->project_name;
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
            if (!$this->ion_auth->logged_in())
            {
                redirect('bigadmin/login', 'refresh');
            }
            else
            {    
                $this->form_validation->set_rules('content', 'Message', 'required|min_length[20]');
                $this->form_validation->set_message('required', '{field} masih kosong, silahkan diisi');
                $this->form_validation->set_message('min_length', 'Panjang minimal karakter 20');
        
                if($this->form_validation->run() == TRUE){
                    $input = $this->input->post(NULL, TRUE);
        
                    $data = [
                        'content'     => $input['content'],
                        'user_id'     => $this->ion_auth->get_user_id(),
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
                        
                    redirect("bigadmin/tickets/detail/{$input['ticket_code']}", 'refresh');
                }

                //list the users
                $data['users']     = $this->post_model->read("users", ["id" => $this->ion_auth->get_user_id()])->row();
                $data['solutions'] = $this->tickets_model->getSolutionData($id)->result();
                $data['result']    = $this->tickets_model->getTicketData($id)->row();
                // print_r($getData);
                $this->template->load('template', 'tickets/detail', $data);
            }
        }
    }

}

/* End of file Tickets.php */
