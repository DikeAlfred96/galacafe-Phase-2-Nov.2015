<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>

<div id="user_signup_form" class="login_form">
	<h1>新用户注册</h1>
		<?php
			echo form_open('signup/validate_credentials_user');
		?>
		<div class="form-group <?php if(form_error('email_address')){echo 'has-error';} ?> has-feedback">
		<?php
			if (form_error('email_address')) { // Email Validation
				echo form_input(array(
					'class' => 'form-control required',
					'name' => 'email_address',
					'placeholder' => '您的常用邮箱（用于找回密码）'
				));
				echo form_error('email_address', '<p class="signup_error">', '</p>');
			} else {
				echo form_input(array(
					'class' => 'form-control required',
					'name' => 'email_address',
					'placeholder' => '您的常用邮箱（用于找回密码）',
					'value' => set_value('email_address')
				));
			}
		?>
		</div>
		<div class="form-group <?php if(form_error('phone_number')){echo 'has-error';} ?> has-feedback">
		<?php
			if (form_error('phone_number')) { // Phone number Validation
				echo form_input(array(
					'class' => 'form-control required',
					'name' => 'phone_number',
					'placeholder' => '您的电话/手机（此信息将用作登录名）'
				));
				echo form_error('phone_number', '<p class="signup_error">', '</p>');
			} else {
				echo form_input(array(
					'class' => 'form-control required',
					'name' => 'phone_number',
					'placeholder' => '您的电话/手机（此信息将用作登录名）',
					'value' => set_value('phone_number')
				));
			}
		?>
		</div>
		<div class="form-group <?php if(form_error('user_name')){echo 'has-error';} ?> has-feedback">
		<?php
			if (form_error('user_name')) { // Username Valication
				echo form_input(array(
					'class' => 'form-control required',
					'name' => 'user_name',
					'placeholder' => '您的姓名（此信息将用于确认订单）',
				));
				echo form_error('user_name', '<p class="signup_error">', '</p>');
			} else {
				echo form_input(array(
					'class' => 'form-control required',
					'name' => 'user_name',
					'placeholder' => '您的姓名（此信息将用于确认订单）',
					'value' => set_value('user_name')
				));
			}
		?>
		</div>
		<div class="form-group <?php if(form_error('password')){echo 'has-error';} ?> has-feedback">
		<?php
			echo form_password(array(
				'class' => 'form-control required',
				'name' => 'password',
				'placeholder' => '设置密码'
			));
			echo form_error('password', '<p class="signup_error">', '</p>');
		?>
		</div>
		<div class="form-group <?php if(form_error('password2')){echo 'has-error';} ?> has-feedback">
		<?php
			echo form_password(array(
				'class' => 'form-control required',
				'name' => 'password2',
				'placeholder' => '确认密码'
			));
			echo form_error('password2', '<p class="signup_error">', '</p>');
		?>
		</div>
		<?php
			echo form_submit(array(
				'class' => 'btn btn-success',
				'name' => 'submit',
				'value' => '注册'
			));
			echo anchor('login', '返回登录', array('class' => 'back_btn'));
			
		?>
</div>
