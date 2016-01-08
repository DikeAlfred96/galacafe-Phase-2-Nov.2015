		<div id="footer">
		<?php if ($this->session->userdata('is_logged_in_admin')) { ?>
			<p class="footer_link"><a href="<?php echo base_url(); ?>">首页</a> | <a href="<?php echo base_url(); ?>admin">后台管理</a> | <a href="<?php echo base_url(); ?>control_panel/logout">注销管理员</a></p>
			<p class="footer_link_s"><a href="<?php echo base_url(); ?>control_panel/view_dishesmodify">菜肴操作</a> | <a href="<?php echo base_url(); ?>control_panel/view_analytics">报告</a></p>
		<?php } else { ?>
			<p class="footer_link"><a href="<?php echo base_url(); ?>admin">后台登陆</a></p>
		<?php } ?>	
			<p class="copyright">版权所有 旮旯小馆 &copy; 2015 | Designed by <a href="http://www.alfredzhu.com" target="_blank">Alfred Zhu</a></p>
		</div>
	</div>
	<!-- JS Files -->
	<script src="<?php echo base_url(); ?>theme/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>theme/js/script.js"></script>
</body>
</html>