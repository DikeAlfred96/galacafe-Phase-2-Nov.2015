<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('dishes_model');
		$this->load->library('form_validation');
		if($this->session->userdata('is_logged_in')) {
			$this->user_session = $this->session->userdata('is_logged_in');
		}
		date_default_timezone_set('America/Vancouver');
	}

	function add_cart_dishes() {
		$data = $_POST;

        $id = $data['product_id'];    //get new product id
        $qty = $data['quantity'];     //get quantity if that item       
        $cart = $this->cart->contents(); //get all items in the cart
        $exists = false;             //lets say that the new item we're adding is not in the cart
        $rowid = '';

        foreach($cart as $item) {
            if($item['id'] == $id) {    //if the item we're adding is in cart add up those two quantities
                $exists = true;
                $rowid = $item['rowid'];
                $qty = $item['qty'] + $qty;
            }       
        }

        if($exists) {
            $this->dishes_model->update_dishes($rowid, $qty);
	        echo 'true'; // If javascript is enabled, return true, so the cart gets updated
        } else {
            if($this->dishes_model->validate_add_cart_dishes() == TRUE) {         
		        // Check if user has javascript enabled
		        if($this->input->post('ajax') != '1') {
		            redirect('/'); // If javascript is not enabled, reload the page with new data
		        } else {
		            echo 'true'; // If javascript is enabled, return true, so the cart gets updated
		        }
		    }
        }
	}
	
	function show_cart() {
		$this->load->view('cart');
	}
	
/*	function update_cart() {
	    $this->dishes_model->validate_update_cart();
	    redirect('/');
	} */

	function empty_cart() {
	    $this->cart->destroy(); // Destroy all cart data
	    redirect('/'); // Refresh te page
	}

	function remove_dish($rowid) {
		$this->cart->update(array(
			'rowid' => $rowid,
			'qty' => 0
		));
		
		redirect('/');
	}

	function submit_order() {
		if($this->session->userdata('is_logged_in') == TRUE) {
			$data['user_name'] = $this->session->userdata('nickname');
			$data['phone_number'] = $this->session->userdata('phonenumber');
		}
		$data['return'] = ' <a href="'.base_url().'">返回</a>';
		$data['main_content'] = 'submit_order_form';
		$this->load->view('includes/template', $data);
	}

	function finish_order() {
		$this->form_validation->set_rules('phone_number', '电话/手机', 'trim|required|xss_clean|numeric|min_length[10]|max_length[10]|callback_phone_exists');
	    $this->form_validation->set_rules('user_name', '姓名', 'trim|required|xss_clean|max_length[32]');
	    
	    if($this->form_validation->run() == FALSE)
		{
			if($this->session->userdata('is_logged_in') == TRUE) {
				$data['user_name'] = $this->session->userdata('nickname');
				$data['phone_number'] = $this->session->userdata('phonenumber');
			}
			$data['main_content'] = 'submit_order_form';
			$this->load->view('includes/template', $data);
		} else {
			$query_1 = $this->dishes_model->create_order();
			$query_2 = $this->dishes_model->create_order_dishes();
			if ($query_1 && $query_2) {
				$this->cart->destroy();
				redirect('cart/success_order', 'refresh');
			} else {
				redirect('cart/error_order', 'refresh');
			}
		}
	}

	function success_order() {
		$data['main_content'] = 'order_success';
		$this->load->view('includes/template', $data);
	}

	function error_order() {
		$data['main_content'] = 'order_error'; // Should never showing this page...
		$this->load->view('includes/template', $data);
	}
	
/*	function add_dishes()
	{
		$data = array(
	                'id'      => 'asdf',
	                'qty'     => 2,
	                'price'   => 39.99,
	                'name'    => 'F U C K'
	            );
		
		$this->cart->insert($data);
		echo "add1() called";
	}
	
	function show()
	{
		$cart = $this->cart->contents();
		
		echo "<pre>";
		print_r($cart);
	}
	
	function update()
	{
		$data = array(
			'rowid' => 'd0c00b4e4b747d8475d1c93ff8067138',
			'qty' => '20'
		);
		
		$this->cart->update($data);
	}
	
	function total()
	{
		echo $this->cart->total();
	}
	
	function remove()
	{
		$data = array(
			'rowid' => 'd0c00b4e4b747d8475d1c93ff8067138',
			'qty' => '0'
		);
		
		$this->cart->update($data);
		echo "removed() called";
	}
	
	function destroy()
	{
		$this->cart->destroy();
		echo "destroy() called";
	} */

    function index()
    {
        $data['main_content'] = 'cart';
		$this->load->view('includes/template', $data);
    }
}