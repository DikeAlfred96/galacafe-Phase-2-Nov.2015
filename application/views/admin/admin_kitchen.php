<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Vancouver');
?>

<div class="wrapper">
	<div id="back_end_control_panel">
		<!-- Nav tabs -->
	  <ul class="nav nav-tabs">
	    <li><a href="<?php echo base_url(); ?>control_panel">下单</a></li>
	    <li><a href="<?php echo base_url(); ?>control_panel/view_orderhistory">历史</a></li>
	    <li><a href="<?php echo base_url(); ?>control_panel/view_orderdetail_pickup">外卖</a></li>
	    <li><a href="<?php echo base_url(); ?>control_panel/view_orderdetail_eatin">堂食</a></li>
	    <li class="active"><a href="<?php echo base_url(); ?>control_panel/view_kitchen">后堂</a></li>
	  </ul>
	
	  <!-- Tab panes -->
	  <div class="tab-content">
	    <div id="kitchen">
		    <?php $category = array('1','2','3','4','5','6','7','8');
			    for ($cid=1; $cid<=8; $cid++) { ?>
		    <div class="catagory">
				<h5><?php echo $category[$cid-1]; ?></h5>
				<?php foreach (${"dish_status_".$cid}->result() as $items):
					$currentName = $items->dishChiName; 
					$dishTotal = $items->dishTotal;
					$sql_dish_qty = "SELECT dishQuantity, dishChiName, dishStatus, tableId, orderAlias, orderTime, catId FROM view_kitchen WHERE dishStatus=0 AND catId='{$cid}' AND dishChiName='{$currentName}' ORDER BY orderTime DESC, dishQuantity DESC";
					$result_dish_qty = $this->db->query($sql_dish_qty); ?>
					<div class="single_dish">
						<div class="left_dish">
							<span class="dishname"><?php echo $currentName; ?></span>
							<span class="totalnum"><?php echo $dishTotal; ?></span>
						</div>
						<div class="right_dish">
					<?php foreach ($result_dish_qty->result() as $dishes): 
						$table = $dishes->tableId;
						$alias = $dishes->orderAlias;
					?>
						<div class="unit">
							<span class="table"><?php if ($table != 0) {echo $table;} else {echo $alias;} ?></span>
							<span class="qty"><?php echo $dishes->dishQuantity; ?></span>
						</div>
					<?php endforeach; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<?php } ?>
	    </div>
	  </div>
	</div>
	<script type="text/javascript">
		var height = $('#kitchen .catagory:nth-child(6)').outerHeight();
		$('#kitchen .catagory:nth-child(7)').css("top", height+30);
	</script>
</div>