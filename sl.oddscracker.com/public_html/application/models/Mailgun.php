<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mailgun extends MY_Model {
	public function __construct(){
		parent::__construct();
	}

	public function send_email($to, $subject, $message, $from=null){
		if (!is_null($from)) {
			$post_data = array(
				'from'=>$from,
				'to'=>$to,
				'subject'=>$subject,
				'html'=>$message
			);
		} else {
			$post_data = array(
				'from'=>$this->data['settings']['default_email'],
				'to'=>$to,
				'subject'=>$subject,
				'html'=>$message
			);
		}
		$url = $this->data['settings']['mailgun_service_url'];
		$key = $this->data['settings']['mailgun_api_key'];
		$curl = curl_init($url . '/messages');
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_USERPWD, "api:$key");
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_POST, TRUE);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_exec($curl);
		curl_close($curl);
	}

}
