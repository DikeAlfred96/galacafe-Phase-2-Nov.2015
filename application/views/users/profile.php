<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>

<div class="wrapper">
	<div id="back_end_profile">
		<!-- Nav tabs -->
		<ul class="nav" role="tablist">
			<li role="presentation" class="active"><a href="#order_history" aria-controls="order_history" role="tab" data-toggle="tab">订单历史</a></li><li role="presentation"><a href="#my_account" aria-controls="my_account" role="tab" data-toggle="tab">我的账户</a></li>
		</ul>
	
		<!-- Tab panes -->
		<div class="tab-content">
	    	<div role="tabpanel" class="tab-pane active" id="order_history">
			    <table class="table-hover">
			    	<thead>
			    		<tr>
				    		<th>订单编号</th>
			    			<th>下单时间</th>
			    			<th>订单总额(含税)</th>
			    			<th>订单详情</th>
			    			<th>订单状态</th>
			    		</tr>
			    	</thead>
			    	<?php if ($result_order && $result_dishes) {
				    	$i=1; $x=1; ?>
			    	<tbody>
				    <?php foreach ($result_order->result() as $item):
							$odd = ($x%2 == 0)? 'odd': '';
							$order_status = $item->orderStatus; 
							$current_result_order = $item->orderId;
							$sql_dishes = "SELECT order_items.dishId, order_items.dishQuantity, order_items.dishStatus, dishes.dishChiName, dishes.dishPrice, dishes.dishAlphaId FROM order_items INNER JOIN dishes ON order_items.dishId=dishes.dishId WHERE orderId='{$current_result_order}';";
							$result_dishes = $this->db->query($sql_dishes); ?>
			    		<tr class="<?php echo $odd; ?> order_single">
			    			<td><?php echo $item->orderId; ?></td>
			    			<td><?php echo $item->orderTime; ?></td>
			    			<td><?php echo $item->orderTotal; ?></td>
			    			<td><button class="show_details show_details_<?php echo $i; ?>">查看</button></td>
			    			<td><?php if ($order_status == '0') { ?>审核中<?php } else if ($order_status == '1') { ?>已下单<?php } else if ($order_status == '2') { ?>等待取餐<?php } else if ($order_status == '3') { ?>已完成<?php } else if ($order_status == '4') { ?>已取消<?php } else { ?>订单错误<?php } ?></td>
			    		</tr>
			    		<tr class="details extra_<?php echo $i; ?>">
				    		<th class="one_third">菜品编号</th>
			    			<th class="one_third">菜品名称</th>
			    			<th class="one_third">菜品价格</th>
			    		</tr>
						<?php foreach ($result_dishes->result() as $items): ?>
						<tr class="details extra_<?php echo $i; ?>">
				    		<td><?php echo $items->dishAlphaId; ?></td>
				    		<td><?php echo $items->dishChiName; ?></td>
				    		<td><?php echo $items->dishPrice; ?></td>
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
	    	
		    <div role="tabpanel" class="tab-pane" id="my_account">
			    Coming Soon...
		    </div>
		</div>
	</div>
</div>








