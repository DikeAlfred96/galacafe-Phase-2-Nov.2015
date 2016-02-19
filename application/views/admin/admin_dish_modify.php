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
  	<div id="dishesmodify">
      <div class="single_dish">
        <div class="dish_id inline">
          Id
        </div>
        <div class="dish_alphaid inline">
          餐点代码
        </div>
        <div class="dish_chiname inline">
          中文名
        </div>
        <div class="dish_fullchiname inline">
          中文全名
        </div>
        <div class="dish_dishengname inline">
          英文名
        </div>
        <div class="dish_dishinitial inline">
          拼音首字
        </div>
        <div class="dish_price inline">
          价格
        </div>
        <div class="dish_kitchencat inline">
          厨房菜类
        </div>
        <div class="dish_image inline">
          图片
        </div>
        <div class="dish_usercat inline">
          用户菜类
        </div>
      </div>
	    <?php foreach ($fetch_dishes->result() as $item): ?>
      <div class="single_dish">
        <div class="dish_id inline">
          <?php echo $item->dishId; ?>
        </div>
        <div class="dish_alphaid inline">
          <?php echo $item->dishAlphaId; ?>
        </div>
        <div class="dish_chiname inline">
          <?php echo $item->dishChiName; ?>
        </div>
        <div class="dish_fullchiname inline">
          <?php echo $item->dishFullChiName; ?>
        </div>
        <div class="dish_dishengname inline">
          <?php echo $item->dishEngName; ?>
        </div>
        <div class="dish_dishinitial inline">
          <?php echo $item->dishInitial; ?>
        </div>
        <div class="dish_price inline">
          <?php echo $item->dishPrice; ?>
        </div>
        <div class="dish_kitchencat inline">
          <?php echo $item->catId; ?>
        </div>
        <div class="dish_image inline">
          <?php echo $item->imagePath; ?>
        </div>
        <div class="dish_usercat inline">
          <?php echo $item->userCatId; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
