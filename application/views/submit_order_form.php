<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<div id="cart_on_submit">
	<?php echo $this->view('cart'); ?>
</div>
	<?php 
		if (isset($phone_number)) { $phone_number = $phone_number;
		} else { $phone_number = ''; }
		if (isset($user_name)) { $user_name = $user_name;
		} else { $user_name = ''; }
	?>
<?php if(!$this->cart->contents()):
		else:
?>
<div id="user_info_submit" class="login_form">
	<h1>Step 1: 用户信息</h1>
		<?php
			echo form_open('cart/finish_order');
		?>
		<div class="form-group <?php if(form_error('phone_number')){echo 'has-error';} ?> has-feedback">
		<?php
			if (form_error('phone_number')) { // Phone number Validation
				echo form_input(array(
					'class' => 'form-control required',
					'name' => 'phone_number',
					'placeholder' => '您的电话/手机（我们将联系确认订单）'
				));
				echo form_error('phone_number', '<p class="signup_error">', '</p>');
			} else {
				echo form_input(array(
					'class' => 'form-control required',
					'name' => 'phone_number',
					'placeholder' => '您的电话/手机（我们将联系确认订单）',
					'value' => $phone_number
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
					'placeholder' => '您的姓名（此信息将用于取餐时核对）',
				));
				echo form_error('user_name', '<p class="signup_error">', '</p>');
			} else {
				echo form_input(array(
					'class' => 'form-control required',
					'name' => 'user_name',
					'placeholder' => '您的姓名（此信息将用于取餐时核对）',
					'value' => $user_name
				));
			}
		?>
		</div>
		<div class="form-group">
		<?php
			echo form_textarea(array(
				'class' => 'form-control additional_info',
				'name' => 'additional_info',
				'placeholder' => '您对订餐的其他要求（如少盐、不加辣等）'
			));
		?>
		</div>
		<?php
			echo form_submit(array(
				'class' => 'btn btn-success',
				'name' => 'submit',
				'value' => '提交订单'
			));
			echo anchor('/', '返回修改订单', array('class' => 'back_btn'));
			echo form_close();
			
			endif;
		?>
</div>
