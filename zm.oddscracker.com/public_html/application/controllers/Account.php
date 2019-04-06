<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends MY_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function check_login_status(){
		if (!get_cookie('_user_')) {
			redirect($this->data['settings']['abs_url'] . '/account/login_required');
		}
	}

	public function index(){
		$this->check_login_status();
		$this->data['user'] = $this->FrontModel->get_user_data(get_cookie('_user_'));
		$this->data['newsletter'] = $this->FrontModel->get_newsletter($this->data['user']['Email']);
		$this->data['countries'] = $this->FrontModel->get_country_list();
		$this->load->view('templates/head', $this->data);
		$this->load->view('templates/left_col');
		$this->load->view('account');
		$this->load->view('templates/right_col');
		$this->load->view('templates/footer');
	}
	
	public function update(){
		$this->check_login_status();
		$errors = $this->FrontModel->update_account($this->input->post());
		if ($errors) {
			$this->session->set_flashdata('error', $errors);
			redirect($this->data['settings']['abs_url'] . '/account');
		} else {
			$this->session->set_flashdata('success', 'Your account has been updated!');
			redirect($this->data['settings']['abs_url'] . '/account');
		}
	}
	
	public function login_required(){
		$this->load->view('templates/head', $this->data);
		$this->load->view('templates/left_col');
		$this->load->view('login_required');
		$this->load->view('templates/right_col');
		$this->load->view('templates/footer');
	}

}
