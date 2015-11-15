<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>

<div id="user_reset_pass_form" class="login_form">
	<h1>重置密码</h1>
		<?php
			echo form_open('login/update_user_password');
		
			if (isset($email_hash, $email_code))
			{
			echo form_hidden('email_hash', $email_hash);
			echo form_hidden('email_code', $email_code);
			}
			
			if(isset($email)) {	$email_value = $email; } else { $email_value = ''; }
			
			echo form_input(array(
				'class' => 'form-control required',
				'name' => 'email_address',
				'placeholder' => '您的邮箱地址',
				'value' => $email_value
			));
			echo form_error('email_address', '<p class="signup_error">', '</p>');
			
			echo form_password(array(
				'class' => 'form-control required',
				'name' => 'password',
				'placeholder' => '新的密码'
			));
			echo form_error('password', '<p class="signup_error">', '</p>');
			
			echo form_password(array(
				'class' => 'form-control required',
				'name' => 'password2',
				'placeholder' => '新的密码确认'
			));
			echo form_error('password2', '<p class="signup_error">', '</p>');

			echo form_submit(array(
				'class' => 'btn btn-success',
				'name' => 'submit',
				'value' => '重置密码'
				));
			echo form_close();
			
		?>
</div>