<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kuisioner extends CI_Controller {

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
		$this->parser->parse('kuisioner', $data);
        $this->parser->parse('footer', $data);
        $this->parser->parse('app_js', $data);
	}
    
    public function ajax_list()
	{	
		$id = $this->uri->segment(3);
		$list = $this->Kuisioner_model->get_datatables($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $value) {
			$no++;

            // $diklat = $this->Crud_model->getFindField($value->id_diklat, 'id', 'diklat');
            // if($diklat->num_rows() > 0){
            //     $diklatRow = $diklat->row();
            //     $diklatName = $diklatRow->diklat_name;
            // }else{
            //     $diklatName = '-';
            // }

			if($value->status != 0){
				$status = "Active";
			}else{
				$status = "Not Active";
			}

			$row = array();
			$row[] = '<p class="text-center" style="margin-top:5px;margin-bottom:0px">'.$no.'</p>';
			$row[] = '<p style="margin-top:5px;margin-bottom:0px">'.$value->kuisioner_name.'</p>';
			$row[] = '<p class="text-left" style="margin-top:5px;margin-bottom:0px">'.$status.'</p>';
            
			$row[] = '<a class="btn btn-sm btn-block btn-default" href="javascript:void(0)" title="Edit" onclick="editData('.$value->id.')" style="background-color:#f1c40f;color:#fff;border-color:#fff"><i class="fa fa-pencil"></i></a>';
			$row[] = '<a class="btn btn-sm btn-block btn-default" href="javascript:void(0)" title="Delete" onclick="deleteData('.$value->id.')" style="background-color:#e74c3c;color:#fff;border-color:#fff"><i class="fa fa-remove"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Kuisioner_model->count_all($id),
						"recordsFiltered" => $this->Kuisioner_model->count_filtered($id),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
    
    public function ajax_add()
	{
		$data = array(
				'kuisioner_name' => $this->input->post('kuisioner_name'),
                'id_jenis_pelatihan' => $this->input->post('id_jenis_pelatihan'),
				'status' => $this->input->post('status'),
			);

		$this->Crud_model->save($data, 'kuisioner');

		echo json_encode(array("status" => TRUE));
	}

	public function ajax_edit($id)
	{
		$data = $this->Crud_model->getFind($id, 'kuisioner');
		echo json_encode($data);
	}

	public function ajax_update()
	{
		$data = array(
				'kuisioner_name' => $this->input->post('kuisioner_name'),
				'status' => $this->input->post('status'),
			);
		$this->Crud_model->update(array('id' => $this->input->post('id')), $data, 'kuisioner');
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{		
		$this->Crud_model->delete_by_id($id, 'kuisioner');
		echo json_encode(array("status" => TRUE));
	}
    
}
