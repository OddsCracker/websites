<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FrontModel extends MY_Model {
	public function __construct(){
		parent::__construct();
	}

	public function check_ban($ip){
			$this->db->where('IpAddr', $ip);
			$query = $this->db->get('oc_bans');
			$result = $query->row_array();
			if (is_null($result)) {
				return FALSE;
			} else {
				return TRUE;
			}
	}
	
	public function get_bookmakers(){
		$bookmakers = array();
		$this->db->order_by('SortOrder ASC, BookmakerID DESC');
		$query = $this->db->get('oc_bookmakers');
		foreach ($query->result_array() as $row) {
			$bookmakers[$row['BookmakerID']] = array();
			foreach ($row as $key => $value) {
				$bookmakers[$row['BookmakerID']][$key] = $value;
			}
			$bookmakers[$row['BookmakerID']]['Rating'] = round(($row['RatingUse']+$row['RatingGames']+$row['RatingBonus']+$row['RatingService']+$row['RatingMobile']+$row['RatingWithdraw'])/6, 1);
		}
		return $bookmakers;
	}
	
	public function get_bookmaker($slug){
		$bookmaker = array();
		$this->db->where(array('Slug'=>$slug));
		$query = $this->db->get('oc_bookmakers');
		$row = $query->row_array();
		if (is_null($row)) {
			return FALSE;
		} else {
			foreach ($row as $key => $value){
				$bookmaker[$key] = $value;
			}
			$bookmaker['Rating'] = round(($row['RatingUse']+$row['RatingGames']+$row['RatingBonus']+$row['RatingService']+$row['RatingMobile']+$row['RatingWithdraw'])/6, 1);
			$ql = $this->db->query("SELECT * FROM oc_bookmakers_ratings WHERE BookmakerID = " . $row['BookmakerID'] . " AND Rating = 1");
			$likes = $ql->num_rows();
			$qd = $this->db->query("SELECT * FROM oc_bookmakers_ratings WHERE BookmakerID = " . $row['BookmakerID'] . " AND Rating = 0");
			$dislikes = $qd->num_rows();
			$bookmaker['likes'] = $likes;
			$bookmaker['dislikes'] = $dislikes;
			return $bookmaker;
		}
	}
	
	public function get_country_list(){
		$countries = array();
		$this->db->order_by('CountryName ASC');
		$query = $this->db->get('oc_countries');
		foreach ($query->result_array() as $row) {
			$countries[$row['CountryID']] = array();
			$countries[$row['CountryID']]['CountryName'] = $row['CountryName'];
			$countries[$row['CountryID']]['ContinentName'] = $row['ContinentName'];
			$countries[$row['CountryID']]['CountrySlug'] = $row['CountrySlug'];
		}
		return $countries;
	}
	
	public function get_leagues_list(){
		$leagues = array();
		$ql = $this->db->query("SELECT oc_leagues.*, oc_countries.CountryName FROM oc_leagues INNER JOIN oc_countries ON oc_leagues.CountryCode = oc_countries.CountryCode ORDER BY oc_leagues.SortOrder ASC, oc_leagues.Name ASC");
		foreach ($ql->result_array() as $rl) {
			$leagues[$rl['LeagueID']] = array();
			$leagues[$rl['LeagueID']]['Name'] = $rl['Name'];
			$leagues[$rl['LeagueID']]['Slug'] = str_replace(' ', '_', $rl['Name']);
			$leagues[$rl['LeagueID']]['CountryName'] = $rl['CountryName'];
			$leagues[$rl['LeagueID']]['CountryFlag'] = $rl['CountryFlag'];
			$today = date('Y-m-d ' . '00:00:00');
			$tomorrow = date('Y-m-d H:i:s', strtotime('+1 days'));
			$qc = $this->db->query("SELECT * FROM oc_events WHERE LeagueID = " . $rl['LeagueID'] . " AND Time BETWEEN '$today' AND '$tomorrow'");
			$count = $qc->num_rows();
			$leagues[$rl['LeagueID']]['EventCount'] = $count;
		}
		return $leagues;
	}
	
	public function get_events($LeagueName=NULL){
		$Today = date('Y-m-d ') . '00:00:00';
		if (!is_null($LeagueName)) {
			$qe = $this->db->query("SELECT oc_events.*, oc_leagues.Name AS LeagueName, oc_leagues.CountryCode, oc_leagues.CountryFlag FROM oc_events INNER JOIN oc_leagues ON oc_events.LeagueID = oc_leagues.LeagueID WHERE oc_leagues.Name = '$LeagueName' AND oc_events.Time >= '$Today' ORDER BY oc_events.Time ASC");
		} else {
			$qe = $this->db->query("SELECT oc_events.*, oc_leagues.Name AS LeagueName, oc_leagues.CountryCode, oc_leagues.CountryFlag FROM oc_events INNER JOIN oc_leagues ON oc_events.LeagueID = oc_leagues.LeagueID WHERE oc_events.Time >= '$Today' ORDER BY oc_events.Time ASC");
		}
		$ce = $qe->num_rows();
		if ($ce == 0) {
			return FALSE;
		} else {
			$events = array();
			foreach ($qe->result_array() as $re) {
				$events[$re['EventID']] = array();
				$events[$re['EventID']]['EventID'] = $re['EventID'];
				$events[$re['EventID']]['Time'] = $re['Time'];
				$events[$re['EventID']]['ApiID'] = $re['ApiID'];
				$events[$re['EventID']]['LeagueID'] = $re['LeagueID'];
				$events[$re['EventID']]['LeagueName'] = $re['LeagueName'];
				$events[$re['EventID']]['CountryCode'] = $re['CountryCode'];
				$events[$re['EventID']]['CountryFlag'] = $re['CountryFlag'];
				$events[$re['EventID']]['Team1'] = $re['Team1'];
				$events[$re['EventID']]['Team2'] = $re['Team2'];
			}
			return $events;
		}
	}
	
	public function get_upcoming_events(){
		$Tomorrow = date('Y-m-d H:i:s', strtotime('+1 days'));
		$qe = $this->db->query("SELECT oc_events.*, oc_leagues.Name AS LeagueName, oc_leagues.CountryCode, oc_leagues.CountryFlag FROM oc_events INNER JOIN oc_leagues ON oc_events.LeagueID = oc_leagues.LeagueID WHERE oc_events.Time >= '$Tomorrow' ORDER BY oc_events.Time ASC LIMIT 0,20");
		$ce = $qe->num_rows();
		if ($ce == 0) {
			return FALSE;
		} else {
			$events = array();
			foreach ($qe->result_array() as $re) {
				$events[$re['EventID']] = array();
				$events[$re['EventID']]['EventID'] = $re['EventID'];
				$events[$re['EventID']]['Time'] = $re['Time'];
				$events[$re['EventID']]['ApiID'] = $re['ApiID'];
				$events[$re['EventID']]['LeagueID'] = $re['LeagueID'];
				$events[$re['EventID']]['LeagueName'] = $re['LeagueName'];
				$events[$re['EventID']]['CountryCode'] = $re['CountryCode'];
				$events[$re['EventID']]['CountryFlag'] = $re['CountryFlag'];
				$events[$re['EventID']]['Team1'] = $re['Team1'];
				$events[$re['EventID']]['Team2'] = $re['Team2'];
			}
			return $events;
		}
	}
	
	public function get_today_events(){
		$Today = date('Y-m-d ') . '00:00:00';
		$Tomorrow = date('Y-m-d ') . '23:59:59';
		$qe = $this->db->query("SELECT oc_events.*, oc_leagues.Name AS LeagueName, oc_leagues.CountryCode, oc_leagues.CountryFlag FROM oc_events INNER JOIN oc_leagues ON oc_events.LeagueID = oc_leagues.LeagueID WHERE oc_events.Time >= '$Today' AND oc_events.Time < '$Tomorrow' ORDER BY oc_events.Time ASC");
		$ce = $qe->num_rows();
		if ($ce == 0) {
			return FALSE;
		} else {
			$events = array();
			foreach ($qe->result_array() as $re) {
				$events[$re['EventID']] = array();
				$events[$re['EventID']]['EventID'] = $re['EventID'];
				$events[$re['EventID']]['Time'] = $re['Time'];
				$events[$re['EventID']]['ApiID'] = $re['ApiID'];
				$events[$re['EventID']]['LeagueID'] = $re['LeagueID'];
				$events[$re['EventID']]['LeagueName'] = $re['LeagueName'];
				$events[$re['EventID']]['CountryCode'] = $re['CountryCode'];
				$events[$re['EventID']]['CountryFlag'] = $re['CountryFlag'];
				$events[$re['EventID']]['Team1'] = $re['Team1'];
				$events[$re['EventID']]['Team2'] = $re['Team2'];
			}
			return $events;
		}
	}
	
	public function get_rss_events(){
		$Now = date('Y-m-d H:i:s');
		$qe = $this->db->query("SELECT oc_events.*, oc_leagues.Name AS LeagueName, oc_leagues.CountryCode, oc_countries.CountryName FROM oc_events INNER JOIN oc_leagues ON oc_events.LeagueID = oc_leagues.LeagueID INNER JOIN oc_countries ON oc_leagues.CountryCode = oc_countries.CountryCode WHERE oc_events.Time >= '$Now' ORDER BY oc_events.Time ASC");
		$ce = $qe->num_rows();
		if ($ce == 0) {
			return FALSE;
		} else {
			$events = array();
			foreach ($qe->result_array() as $re) {
				$events[$re['EventID']] = array();
				$events[$re['EventID']]['EventID'] = $re['EventID'];
				$events[$re['EventID']]['Time'] = $re['Time'];
				$events[$re['EventID']]['ApiID'] = $re['ApiID'];
				$events[$re['EventID']]['LeagueID'] = $re['LeagueID'];
				$events[$re['EventID']]['LeagueName'] = $re['LeagueName'];
				$events[$re['EventID']]['CountryCode'] = $re['CountryCode'];
				$events[$re['EventID']]['CountryName'] = $re['CountryName'];
				$events[$re['EventID']]['Team1'] = $re['Team1'];
				$events[$re['EventID']]['Team2'] = $re['Team2'];
			}
			return $events;
		}
	}
	
	public function get_event($event_id){
		$qe = $this->db->query("SELECT oc_events.*, oc_leagues.Name AS LeagueName, oc_countries.CountryName AS CountryName FROM oc_events INNER JOIN oc_leagues ON oc_events.LeagueID = oc_leagues.LeagueID INNER JOIN oc_countries ON oc_leagues.CountryCode = oc_countries.CountryCode WHERE oc_events.EventID = " . intval($event_id));
		$re = $qe->row_array();
		if (is_null($re)) {
			return FALSE;
		} else {
			$event = array();
			$event['date'] = date('Y-m-d', strtotime($re['Time']));
			$event['time'] = date('H:i', strtotime($re['Time']));
			$event['league'] = $re['LeagueName'];
			$event['country'] = $re['CountryName'];
			$event['team1'] = $re['Team1'];
			$event['team2'] = $re['Team2'];
			$qpe = $this->db->query("SELECT * FROM oc_events WHERE Time < '" . $re['Time'] . "' ORDER BY Time DESC LIMIT 0,1");
			$rpe = $qpe->row_array();
			if (!is_null($rpe)) {
				$event['previous']['id'] = $rpe['EventID'];
				$event['previous']['team1'] = $rpe['Team1'];
				$event['previous']['team2'] = $rpe['Team2'];
			}
			$qne = $this->db->query("SELECT * FROM oc_events WHERE Time > '" . $re['Time'] . "' ORDER BY Time ASC LIMIT 0,1");
			$rne = $qne->row_array();
			if (!is_null($rne)) {
				$event['next']['id'] = $rne['EventID'];
				$event['next']['team1'] = $rne['Team1'];
				$event['next']['team2'] = $rne['Team2'];
			}
			return $event;
		}
	}
	
	public function get_event_urls($event_id) {
		$urls = array();
		$qm = $this->db->query("SELECT DISTINCT MarketName FROM oc_markets WHERE EventID = " . intval($event_id));
		foreach ($qm->result_array() as $rm) {
			$MarketName = preg_replace('/[^a-zA-Z0-9\-\_\.\,\:]/', '', $rm['MarketName']);
			$urls[$MarketName] = array();
			$qb = $this->db->query("SELECT DISTINCT Bookmaker, EventUrl FROM oc_markets WHERE EventID = " . intval($event_id) . " AND MarketName = '$MarketName'");
			foreach ($qb->result_array() as $rb) {
				$urls[$MarketName][$rb['Bookmaker']] = $rb['EventUrl'];
			}
		}
		return $urls;
	}
	
	public function get_odds($event_id){
		$odds = array();
		$qm = $this->db->query("SELECT DISTINCT MarketName FROM oc_markets WHERE EventID = " . intval($event_id));
		$cm = $qm->num_rows();
		if ($cm > 0) {
			$odds['markets'] = array();
			$odds['stats'] = array();
			foreach ($qm->result_array() as $rm) {
				$odds['markets'][$rm['MarketName']] = array();
				$odds['stats'][$rm['MarketName']] = array();
				$MarketName = preg_replace('/[^a-zA-Z0-9\-\_\.\,\:]/', '', $rm['MarketName']);
				if ($MarketName == '1x2') {
					$qdb1 = $this->db->query("SELECT DISTINCT Bet, Bookmaker, MAX(Odds) AS high_odds, AVG(Odds) AS avg_odds FROM oc_markets WHERE EventID = " . intval($event_id) . " AND MarketName = '1x2' AND Bet = '1'");
					$rdb1 = $qdb1->row_array();
					$odds['stats']['1x2']['high']['1'] = $rdb1['high_odds'];
					$odds['stats']['1x2']['avg']['1'] = $rdb1['avg_odds'];
					$qdbx = $this->db->query("SELECT DISTINCT Bet, Bookmaker, MAX(Odds) AS high_odds, AVG(Odds) AS avg_odds FROM oc_markets WHERE EventID = " . intval($event_id) . " AND MarketName = '1x2' AND Bet = 'X'");
					$rdbx = $qdbx->row_array();
					$odds['stats']['1x2']['high']['X'] = $rdbx['high_odds'];
					$odds['stats']['1x2']['avg']['X'] = $rdbx['avg_odds'];
					$qdb2 = $this->db->query("SELECT DISTINCT Bet, Bookmaker, MAX(Odds) AS high_odds, AVG(Odds) AS avg_odds FROM oc_markets WHERE EventID = " . intval($event_id) . " AND MarketName = '1x2' AND Bet = '2'");
					$rdb2 = $qdb2->row_array();
					$odds['stats']['1x2']['high']['2'] = $rdb2['high_odds'];
					$odds['stats']['1x2']['avg']['2'] = $rdb2['avg_odds'];
				} elseif ($MarketName == 'dc') {
					$qdb1x = $this->db->query("SELECT DISTINCT Bet, Bookmaker, MAX(Odds) AS high_odds, AVG(Odds) AS avg_odds FROM oc_markets WHERE EventID = " . intval($event_id) . " AND MarketName = 'dc' AND Bet = '1X'");
					$rdb1x = $qdb1x->row_array();
					$odds['stats']['dc']['high']['1X'] = $rdb1x['high_odds'];
					$odds['stats']['dc']['avg']['1X'] = $rdb1x['avg_odds'];
					$qdb12 = $this->db->query("SELECT DISTINCT Bet, Bookmaker, MAX(Odds) AS high_odds, AVG(Odds) AS avg_odds FROM oc_markets WHERE EventID = " . intval($event_id) . " AND MarketName = 'dc' AND Bet = '12'");
					$rdb12 = $qdb12->row_array();
					$odds['stats']['dc']['high']['12'] = $rdb12['high_odds'];
					$odds['stats']['dc']['avg']['12'] = $rdb12['avg_odds'];
					$qdbx2 = $this->db->query("SELECT DISTINCT Bet, Bookmaker, MAX(Odds) AS high_odds, AVG(Odds) AS avg_odds FROM oc_markets WHERE EventID = " . intval($event_id) . " AND MarketName = 'dc' AND Bet = 'X2'");
					$rdbx2 = $qdbx2->row_array();
					$odds['stats']['dc']['high']['X2'] = $rdbx2['high_odds'];
					$odds['stats']['dc']['avg']['X2'] = $rdbx2['avg_odds'];
				} else {
					$qdb = $this->db->query("SELECT Bet, Bookmaker, MAX(Odds) AS high_odds, AVG(Odds) AS avg_odds FROM oc_markets WHERE EventID = " . intval($event_id) . " AND MarketName = '$MarketName' GROUP BY Bet");
					foreach ($qdb->result_array() as $rdb) {
						$odds['stats'][$rm['MarketName']]['high'][$rdb['Bet']] = $rdb['high_odds'];
						$odds['stats'][$rm['MarketName']]['avg'][$rdb['Bet']] = $rdb['avg_odds'];
					}
				}
				$qb = $this->db->query("SELECT oc_markets.Bookmaker FROM oc_markets INNER JOIN oc_bookmakers ON oc_markets.Bookmaker = LOWER(oc_bookmakers.Name) WHERE oc_markets.EventID = " . $event_id . " AND oc_markets.MarketName = '" .  $rm['MarketName']. "' ORDER BY oc_bookmakers.SortOrder ASC");
				foreach ($qb->result_array() as $rb) {
					$odds['markets'][$rm['MarketName']][$rb['Bookmaker']] = array();
					$this->db->where(array('EventID'=>$event_id, 'MarketName'=>$rm['MarketName'], 'Bookmaker'=>$rb['Bookmaker']));
					$this->db->select('Bet, Odds');
					$qo = $this->db->get('oc_markets');
					foreach ($qo->result_array() as $ro) {
						$odds['markets'][$rm['MarketName']][$rb['Bookmaker']][$ro['Bet']] = $ro['Odds'];
					}
					
				}
			}
			return $odds;
		} else {
			return FALSE;
		}
	}
	
	public function get_best_odds($event_id){
		$best_odds = array();
		$q1 = $this->db->query("SELECT oc_markets.Bookmaker, oc_markets.Odds, oc_bookmakers.Logo, oc_bookmakers.Link FROM oc_markets INNER JOIN oc_bookmakers ON oc_markets.Bookmaker = LOWER(oc_bookmakers.Name) WHERE oc_markets.EventID = " . intval($event_id) . " AND oc_markets.MarketName = '1x2' AND oc_markets.Bet = '1' ORDER BY oc_markets.Odds DESC LIMIT 0,1");
		$r1 = $q1->row_array();
		$best_odds['1'] = array();
		$best_odds['1']['bookmaker'] = $r1['Bookmaker'];
		$best_odds['1']['odds'] = $r1['Odds'];
		$best_odds['1']['url'] = $r1['Link'];
		$best_odds['1']['logo'] = $r1['Logo'];
		$qx = $this->db->query("SELECT oc_markets.Bookmaker, oc_markets.Odds, oc_bookmakers.Logo, oc_bookmakers.Link FROM oc_markets INNER JOIN oc_bookmakers ON oc_markets.Bookmaker = LOWER(oc_bookmakers.Name) WHERE oc_markets.EventID = " . intval($event_id) . " AND oc_markets.MarketName = '1x2' AND oc_markets.Bet = 'x' ORDER BY oc_markets.Odds DESC LIMIT 0,1");
		$rx = $qx->row_array();
		$best_odds['x'] = array();
		$best_odds['x']['bookmaker'] = $rx['Bookmaker'];
		$best_odds['x']['odds'] = $rx['Odds'];
		$best_odds['x']['url'] = $rx['Link'];
		$best_odds['x']['logo'] = $rx['Logo'];
		$q2 = $this->db->query("SELECT oc_markets.Bookmaker, oc_markets.Odds, oc_bookmakers.Logo, oc_bookmakers.Link FROM oc_markets INNER JOIN oc_bookmakers ON oc_markets.Bookmaker = LOWER(oc_bookmakers.Name) WHERE oc_markets.EventID = " . intval($event_id) . " AND oc_markets.MarketName = '1x2' AND oc_markets.Bet = '2' ORDER BY oc_markets.Odds DESC LIMIT 0,1");
		$r2 = $q2->row_array();
		$best_odds['2'] = array();
		$best_odds['2']['bookmaker'] = $r2['Bookmaker'];
		$best_odds['2']['odds'] = $r2['Odds'];
		$best_odds['2']['url'] = $r2['Link'];
		$best_odds['2']['logo'] = $r2['Logo'];
		return $best_odds;
	}
	
	public function get_best_event() {
		$events = array();
		$sums = array();
		$best = array();
		$today = date('Y-m-d 00:00:00');
		$tomorrow = date('Y-m-d 23:59:59');
		$qe = $this->db->query("SELECT oc_events.*, oc_leagues.Name FROM oc_events INNER JOIN oc_leagues ON oc_events.LeagueID = oc_leagues.LeagueID WHERE oc_events.Time >= '$today' AND oc_events.Time <= '$tomorrow'");
		foreach ($qe->result_array() as $re) {
			$EventID = $re['EventID'];
			$events[$EventID] = array();
			$events[$EventID]['EventID'] = $EventID;
			$events[$EventID]['League'] = $re['Name'];
			$events[$EventID]['Team1'] = $re['Team1'];
			$events[$EventID]['Team2'] = $re['Team2'];
			$events[$EventID]['Time'] = $re['Time'];
			$events[$EventID]['odds'] = array();
			$sum = 0;
			$qo1 = $this->db->query("SELECT oc_markets.Odds, oc_markets.Bookmaker, oc_markets.EventUrl, oc_bookmakers.Name AS BookmakerName, oc_bookmakers.Logo AS BookmakerLogo FROM oc_markets INNER JOIN oc_bookmakers ON oc_markets.Bookmaker = LOWER(oc_bookmakers.Name) WHERE oc_markets.EventID = " . $EventID . " AND oc_markets.MarketName = '1x2' AND oc_markets.Bet = '1' ORDER BY oc_markets.Odds DESC LIMIT 0,1");
			$ro1 = $qo1->row_array();
			if (!is_null($ro1)) {
				$events[$EventID]['odds']['1'] = array();
				$events[$EventID]['odds']['1']['value'] = $ro1['Odds'];
				$events[$EventID]['odds']['1']['bookmaker_name'] = $ro1['BookmakerName'];
				$events[$EventID]['odds']['1']['bookmaker_logo'] = $ro1['BookmakerLogo'];
				$events[$EventID]['odds']['1']['url'] = $ro1['EventUrl'];
				$sum += $ro1['Odds'];
			}
			$qox = $this->db->query("SELECT oc_markets.Odds, oc_markets.Bookmaker, oc_markets.EventUrl, oc_bookmakers.Name AS BookmakerName, oc_bookmakers.Logo AS BookmakerLogo FROM oc_markets INNER JOIN oc_bookmakers ON oc_markets.Bookmaker = LOWER(oc_bookmakers.Name) WHERE oc_markets.EventID = " . $EventID . " AND oc_markets.MarketName = '1x2' AND oc_markets.Bet = 'X' ORDER BY oc_markets.Odds DESC LIMIT 0,1");
			$rox = $qox->row_array();
			if (!is_null($rox)) {
				$events[$EventID]['odds']['X'] = array();
				$events[$EventID]['odds']['X']['value'] = $rox['Odds'];
				$events[$EventID]['odds']['X']['bookmaker_name'] = $rox['BookmakerName'];
				$events[$EventID]['odds']['X']['bookmaker_logo'] = $rox['BookmakerLogo'];
				$events[$EventID]['odds']['X']['url'] = $rox['EventUrl'];
				$sum += $rox['Odds'];
			}
			$qo2 = $this->db->query("SELECT oc_markets.Odds, oc_markets.Bookmaker, oc_markets.EventUrl, oc_bookmakers.Name AS BookmakerName, oc_bookmakers.Logo AS BookmakerLogo FROM oc_markets INNER JOIN oc_bookmakers ON oc_markets.Bookmaker = LOWER(oc_bookmakers.Name) WHERE oc_markets.EventID = " . $EventID . " AND oc_markets.MarketName = '1x2' AND oc_markets.Bet = '2' ORDER BY oc_markets.Odds DESC LIMIT 0,1");
			$ro2 = $qo2->row_array();
			if (!is_null($ro2)) {
				$events[$EventID]['odds']['2'] = array();
				$events[$EventID]['odds']['2']['value'] = $ro2['Odds'];
				$events[$EventID]['odds']['2']['bookmaker_name'] = $ro2['BookmakerName'];
				$events[$EventID]['odds']['2']['bookmaker_logo'] = $ro2['BookmakerLogo'];
				$events[$EventID]['odds']['2']['url'] = $ro2['EventUrl'];
				$sum += $ro2['Odds'];
				$sums[$EventID] = $sum;
			}
		}
		$best_key = array_keys($sums, min($sums));
		$best = $events[$best_key['0']];
		return $best;
	}
	
	public function get_standings($LeagueName){
		$this->db->where('League', $LeagueName);
		$qs = $this->db->get('oc_standings');
		$rs = $qs->row_array();
		if (is_null($rs)) {
			return FALSE;
		} else {
			return $rs;
		}
	}
	
	public function get_bookies(){
		$bookies = array();
		$qb = $this->db->query("SELECT * FROM oc_bookmakers ORDER BY SortOrder ASC");
		foreach ($qb->result_array() as $rb) {
			$Name = strtolower($rb['Name']);
			$bookies[$Name] = array();
			$bookies[$Name]['Name'] = $rb['Name'];
			$bookies[$Name]['Link'] = $rb['Link'];
			$bookies[$Name]['Logo'] = $rb['Logo'];
			$bookies[$Name]['DisplayOdds'] = $rb['DisplayOdds'];
			$bookies[$Name]['Bonus'] = $rb['Bonus'];
		}
		return $bookies;
	}
	
	public function get_markets($event_id){
		$markets = array();
		$qm = $this->db->query("SELECT DISTINCT MarketName FROM oc_markets WHERE EventID = " . intval($event_id));
		foreach ($qm->result_array() as $rm) {
			array_push($markets, $rm['MarketName']);
		}
		return $markets;
	}
	
	public function get_archives($time){
		$json = curl_get_page($this->data['settings']['api_url']. $this->data['settings']['api_token'] . '/archives/' . $this->data['settings']['country_code'] . '/' . $time);
		$list = json_decode($json, TRUE);
		if ($list['status'] == 'success') {
			return $list['data'];
		} else {
			return FALSE;
		}
	}
	
	public function get_archive($event_id) {
		$json = curl_get_page($this->data['settings']['api_url']. $this->data['settings']['api_token'] . '/archive/' . $event_id);
		$list = json_decode($json, TRUE);
		if ($list['status'] == 'success') {
			return $list['data'];
		} else {
			return FALSE;
		}
	}
	
	public function get_archive_event($event_id){
		$json = curl_get_page($this->data['settings']['api_url'] . '/events/' . $event_id);
		$list = json_decode($json, TRUE);
		if (!isset($list['message'])) {
			return $list;
		} else {
			return FALSE;
		}
	}
	
	public function search_team($string){
		$match = addslashes($string);
		$Now = date('Y-m-d H:i:s');
		$query = $this->db->query("SELECT * FROM oc_events WHERE (Team1 LIKE '%$match%' OR Team2 LIKE '%$match%') AND oc_events.Time > '$Now'");
		$count = $query->num_rows();
		if ($count == 0) {
			return FALSE;
		} else {
			$results = array();
			foreach ($query->result_array() as $result) {
				$results[$result['EventID']] = array();
				$results[$result['EventID']]['team1'] = $result['Team1'];
				$results[$result['EventID']]['team2'] = $result['Team2'];
				$results[$result['EventID']]['time'] = $result['Time'];
			}
			return $results;
		}
	}
	
	public function check_user_registration_form($post){
		if (get_cookie('csrf') && (!isset($post['csrf']) || $post['csrf'] != get_cookie('csrf'))) {
			$errors = 'There is a problem with your cookies! Try refreshing the page.';
			return $errors;
		} else {
			if (!filter_var($post['Email'], FILTER_VALIDATE_EMAIL)) {
				$errors = 'Email address is not valid!';
				return $errors;
			} else {
				if ($post['Email'] != $post['ConfirmEmail']) {
					$errors = 'Email addresses do not match!';
					return $errors;
				} else {
					$this->db->where('Email', $post['Email']);
					$qe = $this->db->get('oc_users');
					$ce = $qe->num_rows();
					if ($ce > 0) {
						$errors = 'Email address is already in use!';
						return $errors;
					} else {
						if (strlen($post['Password']) < 6 || strlen($post['Password']) > 50) {
							$errors = 'Password length must be between 6 and 50 characters!';
							return $errors;
						} else {
							if ($post['Password'] != $post['ConfirmPassword']) {
								$errors = 'Passwords do not match!';
								return $errors;
							} else {
								if ($post['Captcha'] != $this->session->userdata('captcha')) {
									$errors = 'Captcha code is incorrect!';
									return $errors;
								} else {
									if (!isset($post['agreement'])) {
										$errors = 'You have to agree to our terms of service and privacy policy!';
										return $errors;
									} else {
										$data['Email'] = $post['Email'];
										$data['Password'] = hash('sha512', trim($post['Password']));
										$data['Username'] = htmlspecialchars($post['Username']);
										$data['Country'] = $post['Country'];
										$data['Token'] = hash('sha512', $post['Email'] . time());
										$this->db->insert('oc_users', $data);
										if (isset($post['newsletter'])) {
											/* check if subscription exists or insert it */
											$qn = $this->db->query("SELECT * FROM oc_newsletter WHERE Email = '" . filter_var($post['Email'], FILTER_SANITIZE_EMAIL) . "'");
											$cn = $qn->num_rows();
											if ($cn == 0) {
												$this->db->query("INSERT INTO oc_newsletter (Email) VALUES ('" . filter_var($post['Email'], FILTER_SANITIZE_EMAIL) . "')");
											}
										}
										if ($this->data['settings']['use_smtp'] == 0) {
											$this->load->model('Mailgun');
											$from = $this->data['settings']['default_email'];
											$to = $post['Email'];
											$subject = 'Welcome to Oddscracker';
											$message = '<p>Hello <strong>' . $data['Username'] . '</strong><br>Welcome to Oddscracker!<br>Your account has been created but it needs activation.<br>To activate it, please click the URL bellow<br><br><a href="' . $this->data['settings']['abs_url'] . '/register/activate/' . $data['Token'] . '">' . $this->data['settings']['abs_url'] . '/register/activate/' . $data['Token'] . '</a></p>';
											$this->Mailgun->send_email($to, $subject, $message, $from);
										} else {
											$this->load->library('email');
											$cfg['useragent'] = 'CodeIgniter';
											$cfg['protocol'] = 'smtp';
											$cfg['smtp_host'] = $this->data['settings']['smtp_host'];
											$cfg['smtp_port'] = $this->data['settings']['smtp_port'];
											$cfg['smtp_user'] = $this->data['settings']['smtp_user'];
											$cfg['smtp_pass'] = $this->data['settings']['smtp_pass'];
											if ($this->data['settings']['smtp_port'] == 465) {
												$cfg['smtp_crypto'] = 'ssl';
											} else {
												$cfg['smtp_crypto'] = 'tls';
											}
											$cfg['mailtype'] = 'html';
											$cfg['charset'] = 'utf-8';
											$this->email->initialize($cfg);
											$this->email->from($this->data['settings']['default_email'], 'Oddscracker Kenya');
											$this->email->to($post['Email']);
											$this->email->subject('Welcome to Oddscracker');
											$this->email->message('<p>Hello <strong>' . $data['Username'] . '</strong><br>Welcome to Oddscracker!<br>Your account has been created but it needs activation.<br>To activate it, please click the URL bellow<br><br><a href="' . $this->data['settings']['abs_url'] . '/register/activate/' . $data['Token'] . '">' . $this->data['settings']['abs_url'] . '/register/activate/' . $data['Token'] . '</a></p>');
											$this->email->send();
										}
										return FALSE;
									}
								}
							}
						}
					}
				}
			}
		}
	}
	
	public function check_user_login_form($post){
		if (get_cookie('csrf') && (!isset($post['csrf']) || $post['csrf'] != get_cookie('csrf'))) {
			$errors = 'There is a problem with your cookies! Try refreshing the page first.';
			return $errors;
		} else {
			$Email = filter_var($post['Email'], FILTER_SANITIZE_EMAIL);
			$Password = hash('sha512', trim($post['Password']));
			$this->db->where(array('Email'=>$Email, 'Password'=>$Password, 'IsAdmin'=>0));
			$query = $this->db->get('oc_users');
			$row = $query->row_array();
			if (is_null($row)) {
				$errors = 'Login is incorrect!';
				return $errors;
			} else {
				if ($row['Active'] == 0) {
					$errors = 'Your account has not been activated. You must confirm your email address before logging in. If you did not receive any email from us, contact us directly at <a href="mailto:' . $this->data['settings']['default_email'] . '">' . $this->data['settings']['default_email'] . '</a>';
					return $errors;
				} else {
					if (isset($post['rememberme'])) {
						$expire = time()+86400*30;
					} else {
						$expire = 0;
					}
					setcookie('_user_', md5($row['UserID']), $expire, '/', $_SERVER['SERVER_NAME'], ini_get('session.cookie_secure'), 1);
					$LastLogin = date('Y-m-d H:i:s');
					$this->db->query("UPDATE oc_users SET LastLogin = '$LastLogin' WHERE UserID = " . $row['UserID']);
					return FALSE;
				}
			}
		}
	}
	
	public function check_facebook_login($post){
		if ((!isset($post['Email']) || empty($post['Email'])) && (!isset($post['Name']) || empty($post['Name']))) {
			$errors = 'Email and name fields are required!';
			return $errors;
		} else {
			$Email = filter_var($post['Email'], FILTER_SANITIZE_EMAIL);
			$Username = preg_replace('/[^A-Za-z0-9\-\_]/', '', $post['Name']);
			$explode = explode(' ', $post['Name']);
			$FirstName = $explode['0'];
			$LastName = $explode['1'];
			$this->db->where(array('Email'=>$Email, 'IsAdmin'=>0));
			$query = $this->db->get('oc_users');
			$row = $query->row_array();
			if (is_null($row)) {
				$this->db->insert('oc_users', array('Email'=>$Email, 'Username'=>$Username, 'FirstName'=>$FirstName, 'LastName'=>$LastName, 'Active'=>1, 'FacebookLogin'=>1));
				$UserID = $this->db->insert_id();
				$expire = time()+86400*30;
				setcookie('_user_', md5($row['UserID']), $expire, '/', $_SERVER['SERVER_NAME'], ini_get('session.cookie_secure'), 1);
				$LastLogin = date('Y-m-d H:i:s');
				$this->db->query("UPDATE oc_users SET LastLogin = '$LastLogin' WHERE UserID = " . $row['UserID']);
				$this->session->set_flashdata('success', 'Welcome ' . htmlspecialchars($post['Name']));
				return FALSE;
			} else {
				$expire = time()+86400*30;
				setcookie('_user_', md5($row['UserID']), $expire, '/', $_SERVER['SERVER_NAME'], ini_get('session.cookie_secure'), 1);
				$LastLogin = date('Y-m-d H:i:s');
				$this->db->query("UPDATE oc_users SET LastLogin = '$LastLogin' WHERE UserID = " . $row['UserID']);
				$this->session->set_flashdata('success', 'Welcome back ' . htmlspecialchars($row['Username']));
				return FALSE;
			}
		}
	}
	
	public function check_google_login($post){
		if ((!isset($post['Email']) || empty($post['Email'])) && (!isset($post['FirstName']) || empty($post['FirstName'])) && (!isset($post['LastName']) || empty($post['LastName']))) {
			$errors = 'Email, first name and last name fields are required!';
			return $errors;
		} else {
			$Email = filter_var($post['Email'], FILTER_SANITIZE_EMAIL);
			$FirstName = $post['FirstName'];
			$LastName = $post['LastName'];
			$Username = $FirstName . $LastName;
			$this->db->where(array('Email'=>$Email, 'IsAdmin'=>0));
			$query = $this->db->get('oc_users');
			$row = $query->row_array();
			if (is_null($row)) {
				$this->db->insert('oc_users', array('Email'=>$Email, 'Username'=>$Username, 'FirstName'=>$FirstName, 'LastName'=>$LastName, 'Active'=>1, 'GoogleLogin'=>1));
				$UserID = $this->db->insert_id();
				$expire = time()+86400*30;
				setcookie('_user_', md5($row['UserID']), $expire, '/', $_SERVER['SERVER_NAME'], ini_get('session.cookie_secure'), 1);
				$LastLogin = date('Y-m-d H:i:s');
				$this->db->query("UPDATE oc_users SET LastLogin = '$LastLogin' WHERE UserID = " . $row['UserID']);
				$this->session->set_flashdata('success', 'Welcome ' . htmlspecialchars($post['FirstName'] . ' ' . $post['LastName']));
				return FALSE;
			} else {
				$expire = time()+86400*30;
				setcookie('_user_', md5($row['UserID']), $expire, '/', $_SERVER['SERVER_NAME'], ini_get('session.cookie_secure'), 1);
				$LastLogin = date('Y-m-d H:i:s');
				$this->db->query("UPDATE oc_users SET LastLogin = '$LastLogin' WHERE UserID = " . $row['UserID']);
				$this->session->set_flashdata('success', 'Welcome back ' . htmlspecialchars($row['FirstName'] . ' ' . $row['LastName']));
				return FALSE;
			}
		}
	}
	
	public function submit_contact_form($post){
		if (get_cookie('csrf') && (!isset($post['csrf']) || $post['csrf'] != get_cookie('csrf'))) {
			$errors = 'There is a problem with your cookies! Try refreshing the page first.';
			return $errors;
		} else {
			if (empty($post['Name'])) {
				$errors = 'Your name is required!';
				return $errors;
			} else {
				$Name = htmlspecialchars($post['Name']);
				if (!filter_var($post['Email'], FILTER_VALIDATE_EMAIL)) {
					$errors = 'Email address is not valid!';
					return $errors;
				} else {
					$Email = filter_var($post['Email'], FILTER_SANITIZE_EMAIL);
					if (empty($post['Phone'])) {
						$errors = 'Your phone number is required!';
						return $errors;
					} else {
						$Phone = preg_replace('/[^0-9\+]/', '', $post['Phone']);
						if (strlen($post['Message']) < 15 || strlen($post['Message']) > 1000) {
							$errors = 'The message must contain at least 15 characters but no more than 1000. Yours contains ' . strlen($post['Message']);
							return $errors;
						} else {
							$Message = htmlspecialchars($post['Message']);
							if ($post['Captcha'] != $this->session->userdata('captcha')) {
								$errors = 'Captcha code is incorrect!';
								return $errors;
							} else {
								$IpAddr = $_SERVER['REMOTE_ADDR'];
								$data = array('Name'=>$Name, 'Email'=>$Email, 'Phone'=>$Phone, 'Message'=>$Message, 'IpAddr'=>$IpAddr);
								$this->db->insert('oc_messages', $data);
								if ($this->data['settings']['use_smtp'] == 0) {
									$this->load->model('Mailgun');
									$from = $Email;
									$to = $this->data['settings']['contact_email'];
									$subject = 'New message from ' . $Name;
									$message = '<p>Hello admin, <strong>' . $Name . '</strong> sent you a message using the site contact form:<br><hr>'  . $Message . '<hr><br>Sender contact information:<br><ul><li>Email: ' . $Email . '</li><li>Phone: ' . $Phone . '</li></p><p>Message was sent from IP address <strong>' . $_SERVER['REMOTE_ADDR'] . '</strong> on <strong>' . date('r') . '</strong></p>';
									$this->Mailgun->send_email($to, $subject, $message, $from);
								} else {
									$this->load->library('email');
									$cfg['useragent'] = 'CodeIgniter';
									$cfg['protocol'] = 'smtp';
									$cfg['smtp_host'] = $this->data['settings']['smtp_host'];
									$cfg['smtp_port'] = $this->data['settings']['smtp_port'];
									$cfg['smtp_user'] = $this->data['settings']['smtp_user'];
									$cfg['smtp_pass'] = $this->data['settings']['smtp_pass'];
									if ($this->data['settings']['smtp_port'] == 465) {
										$cfg['smtp_crypto'] = 'ssl';
									} else {
										$cfg['smtp_crypto'] = 'tls';
									}
									$cfg['mailtype'] = 'html';
									$cfg['charset'] = 'utf-8';
									$this->email->initialize($cfg);
									$this->email->from($Email, $Name);
									$this->email->to($this->data['settings']['contact_email']);
									$this->email->subject('New message from ' . $Name);
									$this->email->message('<p>Hello admin, <strong>' . $Name . '</strong> sent you a message using the site contact form:<br><hr>'  . $Message . '<hr><br>Sender contact information:<br><ul><li>Email: ' . $Email . '</li><li>Phone: ' . $Phone . '</li></p><p>Message was sent from IP address <strong>' . $_SERVER['REMOTE_ADDR'] . '</strong> on <strong>' . date('r') . '</strong></p>');
									$this->email->send();
								}
								return FALSE;
							}
						}
					}
				}
			}
		}
	}

	public function get_news($start,$limit){
		/* create pagination */
		$qcn = $this->db->query("SELECT NewsID FROM oc_news");
		$news_count = $qcn->num_rows();
		$this->load->library('pagination');
		$config['base_url'] = $this->data['settings']['abs_url'] . '/news/page';
		$config['total_rows'] = $news_count;
		$config['per_page'] = $this->data['settings']['items_per_page'];
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['num_links'] = 3;
		$config['use_page_numbers'] = TRUE;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		/* end pagination */
		if ($start == 0 && $limit == 0){
			$query = $this->db->query("SELECT * FROM oc_news ORDER BY DateTime DESC");
		} else {
			if ($start == 0) {
				$query = $this->db->query("SELECT * FROM oc_news ORDER BY DateTime DESC LIMIT 0," . intval($limit));
			} else {
				$query = $this->db->query("SELECT * FROM oc_news ORDER BY DateTime DESC LIMIT " . intval($start) . "," . intval($limit));
			}
		}
		$news = array();
		foreach ($query->result_array() as $row) {
			$news[$row['NewsID']] = array();
			foreach ($row as $key => $value) {
				if ($key != 'NewsID') {
					if ($key == 'Content') {
						$news[$row['NewsID']][$key] = substr($value, 0, 128);
					} else {
						$news[$row['NewsID']][$key] = $value;
					}
				}
			}
		}
		return $news;
	}
	
	public function add_rating($post) {
		$IpAddr = $_SERVER['REMOTE_ADDR'];
		$Rating = intval($post['rating']);
		$BookmakerID = intval($post['bookmaker']);
		$this->db->where(array('BookmakerID'=>$BookmakerID, 'IpAddr'=>$IpAddr));
		$qr = $this->db->get('oc_bookmakers_ratings');
		$rr = $qr->row_array();
		if (is_null($rr)) {
			$this->db->insert('oc_bookmakers_ratings', array('BookmakerID'=>$BookmakerID, 'Rating'=>$Rating, 'IpAddr'=>$IpAddr, 'Time'=>time()));
			$query = $this->db->query("SELECT * FROM oc_bookmakers_ratings WHERE BookmakerID = " . $BookmakerID . " AND Rating = " . $Rating);
			$count = $query->num_rows();
			return $count;
		} else {
			return FALSE;
		}
	}
	
	public function add_subscription($post){
		$this->db->where('Email', $post['Email']);
		$query = $this->db->get('oc_newsletter');
		$row = $query->row_array();
		if (is_null($row)) {
			$this->db->insert('oc_newsletter', array('Email'=>$post['Email']));
			$SubscriptionID = $this->db->insert_id();
			return $SubscriptionID;
		} else {
			return FALSE;
		}
	}
	
	public function get_user_data($cookie){
		$this->db->where('md5(UserID)', preg_replace('/[^a-z0-9]/', '', $cookie));
		$query = $this->db->get('oc_users');
		$row = $query->row_array();
		if (is_null($row)) {
			return FALSE;
		} else {
			$user = array();
			foreach ($row as $key => $value) {
				if ($key != 'Password' && $key != 'Token') {
					$user[$key] = $value;
				}
			}
			return $user;
		}
	}
	
	public function update_account($post){
		$md5 = get_cookie('_user_');
		if (get_cookie('csrf') && (!isset($post['csrf']) || $post['csrf'] != get_cookie('csrf'))) {
			$errors = 'There is a problem with your cookies, please refresh the page!';
			return $errors;
		} else {
			if (!filter_var($post['Email'], FILTER_VALIDATE_EMAIL)) {
				$errors = 'Email address is not valid!';
				return $errors;
			} else {
				$Email = filter_var($post['Email'], FILTER_SANITIZE_EMAIL);
				$qd = $this->db->query("SELECT * FROM oc_users WHERE Email = '$Email' AND md5(UserID) != '$md5'");
				$cd = $qd->num_rows();
				if ($cd > 0) {
					$errors = 'Email address ' . $Email . ' is taken!';
					return $errors;
				} else {
					if (empty($post['Password'])) {
						$data = array('Email'=>$Email, 'Username'=>$post['Username'], 'FirstName'=>$post['FirstName'], 'LastName'=> $post['LastName'], 'Phone'=>$post['Phone'], 'Country'=>$post['Country']);
						$this->db->where('md5(UserID)', $md5);
						$this->db->update('oc_users', $data);
					} else {
						if ($post['Password'] != $post['ConfirmPassword']) {
							$errors = 'Passwords do not match!';
							return $errors;
						} else {
							if (strlen($post['Password']) < 6 || strlen($post['Password']) > 50) {
								$errors = 'Password length must be between 6 and 50 characters!';
								return $errors;
							} else {
								$Password = hash('sha512', trim($post['Password']));
								$data = array('Email'=>$Email, 'Password'=>$Password, 'Username'=>$post['Username'], 'FirstName'=>$post['FirstName'], 'LastName'=> $post['LastName'], 'Phone'=>$post['Phone'], 'Country'=>$post['Country']);
								$this->db->where('md5(UserID)', $md5);
								$this->db->update('oc_users', $data);
							}
						}
					}
					$qn = $this->db->query("SELECT * FROM oc_newsletter WHERE Email = '$Email'");
					$cn = $qn->num_rows();
					if ($cn > 0) {
						if (!isset($post['newsletter'])) {
							$this->db->query("DELETE FROM oc_newsletter WHERE Email = '$Email'");
						}
					} else {
						if (isset($post['newsletter'])) {
							$this->db->query("INSERT INTO oc_newsletter (Email) VALUES ('$Email')");
						}
					}
					return FALSE;
				}
			}
		}
	}
	
	public function get_newsletter($email){
		$this->db->where('Email', $email);
		$query = $this->db->get('oc_newsletter');
		$subscription = $query->row_array();
		if (is_null($subscription)) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	public function verify_activation($token){
		$this->db->where('Token', $token);
		$query = $this->db->get('oc_users');
		$row = $query->row_array();
		if (is_null($row)) {
			$errors = 'Invalid activation code! Please contact us directly at ' . $this->data['settings']['default_email'] . ' so we can manually validate your account.';
			return $errors;
		} else {
			if ($row['Active'] > 0) {
				$errors = 'Your account has already been activate, you can login to your account!';
				return $errors;
			} else {
				$this->db->query("UPDATE oc_users SET Active = 1 WHERE UserID = " . $row['UserID']);
				return FALSE;
			}
		}
	}
	
	public function newsletter_unsubscribe($email){
		$Email = filter_var(urldecode($email), FILTER_SANITIZE_EMAIL);
		$qe = $this->db->query("SELECT * FROM oc_newsletter WHERE Email = '$Email'");
		$ce = $qe->num_rows();
		if ($ce == 0) {
			return FALSE;
		} else {
			$this->db->query("DELETE FROM oc_newsletter WHERE Email = '$Email'");
			return $Email;
		}
	}
	
	public function get_archive_odds($event_id){
		$json = curl_get_page($this->data['settings']['api_url'] . '/events/' . $event_id . '/odds');
		$list = json_decode($json, TRUE);
		if (!isset($list['message'])) {
			$odds['markets'] = array();
			$markets = array();
			foreach ($list as $key => $value) {
				foreach ($value['odds'] as $market_name => $bets) {
					if (!in_array($market_name, $markets)) {
						array_push($markets, $market_name);
					}
				}
			}
			foreach ($markets as $market_key => $market) {
				foreach ($list as $key => $value) {
					if (isset($value['odds'][$market])) {
						$odds['markets'][$market] = array();
						$odds['markets'][$market][$value['bookmaker']] = array();
						foreach ($value['odds'][$market] as $outcome => $bet) {
							if (!is_array($bet)) {
								$odds['markets'][$market][$value['bookmaker']][$outcome] = $bet;
							} else {
								$odds['markets'][$market][$value['bookmaker']][$outcome] = serialize($bet);
							}
						}
					}
				}
			}
			$odds['stats'] = array();
			foreach ($markets as $market_key => $market) {
				foreach ($list as $key => $value) {
					if (isset($value['odds'][$market])) {
						$odds['stats'][$market] = array();
						$odds['stats'][$market]['high'] = array();
						$odds['stats'][$market]['avg'] = array();
						foreach ($value['odds'][$market] as $outcome => $bet) {
							$arr = array();
							foreach ($list as $k => $v) {
								if (isset($list[$k]['odds'][$market][$outcome])) {
									if (is_array($list[$k]['odds'][$market][$outcome])) {
										array_push($arr, serialize($list[$k]['odds'][$market][$outcome]));
									} else {
										array_push($arr, $list[$k]['odds'][$market][$outcome]);
									}
								}
							}
							$odds['stats'][$market]['high'][$outcome] = max($arr);
							$odds['stats'][$market]['avg'][$outcome] = array_sum($arr)/count($arr);
						}
					}
				}
			}
			return $odds;
		} else {
			return FALSE;
		}
	}
	
	public function get_campaign($token){
		$campaign = array();
		$this->db->where('Token', $token);
		$qc = $this->db->get('oc_campaigns');
		$rc = $qc->row_array();
		foreach ($rc as $key => $value) {
			$campaign[$key] = $value;
		}
		$campaign['bookmaker'] = array();
		$this->db->where('BookmakerID', $rc['BookmakerID']);
		$qb = $this->db->get('oc_bookmakers');
		$rb = $qb->row_array();
		foreach ($rb as $key => $value) {
			$campaign['bookmaker'][$key] = $value;
		}
		return $campaign;
	}

	public function get_jackpots(){
		$jackpots = array();
		$qb = $this->db->get('oc_bookmakers');
		foreach ($qb->result_array() as $rb) {
			$Bookmaker = $rb['Slug'];
			$qj = $this->db->query("SELECT * FROM oc_jackpots WHERE Bookmaker = '$Bookmaker'");
			foreach ($qj->result_array() as $rj) {
				$JackpotID = $rj['JackpotID'];
				$jackpots[$JackpotID] = array();
				$jackpots[$JackpotID]['Bookmaker'] = $rb['Name'];
				$jackpots[$JackpotID]['Logo'] = $rb['Logo'];
				foreach ($rj as $key => $value) {
					if ($key != 'Bookmaker') {
						$jackpots[$JackpotID][$key] = $value;
					}
				}
			}
		}
		return $jackpots;
	}

}
