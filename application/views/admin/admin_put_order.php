<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Vancouver');
?>

<div id="back_end_control_panel">
	<!-- Nav tabs -->
	<ul class="nav nav-tabs">
	    <li class="active"><a href="<?php echo base_url(); ?>control_panel">下单</a></li>
	    <li><a href="<?php echo base_url(); ?>control_panel/view_orderhistory">历史</a></li>
	    <li><a href="<?php echo base_url(); ?>control_panel/view_orderdetail_pickup">外卖</a></li>
    	<li><a href="<?php echo base_url(); ?>control_panel/view_orderdetail_eatin">堂食</a></li>
	    <li><a href="<?php echo base_url(); ?>control_panel/view_kitchen">后堂</a></li>
	</ul>
	
	<!-- Tab panes -->
	<div class="tab-content">
		<div id="put_order">
			<?php
				echo ('<form action="control_panel/admin_put_order" name="order_form" method="post" accept-charset="utf-8" id="admin_order_form" onsubmit="return validate();" >');
				
				echo form_fieldset('', array('id'=>'basic_info')); // Section I
				echo form_label('桌号','table_id');
				echo form_input(array(
					'name' => 'table_id',
					'id' => 'table_id',
					'class' => 'form-control put_order_input_a',
					'maxlength' => "1"
				));
				echo form_label('姓名','user_name');
				echo form_input(array(
					'name' => 'user_name',
					'id' => 'user_name',
					'class' => 'form-control put_order_input_a'
				));
				echo form_label('电话','user_tel');
				echo form_input(array(
					'name' => 'user_tel',
					'id' => 'user_tel',
					'class' => 'form-control put_order_input_a'
				));
				$options = array(
				    'default' => '链接',
				    '1' => '1',
				    '2' => '2',
				    '3' => '3',
				    '4' => '4',
				    '5' => '5',
				    '6' => '6',
				    '7' => '7',
				    '8' => '8',
				    'A' => 'A',
				    'B' => 'B',
				    'C' => 'C',
				    'D' => 'D',
				    'E' => 'E',
				    'F' => 'F',
				    'G' => 'G',
				    'H' => 'H',
				    'I' => 'I',
				    'J' => 'J',
				    'K' => 'K',
				    'L' => 'L',
				    'M' => 'M',
				    'N' => 'N',
				    'O' => 'O',
				    'P' => 'P',
				    'Q' => 'Q',
				    'R' => 'R',
				    'S' => 'S',
				    'T' => 'T',
				    'U' => 'U',
				    'V' => 'V',
				    'W' => 'W',
				    'X' => 'X',
				    'Y' => 'Y',
				    'Z' => 'Z'
				);
				echo form_dropdown('link_table', $options, 'default');
				echo form_fieldset_close();
				
				/* echo form_fieldset('', array('id'=>'dishes_order_title')); // Section II - Title
				echo form_label('餐点代码','', array('class' => 'put_order_input_b'));
				echo form_label('菜名','', array('class' => 'put_order_input_b'));
				echo form_label('单价','', array('class' => 'put_order_input_b'));
				echo form_label('数量','', array('class' => 'put_order_input_b'));
				echo form_label('小计','', array('class' => 'put_order_input_b'));
				echo form_fieldset_close(); */
				
				echo form_fieldset('', array('id'=>'dishes_order')); // Section II
				for ($i = 1; $i <= 25; $i++) {
				echo '<div class="dishes_row dishes_row_'.$i.'">';
				echo form_input(array(
					'name' => 'dish_id_'.$i,
					'id' => 'dish_id_'.$i,
					'class' => 'form-control put_order_input_b dish_input'
				));
				echo form_label('','', array('class' => 'put_order_input_b reset item_name_'.$i));
				echo form_label('$','', array('class' => 'put_order_input_b reset_d item_price_'.$i));
				echo form_input(array(
					'name' => 'item_quantity_'.$i,
					'id' => 'item_quantity_'.$i,
					'class' => 'form-control quantities put_order_input_b',
					'value' => '1',
					'onClick' => 'this.select();'
				));
				/* echo form_label('$','', array('class' => 'put_order_input_b reset_d sub_total_price_'.$i)); */
				echo '<input type="hidden" class="put_order_input_b dish_input_subtotal item_sub_'.$i.'" name="dish_subtotal_'.$i.'" id="dish_subtotal_'.$i.'" value="">';
				echo '<input type="hidden" class="put_order_input_b dish_input_id item_id_'.$i.'" name="dishes_id_'.$i.'" id="dishes_id_'.$i.'" value="">';
				echo '</div>';
				}
				echo form_fieldset_close();
				
				echo form_fieldset('', array('id'=>'dishes_order_submit')); // Section III
				echo form_submit(array(
					'class' => 'btn btn-primary btn-lg',
					'name' => 'submit_order',
					'value' => '提交'
				)); ?>
				<p id="total_sum">$ <span id="sum_math"></span></p>
				<?php echo form_reset(array(
					'class' => 'btn btn-danger btn-lg',
					'name' => 'reset_order',
					'value' => '重置',
					'id' => 'reset_order'
				));
				echo form_fieldset_close();
				
				echo form_close();
			?>
	    </div>
	</div>
