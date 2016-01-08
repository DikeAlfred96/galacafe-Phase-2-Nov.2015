<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Vancouver');
?>

<div id="back_end_control_panel">
	<!-- Nav tabs -->
  <ul class="nav nav-tabs">
    <li><a href="<?php echo base_url(); ?>control_panel">下单</a></li>
    <li><a href="<?php echo base_url(); ?>control_panel/view_orderhistory">历史</a></li>
    <li><a href="<?php echo base_url(); ?>control_panel/view_orderdetail_pickup">外卖</a></li>
    <li class="active"><a href="<?php echo base_url(); ?>control_panel/view_orderdetail_eatin">堂食</a></li>
    <li><a href="<?php echo base_url(); ?>control_panel/view_kitchen">后堂</a></li>
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
						<?php for ($change=1; $change<=8; $change++) {
						if ($change == $tid) {} else { ?>
						<option class="change_to" value="<?php echo $change; ?>"><?php echo $change; ?></option>
						<?php } } ?>
					</select>
					<span class="finish_all">全部完成<input type="hidden" value="<?php echo $tid; ?>" class="table_id"></span>
				</h5>
				<ul class="nav nav-tabs" role="tablist" id="tab_<?php echo $tid; ?>">
					<?php 
					$sql = "SELECT orderId, orderStatus FROM view_unfinished_order WHERE tableId = '{$tid}' ORDER BY orderId DESC"; 
					$result = $this->db->query($sql);
if ($result->num_rows() > 1) {
					$a = 0;
	foreach ($result->result() as $item):
					if ($a == 0) { $active = 'active'; } else { $active = ''; }
					$a++;
					$status = $item->orderStatus;
					$current_id = $item->orderId;
					if ($status != '3') {
						$unfinish = "red";
					} else {
						$unfinish = "";
					} ?>
					<li role="presentation" class="<?php echo $active; ?>">
						<a href="#order_<?php echo $current_id; ?>" role="tab" data-toggle="tab" class="<?php echo $unfinish; ?>"><?php echo $current_id; ?></a>
					</li>
	<?php endforeach; 
} else {
					$sql_2 = "SELECT orderId, orderStatus FROM orders WHERE tableId = '{$tid}' ORDER BY orderStatus ASC, orderId DESC LIMIT 2";
					$result_2 = $this->db->query($sql_2); 
					$b = 0;
		foreach ($result_2->result() as $item_2):
					if ($b == 0) { $active = 'active'; } else { $active = ''; }
					$b++;
					$status = $item_2->orderStatus;
					if ($status != 3) {
						$unfinish = "red";
					} else {
						$unfinish = "";
					}
					$current_id = $item_2->orderId; ?>
					<li role="presentation" class="<?php echo $active; ?>">
						<a href="#order_<?php echo $current_id; ?>" role="tab" data-toggle="tab" class="<?php echo $unfinish; ?>"><?php echo $current_id; ?></a>
					</li>
		<?php endforeach;
} ?>
				</ul>
				<!-- <div> -->
				<div class="tab-content">
<?php if ($result->num_rows() > 1) {
					$c = 0;
	foreach ($result->result() as $item):
					if ($c == 0) { $active = 'active'; } else { $active = ''; }
					$current_id_2 = $item->orderId; ?>
					<div role="tabpanel" class="tab-pane <?php echo $active; ?>" id="order_<?php echo $current_id_2; ?>">
					<?php $sql_e = "SELECT tableId, orderId, dishId, serialId, dishQuantity, dishQtyAdj, dishStatus, dishChiName, dishAlphaId FROM view_unfinished_order_item WHERE tableId = '{$tid}' AND orderId = '{$current_id_2}' ORDER BY dishStatus ASC;";
					$c++;
					$result_e = $this->db->query($sql_e);
		foreach ($result_e->result() as $item_e):
					$status = $item_e->dishStatus; ?>
		    			<a class="single_dish <?php if ($status != '1') {} else {echo 'done';} ?>">
		    				<span class="dish_alpha"><?php echo $item_e->dishAlphaId; ?></span>
		    				<span class="dish_name"><?php echo $item_e->dishChiName; ?></span>
		    				<span class="dish_qty"><span class="adj"><?php echo $item_e->dishQtyAdj; ?></span>/<span class="total"><?php echo $item_e->dishQuantity; ?></span></span>
		    				<input type="text" onclick="event.stopPropagation(); this.select();" class="dish_qty_adj" maxlength="3">
		    				<input class="qty_cache" type="hidden" value="<?php echo $item_e->dishQuantity; ?>">
		    				<input class="serial" type="hidden" value="<?php echo $item_e->serialId; ?>">
		    				<input class="order_id" type="hidden" value="<?php echo $item_e->orderId; ?>">
		    				<input class="table_id" type="hidden" value="<?php echo $item_e->tableId; ?>">
		    			</a>
		<?php endforeach; ?> 
		    		</div>
	<?php endforeach;
} else {
						$sql_e2 = "SELECT orderId FROM orders WHERE tableId = '{$tid}' ORDER BY orderStatus ASC, orderId DESC LIMIT 2";
						$result_e2 = $this->db->query($sql_e2);
						$d = 0;
	foreach ($result_e2->result() as $item_e2):
							if ($d == 0) { $active = 'active'; } else { $active = ''; }
							$current_id_2 = $item_e2->orderId; ?>
							<div role="tabpanel" class="tab-pane <?php echo $active; ?>" id="order_<?php echo $current_id_2; ?>">
							<?php $sql_e2_item = "SELECT tableId, orderId, dishId, serialId, dishQuantity, dishQtyAdj, dishStatus, dishChiName, dishAlphaId FROM view_order_items WHERE orderId = '{$current_id_2}' ORDER BY dishStatus ASC;";
							$d++;
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
									<input class="table_id" type="hidden" value="<?php echo $item_e2_i->tableId; ?>">
								</a>
		<?php endforeach; ?>
							</div>
	<?php endforeach;
} ?>
				</div>
			</div>
		<?php } ?>
