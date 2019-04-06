<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends MY_Controller {

	public function index(){
		$explode = explode('-', $this->uri->segment(2));
		$event_id = $explode[max(array_keys($explode))];
		$event = $this->FrontModel->get_event($event_id);
		$this->data['event'] = $event;
		$this->data['page']['MetaTitle'] = $event['team1'] . ' vs. ' . $event['team2'] . ' - Best Odds Comparison | ' . $this->data['settings']['site_name'] . ' ' . $this->data['settings']['country_name'];
		$this->data['page']['og:title'] = $event['team1'] . ' vs. ' . $event['team2'] . ' - Best Odds Comparison | ' . $this->data['settings']['site_name'] . ' ' . $this->data['settings']['country_name'];
		$this->data['page']['MetaDescription'] = 'Get the best betting odds for the match ' . $event['team1'] . ' versus ' . $event['team2'] . ' in ' . $event['league'] . ' scheduled on ' . date('d M Y', strtotime($event['time'])) . ' from ' . $this->data['settings']['site_name'];
		$this->data['page']['og:description'] = 'Get the best betting odds for the match ' . $event['team1'] . ' versus ' . $event['team2'] . ' in ' . $event['league'] . ' scheduled on ' . date('d M Y', strtotime($event['time'])) . ' from ' . $this->data['settings']['site_name'];
		$this->data['page']['og:image'] = $this->data['settings']['abs_url'] . '/images/goal.jpeg';
		$this->load->view('templates/head', $this->data);
		$this->load->view('templates/left_col');
		$this->load->view('event');
		$this->load->view('templates/right_col');
		$this->load->view('templates/footer');
	}

}
