<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="wrapper">
	<div class="shopping_cart">
	    <div class="cart_list">
	        <h3>美食车</h3>
			<div id="cart_content">
	            <?php echo $this->view('cart'); ?>
			</div>
		</div>
	</div>
	<div class="dishes_wrap">
		<ul class="nav nav-tabs" role="tablist">
		    <li role="presentation" class="active"><a href="#appetizer" aria-controls="appetizer" role="tab" data-toggle="tab">凉菜</a></li>
		    <li role="presentation"><a href="#main_course" aria-controls="main_course" role="tab" data-toggle="tab">主菜</a></li>
		    <li role="presentation"><a href="#kebab" aria-controls="kebab" role="tab" data-toggle="tab">串</a></li>
		    <li role="presentation"><a href="#noodle_rice_congee" aria-controls="noodle_rice_congee" role="tab" data-toggle="tab">主食</a></li>
		    <li role="presentation"><a href="#dessert" aria-controls="dessert" role="tab" data-toggle="tab">甜品</a></li>
		    <li role="presentation"><a href="#combo" aria-controls="combo" role="tab" data-toggle="tab">套餐</a></li>
		</ul>
	
		<!-- Tab panes -->
		<div class="tab-content">	
			<?php $category = array('appetizer','main_course','kebab','noodle_rice_congee','dessert','combo','','');
				for ($cat=1; $cat<= 6; $cat++) { ?>
		    <div role="tabpanel" class="tab-pane active" id="<?php echo $category[$cat-1]; ?>">
				<ul class="category_wrap">
					<?php foreach($dishes as $d): if ($d['catId'] == $cat) {?>
				    <li class="single_dish">
				    	<h3><?php echo $d['dishChiName']; ?></h3>
				    	<h6><?php echo $d['dishEngName']; ?></h6>
<!--				        <img src="<?php echo base_url(); ?>assets/img/products/<?php echo $d['imagePath']; ?>" alt="" /> -->
				        <small>&dollar;<?php echo $d['dishPrice']; ?></small>
				        <?php echo form_open('cart/add_cart_dishes'); ?>
				            <fieldset>
				                <?php echo form_hidden('quantity', '1'); ?>
				                <?php echo form_hidden('product_id', $d['dishId']); ?>
				                <?php echo form_submit('add', '+'); ?>
				            </fieldset>
				        <?php echo form_close();?>
				    </li>
				    <?php } endforeach;?>
				</ul>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<script charset="utf-8">
	$(window).scroll(function() {    
	    var scroll = $(window).scrollTop();
	    if (scroll >= 50) {
	        $(".shopping_cart").addClass("fixed");
	    } else {
		    $(".shopping_cart").removeClass("fixed");
	    }
	});
</script>