<?php $class = $this->uri->segment(1)==""?"active":""; ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="initial-scale=1.0">
	<meta name="description" content="Gala Cafe Online Ordering System - 旮旯小馆网上点餐系统">
	<meta name="author" content="Alfred Zhu - alfredzhu.com">
	<title>Gala Cafe Online Ordering System - 旮旯小馆网上点餐系统</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>theme/css/style.css">
	<!-- Third Party Stylesheet -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>theme/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>theme/css/auto-complete.css">
	<!-- jQuery Plug-in -->
	<script src="<?php echo base_url(); ?>theme/js/jquery-11.0.js"></script>
	<script src="<?php echo base_url(); ?>theme/js/auto-complete.js"></script>
	<script src="<?php echo base_url(); ?>theme/js/jquery-scrolltofixed.js"></script>
	<script src="<?php echo base_url(); ?>theme/js/jquery.calculation.js"></script>
	<?php // <script src="<?php echo base_url(); theme/js/parallax.js"></script> ?>
</head>
<body>
	<div class="main_wrapper">
		<div id="header">
			<?php if (strpos($_SERVER['REQUEST_URI'], "control_panel") !== false) {
			} else { ?>
			<?php if ($_SERVER['REQUEST_URI'] !== '') { ?>
			<div class="main_nav">
				<nav class="sub_nav nav-down" id="user_log">
					<ul>
						<?php if ($this->session->userdata('is_logged_in')) { ?>
						<!--<li>欢迎: <a href="<?php // echo base_url(); ?>profile"><?php // echo $this->session->userdata('nickname'); ?></a></li>--><li><a href="<?php echo base_url(); ?>profile">用户中心</a></li><li><a href="<?php echo base_url(); ?>profile/logout">注销</a></li>
						<?php } else { ?>	
						<li><a href="<?php echo base_url(); ?>login">登录</a></li><li><a href="<?php echo base_url(); ?>signup">注册</a></li>
						<?php } ?>
					</ul>
				</nav>

				<div id="main_logo">
					<a href="<?php echo base_url(); ?>">
						<img src="<?php echo base_url(); ?>theme/images/logo.png">
					</a>
				</div>
			</div>
			<?php } ?>

			<div class="shopping_cart_nav up">
				<div id="cart_pop">
					<span class="cart_icon"></span>
					<span class="quantity_number"><?php echo $this->cart->total_items(); ?></span>
					<?php /* <span class="cart_subtotal">&dollar; <?php if ($this->cart->total() != 0) { echo $this->cart->format_number($this->cart->total() * 1.05); } else { echo '0.00'; } ?></span> */ ?>
				</div>
			</div>
			<div id="close_cart"></div>
			<div id="shopping_cart_wrap" class="up">
				<?php if(!$this->cart->contents()):
				echo '您的美食车还是空的，请点餐！';
				else:
				echo form_open('cart/submit_order'); ?>
				<table width="100%" cellpadding="0" cellspacing="0">
				    <thead>
				        <tr class="total">
				            <td>
				            	<p class="submit_form">
									<?php echo form_submit(array('class'=>'btn btn-primary', 'name'=>'Submit Order', 'value'=>'提交订单')); ?>
								</p>
							</td>
				            <td>
				            	<strong>总额
				            		<small>（未包含送货）</small>
				            	</strong>
				            </td>
				            <td>&dollar;<?php echo $this->cart->format_number($this->cart->total() * 1.05); ?></td>
				            <td><span class="btn" id="empty">X</span></td>
				        </tr>
				    </thead>
				    <tbody>
				    	<tr>
				    		<td>赠品:柠檬茶</td>
				    		<td>1</td>
				    		<td><strike>$5.99</strike></td>
				    		<td></td>
				    	</tr>

				        <?php $i = 1; ?>
				        <?php foreach($this->cart->contents() as $items): ?>

				        <tr <?php if ( $i & 1 ) { echo 'class="alt"'; }?>>
					        <?php echo form_hidden('rowid', $items['rowid']); ?>
					        <?php echo form_hidden('id', $items['id']); ?>

					        <td><?php echo $items['name']; ?></td>

				            <td>
				                <?php echo form_input(array(
				                	'type' => 'number',
            						'class' => 'user_dish_qty',
            						'name' => 'qty',
            						'value' => $items['qty'],
            						'onFocus' => 'this.select()'
            					)); ?>
				            </td>
				            
				            <?php // <td>&dollar;<?php echo $this->cart->format_number($items['price']); </td> ?>
				            <td>&dollar;<?php echo $this->cart->format_number($items['subtotal']); ?></td>
				            <td class="remove">
					            <span class="icon">X</span>
				            </td>
				        </tr>
				         
				        <?php $i++; ?>
				        <?php endforeach; ?>
				        
				        <?php /* <tr class="taxes">
					        <td></td>
				            <td></td>
				            <td><strong>GST</strong></td>
				            <td>&dollar;<?php echo $this->cart->format_number($this->cart->total() * 0.05); ?></td>
				            <td></td>
				        </tr> */ ?>
				         
				    </tbody>
				</table>
				<input type="hidden" class="total_dishes" value="<?php echo $this->cart->total_items(); ?>">
				<input type="hidden" class="cart_subtotal" value="<?php echo $this->cart->format_number($this->cart->total() * 1.05); ?>">

				<?php 
				echo form_close(); 
				endif;
				?>
			</div>
			<?php } ?>
		</div>

<script type="text/javascript">
	$("#shopping_cart_wrap form").on("keydown", "input", function(e) {
  		if (e.which==13) e.preventDefault();
	});

</script>