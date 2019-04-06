<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Archives extends MY_Controller {

	public function index(){
		$this->output->cache(60);
		if ($this->uri->segment(2)) {
			$Time = date('Y-m-d', strtotime(preg_replace('/[^0-9\-]/', '', $this->uri->segment(2))));
			if ($Time > strtotime('-1 day')) {
				$this->session->set_flashdata('error', 'Please select a date in the past to browse archived events!');
			} else {
				$this->data['archives'] = $this->FrontModel->get_archives($Time);
				$this->data['page']['MetaTitle'] = date('d M Y', strtotime($Time)) . ' archives | ' . $this->data['settings']['site_name'];
			}
		} else {
			$Time = date('Y-m-d', strtotime('-1 day'));
			$this->data['archives'] = $this->FrontModel->get_archives($Time);
			$this->data['page']['MetaTitle'] = date('d M Y', strtotime($Time)) . ' archives | ' . $this->data['settings']['site_name'];
		}
		$this->load->view('templates/head', $this->data);
		$this->load->view('templates/left_col');
		$this->load->view('archives');
		$this->load->view('templates/right_col');
		$this->load->view('templates/footer');
	}

}
