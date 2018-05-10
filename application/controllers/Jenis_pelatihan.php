<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_pelatihan extends CI_Controller {

	function __construct() {
        parent::__construct();
        checkSession();
    }

	public function index()
	{
        $userLevel = $this->session->userdata('checkUsers')['Users']['userLevel'];
        $menus = $this->Crud_model->getMenuActive($userLevel);
             
        $arr = Array();
		$obj = Array();
		foreach ($menus->result() as $value) {
			$arr['menuID'] = $value->id;
			$arr['menuName'] = $value->menu_name;
			$arr['menuUrl'] = $value->url;
			$arr['ada'] = $this->Crud_model->getCountFieldStatus($value->id, 'id_menu', 'submenus');
			$obj[] = $arr;
 		}
 		$data['menus'] = $obj;
        
		$data = array(
                       'baseUrl' => base_url(),
                       'dataUrl' => $this->uri->segment(1),
                       'dataLevel' => $this->Crud_model->getFindField(1, 'status', 'levels')->result(),
                       'getMenu' => $obj,
                       'getSubmenu' => $this->Crud_model->getFindFieldLevel(1, 'status', 'submenus', $userLevel)->result()
                     );
        $this->parser->parse('header', $data);
		$this->parser->parse('jenis_pelatihan', $data);
        $this->parser->parse('footer', $data);
        $this->parser->parse('app_js', $data);
	}
    
    public function ajax_list()
	{	
		$list = $this->Jenis_pelatihan_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $value) {
			$no++;

			$count = $this->Crud_model->getCountField($value->id, 'id_jenis_pelatihan', 'kuisioner');
			

   //          $level = $this->Crud_model->getFindField($value->level, 'id', 'levels');
   //          if($level->num_rows() > 0){
   //              $levelRow = $level->row();
   //              $levelName = $levelRow->name_level;
   //          }else{
   //              $levelName = '-';
   //          }

			if($value->status != 0){
				$status = "Active";
			}else{
				$status = "Not Active";
			}

			$row = array();
			$row[] = '<p class="text-center" style="margin-top:5px;margin-bottom:0px">'.$no.'</p>';
			$row[] = '<p style="margin-top:5px;margin-bottom:0px">'.$value->nama_jenis_pelatihan.'</p>';
			$row[] = '<p class="text-left" style="margin-top:5px;margin-bottom:0px">'.$status.'</p>';
            
            $row[] = '<div class="btn-group btn-group-sm" role="group" aria-label="...">
						<a href="'.base_url().'jenis_pelatihan/kuisioner/'.$value->id.'" class="btn btn-default" style="background-color:#34495e;color:#fff;border-color:#fff"><i class="fa fa-plus"></i></a>
						<a class="btn btn-default" style="background-color:#2c3e50;color:#fff;border-color:#fff"> '.$count.'&nbsp;&nbsp;<i class="fa fa-navicon"></i></a>
					  </div>';
			$row[] = '<a class="btn btn-sm btn-block btn-default" href="javascript:void(0)" title="Edit" onclick="editData('.$value->id.')" style="background-color:#f1c40f;color:#fff;border-color:#fff"><i class="fa fa-pencil"></i></a>';
			$row[] = '<a class="btn btn-sm btn-block btn-default" href="javascript:void(0)" title="Delete" onclick="deleteData('.$value->id.')" style="background-color:#e74c3c;color:#fff;border-color:#fff"><i class="fa fa-remove"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Jenis_pelatihan_model->count_all(),
						"recordsFiltered" => $this->Jenis_pelatihan_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
    
    public function ajax_add()
	{
		$data = array(
				'nama_jenis_pelatihan' => $this->input->post('jenis_pelatihan'),
				'status' => $this->input->post('status'),
			);

		$this->Crud_model->save($data, 'jenis_pelatihan');

		echo json_encode(array("status" => TRUE));
	}

	public function ajax_edit($id)
	{
		$data = $this->Crud_model->getFind($id, 'jenis_pelatihan');
		echo json_encode($data);
	}

	public function ajax_update()
	{
		$data = array(
				'nama_jenis_pelatihan' => $this->input->post('jenis_pelatihan'),
				'status' => $this->input->post('status'),
			);
		$this->Crud_model->update(array('id' => $this->input->post('id')), $data, 'jenis_pelatihan');
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{		
		$this->Crud_model->delete_by_id($id, 'jenis_pelatihan');
		echo json_encode(array("status" => TRUE));
	}
    
    public function kuisioner()
    {
    	$userLevel = $this->session->userdata('checkUsers')['Users']['userLevel'];
        $menus = $this->Crud_model->getMenuActive($userLevel);
        $menuName = $this->Crud_model->getFindField($this->uri->segment(3), 'id', 'menus')->row();
        $jenisPelatihan = $this->Crud_model->getFindField($this->uri->segment(3), 'id', 'jenis_pelatihan')->row();
             
        $arr = Array();
		$obj = Array();
		foreach ($menus->result() as $value) {
			$arr['menuID'] = $value->id;
			$arr['menuName'] = $value->menu_name;
			$arr['menuUrl'] = $value->url;
			$arr['ada'] = $this->Crud_model->getCountFieldStatus($value->id, 'id_menu', 'submenus');
			$obj[] = $arr;
 		}
 		$data['menus'] = $obj;
        
		$data = array(
                       'baseUrl' => base_url(),
                       'dataUrl' => $this->uri->segment(2),
                       'dataID' => $this->uri->segment(3),
                       // 'dataMenu' => $menuName->menu_name,
                       'jenisPelatihan' => $jenisPelatihan->nama_jenis_pelatihan,
                       'dataLevel' => $this->Crud_model->getFindField(1, 'status', 'levels')->result(),
                       'getMenu' => $obj,
                       'getSubmenu' => $this->Crud_model->getFindFieldLevel(1, 'status', 'submenus', $userLevel)->result()
                     );
        $this->parser->parse('header', $data);
		$this->parser->parse('kuisioner', $data);
        $this->parser->parse('footer', $data);
        $this->parser->parse('custom_app_js/app_js', $data);
    }
}
