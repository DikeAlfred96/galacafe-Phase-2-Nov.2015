<?php  // control_panel.php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Control_panel extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->is_logged_in_admin();
		$this->load->model('admin_user_model','',TRUE);
		date_default_timezone_set('America/Vancouver');
	}
	
	
	function index() {   
		$data['main_content'] = 'admin/admin_put_order';
		$this->load->view('includes/template', $data);

	}
	
	function view_orderhistory() {
		$data['today_history'] = $this->admin_user_model->fetch_order_history_today();
		$data['one_day_history'] = $this->admin_user_model->fetch_order_history_yesterday();
		$data['older_history'] = $this->admin_user_model->fetch_order_history_older();
		$data['main_content'] = 'admin/admin_order_history';
		$this->load->view('includes/template', $data);
	}
	
	function view_orderdetail_pickup() {
		$data['table_0_pending'] = $this->admin_user_model->order_status_table_0_pending();
		// $data['table_0_final'] = $this->admin_user_model->order_status_table_0_final();
		$data['table_0'] = $this->admin_user_model->order_status_table_0();
		$data['main_content'] = 'admin/admin_order_detail_pickup';
		$this->load->view('includes/template', $data);
	}

	function view_orderdetail_eatin() {
		$data['table_1'] = $this->admin_user_model->order_status_table_1();
		$data['table_2'] = $this->admin_user_model->order_status_table_2();
		$data['table_3'] = $this->admin_user_model->order_status_table_3();
		$data['table_4'] = $this->admin_user_model->order_status_table_4();
		$data['table_5'] = $this->admin_user_model->order_status_table_5();
		$data['table_6'] = $this->admin_user_model->order_status_table_6();
		$data['table_7'] = $this->admin_user_model->order_status_table_7();
		$data['table_8'] = $this->admin_user_model->order_status_table_8();
		$data['main_content'] = 'admin/admin_order_detail_eatin_test';
		$this->load->view('includes/template', $data);
	}
	
	function view_kitchen_iframe() {
		$data['dish_status_1'] = $this->admin_user_model->kitchen_fetch_dish_status_cat_1();
		$data['dish_status_2'] = $this->admin_user_model->kitchen_fetch_dish_status_cat_2();
		$data['dish_status_3'] = $this->admin_user_model->kitchen_fetch_dish_status_cat_3();
		$data['dish_status_4'] = $this->admin_user_model->kitchen_fetch_dish_status_cat_4();
		$data['dish_status_5'] = $this->admin_user_model->kitchen_fetch_dish_status_cat_5();
		$data['dish_status_6'] = $this->admin_user_model->kitchen_fetch_dish_status_cat_6();
		$data['dish_status_7'] = $this->admin_user_model->kitchen_fetch_dish_status_cat_7();
		$data['dish_status_8'] = $this->admin_user_model->kitchen_fetch_dish_status_cat_8();
		$data['main_content'] = 'admin/admin_kitchen';
		$this->load->view('includes/template', $data);
	}
	
	function view_kitchen() {
		$data['main_content'] = 'admin/admin_kitchen_main';
		$this->load->view('includes/template', $data);
	}
	
	function view_dishesmodify() {
		$data['main_content'] = 'admin/admin_dish_modify';
		$this->load->view('includes/template', $data);
	}
	
	function view_analytics() {
		$data['main_content'] = 'admin/admin_analytics';
		$this->load->view('includes/template', $data);
	}
	
	// ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ View Part ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
	
	public function is_logged_in_admin()
	{
		$is_logged_in_admin = $this->session->userdata('is_logged_in_admin');
		
		if(!isset($is_logged_in_admin) || $is_logged_in_admin != true) {
			redirect('admin', 'refresh');
		}
	}
	
	function logout()
	{
	    $this->session->unset_userdata('is_logged_in_admin');
//	    $this->db->cache_delete_all();
	    $data['error'] = '您已成功登出系统！谢谢';
		$data['main_content'] = 'admin_login_form';
		$this->load->view('includes/template', $data);
	}
	
	function admin_fetch_dish_data() {
		header("Content-type:text/html;charset=utf-8");
		
		$dish_id = $_POST['data'];
		$sql_order = "SELECT dishId, dishChiName, dishPrice FROM dishes WHERE dishAlphaId = '{$dish_id}' LIMIT 1";
		$result_order = $this->db->query($sql_order);
		if ($result_order->num_rows() > 0) {
			
			$row = $result_order->row();
			echo $row->dishId;
			echo ',';
			echo $row->dishChiName;
			echo ',';
			echo $row->dishPrice;
		}
	}
	
	function admin_put_order() {
		$this->form_validation->set_rules('table_id', '桌号', 'trim|required|xss_clean|numeric|max_length[2]');
		$this->form_validation->set_rules('dish_id_1', '第一个餐点', 'trim|required|xss_clean');
	    
	    if($this->form_validation->run() == FALSE) {
//			$data['main_content'] = 'control_panel';
//			$this->load->view('includes/template', $data);
//			$this->session->set_flashdata('error', validation_errors());
//			if (!empty($this->session->flashdata('error'))) {
//			    $data['error'] = $this->session->flashdata('error');
//			}
		    redirect('/control_panel', 'refresh');
		} else {
			$query = $this->admin_user_model->admin_create_order();
			//$query_2 = $this->admin_user_model->admin_create_order_dishes();
			if ($query) {
				redirect('/control_panel/print_order', 'refresh');
			} else {
				redirect('/control_panel', 'refresh');
			}
		}
	}
	
	function print_order() {
		$data['latest_order'] = $this->admin_user_model->admin_print_order();
		$data['main_content'] = 'admin/print_order';
		$this->load->view('includes/template', $data);
	}
	
	function admin_approve_order() {
		$order_id = $_POST['order_id'];
		$sql_order = array('orderStatus' => 1);
		$this->db->where('orderId', $order_id);
		$this->db->update('orders', $sql_order);
		
		redirect('/control_panel/view_orderdetail_pickup', 'refresh');
	}
	
	function dish_status_change() {
		header("Content-type:text/html;charset=utf-8");
		
		$serialId = $_POST['data'];
		$sql_fetch = "SELECT dishStatus, dishQuantity FROM order_items WHERE serialId = '{$serialId}' LIMIT 1";
		$result_fetch = $this->db->query($sql_fetch);
		foreach ($result_fetch->result() as $items):
			if ($items->dishStatus == "0") {
				$sql_order = array(
					'dishStatus' => 1,
					'dishQtyAdj' => 0
				);
				$this->db->where('serialId', $serialId);
				$this->db->update('order_items', $sql_order);
				
				echo 'done';
				
			} else if ($items->dishStatus == "1") {
				$sql_order = array(
					'dishStatus' => 0,
					'dishQtyAdj' => $items->dishQuantity
				);
				$this->db->where('serialId', $serialId);
				$this->db->update('order_items', $sql_order);
				
				echo 'cancel';
			}
		endforeach;

		$orderId = $_POST['order_id'];
		$sql_status_change = "SELECT dishStatus FROM order_items WHERE orderId = '{$orderId}' AND dishStatus = '0'";
		$result_status_change = $this->db->query($sql_status_change);
		if ($result_status_change->num_rows() == 0) {
			$sql_order = array('orderStatus' => 3);
			$this->db->where('orderId', $orderId);
			$this->db->update('orders', $sql_order);
		} else {
			$sql_order = array('orderStatus' => 1);
			$this->db->where('orderId', $orderId);
			$this->db->update('orders', $sql_order);
		}
	}

	function dish_qty_change() {
		header("Content-type:text/html;charset=utf-8");

		$qty = $_POST['qty'];
		$serialId = $_POST['data'];
		$original = $_POST['original'];
		$sql_fetch = "SELECT dishStatus, dishQuantity FROM order_items WHERE serialId = '{$serialId}' LIMIT 1";
		$result_fetch = $this->db->query($sql_fetch);
		foreach ($result_fetch->result() as $items):
			if ($qty == "0") {
				$sel_dish_qty = array(
					'dishQtyAdj' => $qty,
					'dishStatus' => '1'
				);
			} else {
				$sel_dish_qty = array(
					'dishQtyAdj' => $qty,
					'dishStatus' => '0'
				);
			}
		endforeach;
		$this->db->where('serialId', $serialId);
		$this->db->update('view_order_items', $sel_dish_qty);

		$orderId = $_POST['order_id'];
		$sql_status_change = "SELECT dishStatus FROM order_items WHERE orderId = '{$orderId}' AND dishStatus = '0'";
		$result_status_change = $this->db->query($sql_status_change);
		if ($result_status_change->num_rows() == 0) {
			$sql_order = array('orderStatus' => 3);
			$this->db->where('orderId', $orderId);
			$this->db->update('orders', $sql_order);
		} else {
			$sql_order = array('orderStatus' => 1);
			$this->db->where('orderId', $orderId);
			$this->db->update('orders', $sql_order);
		}

		echo '<span class="adj">'.$qty.'</span>/<span class="total">'.$original.'</span>';
	}

	function dish_qty_reset() {
		header("Content-type:text/html;charset=utf-8");

		$serialId = $_POST['data'];
		$sql = "SELECT dishQuantity, dishStatus FROM view_order_items WHERE serialId = '{$serialId}' LIMIT 1";
		$result_fetch = $this->db->query($sql);
		foreach ($result_fetch->result() as $item):
			$original_quantity = $item->dishQuantity;
		endforeach;

		$sel_dish_qty = array(
			'dishQtyAdj' => $original_quantity,
			'dishStatus' => 0
		);
		$this->db->where('serialId', $serialId);
		$this->db->update('view_order_items', $sel_dish_qty);

		$orderId = $_POST['order_id'];
		$sql_status_change = "SELECT dishStatus FROM order_items WHERE orderId = '{$orderId}' AND dishStatus = '0'";
		$result_status_change = $this->db->query($sql_status_change);
		if ($result_status_change->num_rows() == 0) {
			$sql_order = array('orderStatus' => 3);
			$this->db->where('orderId', $orderId);
			$this->db->update('orders', $sql_order);
		} else {
			$sql_order = array('orderStatus' => 1);
			$this->db->where('orderId', $orderId);
			$this->db->update('orders', $sql_order);
		}

		echo '<span class="adj">'.$original_quantity.'</span>/<span class="total">'.$original_quantity.'</span>';
	}

	function dish_status_change_all_z() { // Pick-up order page only
		header("Content-type:text/html;charset=utf-8");
		
		$orderId = $_POST['data'];
		$sql_dish_all = array(
			'dishStatus' => 1,
			'dishQtyAdj' => 0
		);
		$this->db->where('orderId', $orderId);
		$this->db->update('view_order_items', $sql_dish_all);

		$sql_order = array(
			'orderStatus' => 3,
			'orderFinishTime' => date('Y-m-d H:i:s'
		));
		$this->db->where('orderId', $orderId);
		$this->db->update('orders', $sql_order);
		
		echo 'success change all zero table';
	}

	function dish_status_change_all() {
		header("Content-type:text/html;charset=utf-8");
		
		$tableId = $_POST['data'];
		$orderId = $_POST['order_id'];
		$sql_dish_all = array(
			'dishStatus' => 1,
			'dishQtyAdj' => 0
		);
		$this->db->where('tableId', $tableId);
		$this->db->where('orderId', $orderId);
		$this->db->update('view_order_items', $sql_dish_all);
		
		$sql_order = array('orderStatus' => 3);
		$this->db->where('orderId', $orderId);
		$this->db->update('orders', $sql_order);

		echo 'success change all';
	}

	function user_order_cancel() { // Approve order part
		header("Content-type:text/html;charset=utf-8");
		
		$orderId = $_POST['data'];
		$sql_order = array(
			'orderStatus' => 4,
			'orderFinishTime' => date('Y-m-d H:i:s')
		);
		$this->db->where('orderId', $orderId);
		$this->db->update('orders', $sql_order);
	}

	function erase_single_dish() { // Approve order part
		header("Content-type:text/html;charset=utf-8");
		
		$serialId = $_POST['data'];
		$this->db->where('serialId', $serialId);
		$this->db->delete('order_items');

		echo 'success delete single dish';
	}

	function eatin_change_table() {
		header("Content-type:text/html;charset=utf-8");

		$tableId = $_POST['data'];
		$changeId = $_POST['change_id'];
		$orderId = $_POST['order_id'];
		$sql_change_table = array(
			'tableId' => $changeId,
			'orderTime' => date('Y-m-d H:i:s')
		);
		$this->db->where('tableId', $tableId);
		$this->db->where('orderId', $orderId);
		$this->db->update('orders', $sql_change_table);

		echo 'table changed';
	}

	/* function order_status_change() { // ****** ABANDON ******
		header("Content-type:text/html;charset=utf-8");
		
		$orderId = $_POST['data'];
		$sql_order = array('orderStatus' => 2);
		$this->db->where('orderId', $orderId);
		$this->db->update('orders', $sql_order);
		
		$sql_dish = array('dishStatus' => 1);		
		$this->db->where('orderId', $orderId);
		$this->db->update('view_order_items', $sql_dish);
		
		echo 'success';
	} */

	/* function order_status_change_finish() {
		header("Content-type:text/html;charset=utf-8");
		
		$orderId = $_POST['data'];
		$sql_order = array(
			'orderStatus' => 3,
			'orderFinishTime' => date('Y-m-d H:i:s')
		);
		$this->db->where('orderId', $orderId);
		$this->db->update('orders', $sql_order);
		
		echo 'success';
	} */
}

?>