$(function() {

	// Show more input on ordering tab.
	for (var i=2; i<=24; i++) {
		$('.dishes_row #dish_id_'+i).focus(function() {
			$(this).parent().next().first().show();
		});
	}
	if (document.location.href.indexOf('control_panel') > -1) { // Hide Admin Header

		$('#header').hide();

		if ((document.location.href.indexOf('view_kitchen') > -1)||(document.location.href.indexOf('_only') > -1)) { 
			$('body').addClass('black');
			$('ul.nav.nav-tabs').hide();
		} else {
			$('body').removeClass('black');
			$('ul.nav.nav-tabs').show();
		}

	} else if ((document.location.href.indexOf('cart/submit_order') > -1) || (document.location.href.indexOf('cart/finish_order') > -1)) {
		$('.shopping_cart_nav').hide();
		$('.user_dish_qty').attr('disabled', 'disabled');
	} else {

		$('#header').show();
	}
	
	// Admin - Order section reset form...
	$('#reset_order').click(function() {
		window.location.reload();
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

	// Admin - Trying to fix the white space on admin page
	$(document.body).find(String.fromCharCode(65279)).each(function() {
		alert(this);
		$(this).replaceWith('');
	});
});

// User - Index page Hide Header on on scroll down

var didScroll;
var lastScrollTop = 0;
var delta = 5;
var navbarHeight = $('#main_nav').outerHeight();

$(window).scroll(function(event){
    didScroll = true;
});

setInterval(function() {
    if (didScroll) {
        hasScrolled();
        didScroll = false;
    }
}, 250);

function hasScrolled() {
    var st = $(this).scrollTop() + 1;
    
    // Make sure they scroll more than delta
    if(Math.abs(lastScrollTop - st) <= delta)
        return;
    
    // If they scrolled down and are past the navbar, add class .nav-up.
    // This is necessary so you never see what is "behind" the navbar.
    if (st > lastScrollTop && st > navbarHeight) {
    	// Scroll Down With Shipping cart page show
    	$('#main_nav').addClass('fixed');
    	$('.dishes_wrap').addClass('fix_helper');
    	$('#main_nav_switch').addClass('show');
    	$('#close_nav').removeClass('show');
    	$('#main_nav').removeClass('nav-down').addClass('nav-up');
    	// $('.nav').removeClass('nav-down').addClass('nav-up');
    	// $('.shopping_cart_nav').removeClass('up').addClass('down');
    	$('#shopping_cart_wrap').removeClass('cart_up').addClass('cart_down');
    } else {
        // Scroll Up
        if (st + $(window).height() < $(document).height()) {
            // $('.nav').removeClass('nav-up').addClass('nav-down');
            // $('.shopping_cart_nav').removeClass('down').addClass('up');
            $('#shopping_cart_wrap').removeClass('cart_down').addClass('cart_up');
        }
        if (st <= navbarHeight) {
        	$('#main_nav').removeClass('nav-up').addClass('nav-down');
        	$('#main_nav').removeClass('fixed');
        	$('.dishes_wrap').removeClass('fix_helper');
        	$('#main_nav_switch').removeClass('show');
        }
    }
    
    lastScrollTop = st;
}

// User - After click category
$('#main_cat.nav.nav-tabs li a').each(function() {
	$(this).click(function() {
		$('#close_nav').removeClass('show');
		$('#main_nav_switch').addClass('show');
		$('#main_nav').removeClass('nav-down').addClass('nav-up');
	});
});

// User - Show Main Nav button 
$('#main_nav_switch .show_all_cat').click(function() {
	$('#main_nav_switch').removeClass('show');
	$('#close_nav').addClass('show');
	$('#main_nav').removeClass('nav-up').addClass('nav-down');
});

$('#close_nav').click(function() {
	$('#main_nav').removeClass('nav-down').addClass('nav-up');
	$('#close_nav').removeClass('show');
	$('#main_nav_switch').addClass('show');
});

// User - Get current category name and input to #cat_title

$('#main_cat li a').each(function() {
	$(this).on('click',function() {
		$('#cat_title').html($(this).html());
	});
});

// User - Show shopping cart
var reveal_menu = true;

$('#cart_pop').click(function() {
	if (reveal_menu === false) {
		$('#shopping_cart_wrap').hide();
		$('#close_cart').hide();
		reveal_menu = true;
	} else {
		$('#shopping_cart_wrap').show();
		$('#close_cart').show();
		reveal_menu = false;
	}

});

$('#close_cart').click(function() {
	$('#shopping_cart_wrap').hide();
	$('#close_cart').hide();
	reveal_menu = true;
	$('.sub_nav').removeClass('nav-up').addClass('nav-down');
	// $('.shopping_cart_nav').removeClass('down').addClass('up');
});

$(document).ready(function() { 
	

	$(".order_qty span").each(function() {
		if ($(this).html().trim() != '0') {
			$(this).parent().parent().addClass('active');
			$(this).parent().parent().next().addClass('show');
		}
	});

	// User - Add to cart

	/* place jQuery actions here */
	var link = "/galacafe-Phase-2-Nov.2015/"; // Url to your application (including index.php/) MODIFY!!! galacafe-Phase-2-Nov.2015/

	$(".dishes_wrap ul.category_wrap .single_dish_js form").submit(function() {
		/*// Get which button it's been clicked.
		var val = $("input[type=submit]").data("clicked").val();
		alert(val); */
		// Get the product ID and the quantity 
		var id = $(this).find('input[name=product_id]').val();
		var qty = $(this).find('input[name=quantity]').val();
		var dish_qty = $(this).parent().find('.order_qty span');

		// Addon dishes support!
		var has_addon_class = $(this).parent().attr('class').split(' ')[0];

		if ($(this).parent().next().hasClass(has_addon_class)) {
			if (qty > 0) {
				$(this).parent().next().addClass('show');
			} else if (parseInt(dish_qty.html()) < 2 && qty < 0) {
				$(this).parent().next().removeClass('show');
				$(this).parent().next().next().removeClass('show');
			}
		}

		// --- Normal add/sub dishes function. ---
		if (qty > 0) {
			dish_qty.html(parseInt(dish_qty.html()) + 1);
		} else {
			var check_num = parseInt(dish_qty.html()) - 1;
			if (check_num > -1) {
				dish_qty.html(parseInt(dish_qty.html()) - 1);	
			} else {
				dish_qty.html('0');
			}

			
		}

		// if ( val == '+') {
		
		$.post(link + "cart/add_cart_dishes", { product_id: id, quantity: qty, ajax: '1' },
		function(data) {	// Interact with returned data
			if (data != null) {
				$.get(link + "cart/show_cart", function(cart) { // Get the contents of the url cart/show_cart
					$("#shopping_cart_wrap").html(cart); // Replace the information in the div #cart_content with the retrieved data
					if ($(cart).find('.total_dishes').val() != null) {
						$('.quantity_number').html($(cart).find('.total_dishes').val());
						$('.cart_subtotal').html('$ ' + $(cart).find('.cart_subtotal').val());
					} else {
						$('.quantity_number').html('0');
						$('.cart_subtotal').html('$ 0.00');
					}
					// $(dish_qty).html(data);
					$(".dishes_wrap ul.category_wrap .single_dish_js form.add_dish_form").each(function() {
						current = $(this).find('input[name=product_id]').val();
						if (current == id) {
							var final_qty = $(this).parent().find('.order_qty span').html().trim();
							if (data != false) {
								if (final_qty != '0') {
									$(this).parent().addClass('active');
								}
							}
							if (final_qty == '0') {
								$(this).parent().removeClass('active');
							}
						}
					});
				});
			} else {
				alert("There's a error occured. This product does not exist");
			}
		});
		return false; // Stop the browser of loading the page defined in the form "action" parameter.
		// } else {

		// }	
		
	});


	// User - Listing page title jump part fix.

	for (var i=1; i<=8; i++) {
		$(".category_title_"+i).detach().prependTo(".category_content_"+i);
	}

	// User - Listing page title fix when scroll to.

	var summaries = $('.fixme');
	summaries.each(function(i) {
	    var summary = $(summaries[i]);
	    var next = summaries[i + 1];

	    summary.scrollToFixed({
	        // marginTop: $('.header').outerHeight(true) + 10,
	        limit: function() {
	            var limit = 0;
	            if (next) {
	                limit = $(next).offset().top - $(this).outerHeight(true) - 10;
	            } else {
	                // limit = $('.footer').offset().top - $(this).outerHeight(true) - 10;
	            }
	            return limit;
	        },
	        zIndex: 999
	    });
	});

	// User - update cart, delete single dish.
	$('#shopping_cart_wrap form .remove').each(function() {

		$(this).click(function() {
			var rowid = $(this).parent().find('input[name=rowid]').val();
			var id = $(this).parent().find('input[name=id]').val();

			$.ajax({
		        url: 'cart/remove_dish', //the script to call to get data
		        data: {
		        	"rowid" : rowid,
					"id" : id
				}, //you can insert url argumnets here to pass
		        type: "POST",
		        success: function(cart) {
					$("#shopping_cart_wrap").html(cart);
					if ($(cart).find('.total_dishes').val() != null) {
						$('.quantity_number').html($(cart).find('.total_dishes').val());
						$('.cart_subtotal').html('$ ' + $(cart).find('.cart_subtotal').val());
					} else {
						$('.quantity_number').html('0');
						$('.cart_subtotal').html('$ 0.00');
					}
					$(".dishes_wrap ul.category_wrap .single_dish_js form.add_dish_form").each(function() {
						current = $(this).find('input[name=product_id]').val();
						if (current == id) {
							$(this).parent().find('.order_qty span').html('0');
							$(this).parent().removeClass('active');
						}
					});
				}
			});
		});
	});

	// User - update shopping cart dish quantity
	$("#shopping_cart_wrap form input.user_dish_qty").each(function() {
		$(this).blur(function() {
			var update_qty = $(this).val();
			var rowid = $(this).parent().parent().find('input[name=rowid]').val();
			var dish_qty = $(this).parent().parent().find('.order_qty span');
			var id = $(this).parent().parent().find('input[name=id]').val();

			$.ajax({
				url: 'cart/update_dish',
				data: {
					"update_qty" : update_qty,
					"rowid" : rowid,
					"id": id
				},
				type: "POST",
				success: function(cart) {
					$("#shopping_cart_wrap").html(cart);
					if ($(cart).find('.total_dishes').val() != null) {
						$('.quantity_number').html($(cart).find('.total_dishes').val());
						$('.cart_subtotal').html('$ ' + $(cart).find('.cart_subtotal').val());
					} else {
						$('.quantity_number').html('0');
						$('.cart_subtotal').html('$ 0.00');
					}
					$('dish_qty').html(update_qty);
					$(".dishes_wrap ul.category_wrap .single_dish_js form.add_dish_form").each(function() {
						current = $(this).find('input[name=product_id]').val();
						if (current == id) {
							$(this).parent().find('.order_qty span').html(update_qty);
						}
						if (update_qty == '0') {
							$(this).parent().removeClass('active');
						}
					});
				}
			});
		});
	});
	
	// User - Delivery method pick hiding/showing js
	$('.delivery_method').change(function() {
		if ($(this).hasClass('delivery')) {
			$('.delivery_address').addClass('show');
		} else {
			$('.delivery_address').removeClass('show');
		}
	});

	// User - Single add-on dish colour change.
	$('.single_addon').click(function() {
		$(this).find('form').addClass('selected');
	});
});


