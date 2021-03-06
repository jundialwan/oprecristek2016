<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('date');

		ini_set('date.timezone', 'Asia/Jakarta');
		date_default_timezone_set('Asia/Jakarta');
	}

	// render template.php and the content which user request
	public function render($view, $data = array()) {				
		$userdata = $this->session->userdata('userdata');
		$date = new DateTime();
		$data['date'] = $date->getTimestamp();
		$data['user'] = $userdata;
		$data['content'] = $this->load->view($view, $data, TRUE);		
		$data['isLogin'] = $this->is_logged_in();	
		$data['isAdmin'] = $this->isAdmin($userdata['username']);
		$data['isRegistered'] = $this->isRegistered($userdata['username']);
		if ($this->is_logged_in()) $this->refresh_userdata();
		$this->load->view('template', $data);
	}

	public function is_logged_in() {
		return $this->session->userdata('userdata');
	}

	public function isAdmin($username) {
		return $this->useradmin->isAdmin($username);
	}

	public function isRegistered($username) {
		return $this->biodata->isUserRegistered($username);
	}

	private function refresh_userdata() {		
		$user = $this->session->userdata('userdata');			
		$this->session->set_userdata('userdata', $user);
	}
}