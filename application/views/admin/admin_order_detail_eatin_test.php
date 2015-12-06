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
	    	<?php for ($tid=1; $tid<=8; $tid++) { ?>
	    	<div class="table_<?php echo $tid; ?>">
				<h5>
					<?php echo $tid;?>号桌
					<select class="change_table">
						<option class="change_none">-</option>
						<?php for ($cid=1; $cid<=8; $cid++) {
						if ($cid == $tid) {} else { ?>
						<option class="change_to" value="<?php echo $cid; ?>"><?php echo $cid; ?></option>
						<?php } } ?>
					</select>
					<span class="finish_all">全部完成<input type="hidden" value="<?php echo $tid; ?>" class="table_id"></span>
				</h5>
				<ul class="nav nav-tabs" role="tablist">
				</ul>
				<div class="tab-content">
					<?php $sql_e = "SELECT orderId, dishId, serialId, dishQuantity, dishQtyAdj, dishStatus, dishChiName, dishAlphaId FROM view_unfinished_order_item WHERE tableId = '{$tid}';";
					$result_e = $this->db->query($sql_e);
					if ($result_e->num_rows() > 1) {
					foreach ($result_e->result() as $item_e):
					$status = $item_e->dishStatus;
					$current_order_id = $item_e->orderId; ?>
					<div role="tabpanel" class="tab-pane active" id="order_<?php echo $tid; ?>_<?php echo $current_order_id; ?>">
		    			<a class="single_dish <?php if ($status != '1') {} else {echo 'done';} ?>">
		    				<span class="dish_alpha"><?php echo $item_e->dishAlphaId; ?></span>
		    				<span class="dish_name"><?php echo $item_e->dishChiName; ?></span>
		    				<span class="dish_qty"><span class="adj"><?php echo $item_e->dishQtyAdj; ?></span>/<span class="total"><?php echo $item_e->dishQuantity; ?></span></span>
		    				<input type="text" onclick="event.stopPropagation(); this.select();" class="dish_qty_adj" maxlength="3">
		    				<input class="qty_cache" type="hidden" value="<?php echo $item_e->dishQuantity; ?>">
		    				<input class="serial" type="hidden" value="<?php echo $item_e->serialId; ?>">
		    				<input class="order_id" type="hidden" value="<?php echo $item_e->orderId; ?>">
		    			</a>
		    		</div>
					<?php endforeach; 
					} else {
						$sql_e2 = "SELECT orderId FROM orders WHERE tableId = '{$tid}' ORDER BY orderId DESC LIMIT 2";
						$result_e2 = $this->db->query($sql_e2);
						foreach ($result_e2->result() as $item_e2):
							$c_order_id = $item_e2->orderId;
							$sql_e2_item = "SELECT orderId, dishId, serialId, dishQuantity, dishQtyAdj, dishStatus, dishChiName, dishAlphaId FROM view_order_items WHERE orderId = '{$c_order_id}'";
							$result_e2_item = $this->db->query($sql_e2_item);
							foreach ($result_e2_item->result() as $item_e2_i): 
							$status = $item_e2_i->dishStatus; ?>
								<a class="single_dish <?php if ($status != '1') {} else {echo 'done';} ?>">
									<span class="dish_alpha"><?php echo $item_e2_i->dishAlphaId; ?></span>
									<span class="dish_name"><?php echo $item_e2_i->dishChiName; ?></span>
									<span class="dish_qty"><span class="adj"><?php echo $item_e2_i->dishQtyAdj; ?></span>/<span class="total"><?php echo $item_e2_i->dishQuantity; ?></span></span>
									<input type="text" onclick="event.stopPropagation(); this.select();" class="dish_qty_adj" maxlength="3">
									<input class="qty_cache" type="hidden" value="<?php echo $item_e2_i->dishQuantity; ?>">
									<input class="serial" type="hidden" value="<?php echo $item_e2_i->serialId; ?>">
									<input class="order_id" type="hidden" value="<?php echo $item_e2_i->orderId; ?>">
								</a>
							<?php endforeach;
						endforeach;
					} ?>
				</div>
			</div>
		<?php } ?>
