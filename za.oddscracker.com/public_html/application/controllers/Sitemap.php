<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap extends MY_Controller {

	public function index(){
		$bookmakers = $this->FrontModel->get_bookmakers();
		$leagues = $this->FrontModel->get_leagues_list();
		$events = $this->FrontModel->get_events();
		header('Content-type:application/xml');
		echo '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
		echo '<url><loc>' . $this->data['settings']['abs_url'] . '</loc><changefreq>hourly</changefreq><priority>0.9</priority></url>' . "\n";
		echo '<url><loc>' . $this->data['settings']['abs_url'] . '/about</loc><changefreq>monthly</changefreq><priority>0.5</priority></url>' . "\n";
		echo '<url><loc>' . $this->data['settings']['abs_url'] . '/faq</loc><changefreq>monthly</changefreq><priority>0.5</priority></url>' . "\n";
		echo '<url><loc>' . $this->data['settings']['abs_url'] . '/contact</loc><changefreq>monthly</changefreq><priority>0.5</priority></url>' . "\n";
		echo '<url><loc>' . $this->data['settings']['abs_url'] . '/privacy</loc><changefreq>monthly</changefreq><priority>0.5</priority></url>' . "\n";
		echo '<url><loc>' . $this->data['settings']['abs_url'] . '/help</loc><changefreq>monthly</changefreq><priority>0.5</priority></url>' . "\n";
		echo '<url><loc>' . $this->data['settings']['abs_url'] . '/register</loc><changefreq>monthly</changefreq><priority>0.5</priority></url>' . "\n";
		echo '<url><loc>' . $this->data['settings']['abs_url'] . '/jackpots</loc><changefreq>monthly</changefreq><priority>0.5</priority></url>' . "\n";
		echo '<url><loc>' . $this->data['settings']['abs_url'] . '/bookmakers</loc><changefreq>weekly</changefreq><priority>0.5</priority></url>' . "\n";
		echo '<url><loc>' . $this->data['settings']['abs_url'] . '/bookmakers/comparison</loc><changefreq>weekly</changefreq><priority>0.5</priority></url>' . "\n";
		foreach ($bookmakers as $key => $value) {
			echo '<url><loc>' . $this->data['settings']['abs_url'] . '/bookmakers/reviews/' . $value['Slug'] . '</loc><changefreq>weekly</changefreq><priority>0.7</priority></url>' . "\n";
		}
		echo '<url><loc>' . $this->data['settings']['abs_url'] . '/archives</loc><changefreq>daily</changefreq><priority>0.7</priority></url>' . "\n";
		echo '<url><loc>' . $this->data['settings']['abs_url'] . '/leagues</loc><changefreq>weekly</changefreq><priority>0.6</priority></url>' . "\n";
		echo '<url><loc>' . $this->data['settings']['abs_url'] . '/events</loc><changefreq>hourly</changefreq><priority>0.9</priority></url>' . "\n";
		foreach ($leagues as $key => $value) {
			echo '<url><loc>' . $this->data['settings']['abs_url'] . '/events/' . $value['Slug'] . '</loc><changefreq>daily</changefreq><priority>0.8</priority></url>' . "\n";
		}
		foreach ($events as $key => $value) {
			echo '<url><loc>' . $this->data['settings']['abs_url'] . '/event/' . preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', $value['Team1'])) . '-' . preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', $value['Team2'])) . '-' . $value['EventID'] . '</loc><changefreq>hourly</changefreq><priority>0.8</priority></url>' . "\n";
		}
		echo '</urlset>';
	}

}
