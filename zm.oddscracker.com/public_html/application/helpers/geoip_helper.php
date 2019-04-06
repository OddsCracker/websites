<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_geoip_data')) {
	function get_geoip_data($IpAddr){
		$geoip = array();
		$json = curl_get_page('http://ip-api.com/json/' . $IpAddr);
		$data = json_decode($json, TRUE);
		$status = $data['status'] ?: '';
		if ($status == 'success') {
			$geoip['country'] = $data['country'];
			$geoip['city'] = $data['city'];
			$geoip['lat'] = $data['lat'];
			$geoip['long'] = $data['lon'];
			$geoip['isp'] = $data['isp'];
			return $geoip;
		} else {
			return false;
		}
	}
}

?>
