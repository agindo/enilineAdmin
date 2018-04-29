<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
                        'username' => $this->session->userdata('checkUsers')['Users']['userName'],
                        'getMenu' => $obj,
                        'getSubmenu' => $this->Crud_model->getFindFieldLevel(1, 'status', 'submenus', $userLevel)->result()
                     );
        $this->parser->parse('header', $data);
		$this->parser->parse('dashboard', $data);
        $this->parser->parse('footer', $data);
	}
    
}
