<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

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
		$this->parser->parse('menu', $data);
        $this->parser->parse('footer', $data);
        $this->parser->parse('app_js', $data);
	}
    
    public function ajax_list()
	{	
		$list = $this->Menu_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $value) {
			$no++;

            $level = $this->Crud_model->getFindField($value->level, 'id', 'levels');
            if($level->num_rows() > 0){
                $levelRow = $level->row();
                $levelName = $levelRow->name_level;
            }else{
                $levelName = '-';
            }

			if($value->status != 0){
				$status = "Active";
			}else{
				$status = "Not Active";
			}

			$row = array();
			$row[] = '<p class="text-center" style="margin-top:5px;margin-bottom:0px">'.$no.'</p>';
			$row[] = '<p style="margin-top:5px;margin-bottom:0px">'.$value->menu_name.'</p>';
            $row[] = '<p style="margin-top:5px;margin-bottom:0px">'.$value->url.'</p>';
            $row[] = '<p style="margin-top:5px;margin-bottom:0px">'.$levelName.'</p>';
			$row[] = '<p class="text-left" style="margin-top:5px;margin-bottom:0px">'.$status.'</p>';
            
			$row[] = '<a class="btn btn-sm btn-block btn-default" href="javascript:void(0)" title="Edit" onclick="editData('.$value->id.')" style="background-color:#f1c40f;color:#fff;border-color:#fff"><i class="fa fa-pencil"></i></a>';
			$row[] = '<a class="btn btn-sm btn-block btn-default" href="javascript:void(0)" title="Delete" onclick="deleteData('.$value->id.')" style="background-color:#e74c3c;color:#fff;border-color:#fff"><i class="fa fa-remove"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Menu_model->count_all(),
						"recordsFiltered" => $this->Menu_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
    
    public function ajax_add()
	{
		$data = array(
				'menu_name' => $this->input->post('menu_name'),
                'url' => $this->input->post('url'),
                'level' => $this->input->post('level'),
				'status' => $this->input->post('status'),
			);

		$this->Crud_model->save($data, 'menus');

		echo json_encode(array("status" => TRUE));
	}

	public function ajax_edit($id)
	{
		$data = $this->Crud_model->getFind($id, 'menus');
		echo json_encode($data);
	}

	public function ajax_update()
	{
		$data = array(
				'menu_name' => $this->input->post('menu_name'),
                'url' => $this->input->post('url'),
                'level' => $this->input->post('level'),
				'status' => $this->input->post('status'),
			);
		$this->Crud_model->update(array('id' => $this->input->post('id')), $data, 'menus');
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{		
		$this->Crud_model->delete_by_id($id, 'menus');
		echo json_encode(array("status" => TRUE));
	}
    
}