<script type="text/javascript">
	function partialRefresh(id, td) {
		$.ajax({
		    url: 'view_orderdetail_eatin',
		    type: 'post',
		    success: function(data) {
				$("div#eat_in").html($(data).find('#eat_in').html());
				$(document).find('#tab_'+td).children('li').removeClass('active');
				$(document).find('.table_'+td).children('.tab-content').children('.tab-pane.active').removeClass('active');
				$(document).find('#order_'+id).addClass('active');
				$(document).find('#tab_'+td).children('li').find("a[href='#order_"+id+"']").parent().addClass('active');
		    }
		});
	}

	$('.finish_all').each(function() { // Finish all button besides table number
		$(this).click(function() {
			var save_status = $(this);
			var table_id = $(this).children('.table_id').val();
			var order_id = $(this).parent().parent().children('.tab-content').children('.tab-pane.active').children('.single_dish').children('.order_id').val();
			$.ajax({
		        url: 'dish_status_change_all',
		        data: {
		        	"data" : table_id,
		        	"order_id" : order_id,
				    "table_id" : table_id
		        },
		        type: "POST",
		        success: function(data) {
					partialRefresh(order_id, table_id);
		        }
		    });
		});
	});

	$('.single_dish').each(function() { // Change singel dish status.
		$(this).click(function() {
		var save_status = $(this);
		var dish_serial = $(this).children('.serial').val();
		var order_id = $(this).children('.order_id').val();
		var table_id = $(this).children('.table_id').val();
			$.ajax({
		        url: 'dish_status_change',
		        data: {
		        	"data" : dish_serial,
		        	"order_id" : order_id,
				    "table_id" : table_id
		        },
		        type: "POST",
		        success: function(data) {
					// partialRefresh(order_id, table_id); // location.reload();
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
		$(this).keypress(function(e) {
		var t = $(this);
		var order_qty = $(this).parent().children('.dish_qty').children('.total').html();
		var dish_serial = $(this).parent().children('.serial').val();
		var order_id = $(this).parent().children('.order_id').val();
		var table_id = $(this).parent().children('.table_id').val();
		    if (e.which == 13) {
		    	var input_val = t.val();
		    	var original_qty = $(this).parent().children('.dish_qty').children('.adj').html();
				var final_qty = original_qty - input_val;
				if ($.trim(input_val) === "0") {
					$.ajax({
						url: 'dish_qty_reset',
				        data: {
				        	"data" : dish_serial,
				        	"order_id" : order_id,
				        	"table_id" : table_id
				        },
				        type: "POST",
				        success: function(data) {
				        	partialRefresh(order_id, table_id); // location.reload();
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
					        	"order_id" : order_id,
				        		"table_id" : table_id
					        },
					        type: "POST",
					        success: function(data) {
					        	partialRefresh(order_id, table_id); // location.reload();
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
		$(this).change(function() {
			var save_status = $(this);
			var table_id = $(this).parent().children('.finish_all').children('.table_id').val();
			var order_id = $(this).parent().parent().children('.tab-content').children('.tab-pane.active').children('.single_dish').children('.order_id').val();
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
					partialRefresh(order_id, table_id);
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
	function fetchEatin() {
		$.ajax({
		    url: 'view_orderdetail_eatin',
		    data: {},
		    type: 'post',
		    success: function(data) {
				$("div#eat_in").html($(data).find('div#eat_in').html());
		    }
		});
	}
	fetchEatin();
	setInterval('fetchEatin()',15000); // After 10 sec re-fetch data

	function myrefresh() {
		window.location.reload();
	}
	setInterval('myrefresh()',600000); // refresh page every 10 min, Prevent Crash */
</script>