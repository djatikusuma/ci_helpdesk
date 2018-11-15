<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_categories extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        
        $this->load->model(array('datatable_model', 'post_model'));
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
			$this->template->load('template', 'project_categories/view', $this->data);
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
            
			$users = $this->ion_auth->users()->result();
            // validate form input
            $this->form_validation->set_rules('name', "Name", 'trim|required');
            $this->form_validation->set_rules('code', "Code", 'trim|required');
            $post = $this->input->post(NULL, TRUE);
            if ($this->form_validation->run() === TRUE)
            {
                $code = !empty($post['code']) ? $post['code'] : "INT00"; 
                $data = [
                    'name'       => $post['name'],
                    'code'       => $post['code'],
                    'created_at' => date('Y-m-d h:i:s')
                ];

                $this->data['message'] = "";
                $this->post_model->create('project_categories', $data);
                
                redirect("bigadmin/project_categories", 'refresh');
            }
            else
            {
                // display the create user form
                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

                $this->data['name'] = array(
                    'name' => 'name',
                    'id' => 'name',
                    'type' => 'text',
                    'value' => $this->form_validation->set_value('name'),
                );
                $this->data['code'] = array(
                    'name' => 'code',
                    'id' => 'code',
                    'type' => 'text',
                    'value' => $this->form_validation->set_value('code'),
                );
            }

            // get Project_categories category
            $this->data['categories'] = $this->post_model->read('project_categories')->result();
            //list the users
            $this->data['users'] = $users;
			$this->template->load('template', 'project_categories/add', $this->data);
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
            $this->form_validation->set_rules('name', "Name", 'trim|required');
            $this->form_validation->set_rules('code', "Code", 'trim|required');
            $post = $this->input->post(NULL, TRUE);
            if ($this->form_validation->run() === TRUE)
            {
                $data = [
                    'name'        => $post['name'],
                    'code' => $post['code']
                ];
                if($this->post_model->update('project_categories', $data, ['id' => $id]) > 0)
                    $this->redirects();
            }
            

            $result = $this->post_model->read('project_categories', ['id' => $id])->row();

            $this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

            $this->data['name'] = array(
                'name' => 'name',
                'id' => 'name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('name', $result->name),
            );
            $this->data['code'] = array(
                'name' => 'code',
                'id' => 'code',
                'type' => 'text',
                'value' => $this->form_validation->set_value('code', $result->code),
            );
            //list the users
            $this->data['users'] = $this->post_model->read("users", ["id" => $this->ion_auth->get_user_id()])->row();
            $this->data['id'] = $id;
			$this->template->load('template', 'project_categories/edit', $this->data);
        }
    }

    public function ajax_list()
    {
        $option = array(
            'table'         => 'project_categories',
            'where'         => null,
            'column_search' => array('name', 'code'),
            'column_order'  => array(NULL,'name', 'code', 'updated_at', null),
            'order'         => array('id' => 'asc')
        );
        $getData = $this->datatable_model->get_datatables($option);
        $data    = array();
        $no      = $_POST['start'];
        foreach ($getData as $res) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$res->id.'">';
            $row[] = $res->name;
            $row[] = $res->code;
            $row[] = date('j F Y', strtotime($res->updated_at));
			$row[] = '<a class="btn btn-xs btn-primary" href="project_categories/edit/'.$res->id.'" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a>
                  <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_project_categories('."'".$res->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			
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
        $option = array(
            'table'         => 'project_categories'
        );
        $this->datatable_model->delete_by_id($id, $option);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_bulk_delete()
    {
        $option = array(
            'table'         => 'project_categories'
        );
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->datatable_model->delete_by_id($id, $option);
        }
        echo json_encode(array("status" => TRUE));
    }
    
    private function redirects()
	{
		if ($this->ion_auth->is_admin()){
			redirect('bigadmin/project_categories', 'refresh');
		}
		redirect('/', 'refresh');
	}

}

/* End of file Department.php */
