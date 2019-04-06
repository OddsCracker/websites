<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends MY_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		if (get_cookie('_user_')) {
			redirect($this->data['settings']['abs_url'] . '/account');
		}
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
		$this->data['countries'] = $this->FrontModel->get_country_list();
		$this->load->view('templates/head', $this->data);
		$this->load->view('templates/left_col');;
		$this->load->view('register_form');
		$this->load->view('templates/right_col');
		$this->load->view('templates/footer');
	}
	
	public function activate(){
		if (!$this->uri->segment(3)){
			$this->session->set_flashdata('error', 'Code d\'activation invalide!');
		} else {
			$errors = $this->FrontModel->verify_activation($this->uri->segment(3));
			if ($errors) {
				$this->session->set_flashdata('error', $errors);
			} else {
				$this->session->set_flashdata('success', 'Merci de valider votre compte! Le formulaire de connexion apparaîtra dans 3 secondes.');
			}
		}
		$this->load->view('templates/head', $this->data);
		$this->load->view('templates/left_col');;
		$this->load->view('activation');
		$this->load->view('templates/right_col');
		$this->load->view('templates/footer');
	}

}
