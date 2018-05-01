<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subdiklat extends CI_Controller {

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
                       'getMenu' => $obj,
                       'getSubmenu' => $this->Crud_model->getFindFieldLevel(1, 'status', 'submenus', $userLevel)->result(),
                       'diklat' => $this->Crud_model->getFindField(1, 'status', 'diklat')->result()
                     );
        $this->parser->parse('header', $data);
		$this->parser->parse('subdiklat', $data);
        $this->parser->parse('footer', $data);
        $this->parser->parse('app_js', $data);
	}
    
    public function ajax_list()
	{	
		$id = $this->uri->segment(3);
		$list = $this->Subdiklat_model->get_datatables($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $value) {
			$no++;

			$count = $this->Crud_model->getCountField($value->id, 'id_subdiklat', 'angkatan');

            $diklat = $this->Crud_model->getFindField($value->id_diklat, 'id', 'diklat');
            if($diklat->num_rows() > 0){
                $diklatRow = $diklat->row();
                $diklatName = $diklatRow->diklat_name;
            }else{
                $diklatName = '-';
            }

			if($value->status != 0){
				$status = "Active";
			}else{
				$status = "Not Active";
			}

			$row = array();
			$row[] = '<p class="text-center" style="margin-top:5px;margin-bottom:0px">'.$no.'</p>';
			$row[] = '<p style="margin-top:5px;margin-bottom:0px">'.$diklatName.' / '.$value->subdiklat_name.'</p>';
			$row[] = '<p class="text-left" style="margin-top:5px;margin-bottom:0px">'.$status.'</p>';
            
            $row[] = '<div class="btn-group btn-group-sm" role="group" aria-label="...">
						<a href="'.base_url().'subdiklat/angkatan/'.$value->id.'" class="btn btn-default" style="background-color:#34495e;color:#fff;border-color:#fff"><i class="fa fa-plus"></i></a>
						<a class="btn btn-default" style="background-color:#2c3e50;color:#fff;border-color:#fff"> '.$count.'&nbsp;&nbsp;<i class="fa fa-flag"></i></a>
					  </div>';
			$row[] = '<a class="btn btn-sm btn-block btn-default" href="javascript:void(0)" title="Edit" onclick="editData('.$value->id.')" style="background-color:#f1c40f;color:#fff;border-color:#fff"><i class="fa fa-pencil"></i></a>';
			$row[] = '<a class="btn btn-sm btn-block btn-default" href="javascript:void(0)" title="Delete" onclick="deleteData('.$value->id.')" style="background-color:#e74c3c;color:#fff;border-color:#fff"><i class="fa fa-remove"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Subdiklat_model->count_all($id),
						"recordsFiltered" => $this->Subdiklat_model->count_filtered($id),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
    
    public function ajax_add()
	{
		$data = array(
				'subdiklat_name' => $this->input->post('subdiklat_name'),
                'id_diklat' => $this->input->post('id_diklat'),
				'status' => $this->input->post('status'),
			);

		$this->Crud_model->save($data, 'subdiklat');

		echo json_encode(array("status" => TRUE));
	}

	public function ajax_edit($id)
	{
		$data = $this->Crud_model->getFind($id, 'subdiklat');
		echo json_encode($data);
	}

	public function ajax_update()
	{
		$data = array(
				'subdiklat_name' => $this->input->post('subdiklat_name'),
                // 'id_diklat' => $this->input->post('id_diklat'),
				'status' => $this->input->post('status'),
			);
		$this->Crud_model->update(array('id' => $this->input->post('id')), $data, 'subdiklat');
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{		
		$this->Crud_model->delete_by_id($id, 'subdiklat');
		echo json_encode(array("status" => TRUE));
	}

	public function angkatan()
    {
    	$userLevel = $this->session->userdata('checkUsers')['Users']['userLevel'];
        $menus = $this->Crud_model->getMenuActive($userLevel);
        $subdiklatName = $this->Crud_model->getFindField($this->uri->segment(3), 'id', 'subdiklat')->row();
             
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
                       'dataSubdiklat' => $subdiklatName->subdiklat_name,
                       'dataLevel' => $this->Crud_model->getFindField(1, 'status', 'levels')->result(),
                       'getMenu' => $obj,
                       'getSubmenu' => $this->Crud_model->getFindFieldLevel(1, 'status', 'submenus', $userLevel)->result()
                     );
        $this->parser->parse('header', $data);
		$this->parser->parse('angkatan', $data);
        $this->parser->parse('footer', $data);
        $this->parser->parse('custom_app_js/app_js', $data);
    }
    
}
