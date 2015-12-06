<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Vancouver');
?>

<div id="back_end_control_panel">
	<!-- Nav tabs -->
	<ul class="nav nav-tabs">
	    <li class="active"><a href="<?php echo base_url(); ?>control_panel">餐厅下单</a></li>
	    <li><a href="<?php echo base_url(); ?>control_panel/view_orderhistory">订单历史</a></li>
	    <li><a href="<?php echo base_url(); ?>control_panel/view_orderdetail_pickup">外卖订单</a></li>
    	<li><a href="<?php echo base_url(); ?>control_panel/view_orderdetail_eatin">堂食订单</a></li>
	    <li><a href="<?php echo base_url(); ?>control_panel/view_kitchen">后堂汇总</a></li>
	    <li><a href="<?php echo base_url(); ?>control_panel/view_dishesmodify">菜肴操作</a></li>
	    <li><a href="<?php echo base_url(); ?>control_panel/view_analytics">报告</a></li>
	</ul>
	
	<!-- Tab panes -->
	<div class="tab-content">
		<div id="put_order">
			<?php
				echo ('<form action="control_panel/admin_put_order" name="order_form" method="post" accept-charset="utf-8" id="admin_order_form" onsubmit="return validate();">');
				
				echo form_fieldset('', array('id'=>'basic_info')); // Section I
				echo form_label('桌号','table_id');
				echo form_input(array(
					'name' => 'table_id',
					'id' => 'table_id',
					'class' => 'form-control put_order_input_a',
					'maxlength' => "2"
				));
				echo form_label('顾客姓名','user_name');
				echo form_input(array(
					'name' => 'user_name',
					'id' => 'user_name',
					'class' => 'form-control put_order_input_a'
				));
				echo form_label('顾客电话','user_tel');
				echo form_input(array(
					'name' => 'user_tel',
					'id' => 'user_tel',
					'class' => 'form-control put_order_input_a'
				));
				echo form_fieldset_close();
				
				echo form_fieldset('', array('id'=>'dishes_order_title')); // Section II - Title
				echo form_label('餐点代码','', array('class' => 'put_order_input_b'));
				echo form_label('菜名','', array('class' => 'put_order_input_b'));
				echo form_label('单价','', array('class' => 'put_order_input_b'));
				echo form_label('数量','', array('class' => 'put_order_input_b'));
				echo form_label('小计','', array('class' => 'put_order_input_b'));
				echo form_fieldset_close();
				
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
				echo form_label('$','', array('class' => 'put_order_input_b reset_d sub_total_price_'.$i));
				echo '<input type="hidden" class="put_order_input_b dish_input_subtotal item_sub_'.$i.'" name="dish_subtotal_'.$i.'" id="dish_subtotal_'.$i.'" value="">';
				echo '<input type="hidden" class="put_order_input_b dish_input_id item_id_'.$i.'" name="dishes_id_'.$i.'" id="dishes_id_'.$i.'" value="">';
				echo '</div>';
				}
				echo form_fieldset_close();
				
				echo form_fieldset('', array('id'=>'dishes_order_submit')); // Section III
				echo form_submit(array(
					'class' => 'btn btn-primary btn-lg',
					'name' => 'submit_order',
					'value' => '提交订单'
				));
				echo form_reset(array(
					'class' => 'btn btn-danger btn-lg',
					'name' => 'reset_order',
					'value' => '重置订单',
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
		var regex = /^[0-9]+$/;
	    if ((document.order_form.table_id.value == "") || !(x.match(regex))) {
		    alert("桌号不可为空/只能包含数字");
	        return false;
	    } else if ((document.order_form.dish_id_1.value == "") || document.order_form.dishes_id_1.value == "") {
			alert("订单至少要有一个有效餐点");
	        return false;
	    } else {
		    return true;
	    }
	} // Form content validation!!!
	<?php for ($did=1; $did<=25; $did++) { ?>
	new autoComplete({
	    selector: '#dish_id_<?php echo $did; ?>',
	    minChars: 1,
	    source: function(term, suggest){
	        term = term.toLowerCase();
	        var choices = [['A1 川北凉粉', 'cblf'], ['A2 白水牛舌', 'bsns'], ['A3A 拍黄瓜', 'phg'], ['A3B 北京凉拌菜', 'bjlbc'], ['A4 油泼紫椰菜', 'ypzyc'], ['A5 炸蚕豆', 'zcd'], ['A6 芥末木耳', 'jmme'], ['A7A 酱牛肉', 'jnr'], ['A7B 酱猪蹄', 'jzt'], ['A8A 泡椒凤爪', 'pjfz'], ['A8B 香糟鸡爪', 'xzjz'], ['A8B 辣鸭脖', 'lyb'], ['A10 凉拌肚丝', 'lbds'], ['A11A 炸鸡翅(辣)', 'zjcl'], ['A11B 炸鸡翅(不辣)', 'zjcbl'], ['A12 炸素丸子', 'zswz'], ['A13 小葱拌豆腐', 'xcbdf'], ['A14 炸鱼', 'zy'], ['B1 大盘鸡', 'dpj'], ['B2 清炖狮子头', 'qdszt'], ['B3 麻婆豆腐', 'mpdf'], ['B4 清蒸平鱼', 'qzpy'], ['B5 红烧茄子', 'hsqz'], ['B6 铁锅炖鱼', 'tgdy'], ['B7 小碗蒸酥肉', 'xwzsr'], ['B8 糖醋鱼片', 'tcyp'], ['B9 炝炒圆白菜', 'qcybc'], ['B10 醋溜土豆片', 'cltdp'], ['B11A 羊蝎子(清汤)', 'yxzqt'], ['B11B 羊蝎子(辣汤)', 'yxzlt'], ['B12 口水鸡', 'ksj'], ['B13 小碗牛肉', 'xwnr'], ['B14A 爆肚', 'bd'], ['B14B 爆肥牛', 'bfn'], ['B14C 爆羊肉', 'byr'], ['B14D 爆百叶', 'bby'], ['B14E 爆豆腐', 'bdf'], ['B14F 爆白菜', 'bbc'], ['B14G 爆粉丝', 'bfs'], ['B14H 爆土豆', 'btd'], ['B14I 爆冻豆腐', 'bddf'], ['B15A 香辣虾', 'xlx'], ['B15B 香辣鸡翅', 'xljc']];
	        var suggestions = [];
	        for (i=0;i<choices.length;i++)
	            if (~(choices[i][0]+' '+choices[i][1]).toLowerCase().indexOf(term)) suggestions.push(choices[i]);
	        suggest(suggestions);
	    },
	    renderItem: function (item, search){
	        search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
	        var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
	        return '<div class="autocomplete-suggestion" data-langname="'+item[0]+'" data-lang="'+item[1]+'" data-val="'+search+'">'+item[0].replace(re, "<b>$1</b>")+'</div>';
	    },
	    onSelect: function(e, term, item){
			document.getElementById('dish_id_<?php echo $did; ?>').value = item.getAttribute('data-langname').split(" ")[0];
	    }
	});
	<?php } ?>
		
	$('form').bind("keypress", function(e) {
		if (e.keyCode == 13) {               
			e.preventDefault();
			return false;
		}
	});
</script>