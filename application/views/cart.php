<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<div class="cart_wrapper">
		<?php if(!$this->cart->contents()):
		echo '您的美食车还是空的，请点餐！'.$return;
		else:
		?>
		
		<?php echo form_open('cart/submit_order'); ?>
		<table width="100%" cellpadding="0" cellspacing="0">
		    <thead>
		        <tr>
		            <td>数量</td>
		            <td>菜名</td>
		            <td>单价</td>
		            <td>小计</td>
		            <td></td>
		        </tr>
		    </thead>
		    <tbody>
		        <?php $i = 1; ?>
		        <?php foreach($this->cart->contents() as $items): ?>
		         
		        
		        <tr <?php if($i&1){ echo 'class="alt"'; }?>>
			        <?php echo form_hidden('rowid[]', $items['rowid']); ?>
		            <td>
		                <?php echo form_label($items['qty'], 'qty[]'); ?>
		            </td>
		             
		            <td><?php echo $items['name']; ?></td>
		            
		            <td>&dollar;<?php echo $this->cart->format_number($items['price']); ?></td>
		            <td>&dollar;<?php echo $this->cart->format_number($items['subtotal']); ?></td>
		            <td class="remove">
			            <?php echo anchor('cart/remove_dish/'.$items['rowid'], 'X', 'class="icon"'); ?>
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
		 
		<p class="submit_form"><?php echo form_submit(array('class'=>'btn btn-primary', 'name'=>'Submit Order', 'value'=>'提交订单')); echo anchor('cart/empty_cart', '清空美食车', 'class="btn" id="empty"');?></p>
		<?php 
		echo form_close(); 
		endif;
		?>
	</div>