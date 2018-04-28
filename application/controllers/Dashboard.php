<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct() {
        parent::__construct();
        checkSession();
    }

	public function index()
	{
		$data = array('baseUrl' => base_url());
		$this->parser->parse('dashboard', $data);
	}

	public function try()
	{
		echo 2;
	}
    
}
