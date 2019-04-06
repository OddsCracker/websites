<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PageModel extends MY_Model {
	public function __construct(){
		parent::__construct();
	}
	
	public function get_page(){
		$page = array();
		if ($this->uri->segment(2)) {
			$slug = preg_replace('/[^a-z0-9\_]/', '', $this->uri->segment(2));
			$this->db->where(array('Slug'=>$slug));
			$query = $this->db->get('oc_pages');
			$row = $query->row_array();
			if (!is_null($row)) {
				$page['MetaTitle'] = $row['MetaTitle'];
				$page['MetaDescription'] = $row['MetaDescription'];
				$page['og:title'] = $row['MetaTitle'];
				$page['og:description'] = $row['MetaDescription'];
				$page['Heading'] = $row['Heading'];
				$page['Html'] = $row['Html'];
			} else {
				goto first_segment;
			}
		} else {
			first_segment:
			if ($this->uri->segment(1)) {
				$slug = preg_replace('/[^a-z0-9\_]/', '', $this->uri->segment(1));
				$this->db->where(array('Slug'=>$slug));
				$query = $this->db->get('oc_pages');
				$row = $query->row_array();
				if (!is_null($row)) {
					$page['MetaTitle'] = $row['MetaTitle'];
					$page['MetaDescription'] = $row['MetaDescription'];
					$page['og:title'] = $row['MetaTitle'];
					$page['og:description'] = $row['MetaDescription'];
					$page['Heading'] = $row['Heading'];
					$page['Html'] = $row['Html'];
				} else {
					$page['MetaTitle'] = $this->data['settings']['default_title'];
					$page['MetaDescription'] = $this->data['settings']['default_description'];
					$page['og:title'] = $this->data['settings']['default_title'];
					$page['og:description'] = $this->data['settings']['default_description'];
					$page['Heading'] = '';
					$page['Html'] = '';
				}
			} else {
				$this->db->where(array('Slug'=>'home'));
				$query = $this->db->get('oc_pages');
				$row = $query->row_array();
				if (!is_null($row)) {
					$page['MetaTitle'] = $row['MetaTitle'];
					$page['MetaDescription'] = $row['MetaDescription'];
					$page['og:title'] = $row['MetaTitle'];
					$page['og:description'] = $row['MetaDescription'];
					$page['Heading'] = $row['Heading'];
					$page['Html'] = $row['Html'];
				} else {
					$page['MetaTitle'] = $this->data['settings']['default_title'];
					$page['MetaDescription'] = $this->data['settings']['default_description'];
					$page['og:title'] = $this->data['settings']['default_title'];
					$page['og:description'] = $this->data['settings']['default_description'];
					$page['Heading'] = '';
					$page['Html'] = '';
				}
			}
		}
		return $page;
	}
	
}
