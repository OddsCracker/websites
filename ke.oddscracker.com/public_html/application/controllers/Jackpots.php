<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jackpots extends MY_Controller {

	public function index(){
		$this->output->cache(60);
		$this->data['jackpots'] = $this->FrontModel->get_jackpots();
		$this->load->view('templates/head', $this->data);
		$this->load->view('templates/left_col');
		$this->load->view('jackpots');
		$this->load->view('templates/right_col');
		$this->load->view('templates/footer');
	}

}
