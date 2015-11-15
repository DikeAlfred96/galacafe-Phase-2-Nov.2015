		<div id="footer">
		<?php if ($this->session->userdata('is_logged_in_admin')) { ?>
			<p class="footer_link"><a href="<?php echo base_url(); ?>admin">后台管理</a> | <a href="<?php echo base_url(); ?>control_panel/logout">注销管理员</a></p>
		<?php } else { ?>
			<p class="footer_link"><a href="<?php echo base_url(); ?>admin">后台登陆</a></p>
		<?php } ?>	
			<p class="copyright">版权所有 <!--旮旯小馆--> &copy; 2015 | Designed by <a href="http://www.alfredzhu.com" target="_blank">Alfred Zhu</a></p>
		</div>
	</div>
	<!-- JS Files -->
	<script src="<?php echo base_url(); ?>theme/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>theme/js/script.js"></script>
	<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
</body>
</html>