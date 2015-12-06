<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="wrapper">
	<div id="back_end_control_panel">
		<!-- Nav tabs -->
	  <ul class="nav nav-tabs">
	    <li><a href="<?php echo base_url(); ?>control_panel">餐厅下单</a></li>
	    <li><a href="<?php echo base_url(); ?>control_panel/view_orderhistory">订单历史</a></li>
	    <li><a href="<?php echo base_url(); ?>control_panel/view_orderdetail_pickup">外卖订单</a></li>
	    <li><a href="<?php echo base_url(); ?>control_panel/view_orderdetail_eatin">堂食订单</a></li>
	    <li class="active"><a href="<?php echo base_url(); ?>control_panel/view_kitchen">后堂汇总</a></li>
	    <li><a href="<?php echo base_url(); ?>control_panel/view_dishesmodify">菜肴操作</a></li>
	    <li><a href="<?php echo base_url(); ?>control_panel/view_analytics">报告</a></li>
	  </ul>
	
	  <!-- Tab panes -->
	  <div class="tab-content">
	    <div id="kitchen">
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>theme/js/jquery-11.0.js"></script>
<script>
	var ajax = function ajax() {
		$.ajax({
		    url: 'view_kitchen_iframe',
		    data: {},
		    type: 'post',
		    success: function(data) {
				$("div.wrapper").html($(data).find('.wrapper').html());
		    }
		});
	}
	ajax();
	setInterval(ajax, 6000); // Maximize this number if test.
	
	function myrefresh() {
		window.location.reload();
	}
	setInterval('myrefresh()',600000); // refresh page every 10 min */
	
</script>
</html>