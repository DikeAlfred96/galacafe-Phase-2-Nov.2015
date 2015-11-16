<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Vancouver');
?>

<div id="back_end_control_panel">
	<!-- Nav tabs -->
  <ul class="nav nav-tabs">
    <li><a href="<?php echo base_url(); ?>control_panel">餐厅下单</a></li>
    <li><a href="<?php echo base_url(); ?>control_panel/view_orderhistory">订单历史</a></li>
    <li><a href="<?php echo base_url(); ?>control_panel/view_orderdetail_pickup">外卖订单</a></li>
    <li class="active"><a href="<?php echo base_url(); ?>control_panel/view_orderdetail_eatin">堂食订单</a></li>
    <li><a href="<?php echo base_url(); ?>control_panel/view_kitchen">后堂汇总</a></li>
    <li><a href="<?php echo base_url(); ?>control_panel/view_dishesmodify">菜肴操作</a></li>
    <li><a href="<?php echo base_url(); ?>control_panel/view_analytics">报告</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div id="orderdetail">
		<div id="eat_in">
	    	<?php for ($tid=1; $tid<=8; $tid++) {
				echo '<div class="table_'.$tid.'">'; ?>
			<h5><?php echo $tid;?>号桌<span class="finish_all">全部完成<input type="hidden" value="<?php echo $tid; ?>" class="table_id"></span></h5>	
			<?php $sql_e="SELECT orderId, dishId, serialId, dishQuantity, dishStatus, dishChiName, dishAlphaId FROM view_last_order WHERE tableId = '{$tid}';";
				$result_e = $this->db->query($sql_e);
				foreach ($result_e->result() as $item_e):
				$status = $item_e->dishStatus; ?>
    			<p class="single_dish <?php if ($status != '1') {} else {echo 'done';} ?>"><span class="dish_alpha"><?php echo $item_e->dishAlphaId; ?></span><span class="dish_name"><?php echo $item_e->dishChiName; ?></span><span class="dish_qty"><?php echo $item_e->dishQuantity; ?></span><input class="serial" type="hidden" value="<?php echo $item_e->serialId; ?>"></p>
			<?php endforeach; ?>
			</div>
		<?php } ?>
			</div>
		</div>
	</div>
</div>
<script>
	$('.finish_all').each(function() { // Finish all button besides table number
		var save_status = $(this);
		var table_id = $(this).children('.table_id').val();
		$(this).click(function() {
			$.ajax({
		        url: 'dish_status_change_all',
		        data: {"data" : table_id},
		        type: "POST",
		        success: function(data) {
					$(save_status).parent().parent().children('.single_dish').addClass('done');
		        }
		    });
		});
	});

	$('.single_dish').each(function() { // Change singel dish status.
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

	function myrefresh() {
		window.location.reload();
	}
	setTimeout('myrefresh()',900000); // refresh page every 15 min, Prevent Crash */
</script>