<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		checkLogin();
		$data = array(
                        'baseUrl' => base_url()
                     );
		// $this->load->view('welcome_message');
		$this->parser->parse('welcome_message', $data);
	}

	public function coba()
	{
		echo $this->input->post('email');
	}
	
}
