<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Archive extends MY_Controller {

	public function index(){
		if (!$this->uri->segment(2)) {
			$this->session->set_flashdata('error', 'Please select an event!');
		} else {
			$explode = explode('-', preg_replace('/[^a-zA-Z0-9\-]/', '', $this->uri->segment(2)));
			$event_id = $explode[max(array_keys($explode))];
			$this->data['archive'] = $this->FrontModel->get_archive($event_id);
			if ($this->data['archive']) {
				$this->data['page']['MetaTitle'] = $this->data['archive']['event']['team1'] . ' - ' . $this->data['archive']['event']['team2'] . ' Best Odds Comparison ' . date('d M Y', strtotime($this->data['archive']['event']['time'])) . ' | ' . $this->data['settings']['site_name'];
				$this->data['page']['og:title'] = $this->data['archive']['event']['team1'] . ' - ' . $this->data['archive']['event']['team2'] . ' Best Odds Comparison ' . date('d M Y', strtotime($this->data['archive']['event']['time'])) . ' | ' . $this->data['settings']['site_name'];
				$this->data['page']['MetaDescription'] = $this->data['archive']['event']['team1'] . ' - ' . $this->data['archive']['event']['team2'] . ' archive at ' . $this->data['settings']['site_name'];
				$this->data['page']['og:description'] = $this->data['archive']['event']['team1'] . ' - ' . $this->data['archive']['event']['team2'] . ' archive at ' . $this->data['settings']['site_name'];
				$this->data['page']['og:image'] = $this->data['settings']['abs_url'] . '/images/goal.jpeg';
				$this->data['bookies'] = $this->FrontModel->get_bookies();
			}
		}
		$this->load->view('templates/head', $this->data);
		$this->load->view('templates/left_col');
		$this->load->view('archive');
		$this->load->view('templates/right_col');
		$this->load->view('templates/footer');
	}

}
