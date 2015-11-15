<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>

<div id="order_error" class="login_form">
	<h1>下单失败！</h1>
	<p>很抱歉，您的订单由于网络问题没有成功提交，请<br><?php echo anchor('/', '返回'); ?>重试</p>
</div>