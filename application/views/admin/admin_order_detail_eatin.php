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
			<?php $sql_e="SELECT orderId, dishId, serialId, dishQuantity, dishQtyAdj, dishStatus, dishChiName, dishAlphaId FROM view_last_order WHERE tableId = '{$tid}';";
				$result_e = $this->db->query($sql_e);
				foreach ($result_e->result() as $item_e):
				$status = $item_e->dishStatus; ?>
    			<a class="single_dish <?php if ($status != '1') {} else {echo 'done';} ?>">
    				<span class="dish_alpha"><?php echo $item_e->dishAlphaId; ?></span>
    				<span class="dish_name"><?php echo $item_e->dishChiName; ?></span>
    				<span class="dish_qty"><?php echo $item_e->dishQtyAdj; ?>/<span class="total"><?php echo $item_e->dishQuantity; ?></span></span>
    				<select class="dish_qty_adj" onclick="event.stopPropagation();">
    					<option value="default">-</option>
    					<?php for ($option=0; $option<=$item_e->dishQtyAdj; $option++) { // dishQuantity / dishQtyAdj;
    					echo '<option value="'.$option.'">'.$option.'</option>';
    					} ?>
    					<option value="reset">复位</option>
    				</select>
    				<span class="undo" onclick="event.stopPropagation();"><img src="<?php echo base_url(); ?>theme/images/undo.png" width="14px"></span>
    				<input class="qty_cache" type="hidden" value="<?php echo $item_e->dishQuantity; ?>">
    				<input class="serial" type="hidden" value="<?php echo $item_e->serialId; ?>">
    			</a>
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

	$('.dish_qty_adj').each(function() {
		var save_status = $(this);
		var order_qty = $(this).parent().children('.dish_qty').children('.total').html();
		var dish_serial = $(this).parent().children('.serial').val();
		$(this).change(function() {
			var current_value = $(this).children('option:selected').val();
			if (current_value === 'reset') {
				$.ajax({
					url: 'dish_qty_reset',
			        data: {"data" : dish_serial},
			        type: "POST",
			        success: function(data) {
			        	location.reload();
			        	// save_status.parent().children('.dish_qty').html(data);
			        	// $('select').prop('selectedIndex', 0);
			        }
				});
				/* $(document).ready(function() {
					$('.qty_cache').val('kakak');
				}); */
			} else if (!isNaN(current_value)) {
				var qty = $(this).children('option:selected').html();
				var original_qty = $(this).children('option:nth-last-child(2)').html();
				var final_qty = original_qty - qty;
				$.ajax({
			        url: 'dish_qty_change',
			        data: {
			        	"data" : dish_serial,
			        	"qty" : final_qty,
			        	"original" : order_qty
			        },
			        type: "POST",
			        success: function(data) {
			        	location.reload();
			        	// save_status.parent().children('.dish_qty').html(data);
			        }
			    });
			} else {}
		});
	});

	function myrefresh() {
		window.location.reload();
	}
	setTimeout('myrefresh()',900000); // refresh page every 15 min, Prevent Crash */
</script>