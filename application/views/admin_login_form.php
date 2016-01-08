<div id="admin_login_form" class="login_form">
	<h1>后台管理平台登录</h1>
		<?php
			echo form_open('admin/validate_credentials');
			echo form_input(array(
				'class' => 'form-control',
				'name' => 'username',
				'placeholder' => '用户名'
				));
			echo form_password(array(
				'class' => 'form-control',
				'name' => 'password',
				'placeholder' => '密码'
				));
			echo form_submit(array(
				'class' => 'btn btn-success btn-lg',
				'name' => 'submit',
				'value' => '登陆'
				));
			// echo anchor('login/signup', 'Create Account');
			if(isset($error))
			{
		?>
		<div class="login_error"><?php echo $error; ?></div>
		<?php
			}
		?>
</div>