<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_Model extends CI_Model {

	public function auth($email, $password){
		$check = $this->db->get_where('users', array('email'=>$email, 'password'=>$password));
		if($check->num_rows() > 0) {
			return 1;
		}else{
			return 0;
		}
	}

	public function authUsers($email, $password){
		$check = $this->db->get_where('users', array('email'=>$email, 'password'=>$password))->row();
		$arr = Array();
		$obj = Array();
		$arr['userID'] = $check->id;
		$arr['userName'] = $check->name;
		$arr['userLevel'] = $check->level;
		$obj['Users'] = $arr;
		
		return $obj;
	}

	public function getUsersByEmail($email)
	{
		return $this->db->get_where('users', array('email'=>$email));
	}

	// public function insertToken($id)  
 //   	{    
 //   		date_default_timezone_set("Asia/Jakarta");
 //    	$token = substr(sha1(rand()), 0, 30);   
 //     	$date = date("Y-m-d h:i:sa");  
       
 //     	$data = array(  
 //         	'token'=> $token,    
 //         	'created_at'=>$date,  
 //       	);  

 //       	$this->db->update('users', $data, $id);
     	// $this->db->insert_string('user',$string); 
     	// $this->db->query($query);  
     	// return $token . $user_id;     
   // }

}
