<?php
defined('BASEPATH') OR exit('No direct script access allowed');

 class home extends CI_Controller
 {
 	
 	function __construct()
 	{
 		parent::__construct();
        $this->load->model('dishes_model');
 	}

 	function index()
    {
	    $data['return'] = '';
        $data['main_content'] = 'index';
        $data['dishes'] = $this->dishes_model->retrieve_dishes();
//      $data['dishes'] = $this->dishes_model->get_all_dishes();
        $this->load->view('includes/template-home', $data);
    }
 }

 ?>