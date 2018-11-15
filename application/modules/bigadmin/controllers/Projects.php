<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends CI_Controller {

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
			$this->template->load('template', 'projects/view', $this->data);
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
            $this->form_validation->set_rules('project_name', "Project Name", 'trim|required');
            $this->form_validation->set_rules('project_date', "Project Date", 'trim|required');
            $this->form_validation->set_rules('project_description', "Project Description", 'trim|required');
            $post = $this->input->post(NULL, TRUE);
            if ($this->form_validation->run() === TRUE)
            {
                $code = !empty($post['category_code']) ? $post['category_code'] : "INT00"; 
                $data = [
                    'id'                  => strtoupper("BIG{$code}".date('Ymd', strtotime($post['project_date']))),
                    'project_name'        => $post['project_name'],
                    'project_description' => $post['project_description'],
                    'created_at'          => date('Y-m-d h:i:s'),
                    'project_date'        => date('Y-m-d', strtotime($post['project_date'])),
                    'user_id'             => $users[0]->id,
                    'category_code'       => $code
                ];

                $this->data['message'] = "";
                $this->post_model->create('projects', $data);
                
                redirect("bigadmin/projects", 'refresh');
            }
            else
            {
                // display the create user form
                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

                $this->data['project_name'] = array(
                    'name' => 'project_name',
                    'id' => 'project_name',
                    'type' => 'text',
                    'value' => $this->form_validation->set_value('project_name'),
                );
                $this->data['project_description'] = array(
                    'name' => 'project_description',
                    'id' => 'project_description',
                    'type' => 'text',
                    'value' => $this->form_validation->set_value('project_description'),
                );
                $this->data['project_date'] = array(
                    'name' => 'project_date',
                    'id' => 'project_date',
                    'type' => 'text',
                    'value' => $this->form_validation->set_value('project_date'),
                );
            }

            // get projects category
            $this->data['categories'] = $this->post_model->read('project_categories')->result();
            //list the users
            $this->data['users'] = $users;
			$this->template->load('template', 'projects/add', $this->data);
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
            $this->form_validation->set_rules('project_name', "Project Name", 'trim|required');
            $this->form_validation->set_rules('project_date', "Project Date", 'trim|required');
            $this->form_validation->set_rules('project_description', "Project Description", 'trim|required');
            $post = $this->input->post(NULL, TRUE);
            if ($this->form_validation->run() === TRUE)
            {
                $data = [
                    'project_name'        => $post['project_name'],
                    'project_description' => $post['project_description'],
                    'project_date'        => date('Y-m-d', strtotime($post['project_date']))
                ];
                if($this->post_model->update('projects', $data, ['id' => $id]) > 0)
                    $this->redirects();
            }
            

            $result = $this->post_model->read('projects', ['id' => $id])->row();

            $this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

            $this->data['project_name'] = array(
                'name' => 'project_name',
                'id' => 'project_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('project_name', $result->project_name),
            );
            $this->data['project_description'] = array(
                'name' => 'project_description',
                'id' => 'project_description',
                'type' => 'text',
                'value' => $this->form_validation->set_value('project_description', $result->project_description),
            );
            $this->data['project_date'] = array(
                'name' => 'project_date',
                'id' => 'project_date',
                'type' => 'text',
                'value' => $this->form_validation->set_value('project_date', $result->project_date),
            );
            $this->data['category_code'] = array(
                'name' => 'category_code',
                'id' => 'category_code',
                'type' => 'text',
                'value' => $this->form_validation->set_value('category_code', $result->category_code),
            );
            // get projects category
            $this->data['categories'] = $this->post_model->read('project_categories')->result();
            //list the users
            $this->data['users'] = $this->post_model->read("users", ["id" => $this->ion_auth->get_user_id()])->row();
            $this->data['id'] = $id;
			$this->template->load('template', 'projects/edit', $this->data);
        }
    }

    public function ajax_list()
    {
        $option = array(
            'table'         => 'projects',
            'where'         => null,
            'column_search' => array('project_name', 'project_description', 'project_date'),
            'column_order'  => array(NULL,'project_name', 'project_description', 'project_date', 'updated_at', null),
            'order'         => array('id' => 'asc')
        );
        $getData = $this->datatable_model->get_datatables($option);
        $data    = array();
        $no      = $_POST['start'];
        foreach ($getData as $res) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$res->id.'">';
            $row[] = $res->project_name;
            $row[] = $res->project_description;
            $row[] = date('j F Y', strtotime($res->project_date));
            $row[] = date('j F Y', strtotime($res->updated_at));
			$row[] = '<a class="btn btn-xs btn-primary" href="projects/edit/'.$res->id.'" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a>
                  <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_projects('."'".$res->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			
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
            'table'         => 'projects'
        );
        $this->datatable_model->delete_by_id($id, $option);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_bulk_delete()
    {
        $option = array(
            'table'         => 'projects'
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
			redirect('bigadmin/projects', 'refresh');
		}
		redirect('/', 'refresh');
	}

}

/* End of file Department.php */
