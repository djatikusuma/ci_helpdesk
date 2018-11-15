<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		/*$date = date("d-m-Y");
    	$jadwal = json_decode(file_get_contents("https://api.aladhan.com/v1/timings/{$date}?latitude=-6.9187951&longitude=107.7221825"));
    	
    	echo $jadwal->data->timings->Fajr;*/
    	echo "Website under construction";
	}
	
	public function test($n=null){
		$page = explode(" ", trim("#page $n"));
		$BaseSizeBuilder = [];
		
		$width = 333;
		$height = 97;
		
		$pages = count($page) > 1 ? $page[1] : 1;
        $id = ( $pages==1 ? 1 : 
			        ( ($pages==2) ? 24 : ( ($pages==3) ? 47 : ( ($pages==4) ? 70 : 93))));
		$awal = $id;
		
		$akhir = $id + 2;
		//$awal = $page;
		//Kebawah
		
		$areaY = 92;
		for($n = 1; $n<=7; $n++){
		    // Kepinggir
		    $areaX = 9;
		    for($i = $awal; $i<=$akhir; $i++){
		        $BaseSizeBuilder[] = [
		            "#quran {$i}",
		            ["AreaBuilder"=>[$areaX, $areaY, $width, $height]]
		        ];
		        $areaX += ($width+9);
		        
		    }
		    //echo "($akhir)<hr>";
		    
		    $areaY += ($height+21);
		    $awal = $akhir + 1;
		    $akhir = $akhir + 3;
		}
		
		if($pages < 5){
			$n = 1;
		    for($i = $awal; $i<=$akhir-1; $i++){
		    	$areaX = ($n == 1) ? 9 : 693;
		        $BaseSizeBuilder[] = [
		            "#quran {$i}",
		            ["AreaBuilder"=>[$areaX, $areaY, $width, $height]]
		        ];
		        $n++;
		    }
		}else{
			$BaseSizeBuilder[] = [
	            "#quran {$i}",
	            ["AreaBuilder"=>[351, $areaY, $width, $height]]
	        ];
		}
		header('Content-Type: application/json');
		
		echo json_encode($BaseSizeBuilder);
	}
	
	function event_bro(){
		$this->load->model("event_model");
		
		$page      = empty($this->input->get('page')) ? 1 : $this->input->get('page');
		$perpage   = 9;
		$getList   = $this->event_model->read(['status' => 'publish', "event_start >=" => date("Y-m-d G:i:s")], "event_start", "DESC", $perpage, ($page-1)*$perpage)->result();
		$query     = $this->event_model->read(['status' => 'publish', "event_start >=" => date("Y-m-d G:i:s")]);
		$count     = $query->num_rows();
		$totalPage = floor($count / $perpage);
        
        $data      = [
        	'status'        => 200,
            'message'       => count($getList) < 1 ? 'fail' : 'success',
            'next_page'     => ($page>=$totalPage) ? null : $page+1,
            'result'        => $getList
        ];

        header('Content-Type: application/json');
        echo json_encode($data);
	}
}
