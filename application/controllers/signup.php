<?php // signup.php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->library('form_validation');
		// field name, error message, validation rules...
	}
	
	function index() {
		$data['main_content'] = 'users/signup_form';
		$this->load->view('includes/template', $data);
	}
	
	function validate_credentials_user() {
		$this->form_validation->set_rules('email_address', '常用邮箱', 'trim|required|xss_clean|valid_email|max_length[60]|callback_email_exists');
		$this->form_validation->set_rules('phone_number', '电话/手机', 'trim|required|xss_clean|numeric|min_length[10]|max_length[10]|callback_phone_exists');
		$this->form_validation->set_rules('user_name', '姓名', 'trim|required|xss_clean|max_length[32]');
		$this->form_validation->set_rules('password', '密码', 'trim|required|xss_clean|min_length[4]|max_length[16]');
		$this->form_validation->set_rules('password2', '确认密码', 'trim|required|xss_clean|matches[password]');
		
		if($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			if($query = $this->user_model->create_user()) {
				$data['main_content'] = 'users/signup_successful';
				$this->load->view('includes/template', $data);
			} else {
				$this->load->view('users/signup_form');
			}
		}
	}
	
	function phone_exists($phonenumber) 
	{
	    $user_check = $this->user_model->phone_exists($phonenumber);
	    if($user_check > 0) {
	        $this->form_validation->set_message('phone_exists', '电话/手机号码已存在');
	        return FALSE;
	    } else {
	        return TRUE;
	    }
	}
	
	function email_exists($email) {
	    $check_email = $this->user_model->email_exists($email);
	    if($check_email > 0) {
	        $this->form_validation->set_message('email_exists', '邮箱地址已经被注册');
	        return FALSE;
	    } else {
	        return TRUE;
	    }
	}
}