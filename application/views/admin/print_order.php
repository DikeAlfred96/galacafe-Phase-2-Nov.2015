<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>

<style>
	#header,
	#footer {
		display: none;
	}
	body {
		font-family: "Arial", sans-serif;
	}
	div#main {
		position: relative;
		width: 320px;
	}
	p.center {
		text-align: center;
		margin-bottom: 0;
		padding-bottom: 5px;
	}
	p strong {
		font-size: 18px;
	}
	p .table_id {
		font-size: 14px;
	}
	p em {
		width: 150px;
		position: absolute;
		right: 0;
	}
	table {
		width: 320px;
		text-align: center;
		margin-top: 10px;
		border-top: 2px solid #333;
	}
	table tr.sub_title th {
		text-align: center !important;
	}
	table tr {
		font-family: "黑体", Arial, sans-serif;
		font-size: 15px;
		text-align: center;
	}
	table td.low {
		line-height: 10px;
		vertical-align: center;
	}
	p.footer {
		font-size: 16px;
		line-height: 18px;
	}
	p.footer.special {
		text-align: right;
		font-size: 16px;
	}
	p.footer.first {
		border-top: 3px solid #333;
		padding-top: 10px;
	}
	p.footer {
		width: 320px;
		margin: 0;
		position: relative;
		padding-right: 5px;
	}
	p.footer.small {
		font-size: 14px;
	}
	p.footer.large {
		font-size: 22px;
		font-weight: bold;
	}
	p.footer em {
		font-size: 16px;
		font-weight: normal;
		position: absolute;
		right: 0;
		width: 100px;
		text-align: right;
		padding-right: 5px;
	}
</style>
<!--<style>
	body {
		font-family: "Arial", sans-serif;
	}
	p, tr, td, th {
		font-family: "Times New Roman", serif !important;
		font-size: 1.1em;
	}
	div#main {
		position: relative;
		width: 320px;
		font-family: "Times New Roman", serif !important;
	}
	p.center {
		text-align: center;
		border-bottom: 1px solid #aaa;
		margin-bottom: 0;
		padding-bottom: 5px;
	}
	p em {
		width: 150px;
		position: absolute;
		right: 0;
	}
	table {
		width: 320px;
		text-align: center;
		margin-top: 10px;
		border-top: 2px solid #333;
	}
	table tr {
		width: 33.33%;
	}
	table tr.sub_title th {
		text-align: center;
		font-weight: bold;
		font-size: 16px;
	}
	table td.low {
		line-height: 10px;
		vertical-align: center;
	}
	p.footer.special {
		text-align: right;
		font-size: 14px;
	}
	p.footer.first {
		border-top: 3px solid #333;
		padding-top: 10px;
	}
	p.footer {
		width: 320px;
		margin: 0;
		position: relative;
	}
	p.footer.small {
		font-size: 14px;
	}
	p.footer.large {
		font-size: 18px;
		font-weight: bold;
	}
	p.footer em {
		font-size: 14px;
		font-weight: normal;
		position: absolute;
		right: 0;
		width: 100px;
		text-align: right;
	}
</style>-->
<?php foreach ($latest_order->result() as $item): 
	$table_id = $item->tableId; ?>
<div id="main">
	<p class="center">www.galacafe.ca<br>galacafemanager@gmail.com<br>(GST 829982370RT0001)</p>
	<p style="margin-top: 10px;">Table No: <strong><?php if ($table_id != 0) { echo $item->tableId;} else {echo '<span class="table_id">外卖</span>'; echo $item->orderAlias;} ?></strong><br>Order ID: <?php echo $item->orderId; ?><em><?php echo $item->orderTime; ?></em></p>
	<?php if ($item->userTel != null || $item->userName != null) { ?>
		<p>Client: <?php echo $item->userName; ?><em><?php echo $item->userTel; ?></em></p>
	<?php } ?>
	<table>
		<tr class="sub_title">
			<th>ID</th>
			<th>Name</th>
			<th>Qty</th>
			<th>Price</th>
		</tr>
		<?php 
			$current_order_id = $item->orderId; 
			$sql_dishes = "SELECT order_items.dishId, order_items.dishQuantity, order_items.dishStatus, dishes.dishChiName, dishes.dishEngName, dishes.dishPrice, dishes.dishAlphaId FROM order_items INNER JOIN dishes ON order_items.dishId=dishes.dishId WHERE orderId='{$current_order_id}';";
			$result_dishes = $this->db->query($sql_dishes);
			foreach ($result_dishes->result() as $items): ?>
			<tr><td class="low">--</td><td class="low">--</td><td class="low">--</td><td class="low">--</td></tr>
			<tr>
				<td><?php echo $items->dishAlphaId; ?></td>
				<td><?php echo $items->dishChiName; ?></td>
				<td><?php echo $items->dishQuantity; ?></td>
				<td><?php echo round(($items->dishPrice)*($items->dishQuantity), 2); ?></td>
			</tr>
			<tr>
				<td colspan="4"><?php echo $items->dishEngName; ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>
<p class="footer special first">Tip Suggestions:</p>
<p class="footer small ">SubTotal: $ <?php echo $subtotal = $item->orderSubtotal; ?><em>10%: $<?php echo round($subtotal*0.1, 2); ?></em></p>
<p class="footer small">Tax: $ <?php echo $item->orderTax; ?><em>12%: $<?php echo round($subtotal*0.12, 2); ?></em></p>
<p class="footer large">Total: $ <?php echo $item->orderTotal; ?><em>15%: $<?php echo round($subtotal*0.15, 2); ?></em></p>
<?php endforeach; ?>

<script>
	$(document).ready(function() {
		window.print();
		document.location.href = "<?php echo base_url(); ?>control_panel";
	});
</script>