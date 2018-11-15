<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Departments extends CI_Controller {

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
			$this->template->load('template', 'department/view', $this->data);
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
            $this->form_validation->set_rules('department_name', "Department Name", 'trim|required');
            $this->form_validation->set_rules('department_description', "Department Description", 'trim');
            $post = $this->input->post(NULL, TRUE);
            if ($this->form_validation->run() === TRUE)
            {
                $data = [
                    'department_name'        => $post['department_name'],
                    'department_description' => $post['department_description'],
                    'created_at'             => date('Y-m-d h:i:s')
                ];

                if(($this->post_model->create('departments', $data)) > 0)
                    redirect("bigadmin/departments", 'refresh');
            }
            else
            {
                // display the create user form
                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

                $this->data['department_name'] = array(
                    'name' => 'department_name',
                    'id' => 'department_name',
                    'type' => 'text',
                    'value' => $this->form_validation->set_value('department_name'),
                );
                $this->data['department_description'] = array(
                    'name' => 'department_description',
                    'id' => 'department_description',
                    'type' => 'text',
                    'value' => $this->form_validation->set_value('department_description'),
                );
            }
            //list the users
			$this->data['users'] = $this->post_model->read("users", ["id" => $this->ion_auth->get_user_id()])->row();
			$this->template->load('template', 'department/add', $this->data);
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
            $this->form_validation->set_rules('department_name', "Department Name", 'trim|required');
            $this->form_validation->set_rules('department_description', "Department Description", 'trim');
            $post = $this->input->post(NULL, TRUE);
            if ($this->form_validation->run() === TRUE)
            {
                $data = [
                    'department_name' => $post['department_name'],
                    'department_description' => $post['department_description']
                ];
                if($this->post_model->update('departments', $data, ['id' => $id]) > 0)
                    $this->redirects();
            }
            

            $result = $this->post_model->read('departments', ['id' => $id])->row();

            $this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

            $this->data['department_name'] = array(
                'name' => 'department_name',
                'id' => 'department_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('department_name', $result->department_name),
            );
            $this->data['department_description'] = array(
                'name' => 'department_description',
                'id' => 'department_description',
                'type' => 'text',
                'value' => $this->form_validation->set_value('department_description', $result->department_description),
            );
            //list the users
            $this->data['users'] = $this->post_model->read("users", ["id" => $this->ion_auth->get_user_id()])->row();
            $this->data['id'] = $id;
			$this->template->load('template', 'department/edit', $this->data);
        }
    }

    public function ajax_list()
    {
        $option = array(
            'table'         => 'departments',
            'where'         => null,
            'column_search' => array('department_name', 'department_description'),
            'column_order'  => array(NULL,'department_name', 'department_description', null),
            'order'         => array('id' => 'asc')
        );
        $getData = $this->datatable_model->get_datatables($option);
        $data    = array();
        $no      = $_POST['start'];
        foreach ($getData as $res) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$res->id.'">';
            $row[] = $res->department_name;
            $row[] = $res->department_description;
            $row[] = date('j F Y', strtotime($res->updated_at));
			$row[] = '<a class="btn btn-xs btn-primary" href="departments/edit/'.$res->id.'" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a>
                  <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_departments('."'".$res->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			
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
            'table'         => 'departments'
        );
        $this->datatable_model->delete_by_id($id, $option);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_bulk_delete()
    {
        $option = array(
            'table'         => 'departments'
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
			redirect('bigadmin/departments', 'refresh');
		}
		redirect('/', 'refresh');
	}

}

/* End of file Department.php */
