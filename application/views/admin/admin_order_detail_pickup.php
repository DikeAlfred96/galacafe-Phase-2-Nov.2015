<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Vancouver');
?>

<div id="back_end_control_panel">
	<!-- Nav tabs -->
  <ul class="nav nav-tabs">
    <li><a href="<?php echo base_url(); ?>control_panel">餐厅下单</a></li>
    <li><a href="<?php echo base_url(); ?>control_panel/view_orderhistory">订单历史</a></li>
    <li class="active"><a href="<?php echo base_url(); ?>control_panel/view_orderdetail_pickup">外卖订单</a></li>
    <li><a href="<?php echo base_url(); ?>control_panel/view_orderdetail_eatin">堂食订单</a></li>
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
		    		$i=1;
		    		$currentId_pending = $t_zero_pending->orderId;
		    		$user_tel = $t_zero_pending->userTel;
		    		$user_name = $t_zero_pending->userName;
		    		$order_remarks = $t_zero_pending->orderRemarks; ?>
	    		<div class="single_pending">
		    		<form action="admin_approve_order" method="post" class="pending_form">
			    		<p>订单号: <?php echo $currentId_pending; ?><input type="submit" value="通过" class="order_approve" onclick="printDiv('<?php echo $i; ?>');"><a href="#" class="cancel_order">取消<input type="hidden" value="<?php echo $currentId_pending; ?>" class="order_id" name="order_id"></a></p>
			    		<p class="user_detail"><span class="user_name"><?php echo $t_zero_pending->userName; ?></span><span class="user_tel"><?php echo $t_zero_pending->userTel; ?></span><?php if ($order_remarks != '') { ?><br><span class="remarks"><?php echo $t_zero_pending->orderRemarks; ?></span><?php } ?></p>
			    		<input type="hidden" id="orderId_<?php echo $i; ?>" value="<?php echo $currentId_pending; ?>">
			    		<input type="hidden" id="tableId_<?php echo $i; ?>" value="外卖">
			    		<?php if ($user_tel != '') { ?><input type="hidden" id="userTel_<?php echo $i; ?>" value="<?php echo $user_tel; ?>"><?php } ?>
			    		<?php if ($user_name != '') { ?><input type="hidden" id="userName_<?php echo $i; ?>" value="<?php echo $user_name; ?>"><?php } ?>
			    		<?php if ($order_remarks != '') { ?><input type="hidden" id="orderRemark_<?php echo $i; ?>" value="<?php echo $order_remarks ?>"><?php } ?>
			    		<input type="hidden" id="orderSubtotal_<?php echo $i; ?>" value="<?php echo $t_zero_pending->orderSubtotal; ?>">
			    		<input type="hidden" id="orderTax_<?php echo $i; ?>" value="<?php echo $t_zero_pending->orderTax; ?>">
			    		<input type="hidden" id="orderTime_<?php echo $i; ?>" value="<?php echo $t_zero_pending->orderTime; ?>">
			    		<input type="hidden" id="orderTotal_<?php echo $i; ?>" value="<?php echo $t_zero_pending->orderTotal; ?>">
		    		</form>
		    	<?php $sql_pending = "SELECT dishId, serialId, dishQuantity, dishStatus, dishChiName, dishEngName, dishPrice, dishAlphaId FROM view_order_items WHERE orderId='{$currentId_pending}';";
		    		$result_pending = $this->db->query($sql_pending);
		    		foreach ($result_pending->result() as $item_pending):
		    		$status = $item_pending->dishStatus; ?>
		    		<p class="extra_<?php echo $i; ?> single_pending_dish single_pending <?php if ($status != '1') {}else{echo 'done';} ?>">
			    		<span class="dish_alpha one"><?php echo $item_pending->dishAlphaId; ?></span><span class="dish_name two"><?php echo $item_pending->dishChiName; ?><br><span class="eng_name two"><?php echo $item_pending->dishEngName; ?></span></span><span class="dish_qty three"><?php echo $item_pending->dishQuantity; ?></span><span class="dish_price four"><?php echo '$ '.$item_pending->dishPrice; ?></span><input class="serial" type="hidden" value="<?php echo $item_pending->serialId; ?>"><a href="#" class="erase_dish">X<input class="serial" type="hidden" value="<?php echo $item_pending->serialId; ?>"></a>
			    	</p>
		    		<?php endforeach; ?>
				</div>
	    		<?php $i++;
					endforeach; ?>
	    	</div>
	    </div><div id="table_0">
		    <div class="kitchen_process">
			    <h5>外卖</h5>
	    		<?php foreach ($table_0->result() as $t_zero): ?>
	    		<div class="single_takeout">
	    			<?php $currentId = $t_zero->orderId; ?>
	    			<p>订单号: <?php echo $currentId; ?><span class="finish_order">全部完成<input type="hidden" value="<?php echo $currentId; ?>" class="order_id"></span></p>
	    			<?php $sql_takeout = "SELECT dishId, serialId, dishQuantity, dishQtyAdj, dishStatus, dishChiName, dishAlphaId FROM view_order_items WHERE orderId='{$currentId}';";
		    		$result_takeout = $this->db->query($sql_takeout); 
		    		foreach ($result_takeout->result() as $item_out): 
		    		$status = $item_out->dishStatus; ?>
	    				<a class="single_takeout_dish single_dish <?php if ($status != '1') {}else{echo 'done';} ?>">
	    					<span class="dish_alpha"><?php echo $item_out->dishAlphaId; ?></span>
	    					<span class="dish_name"><?php echo $item_out->dishChiName; ?></span>
	    					<span class="dish_qty"><?php echo $item_out->dishQuantity; ?>/<span class="total"><?php echo $item_out->dishQuantity; ?></span></span>
	    					<select class="dish_qty_adj" onclick="event.stopPropagation();">
		    					<option>-</option>
		    					<?php for ($option=0; $option<=$item_e->dishQtyAdj; $option++) { // dishQuantity / dishQtyAdj;
		    					echo '<option>'.$option.'</option>';
		    					} ?>
		    				</select>
	    					<input class="serial" type="hidden" value="<?php echo $item_out->serialId; ?>">
	    				</a>
	    			<?php endforeach; ?>
	    		</div>
	    		<?php endforeach; ?>
	    	</div>			    	
	    </div>
    </div>
  </div>
