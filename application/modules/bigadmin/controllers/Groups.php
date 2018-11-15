<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends CI_Controller {

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
			$this->template->load('template', 'groups/view', $this->data);
        }
    }

    
	/**
	 * Create a new group
	 */
	public function create_group()
	{
		$this->data['title'] = $this->lang->line('create_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('bigadmin', 'refresh');
		}

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'trim|required|alpha_dash');

		if ($this->form_validation->run() === TRUE)
		{
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if ($new_group_id)
			{
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("bigadmin/groups", 'refresh');
			}
		}
		else
		{
			// display the create group form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['group_name'] = array(
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('group_name'),
			);
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('description'),
			);

			//list the users
			$this->data['users'] = $this->post_model->read("users", ["id" => $this->ion_auth->get_user_id()])->row();
			$this->template->load('template', 'auth/create_group', $this->data);
		}
	}

	/**
	 * Edit a group
	 *
	 * @param int|string $id
	 */
	public function edit_group($id)
	{
		// bail if no group id given
		if (!$id || empty($id))
		{
			redirect('bigadmin', 'refresh');
		}

		$this->data['title'] = $this->lang->line('edit_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('bigadmin/', 'refresh');
		}

		$group = $this->ion_auth->group($id)->row();

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

				if ($group_update)
				{
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("bigadmin/groups", 'refresh');
			}
		}

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['group'] = $group;

		$readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

		$this->data['group_name'] = array(
			'name'    => 'group_name',
			'id'      => 'group_name',
			'type'    => 'text',
			'value'   => $this->form_validation->set_value('group_name', $group->name),
			$readonly => $readonly,
		);
		$this->data['group_description'] = array(
			'name'  => 'group_description',
			'id'    => 'group_description',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_description', $group->description),
        );
        //list the users
		$this->data['users'] = $this->post_model->read("users", ["id" => $this->ion_auth->get_user_id()])->row();
        $this->template->load('template', 'auth/edit_group', $this->data);
    }
    
    public function ajax_list()
    {
        $option = array(
            'table'         => 'groups',
            'where'         => null,
            'column_search' => array('name'),
            'column_order'  => array(NULL,'name','description', null),
            'order'         => array('id' => 'asc')
        );
        $getData = $this->datatable_model->get_datatables($option);
        $data    = array();
        $no      = $_POST['start'];
        foreach ($getData as $res) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $res->name;
            $row[] = $res->description;
            if($res->id != 1){
				$row[] = '<a class="btn btn-xs btn-primary" href="groups/edit_group/'.$res->id.'" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a>
                  <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_groups('."'".$res->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			}else{
				$row[] = "";
			}
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
            'table'         => 'groups'
        );
        $this->datatable_model->delete_by_id($id, $option);
        echo json_encode(array("status" => TRUE));
    }

}

/* End of file Groups.php */
