<?php // Dishes_model.php

class Dishes_model extends CI_Model {
		
	public function __construct()
	{
		parent::__construct();
		$this->load->library('cart');
		date_default_timezone_set('America/Vancouver');
		if($this->session->userdata('is_logged_in')) {
			$this->user_session = $this->session->userdata('is_logged_in');
		}
	}
	
	// Function to retrieve an array with all product information
    function retrieve_dishes()
    {
        $query = $this->db->get('dishes'); // Select the table products
        return $query->result_array(); // Return the results in a array.
    }
    
    // Add an item to the cart
	function validate_add_cart_dishes()
	{     
	    $id = $this->input->post('product_id'); // Assign posted product_id to $id
	    $cty = $this->input->post('quantity'); // Assign posted quantity to $cty
	    
	    $this->db->where('dishId', $id); // Select where id matches the posted id
	    $query = $this->db->get('dishes', 1); // Select the products where a match is found and limit the query by 1
	     
	    // Check if a row has matched our product id
	    if($query->num_rows > 0) { // We have a match!
	        foreach ($query->result() as $row) { // Create an array with product information
	            $data = array(
	                'id'      => 	$id,
	                'qty'     => 	$cty,
	                'price'   => 	$row->dishPrice,
	                'name'    => 	$row->dishChiName
	            );
	            // Add the data to the cart using the insert function that is available because we loaded the cart library
	            $this->cart->insert($data);
	            
	            return TRUE; // Finally return TRUE
	        }
	    } else { // Nothing found! Return FALSE!
	        return FALSE;
	    }
	}
	
	function update_dishes($rowid, $qty) {
        $data = array(  // Create an array with the products rowid's and quantities. 
            'rowid' => $rowid,
            'qty'   => $qty
        );
        $this->cart->update($data);  // Update the cart with the new information
    }
    
    function create_order() {
	    header("Content-type:text/html;charset=utf-8");
	    
	    // orders table build
	    if($this->input->post('phone_number') != '') { $phone_number = $this->input->post('phone_number');
	    } else { $phone_number = ''; }
	    if($this->input->post('user_name') != '') { $user_name = $this->input->post('user_name');
	    } else { $user_name = ''; }
	    if($this->input->post('additional_info') != '') { $additional_info = $this->input->post('additional_info');
	    } else { $additional_info = ''; }
	    
	    $new_order_insert_data = array( // Insert all the info to orders table in database
			'tableId' => '0',
			'userTel' => $phone_number,
			'userName' => $user_name,
			'orderSubtotal' => $this->cart->format_number($this->cart->total()),
			'orderTax' => round($this->cart->format_number($this->cart->total()) * 0.05, 2),
			'orderTotal' => round($this->cart->format_number($this->cart->total()) * 1.05, 2),
			'orderTime' => date('Y-m-d H:i:s'),
			'orderStatus' => '0',
			'orderRemarks' => $additional_info,
			'ifPrinted' => '0'
		);
		
		$insert_order = $this->db->insert('orders', $new_order_insert_data);
		return $insert_order;
    }
    
    function create_order_dishes() {
	    $current_time = date('Y-m-d H:i:s');
	    // order_items table build
		$order_sql = "SELECT orderId FROM orders WHERE orderTime = '{$current_time}' ORDER BY orderId DESC LIMIT 1;";
		$order_query = $this->db->query($order_sql);
		$current_dish_id = $order_query->row()->orderId;
		
		foreach ($this->cart->contents() as $items):
			$new_order_items_insert_data = array(
				'orderId' => $current_dish_id,
		    	'dishId' => $items['id'],
		    	'dishQuantity' => $items['qty'], 
		    	'dishStatus' => '0'
		    );
	    $insert_order_items = $this->db->insert('order_items', $new_order_items_insert_data);
	    
		endforeach;
	    return $insert_order_items;
    }
	
/*	// Updated the shopping cart
	function validate_update_cart()
	{     
	    // Get the total number of items in cart
	    $total = $this->cart->total_items();
	     
	    // Retrieve the posted information
	    $item = $this->input->post('rowid');
	    $qty = $this->input->post('qty');
	 
	    // Cycle true all items and update them
	    for($i=0;$i < $total;$i++) {
	        // Create an array with the products rowid's and quantities. 
	        $data = array(
	           'rowid' => $item[$i],
	           'qty'   => $qty[$i]
	        );
	         
	        // Update the cart with the new information
	        $this->cart->update($data);
	    }
	}
	
		function get_all_dishes()
	{
//		$results = $this->db->get('dishes')->result();
//		foreach ($results as $result) {}
//		return $results;
	}*/
	
}

?>