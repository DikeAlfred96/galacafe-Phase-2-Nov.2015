<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>

<div class="wrapper">
	<div id="back_end_control_panel">
		<!-- Nav tabs -->
	  <ul class="nav nav-tabs">
	    <li><a href="<?php echo base_url(); ?>control_panel">餐厅下单</a></li>
	    <li><a href="<?php echo base_url(); ?>control_panel/view_orderhistory">订单历史</a></li>
	    <li class="active"><a href="<?php echo base_url(); ?>control_panel/view_orderdetail">订单状态</a></li>
	    <li><a href="<?php echo base_url(); ?>control_panel/view_kitchen">后堂汇总</a></li>
	    <li><a href="<?php echo base_url(); ?>control_panel/view_dishesmodify">菜肴操作</a></li>
	    <li><a href="<?php echo base_url(); ?>control_panel/view_analytics">报告</a></li>
	  </ul>
	
	  <!-- Tab panes -->
	  <div class="tab-content">
	    <div id="orderdetail">
		    <div id="take_out">
			    <div id="table_0_pending">
				    <h5>网上订单</h5>
		    		<?php foreach ($table_0_pending->result() as $t_zero_pending):
			    		$currentId_pending = $t_zero_pending->orderId; ?>
		    		<div class="single_pending">
			    		<input type="hidden" value="<?php echo $currentId_pending; ?>" class="order_id">
			    		<form action="view_orderdetail" method="post" accept-charset="utf-8">
			    			<input type="submit" value="通过" class="order_approve"><input type="button" value="取消" class="order_cancel">
			    		</form>
			    	<?php $sql_pending = "SELECT order_items.dishId, order_items.serialId, order_items.dishQuantity, order_items.dishStatus, dishes.dishChiName, dishes.dishAlphaId FROM view_order_items WHERE orderId='{$currentId_pending}';";
			    		$result_pending = $this->db->query($sql_pending);
			    		foreach ($result_pending->result() as $item_pending):
			    		$status = $item_pending->serialId; ?>
			    		<p class="single_pending_dish single_pending <?php if ($status != '1') {}else{echo 'done';} ?>"><span class="dish_alpha"><?php echo $item_pending->dishAlphaId; ?></span><span class="dish_name"><?php echo $item_pending->dishChiName; ?></span><span class="dish_qty"><?php echo $item_pending->dishQuantity; ?></span><input class="serial" type="hidden" value="<?php echo $item_pending->serialId; ?>"></p>
			    		<?php endforeach; ?>
					</div>
		    		<?php endforeach; ?>
		    	</div>
		    </div><div id="table_0">
			    <h5>外卖</h5>
		    		<?php foreach ($table_0->result() as $t_zero): ?>
		    		<div class="single_takeout">
		    			<?php $currentId = $t_zero->orderId; ?>
		    			<p>订单编号: <?php echo $currentId; ?></p>
		    			<?php $sql_takeout = "SELECT order_items.dishId, order_items.serialId, order_items.dishQuantity, order_items.dishStatus, dishes.dishChiName, dishes.dishAlphaId FROM order_items INNER JOIN dishes ON order_items.dishId=dishes.dishId WHERE orderId='{$currentId}';";
			    		$result_takeout = $this->db->query($sql_takeout); 
			    		foreach ($result_takeout->result() as $item_out): 
			    		$status = $item_out->serialId; ?>
		    				<p class="single_takeout_dish single_dish <?php if ($status != '1') {}else{echo 'done';} ?>"><span class="dish_alpha"><?php echo $item_out->dishAlphaId; ?></span><span class="dish_name"><?php echo $item_out->dishChiName; ?></span><span class="dish_qty"><?php echo $item_out->dishQuantity; ?></span><input class="serial" type="hidden" value="<?php echo $item_out->serialId; ?>"></p>
		    			<?php endforeach; ?>
		    		</div>
		    		<?php endforeach; ?>
		    	</div><div id="eat_in">
			    	
			    	<?php 
					for($tid=1;$tid<=8;$tid++){
						echo '<div class="table_'.$tid.'">';
						?>
						
						
						
					<h5><?php echo $tid;?>号桌</h5>
					
					
					
					<?php $sql_e="SELECT dishId, serialId, dishQuantity, dishStatus, dishChiName, dishAlphaId FROM view_order_items WHERE tableId = '{$tid}';";
						$result_e = $this->db->query($sql_e);
						foreach ($result_e->result() as $item_e):
						$status = $item_e->serialId; 
					?>
		    				<p class="single_dish <?php if ($status != '1') {}else{echo 'done';} ?>"><span class="dish_alpha"><?php echo $item_e->dishAlphaId; ?></span><span class="dish_name"><?php echo $item_e->dishChiName; ?></span><span class="dish_qty"><?php echo $item_e->dishQuantity; ?></span><input class="serial" type="hidden" value="<?php echo $item_e->serialId; ?>"></p>
					<?php endforeach; ?>
					
					<!--<?php foreach ($table_1->result() as $t_one): ?>
		    			<?php $currentId = $t_one->orderId; ?>
		    			<?php $sql_t1 = "SELECT dishId, serialId, dishQuantity, dishStatus, dishChiName, dishAlphaId FROM view_order_items WHERE orderId='{$currentId}';";
			    		$result_t1 = $this->db->query($sql_t1);
			    		foreach ($result_t1->result() as $item_in):
			    		$status = $item_in->serialId; 
			    		?>
		    				<p class="single_dish <?php if ($status != '1') {}else{echo 'done';} ?>"><span class="dish_alpha"><?php echo $item_in->dishAlphaId; ?></span><span class="dish_name"><?php echo $item_in->dishChiName; ?></span><span class="dish_qty"><?php echo $item_in->dishQuantity; ?></span><input class="serial" type="hidden" value="<?php echo $item_in->serialId; ?>"></p>
		    		<?php endforeach;
			    		endforeach; ?>		-->				
						
						</div>
						
					<?php
					}
					
					
					?>			    	
			    	
			    	
			    	
				<!--<div class="table_1">
					<h5>1号桌</h5>
					<?php foreach ($table_1->result() as $t_one): ?>
		    			<?php $currentId = $t_one->orderId; ?>
		    			<?php $sql_t1 = "SELECT dishId, serialId, dishQuantity, dishStatus, dishChiName, dishAlphaId FROM view_order_items WHERE orderId='{$currentId}';";
			    		$result_t1 = $this->db->query($sql_t1);
			    		foreach ($result_t1->result() as $item_in):
			    		$status = $item_in->serialId; 
			    		?>
		    				<p class="single_dish <?php if ($status != '1') {}else{echo 'done';} ?>"><span class="dish_alpha"><?php echo $item_in->dishAlphaId; ?></span><span class="dish_name"><?php echo $item_in->dishChiName; ?></span><span class="dish_qty"><?php echo $item_in->dishQuantity; ?></span><input class="serial" type="hidden" value="<?php echo $item_in->serialId; ?>"></p>
		    		<?php endforeach;
			    		endforeach; ?>
				</div><div class="table_2">
					<h5>2号桌</h5>
					<?php foreach ($table_2->result() as $t_two): ?>
		    			<?php $currentId = $t_two->orderId; ?>
		    			<?php $sql_t2 = "SELECT order_items.dishId, order_items.serialId, order_items.dishQuantity, order_items.dishStatus, dishes.dishChiName, dishes.dishAlphaId FROM order_items INNER JOIN dishes ON order_items.dishId=dishes.dishId WHERE orderId='{$currentId}';";
			    		$result_t2 = $this->db->query($sql_t2);
			    		foreach ($result_t2->result() as $item_in):
			    		$status = $item_in->serialId; ?>
		    				<p class="single_dish <?php if ($status != '1') {}else{echo 'done';} ?>"><span class="dish_alpha"><?php echo $item_in->dishAlphaId; ?></span><span class="dish_name"><?php echo $item_in->dishChiName; ?></span><span class="dish_qty"><?php echo $item_in->dishQuantity; ?></span><input class="serial" type="hidden" value="<?php echo $item_in->serialId; ?>"></p>
		    		<?php endforeach;
			    		endforeach; ?>
				</div><div class="table_3">
					<h5>3号桌</h5>
					<?php foreach ($table_3->result() as $t_three): ?>
		    			<?php $currentId = $t_three->orderId; ?>
		    			<?php $sql_t3 = "SELECT order_items.dishId, order_items.serialId, order_items.dishQuantity, order_items.dishStatus, dishes.dishChiName, dishes.dishAlphaId FROM order_items INNER JOIN dishes ON order_items.dishId=dishes.dishId WHERE orderId='{$currentId}';";
			    		$result_t3 = $this->db->query($sql_t3);
			    		foreach ($result_t3->result() as $item_in):
			    		$status = $item_in->serialId; ?>
		    				<p class="single_dish <?php if ($status != '1') {}else{echo 'done';} ?>"><span class="dish_alpha"><?php echo $item_in->dishAlphaId; ?></span><span class="dish_name"><?php echo $item_in->dishChiName; ?></span><span class="dish_qty"><?php echo $item_in->dishQuantity; ?></span><input class="serial" type="hidden" value="<?php echo $item_in->serialId; ?>"></p>
		    		<?php endforeach;
			    		endforeach; ?>
				</div><div class="table_4">
					<h5>4号桌</h5>
					<?php foreach ($table_4->result() as $t_four): ?>
		    			<?php $currentId = $t_four->orderId; ?>
						<?php $sql_t4 = "SELECT order_items.dishId, order_items.serialId, order_items.dishQuantity, order_items.dishStatus, dishes.dishChiName, dishes.dishAlphaId FROM order_items INNER JOIN dishes ON order_items.dishId=dishes.dishId WHERE orderId='{$currentId}';";
			    		$result_t4 = $this->db->query($sql_t4);
			    		foreach ($result_t4->result() as $item_in):
			    		$status = $item_in->serialId; ?>
		    				<p class="single_dish <?php if ($status != '1') {}else{echo 'done';} ?>"><span class="dish_alpha"><?php echo $item_in->dishAlphaId; ?></span><span class="dish_name"><?php echo $item_in->dishChiName; ?></span><span class="dish_qty"><?php echo $item_in->dishQuantity; ?></span><input class="serial" type="hidden" value="<?php echo $item_in->serialId; ?>"></p>
		    		<?php endforeach;
			    		endforeach; ?>
				</div><div class="table_5">
					<h5>5号桌</h5>
					<?php foreach ($table_5->result() as $t_five): ?>
		    			<?php $currentId = $t_five->orderId; ?>
						<?php $sql_t5 = "SELECT order_items.dishId, order_items.serialId, order_items.dishQuantity, order_items.dishStatus, dishes.dishChiName, dishes.dishAlphaId FROM order_items INNER JOIN dishes ON order_items.dishId=dishes.dishId WHERE orderId='{$currentId}';";
			    		$result_t5 = $this->db->query($sql_t5);
			    		foreach ($result_t5->result() as $item_in):
			    		$status = $item_in->serialId; ?>
		    				<p class="single_dish <?php if ($status != '1') {}else{echo 'done';} ?>"><span class="dish_alpha"><?php echo $item_in->dishAlphaId; ?></span><span class="dish_name"><?php echo $item_in->dishChiName; ?></span><span class="dish_qty"><?php echo $item_in->dishQuantity; ?></span><input class="serial" type="hidden" value="<?php echo $item_in->serialId; ?>"></p>
		    		<?php endforeach;
			    		endforeach; ?>
				</div><div class="table_6">
					<h5>6号桌</h5>
					<?php foreach ($table_6->result() as $t_six): ?>
		    			<?php $currentId = $t_six->orderId; ?>
						<?php $sql_t6 = "SELECT order_items.dishId, order_items.serialId, order_items.dishQuantity, order_items.dishStatus, dishes.dishChiName, dishes.dishAlphaId FROM order_items INNER JOIN dishes ON order_items.dishId=dishes.dishId WHERE orderId='{$currentId}';";
			    		$result_t6 = $this->db->query($sql_t6);
			    		foreach ($result_t6->result() as $item_in):
						$status = $item_in->serialId; ?>
		    				<p class="single_dish <?php if ($status != '1') {}else{echo 'done';} ?>"><span class="dish_alpha"><?php echo $item_in->dishAlphaId; ?></span><span class="dish_name"><?php echo $item_in->dishChiName; ?></span><span class="dish_qty"><?php echo $item_in->dishQuantity; ?></span><input class="serial" type="hidden" value="<?php echo $item_in->serialId; ?>"></p>
		    		<?php endforeach;
			    		endforeach; ?>
				</div><div class="table_7">
					<h5>7号桌</h5>
					<?php foreach ($table_7->result() as $t_seven): ?>
		    			<?php $currentId = $t_seven->orderId; ?>
						<?php $sql_t7 = "SELECT order_items.dishId, order_items.serialId, order_items.dishQuantity, order_items.dishStatus, dishes.dishChiName, dishes.dishAlphaId FROM order_items INNER JOIN dishes ON order_items.dishId=dishes.dishId WHERE orderId='{$currentId}';";
			    		$result_t7 = $this->db->query($sql_t7);
			    		foreach ($result_t7->result() as $item_in):
						$status = $item_in->serialId; ?>
		    				<p class="single_dish <?php if ($status != '1') {}else{echo 'done';} ?>"><span class="dish_alpha"><?php echo $item_in->dishAlphaId; ?></span><span class="dish_name"><?php echo $item_in->dishChiName; ?></span><span class="dish_qty"><?php echo $item_in->dishQuantity; ?></span><input class="serial" type="hidden" value="<?php echo $item_in->serialId; ?>"></p>
		    		<?php endforeach;
			    		endforeach; ?>
				</div><div class="table_8">
					<h5>8号桌</h5>
					<?php foreach ($table_8->result() as $t_eight): ?>
		    			<?php $currentId = $t_eight->orderId; ?>
						<?php $sql_t8 = "SELECT order_items.dishId, order_items.serialId, order_items.dishQuantity, order_items.dishStatus, dishes.dishChiName, dishes.dishAlphaId FROM order_items INNER JOIN dishes ON order_items.dishId=dishes.dishId WHERE orderId='{$currentId}';";
			    		$result_t8 = $this->db->query($sql_t8);
			    		foreach ($result_t8->result() as $item_in):
						$status = $item_in->serialId; ?>
		    				<p class="single_dish <?php if ($status != '1') {}else{echo 'done';} ?>"><span class="dish_alpha"><?php echo $item_in->dishAlphaId; ?></span><span class="dish_name"><?php echo $item_in->dishChiName; ?></span><span class="dish_qty"><?php echo $item_in->dishQuantity; ?></span><input class="serial" type="hidden" value="<?php echo $item_in->serialId; ?>"></p>
		    		<?php endforeach;
			    		endforeach; ?>
				</div>-->
		    </div>
	    </div>
	  </div>
	</div>
	<script>
		$('.single_dish').each(function() { // haven't finish
			var save_status = $(this);
			var dish_serial = $(this).children('.serial').val();
			$(this).click(function() {
				$.ajax({
			        url: 'dish_status_change',
			        data: {"data" : dish_serial},
			        type: "POST",
			        success: function(data) {
				       					       
				        if ($(save_status).hasClass('done')) {
					        $(save_status).removeClass('done');
						} else {
							$(save_status).addClass(data);
						}
			        }
			    });
			});
		});
	</script>
</div>