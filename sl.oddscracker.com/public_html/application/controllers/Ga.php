<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ga extends MY_Controller {
	public function index(){
		require_once FCPATH . 'application/libraries/googleapi/vendor/autoload.php';
		$client = new Google_Client();
		$client->setAuthConfig(FCPATH . 'application/libraries/googleapi/client_secrets.json');
		$client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
		if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
			redirect($this->data['settings']['abs_url'] . '/campaign/' . $_SESSION['_campaign_id']);
		} else {
			$redirect_uri = $this->data['settings']['abs_url'] . '/ga/oauth2callback';
			header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
		}
	}
	public function oauth2callback(){
		require_once FCPATH . 'application/libraries/googleapi/vendor/autoload.php';
		$client = new Google_Client();
		$client->setAuthConfig(FCPATH . 'application/libraries/googleapi/client_secrets.json');
		$client->setRedirectUri('https://' . $_SERVER['HTTP_HOST'] . '/ga/oauth2callback');
		$client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
		if (!isset($_GET['code'])) {
			$auth_url = $client->createAuthUrl();
			header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
		} else {
			$client->authenticate($_GET['code']);
			$_SESSION['access_token'] = $client->getAccessToken();
			$redirect_uri = 'https://' . $_SERVER['HTTP_HOST'] . '/ga';
			header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
		}
	}
}
?>