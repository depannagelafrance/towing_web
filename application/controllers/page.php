<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {

	public $data;

  public $pagetype;

	/**
	 *	Constructor
	 *
	 *  Default page settings, used to set site-wide variables
	 */
	public function __construct() {
		parent::__construct();

		$this->load->helper('html');
		$this->load->library('session');

		if(!$this->data) {
			$this->data = array();
		}

		$this->data['content'] 	= '';

		// initialize messages
		$this->data['succes']	= '';
		$this->data['error']	= '';

		$this->data['title'] = 'Towing';

		if(!$this->_get_authenticated_user())
		{
			$this->load->helper('url');
			$uri = uri_string();

			if(substr($uri,0,5) !== 'login') {
				redirect("/login");
			}
		}
		else
		{
			//Set default view vars (if wanted), can be overwritten in specific controller (add construct)
			//title of every page
			if($this->_get_authenticated_user()) {
				$this->data['available_modules'] = $this->_get_available_modules();
			}
		}
	}


	/**
	 * individual page content
	 *
	 * @param type $string
	 */
	public function _add_content($string) {
		$this->data['content'] = $this->data['content'] . $string;
	}

	public function _add_css($string) {
	    $this->data['css'][] = $string;
	}

	public function _add_js($string) {
	    $this->data['js'][] = $string;
	}

	/**
	 * adding errors to individual views
	 *
	 * @param type $string
	 */
	public function _add_error($string) {
		$this->data['error'] = $this->data['error'] . $string;
	}

	/**
	 * rendering the whole page
	 */
	public function _render_page($pagetype = 'container') {
    if($pagetype === 'container'){
      $this->load->view('container', $this->data);
    }
    elseif($pagetype === 'login_container'){
      $this->load->view('login_container', $this->data);
    }

	}

	protected function _set_authenticated_user($user) {
		$this->session->set_userdata('current_user', $user);
	}

	protected function _get_authenticated_user() {
		return $this->session->userdata('current_user');
	}

	protected function _cache_Dossier($dossier) {
		if(!isset($_SESSION)) {
			session_start();
		}

		$_SESSION['dossier_cache'] = $dossier;

		//$this->session->set_userdata('dossier_cache', $dossier);
	}

	protected function _pop_Dossier_cache() {
		if(!isset($_SESSION)) {
			session_start();
		}

		if(array_key_exists('dossier_cache', $_SESSION)) {
			$val = $_SESSION['dossier_cache'];

			unset($_SESSION['dossier_cache']);

			return $val;
		} else {
			return null;
		}

		// $val = $this->session->userdata('dossier_cache');
		//
		// $this->session->unset_userdata("dossier_cache");
		//
		// return $val;
	}

	protected function _get_available_modules() {
		$data = $this->_get_authenticated_user();

		if($data) {
			if($data->token) {
				return $data->user_modules;
			}

			return null;
		}

		return null;
	}

	protected function _get_user_token() {
		$data = $this->_get_authenticated_user();

		if($data) {
			if($data->token) {
				return $data->token;
			}


			return null;
		}

		return null;
	}
}
