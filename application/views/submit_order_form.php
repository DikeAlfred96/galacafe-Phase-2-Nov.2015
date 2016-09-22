<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<div id="cart_on_submit">
	<?php if(!$this->cart->contents()):
	echo '<p class="empty_cart">您的美食车还是空的，请点餐！</p><p class="online_gift">立即网上下单，送柠檬茶一杯！</p>';
	else:
	echo form_open('cart/submit_order'); ?>
	<table width="100%" cellpadding="0" cellspacing="0">
	    <thead>
	        <tr>
	            <td>菜名</td>
	            <td>数量</td>
	            <td>单价</td>
	            <td>小计</td>
	            <td><span class="btn" id="empty">X</span></td>
	        </tr>
	    </thead>
	    <tbody>
	        <?php $i = 1; ?>
	        <?php foreach($this->cart->contents() as $items): ?>
	        
	        <tr <?php if ( $i & 1 ) { echo 'class="alt"'; }?>>
		        <?php echo form_hidden('rowid', $items['rowid']); ?>
		        <?php echo form_hidden('id', $items['id']); ?>
		        <td><?php echo $items['name']; ?></td>
	            <td>
	                <?php echo form_input(array(
						'class' => 'user_dish_qty',
						'name' => 'qty',
						'value' => $items['qty'],
						'onFocus' => 'this.select()'
					)); ?>
	            </td>
	            
	            <td>&dollar;<?php echo $this->cart->format_number($items['price']); ?></td>
	            <td>&dollar;<?php echo $this->cart->format_number($items['subtotal']); ?></td>
	            <td class="remove">
		            <span class="icon">X</span>
	            </td>
	        </tr>
	         
	        <?php $i++; ?>
	        <?php endforeach; ?>
	        
	        <tr class="taxes">
		        <td></td>
	            <td></td>
	            <td><strong>GST</strong></td>
	            <td>&dollar;<?php echo $this->cart->format_number($this->cart->total() * 0.05); ?></td>
	            <td></td>
	        </tr>
	         
	        <tr class="total">
	            <td></td>
	            <td></td>
	            <td><strong>总额</strong></td>
	            <td>&dollar;<?php echo $this->cart->format_number($this->cart->total() * 1.05); ?></td>
	            <td></td>
	        </tr>
	    </tbody>
	</table>
	
	<?php 
	echo form_close(); 
	endif;
	?>
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
		<div class="form-group">
			<input type="radio" name="delivery_method" value="pick_up" class="delivery_method pick_up" id="delivery_meth_pi" checked><label for="delivery_meth_pi"> 自取</label>
			<input type="radio" name="delivery_method" value="delivery" class="delivery_method delivery" id="delivery_meth_de"><label for="delivery_meth_de"> 送餐 (大温地区$5元起)</label>
		</div>
		<div class="form-group">
			<?php
				echo form_textarea(array(
					'class' => 'form-control delivery_address',
					'name' => 'delivery_address',
					'placeholder' => '您的地址（门牌号+街道名+城市）'
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
