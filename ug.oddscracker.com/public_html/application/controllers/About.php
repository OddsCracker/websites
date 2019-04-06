<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends MY_Controller {

	public function index(){
		$this->load->view('templates/head', $this->data);
		$this->load->view('templates/left_col');
		$this->load->view('about');
		$this->load->view('templates/right_col');
		$this->load->view('templates/footer');
	}

}
