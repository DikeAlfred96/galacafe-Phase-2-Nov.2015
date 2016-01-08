<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->is_logged_in();
		$this->load->model('user_model');
	}
	
	
	function index() {
		$data['result_order'] = $this->user_model->fetch_user_order_history();
		$data['result_dishes'] = $this->user_model->fetch_user_order_item_history();
		$data['main_content'] = 'users/profile';
		$this->load->view('includes/template', $data);
	}
	
	public function is_logged_in() {
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			$data['error'] = '请先登录！';
			redirect('login', 'refresh');
		}
	}
	
	function logout() {
	    $this->session->unset_userdata('is_logged_in');
	    $this->session->unset_userdata('nickname');
	    $this->session->unset_userdata('phonenumber');
	    $data['error'] = '您已成功登出系统！谢谢';
		$data['main_content'] = 'users/login_form';
		$this->load->view('includes/template', $data);
	}
}