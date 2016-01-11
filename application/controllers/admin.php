<?php // admin_login.php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('admin_user_model','',TRUE);
		if($this->session->userdata('is_logged_in_admin'))
		{
			$this->admin_user_session = $this->session->userdata('is_logged_in_admin');
		}
	}
	
	function index()
	{
		if(isset($this->admin_user_session)) {
			redirect('control_panel', 'refresh');
		} else {
		$data['main_content'] = 'admin_login_form';
		$this->load->view('includes/template', $data);
		}
	}

	function validate_credentials()
	{
		$query = $this->admin_user_model->validate();

		if($query) // if the user's credentials validated...
		{
			$data = array(
//				'username' => $this->input->post('username'),
				'is_logged_in_admin' => true
			);

			$this->session->set_userdata($data);
			redirect('control_panel', 'refresh');
		}
		else
		{
			// $this->index();
			$data['error'] = '错误的用户名/密码组合<br>如果您忘记密码请联系管理员 <a href="mailto:alfredzhu963@gmail.com">Alfred Zhu</a>';
			$data['main_content'] = 'admin_login_form';
			$this->load->view('includes/template', $data);
		}
	}
}

?>