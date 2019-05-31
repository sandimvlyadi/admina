<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	private $userData;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model', 'login');
		$this->load->model('dashboard_model', 'model');

		$this->userData = array(
			'session'	=> $this->session->userdata('userSession'),
			'host'		=> $this->input->get_request_header('Host', TRUE),
			'referer'	=> $this->input->get_request_header('Referer', TRUE),
			'agent'		=> $this->input->get_request_header('User-Agent', TRUE),
			'ipaddr'	=> $this->input->ip_address()
		);

		$auth = $this->login->auth($this->userData);
		if(!$auth){
			redirect();
		}
	}

	private function get_param($param = '', $needNumber = false)
	{
		if (isset($_GET[$param])) {
			return $_GET[$param];
		} else{
			if ($needNumber) {
				return 0;
			} else{
				return '';
			}
		}
	}

	public function index()
	{
		$this->load->view('dashboard');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect();
    }

    public function datatable_dilayani()
    {
		$response 	= array(
			'result'	=> false,
			'msg'		=> ''
		);

		$param 		= $_GET;
		$response 	= $this->model->datatable_dilayani($param);
    	echo json_encode($response, JSON_PRETTY_PRINT);
    }
    
}
