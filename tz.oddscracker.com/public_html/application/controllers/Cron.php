<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends MY_Controller {

	public function index(){
		if (!$this->uri->segment(2)) {
			exit;
		}
	}
	
	public function update_news(){
		if (!$this->uri->segment(3)) {
			exit;
		}
		if ($this->uri->segment(3) != $this->data['settings']['cron_token']) {
			exit;
		}
		/* goal.com */
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://www.goal.com/en-tz/feeds/news');
		curl_setopt($ch, CURLOPT_TIMEOUT, 45);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$res = curl_exec($ch);
		curl_close($ch);
		$xml = simplexml_load_string($res);
		foreach ($xml->entry as $entry){
			$Source = 'goal.com';
			$Url = $entry->id;
			$Title = $entry->title;
			$DateTime = date('Y-m-d H:i:s', strtotime($entry->updated));
			$Content = strip_tags($entry->summary);
			$this->db->where('Url', $Url);
			$qn = $this->db->get('oc_news');
			$cn = $qn->num_rows();
			if ($cn == 0) {
				$data = array('DateTime'=>$DateTime, 'Title'=>$Title, 'Content'=>$Content, 'Source'=>$Source, 'Url'=>$Url);
				$this->db->insert('oc_news', $data);
			}
		}
		/* mwanaspoti.co.tz */
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://www.mwanaspoti.co.tz/1763586-1763586-view-asFeed-ftqdng/index.xml');
		curl_setopt($ch, CURLOPT_TIMEOUT, 45);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$res = curl_exec($ch);
		curl_close($ch);
		$xml = simplexml_load_string($res);
		foreach ($xml->item as $item){
			$Source = 'mwanaspoti.co.tz';
			$Url = $item->link;
			$Title = $item->title;
			$DateTime = date('Y-m-d H:i:s', strtotime($item->children('dc', true)->date));
			$Content = $item->description;
			$this->db->where('Url', $Url);
			$qn = $this->db->get('oc_news');
			$cn = $qn->num_rows();
			if ($cn == 0) {
				$data = array('DateTime'=>$DateTime, 'Title'=>$Title, 'Content'=>$Content, 'Source'=>$Source, 'Url'=>$Url);
				$this->db->insert('oc_news', $data);
			}
		}
		/* dailynews.co.tz */
  		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://dailynews.co.tz/index.php/sport?format=feed&type=rss');
		curl_setopt($ch, CURLOPT_TIMEOUT, 45);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$res = curl_exec($ch);
		curl_close($ch);
		$xml = simplexml_load_string($res);
		$Source = 'dailynews.co.tz';
		foreach ($xml->channel->item as $item){
			$Url = $item->link;
			$Title = $item->title;
			$DateTime = date('Y-m-d H:i:s', strtotime($item->pubDate));
			$Content = strip_tags($item->description);
			$this->db->where('Url', $Url);
			$qn = $this->db->get('oc_news');
			$cn = $qn->num_rows();
			if ($cn == 0) {
				$data = array('DateTime'=>$DateTime, 'Title'=>$Title, 'Content'=>$Content, 'Source'=>$Source, 'Url'=>$Url);
				$this->db->insert('oc_news', $data);
			}
		}
		/* tanzaniasports.com */
  		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://www.tanzaniasports.com/feed/');
		curl_setopt($ch, CURLOPT_TIMEOUT, 45);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$res = curl_exec($ch);
		curl_close($ch);
		$xml = simplexml_load_string($res);
		$Source = 'tanzaniasports.com';
		foreach ($xml->channel->item as $item){
			$Url = $item->link;
			$Title = $item->title;
			$DateTime = date('Y-m-d H:i:s', strtotime($item->pubDate));
			$Content = strip_tags($item->children('content', true)->encoded);
			$this->db->where('Url', $Url);
			$qn = $this->db->get('oc_news');
			$cn = $qn->num_rows();
			if ($cn == 0) {
				$data = array('DateTime'=>$DateTime, 'Title'=>$Title, 'Content'=>$Content, 'Source'=>$Source, 'Url'=>$Url);
				$this->db->insert('oc_news', $data);
			}
		}
		/* www.thecitizen.co.tz */
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://www.thecitizen.co.tz/News/Sports/1840572-1840572-view-asFeed-bsmfx5z/index.xml');
		curl_setopt($ch, CURLOPT_TIMEOUT, 45);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$res = curl_exec($ch);
		curl_close($ch);
		$xml = simplexml_load_string($res);
		foreach ($xml->item as $item){
			$Source = 'www.thecitizen.co.tz';
			$Url = $item->link;
			$Title = $item->title;
			$DateTime = date('Y-m-d H:i:s', strtotime($item->children('dc', true)->date));
			$Content = strip_tags($item->description);
			$this->db->where('Url', $Url);
			$qn = $this->db->get('oc_news');
			$cn = $qn->num_rows();
			if ($cn == 0) {
				$data = array('DateTime'=>$DateTime, 'Title'=>$Title, 'Content'=>$Content, 'Source'=>$Source, 'Url'=>$Url);
				$this->db->insert('oc_news', $data);
			}
		}
	}
	
	public function update_leagues(){
		if (!$this->uri->segment(3)) {
			exit;
		}
		if ($this->uri->segment(3) != $this->data['settings']['cron_token']) {
			exit;
		}
		$json = curl_get_page($this->data['settings']['api_url'] . '/leagues');
		$list = json_decode($json, TRUE);
		if (!isset($list['message'])) {
			foreach ($list as $key => $value) {
				$Name = $value['name'];
				if (isset($value['count'])) {
					$EventCount = $value['count'];
				} else {
					$EventCount = 0;
				}
				$CountryName = $value['country'];
				$this->db->where('CountryName', $value['country']);
				$query_country = $this->db->get('oc_countries');
				$country = $query_country->row_array();
				$CountryCode = $country['CountryCode'];
				$this->db->where('Name', $Name);
				$ql = $this->db->get('oc_leagues');
				$rl = $ql->row_array();
				if (is_null($rl)) {
					$qso = $this->db->query("SELECT MAX(SortOrder) AS SortOrder FROM oc_leagues");
					$rso = $qso->row_array();
					$SortOrder = $rso['SortOrder'] + 1;
					$this->db->insert('oc_leagues', array('Name'=>$Name, 'CountryCode'=>$CountryCode, 'SortOrder'=>$SortOrder, 'EventCount'=>$EventCount));
				} else {
					$DateTime = date('Y-m-d H:i:s');
					$this->db->query("UPDATE oc_leagues SET EventCount = " . $EventCount . ", Updated = '$DateTime' WHERE LeagueID = " . $rl['LeagueID']);
				}
			}
		}
	}
	
	public function update_events(){
		if (!$this->uri->segment(3)) {
			exit;
		}
		if ($this->uri->segment(3) != $this->data['settings']['cron_token']) {
			exit;
		}
		$json = curl_get_page($this->data['settings']['api_url'] . $this->data['settings']['api_token'] . '/events/' . $this->data['settings']['country_code']);
		$list = json_decode($json, TRUE);
		if ($list['status'] == 'error') {
			echo $list['msg'];
		} else {
			if (count($list['data']) > 0) {
				$events = $list['data'];
				foreach ($events as $key => $value) {
					$Time = $value['start_time'];
					$ApiID = $value['id'];
					$League = $value['league'];
					$Team1 = $value['team1'];
					$Team2 = $value['team2'];
					$this->db->where('ApiID', $ApiID);
					$qe = $this->db->get('oc_events');
					$re = $qe->row_array();
					if (is_null($re)) {
						$this->db->where('Name', $League);
						$ql = $this->db->get('oc_leagues');
						$rl = $ql->row_array();
						$LeagueID = $rl['LeagueID'];
						$this->db->insert('oc_events', array('Time'=>$Time, 'ApiID'=>$ApiID, 'LeagueID'=>$LeagueID, 'Team1'=>$Team1, 'Team2'=>$Team2));
					} else {
						$this->db->query("UPDATE oc_events SET `Time` = '$Time' WHERE EventID = " . $re['EventID']);
					}
				}
			}
		}
	}
	
	public function update_bookmakers(){
		if (!$this->uri->segment(3)) {
			exit;
		}
		if ($this->uri->segment(3) != $this->data['settings']['cron_token']) {
			exit;
		}
		$json = curl_get_page($this->data['settings']['api_url'] . '/' . $this->data['settings']['country_code'] . '/bookmakers');
		$list = json_decode($json, TRUE);
		foreach ($list as $key => $value) {
			$Name = $value['name'];
			$Slug = preg_replace('/[^a-z0-9\-]/', '', strtolower($Name));
			$Link = $value['link'];
			$this->db->where('Name', $Name);
			$qb = $this->db->get('oc_bookmakers');
			$rb = $qb->row_array();
			if (is_null($rb)) {
				$qso = $this->db->query("SELECT MAX(SortOrder) AS SortOrder FROM oc_bookmakers");
				$rso = $qso->row_array();
				$SortOrder = $rso['SortOrder']+1;
				$this->db->insert('oc_bookmakers', array('Name'=>$Name, 'Slug'=>$Slug, 'Link'=>$Link, 'SortOrder'=>$SortOrder));
			} else {
				$this->db->where('BookmakerID', $rb['BookmakerID']);
				$this->db->update('oc_bookmakers', array('Link'=>$Link));
			}
		}
	}
	
	public function update_markets(){
		if (!$this->uri->segment(3)) {
			exit;
		}
		if ($this->uri->segment(3) != $this->data['settings']['cron_token']) {
			exit;
		}
		$Now = date('Y-m-d H:i:s');
		$Next = date('Y-m-d  H:i:s', time()+86400);
		$qe = $this->db->query("SELECT oc_events.*, oc_leagues.Name AS LeagueName, oc_leagues.CountryCode FROM oc_events INNER JOIN oc_leagues ON oc_events.LeagueID = oc_leagues.LeagueID WHERE oc_events.Time > '$Now' AND oc_events.Time < '$Next' ORDER BY oc_events.Time ASC");
		$events = array();
		foreach ($qe->result_array() as $re) {
			$events[$re['EventID']] = array();
			$events[$re['EventID']]['EventID'] = $re['EventID'];
			$events[$re['EventID']]['Time'] = $re['Time'];
			$events[$re['EventID']]['ApiID'] = $re['ApiID'];
			$events[$re['EventID']]['LeagueID'] = $re['LeagueID'];
			$events[$re['EventID']]['LeagueName'] = $re['LeagueName'];
			$events[$re['EventID']]['CountryCode'] = $re['CountryCode'];
			$events[$re['EventID']]['Team1'] = $re['Team1'];
			$events[$re['EventID']]['Team2'] = $re['Team2'];
		}
		if (count($events) == 0) {
			exit;
		}
		foreach ($events as $EventID => $event) {
			$json = curl_get_page($this->data['settings']['api_url'] . $this->data['settings']['api_token'] . '/event/' . $event['ApiID']);
			$list = json_decode($json, TRUE);
			if ($list['status'] == 'success') {
				$this->db->query("DELETE FROM oc_markets WHERE EventID = " . $EventID);
				$data = $list['data'];
				foreach ($data as $key => $value) {
					$odds_arr = json_decode($value['odds'], true);
					foreach ($odds_arr as $mkey => $mvalue) {
						$EventUrl = $value['event_url'];
						$MarketName = htmlspecialchars($mkey);
						$Bookmaker = htmlspecialchars($value['bookmaker']);
						foreach ($mvalue as $okey => $ovalue) {
							$Bet = htmlspecialchars($okey);
							if (is_array($ovalue)) {
								$Odds = serialize($ovalue);
							} else {
								$Odds = $ovalue;
							}
							$data = array('EventID'=>$EventID, 'EventUrl'=>$EventUrl, 'MarketName'=>$MarketName, 'Bookmaker'=>$Bookmaker, 'Bet'=>$Bet, 'Odds'=>$Odds);
							$this->db->insert('oc_markets', $data);
						}
					}
				}
			}
		}
	}
	
	public function update_all_markets(){
		if (!$this->uri->segment(3)) {
			exit;
		}
		if ($this->uri->segment(3) != $this->data['settings']['cron_token']) {
			exit;
		}
		$Now = date('Y-m-d H:i:s');
		$qe = $this->db->query("SELECT oc_events.*, oc_leagues.Name AS LeagueName, oc_leagues.CountryCode FROM oc_events INNER JOIN oc_leagues ON oc_events.LeagueID = oc_leagues.LeagueID WHERE oc_events.Time > '$Now' ORDER BY oc_events.Time ASC");
		$events = array();
		foreach ($qe->result_array() as $re) {
			$events[$re['EventID']] = array();
			$events[$re['EventID']]['EventID'] = $re['EventID'];
			$events[$re['EventID']]['Time'] = $re['Time'];
			$events[$re['EventID']]['ApiID'] = $re['ApiID'];
			$events[$re['EventID']]['LeagueID'] = $re['LeagueID'];
			$events[$re['EventID']]['LeagueName'] = $re['LeagueName'];
			$events[$re['EventID']]['CountryCode'] = $re['CountryCode'];
			$events[$re['EventID']]['Team1'] = $re['Team1'];
			$events[$re['EventID']]['Team2'] = $re['Team2'];
		}
		if (count($events) == 0) {
			exit;
		}
		foreach ($events as $EventID => $event) {
			$json = curl_get_page($this->data['settings']['api_url'] . $this->data['settings']['api_token'] . '/event/' . $event['ApiID']);
			$list = json_decode($json, TRUE);
			if ($list['status'] == 'success') {
				$this->db->query("DELETE FROM oc_markets WHERE EventID = " . $EventID);
				$data = $list['data'];
				foreach ($data as $key => $value) {
					$odds_arr = json_decode($value['odds'], true);
					foreach ($odds_arr as $mkey => $mvalue) {
						$EventUrl = $value['event_url'];
						$MarketName = htmlspecialchars($mkey);
						$Bookmaker = htmlspecialchars(strtolower($value['bookmaker']));
						foreach ($mvalue as $okey => $ovalue) {
							$Bet = htmlspecialchars($okey);
							if (is_array($ovalue)) {
								$Odds = serialize($ovalue);
							} else {
								$Odds = $ovalue;
							}
							$data = array('EventID'=>$EventID, 'EventUrl'=>$EventUrl, 'MarketName'=>$MarketName, 'Bookmaker'=>$Bookmaker, 'Bet'=>$Bet, 'Odds'=>$Odds);
							$this->db->insert('oc_markets', $data);
						}
					}
				}
			}
		}
	}
	
	public function update_standings(){
		$standings = array();
		$json = curl_get_page($this->data['settings']['api_url'] . '/standings');
		$list = json_decode($json, TRUE);
		if (!isset($list['message'])) {
			foreach ($list as $key => $value) {
				$League = $value['league'];
				$CountryName = $value['country'];
				$this->db->where('CountryName', $value['country']);
				$query_country = $this->db->get('oc_countries');
				$country = $query_country->row_array();
				$CountryCode = $country['CountryCode'];
				$Html = $value['content'];
				$this->db->where('League', $League);
				$qs = $this->db->get('oc_standings');
				$rs = $qs->row_array();
				if (is_null($rs)) {
					$data = array('League'=>$League, 'CountryName'=>$CountryName, 'CountryCode'=>$CountryCode, 'Html'=>$Html);
					$this->db->insert('oc_standings', $data);
				} else {
					$this->db->where('StandingsID', $rs['StandingsID']);
					$this->db->update('oc_standings', array('Html'=>$Html));
				}
			}
		}
	}


}
