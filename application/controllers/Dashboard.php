<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct() {
        parent::__construct();
        checkSession();
    }

	public function index()
	{
		$data = array(
                        'baseUrl' => base_url(),
                        'username' => $this->session->userdata('checkUsers')['Users']['userName']
                     );
        $this->parser->parse('header', $data);
		$this->parser->parse('dashboard', $data);
        $this->parser->parse('footer', $data);
	}
    
}
