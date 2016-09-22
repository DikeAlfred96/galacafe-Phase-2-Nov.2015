<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="wrapper">
	<div id="main_nav">
		<nav class="sub_nav nav-down" id="user_log">
			<ul>
				<?php if ($this->session->userdata('is_logged_in')) { ?>
				<!--<li>欢迎: <a href="<?php // echo base_url(); ?>profile"><?php // echo $this->session->userdata('nickname'); ?></a></li>--><li><a href="<?php echo base_url(); ?>profile">用户中心</a></li><li><a href="<?php echo base_url(); ?>profile/logout">注销</a></li>
				<?php } else { ?>
				<li><a href="<?php echo base_url(); ?>login">登录</a></li><li><a href="<?php echo base_url(); ?>signup">注册</a></li>
				<?php } ?>
			</ul>
		</nav>

		<div id="main_logo">
			<a href="<?php echo base_url(); ?>">
				<img src="<?php echo base_url(); ?>theme/images/logo.png">
			</a>
		</div>

		<div id="main_nav_switch">
			<div class="switch_helper">
				<?php if ($this->session->userdata('is_logged_in')) { ?>
					<a href="<?php echo base_url(); ?>profile">
						<span class="show_history"></span>
					</a>
				<?php } else { ?>
					<a href="<?php echo base_url(); ?>login">
						<span class="show_history"></span>
					</a>
				<?php } ?>
				<span class="show_all_cat"></span>
			</div>
		</div>

		<ul class="nav nav-tabs" role="tablist" id="main_cat">
		    <li role="presentation"><a href="#appetizer" aria-controls="appetizer" role="tab" data-toggle="tab">凉菜</a></li>
		    <li role="presentation"><a href="#main_course" aria-controls="main_course" role="tab" data-toggle="tab">主菜</a></li>
		    <li role="presentation"><a href="#kebab" aria-controls="kebab" role="tab" data-toggle="tab">烤炸烫串</a></li>
		    <li role="presentation"><a href="#nine_dish" aria-controls="nine_dish" role="tab" data-toggle="tab">九道精选</a></li>
		    <li role="presentation"><a href="#noodle_rice_congee" aria-controls="noodle_rice_congee" role="tab" data-toggle="tab">粥粉面饭</a></li>
		    <li role="presentation"><a href="#dessert" aria-controls="dessert" role="tab" data-toggle="tab">甜点</a></li>
		    <li role="presentation"><a href="#drinks" aria-controls="drinks" role="tab" data-toggle="tab">饮料</a></li>
		    <li role="presentation"><a href="#combo" aria-controls="combo" role="tab" data-toggle="tab">套餐</a></li>
		</ul>

		<div id="what_to_eat">
			<a href="">不知道吃什么？</a>
		</div>

		<div id="close_nav">
			<span class="close_nav_btn">
				<span class="down_arrow"></span>&nbsp;&nbsp;隐藏&nbsp;&nbsp;<span class="down_arrow"></span>
			</span>
		</div>
	</div>
	<div class="dishes_wrap">
		<!-- Tab panes -->
		<div class="tab-content">	
<?php 		$category = array('appetizer','main_course','kebab','nine_dish','noodle_rice_congee','dessert','drinks','combo');
			$category_c = array('凉菜','主菜','烤炸烫串','九道精选','粥粉面饭','甜点','饮料','套餐');
			// $active = array('active', '', '', '', '', '', '', '');
				for ($cat=1; $cat<= 8; $cat++) { ?>
			<p class="category_title category_title_<?php echo $cat; ?> fixme"><?php echo $category_c[$cat-1]; ?></p>
		    <div role="tabpanel" class="tab-pane category_content_<?php echo $cat; ?> <?php // echo $active[$cat-1]; ?>" id="<?php echo $category[$cat-1]; ?>">
				<ul class="category_wrap">
					<?php foreach($dishes as $d): 
					if ($d['userCatId'] == $cat) { 
						if (strlen($d['dishAlphaId']) == '5') { ?>
							<div class="single_addon single_dish_js dish_code_<?php echo substr($d['dishAlphaId'], 0, -2); ?>" name="dish_code_<?php echo substr($d['dishAlphaId'], 0, -2); ?>">
						    	<h3><?php echo $d['dishFullChiName']; ?></h3>
						    	<h6><?php echo $d['dishEngName']; ?></h6>
						        <?php echo '<form action="cart/add_cart_dishes" method="post" accept-charset="utf-8">'; ?>
						            <fieldset>
						                <?php echo form_hidden('quantity', '1'); ?>
						                <?php echo form_hidden('product_id', $d['dishId']); ?>
						                <?php echo form_submit('add', '+'); ?>
						            </fieldset>
						        <?php echo form_close();?>
						    </div>
				    	<?php } else { ?>
						    <li class="single_dish single_dish_js <?php if ($d['imagePath'] == NULL) { echo 'no-pic'; }?>">
						    	<img src="<?php if ($d['imagePath'] != NULL) { echo base_url(); echo 'theme/images/user/'; echo $d['imagePath']; } else {echo base_url(); echo 'theme/images/user/no-pic.png'; } ?>" alt="<?php echo $d['imagePath']; ?>" />
						    	<h3><?php echo $d['dishFullChiName']; ?><small>&dollar;<?php echo $d['dishPrice']; ?></small></h3>
						    	<h6><?php echo $d['dishEngName']; ?></h6>
						    	<form action="cart/add_cart_dishes" method="post" accept-charset="utf-8" class="add_dish_form">
						            <fieldset>
						                <?php echo form_hidden('quantity', '1'); ?>
						                <?php echo form_hidden('product_id', $d['dishId']); ?>
						                <input type="submit" name="change_dish" value="" class="add_dish">
						            </fieldset>
						        </form>
								<p class="order_qty">
									<span>
										<?php 
										$exists = '';
										$cart = $this->cart->contents();

										foreach($cart as $items) { 
											if ($items['id'] == $d['dishId']) { 
												echo $items['qty'];
												$exists = 'true';
											}
										}
										if ($exists != 'true') { echo '0'; } ?>
									</span>
								</p>
						        <form action="cart/add_cart_dishes" method="post" accept-charset="utf-8" class="min_dish_form">
						            <fieldset>
						                <?php echo form_hidden('quantity', '-1'); ?>
						                <?php echo form_hidden('product_id', $d['dishId']); ?>
						                <input type="submit" name="change_dish" value="-" class="min_dish">
						            </fieldset>
						        </form>
						    </li>
				    <?php }
						}
				    endforeach; ?>
				</ul>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	
		$(document).find('.main_nav').html('');
	// User - Group add on dishes!!!

	var num_addon = $("div[name^='dish_code_']");
	for (var i = 0; i < num_addon.length; i+=21) {
	  num_addon.slice(i, i+21).wrapAll( "<li class='dish_addon_wrap'></li>" );
	}

	$( "<li class='pre_addon_wrap'><div class='show_dish_addon'>&uarr;&nbsp;点击增加配菜 - <span>$4.99/each</span>&nbsp;&uarr;</div></li>" ).insertBefore( ".dish_addon_wrap" );

	$('.pre_addon_wrap').each(function() {
		$(this).click(function() {
			if ($(this).next().hasClass('show')) {
				$(this).next().removeClass('show');
			} else {
				$(this).next().addClass('show');
			}
		});
	});

</script>