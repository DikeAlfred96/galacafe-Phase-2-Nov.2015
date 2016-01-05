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
    <li><a href="<?php echo base_url(); ?>control_panel/view_orderdetail_eatin">堂食</a></li>
    <li><a href="<?php echo base_url(); ?>control_panel/view_kitchen">后堂</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
  	<div id="analytics">
	    报告
    </div>
  </div>
</div>