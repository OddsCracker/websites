<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscribe extends MY_Controller {

	public function __construct(){
		parent::__construct();
	}
	
	public function success(){
		$this->load->view('templates/head', $this->data);
		$this->load->view('templates/left_col');;
		$this->load->view('subscribe_success');
		$this->load->view('templates/right_col');
		$this->load->view('templates/footer');
	}
	
	public function subscribed(){
		$this->load->view('templates/head', $this->data);
		$this->load->view('templates/left_col');;
		$this->load->view('already_subscribed');
		$this->load->view('templates/right_col');
		$this->load->view('templates/footer');
	}
	
	public function confirmed(){
		$this->load->view('templates/head', $this->data);
		$this->load->view('templates/left_col');;
		$this->load->view('subscription_confirmed');
		$this->load->view('templates/right_col');
		$this->load->view('templates/footer');
	}

}