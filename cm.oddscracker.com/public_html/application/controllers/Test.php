<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MY_Controller {
	public function index(){
		$ql = $this->db->query("SELECT * FROM oc_leagues");
		foreach ($ql->result_array() as $rl) {
			$flag = FCPATH . 'images/flags/' . strtolower($rl['CountryCode']) . '.png';
			$string = 'data:image/png;base64,' . base64_encode(file_get_contents($flag));
			$this->db->query("UPDATE oc_leagues SET CountryFlag = '$string' WHERE LeagueID = " . $rl['LeagueID']);
		}
	}
}