</div>
<script>
	var ajax = function ajax() {
		$.ajax({
		    url: 'view_orderdetail_pickup',
		    data: {},
		    type: 'post',
		    success: function(data) {
				$("div#take_out").html($(data).find('div#take_out').html());
				$('.cancel_order').each(function() {
					var save_status = $(this);
					var order_id = $(this).children('.order_id').val();
					$(this).click(function() {
						if (confirm('确认取消订单？')) {
							$.ajax({
						        url: 'user_order_cancel',
						        data: {"data" : order_id},
						        type: "POST",
						        success: function(data) {
									location.reload();
						        }
						    });
						} else {
							return false;
						}
					});
				});

				$('.erase_dish').each(function() {
					var save_status = $(this);
					var dish_serial = $(this).children('.serial').val();
					$(this).click(function() {
						if (confirm('确认删除该餐点？')) {
							$.ajax({
								url: 'erase_single_dish',
						        data: {"data" : dish_serial},
						        type: "POST",
						        success: function(data) {
						        	location.reload();
						        }
							});
						} else {
							return false;
						}
					});
				});
		    }
		});
	}
	ajax();
	setInterval(ajax, 10000); // After 10 sec re-fetch data
	
	$('.finish_order').each(function() {
		var save_status = $(this);
		var order_id = $(this).children('.order_id').val();
		$(this).click(function() {
			$.ajax({
		        url: 'dish_status_change_all_z',
		        data: {"data" : order_id},
		        type: "POST",
		        success: function(data) {
					$(save_status).parent().parent().children('.single_dish').addClass('done');
					location.reload();
		        }
		    });
		});
	});
	
	/* $('.remove_order').each(function() {
		var save_status = $(this);
		var order_id = $(this).children('.order_id').val();
		$(this).click(function() {
			$.ajax({
		        url: 'order_status_change_finish',
		        data: {"data" : order_id},
		        type: "POST",
		        success: function(data) {
					location.reload();
		        }
		    });
		});
	}); */

	$('.dish_qty_adj').each(function() {
		var save_status = $(this);
		var dish_serial = $(this).parent().children('.serial').val();
		$(this).change(function() {
			var qty = $(this).children('option:selected').html();
			var original_qty = $(this).children('option:last-child').html();
			var final_qty = original_qty - qty;
			$.ajax({
		        url: 'dish_qty_change',
		        data: {"qty" : final_qty, "data" : dish_serial},
		        type: "POST",
		        success: function(data) {
		        	location.reload();
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
	
	function printDiv(index) {
		var orderId = document.getElementById('orderId_'+index).value;
		var tableId = document.getElementById('tableId_'+index).value;
		if (tableId == 0) {
			tableId = '外卖';
		} else {
			tableId = tableId;
		}
		var orderTime = document.getElementById('orderTime_'+index).value;
		var orderSubtotal = document.getElementById('orderSubtotal_'+index).value;
		var orderTotal = document.getElementById('orderTotal_'+index).value;
		var orderTax = document.getElementById('orderTax_'+index).value;
	    var print_count = document.getElementsByClassName('extra_'+index);
	    var printContents = '<style>body{font-family: "Arial", sans-serif;} div#main{position:relative; width: 320px;} p.center{text-align:center; margin-bottom: 0; padding-bottom: 5px;} p em{width:150px; position:absolute; right:0;} #table{width:320px; text-align:center; margin-top:10px; border-top:2px solid #333; padding-bottom: 4px;} #table .details_older.tr{font-weight: bold; margin-top: 2px;} #table .tr .onefourth, #table .tr .onethird{display:inline-block;} span.one,span.two,span.three,span.four {vertical-align: middle;font-family: "黑体", Arial, sans-serif; font-size: 15px; display: inline-block;} span.one{width:45px;} span.two{width:191px;} span.three{width:28px;} span.four{width:46px;} #table .tr.low{line-height:10px;} div#table a.erase_dish{display:none;} p.footer{font-size: 16px; line-height:18px;} p.footer.special{text-align:right; font-size: 16px;} p.footer.first{border-top:3px solid #333; padding-top:10px;} p.footer{width:320px; margin: 0; position: relative; padding-right:5px;} p.footer.small{font-size:14px;} p.footer.large{font-size:22px; font-weight:bold;} p.footer em{font-size: 16px; font-weight: normal; position: absolute; right: 0; width: 100px; text-align: right; padding-right: 5px;}</style>';
	    printContents += '<div id="main"><p class="center">www.galacafe.ca<br>';
	    printContents += 'galacafemanager@gmail.com<br>';
	    printContents += '(GST 829982370RT0001)</p>';
	    printContents += '<p style="margin-top: 10px;">Table No: <strong>' + tableId + '</strong><br>';
	    printContents += 'Order ID: ' + orderId + '<em>' + orderTime + '</em></p>';
	    if (document.getElementById('userTel_'+index) != null) {
			var userTel = document.getElementById('userTel_'+index).value;
		}
		if (document.getElementById('userName_'+index) != null) {
			var userName = document.getElementById('userName_'+index).value;
		}
		if (document.getElementById('orderRemark_'+index) != null) {
	  		var orderRemark = document.getElementById('orderRemark_'+index).value;
	  	}
	  	if (userName || userTel || orderRemark) {
		  	printContents += '<p>Client: ' + userName + '<em>' + userTel + '</em><br>Notes: ' + orderRemark + '</p>';
	  	}
	    printContents += '<div id="table">';
	    printContents += '<div class="details_older tr"><span class="one">ID</span><span class="two">Name</span><span class="three">Qty</span><span class="four">Price</span></div>';
	    var i;
	    for (i = 0; i < print_count.length; i++) {
		    printContents += '<div class="tr"><span class="low one">--</span><span class="low two">--</span><span class="low three">--</span><span class="low four">--</span></div>';
		    printContents += '<div class="tr">';
			printContents += document.getElementsByClassName('extra_'+index)[i].innerHTML;
			printContents += '</div>';
	    }
	    printContents += '</div></div>';
	    printContents += '<p class="footer special first">Tip Suggestions:</p>';
	    printContents += '<p class="footer small ">SubTotal: $ ' + orderSubtotal + '<em>10%: $'+ (orderSubtotal*0.1).toFixed(2) +'</em></p>';
	    printContents += '<p class="footer small">Tax: $ ' + orderTax + '<em>12%: $'+ (orderSubtotal*0.12).toFixed(2) +'</em></p>';
	    printContents += '<p class="footer large">Total: $ ' + orderTotal + '<em>15%: $'+ (orderSubtotal*0.15).toFixed(2) +'</em></p>';
//			    alert(printContents);
	    w = window.open();
		if(!w)alert('Please enable pop-ups');
		w.document.write(printContents);
		w.print();
		w.close(); // Comment this for testing
	}
	function myrefresh() {
		window.location.reload();
	}
	setTimeout('myrefresh()',900000); // refresh page every 15 min, Prevent Crash */
</script>