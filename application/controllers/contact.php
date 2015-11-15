<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller 
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $data['main_content'] = 'contact';
		$this->load->view('includes/template', $data);
    }
}