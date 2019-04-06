<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends MY_Controller {

	public function index(){
		$this->load->helper('captcha');
		$vals = array(
				'img_path'      => FCPATH . '/captcha/',
				'img_url'       => $this->data['settings']['abs_url'] . '/captcha/',
				'font_path'     => FCPATH . '/system/fonts/texb.ttf',
				'img_width'     => '200',
				'img_height'    => 45,
				'expiration'    => 7200,
				'word_length'   => 8,
				'font_size'     => 16,
				'img_id'        => 'Imageid',
				'pool'          => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
				'colors'        => array(
				        'background' => array(255, 255, 255),
				        'border' => array(255, 255, 255),
				        'text' => array(0, 0, 0),
				        'grid' => array(255, 40, 40)
				)
		);
		$captcha = create_captcha($vals);
		$this->session->set_userdata('captcha', $captcha['word']);
		$this->data['captcha'] = $captcha;
		$this->load->view('templates/head', $this->data);
		$this->load->view('templates/left_col');
		$this->load->view('contact');
		$this->load->view('templates/right_col');
		$this->load->view('templates/footer');
	}

}
