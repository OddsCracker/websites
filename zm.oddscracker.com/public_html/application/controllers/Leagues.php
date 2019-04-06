<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leagues extends MY_Controller {

	public function index(){
		$this->data['leagues'] = $this->FrontModel->get_leagues_list();
		$this->load->view('templates/head', $this->data);
		$this->load->view('templates/left_col');
		$this->load->view('leagues');
		$this->load->view('templates/right_col');
		$this->load->view('templates/footer');
	}

}
