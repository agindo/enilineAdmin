<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function index()
	{
		$email = $this->input->post('email');
		$password = md5($this->input->post('password'));
		// echo $email." - ".$password;
		$check = $this->Auth_model->auth($email, $password);
		$user = $this->Auth_model->authUsers($email, $password);
		if($check == 1){
			$this->session->set_userdata(array('statusUsers'=>1, 'checkUsers'=>$user));
			redirect(base_url().'dashboard');
		}else{
			$warning = '<div class="alert alert-warning" style="padding-bottom:10px;padding-top:10px">
                            <strong>Warning!</strong> Your email or password is wrong. 
                        </div>';
			echo $this->session->set_flashdata('message', $warning);
			redirect(base_url());
		}
	}

}
