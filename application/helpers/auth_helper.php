<?php
	function checkSession(){
		$CI = & get_instance();
		$check = $CI->session->userdata('statusUsers');
		if($check != 1) {
			redirect(base_url());
		}
	}

	function checkLogin(){
		$CI = & get_instance();
		$check = $CI->session->userdata('statusUsers');
		if($check == 1) {
			redirect('dashboard');
		}
	}
?>