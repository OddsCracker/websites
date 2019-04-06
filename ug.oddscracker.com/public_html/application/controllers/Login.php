<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	public function __construct(){
		parent::__construct();
	}
	
	public function facebook(){
		$this->load->view('templates/head', $this->data);
		$this->load->view('templates/left_col');;
		$this->load->view('facebook_login');
		$this->load->view('templates/right_col');
		$this->load->view('templates/footer');
	}
	
	public function google(){
		$this->load->view('templates/head', $this->data);
		$this->load->view('templates/left_col');;
		$this->load->view('google_login');
		$this->load->view('templates/right_col');
		$this->load->view('templates/footer');
	}

}
