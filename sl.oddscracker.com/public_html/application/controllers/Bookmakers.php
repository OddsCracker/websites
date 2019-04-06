<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bookmakers extends MY_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->load->view('templates/head', $this->data);
		$this->load->view('templates/left_col');
		$this->load->view('bookmakers_reviews');
		$this->load->view('templates/right_col');
		$this->load->view('templates/footer');
	}
	
	public function reviews(){
		if ($this->uri->segment(3)) {
			$Slug = preg_replace('/[^a-z0-9\-]/', '', $this->uri->segment(3));
			$bookmaker = $this->FrontModel->get_bookmaker($Slug);
			if (!$bookmaker) {
				$this->session->set_flashdata('error', 'Bookmaker not found!');
			}
			$this->data['bookmaker'] = $bookmaker;
			if (!empty($bookmaker['MetaTitle'])) {
				$this->data['page']['MetaTitle'] = $bookmaker['MetaTitle'];
				$this->data['page']['og:title'] = $bookmaker['MetaTitle'];
			} else {
				$this->data['page']['MetaTitle'] = $bookmaker['Name'] . '\'s review | ' . $this->data['settings']['site_name'] . ' ' . $this->data['settings']['country_name'];
				$this->data['page']['og:title'] = $bookmaker['Name'] . '\'s review | ' . $this->data['settings']['site_name'] . ' ' . $this->data['settings']['country_name'];
			}
			if (!empty($bookmaker['MetaDescription'])) {
				$this->data['page']['og:description'] = $bookmaker['MetaDescription'];
			}
			if (!empty($bookmaker['Cover'])) {
				$this->data['page']['og:image'] = '../uploads/' . $bookmaker['Cover'];
			}
		}
		$this->load->view('templates/head', $this->data);
		$this->load->view('templates/left_col');
		$this->load->view('bookmakers_reviews');
		$this->load->view('templates/right_col');
		$this->load->view('templates/footer');
	}
	
	public function comparison(){
		$this->data['bookmakers'] = $this->FrontModel->get_bookmakers();
		$this->load->view('templates/head', $this->data);
		$this->load->view('bookmakers_comparison');
		$this->load->view('templates/footer');
	}

}
