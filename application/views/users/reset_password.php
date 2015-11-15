<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>

<div id="user_reset_pass_form" class="login_form">
	<h1>找回密码</h1>
		<?php
			echo form_open('login/reset_password_user');
		?>
			<div class="form-group <?php if(form_error('email_address')){echo 'has-error';} ?> has-feedback">
		<?php
			if (form_error('email_address')) { // Email Validation
				echo form_input(array(
					'class' => 'form-control required',
					'name' => 'email_address',
					'placeholder' => '您的邮箱地址'
				));
				echo form_error('email_address', '<p class="signup_error">', '</p>');
			} else {
				echo form_input(array(
					'class' => 'form-control required',
					'name' => 'email_address',
					'placeholder' => '您的邮箱地址',
					'value' => set_value('email_address')
				));
			}
		?>
			</div>
		<?php
			if(isset($error))
			{
		?>
			<div class="login_error"><?php echo $error; ?></div>
		<?php
			}
		?>
		<?php
			echo form_submit(array(
				'class' => 'btn btn-success',
				'name' => 'submit',
				'value' => '找回密码'
				));
			echo anchor('login', '返回登录', array('class' => 'back_btn'));
			echo form_close();
			
		?>
</div>