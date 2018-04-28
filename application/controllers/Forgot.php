<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot extends CI_Controller {

	public function index()
	{
        checkLogin();
		$data = array('baseUrl' => base_url());
		$this->parser->parse('forgot', $data);
	}
    
    public function send()
    {
    	date_default_timezone_set("Asia/jakarta");

        $email = $this->input->post('email');
        $check = $this->Crud_model->getFindField($email, 'email', 'users');

        $user = $check->row();
  		$user_token = $user->id;

        $date_create_token = date("Y-m-d H:i");
  		$date_expired_token = date('Y-m-d H:i',strtotime('+2 hour',strtotime($date_create_token)));

  		$tokenstring = md5(sha1($user_token.$date_create_token));

  		$data = array(
  					'token'=>$tokenstring,
  					'created'=>$date_create_token,
  					'expired'=>$date_expired_token
  				);
  		$this->Crud_model->update(array('id' => $user->id), $data, 'users');

        if($check->num_rows() > 0){
	    	$config = Array(
	            'protocol' => 'smtp',
	            'smtp_host' => 'ssl://smtp.googlemail.com',
	            'smtp_port' => 465,
	            'smtp_user' => 'codingmuofficial@gmail.com', // change it to yours
	            'smtp_pass' => 'p@ssIscodingmu', // change it to yours
	            'mailtype' => 'html',
	            'charset' => 'iso-8859-1',
	            'wordwrap' => TRUE
	        );

	        $message = 'Click here to reset your password : <a href="'.base_url().'forgot/reset/'.$tokenstring.'">Click</a>';
	        $this->load->library('email', $config);
	        $this->email->set_newline("\r\n");
	        $this->email->from('codingmuofficial@gmail.com', 'Hi'); // change it to yours
	        $this->email->to($email);// change it to yours
	        $this->email->subject('reset your password for eniline');
	        $this->email->message($message);
	        if($this->email->send()){
	        	$warning = "<div class='alert alert-success alert-dismissible' role='alert'>
  	 				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  	 				<strong>Success!</strong> Your email has been sent. Please check your email <strong>".$email."</strong>
			 	  </div>";
				echo $this->session->set_flashdata('message', $warning);
				redirect(base_url().'forgot');
	        }else{
	           show_error($this->email->print_debugger());
	        }
        }else{
			$warning = '<div class="alert alert-warning" style="padding-bottom:10px;padding-top:10px">
			              	<strong>Warning!</strong> Your email or password is wrong. 
			            </div>';
			echo $this->session->set_flashdata('message', $warning);
			redirect(base_url().'forgot');
        }
    }

    public function reset()
    {
    	date_default_timezone_set("Asia/jakarta");
  		$token = $this->uri->segment(3);

  		if($token == ""){
  			redirect(base_url().'forgot');
  		}else{
  			$cekToken = $this->Crud_model->getFindField($token, 'token', 'users');
  			$ada = $cekToken->num_rows();
  			if($ada > 0){
  				$data = $cekToken->row();
	    		$tokenExpired = $data->expired;
	    		$timenow = date("Y-m-d H:i:s");
	    		if ($timenow < $tokenExpired){
	    			$data = array('baseUrl' => base_url(), 'token' => $data->token);
					$this->parser->parse('reset', $data);
	    		}else{
	    			$warning = "<div class='alert alert-warning alert-dismissible' role='alert'>
  								<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  								<strong>Warning!</strong> Your email is wrong.
				  			</div>";
					echo $this->session->set_flashdata('message', $warning);
      				redirect(base_url().'reset');
	    		}
  			}else{
  				redirect(base_url().'forgot');
  			}
  		}

  		// $cekToken = $this->Crud_model->getFindField($token, 'token', 'users');

  		// $ada = $cekToken->num_rows();

  	// 	if($ada > 0){
  	// 		$data = $cekToken->row();
	  //   	$tokenExpired = $data->expired;
	  //   	$timenow = date("Y-m-d H:i:s");
	  //   	if ($timenow < $tokenExpired){
	  //   		$data = array('baseUrl' => base_url());
			// 	$this->parser->parse('reset', $data);
	  //   	}else{
	  //   		$warning = "<div class='alert alert-warning alert-dismissible' role='alert'>
  	// 							<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  	// 							<strong>Warning!</strong> Your email is wrong.
			// 	  			</div>";
			// 	echo $this->session->set_flashdata('message', $warning);
   //    			redirect(base_url().'reset');
	  //   	}
  	// 	}else{
  	// 		$warning = "<div class='alert alert-warning alert-dismissible' role='alert'>
  	// 						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  	// 						<strong>Warning!</strong> Your email is wrong.
			// 	  		</div>";
			// echo $this->session->set_flashdata('message', $warning);
   //  		redirect (base_url().'reset');
  	// 	}
    }

    public function sendReset()
    {
    	$password = $this->input->post('new_password');
  		$token = $this->input->post('token');
  		$cekToken = $this->Crud_model->getFindField($token, 'token', 'users');
  		$data = $cekToken->row();
  		$id = $data->id;
   
  		// ubah password

  		$data = array('password'=>md5($password));

		// $this->crud_model->update(array('id' => $this->input->post('id')), $data, 'users');
  		// $data = array ('password'=>md5($password));
  		$simpan = $this->Crud_model->update(array('id'=>$id), $data, 'users');
 
  		if ($simpan > 0){
    		$warning = "<div class='alert alert-success alert-dismissible' role='alert'>
  					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  					<strong>Successfully!</strong> password has been update, please try login.
				  </div>";
			echo $this->session->set_flashdata('message', $warning);
			redirect(base_url());
  		}else{
    		$warning = "<div class='alert alert-warning alert-dismissible' role='alert'>
  					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  					<strong>Warning!</strong> password can not be updated, please send again, please send again.
				  </div>";
			echo $this->session->set_flashdata('message', $warning);
			redirect(base_url().'forgot');
  		}
  		
    }
    
}
