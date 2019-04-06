<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SettingsModel extends MY_Model {
	public function __construct(){
		parent::__construct();
	}
	
	public function get_settings(){
		$settings = array();
		$query = $this->db->get('oc_settings');
		foreach ($query->result_array() as $result) {
			$settings[$result['Name']] = $result['Value'];
		}
		return $settings;
	}
	
}
