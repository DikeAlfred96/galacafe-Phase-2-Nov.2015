<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Vancouver'); ?>

<div id="back_end_control_panel">
	<!-- Nav tabs -->
	<ul class="nav nav-tabs">
	    <li><a href="<?php echo base_url(); ?>control_panel">下单</a></li>
	    <li class="active"><a href="<?php echo base_url(); ?>control_panel/view_orderhistory">历史</a></li>
	    <li><a href="<?php echo base_url(); ?>control_panel/view_orderdetail_pickup">外卖</a></li>
    	<li><a href="<?php echo base_url(); ?>control_panel/view_orderdetail_eatin">堂食</a></li>
	    <li><a href="<?php echo base_url(); ?>control_panel/view_kitchen">后堂</a></li>
  	</ul>

  <!-- Tab panes -->
  	<div class="tab-content">
	    <div id="orderhistory">
		    <!-- Nav tabs -->
			<ul class="nav" role="tablist">
				<li role="presentation" class="active"><a href="#today" aria-controls="today" role="tab" data-toggle="tab">今天</a></li><li role="presentation"><a href="#yesterday" aria-controls="yesterday" role="tab" data-toggle="tab">昨天</a></li><li role="presentation"><a href="#older" aria-controls="older" role="tab" data-toggle="tab">更早</a></li>
			</ul>
		
			<!-- Tab panes -->
			<div class="tab-content">
		    	<div role="tabpanel" class="tab-pane active" id="today">
			    	<table class="table-today">
				    	<!-- <thead>
				    		<tr>
				    			<th>打印</th>
				    			<th>桌号</th>
					    		<th>编号</th>
				    			<th>下单</th>
				    			<th>总额(含税)</th>
				    			<th></th>
				    			<th>状态</th>
				    		</tr>
				    	</thead> -->
				    	<?php if ($today_history) {
					    	$i=1; $x=1; ?>
				    	<tbody>
					    <?php foreach ($today_history->result() as $item):
								$odd = ($x%2 == 0)? 'odd': '';
								$order_status = $item->orderStatus; 
								$order_remarks = $item->orderRemarks;
								$table_id = $item->tableId;
								$user_tel = $item->userTel;
								$user_name = $item->userName;
								$current_result_order = $item->orderId;
								$alias = $item->orderAlias;
								$order_subtotal = $item->orderSubtotal;
								$order_tax = $item->orderTax;
								$sql_dishes = "SELECT order_items.dishId, order_items.dishQuantity, order_items.dishStatus, dishes.dishChiName, dishes.dishEngName, dishes.dishPrice, dishes.dishAlphaId FROM order_items INNER JOIN dishes ON order_items.dishId=dishes.dishId WHERE orderId='{$current_result_order}';";
								$result_dishes = $this->db->query($sql_dishes); ?>
				    		<tr class="<?php echo $odd; ?> order_single">
					    		<input type="hidden" value="<?php echo $current_result_order; ?>" class="orderId_<?php echo $i; ?>">
					    		<input type="hidden" value="<?php echo $table_id ?>" class="tableId_<?php echo $i; ?>">
					    		<?php if ($table_id == 0) { ?>
					    		<input type="hidden" value="<?php echo $alias; ?>" class="orderAlias_<?php echo $i; ?>">
					    		<?php } ?>
					    		<?php if ($user_tel != '') { ?><input type="hidden" value="<?php echo $user_tel; ?>" class="userTel_<?php echo $i; ?>"><?php } ?>
					    		<?php if ($user_name != '') { ?><input type="hidden" value="<?php echo $user_name; ?>" class="userName_<?php echo $i; ?>"><?php } ?>
					    		<?php if ($order_remarks != '') { ?><input type="hidden" value="<?php echo $order_remarks; ?>" class="orderRemark_<?php echo $i; ?>"><?php } ?>
					    		<input type="hidden" value="<?php echo $order_subtotal; ?>" class="orderSubtotal_<?php echo $i; ?>">
					    		<input type="hidden" value="<?php echo $order_tax ?>" class="orderTax_<?php echo $i; ?>">
					    		
					    		<td><input type="button" value="打印" class="print_order print_details_<?php echo $i; ?>" onclick="printDiv('<?php echo $i; ?>', 'today')"></td>
					    		<td><button class="admin_show_details_today show_details_<?php echo $i; ?>">查看</button></td>
					    		<td><?php if ($table_id == '0') { echo $alias; } else { echo $table_id; } ?></td>
				    			<td><?php echo $item->orderId; ?></td><td class="orderTotal_<?php echo $i; ?>">$<?php echo $item->orderTotal; ?></td>
				    			<td class="orderTime_<?php echo $i; ?>"><?php echo $item->orderTime; ?></td>
				    			<td class="orderFinishTime_<?php echo $i; ?>"><?php echo $item->orderFinishTime; ?></td>
				    			<td><?php if ($order_status == '0') { ?>审核中<?php } else if ($order_status == '1') { ?>已下单<?php } else if ($order_status == '3') { ?>已完成<?php } else { ?>订单错误<?php } ?></td>
				    		</tr>
				    		<tr class="details_today extra_<?php echo $i; ?>">
					    		<th class="one_third">ID</th>
				    			<th class="one_third">Name</th>
				    			<th class="one_third">Qty</th>
				    			<th class="one_third">Price</th>
				    		</tr>
							<?php foreach ($result_dishes->result() as $items): ?>
							<tr class="details_today extra_<?php echo $i; ?>">
					    		<td><?php echo $items->dishAlphaId; ?></td>
					    		<td><?php echo $items->dishChiName; ?>
					    		<td><?php echo $items->dishQuantity; ?></td>
					    		<td><?php echo '$ '.round(($items->dishPrice)*($items->dishQuantity), 2); ?></td>
						    </tr>
						    <tr class="details_older extra_<?php echo $i; ?>">
						    	<td colspan="4"><?php echo $items->dishEngName; ?></td>
						    </tr>
						    <?php endforeach; ?>
						<?php $i++;$x++;
				    	endforeach; ?>
				    	</tbody>
				    	<?php } else { ?>
						<tbody>
							没有查询到订单记录...
						</tbody>
					    <?php } ?>
				    </table>
		    	</div>
		    	<div role="tabpanel" class="tab-pane" id="yesterday">
			    	<table class="table-yesterday">
				    	<!-- <thead>
				    		<tr>
				    			<th>打印</th>
				    			<th>桌号</th>
					    		<th>编号</th>
				    			<th>下单</th>
				    			<th>总额(含税)</th>
				    			<th></th>
				    			<th>状态</th>
				    		</tr>
				    	</thead> -->
				    	<?php if ($one_day_history) {
					    	$i=1; $x=1; ?>
				    	<tbody>
					    <?php foreach ($one_day_history->result() as $item):
								$odd = ($x%2 == 0)? 'odd': '';
								$order_status = $item->orderStatus; 
								$order_remarks = $item->orderRemarks;
								$table_id = $item->tableId;
								$user_tel = $item->userTel;
								$user_name = $item->userName;
								$current_result_order = $item->orderId;
								$alias = $item->orderAlias;
								$order_subtotal = $item->orderSubtotal;
								$order_tax = $item->orderTax;
								$sql_dishes = "SELECT order_items.dishId, order_items.dishQuantity, order_items.dishStatus, dishes.dishChiName, dishes.dishEngName, dishes.dishPrice, dishes.dishAlphaId FROM order_items INNER JOIN dishes ON order_items.dishId=dishes.dishId WHERE orderId='{$current_result_order}';";
								$result_dishes = $this->db->query($sql_dishes); ?>
				    		<tr class="<?php echo $odd; ?> order_single">
					    		<input type="hidden" value="<?php echo $current_result_order; ?>" class="orderId_<?php echo $i; ?>">
					    		<input type="hidden" value="<?php echo $table_id; ?>" class="tableId_<?php echo $i; ?>">
					    		<?php if ($table_id == 0) { ?>
					    		<input type="hidden" value="<?php echo $alias; ?>" class="orderAlias_<?php echo $i; ?>">
					    		<?php } ?>
					    		<?php if ($user_tel != '') { ?><input type="hidden" value="<?php echo $user_tel; ?>" class="userTel_<?php echo $i; ?>"><?php } ?>
					    		<?php if ($user_name != '') { ?><input type="hidden" value="<?php echo $user_name; ?>" class="userName_<?php echo $i; ?>"><?php } ?>
					    		<?php if ($order_remarks != '') { ?><input type="hidden" value="<?php echo $order_remarks; ?>" class="orderRemark_<?php echo $i; ?>"><?php } ?>
					    		<input type="hidden" value="<?php echo $order_subtotal; ?>" class="orderSubtotal_<?php echo $i; ?>">
					    		<input type="hidden" value="<?php echo $order_tax ?>" class="orderTax_<?php echo $i; ?>">
					    		
					    		<td><input type="button" value="打印" class="print_order print_details_<?php echo $i; ?>" onclick="printDiv('<?php echo $i; ?>', 'yesterday')"></td>
								<td><button class="admin_show_details_yesterday show_details_<?php echo $i; ?>">查看</button></td>
								<td><?php if ($table_id == '0') { echo $alias; } else { echo $table_id; } ?></td>
				    			<td><?php echo $item->orderId; ?></td><td class="orderTotal_<?php echo $i; ?>">$<?php echo $item->orderTotal; ?></td>
				    			<td class="orderTime_<?php echo $i; ?>"><?php echo $item->orderTime; ?></td>
				    			<td class="orderFinishTime_<?php echo $i; ?>"><?php echo $item->orderFinishTime; ?></td>
								<td><?php if ($order_status == '0') { ?>审核中<?php } else if ($order_status == '1') { ?>已下单<?php } else if ($order_status == '3') { ?>已完成<?php } else { ?>订单错误<?php } ?></td>
				    		</tr>
				    		<tr class="details_yesterday extra_<?php echo $i; ?>">
					    		<th class="one_third">ID</th>
				    			<th class="one_third">Name</th>
				    			<th class="one_third">Qty</th>
				    			<th class="one_third">Price</th>
				    		</tr>
							<?php foreach ($result_dishes->result() as $items): ?>
							<tr class="details_yesterday extra_<?php echo $i; ?>">
					    		<td><?php echo $items->dishAlphaId; ?></td>
					    		<td><?php echo $items->dishChiName; ?>
					    		<td><?php echo $items->dishQuantity; ?></td>
					    		<td><?php echo '$ '.round(($items->dishPrice)*($items->dishQuantity), 2); ?></td>
						    </tr>
						    <tr class="details_older extra_<?php echo $i; ?>">
						    	<td colspan="4"><?php echo $items->dishEngName; ?></td>
						    </tr>
						    <?php endforeach; ?>
						<?php $i++;$x++;
				    	endforeach; ?>
				    	</tbody>
				    	<?php } else { ?>
						<tbody>
							<tr><th col="6">没有查询到订单记录...</th></tr>
						</tbody>
					    <?php } ?>
				    </table>
		    	</div>
		    	<div role="tabpanel" class="tab-pane" id="older">
			    	<table class="table-older">
				    	<!-- <thead>
				    		<tr>
				    			<th>打印</th>
				    			<th>桌号</th>
					    		<th>编号</th>
				    			<th>下单</th>
				    			<th>总额(含税)</th>
				    			<th></th>
				    			<th>状态</th>
				    		</tr>
				    	</thead> -->
				    	<?php if ($older_history) {
					    	$i=1; $x=1; ?>
				    	<tbody>
					    <?php foreach ($older_history->result() as $item):
								$odd = ($x%2 == 0)? 'odd': '';
								$order_status = $item->orderStatus;
								$order_remarks = $item->orderRemarks;
								$table_id = $item->tableId;
								$user_tel = $item->userTel;
								$user_name = $item->userName;
								$current_result_order = $item->orderId;
								$alias = $item->orderAlias;
								$order_subtotal = $item->orderSubtotal;
								$order_tax = $item->orderTax;
								$sql_dishes = "SELECT order_items.dishId, order_items.dishQuantity, order_items.dishStatus, dishes.dishChiName, dishes.dishEngName, dishes.dishPrice, dishes.dishAlphaId FROM order_items INNER JOIN dishes ON order_items.dishId=dishes.dishId WHERE orderId='{$current_result_order}';";
								$result_dishes = $this->db->query($sql_dishes); ?>
				    		<tr class="<?php echo $odd; ?> order_single">
					    		<input type="hidden" value="<?php echo $current_result_order; ?>" class="orderId_<?php echo $i; ?>">
					    		<input type="hidden" value="<?php echo $table_id ?>" class="tableId_<?php echo $i; ?>">
					    		<?php if ($table_id == 0) { ?>
					    		<input type="hidden" value="<?php echo $alias; ?>" class="orderAlias_<?php echo $i; ?>">
					    		<?php } ?>
					    		<?php if ($user_tel != '') { ?><input type="hidden" value="<?php echo $user_tel; ?>" class="userTel_<?php echo $i; ?>"><?php } ?>
					    		<?php if ($user_name != '') { ?><input type="hidden" value="<?php echo $user_name; ?>" class="userName_<?php echo $i; ?>"><?php } ?>
					    		<?php if ($order_remarks != '') { ?><input type="hidden" value="<?php echo $order_remarks; ?>" class="orderRemark_<?php echo $i; ?>"><?php } ?>
					    		<input type="hidden" value="<?php echo $order_subtotal; ?>" class="orderSubtotal_<?php echo $i; ?>">
					    		<input type="hidden" value="<?php echo $order_tax ?>" class="orderTax_<?php echo $i; ?>">
					    		
					    		<td><input type="button" value="打印" class="print_order print_details_<?php echo $i; ?>" onclick="printDiv('<?php echo $i; ?>', 'older')"></td>
					    		<td><button class="admin_show_details_older show_details_<?php echo $i; ?>">查看</button></td>
					    		<td><?php if ($table_id == '0') { echo $alias; } else { echo $table_id; } ?></td>
					    		<td><?php echo $item->orderId; ?></td><td class="orderTotal_<?php echo $i; ?>">$<?php echo $item->orderTotal; ?></td>
				    			<td class="orderTime_<?php echo $i; ?>"><?php echo $item->orderTime; ?></td>
				    			<td class="orderFinishTime_<?php echo $i; ?>"><?php echo $item->orderFinishTime; ?></td>
				    			<td><?php if ($order_status == '0') { ?>审核中<?php } else if ($order_status == '1') { ?>已下单<?php } else if ($order_status == '3') { ?>已完成<?php } else { ?>订单错误<?php } ?></td>
				    		</tr>
				    		<tr class="details_older extra_<?php echo $i; ?>">
					    		<th class="one_third">ID</th>
				    			<th class="one_third">Name</th>
				    			<th class="one_third">Qty</th>
				    			<th class="one_third">Price</th>
				    		</tr>
							<?php foreach ($result_dishes->result() as $items): ?>
							<tr class="details_older extra_<?php echo $i; ?>">
					    		<td><?php echo $items->dishAlphaId; ?></td>
					    		<td><?php echo $items->dishChiName; ?></td>
					    		<td><?php echo $items->dishQuantity; ?></td>
					    		<td><?php echo '$ '.round(($items->dishPrice)*($items->dishQuantity), 2); ?></td>
						    </tr>
						    <tr class="details_older extra_<?php echo $i; ?>">
						    	<td colspan="4"><?php echo $items->dishEngName; ?></td>
						    </tr>
						    <?php endforeach; ?>
						<?php $i++;$x++;
				    	endforeach; ?>
				    	</tbody>
				    	<?php } else { ?>
						<tbody>
							没有查询到订单记录...
						</tbody>
					    <?php } ?>
				    </table>
		    	</div>
			</div>
	    </div>
  	</div>
  	<script>
	  	function printDiv(index, section) {
		  	var orderId = document.getElementById(section).getElementsByClassName('orderId_'+index)[0].value;
		  	var tableId = document.getElementById(section).getElementsByClassName('tableId_'+index)[0].value;
		  	if (tableId == 0) {
		  		var aliasId = document.getElementById(section).getElementsByClassName('orderAlias_'+index)[0].value;
			  	tableId = '<span class="table_id">外卖</span>' + aliasId;
			} else {
				tableId = tableId;
			}
		  	var orderTime = document.getElementById(section).getElementsByClassName('orderTime_'+index)[0].innerHTML;
		  	var orderSubtotal = document.getElementById(section).getElementsByClassName('orderSubtotal_'+index)[0].value;
		  	var orderTotal = document.getElementById(section).getElementsByClassName('orderTotal_'+index)[0].innerHTML;
		  	var orderTax = document.getElementById(section).getElementsByClassName('orderTax_'+index)[0].value;
		    var print_count = document.getElementById(section).getElementsByClassName('extra_'+index);
		    var printContents = '<style>body{font-family: "Arial", sans-serif;}div#main{position:relative; width: 320px;}p.center{text-align:center; margin-bottom: 0; padding-bottom: 5px;}p em{width:150px; position:absolute; right:0;}p strong{font-size:16px;}p .table_id{font-size: 14px;}table{width:320px; text-align:center; margin-top:10px; border-top:2px solid #333;}table tr{font-family: "黑体", Arial, sans-serif; font-size: 15px;}table td.low{line-height:10px;vertical-align:center;}p.footer{font-size: 16px; line-height:18px;}p.footer.special{text-align:right; font-size: 16px;}p.footer.first{border-top:3px solid #333; padding-top:10px;}p.footer{width:320px; margin: 0; position: relative; padding-right:5px;}p.footer.small{font-size:14px;}p.footer.large{font-size:22px; font-weight:bold;}p.footer em{font-size: 16px; font-weight: normal; position: absolute; right: 0; width: 100px; text-align: right; padding-right: 5px;}</style>'
		    printContents += '<div id="main"><p class="center">www.galacafe.ca<br>';
		    printContents += 'galacafemanager@gmail.com<br>';
		    printContents += '(GST 829982370RT0001)</p>';
		    printContents += '<p style="margin-top: 10px;">Table No: <strong>' + tableId + '</strong><br>';
		    printContents += 'Order ID: ' + orderId + '<em>' + orderTime + '</em></p>';
		    if (document.getElementById(section).getElementsByClassName('userTel_'+index)[0] != null) {
		  		var userTel = document.getElementById(section).getElementsByClassName('userTel_'+index)[0].value;
		  	}
		  	if (document.getElementById(section).getElementsByClassName('userName_'+index)[0] != null) {
		  		var userName = document.getElementById(section).getElementsByClassName('userName_'+index)[0].value;
		  	}
		  	if (document.getElementById(section).getElementsByClassName('orderRemark_'+index)[0] != null) {
		  		var orderRemark = document.getElementById(section).getElementsByClassName('orderRemark_'+index)[0].value;
		  	}
		  	if (userName || userTel || orderRemark) {
			  	printContents += '<p>Client: ' + userName + '<em>' + userTel + '</em><br>Notes: ' + orderRemark + '</p>';
		  	}
		    printContents += '<table>';
		    printContents += '<tr class="details_older"><th class="one_third">ID</th><th class="one_third">Name</th><th class="one_third">Qty</th><th class="one_third">Price</th></tr>';
		    var i;
		    for (i = 1; i < print_count.length; i++) {
			    if (i % 2 == 1) {
			    	printContents += '<tr><td class="low">--</td><td class="low">--</td><td class="low">--</td><td class="low">--</td></tr>';
			    }
			    printContents += '<tr>';
				printContents += document.getElementById(section).getElementsByClassName('extra_'+index)[i].innerHTML;
				printContents += '</tr>';
		    }
		    printContents += '</table></div>';
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
  	</script>
</div>