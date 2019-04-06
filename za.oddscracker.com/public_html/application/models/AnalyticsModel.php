<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AnalyticsModel extends MY_Model {
	public function __construct(){
		parent::__construct();
	}
	
	public function insert_analytics($IpAddr){
		$location = array();
		$this->db->where('IpAddr', $IpAddr);
		$query = $this->db->get('oc_analytics');
		$row = $query->row_array();
		$Url = $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING'];
		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			$UserAgent = $_SERVER['HTTP_USER_AGENT'];
		} else {
			$UserAgent = '';
		}
		if (isset($_SERVER['HTTP_REFERER'])) {
			$Referer = $_SERVER['HTTP_REFERER'];
		} else {
			$Referer = '';
		}
		if (get_cookie('_user_')) {
			$IsLoggedIn = 1;
		} else {
			$IsLoggedIn = 0;
		}
		if (is_null($row)) {
			$geoip = get_geoip_data($IpAddr);
			if ($geoip) {
				$this->db->insert('oc_analytics', array('IpAddr'=>$IpAddr,'Url'=>$Url,'UserAgent'=>$UserAgent,'Referer'=>$Referer,'Country'=>$geoip['country'],'City'=>$geoip['city'],'Latitude'=>$geoip['lat'],'Longitude'=>$geoip['long'],'Isp'=>$geoip['isp']));
				$location['Country'] = $geoip['country'];
				$location['City'] = $geoip['city'];
			} else {
				$location['Country'] = '';
				$location['City'] = '';
			}
		} else {
			$location['Country'] = $row['Country'];
			$location['City'] = $row['City'];
			$LastTime = date('Y-m-d H:i:s');
			$HitCounter = $row['HitCounter']+1;
			$this->db->where('AnalyticID', $row['AnalyticID']);
			$this->db->update('oc_analytics', array('Url'=>$Url,'UserAgent'=>$UserAgent,'Referer'=>$Referer,'LastTime'=>$LastTime, 'HitCounter'=>$HitCounter, 'IsLoggedIn'=>$IsLoggedIn));
		}
		return $location;
	}
	
}
