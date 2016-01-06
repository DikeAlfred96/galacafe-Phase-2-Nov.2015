$(function() {

	// Show more input on ordering tab.
	for (var i=2; i<=24; i++) {
		$('.dishes_row #dish_id_'+i).focus(function() {
			$(this).parent().next().first().show();
		});
	}
	if (document.location.href.indexOf('control_panel') > -1) { // Hide Admin Header...
		$('nav.main_nav').hide();
		$('#header').hide();
		if (document.location.href.indexOf('view_kitchen') > -1) { // Hide Admin Header...
			$('body').addClass('black');
		} else {
			$('body').removeClass('black');
		}
	} else {
		$('nav.main_nav').show();
		$('#header').show();
	}
	
	// Admin - Order section reset form...
	$('#reset_order').click(function() {
		$('.dishes_row_3').hide();
		$('.dishes_row_4').hide();
		$('.dishes_row_5').hide();
		$('.dishes_row_6').hide();
		$('.dishes_row_7').hide();
		$('.dishes_row_8').hide();
		$('.dishes_row_9').hide();
		$('.dishes_row_10').hide();
		$('.dishes_row_11').hide();
		$('.dishes_row_12').hide();
		$('.dishes_row_13').hide();
		$('.dishes_row_14').hide();
		$('.dishes_row_15').hide();
		$('.dishes_row_16').hide();
		$('.dishes_row_17').hide();
		$('.dishes_row_18').hide();
		$('.dishes_row_19').hide();
		$('.dishes_row_20').hide();
		$('.dishes_row_21').hide();
		$('.dishes_row_22').hide();
		$('.dishes_row_23').hide();
		$('.dishes_row_24').hide();
		$('.dishes_row_25').hide();
		$('.reset_d').html('$');
		$('.reset').html('');
		$('.dish_input_subtotal').val('');
		$('.dish_input_id').val('');
	});
	
	// Admin - Order form fetch dish data from database...
	$('.dishes_row .dish_input').each(function(intIndex) {
		$(this).blur(function() {
			var dish_id = $(this).val();
			var qty = $(this).parent().children('.quantities').val();
			$.ajax({
		        url: 'control_panel/admin_fetch_dish_data', //the script to call to get data
		        data: {"data" : dish_id}, //you can insert url argumnets here to pass
		        type: "POST",
		        success: function(data) {
			    	result = data.split(',');
			    	if (result != '') {
				    	var subtotal = (Math.round(result[2] * qty * 100)/100).toFixed(2);
						$('.dishes_row .item_id_'+(intIndex+1)).val(result[0]);
						$('.dishes_row .item_name_'+(intIndex+1)).html(result[1]);
						$('.dishes_row .item_price_'+(intIndex+1)).html('$ ' + result[2]);
						$('.dishes_row .sub_total_price_'+(intIndex+1)).html('$ ' + subtotal);
						$('.dishes_row .item_sub_'+(intIndex+1)).val(subtotal);
					} else {
						$('.dishes_row .item_id_'+(intIndex+1)).val('');
						$('.dishes_row .item_name_'+(intIndex+1)).html('');
						$('.dishes_row .item_price_'+(intIndex+1)).html('$');
						$('.dishes_row .sub_total_price_'+(intIndex+1)).html('$');
						$('.dishes_row .item_sub_'+(intIndex+1)).val('');
					}
		        }
		    });
		});
	});
	
	// Admin - Order Details page approve pending order without refresh page.
/*	$('.single_pending .order_approve').each(function(intIndex) {
		$(this).click(function() {
			var order_id = $(this).parent().children('.order_id').val();
			$.ajax({
		        url: 'control_panel/admin_approve_order', //the script to call to get data
		        data: {"data" : order_id}, //you can insert url argumnets here to pass
		        type: "GET",
		        success: function(data) {
			        alert('asdf');
		        }
		    })
		    .done(function () {
                    alert("Data Saved:");
            });
		});
	}); */
	
	// Admin - Debug the quantity input updating the subtotal...
	$('.dishes_row .quantities').each(function(intIndex) {
		$(this).keyup(function() {
			var dish_id = $(this).parent().children('.dish_input').val();
			var qty = $(this).val();
			$.ajax({
		        url: 'control_panel/admin_fetch_dish_data', //the script to call to get data
		        data: {"data" : dish_id}, //you can insert url argumnets here to pass
		        type: "POST",
		        success: function(data) {
			    	result = data.split(',');
			    	if (result != '') {
				    	var subtotal = (Math.round(result[2] * qty * 100)/100).toFixed(2);
						$('.dishes_row .sub_total_price_'+(intIndex+1)).html('$ ' + subtotal);
						$('.dishes_row .item_sub_'+(intIndex+1)).val(subtotal);
					} else {
						$('.dishes_row .sub_total_price_'+(intIndex+1)).html('$');
						$('.dishes_row .item_sub_'+(intIndex+1)).val('');
					}
		        }
		    });
		});
	});
	
	// User - Show detail for each order
	$('.details').hide();
	$('.show_details').each(function(index) {
		$(this).click(function(e) {
			e.preventDefault();
			$('.details').hide();
			if ($('tr.details.extra_'+(index+1)).css('display', 'none')) {
				$('tr.details.extra_'+(index+1)).show();
			} else {
				$('tr.details.extra_'+(index+1)).hide();
			}
		});
	});
	
	// Admin - Show detail for each order history
	// $('.details_today').hide();
	$('.admin_show_details_today').each(function(index) {
		$(this).click(function() {
			// $('.details_today').hide();
			if ($('tr.details_today.extra_'+(index+1)).hasClass('show')) {
				$('tr.details_today.extra_'+(index+1)).removeClass('show');
			} else {
				$('tr.details_today.extra_'+(index+1)).addClass('show');
			}
		});
	});
	
	// $('.details_yesterday').hide();
	$('.admin_show_details_yesterday').each(function(index) {
		$(this).click(function() {
			// $('.details_yesterday').hide();
			if ($('tr.details_yesterday.extra_'+(index+1)).hasClass('show')) {
				$('tr.details_yesterday.extra_'+(index+1)).removeClass('show');
			} else {
				$('tr.details_yesterday.extra_'+(index+1)).addClass('show');
			}
		});
	});
	
	// $('.details_older').hide();
	$('.admin_show_details_older').each(function(index) {
		$(this).click(function() {
			// $('.details_older').hide();
			if ($('tr.details_older.extra_'+(index+1)).hasClass('show')) {
				$('tr.details_older.extra_'+(index+1)).removeClass('show');
			} else {
				$('tr.details_older.extra_'+(index+1)).addClass('show');
			}

		});
	});
});

// Admin - Empty Order Form
$("a.empty").on("click", "a", function(){  
	$.get(link + "cart/empty_cart", function() {
		$.get(link + "cart/show_cart", function(cart) {
				$("#cart_content").html(cart);
		});
	});
	return false;
});

// User - Add to cart
$(document).ready(function() { 
	/*place jQuery actions here*/ 
	var link = "/"; // Url to your application (including index.php/) MODIFY!!!

	$(".dishes_wrap ul.category_wrap .single_dish form").submit(function() {
		// Get the product ID and the quantity 
		var id = $(this).find('input[name=product_id]').val();
		var qty = $(this).find('input[name=quantity]').val();
		
		$.post(link + "cart/add_cart_dishes", { product_id: id, quantity: qty, ajax: '1' },
			function(data) {	// Interact with returned data
				if(data == 'true') {
					$.get(link + "cart/show_cart", function(cart){ // Get the contents of the url cart/show_cart
							$("#cart_content").html(cart); // Replace the information in the div #cart_content with the retrieved data
					});
				} else {
					alert("Product does not exist");
				}
			});
		return false; // Stop the browser of loading the page defined in the form "action" parameter.
	});
});