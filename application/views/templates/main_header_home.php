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
				echo '<p class="empty_cart">您的美食车还是空的，请点餐！</p><p class="online_gift">立即网上下单，送柠檬茶一杯！</p>';
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
				            
				            <?php // <td>&dollar;<?php echo $this->cart->format_number($items['price']); </td>?>
				            <td>&dollar;<?php echo $this->cart->format_number($items['subtotal']); ?></td>
				            <td class="remove">
					            <span class="icon">X</span>
				            </td>
				        </tr>
				         
				        <?php $i++; ?>
				        <?php endforeach; ?>
				        
				        <?php /* <tr class="taxes">
					        <td></td>
				            <td></td
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

	// User - Empty Order Form
	$("#empty").click(function() {
		$.ajax({
			beforeSend: function() {
			    // This is where you show the dialog.
			    // Return false if you don't want the form submitted.
			    if (!confirm("您确定要清空购物车？")) {
			    	return false;
			    } else {
			    	return true;
			    }
			},
	        url: 'cart/empty_cart', //the script to call to get data
	        data: {}, //you can insert url argumnets here to pass
	        type: "POST",
	        success: function(data) {
	        	$.ajax({
					url: 'cart/show_cart', //the script to call to get data
					data: {}, //you can insert url argumnets here to pass
					type: "POST",
					success: function(cart) {
						$("#shopping_cart_wrap").html(cart);
						if ($(cart).find('.total_dishes').val() != null) {
							$('.quantity_number').html($(cart).find('.total_dishes').val());
							$('.cart_subtotal').html('$ ' + $(cart).find('.cart_subtotal').val());
						} else {
							$('.quantity_number').html('0');
							$('.cart_subtotal').html('$ 0.00');
						}
						$(".dishes_wrap ul.category_wrap .single_dish_js").each(function() {
							$(this).find('.order_qty span').html('0');
							$(this).removeClass('active');
						});

					}
				});
	        }
	    });
	});

</script>