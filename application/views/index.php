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
		    <li role="presentation"><a href="#kebab" aria-controls="kebab" role="tab" data-toggle="tab">烤串</a></li>
		    <li role="presentation"><a href="#nine_dish" aria-controls="nine_dish" role="tab" data-toggle="tab">九道</a></li>
		    <li role="presentation"><a href="#noodle_rice_congee" aria-controls="noodle_rice_congee" role="tab" data-toggle="tab">主食</a></li>
		    <li role="presentation"><a href="#dessert" aria-controls="dessert" role="tab" data-toggle="tab">甜点</a></li>
		    <li role="presentation"><a href="#drinks" aria-controls="drinks" role="tab" data-toggle="tab">饮料</a></li>
		    <li role="presentation"><a href="#combo" aria-controls="combo" role="tab" data-toggle="tab">套餐</a></li>
		</ul>
	
		<!-- Tab panes -->
		<div class="tab-content">	
<?php 		$category = array('appetizer','main_course','kebab','nine_dish','noodle_rice_congee','dessert','drinks','combo');
			$active = array('active', '', '', '', '', '', '', '');
				for ($cat=1; $cat<= 8; $cat++) { ?>
		    <div role="tabpanel" class="tab-pane <?php echo $active[$cat-1]; ?>" id="<?php echo $category[$cat-1]; ?>">
				<ul class="category_wrap">
					<?php foreach($dishes as $d): if ($d['userCatId'] == $cat) { ?>
				    <li class="single_dish">
				    	<h3><?php echo $d['dishFullChiName']; ?></h3>
				    	<h6><?php echo $d['dishEngName']; ?></h6>
<!--				        <img src="<?php echo base_url(); ?>assets/img/products/<?php echo $d['imagePath']; ?>" alt="" /> -->
				        <small>&dollar;<?php echo $d['dishPrice']; ?></small>
				        <?php echo '<form action="cart/add_cart_dishes" method="post" accept-charset="utf-8">'; ?>
				            <fieldset>
				                <?php echo form_hidden('quantity', '1'); ?>
				                <?php echo form_hidden('product_id', $d['dishId']); ?>
				                <?php echo form_submit('add', '+'); ?>
				            </fieldset>
				        <?php echo form_close();?>
				    </li>
				    <?php } endforeach;?>
				</ul>
				<?php if ($cat == 1) { ?><img src="theme/images/user/cat_back_1.jpg"><?php } else if ($cat == 2) { } ?>
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