<script type="text/javascript">
	function partialRefresh() {
		$.ajax({
		    url: 'view_orderdetail_eatin',
		    data: {},
		    type: 'post',
		    success: function(data) {
				$("div#eat_in").html($(data).find('#eat_in').html());
		    }
		});
	}

	$('.finish_all').each(function() { // Finish all button besides table number
		var save_status = $(this);
		var table_id = $(this).children('.table_id').val();
		var order_id = $(this).parent().parent().children('.single_dish').children('.order_id').val();
		$(this).click(function() {
			$.ajax({
		        url: 'dish_status_change_all',
		        data: {
		        	"data" : table_id,
		        	"order_id" : order_id
		        },
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
		var order_id = $(this).children('.order_id').val();
		$(this).click(function() {
			$.ajax({
		        url: 'dish_status_change',
		        data: {
		        	"data" : dish_serial,
		        	"order_id" : order_id
		        },
		        type: "POST",
		        success: function(data) {
					partialRefresh(); // location.reload();
			        /* if ($(save_status).hasClass('done')) {
				        $(save_status).removeClass('done');
					} else {
						$(save_status).addClass(data);
					} */
		        }
		    });
		});
	});
	
	$('.dish_qty_adj').each(function() {
		var t = $(this);
		var order_qty = $(this).parent().children('.dish_qty').children('.total').html();
		var dish_serial = $(this).parent().children('.serial').val();
		var order_id = $(this).parent().children('.order_id').val();
		$(this).keypress(function(e) {

		    if (e.which == 13) {
		    	var input_val = t.val();
		    	var original_qty = $(this).parent().children('.dish_qty').children('.adj').html();
				var final_qty = original_qty - input_val;
				if ($.trim(input_val) === "0") {
					$.ajax({
						url: 'dish_qty_reset',
				        data: {
				        	"data" : dish_serial,
				        	"order_id" : order_id
				        },
				        type: "POST",
				        success: function(data) {
				        	partialRefresh(); // location.reload();
				        	// save_status.parent().children('.dish_qty').html(data);
				        	// $('select').prop('selectedIndex', 0);
				        }
					});
				} else if ($.trim(input_val) !== '') {
					if (final_qty > order_qty || final_qty < 0 || isNaN(input_val)) {
						return false;
					} else {
				    	$.ajax({
					        url: 'dish_qty_change',
					        data: {
					        	"data" : dish_serial,
					        	"qty" : final_qty,
					        	"original" : order_qty,
					        	"order_id" : order_id
					        },
					        type: "POST",
					        success: function(data) {
					        	partialRefresh(); // location.reload();
					        	// save_status.parent().children('.dish_qty').html(data);
					        }
					    });
					}
			    	t.val('');
					t.blur();
				} else {
					return false;
				}
		    }
		});
	});

	$('.change_table').each(function() { // Finish all button besides table number
		var save_status = $(this);
		var table_id = $(this).parent().children('.finish_all').children('.table_id').val();
		var order_id = $(this).parent().parent().children('.single_dish').children('.order_id').val();
		$(this).change(function() {
			var change_id = $(this).find(':selected').val();
			$.ajax({
		        url: 'eatin_change_table',
		        data: {
		        	"data" : table_id,
		        	"change_id" : change_id,
		        	"order_id" : order_id
		        },
		        type: "POST",
		        success: function(data) {
					partialRefresh();
		        }
		    });
		});
	});
</script>
			</div>
		</div>
	</div>
</div>
<script>
	function myrefresh() {
		window.location.reload();
	}
	setInterval('myrefresh()',600000); // refresh page every 10 min, Prevent Crash */
</script>