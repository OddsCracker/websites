<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rss extends MY_Controller {

	public function index(){
		$events = $this->FrontModel->get_rss_events();
		header('Content-Type: application/rss+xml; charset=utf-8');
		echo '<?xml version="1.0" encoding="UTF-8"?>
	<rss version="2.0">
		<channel>
			<title>' . $this->data['settings']['site_name'] . ' - ' . $this->data['settings']['country_name'] . '</title>
			<link>' . $this->data['settings']['abs_url'] . '/rss</link>
			<description>Upcoming football matches - ' . $this->data['settings']['country_name'] . '</description>
';
			foreach ($events as $key => $value) {
				echo '
			<item>
				<title>' . htmlspecialchars($value['Team1']) . ' vs ' . htmlspecialchars($value['Team2']) . '</title>
				<link>' . $this->data['settings']['abs_url'] . '/event/' . preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['Team1']))) . '-' . preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['Team2']))) . '-' . $key . '</link>
				<guid isPermaLink="true">' . $this->data['settings']['abs_url'] . '/event/' . preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['Team1']))) . '-' . preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['Team2']))) . '-' . $key . '</guid>
				<description>' . date('d M Y H:i', strtotime($value['Time'])) . '</description>
			</item>
';
				}
				echo '
	</channel>
</rss>
';
	}

}