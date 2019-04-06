<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

	public function index(){
		$this->output->cache(10);
		if ($this->data['today_events']) {
			$this->data['best'] = $this->FrontModel->get_best_event();
		}
		$this->data['next_events'] = $this->FrontModel->get_events();
		$this->load->view('templates/head', $this->data);
		$this->load->view('templates/left_col');
		$this->load->view('home');
		$this->load->view('templates/right_col');
		$this->load->view('templates/footer');
	}

}
