<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends MY_Controller {

	public function index(){
		if (!$this->uri->segment(2)){
			$this->data['events'] = $this->FrontModel->get_events();
			$this->data['page']['MetaTitle'] = ' All Upcoming Events | ' . $this->data['settings']['site_name'];
			$this->data['page']['og:title'] =  'All Upcoming Events | ' . $this->data['settings']['site_name'];
			$this->data['page']['MetaDescription'] = 'View all upcoming events' ;
			$this->data['page']['og:description'] = 'Get the best betting odds for all the upcoming football matches from ' . $this->data['settings']['site_name'];
			$this->data['page']['og:image'] = $this->data['settings']['abs_url'] . '/images/goal.jpeg';
		} else {
			$LeagueName = preg_replace('/[^a-zA-Z0-9\-\s\.]/', '', str_replace('_', ' ', $this->uri->segment(2)));
			$this->data['page']['MetaTitle'] = $LeagueName . ' | Upcoming Events';
			$this->data['page']['og:title'] =  $LeagueName . '  Upcoming Events | ' . $this->data['settings']['site_name'];
			$this->data['page']['MetaDescription'] = 'View the upcoming events in ' . $LeagueName;
			$this->data['page']['og:description'] = 'Get the best betting odds for the upcoming matches in  ' . $LeagueName . ' from ' . $this->data['settings']['site_name'];
			$this->data['page']['og:image'] = $this->data['settings']['abs_url'] . '/images/goal.jpeg';
			$league_events = $this->FrontModel->get_events($LeagueName);
			$this->data['standings'] = $this->FrontModel->get_standings($LeagueName);
			if ($league_events) {
				$cover = $league_events[min(array_keys($league_events))];
				$best_odds = $this->FrontModel->get_best_odds($cover['EventID']);
				$this->data['league_events'] = $league_events;
				$this->data['cover'] = $cover;
				$this->data['best_odds'] = $best_odds;
			}
		}
		$this->load->view('templates/head', $this->data);
		$this->load->view('templates/left_col');
		$this->load->view('events');
		$this->load->view('templates/right_col');
		$this->load->view('templates/footer');
	}

}