</div>
<script type="text/javascript">
	function validate() {
		var x = document.order_form.table_id.value;
		var regex = /^[0-8]+$/;
	    if ((document.order_form.table_id.value == "") || !(x.match(regex))) {
		    alert("桌号不可为空/只能包含数字, 桌号仅限0-8");
	        return false;
	    } else if ((document.order_form.dish_id_1.value == "") || document.order_form.dishes_id_1.value == "") {
			alert("订单至少要有一个有效餐点");
	        return false;
	    } else {
		    return true;
	    }
	} // Form content validation!!!
	<?php $sql = "SELECT dishAlphaId, dishChiName, dishInitial FROM dishes;";
		$result = $this->db->query($sql);
		$num = $result->num_rows();
		for ($did=1; $did<=25; $did++) {
		$i = 1; ?>
	new autoComplete({
	    selector: '#dish_id_<?php echo $did; ?>',
	    minChars: 1,
	    source: function(term, suggest) {
	        term = term.toLowerCase();
	        var choices = [<?php foreach ($result->result() as $items): if ($i !== $num) { ?>['<?php echo $items->dishAlphaId; ?> <?php echo $items->dishChiName; ?>', '<?php echo $items->dishInitial; ?>'], <?php } else { ?>['<?php echo $items->dishAlphaId; ?> <?php echo $items->dishChiName; ?>', '<?php echo $items->dishInitial; ?>']<?php } $i++; endforeach; ?> ];
	        var suggestions = [];
	        for (i=0;i<choices.length;i++)
	            if (~(choices[i][0]+' '+choices[i][1]).toLowerCase().indexOf(term)) suggestions.push(choices[i]);
	        suggest(suggestions);
	    },
	    renderItem: function (item, search) {
	        search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
	        var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
	        return '<div class="autocomplete-suggestion" data-langname="'+item[0]+'" data-lang="'+item[1]+'" data-val="'+search+'">'+item[0].replace(re, "<b>$1</b>")+'</div>';
	    },
	    onSelect: function(e, term, item) {
			document.getElementById('dish_id_<?php echo $did; ?>').value = item.getAttribute('data-langname').split(" ")[0];
	    }
	});
	<?php } ?>

	$('#table_id').keyup(function() {
		if ($(this).val() == '0') {
			$('#basic_info select').show();
		} else {
			$('#basic_info select').hide();
		}
	});
		
	$('form').bind("keypress", function(e) {
		if (e.keyCode == 13) {               
			e.preventDefault();
			return false;
		}
	});

	$("form").submit(function() {
	    $(this).submit(function() {
	        return false;
	    });
	    return true;
	});

	$('.put_order_input_b').keyup(function() {
		$("input[name^='dish_subtotal_']").sum("keyup", "#sum_math");
	});
</script>