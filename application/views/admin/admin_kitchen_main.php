<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="wrapper">
	
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
	setTimeout('myrefresh()',600000); // refresh page every 10 min */
	
</script>
</html>