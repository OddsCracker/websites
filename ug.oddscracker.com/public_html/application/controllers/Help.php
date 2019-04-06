<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Help extends MY_Controller {

	public function index(){
		$this->load->view('templates/head', $this->data);
		$this->load->view('templates/left_col');
		$this->load->view('help');
		$this->load->view('templates/right_col');
		$this->load->view('templates/footer');
	}

}
