<?php // user_model.php

class User_model extends CI_Model {
		
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('email');
	}
	
	public function validate_user() {
		$this->form_validation->set_rules('username', '', 'valid_email');
		if ($this->form_validation->run() == FALSE) {
			$this->db->where('userTel', $this->input->post('username'));
		} else {
			$this->db->where('userEmail', $this->input->post('username'));
		}
		$this->db->where('userPass', md5($this->input->post('password')));
		$query = $this->db->get('users');
		$this -> db -> limit(1);

		if ($query->num_rows() == 1) {
			return TRUE;
		} else {
			return FALSE;
		}

	}
	
	function create_user() {
		$new_user_insert_data = array(
			'userEmail' => $this->input->post('email_address'),
			'userTel' => $this->input->post('phone_number'),
			'userName' => $this->input->post('user_name'),
			'userPass' => md5($this->input->post('password'))
		);
		
		$insert = $this->db->insert('users', $new_user_insert_data);
		
		return $insert;
	}
	
	function phone_exists($phonenumber) {
	    $this->db->where('userTel', $phonenumber);
	    $query = $this->db->get('users');
	    
	    return $query->num_rows();
	}
	
	function email_exists($email) {
	
	    $this->db->where('userEmail', $email);
	    $query = $this->db->get('users');
	    
	    return $query->num_rows();
	}
	
	public function reset_email_exists($email) {
	
	    $sql = "SELECT userName, userEmail FROM users WHERE userEmail = '{$email}' LIMIT 1";
	    $result = $this->db->query($sql);
	    $row = $result->row();
	    
	    return ($result->num_rows() == 1 && $row->userEmail) ? $row->userName : false;
	}
	
	public function verify_user_reset_password_code($email, $code)
	{
		$sql = "SELECT userName, userEmail FROM users WHERE userEmail = '{$email}' LIMIT 1";
		$result = $this->db->query($sql);
		$row = $result->row();
		
		if ($result->num_rows() == 1)
		{
			return($code == md5($this->config->item('salt') . $row->userName)) ? true : false;
		}
		else
		{
			return false;
		}
	}
	
	public function update_user_password()
	{
		$email = $this->input->post('email_address');
		$password = md5($this->input->post('password'));
		
		$sql = "UPDATE users SET userPass = '{$password}' WHERE userEmail = '{$email}' LIMIT 1";
		$this->db->query($sql);
		
		if ($this->db->affected_rows() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function fetch_user_order_history() {
		if ($this->session->userdata('is_logged_in')) {
	//		$user_name = $this->session->userdata('nickname');
			$phone_number = $this->session->userdata('phonenumber');
			
			$sql_order = "SELECT orderId, orderTotal, orderTime, orderStatus, orderRemarks FROM orders WHERE userTel = '{$phone_number}' ORDER BY orderTime DESC LIMIT 50";
			$result_order = $this->db->query($sql_order);
	
			return $result_order;
		} else {
			return False;
		}
	}
	
	function fetch_user_order_item_history() {
		if ($this->session->userdata('is_logged_in')) {
			$phone_number = $this->session->userdata('phonenumber');
			$sql_order = "SELECT orderId FROM orders WHERE userTel = '{$phone_number}'";
			$result_order = $this->db->query($sql_order);
			if ($result_order->num_rows() > 0) {
				
				return $result_order;
				/*  foreach ($result_order->result() as $item):
					$current_result_order = $item->orderId;
					$sql_dishes = "SELECT dishId, dishQuantity, dishStatus FROM order_items WHERE orderId='{$current_result_order}'";
					$result_dishes = $this->db->query($sql_dishes);
			//		$current_result_dishes = $result_dishes->row()->dishId;
					
					foreach ($result_dishes->result() as $items):
						$each_dish = $items->dishId;
						$sql_dish_item = "SELECT dishChiName, dishPrice FROM dishes WHERE dishId='{$each_dish}'";
						$result_dish_item = $this->db->query($sql_dish_item);
						
						foreach ($result_dish_item->result() as $items_i):
							$arr_area[] = $this->db->escape($items_i);
						endforeach;
					endforeach;
				endforeach;
				
				return $arr_area;
					*/
			} else {
				return False;
			}
			
		/* function returnStuff($search_for_area,$search_for_requirement) {
		    $arr_area = array();
		    $arr_filter = array();
		    if ( ! empty($search_for_area) and ! empty($search_for_requirement)) {
		        foreach($search_for_requirement as $search_value_1) {
		            foreach($search_for_area as $search_value_2) { 
		                if($search_value_2 != null && $search_value_1 != null) {
		                    $arr_area[] = $this->db->escape($search_value_2);
		                    $arr_filter[] = $this->db->escape_like_str($search_value_1);
		                }
		            }
		        }
		    }
		
		    $str_area = 'NULL';
		    if ($arr_area)
		        $str_area = implode(', ', $arr_area);
		
		    $str_filter = "'^-$'";
		    if ($arr_filter)
		        $str_filter = "'(".implode('|', $arr_filter).")'";
		
		    $query = $this->db->query("
		        SELECT name, area, contactno 
		        FROM tut_listing 
		        WHERE area IN ({$str_area}) AND categoryfilter REGEXP {$str_filter} and partner > '' group by name
		    ");
		
		    return $query->result();
		} */
		
		} else {
			return False;
		}
// 		return $result;
	}
			
/* 		foreach ($result_order->result() as $orders):
			$orderId = $orders->orderId;
			$orderTotal = $orders->orderTotal;
			$orderTime = $orders->orderTime;
			$orderStatus = $orders->orderStatus;
		endforeach;
		
		$order_list = array(
				'orderId' => $orders['orderId'],
		    	'orderTotal' => $orders['orderTotal'],
		    	'orderTime' => $orders['orderTime'],
		    	'orderStatus' => $orders['orderStatus']
		    ); */
}

?>