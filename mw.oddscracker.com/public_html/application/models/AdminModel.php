<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminModel extends MY_Model {
	public function __construct(){
		parent::__construct();
	}
	
	public function check_admin($post){
		$this->db->where(array('IsAdmin'=>1, 'Email'=>$post['Email'], 'Password'=>hash('sha512', $post['Password'])));
		$query = $this->db->get('oc_users');
		$row = $query->row_array();
		if (is_null($row)) {
			return FALSE;
		} else {
			return $row['UserID'];
		}
	}
	
	public function get_analytics(){
		$stats['online']['loggedin'] = array();
		$stats['online']['anonymous'] = array();
		$StartTime = date('Y-m-d H:i:s', (time()-900));
		$CurrentTime = date('Y-m-d H:i:s');
		$qo = $this->db->query("SELECT * FROM oc_analytics WHERE LastTime >= '$StartTime' AND LastTime <= '$CurrentTime'");
		foreach ($qo->result_array() as $ro) {
			if ($ro['IsLoggedIn'] > 0) {
				$stats['online']['loggedin'][$ro['AnalyticID']] = array();
				foreach ($ro as $key => $value) {
					if ($key != 'AnalyticID') {
						$stats['online']['loggedin'][$ro['AnalyticID']][$key] = $value;
					}
				}
			} else {
				$stats['online']['anonymous'][$ro['AnalyticID']] = array();
				foreach ($ro as $key => $value) {
					if ($key != 'AnalyticID') {
						$stats['online']['anonymous'][$ro['AnalyticID']][$key] = $value;
					}
				}
			}
		}
		$qld = $this->db->query("SELECT * FROM oc_analytics WHERE LastTime >= '" . date('Y-m-d H:i:s', (time()-86400)) . "' AND LastTime <= '$CurrentTime'");
		$cld = $qld->num_rows();
		$qlw = $this->db->query("SELECT * FROM oc_analytics WHERE LastTime >= '" . date('Y-m-d H:i:s', (time()-86400*7)) . "' AND LastTime <= '$CurrentTime'");
		$clw = $qlw->num_rows();
		$qlm = $this->db->query("SELECT * FROM oc_analytics WHERE LastTime >= '" . date('Y-m-d H:i:s', (time()-86400*30)) . "' AND LastTime <= '$CurrentTime'");
		$clm = $qlm->num_rows();
		$stats['total']['day'] = $cld;
		$stats['total']['week'] = $clw;
		$stats['total']['month'] = $clm;
		$stats['last500'] = array();
		$ql = $this->db->query("SELECT * FROM oc_analytics ORDER BY LastTime DESC LIMIT 0,500");
		foreach ($ql->result_array() as $row) {
			$stats['last500'][$row['AnalyticID']] = array();
			foreach ($row as $key => $value) {
				if ($key != 'AnalyticID') {
					$stats['last500'][$row['AnalyticID']][$key] = $value;
				}
			}
		}
		return $stats;
	}
	
	public function get_sort_order($table){
		$this->db->select('SortOrder');
		$this->db->order_by('SortOrder ASC');
		$query = $this->db->get($table);
		$count = $query->num_rows();
		$sort = array();
		for ($i=1; $i<=$count; $i++) {
			array_push($sort, $i);
		}
		$last = max($sort)+1;
		array_push($sort, $last);
		return $sort;
	}
	
	public function get_bookmaker_by_id($id){
		$bookmaker = array();
		$this->db->where(array('BookmakerID'=>intval($id)));
		$query = $this->db->get('oc_bookmakers');
		$row = $query->row_array();
		if (is_null($row)) {
			return FALSE;
		} else {
			foreach ($row as $key => $value){
				$bookmaker[$key] = $value;
			}
			return $bookmaker;
		}
	}
	
	public function check_bookmaker_duplicate($Name, $BookmakerID = NULL){
		$Slug = preg_replace('/[^a-z0-9\-]/', '', strtolower($Name));
		if (!is_null($BookmakerID)) {
			$query = $this->db->query("SELECT * FROM oc_bookmakers WHERE Slug = '$Slug' AND BookmakerID != " . $BookmakerID);
		} else {
			$query = $this->db->query("SELECT * FROM oc_bookmakers WHERE Slug = '$Slug'");
		}
		$row = $query->row_array();
		if (is_null($row)) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	public function insert_bookmaker($post){
		$this->db->insert('oc_bookmakers', $post);
		$BookmakerID = $this->db->insert_id();
		if ($BookmakerID > 0) {
			return $post['Slug'];
		} else {
			return FALSE;
		}
	}
	
	public function update_bookmaker($post){
		$BookmakerID = intval($post['BookmakerID']);
		$data_to_update = array();
		foreach ($post as $key => $value) {
			if ($key != 'BookmakerID' && $key != 'Slug') {
				$data_to_update[$key] = $value;
			}
		}
		$data_to_update['Slug'] = preg_replace('/[^a-z0-9\-]/', '', strtolower($post['Slug']));
		$this->db->set($data_to_update);
		$this->db->where('BookmakerID', $BookmakerID);
		$this->db->update('oc_bookmakers');
		return $data_to_update['Slug'];
	}
	
	public function delete_bookmaker($data){
		@unlink(FCPATH . '/uploads/' . $data['Logo']);
		@unlink(FCPATH . '/uploads/' . $data['Cover']);
		$this->db->where('BookmakerID', $data['BookmakerID']);
		$this->db->delete('oc_bookmakers');
		return TRUE;
	}
	
	public function get_users(){
		$users = array();
		$this->db->where('IsAdmin', 0);
		$query = $this->db->get('oc_users');
		foreach ($query->result_array() as $row) {
			$users[$row['UserID']] = array();
			foreach ($row as $key => $value) {
				if ($key != 'UserID' && $key != 'Password') {
					$users[$row['UserID']][$key] = $value;
				}
			}
		}
		return $users;
	}
	
	public function get_user($UserID){
		$this->db->where('UserID', $UserID);
		$query = $this->db->get('oc_users');
		$user = $query->row_array();
		return $user;
	}
	
	public function update_user($post){
		$user = $this->AdminModel->get_user(intval($post['UserID']));
		if (!$user) {
			return FALSE;
		} else {
			$Email = filter_var($post['Email'], FILTER_SANITIZE_EMAIL);
			$qe = $this->db->query("SELECT * FROM oc_users WHERE Email = '$Email' AND UserID != " . $user['UserID']);
			$ce = $qe->num_rows();
			if ($ce > 0) {
				return FALSE;
			} else {
				$data['Email'] = $Email;
				$data['Username'] = $post['Username'];
				$data['Country'] = $post['Country'];
				$data['Active'] = intval($post['Active']);
				if (empty($post['Password'])) {
					$data['Password'] = $user['Password'];
				} else {
					$data['Password'] = hash('sha512', trim($post['Password']));
				}
				$this->db->where('UserID', $user['UserID']);
				$this->db->update('oc_users', $data);
				return $user['UserID'];
			}
		}
	}
	
	public function delete_user($id){
		$this->db->where('UserID', intval($id));
		$query = $this->db->get('oc_users');
		$row = $query->row_array();
		if (is_null($row)){
			return FALSE;
		} else {
			$this->db->query("DELETE FROM oc_users WHERE UserID = " . $row['UserID']);
			$this->db->query("DELETE FROM oc_newsletter WHERE Email = '" . $row['Email'] . "'");
			return TRUE;
		}
	}
	
	public function get_pages(){
		$pages = array();
		$query = $this->db->get('oc_pages');
		foreach ($query->result_array() as $row) {
			$pages[$row['PageID']] = array();
			foreach ($row as $key => $value) {
				if ($key != 'PageID') {
					$pages[$row['PageID']][$key] = $value;
				}
			}
		}
		return $pages;
	}
	
	public function get_page($PageID){
		$this->db->where('PageID', $PageID);
		$query = $this->db->get('oc_pages');
		$row = $query->row_array();
		if (is_null($row)) {
			return FALSE;
		} else {
			$page = array();
			foreach ($row as $key => $value) {
				$page[$key] = $value;
			}
			return $page;
		}
	}
	
	public function update_page($post){
		$data['MetaTitle'] = $post['MetaTitle'];
		$data['MetaDescription'] = $post['MetaDescription'];
		$data['Heading'] = $post['Heading'];
		$data['Html'] = $post['Html'];
		$this->db->where('PageID', intval($post['PageID']));
		$this->db->update('oc_pages', $data);
		return intval($post['PageID']);
	}
	
	public function get_site_settings(){
		$settings = array();
		$query = $this->db->get('oc_settings');
		foreach ($query->result_array() as $row) {
			$settings[$row['SettingID']] = array();
			foreach ($row as $key => $value) {
				if ($key != 'SettingID') {
					$settings[$row['SettingID']][$key] = $value;
				}
			}
		}
		return $settings;
	}
	
	public function update_settings($post){
		foreach ($post['SettingID'] as $key => $value) {
			$SettingID = intval($value);
			$data['Description'] = $post['Description'][$key];
			$data['Value'] = $post['Value'][$key];
			$this->db->where('SettingID', $SettingID);
			$this->db->update('oc_settings', $data);
		}
		$this->session->set_flashdata('success', 'Site settings updated successfully!');
		$settings = $this->AdminModel->get_site_settings();
		return $settings;
	}
	
	public function get_messages(){
		$messages = array();
		$query = $this->db->query("SELECT * FROM oc_messages ORDER BY IsRead ASC, MessageID DESC LIMIT 0,500");
		foreach ($query->result_array() as $row) {
			$MessageID = $row['MessageID'];
			$messages[$MessageID] = array();
			foreach ($row as $key => $value) {
				if ($key != 'MessageID' && $key != 'Message') {
					$messages[$MessageID][$key] = $value;
				}
			}
		}
		return $messages;
	}
	
	public function get_message($id){
		$query = $this->db->query("SELECT * FROM oc_messages WHERE MessageID = " . intval($id));
		$row = $query->row_array();
		if (is_null($row)) {
			return FALSE;
		} else {
			if ($row['IsRead'] == 0) {
				$this->db->query("UPDATE oc_messages SET IsRead = 1 WHERE MessageID = " . $row['MessageID']);
			}
			return $row;
		}
	}

	public function delete_message($id){
		$this->db->query("DELETE FROM oc_messages WHERE MessageID = " . intval($id));
		return intval($id);
	}
	
	public function get_countries(){
		$query = $this->db->query("SELECT * FROM oc_countries ORDER BY CountryName ASC");
		$countries = array();
		foreach ($query->result_array() as $row) {
			$countries[$row['CountryID']] = array();
			foreach ($row as $key => $value) {
				if ($key != 'CountryID') {
					$countries[$row['CountryID']][$key] = $value;
				}
			}
		}
		return $countries;
	}
	
	public function get_leagues(){
		$query = $this->db->query("SELECT oc_leagues.*, oc_countries.CountryName, oc_countries.ContinentName, oc_countries.CountryID FROM oc_leagues LEFT JOIN oc_countries ON oc_leagues.CountryCode = oc_countries.CountryCode ORDER BY oc_leagues.SortOrder ASC");
		$leagues = array();
		foreach ($query->result_array() as $row) {
			$leagues[$row['LeagueID']] = array();
			foreach ($row as $key => $value) {
				if ($key != 'LeagueID') {
					$leagues[$row['LeagueID']][$key] = $value;
				}
			}
		}
		return $leagues;
	}
	
	public function get_league($id){
		$query = $this->db->query("SELECT oc_leagues.*, oc_countries.CountryID, oc_countries.CountryName, oc_countries.ContinentName FROM oc_leagues LEFT JOIN oc_countries ON oc_leagues.CountryCode = oc_countries.CountryCode WHERE oc_leagues.LeagueID = " . intval($id));
		$row = $query->row_array();
		if (is_null($row)) {
			return FALSE;
		} else {
			return $row;
		}
	}
	
	public function insert_league($post){
		$data = $post;
		$this->db->insert('oc_leagues', $data);
		$insert = $this->db->insert_id();
		return $insert;
	}
	
	public function update_league($post){
		$LeagueID = intval($post['LeagueID']);
		$data = array();
		foreach ($post as $key => $value) {
			if ($key != 'LeagueID') {
				$data[$key] = $value;
			}
		}
		$this->db->where('LeagueID', $LeagueID);
		$this->db->update('oc_leagues', $data);
		return $LeagueID;
	}
	
	public function delete_league($id){
		$this->db->query("DELETE FROM oc_leagues WHERE LeagueID = " . intval($id));
		$qe = $this->db->query("SELECT * FROM oc_events WHERE LeagueID = " . intval($id));
		foreach ($qe->result_array() as $re) {
			$this->db->query("DELETE FROM oc_markets WHERE EventID = " . $re['EventID']);
		}
		$this->db->query("DELETE FROM oc_events WHERE LeagueID = " . intval($id));
		return $id;
	}
	
	public function get_newsletter(){
		$query = $this->db->get('oc_newsletter');
		$newsletter = array();
		foreach ($query->result_array() as $row) {
			$newsletter[$row['SubscriptionID']] = array();
			$newsletter[$row['SubscriptionID']]['Email'] = $row['Email'];
			$newsletter[$row['SubscriptionID']]['SubscriptionDate'] = $row['SubscriptionDate'];
		}
		return $newsletter;
	}
	
	public function insert_ip_ban($ip){
		$this->db->where('IpAddr', $ip);
		$qb = $this->db->get('oc_bans');
		$rb = $qb->row_array();
		if (is_null($rb)) {
			$this->db->insert('oc_bans', array('IpAddr'=>$ip));
			return $ip;
		} else {
			return FALSE;
		}
	}
	
	public function send_newsletter($post) {
		$Subject = $post['Subject'];
		$Message = nl2br($post['Message']);
		$newsletter = $this->AdminModel->get_newsletter();
		$log = '';
		if ($this->data['settings']['use_smtp'] > 0) {
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
			foreach ($newsletter as $key => $value) {
				$this->email->initialize($cfg);
				$this->email->from($this->data['settings']['default_email'], 'Oddscracker Kenya');
				$this->email->subject($Subject);
				$this->email->to($value['Email']);
				$this->email->message($Message . '<br><hr><p>You can opt out from receiving email messages from us by clicking the following URL:&nbsp;<a href="' . $this->data['settings']['abs_url'] . '/unsubscribe?email=' . urlencode($value['Email']) . '" target="_blank">unsubscribe</a></p>');
				$this->email->send();
				$log .= 'Sent newsletter to ' . $value['Email'] . '<br>';
			}
		} else {
			$this->load->model('Mailgun');
			foreach ($newsletter as $key => $value) {
				$from = $this->data['settings']['default_email'];
				$to = $value['Email'];
				$this->Mailgun->send_email($to, $Subject, $Message . '<br><hr><p>You can opt out from receiving email messages from us by clicking the following URL:&nbsp;<a href="' . $this->data['settings']['abs_url'] . '/unsubscribe?email=' . urlencode($value['Email']) . '" target="_blank">unsubscribe</a></p>', $from);
				$log .= 'Sent newsletter to ' . $value['Email'] . '<br>';
			}
		}
		return $log;
	}
	
	public function delete_subscription($id){
		$this->db->query("DELETE FROM oc_newsletter WHERE SubscriptionID = " . intval($id));
		return intval($id);
	}
	
	public function get_admin(){
		$this->db->where(array('md5(UserID)'=>get_cookie('_admin_'), 'IsAdmin'=>1));
		$query = $this->db->get('oc_users');
		$admin = $query->row_array();
		return $admin;
	}
	
	public function update_admin($post){
		if (empty($post['Email'])) {
			$errors = 'Email address is required!';
			return $errors;
		} else {
			if ($post['Email'] != $post['ConfirmEmail']) {
				$errors = 'Email addresses do not match!';
				return $errors;
			} else {
				$Email = filter_var($post['Email'], FILTER_SANITIZE_EMAIL);
				$qe = $this->db->query("SELECT * FROM oc_users WHERE Email = '$Email' AND UserID != " . intval($post['UserID']));
				$ce = $qe->num_rows();
				if ($ce > 0) {
					$errors = 'Email address ' . $Email . ' is already in use!';
					return $errors;
				} else {
					if (empty($post['Password'])) {
						$this->db->query("UPDATE oc_users SET Email = '$Email' WHERE UserID = " . intval($post['UserID']));
						return FALSE;
					} else {
						if (trim($post['Password']) != trim($post['ConfirmPassword'])) {
							$errors = 'Passwords do not match!';
							return $errors;
						} else {
							$Password = hash('sha512', trim($post['Password']));
							$this->db->query("UPDATE oc_users SET Email = '$Email', Password = '$Password' WHERE UserID = " . intval($post['UserID']));
							return FALSE;
						}
					}
				}
			}
		}
	}
	
	public function get_bans(){
		$this->db->order_by('BanID DESC');
		$query = $this->db->get('oc_bans');
		$count_bans = $query->num_rows();
		if ($count_bans == 0) {
			return FALSE;
		} else {
			$bans = array();
			foreach ($query->result_array() as $result) {
				$bans[$result['BanID']] = $result['IpAddr'];
			}
			return $bans;
		}
	}
	
	public function delete_ban($BanID){
		$this->db->where('BanID', $BanID);
		$query = $this->db->get('oc_bans');
		$result = $query->row_array();
		if (is_null($result)){
			return FALSE;
		} else {
			$this->db->query("DELETE FROM oc_bans WHERE BanID = " . $BanID);
			return $result['IpAddr'];
		}
	}
	
	public function get_campaigns(){
		$campaings = array();
		$qc = $this->db->query("SELECT oc_campaigns.*, oc_bookmakers.Name FROM oc_campaigns INNER JOIN oc_bookmakers ON oc_campaigns.BookmakerID = oc_bookmakers.BookmakerID");
		foreach ($qc->result_array() as $rc){
			$campaign_id = $rc['CampaignID'];
			$campaings[$campaign_id] = array();
			foreach ($rc as $key => $value) {
				$campaings[$campaign_id][$key] = $value;
			}
		}
		return $campaings;
	}
	public function get_campaign($CampaignID){
		$campaign = array();
		$this->db->where('CampaignID', $CampaignID);
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
	public function check_campaign_duplicate($BookmakerID){
		$this->db->where('BookmakerID', $BookmakerID);
		$qd = $this->db->get('oc_campaigns');
		$rd = $qd->row_array();
		if (!is_null($rd)){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function insert_campaign($post){
		$post['Token'] = hash('sha512', time() . $post['BookmakerID']);
		if (intval($post['StartDate']) == 0) {
			$post['StartDate'] = time();
		}
		$this->db->insert('oc_campaigns', $post);
		$CampaignID = $this->db->insert_id();
		return $CampaignID;
	}
	public function update_campaign($post){
		$this->db->where('CampaignID', $post['CampaignID']);
		$data = array();
		foreach ($post as $key => $value) {
			if ($key != 'CampaignID') {
				$data[$key] = $value;
			}
		}
		$update = $this->db->update('oc_campaigns', $data);
		return $update;
	}
	public function delete_campaign($CampaignID){
		$this->db->query("DELETE FROM oc_campaigns WHERE CampaignID = " . intval($CampaignID));
		return TRUE;
	}
	
}
