<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class MY_Controller extends CI_Controller{
	
	public $data;
	
	public function __construct(){
		parent::__construct();
		$this->data['settings'] = $this->SettingsModel->get_settings();
		$is_banned = $this->FrontModel->check_ban($_SERVER['REMOTE_ADDR']);
		if ($is_banned) {
			exit(redirect($this->data['settings']['abs_url'] . '/403.html'));
		}
		if (!get_cookie('csrf')) {
			if (isset($_SERVER['REMOTE_ADDR']) && isset($_SERVER['HTTP_USER_AGENT']) && isset($_SERVER['SERVER_NAME'])) {
				setcookie('csrf', md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . time()), (time()+7200), '/', $_SERVER['SERVER_NAME'], ini_get('session.cookie_secure'), 1);
			}
		}
		$this->data['page'] = $this->PageModel->get_page();
		$this->data['bookmakers'] = $this->FrontModel->get_bookmakers();
		if (!get_cookie('_admin_')) {
			$this->data['location'] = $this->AnalyticsModel->insert_analytics($_SERVER['REMOTE_ADDR']);
			$this->data['leagues'] = $this->FrontModel->get_leagues_list();
			$this->data['today_events'] = $this->FrontModel->get_today_events();
			$this->data['latest_news'] = $this->FrontModel->get_news(0,$this->data['settings']['latest_news_limit']);
		}
	}
}
?>
