<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>

<div id="user_login_form" class="login_form">
	<h1>用户登录</h1>
		<?php
			echo form_open('login/validate_credentials_user');
			echo form_input(array(
				'class' => 'form-control',
				'name' => 'username',
				'placeholder' => '电话/手机号码或邮箱'
				));
			echo form_password(array(
				'class' => 'form-control',
				'name' => 'password',
				'placeholder' => '密码'
				));
			echo form_submit(array(
				'class' => 'btn btn-success',
				'name' => 'submit',
				'value' => '登陆'
				));
			echo anchor('signup', '新用户？', array('class' => 'btn btn-success sign_up'));
			echo anchor('login/reset_password_user', '忘记密码?', array('class' => 'forgot_pass'));
			echo form_close();
			
			if(isset($error)) {
		?>
		<div class="login_error"><?php echo $error; ?></div>
		<?php
			}
		?>
</div>