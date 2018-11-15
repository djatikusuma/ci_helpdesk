<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Json extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('JsonModel');
    }
    

    public function getProvinces()
    {
        $getProvinces = $this->JsonModel->getJsonItem();

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode([
            'items' => 'provinces',
            'data'  => $getProvinces->result()
        ]);
    }

    public function getRegencies()
    {
        $province_id  = $this->input->post('province_id');
        $table        = $this->input->post('type');

        $getRegencies = $this->JsonModel->getJsonItem($table, array('province_id' => $province_id));

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode([
            'items' => 'regencies',
            'data'  => $getRegencies->result()
        ]);
    }

    public function getDistricts()
    {
        $regency_id = $this->input->post('regency_id');
        $table      = $this->input->post('type');

        $getDistricts = $this->JsonModel->getJsonItem($table, array('regency_id' => $regency_id));

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode([
            'items' => 'districts',
            'data'  => $getDistricts->result()
        ]);
    }

    public function getVillages()
    {
        $district_id = $this->input->post('district_id');
        $table      = $this->input->post('type');

        $getVillages = $this->JsonModel->getJsonItem($table, array('district_id' => $district_id));

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode([
            'items' => 'villages',
            'data'  => $getVillages->result()
        ]);
    }

}

/* End of file Json.php */