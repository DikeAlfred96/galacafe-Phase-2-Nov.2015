<?php // admin_user_model.php

class Admin_user_model extends CI_Model {
		
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		date_default_timezone_set('America/Vancouver');
	}
	
	public function validate() {
		$this->db->where('adminUser', $this->input->post('username'));
		$this->db->where('adminPass', md5($this->input->post('password')));
		$query = $this->db->get('admin');

		if ($query->num_rows() == 1)
		{
			return true;
		}
	}
	
	public function get_all_dishes() {
        $dish_cache = $this->db->query("SELECT dishAlphaId, dishChiName, dishPrice FROM dishes");
        return $dish_cache->result();
        //returns from this string in the db, converts it into an array
    }
    
    function admin_create_order() {
		header("Content-type:text/html;charset=utf-8");
	    
	    // orders table build
	    if($this->input->post('user_tel') != '') { $user_tel = $this->input->post('user_tel');
	    } else { $user_tel = ''; }
	    if($this->input->post('user_name') != '') { $user_name = $this->input->post('user_name');
	    } else { $user_name = ''; }
	    
	    if ($this->input->post('link_table') == 'default') { $order_link = ''; } else { $order_link = $this->input->post('link_table'); }
	    $table_id = $this->input->post('table_id');
		/* if (in_array($table_id, array('1','2','3','4','5','6','7','8'), true)) {
		    $sql_dish_stat = array('dishStatus' => 1);
			$sql_order_stat = array('orderStatus' => 3);
			
			$this->db->where('tableId', $table_id);
			$this->db->update('view_order_items', $sql_dish_stat);
			
			$this->db->where('tableId', $table_id);
			$this->db->update('orders', $sql_order_stat);
	    } 
	    === ABANDON for now because new function that allows client to see all unfinished order */
	    $subtotal = '';
	    for ($i=1; $i<=25; $i++) {
		    if ($this->input->post('dish_subtotal_'.$i) != '') {
				$subtotal += $this->input->post('dish_subtotal_'.$i);
			}
	    }
	    $current_time = date('Y-m-d H:i:s');
	    
	    $new_order_insert_data = array( // Insert all the info to orders table in database
	    	'orderLinkId' => $order_link,
			'tableId' => $table_id,
			'userTel' => $user_tel,
			'userName' => $user_name,
			'orderSubtotal' => $subtotal,
			'orderTax' => round($subtotal * 0.05, 2),
			'orderTotal' => round($subtotal * 1.05, 2),
			'orderTime' => $current_time,
			'orderStatus' => '1',
			'orderRemarks' => ''
		);
		$insert_order = $this->db->insert('orders', $new_order_insert_data);
		
		$order_sql = "SELECT orderId FROM orders WHERE orderTime = '{$current_time}' ORDER BY orderId DESC LIMIT 1;";
		$order_query = $this->db->query($order_sql);
		$current_order_id = $order_query->row()->orderId;

		$alias = chr( 65 + $current_order_id % 22);
		$sql_order = array('orderAlias' => $alias);
		$this->db->where('orderId', $current_order_id);
		$this->db->update('orders', $sql_order);

		for ($i=1; $i<=25; $i++) {
			if ($this->input->post('dish_subtotal_'.$i) != '') {
				$new_order_items_insert_data = array(
					'orderId' => $current_order_id,
			    	'dishId' => $this->input->post('dishes_id_'.$i),
			    	'dishQuantity' => $this->input->post('item_quantity_'.$i),
			    	'dishQtyAdj' => $this->input->post('item_quantity_'.$i), 
			    	'dishStatus' => '0'
			    );
			    $insert_order_items = $this->db->insert('order_items', $new_order_items_insert_data);
			}
	    }
	    return $insert_order_items;
	    if ($insert_order && $insert_order_items) {
		    return TRUE;
	    } else {
		    return FALSE;
	    }
    }
    
    function admin_print_order() {
	    $latest_order = "SELECT orderId, orderAlias, tableId, userTel, userName, orderSubtotal, orderTax, orderTotal, orderTime, orderStatus, orderRemarks FROM orders WHERE orderStatus = '1' ORDER BY orderTime DESC LIMIT 1";
	    $latest_order_query = $this->db->query($latest_order);
	    return $latest_order_query;
    }
    
    function fetch_order_history_today() {
	    $current_time = date('Y-m-d');
		$sql_order = "SELECT orderId, orderAlias, tableId, userTel, userName, orderSubtotal, orderTax, orderTotal, orderTime, orderFinishTime, orderStatus, orderRemarks, orderAddress, orderDeliverMethod FROM orders WHERE orderTime LIKE '{$current_time}%' ORDER BY orderTime DESC";
		$result_order = $this->db->query($sql_order);

		return $result_order;
	}
	
	function fetch_order_history_yesterday() {
		$yesterday = date('Y-m-d', time() - 60 * 60 * 24);
		$sql_order = "SELECT orderId, orderAlias, tableId, userTel, userName, orderSubtotal, orderTax, orderTotal, orderTime, orderFinishTime, orderStatus, orderRemarks, orderAddress, orderDeliverMethod FROM orders WHERE orderTime LIKE '{$yesterday}%' ORDER BY orderTime DESC";
		$result_order = $this->db->query($sql_order);

		return $result_order;
	}
	
	function fetch_order_history_older() {
		$older = date('Y-m-d', time() - 60 * 60 * 24 * 2);
		$sql_order = "SELECT orderId, orderAlias, tableId, userTel, userName, orderSubtotal, orderTax, orderTotal, orderTime, orderFinishTime, orderStatus, orderRemarks, orderAddress, orderDeliverMethod FROM orders WHERE orderTime <= '{$older}%' ORDER BY orderTime DESC LIMIT 100";
		$result_order = $this->db->query($sql_order);

		return $result_order;
	}
	
	function order_status_table_0() {
		$sql = "SELECT orderId, orderAlias, tableId, orderStatus, orderTime, orderRemarks FROM orders WHERE (orderStatus = '1' OR orderStatus = '2' OR orderStatus = '3') AND tableId = '0' ORDER BY orderStatus ASC, orderFinishTime DESC LIMIT 7";
		$result = $this->db->query($sql);
		
		return $result;
	}
	
	/* function order_status_table_0_final() { // ****** ABANDON ******
		$sql = "SELECT orderId, tableId, orderStatus, orderRemarks FROM orders WHERE tableId = '0' AND orderStatus = '2' ORDER BY orderTime, orderStatus DESC";
		$result = $this->db->query($sql);
		
		return $result;
	} */
	
	function order_status_table_0_pending() {
		$sql = "SELECT orderId, orderAlias, tableId, userName, userTel, orderStatus, orderTime, orderRemarks, orderTotal, orderSubtotal, orderTax, orderAddress, orderDeliverMethod FROM orders WHERE tableId = '0' AND orderStatus = '0' ORDER BY orderTime, orderStatus DESC";
		$result = $this->db->query($sql);
		
		return $result;
	}
	
	function order_status_table_1() {
		$sql = "SELECT orderId, tableId, orderStatus, orderRemarks FROM orders WHERE tableId = '1' AND orderStatus = '1' ORDER BY orderTime DESC LIMIT 1";
		$result = $this->db->query($sql);
		
		return $result;
	}
	
	function order_status_table_2() {
		$sql = "SELECT orderId, tableId, orderStatus, orderRemarks FROM orders WHERE tableId = '2' AND orderStatus = '1' ORDER BY orderTime DESC LIMIT 1";
		$result = $this->db->query($sql);
		
		return $result;
	}
	
	function order_status_table_3() {
		$sql = "SELECT orderId, tableId, orderStatus, orderRemarks FROM orders WHERE tableId = '3' AND orderStatus = '1' ORDER BY orderTime DESC LIMIT 1";
		$result = $this->db->query($sql);
		
		return $result;
	}
	
	function order_status_table_4() {
		$sql = "SELECT orderId, tableId, orderStatus, orderRemarks FROM orders WHERE tableId = '4' AND orderStatus = '1' ORDER BY orderTime DESC LIMIT 1";
		$result = $this->db->query($sql);
		
		return $result;
	}
	
	function order_status_table_5() {
		$sql = "SELECT orderId, tableId, orderStatus, orderRemarks FROM orders WHERE tableId = '5' AND orderStatus = '1' ORDER BY orderTime DESC LIMIT 1";
		$result = $this->db->query($sql);
		
		return $result;
	}
	
	function order_status_table_6() {
		$sql = "SELECT orderId, tableId, orderStatus, orderRemarks FROM orders WHERE tableId = '6' AND orderStatus = '1' ORDER BY orderTime DESC LIMIT 1";
		$result = $this->db->query($sql);
		
		return $result;
	}
	
	function order_status_table_7() {
		$sql = "SELECT orderId, tableId, orderStatus, orderRemarks FROM orders WHERE tableId = '7' AND orderStatus = '1' ORDER BY orderTime DESC LIMIT 1";
		$result = $this->db->query($sql);
		
		return $result;
	}
	
	function order_status_table_8() {
		$sql = "SELECT orderId, tableId, orderStatus, orderRemarks FROM orders WHERE tableId = '8' AND orderStatus = '1' ORDER BY orderTime DESC LIMIT 1";
		$result = $this->db->query($sql);
		
		return $result;
	}
	
	function kitchen_fetch_dish_status_cat_1() {
		$sql_dishes = "SELECT dishTotal, dishChiName, orderTime, dishId, dishAlphaId FROM view_kitchen_sum WHERE catId=1 AND orderStatus != 4 ORDER BY dishTotal DESC, dishAlphaId DESC;";
		$result_dishes = $this->db->query($sql_dishes);
		
		return $result_dishes;
	}
	
	function kitchen_fetch_dish_status_cat_2() {
		$sql_dishes = "SELECT dishTotal, dishChiName, orderTime, dishId, dishAlphaId FROM view_kitchen_sum WHERE catId=2 AND orderStatus != 4  ORDER BY dishAlphaId ASC, dishTotal DESC;";
		$result_dishes = $this->db->query($sql_dishes);
		
		return $result_dishes;
	}
	
	function kitchen_fetch_dish_status_cat_3() {
		$sql_dishes = "SELECT dishTotal, dishChiName, orderTime, dishId, dishAlphaId FROM view_kitchen_sum WHERE catId=3 AND orderStatus != 4  ORDER BY dishTotal DESC, dishAlphaId DESC;";
		$result_dishes = $this->db->query($sql_dishes);
		
		return $result_dishes;
	}
	
	function kitchen_fetch_dish_status_cat_4() {
		$sql_dishes = "SELECT dishTotal, dishChiName, orderTime, dishId, dishAlphaId FROM view_kitchen_sum WHERE catId=4 AND orderStatus != 4  ORDER BY dishTotal DESC, dishAlphaId DESC;";
		$result_dishes = $this->db->query($sql_dishes);
		
		return $result_dishes;
	}
	
	function kitchen_fetch_dish_status_cat_5() {
		$sql_dishes = "SELECT dishTotal, dishChiName, orderTime, dishId, dishAlphaId FROM view_kitchen_sum WHERE catId=5 AND orderStatus != 4  ORDER BY dishTotal DESC, dishAlphaId DESC;";
		$result_dishes = $this->db->query($sql_dishes);
		
		return $result_dishes;
	}
	
	function kitchen_fetch_dish_status_cat_6() {
		$sql_dishes = "SELECT dishTotal, dishChiName, orderTime, dishId, dishAlphaId FROM view_kitchen_sum WHERE catId=6 AND orderStatus != 4  ORDER BY dishTotal DESC, dishAlphaId DESC;";
		$result_dishes = $this->db->query($sql_dishes);
		
		return $result_dishes;
	}
	
	function kitchen_fetch_dish_status_cat_7() {
		$sql_dishes = "SELECT dishTotal, dishChiName, orderTime, dishId, dishAlphaId FROM view_kitchen_sum WHERE catId=7 AND orderStatus != 4  ORDER BY dishTotal DESC, dishAlphaId DESC;";
		$result_dishes = $this->db->query($sql_dishes);
		
		return $result_dishes;
	}
	
	function kitchen_fetch_dish_status_cat_8() {
		$sql_dishes = "SELECT dishTotal, dishChiName, orderTime, dishId, dishAlphaId FROM view_kitchen_sum WHERE catId=8 AND orderStatus != 4  ORDER BY dishTotal DESC, dishAlphaId DESC;";
		$result_dishes = $this->db->query($sql_dishes);
		
		return $result_dishes;
	}

	function fetch_dishes_modify() {
		$sql = "SELECT * FROM dishes;";
		$result = $this->db->query($sql);

		return $result;
	}
}

?>