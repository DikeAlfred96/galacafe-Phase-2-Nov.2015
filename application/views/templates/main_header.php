<?php $class = $this->uri->segment(1)==""?"active":""; ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="initial-scale=1.0">
	<meta name="description" content="Gala Cafe Online Ordering System - 旮旯小馆网上点餐系统">
	<meta name="author" content="Alfred Zhu - alfredzhu.com">
	<title>Gala Cafe Online Ordering System - 旮旯小馆网上点餐系统</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>theme/css/style.css">
	<!-- Third Party Stylesheet -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>theme/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>theme/css/auto-complete.css">
	<!-- jQuery Plug-in -->
	<script src="<?php echo base_url(); ?>theme/js/jquery-11.0.js"></script>
	<script src="<?php echo base_url(); ?>theme/js/auto-complete.js"></script>
	<script src="<?php echo base_url(); ?>theme/js/jquery.calculation.js"></script>
</head>
<body>
	<div class="main_wrapper">
		<div id="header">
			<?php if (strpos($_SERVER['REQUEST_URI'], "control_panel") !== false){
			} else { ?>
			<nav class="sub_nav">
				<ul>
					<?php if ($this->session->userdata('is_logged_in')) { ?>
					<!--<li>欢迎: <a href="<?php echo base_url(); ?>profile"><?php echo $this->session->userdata('nickname'); ?></a></li>--><li><a href="<?php echo base_url(); ?>profile">用户中心</a></li><li><a href="<?php echo base_url(); ?>profile/logout">注销</a></li>
					<?php } else { ?>	
					<li><a href="<?php echo base_url(); ?>login">登录</a></li><li><a href="<?php echo base_url(); ?>signup">注册</a></li>
					<?php } ?>
				</ul>
			</nav>
			<?php } ?>
			<h1 class="main_title"><a href="<?php echo base_url(); ?>">LOGO</a></h1>
			<nav class="main_nav">
				<ul class="nav nav-pills nav-justified">
					<li class="<?=($this->uri->segment(1)=='')?'active':''?>">
						<a href="<?php echo base_url(); ?>">订餐</a>
					</li>
					<li class="<?=($this->uri->segment(1)=='about')?'active':''?>">
						<a href="<?php echo base_url(); ?>about">关于<!--旮旯--></a>
					</li>
					<li class="<?=($this->uri->segment(1)=='contact')?'active':''?>">
						<a href="<?php echo base_url(); ?>contact">联系我们</a>
					</li>
				</ul>	
			</nav>
		</div>
