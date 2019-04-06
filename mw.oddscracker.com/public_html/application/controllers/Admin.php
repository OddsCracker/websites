<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('AdminModel');
		$this->load->model('FrontModel');
	}

	public function check_login_status(){
		if (!get_cookie('_admin_')) {
			redirect($this->data['settings']['abs_url'] . '/admin/login');
		}
	}

	public function index(){
		$this->check_login_status();
		$this->data['stats'] = $this->AdminModel->get_analytics();
		$this->load->view('admin/templates/head', $this->data);
		$this->load->view('admin/dashboard');
		$this->load->view('admin/templates/footer');
	}
	
	public function login(){
		$this->load->view('admin/templates/head', $this->data);
		$this->load->view('admin/login_form');
		$this->load->view('admin/templates/footer');
	}
	
	public function dologin(){
		if (get_cookie('csrf') && (!$this->input->post('csrf') || $this->input->post('csrf') != get_cookie('csrf'))) {
			$this->session->set_flashdata('error', 'There was a problem with your cookies, please reload the page!');
			redirect($this->data['settings']['abs_url'] . '/admin/login');
		} else {
			$check = $this->AdminModel->check_admin($this->input->post());
			if (!$check) {
				$this->session->set_flashdata('error', 'Invalid email/password combination, try again!');
				redirect($this->data['settings']['abs_url'] . '/admin/login');
			} else {
				if ($this->input->post('rememberme')) {
					$expire = time()+86400*30;
				} else {
					$expire = 0;
				}
				setcookie('_admin_', md5($check), $expire, '/admin/', $_SERVER['SERVER_NAME'], ini_get('session.cookie_secure'), 1);
				redirect($this->data['settings']['abs_url'] . '/admin/');
			}
		}
	}
	
	public function bookmakers(){
		$this->check_login_status();
		$this->data['bookmakers'] = $this->FrontModel->get_bookmakers();
		$this->load->view('admin/templates/head', $this->data);
		$this->load->view('admin/bookmakers');
		$this->load->view('admin/templates/footer');
	}
	
	public function bookmaker_info(){
		$this->check_login_status();
		$slug = preg_replace('/[^a-z0-9\-\_]/', '', $this->uri->segment(3)) ?: '';
		$bookmaker = $this->FrontModel->get_bookmaker($slug);
		if (!$bookmaker) {
			
		} else {
			$this->data['bookmaker'] = $bookmaker;
			$this->load->view('admin/templates/head', $this->data);
			$this->load->view('admin/view_bookmaker');
			$this->load->view('admin/templates/footer');
		}
	}
	
	public function add_bookmaker(){
		$this->check_login_status();
		$this->data['sort_numbers'] = $this->AdminModel->get_sort_order('oc_bookmakers');
		$this->load->view('admin/templates/head', $this->data);
		$this->load->view('admin/add_bookmaker');
		$this->load->view('admin/templates/footer');
	}
	
	public function edit_bookmaker(){
		$this->check_login_status();
		$slug = preg_replace('/[^a-z0-9\-\_]/', '', $this->uri->segment(3)) ?: '';
		$bookmaker = $this->FrontModel->get_bookmaker($slug);
		if (!$bookmaker){
			
		} else {
			$this->data['bookmaker'] = $bookmaker;
			$this->data['sort_numbers'] = $this->AdminModel->get_sort_order('oc_bookmakers');
			$this->load->view('admin/templates/head', $this->data);
			$this->load->view('admin/edit_bookmaker');
			$this->load->view('admin/templates/footer');
		}
	}
	
	public function save_bookmaker(){
		$this->check_login_status();
		$post = $this->input->post();
		$duplicate = $this->AdminModel->check_bookmaker_duplicate($post['Name']);
		if ($duplicate) {
			$this->session->set_flashdata('error', 'A bookmaker named ' . $post['Name'] . ' already exists, you are not allowed to duplicate bookmakers names.');
			redirect($this->data['settings']['abs_url'] . '/admin/add_bookmaker');
		} else {
			$config['upload_path'] = FCPATH . '/uploads';
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['max_size'] = 0;
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('Logo')) {
				$this->session->set_flashdata('error', $this->upload->display_errors());
				redirect($this->data['settings']['abs_url'] . '/admin/add_bookmaker');
			} else {
				$upload_data = $this->upload->data();
				$logo_src = $upload_data['file_name'];
				if (!$this->upload->do_upload('Cover')) {
					$this->session->set_flashdata('error', $this->upload->display_errors());
					redirect($this->data['settings']['abs_url'] . '/admin/add_bookmaker');
				} else {
					$upload_data = $this->upload->data();
					$cover_src = $upload_data['file_name'];
					$post['Slug'] = preg_replace('/[^a-z0-9\-]/', '', strtolower($post['Name']));
					$post['Logo'] = $logo_src;
					$post['Cover'] = $cover_src;
					$slug = $this->AdminModel->insert_bookmaker($post);
					if (!$slug) {
						$this->session->set_flashdata('error', 'Bookmaker was not saved due to errors!');
						redirect($this->data['settings']['abs_url'] . '/admin/add_bookmaker');
					} else {
						$this->session->set_flashdata('success', 'New bookmaker added successfully!');
						redirect($this->data['settings']['abs_url'] . '/admin/bookmaker_info/' . $slug);
					}
				}
			}
		}
	}
	
	public function update_bookmaker(){
		$this->check_login_status();
		$post = $this->input->post();
		$slug = preg_replace('/[^a-z0-9\-]/', '', strtolower($post['Name'])) ?: '';
		$bookmaker = $this->AdminModel->get_bookmaker_by_id($post['BookmakerID']);
		if (!$bookmaker) {
			$this->session->set_flashdata('error', 'Bookmaker ' . $slug . ' not found!');
			redirect($this->data['settings']['abs_url'] . '/admin/bookmakers');
		} else {
			$duplicate = $this->AdminModel->check_bookmaker_duplicate($post['Name'], intval($post['BookmakerID']));
			if ($duplicate) {
				$this->session->set_flashdata('error', 'A bookmaker named ' . $post['Name'] . ' already exists, you are not allowed to duplicate bookmakers names.');
				redirect($this->data['settings']['abs_url'] . '/admin/edit_bookmaker/' . preg_replace('/[^a-z0-9\-]/', '', strtolower($post['Name'])));
			} else {
				$config['upload_path'] = FCPATH . '/uploads';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['max_size'] = 0;
				$config['encrypt_name'] = TRUE;
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('Logo')) {
					$post['Logo'] = $bookmaker['Logo'];
				} else {
					$upload_data = $this->upload->data();
					$logo_src = $upload_data['file_name'];
					$post['Logo'] = $logo_src;
				}
				if (!$this->upload->do_upload('Cover')) {
					$post['Cover'] = $bookmaker['Cover'];
				} else {
					$upload_data = $this->upload->data();
					$cover_src = $upload_data['file_name'];
					$post['Cover'] = $cover_src;
				}
				$update = $this->AdminModel->update_bookmaker($post);
				if ($update) {
					$this->session->set_flashdata('success', 'Bookmaker successfully updated!');
					redirect($this->data['settings']['abs_url'] . '/admin/bookmaker_info/' . $update);
				} else {
					$this->session->set_flashdata('error', 'Bookmaker was not updated due to errors!');
					redirect($this->data['settings']['abs_url'] . '/admin/bookmaker_info/' . preg_replace('/[^a-z0-9\-]/', '', strtolower($post['Name'])));
				}
			}
		}
	}
	
	public function delete_bookmaker(){
		$this->check_login_status();
		$slug = preg_replace('/[^a-z0-9\-]/', '', $this->uri->segment(3)) ?: '';
		$bookmaker = $this->FrontModel->get_bookmaker($slug);
		if (!$bookmaker) {
			$this->session->set_flashdata('error', 'Bookmaker ' . $slug . ' not found!');
			redirect($this->data['settings']['abs_url'] . '/admin/bookmakers');
		} else {
			$this->AdminModel->delete_bookmaker($bookmaker);
			$this->session->set_flashdata('success', 'Bookmaker ' . $bookmaker['Name'] . ' deleted!');
			redirect($this->data['settings']['abs_url'] . '/admin/bookmakers');
		}
	}

	public function users(){
		$this->check_login_status();
		$this->data['users'] = $this->AdminModel->get_users();
		$this->load->view('admin/templates/head', $this->data);
		$this->load->view('admin/users');
		$this->load->view('admin/templates/footer');
	}
	
	public function edit_user(){
		$this->check_login_status();
		$UserID = intval($this->uri->segment(3)) ?: 0;
		$user = $this->AdminModel->get_user($UserID);
		if (!$user) {
			$this->session->set_flashdata('error', 'User not found!');
			redirect($this->data['settings']['abs_url'] . '/admin/users');
		} else {
			$this->data['user'] = $user;
			$this->data['countries'] = $this->FrontModel->get_country_list();
			$this->load->view('admin/templates/head', $this->data);
			$this->load->view('admin/edit_user');
			$this->load->view('admin/templates/footer');
		}
	}
	
	public function user_info(){
		$this->check_login_status();
		$UserID = intval($this->uri->segment(3)) ?: 0;
		$user = $this->AdminModel->get_user($UserID);
		if (!$user) {
			$this->session->set_flashdata('error', 'User not found!');
			redirect($this->data['settings']['abs_url'] . '/admin/users');
		} else {
			$this->data['user'] = $user;
			$this->load->view('admin/templates/head', $this->data);
			$this->load->view('admin/view_user');
			$this->load->view('admin/templates/footer');
		}
	}
	
	public function update_user(){
		$this->check_login_status();
		$post = $this->input->post();
		$update = $this->AdminModel->update_user($post);
		if (!$update) {
			$this->session->set_flashdata('error', 'User not updated due to errors!');
			redirect($this->data['settings']['abs_url'] . '/admin/users');
		} else {
			$this->session->set_flashdata('success', 'User updated!');
			redirect($this->data['settings']['abs_url'] . '/admin/user_info/' . $update);
		}
	}
	
	public function delete_user(){
		$this->check_login_status();
		$delete = $this->AdminModel->delete_user($this->uri->segment(3));
		if (!$delete) {
			$this->session->set_flashdata('error', 'User not deleted due to errors!');
			redirect($this->data['settings']['abs_url'] . '/admin/users');
		} else {
			$this->session->set_flashdata('success', 'User deleted!');
			redirect($this->data['settings']['abs_url'] . '/admin/users');
		}
	}
	
	public function pages(){
		$this->check_login_status();
		$this->data['pages'] = $this->AdminModel->get_pages();
		$this->load->view('admin/templates/head', $this->data);
		$this->load->view('admin/pages');
		$this->load->view('admin/templates/footer');
	}
	
	public function page_info(){
		$this->check_login_status();
		$PageID = intval($this->uri->segment(3)) ?: 0;
		$page = $this->AdminModel->get_page($PageID);
		if (!$page) {
			$this->session->set_flashdata('error', 'Page not found!');
		} else {
			$this->data['page'] = $page;
		}
		$this->load->view('admin/templates/head', $this->data);
		$this->load->view('admin/view_page');
		$this->load->view('admin/templates/footer');
	}
	
	public function edit_page(){
		$this->check_login_status();
		$PageID = intval($this->uri->segment(3)) ?: 0;
		$page = $this->AdminModel->get_page($PageID);
		if (!$page) {
			$this->session->set_flashdata('error', 'Page not found!');
		} else {
			$this->data['page'] = $page;
		}
		$this->load->view('admin/templates/head', $this->data);
		$this->load->view('admin/edit_page');
		$this->load->view('admin/templates/footer');
	}
	
	public function update_page(){
		$this->check_login_status();
		$post = $this->input->post();
		$update = $this->AdminModel->update_page($post);
		if (!$update) {
			$this->session->set_flashdata('error', 'Page not updated due to errors!');
			redirect($this->data['settings']['abs_url'] . '/admin/pages');
		} else {
			$this->session->set_flashdata('success', 'Page updated successfully!');
			redirect($this->data['settings']['abs_url'] . '/admin/page_info/' . $update);
		}
	}
	
	public function settings(){
		$this->check_login_status();
		$this->data['site_settings'] = $this->AdminModel->get_site_settings();
		$this->load->view('admin/templates/head', $this->data);
		$this->load->view('admin/settings');
		$this->load->view('admin/templates/footer');
	}
	
	public function update_settings(){
		$this->check_login_status();
		$update = $this->AdminModel->update_settings($this->input->post());
		$this->data['site_settings'] = $update;
		$this->load->view('admin/templates/head', $this->data);
		$this->load->view('admin/settings');
		$this->load->view('admin/templates/footer');
	}
	
	public function messages(){
		$this->check_login_status();
		$this->data['messages'] = $this->AdminModel->get_messages();
		$this->load->view('admin/templates/head', $this->data);
		$this->load->view('admin/messages');
		$this->load->view('admin/templates/footer');
	}
	
	public function view_message(){
		$this->check_login_status();
		$message = $this->AdminModel->get_message($this->uri->segment(3));
		if (!$message) {
			$this->session->set_flashdata('error', 'Message not found!');
			redirect($this->data['settings']['abs_url'] . '/admin/messages/');
		} else {
			$this->data['message'] = $message;
			$this->load->view('admin/templates/head', $this->data);
			$this->load->view('admin/view_message');
			$this->load->view('admin/templates/footer');
		}
	}
	
	public function bans(){
		$this->data['bans'] = $this->AdminModel->get_bans();
		$this->load->view('admin/templates/head', $this->data);
		$this->load->view('admin/bans');
		$this->load->view('admin/templates/footer');
	}
	
	public function delete_message(){
		$this->check_login_status();
		$delete = $this->AdminModel->delete_message($this->uri->segment(3));
		if (!$delete) {
			$this->session->set_flashdata('error', 'Message not deleted due to errors!');
			redirect($this->data['settings']['abs_url'] . '/admin/messages/');
		} else {
			$this->session->set_flashdata('success', 'Message #' . $delete . ' deleted!');
			redirect($this->data['settings']['abs_url'] . '/admin/messages/');
		}
	}
	
	public function leagues(){
		$this->check_login_status();
		$this->data['leagues'] = $this->AdminModel->get_leagues();
		$this->load->view('admin/templates/head', $this->data);
		$this->load->view('admin/leagues');
		$this->load->view('admin/templates/footer');
	}
	
	public function add_league(){
		$this->check_login_status();
		$this->data['countries'] = $this->AdminModel->get_countries();
		$this->data['sort_numbers'] = $this->AdminModel->get_sort_order('oc_leagues');
		$this->load->view('admin/templates/head', $this->data);
		$this->load->view('admin/add_league');
		$this->load->view('admin/templates/footer');
	}
	
	public function insert_league(){
		$this->check_login_status();
		$insert = $this->AdminModel->insert_league($this->input->post());
		if (!$insert) {
			$this->session->set_flashdata('error', 'League not saved due to errors!');
			redirect($this->data['settings']['abs_url'] . '/admin/leagues/');
		} else {
			$this->session->set_flashdata('success', 'League #' . $insert . ' inserted!');
			redirect($this->data['settings']['abs_url'] . '/admin/leagues/');
		}
	}
	
	public function edit_league(){
		$this->check_login_status();
		$league = $this->AdminModel->get_league($this->uri->segment(3));
		if (!$league) {
			$this->session->set_flashdata('error', 'League not found!');
			redirect($this->data['settings']['abs_url'] . '/admin/leagues/');
		} else {
			$this->data['countries'] = $this->AdminModel->get_countries();
			$this->data['league'] = $league;
			$this->data['sort_numbers'] = $this->AdminModel->get_sort_order('oc_leagues');
			$this->load->view('admin/templates/head', $this->data);
			$this->load->view('admin/edit_league');
			$this->load->view('admin/templates/footer');
		}
	}
	
	public function update_league(){
		$this->check_login_status();
		$update = $this->AdminModel->update_league($this->input->post());
		if (!$update) {
			$this->session->set_flashdata('error', 'League not updated due to errors!');
			redirect($this->data['settings']['abs_url'] . '/admin/leagues/');
		} else {
			$this->session->set_flashdata('success', 'League #' . $update . ' updated!');
			redirect($this->data['settings']['abs_url'] . '/admin/leagues/');
		}
	}
	
	public function delete_league(){
		$this->check_login_status();
		$league = $this->AdminModel->get_league($this->uri->segment(3));
		if (!$league) {
			$this->session->set_flashdata('error', 'League not found!');
			redirect($this->data['settings']['abs_url'] . '/admin/leagues/');
		} else {
			$delete = $this->AdminModel->delete_league($league['LeagueID']);
			if (!$delete) {
				$this->session->set_flashdata('error', 'League not deleted due to errors!');
				redirect($this->data['settings']['abs_url'] . '/admin/leagues/');
			} else {
				$this->session->set_flashdata('success', 'League deleted!');
				redirect($this->data['settings']['abs_url'] . '/admin/leagues/');
			}
		}
	}
	
	public function parse_news_feeds(){
		$this->check_login_status();
		$log = 'Started parsing news feeds at ' . date('Y-m-d H:i:s') . "\n";
		$count = array();
		/* goal.com */
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://www.goal.com/en-ke/feeds/news');
		curl_setopt($ch, CURLOPT_TIMEOUT, 45);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$res = curl_exec($ch);
		curl_close($ch);
		$xml = simplexml_load_string($res);
		$count['goal.com'] = 0;
		foreach ($xml->entry as $entry){
			$Source = 'goal.com';
			$Url = $entry->id;
			$Title = $entry->title;
			$DateTime = date('Y-m-d H:i:s', strtotime($entry->updated));
			$Content = $entry->summary;
			$Image = '';
			foreach ($entry->link as $link) {
				if ($link['rel'] == 'related' && $link['type'] = 'image/jpeg') {
					$Image = $link['href'];
				}
			}
			$this->db->where('Url', $Url);
			$qn = $this->db->get('oc_news');
			$cn = $qn->num_rows();
			if ($cn == 0) {
				$data = array('DateTime'=>$DateTime, 'Title'=>$Title, 'Content'=>$Content, 'Image'=>$Image, 'Source'=>$Source, 'Url'=>$Url);
				$this->db->insert('oc_news', $data);
				$log .= 'Inserted ' . $Title . ' from goal.com' . "\n";
				$count['goal.com']++;
			}
		}
		/* soka.co.ke */
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://www.soka.co.ke/rss');
		curl_setopt($ch, CURLOPT_TIMEOUT, 45);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$res = curl_exec($ch);
		curl_close($ch);
		$xml = simplexml_load_string($res);
		$count['soka.co.ke'] = 0;
		foreach ($xml->channel->item as $item) {
			$Source = 'soka.co.ke';
			$DateTime = date('Y-m-d H:i:s', strtotime($item->pubDate));
			$Url = $item->link;
			$Title = $item->title;
			$Content = $item->description;
			$Image = '';
			$this->db->where('Url', $Url);
			$qn = $this->db->get('oc_news');
			$cn = $qn->num_rows();
			if ($cn == 0) {
				$data = array('DateTime'=>$DateTime, 'Title'=>$Title, 'Content'=>$Content, 'Image'=>$Image, 'Source'=>$Source, 'Url'=>$Url);
				$this->db->insert('oc_news', $data);
				$log .= 'Inserted ' . $Title . ' from soka.co.ke' . "\n";
				$count['soka.co.ke']++;
			}
		}
		/* standard.media.co.ke */
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://www.standardmedia.co.ke/rss/sports.php');
		curl_setopt($ch, CURLOPT_TIMEOUT, 45);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$res = curl_exec($ch);
		curl_close($ch);
		$xml = simplexml_load_string($res);
		$count['standardmedia.co.ke'] = 0;
		$Source = 'standardmedia.co.ke';
		foreach ($xml->channel->item as $item) {
			$Title = $item->title;
			$Url = $item->link;
			$Content = $item->description;
			$Image = '';
			$DateTime = date('Y-m-d H:i:s', strtotime($item->pubDate));
			$this->db->where('Url', $Url);
			$qn = $this->db->get('oc_news');
			$cn = $qn->num_rows();
			if ($cn == 0) {
				$data = array('DateTime'=>$DateTime, 'Title'=>$Title, 'Content'=>$Content, 'Image'=>$Image, 'Source'=>$Source, 'Url'=>$Url);
				$this->db->insert('oc_news', $data);
				$log .= 'Inserted ' . $Title . ' from standardmedia.co.ke' . "\n";
				$count['standardmedia.co.ke']++;
			}
		}
		/* michezoafrika.com */
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://www.michezoafrika.com/rss.aspx');
		curl_setopt($ch, CURLOPT_TIMEOUT, 45);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$res = curl_exec($ch);
		curl_close($ch);
		$xml = simplexml_load_string($res);
		$Source = 'michezoafrika.com';
		$count['michezoafrika.com'] = 0;
		$base_url = 'https://www.michezoafrika.com';
		foreach ($xml->channel->item as $item) {
			$Title = $item->title;
			$Url = $base_url . $item->link;
			$Content = $item->description;
			$Image = '';
			$DateTime = date('Y-m-d H:i:s', strtotime($item->pubDate));
			$this->db->where('Url', $Url);
			$qn = $this->db->get('oc_news');
			$cn = $qn->num_rows();
			if ($cn == 0) {
				$data = array('DateTime'=>$DateTime, 'Title'=>$Title, 'Content'=>$Content, 'Image'=>$Image, 'Source'=>$Source, 'Url'=>$Url);
				$this->db->insert('oc_news', $data);
				$log .= 'Inserted ' . $Title . ' from michezoafrika.com' . "\n";
				$count['michezoafrika.com']++;
			}
		}
		/* capitalfm.co.ke */
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://www.capitalfm.co.ke/sports/feed/');
		curl_setopt($ch, CURLOPT_TIMEOUT, 45);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$res = curl_exec($ch);
		curl_close($ch);
		$xml = simplexml_load_string($res);
		$count['capitalfm.co.ke'] = 0;
		$Source = 'capitalfm.co.ke';
		foreach ($xml->channel->item as $item) {
			$Title = $item->title;
			$Url = $item->link;
			$DateTime = date('Y-m-d H:i:s', strtotime($item->pubDate));
			$Content = $item->children('content', true);
			$Image = '';
			preg_match_all('/<img[^>]+>/i', $Content, $img);
			if (isset($img['0']['0'])) {
				preg_match_all('/(src)=("[^"]*")/i', $img['0']['0'], $src);
				if (isset($src['0']['0'])) {
					$Image .= str_replace(array('src="', '"'), '', $src['0']['0']);
				}
			}
			$this->db->where('Url', $Url);
			$qn = $this->db->get('oc_news');
			$cn = $qn->num_rows();
			if ($cn == 0) {
				$data = array('DateTime'=>$DateTime, 'Title'=>$Title, 'Content'=>$Content, 'Image'=>$Image, 'Source'=>$Source, 'Url'=>$Url);
				$this->db->insert('oc_news', $data);
				$log .= 'Inserted ' . $Title . ' from capitalfm.co.ke' . "\n";
				$count['capitalfm.co.ke']++;
			}
		}
		$log .= 'Finished parsing news feeds at ' . date('Y-m-d H:i:s') . "\n";
		$this->data['log'] = $log;
		$this->data['count'] = $count;
		$this->load->view('admin/templates/head', $this->data);
		$this->load->view('admin/update_news');
		$this->load->view('admin/templates/footer');
	}
	
	public function newsletter(){
		$this->check_login_status();
		$this->data['newsletter'] = $this->AdminModel->get_newsletter();
		$this->load->view('admin/templates/head', $this->data);
		$this->load->view('admin/newsletter');
		$this->load->view('admin/templates/footer');
	}
	
	public function send_newsletter(){
		$this->check_login_status();
		$this->data['send'] = $this->AdminModel->send_newsletter($this->input->post());
		$this->load->view('admin/templates/head', $this->data);
		$this->load->view('admin/send_newsletter');
		$this->load->view('admin/templates/footer');
	}
	
	public function delete_subscription(){
		$this->check_login_status();
		$delete = $this->AdminModel->delete_subscription($this->uri->segment(3));
		if (!$delete) {
			$this->session->set_flashdata('error', 'Subscription not deleted due to errors!');
		} else {
			$this->session->set_flashdata('success', 'Subscription #' . $delete . ' deleted successfully!');
		}
		redirect($this->data['settings']['abs_url'] . '/admin/newsletter');
	}

	public function block_ip(){
		$ip_address = preg_replace('/[^a-z0-9\.]/', '', urldecode($this->uri->segment(3)));
		if (empty($ip_address)) {
			echo 'Empty value!';
		} else {
			$block = $this->AdminModel->insert_ip_ban($ip_address);
			if (!$block) {
				echo 'IP already blocked';
			} else {
				echo $block . ' blocked!';
			}	
		}
	}
	
	public function edit(){
		$this->check_login_status();
		$this->data['admin'] = $this->AdminModel->get_admin();
		$this->load->view('admin/templates/head', $this->data);
		$this->load->view('admin/edit_admin');
		$this->load->view('admin/templates/footer');
	}
	
	public function update(){
		$this->check_login_status();
		$errors = $this->AdminModel->update_admin($this->input->post());
		if ($errors) {
			$this->session->set_flashdata('error', $errors);
			redirect($this->data['settings']['abs_url'] . '/admin/edit');
		} else {
			$this->session->set_flashdata('success', 'Your login has been updated successfully!');
			redirect($this->data['settings']['abs_url'] . '/admin/edit');
		}
	}
	
	public function delete_ban($id){
		$BanID = intval($id);
		$delete = $this->AdminModel->delete_ban($BanID);
		if ($delete) {
			$this->session->set_flashdata('success', 'IP ban removed for IP address ' . $delete . '!');	
		} else {
			$this->session->set_flashdata('error', 'IP address not found!');
		}
		redirect($this->data['settings']['abs_url'] . '/admin/bans');
	}

	public function logout(){
		setcookie('_admin_', '', (time()-86400*30), '/admin/', $_SERVER['SERVER_NAME'], ini_get('session.cookie_secure'), 1);
		redirect($this->data['settings']['abs_url'] . '/admin/');
	}
	
	public function campaigns(){
		$this->check_login_status();
		$this->data['campaigns'] = $this->AdminModel->get_campaigns();
		$this->load->view('admin/templates/head', $this->data);
		$this->load->view('admin/view_campaigns');
		$this->load->view('admin/templates/footer');
	}
	public function add_campaign(){
		$this->check_login_status();
		$this->data['bookmakers'] = $this->FrontModel->get_bookmakers();
		$this->load->view('admin/templates/head', $this->data);
		$this->load->view('admin/add_campaign');
		$this->load->view('admin/templates/footer');
	}
	public function save_campaign(){
		$this->check_login_status();
		$BookmakerID = intval($this->input->post('BookmakerID'));
		$duplicate = $this->AdminModel->check_campaign_duplicate($BookmakerID);
		if ($duplicate) {
			$this->session->set_flashdata('error', 'A campaign already exists for this bookmaker, please edit or that or delete it first!');
			redirect($this->data['settings']['abs_url'] . '/admin/add_campaign');
		} else {
			$post = array( 'BookmakerID'=>$BookmakerID, 'Budget'=>floatval($this->input->post('Budget')), 'CostPerClick'=>floatval($this->input->post('CostPerClick')), 'Ongoing'=>intval($this->input->post('Ongoing')), 'StartDate'=>strtotime($this->input->post('StartDate')), 'EndDate'=>strtotime($this->input->post('EndDate')) );
			if ( $post['Ongoing'] == 0 && ( empty($post['StartDate']) || empty($post['EndDate']) ) ){
				$this->session->set_flashdata('error', 'For fixed time campaigns you have to define the campaign start and end date!');
				redirect($this->data['settings']['abs_url'] . '/admin/add_campaign');
			} else {
				$CampaignID = $this->AdminModel->insert_campaign($post);
				if (!$CampaignID) {
					$this->session->set_flashdata('error', 'There was an error while saving your campaign, check your form and try again!');
					redirect($this->data['settings']['abs_url'] . '/admin/add_campaign');
				} else {
					$this->session->set_flashdata('success', 'Campaign was created with success!');
					redirect($this->data['settings']['abs_url'] . '/admin/view_campaign/' . $CampaignID);
				}
			}
		}
	}
	public function view_campaign(){
		$this->check_login_status();
		$CampaignID = intval($this->uri->segment(3));
		$this->data['campaign'] = $this->AdminModel->get_campaign($CampaignID);
		$this->load->view('admin/templates/head', $this->data);
		$this->load->view('admin/view_campaign');
		$this->load->view('admin/templates/footer');
	}
	public function delete_campaign(){
		$this->check_login_status();
		$CampaignID = intval($this->uri->segment(3));
		$delete = $this->AdminModel->delete_campaign($CampaignID);
		if (!$delete) {
			$this->session->set_flashdata('error', 'The campaign was not deleted due to errors!');
			redirect($this->data['settings']['abs_url'] . '/admin/view_campaign/' . $CampaignID);
		} else {
			$this->session->set_flashdata('success', 'The campaign with ID ' . $CampaignID . ' deleted!');
			redirect($this->data['settings']['abs_url'] . '/admin/campaigns');
		}
	}
	public function edit_campaign(){
		$this->check_login_status();
		$CampaignID = intval($this->uri->segment(3));
		$this->data['campaign'] = $this->AdminModel->get_campaign($CampaignID);
		$this->data['bookmakers'] = $this->FrontModel->get_bookmakers();
		$this->load->view('admin/templates/head', $this->data);
		$this->load->view('admin/edit_campaign');
		$this->load->view('admin/templates/footer');
	}
	public function update_campaign(){
		$CampaignID = intval($this->input->post('CampaignID'));
		$BookmakerID = intval($this->input->post('BookmakerID'));
		$post = array( 'CampaignID'=>$CampaignID, 'BookmakerID'=>$BookmakerID, 'Budget'=>floatval($this->input->post('Budget')), 'CostPerClick'=>floatval($this->input->post('CostPerClick')), 'Active'=>intval($this->input->post('Active')), 'Ongoing'=>intval($this->input->post('Ongoing')), 'StartDate'=>strtotime($this->input->post('StartDate')), 'EndDate'=>strtotime($this->input->post('EndDate')) );
		if ( $post['Ongoing'] == 0 && ( empty($post['StartDate']) || empty($post['EndDate']) ) ) {
			$this->session->set_flashdata('error', 'For fixed time campaigns you have to define the campaign start and end date!');
			redirect($this->data['settings']['abs_url'] . '/admin/edit_campaign/' . $CampaignID);
		} else {
			$update = $this->AdminModel->update_campaign($post);
			if (!$update) {
				$this->session->set_flashdata('error', 'The campaign was not updated due to errors!');
				redirect($this->data['settings']['abs_url'] . '/admin/edit_campaign/' . $CampaignID);
			} else {
				$this->session->set_flashdata('success', 'The campaign was updated successfully!');
				redirect($this->data['settings']['abs_url'] . '/admin/view_campaign/' . $CampaignID);
			}
		}
	}

}
