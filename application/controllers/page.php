<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {

	public $data;

	/**
	 *	Constructor
	 *
	 *  Default page settings, used to set site-wide variables
	 */
	public function __construct() {
		parent::__construct();
        //Set default view vars (if wanted), can be overwritten in specific controller (add construct)
		//title of every page
		$this->data['title'] = 'Towing';
		$this->data['content'] 	= '';
		// initialize messages
		$this->data['succes']	= '';
		$this->data['error']	= '';
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
	public function _render_page() {
		$this->load->view('container', $this->data);
	}
}