<?php // admin_login.php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model','',TRUE);
		$this->load->library('form_validation'); // field name, error message, validation rules...
		$this->load->library('email'); // email plug
		if($this->session->userdata('is_logged_in'))
		{
			$this->user_session = $this->session->userdata('is_logged_in');
		}
	}
	
	function index()
	{
		if(isset($this->user_session))
		{
			redirect('profile', 'refresh');
		}
		else
		{
		$data['main_content'] = 'users/login_form';
		$this->load->view('includes/template', $data);
		}
	}

	function validate_credentials_user()
	{
		$query = $this->user_model->validate_user();
		
		if($query) { // if the user's credentials validated...
//			$result = $this->db->query($sql);
			$sql = $this->db->query('SELECT userName, userTel FROM users WHERE (userEmail=\''.$this->input->post('username').'\' OR userTel=\''.$this->input->post('username').'\') LIMIT 1');
			$row = $sql->row();
			$data = array(
				'nickname' => $row->userName,
				'phonenumber' => $row->userTel,
				'is_logged_in' => true
			);

			$this->session->set_userdata($data);
			redirect('profile', 'refresh');
		} else {
			// $this->index();
			$data['error'] = '错误的用户名/密码组合';
			$data['main_content'] = 'users/login_form';
			$this->load->view('includes/template', $data);
		}
	}
	
	function reset_password_user()
	{
		if(isset($_POST['email_address']))
		{
			$this->form_validation->set_rules('email_address', '邮箱地址', 'trim|required|valid_email|max_length[60]|xss_clean');
			
			if($this->form_validation->run() == FALSE)
			{
				// email didn't validate, kick back errors
				$data['main_content'] = 'users/reset_password';
				$this->load->view('includes/template', $data);
			}
			else
			{
				$email = trim($this->input->post('email_address'));
				$result = $this->user_model->reset_email_exists($email);
				
				if($result)
				{ // if we found the email in the database...Result is the userName
					$this->send_reset_password_user($email, $result);
					$data['email'] = $email;
					$data['main_content'] = 'users/reset_password_sent';
					$this->load->view('includes/template', $data);
				}
				else{
					$data['error'] = '此邮箱地址不存在，<a href="'.base_url().'signup">注册新用户</a>';
					$data['main_content'] = 'users/reset_password';
					$this->load->view('includes/template', $data);
				}
			}
		}
		else
		{
			$data['main_content'] = 'users/reset_password';
			$this->load->view('includes/template', $data);
		}
	}
	
	public function reset_password_form_user($email, $email_code)
	{
		if(isset($email, $email_code))
		{
			$email = trim($email);
			$email_hash = sha1($email . $email_code);
			$verified = $this->user_model->verify_user_reset_password_code($email, $email_code);
			
			if($verified)
			{
				$data['email'] = $email;
				$data['email_hash'] = $email_hash;
				$data['email_code'] = $email_code;
				$data['main_content'] = 'users/update_password';
				$this->load->view('includes/template', $data);
			}
			else
			{
				$data['email'] = $email;
				$data['error'] = '抱歉，我们无法完成您的请求，请重新点击邮箱中的链接或重新请求新的链接并重试，谢谢！';
				$data['main_content'] = 'users/update_password';
				$this->load->view('includes/template', $data);
			}
		}
		else
		{
			redirect('login/reset_password_user','refresh');
		}
	}
	
	private	function send_reset_password_user($email, $userName)
	{
		$email_code = md5($this->config->item('salt') . $userName);
		
		$this->email->set_mailtype('html');
		$this->email->from($this->config->item('customer_email'), 'Gala Cafe - 旮旯小馆');
		$this->email->to($email);
		$this->email->subject('旮旯小馆用户密码重置');
		
		$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html><head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		</head><body>';
		$message .= '<p>亲爱的 ' . $userName . ',</p>';
		$message .= '<p>您请求重置您在旮旯小馆网站的登录密码！请点击下面链接重置您的密码：</p>';
		// the link we send will look like: /login/user_reset_password_form/jone@doe.com/akjsdfh123ahsdf8912
		$message .= '<p><a href="'.base_url().'login/reset_password_form_user/'.$email.'/'.$email_code.'">'.base_url().'login/users/reset_password_form_user/'.$email.'/'.$email_code.'</a></p>';
		$message .= '<br><p>谢谢！<br>Gala Cafe - 旮旯小馆</p>';
		$message .= '</body></html>';
		
		$this->email->message($message);
		$this->email->send();
	}
	
	public function update_user_password()
	{
		if (!isset($_POST['email_address'], $_POST['email_hash']) || $_POST['email_hash'] != sha1($_POST['email_address'] . $_POST['email_code']))
		{
			die('Error updating your password');
		}
		
		$this->form_validation->set_rules('email_hash', 'Email Hash', 'trim|required');
		$this->form_validation->set_rules('email_address', '邮箱地址', 'trim|required|valid_email|max_lengh[60]|xss_clean');
		$this->form_validation->set_rules('password', '新的密码', 'trim|required|min_length[4]|max_length[32]|xss_clean');
		$this->form_validation->set_rules('password2', '新的密码确认', 'trim|required|min_length[4]|max_length[32]|matches[password]|xss_clean');
		
		if ($this->form_validation->run() == FALSE)
		{ // user didn't validate, send back to update password form and show errors...
			$data['main_content'] = 'users/update_password';
			$this->load->view('includes/template', $data);
		}
		else
		{
			$result = $this->user_model->update_user_password();
			
			if ($result)
			{ // successful update.
				$data['main_content'] = 'users/update_password_success';
				$this->load->view('includes/template', $data);
			}
			else
			{ // this should never happen...
				$data['error'] = '很抱歉，我们无法重置您的密码，请重试或<a href="'.$this->config->item('admin_email').'联系管理员';
				$data['main_content'] = 'users/update_password';
				$this->load->view('includes/template', $data);
			}
		}
	}
}

?>