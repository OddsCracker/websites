<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Terms extends MY_Controller {

	public function index(){
		$this->output->cache(1440);
		$this->load->view('templates/head', $this->data);
		$this->load->view('templates/left_col');
		$this->load->view('terms');
		$this->load->view('templates/right_col');
		$this->load->view('templates/footer');
	}

}
