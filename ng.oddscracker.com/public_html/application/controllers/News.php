<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends MY_Controller {

	public function index(){
		$this->data['news'] = $this->FrontModel->get_news(0, $this->data['settings']['items_per_page']);
		$this->load->view('templates/head', $this->data);
		$this->load->view('templates/left_col');
		$this->load->view('news');
		$this->load->view('templates/right_col');
		$this->load->view('templates/footer');
	}
	public function page(){
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$this->data['news'] = $this->FrontModel->get_news($page*$this->data['settings']['items_per_page'], $this->data['settings']['items_per_page']);
		$this->load->view('templates/head', $this->data);
		$this->load->view('templates/left_col');
		$this->load->view('news');
		$this->load->view('templates/right_col');
		$this->load->view('templates/footer');
	}

}
